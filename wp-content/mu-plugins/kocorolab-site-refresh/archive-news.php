<?php
if ( ! defined( 'KOCOROLAB_REFRESH_DIR' ) || __DIR__ !== KOCOROLAB_REFRESH_DIR ) {
	return;
}
$lang = kocorolab_refresh_lang();
$wp   = array();
if ( function_exists( 'get_posts' ) ) {
	$wp = get_posts(
		array(
			'post_type'        => 'news',
			'posts_per_page'   => -1,
			'orderby'          => 'date',
			'order'            => 'DESC',
			'suppress_filters' => false,
		)
	);
}
$items = kocorolab_refresh_news_feed_items( $lang, $wp );
?>
<main>
	<div class="kl-page">
		<h1><?php echo esc_html( kocorolab_refresh_t( 'section_news', $lang ) ); ?></h1>
		<p class="kl-lead"><?php echo esc_html( kocorolab_refresh_t( 'news_lead', $lang ) ); ?></p>
		<?php if ( $items ) : ?>
			<?php echo kocorolab_refresh_news_list_html( $items, $lang ); ?>
		<?php else : ?>
			<p><?php echo esc_html( kocorolab_refresh_t( 'news_empty', $lang ) ); ?></p>
		<?php endif; ?>
	</div>
</main>
