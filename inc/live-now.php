<?php
/**
 * Helper utilities for the Live Now page template.
 *
 * @package brendon-core
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Returns the configured Twitch channel, preferring the TWITCH_CHANNEL env var.
 *
 * @return string
 */
function bb_live_twitch_channel() {
	$env = getenv( 'TWITCH_CHANNEL' );
	if ( false !== $env && '' !== trim( $env ) ) {
		return sanitize_text_field( $env );
	}

	return sanitize_text_field( get_theme_mod( 'bb_live_twitch_channel', 'mr__brights1de' ) );
}

/**
 * Returns the configured Twitch parent domain, preferring the TWITCH_PARENT env var.
 *
 * @return string
 */
function bb_live_twitch_parent_domain() {
	$env = getenv( 'TWITCH_PARENT' );
	if ( false !== $env && '' !== trim( $env ) ) {
		return sanitize_text_field( $env );
	}

	return sanitize_text_field( get_theme_mod( 'bb_live_parent_domain', 'brendonbaugh.com' ) );
}

/**
 * Returns the saved Twitch client ID.
 *
 * @return string
 */
function bb_live_twitch_client_id() {
	return sanitize_text_field( get_theme_mod( 'bb_live_twitch_client_id', '' ) );
}

/**
 * Returns the saved Twitch client secret.
 *
 * @return string
 */
function bb_live_twitch_client_secret() {
	return sanitize_text_field( get_theme_mod( 'bb_live_twitch_client_secret', '' ) );
}

/**
 * Determines if Twitch credentials are available.
 *
 * @return bool
 */
function bb_live_twitch_has_credentials() {
	return (bool) ( bb_live_twitch_client_id() && bb_live_twitch_client_secret() );
}

/**
 * Retrieve a Twitch App access token using client credentials.
 *
 * @return string
 */
function bb_live_twitch_get_access_token() {
	if ( ! bb_live_twitch_has_credentials() ) {
		return '';
	}

	$cache_key = 'bb_live_twitch_access_token';
	$token     = get_transient( $cache_key );
	if ( $token ) {
		return $token;
	}

	$response = wp_remote_post(
		'https://id.twitch.tv/oauth2/token',
		array(
			'timeout' => 20,
			'body'    => array(
				'client_id'     => bb_live_twitch_client_id(),
				'client_secret' => bb_live_twitch_client_secret(),
				'grant_type'    => 'client_credentials',
			),
		)
	);

	if ( is_wp_error( $response ) ) {
		return '';
	}

	$body = json_decode( wp_remote_retrieve_body( $response ), true );
	if ( empty( $body['access_token'] ) ) {
		return '';
	}

	$expires = isset( $body['expires_in'] ) ? max( 300, absint( $body['expires_in'] ) - 60 ) : HOUR_IN_SECONDS;
	set_transient( $cache_key, $body['access_token'], $expires );

	return $body['access_token'];
}

/**
 * Retrieves the stream status for the configured channel.
 *
 * @param string $channel Optional override channel.
 * @return array
 */
function bb_live_twitch_stream_status( $channel = '' ) {
	$channel = $channel ? sanitize_text_field( $channel ) : bb_live_twitch_channel();
	if ( ! $channel ) {
		return array(
			'is_live' => null,
			'message' => __( 'Missing Twitch channel configuration.', 'brendon-core' ),
			'raw'     => array(),
		);
	}

	$cache_key = 'bb_live_twitch_stream_' . sanitize_title( $channel );
	$cached    = get_transient( $cache_key );
	if ( false !== $cached ) {
		return $cached;
	}

	if ( ! bb_live_twitch_has_credentials() ) {
		$result = array(
			'is_live' => null,
			'message' => __( 'API credentials are not configured.', 'brendon-core' ),
			'raw'     => array(),
		);
		set_transient( $cache_key, $result, MINUTE_IN_SECONDS );
		return $result;
	}

	$access_token = bb_live_twitch_get_access_token();
	if ( ! $access_token ) {
		$result = array(
			'is_live' => null,
			'message' => __( 'Unable to acquire Twitch access token.', 'brendon-core' ),
			'raw'     => array(),
		);
		set_transient( $cache_key, $result, MINUTE_IN_SECONDS );
		return $result;
	}

	$request = wp_remote_get(
		add_query_arg(
			array(
				'user_login' => $channel,
			),
			'https://api.twitch.tv/helix/streams'
		),
		array(
			'timeout' => 15,
			'headers' => array(
				'Client-ID'     => bb_live_twitch_client_id(),
				'Authorization' => 'Bearer ' . $access_token,
				'User-Agent'    => 'brendon-core-live-now/1.0',
			),
		)
	);

	if ( is_wp_error( $request ) ) {
		$result = array(
			'is_live' => null,
			'message' => $request->get_error_message(),
			'raw'     => array(),
		);
		set_transient( $cache_key, $result, MINUTE_IN_SECONDS );
		return $result;
	}

	$code = wp_remote_retrieve_response_code( $request );
	$body = json_decode( wp_remote_retrieve_body( $request ), true );

	if ( 200 !== absint( $code ) || empty( $body['data'] ) ) {
		$result = array(
			'is_live' => false,
			'message' => $body['message'] ?? '',
			'raw'     => $body,
		);
		set_transient( $cache_key, $result, MINUTE_IN_SECONDS );
		return $result;
	}

	$result = array(
		'is_live' => true,
		'message' => '',
		'raw'     => $body,
	);
	set_transient( $cache_key, $result, MINUTE_IN_SECONDS );

	return $result;
}

/**
 * Returns the stored schedule JSON.
 *
 * @return string
 */
function bb_live_schedule_json() {
	return stripslashes( get_theme_mod( 'bb_live_schedule_json', '' ) );
}
