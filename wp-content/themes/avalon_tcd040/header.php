<!DOCTYPE html>
<html class="pc" <?php language_attributes(); ?>>
<?php
     $options = get_desing_plus_option();
     if($options['use_ogp']) {
?>
<head prefix="og: https://ogp.me/ns# fb: https://ogp.me/ns/fb#">
<?php } else { ?>
<head>
<?php }; ?>
<?php if($options['favicon']){ ?>
<link rel="shortcut icon" href="<?php echo $options['favicon']; ?>" />
<?php }; ?>
<meta charset="<?php bloginfo('charset'); ?>">
<!--[if IE]><meta http-equiv="X-UA-Compatible" content="IE=edge"><![endif]-->
<meta name="viewport" content="width=device-width,initial-scale=1.0">
<title><?php wp_title('|', true, 'right'); ?></title>
<meta name="description" content="<?php seo_description(); ?>">
<?php if($options['use_ogp']) { ogp(); }; ?>
<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">
<?php wp_enqueue_style('style', get_stylesheet_uri(), false, version_num(), 'screen'); wp_enqueue_script( 'jquery' ); if ( is_singular() ) wp_enqueue_script( 'comment-reply' ); ?>
<?php wp_head(); ?>
</head>
<body <?php body_class(get_body_classname()) ?>>
<div id="site_loader_overlay"><div id="site_loader_spinner"></div></div>
<div id="site_wrap">
	<div id="main_content" class="clearfix row no-gutters">
		<!-- side col -->
		<?php get_template_part('shopnavi'); ?>
		<!-- main col -->
		<?php
		$main_col_align = 'right';
		if($options['layout'] === 'type2') {
			$main_col_align = 'left';
		}
		?>
		<div id="main_col" class="col-md-10 main_col_<?php echo $main_col_align ?>">
