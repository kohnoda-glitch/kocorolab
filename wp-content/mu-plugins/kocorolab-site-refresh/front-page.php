<?php
get_header();
$options = function_exists( 'get_desing_plus_option' ) ? get_desing_plus_option() : array();
$lang    = kocorolab_refresh_lang();
?>
<div id="edit-area" class="mt0 kl-home-wrap">
	<?php if ( ! empty( $options['news_visible'] ) ) : ?>
		<?php
		$news_posts = get_posts(
			array(
				'post_type'   => 'news',
				'numberposts' => isset( $options['news_count'] ) ? (int) $options['news_count'] : 5,
				'order'       => 'DESC',
				'orderby'     => 'post_date',
			)
		);
		?>
		<?php if ( $news_posts ) : ?>
			<div id="index_news">
				<div id="newsticker">
					<div class="row no-gutters">
						<div class="ticker col-md-10" rel="fade">
							<ul>
								<?php foreach ( $news_posts as $post ) : setup_postdata( $post ); ?>
									<li>
										<time class="date" datetime="<?php echo esc_attr( get_the_date( 'Y-m-d' ) ); ?>"><?php echo esc_html( get_the_date( 'Y.m.d' ) ); ?></time>
										<span class="title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></span>
									</li>
								<?php endforeach; wp_reset_postdata(); ?>
							</ul>
						</div>
						<div class="archive_link col-md-2">
							<a href="<?php echo esc_url( get_post_type_archive_link( 'news' ) ); ?>"><?php echo esc_html( isset( $options['news_linktext'] ) ? $options['news_linktext'] : 'News' ); ?></a>
						</div>
					</div>
				</div>
			</div>
		<?php endif; ?>
	<?php endif; ?>

	<main class="kl-home" lang="<?php echo esc_attr( $lang ); ?>">
		<section class="kl-hero">
			<p class="kl-kicker"><?php kocorolab_refresh_e( 'hero_kicker' ); ?></p>
			<h1><?php kocorolab_refresh_e( 'hero_title' ); ?></h1>
			<p class="kl-lead"><?php kocorolab_refresh_e( 'hero_lead' ); ?></p>
			<p class="kl-actions">
				<a class="kl-btn" href="<?php echo esc_url( kocorolab_refresh_url( '/service/', '/en/service/' ) ); ?>"><?php kocorolab_refresh_e( 'hero_cta1' ); ?></a>
				<a class="kl-btn kl-btn-ghost" href="<?php echo esc_url( kocorolab_refresh_url( '/hakkou/', '/en/publications/' ) ); ?>"><?php kocorolab_refresh_e( 'hero_cta2' ); ?></a>
			</p>
		</section>

		<section class="kl-section">
			<h2><?php kocorolab_refresh_e( 'section_work' ); ?></h2>
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
