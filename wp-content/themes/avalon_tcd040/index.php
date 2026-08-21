<?php
	get_header();
	$options = get_desing_plus_option();
	$image = wp_get_attachment_image_src( $options['blog_image'], 'size4');
	$headline = $options['blog_headline'];
	$content = $options['blog_content'];
	$effect_type = 1;
	if($options['hover_type'] == 'type3') {
		$effect_type = 2;
	} else if($options['hover_type'] == 'type1') {
		$effect_type = 3;
	}
?>
<div id="header" class="header-blog mb50">
	<?php if(!empty($image)) : ?>
		<div class="header-title" style="<?php dp_blog_headstyle_e($options) ?>">
			<h1>
			<?php if(is_category()): ?>
				<?php echo single_cat_title('', false); ?>
			<?php elseif(is_tag()): ?>
				<?php echo single_tag_title('', false); ?>
			<?php elseif(is_search()): ?>
				<?php printf(__('Search results for - %s', 'tcd-w'), get_search_query()); ?>
			<?php elseif(is_day()): ?>
				<?php printf(__('Archive for &#8216; %s &#8217;', 'tcd-w'), get_the_time(__('F jS, Y', 'tcd-w'))); ?>
			<?php elseif(is_month()): ?>
				<?php printf(__('Archive for &#8216; %s &#8217;', 'tcd-w'), get_the_time(__('F, Y', 'tcd-w'))); ?>
			<?php elseif(is_year()): ?>
				<?php printf(__('Archive for &#8216; %s &#8217;', 'tcd-w'), get_the_time(__('Y', 'tcd-w'))); ?>
			<?php elseif(is_author()): ?>
				<?php global $wp_query; $curauth = $wp_query->get_queried_object(); //get the author info ?>
				<?php printf(__('Archive for the &#8216; %s &#8217;', 'tcd-w'), $curauth->display_name ); ?>
			<?php else: ?>
				<?php esc_html_e($headline) ?>
			<?php endif; ?>
			</h1>
			<?php if (is_category()) { ?>
				<?php if(category_description()) { ?>
					<div id="category_desc">
						<?php echo category_description(); ?>
					</div>
				<?php }; ?>
			<?php } elseif( is_tag() ) { ?>
				<?php if(tag_description()) { ?>
					<div id="category_desc">
						<?php echo tag_description(); ?>
					</div>
				<?php }; ?>
			<?php }; ?>
		</div>
		<img src="<?php echo esc_attr($image[0]); ?>" />
	<?php endif; ?>
</div>
<div id="edit-area">
	<div class="container">
		<?php get_template_part('breadcrumb'); ?>
		<?php if(is_home()) { ?>
			<p class="desc1 mb50"><?php echo nl2br(esc_html($content)) ?></p>
		<?php }; ?>
		<?php if ( have_posts() ) : ?>
			<?php $count = 0; ?>
			<?php while ( have_posts() ) : the_post(); $count++; ?>
				<?php if($count % 2 == 1): echo '<div class="row">'; endif; ?>
				<div class="col-sm-6 archive_post">
					<article class="blog-item">
						<a class="hvr_ef<?php echo $effect_type ?>" href="<?php the_permalink() ?>">
							<div class="img-wrap">
								<?php dp_post_thumbnail_e() ?>
							</div>
						</a>
							<div class="blog-content">
								<h2 class="blog-title"><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h2>
								<p class="blog-meta">
									<?php if($options['archive_show_category'] && $options['archive_show_date']) : ?>
										<span class="blog-category"><?php the_category(", ") ?></span> | <time class="blog-date" datetime="<?php echo get_the_date("Y-m-d") ?>"><?php echo get_the_date("Y.m.d") ?></time>
									<?php elseif($options['archive_show_category']) : ?>
										<span class="blog-category"><?php the_category(", ") ?></span>
									<?php elseif($options['archive_show_date']) : ?>
										<time class="blog-date" datetime="<?php echo get_the_date("Y-m-d") ?>"><?php echo get_the_date("Y.m.d") ?></time>
									<?php endif; ?>
								</p>
							</div>
					</article>
				</div>
				<?php if($count % 2 == 0): echo '</div>'; endif; ?>
			<?php endwhile; ?>
			<?php if($count % 2 == 1): echo '</div>'; endif; ?>
		<?php else: ?>
			<p><?php _e('There is no registered post.','tcd-w'); ?></p>
		<?php endif; ?>
		<div class="page_navi clearfix">
			<?php dp_pagination() ?>
		</div>
	</div>
</div><!-- / #edit-area -->
<?php get_footer(); ?>
