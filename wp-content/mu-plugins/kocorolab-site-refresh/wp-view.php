<?php
/**
 * WordPress shell: our chrome + content, Avalon header/footer hidden by CSS.
 */
$GLOBALS['KOCORO_IN_VIEW'] = true;
get_header();
kocorolab_refresh_site_header();

if ( is_front_page() ) {
	include __DIR__ . '/front-page.php';
} elseif ( function_exists( 'is_post_type_archive' ) && is_post_type_archive( 'news' ) ) {
	include __DIR__ . '/archive-news.php';
} elseif ( function_exists( 'is_singular' ) && is_singular( 'news' ) ) {
	include __DIR__ . '/single-news.php';
} else {
	echo '<main>';
	if ( have_posts() ) {
		while ( have_posts() ) {
			the_post();
			the_content();
		}
	}
	echo '</main>';
}

kocorolab_refresh_site_footer();
get_footer();
