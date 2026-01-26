<?php

/**
 * The main template file
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package brendon-core
 */

get_header();
?>

<main id="primary" class="site-main min-h-screen bg-[#F2F2F2]">
	<div class="w-full px-6 py-8">

		<div class="grid grid-cols-1 gap-8 lg:grid-cols-12">

			<aside class="lg:col-span-3 lg:sticky lg:top-8 self-start">
				<?php get_template_part('template-parts/sidebar-panel'); ?>
			</aside>

			<section class="lg:col-span-9 space-y-6">

				<?php if (have_posts()) : ?>

					<div class="grid grid-cols-1 gap-6">
						<?php
						while (have_posts()) :
							the_post();
							get_template_part('template-parts/content');
						endwhile;
						?>
					</div>

					<?php
					$pagination = paginate_links([
						'type' => 'array',
						'prev_text' => esc_html__('← Previous', 'brendon-core'),
						'next_text' => esc_html__('Next →', 'brendon-core'),
					]);

					if (!empty($pagination) && is_array($pagination)) :
					?>
						<nav class="mt-10" aria-label="<?php esc_attr_e('Posts pagination', 'brendon-core'); ?>">
							<ul class="flex flex-wrap gap-2">
						<?php foreach ($pagination as $link) : ?>
							<li class="[&>a]:inline-flex [&>a]:items-center [&>a]:rounded-lg [&>a]:border [&>a]:border-[#F2A25C]/30 [&>a]:bg-white [&>a]:px-3 [&>a]:py-2 [&>a]:text-sm [&>a]:text-slate-700 [&>a]:shadow-sm [&>a]:transition [&>a]:hover:bg-[#F2EB8D]/60 [&>a]:hover:text-slate-900 [&>a]:focus-visible:outline [&>a]:focus-visible:outline-2 [&>a]:focus-visible:outline-offset-2 [&>a]:focus-visible:outline-[#F2A25C]/70 [&>span]:inline-flex [&>span]:items-center [&>span]:rounded-lg [&>span]:border [&>span]:border-[#F24E29] [&>span]:bg-[#F24E29] [&>span]:px-3 [&>span]:py-2 [&>span]:text-sm [&>span]:text-white [&>span]:shadow-sm">
										<?php echo wp_kses_post($link); ?>
									</li>
								<?php endforeach; ?>
							</ul>
						</nav>
					<?php endif; ?>

				<?php else : ?>

					<div class="rounded-xl border border-[#F2A25C]/30 bg-white p-8 shadow-sm">
						<h2 class="text-2xl font-semibold tracking-tight"><?php esc_html_e('No posts yet', 'brendon-core'); ?></h2>
						<p class="mt-2 text-slate-600"><?php esc_html_e('Once you publish posts, they’ll show up here.', 'brendon-core'); ?></p>
					</div>

				<?php endif; ?>

			</section>

		</div>

	</div>
</main>

<?php
get_footer();
