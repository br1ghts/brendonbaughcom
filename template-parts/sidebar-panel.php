<?php

/**
 * Sidebar panel with site info, navigation, and search.
 *
 * @package brendon-core
 */

$site_title = get_bloginfo('name');
$site_description = get_bloginfo('description');
$fallback_pages = [
	[
		'label' => esc_html__('Home', 'brendon-core'),
		'url' => home_url('/'),
	],
	[
		'label' => esc_html__('Writing', 'brendon-core'),
		'url' => home_url('/writing'),
	],
	[
		'label' => esc_html__('Work', 'brendon-core'),
		'url' => home_url('/work'),
	],
	[
		'label' => esc_html__('About', 'brendon-core'),
		'url' => home_url('/about'),
	],
];
$social_links = brendon_core_get_sidebar_social_links();
?>

<div class="flex flex-col gap-6 rounded-2xl border border-[#F2A25C]/30 bg-white p-6 shadow-sm">

	<div class="space-y-1">
		<h2 class="text-xl font-semibold tracking-tight"><?php echo esc_html($site_title); ?></h2>
		<?php if ($site_description) : ?>
			<p class="text-sm text-slate-600"><?php echo esc_html($site_description); ?></p>
		<?php endif; ?>
	</div>

	<nav class="space-y-2" aria-label="<?php echo esc_attr_x('Sidebar menu', 'aria label', 'brendon-core'); ?>">
		<?php if (has_nav_menu('sidebar')) : ?>
			<?php
			wp_nav_menu([
				'theme_location' => 'sidebar',
				'container' => false,
				'menu_class' => 'space-y-2',
				'depth' => 1,
				'fallback_cb' => false,
			]);
			?>
		<?php else : ?>
			<?php $sidebar_menu_link_classes = brendon_core_sidebar_menu_base_classes(); ?>
			<ul class="space-y-2">
				<?php foreach ($fallback_pages as $page) : ?>
					<li>
						<a href="<?php echo esc_url($page['url']); ?>" class="<?php echo esc_attr($sidebar_menu_link_classes); ?>">
							<?php echo esc_html($page['label']); ?>
						</a>
					</li>
				<?php endforeach; ?>
			</ul>
		<?php endif; ?>
	</nav>

	<form role="search" method="get" class="space-y-2" action="<?php echo esc_url(home_url('/')); ?>">
		<label class="text-xs font-semibold uppercase tracking-wide text-slate-500" for="sidebar-search"><?php esc_html_e('Search posts', 'brendon-core'); ?></label>
		<div class="flex">
			<input id="sidebar-search" name="s" type="search" placeholder="<?php esc_attr_e('Search the archive…', 'brendon-core'); ?>" class="w-full rounded-l-lg border border-[#F2A25C]/30 bg-white px-3 py-2 text-sm text-slate-900 placeholder:text-slate-400 focus:outline-none focus:border-[#F2A25C] focus:ring-2 focus:ring-[#F2A25C]/40" />
			<button type="submit" class="rounded-r-lg border border-transparent bg-[#F26D3D] px-4 py-2 text-sm font-semibold uppercase tracking-wide text-white shadow-sm transition hover:bg-[#F24E29] focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-[#F2A25C]/70"><?php esc_html_e('Go', 'brendon-core'); ?></button>
		</div>
	</form>

			<div class="rounded-xl border border-[#F2A25C]/30 bg-[#F2F2F2] p-4">
				<div class="flex items-center justify-between">
					<p class="text-xs font-semibold uppercase tracking-wide text-slate-500"><?php esc_html_e('Socials', 'brendon-core'); ?></p>
				</div>
				<ul class="mt-3 space-y-2 text-sm text-slate-700">
					<?php foreach ($social_links as $social) : ?>
						<li>
							<a href="<?php echo esc_url($social['url']); ?>" target="_blank" rel="noopener noreferrer" class="flex w-full items-center gap-3 rounded-lg border border-transparent bg-white px-3 py-2 font-medium text-slate-700 transition hover:border-[#F2A25C]/40 hover:bg-[#F2EB8D]/40 hover:text-slate-900 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-[#F2A25C]/70">
									<span class="flex h-5 w-5 items-center justify-center rounded-full border border-[#F2A25C]/20 bg-white text-[#F26D3D]">
										<?php echo brendon_core_get_social_icon_svg($social['icon'], 'h-4 w-4'); ?>
									</span>
								<span><?php echo esc_html($social['label']); ?></span>
							</a>
						</li>
					<?php endforeach; ?>
				</ul>
			</div>

</div>
