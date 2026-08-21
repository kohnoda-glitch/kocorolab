<?php
    get_header();
    $options = get_desing_plus_option();

    $image_id = get_post_meta($post->ID, 'page_image', true);
    if(!empty($image_id)) {
        $image = wp_get_attachment_image_src( $image_id, 'full' );
    }
    $headline = esc_html(get_post_meta($post->ID, 'page_headline', true));
    if(empty($headline)) {
        $headline = get_the_title();
    };
    $font_size = esc_html(get_post_meta($post->ID, 'page_headline_font_size', true));
    $font_color = esc_html(get_post_meta($post->ID, 'page_headline_color', true));
    $shadow1 = esc_html(get_post_meta($post->ID, 'page_headline_shadow1', true));
    $shadow2 = esc_html(get_post_meta($post->ID, 'page_headline_shadow2', true));
    $shadow3 = esc_html(get_post_meta($post->ID, 'page_headline_shadow3', true));
    $shadow4 = esc_html(get_post_meta($post->ID, 'page_headline_shadow4', true));
    if(empty($font_size)) { $font_size = 28; };
    if(empty($font_color)) { $font_color = '333333'; };
    if(empty($shadow1)) { $shadow1 = 0; };
    if(empty($shadow2)) { $shadow2 = 0; };
    if(empty($shadow3)) { $shadow3 = 4; };
    if(empty($shadow4)) { $shadow4 = '333333'; };
		$image_path = !empty($image) ? esc_attr($image[0]) : '';
?>

<?php
 $page_tcd_template_type = get_post_meta($post->ID,'page_tcd_template_type',true);
 if(empty($page_tcd_template_type)) {
     $page_tcd_template_type = 'type1';
 }
	switch ( $page_tcd_template_type ) {
		case 'type3' :
		case 'type4' :
		case 'type5' :
		case 'type6' :
?>
<div id="header">
    <h1 class="header-title" style="<?php page_textstyle_e($post->ID, true) ?>"><span<?php if($page_tcd_template_type == 'type1'){echo ' style="padding-left:15px;"';}; ?>><?php echo $headline ?></span></h1>
    <img src="<?php echo $image_path ?>" width="1180" height="auto" title="" alt="" />
</div>
<?php
			break;
		// 「普通のテンプレート」「サイドバーなし」の時は、ヘッダー画像が登録されている時のみこの位置にタイトルを配置
		case 'type1' :
		case 'type2' :
			if ( $image_path ) {
?>
<div id="header">
    <h1 class="header-title" style="<?php page_textstyle_e($post->ID, true) ?>"><span<?php if($page_tcd_template_type == 'type1'){echo ' style="padding-left:15px;"';}; ?>><?php echo $headline ?></span></h1>
    <img src="<?php echo $image_path ?>" width="1180" height="auto" title="" alt="" />
</div>
<?php }
			break;
 }
?>
<?php
 if($page_tcd_template_type == 'type3') { get_template_part('page/template_about'); }
 elseif($page_tcd_template_type == 'type4') { get_template_part('page/template_staff'); }
 elseif($page_tcd_template_type == 'type5') { get_template_part('page/template_menu'); }
 elseif($page_tcd_template_type == 'type6') { get_template_part('page/template_access'); }
 else {
?>
     <div class="container single_wrap <?php if ( ! $image_path ) { ?>container--no-img<?php } ?>">
       <?php get_template_part('breadcrumb'); ?>
				<?php if ( ! $image_path ) : ?>
    		<h1 class="header-title--no-img" style="<?php page_textstyle_e($post->ID, true) ?>"><span><?php echo $headline ?></span></h1>
				<?php endif; ?>
         <div class="row <?php if( $page_tcd_template_type == 'type1') { echo 'flex_layout';};?>">
             <?php $sidebar_visible = FALSE; ?>
             <?php if($page_tcd_template_type == 'type1') : ?>
                 <?php if((!wp_is_mobile() || is_no_resposive()) && is_active_sidebar('single_side_widget')) : ?>
                     <?php $sidebar_visible = TRUE; ?>
                 <?php elseif(wp_is_mobile() && is_no_resposive() == FALSE && is_active_sidebar('mobile_widget_single')): ?>
                     <?php $sidebar_visible = TRUE; ?>
                 <?php endif; ?>
             <?php endif; ?>
             <div id="edit-area"  class="post_content">
                 <div class="<?php if($sidebar_visible == TRUE) : echo 'col-md-8'; else: echo 'col-md-12'; endif; ?> entry-content">
                     <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
                         <?php the_content() ?>
                     <?php endwhile; endif; ?>
                 </div>
             </div>
             <?php custom_wp_link_pages(); ?>
             <?php if($sidebar_visible == TRUE) : ?>
                 <?php get_template_part('sidebar'); ?>
             <?php endif; ?>
         </div>
     </div>
 <?php }; ?>
<?php get_footer(); ?>
