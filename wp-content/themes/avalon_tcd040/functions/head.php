<?php
     function tcd_head() {
       $options = get_desing_plus_option();
       $logo = dp_logo_to_display();
?>

<script src="<?php echo get_template_directory_uri(); ?>/js/jquery.easing.js?ver=<?php echo version_num(); ?>"></script>
<?php if( is_no_resposive() ) { ?>
<script src="<?php echo get_template_directory_uri(); ?>/js/jscript_no_responsive.js?ver=<?php echo version_num(); ?>"></script>
<?php } else { ?>
<script src="<?php echo get_template_directory_uri(); ?>/js/jscript.js?ver=<?php echo version_num(); ?>"></script>
<link rel="stylesheet" media="screen and (max-width:770px)" href="<?php echo get_template_directory_uri(); ?>/footer-bar/footer-bar.css?ver=<?php echo version_num(); ?>">
<?php }; ?>
<script src="<?php echo get_template_directory_uri(); ?>/js/comment.js?ver=<?php echo version_num(); ?>"></script>

<?php if (strtoupper(get_locale()) == 'JA') : //to fix the font-size for japanese font ?>
<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/japanese.css?ver=<?php echo version_num(); ?>">
<?php endif; ?>

<!--[if lt IE 9]>
<script src="<?php echo get_template_directory_uri(); ?>/js/html5.js?ver=<?php echo version_num(); ?>"></script>
<![endif]-->

<?php if(is_front_page()) { ?>
<script src="<?php echo get_template_directory_uri(); ?>/js/imagesloaded.pkgd.min.js?ver=<?php echo version_num(); ?>"></script>
<script src="<?php echo get_template_directory_uri(); ?>/js/masonry.pkgd.min.js?ver=<?php echo version_num(); ?>"></script>
<script>
jQuery(document).ready(function($){

  var $container = $('#index_product_list');

  $(window).load(function () {
    $container.imagesLoaded( function() {
      $container.masonry({
        itemSelector: '.box',
        columnWidth: '.box-sizer',
        percentPosition: true,
        transitionDuration: 0
      });
    });
  });

});
</script>
<?php }; ?>

<?php if(is_post_type_archive('product') || is_tax('product_category')) { ?>
<?php if( !is_mobile() || is_no_resposive() ) { ?>
<script src="<?php echo get_template_directory_uri(); ?>/js/jquery.inview.min.js?ver=<?php echo version_num(); ?>"></script>
<script>
jQuery(document).ready(function($){

 $('.box').css('opacity', 0);
 $('.animate_box1').bind('inview', function(event, visible) {
	if (visible) {
    $(this).delay(700).queue(function(){
		  $(this).stop().animate({ opacity: 1 }, 1000);
    });
	}
 });
 $('.animate_box2').bind('inview', function(event, visible) {
	if (visible) {
    $(this).delay(1200).queue(function(){
		  $(this).stop().animate({ opacity: 1 }, 500);
    });
	}
 });

});
</script>
<?php }; ?>
<?php }; ?>
<?php 
// 画像が設定されていないコンテンツがある時は、スクロールの挙動を止めるフラグを設定する
$blog_index = 99999999;
$freespace_index = 99999999;
?>
<?php if ($options['front_scroll_no_animation'] === 0){?>
<?php if (count($options['index_section_items']) > 0 || !empty($options['show_index_blog']) || !empty($options['show_index_freespace'])) {?>
<script>
 $(document).ready(function() {
     if($(window).width() >= 1025) {
         $('#fullpage').fullpage({
                licenseKey: '47E50799-01BE4E5E-83C97E0B-189E3E95',
            <?php
                echo "anchors: [";
                $i = 0;
                if(count($options['index_section_items']) > 0 ):
                foreach($options['index_section_items'] as $section_item) {
                    echo "'Page".$i."', ";
                    $i++;
                }
                endif;
                if($options['show_index_blog']):
                    $blog_index = $i;
                    echo "'Page".$i."', ";
                    $i++;
                endif;
                if($options['show_index_freespace']):
                    $freespace_index = $i;
                    echo "'Page".$i."', ";
                endif;
                echo '],';
            ?>

             lockAnchors: false,
            <?php
                echo 'sectionsColor: [';
                if(count($options['index_section_items']) > 0 ):
                    for($j=0;$j<count($options['index_section_items']);$j++){
                        echo "'#FFF', ";
                    }
                endif;
                if($options['show_index_blog']):
                     echo "'#".$options['front_blog_bgcolor']."', ";
                endif;
                if($options['show_index_freespace']):
                    echo "'#".$options['front_freespace_bgcolor']."'";
                endif;
                echo '],';
            ?>

             scrollBar: true,
             scrollingSpeed: 1200,
             normalScrollElements: '<?php if($blog_index != 99999999){ ?>#section<?php echo $blog_index; ?>,<?php } ?><?php if($freespace_index != 99999999){ ?>#section<?php echo $freespace_index; ?><?php } ?>',
             fitToSection: false,
             easing: 'easeInOutQuart'
         });
     } else {
         $('#fullpage').fullpage({
                licenseKey: '47E50799-01BE4E5E-83C97E0B-189E3E95',
            <?php
                echo "anchors: [";
                $i = 0;
                if(count($options['index_section_items']) > 0 ):
                foreach($options['index_section_items'] as $section_item) {
                    echo "'Page".$i."', ";
                    $i++;
                }
                endif;
                if($options['show_index_blog']):
                    $blog_index = $i;
                    echo "'Page".$i."', ";
                    $i++;
                endif;
                if($options['show_index_freespace']):
                    $freespace_index = $i;
                    echo "'Page".$i."', ";
                endif;
                echo '],';
            ?>

             lockAnchors: false,
            <?php
                echo 'sectionsColor: [';
                for($j=0;$j<count($options['index_section_items']);$j++){
                    echo "'#FFF', ";
                }
                if($options['show_index_blog']):
                     echo "'#".$options['front_blog_bgcolor']."', ";
                endif;
                if($options['show_index_freespace']):
                    echo "'#".$options['front_freespace_bgcolor']."'";
                endif;
                echo '],';
            ?>
            
             scrollBar: true,
             scrollingSpeed: 1000,
             autoScrolling: false,
             fitToSection: false
         });
     }
 });
</script>
<?php } ?>
<?php } ?>
<style type="text/css">
<?php if ($options['front_scroll_no_animation'] === 1){?>
<?php // または画像の登録がない時の背景色を設定
    if (!empty($options['show_index_blog']) || !empty($options['show_index_freespace'])) { ?>
    body.home .top-freespace_wrap{ background: #<?php echo $options['front_freespace_bgcolor'] ?>;margin-top: 0;}
    @media screen and (min-width: 1024px){
        body.home #main_col .top-blog-list_wrap{ background: #<?php echo $options['front_blog_bgcolor'] ?>}
    }
    @media screen and (max-width: 1024px) {
        body.home .top-blog-list_wrap{ background: #<?php echo $options['front_blog_bgcolor'] ?>}
    }
 <?php }; ?>
 <?php }; ?>
<?php if($logo) { ?>
#logo { top:<?php echo $options['logotop']; ?>px; left:<?php echo $options['logoleft']; ?>px; }
<?php }; ?>

.pc #logo_text .logo{font-size:<?php echo esc_html($options['logo_font_size']); ?>px; }
.pc #logo_text .desc { font-size:<?php echo esc_html($options['site_desc_font_size']); ?>px; }

.mobile #logo_text .logo{font-size:<?php echo esc_html($options['logo_font_size_mobile']); ?>px; }

#footer_logo .logo { font-size:<?php echo esc_html($options['logo_font_size_footer']); ?>px; }
#footer_logo .desc { font-size:<?php echo esc_html($options['site_desc_font_size_footer']); ?>px; }

.pc #global_menu li a:hover, .pc #global_menu > ul > li.active > a, .post_list li.type1 .meta li a:hover, .post_list li.type2 .meta li a:hover, #footer_menu li a:hover, #home_slider .info_inner .title_link:hover, #post_meta_top a:hover, #bread_crumb li a:hover, #comment_header ul li a:hover, #template1_header .product_cateogry a:hover, #archive_product_list .no_image:hover .title a
 { color:#<?php echo $options['pickedcolor1']; ?>; }

<?php if(!is_mobile()){ ?>
#side_col, #main_content{ background-color: #<?php echo $options['pickedcolor4']; ?>;}
<?php }; ?>

#global_menu .sub-menu{background: none;}
<?php
     $base_color = hex2rgb($options['gnav_submenu_bgcolor']);
     $hex_color = implode(",",$base_color);
?>
#global_menu .sub-menu li{background: rgba(<?php echo $hex_color; ?>, <?php echo $options['gnav_submenu_opacity']; ?>);}
#global_menu .sub-menu li a{color:#<?php echo $options['gnav_submenu_color']; ?> !important;}
#global_menu .sub-menu li a:hover{color:#<?php echo $options['gnav_submenu_color_hover']; ?> !important; background: #<?php echo $options['gnav_submenu_bgcolor_hover']; ?> !important;}

.post_content a, .custom-html-widget a { color:#<?php echo $options['pickedcolor3']; ?>; }
#edit-area .headline, .footer_headline, .widget-title, a:hover, .menu_category, .custom-html-widget a:hover { color:#<?php echo $options['pickedcolor1']; ?>; }
#return_top a:hover, .next_page_link a:hover, .page_navi a:hover, #index_news_list .archive_link:hover, .pc #index_news_list .news_title a:hover, .box_list_headline .archive_link a:hover, .previous_next_post .previous_post a:hover, .previous_next_post .next_post a:hover,
 #single_product_list .slick-prev:hover, #single_product_list .slick-next:hover, #previous_next_page a:hover, .mobile .template1_content_list .caption a.link:hover, #archive_product_cateogry_menu li a:hover, .pc #archive_product_cateogry_menu li.active > a, .pc #archive_product_cateogry_menu li ul,
  #wp-calendar td a:hover, #wp-calendar #prev a:hover, #wp-calendar #next a:hover, .widget_search #search-btn input:hover, .widget_search #searchsubmit:hover, .side_widget.google_search #searchsubmit:hover,
   #submit_comment:hover, #post_pagination a:hover, #post_pagination p, .mobile a.category_menu_button:hover, .mobile a.category_menu_button.active, .user_sns li a:hover
    { background-color:#<?php echo $options['pickedcolor1']; ?>; }



/*#edit-area .top-blog-list .headline{ color:#<?php echo $options['pickedcolor1']; ?>; }*/
<?php
    // フォントタイプの旧値（type1 など）を新値（1や2）にマッピング
    $convert_font_type = function($value) {
        $map = [
          'type1' => 1,
          'type2' => 2,
          '1'     => 1,
          '2'     => 2,
          '3'     => 3,
          1       => 1,
          2       => 2,
          3       => 3,
        ];
        return $map[$value] ?? 1;
      };
      $headline_font_type = $convert_font_type($options['headline_font_type'] ?? 1);
?>
.page-title, .headline, #edit-area .headline, .header-title, .blog-title, .related-posts-title, .widget-title{
    <?php if($headline_font_type == 1){
            echo 'font-family: var(--tcd-font-type1);';
        }elseif( $headline_font_type == 2){
            echo 'font-family:  var(--tcd-font-type2);';
        }else{ 
            echo 'font-family:  var(--tcd-font-type3);';
        }
        ?>

}
.rich_font_logo { font-family: var(--tcd-font-type-logo); font-weight: <?php echo esc_html( $options['font_list']['logo']['weight'] ?? 'bold' ); ?> !important;}
.blog-title{ font-size: <?php echo $options['archive_title_font_size']; ?>px; }
.page-title{ font-size: <?php echo $options['title_font_size']; ?>px; }
.post_content{ font-size: <?php echo $options['content_font_size']; ?>px; }

.store-information01 { background-color:#<?php echo $options['pickedcolor1']; ?>; }
.page_navi li .current { background-color:#<?php echo $options['pickedcolor1']; ?>; }

#comment_textarea textarea:focus, #guest_info input:focus
 { border-color:#<?php echo $options['pickedcolor1']; ?>; }

.pc #archive_product_cateogry_menu li ul a:hover
 { background-color:#<?php echo $options['pickedcolor1']; ?>; color:#<?php echo $options['pickedcolor2']; ?>; }

#previous_next_post .prev_post:hover, #previous_next_post .next_post:hover { background-color:#<?php echo $options['pickedcolor1']; ?>;}
.related-posts-title { color:#<?php echo $options['pickedcolor1']; ?>;}

/*.btn_gst:hover { color:#<?php echo $options['pickedcolor1']; ?>!important;}*/

.footer_menu li.no_link a { color:#<?php echo $options['pickedcolor1']; ?>; }
#global_menu ul li.no_link > a { color:#<?php echo $options['pickedcolor1']; ?>; }

.blog-title a:hover, .blog-meta a:hover, .entry-meta a:hover, #post_meta_bottom a:hover { color: #<?php echo $options['pickedcolor1']; ?>; }

#global_menu a, .store-information, .store-information02, .store-information a, .store-information02 a,
.store-information .store-tel, .store-information02 .store-tel, .store-information .store-tel a, .store-information02 .store-tel a
  {color:#<?php echo $options['pickedcolor2']; ?> !important;}

@media screen and (max-width: 1024px) {
 #global_menu a { color: #<?php echo $options['gnav_submenu_color']; ?> !important; background: #<?php echo $options['gnav_submenu_bgcolor']; ?> !important; border-color:  #<?php echo $options['gnav_submenu_bgcolor']; ?>; }
 .mobile #global_menu a:hover { color: #<?php echo $options['gnav_submenu_color_hover']; ?> !important; background-color:#<?php echo $options['gnav_submenu_bgcolor_hover']; ?> !important; }
 #global_menu li:before { color: #<?php echo $options['gnav_submenu_color']; ?> !important; }
 #global_menu .child_menu_button .icon:before { color: #<?php echo $options['gnav_submenu_color']; ?> !important; }
<?php
     $base_color = hex2rgb($options['gnav_submenu_bgcolor']);
     $hex_color = implode(",",$base_color);
?>
 #global_menu .sub-menu li a{background: rgba(<?php echo $hex_color; ?>, <?php echo $options['gnav_submenu_opacity']; ?>) !important;}
}

@media screen and (min-width:1025px) {
 .store-information01 .store-tel, .store-information01 .store-tel a { color:#ffffff !important; }
}

#page_header .title { font-size:<?php echo $options['title_font_size']; ?>px; }
#article .post_content { font-size:<?php echo $options['content_font_size']; ?>px; }


.store-information .store-name, .store-information02 .store-name{ font-size:<?php echo $options['shop_name_fontsize_side']; ?>px; }
.store-address{ font-size:<?php echo $options['shop_addr_fontsize_side']; ?>px; }
.store-information .store-tel, .store-information02 .store-tel{ font-size:<?php echo $options['shop_tel_fontsize_side']; ?>px; }
.store-information .store-tel span, .store-information02 .store-tel span{ font-size:<?php echo $options['shop_addr_fontsize_side']; ?>px; }

.store-information01{ font-size:<?php echo $options['shop_addr_fontsize_foot']; ?>px; }
.store-information01 .store-name{ font-size:<?php echo $options['shop_name_fontsize_foot']; ?>px; }
.store-information01 .store-tel{ font-size:<?php echo $options['shop_tel_fontsize_foot']; ?>px; }

<?php if(empty($options['mobile_logo'])) : ?>
    @media screen and (max-width: 1024px) {
        #main_col {top: auto !important;}
    }
<?php endif; ?>

<?php if($options['layout'] == 'type2') : ?>
    @media screen and (min-width: 1025px) {
        #global_menu .sub-menu { left: -100%; }
    }
<?php endif; ?>

<?php
     $base_color = hex2rgb($options['pickedcolor1']);
     $hex_color = implode(",",$base_color);
?>
#site_loader_spinner { border:4px solid rgba(<?php echo $hex_color; ?>,0.2); border-top-color:#<?php echo $options['pickedcolor1']; ?>; }

<?php if($options['hover_type'] == 'type1'){ ?>
.hvr_ef3 .img-wrap:hover img{
    -webkit-transform: scale(<?php echo $options['hover1_zoom']; ?>);
    transform: scale(<?php echo $options['hover1_zoom']; ?>);
}
<?php }; ?>

<?php if($options['hover_type'] == 'type2'){ ?>
.hvr_ef1 .img-wrap img{
-webkit-backface-visibility: hidden;
backface-visibility: hidden;
margin-left: 8px;
<?php if($options['hover2_direct']=='type1'): ?>
-webkit-transform: scale(1.18) translate3d(-8px, 0, 0);
-webkit-transition-property: opacity, translate3d;
-webkit-transition: 0.5s;
-moz-transform: scale(1.18) translate3d(-8px, 0, 0);
-moz-transition-property: opacity, translate3d;
-moz-transition: 0.5s;
-ms-transform: scale(1.18) translate3d(-8px, 0, 0);
-ms-transition-property: opacity, translate3d;
-ms-transition: 0.5s;
-o-transform: scale(1.18) translate3d(-8px, 0, 0);
-o-transition-property: opacity, translate3d;
-o-transition: 0.5s;
transform: scale(1.18) translate3d(-8px, 0, 0);
transition-property: opacity, translate3d;
transition: 0.5s;
<?php else: ?>
-webkit-transform: scale(1.18) translate3d(0, 0, 0);
-webkit-transition-property: opacity, translate3d;
-webkit-transition: 0.5s;
-moz-transform: scale(1.18) translate3d(0, 0, 0);
-moz-transition-property: opacity, translate3d;
-moz-transition: 0.5s;
-ms-transform: scale(1.18) translate3d(0, 0, 0);
-ms-transition-property: opacity, translate3d;
-ms-transition: 0.5s;
-o-transform: scale(1.18) translate3d(0, 0, 0);
-o-transition-property: opacity, translate3d;
-o-transition: 0.5s;
transform: scale(1.18) translate3d(0, 0, 0);
transition-property: opacity, translate3d;
transition: 0.5s;
<?php endif; ?>
}
.hvr_ef1 .img-wrap:hover img{
opacity: <?php echo $options['hover2_opacity']; ?>;
<?php if($options['hover2_direct']=='type1'): ?>
-webkit-transform: scale(1.18) translate3d(0, 0, 0);
-moz-transform: scale(1.18) translate3d(0, 0, 0);
-ms-transform: scale(1.18) translate3d(0, 0, 0);
-o-transform: scale(1.18) translate3d(0, 0, 0);
transform: scale(1.18) translate3d(0, 0, 0);
<?php else: ?>
-webkit-transform: scale(1.18) translate3d(-8px, 0, 0);
-moz-transform: scale(1.18) translate3d(-8px, 0, 0);
-ms-transform: scale(1.18) translate3d(-8px, 0, 0);
-o-transform: scale(1.18) translate3d(-8px, 0, 0);
transform: scale(1.18) translate3d(-8px, 0, 0);
<?php endif; ?>
}
<?php }; ?>

<?php if($options['hover_type'] == 'type3'){ ?>
.hvr_ef2 .img-wrap{ background-color: #<?php echo $options['hover3_bgcolor']; ?>}
.hvr_ef2 .img-wrap:hover img{
    opacity: <?php echo $options['hover3_opacity']; ?>
}
<?php }; ?>

<?php if($options['footer_menu_off_link']){ ?>
#footer_menu li:first-child a{pointer-events: none;}
<?php }; ?>

<?php if($options['css_code']) { echo $options['css_code']; };?>


<?php if(is_front_page()){
    if ($options['index_section_items']) {
        $i = 0;
        foreach($options['index_section_items'] as $section_item) {
            if ($section_item['use_overlay']) {
                $bg_color = hex2rgb($section_item['overlay']);
                $bg_hex_color = implode(",",$bg_color);
                if ($options['front_scroll_no_animation'] === 1){
                    echo '#section'.$i.' .container-wrap{ background-color:rgba('.$bg_hex_color.', '.$section_item['overlay_opacity'].'); }';
                }else{
                    echo '#section'.$i.' .fp-tableCell{ background-color:rgba('.$bg_hex_color.', '.$section_item['overlay_opacity'].'); }';
                }
            };
            //if(!is_mobile()){
              if($section_item['use_btn']){
                  if($section_item['use_ghost_btn']){
                      echo '#section'.$i.' .btn_gst::before{border-color:#'.$section_item['btn_bordercolor'].';}';
                      echo '#section'.$i.' .btn_gst::after{border-color:#'.$section_item['btn_bordercolor'].';}';
                      $btn_bg_color = hex2rgb($section_item['btn_hover_bgcolor']);
                      $btn_bg_hex_color = implode(",",$btn_bg_color);
                      echo '#section'.$i.' .btn_gst:hover{color:#'.$section_item['btn_hover_color'].' !important; background-color:rgba('.$btn_bg_hex_color.','.$section_item['btn_bg_opacity'].');}';
                  }else{
                      $btn_bg_color = hex2rgb($section_item['btn_bgcolor']);
                      $btn_bg_hex_color = implode(",",$btn_bg_color);
                      echo '#section'.$i.' .btn_def{background-color:rgba('.$btn_bg_hex_color.',0.5); border:solid 1px #'.$section_item['btn_bordercolor'].';}';
                      $btn_bg_color = hex2rgb($section_item['btn_hover_bgcolor']);
                      $btn_bg_hex_color = implode(",",$btn_bg_color);
                      echo '#section'.$i.' .btn_def:hover{color:#'.$section_item['btn_hover_color'].' !important; background-color:rgba('.$btn_bg_hex_color.','.$section_item['btn_bg_opacity'].');}';
                  }
              };
            /*}else{
              $btn_bg_color = hex2rgb($section_item['btn_bgcolor']);
              $btn_bg_hex_color = implode(",",$btn_bg_color);
              echo '#section'.$i.' .btn_def{background-color:rgba('.$btn_bg_hex_color.',0.5); border:solid 1px #'.$section_item['btn_bordercolor'].';}';
              $btn_bg_color = hex2rgb($section_item['btn_hover_bgcolor']);
              $btn_bg_hex_color = implode(",",$btn_bg_color);
              echo '#section'.$i.' .btn_def:hover{color:#'.$section_item['btn_hover_color'].' !important; background-color:rgba('.$btn_bg_hex_color.','.$section_item['btn_bg_opacity'].');}';
            }*/
            $i++;
        };
    };
  }; ?>

<?php if(is_front_page()&&!is_mobile()){ 
    if(!$options['fixed_news']){
?>
.main_col_right #index_news{position:absolute; width:100%;}
<?php }; }; ?>

<?php if (is_front_page() && !$options['show_news_date']) : ?>
  #index_news ul .date { display: none; }
  <?php if (!wp_is_mobile()) : ?>
    #index_news ul .title { margin-left: 50px; }
  <?php endif; ?>
<?php endif; ?>

<?php if(is_404()){ ?>
.header-title{ color:#<?php echo $options['header_txt_color_404']; ?>; font-size:<?php echo $options['header_txt_size_404']; ?>px; text-shadow: <?php echo $options['dropshadow_404_h']; ?>px <?php echo $options['dropshadow_404_v']; ?>px <?php echo $options['dropshadow_404_b']; ?>px #<?php echo $options['dropshadow_404_c']; ?>;}
<?php }; ?>


<?php if(is_mobile()):
  if($options['footer_bar_display'] == 'type1' || $options['footer_bar_display'] == 'type2'):
?>
.dp-footer-bar{
  background: <?php echo 'rgba('.implode(',', hex2rgb($options['footer_bar_bg'])).', '.esc_html($options['footer_bar_tp']).');'; ?>
  border-top: solid 1px #<?php echo esc_html($options['footer_bar_border']); ?>;
  color: #<?php echo esc_html($options['footer_bar_color']); ?>;
  display: flex;
  flex-wrap: wrap;
}
.dp-footer-bar a{
  color: #<?php echo esc_html($options['footer_bar_color']); ?>;
}
.dp-footer-bar-item + .dp-footer-bar-item{
  border-left: solid 1px #<?php echo esc_html($options['footer_bar_border']); ?>;
}
<?php endif; endif; ?>
</style>

<?php
     };
     add_action("wp_head", "tcd_head");
// Custom head/script
function tcd_custom_head() {
$options = get_design_plus_option();

if ( $options['custom_head'] ) {
echo $options['custom_head'] . "\n";
}
}
add_action( 'wp_head', 'tcd_custom_head', 9999 );
?>
