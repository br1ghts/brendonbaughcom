<?php

/**
 * Lightweight mobile navigation alternative for the sidebar.
 *
 * @package brendon-core
 */

$fallback_pages = brendon_core_sidebar_fallback_pages();
$social_links = brendon_core_get_sidebar_social_links();
?>

<details class="lg:hidden rounded-2xl border border-[#F2A25C]/30 bg-white p-4 shadow-sm transition dark:bg-slate-900 dark:border-[#F2A25C]/20">
	<summary class="flex items-center justify-between text-sm font-semibold text-slate-900 dark:text-white">
		<span class="sr-only"><?php esc_html_e('Open mobile navigation', 'brendon-core'); ?></span>
		<svg class="h-6 w-6 text-[#F26D3D]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
			<line x1="3" y1="6" x2="21" y2="6"></line>
			<line x1="3" y1="12" x2="21" y2="12"></line>
			<line x1="3" y1="18" x2="21" y2="18"></line>
		</svg>
	</summary>

	<div class="mt-4 space-y-4">
		<nav aria-label="<?php echo esc_attr_x('Mobile sidebar menu', 'aria label', 'brendon-core'); ?>">
			<?php if (has_nav_menu('sidebar')) : ?>
				<?php
				wp_nav_menu(
					[
						'theme_location' => 'sidebar',
						'container'      => '',
						'menu_class'     => 'space-y-2',
						'depth'          => 1,
						'fallback_cb'    => false,
					]
				);
				?>
			<?php else : ?>
				<ul class="space-y-2">
					<?php foreach ($fallback_pages as $page) : ?>
						<li>
							<a class="block rounded-lg border border-[#F2A25C]/30 bg-[#F2EB8D]/40 px-3 py-2 text-sm font-medium text-slate-900 transition hover:bg-[#F26D3D]/10 dark:text-slate-200" href="<?php echo esc_url($page['url']); ?>">
								<?php echo esc_html($page['label']); ?>
							</a>
						</li>
					<?php endforeach; ?>
				</ul>
			<?php endif; ?>
		</nav>

		<?php if ( has_nav_menu( 'sidebar-secondary' ) ) : ?>
			<?php
			$sidebar_secondary_label = brendon_core_get_menu_label_by_location( 'sidebar-secondary' );
			if ( ! $sidebar_secondary_label ) {
				$sidebar_secondary_label = esc_html__( 'More links', 'brendon-core' );
			}
			?>
			<div class="space-y-2">
				<p class="text-xs font-semibold uppercase tracking-wide text-slate-500 dark:text-slate-400">
					<?php echo esc_html( $sidebar_secondary_label ); ?>
				</p>
				<nav aria-label="<?php echo esc_attr_x( 'Mobile sidebar secondary menu', 'aria label', 'brendon-core' ); ?>">
					<?php
					wp_nav_menu(
						[
							'theme_location' => 'sidebar-secondary',
							'container'      => '',
							'menu_class'     => 'space-y-2',
							'depth'          => 1,
							'fallback_cb'    => false,
						]
					);
					?>
				</nav>
			</div>
		<?php endif; ?>

		<form role="search" method="get" action="<?php echo esc_url(home_url('/')); ?>" class="space-y-2">
			<label class="sr-only" for="mobile-menu-search"><?php esc_html_e('Search posts', 'brendon-core'); ?></label>
			<div class="flex gap-2">
				<input id="mobile-menu-search" name="s" type="search" placeholder="<?php esc_attr_e('Search the archive…', 'brendon-core'); ?>" class="flex-1 rounded-lg border border-[#F2A25C]/30 bg-[#F2F2F2] px-3 py-2 text-sm text-slate-900 placeholder:text-slate-500 focus:outline-none focus:border-[#F2A25C] focus:ring-2 focus:ring-[#F2A25C]/40 dark:bg-slate-900 dark:text-slate-100" />
				<button type="submit" class="rounded-lg border border-transparent bg-[#F26D3D] px-3 py-2 text-sm font-semibold uppercase tracking-wide text-white transition hover:bg-[#F24E29]"><?php esc_html_e('Go', 'brendon-core'); ?></button>
			</div>
		</form>

		<div class="rounded-lg border border-[#F2A25C]/30 bg-[#F2F2F2] p-3 dark:bg-slate-950">
			<p class="text-xs font-semibold uppercase tracking-wide text-slate-500 dark:text-slate-400"><?php esc_html_e('Social links', 'brendon-core'); ?></p>
			<div class="mt-3 flex flex-wrap items-center justify-center gap-3 text-slate-700 dark:text-slate-200">
				<?php foreach ($social_links as $social) : ?>
					<a href="<?php echo esc_url($social['url']); ?>" target="_blank" rel="noopener noreferrer" class="flex h-11 w-11 items-center justify-center rounded-full border border-[#F2A25C]/30 bg-white text-[#F26D3D] transition hover:bg-[#F2EB8D]/40 dark:border-slate-800 dark:bg-slate-900">
						<span class="sr-only"><?php echo esc_html($social['label']); ?></span>
						<span class="flex h-5 w-5 items-center justify-center">
							<?php echo brendon_core_get_social_icon_svg($social['icon'], 'h-4 w-4'); ?>
						</span>
					</a>
				<?php endforeach; ?>
				<button data-theme-toggle type="button" class="flex h-11 w-11 items-center justify-center rounded-full border border-[#F2A25C]/30 bg-white text-[#F26D3D] transition hover:bg-[#F2EB8D]/40 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-[#F2A25C]/70 dark:border-slate-800 dark:bg-slate-900">
					<span class="sr-only"><?php esc_html_e('Toggle light and dark mode', 'brendon-core'); ?></span>
					<span class="relative flex h-5 w-5 items-center justify-center">
						<svg class="absolute h-5 w-5 dark:hidden" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
							<circle cx="12" cy="12" r="5"></circle>
							<path d="M12 1v2M12 21v2M4.22 4.22l1.41 1.41M18.36 18.36l1.41 1.41M1 12h2M21 12h2M4.22 19.78l1.41-1.41M18.36 5.64l1.41-1.41"></path>
						</svg>
						<svg class="absolute hidden h-5 w-5 dark:inline" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
							<path d="M21 12.79A9 9 0 0111.21 3 7 7 0 1019 12.79z"></path>
						</svg>
					</span>
				</button>
			</div>
		</div>
	</div>
</details>
