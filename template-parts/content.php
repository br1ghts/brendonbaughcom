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
$categories = get_the_category_list(', ');
$has_thumb  = has_post_thumbnail();

$card_classes = 'rounded-2xl border border-slate-200 bg-white p-6 shadow-sm';

if (is_singular()) :
	?>

	<main id="primary" class="site-main min-h-screen bg-slate-50">
		<div class="mx-auto w-full max-w-7xl px-6 py-10">
			<div class="grid grid-cols-1 gap-8 lg:grid-cols-12">

				<aside class="lg:col-span-3 lg:sticky lg:top-8 self-start">
					<?php get_template_part('template-parts/sidebar-panel'); ?>
				</aside>

				<section class="lg:col-span-9 space-y-6">

					<article id="post-<?php the_ID(); ?>" <?php post_class($card_classes); ?>>
						<div class="flex flex-col gap-4">

							<?php if ($has_thumb) : ?>
								<div class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">
									<?php the_post_thumbnail('large', ['class' => 'h-auto w-full']); ?>
								</div>
							<?php endif; ?>

							<header class="flex flex-col gap-2">
								<?php if (!empty($categories) && 'post' === get_post_type()) : ?>
									<div class="text-sm text-slate-500">
										<?php echo wp_kses_post($categories); ?>
									</div>
								<?php endif; ?>

								<h1 class="text-3xl font-semibold tracking-tight">
									<?php echo esc_html($title); ?>
								</h1>

								<?php if ('post' === get_post_type()) : ?>
									<div class="text-sm text-slate-600">
										<span><?php echo esc_html($date); ?></span>
										<span class="mx-2 text-slate-300">•</span>
										<span><?php echo esc_html($author); ?></span>
									</div>
								<?php endif; ?>
							</header>

							<div class="prose prose-slate max-w-none">
								<?php
								the_content();
								wp_link_pages([
									'before' => '<div class="mt-6 text-sm text-slate-600">' . esc_html__('Pages:', 'brendon-core') . ' ',
									'after'  => '</div>',
								]);
								?>
							</div>

							<?php if ('post' === get_post_type()) : ?>
								<footer class="pt-2 text-sm text-slate-600">
									<?php the_tags('Tags: ', ', ', ''); ?>
								</footer>
							<?php endif; ?>

						</div>
					</article>

					<?php if (comments_open() || get_comments_number()) : ?>
						<div class="mt-10">
							<?php comments_template(); ?>
						</div>
					<?php endif; ?>

				</section>

			</div>
		</div>
	</main>

<?php else : ?>

	<article id="post-<?php the_ID(); ?>" <?php post_class($card_classes); ?>>
		<div class="flex flex-col gap-4">

			<?php if ($has_thumb) : ?>
				<a class="block overflow-hidden rounded-lg" href="<?php echo esc_url($permalink); ?>" aria-label="<?php echo esc_attr($title); ?>">
					<?php the_post_thumbnail('large', ['class' => 'h-auto w-full']); ?>
				</a>
			<?php endif; ?>

			<header class="flex flex-col gap-2">
				<?php if (!empty($categories)) : ?>
					<div class="text-sm text-slate-500">
						<?php echo wp_kses_post($categories); ?>
					</div>
				<?php endif; ?>

				<h2 class="text-2xl font-semibold tracking-tight">
					<a class="hover:underline" href="<?php echo esc_url($permalink); ?>" rel="bookmark">
						<?php echo esc_html($title); ?>
					</a>
				</h2>

				<?php if ('post' === get_post_type()) : ?>
					<div class="text-sm text-slate-600">
						<span><?php echo esc_html($date); ?></span>
						<span class="mx-2 text-slate-300">•</span>
						<span><?php echo esc_html($author); ?></span>
					</div>
				<?php endif; ?>
			</header>

			<div class="prose prose-slate max-w-none">
				<?php the_excerpt(); ?>
			</div>

			<div>
				<a class="inline-flex items-center rounded-lg border border-slate-200 bg-white px-4 py-2 text-sm font-medium text-slate-900 shadow-sm hover:bg-slate-50" href="<?php echo esc_url($permalink); ?>">
					<?php esc_html_e('Read more', 'brendon-core'); ?>
					<span class="ml-2" aria-hidden="true">→</span>
				</a>
			</div>

		</div>
	</article>

<?php endif; ?>
