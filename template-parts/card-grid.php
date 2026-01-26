<?php
/**
 * Card markup used in the featured grid on the home and archive templates.
 *
 * @package brendon-core
 */

$grid_span = get_query_var( 'grid_span', '' );
$card_classes = trim( "relative flex flex-col gap-4 rounded-3xl border border-[#F2A25C]/30 bg-white p-6 shadow-lg transition hover:-translate-y-0.5 hover:shadow-2xl dark:border-[#F2A25C]/20 dark:bg-slate-900 dark:text-slate-100 {$grid_span}" );
?>

<article class="<?php echo esc_attr( $card_classes ); ?>">
	<?php if ( has_post_thumbnail() ) : ?>
		<div class="overflow-hidden rounded-2xl">
			<a class="group block" href="<?php the_permalink(); ?>">
				<?php the_post_thumbnail( 'large', [ 'class' => 'h-48 w-full object-cover transition duration-300 group-hover:scale-105' ] ); ?>
			</a>
		</div>
	<?php endif; ?>

	<header class="flex flex-col gap-2">
		<div class="text-xs font-semibold uppercase tracking-wider text-[#F2A25C] dark:text-[#F2A25C]/90">
			<?php the_category( ' · ' ); ?>
		</div>
		<h3 class="text-xl font-semibold leading-tight">
			<a class="text-slate-900 transition-colors hover:text-[#F26D3D] dark:text-white" href="<?php the_permalink(); ?>">
				<?php the_title(); ?>
			</a>
		</h3>
		<div class="text-sm text-slate-600 dark:text-slate-300">
			<?php echo wp_trim_words( get_the_excerpt(), 35, '…' ); ?>
		</div>
	</header>

	<div class="mt-auto flex items-center justify-between text-xs uppercase tracking-wide text-slate-500 dark:text-slate-300">
		<span><?php echo esc_html( get_the_date() ); ?></span>
		<span><?php echo esc_html( get_the_author() ); ?></span>
	</div>
</article>
