<?php
$lang     = kocorolab_refresh_lang();
$inserted = false;
?>
<main>
	<div class="kl-page">
		<h1><?php echo esc_html( kocorolab_refresh_t( 'section_news', $lang ) ); ?></h1>
		<p class="kl-lead"><?php echo esc_html( kocorolab_refresh_t( 'news_lead', $lang ) ); ?></p>
		<?php if ( have_posts() ) : ?>
			<ul class="kl-news-list">
				<?php
				while ( have_posts() ) :
					the_post();
					if ( ! $inserted && get_the_date( 'Y-m-d' ) < '2019-05-25' ) {
						echo kocorolab_refresh_etm_2019_news_li( $lang );
						$inserted = true;
					}
					?>
					<li>
						<time datetime="<?php echo esc_attr( get_the_date( 'Y-m-d' ) ); ?>"><?php echo esc_html( get_the_date( 'Y.m.d' ) ); ?></time>
						<div>
							<a href="<?php echo esc_url( kocorolab_refresh_news_permalink() ); ?>"><?php the_title(); ?></a>
							<?php
							$post = get_post();
							$hay  = $post ? ( $post->post_title . ' ' . $post->post_name . ' ' . $post->post_content ) : get_the_title();
							echo kocorolab_refresh_related_links_html( $hay, $lang );
							?>
						</div>
					</li>
				<?php endwhile; ?>
				<?php
				if ( ! $inserted ) {
					echo kocorolab_refresh_etm_2019_news_li( $lang );
				}
				?>
			</ul>
		<?php else : ?>
			<?php echo kocorolab_refresh_news_html( $lang ); ?>
		<?php endif; ?>
	</div>
</main>
