<?php
	get_header();
	$options = get_desing_plus_option();
	$effect_type = 1;
	if($options['hover_type'] == 'type3') {
		$effect_type = 2;
	} else if($options['hover_type'] == 'type1') {
		$effect_type = 3;
	}
	$image = wp_get_attachment_image_src( $options['news_image'], 'size4');
	$headline = $options['news_headline'];
	/*$archive_count = $options['news_archive_count'];
	if(empty($archive_count)) {
		$archive_count = 5;
	}*/
	$news_title_font_size = $options['news_title_font_size'];
	if(empty($news_title_font_size)) {
		$news_title_font_size = 30;
	}
?>
<div id="header" class="header-news">
	<?php if(!empty($image)) : ?>
		<h1 class="header-title" style="<?php dp_blog_headstyle_e($options, 'news') ?>"><span><?php esc_html_e($headline) ?></span></h1>
		<img src="<?php echo esc_attr($image[0]); ?>" />
	<?php endif; ?>
</div>
<div id="edit-area">
	<div class="container">
		<?php get_template_part('breadcrumb'); ?>
		<?php
		//$paged = get_query_var('paged') ? get_query_var('paged') : 1 ;
		//query_posts("posts_per_page=".$archive_count."&paged=".$paged."&post_type=news&order=DESC&orderby=post_date");
		?>
		<?php if (have_posts()) : ?>
			<?php while(have_posts()) : the_post(); ?>
				<article class="news-item">
					<div class="row no-gutters mb0 news-header">
						<h2 class="col-sm-10 news-title" style="font-size: <?php echo $news_title_font_size ?>px;"><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h2>
						<?php if($options['show_news_date_archive']){ ?><time class="col-sm-2 news-date" datetime="<?php echo get_the_date("Y-m-d") ?>"><?php echo get_the_date("Y.m.d") ?></time><?php }; ?>
					</div>
					<div class="news-content clearfix">
						<?php if(has_post_thumbnail()){ ?><div class="news-img"><a class="hvr_ef<?php echo $effect_type ?>" href="<?php the_permalink() ?>"><div class="img-wrap"><?php dp_news_thumbnail_e() ?></div></a></div><?php }; ?>
						<div class="news-excerpt"><a href="<?php the_permalink() ?>"><?php new_excerpt(200) ?></a></div>
					</div>
				</article>
			<?php endwhile; ?>
			<div class="page_navi clearfix">
				<?php dp_pagination() ?>
			</div>
			<?php wp_reset_query(); ?>
		<?php else: ?>
			<p><?php _e('There is no registered post.','tcd-w'); ?></p>
		<?php endif; ?>
	</div>
</div><!-- / #edit-area -->
<?php get_footer(); ?>
