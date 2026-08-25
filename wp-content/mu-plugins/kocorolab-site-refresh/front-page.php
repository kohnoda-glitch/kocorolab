<?php
if ( empty( $GLOBALS['KOCORO_IN_VIEW'] ) ) {
	get_header();
	kocorolab_refresh_site_header();
}

$lang        = kocorolab_refresh_lang();
$hero        = kocorolab_refresh_image_url( 'hero' );
$spirit      = kocorolab_refresh_image_url( 'spirit' );
$society     = kocorolab_refresh_image_url( 'society' );
$environment = kocorolab_refresh_image_url( 'environment' );

$news_posts = array();
if ( function_exists( 'get_posts' ) ) {
	$news_posts = get_posts(
		array(
			'post_type'        => 'news',
			'posts_per_page'   => 20,
			'orderby'          => 'date',
			'order'            => 'DESC',
			'suppress_filters' => false,
		)
	);
}
$news_items = kocorolab_refresh_news_feed_items( $lang, $news_posts, 4 );
?>
<div id="edit-area" class="mt0 kl-home-wrap">
	<main class="kl-home" lang="<?php echo esc_attr( $lang ); ?>">
		<section class="kl-hero" style="--kl-hero-image: url('<?php echo esc_url( $hero ); ?>');">
			<div class="kl-hero-inner">
				<div class="kl-hero-copy">
					<p class="kl-badge"><?php kocorolab_refresh_e( 'hero_badge' ); ?></p>
					<h1>
						<span><?php kocorolab_refresh_e( 'hero_title' ); ?></span>
						<em><?php kocorolab_refresh_e( 'hero_title_accent' ); ?></em>
					</h1>
					<p class="kl-lead"><?php kocorolab_refresh_e( 'hero_lead' ); ?></p>
					<p class="kl-actions">
						<a class="kl-btn" href="<?php echo esc_url( kocorolab_refresh_url( '/service/', '/en/service/' ) ); ?>"><?php kocorolab_refresh_e( 'hero_cta1' ); ?></a>
						<a class="kl-btn kl-btn-ghost" href="<?php echo esc_url( kocorolab_refresh_url( '/news/', '/news/?lang=en' ) ); ?>"><?php kocorolab_refresh_e( 'hero_cta2' ); ?></a>
					</p>
				</div>
			</div>
		</section>

		<section class="kl-band kl-mission">
			<div class="kl-wide">
				<div class="kl-mission-copy">
					<p class="kl-kicker"><?php kocorolab_refresh_e( 'mission_kicker' ); ?></p>
					<h2><?php kocorolab_refresh_e( 'company_m' ); ?></h2>
					<p class="kl-mission-pair"><?php kocorolab_refresh_e( 'company_m_other' ); ?></p>
					<p><?php kocorolab_refresh_e( 'company_lead' ); ?></p>
					<p><?php kocorolab_refresh_e( 'world_lead' ); ?></p>
				</div>
				<div class="kl-mission-cards">
					<article class="kl-soft-card">
						<p class="kl-kicker"><?php kocorolab_refresh_e( 'domain1_kicker' ); ?></p>
						<h3><?php kocorolab_refresh_e( 'domain1_title' ); ?></h3>
						<p><?php kocorolab_refresh_e( 'domain1_body' ); ?></p>
					</article>
					<article class="kl-soft-card">
						<p class="kl-kicker"><?php kocorolab_refresh_e( 'domain2_kicker' ); ?></p>
						<h3><?php kocorolab_refresh_e( 'domain2_title' ); ?></h3>
						<p><?php kocorolab_refresh_e( 'domain2_body' ); ?></p>
					</article>
				</div>
			</div>
		</section>

		<section class="kl-band kl-pillars">
			<div class="kl-wide">
				<p class="kl-kicker">CORE</p>
				<h2><?php kocorolab_refresh_e( 'section_world' ); ?></h2>
				<div class="kl-photo-grid">
					<article class="kl-photo-card">
						<figure><img src="<?php echo esc_url( $spirit ); ?>" alt=""></figure>
						<p class="kl-kicker">01 · <?php kocorolab_refresh_e( 'domain1_kicker' ); ?></p>
						<h3><?php kocorolab_refresh_e( 'domain1_title' ); ?></h3>
						<p><?php kocorolab_refresh_e( 'domain1_body' ); ?></p>
					</article>
					<article class="kl-photo-card">
						<figure><img src="<?php echo esc_url( $society ); ?>" alt=""></figure>
						<p class="kl-kicker">02 · <?php kocorolab_refresh_e( 'domain2_kicker' ); ?></p>
						<h3><?php kocorolab_refresh_e( 'domain2_title' ); ?></h3>
						<p><?php kocorolab_refresh_e( 'domain2_body' ); ?></p>
					</article>
					<article class="kl-photo-card">
						<figure><img src="<?php echo esc_url( $environment ); ?>" alt=""></figure>
						<p class="kl-kicker">03 · <?php kocorolab_refresh_e( 'domain3_kicker' ); ?></p>
						<h3><?php kocorolab_refresh_e( 'domain3_title' ); ?></h3>
						<p><?php kocorolab_refresh_e( 'domain3_body' ); ?></p>
					</article>
				</div>
			</div>
		</section>

		<section class="kl-band">
			<div class="kl-wide">
				<p class="kl-kicker">SERVICES</p>
				<h2><?php kocorolab_refresh_e( 'section_work' ); ?></h2>
				<p class="kl-lead"><?php kocorolab_refresh_e( 'work_lead' ); ?></p>
				<div class="kl-photo-grid kl-text-grid">
					<article class="kl-soft-card">
						<h3><?php kocorolab_refresh_e( 'card1_title' ); ?></h3>
						<p><?php kocorolab_refresh_e( 'card1_body' ); ?></p>
					</article>
					<a class="kl-soft-card" href="<?php echo esc_url( kocorolab_refresh_mhq_lp_url() ); ?>">
						<h3><?php kocorolab_refresh_e( 'card2_title' ); ?></h3>
						<p><?php kocorolab_refresh_e( 'card2_body' ); ?></p>
					</a>
					<article class="kl-soft-card">
						<h3><?php kocorolab_refresh_e( 'card3_title' ); ?></h3>
						<p><?php kocorolab_refresh_e( 'card3_body' ); ?></p>
					</article>
				</div>
				<p class="kl-actions">
					<a class="kl-btn kl-btn-dark" href="<?php echo esc_url( kocorolab_refresh_url( '/service/', '/en/service/' ) ); ?>"><?php kocorolab_refresh_e( 'work_link' ); ?></a>
				</p>
			</div>
		</section>

		<section class="kl-band kl-band-muted">
			<div class="kl-wide">
				<p class="kl-kicker"><?php kocorolab_refresh_e( 'section_news' ); ?></p>
				<h2><?php kocorolab_refresh_e( 'section_news' ); ?></h2>
				<p class="kl-lead"><?php kocorolab_refresh_e( 'news_lead' ); ?></p>
				<?php if ( $news_items ) : ?>
					<?php echo kocorolab_refresh_news_list_html( $news_items, $lang, true ); ?>
				<?php else : ?>
					<p><?php kocorolab_refresh_e( 'news_empty' ); ?></p>
				<?php endif; ?>
				<p class="kl-actions">
					<a class="kl-btn kl-btn-dark" href="<?php echo esc_url( kocorolab_refresh_url( '/news/', '/news/?lang=en' ) ); ?>"><?php kocorolab_refresh_e( 'news_link' ); ?></a>
				</p>
			</div>
		</section>

		<section class="kl-band" id="profile">
			<div class="kl-wide kl-founder">
				<figure class="kl-founder-photo">
					<img src="<?php echo esc_url( $society ); ?>" alt="<?php echo esc_attr( kocorolab_refresh_t( 'bio_name_ja' ) ); ?>">
				</figure>
				<div class="kl-founder-copy">
					<p class="kl-kicker"><?php kocorolab_refresh_e( 'bio_kicker' ); ?></p>
					<h2><?php kocorolab_refresh_e( 'section_who' ); ?></h2>
					<?php echo kocorolab_refresh_title_list_html(); ?>
					<?php echo kocorolab_refresh_bio_tabs_html( 'home' ); ?>
					<p><?php kocorolab_refresh_e( 'who_hr' ); ?></p>
					<p><a href="<?php echo esc_url( kocorolab_refresh_url( '/member/', '/en/member/' ) ); ?>"><?php kocorolab_refresh_e( 'who_more' ); ?></a></p>
				</div>
			</div>
		</section>

		<section class="kl-band kl-band-dark">
			<div class="kl-wide">
				<h2><?php kocorolab_refresh_e( 'section_pub' ); ?></h2>
				<p><?php kocorolab_refresh_e( 'pub_body' ); ?></p>
				<p class="kl-actions">
					<a class="kl-btn kl-btn-ghost" href="<?php echo esc_url( kocorolab_refresh_publications_url() ); ?>"><?php kocorolab_refresh_e( 'pub_link' ); ?></a>
				</p>
			</div>
		</section>

		<?php echo kocorolab_refresh_contact_section_html(); ?>
	</main>
</div>
<?php
if ( empty( $GLOBALS['KOCORO_IN_VIEW'] ) ) {
	kocorolab_refresh_site_footer();
	get_footer();
}
