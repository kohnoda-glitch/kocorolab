<?php
get_header();
$lang = kocorolab_refresh_lang();

$news_posts = array();
if ( function_exists( 'get_posts' ) ) {
	$news_posts = get_posts(
		array(
			'post_type'        => 'news',
			'posts_per_page'   => 4,
			'orderby'          => 'date',
			'order'            => 'DESC',
			'suppress_filters' => false,
		)
	);
}
?>
<div id="edit-area" class="mt0 kl-home-wrap">
	<main class="kl-home" lang="<?php echo esc_attr( $lang ); ?>">
		<section class="kl-hero">
			<p class="kl-kicker"><?php kocorolab_refresh_e( 'hero_kicker' ); ?></p>
			<h1><?php kocorolab_refresh_e( 'hero_title' ); ?></h1>
			<p class="kl-lead"><?php kocorolab_refresh_e( 'hero_lead' ); ?></p>
			<p class="kl-actions">
				<a class="kl-btn" href="<?php echo esc_url( kocorolab_refresh_url( '/service/', '/en/service/' ) ); ?>"><?php kocorolab_refresh_e( 'hero_cta1' ); ?></a>
				<a class="kl-btn kl-btn-ghost" href="<?php echo esc_url( kocorolab_refresh_url( '/news/', '/en/news/' ) ); ?>"><?php kocorolab_refresh_e( 'hero_cta2' ); ?></a>
			</p>
		</section>

		<section class="kl-section">
			<h2><?php kocorolab_refresh_e( 'section_world' ); ?></h2>
			<p class="kl-lead"><?php kocorolab_refresh_e( 'world_lead' ); ?></p>
			<div class="kl-cards">
				<article class="kl-card">
					<p class="kl-kicker"><?php kocorolab_refresh_e( 'domain1_kicker' ); ?></p>
					<h3><?php kocorolab_refresh_e( 'domain1_title' ); ?></h3>
					<p><?php kocorolab_refresh_e( 'domain1_body' ); ?></p>
				</article>
				<article class="kl-card">
					<p class="kl-kicker"><?php kocorolab_refresh_e( 'domain2_kicker' ); ?></p>
					<h3><?php kocorolab_refresh_e( 'domain2_title' ); ?></h3>
					<p><?php kocorolab_refresh_e( 'domain2_body' ); ?></p>
				</article>
				<article class="kl-card">
					<p class="kl-kicker"><?php kocorolab_refresh_e( 'domain3_kicker' ); ?></p>
					<h3><?php kocorolab_refresh_e( 'domain3_title' ); ?></h3>
					<p><?php kocorolab_refresh_e( 'domain3_body' ); ?></p>
				</article>
			</div>
		</section>

		<section class="kl-section">
			<h2><?php kocorolab_refresh_e( 'section_work' ); ?></h2>
			<p class="kl-lead"><?php kocorolab_refresh_e( 'work_lead' ); ?></p>
			<div class="kl-cards">
				<article class="kl-card">
					<h3><?php kocorolab_refresh_e( 'card1_title' ); ?></h3>
					<p><?php kocorolab_refresh_e( 'card1_body' ); ?></p>
				</article>
				<article class="kl-card">
					<h3><?php kocorolab_refresh_e( 'card2_title' ); ?></h3>
					<p><?php kocorolab_refresh_e( 'card2_body' ); ?></p>
				</article>
				<article class="kl-card">
					<h3><?php kocorolab_refresh_e( 'card3_title' ); ?></h3>
					<p><?php kocorolab_refresh_e( 'card3_body' ); ?></p>
				</article>
			</div>
			<p class="kl-actions">
				<a class="kl-btn" href="<?php echo esc_url( kocorolab_refresh_url( '/service/', '/en/service/' ) ); ?>"><?php kocorolab_refresh_e( 'work_link' ); ?></a>
			</p>
		</section>

		<section class="kl-section kl-news">
			<h2><?php kocorolab_refresh_e( 'section_news' ); ?></h2>
			<p class="kl-lead"><?php kocorolab_refresh_e( 'news_lead' ); ?></p>
			<?php if ( $news_posts ) : ?>
				<ul class="kl-news-list">
					<?php foreach ( $news_posts as $post ) : setup_postdata( $post ); ?>
						<li>
							<time datetime="<?php echo esc_attr( get_the_date( 'Y-m-d' ) ); ?>"><?php echo esc_html( get_the_date( 'Y.m.d' ) ); ?></time>
							<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
						</li>
					<?php endforeach; wp_reset_postdata(); ?>
				</ul>
			<?php else : ?>
				<p><?php kocorolab_refresh_e( 'news_empty' ); ?></p>
			<?php endif; ?>
			<p class="kl-actions">
				<a class="kl-btn kl-btn-ghost" href="<?php echo esc_url( kocorolab_refresh_url( '/news/', '/en/news/' ) ); ?>"><?php kocorolab_refresh_e( 'news_link' ); ?></a>
			</p>
		</section>

		<section class="kl-section kl-section-who">
			<h2><?php kocorolab_refresh_e( 'section_who' ); ?></h2>
			<p><?php kocorolab_refresh_e( 'who_body' ); ?></p>
			<p><?php kocorolab_refresh_e( 'who_hr' ); ?></p>
			<p><a href="<?php echo esc_url( kocorolab_refresh_url( '/member/', '/en/company/' ) ); ?>"><?php kocorolab_refresh_e( 'who_more' ); ?></a></p>
		</section>

		<section class="kl-section">
			<h2><?php kocorolab_refresh_e( 'section_pub' ); ?></h2>
			<p><?php kocorolab_refresh_e( 'pub_body' ); ?></p>
			<p class="kl-actions">
				<a class="kl-btn kl-btn-ghost" href="<?php echo esc_url( kocorolab_refresh_url( '/hakkou/', '/en/publications/' ) ); ?>"><?php kocorolab_refresh_e( 'pub_link' ); ?></a>
				<a class="kl-btn" href="<?php echo esc_url( kocorolab_refresh_url( '/contact/', '/en/contact/' ) ); ?>"><?php kocorolab_refresh_e( 'contact_link' ); ?></a>
			</p>
		</section>
	</main>
</div>
<?php
get_footer();
