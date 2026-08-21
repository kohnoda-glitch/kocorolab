<?php
    get_header();
    $options = get_desing_plus_option();

    $image_id = get_post_thumbnail_id();
    if(!empty($image_id)) {
        $image = wp_get_attachment_image_src($image_id, true);
    }
    if(!empty($image)) {
        $image_path = esc_attr($image[0]);
    }
    $title_font_size = $options['title_font_size'];
    $content_font_size = $options['content_font_size'];
    if(empty($title_font_size)) {
        $title_font_size = "30";
    }
    if(empty($content_font_size)) {
        $content_font_size = "14";
    }
?>
 <div class="container single_wrap">
     <?php get_template_part('breadcrumb'); ?>    
     <header class="entry-header">
         <?php if($options['show_news_date_single']){ ?><p class="entry-meta">
                <time class="blog-date" datetime="<?php echo get_the_date("Y-m-d") ?>"><?php echo get_the_date("Y.m.d") ?></time>
         </p><?php }; ?>
         <h1 class="page-title" style="font-size:<?php echo $title_font_size ?>px"><?php the_title() ?></h1>
     </header>
     <div class="row flex_layout">
         <?php $sidebar_visible = FALSE; ?>
         <?php if((!wp_is_mobile() || is_no_resposive()) && is_active_sidebar('news_side_widget')) : ?>
             <?php $sidebar_visible = TRUE; ?>
         <?php elseif(wp_is_mobile() && is_no_resposive() == FALSE && is_active_sidebar('mobile_widget_news')): ?>
             <?php $sidebar_visible = TRUE; ?>
         <?php endif; ?>
         <div class="<?php if($sidebar_visible == TRUE) : echo 'col-md-8'; else: echo 'col-md-12'; endif; ?> entry-content">
             <?php if(has_post_thumbnail() && $options['show_thumbnail'] && $page=='1') : ?>
                 <div class="entry-content-thumbnail">
                     <?php the_post_thumbnail('size600x400'); ?>
                 </div>
             <?php endif; ?>
             <div id="edit-area" class="post_content" style="font-size:<?php echo $content_font_size ?>px">
                 <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
                     <?php the_content(__('Read more', 'tcd-w')) ?>
                 <?php endwhile; endif; ?>
             </div>
             <?php custom_wp_link_pages(); ?>
             <?php if ($options['show_next_post']) : ?>
                 <div id="previous_next_post" class="clearfix">
                     <?php next_prev_post_link(); ?>
                 </div>
             <?php endif; ?>
         </div>
         <?php if($sidebar_visible == TRUE) : ?>
             <?php get_template_part('sidebar'); ?>
         <?php endif; ?>
     </div>
 </div>
 <?php get_footer(); ?>
