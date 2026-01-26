<?php

/**
 * Sidebar panel with site info, navigation, and search.
 *
 * @package brendon-core
 */

$site_title = get_bloginfo('name');
$site_description = get_bloginfo('description');
$sidebar_items = function_exists('brendon_core_get_sidebar_menu_items') ? brendon_core_get_sidebar_menu_items() : [];
?>

<div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
	<h2 class="text-xl font-semibold tracking-tight"><?php echo esc_html($site_title); ?></h2>


	<nav class="mt-6" aria-label="<?php echo esc_attr_x('Sidebar menu', 'aria label', 'brendon-core'); ?>">
		<form role="search" method="get" class="mt-6" action="<?php echo esc_url(home_url('/')); ?>">
			<label class="sr-only" for="sidebar-search">Search</label>
			<div class="flex">
				<input id="sidebar-search" name="s" type="search" placeholder="<?php esc_attr_e('Search posts…', 'brendon-core'); ?>" class="w-full rounded-l-lg border border-slate-200 bg-white px-3 py-2 text-sm text-slate-900 placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-slate-900/20" />
				<button type="submit" class="rounded-r-lg border border-slate-900 bg-slate-900 px-3 py-2 text-sm font-medium text-white hover:bg-slate-800"><?php esc_html_e('Go', 'brendon-core'); ?></button>
			</div>
		</form>
		<?php if (! empty($sidebar_items)) : ?>
			<ul class="space-y-2 text-sm">
				<?php foreach ($sidebar_items as $item) :
					$url = ! empty($item->url) ? $item->url : '';
					$target_attr = ! empty($item->target) ? ' target="' . esc_attr($item->target) . '"' : '';
					$rel_attr = ! empty($item->xfn) ? ' rel="' . esc_attr($item->xfn) . '"' : '';
				?>
					<li>
						<a class="block rounded-lg px-3 py-2 text-slate-700 transition hover:bg-slate-50" href="<?php echo esc_url($url); ?>" <?php echo $target_attr . $rel_attr; ?>>
							<?php echo esc_html($item->title ?: $site_title); ?>
						</a>
					</li>
				<?php endforeach; ?>
			</ul>

		<?php endif; ?>
	</nav>



	<div class="mt-6 rounded-lg bg-slate-50 p-4">
		<div class="text-xs font-medium uppercase tracking-wider text-slate-500"><?php esc_html_e('Socials', 'brendon-core'); ?></div>
		<ul class="mt-2 space-y-1 text-sm text-slate-700">
			<li><a href="https://youtube.com"><?php esc_html_e('YouTube', 'brendon-core'); ?></a></li>
			<li><a href="https://twitch.tv"><?php esc_html_e('Twitch', 'brendon-core'); ?></a></li>
			<li><a href="https://instagram.com"><?php esc_html_e('Instagram', 'brendon-core'); ?></a></li>
		</ul>
	</div>
</div>
