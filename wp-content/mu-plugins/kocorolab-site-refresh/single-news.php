<?php
?>
<main>
	<div class="kl-page">
		<p class="kl-kicker"><?php echo esc_html( get_the_date( 'Y.m.d' ) ); ?></p>
		<h1><?php the_title(); ?></h1>
		<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
			<?php the_content(); ?>
		<?php endwhile; endif; ?>
		<p><a href="<?php echo esc_url( kocorolab_refresh_url( '/news/', '/news/?lang=en' ) ); ?>"><?php echo esc_html( kocorolab_refresh_t( 'news_link' ) ); ?></a></p>
	</div>
</main>
