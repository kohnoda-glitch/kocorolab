<?php
get_header();
$options = get_desing_plus_option();
?>
<div id="edit-area" class="post_content">
<?php
if ( have_posts() ) : while ( have_posts() ) : the_post();
	$type4_row1_headline = esc_html(get_post_meta($post->ID, 'type4_row1_headline', true));
	$type4_row2_content = esc_html(get_post_meta($post->ID, 'type4_row2_content', true));
	$type4_row2_image_id = get_post_meta($post->ID, 'type4_row2_image', true);
	if(!empty($type4_row2_image_id)) { $type4_row2_image = wp_get_attachment_image_src($type4_row2_image_id, 'full'); };
	$type4_row3_image_id = esc_html(get_post_meta($post->ID, 'type4_row3_image', true));
	if(!empty($type4_row3_image_id)) { $type4_row3_image = wp_get_attachment_image_src($type4_row3_image_id, 'full'); };
	$type4_row3_content = esc_html(get_post_meta($post->ID, 'type4_row3_content', true));
	$type4_row4_image_id = esc_html(get_post_meta($post->ID, 'type4_row4_image', true));
	if(!empty($type4_row4_image_id)) { $type4_row4_image = wp_get_attachment_image_src($type4_row4_image_id, 'full'); };
	$type4_row4_headline = esc_html(get_post_meta($post->ID, 'type4_row4_headline', true));
	$type4_row4_content = esc_html(get_post_meta($post->ID, 'type4_row4_content', true));
	?>
	<div class="container">
		<?php get_template_part('breadcrumb'); ?>
		<h2 class="headline"><?php echo $type4_row1_headline ?></h2>
		<?php if($type4_row2_content || $type4_row2_image){ ?>
		<div class="row">
			<div class="col-md-6">
				<p><?php echo nl2br($type4_row2_content) ?></p>
			</div>
			<div class="align1 col-md-6">
				<?php if($type4_row2_image) { ?><img src="<?php echo $type4_row2_image[0]; ?>" alt="" title="" /><?php }; ?>
			</div>
		</div>
		<?php } ?>
		<?php if($type4_row3_image || $type4_row3_content){ ?>
		<div class="row">
			<div class="align1 col-md-6">
				<?php if($type4_row3_image) { ?><img src="<?php echo $type4_row3_image[0]; ?>" alt="" title="" /><?php }; ?>
			</div>
			<div class="col-md-6">
				<p><?php echo nl2br($type4_row3_content) ?></p>
			</div>
		</div>
		<?php } ?>
	</div>
	<?php if(isset($type4_row4_image) || $type4_row4_headline || $type4_row4_content){ ?>
	<div class="signage"<?php if(isset($type4_row4_image)) : echo ' style="background: url('.$type4_row4_image[0].') no-repeat left top/cover;"'; endif; ?>>
		<div class="signage-content">
			<h2 class="signage-title" style="<?php page_textstyle_e($post->ID) ?>"><?php echo $type4_row4_headline ?></h2>
			<p class="signage-text" style="<?php page_textstyle_e($post->ID) ?>"><?php echo nl2br($type4_row4_content) ?></p>
		</div>
	</div>
	<?php } ?>

	<div class="container staff-post">
		<?php echo wpautop(do_shortcode(get_post_meta($post->ID, 'type4_body', true))) ?>
	</div>
<?php endwhile; endif; ?>
</div><!-- / #edit-area -->
<?php get_footer(); ?>
