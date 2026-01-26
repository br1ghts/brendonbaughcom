<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package _s
 */

get_header();
?>

<main id="primary" class="site-main min-h-screen bg-[#F2F2F2] text-slate-900 dark:bg-slate-950 dark:text-slate-100">
	<div class="w-full px-6 py-8 space-y-8">
		<section class="mx-auto flex max-w-5xl flex-col gap-10">
			<div class="rounded-3xl border border-[#F2A25C]/30 bg-white p-8 shadow-lg shadow-[#F2A25C]/10 transition dark:border-[#F2A25C]/20 dark:bg-slate-900">
				<p class="text-xs font-semibold uppercase tracking-[0.4em] text-[#F2A25C]">404 error</p>
				<h1 class="mt-4 text-4xl font-semibold leading-tight text-slate-900 dark:text-white md:text-5xl">
					Sorry, we couldn&rsquo;t find that page.
				</h1>
				<p class="mt-4 text-lg text-slate-600 dark:text-slate-300">
					It looks like the URL you entered doesn&rsquo;t exist anymore. Try searching, jump back home, or explore some recent posts.
				</p>
				<div class="mt-6 flex flex-col gap-3 text-sm text-slate-500 dark:text-slate-300 sm:flex-row sm:items-center sm:justify-between">
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="inline-flex items-center justify-center rounded-2xl border border-[#F2A25C]/40 bg-[#F26D3D] px-6 py-3 text-sm font-semibold text-white shadow-lg shadow-[#F26D3D]/30 transition hover:translate-y-0.5 hover:bg-[#F24E29]">
						Return to homepage
					</a>
					<span class="text-center sm:text-right text-slate-500 dark:text-slate-400">
						Or explore the suggestions below.
					</span>
				</div>
			</div>

			<div class="grid gap-6 lg:grid-cols-3">
				<article class="flex min-h-[220px] flex-col justify-between rounded-3xl border border-[#F2A25C]/20 bg-white p-6 shadow-lg dark:border-[#F2A25C]/20 dark:bg-slate-900">
					<header class="space-y-1">
						<p class="text-xs font-semibold uppercase tracking-[0.4em] text-[#F2A25C]">Search</p>
						<h2 class="text-2xl font-semibold text-slate-900 dark:text-white">Find what you need</h2>
					</header>
					<form role="search" method="get" class="mt-6 flex w-full flex-col gap-3" action="<?php echo esc_url( home_url( '/' ) ); ?>">
						<div class="flex w-full flex-col gap-2 sm:flex-row sm:items-center sm:gap-3">
							<label class="sr-only" for="search-input-404">Search</label>
							<input id="search-input-404" class="min-w-0 flex-1 rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-700 placeholder:text-slate-400 focus:border-[#F2A25C]/60 focus:outline-none focus:ring-2 focus:ring-[#F2A25C]/30 dark:border-slate-800 dark:bg-slate-900 dark:text-slate-100" type="search" name="s" value="<?php echo esc_attr( get_search_query() ); ?>" placeholder="Search the blog" />
							<button type="submit" class="flex h-12 items-center justify-center rounded-2xl bg-[#F26D3D] px-5 py-3 text-sm font-semibold text-white transition hover:bg-[#F24E29] sm:w-auto">
								Search
							</button>
						</div>
					</form>
				</article>

				<article class="flex min-h-[220px] flex-col justify-between rounded-3xl border border-[#F2A25C]/20 bg-white p-6 shadow-lg dark:border-[#F2A25C]/20 dark:bg-slate-900">
					<header class="space-y-1">
						<p class="text-xs font-semibold uppercase tracking-[0.4em] text-[#F2A25C]">Recent</p>
						<h2 class="text-2xl font-semibold text-slate-900 dark:text-white">Fresh posts</h2>
					</header>
					<ul class="mt-6 space-y-4 text-sm text-slate-600 dark:text-slate-300">
						<?php
						$recent_query = new WP_Query(
							[
								'posts_per_page'      => 5,
								'post_status'         => 'publish',
								'ignore_sticky_posts' => true,
							]
						);

						if ( $recent_query->have_posts() ) :
							while ( $recent_query->have_posts() ) :
								$recent_query->the_post();
								?>
								<li>
									<a href="<?php the_permalink(); ?>" class="font-semibold text-slate-900 transition hover:text-[#F26D3D] dark:text-white">
										<?php the_title(); ?>
									</a>
									<p class="text-xs font-medium uppercase tracking-wide text-slate-400 dark:text-slate-500">
										<?php echo esc_html( get_the_date() ); ?>
									</p>
								</li>
							<?php endwhile; ?>
							<?php wp_reset_postdata(); ?>
						<?php else : ?>
							<li class="text-sm text-slate-500 dark:text-slate-400"><?php esc_html_e( 'No recent posts available right now.', 'brendon-core' ); ?></li>
						<?php endif; ?>
					</ul>
				</article>

				<article class="flex min-h-[220px] flex-col justify-between rounded-3xl border border-[#F2A25C]/20 bg-white p-6 shadow-lg dark:border-[#F2A25C]/20 dark:bg-slate-900">
					<header class="space-y-1">
						<p class="text-xs font-semibold uppercase tracking-[0.4em] text-[#F2A25C]">Browse</p>
						<h2 class="text-2xl font-semibold text-slate-900 dark:text-white">Categories & archives</h2>
					</header>
					<div class="mt-6 space-y-6 text-sm text-slate-600 dark:text-slate-300">
						<div>
							<p class="text-sm font-semibold text-slate-900 dark:text-white">Top categories</p>
							<ul class="mt-3 space-y-2 text-slate-600 dark:text-slate-300">
								<?php
								wp_list_categories(
									[
										'orderby'    => 'count',
										'order'      => 'DESC',
										'show_count' => 1,
										'title_li'   => '',
										'number'     => 6,
										'depth'      => 1,
									]
								);
								?>
							</ul>
						</div>
						<div>
							<p class="text-sm font-semibold text-slate-900 dark:text-white">Monthly archives</p>
							<ul class="mt-3 space-y-2 text-slate-600 dark:text-slate-300">
								<?php
								wp_get_archives(
									[
										'type'            => 'monthly',
										'limit'           => 6,
										'show_post_count' => true,
									]
								);
								?>
							</ul>
						</div>
					</div>
				</article>
			</div>
		</section>
	</div>
</main><!-- #main -->

<?php
get_footer();
