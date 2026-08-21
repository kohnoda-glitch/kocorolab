<?php
	get_header();
	$options = get_desing_plus_option();
	$image = wp_get_attachment_image_src( $options['header_image_404'], 'size4');
	if($options['header_txt_404']){
		$headline = $options['header_txt_404'];
	}else{
		$headline = __("Sorry, but you are looking for something that isn't here.","tcd-w");
	}
?>
<?php if(!empty($image)) : ?>
<div id="header" class="header-blog mb50">
	<h2 class="header-title"><span><?php esc_html_e($headline); ?></span></h2>
	<img src="<?php echo esc_attr($image[0]); ?>" />
</div>
<?php else: ?>
<div class="header_notfound">
	<h2 class="header-title"><span><?php esc_html_e($headline); ?></span></h2>
</div>
<?php endif; ?>
<div id="edit-area">
	<div class="container single_wrap">
		<?php get_template_part('breadcrumb'); ?>
		<div class="row">
			<?php $sidebar_visible = FALSE; ?>
			<?php if((!wp_is_mobile() || is_no_resposive()) && is_active_sidebar('single_side_widget')) : ?>
				<?php $sidebar_visible = TRUE; ?>
			<?php elseif(wp_is_mobile() && is_no_resposive() == FALSE && is_active_sidebar('mobile_widget_single')): ?>
				<?php $sidebar_visible = TRUE; ?>
			<?php endif; ?>
			<div class="<?php if($sidebar_visible == TRUE) : echo 'col-md-8'; else: echo 'col-md-12'; endif; ?> entry-content">
				<div id="edit-area" class="blog_content">
					<p><?php _e("Sorry, but you are looking for something that isn't here.","tcd-w"); ?></p>
				</div>
			</div>
			<?php if($sidebar_visible == TRUE) : ?>
				<?php get_template_part('sidebar'); ?>
			<?php endif; ?>
		</div>
	</div>
</div>
<?php get_footer(); ?>
