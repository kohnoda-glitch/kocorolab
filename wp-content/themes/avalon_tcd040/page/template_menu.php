<?php
get_header();
$options = get_desing_plus_option();
?>
<div id="edit-area" class="post_content">
<?php
if ( have_posts() ) : while ( have_posts() ) : the_post();

	$type5_headline = esc_html(get_post_meta($post->ID, 'type5_headline', true));
	$type5_description = esc_html(get_post_meta($post->ID, 'type5_description', true));
	?>
	<div class="container">
    <?php get_template_part('breadcrumb'); ?>
		<h2 class="headline mb15"><?php echo $type5_headline ?></h2>
		<p class="desc1 menu_desc"><?php echo nl2br($type5_description) ?></p>
	</div>
	<div class="container menu_contents">
		<?php echo do_shortcode('[tcd-w_menu]') ?>
	</div>
<?php endwhile; endif; ?>
</div><!-- / #edit-area -->
<?php get_footer(); ?>
