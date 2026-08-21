<?php
    $options = get_desing_plus_option();
    $title = wp_get_document_title(); 
    $url = ( empty( $_SERVER['HTTPS'] ) ? 'http://' : 'https://' ) . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    $noline = false;
    if(is_page()){
      $page_tcd_template_type = get_post_meta($post->ID,'page_tcd_template_type',true);
      if($page_tcd_template_type == 'type6'){ $noline = true; }else{ $noline = false; };
    }
?>

<div id="footer">
<?php if(is_mobile()){ ?>
        <div class="container">
            <div class="row">
                <div id="footer_menu" class="clearfix">
	<?php if(is_active_sidebar('mobile_footer_widget')){
		dynamic_sidebar('mobile_footer_widget');
	}; ?>
                </div><!-- / #footer_menu -->
            </div>
        </div><!-- / .container -->
<?php }else{ ?>
    <?php if(is_front_page() == FALSE) : ?>
      <?php if($noline): ?>
        <div class="container noline">
      <?php else: ?>
        <div class="container">
      <?php endif; ?>
            <div id="footer_logo" class="align1 mb60 sp-none">
                <?php footer_logo(); ?>
            </div>
            <div class="row">
                <div id="footer_menu" class="clearfix">
                <?php
                  if (is_active_sidebar('footer_widget')) {
                    dynamic_sidebar('footer_widget');
                  }
                ?>
                </div><!-- / #footer_menu -->
            </div>
        </div><!-- / .container -->
    <?php endif; ?>
<?php };?>
    <div class="store-information02 mt50 mb20 pc-none">
      <?php if(is_blankstr($options['shop_name']) == FALSE): ?><p class="store-name"><?php esc_html_e($options['shop_name']) ?></p><?php endif; ?>
      <?php if(is_blankstr($options['shop_addr']) == FALSE): ?><p class="store-address"><?php echo nl2br(esc_html($options['shop_addr'])) ?></p><?php endif; ?>
      <?php if(is_blankstr($options['shop_tel']) == FALSE): ?>
        <?php if(is_mobile()): ?>
          <p class="store-tel"><span>TEL.</span><a href="tel:<?php echo esc_attr($options['shop_tel']); ?>"><?php esc_html_e($options['shop_tel']) ?></a></p>
        <?php else: ?>
          <p class="store-tel"><span>TEL.</span><?php esc_html_e($options['shop_tel']) ?></p>
        <?php endif; ?>
      <?php endif; ?>
    </div>
    <ul class="user_sns pc-none clearfix">
        <?php if(is_blankstr($options['snsurl_tiktok']) == FALSE): ?><li class="tiktok"><a href="<?php esc_attr_e($options['snsurl_tiktok']) ?>" target="_blank"><span>TikTok</span></a></li><?php endif; ?>
        <?php if(is_blankstr($options['snsurl_twitter']) == FALSE): ?><li class="twitter"><a href="<?php esc_attr_e($options['snsurl_twitter']) ?>" target="_blank"><span>Twitter</span></a></li><?php endif; ?>
        <?php if(is_blankstr($options['snsurl_facebook']) == FALSE): ?><li class="facebook"><a href="<?php esc_attr_e($options['snsurl_facebook']) ?>" target="_blank"><span>Facebook</span></a></li><?php endif; ?>
        <?php if(is_blankstr($options['snsurl_instagram']) == FALSE): ?><li class="insta"><a href="<?php esc_attr_e($options['snsurl_instagram']) ?>" target="_blank"><span>Instagram</span></a></li><?php endif; ?>
        <?php if(is_blankstr($options['snsurl_pinterest']) == FALSE): ?><li class="pint"><a href="<?php esc_attr_e($options['snsurl_pinterest']) ?>" target="_blank"><span>Pinterest</span></a></li><?php endif; ?>
        <?php if(is_blankstr($options['snsurl_flickr']) == FALSE): ?><li class="flickr"><a href="<?php esc_attr_e($options['snsurl_flickr']) ?>" target="_blank"><span>Flickr</span></a></li><?php endif; ?>
        <?php if(is_blankstr($options['snsurl_tumblr']) == FALSE): ?><li class="tumblr"><a href="<?php esc_attr_e($options['snsurl_tumblr']) ?>" target="_blank"><span>Tumblr</span></a></li><?php endif; ?>
    </ul>
    <?php if(is_front_page() == FALSE) : ?>
        <p class="store-information01 sp-none">
            <span class="store-name"><?php esc_html_e($options['shop_name']) ?></span>
            <span class="store-address"><?php esc_html_e($options['shop_addr']) ?></span>TEL.<span class="store-tel"><?php esc_html_e($options['shop_tel']) ?></span>
        </p>
    <?php endif; ?>
    <p id="copyright">&copy;&nbsp;<?php bloginfo('name'); ?> All Rights Reserved.</p>
</div><!-- / #footer -->

 <div id="return_top">
  <a href="#main_col"><span><?php _e('PAGE TOP', 'tcd-w'); ?></span></a>
 </div>

</div><!-- / #main_col -->
</div><!-- / #main_content -->
</div><!-- / #site_wrap -->

<?php if ( is_mobile()) { get_template_part('footer-bar/footer-bar'); }; ?>
<?php if( is_mobile() ) { ?>
<?php if($options['footer_bar_display'] == 'type1') { ?>
<script src="<?php echo get_template_directory_uri(); ?>/footer-bar/footer-bar.js?ver=<?php echo version_num(); ?>"></script>
<?php }elseif($options['footer_bar_display'] == 'type2'){ ?>
<script src="<?php echo get_template_directory_uri(); ?>/footer-bar/footer-bar2.js?ver=<?php echo version_num(); ?>"></script>
<?php }; ?>
<?php } ?>

<script>
jQuery(document).ready(function($){

  $(window).load(function () {
    $('#site_loader_spinner').delay(600).fadeOut(400);
    $('#site_loader_overlay').delay(900).fadeOut(800);
    $('#site_wrap').css('display', 'block');
    $(window).trigger('resize');
		if ($('.pb_slider').length) {
			$('.pb_slider').slick('setPosition');
			$('.pb_slider_nav').slick('setPosition');
		}
    if ($('.pb_tab_slider').length) {
      $('.pb_tab_slider').slick('setPosition');
    }
  });
  $(function(){
    setTimeout(function(){
      $('#site_loader_spinner').delay(600).fadeOut(400);
      $('#site_loader_overlay').delay(900).fadeOut(800);
      $('#site_wrap').css('display', 'block');
    }, <?php echo esc_html( $options['load_time'] ); ?>);
  });
});
<?php if(!is_mobile()){ ?>
var timer = false;
 jQuery(window).on('load resize', function(){
     if (timer !== false) {
         clearTimeout(timer);
     }
     timer = setTimeout(function() {
         var h = $(window).height();
         var w = $(window).width();
         var x = <?php echo $options['min_height_sidebar']; ?>;
         if(h<x){
             $('#side_col').css('position', 'relative');
             $('#side_col .store-information').css('position', 'relative');
         }
    }, 200);
});
<?php }; ?>
</script>
<?php if(is_single()) { ?>
    <!-- facebook share button code -->
    <div id="fb-root"></div>
    <script>
        (function(d, s, id) {
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) return;
            js = d.createElement(s); js.id = id;
            js.src = "//connect.facebook.net/ja_JP/sdk.js#xfbml=1&version=v2.5";
            fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));
    </script>
<?php }; ?>
<?php
         if ( ($options['show_line_top'] && $options['sns_type_top'] == 'type5') || ($options['show_line_btm'] && $options['sns_type_btm'] == 'type5') ) :
?>
<script src="https://www.line-website.com/social-plugins/js/thirdparty/loader.min.js" async="async" defer="defer"></script>
<?php
         endif;
?>
<?php wp_footer(); ?>
</body>
</html>
