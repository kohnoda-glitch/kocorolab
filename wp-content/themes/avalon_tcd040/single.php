<?php
    get_header();
    $options = get_desing_plus_option();
    $effect_type = 1;
    if($options['hover_type'] == 'type3') {
        $effect_type = 2;
    } else if($options['hover_type'] == 'type1') {
        $effect_type = 3;
    }

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
	<?php if(!is_mobile()): ?>
         <p class="entry-meta">
             <?php if(has_category() && $options['show_date']) : ?>
                <?php the_category(", ") ?> | <time class="blog-date" datetime="<?php echo get_the_date("Y-m-d") ?>"><?php echo get_the_date("Y.m.d") ?></time>
             <?php elseif(has_category()) : ?>
                <?php the_category(", ") ?>
             <?php elseif($options['show_date']) : ?>
                <time class="blog-date" datetime="<?php echo get_the_date("Y-m-d") ?>"><?php echo get_the_date("Y.m.d") ?></time>
             <?php endif; ?>
         </p>
	<?php endif; ?>
         <h1 class="page-title"><?php the_title() ?></h1>
	<?php if(is_mobile()): ?>
         <p class="entry-meta">
             <?php if(has_category() && $options['show_date']) : ?>
                <?php the_category(", ") ?> | <time class="blog-date" datetime="<?php echo get_the_date("Y-m-d") ?>"><?php echo get_the_date("Y.m.d") ?></time>
             <?php elseif(has_category()) : ?>
                <?php the_category(", ") ?>
             <?php elseif($options['show_date']) : ?>
                <time class="blog-date" datetime="<?php echo get_the_date("Y-m-d") ?>"><?php echo get_the_date("Y.m.d") ?></time>
             <?php endif; ?>
         </p>
	<?php endif; ?>
             <?php if($options['show_sns_top']) : ?>
             <div class="row flex_layout">
                <?php if($options['sns_type_top']=='type3'||$options['sns_type_top']=='type4'): ?>
                 <div class="single_share clearfix col-md-8" id="single_share_top">
                 <?php else: ?>
                 <div class="single_share clearfix col-md-12" style="max-width:950px; padding-left:25px; padding-right:25px;" id="single_share_top">
                 <?php endif; ?>
                     <?php get_template_part('sns_btn_top'); ?>
                 </div>
             </div>
             <?php endif; ?>
     </header>
     <div class="row flex_layout">
         <?php $sidebar_visible = FALSE; ?>
         <?php if((!wp_is_mobile() || is_no_resposive()) && is_active_sidebar('single_side_widget')) : ?>
             <?php $sidebar_visible = TRUE; ?>
         <?php elseif(wp_is_mobile() && is_no_resposive() == FALSE && is_active_sidebar('mobile_widget_single')): ?>
             <?php $sidebar_visible = TRUE; ?>
         <?php endif; ?>
         <div class="<?php if($sidebar_visible == TRUE) : echo 'col-md-8'; else: echo 'col-md-12'; endif; ?> entry-content">
             <?php if(has_post_thumbnail() && $options['show_thumbnail'] && $page=='1') : ?>
                 <div class="entry-content-thumbnail">
                     <?php the_post_thumbnail('size600x400'); ?>
                 </div>
             <?php endif; ?>
             <!-- banner1 -->
             <?php if(!is_mobile()): ?>
                 <?php if( $options['single_ad_code1'] || $options['single_ad_image1'] || $options['single_ad_code2'] || $options['single_ad_image2'] ) { ?>
                     <div id="single_banner_area" class="clearfix<?php if( !$options['single_ad_code2'] && !$options['single_ad_image2'] ) { echo ' one_banner'; }; ?>">
                         <?php if($options['single_ad_code1']||$options['single_ad_image1']): ?>
                             <?php if ($options['single_ad_code1']) { ?>
                                 <div class="single_banner single_banner_left">
                                     <?php echo $options['single_ad_code1']; ?>
                                 </div>
                                 <?php
                             } else {
                                 $single_image1 = wp_get_attachment_image_src( $options['single_ad_image1'], 'full' );
                                 ?>
                                 <div class="single_banner single_banner_left">
                                     <a href="<?php esc_attr_e( $options['single_ad_url1'] ); ?>" target="_blank"><img src="<?php echo $single_image1[0]; ?>" alt="" title="" /></a>
                                 </div>
                             <?php }; ?>
                         <?php endif; ?>
                         <?php if($options['single_ad_code2']||$options['single_ad_image2']): ?>
                             <?php if ($options['single_ad_code2']) { ?>
                                 <div class="single_banner single_banner_right">
                                     <?php echo $options['single_ad_code2']; ?>
                                 </div>
                                 <?php
                             } else {
                                 $single_image2 = wp_get_attachment_image_src( $options['single_ad_image2'], 'full' );
                                 ?>
                                 <div class="single_banner single_banner_right">
                                     <a href="<?php esc_attr_e( $options['single_ad_url2'] ); ?>" target="_blank"><img src="<?php echo $single_image2[0]; ?>" alt="" title="" /></a>
                                 </div>
                             <?php }; ?>
                         <?php endif; ?>
                     </div><!-- END #single_banner_area -->
                 <?php }; ?>
             <?php else: ?>
                     <div id="single_banner_area" class="clearfix one_banner">
                         <?php if($options['single_ad_code_m1']||$options['single_ad_image_m1']): ?>
                             <?php if ($options['single_ad_code_m1']) { ?>
                                 <div class="single_banner single_banner_left">
                                     <?php echo $options['single_ad_code_m1']; ?>
                                 </div>
                                 <?php
                             } else {
                                 $single_image_m1 = wp_get_attachment_image_src( $options['single_ad_image_m1'], 'full' );
                                 ?>
                                 <div class="single_banner single_banner_left">
                                     <a href="<?php esc_attr_e( $options['single_ad_url_m1'] ); ?>" target="_blank"><img src="<?php echo $single_image_m1[0]; ?>" alt="" title="" /></a>
                                 </div>
                             <?php }; ?>
                         <?php endif; ?>
                     </div><!-- END #single_banner_area -->
             <?php endif; ?>

             <div id="edit-area" class="post_content">
                 <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
                     <?php the_content(__('Read more', 'tcd-w')) ?>
                 <?php endwhile; endif; ?>
             </div>
             <?php if($options['show_sns_btm']) : ?>
                 <div class="single_share" id="single_share_bottom">
                     <?php get_template_part('sns_btn_btm'); ?>
                 </div>
             <?php endif;?>
             <?php custom_wp_link_pages(); ?>
             <?php if ($options['show_author'] || has_category() || has_tag() || $options['show_comment']) { ?>
                 <ul id="post_meta_bottom" class="clearfix">
                     <?php if ($options['show_author']) : ?><li class="post_author"><?php _e("Author","tcd-w"); ?>: <?php if (function_exists('coauthors_posts_links')) { coauthors_posts_links(', ',', ','','',true); } else { the_author_posts_link(); }; ?></li><?php endif; ?>
                     <?php if (has_category()){ ?><li class="post_category"><?php the_category(', '); ?></li><?php }; ?>
                     <?php if (has_tag()): ?><?php the_tags('<li class="post_tag">',', ','</li>'); ?><?php endif; ?>
                     <?php if ($options['show_comment']) : if (comments_open()){ ?><li class="post_comment"><?php _e("Comment","tcd-w"); ?>: <a href="#comment_headline"><?php comments_number( '0','1','%' ); ?></a></li><?php }; endif; ?>
                 </ul>
             <?php }; ?>
             <?php if ($options['show_next_post']) : ?>
                 <div id="previous_next_post" class="clearfix">
                     <?php next_prev_post_link(); ?>
                 </div>
             <?php endif; ?>
             <!-- banner2 -->
             <?php if(!is_mobile()): ?>
             <?php if( $options['single_ad_code5'] || $options['single_ad_image5'] || $options['single_ad_code6'] || $options['single_ad_image6'] ) { ?>
                 <div id="single_banner_area_bottom" class="clearfix<?php if( !$options['single_ad_code6'] && !$options['single_ad_image6'] ) { echo ' one_banner'; }; ?>">
                 <?php if($options['single_ad_code5']||$options['single_ad_image5']): ?>
                     <?php if ($options['single_ad_code5']) { ?>
                         <div class="single_banner single_banner_left">
                             <?php echo $options['single_ad_code5']; ?>
                         </div>
                         <?php
                     } else {
                         $single_image5 = wp_get_attachment_image_src( $options['single_ad_image5'], 'full' );
                         ?>
                         <div class="single_banner single_banner_left">
                             <a href="<?php esc_attr_e( $options['single_ad_url5'] ); ?>" target="_blank"><img src="<?php echo $single_image5[0]; ?>" alt="" title="" /></a>
                         </div>
                     <?php }; ?>
                 <?php endif; ?>
                 <?php if($options['single_ad_code6']||$options['single_ad_image6']): ?>
                     <?php if ($options['single_ad_code6']) { ?>
                         <div class="single_banner single_banner_right">
                             <?php echo $options['single_ad_code6']; ?>
                         </div>
                         <?php
                     } else {
                         $single_image6 = wp_get_attachment_image_src( $options['single_ad_image6'], 'full' );
                         ?>
                         <div class="single_banner single_banner_right">
                             <a href="<?php esc_attr_e( $options['single_ad_url6'] ); ?>" target="_blank"><img src="<?php echo $single_image6[0]; ?>" alt="" title="" /></a>
                         </div>
                     <?php }; ?>
                 <?php endif; ?>
                 </div><!-- END #single_banner_area_bottom -->
             <?php }; ?>
             <?php else: ?>
                 <div id="single_banner_area_bottom" class="clearfix one_banner">
                         <?php if($options['single_ad_code_m2']||$options['single_ad_image_m2']): ?>
                             <?php if ($options['single_ad_code_m2']) { ?>
                                 <div class="single_banner single_banner_left">
                                     <?php echo $options['single_ad_code_m2']; ?>
                                 </div>
                                 <?php
                             } else {
                                 $single_image_m2 = wp_get_attachment_image_src( $options['single_ad_image_m2'], 'full' );
                                 ?>
                                 <div class="single_banner single_banner_left">
                                     <a href="<?php esc_attr_e( $options['single_ad_url_m2'] ); ?>" target="_blank"><img src="<?php echo $single_image_m2[0]; ?>" alt="" title="" /></a>
                                 </div>
                             <?php }; ?>
                         <?php endif; ?>
                 </div><!-- END #single_banner_area_bottom -->
             <?php endif; ?>
             <!-- related post -->
             <?php if($options['show_related_post']) : $box_list = get_related_posts($post->ID); ?>
                 <?php if($box_list != null) : ?>
                     <div class="related-posts">
                         <h2 class="related-posts-title"><?php _e('Related posts', 'tcd-w') ?></h2>
                         <?php $count = 0; ?>
                         <?php foreach ($box_list as $post) : setup_postdata ($post); $count++; ?>
                             <?php if($count % 2 == 1) : echo '<div class="row">'; endif; ?>
                             <div class="col-sm-6">
                                 <div class="related_post clearfix">
                                     <div class="related_post_img">
                                         <a class="hvr_ef<?php echo $effect_type ?>" href="<?php the_permalink() ?>">
                                             <div class="img-wrap"><?php $rel_image = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'thumbnail_size'); ?>
                                             <?php if($rel_image) : ?>
                                                 <img width="100px" height="100px" src="<?php esc_attr_e($rel_image[0]) ?>" alt="<?php the_title() ?>" />
                                             <?php else: ?>
                                                 <img width="100px" height="100px" src="<?php echo get_template_directory_uri() ?>/img/common/no_image1.gif" alt="NO IMAGE" />
                                             <?php endif; ?>
                                             </div>
                                         </a>
                                     </div>
                                     <div class="related_post_meta">
                                         <h3 class="title"><a href="<?php the_permalink() ?>"><?php the_title() ?></a></h3>
                                     </div>
                                 </div>
                             </div>
                             <?php if($count % 2 == 0) : echo '</div>'; endif; ?>
                         <?php endforeach; wp_reset_query(); ?>
                         <?php if($count % 2 == 1) : echo '</div>'; endif; ?>
                     </div>
                 <?php endif; ?>
             <?php endif; ?>
             <!-- comment -->
             <?php if ($options['show_comment']) : if (function_exists('wp_list_comments')) { comments_template('', true); } else { comments_template(); }; endif; ?>
         </div>
         <?php if($sidebar_visible == TRUE) : ?>
             <?php get_template_part('sidebar'); ?>
         <?php endif; ?>
     </div>
 </div>
 <?php get_footer(); ?>
