<?php
$lang = kocorolab_refresh_lang();
?>
<main>
	<div class="kl-page">
		<h1><?php echo esc_html( kocorolab_refresh_t( 'section_news', $lang ) ); ?></h1>
		<p class="kl-lead"><?php echo esc_html( kocorolab_refresh_t( 'news_lead', $lang ) ); ?></p>
		<?php if ( have_posts() ) : ?>
			<ul class="kl-news-list">
				<?php while ( have_posts() ) : the_post(); ?>
					<li>
						<time datetime="<?php echo esc_attr( get_the_date( 'Y-m-d' ) ); ?>"><?php echo esc_html( get_the_date( 'Y.m.d' ) ); ?></time>
						<a href="<?php echo esc_url( kocorolab_refresh_news_permalink() ); ?>"><?php the_title(); ?></a>
					</li>
				<?php endwhile; ?>
			</ul>
		<?php else : ?>
			<?php echo kocorolab_refresh_news_html( $lang ); ?>
		<?php endif; ?>
	</div>
</main>
