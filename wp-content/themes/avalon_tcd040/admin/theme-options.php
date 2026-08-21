<?php

use TCD\Helper\UI;
use TCD\Helper\Sanitization as San;

add_action( 'admin_init', 'theme_options_init' );
add_action( 'admin_menu', 'theme_options_add_page' );

global $footer_bar_button_options;
global $footer_bar_icon_options;

/**
 * オプション初期値
 * @var array 
 */
global $dp_default_options;
// #TODO 画面作成後に不要な定義を削除する
$dp_default_options = array(
	'pickedcolor1' => '753A00',
	'pickedcolor2' => '999999',
	'pickedcolor3' => 'F57500',
	'pickedcolor4' => 'FFFFFF',
	'logotop' => 0,
	'logoleft' => 0,
	'layout'  => 'type1',
  // フォントセット（type1, type2, type3, logo 用）
  	'font_list' => array(
	1 => [ // type1
	  'type'       => 'system',
	  'weight'     => 'normal',
	  'japan'      => 'sans-serif',
	  'latin'      => 'arial',
	  'web_japan'  => 'noto_sans',
	  'web_latin'  => '',
	],
	2 => [ // type2
	  'type'       => 'system',
	  'weight'     => 'normal',
	  'japan'      => 'serif',
	  'latin'      => 'times',
	  'web_japan'  => 'noto_sans',
	  'web_latin'  => '',
	],
	3 => [ // type3
	  'type'       => 'system',
	  'weight'     => 'normal',
	  'japan'      => 'kyokasho',
	  'latin'      => 'palatino',
	  'web_japan'  => 'noto_sans',
	  'web_latin'  => '',
	],
	'logo' => [ // ロゴ用フォント
	  'type'       => 'web',
	  'weight'     => 'bold',
	  'japan'      => 'kyokasho',
	  'latin'      => 'palatino',
	  'web_japan'  => 'noto_sans',
	  'web_latin'  => '',
	],
),

	'basefont' => 1,
	'headline_font_type' => 2,
	'use_ogp' => 0,
	'fb_app_id' => '',
	'use_twitter_card' => 0,
	'twitter_account_name' => '',
	'ogp_image' => false,

	'favicon' => false,

	'header_image_404' => false,
	'header_txt_404' => '',
	'header_txt_size_404' => 30,
	'header_txt_color_404' => 'FFFFFF',
	'dropshadow_404_h' => 0,
	'dropshadow_404_v' => 0,
	'dropshadow_404_b' => 0,
	'dropshadow_404_c' => 'FFFFFF',

	'css_code' => '',
	'custom_head' => '',
	'use_emoji' => 1,

	'hover_type' => 'type1',
	'hover1_zoom' => '1.2',
	'hover2_direct' => 'type1',
	'hover2_opacity' => '0.5',
	'hover3_opacity' => '0.5',
	'hover3_bgcolor' => 'FFFFFF',

	//Google maps
	'gmap_api_key' => '',
	'gmap_marker_type' => 'type1',
	'gmap_custom_marker_type' => 'type1',
	'gmap_marker_text' => '',
	'gmap_marker_color' => '#FFFFFF',
	'gmap_marker_img' => '',
	'gmap_marker_bg' => '#000000',

//logo
	'logo_font_size' => 21,
	'logo_font_size_fix' => 21,
	'logo_font_size_mobile' => 18,
	'logo_font_size_footer' => 40,
	'site_desc_font_size' => 12,
	'site_desc_font_size_footer' => 12,
	'show_site_desc' => 1,
	'show_site_desc_footer' => 1,
	'header_logo_image' => false,
	'header_logo_image_fix' => false,
	'header_logo_image_mobile' => false,
	'footer_logo_image' => false,

	'index_section_items' => array(
		array(
			'image' => '',
			'use_overlay' => 0,
			'overlay' => '000000',
			'overlay_opacity' => '0.5',
			'use_headline' => 0,
			'headline' => '',
			'headline_fontsize' => '42',
			'headline_color' => 'FFFFFF',
			'dropshadow_h' => 1,
			'dropshadow_v' => 1,
			'dropshadow_b' => 5,
			'dropshadow_c' => '444444',
			'use_desc' => 0,
			'desc' => '',
			'desc_fontsize' => '14',
			'desc_color' => '',
			'dropshadow_desc_h' => 0,
			'dropshadow_desc_v' => 0,
			'dropshadow_desc_b' => 0,
			'dropshadow_desc_c' => '444444',
			'use_btn' => 0,
			'use_ghost_btn' => 0,
			'btn_label' => '',
			'btn_url' => '',
			'btn_url_target' => 0,
			'btn_bg_opacity' => '0.5',
			'btn_color' => 'FFFFFF',
			'btn_bgcolor' => '000000',
			'btn_bordercolor' => 'FFFFFF',
			'btn_hover_color' => 'FFFFFF',
			'btn_hover_bgcolor' => '000000'
		)
	),

	'show_index_blog' => '1',
	'front_blog_bgcolor' => '222222',
	'front_blog_headline' => 'NEW BLOG',
	'front_blog_headline_fontsize' => 42,
	'front_blog_headline_color' => 'FFFFFF',
	'front_blog_count' => 4,
	'front_blog_linktext' => __('Blog list', 'tcd-w'),
	'show_index_freespace' => 0,
	'front_freespace_headline' => '',
	'front_freespace_bgcolor' => '222222',
	'front_freespace_headline' => 'NEW CONTENTS',
	'front_freespace_headline_fontsize' => 42,
	'front_freespace_headline_color' => 'FFFFFF',
	'front_freespace_editor' => '',
	'snsurl_tiktok' => '',
	'snsurl_twitter' => '',
	'snsurl_facebook' => '',
	'snsurl_instagram' => '',
	'snsurl_pinterest' => '',
	'snsurl_flickr' => '',
	'snsurl_tumblr' => '',
	'front_scroll_no_animation' => 0,

	'min_height_sidebar' => 500,

	'shop_name' => '',
	'shop_addr' => '',
	'shop_tel' => '',
	'shop_name_fontsize_side' => 16,
	'shop_name_fontsize_foot' => 14,
	'shop_addr_fontsize_side' => 12,
	'shop_addr_fontsize_foot' => 12,
	'shop_tel_fontsize_side' => 30,
	'shop_tel_fontsize_foot' => 24,

	'news_visible' => TRUE,
	'news_count' => 6,
	'news_linktext' => __('News list', 'tcd-w'),
	'fixed_news' => 1,
	'show_news_date' =>1,

	'index_blog_num' => '8',

	'blog_list_show_date' => 1,
	'blog_list_show_excerpt' => 1,

	'show_index_news' => 1,
	'index_news_link' => __('News archive', 'tcd-w'),

	//--
// blog content
	'blog_image' => false,
	'blog_headline' => '',
	'blog_headline_font_size' => '40',
	'blog_headline_color' => 'FFFFFF',
	'blog_headline_shadow1' => 0,
	'blog_headline_shadow2' => 0,
	'blog_headline_shadow3' => 4,
	'blog_headline_shadow_color' => '333333',
	'blog_content' => '',
// post page
	'title_font_size' => '18',
	'archive_title_font_size' => '30',
	'content_font_size' => '14',
	'show_date' => 1,
	'show_comment' => 1,
	'show_author' => 1,
	'show_related_post' => 1,
	'show_next_post' => 1,
	'show_thumbnail' => 1,
// top & archive page
	'archive_show_date' => 1,
	'archive_show_category' => 1,
// share button
	'show_sns_top' => 1,
	'show_sns_btm' => 1,
	'sns_type_top' => 'type1',
	'sns_type_btm' => 'type1',
	'show_twitter_top' => 1,
	'show_fblike_top' => 1,
	'show_fbshare_top' => 1,
	'show_hatena_top' => 1,
	'show_pocket_top' => 1,
	'show_feedly_top' => 1,
	'show_rss_top' => 1,
	'show_pinterest_top' => 1,
	'show_line_top' => 1,
	'show_note_top' => 1,

	'show_twitter_btm' => 1,
	'show_fblike_btm' => 1,
	'show_fbshare_btm' => 1,
	'show_hatena_btm' => 1,
	'show_pocket_btm' => 1,
	'show_feedly_btm' => 1,
	'show_rss_btm' => 1,
	'show_pinterest_btm' => 1,
	'show_line_btm' => 1,
	'show_note_btm' => 1,
	'twitter_info' => '',
// post page banner
	'single_ad_code1' => '',
	'single_ad_image1' => false,
	'single_ad_url1' => '',
	'single_ad_code2' => '',
	'single_ad_image2' => false,
	'single_ad_url2' => '',
	'single_ad_code3' => '',
	'single_ad_image3' => false,
	'single_ad_url3' => '',
	'single_ad_code4' => '',
	'single_ad_image4' => false,
	'single_ad_url4' => '',
	'single_ad_code5' => '',
	'single_ad_image5' => false,
	'single_ad_url5' => '',
	'single_ad_code6' => '',
	'single_ad_image6' => false,
	'single_ad_url6' => '',

	'single_ad_code_m1' => '',
	'single_ad_image_m1' => false,
	'single_ad_url_m1' => '',
	'single_ad_code_m2' => '',
	'single_ad_image_m2' => false,
	'single_ad_url_m2' => '',
	//--

// news content
	'news_image' => false,
	'news_headline' => '',
	'news_headline_font_size' => '40',
	'news_headline_color' => 'FFFFFF',
	'news_headline_shadow1' => 0,
	'news_headline_shadow2' => 0,
	'news_headline_shadow3' => 4,
	'news_headline_shadow_color' => '333333',
	//'news_archive_count' => 5,
	'news_title_font_size' => 30,
	'show_news_date_single' => 1,
	'show_news_date_archive' => 1,
	'show_product_category' => 1,
	'show_next_post_product' => 1,
	'show_product_carousel' => 1,

	'load_time' => '7',

	// gnav setting
	'gnav_submenu_opacity' => 0.5,
	'gnav_submenu_color' => 'FFFFFF',
	'gnav_submenu_bgcolor' => '000000',
	'gnav_submenu_color_hover' => 'FFFFFF',
	'gnav_submenu_bgcolor_hover' => '753A00',

	'footer_menu_off_link' => '',
  // フッターの固定メニュー
  'footer_bar_display' => 'type3',
  'footer_bar_tp' => 0.8,
  'footer_bar_bg' => 'FFFFFF',
  'footer_bar_border' => 'DDDDDD',
  'footer_bar_color' => '000000',
  'footer_bar_btns' => array(
    array(
      'type' => 'type1',
      'label' => '',
      'url' => '',
      'number' => '',
      'target' => 0,
      'icon' => 'file-text'
    )
  )

);

/**
 * Design Plusのオプションを返す
 * @global array $dp_default_options
 * @return array 
 */
function get_desing_plus_option(){
	global $dp_default_options;
	return shortcode_atts($dp_default_options, get_option('dp_options', array()));
}


// 登録
function theme_options_init(){
 register_setting( 'design_plus_options', 'dp_options', 'theme_options_validate' );
}


// ロード
function theme_options_add_page() {
 add_theme_page( __( 'Theme Options', 'tcd-w' ), __( 'TCD Theme Options', 'tcd-w' ), 'edit_theme_options', 'theme_options', 'theme_options_do_page' );
}


// レイアウトの設定
global $layout_options;
$layout_options = array(
	'type1' => array('value' => 'type1','label' => __( 'Layout type1', 'tcd-w' ),'img' => 'type1'),
	'type2' => array('value' => 'type2','label' => __( 'Layout type2', 'tcd-w' ),'img' => 'type2'),
);

// ベースフォントの設定
global $basefont_options;
$basefont_options = array(
	'meiryo' => array('value' => 'meiryo','label' => __( 'Basefont meiryo', 'tcd-w' )),
	'yugothic' => array('value' => 'yugothic','label' => __( 'Basefont yugothic', 'tcd-w' )),
	'yumincho' => array('value' => 'yumincho','label' => __( 'Basefont YuMincho', 'tcd-w' ))
);
// headline font
global $headline_font_type_options;
$headline_font_type_options = array(
	'type1' => array('value' => 'type1','label' => __( 'Gothic', 'tcd-w' )),
	'type2' => array('value' => 'type2','label' => __( 'Mincho', 'tcd-w' ))
);

// hover effect
global $hover_type_options;
$hover_type_options = array(
 'type1' => array('value' => 'type1','label' => __( 'Zoom', 'tcd-w' )),
 'type2' => array('value' => 'type2','label' => __( 'Slide', 'tcd-w' )),
 'type3' => array('value' => 'type3','label' => __( 'Fade', 'tcd-w' ))
);
global $hover2_direct_options;
$hover2_direct_options = array(
 'type1' => array('value' => 'type1','label' => __( 'Left to Right', 'tcd-w' )),
 'type2' => array('value' => 'type2','label' => __( 'Right to Left', 'tcd-w' ))
);


// 記事下のSNSボタン
global $sns_type_btm_options;
$sns_type_btm_options = array(
'type1' => array( 'value' => 'type1', 'label' => __( 'Button type1 - left align with color', 'tcd-w' )),
'type2' => array( 'value' => 'type2', 'label' => __( 'Button type2 - left align with monotone', 'tcd-w' )),
'type3' => array( 'value' => 'type3', 'label' => __( 'Button type3 - full width with color', 'tcd-w' )),
'type4' => array( 'value' => 'type4', 'label' => __( 'Button type4 - full width with monotone', 'tcd-w' )),
'type5' => array( 'value' => 'type5', 'label' => __( 'Button type5 - default design', 'tcd-w' ))
);


// ローディングアイコンの最大表示時間の設定
global $load_time_options;
$load_time_options = array(
 '3' => array('value' => '3000','label' => __( '3 second', 'tcd-w' )),
 '4' => array('value' => '4000','label' => __( '4 second', 'tcd-w' )),
 '5' => array('value' => '5000','label' => __( '5 second', 'tcd-w' )),
 '6' => array('value' => '6000','label' => __( '6 second', 'tcd-w' )),
 '7' => array('value' => '7000','label' => __( '7 second', 'tcd-w' )),
 '8' => array('value' => '8000','label' => __( '8 second', 'tcd-w' )),
 '9' => array('value' => '9000','label' => __( '9 second', 'tcd-w' )),
 '10' => array('value' => '10000','label' => __( '10 second', 'tcd-w' )),
);


// ソーシャルボタンの設定
// 記事上ボタンタイプ
global $sns_type_top_options;
$sns_type_top_options = array(
	'type1' => array( 'value' => 'type1', 'label' => __( 'style1', 'tcd-w' )),
	'type2' => array( 'value' => 'type2', 'label' => __( 'style2', 'tcd-w' )),
	'type3' => array( 'value' => 'type3', 'label' => __( 'style3', 'tcd-w' )),
	'type4' => array( 'value' => 'type4', 'label' => __( 'style4', 'tcd-w' )),
	'type5' => array( 'value' => 'type5', 'label' => __( 'style5', 'tcd-w' ))
);

// フッターの固定メニュー 表示タイプ
global $footer_bar_display_options;
$footer_bar_display_options = array(
 'type1' => array('value' => 'type1', 'label' => __( 'Fade In', 'tcd-w' )),
 'type2' => array('value' => 'type2', 'label' => __( 'Slide In', 'tcd-w' )),
 'type3' => array('value' => 'type3', 'label' => __( 'Hide', 'tcd-w' ))
);

// フッターの固定メニュー ボタンのタイプ
global $footer_bar_button_options;
$footer_bar_button_options = array(
 'type1' => array('value' => 'type1', 'label' => __( 'Default', 'tcd-w' )),
 'type2' => array('value' => 'type2', 'label' => __( 'Share', 'tcd-w' )),
 'type3' => array('value' => 'type3', 'label' => __( 'Telephone', 'tcd-w' ))
);

// フッターの固定メニューのアイコン
global $footer_bar_icon_options;
$footer_bar_icon_options = array(
 'file-text' => array('value' => 'file-text', 'label' => __( 'Document', 'tcd-w' )),
 'share-alt' => array('value' => 'share-alt', 'label' => __( 'Share', 'tcd-w' )),
 'phone' => array('value' => 'phone', 'label' => __( 'Telephone', 'tcd-w' )),
 'envelope' => array('value' => 'envelope', 'label' => __( 'Envelope', 'tcd-w' )),
 'tag' => array('value' => 'tag', 'label' => __( 'Tag', 'tcd-w' )),
 'pencil' => array('value' => 'pencil', 'label' => __( 'Pencil', 'tcd-w' ))
);

// Google Maps
global $gmap_marker_type_options;
$gmap_marker_type_options = array(
  'type1' => array( 'value' => 'type1', 'label' => __( 'Use default marker', 'tcd-w' ) ),
  'type2' => array( 'value' => 'type2', 'label' => __( 'Use custom marker', 'tcd-w' ) )
);

global $gmap_custom_marker_type_options;
$gmap_custom_marker_type_options = array(
  'type1' => array( 'value' => 'type1', 'label' => __( 'Text', 'tcd-w' ) ),
  'type2' => array( 'value' => 'type2', 'label' => __( 'Image', 'tcd-w' ) )
);

// テーマオプション画面の作成
function theme_options_do_page() {
 global $hover_type_options, $dp_default_options,$hover2_direct_options, $basefont_options, $headline_font_type_options, $sns_type_btm_options, $layout_options, $load_time_options, $dp_upload_error, $sns_type_top_options, $footer_bar_icon_options, $footer_bar_button_options, $footer_bar_display_options, $gmap_marker_type_options, $gmap_custom_marker_type_options;
 $options = get_desing_plus_option(); 

 if ( ! isset( $_REQUEST['settings-updated'] ) )
  $_REQUEST['settings-updated'] = false;

?>

<div class="wrap">

 <?php echo "<h2>" . __( 'TCD Theme Options', 'tcd-w' ) . "</h2>"; ?>

 <?php // 更新時のメッセージ
       if ( false !== $_REQUEST['settings-updated'] ) :
 ?>
 <div class="updated fade"><p><strong><?php _e('Updated', 'tcd-w');  ?></strong></p></div>
 <?php endif; ?>

 <?php /* ファイルアップロード時のメッセージ */ if(!empty($dp_upload_error['message'])): ?>
  <?php if($dp_upload_error['error']): ?>
   <div id="error" class="error"><p><?php echo $dp_upload_error['message']; ?></p></div>
  <?php else: ?>
   <div id="message" class="updated fade"><p><?php echo $dp_upload_error['message']; ?></p></div>
  <?php endif; ?>
 <?php endif; ?>
 
 <div id="my_theme_option" class="cf">

  <div id="my_theme_left">
   <ul id="theme_tab" class="cf">
    <li><a href="#tab-content1"><?php _e('Basic', 'tcd-w');  ?></a></li>
    <li><a href="#tab-content2"><?php _e('Logo', 'tcd-w');  ?></a></li>
    <li><a href="#tab-content3"><?php _e('Index page', 'tcd-w');  ?></a></li>
    <li><a href="#tab-content4"><?php _e('Blog', 'tcd-w');  ?></a></li>
    <li><a href="#tab-content5"><?php _e('News', 'tcd-w');  ?></a></li>
    <li><a href="#tab-content6"><?php _e('Fixed sidebar', 'tcd-w');  ?></a></li>
    <li><a href="#tab-content7"><?php _e('Footer', 'tcd-w');  ?></a></li>
   </ul>
  </div>

  <div id="my_theme_right">

  <form method="post" action="options.php" enctype="multipart/form-data">

  <?php settings_fields( 'design_plus_options' ); ?>

  <div id="tab-panel">

  <!-- #tab-content1 //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////  -->
  <div id="tab-content1">

   <?php // サイトカラー ?>
   <div id="color_pattern">
    <div class="theme_option_field cf">
     <h3 class="theme_option_headline"><?php _e('Color setting', 'tcd-w');  ?></h3>
     <h4 class="theme_option_headline2"><?php _e('Primary color setting', 'tcd-w');  ?></h4>
     <input type="text" id="color1" class="color" name="dp_options[pickedcolor1]" value="<?php esc_attr_e( $options['pickedcolor1'] ); ?>" />
     <input type="button" style="margin:2px 0 0 15px;" class="button-secondary" value="<?php _e('Default color', 'tcd-w');  ?>" onClick="document.getElementById('color1').color.fromString('753A00')">
     <h4 class="theme_option_headline2"><?php _e('Secondary color setting', 'tcd-w');  ?></h4>
     <input type="text" id="color2" class="color" name="dp_options[pickedcolor2]" value="<?php esc_attr_e( $options['pickedcolor2'] ); ?>" />
     <input type="button" style="margin:2px 0 0 15px;" class="button-secondary" value="<?php _e('Default color', 'tcd-w');  ?>" onClick="document.getElementById('color2').color.fromString('999999')">
     <h4 class="theme_option_headline2"><?php _e('Link text color in the article', 'tcd-w');  ?></h4>
     <input type="text" id="color3" class="color" name="dp_options[pickedcolor3]" value="<?php esc_attr_e( $options['pickedcolor3'] ); ?>" />
     <input type="button" style="margin:2px 0 0 15px;" class="button-secondary" value="<?php _e('Default color', 'tcd-w');  ?>" onClick="document.getElementById('color3').color.fromString('f57500')">
     <h4 class="theme_option_headline2"><?php _e('Background color of side column', 'tcd-w');  ?></h4>
     <input type="text" id="color4" class="color" name="dp_options[pickedcolor4]" value="<?php esc_attr_e( $options['pickedcolor4'] ); ?>" />
     <input type="button" style="margin:2px 0 0 15px;" class="button-secondary" value="<?php _e('Default color', 'tcd-w');  ?>" onClick="document.getElementById('color4').color.fromString('ffffff')">
     <input type="submit" class="button-ml" value="<?php echo __( 'Save Changes', 'tcd-w' ); ?>" />
    </div>
   </div>


   <?php //favicon ?>

   <div class="theme_option_field cf">
   <h3 class="theme_option_headline"><?php _e('Favicon setup', 'tcd-w');  ?></h3>
   <div class="theme_option_input">
   <p><?php _e( 'If you have registered an icon from "Site Icon" in <a href="./options-general.php" target="_blank">General Settings</a>, you do not need to use this option.', 'tcd-w' ); ?></p>
    <p><?php _e( 'Instruction for registering site icon, see the official <a href="https://tcd-theme.com/2021/02/wp-favicon-setting.html" target="_blank">TCD blog article</a>.', 'tcd-w' ); ?></p>
      <div class="image_box cf">
       <div class="upload_banner_button_area">
        <div class="hide"><input type="text" size="36" name="dp_options[favicon]" value="<?php esc_attr_e( $options['favicon'] ); ?>" /></div>
        <input type="file" name="favicon_file" id="favicon_file" />
        <input type="submit" class="button-ml" value="<?php echo __('Save Image', 'tcd-w');  ?>" />
       </div>
       <?php if($options['favicon']) { ?>
        <div class="uploaded_banner_image">
         <img src="<?php esc_attr_e( $options['favicon'] ); ?>" alt="" title="" />
        </div>
        <?php if(dp_is_uploaded_img($options['favicon'])): ?>
        <div class="delete_uploaded_banner_image">
         <a href="<?php echo wp_nonce_url(admin_url('themes.php?page=theme_options'), 'dp_delete_favicon') ?>" class="button-ml" onclick="if(!confirm('<?php _e('Are you sure to delete this image?', 'tcd-w'); ?>')) return false;"><?php _e('Delete Image', 'tcd-w'); ?></a>
        </div>
       <?php endif; ?>
       <?php }; ?>
     </div>
     <input type="submit" class="button-ml" value="<?php echo __( 'Save Changes', 'tcd-w' ); ?>" />
    </div>
   </div>

	  <?php // ベースフォントの設定 ?>
	  <div class="theme_option_field cf">
		  <h3 class="theme_option_headline"><?php _e('Basefont', 'tcd-w');  ?></h3>
		  <div class="theme_option_input basefont_option">

		  <?php
    //新フォントシステム実装
    set_query_var('options', $options);
    set_query_var('dp_default_options', $dp_default_options);
    get_template_part('admin/font/font-basic-main-contents');
   ?>
    <?php echo UI\font_select( 'dp_options[basefont]', $options['basefont'] ); ?>
			  <input type="submit" class="button-ml" value="<?php echo __( 'Save Changes', 'tcd-w' ); ?>" />
		  </div>
	  </div>

   <?php // フォントの種類 ?>
   <div class="theme_option_field cf">
    <h3 class="theme_option_headline"><?php _e('Font type of headline', 'tcd-w');  ?></h3>
	<?php echo UI\font_select( 'dp_options[headline_font_type]', $options['headline_font_type'] ); ?>
    <input type="submit" class="button-ml" value="<?php echo __( 'Save Changes', 'tcd-w' ); ?>" />
   </div>

	<?php // サムネイルのホバーエフェクト ?>
	<div class="theme_option_field cf">
		<h3 class="theme_option_headline"><?php _e('Hover effect of thumbnails', 'tcd-w');  ?></h3>
	    <h4 class="theme_option_headline2"><?php _e('Hover effect type', 'tcd-w'); ?></h4>
		<p><?php _e('You can select the hover effect of thumbnails except for ads. ', 'tcd-w'); ?></p>
	    <fieldset class="cf select_type2">
	     <?php
	          if ( ! isset( $checked ) )
	          $checked = '';
	          foreach ( $hover_type_options as $option ) {
	          $hover_type_setting = $options['hover_type'];
	            if ( '' != $hover_type_setting ) {
	              if ( $options['hover_type'] == $option['value'] ) {
	                $checked = "checked=\"checked\"";
	              } else {
	                $checked = '';
	              }
	           }
	     ?>
	     
	     <input style="display:inline; margin: 5px 5px 5px 0;" type="radio" id="tab-<?php echo $option['value']; ?>" name="dp_options[hover_type]" value="<?php esc_attr_e( $option['value'] ); ?>" <?php echo $checked; ?> />
	     <label style="display:inline;" class="description" for="tab-<?php echo $option['value']; ?>"><?php echo $option['label']; ?></label><br>
	     
	     <?php } ?>
	    <div class="tab-box">
	    	<div id="tabView1">
			    <h4 class="theme_option_headline2"><?php _e('Settings for Zoom effect', 'tcd-w'); ?></h4>
			    <p><?php _e('Please set the rate of magnification.', 'tcd-w'); ?></p>
			    <input id="dp_options[hover1_zoom]" class="hankaku" style="width:45px;" type="text" name="dp_options[hover1_zoom]" value="<?php esc_attr_e( $options['hover1_zoom'] ); ?>" />
			    <input type="submit" class="button-ml" value="<?php echo __( 'Save Changes', 'tcd-w' ); ?>" />
		    </div>
	    	<div id="tabView2">
			    <h4 class="theme_option_headline2"><?php _e('Settings for Slide effect', 'tcd-w'); ?></h4>
			    <p><?php _e('Please set the direction of slide.', 'tcd-w'); ?></p>
			    <fieldset class="cf select_type2">
			     <?php
			          if ( ! isset( $checked ) )
			          $checked = '';
			          foreach ( $hover2_direct_options as $option ) {
			          $hover2_direct_setting = $options['hover2_direct'];
			            if ( '' != $hover2_direct_setting ) {
			              if ( $options['hover2_direct'] == $option['value'] ) {
			                $checked = "checked=\"checked\"";
			              } else {
			                $checked = '';
			              }
			           }
			     ?>
			     <label class="description" style="display:inline-block;margin-right:15px;">
			      <input type="radio" name="dp_options[hover2_direct]" value="<?php esc_attr_e( $option['value'] ); ?>" <?php echo $checked; ?> />
			      <?php echo $option['label']; ?>
			     </label>
			     <?php } ?>
			    </fieldset>
			    <p><?php _e('Please set the opacity. (0 - 1.0, e.g. 0.7)', 'tcd-w'); ?></p>
			    <input id="dp_options[hover2_opacity]" class="hankaku" style="width:45px;" type="text" name="dp_options[hover2_opacity]" value="<?php esc_attr_e( $options['hover2_opacity'] ); ?>" />
			    <input type="submit" class="button-ml" value="<?php echo __( 'Save Changes', 'tcd-w' ); ?>" />
		    </div>
	    	<div id="tabView3">
			    <h4 class="theme_option_headline2"><?php _e('Settings for Fade effect', 'tcd-w'); ?></h4>
			    <p><?php _e('Please set the opacity. (0 - 1.0, e.g. 0.7)', 'tcd-w'); ?></p>
			    <input id="dp_options[hover3_opacity]" class="hankaku" style="width:45px;" type="text" name="dp_options[hover3_opacity]" value="<?php esc_attr_e( $options['hover3_opacity'] ); ?>" />
			    <p><?php _e('Please set the background color.', 'tcd-w'); ?></p>
			    <input type="text" id="hover3_bgcolor" class="color" name="dp_options[hover3_bgcolor]" value="<?php esc_attr_e( $options['hover3_bgcolor'] ); ?>" />
	     <input type="button" style="margin:0 0 0 5px;" class="button-secondary" value="<?php _e('Default color', 'tcd-w');  ?>" onClick="document.getElementById('hover3_bgcolor').color.fromString('FFFFFF')">
			    <input type="submit" class="button-ml" value="<?php echo __( 'Save Changes', 'tcd-w' ); ?>" />
		    </div>
	    </div>
	    </fieldset>
	</div>

    <?php // Use OGP tag ?>
   <div class="theme_option_field cf">
    <h3 class="theme_option_headline"><?php _e('OGP', 'tcd-w');  ?></h3>
    <div class="theme_option_input">
     <p><?php _e( 'OGP is a mechanism for correctly conveying page information.', 'tcd-w' ); ?></p>
     <p><label><input id="dp_options[use_ogp]" name="dp_options[use_ogp]" type="checkbox" value="1" <?php checked( '1', $options['use_ogp'] ); ?> /> <?php _e('Use OGP', 'tcd-w');  ?></label></p>
			<h4 class="theme_option_headline2"><?php _e('OGP image', 'tcd-w');  ?></h4>
			<p><?php _e('This image is displayed for OGP if the page does not have a thumbnail.', 'tcd-w'); ?></p>
			<p><?php _e('Recommend image size. Width:1200px, Height:630px', 'tcd-w');  ?></p>
			<div class="image_box cf">
				<div class="cf cf_media_field hide-if-no-js header_image_404">
					<input type="hidden" value="<?php echo esc_attr( $options['ogp_image'] ); ?>" id="ogp_image" name="dp_options[ogp_image]" class="cf_media_id">
					<div class="preview_field"><?php if($options['ogp_image']){ echo wp_get_attachment_image($options['ogp_image'], 'medium'); }; ?></div>
					<div class="buttton_area">
						<input type="button" value="<?php _e('Select Image', 'tcd-w'); ?>" class="cfmf-select-img button">
						<input type="button" value="<?php _e('Remove Image', 'tcd-w'); ?>" class="cfmf-delete-img button <?php if(!$options['ogp_image']){ echo 'hidden'; }; ?>">
					</div>
				</div>
			</div>
			<h4 class="theme_option_headline2"><?php _e('Facebook OGP setting', 'tcd-w');  ?></h4>
      <p><?php _e( 'In order to use Facebook Insights please set your app ID.', 'tcd-w' ); ?></p>
		  <p><a href="https://tcd-theme.com/2018/01/facebook_app_id.html" target="_blank"><?php _e( 'Information about Facebook app ID.', 'tcd-w' ); ?></a></p>
      <p><?php _e( 'Your app ID', 'tcd-w' );  ?> <input class="regular-text" type="text" name="dp_options[fb_app_id]" value="<?php esc_attr_e( $options['fb_app_id'] ); ?>"></p>
			<h4 class="theme_option_headline2"><?php _e('X Cards setting', 'tcd-w');  ?></h4>
     <p><?php _e('Your X account name (exclude @ mark)', 'tcd-w');  ?> <input id="dp_options[twitter_account_name]" class="regular-text" type="text" name="dp_options[twitter_account_name]" value="<?php esc_attr_e( $options['twitter_account_name'] ); ?>" /></p>
     <p><a href="https://tcd-theme.com/2016/11/twitter-cards.html" target="_blank"><?php _e( 'Information about X Cards.', 'tcd-w' ); ?></a></p>
   </div>
     <input type="submit" class="button-ml" value="<?php echo __( 'Save Changes', 'tcd-w' ); ?>" />
   </div>

   <?php // 絵文字の設定 ?>
   <div class="theme_option_field cf">
    <h3 class="theme_option_headline"><?php _e('Emoji setup', 'tcd-w');  ?></h3>
    <p><?php _e('We recommend to checkoff this option if you dont use any Emoji in your post content.', 'tcd-w');  ?></p>
    <p><label><input id="dp_options[use_emoji]" name="dp_options[use_emoji]" type="checkbox" value="1" <?php checked( '1', $options['use_emoji'] ); ?> /> <?php _e('Use emoji', 'tcd-w');  ?></label></p>
    <input type="submit" class="button-ml" value="<?php echo __( 'Save Changes', 'tcd-w' ); ?>" />
   </div>

   <?php // ローディング画面の最大表示設定 ?>
   <div class="theme_option_field cf">
    <h3 class="theme_option_headline"><?php _e('Loading screen setting', 'tcd-w');  ?></h3>
    <p><?php _e('Please set the maximum display time of the loading screen.<br />Even if all the content is not loaded, loading screen will disappear automatically after a lapse of time you have set at follwing.', 'tcd-w');  ?></p>
    <select name="dp_options[load_time]">
     <?php
          foreach ( $load_time_options as $option ) :
          $label = $option['label'];
          $selected = '';
          if ( $options['load_time'] == $option['value']) {
            $selected = 'selected="selected"';
          } else {
            $selected = '';
          }
          echo '<option style="padding-right: 10px;" value="' . esc_attr( $option['value'] ) . '" ' . $selected . '>' . $label . '</option>' ."\n";
          endforeach;
     ?>
    </select>
    <input type="submit" class="button-ml" value="<?php echo __( 'Save Changes', 'tcd-w' ); ?>" />
   </div>

<?php // Google Map ?>
<div class="theme_option_field cf">
	<h3 class="theme_option_headline"><?php _e( 'Google Maps settings', 'tcd-w' );?></h3>
	<h4 class="theme_option_headline2"><?php _e( 'API key', 'tcd-w' ); ?></h4>
	<input type="text" class="regular-text" name="dp_options[gmap_api_key]" value="<?php echo esc_attr( $options['gmap_api_key'] ); ?>">
	<h4 class="theme_option_headline2"><?php _e( 'Marker type', 'tcd-w' ); ?></h4>
	<?php foreach ( $gmap_marker_type_options as $option ) : ?>
	<p style="display:inline-block; margin-right:15px;">
		<label id="gmap_marker_type_button_<?php echo esc_attr( $option['value'] ); ?>">
			<input type="radio" name="dp_options[gmap_marker_type]" value="<?php echo esc_attr( $option['value'] ); ?>" <?php checked( $option['value'], $options['gmap_marker_type'] ); ?>> <?php echo esc_html_e( $option['label'] ); ?><br>
			<img src="<?php echo get_template_directory_uri(); ?>/admin/img/gmap_marker_<?php echo esc_attr( $option['value'] ); ?>.jpg" alt="">
		</label>
	</p>
	<?php endforeach; ?>
	<div id="gmap_marker_type2_area" style="<?php if ( $options['gmap_marker_type'] == 'type1' ) { echo 'display:none;'; } else { echo 'display:block;'; } ?>">
		<h4 class="theme_option_headline2"><?php _e( 'Custom marker type', 'tcd-w' ); ?></h4>
		<?php foreach ( $gmap_custom_marker_type_options as $option ) : ?>
		<p><label id="gmap_custom_marker_type_button_<?php echo esc_attr( $option['value'] ); ?>"><input type="radio" name="dp_options[gmap_custom_marker_type]" value="<?php echo esc_attr( $option['value'] ); ?>" <?php checked( $option['value'], $options['gmap_custom_marker_type'] ); ?>> <?php echo esc_html_e( $option['label'] ); ?></label></p>
		<?php endforeach; ?>
		<div id="gmap_custom_marker_type1_area" style="<?php if ( $options['gmap_custom_marker_type'] == 'type1') { echo 'display:block;'; } else { echo 'display:none;'; } ?>">
			<h4 class="theme_option_headline2"><?php _e( 'Custom marker text', 'tcd-w' ); ?></h4>
			<input type="text" name="dp_options[gmap_marker_text]" value="<?php echo esc_attr( $options['gmap_marker_text'] ); ?>" class="regular-text">
			<p><label for="gmap_marker_color"><?php _e( 'Font color', 'tcd-w' ); ?></label></p>
			<input type="text" id="gmap_marker_color" class="color" name="dp_options[gmap_marker_color]" value="<?php esc_attr_e( $options['gmap_marker_color'] ); ?>" />
			<input type="button" style="margin:0 0 0 5px;" class="button-secondary" value="<?php _e('Default color', 'tcd-w');  ?>" onClick="document.getElementById('gmap_marker_color').color.fromString('ffffff')">
		</div>
		<div id="gmap_custom_marker_type2_area" style="<?php if ( $options['gmap_custom_marker_type'] == 'type1') { echo 'display:none;'; } else { echo 'display:block;'; } ?>">
			<h4 class="theme_option_headline2"><?php _e( 'Custom marker image', 'tcd-w' ); ?></h4>
			<p><?php _e( 'Recommended size: width:60px, height:20px', 'tcd-w' ); ?></p>
			<div class="image_box cf">
				<div class="cf cf_media_field hide-if-no-js gmap_marker_img">
					<input type="hidden" value="<?php echo esc_attr( $options['gmap_marker_img'] ); ?>" id="gmap_marker_img" name="dp_options[gmap_marker_img]" class="cf_media_id">
					<div class="preview_field"><?php if ( $options['gmap_marker_img'] ) { echo wp_get_attachment_image($options['gmap_marker_img'], 'medium' ); } ?></div>
					<div class="button_area">
						<input type="button" value="<?php _e( 'Select Image', 'tcd-w' ); ?>" class="cfmf-select-img button">
						<input type="button" value="<?php _e( 'Remove Image', 'tcd-w' ); ?>" class="cfmf-delete-img button <?php if ( ! $options['gmap_marker_img'] ) { echo 'hidden'; } ?>">
					</div>
				</div>
			</div>
		</div>
	</div>
	<h4 class="theme_option_headline2"><?php _e( 'Marker style', 'tcd-w' ); ?></h4>
	<p><label for=""> <?php _e( 'Background color', 'tcd-w' ); ?></label></p>
     <input type="text" id="gmap_marker_bg" class="color" name="dp_options[gmap_marker_bg]" value="<?php esc_attr_e( $options['gmap_marker_bg'] ); ?>" />
     <input type="button" style="margin:0 0 0 5px;" class="button-secondary" value="<?php _e('Default color', 'tcd-w');  ?>" onClick="document.getElementById('gmap_marker_bg').color.fromString('000000')">

	<input type="submit" class="button-ml" value="<?php echo __( 'Save Changes', 'tcd-w' ); ?>">
</div>

	  <?php // ユーザーCSS用の自由記入欄 ?>
   <div class="theme_option_field cf">
    <h3 class="theme_option_headline"><?php _e('Free input area for user definition CSS.', 'tcd-w');  ?></h3>
    <p><?php _e('Code example:<br /><strong>.example { font-size:12px; }</strong>', 'tcd-w');  ?></p>
    <textarea id="dp_options[css_code]" class="large-text" cols="50" rows="10" name="dp_options[css_code]"><?php echo esc_textarea( $options['css_code'] ); ?></textarea>
    <input type="submit" class="button-ml" value="<?php echo __( 'Save Changes', 'tcd-w' ); ?>" />
   </div>

	  <?php // custom head/script ?>
   <div class="theme_option_field cf">
    <h3 class="theme_option_headline"><?php _e( 'Free input area for user definition scripts.', 'tcd-w' ); ?></h3>
    <p><?php esc_html_e( 'Custom Script will output the end of the <head> tag. Please insert scripts (i.e. Google Analytics script), including <script>tag.', 'tcd-w' ); ?></p>
    <textarea id="dp_options[custom_head]" class="large-text" cols="50" rows="10" name="dp_options[custom_head]"><?php echo esc_textarea( $options['custom_head'] ); ?></textarea>
    <input type="submit" class="button-ml" value="<?php echo __( 'Save Changes', 'tcd-w' ); ?>" />
   </div>

	<?php // 404 page -------------------------------------------------------------------------------------------- ?>
   <div class="theme_option_field cf">
    <h3 class="theme_option_headline"><?php _e('Settings for 404 page', 'tcd-w');  ?></h3>
		<h4 class="theme_option_headline2"><?php _e('Header image', 'tcd-w');  ?></h4>
		<p><?php _e('Recommend image size. Width:1180px, Height:550px', 'tcd-w');  ?></p>
		<div class="image_box cf">
			<div class="cf cf_media_field hide-if-no-js header_image_404">
				<input type="hidden" value="<?php echo esc_attr( $options['header_image_404'] ); ?>" id="header_image_404" name="dp_options[header_image_404]" class="cf_media_id">
				<div class="preview_field"><?php if($options['header_image_404']){ echo wp_get_attachment_image($options['header_image_404'], 'medium'); }; ?></div>
				<div class="buttton_area">
					<input type="button" value="<?php _e('Select Image', 'tcd-w'); ?>" class="cfmf-select-img button">
					<input type="button" value="<?php _e('Remove Image', 'tcd-w'); ?>" class="cfmf-delete-img button <?php if(!$options['header_image_404']){ echo 'hidden'; }; ?>">
				</div>
			</div>
		</div>
		<h4 class="theme_option_headline2"><?php _e('Headline', 'tcd-w');  ?></h4>
		<input id="dp_options[header_txt_404]" class="regular-text" type="text" name="dp_options[header_txt_404]" value="<?php esc_attr_e( $options['header_txt_404'] ); ?>" />
		<h4 class="theme_option_headline2"><?php _e('Font size of headline', 'tcd-w');  ?></h4>
		<p><input id="dp_options[header_txt_size_404]" class="font_size hankaku" type="text" name="dp_options[header_txt_size_404]" value="<?php esc_attr_e( $options['header_txt_size_404'] ); ?>" /><span>px</span></p>
		<h4 class="theme_option_headline2"><?php _e('Font color of headline', 'tcd-w');  ?></h4>
		<input type="text" id="header_txt_color_404" class="color" name="dp_options[header_txt_color_404]" value="<?php esc_attr_e( $options['header_txt_color_404'] ); ?>" />
		<input type="button" style="margin:0 0 0 5px;" class="button-secondary" value="<?php _e('Default color', 'tcd-w');  ?>" onClick="document.getElementById('header_txt_color_404').color.fromString('FFFFFF')">
		<h4 class="theme_option_headline2"><?php _e('Dropshadow of headline', 'tcd-w');  ?></h4>
		<p><?php _e('Enter "0" if you don\'t want to use dropshadow.', 'tcd-w'); ?></p>
		<ul class="headline_option">
			<li><label style="margin-right:7px;"><?php _e('Dropshadow position (left)', 'tcd-w');  ?></label><input id="dp_options[dropshadow_404_h]" class="font_size hankaku" type="text" name="dp_options[dropshadow_404_h]" value="<?php esc_attr_e( $options['dropshadow_404_h'] ); ?>" /><span>px</span></li>
			<li><label style="margin-right:7px;"><?php _e('Dropshadow position (top)', 'tcd-w');  ?></label><input id="dp_options[dropshadow_404_v]" class="font_size hankaku" type="text" name="dp_options[dropshadow_404_v]" value="<?php esc_attr_e( $options['dropshadow_404_v'] ); ?>" /><span>px</span></li>
			<li><label style="margin-right:7px;"><?php _e('Dropshadow size', 'tcd-w');  ?></label><input id="dp_options[dropshadow_404_b]" class="font_size hankaku" type="text" name="dp_options[dropshadow_404_b]" value="<?php esc_attr_e( $options['dropshadow_404_b'] ); ?>" /><span>px</span></li>
			<li><label style="margin-right:7px;"><?php _e('Dropshadow color', 'tcd-w');  ?></label><input type="text" id="dropshadow_404_c" class="color" name="dp_options[dropshadow_404_c]" value="<?php esc_attr_e( $options['dropshadow_404_c'] ); ?>" /><input type="button" style="margin:0 0 0 5px;" class="button-secondary" value="<?php _e('Default color', 'tcd-w');  ?>" onClick="document.getElementById('dropshadow_404_c').color.fromString('FFFFFF')"></li>
		</ul>
		<input type="submit" class="button-ml" value="<?php echo __( 'Save Changes', 'tcd-w' ); ?>" />
   </div>
  </div><!-- END #tab-content1 -->




  <!-- #tab-content2 //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////  -->
  <div id="tab-content2">

   <?php // ヘッダーのロゴ ----------------------------------------------------- ?>
   <div class="theme_option_field cf">
    <h3 class="theme_option_headline"><?php _e('Header logo', 'tcd-w');  ?></h3>
    <div<?php if(!empty($options['header_logo_image'])) { echo ' style="display:none;"'; }; ?>>
	<?php echo UI\note(
          [
            sprintf(
              __( '<a href="%s" target="_blank" rel="noopener noreferrer">Site title</a> appears as a logo.','tcd-w' ),
              esc_url( admin_url( '/options-general.php#blogname' ) )
            ),
            __( 'The fonts in the font set (for logos) are reflected.','tcd-w' )
          ]
        ); ?>
    <h4 class="theme_option_headline2"><?php _e('Font size for text logo', 'tcd-w');  ?></h4>
    <input id="dp_options[logo_font_size]" class="font_size hankaku" type="text" name="dp_options[logo_font_size]" value="<?php esc_attr_e( $options['logo_font_size'] ); ?>" /><span>px</span>
    <h4 class="theme_option_headline2"><?php _e('Font size for site description', 'tcd-w');  ?></h4>
    <input id="dp_options[site_desc_font_size]" class="font_size hankaku" type="text" name="dp_options[site_desc_font_size]" value="<?php esc_attr_e( $options['site_desc_font_size'] ); ?>" /><span>px</span>
    <p><label><input id="dp_options[show_site_desc]" name="dp_options[show_site_desc]" type="checkbox" value="1" <?php checked( '1', $options['show_site_desc'] ); ?> /> <?php _e('Display site description', 'tcd-w');  ?></label></p>
    </div>
    <h4 class="theme_option_headline2"><?php _e('Image for logo', 'tcd-w');  ?></h4>
    <p><?php _e('If the image is not registered, text will be displayed instead.','tcd-w'); ?></p>
    <p><?php _e('Recommended size, Width:200px Height:200px', 'tcd-w'); ?></p>
    <div class="image_box cf">
     <div class="cf cf_media_field hide-if-no-js header_logo_image">
      <input type="hidden" value="<?php echo esc_attr( $options['header_logo_image'] ); ?>" id="header_logo_image" name="dp_options[header_logo_image]" class="cf_media_id">
      <div class="preview_field"><?php if($options['header_logo_image']){ echo wp_get_attachment_image($options['header_logo_image'], 'full'); }; ?></div>
      <div class="buttton_area">
       <input type="button" value="<?php _e('Select Image', 'tcd-w'); ?>" class="cfmf-select-img button">
       <input type="button" value="<?php _e('Remove Image', 'tcd-w'); ?>" class="cfmf-delete-img button <?php if(!$options['header_logo_image']){ echo 'hidden'; }; ?>">
      </div>
     </div>
    </div>
    <input type="submit" class="button-ml" value="<?php echo __( 'Save Changes', 'tcd-w' ); ?>" />
   </div>

   <?php // ヘッダーのロゴ（モバイル用） ----------------------------------------------------- ?>
   <div class="theme_option_field cf">
    <h3 class="theme_option_headline"><?php _e('Header logo for mobile device', 'tcd-w');  ?></h3>
    <div<?php if(!empty($options['header_logo_image_mobile'])) { echo ' style="display:none;"'; }; ?>>
	<?php echo UI\note(
          [
            sprintf(
              __( '<a href="%s" target="_blank" rel="noopener noreferrer">Site title</a> appears as a logo.','tcd-w' ),
              esc_url( admin_url( '/options-general.php#blogname' ) )
            ),
            __( 'The fonts in the font set (for logos) are reflected.','tcd-w' )
          ]
        ); ?>
    <h4 class="theme_option_headline2"><?php _e('Font size for text logo', 'tcd-w');  ?></h4>
    <input id="dp_options[logo_font_size_mobile]" class="font_size hankaku" type="text" name="dp_options[logo_font_size_mobile]" value="<?php esc_attr_e( $options['logo_font_size_mobile'] ); ?>" /><span>px</span>
    </div>
    <h4 class="theme_option_headline2"><?php _e('Image for logo', 'tcd-w');  ?></h4>
    <p><?php _e('If the image is not registered, text will be displayed instead.','tcd-w'); ?></p>
    <p><?php _e('Recommended size, Width:200px Height:100px', 'tcd-w'); ?></p>
    <div class="image_box cf">
     <div class="cf cf_media_field hide-if-no-js header_logo_image_mobile">
      <input type="hidden" value="<?php echo esc_attr( $options['header_logo_image_mobile'] ); ?>" id="header_logo_image_mobile" name="dp_options[header_logo_image_mobile]" class="cf_media_id">
      <div class="preview_field"><?php if($options['header_logo_image_mobile']){ echo wp_get_attachment_image($options['header_logo_image_mobile'], 'full'); }; ?></div>
      <div class="buttton_area">
       <input type="button" value="<?php _e('Select Image', 'tcd-w'); ?>" class="cfmf-select-img button">
       <input type="button" value="<?php _e('Remove Image', 'tcd-w'); ?>" class="cfmf-delete-img button <?php if(!$options['header_logo_image_mobile']){ echo 'hidden'; }; ?>">
      </div>
     </div>
    </div>
    <input type="submit" class="button-ml" value="<?php echo __( 'Save Changes', 'tcd-w' ); ?>" />
   </div>

   <?php // フッターのロゴ ----------------------------------------------------- ?>
   <div class="theme_option_field cf">
    <h3 class="theme_option_headline"><?php _e('Footer logo', 'tcd-w');  ?></h3>
    <p><?php _e('Footer logo is displayed at the bottom of page except for front page.', 'tcd-w'); ?></p>
    <div<?php if(!empty($options['footer_logo_image'])) { echo ' style="display:none;"'; }; ?>>
	<?php echo UI\note(
          [
            sprintf(
              __( '<a href="%s" target="_blank" rel="noopener noreferrer">Site title</a> appears as a logo.','tcd-w' ),
              esc_url( admin_url( '/options-general.php#blogname' ) )
            ),
            __( 'The fonts in the font set (for logos) are reflected.','tcd-w' )
          ]
        ); ?>
    <h4 class="theme_option_headline2"><?php _e('Font size for text logo', 'tcd-w');  ?></h4>
    <input id="dp_options[logo_font_size_footer]" class="font_size hankaku" type="text" name="dp_options[logo_font_size_footer]" value="<?php esc_attr_e( $options['logo_font_size_footer'] ); ?>" /><span>px</span>
    <h4 class="theme_option_headline2"><?php _e('Font size for site description', 'tcd-w');  ?></h4>
    <input id="dp_options[site_desc_font_size_footer]" class="font_size hankaku" type="text" name="dp_options[site_desc_font_size_footer]" value="<?php esc_attr_e( $options['site_desc_font_size_footer'] ); ?>" /><span>px</span>
    <p><label><input id="dp_options[show_site_desc_footer]" name="dp_options[show_site_desc_footer]" type="checkbox" value="1" <?php checked( '1', $options['show_site_desc_footer'] ); ?> /> <?php _e('Display site description', 'tcd-w');  ?></label></p>
    </div>
    <h4 class="theme_option_headline2"><?php _e('Image for logo', 'tcd-w');  ?></h4>
    <p><?php _e('If the image is not registered, text will be displayed instead.','tcd-w'); ?></p>
    <p><?php _e('Recommended size, Width:300px Height:120px (maximum height:140px), and we recommend you to use the background transparent PNG image.', 'tcd-w'); ?></p>
    <div class="image_box cf">
     <div class="cf cf_media_field hide-if-no-js footer_logo_image">
      <input type="hidden" value="<?php echo esc_attr( $options['footer_logo_image'] ); ?>" id="footer_logo_image" name="dp_options[footer_logo_image]" class="cf_media_id">
      <div class="preview_field"><?php if($options['footer_logo_image']){ echo wp_get_attachment_image($options['footer_logo_image'], 'full'); }; ?></div>
      <div class="buttton_area">
       <input type="button" value="<?php _e('Select Image', 'tcd-w'); ?>" class="cfmf-select-img button">
       <input type="button" value="<?php _e('Remove Image', 'tcd-w'); ?>" class="cfmf-delete-img button <?php if(!$options['footer_logo_image']){ echo 'hidden'; }; ?>">
      </div>
     </div>
    </div>
    <input type="submit" class="button-ml" value="<?php echo __( 'Save Changes', 'tcd-w' ); ?>" />
   </div>

  </div><!-- END #tab-content2 -->

   <!-- #tab-content3 トップページの設定 //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////  -->
    <div id="tab-content3">
		<p style="margin:0 0 30px 0;"><?php _e('Setting the index page. The index page is "1 page scroll specification" to block move whole with a scroll.', 'tcd-w');  ?></p>

		<div class="theme_option_field cf">
		    <h3 class="theme_option_headline"><?php _e('News ticker setting', 'tcd-w');  ?></h3>
		    <p style="margin:0 0 30px 0;"><?php _e('Setting of news ticker to be displayed at the front page.', 'tcd-w');  ?></p>
		    <p><label><input id="dp_options[news_visible]" name="dp_options[news_visible]" type="checkbox" value="1" <?php checked( '1', $options['news_visible'] ); ?> /> <?php _e('Display News ticker at front page', 'tcd-w');  ?></label></p>
		    <p><label><input id="dp_options[fixed_news]" name="dp_options[fixed_news]" type="checkbox" value="1" <?php checked( '1', $options['fixed_news'] ); ?> /> <?php _e('Fix News ticker at the top of front page', 'tcd-w');  ?></label></p>
		    <p><label><input id="dp_options[show_news_date]" name="dp_options[show_news_date]" type="checkbox" value="1" <?php checked( '1', $options['show_news_date'] ); ?> /> <?php _e('Display the date of news', 'tcd-w');  ?></label></p>
		    <h4 class="theme_option_headline2"><?php _e('Number of News ticker', 'tcd-w');  ?></h4>
		    <select name="dp_options[news_count]">
			    <?php dp_numoptions_e(1, 6, $options['news_count']) ?>
		    </select>
		    <h4 class="theme_option_headline2"><?php _e('Label for News archive page button', 'tcd-w');  ?></h4>
		    <input id="dp_options[news_linktext]" class="text" type="text" name="dp_options[news_linktext]" value="<?php esc_attr_e( $options['news_linktext'] ); ?>" />
		    <input type="submit" class="button-ml" value="<?php echo __( 'Save Changes', 'tcd-w' ); ?>" />
		</div>

		<div class="theme_option_field cf">
			<h3 class="theme_option_headline"><?php _e('Settings for scroll contents', 'tcd-w');  ?></h3>
		    <p style="margin:0 0 15px 0;"><?php _e('Setting of scroll contents to be displayed at the front page.', 'tcd-w');  ?></p>
			<h4 class="theme_option_headline2"><?php _e('Setting for Section', 'tcd-w');  ?></h4>
			<div class="topt_repeater_wrapper">
				<div class="topt_repeater" data-delete-confirm="<?php _e('Delete?', 'tcd-w'); ?>">
					<?php
						if ($options['index_section_items']) :
							$i = 1;
							foreach($options['index_section_items'] as $key => $value) :
					?>
					<div class="topt_repeater-row sub_box sub_box cf">
						<h3 class="theme_option_subbox_headline"><?php printf(__('Section%s setting', 'tcd-w'),$i);  ?></h3>
						<div class="sub_box_content">
							<h4 class="theme_option_headline2"><?php _e('Background image', 'tcd-w');  ?></h4>
							<p><?php _e('Recommend image size. Width:1180px, Height:1200px', 'tcd-w');  ?></p>
							<div class="cf cf_media_field hide-if-no-js">
								<input type="hidden" value="<?php echo esc_attr( $value['image'] ); ?>" id="index_section_items-image-<?php echo $key; ?>" name="dp_options[repeater_index_section_items][<?php echo esc_attr( $key ); ?>][image]" class="cf_media_id" />
								<div class="preview_field"><?php if($value['image']){ echo wp_get_attachment_image($value['image'], 'medium'); } ?></div>
								<div class="buttton_area">
									<input type="button" value="<?php _e('Select Image', 'tcd-w'); ?>" class="cfmf-select-img button" />
									<input type="button" value="<?php _e('Remove Image', 'tcd-w'); ?>" class="cfmf-delete-img button <?php if(!$value['image']){ echo 'hidden'; } ?>" />
								</div>
							</div>
							<h4 class="theme_option_headline2"><?php _e('Overlay setting', 'tcd-w');  ?></h4>
							<p class="use_overlay"><label><input type="checkbox" id="index_section_items-use_overlay-<?php echo $key; ?>" name="dp_options[repeater_index_section_items][<?php echo esc_attr( $key ); ?>][use_overlay]" value="1" <?php checked( $value['use_overlay'], 1 ); ?> /> <?php _e('Use overlay on image.', 'tcd-w'); ?></label></p>
							<div class="section_overlay_setting"<?php if( $value['use_overlay'] == 1 ) { echo ' style="display:block;"'; }; ?>>
								<h4 class="theme_option_headline3"><?php _e('Overlay color', 'tcd-w');  ?></h4>
								<p>
									<input type="text" id="index_section_items-overlay-<?php echo $key; ?>" class="color" name="dp_options[repeater_index_section_items][<?php echo esc_attr( $key ); ?>][overlay]" value="<?php echo esc_attr( $value['overlay'] ); ?>" />
									<input type="button" style="margin:0 0 0 5px;" class="button-secondary" value="<?php _e('Default color', 'tcd-w'); ?>" onClick="document.getElementById('index_section_items-overlay-<?php echo $key; ?>').color.fromString('000000')" />
								</p>
								<h4 class="theme_option_headline3"><?php _e('Overlay color transparency', 'tcd-w');  ?></h4>
								<p><?php _e('Please specify the number of 0.1 from 0.9. Overlay color will be more transparent as the number is small.', 'tcd-w');  ?></p>
								<p><input id="index_section_items-overlay_opacity-<?php echo $key; ?>" class="font_size hankaku" type="text" name="dp_options[repeater_index_section_items][<?php echo esc_attr( $key ); ?>][overlay_opacity]" value="<?php echo esc_attr( $value['overlay_opacity'] ); ?>" /></p>
							</div>
							<p class="theme_option_notice"><?php _e('You can set texts for each section.', 'tcd-w'); ?></p>
							<h4 class="theme_option_headline2"><?php _e('Headline setting', 'tcd-w');  ?></h4>
							<p class="use_headline"><label><input type="checkbox" id="index_section_items-use_headline-<?php echo $key; ?>" name="dp_options[repeater_index_section_items][<?php echo esc_attr( $key ); ?>][use_headline]" value="1" <?php checked( $value['use_headline'], 1 ); ?> /> <?php _e('Display headline.', 'tcd-w'); ?></label></p>
							<div class="section_headline_setting"<?php if( $value['use_headline'] == 1 ) { echo ' style="display:block;"'; }; ?>>
								<h4 class="theme_option_headline3"><?php _e('Headline', 'tcd-w');  ?></h4>
								<p><?php _e('Please enter the headline of this section', 'tcd-w'); ?></p>
								<textarea id="index_section_items-headline-<?php echo $key; ?>" name="dp_options[repeater_index_section_items][<?php echo esc_attr( $key ); ?>][headline]" rows="2" class="widefat"><?php echo esc_textarea( $value['headline'] ); ?></textarea>
								<h4 class="theme_option_headline3"><?php _e('Font size', 'tcd-w');  ?></h4>
								<p><input id="index_section_items-headline_fontsize-<?php echo $key; ?>" class="font_size hankaku" type="text" name="dp_options[repeater_index_section_items][<?php echo esc_attr( $key ); ?>][headline_fontsize]" value="<?php echo esc_attr( $value['headline_fontsize'] ); ?>" />px</p>
								<h4 class="theme_option_headline3"><?php _e('Font color', 'tcd-w');  ?></h4>
								<p>
									<input type="text" id="index_section_items-headline_color-<?php echo $key; ?>" class="color" name="dp_options[repeater_index_section_items][<?php echo esc_attr( $key ); ?>][headline_color]" value="<?php echo esc_attr( $value['headline_color'] ); ?>" />
									<input type="button" style="margin:0 0 0 5px;" class="button-secondary" value="<?php _e('Default color', 'tcd-w'); ?>" onClick="document.getElementById('index_section_items-headline_color-<?php echo $key; ?>').color.fromString('FFFFFF')" />
								</p>
								<h4 class="theme_option_headline3"><?php _e('Dropshadow', 'tcd-w');  ?></h4>
								<p><?php _e('Enter "0" if you don\'t want to use dropshadow.', 'tcd-w'); ?></p>
								<ul class="headline_option">
									<li><label style="margin-right:7px;"><?php _e('Dropshadow position (left)', 'tcd-w');  ?></label><input id="index_section_items-dropshadow_h-<?php echo $key; ?>" class="font_size hankaku" type="text" name="dp_options[repeater_index_section_items][<?php echo esc_attr( $key ); ?>][dropshadow_h]" value="<?php echo esc_attr( $value['dropshadow_h'] ); ?>" /><span>px</span></li>
									<li><label style="margin-right:7px;"><?php _e('Dropshadow position (top)', 'tcd-w');  ?></label><input id="index_section_items-dropshadow_v-<?php echo $key; ?>" class="font_size hankaku" type="text" name="dp_options[repeater_index_section_items][<?php echo esc_attr( $key ); ?>][dropshadow_v]" value="<?php echo esc_attr( $value['dropshadow_v'] ); ?>" /><span>px</span></li>
									<li><label style="margin-right:7px;"><?php _e('Dropshadow size', 'tcd-w');  ?></label><input id="index_section_items-dropshadow_b-<?php echo $key; ?>" class="font_size hankaku" type="text" name="dp_options[repeater_index_section_items][<?php echo esc_attr( $key ); ?>][dropshadow_b]" value="<?php echo esc_attr( $value['dropshadow_b'] ); ?>" /><span>px</span></li>
									<li><label style="margin-right:7px;"><?php _e('Dropshadow color', 'tcd-w');  ?></label><input type="text" id="index_section_items-dropshadow_c-<?php echo $key; ?>" class="color" name="dp_options[repeater_index_section_items][<?php echo esc_attr( $key ); ?>][dropshadow_c]" value="<?php echo esc_attr( $value['dropshadow_c'] ); ?>" /><input type="button" style="margin:0 0 0 5px;" class="button-secondary" value="<?php _e('Default color', 'tcd-w');  ?>" onClick="document.getElementById('index_section_items-dropshadow_c-<?php echo $key; ?>').color.fromString('444444')"></li>
								</ul>
							</div>
							<h4 class="theme_option_headline2"><?php _e('Description setting', 'tcd-w');  ?></h4>
							<p class="use_desc"><label><input type="checkbox" id="index_section_items-use_desc-<?php echo $key; ?>" name="dp_options[repeater_index_section_items][<?php echo esc_attr( $key ); ?>][use_desc]" value="1" <?php checked( $value['use_desc'], 1 ); ?> /> <?php _e('Display description.', 'tcd-w'); ?></label></p>
							<div class="section_desc_setting"<?php if( $value['use_desc'] == 1 ) { echo ' style="display:block;"'; }; ?>>
								<h4 class="theme_option_headline3"><?php _e('Description', 'tcd-w');  ?></h4>
								<p><?php _e('Please enter the description displayed below the headline', 'tcd-w'); ?></p>
								<textarea id="index_section_items-desc-<?php echo $key; ?>" name="dp_options[repeater_index_section_items][<?php echo esc_attr( $key ); ?>][desc]" rows="2" class="widefat"><?php echo esc_textarea( $value['desc'] ); ?></textarea>
								<h4 class="theme_option_headline3"><?php _e('Font size', 'tcd-w');  ?></h4>
								<p><input id="index_section_items-desc_fontsize-<?php echo $key; ?>" class="font_size hankaku" type="text" name="dp_options[repeater_index_section_items][<?php echo esc_attr( $key ); ?>][desc_fontsize]" value="<?php echo esc_attr( $value['desc_fontsize'] ); ?>" />px</p>
								<h4 class="theme_option_headline3"><?php _e('Font color', 'tcd-w');  ?></h4>
								<p>
									<input type="text" id="index_section_items-desc_color-<?php echo $key; ?>" class="color" name="dp_options[repeater_index_section_items][<?php echo esc_attr( $key ); ?>][desc_color]" value="<?php echo esc_attr( $value['desc_color'] ); ?>" />
									<input type="button" style="margin:0 0 0 5px;" class="button-secondary" value="<?php _e('Default color', 'tcd-w'); ?>" onClick="document.getElementById('index_section_items-desc_color-<?php echo $key; ?>').color.fromString('FFFFFF')" />
								</p>
								<h4 class="theme_option_headline3"><?php _e('Dropshadow', 'tcd-w');  ?></h4>
								<p><?php _e('Enter "0" if you don\'t want to use dropshadow.', 'tcd-w'); ?></p>
								<ul class="headline_option">
									<li><label style="margin-right:7px;"><?php _e('Dropshadow position (left)', 'tcd-w');  ?></label><input id="index_section_items-dropshadow_desc_h-<?php echo $key; ?>" class="font_size hankaku" type="text" name="dp_options[repeater_index_section_items][<?php echo esc_attr( $key ); ?>][dropshadow_desc_h]" value="<?php echo esc_attr( $value['dropshadow_desc_h'] ); ?>" /><span>px</span></li>
									<li><label style="margin-right:7px;"><?php _e('Dropshadow position (top)', 'tcd-w');  ?></label><input id="index_section_items-dropshadow_desc_v-<?php echo $key; ?>" class="font_size hankaku" type="text" name="dp_options[repeater_index_section_items][<?php echo esc_attr( $key ); ?>][dropshadow_desc_v]" value="<?php echo esc_attr( $value['dropshadow_desc_v'] ); ?>" /><span>px</span></li>
									<li><label style="margin-right:7px;"><?php _e('Dropshadow size', 'tcd-w');  ?></label><input id="index_section_items-dropshadow_desc_b-<?php echo $key; ?>" class="font_size hankaku" type="text" name="dp_options[repeater_index_section_items][<?php echo esc_attr( $key ); ?>][dropshadow_desc_b]" value="<?php echo esc_attr( $value['dropshadow_desc_b'] ); ?>" /><span>px</span></li>
									<li><label style="margin-right:7px;"><?php _e('Dropshadow color', 'tcd-w');  ?></label><input type="text" id="index_section_items-dropshadow_desc_c-<?php echo $key; ?>" class="color" name="dp_options[repeater_index_section_items][<?php echo esc_attr( $key ); ?>][dropshadow_desc_c]" value="<?php echo esc_attr( $value['dropshadow_desc_c'] ); ?>" /><input type="button" style="margin:0 0 0 5px;" class="button-secondary" value="<?php _e('Default color', 'tcd-w');  ?>" onClick="document.getElementById('index_section_items-dropshadow_desc_c-<?php echo $key; ?>').color.fromString('444444')"></li>
								</ul>
							</div>
							<h4 class="theme_option_headline2"><?php _e('Button setting', 'tcd-w');  ?></h4>
							<p class="use_btn"><label><input type="checkbox" id="index_section_items-use_btn-<?php echo $key; ?>" name="dp_options[repeater_index_section_items][<?php echo esc_attr( $key ); ?>][use_btn]" value="1" <?php checked( $value['use_btn'], 1 ); ?> /> <?php _e('Display button.', 'tcd-w'); ?></label></p>
							<div class="section_btn_setting"<?php if( $value['use_btn'] == 1 ) { echo ' style="display:block;"'; }; ?>>
								<h4 class="theme_option_headline3"><?php _e('Button label', 'tcd-w');  ?></h4>
								<p><?php _e('Please enter the button label displayed below the description', 'tcd-w'); ?></p>
								<input type="text" id="index_section_items-btn_label-<?php echo $key; ?>" name="dp_options[repeater_index_section_items][<?php echo esc_attr( $key ); ?>][btn_label]" value="<?php echo esc_attr( $value['btn_label'] ); ?>" class="regular-text" />
								<h4 class="theme_option_headline3"><?php _e('Button Color setting', 'tcd-w');  ?></h4>
								<p class="use_ghost_btn"><label><input type="checkbox" id="index_section_items-use_ghost_btn-<?php echo $key; ?>" name="dp_options[repeater_index_section_items][<?php echo esc_attr( $key ); ?>][use_ghost_btn]" value="1" <?php checked( '1', $value['use_ghost_btn'] ); ?> /> <?php _e('Use this button as a ghost button.', 'tcd-w'); ?></label></p>
								<ul class="headline_option">
									<li><label style="margin-right:7px;"><?php _e('Font color', 'tcd-w');  ?></label><input type="text" id="index_section_items-btn_color-<?php echo $key; ?>" class="color" name="dp_options[repeater_index_section_items][<?php echo esc_attr( $key ); ?>][btn_color]" value="<?php esc_attr_e( $value['btn_color'] ); ?>" /><input type="button" style="margin:0 0 0 5px;" class="button-secondary" value="<?php _e('Default color', 'tcd-w');  ?>" onClick="document.getElementById('index_section_items-btn_color-<?php echo $key; ?>').color.fromString('FFFFFF')"></li>
									<li><label style="margin-right:7px;"><?php _e('Background color', 'tcd-w');  ?></label><input type="text" id="index_section_items-btn_bgcolor-<?php echo $key; ?>" class="color" name="dp_options[repeater_index_section_items][<?php echo esc_attr( $key ); ?>][btn_bgcolor]" value="<?php esc_attr_e( $value['btn_bgcolor'] ); ?>" /><input type="button" style="margin:0 0 0 5px;" class="button-secondary" value="<?php _e('Default color', 'tcd-w');  ?>" onClick="document.getElementById('index_section_items-btn_bgcolor-<?php echo $key; ?>').color.fromString('000000')"></li>
									<li><label style="margin-right:7px;"><?php _e('Border color', 'tcd-w');  ?></label><input type="text" id="index_section_items-btn_bordercolor-<?php echo $key; ?>" class="color" name="dp_options[repeater_index_section_items][<?php echo esc_attr( $key ); ?>][btn_bordercolor]" value="<?php esc_attr_e( $value['btn_bordercolor'] ); ?>" /><input type="button" style="margin:0 0 0 5px;" class="button-secondary" value="<?php _e('Default color', 'tcd-w');  ?>" onClick="document.getElementById('index_section_items-btn_bordercolor-<?php echo $key; ?>').color.fromString('FFFFFF')"></li>
									<li><label style="margin-right:7px;"><?php _e('Font hover color', 'tcd-w');  ?></label><input type="text" id="index_section_items-btn_hover_color-<?php echo $key; ?>" class="color" name="dp_options[repeater_index_section_items][<?php echo esc_attr( $key ); ?>][btn_hover_color]" value="<?php esc_attr_e( $value['btn_hover_color'] ); ?>" /><input type="button" style="margin:0 0 0 5px;" class="button-secondary" value="<?php _e('Default color', 'tcd-w');  ?>" onClick="document.getElementById('index_section_items-btn_hover_color-<?php echo $key; ?>').color.fromString('FFFFFF')"></li>
									<li><label style="margin-right:7px;"><?php _e('Background hover color', 'tcd-w');  ?></label><input type="text" id="index_section_items-btn_hover_bgcolor-<?php echo $key; ?>" class="color" name="dp_options[repeater_index_section_items][<?php echo esc_attr( $key ); ?>][btn_hover_bgcolor]" value="<?php esc_attr_e( $value['btn_hover_bgcolor'] ); ?>" /><input type="button" style="margin:0 0 0 5px;" class="button-secondary" value="<?php _e('Default color', 'tcd-w');  ?>" onClick="document.getElementById('index_section_items-btn_hover_bgcolor-<?php echo $key; ?>').color.fromString('000000')"></li>
									<li><label style="margin-right:7px;"><?php _e('Background hover opacity', 'tcd-w');  ?></label><input id="index_section_items-btn_bg_opacity-<?php echo $key; ?>" class="font_size hankaku" type="text" name="dp_options[repeater_index_section_items][<?php echo esc_attr( $key ); ?>][btn_bg_opacity]" value="<?php echo esc_attr( $value['btn_bg_opacity'] ); ?>" /><input type="button" style="margin:0 0 0 5px;" class="button-secondary" value="<?php _e('Default value', 'tcd-w');  ?>" onClick="document.getElementById('index_section_items-btn_bg_opacity-<?php echo $key; ?>').value='0.5'"></li>
								</ul>
								<h4 class="theme_option_headline3"><?php _e('Link URL', 'tcd-w');  ?></h4>
								<p><?php _e('Leave this field blank if you don\'t want to use link at image.', 'tcd-w');  ?></p>
								<input type="text" id="index_section_items-btn_url-<?php echo $key; ?>" name="dp_options[repeater_index_section_items][<?php echo esc_attr( $key ); ?>][btn_url]" value="<?php echo esc_attr( $value['btn_url'] ); ?>" class="widefat" />
								<p><label><input id="index_section_items-btn_url_target-<?php echo $key; ?>" name="dp_options[repeater_index_section_items][<?php echo esc_attr( $key ); ?>][btn_url_target]" type="checkbox" value="1" <?php checked( $value['btn_url_target'], 1 ); ?> /> <?php _e('Open link in new window', 'tcd-w');  ?></label></p>
							</div>
							<input type="submit" class="button-ml" value="<?php echo __( 'Save Changes', 'tcd-w' ); ?>" />
							<p class="delete-row"><a href="#" class="button button-secondary button-delete-row"><?php _e('Delete item', 'tcd-w'); ?></a></p>
						</div>
					</div>
					<?php
						$i++;
						endforeach;
						endif;
						$key = 'addindex';
						ob_start();
					?>
					<div id="topt_repeater-<?php echo $key; ?>" class="topt_repeater-row sub_box cf">
						<h3 class="theme_option_subbox_headline"><?php _e('Added section', 'tcd-w'); ?></h3>
						<div class="sub_box_content">
							<h4 class="theme_option_headline2"><?php _e('Background image', 'tcd-w');  ?></h4>
							<p><?php _e('Recommend image size. Width:1180px, Height:1200px', 'tcd-w');  ?></p>
							<div class="cf cf_media_field hide-if-no-js">
								<input type="hidden" value="<?php echo esc_attr( $value['image'] ); ?>" id="index_section_items-image-<?php echo $key; ?>" name="dp_options[repeater_index_section_items][<?php echo esc_attr( $key ); ?>][image]" class="cf_media_id" />
								<div class="preview_field"></div>
								<div class="buttton_area">
									<input type="button" value="<?php _e('Select Image', 'tcd-w'); ?>" class="cfmf-select-img button" />
									<input type="button" value="<?php _e('Remove Image', 'tcd-w'); ?>" class="cfmf-delete-img button <?php if(!$value['image']){ echo 'hidden'; } ?>" />
								</div>
							</div>
							<h4 class="theme_option_headline2"><?php _e('Overlay setting', 'tcd-w');  ?></h4>
							<p class="use_overlay"><label><input type="checkbox" id="index_section_items-use_overlay-<?php echo $key; ?>" name="dp_options[repeater_index_section_items][<?php echo esc_attr( $key ); ?>][use_overlay]" value="1" /> <?php _e('Use overlay on image.', 'tcd-w'); ?></label></p>
							<div class="section_overlay_setting">
								<h4 class="theme_option_headline3"><?php _e('Overlay color', 'tcd-w');  ?></h4>
								<p>
									<input type="text" id="index_section_items-overlay-<?php echo $key; ?>" class="color" name="dp_options[repeater_index_section_items][<?php echo esc_attr( $key ); ?>][overlay]" value="000000" />
									<input type="button" style="margin:0 0 0 5px;" class="button-secondary" value="<?php _e('Default color', 'tcd-w'); ?>" onClick="document.getElementById('index_section_items-overlay-<?php echo $key; ?>').color.fromString('000000')" />
								</p>
								<h4 class="theme_option_headline3"><?php _e('Overlay color transparency', 'tcd-w');  ?></h4>
								<p><?php _e('Please specify the number of 0.1 from 0.9. Overlay color will be more transparent as the number is small.', 'tcd-w');  ?></p>
								<p><input id="index_section_items-overlay_opacity-<?php echo $key; ?>" class="font_size hankaku" type="text" name="dp_options[repeater_index_section_items][<?php echo esc_attr( $key ); ?>][overlay_opacity]" value="0.5" /></p>
							</div>
							<p class="theme_option_notice"><?php _e('You can set texts for each section.', 'tcd-w'); ?></p>
							<h4 class="theme_option_headline2"><?php _e('Headline setting', 'tcd-w');  ?></h4>
							<p class="use_headline"><label><input type="checkbox" id="index_section_items-use_headline-<?php echo $key; ?>" name="dp_options[repeater_index_section_items][<?php echo esc_attr( $key ); ?>][use_headline]" value="1" /> <?php _e('Display headline.', 'tcd-w'); ?></label></p>
							<div class="section_headline_setting">
								<h4 class="theme_option_headline3"><?php _e('Headline', 'tcd-w');  ?></h4>
								<p><?php _e('Please enter the headline of this section', 'tcd-w'); ?></p>
								<textarea id="index_section_items-headline-<?php echo $key; ?>" name="dp_options[repeater_index_section_items][<?php echo esc_attr( $key ); ?>][headline]" rows="2" class="widefat"></textarea>
								<h4 class="theme_option_headline3"><?php _e('Font size', 'tcd-w');  ?></h4>
								<p><input id="index_section_items-headline_fontsize-<?php echo $key; ?>" class="font_size hankaku" type="text" name="dp_options[repeater_index_section_items][<?php echo esc_attr( $key ); ?>][headline_fontsize]" value="42" />px</p>
								<h4 class="theme_option_headline3"><?php _e('Font color', 'tcd-w');  ?></h4>
								<p>
									<input type="text" id="index_section_items-headline_color-<?php echo $key; ?>" class="color" name="dp_options[repeater_index_section_items][<?php echo esc_attr( $key ); ?>][headline_color]" value="FFFFFF" />
									<input type="button" style="margin:0 0 0 5px;" class="button-secondary" value="<?php _e('Default color', 'tcd-w'); ?>" onClick="document.getElementById('index_section_items-headline_color-<?php echo $key; ?>').color.fromString('FFFFFF')" />
								</p>
								<h4 class="theme_option_headline3"><?php _e('Dropshadow', 'tcd-w');  ?></h4>
								<p><?php _e('Enter "0" if you don\'t want to use dropshadow.', 'tcd-w'); ?></p>
								<ul class="headline_option">
									<li><label style="margin-right:7px;"><?php _e('Dropshadow position (left)', 'tcd-w');  ?></label><input id="index_section_items-dropshadow_h-<?php echo $key; ?>" class="font_size hankaku" type="text" name="dp_options[repeater_index_section_items][<?php echo esc_attr( $key ); ?>][dropshadow_h]" value="1" /><span>px</span></li>
									<li><label style="margin-right:7px;"><?php _e('Dropshadow position (top)', 'tcd-w');  ?></label><input id="index_section_items-dropshadow_v-<?php echo $key; ?>" class="font_size hankaku" type="text" name="dp_options[repeater_index_section_items][<?php echo esc_attr( $key ); ?>][dropshadow_v]" value="1" /><span>px</span></li>
									<li><label style="margin-right:7px;"><?php _e('Dropshadow size', 'tcd-w');  ?></label><input id="index_section_items-dropshadow_b-<?php echo $key; ?>" class="font_size hankaku" type="text" name="dp_options[repeater_index_section_items][<?php echo esc_attr( $key ); ?>][dropshadow_b]" value="5" /><span>px</span></li>
									<li><label style="margin-right:7px;"><?php _e('Dropshadow color', 'tcd-w');  ?></label><input type="text" id="index_section_items-dropshadow_c-<?php echo $key; ?>" class="color" name="dp_options[repeater_index_section_items][<?php echo esc_attr( $key ); ?>][dropshadow_c]" value="444444" /><input type="button" style="margin:0 0 0 5px;" class="button-secondary" value="<?php _e('Default color', 'tcd-w');  ?>" onClick="document.getElementById('index_section_items-dropshadow_c-<?php echo $key; ?>').color.fromString('444444')"></li>
								</ul>
							</div>
							<h4 class="theme_option_headline2"><?php _e('Description setting', 'tcd-w');  ?></h4>
							<p class="use_desc"><label><input type="checkbox" id="index_section_items-use_desc-<?php echo $key; ?>" name="dp_options[repeater_index_section_items][<?php echo esc_attr( $key ); ?>][use_desc]" value="1" /> <?php _e('Display description.', 'tcd-w'); ?></label></p>
							<div class="section_desc_setting">
								<h4 class="theme_option_headline3"><?php _e('Description', 'tcd-w');  ?></h4>
								<p><?php _e('Please enter the description displayed below the headline', 'tcd-w'); ?></p>
								<textarea id="index_section_items-desc-<?php echo $key; ?>" name="dp_options[repeater_index_section_items][<?php echo esc_attr( $key ); ?>][desc]" rows="2" class="widefat"></textarea>
								<h4 class="theme_option_headline3"><?php _e('Font size', 'tcd-w');  ?></h4>
								<p><input id="index_section_items-desc_fontsize-<?php echo $key; ?>" class="font_size hankaku" type="text" name="dp_options[repeater_index_section_items][<?php echo esc_attr( $key ); ?>][desc_fontsize]" value="14" />px</p>
								<h4 class="theme_option_headline3"><?php _e('Font color', 'tcd-w');  ?></h4>
								<p>
									<input type="text" id="index_section_items-desc_color-<?php echo $key; ?>" class="color" name="dp_options[repeater_index_section_items][<?php echo esc_attr( $key ); ?>][desc_color]" value="FFFFFF" />
									<input type="button" style="margin:0 0 0 5px;" class="button-secondary" value="<?php _e('Default color', 'tcd-w'); ?>" onClick="document.getElementById('index_section_items-desc_color-<?php echo $key; ?>').color.fromString('FFFFFF')" />
								</p>
								<h4 class="theme_option_headline3"><?php _e('Dropshadow', 'tcd-w');  ?></h4>
								<p><?php _e('Enter "0" if you don\'t want to use dropshadow.', 'tcd-w'); ?></p>
								<ul class="headline_option">
									<li><label style="margin-right:7px;"><?php _e('Dropshadow position (left)', 'tcd-w');  ?></label><input id="index_section_items-dropshadow_desc_h-<?php echo $key; ?>" class="font_size hankaku" type="text" name="dp_options[repeater_index_section_items][<?php echo esc_attr( $key ); ?>][dropshadow_desc_h]" value="0" /><span>px</span></li>
									<li><label style="margin-right:7px;"><?php _e('Dropshadow position (top)', 'tcd-w');  ?></label><input id="index_section_items-dropshadow_desc_v-<?php echo $key; ?>" class="font_size hankaku" type="text" name="dp_options[repeater_index_section_items][<?php echo esc_attr( $key ); ?>][dropshadow_desc_v]" value="0" /><span>px</span></li>
									<li><label style="margin-right:7px;"><?php _e('Dropshadow size', 'tcd-w');  ?></label><input id="index_section_items-dropshadow_desc_b-<?php echo $key; ?>" class="font_size hankaku" type="text" name="dp_options[repeater_index_section_items][<?php echo esc_attr( $key ); ?>][dropshadow_desc_b]" value="0" /><span>px</span></li>
									<li><label style="margin-right:7px;"><?php _e('Dropshadow color', 'tcd-w');  ?></label><input type="text" id="index_section_items-dropshadow_desc_c-<?php echo $key; ?>" class="color" name="dp_options[repeater_index_section_items][<?php echo esc_attr( $key ); ?>][dropshadow_desc_c]" value="444444" /><input type="button" style="margin:0 0 0 5px;" class="button-secondary" value="<?php _e('Default color', 'tcd-w');  ?>" onClick="document.getElementById('index_section_items-dropshadow_desc_c-<?php echo $key; ?>').color.fromString('444444')"></li>
								</ul>
							</div>
							<h4 class="theme_option_headline2"><?php _e('Button setting', 'tcd-w');  ?></h4>
							<p class="use_btn"><label><input type="checkbox" id="index_section_items-use_btn-<?php echo $key; ?>" name="dp_options[repeater_index_section_items][<?php echo esc_attr( $key ); ?>][use_btn]" value="1" /> <?php _e('Display button.', 'tcd-w'); ?></label></p>
							<div class="section_btn_setting">
								<h4 class="theme_option_headline3"><?php _e('Button label', 'tcd-w');  ?></h4>
								<p><?php _e('Please enter the button label displayed below the description', 'tcd-w'); ?></p>
								<input type="text" id="index_section_items-btn_label-<?php echo $key; ?>" name="dp_options[repeater_index_section_items][<?php echo esc_attr( $key ); ?>][btn_label]" value="" class="regular-text" />
								<h4 class="theme_option_headline3"><?php _e('Button Color setting', 'tcd-w');  ?></h4>
								<p class="use_ghost_btn"><label><input type="checkbox" id="index_section_items-use_ghost_btn-<?php echo $key; ?>" name="dp_options[repeater_index_section_items][<?php echo esc_attr( $key ); ?>][use_ghost_btn]" value="1" /> <?php _e('Use this button as a ghost button.', 'tcd-w'); ?></label></p>
								<ul class="headline_option">
									<li><label style="margin-right:7px;"><?php _e('Font color', 'tcd-w');  ?></label><input type="text" id="index_section_items-btn_color-<?php echo $key; ?>" class="color" name="dp_options[repeater_index_section_items][<?php echo esc_attr( $key ); ?>][btn_color]" value="FFFFFF" /><input type="button" style="margin:0 0 0 5px;" class="button-secondary" value="<?php _e('Default color', 'tcd-w');  ?>" onClick="document.getElementById('index_section_items-btn_color-<?php echo $key; ?>').color.fromString('FFFFFF')"></li>
									<li><label style="margin-right:7px;"><?php _e('Background color', 'tcd-w');  ?></label><input type="text" id="index_section_items-btn_bgcolor-<?php echo $key; ?>" class="color" name="dp_options[repeater_index_section_items][<?php echo esc_attr( $key ); ?>][btn_bgcolor]" value="000000" /><input type="button" style="margin:0 0 0 5px;" class="button-secondary" value="<?php _e('Default color', 'tcd-w');  ?>" onClick="document.getElementById('index_section_items-btn_bgcolor-<?php echo $key; ?>').color.fromString('000000')"></li>
									<li><label style="margin-right:7px;"><?php _e('Border color', 'tcd-w');  ?></label><input type="text" id="index_section_items-btn_bordercolor-<?php echo $key; ?>" class="color" name="dp_options[repeater_index_section_items][<?php echo esc_attr( $key ); ?>][btn_bordercolor]" value="FFFFFF" /><input type="button" style="margin:0 0 0 5px;" class="button-secondary" value="<?php _e('Default color', 'tcd-w');  ?>" onClick="document.getElementById('index_section_items-btn_bordercolor-<?php echo $key; ?>').color.fromString('FFFFFF')"></li>
									<li><label style="margin-right:7px;"><?php _e('Font hover color', 'tcd-w');  ?></label><input type="text" id="index_section_items-btn_hover_color-<?php echo $key; ?>" class="color" name="dp_options[repeater_index_section_items][<?php echo esc_attr( $key ); ?>][btn_hover_color]" value="FFFFFF" /><input type="button" style="margin:0 0 0 5px;" class="button-secondary" value="<?php _e('Default color', 'tcd-w');  ?>" onClick="document.getElementById('index_section_items-btn_hover_color-<?php echo $key; ?>').color.fromString('FFFFFF')"></li>
									<li><label style="margin-right:7px;"><?php _e('Background hover color', 'tcd-w');  ?></label><input type="text" id="index_section_items-btn_hover_bgcolor-<?php echo $key; ?>" class="color" name="dp_options[repeater_index_section_items][<?php echo esc_attr( $key ); ?>][btn_hover_bgcolor]" value="000000" /><input type="button" style="margin:0 0 0 5px;" class="button-secondary" value="<?php _e('Default color', 'tcd-w');  ?>" onClick="document.getElementById('index_section_items-btn_hover_bgcolor-<?php echo $key; ?>').color.fromString('000000')"></li>
									<li><label style="margin-right:7px;"><?php _e('Background hover opacity', 'tcd-w');  ?></label><input id="index_section_items-btn_bg_opacity-<?php echo $key; ?>" class="font_size hankaku" type="text" name="dp_options[repeater_index_section_items][<?php echo esc_attr( $key ); ?>][btn_bg_opacity]" value="0.5" /><input type="button" style="margin:0 0 0 5px;" class="button-secondary" value="<?php _e('Default value', 'tcd-w');  ?>" onClick="document.getElementById('index_section_items-btn_bg_opacity-<?php echo $key; ?>').value='0.5'"></li>
								</ul>
								<h4 class="theme_option_headline3"><?php _e('Link URL', 'tcd-w');  ?></h4>
								<p><?php _e('Leave this field blank if you don\'t want to use link at image.', 'tcd-w');  ?></p>
								<input type="text" id="index_section_items-btn_url-<?php echo $key; ?>" name="dp_options[repeater_index_section_items][<?php echo esc_attr( $key ); ?>][btn_url]" value="" class="widefat" />
								<p><label><input id="index_section_items-btn_url_target-<?php echo $key; ?>" name="dp_options[repeater_index_section_items][<?php echo esc_attr( $key ); ?>][btn_url_target]" type="checkbox" value="1" /> <?php _e('Open link in new window', 'tcd-w');  ?></label></p>
							</div>
							<input type="submit" class="button-ml" value="<?php echo __( 'Save Changes', 'tcd-w' ); ?>" />
							<p class="delete-row"><a href="#" class="button button-secondary button-delete-row"><?php _e('Delete item', 'tcd-w'); ?></a></p>
						</div>
					</div>
					<?php
						$clone = ob_get_clean();
					?>
				</div>
				<a href="#" class="button button-secondary button-add-row" data-clone="<?php echo esc_attr($clone); ?>"><?php _e('Add item', 'tcd-w'); ?></a>
			</div>
			<h4 class="theme_option_headline2"><?php _e('Setting for Scroll', 'tcd-w');  ?></h4>
			<p><?php _e('If you wish to disable scrolling direction, check the box below.', 'tcd-w');  ?></p>
			<p style="margin:0 0 30px 0;"><label><input id="dp_options[front_scroll_no_animation]" name="dp_options[front_scroll_no_animation]" type="checkbox" value="1" <?php checked( '1', $options['front_scroll_no_animation'] ); ?> /> <?php _e('Turn off scrolling direction', 'tcd-w');  ?></label></p>
			<input type="submit" class="button-ml" value="<?php echo __( 'Save Changes', 'tcd-w' ); ?>" />
		</div>
		<!-- トップページ・ブログ -->
		<div class="theme_option_field cf">
			<h3 class="theme_option_headline"><?php _e('Blog content', 'tcd-w');  ?></h3>
			<p style="margin:0 0 30px 0;"><?php _e('Setting of blog content to be displayed at the front page.', 'tcd-w');  ?></p>
		    <p><label><input id="dp_options[show_index_blog]" name="dp_options[show_index_blog]" type="checkbox" value="1" <?php checked( '1', $options['show_index_blog'] ); ?> /> <?php _e('Display blog contents at front page', 'tcd-w');  ?></label></p>
			<h4 class="theme_option_headline2"><?php _e('Headline of Blog list', 'tcd-w');  ?></h4>
			<input id="dp_options[front_blog_headline]" class="regular-text" type="text" name="dp_options[front_blog_headline]" value="<?php esc_attr_e( $options['front_blog_headline'] ); ?>" />
			<h4><?php _e('Font size', 'tcd-w');  ?></h4>
			<input id="dp_options[front_blog_headline_fontsize]" class="font_size hankaku" type="text" name="dp_options[front_blog_headline_fontsize]" value="<?php esc_attr_e( $options['front_blog_headline_fontsize'] ); ?>" />px
			<h4><?php _e('Font color', 'tcd-w');  ?></h4>
			<input type="text" id="front_blog_headline_color" class="color" name="dp_options[front_blog_headline_color]" value="<?php esc_attr_e( $options['front_blog_headline_color'] ); ?>" />
			<input type="button" style="margin:2px 0 0 15px;" class="button-secondary" value="<?php _e('Default color', 'tcd-w');  ?>" onClick="document.getElementById('front_blog_headline_color').color.fromString('FFFFFF')">
			<h4 class="theme_option_headline2"><?php _e('Number of post to show at Blog list', 'tcd-w');  ?></h4>
			<select name="dp_options[front_blog_count]">
				<?php dp_numoptions_e(2, 6, $options['front_blog_count'], 2) ?>
			</select>
			<h4 class="theme_option_headline2"><?php _e('Label for Blog archive page button', 'tcd-w');  ?></h4>
			<input id="dp_options[front_blog_linktext]" class="regular-text" type="text" name="dp_options[front_blog_linktext]" value="<?php esc_attr_e( $options['front_blog_linktext'] ); ?>" />
			<h4 class="theme_option_headline2"><?php _e('Background color of Blog list', 'tcd-w');  ?></h4>
			<input type="text" id="front_blog_bgcolor" class="color" name="dp_options[front_blog_bgcolor]" value="<?php esc_attr_e( $options['front_blog_bgcolor'] ); ?>" />
			<input type="button" style="margin:2px 0 0 15px;" class="button-secondary" value="<?php _e('Default color', 'tcd-w');  ?>" onClick="document.getElementById('front_blog_bgcolor').color.fromString('222222')">
			<input type="submit" class="button-ml" value="<?php echo __( 'Save Changes', 'tcd-w' ); ?>" />
		</div>
		<!-- トップページ・フリースペース -->
		<div class="theme_option_field cf">
			<h3 class="theme_option_headline"><?php _e('Free Space', 'tcd-w');  ?></h3>
			<p style="margin:0 0 30px 0;"><?php _e('Setting of Fixed Page content to be displayed at the front page.', 'tcd-w');  ?></p>
		    <p><label><input id="dp_options[show_index_freespace]" name="dp_options[show_index_freespace]" type="checkbox" value="1" <?php checked( '1', $options['show_index_freespace'] ); ?> /> <?php _e('Display Free Space at front page', 'tcd-w');  ?></label></p>
			<h4 class="theme_option_headline2"><?php _e('Headline of Free Space', 'tcd-w');  ?></h4>
			<input id="dp_options[front_freespace_headline]" class="regular-text" type="text" name="dp_options[front_freespace_headline]" value="<?php esc_attr_e( $options['front_freespace_headline'] ); ?>" />
			<h4><?php _e('Font size', 'tcd-w');  ?></h4>
			<input id="dp_options[front_freespace_headline_fontsize]" class="font_size hankaku" type="text" name="dp_options[front_freespace_headline_fontsize]" value="<?php esc_attr_e( $options['front_freespace_headline_fontsize'] ); ?>" />px
			<h4><?php _e('Font color', 'tcd-w');  ?></h4>
			<input type="text" id="front_freespace_headline_color" class="color" name="dp_options[front_freespace_headline_color]" value="<?php esc_attr_e( $options['front_freespace_headline_color'] ); ?>" />
			<input type="button" style="margin:2px 0 0 15px;" class="button-secondary" value="<?php _e('Default color', 'tcd-w');  ?>" onClick="document.getElementById('front_freespace_headline_color').color.fromString('000000')">
			<h4 class="theme_option_headline2"><?php _e('Background color of Free Space', 'tcd-w');  ?></h4>
			<input type="text" id="front_freespace_bgcolor" class="color" name="dp_options[front_freespace_bgcolor]" value="<?php esc_attr_e( $options['front_freespace_bgcolor'] ); ?>" />
			<input type="button" style="margin:2px 0 0 15px;" class="button-secondary" value="<?php _e('Default color', 'tcd-w');  ?>" onClick="document.getElementById('front_freespace_bgcolor').color.fromString('FFFFFF')">
			<h4 class="theme_option_headline2"><?php _e('Contents of Free Space', 'tcd-w');  ?></h4>
			<?php
			wp_editor(
				$options['front_freespace_editor'],
				'front_freespace_editor',
				array(
				'textarea_name' => 'dp_options[front_freespace_editor]',
				'textarea_rows' => 10
				)
			);
			?>
			<input type="submit" class="button-ml" value="<?php echo __( 'Save Changes', 'tcd-w' ); ?>" />
		</div>
  </div><!-- END #tab-content3 -->


	<!-- #tab-content4 ブログページ //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////  -->
	<div id="tab-content4">
		<p style="margin:0 0 30px 0;"><?php _e('Setting the Blog Archive page and blog post page.', 'tcd-w');  ?></p>

		<?php // ヘッダーの画像 -------------------------------------------------------------------------------------------- ?>
		<div class="theme_option_field cf">
			<h3 class="theme_option_headline"><?php _e('Header image', 'tcd-w');  ?></h3>
			<p><?php _e('Recommend image size. Width:1180px, Height:550px', 'tcd-w');  ?></p>
			<div class="image_box cf">
				<div class="cf cf_media_field hide-if-no-js blog_image">
					<input type="hidden" value="<?php echo esc_attr( $options['blog_image'] ); ?>" id="blog_image" name="dp_options[blog_image]" class="cf_media_id">
					<div class="preview_field"><?php if($options['blog_image']){ echo wp_get_attachment_image($options['blog_image'], 'medium'); }; ?></div>
					<div class="buttton_area">
						<input type="button" value="<?php _e('Select Image', 'tcd-w'); ?>" class="cfmf-select-img button">
						<input type="button" value="<?php _e('Remove Image', 'tcd-w'); ?>" class="cfmf-delete-img button <?php if(!$options['blog_image']){ echo 'hidden'; }; ?>">
					</div>
				</div>
			</div>
			<input type="submit" class="button-ml" value="<?php echo __( 'Save Changes', 'tcd-w' ); ?>" />
		</div>

		<?php // キャッチフレーズ ----------------------------------------------------------------------------- ?>
		<div class="theme_option_field cf">
			<h3 class="theme_option_headline"><?php _e('Header catchphrase', 'tcd-w');  ?></h3>
			<h4 class="theme_option_headline2"><?php _e('Catchphrase', 'tcd-w');  ?></h4>
			<input id="dp_options[blog_headline]" class="regular-text" type="text" name="dp_options[blog_headline]" value="<?php esc_attr_e( $options['blog_headline'] ); ?>" />
			<h4 class="theme_option_headline2"><?php _e('Font size', 'tcd-w');  ?></h4>
			<p><input id="dp_options[blog_headline_font_size]" class="font_size hankaku" type="text" name="dp_options[blog_headline_font_size]" value="<?php esc_attr_e( $options['blog_headline_font_size'] ); ?>" /><span>px</span></p>
			<h4 class="theme_option_headline2"><?php _e('Font color', 'tcd-w');  ?></h4>
			<input type="text" id="blog_headline_color" class="color" name="dp_options[blog_headline_color]" value="<?php esc_attr_e( $options['blog_headline_color'] ); ?>" />
			<input type="button" style="margin:0 0 0 5px;" class="button-secondary" value="<?php _e('Default color', 'tcd-w');  ?>" onClick="document.getElementById('blog_headline_color').color.fromString('FFFFFF')">
			<h4 class="theme_option_headline2"><?php _e('Dropshadow', 'tcd-w');  ?></h4>
			<ul class="headline_option">
				<li><label><?php _e('Dropshadow position (left)', 'tcd-w');  ?></label><input id="dp_options[blog_headline_shadow1]" class="font_size hankaku" type="text" name="dp_options[blog_headline_shadow1]" value="<?php esc_attr_e( $options['blog_headline_shadow1'] ); ?>" /><span>px</span></li>
				<li><label><?php _e('Dropshadow position (top)', 'tcd-w');  ?></label><input id="dp_options[blog_headline_shadow2]" class="font_size hankaku" type="text" name="dp_options[blog_headline_shadow2]" value="<?php esc_attr_e( $options['blog_headline_shadow2'] ); ?>" /><span>px</span></li>
				<li><label><?php _e('Dropshadow size', 'tcd-w');  ?></label><input id="dp_options[blog_headline_shadow3]" class="font_size hankaku" type="text" name="dp_options[blog_headline_shadow3]" value="<?php esc_attr_e( $options['blog_headline_shadow3'] ); ?>" /><span>px</span></li>
				<li><label><?php _e('Dropshadow color', 'tcd-w');  ?></label><input type="text" id="blog_headline_shadow_color" class="color" name="dp_options[blog_headline_shadow_color]" value="<?php esc_attr_e( $options['blog_headline_shadow_color'] ); ?>" /><input type="button" style="margin:0 0 0 5px;" class="button-secondary" value="<?php _e('Default color', 'tcd-w');  ?>" onClick="document.getElementById('blog_headline_shadow_color').color.fromString('333333')"></li>
			</ul>
			<h4 class="theme_option_headline2"><?php _e('Description', 'tcd-w');  ?></h4>
			<textarea id="dp_options[blog_content]" class="large-text" cols="10" rows="2" name="dp_options[blog_content]"><?php echo esc_textarea( $options['blog_content'] ); ?></textarea>
			<input type="submit" class="button-ml" value="<?php echo __( 'Save Changes', 'tcd-w' ); ?>" />
		</div>

		<?php // フォントサイズ ?>
		<div class="theme_option_field cf">
			<h3 class="theme_option_headline"><?php _e('Font size', 'tcd-w');  ?></h3>
			<h4 class="theme_option_headline2"><?php _e('Font size of post title in archive page', 'tcd-w');  ?></h4>
			<input id="dp_options[archive_title_font_size]" class="font_size hankaku" type="text" name="dp_options[archive_title_font_size]" value="<?php esc_attr_e( $options['archive_title_font_size'] ); ?>" /><span>px</span>
			<h4 class="theme_option_headline2"><?php _e('Font size of post title in single page', 'tcd-w');  ?></h4>
			<input id="dp_options[title_font_size]" class="font_size hankaku" type="text" name="dp_options[title_font_size]" value="<?php esc_attr_e( $options['title_font_size'] ); ?>" /><span>px</span>
			<h4 class="theme_option_headline2"><?php _e('Font size of post contents in single page', 'tcd-w');  ?></h4>
			<input id="dp_options[content_font_size]" class="font_size hankaku" type="text" name="dp_options[content_font_size]" value="<?php esc_attr_e( $options['content_font_size'] ); ?>" /><span>px</span>
			<input type="submit" class="button-ml" value="<?php echo __( 'Save Changes', 'tcd-w' ); ?>" />
		</div>

		<?php // 投稿者名・タグ・コメント ?>
		<div class="theme_option_field cf">
			<h3 class="theme_option_headline"><?php _e('Display setting', 'tcd-w');  ?></h3>
			<h4 class="theme_option_headline2"><?php _e('Post list of the top and archive page', 'tcd-w');  ?></h4>
			<ul>
				<li><label><input id="dp_options[archive_show_date]" name="dp_options[archive_show_date]" type="checkbox" value="1" <?php checked( '1', $options['archive_show_date'] ); ?> /> <?php _e('Display date', 'tcd-w');  ?></label></li>
				<li><label><input id="dp_options[archive_show_category]" name="dp_options[archive_show_category]" type="checkbox" value="1" <?php checked( '1', $options['archive_show_category'] ); ?> /> <?php _e('Display category', 'tcd-w');  ?></label></li>
			</ul>
			<h4 class="theme_option_headline2"><?php _e('Post page', 'tcd-w');  ?></h4>
			<ul>
				<li><label><input id="dp_options[show_date]" name="dp_options[show_date]" type="checkbox" value="1" <?php checked( '1', $options['show_date'] ); ?> /> <?php _e('Display date', 'tcd-w');  ?></label></li>
				<li><label><input id="dp_options[show_author]" name="dp_options[show_author]" type="checkbox" value="1" <?php checked( '1', $options['show_author'] ); ?> /> <?php _e('Display author', 'tcd-w');  ?></label></li>
				<li><label><input id="dp_options[show_thumbnail]" name="dp_options[show_thumbnail]" type="checkbox" value="1" <?php checked( '1', $options['show_thumbnail'] ); ?> /> <?php _e('Display thumbnail', 'tcd-w');  ?></label></li>
				<li><label><input id="dp_options[show_next_post]" name="dp_options[show_next_post]" type="checkbox" value="1" <?php checked( '1', $options['show_next_post'] ); ?> /> <?php _e('Display next previous post link', 'tcd-w');  ?></label></li>
				<li><label><input id="dp_options[show_related_post]" name="dp_options[show_related_post]" type="checkbox" value="1" <?php checked( '1', $options['show_related_post'] ); ?> /> <?php _e('Display related post', 'tcd-w');  ?></label></li>
				<li><label><input id="dp_options[show_comment]" name="dp_options[show_comment]" type="checkbox" value="1" <?php checked( '1', $options['show_comment'] ); ?> /> <?php _e('Display comment and trackback', 'tcd-w');  ?></label></li>
			</ul>
			<input type="submit" class="button-ml" value="<?php echo __( 'Save Changes', 'tcd-w' ); ?>" />
		</div>

		<?php // NEWソーシャルボタン  ------------------------------------------------------------------ ?>
		<div class="theme_option_field cf">
			<h3 class="theme_option_headline"><?php _e('Social button Setup', 'tcd-w');  ?></h3>
			<div class="theme_option_input">
				<h4 class="theme_option_headline2"><?php _e('Set of articles top buttons', 'tcd-w');  ?></h4>

				<label><input id="dp_options[show_sns_top]" name="dp_options[show_sns_top]" type="checkbox" value="1" <?php checked( '1', $options['show_sns_top'] ); ?> /> <?php _e('Buttons to the article top', 'tcd-w');  ?></label>

				<h4 class="theme_option_headline2"><?php _e('Type of button on article top', 'tcd-w');  ?></h4>
				<fieldset class="cf">
					<ul class="cf">
						<?php
						if ( ! isset( $checked ) )
							$checked = '';
						foreach ( $sns_type_top_options as $option ) {
							$sns_type_top_setting = $options['sns_type_top'];
							if ( '' != $sns_type_top_setting ) {
								if ( $options['sns_type_top'] == $option['value'] ) {
									$checked = "checked=\"checked\"";
								} else {
									$checked = '';
								}
							}
							?>
							<li>
								<label>
									<input type="radio" name="dp_options[sns_type_top]" value="<?php esc_attr_e( $option['value'] ); ?>" <?php echo $checked; ?> />
									<?php _e($option['label'], 'tcd-w'); ?>
								</label>
							</li>
							<?php
						}
						?>
					</ul>
				</fieldset>
				<h4 class="theme_option_headline2"><?php _e('Select the social button to show on article top', 'tcd-w');  ?></h4>
				<ul>
					<li><label><input id="dp_options[show_twitter_top]" name="dp_options[show_twitter_top]" type="checkbox" value="1" <?php checked( '1', $options['show_twitter_top'] ); ?> /> <?php _e('Display X button', 'tcd-w');  ?></label></li>
					<li><label><input id="dp_options[show_fblike_top]" name="dp_options[show_fblike_top]" type="checkbox" value="1" <?php checked( '1', $options['show_fblike_top'] ); ?> /> <?php _e('Display facebook like button -Button type 5 (Default button) only', 'tcd-w');  ?></label></li>
					<li><label><input id="dp_options[show_fbshare_top]" name="dp_options[show_fbshare_top]" type="checkbox" value="1" <?php checked( '1', $options['show_fbshare_top'] ); ?> /> <?php _e('Display facebook share button', 'tcd-w');  ?></label></li>
					<li><label><input id="dp_options[show_hatena_top]" name="dp_options[show_hatena_top]" type="checkbox" value="1" <?php checked( '1', $options['show_hatena_top'] ); ?> /> <?php _e('Display hatena button', 'tcd-w');  ?></label></li>
					<li><label><input id="dp_options[show_line_top]" name="dp_options[show_line_top]" type="checkbox" value="1" <?php checked( '1', $options['show_line_top'] ); ?> /> <?php _e('Display LINE button', 'tcd-w');  ?></label></li>
					<li><label><input id="dp_options[show_feedly_top]" name="dp_options[show_feedly_top]" type="checkbox" value="1" <?php checked( '1', $options['show_feedly_top'] ); ?> /> <?php _e('Display feedly button', 'tcd-w');  ?></label></li>
					<li><label><input id="dp_options[show_rss_top]" name="dp_options[show_rss_top]" type="checkbox" value="1" <?php checked( '1', $options['show_rss_top'] ); ?> /> <?php _e('Display rss button', 'tcd-w');  ?></label></li>
					<li><label><input id="dp_options[show_pinterest_top]" name="dp_options[show_pinterest_top]" type="checkbox" value="1" <?php checked( '1', $options['show_pinterest_top'] ); ?> /> <?php _e('Display pinterest button', 'tcd-w');  ?></label></li>
					<li><label><input id="dp_options[show_note_top]" name="dp_options[show_note_top]" type="checkbox" value="1" <?php checked( '1', $options['show_note_top'] ); ?> /> <?php _e('Display note button', 'tcd-w');  ?></label></li>
				</ul>
				</li>
				</ul>

				<hr />

				<h4 class="theme_option_headline2"><?php _e('Set of articles bottom buttons', 'tcd-w');  ?></h4>
				<label><input id="dp_options[show_sns_btm]" name="dp_options[show_sns_btm]" type="checkbox" value="1" <?php checked( '1', $options['show_sns_btm'] ); ?> /> <?php _e('Buttons to the article bottom', 'tcd-w');  ?></label>
				<h4 class="theme_option_headline2"><?php _e('Type of button on article bottom', 'tcd-w');  ?></h4>
				<fieldset class="cf">
					<ul class="cf">
						<?php
						if ( ! isset( $checked ) )
							$checked = '';
						foreach ( $sns_type_btm_options as $option ) {
							$sns_type_btm_setting = $options['sns_type_btm'];
							if ( '' != $sns_type_btm_setting ) {
								if ( $options['sns_type_btm'] == $option['value'] ) {
									$checked = "checked=\"checked\"";
								} else {
									$checked = '';
								}
							}
							?>
							<li>
								<label>
									<input type="radio" name="dp_options[sns_type_btm]" value="<?php esc_attr_e( $option['value'] ); ?>" <?php echo $checked; ?> />
									<?php _e($option['label'], 'tcd-w'); ?>
								</label>
							</li>
							<?php
						}
						?>
					</ul>
				</fieldset>

				<h4 class="theme_option_headline2"><?php _e('Select the social button to show on article bottom', 'tcd-w');  ?></h4>
				<ul>
					<li><label><input id="dp_options[show_twitter_btm]" name="dp_options[show_twitter_btm]" type="checkbox" value="1" <?php checked( '1', $options['show_twitter_btm'] ); ?> /> <?php _e('Display X button', 'tcd-w');  ?></label></li>
					<li><label><input id="dp_options[show_fblike_btm]" name="dp_options[show_fblike_btm]" type="checkbox" value="1" <?php checked( '1', $options['show_fblike_btm'] ); ?> /> <?php _e('Display facebook like button-Button type 5 (Default button) only', 'tcd-w');  ?></label></li>
					<li><label><input id="dp_options[show_fbshare_btm]" name="dp_options[show_fbshare_btm]" type="checkbox" value="1" <?php checked( '1', $options['show_fbshare_btm'] ); ?> /> <?php _e('Display facebook share button', 'tcd-w');  ?></label></li>
					<li><label><input id="dp_options[show_hatena_btm]" name="dp_options[show_hatena_btm]" type="checkbox" value="1" <?php checked( '1', $options['show_hatena_btm'] ); ?> /> <?php _e('Display hatena button', 'tcd-w');  ?></label></li>
					<li><label><input id="dp_options[show_line_btm]" name="dp_options[show_line_btm]" type="checkbox" value="1" <?php checked( '1', $options['show_line_btm'] ); ?> /> <?php _e('Display LINE button', 'tcd-w');  ?></label></li>
					<li><label><input id="dp_options[show_feedly_btm]" name="dp_options[show_feedly_btm]" type="checkbox" value="1" <?php checked( '1', $options['show_feedly_btm'] ); ?> /> <?php _e('Display feedly button', 'tcd-w');  ?></label></li>
					<li><label><input id="dp_options[show_rss_btm]" name="dp_options[show_rss_btm]" type="checkbox" value="1" <?php checked( '1', $options['show_rss_btm'] ); ?> /> <?php _e('Display rss button', 'tcd-w');  ?></label></li>
					<li><label><input id="dp_options[show_pinterest_btm]" name="dp_options[show_pinterest_btm]" type="checkbox" value="1" <?php checked( '1', $options['show_pinterest_btm'] ); ?> /> <?php _e('Display pinterest button', 'tcd-w');  ?></label></li>
					<li><label><input id="dp_options[show_note_btm]" name="dp_options[show_note_btm]" type="checkbox" value="1" <?php checked( '1', $options['show_note_btm'] ); ?> /> <?php _e('Display note button', 'tcd-w');  ?></label></li>
				</ul>
				</li>
				</ul>
				<h4 class="theme_option_headline2"><?php _e('Setting for the X button', 'tcd-w');  ?></h4>
				<label style="margin-top:20px;"><?php _e('Set of X account. (ex.designplus)', 'tcd-w');  ?></label>
				<input style="display:block; margin:.6em 0 1em;" id="dp_options[twitter_info]" class="regular-text" type="text" name="dp_options[twitter_info]" value="<?php esc_attr_e( $options['twitter_info'] ); ?>" />
				<input type="submit" class="button-ml" value="<?php echo __( 'Save Changes', 'tcd-w' ); ?>" />
			</div>
		</div>

		<?php // 広告の登録1 -------------------------------------------------------------------------------------------- ?>
		<div class="theme_option_field cf">
			<h3 class="theme_option_headline"><?php _e('Single page banner setup', 'tcd-w');  ?>1</h3>
			<p><?php _e('This banner will be displayed under contents.', 'tcd-w');  ?></p>
			<div class="sub_box cf">
				<h3 class="theme_option_subbox_headline"><?php _e('Left banner', 'tcd-w');  ?></h3>
				<div class="theme_option_content">
					<h4 class="theme_option_headline2"><?php _e('Banner code', 'tcd-w');  ?></h4>
					<p><?php _e('If you are using google adsense, enter all code below.', 'tcd-w');  ?></p>
					<textarea id="dp_options[single_ad_code1]" class="large-text" cols="50" rows="10" name="dp_options[single_ad_code1]"><?php echo esc_textarea( $options['single_ad_code1'] ); ?></textarea>
				</div>
				<p><?php _e('If you are not using google adsense, you can register your banner image and affiliate code individually.', 'tcd-w');  ?></p>
				<div class="theme_option_content">
					<h4 class="theme_option_headline2"><?php _e('Register banner image.', 'tcd-w'); _e('Recommend size. Width:300px Height:250px', 'tcd-w'); ?></h4>
					<div class="image_box cf">
						<div class="cf cf_media_field hide-if-no-js single_ad_image1">
							<input type="hidden" value="<?php echo esc_attr( $options['single_ad_image1'] ); ?>" id="single_ad_image" name="dp_options[single_ad_image1]" class="cf_media_id">
							<div class="preview_field"><?php if($options['single_ad_image1']){ echo wp_get_attachment_image($options['single_ad_image1'], 'medium'); }; ?></div>
							<div class="buttton_area">
								<input type="button" value="<?php _e('Select Image', 'tcd-w'); ?>" class="cfmf-select-img button">
								<input type="button" value="<?php _e('Remove Image', 'tcd-w'); ?>" class="cfmf-delete-img button <?php if(!$options['single_ad_image1']){ echo 'hidden'; }; ?>">
							</div>
						</div>
					</div>
				</div>
				<div class="theme_option_content">
					<h4 class="theme_option_headline2"><?php _e('Register affiliate code', 'tcd-w');  ?></h4>
					<input id="dp_options[single_ad_url1]" class="regular-text" type="text" name="dp_options[single_ad_url1]" value="<?php esc_attr_e( $options['single_ad_url1'] ); ?>" />
					<input type="submit" class="button-ml" value="<?php echo __( 'Save Changes', 'tcd-w' ); ?>" />
				</div>
			</div><!-- END .sub_box -->
			<div class="sub_box cf">
				<h3 class="theme_option_subbox_headline"><?php _e('Right banner', 'tcd-w');  ?></h3>
				<div class="theme_option_content">
					<h4 class="theme_option_headline2"><?php _e('Banner code', 'tcd-w');  ?></h4>
					<p><?php _e('If you are using google adsense, enter all code below.', 'tcd-w');  ?></p>
					<textarea id="dp_options[single_ad_code2]" class="large-text" cols="50" rows="10" name="dp_options[single_ad_code2]"><?php echo esc_textarea( $options['single_ad_code2'] ); ?></textarea>
				</div>
				<p><?php _e('If you are not using google adsense, you can register your banner image and affiliate code individually.', 'tcd-w');  ?></p>
				<div class="theme_option_content">
					<h4 class="theme_option_headline2"><?php _e('Register banner image.', 'tcd-w'); _e('Recommend size. Width:300px Height:250px', 'tcd-w'); ?></h4>
					<div class="image_box cf">
						<div class="cf cf_media_field hide-if-no-js single_ad_image2">
							<input type="hidden" value="<?php echo esc_attr( $options['single_ad_image2'] ); ?>" id="single_ad_image2" name="dp_options[single_ad_image2]" class="cf_media_id">
							<div class="preview_field"><?php if($options['single_ad_image2']){ echo wp_get_attachment_image($options['single_ad_image2'], 'medium'); }; ?></div>
							<div class="buttton_area">
								<input type="button" value="<?php _e('Select Image', 'tcd-w'); ?>" class="cfmf-select-img button">
								<input type="button" value="<?php _e('Remove Image', 'tcd-w'); ?>" class="cfmf-delete-img button <?php if(!$options['single_ad_image2']){ echo 'hidden'; }; ?>">
							</div>
						</div>
					</div>
				</div>
				<div class="theme_option_content">
					<h4 class="theme_option_headline2"><?php _e('Register affiliate code', 'tcd-w');  ?></h4>
					<input id="dp_options[single_ad_url2]" class="regular-text" type="text" name="dp_options[single_ad_url2]" value="<?php esc_attr_e( $options['single_ad_url2'] ); ?>" />
					<input type="submit" class="button-ml" value="<?php echo __( 'Save Changes', 'tcd-w' ); ?>" />
				</div>
			</div><!-- END .sub_box -->
		</div><!-- END .theme_option_field -->

		<?php // 広告の登録2 -------------------------------------------------------------------------------------------- ?>
		<div class="theme_option_field cf">
			<h3 class="theme_option_headline"><?php _e('Single page banner setup', 'tcd-w');  ?>2</h3>
			<p><?php _e('This banner will be displayed at bottom of the page.', 'tcd-w');  ?></p>
			<div class="sub_box cf">
				<h3 class="theme_option_subbox_headline"><?php _e('Left banner', 'tcd-w');  ?></h3>
				<div class="theme_option_content">
					<h4 class="theme_option_headline2"><?php _e('Banner code', 'tcd-w');  ?></h4>
					<p><?php _e('If you are using google adsense, enter all code below.', 'tcd-w');  ?></p>
					<textarea id="dp_options[single_ad_code5]" class="large-text" cols="50" rows="10" name="dp_options[single_ad_code5]"><?php echo esc_textarea( $options['single_ad_code5'] ); ?></textarea>
				</div>
				<p><?php _e('If you are not using google adsense, you can register your banner image and affiliate code individually.', 'tcd-w');  ?></p>
				<div class="theme_option_content">
					<h4 class="theme_option_headline2"><?php _e('Register banner image.', 'tcd-w'); _e('Recommend size. Width:300px Height:250px', 'tcd-w'); ?></h4>
					<div class="image_box cf">
						<div class="cf cf_media_field hide-if-no-js single_ad_image5">
							<input type="hidden" value="<?php echo esc_attr( $options['single_ad_image5'] ); ?>" id="single_ad_image5" name="dp_options[single_ad_image5]" class="cf_media_id">
							<div class="preview_field"><?php if($options['single_ad_image5']){ echo wp_get_attachment_image($options['single_ad_image5'], 'medium'); }; ?></div>
							<div class="buttton_area">
								<input type="button" value="<?php _e('Select Image', 'tcd-w'); ?>" class="cfmf-select-img button">
								<input type="button" value="<?php _e('Remove Image', 'tcd-w'); ?>" class="cfmf-delete-img button <?php if(!$options['single_ad_image5']){ echo 'hidden'; }; ?>">
							</div>
						</div>
					</div>
				</div>
				<div class="theme_option_content">
					<h4 class="theme_option_headline2"><?php _e('Register affiliate code', 'tcd-w');  ?></h4>
					<input id="dp_options[single_ad_url5]" class="regular-text" type="text" name="dp_options[single_ad_url5]" value="<?php esc_attr_e( $options['single_ad_url5'] ); ?>" />
					<input type="submit" class="button-ml" value="<?php echo __( 'Save Changes', 'tcd-w' ); ?>" />
				</div>
			</div><!-- END .sub_box -->
			<div class="sub_box cf">
				<h3 class="theme_option_subbox_headline"><?php _e('Right banner', 'tcd-w');  ?></h3>
				<div class="theme_option_content">
					<h4 class="theme_option_headline2"><?php _e('Banner code', 'tcd-w');  ?></h4>
					<p><?php _e('If you are using google adsense, enter all code below.', 'tcd-w');  ?></p>
					<textarea id="dp_options[single_ad_code6]" class="large-text" cols="50" rows="10" name="dp_options[single_ad_code6]"><?php echo esc_textarea( $options['single_ad_code6'] ); ?></textarea>
				</div>
				<p><?php _e('If you are not using google adsense, you can register your banner image and affiliate code individually.', 'tcd-w');  ?></p>
				<div class="theme_option_content">
					<h4 class="theme_option_headline2"><?php _e('Register banner image.', 'tcd-w'); _e('Recommend size. Width:300px Height:250px', 'tcd-w'); ?></h4>
					<div class="image_box cf">
						<div class="cf cf_media_field hide-if-no-js single_ad_image6">
							<input type="hidden" value="<?php echo esc_attr( $options['single_ad_image6'] ); ?>" id="single_ad_image6" name="dp_options[single_ad_image6]" class="cf_media_id">
							<div class="preview_field"><?php if($options['single_ad_image6']){ echo wp_get_attachment_image($options['single_ad_image6'], 'medium'); }; ?></div>
							<div class="buttton_area">
								<input type="button" value="<?php _e('Select Image', 'tcd-w'); ?>" class="cfmf-select-img button">
								<input type="button" value="<?php _e('Remove Image', 'tcd-w'); ?>" class="cfmf-delete-img button <?php if(!$options['single_ad_image6']){ echo 'hidden'; }; ?>">
							</div>
						</div>
					</div>
				</div>
				<div class="theme_option_content">
					<h4 class="theme_option_headline2"><?php _e('Register affiliate code', 'tcd-w');  ?></h4>
					<input id="dp_options[single_ad_url6]" class="regular-text" type="text" name="dp_options[single_ad_url6]" value="<?php esc_attr_e( $options['single_ad_url6'] ); ?>" />
					<input type="submit" class="button-ml" value="<?php echo __( 'Save Changes', 'tcd-w' ); ?>" />
				</div>
			</div><!-- END .sub_box -->
		</div><!-- END .theme_option_field -->

		<?php // 広告の登録3 -------------------------------------------------------------------------------------------- ?>
		<div class="theme_option_field cf">
			<h3 class="theme_option_headline"><?php _e('Single page banner setup', 'tcd-w');  ?>3</h3>
			<p><?php _e('Please copy and paste the short code inside the content to show this banner.', 'tcd-w');  ?></p>
			<p><?php _e('Short code', 'tcd-w');  ?> : <input type="text" readonly="readonly" value="[s_ad]" /></p>
			<div class="sub_box cf">
				<h3 class="theme_option_subbox_headline"><?php _e('Left banner', 'tcd-w');  ?></h3>
				<div class="theme_option_content">
					<h4 class="theme_option_headline2"><?php _e('Banner code', 'tcd-w');  ?></h4>
					<p><?php _e('If you are using google adsense, enter all code below.', 'tcd-w');  ?></p>
					<textarea id="dp_options[single_ad_code3]" class="large-text" cols="50" rows="10" name="dp_options[single_ad_code3]"><?php echo esc_textarea( $options['single_ad_code3'] ); ?></textarea>
				</div>
				<p><?php _e('If you are not using google adsense, you can register your banner image and affiliate code individually.', 'tcd-w');  ?></p>
				<div class="theme_option_content">
					<h4 class="theme_option_headline2"><?php _e('Register banner image.', 'tcd-w'); _e('Recommend size. Width:300px Height:250px', 'tcd-w'); ?></h4>
					<div class="image_box cf">
						<div class="cf cf_media_field hide-if-no-js single_ad_image3">
							<input type="hidden" value="<?php echo esc_attr( $options['single_ad_image3'] ); ?>" id="single_ad_image3" name="dp_options[single_ad_image3]" class="cf_media_id">
							<div class="preview_field"><?php if($options['single_ad_image3']){ echo wp_get_attachment_image($options['single_ad_image3'], 'medium'); }; ?></div>
							<div class="buttton_area">
								<input type="button" value="<?php _e('Select Image', 'tcd-w'); ?>" class="cfmf-select-img button">
								<input type="button" value="<?php _e('Remove Image', 'tcd-w'); ?>" class="cfmf-delete-img button <?php if(!$options['single_ad_image3']){ echo 'hidden'; }; ?>">
							</div>
						</div>
					</div>
				</div>
				<div class="theme_option_content">
					<h4 class="theme_option_headline2"><?php _e('Register affiliate code', 'tcd-w');  ?></h4>
					<input id="dp_options[single_ad_url3]" class="regular-text" type="text" name="dp_options[single_ad_url3]" value="<?php esc_attr_e( $options['single_ad_url3'] ); ?>" />
					<input type="submit" class="button-ml" value="<?php echo __( 'Save Changes', 'tcd-w' ); ?>" />
				</div>
			</div><!-- END .sub_box -->
			<div class="sub_box cf">
				<h3 class="theme_option_subbox_headline"><?php _e('Right banner', 'tcd-w');  ?></h3>
				<div class="theme_option_content">
					<h4 class="theme_option_headline2"><?php _e('Banner code', 'tcd-w');  ?></h4>
					<p><?php _e('If you are using google adsense, enter all code below.', 'tcd-w');  ?></p>
					<textarea id="dp_options[single_ad_code4]" class="large-text" cols="50" rows="10" name="dp_options[single_ad_code4]"><?php echo esc_textarea( $options['single_ad_code4'] ); ?></textarea>
				</div>
				<p><?php _e('If you are not using google adsense, you can register your banner image and affiliate code individually.', 'tcd-w');  ?></p>
				<div class="theme_option_content">
					<h4 class="theme_option_headline2"><?php _e('Register banner image.', 'tcd-w'); _e('Recommend size. Width:300px Height:250px', 'tcd-w'); ?></h4>
					<div class="image_box cf">
						<div class="cf cf_media_field hide-if-no-js single_ad_image4">
							<input type="hidden" value="<?php echo esc_attr( $options['single_ad_image4'] ); ?>" id="single_ad_image4" name="dp_options[single_ad_image4]" class="cf_media_id">
							<div class="preview_field"><?php if($options['single_ad_image4']){ echo wp_get_attachment_image($options['single_ad_image4'], 'medium'); }; ?></div>
							<div class="buttton_area">
								<input type="button" value="<?php _e('Select Image', 'tcd-w'); ?>" class="cfmf-select-img button">
								<input type="button" value="<?php _e('Remove Image', 'tcd-w'); ?>" class="cfmf-delete-img button <?php if(!$options['single_ad_image4']){ echo 'hidden'; }; ?>">
							</div>
						</div>
					</div>
				</div>
				<div class="theme_option_content">
					<h4 class="theme_option_headline2"><?php _e('Register affiliate code', 'tcd-w');  ?></h4>
					<input id="dp_options[single_ad_url4]" class="regular-text" type="text" name="dp_options[single_ad_url4]" value="<?php esc_attr_e( $options['single_ad_url4'] ); ?>" />
					<input type="submit" class="button-ml" value="<?php echo __( 'Save Changes', 'tcd-w' ); ?>" />
				</div>
			</div><!-- END .sub_box -->
		</div><!-- END .theme_option_field -->

		<?php // 広告の登録 for mobile -------------------------------------------------------------------------------------------- ?>
		<div class="theme_option_field cf">
			<h3 class="theme_option_headline"><?php _e('Single page banner for mobile setup', 'tcd-w');  ?></h3>
			<p><?php _e('This banner will be displayed with only mobile device.', 'tcd-w');  ?></p>
			<div class="sub_box cf">
				<h3 class="theme_option_subbox_headline"><?php _e('first banner', 'tcd-w');  ?></h3>
				<div class="theme_option_content">
					<h4 class="theme_option_headline2"><?php _e('Banner code', 'tcd-w');  ?></h4>
					<p><?php _e('If you are using google adsense, enter all code below.', 'tcd-w');  ?></p>
					<textarea id="dp_options[single_ad_code_m1]" class="large-text" cols="50" rows="10" name="dp_options[single_ad_code_m1]"><?php echo esc_textarea( $options['single_ad_code1'] ); ?></textarea>
				</div>
				<p><?php _e('If you are not using google adsense, you can register your banner image and affiliate code individually.', 'tcd-w');  ?></p>
				<div class="theme_option_content">
					<h4 class="theme_option_headline2"><?php _e('Register banner image.', 'tcd-w'); _e('Recommend size. Width:300px Height:250px', 'tcd-w'); ?></h4>
					<div class="image_box cf">
						<div class="cf cf_media_field hide-if-no-js single_ad_image_m1">
							<input type="hidden" value="<?php echo esc_attr( $options['single_ad_image_m1'] ); ?>" id="single_ad_image_m1" name="dp_options[single_ad_image_m1]" class="cf_media_id">
							<div class="preview_field"><?php if($options['single_ad_image_m1']){ echo wp_get_attachment_image($options['single_ad_image_m1'], 'medium'); }; ?></div>
							<div class="buttton_area">
								<input type="button" value="<?php _e('Select Image', 'tcd-w'); ?>" class="cfmf-select-img button">
								<input type="button" value="<?php _e('Remove Image', 'tcd-w'); ?>" class="cfmf-delete-img button <?php if(!$options['single_ad_image_m1']){ echo 'hidden'; }; ?>">
							</div>
						</div>
					</div>
				</div>
				<div class="theme_option_content">
					<h4 class="theme_option_headline2"><?php _e('Register affiliate code', 'tcd-w');  ?></h4>
					<input id="dp_options[single_ad_url_m1]" class="regular-text" type="text" name="dp_options[single_ad_url_m1]" value="<?php esc_attr_e( $options['single_ad_url_m1'] ); ?>" />
					<input type="submit" class="button-ml" value="<?php echo __( 'Save Changes', 'tcd-w' ); ?>" />
				</div>
			</div><!-- END .sub_box -->
			<div class="sub_box cf">
				<h3 class="theme_option_subbox_headline"><?php _e('second banner', 'tcd-w');  ?></h3>
				<div class="theme_option_content">
					<h4 class="theme_option_headline2"><?php _e('Banner code', 'tcd-w');  ?></h4>
					<p><?php _e('If you are using google adsense, enter all code below.', 'tcd-w');  ?></p>
					<textarea id="dp_options[single_ad_code_m2]" class="large-text" cols="50" rows="10" name="dp_options[single_ad_code_m2]"><?php echo esc_textarea( $options['single_ad_code_m2'] ); ?></textarea>
				</div>
				<p><?php _e('If you are not using google adsense, you can register your banner image and affiliate code individually.', 'tcd-w');  ?></p>
				<div class="theme_option_content">
					<h4 class="theme_option_headline2"><?php _e('Register banner image.', 'tcd-w'); _e('Recommend size. Width:300px Height:250px', 'tcd-w'); ?></h4>
					<div class="image_box cf">
						<div class="cf cf_media_field hide-if-no-js single_ad_image_m2">
							<input type="hidden" value="<?php echo esc_attr( $options['single_ad_image_m2'] ); ?>" id="single_ad_image_m2" name="dp_options[single_ad_image_m2]" class="cf_media_id">
							<div class="preview_field"><?php if($options['single_ad_image_m2']){ echo wp_get_attachment_image($options['single_ad_image_m2'], 'medium'); }; ?></div>
							<div class="buttton_area">
								<input type="button" value="<?php _e('Select Image', 'tcd-w'); ?>" class="cfmf-select-img button">
								<input type="button" value="<?php _e('Remove Image', 'tcd-w'); ?>" class="cfmf-delete-img button <?php if(!$options['single_ad_image_m2']){ echo 'hidden'; }; ?>">
							</div>
						</div>
					</div>
				</div>
				<div class="theme_option_content">
					<h4 class="theme_option_headline2"><?php _e('Register affiliate code', 'tcd-w');  ?></h4>
					<input id="dp_options[single_ad_url_m2]" class="regular-text" type="text" name="dp_options[single_ad_url_m2]" value="<?php esc_attr_e( $options['single_ad_url_m2'] ); ?>" />
					<input type="submit" class="button-ml" value="<?php echo __( 'Save Changes', 'tcd-w' ); ?>" />
				</div>
			</div><!-- END .sub_box -->
		</div><!-- END .theme_option_field -->
	</div><!-- END #tab-content4 -->

	<!-- #tab-content5 ニュースページ //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////  -->
	  <div id="tab-content5">
		<p style="margin:0 0 30px 0;"><?php _e('Setting the News Archive page.', 'tcd-w');  ?></p>
		  <?php // ヘッダーの画像 -------------------------------------------------------------------------------------------- ?>
		  <div class="theme_option_field cf">
			  <h3 class="theme_option_headline"><?php _e('Header image', 'tcd-w');  ?></h3>
			  <p><?php _e('Recommend image size. Width:1180px, Height:550px', 'tcd-w');  ?></p>
			  <div class="image_box cf">
				  <div class="cf cf_media_field hide-if-no-js news_image">
					  <input type="hidden" value="<?php echo esc_attr( $options['news_image'] ); ?>" id="news_image" name="dp_options[news_image]" class="cf_media_id">
					  <div class="preview_field"><?php if($options['news_image']){ echo wp_get_attachment_image($options['news_image'], 'medium'); }; ?></div>
					  <div class="buttton_area">
						  <input type="button" value="<?php _e('Select Image', 'tcd-w'); ?>" class="cfmf-select-img button">
						  <input type="button" value="<?php _e('Remove Image', 'tcd-w'); ?>" class="cfmf-delete-img button <?php if(!$options['news_image']){ echo 'hidden'; }; ?>">
					  </div>
				  </div>
			  </div>
			  <input type="submit" class="button-ml" value="<?php echo __( 'Save Changes', 'tcd-w' ); ?>" />
		  </div>

		  <?php // キャッチフレーズ ----------------------------------------------------------------------------- ?>
		  <div class="theme_option_field cf">
			  <h3 class="theme_option_headline"><?php _e('Header catchphrase', 'tcd-w');  ?></h3>
			  <h4 class="theme_option_headline2"><?php _e('Catchphrase', 'tcd-w');  ?></h4>
			  <input id="dp_options[news_headline]" class="regular-text" type="text" name="dp_options[news_headline]" value="<?php esc_attr_e( $options['news_headline'] ); ?>" />
			  <h4 class="theme_option_headline2"><?php _e('Font size', 'tcd-w');  ?></h4>
			  <p><input id="dp_options[news_headline_font_size]" class="font_size hankaku" type="text" name="dp_options[news_headline_font_size]" value="<?php esc_attr_e( $options['news_headline_font_size'] ); ?>" /><span>px</span></p>
			  <h4 class="theme_option_headline2"><?php _e('Font color', 'tcd-w');  ?></h4>
			  <input type="text" id="news_headline_color" class="color" name="dp_options[news_headline_color]" value="<?php esc_attr_e( $options['news_headline_color'] ); ?>" />
			  <input type="button" style="margin:0 0 0 5px;" class="button-secondary" value="<?php _e('Default color', 'tcd-w');  ?>" onClick="document.getElementById('news_headline_color').color.fromString('FFFFFF')">
			  <h4 class="theme_option_headline2"><?php _e('Dropshadow', 'tcd-w');  ?></h4>
			  <ul class="headline_option">
				  <li><label><?php _e('Dropshadow position (left)', 'tcd-w');  ?></label><input id="dp_options[news_headline_shadow1]" class="font_size hankaku" type="text" name="dp_options[news_headline_shadow1]" value="<?php esc_attr_e( $options['news_headline_shadow1'] ); ?>" /><span>px</span></li>
				  <li><label><?php _e('Dropshadow position (top)', 'tcd-w');  ?></label><input id="dp_options[news_headline_shadow2]" class="font_size hankaku" type="text" name="dp_options[news_headline_shadow2]" value="<?php esc_attr_e( $options['news_headline_shadow2'] ); ?>" /><span>px</span></li>
				  <li><label><?php _e('Dropshadow size', 'tcd-w');  ?></label><input id="dp_options[news_headline_shadow3]" class="font_size hankaku" type="text" name="dp_options[news_headline_shadow3]" value="<?php esc_attr_e( $options['news_headline_shadow3'] ); ?>" /><span>px</span></li>
				  <li><label><?php _e('Dropshadow color', 'tcd-w');  ?></label><input type="text" id="news_headline_shadow_color" class="color" name="dp_options[news_headline_shadow_color]" value="<?php esc_attr_e( $options['news_headline_shadow_color'] ); ?>" /><input type="button" style="margin:0 0 0 5px;" class="button-secondary" value="<?php _e('Default color', 'tcd-w');  ?>" onClick="document.getElementById('news_headline_shadow_color').color.fromString('333333')"></li>
			  </ul>
			  <?php /* ?>
			  <h4 class="theme_option_headline2"><?php _e('Number of post to show at News archive page', 'tcd-w'); ?></h4>
			  <select id="dp_options[news_archive_count]" class="font_size" name="dp_options[news_archive_count]">
				  <?php dp_numoptions_e(1, 10, $options['news_archive_count']) ?>
			  </select>
			  <?php */ ?>
			  <h4 class="theme_option_headline2"><?php _e('Font size of post title', 'tcd-w'); ?></h4>
			  <input id="dp_options[news_title_font_size]" class="font_size hankaku" type="text" name="dp_options[news_title_font_size]" value="<?php echo esc_attr( $options['news_title_font_size'] ); ?>" /><span>px</span>
			  <h4 class="theme_option_headline2"><?php _e('Setting to display date', 'tcd-w'); ?></h4>
			  <p><label><input id="dp_options[show_news_date_single]" name="dp_options[show_news_date_single]" type="checkbox" value="1" <?php checked( '1', $options['show_news_date_single'] ); ?> /> <?php _e('Display the date of news at single page', 'tcd-w');  ?></label></p>
			  <p><label><input id="dp_options[show_news_date_archive]" name="dp_options[show_news_date_archive]" type="checkbox" value="1" <?php checked( '1', $options['show_news_date_archive'] ); ?> /> <?php _e('Display the date of news at archive page', 'tcd-w');  ?></label></p>
			  <input type="submit" class="button-ml" value="<?php echo __( 'Save Changes', 'tcd-w' ); ?>" />
		  </div>
	</div><!-- END #tab-content5 -->

	  <!-- #tab-content6 固定サイドバー //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////  -->
    <div id="tab-content6">
		<p style="margin:0 0 30px 0;"><?php _e('Setting a fixed side bar which is common to all the pages.', 'tcd-w');  ?></p>

		<?php // レイアウトの設定 ?>
		<div class="theme_option_field cf">
		  <h3 class="theme_option_headline"><?php _e('Layout of sidebar', 'tcd-w');  ?></h3>
		  <div class="theme_option_input layout_option">
			  <ul class="select_type1 cf">
				  <?php
				  if ( ! isset( $checked ) )
					  $checked = '';
				  foreach ( $layout_options as $option ) {
					  $layout_setting = $options['layout'];
					  if ( '' != $layout_setting ) {
						  if ( $options['layout'] == $option['value'] ) {
							  $checked = "checked=\"checked\"";
						  } else {
							  $checked = '';
						  }
					  }
					  ?>
					  <li>
						  <label>
							  <input type="radio" name="dp_options[layout]" value="<?php esc_attr_e( $option['value'] ); ?>" <?php echo $checked; ?> />
							  <img src="<?php bloginfo('template_url'); ?>/admin/img/<?php echo $option['img']; ?>.gif" alt="" title="" />
							  <?php echo $option['label']; ?>
						  </label>
					  </li>
					  <?php
				  }
				  ?>
			  </ul>
			  <input type="submit" class="button-ml" value="<?php echo __( 'Save Changes', 'tcd-w' ); ?>" />
		  </div>
		</div>

		<?php // 固定サイドバーの最小値（この値より画面が小さいときはサイドバーを固定しない） ?>
		<div class="theme_option_field cf">
			<h3 class="theme_option_headline"><?php _e('Minimum height of fixed sidebar', 'tcd-w'); ?></h3>
			<p><?php _e('If the height of window is smaller than this value, the sidebar is not fixed.', 'tcd-w'); ?></p>
			<p><input id="dp_options[min_height_sidebar]" class="hankaku" style="width:45px;" type="text" name="dp_options[min_height_sidebar]" value="<?php esc_attr_e( $options['min_height_sidebar'] ); ?>" /><span>px</span></p>
			<p><label><?php _e('Check the hight of the current window.', 'tcd-w'); ?></label><input type="button" style="margin:0 0 0 15px;" class="button-secondary" value="<?php _e('Check', 'tcd-w'); ?>" onClick="alert('<?php _e('Hight of the current window is', 'tcd-w'); ?> '+window.innerHeight+'px')"></p>
			<input type="submit" class="button-ml" value="<?php echo __( 'Save Changes', 'tcd-w' ); ?>" />
		</div>

		<?php // Global menuの設定 ?>
		<div class="theme_option_field cf">
			<h3 class="theme_option_headline"><?php _e('Global menu setting', 'tcd-w'); ?></h3>
			<p><?php _e('You can set the color of sub menu button of global menu.', 'tcd-w'); ?></p>
			<h4 class="theme_option_headline2"><?php _e('Font color', 'tcd-w');  ?></h4>
			<input type="text" id="gnav_submenu_color" class="color" name="dp_options[gnav_submenu_color]" value="<?php esc_attr_e( $options['gnav_submenu_color'] ); ?>" />
			<input type="button" style="margin:0 0 0 5px;" class="button-secondary" value="<?php _e('Default color', 'tcd-w');  ?>" onClick="document.getElementById('gnav_submenu_color').color.fromString('FFFFFF')">
			<h4 class="theme_option_headline2"><?php _e('Background color', 'tcd-w');  ?></h4>
			<input type="text" id="gnav_submenu_bgcolor" class="color" name="dp_options[gnav_submenu_bgcolor]" value="<?php esc_attr_e( $options['gnav_submenu_bgcolor'] ); ?>" />
			<input type="button" style="margin:0 0 0 5px;" class="button-secondary" value="<?php _e('Default color', 'tcd-w');  ?>" onClick="document.getElementById('gnav_submenu_bgcolor').color.fromString('000000')">
			<h4 class="theme_option_headline2"><?php _e('Font hover color', 'tcd-w');  ?></h4>
			<input type="text" id="gnav_submenu_color_hover" class="color" name="dp_options[gnav_submenu_color_hover]" value="<?php esc_attr_e( $options['gnav_submenu_color_hover'] ); ?>" />
			<input type="button" style="margin:0 0 0 5px;" class="button-secondary" value="<?php _e('Default color', 'tcd-w');  ?>" onClick="document.getElementById('gnav_submenu_color_hover').color.fromString('FFFFFF')">
			<h4 class="theme_option_headline2"><?php _e('Background hover color', 'tcd-w');  ?></h4>
			<input type="text" id="gnav_submenu_bgcolor_hover" class="color" name="dp_options[gnav_submenu_bgcolor_hover]" value="<?php esc_attr_e( $options['gnav_submenu_bgcolor_hover'] ); ?>" />
			<input type="button" style="margin:0 0 0 5px;" class="button-secondary" value="<?php _e('Default color', 'tcd-w');  ?>" onClick="document.getElementById('gnav_submenu_bgcolor_hover').color.fromString('753A00')">
			<h4 class="theme_option_headline2"><?php _e('Background opacity', 'tcd-w');  ?></h4>
			<p><?php _e('Please set the opacity. (0 - 1.0, e.g. 0.7)', 'tcd-w'); ?></p>
			<input id="dp_options[gnav_submenu_opacity]" class="hankaku" style="width:45px;" type="text" name="dp_options[gnav_submenu_opacity]" value="<?php esc_attr_e( $options['gnav_submenu_opacity'] ); ?>" />
			<input type="submit" class="button-ml" value="<?php echo __( 'Save Changes', 'tcd-w' ); ?>" />
		</div>

	<?php // SNSボタンの設定 ?>
	<div class="theme_option_field cf">
	  <h3 class="theme_option_headline"><?php _e('SNS button setting', 'tcd-w');  ?></h3>
	  <p><?php _e('Enter url of your SNS page. If it is blank SNS button will not be shown.', 'tcd-w');  ?></p>
	  <ul>
	  		<li>
			  <label style="display:inline-block; min-width:140px;"><?php _e('your tiktok URL', 'tcd-w');  ?></label>
			  <input id="dp_options[snsurl_tiktok]" class="regular-text" type="text" name="dp_options[snsurl_tiktok]" value="<?php esc_attr_e( $options['snsurl_tiktok'] ); ?>" />
		  </li>
		  <li>
			  <label style="display:inline-block; min-width:140px;"><?php _e('your X URL', 'tcd-w');  ?></label>
			  <input id="dp_options[snsurl_twitter]" class="regular-text" type="text" name="dp_options[snsurl_twitter]" value="<?php esc_attr_e( $options['snsurl_twitter'] ); ?>" />
		  </li>
		  <li>
			  <label style="display:inline-block; min-width:140px;"><?php _e('your facebook URL', 'tcd-w');  ?></label>
			  <input id="dp_options[snsurl_facebook]" class="regular-text" type="text" name="dp_options[snsurl_facebook]" value="<?php esc_attr_e( $options['snsurl_facebook'] ); ?>" />
		  </li>
		  <li>
			  <label style="display:inline-block; min-width:140px;"><?php _e('your instagram URL', 'tcd-w');  ?></label>
			  <input id="dp_options[snsurl_instagram]" class="regular-text" type="text" name="dp_options[snsurl_instagram]" value="<?php esc_attr_e( $options['snsurl_instagram'] ); ?>" />
		  </li>
		  <li>
			  <label style="display:inline-block; min-width:140px;"><?php _e('your pinterest URL', 'tcd-w');  ?></label>
			  <input id="dp_options[snsurl_pinterest]" class="regular-text" type="text" name="dp_options[snsurl_pinterest]" value="<?php esc_attr_e( $options['snsurl_pinterest'] ); ?>" />
		  </li>
		  <li>
			  <label style="display:inline-block; min-width:140px;"><?php _e('your flickr URL', 'tcd-w');  ?></label>
			  <input id="dp_options[snsurl_flickr]" class="regular-text" type="text" name="dp_options[snsurl_flickr]" value="<?php esc_attr_e( $options['snsurl_flickr'] ); ?>" />
		  </li>
		  <li>
			  <label style="display:inline-block; min-width:140px;"><?php _e('your tumblr URL', 'tcd-w');  ?></label>
			  <input id="dp_options[snsurl_tumblr]" class="regular-text" type="text" name="dp_options[snsurl_tumblr]" value="<?php esc_attr_e( $options['snsurl_tumblr'] ); ?>" />
		  </li>
	  </ul>
	  <hr />
	  <input type="submit" class="button-ml" value="<?php echo __( 'Save Changes', 'tcd-w' ); ?>" />
	</div>

   <?php // ショップ情報の設定 ?>
   <div class="theme_option_field cf">
    <h3 class="theme_option_headline"><?php _e('Shop information', 'tcd-w');  ?></h3>
<p style="margin:0 0 30px 0;"><?php _e('Shop information is displayed at the bottom of the fixed sidebar and the footer of contents page.', 'tcd-w');  ?></p>

    <h4 class="theme_option_headline2"><?php _e('Shop name', 'tcd-w');  ?></h4>
	<input id="dp_options[shop_name]" class="regular-text" type="text" name="dp_options[shop_name]" value="<?php esc_attr_e( $options['shop_name'] ); ?>" />
	<p><?php _e('Font size at fixed sidebar', 'tcd-w'); ?> <input id="dp_options[shop_name_fontsize_side]" class="font_size hankaku" type="text" name="dp_options[shop_name_fontsize_side]" value="<?php echo esc_attr( $options['shop_name_fontsize_side'] ); ?>" /><span>px</span></p>
	<p><?php _e('Font size at footer of contents page', 'tcd-w'); ?> <input id="dp_options[shop_name_fontsize_foot]" class="font_size hankaku" type="text" name="dp_options[shop_name_fontsize_foot]" value="<?php echo esc_attr( $options['shop_name_fontsize_foot'] ); ?>" /><span>px</span></p>
	<h4 class="theme_option_headline2"><?php _e('Shop address', 'tcd-w');  ?></h4>
	<p><?php _e('We recommed you to use new line at the appropriate place.', 'tcd-w'); ?></p>
	<textarea id="dp_options[shop_addr]" class="large-text" cols="10" rows="3" name="dp_options[shop_addr]"><?php echo esc_textarea( $options['shop_addr'] ); ?></textarea>
	<p><?php _e('Font size at fixed sidebar', 'tcd-w'); ?> <input id="dp_options[shop_addr_fontsize_side]" class="font_size hankaku" type="text" name="dp_options[shop_addr_fontsize_side]" value="<?php echo esc_attr( $options['shop_addr_fontsize_side'] ); ?>" /><span>px</span></p>
	<p><?php _e('Font size at footer of contents page', 'tcd-w'); ?> <input id="dp_options[shop_addr_fontsize_foot]" class="font_size hankaku" type="text" name="dp_options[shop_addr_fontsize_foot]" value="<?php echo esc_attr( $options['shop_addr_fontsize_foot'] ); ?>" /><span>px</span></p>
	<h4 class="theme_option_headline2"><?php _e('Shop telephone number', 'tcd-w');  ?></h4>
	<p><?php _e('Visitors of this site can call this number directly with their smart phones.', 'tcd-w'); ?></p>
	<input id="dp_options[shop_tel]" class="text" type="text" name="dp_options[shop_tel]" value="<?php esc_attr_e( $options['shop_tel'] ); ?>" />
	<p><?php _e('Font size at fixed sidebar', 'tcd-w'); ?> <input id="dp_options[shop_tel_fontsize_side]" class="font_size hankaku" type="text" name="dp_options[shop_tel_fontsize_side]" value="<?php echo esc_attr( $options['shop_tel_fontsize_side'] ); ?>" /><span>px</span></p>
	<p><?php _e('Font size at footer of contents page', 'tcd-w'); ?> <input id="dp_options[shop_tel_fontsize_foot]" class="font_size hankaku" type="text" name="dp_options[shop_tel_fontsize_foot]" value="<?php echo esc_attr( $options['shop_tel_fontsize_foot'] ); ?>" /><span>px</span></p>
	
	<input type="submit" class="button-ml" value="<?php echo __( 'Save Changes', 'tcd-w' ); ?>" />
   </div>

  </div><!-- END #tab-content6 -->

  <!-- #tab-content7 //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////  -->
  <div id="tab-content7">

   <?php // フッターバーの設定 ?>
   <div class="theme_option_field cf">
    <h3 class="theme_option_headline"><?php _e( 'Setting of the footer bar for smart phone', 'tcd-w' ); ?></h3>
    <p><?php _e( 'Please set the footer bar which is displayed with smart phone.', 'tcd-w' ); ?>

    <h4 class="theme_option_headline2"><?php _e('Display type of the footer bar', 'tcd-w'); ?></h4>
    <fieldset class="cf select_type2">
     <?php
          if ( ! isset( $checked ) )
          $checked = '';
          foreach ( $footer_bar_display_options as $option ) {
          $footer_bar_display_setting = $options['footer_bar_display'];
            if ( '' != $footer_bar_display_setting ) {
              if ( $options['footer_bar_display'] == $option['value'] ) {
                $checked = "checked=\"checked\"";
              } else {
                $checked = '';
              }
           }
     ?>
     <label class="description">
      <input type="radio" name="dp_options[footer_bar_display]" value="<?php echo esc_attr( $option['value'] ); ?>" <?php echo $checked; ?> />
      <?php echo $option['label']; ?>
     </label>
     <?php } ?>
    </fieldset>

    <h4 class="theme_option_headline2"><?php _e('Settings for the appearance of the footer bar', 'tcd-w'); ?></h4>
    <p>
     <?php _e('Background color', 'tcd-w'); ?>
     <input type="text" id="footer_bar_bg" class="color" name="dp_options[footer_bar_bg]" value="<?php echo esc_attr( $options['footer_bar_bg'] ); ?>" />
     <input type="button" style="margin:0 0 0 5px;" class="button-secondary" value="<?php _e('Default color', 'tcd-w'); ?>" onClick="document.getElementById('footer_bar_bg').color.fromString('FFFFFF')">
  </p>
    <p>
     <?php _e('Border color', 'tcd-w'); ?>
     <input type="text" id="footer_bar_border" class="color" name="dp_options[footer_bar_border]" value="<?php echo esc_attr( $options['footer_bar_border'] ); ?>" />
     <input type="button" style="margin:0 0 0 5px;" class="button-secondary" value="<?php _e('Default color', 'tcd-w'); ?>" onClick="document.getElementById('footer_bar_border').color.fromString('DDDDDD')">
  </p>
    <p>
     <?php _e('Font color', 'tcd-w'); ?>
     <input type="text" id="footer_bar_color" class="color" name="dp_options[footer_bar_color]" value="<?php echo esc_attr( $options['footer_bar_color'] ); ?>" />
     <input type="button" style="margin:0 0 0 5px;" class="button-secondary" value="<?php _e('Default color', 'tcd-w'); ?>" onClick="document.getElementById('footer_bar_color').color.fromString('000000')">
  </p>
  <p>
     <?php _e('Opacity of background', 'tcd-w'); ?>
     <input id="dp_options[footer_bar_tp]" class="font_size hankaku" type="text" name="dp_options[footer_bar_tp]" value="<?php echo esc_attr( $options['footer_bar_tp'] ); ?>" /><br>
     <?php _e('Please enter the number 0 - 1.0. (e.g. 0.8)', 'tcd-w'); ?>
  </p>

    <h4 class="theme_option_headline2"><?php _e('Settings for the contents of the footer bar', 'tcd-w'); ?></h4>
    <p><?php _e( 'You can display the button with icon in footer bar. (We recommend you to set max 4 buttons.)', 'tcd-w' ); ?><br><?php _e( 'You can select button types below.', 'tcd-w' ); ?></p>
    <table class="table-border">
     <tr>
      <th><?php _e( 'Default', 'tcd-w' ); ?></th>
      <td><?php _e( 'You can set link URL.', 'tcd-w' ); ?></td>
     </tr>
     <tr>
      <th><?php _e( 'Share', 'tcd-w' ); ?></th>
      <td><?php _e( 'Share buttons are displayed if you tap this button.', 'tcd-w' ); ?></td>
     </tr>
     <tr>
      <th><?php _e( 'Telephone', 'tcd-w' ); ?></th>
      <td><?php _e( 'You can call this number.', 'tcd-w' ); ?></td>
     </tr>
    </table>
    <p><?php _e( 'Click "Add item", and set the button for footer bar. You can drag the item to change their order.', 'tcd-w' ); ?></p>
    <div class="repeater-wrapper">
     <div class="repeater sortable" data-delete-confirm="<?php _e( 'Delete?', 'tcd-w' ); ?>">
<?php
    if ( $options['footer_bar_btns'] ) :
      foreach ( $options['footer_bar_btns'] as $key => $value ) :  
?>
      <div class="sub_box repeater-item repeater-item-<?php echo esc_attr( $key ); ?>">
       <h4 class="theme_option_subbox_headline"><?php echo esc_attr( $value['label'] ); ?></h4>
       <div class="sub_box_content">
        <p class="footer-bar-target" style="<?php if ( $value['type'] !== 'type1' ) { echo 'display: none;'; } ?>"><label><input name="dp_options[repeater_footer_bar_btns][<?php echo esc_attr( $key ); ?>][target]" type="checkbox" value="1" <?php checked( $value['target'], 1 ); ?>><?php _e( 'Open with new window', 'tcd-w' ); ?></label></p>
        <table class="table-repeater">
         <tr class="footer-bar-type">
          <th><label><?php _e( 'Button type', 'tcd-w' ); ?></label></th>
          <td>

           <select name="dp_options[repeater_footer_bar_btns][<?php echo esc_attr( $key ); ?>][type]">
            <?php foreach( $footer_bar_button_options as $option ) : ?>
            <option value="<?php echo esc_attr( $option['value'] ); ?>" <?php selected( $value['type'], $option['value'] ); ?>><?php esc_html_e( $option['label'], 'tcd-w' ); ?></option>
            <?php endforeach; ?>
           </select>
          </td>
         </tr>
         <tr>
          <th><label for="dp_options[footer_bar_btn<?php echo esc_attr( $key ); ?>_label]"><?php _e( 'Button label', 'tcd-w' ); ?></label></th>
          <td><input id="dp_options[footer_bar_btn<?php echo esc_attr( $key ); ?>_label]" class="regular-text repeater-label" type="text" name="dp_options[repeater_footer_bar_btns][<?php echo esc_attr( $key ); ?>][label]" value="<?php echo esc_attr( $value['label'] ); ?>"></td>
         </tr>
         <tr class="footer-bar-url" style="<?php if ( $value['type'] !== 'type1' ) { echo 'display: none;'; } ?>">
          <th><label for="dp_options[footer_bar_btn<?php echo esc_attr( $key ); ?>_url]"><?php _e( 'Link URL', 'tcd-w' ); ?></label></th>
          <td><input id="dp_options[footer_bar_btn<?php echo esc_attr( $key ); ?>_url]" class="regular-text" type="text" name="dp_options[repeater_footer_bar_btns][<?php echo esc_attr( $key ); ?>][url]" value="<?php echo esc_attr( $value['url'] ); ?>"></td>
         </tr>
         <tr class="footer-bar-number" style="<?php if ( $value['type'] !== 'type3' ) { echo 'display: none;'; } ?>">
          <th><label for="dp_options[footer_bar_btn<?php echo esc_attr( $key ); ?>_number]"><?php _e( 'Phone number', 'tcd-w' ); ?></label></th>
          <td><input id="dp_options[footer_bar_btn<?php echo esc_attr( $key ); ?>_number]" class="regular-text" type="text" name="dp_options[repeater_footer_bar_btns][<?php echo esc_attr( $key ); ?>][number]" value="<?php echo esc_attr( $value['number'] ); ?>"></td>
         </tr>
         <tr>
          <th><?php _e( 'Button icon', 'tcd-w' ); ?></th>
          <td>
           <?php foreach( $footer_bar_icon_options as $option ) : ?>
           <p><label><input type="radio" name="dp_options[repeater_footer_bar_btns][<?php echo esc_attr( $key ); ?>][icon]" value="<?php echo esc_attr( $option['value'] ); ?>" <?php checked( $option['value'], $value['icon'] ); ?>><span class="icon icon-<?php echo esc_attr( $option['value'] ); ?>"></span><?php esc_html_e( $option['label'], 'tcd-w' ); ?></label></p>
           <?php endforeach; ?>
          </td>
         </tr>
        </table>
        <p class="delete-row right-align"><a href="#" class="button button-secondary button-delete-row"><?php _e( 'Delete item', 'tcd-w' ); ?></a></p>
       </div>
      </div>
<?php
      endforeach;
    endif;

    $key = 'addindex';
    ob_start();
?>
      <div class="sub_box repeater-item repeater-item-<?php echo $key; ?>">
       <h4 class="theme_option_subbox_headline"><?php _e( 'New item', 'tcd-w' ); ?></h4>
       <div class="sub_box_content">
        <p class="footer-bar-target"><label><input name="dp_options[repeater_footer_bar_btns][<?php echo esc_attr( $key ); ?>][target]" type="checkbox" value="1"><?php _e( 'Open with new window', 'tcd-w' ); ?></label></p>
        <table class="table-repeater">
         <tr class="footer-bar-type">
          <th><label><?php _e( 'Button type', 'tcd-w' ); ?></label></th>
          <td>
           <select name="dp_options[repeater_footer_bar_btns][<?php echo esc_attr( $key ); ?>][type]">
            <?php foreach( $footer_bar_button_options as $option ) : ?>
            <option value="<?php echo esc_attr( $option['value'] ); ?>"><?php esc_html_e( $option['label'], 'tcd-w' ); ?></option>
            <?php endforeach; ?>
           </select>
          </td>
         </tr>
         <tr>
          <th><label for="dp_options[repeater_footer_bar_btn<?php echo esc_attr( $key ); ?>_label]"><?php _e( 'Button label', 'tcd-w' ); ?></label></th>
          <td><input id="dp_options[footer_bar_btn<?php echo esc_attr( $key ); ?>_label]" class="regular-text repeater-label" type="text" name="dp_options[repeater_footer_bar_btns][<?php echo esc_attr( $key ); ?>][label]" value=""></td>
         </tr>
         <tr class="footer-bar-url">
          <th><label for="dp_options[footer_bar_btn<?php echo esc_attr( $key ); ?>_url]"><?php _e( 'Link URL', 'tcd-w' ); ?></label></th>
          <td><input id="dp_options[footer_bar_btn<?php echo esc_attr( $key ); ?>_url]" class="regular-text" type="text" name="dp_options[repeater_footer_bar_btns][<?php echo esc_attr( $key ); ?>][url]" value=""></td>
         </tr>
         <tr class="footer-bar-number" style="display: none;">
          <th><label for="dp_options[footer_bar_btn<?php echo esc_attr( $key ); ?>_number]"><?php _e( 'Phone number', 'tcd-w' ); ?></label></th>
          <td><input id="dp_options[footer_bar_btn<?php echo esc_attr( $key ); ?>_number]" class="regular-text" type="text" name="dp_options[repeater_footer_bar_btns][<?php echo esc_attr( $key ); ?>][number]" value=""></td>
         </tr>
         <tr>
          <th><?php _e( 'Button icon', 'tcd-w' ); ?></th>
          <td>
           <?php foreach( $footer_bar_icon_options as $option ) : ?>
           <p><label><input type="radio" name="dp_options[repeater_footer_bar_btns][<?php echo esc_attr( $key ); ?>][icon]" value="<?php echo esc_attr( $option['value'] ); ?>"<?php if ( 'file-text' == $option['value'] ) { echo ' checked="checked"'; } ?>><span class="icon icon-<?php echo esc_attr( $option['value'] ); ?>"></span><?php esc_html_e( $option['label'], 'tcd-w' ); ?></label></p>
           <?php endforeach; ?>
          </td>
         </tr>
        </table>
        <p class="delete-row right-align"><a href="#" class="button button-secondary button-delete-row"><?php _e( 'Delete item', 'tcd-w' ); ?></a></p>
       </div>
      </div>
<?php
    $clone = ob_get_clean();
?>
     </div>
     <a href="#" class="button button-secondary button-add-row" data-clone="<?php echo esc_attr( $clone ); ?>"><?php _e( 'Add item', 'tcd-w' ); ?></a>
    </div>
    <input type="submit" class="button-ml" value="<?php _e( 'Save Changes', 'tcd-w' ); ?>"> 
						
					</div>
  				</div><!-- END #tab-content7 -->

  </div><!-- END #tab-panel -->

  </form>

  </div><!-- END #my_theme_right -->

 </div><!-- END #my_theme_option -->

</div><!-- END #wrap -->

<?php

 }


/**
 * チェック
 */
function theme_options_validate( $input ) {

 #TODO 新規追加項目の入力チェック追加＆不要項目削除

 global $hover_type_options, $hover2_direct_options, $basefont_options, $tcd_font_manager,$headline_font_type_options, $sns_type_btm_options, $load_time_options, $sns_type_top_options, $footer_bar_icon_options, $footer_bar_button_options, $footer_bar_display_options, $gmap_marker_type_options, $gmap_custom_marker_type_options;

 // 色の設定
 $input['pickedcolor1'] = wp_filter_nohtml_kses( $input['pickedcolor1'] );
 $input['pickedcolor2'] = wp_filter_nohtml_kses( $input['pickedcolor2'] );
 $input['pickedcolor3'] = wp_filter_nohtml_kses( $input['pickedcolor3'] );
 $input['pickedcolor4'] = wp_filter_nohtml_kses( $input['pickedcolor4'] );

 // フォントサイズ
 $input['title_font_size'] = wp_filter_nohtml_kses( $input['title_font_size'] );
 $input['archive_title_font_size'] = wp_filter_nohtml_kses( $input['archive_title_font_size'] );
 $input['content_font_size'] = wp_filter_nohtml_kses( $input['content_font_size'] );

   // フォントリストのバリデーション
   $input['font_list'] = San\repeater(
	$input['font_list'],
	function( $font_item ) use ( $tcd_font_manager ) {
	  return [
		'type'      => San\choice( $font_item['type'] ?? 'system', [ 'system', 'web' ] ),
		'weight'    => San\choice( $font_item['weight'] ?? 'normal', [ 'normal', 'bold' ] ),
		'japan'     => San\choice( $font_item['japan'] ?? '', array_keys( $tcd_font_manager->system_font_japan ) ),
		'latin'     => San\choice( $font_item['latin'] ?? '', array_keys( $tcd_font_manager->system_font_latin ) ),
		'web_japan' => San\choice( $font_item['web_japan'] ?? '', array_merge( [ '' ], array_keys( $tcd_font_manager->web_font_japan ) ) ),
		'web_latin' => San\choice( $font_item['web_latin'] ?? '', array_merge( [ '' ], array_keys( $tcd_font_manager->web_font_latin ) ) ),
	  ];
	}
	);

	$input['basefont'] = San\choice( $input['basefont'], [ '1', '2', '3' ] );
	$input['headline_font_type'] = San\choice( $input['headline_font_type'], [ '1', '2', '3' ] );

 // オリジナルスタイルの設定
 $input['css_code'] = $input['css_code'];

 // オリジナルスタイルの設定
 $input['custom_head'] = $input['custom_head'];

 // favicon
 $input['favicon'] = wp_filter_nohtml_kses( $input['favicon'] );

 //絵文字の設定
 if ( ! isset( $input['use_emoji'] ) )
  $input['use_emoji'] = null;
  $input['use_emoji'] = ( $input['use_emoji'] == 1 ? 1 : 0 );

 //hover effect
 if ( ! isset( $input['hover_type'] ) )
  $input['hover_type'] = null;
 if ( ! array_key_exists( $input['hover_type'], $hover_type_options ) )
  $input['hover_type'] = null;

 // hover1
 $input['hover1_zoom'] = wp_filter_nohtml_kses( $input['hover1_zoom'] );
 // hover2
 if ( ! isset( $input['hover2_direct'] ) )
  $input['hover2_direct'] = null;
 if ( ! array_key_exists( $input['hover2_direct'], $hover2_direct_options ) )
  $input['hover2_direct'] = null;
 $input['hover2_opacity'] = wp_filter_nohtml_kses( $input['hover2_opacity'] );
 // hover3
 $input['hover3_opacity'] = wp_filter_nohtml_kses( $input['hover3_opacity'] );
 $input['hover3_bgcolor'] = wp_filter_nohtml_kses( $input['hover3_bgcolor'] );

 //OGPタグ関連
 if ( ! isset( $input['use_ogp'] ) )
  $input['use_ogp'] = null;
  $input['use_ogp'] = ( $input['use_ogp'] == 1 ? 1 : 0 );
 $input['fb_app_id'] = wp_filter_nohtml_kses( $input['fb_app_id'] );

	$input['ogp_image'] = wp_filter_nohtml_kses( $input['ogp_image'] );

 if ( ! isset( $input['use_twitter_card'] ) )
  $input['use_twitter_card'] = null;
  $input['use_twitter_card'] = ( $input['use_twitter_card'] == 1 ? 1 : 0 );
 $input['twitter_account_name'] = wp_filter_nohtml_kses( $input['twitter_account_name'] );

 //ローディング画面の表示設定
 $input['load_time'] = wp_filter_nohtml_kses( $input['load_time'] );

 // ブログ記事一覧の設定
 if ( ! isset( $input['blog_list_show_date'] ) )
  $input['blog_list_show_date'] = null;
  $input['blog_list_show_date'] = ( $input['blog_list_show_date'] == 1 ? 1 : 0 );
 if ( ! isset( $input['blog_list_show_excerpt'] ) )
  $input['blog_list_show_excerpt'] = null;
  $input['blog_list_show_excerpt'] = ( $input['blog_list_show_excerpt'] == 1 ? 1 : 0 );

 // トップページのニュースの設定
 if ( ! isset( $input['news_visible'] ) )
  $input['news_visible'] = null;
  $input['news_visible'] = ( $input['news_visible'] == 1 ? 1 : 0 );

 if ( ! isset( $input['fixed_news'] ) )
  $input['fixed_news'] = null;
  $input['fixed_news'] = ( $input['fixed_news'] == 1 ? 1 : 0 );

 if ( ! isset( $input['show_news_date'] ) )
  $input['show_news_date'] = null;
  $input['show_news_date'] = ( $input['show_news_date'] == 1 ? 1 : 0 );

 if ( ! isset( $input['show_news_date_single'] ) )
  $input['show_news_date_single'] = null;
  $input['show_news_date_single'] = ( $input['show_news_date_single'] == 1 ? 1 : 0 );

 if ( ! isset( $input['show_news_date_archive'] ) )
  $input['show_news_date_archive'] = null;
  $input['show_news_date_archive'] = ( $input['show_news_date_archive'] == 1 ? 1 : 0 );

// Google Maps 
$input['gmap_api_key'] = wp_filter_nohtml_kses( $input['gmap_api_key'] );
if ( ! isset( $input['gmap_marker_type'] ) || ! array_key_exists( $input['gmap_marker_type'], $gmap_marker_type_options ) )
	$input['gmap_marker_type'] = $dp_default_options['gmap_marker_type'];
if ( ! isset( $input['gmap_custom_marker_type'] ) || ! array_key_exists( $input['gmap_custom_marker_type'], $gmap_custom_marker_type_options ) )
	$input['gmap_custom_marker_type'] = $dp_default_options['gmap_custom_marker_type'];
$input['gmap_marker_text'] = wp_filter_nohtml_kses( $input['gmap_marker_text'] );
$input['gmap_marker_color'] = '#'.wp_filter_nohtml_kses( $input['gmap_marker_color'] );
$input['gmap_marker_img'] = wp_filter_nohtml_kses( $input['gmap_marker_img'] );
$input['gmap_marker_bg'] = '#'.wp_filter_nohtml_kses( $input['gmap_marker_bg'] );

	// 404 page
	$input['header_image_404'] = wp_filter_nohtml_kses( $input['header_image_404'] );
	$input['header_txt_404'] = wp_filter_nohtml_kses( $input['header_txt_404'] );
	$input['header_txt_size_404'] = wp_filter_nohtml_kses( $input['header_txt_size_404'] );
	$input['header_txt_color_404'] = wp_filter_nohtml_kses( $input['header_txt_color_404'] );
	$input['dropshadow_404_h'] = wp_filter_nohtml_kses( $input['dropshadow_404_h'] );
	$input['dropshadow_404_v'] = wp_filter_nohtml_kses( $input['dropshadow_404_v'] );
	$input['dropshadow_404_b'] = wp_filter_nohtml_kses( $input['dropshadow_404_b'] );
	$input['dropshadow_404_c'] = wp_filter_nohtml_kses( $input['dropshadow_404_c'] );


 // トップページのブログ記事一覧の設定
 if ( ! isset( $input['show_index_blog'] ) )
  $input['show_index_blog'] = null;
  $input['show_index_blog'] = ( $input['show_index_blog'] == 1 ? 1 : 0 );
 $input['front_blog_bgcolor'] = wp_filter_nohtml_kses( $input['front_blog_bgcolor'] );
 $input['front_blog_headline_color'] = wp_filter_nohtml_kses( $input['front_blog_headline_color'] );
 
  // トップページのフリースペースの設定
  if ( ! isset( $input['show_index_freespace'] ) )
  $input['show_index_freespace'] = null;
  $input['show_index_freespace'] = ( $input['show_index_freespace'] == 1 ? 1 : 0 );
  $input['front_freespace_bgcolor'] = wp_filter_nohtml_kses( $input['front_freespace_bgcolor'] );
  $input['front_freespace_headline_color'] = wp_filter_nohtml_kses( $input['front_freespace_headline_color'] );
  
  if ( ! isset( $input['front_freespace_editor'] ) )
  $input['front_freespace_editor'] = null;
  $input['front_freespace_editor'] =   $input['front_freespace_editor'] ;
  
  if ( ! isset( $input['front_scroll_no_animation'] ) )
  $input['front_scroll_no_animation'] = null;
  $input['front_scroll_no_animation'] = ( $input['front_scroll_no_animation'] == 1 ? 1 : 0 );

 // gnav submenu
 $input['gnav_submenu_color'] = wp_filter_nohtml_kses( $input['gnav_submenu_color'] );
 $input['gnav_submenu_bgcolor'] = wp_filter_nohtml_kses( $input['gnav_submenu_bgcolor'] );
 $input['gnav_submenu_color_hover'] = wp_filter_nohtml_kses( $input['gnav_submenu_color_hover'] );
 $input['gnav_submenu_bgcolor_hover'] = wp_filter_nohtml_kses( $input['gnav_submenu_bgcolor_hover'] );
 $input['gnav_submenu_opacity'] = wp_filter_nohtml_kses( $input['gnav_submenu_opacity'] );

 // footer logo
 $input['logo_font_size_footer'] = wp_filter_nohtml_kses( $input['logo_font_size_footer'] );
 $input['site_desc_font_size_footer'] = wp_filter_nohtml_kses( $input['site_desc_font_size_footer'] );
 $input['footer_logo_image'] = wp_filter_nohtml_kses( $input['footer_logo_image'] );
 if ( ! isset( $input['show_site_desc_footer'] ) )
  $input['show_site_desc_footer'] = null;
  $input['show_site_desc_footer'] = ( $input['show_site_desc_footer'] == 1 ? 1 : 0 );

 // トップページ表示項目設定
 $index_section_items = array();
  foreach($input['repeater_index_section_items'] as $key => $value) {
   $index_section_items[] = array(
    'image' => isset($input['repeater_index_section_items'][$key]['image']) ? $input['repeater_index_section_items'][$key]['image'] : '',
    'use_overlay' => !empty($input['repeater_index_section_items'][$key]['use_overlay']) ? 1 : 0,
    'overlay' => isset($input['repeater_index_section_items'][$key]['overlay']) ? $input['repeater_index_section_items'][$key]['overlay'] : '',
    'overlay_opacity' => isset($input['repeater_index_section_items'][$key]['overlay_opacity']) ? wp_filter_nohtml_kses($input['repeater_index_section_items'][$key]['overlay_opacity']) : '',
    'use_headline' => !empty($input['repeater_index_section_items'][$key]['use_headline']) ? 1 : 0,
    'headline' => isset($input['repeater_index_section_items'][$key]['headline']) ? wp_filter_nohtml_kses($input['repeater_index_section_items'][$key]['headline']) : '',
    'headline_fontsize' => isset($input['repeater_index_section_items'][$key]['headline_fontsize']) ? wp_filter_nohtml_kses($input['repeater_index_section_items'][$key]['headline_fontsize']) : '',
    'headline_color' => isset($input['repeater_index_section_items'][$key]['headline_color']) ? $input['repeater_index_section_items'][$key]['headline_color'] : '',
    'dropshadow_h' => isset($input['repeater_index_section_items'][$key]['dropshadow_h']) ? $input['repeater_index_section_items'][$key]['dropshadow_h'] : '',
    'dropshadow_v' => isset($input['repeater_index_section_items'][$key]['dropshadow_v']) ? $input['repeater_index_section_items'][$key]['dropshadow_v'] : '',
    'dropshadow_b' => isset($input['repeater_index_section_items'][$key]['dropshadow_b']) ? $input['repeater_index_section_items'][$key]['dropshadow_b'] : '',
    'dropshadow_c' => isset($input['repeater_index_section_items'][$key]['dropshadow_c']) ? $input['repeater_index_section_items'][$key]['dropshadow_c'] : '',
    'use_desc' => !empty($input['repeater_index_section_items'][$key]['use_desc']) ? 1 : 0,
    'desc' => isset($input['repeater_index_section_items'][$key]['desc']) ? wp_filter_nohtml_kses($input['repeater_index_section_items'][$key]['desc']) : '',
    'desc_fontsize' => isset($input['repeater_index_section_items'][$key]['desc_fontsize']) ? wp_filter_nohtml_kses($input['repeater_index_section_items'][$key]['desc_fontsize']) : '',
    'desc_color' => isset($input['repeater_index_section_items'][$key]['desc_color']) ? $input['repeater_index_section_items'][$key]['desc_color'] : '',
    'dropshadow_desc_h' => isset($input['repeater_index_section_items'][$key]['dropshadow_desc_h']) ? $input['repeater_index_section_items'][$key]['dropshadow_desc_h'] : '',
    'dropshadow_desc_v' => isset($input['repeater_index_section_items'][$key]['dropshadow_desc_v']) ? $input['repeater_index_section_items'][$key]['dropshadow_desc_v'] : '',
    'dropshadow_desc_b' => isset($input['repeater_index_section_items'][$key]['dropshadow_desc_b']) ? $input['repeater_index_section_items'][$key]['dropshadow_desc_b'] : '',
    'dropshadow_desc_c' => isset($input['repeater_index_section_items'][$key]['dropshadow_desc_c']) ? $input['repeater_index_section_items'][$key]['dropshadow_desc_c'] : '',
    'use_btn' => !empty($input['repeater_index_section_items'][$key]['use_btn']) ? 1 : 0,
    'use_ghost_btn' => !empty($input['repeater_index_section_items'][$key]['use_ghost_btn']) ? 1 : 0,
    'btn_label' => isset($input['repeater_index_section_items'][$key]['btn_label']) ? wp_filter_nohtml_kses($input['repeater_index_section_items'][$key]['btn_label']) : '',
    'btn_url' => isset($input['repeater_index_section_items'][$key]['btn_url']) ? wp_filter_nohtml_kses($input['repeater_index_section_items'][$key]['btn_url']) : '',
    'btn_url_target' => !empty($input['repeater_index_section_items'][$key]['btn_url_target']) ? 1 : 0,
    'btn_color' => isset($input['repeater_index_section_items'][$key]['btn_color']) ? $input['repeater_index_section_items'][$key]['btn_color'] : '',
    'btn_bgcolor' => isset($input['repeater_index_section_items'][$key]['btn_bgcolor']) ? $input['repeater_index_section_items'][$key]['btn_bgcolor'] : '',
    'btn_bordercolor' => isset($input['repeater_index_section_items'][$key]['btn_bordercolor']) ? $input['repeater_index_section_items'][$key]['btn_bordercolor'] : '',
    'btn_hover_color' => isset($input['repeater_index_section_items'][$key]['btn_hover_color']) ? $input['repeater_index_section_items'][$key]['btn_hover_color'] : '',
    'btn_hover_bgcolor' => isset($input['repeater_index_section_items'][$key]['btn_hover_bgcolor']) ? $input['repeater_index_section_items'][$key]['btn_hover_bgcolor'] : '',
    'btn_bg_opacity' => isset($input['repeater_index_section_items'][$key]['btn_bg_opacity']) ? wp_filter_nohtml_kses($input['repeater_index_section_items'][$key]['btn_bg_opacity']) : '',
   );
  }
 $input['index_section_items'] = $index_section_items;

 // 記事ページの設定
 if ( ! isset( $input['show_date'] ) )
  $input['show_date'] = null;
  $input['show_date'] = ( $input['show_date'] == 1 ? 1 : 0 );
 if ( ! isset( $input['show_comment'] ) )
  $input['show_comment'] = null;
  $input['show_comment'] = ( $input['show_comment'] == 1 ? 1 : 0 );
 if ( ! isset( $input['show_related_post'] ) )
  $input['show_related_post'] = null;
  $input['show_related_post'] = ( $input['show_related_post'] == 1 ? 1 : 0 );
 if ( ! isset( $input['show_next_post'] ) )
  $input['show_next_post'] = null;
  $input['show_next_post'] = ( $input['show_next_post'] == 1 ? 1 : 0 );
 if ( ! isset( $input['show_thumbnail'] ) )
  $input['show_thumbnail'] = null;
  $input['show_thumbnail'] = ( $input['show_thumbnail'] == 1 ? 1 : 0 );
 if ( ! isset( $input['show_author'] ) )
  $input['show_author'] = null;
  $input['show_author'] = ( $input['show_author'] == 1 ? 1 : 0 );
 $input['single_ad_code1'] = $input['single_ad_code1'];
 $input['single_ad_image1'] = wp_filter_nohtml_kses( $input['single_ad_image1'] );
 $input['single_ad_url1'] = wp_filter_nohtml_kses( $input['single_ad_url1'] );
 $input['single_ad_code2'] = $input['single_ad_code2'];
 $input['single_ad_image2'] = wp_filter_nohtml_kses( $input['single_ad_image2'] );
 $input['single_ad_url2'] = wp_filter_nohtml_kses( $input['single_ad_url2'] );
 $input['single_ad_code3'] = $input['single_ad_code3'];
 $input['single_ad_image3'] = wp_filter_nohtml_kses( $input['single_ad_image3'] );
 $input['single_ad_url3'] = wp_filter_nohtml_kses( $input['single_ad_url3'] );
 $input['single_ad_code4'] = $input['single_ad_code4'];
 $input['single_ad_image4'] = wp_filter_nohtml_kses( $input['single_ad_image4'] );
 $input['single_ad_url4'] = wp_filter_nohtml_kses( $input['single_ad_url4'] );

 $input['single_ad_code_m1'] = $input['single_ad_code_m1'];
 $input['single_ad_image_m1'] = wp_filter_nohtml_kses( $input['single_ad_image_m1'] );
 $input['single_ad_url_m1'] = wp_filter_nohtml_kses( $input['single_ad_url_m1'] );
 $input['single_ad_code_m2'] = $input['single_ad_code_m2'];
 $input['single_ad_image_m2'] = wp_filter_nohtml_kses( $input['single_ad_image_m2'] );
 $input['single_ad_url_m2'] = wp_filter_nohtml_kses( $input['single_ad_url_m2'] );

 // min height
 $input['min_height_sidebar'] = wp_filter_nohtml_kses( $input['min_height_sidebar'] );

 // shop name
 $input['shop_name_fontsize_side'] = wp_filter_nohtml_kses( $input['shop_name_fontsize_side'] );
 $input['shop_name_fontsize_foot'] = wp_filter_nohtml_kses( $input['shop_name_fontsize_foot'] );
 $input['shop_addr_fontsize_side'] = wp_filter_nohtml_kses( $input['shop_addr_fontsize_side'] );
 $input['shop_addr_fontsize_foot'] = wp_filter_nohtml_kses( $input['shop_addr_fontsize_foot'] );
 $input['shop_tel_fontsize_side'] = wp_filter_nohtml_kses( $input['shop_tel_fontsize_side'] );
 $input['shop_tel_fontsize_foot'] = wp_filter_nohtml_kses( $input['shop_tel_fontsize_foot'] );


 //商品ページ
 if ( ! isset( $input['show_next_post_product'] ) )
  $input['show_next_post_product'] = null;
  $input['show_next_post_product'] = ( $input['show_next_post_product'] == 1 ? 1 : 0 );
 if ( ! isset( $input['show_product_category'] ) )
  $input['show_product_category'] = null;
  $input['show_product_category'] = ( $input['show_product_category'] == 1 ? 1 : 0 );
 if ( ! isset( $input['show_product_carousel'] ) )
  $input['show_product_carousel'] = null;
  $input['show_product_carousel'] = ( $input['show_product_carousel'] == 1 ? 1 : 0 );


 // SNSボタンの設定
 $input['snsurl_twitter'] = wp_filter_nohtml_kses( $input['snsurl_twitter'] );
 $input['snsurl_facebook'] = wp_filter_nohtml_kses( $input['snsurl_facebook'] );
 $input['snsurl_instagram'] = wp_filter_nohtml_kses( $input['snsurl_instagram'] );
 $input['snsurl_pinterest'] = wp_filter_nohtml_kses( $input['snsurl_pinterest'] );
 $input['snsurl_flickr'] = wp_filter_nohtml_kses( $input['snsurl_flickr'] );
 $input['snsurl_tumblr'] = wp_filter_nohtml_kses( $input['snsurl_tumblr'] );

 //ロゴの位置
 if(isset($input['logotop'])){
	 $input['logotop'] = intval($input['logotop']);
 }
 if(isset($input['logoleft'])){
	 $input['logoleft'] = intval($input['logoleft']);
 }

 //ファイルアップロード
 if(isset($_FILES['dp_image'])){
	$message = _dp_upload_logo();
	add_settings_error('design_plus_options', 'default', $message['message'], ($message['error'] ? 'error' : 'updated'));
 }

 //画像リサイズ
 if(isset($_REQUEST['dp_logo_resize_left'], $_REQUEST['dp_logo_resize_top']) && is_numeric($_REQUEST['dp_logo_resize_left']) && is_numeric($_REQUEST['dp_logo_resize_top'])){
	$message = _dp_resize_logo();
	add_settings_error('design_plus_options', 'default', $message['message'], ($message['error'] ? 'error' : 'updated'));
 }

 //背景画像の登録
/*
 for($i = 1; $i <= 3; $i++){
    $message = _dp_upload_bg_image($i);
    add_settings_error('design_plus_options', 'default', $message['message'], ($message['error'] ? 'error' : 'updated'));
 }
*/

 // ブログ関係
//ブログコンテンツの設定
	$input['blog_image'] = wp_filter_nohtml_kses( $input['blog_image'] );
	$input['blog_headline'] = wp_filter_nohtml_kses( $input['blog_headline'] );
	$input['blog_headline_font_size'] = wp_filter_nohtml_kses( $input['blog_headline_font_size'] );
	$input['blog_headline_color'] = wp_filter_nohtml_kses( $input['blog_headline_color'] );
	$input['blog_headline_shadow1'] = wp_filter_nohtml_kses( $input['blog_headline_shadow1'] );
	$input['blog_headline_shadow2'] = wp_filter_nohtml_kses( $input['blog_headline_shadow2'] );
	$input['blog_headline_shadow3'] = wp_filter_nohtml_kses( $input['blog_headline_shadow3'] );
	$input['blog_headline_shadow_color'] = wp_filter_nohtml_kses( $input['blog_headline_shadow_color'] );

	//ブログ記事ページのフォントサイズ
	$input['title_font_size'] = wp_filter_nohtml_kses( $input['title_font_size'] );
	$input['content_font_size'] = wp_filter_nohtml_kses( $input['content_font_size'] );

	//アーカイブページの設定
	if ( ! isset( $input['archive_show_date'] ) )
		$input['archive_show_date'] = null;
	$input['archive_show_date'] = ( $input['archive_show_date'] == 1 ? 1 : 0 );
	if ( ! isset( $input['archive_show_category'] ) )
		$input['archive_show_category'] = null;
	$input['archive_show_category'] = ( $input['archive_show_category'] == 1 ? 1 : 0 );

	//ブログ記事ページの表示設定
	if ( ! isset( $input['show_date'] ) )
		$input['show_date'] = null;
	$input['show_date'] = ( $input['show_date'] == 1 ? 1 : 0 );
	if ( ! isset( $input['show_comment'] ) )
		$input['show_comment'] = null;
	$input['show_comment'] = ( $input['show_comment'] == 1 ? 1 : 0 );
	if ( ! isset( $input['show_related_post'] ) )
		$input['show_related_post'] = null;
	$input['show_related_post'] = ( $input['show_related_post'] == 1 ? 1 : 0 );
	if ( ! isset( $input['show_next_post'] ) )
		$input['show_next_post'] = null;
	$input['show_next_post'] = ( $input['show_next_post'] == 1 ? 1 : 0 );
	if ( ! isset( $input['show_thumbnail'] ) )
		$input['show_thumbnail'] = null;
	$input['show_thumbnail'] = ( $input['show_thumbnail'] == 1 ? 1 : 0 );
	if ( ! isset( $input['show_author'] ) )
		$input['show_author'] = null;
	$input['show_author'] = ( $input['show_author'] == 1 ? 1 : 0 );

	//ソーシャルボタンの表示設定
	if ( ! isset( $input['sns_type_top'] ) )
		$input['sns_type_top'] = null;
	if ( ! array_key_exists( $input['sns_type_top'], $sns_type_top_options ) )
		$input['sns_type_top'] = null;
	if ( ! isset( $input['show_sns_top'] ) )
		$input['show_sns_top'] = null;
	$input['show_sns_top'] = ( $input['show_sns_top'] == 1 ? 1 : 0 );
	if ( ! isset( $input['show_twitter_top'] ) )
		$input['show_twitter_top'] = null;
	$input['show_twitter_top'] = ( $input['show_twitter_top'] == 1 ? 1 : 0 );
	if ( ! isset( $input['show_fblike_top'] ) )
		$input['show_fblike_top'] = null;
	$input['show_fblike_top'] = ( $input['show_fblike_top'] == 1 ? 1 : 0 );
	if ( ! isset( $input['show_fbshare_top'] ) )
		$input['show_fbshare_top'] = null;
	$input['show_fbshare_top'] = ( $input['show_fbshare_top'] == 1 ? 1 : 0 );
	if ( ! isset( $input['show_hatena_top'] ) )
		$input['show_hatena_top'] = null;
	$input['show_hatena_top'] = ( $input['show_hatena_top'] == 1 ? 1 : 0 );
	if ( ! isset( $input['show_pocket_top'] ) )
		$input['show_pocket_top'] = null;
	$input['show_pocket_top'] = ( $input['show_pocket_top'] == 1 ? 1 : 0 );
	if ( ! isset( $input['show_feedly_top'] ) )
		$input['show_feedly_top'] = null;
	$input['show_feedly_top'] = ( $input['show_feedly_top'] == 1 ? 1 : 0 );
	if ( ! isset( $input['show_rss_top'] ) )
		$input['show_rss_top'] = null;
	$input['show_rss_top'] = ( $input['show_rss_top'] == 1 ? 1 : 0 );
	if ( ! isset( $input['show_pinterest_top'] ) )
		$input['show_pinterest_top'] = null;
	$input['show_pinterest_top'] = ( $input['show_pinterest_top'] == 1 ? 1 : 0 );
	if ( ! isset( $input['show_line_top'] ) )
		$input['show_line_top'] = null;
	$input['show_line_top'] = ( $input['show_line_top'] == 1 ? 1 : 0 );
	if ( ! isset( $input['show_note_top'] ) )
		$input['show_note_top'] = null;
	$input['show_note_top'] = ( $input['show_note_top'] == 1 ? 1 : 0 );

	if ( ! isset( $input['sns_type_btm'] ) )
		$input['sns_type_btm'] = null;
	if ( ! array_key_exists( $input['sns_type_btm'], $sns_type_btm_options ) )
		$input['sns_type_btm'] = null;
	if ( ! isset( $input['show_sns_btm'] ) )
		$input['show_sns_btm'] = null;
	$input['show_sns_btm'] = ( $input['show_sns_btm'] == 1 ? 1 : 0 );
	if ( ! isset( $input['show_twitter_btm'] ) )
		$input['show_twitter_btm'] = null;
	$input['show_twitter_btm'] = ( $input['show_twitter_btm'] == 1 ? 1 : 0 );
	if ( ! isset( $input['show_fblike_btm'] ) )
		$input['show_fblike_btm'] = null;
	$input['show_fblike_btm'] = ( $input['show_fblike_btm'] == 1 ? 1 : 0 );
	if ( ! isset( $input['show_fbshare_btm'] ) )
		$input['show_fbshare_btm'] = null;
	$input['show_fbshare_btm'] = ( $input['show_fbshare_btm'] == 1 ? 1 : 0 );
	if ( ! isset( $input['show_hatena_btm'] ) )
		$input['show_hatena_btm'] = null;
	$input['show_hatena_btm'] = ( $input['show_hatena_btm'] == 1 ? 1 : 0 );
	if ( ! isset( $input['show_pocket_btm'] ) )
		$input['show_pocket_btm'] = null;
	$input['show_pocket_btm'] = ( $input['show_pocket_btm'] == 1 ? 1 : 0 );
	if ( ! isset( $input['show_feedly_btm'] ) )
		$input['show_feedly_btm'] = null;
	$input['show_feedly_btm'] = ( $input['show_feedly_btm'] == 1 ? 1 : 0 );
	if ( ! isset( $input['show_rss_btm'] ) )
		$input['show_rss_btm'] = null;
	$input['show_rss_btm'] = ( $input['show_rss_btm'] == 1 ? 1 : 0 );
	if ( ! isset( $input['show_pinterest_btm'] ) )
		$input['show_pinterest_btm'] = null;
	$input['show_pinterest_btm'] = ( $input['show_pinterest_btm'] == 1 ? 1 : 0 );
	if ( ! isset( $input['show_line_btm'] ) )
		$input['show_line_btm'] = null;
	$input['show_line_btm'] = ( $input['show_line_btm'] == 1 ? 1 : 0 );
	if ( ! isset( $input['show_note_btm'] ) )
		$input['show_note_btm'] = null;
	$input['show_note_btm'] = ( $input['show_note_btm'] == 1 ? 1 : 0 );


 // スマホ用固定フッターバーの設定
 if ( ! array_key_exists( $input['footer_bar_display'], $footer_bar_display_options ) )
  $input['footer_bar_display'] = 'type3';
 $input['footer_bar_bg'] = wp_filter_nohtml_kses( $input['footer_bar_bg'] );
 $input['footer_bar_border'] = wp_filter_nohtml_kses( $input['footer_bar_border'] );
 $input['footer_bar_color'] = wp_filter_nohtml_kses( $input['footer_bar_color'] );
 $input['footer_bar_tp'] = wp_filter_nohtml_kses( $input['footer_bar_tp'] );

 $footer_bar_btns = array();
 if ( isset( $input['repeater_footer_bar_btns'] ) ) {
    foreach ( $input['repeater_footer_bar_btns'] as $key => $value ) {
    $footer_bar_btns[] = array(
     'type' => ( isset( $input['repeater_footer_bar_btns'][$key]['type'] ) && array_key_exists( $input['repeater_footer_bar_btns'][$key]['type'], $footer_bar_button_options ) ) ? $input['repeater_footer_bar_btns'][$key]['type'] : 'type1',
     'label' => isset( $input['repeater_footer_bar_btns'][$key]['label'] ) ? wp_filter_nohtml_kses( $input['repeater_footer_bar_btns'][$key]['label'] ) : '',
     'url' => isset( $input['repeater_footer_bar_btns'][$key]['url'] ) ? wp_filter_nohtml_kses( $input['repeater_footer_bar_btns'][$key]['url'] ) : '',
     'number' => isset( $input['repeater_footer_bar_btns'][$key]['number'] ) ? wp_filter_nohtml_kses( $input['repeater_footer_bar_btns'][$key]['number'] ) : '',
     'target' => ! empty( $input['repeater_footer_bar_btns'][$key]['target'] ) ? 1 : 0,
     'icon' => ( isset( $input['repeater_footer_bar_btns'][$key]['icon'] ) && array_key_exists( $input['repeater_footer_bar_btns'][$key]['icon'], $footer_bar_icon_options ) ) ? $input['repeater_footer_bar_btns'][$key]['icon'] : 'file-text'
    );
  }

 }
 $input['footer_bar_btns'] = $footer_bar_btns;



	//ブログ記事ページのバナー広告
	$input['single_ad_code1'] = $input['single_ad_code1'];
	$input['single_ad_image1'] = wp_filter_nohtml_kses( $input['single_ad_image1'] );
	$input['single_ad_url1'] = wp_filter_nohtml_kses( $input['single_ad_url1'] );
	$input['single_ad_code2'] = $input['single_ad_code2'];
	$input['single_ad_image2'] = wp_filter_nohtml_kses( $input['single_ad_image2'] );
	$input['single_ad_url2'] = wp_filter_nohtml_kses( $input['single_ad_url2'] );
	$input['single_ad_code3'] = $input['single_ad_code3'];
	$input['single_ad_image3'] = wp_filter_nohtml_kses( $input['single_ad_image3'] );
	$input['single_ad_url3'] = wp_filter_nohtml_kses( $input['single_ad_url3'] );
	$input['single_ad_code4'] = $input['single_ad_code4'];
	$input['single_ad_image4'] = wp_filter_nohtml_kses( $input['single_ad_image4'] );
	$input['single_ad_url4'] = wp_filter_nohtml_kses( $input['single_ad_url4'] );
	$input['single_ad_code5'] = $input['single_ad_code5'];
	$input['single_ad_image5'] = wp_filter_nohtml_kses( $input['single_ad_image5'] );
	$input['single_ad_url5'] = wp_filter_nohtml_kses( $input['single_ad_url5'] );
	$input['single_ad_code6'] = $input['single_ad_code6'];
	$input['single_ad_image6'] = wp_filter_nohtml_kses( $input['single_ad_image6'] );
	$input['single_ad_url6'] = wp_filter_nohtml_kses( $input['single_ad_url6'] );


   if(isset($_FILES['favicon_file'])){
     //画像のアップロードに問題はないか
     if($_FILES['favicon_file']['error'] === 0){
       $name = sanitize_file_name($_FILES['favicon_file']['name']);
       //ファイル形式をチェック
       if(!preg_match("/\.(png|ico|gif)$/i", $name)){
         add_settings_error('design_plus_options', 'dp_uploader', sprintf(__('You uploaded %s but allowed file format is PNG, GIF and JPG.', 'tcd-w'), $name), 'error');
       }else{
        //ディレクトリの存在をチェック
        if(
          (
            (file_exists(dp_logo_basedir()) && is_dir(dp_logo_basedir()) && is_writable(dp_logo_basedir()) )
              ||
            @mkdir(dp_logo_basedir())
          )
            &&
          move_uploaded_file($_FILES['favicon_file']['tmp_name'], dp_logo_basedir().DIRECTORY_SEPARATOR.$name)
        ){
          $input['favicon'] = dp_logo_baseurl().'/'.$name;
        }else{
          add_settings_error('default', 'dp_uploader', sprintf(__('Directory %s is not writable. Please check permission.', 'tcd-w'), dp_logo_basedir()), 'error');
          //break;
        }
       }
     }elseif($_FILES['favicon_file']['error'] !== UPLOAD_ERR_NO_FILE){
       add_settings_error('default', 'dp_uploader', _dp_get_upload_err_msg($_FILES['favicon_file']['error']), 'error');
       //continue;
     }
   }

 return $input;
}

?>
