<?php

/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package brendon-core
 */

$permalink  = get_permalink();
$title      = get_the_title();
$date       = get_the_date();
$author     = get_the_author();
$category_objects = get_the_category();
$category_badges = '';
	if ( 'post' === get_post_type() && ! empty( $category_objects ) ) {
		foreach ( $category_objects as $category_object ) {
			$category_link = get_category_link( $category_object );
			if ( is_wp_error( $category_link ) || ! $category_link ) {
				continue;
			}

			$category_badges .= sprintf(
				'<a href="%s" class="inline-flex items-center rounded-full bg-[#F2EB8D]/60 px-3 py-1 text-[11px] font-semibold text-slate-900 transition hover:bg-[#F2EB8D] focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-[#F2A25C]/60">%s</a>',
				esc_url( $category_link ),
				esc_html( $category_object->name )
			);
		}
	}
$has_thumb  = has_post_thumbnail();

$post_content_value = get_post_field( 'post_content', get_the_ID() );
$word_count = str_word_count( wp_strip_all_tags( $post_content_value ?: '' ) );
$reading_minutes = max( 1, (int) ceil( $word_count / 200 ) );
$reading_time = '';
if ( 'post' === get_post_type() ) {
	$reading_time = sprintf(
		/* translators: %s: minutes of reading time. */
		_n( '%s min read', '%s min read', $reading_minutes, 'brendon-core' ),
		number_format_i18n( $reading_minutes )
	);
}

$card_classes = 'group relative overflow-hidden rounded-2xl border border-[#F2A25C]/30 bg-white p-6 shadow-sm transition duration-300 hover:-translate-y-[1px] hover:border-[#F2A25C]/60 hover:shadow-lg focus-within:-translate-y-[1px] focus-within:border-[#F2A25C]/60 focus-within:shadow-lg';

if ( is_singular() ) :
	?>

	<main id="primary" class="site-main min-h-screen bg-[#F2F2F2]">
		<div class="w-full px-6 py-8">
			<div class="grid grid-cols-1 gap-8 lg:grid-cols-12">

				<aside class="lg:col-span-3 lg:sticky lg:top-8 self-start">
					<?php get_template_part( 'template-parts/sidebar-panel' ); ?>
				</aside>

				<section class="lg:col-span-9 space-y-6">

					<article id="post-<?php the_ID(); ?>" <?php post_class( $card_classes ); ?>>

						<div class="flex flex-col gap-4">

							<?php if ( $has_thumb ) : ?>
								<div class="overflow-hidden rounded-2xl border border-[#F2A25C]/30 bg-white shadow-sm">
									<?php the_post_thumbnail( 'large', [ 'class' => 'h-auto w-full object-cover transition duration-300 group-hover:scale-105' ] ); ?>
								</div>
							<?php else : ?>
								<div class="flex h-52 items-center justify-center rounded-2xl border border-[#F2A25C]/30 bg-gradient-to-r from-[#F2EB8D]/40 via-[#F2F2F2]/70 to-[#F2F2F2]/70 text-sm font-semibold uppercase tracking-wide text-slate-500">
									<?php esc_html_e( 'No featured image', 'brendon-core' ); ?>
								</div>
							<?php endif; ?>

							<header class="flex flex-col gap-3">
								<?php if ( $category_badges ) : ?>
									<div class="flex flex-wrap gap-2">
										<?php echo wp_kses_post( $category_badges ); ?>
									</div>
								<?php endif; ?>

								<h1 class="text-3xl font-semibold tracking-tight leading-tight text-slate-900 transition-colors duration-200">
									<?php echo esc_html( $title ); ?>
								</h1>

								<?php if ( 'post' === get_post_type() ) : ?>
									<div class="flex flex-wrap items-center gap-2 text-sm text-slate-600">
										<span><?php echo esc_html( $date ); ?></span>
										<span class="text-slate-300">•</span>
										<span><?php echo esc_html( $author ); ?></span>
										<?php if ( $reading_time ) : ?>
											<span class="text-slate-300">•</span>
											<span><?php echo esc_html( $reading_time ); ?></span>
										<?php endif; ?>
									</div>
								<?php endif; ?>
							</header>

							<div class="prose prose-slate max-w-none text-slate-600 prose-blockquote:border-[#F2A25C] prose-blockquote:border-l-4 prose-blockquote:bg-[#F2EB8D]/20 prose-blockquote:text-slate-800 prose-blockquote:px-4 prose-blockquote:py-2 prose-blockquote:rounded-lg">
								<?php
								the_content();
								wp_link_pages(
									[
										'before' => '<div class="mt-6 text-sm text-slate-600">' . esc_html__( 'Pages:', 'brendon-core' ) . ' ',
										'after'  => '</div>',
									]
								);
								?>
							</div>

							<?php if ( 'post' === get_post_type() ) : ?>
								<footer class="pt-2 text-sm text-slate-600">
									<?php the_tags( 'Tags: ', ', ', '' ); ?>
								</footer>
							<?php endif; ?>

						</div>

					</article>

					<?php if ( comments_open() || get_comments_number() ) : ?>
						<div class="mt-10">
							<?php comments_template(); ?>
						</div>
					<?php endif; ?>

				</section>

			</div>
		</div>
	</main>

<?php else : ?>

	<article id="post-<?php the_ID(); ?>" <?php post_class( $card_classes ); ?>>
		<div class="flex flex-col gap-4">

			<?php if ( $has_thumb ) : ?>
				<a class="overflow-hidden rounded-2xl border border-[#F2A25C]/30 bg-white shadow-sm transition duration-300 group-hover:shadow-lg" href="<?php echo esc_url( $permalink ); ?>" aria-label="<?php echo esc_attr( $title ); ?>">
					<?php the_post_thumbnail( 'large', [ 'class' => 'h-auto w-full object-cover transition duration-300 group-hover:scale-105' ] ); ?>
				</a>
			<?php else : ?>
				<div class="flex h-48 items-center justify-center rounded-2xl border border-[#F2A25C]/30 bg-gradient-to-r from-[#F2EB8D]/40 via-[#F2F2F2]/80 to-[#F2F2F2]/80 text-sm font-semibold uppercase tracking-wide text-slate-500">
					<?php esc_html_e( 'No featured image', 'brendon-core' ); ?>
				</div>
			<?php endif; ?>

			<header class="flex flex-col gap-3">
				<?php if ( $category_badges ) : ?>
					<div class="flex flex-wrap gap-2">
						<?php echo wp_kses_post( $category_badges ); ?>
					</div>
				<?php endif; ?>

				<h2 class="text-2xl font-semibold tracking-tight leading-tight">
					<a class="text-slate-900 transition-colors duration-200 hover:text-[#F26D3D] focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-[#F2A25C]/70" href="<?php echo esc_url( $permalink ); ?>" rel="bookmark">
						<?php echo esc_html( $title ); ?>
					</a>
				</h2>

				<?php if ( 'post' === get_post_type() ) : ?>
					<div class="flex flex-wrap items-center gap-2 text-sm text-slate-600">
						<span><?php echo esc_html( $date ); ?></span>
						<span class="text-slate-300">•</span>
						<span><?php echo esc_html( $author ); ?></span>
						<?php if ( $reading_time ) : ?>
							<span class="text-slate-300">•</span>
							<span><?php echo esc_html( $reading_time ); ?></span>
						<?php endif; ?>
					</div>
				<?php endif; ?>
			</header>

			<div class="prose prose-slate max-w-none text-slate-700 leading-relaxed prose-blockquote:border-[#F2A25C] prose-blockquote:border-l-4 prose-blockquote:bg-[#F2EB8D]/20 prose-blockquote:text-slate-800 prose-blockquote:px-4 prose-blockquote:py-2 prose-blockquote:rounded-lg">
				<?php the_excerpt(); ?>
			</div>

			<div>
				<a class="inline-flex items-center gap-2 rounded-lg border border-[#F26D3D] bg-[#F26D3D] px-4 py-2 text-sm font-semibold uppercase tracking-wide text-white shadow-sm transition hover:bg-[#F24E29] focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-[#F2A25C]/70" href="<?php echo esc_url( $permalink ); ?>">
					<?php esc_html_e( 'Read more', 'brendon-core' ); ?>
					<span aria-hidden="true">→</span>
				</a>
			</div>

		</div>
	</article>

<?php endif; ?>
