<?php
/**
 * Standalone overlay. Avalon’s theme chrome is not used, so the old
 * loading screen cannot hide Japanese or English pages.
 */
$GLOBALS['KOCORO_IN_VIEW'] = true;
$lang                      = function_exists( 'kocorolab_refresh_lang' ) ? kocorolab_refresh_lang() : 'ja';
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?php echo esc_html( wp_get_document_title() ); ?></title>
<style id="kocorolab-refresh-critical">
html,body{margin:0;padding:0;background:#f5f8fa}
#site_wrap{display:block!important}
#site_loader_overlay,#site_loader_spinner,#fullpage,#fp-nav,#header,#header_top,#footer,#footer_widget,#side_col{display:none!important}
</style>
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>><?php
if ( function_exists( 'wp_body_open' ) ) {
	wp_body_open();
}
kocorolab_refresh_site_header();

if ( is_front_page() ) {
	include __DIR__ . '/front-page.php';
} elseif ( function_exists( 'is_post_type_archive' ) && is_post_type_archive( 'news' ) ) {
	include __DIR__ . '/archive-news.php';
} elseif ( function_exists( 'is_singular' ) && is_singular( 'news' ) ) {
	include __DIR__ . '/single-news.php';
} else {
	echo '<main>';
	$lp = function_exists( 'is_page' ) && is_page( array( 'mhqlp', 'mhq' ) );
	if ( $lp ) {
		echo '<div class="kl-page kl-mhq-lp">';
	}
	if ( have_posts() ) {
		while ( have_posts() ) {
			the_post();
			the_content();
		}
	}
	if ( $lp ) {
		echo '</div>';
	}
	echo '</main>';
}

kocorolab_refresh_site_footer();
wp_footer();
?>
</body>
</html>
