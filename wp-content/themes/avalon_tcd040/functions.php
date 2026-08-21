<?php


// 言語ファイル --------------------------------------------------------------------------------
load_textdomain('tcd-w', dirname(__FILE__).'/languages/tcd-avalon-' . determine_locale() . '.mo');
load_textdomain('tcd-avalon', dirname(__FILE__).'/languages/tcd-avalon-' . determine_locale() . '.mo');



// style.cssのDescriptionをPoedit等に認識させる
__( 'WordPress theme "Avalon" was developed for a stylish bar. The up and down scrolling content is impressive from the first view. The two-column design is easy to use and tells the story of yours effectively.', 'tcd-avalon' );


// hook wp_head --------------------------------------------------------------------------------
require get_template_directory() . '/functions/head.php';


// テーマオプション --------------------------------------------------------------------------------
require_once ( dirname(__FILE__) . '/admin/theme-options.php' );

// セットアップ -------------------------------------------------------------------------------
require_once ( dirname(__FILE__) . '/functions/theme-setup.php' );

// 更新通知 --------------------------------------------------------------------------------
require_once ( dirname(__FILE__) . '/functions/update_notifier.php' );


// マニュアル --------------------------------------------------------------------------------
require_once  ( dirname(__FILE__) . '/functions/manual.php' );


// カスタマイザー設定( 外観 > ウィジェットから設定を取り除く)--------------------------------------------------------------------------------
require_once  ( dirname(__FILE__) . '/functions/customizer.php' );

// 「トップページ」と「ブログ一覧ページ」用の固定ページ作成機能の実装----------------------------------
require_once  ( dirname(__FILE__) . '/functions/class-page-new.php' );

// 新フォント機能 --------------------------------------------------------------------------------
require_once ( dirname(__FILE__) . '/admin/font/hooks-font.php' );


// Javascriptの読み込み -----------------------------------------------------------------------
function widget_admin_scripts() {
  wp_enqueue_script('thickbox');
  wp_enqueue_script('media-upload');
  wp_enqueue_style('imgareaselect');
  wp_enqueue_script('font_ui', get_template_directory_uri().'/admin/font/ui/font_ui.js', '', '1.0.4', true);
  wp_enqueue_script('ml-widget-js', get_template_directory_uri().'/widget/js/script.js', '', '1', true);
  wp_enqueue_script('dp-image-manager', get_template_directory_uri().'/admin/js/image-manager.js', array('jquery', 'jquery-ui-draggable', 'imgareaselect'));
  wp_enqueue_script('jscolor', get_template_directory_uri().'/admin/js/jscolor.js');
  wp_enqueue_script('jquery.cookieTab', get_template_directory_uri().'/admin/js/jquery.cookieTab.js');
  wp_enqueue_script('my_script', get_template_directory_uri().'/admin/js/my_script.js', '', '2.0.0', true);
  wp_enqueue_script('ml-rebox-js', get_template_directory_uri().'/admin/js/rebox/jquery-rebox.js', '', '1', true);
	wp_enqueue_media();//画像アップロード用
?>
<script type="text/javascript">
  var cfmf_text = { title:'<?php _e('Please Select Image', 'tcd-w'); ?>', button:'<?php _e('Use this Image', 'tcd-w'); ?>' };
</script>
<?php
  wp_enqueue_script('cf-media-field', get_template_directory_uri().'/admin/js/cf-media-field.js', '', '1.1', true); //画像アップロード用
  wp_localize_script( 'cf-media-field', 'cfmf_text', array(
    'image_title' => __( 'Please select image', 'tcd-w' ),
    'image_button' => __( 'Use this image', 'tcd-w' ),
    'video_title' => __( 'Please select MP4 file', 'tcd-w' ),
    'video_button' => __( 'Use this MP4 file', 'tcd-w' )
  ) );
}
add_action('admin_print_scripts', 'widget_admin_scripts');


// スタイルシートの読み込み -----------------------------------------------------------------------
function my_admin_styles() {
  wp_enqueue_style('thickbox');
  wp_enqueue_style('font_ui_css', get_template_directory_uri() . '/admin/font/ui/font_ui.css','','1.0.0');
  wp_enqueue_style('my_widget_css', get_template_directory_uri() . '/widget/css/style.css','','1.0.0');
  wp_enqueue_style('my_admin_css', get_template_directory_uri() .'/admin/css/my_admin.css','','2.0.0');
  wp_enqueue_style('repeater_css', get_template_directory_uri() .'/admin/css/repeater.css','','2.0.0');
  wp_enqueue_style('ml-rebox-style', get_template_directory_uri() . '/admin/js/rebox/jquery-rebox.css','','1.0.0');
}
add_action('admin_print_styles', 'my_admin_styles');

function my_general_styles() {
    $stylesheet_dir_uri = get_template_directory_uri();
    wp_enqueue_style('bootstrap.min', $stylesheet_dir_uri . '/bootstrap.min.css', false, version_num(), 'all');
    // style.cssをbootstrap.min.cssの後に出力する為、一旦削除する
    wp_dequeue_style('style');
    if(is_no_resposive() === TRUE) {
        wp_enqueue_style('style_no_responsive', $stylesheet_dir_uri . '/style_no_responsive.css', array('bootstrap.min'));
    } else {
        wp_enqueue_style('style', $stylesheet_dir_uri . '/style.css', array('bootstrap.min'));
        wp_enqueue_style('responsive', $stylesheet_dir_uri . '/responsive.css', false, version_num(), 'screen and (max-width:1024px)');
    }
    wp_enqueue_style('fullpage.min', $stylesheet_dir_uri . '/fullpage.min.css', false, version_num(), 'all');
}
add_action('wp_enqueue_styles', 'my_general_styles' );

function my_general_scripts() {
    wp_enqueue_script('jquery.min', 'https://ajax.googleapis.com/ajax/libs/jquery/1.12.3/jquery.min.js', false, false, false);
    $script_dir_uri = get_template_directory_uri() . "/js";
    wp_enqueue_script('bootstrap.min', $script_dir_uri . '/bootstrap.min.js', false, version_num(), false);
    wp_enqueue_script('jquery.newsticker', $script_dir_uri . '/jquery.newsticker.js', false, version_num(), false);
    wp_enqueue_script('menu', $script_dir_uri . '/menu.js', false, version_num(), false);
    wp_enqueue_script('jquery.easings.min', $script_dir_uri . '/jquery.easings.min.js', false, version_num(), false);
    wp_enqueue_script('fullpage.min', $script_dir_uri . '/fullpage.min.js', false, version_num(), false);
    wp_enqueue_script('easings.min', $script_dir_uri . '/easings.min.js', false, version_num(), false);
    wp_enqueue_script('scrolloverflow.min', $script_dir_uri . '/scrolloverflow.min.js', false, version_num(), false);
    wp_enqueue_script('jquery.inview.min', $script_dir_uri . '/jquery.inview.min.js', false, version_num(), false);

    // TCDCE対策のため、クイックタグスタイルをstyle.cssから分離させる
    // NOTE: スタイルの優先度に影響を与えないよう、style.cssの直後に読み込み
	wp_enqueue_style( 'design-plus', get_template_directory_uri() . '/css/design-plus.css', array(), version_num() );
}
add_action('wp_enqueue_scripts', 'my_general_styles' );
add_action('wp_enqueue_scripts', 'my_general_scripts' );

// ビジュアルエディタにクイックタグを追加 --------------------------------------------------------------------------------
require get_template_directory() . '/functions/custom_editor.php';

// 管理画面のクイック編集 --------------------------------------------------------------------------------
require get_template_directory() . '/functions/quick_edit.php';

// カスタムフィールド用メタボックス --------------------------------------------------------------------------------
require get_template_directory() . '/functions/page_cf2.php';
require get_template_directory() . '/functions/page_cf.php';
require get_template_directory() . '/functions/box_size.php';
require get_template_directory() . '/functions/product.php';
require get_template_directory() . '/functions/news.php';
require get_template_directory() . '/functions/recommend.php';
require get_template_directory() . '/functions/repeater.php';
require get_template_directory() . '/functions/repeater_staff.php';
require get_template_directory() . '/functions/repeater_menu.php';


// ウィジェット ------------------------------------------------------------------------
require_once ( dirname(__FILE__) . '/widget/ad.php' );
require_once ( dirname(__FILE__) . '/widget/styled_post_list1.php' );
require_once ( dirname(__FILE__) . '/widget/category_list.php' );
require_once ( dirname(__FILE__) . '/widget/google_search.php' );
require_once ( dirname(__FILE__) . '/widget/archive_list.php' );
require_once ( dirname(__FILE__) . '/widget/custom_menu.php' );


// meta title meta description  --------------------------------------------------------------------------------
require_once ( dirname(__FILE__) . '/functions/seo.php' );


// カスタムページリンク  --------------------------------------------------------------------------------
require_once ( dirname(__FILE__) . '/functions/custom_page_link.php' );


// OGP tag  -------------------------------------------------------------------------------------------
require get_template_directory() . '/functions/ogp.php';


// ショートコード --------------------------------------------------------------------------------
require get_template_directory() . '/functions/short_code.php';


//ロゴ画像用関数 --------------------------------------------------------------------------------
require_once ( dirname(__FILE__) . '/functions/header-logo.php' );

//ロゴ用関数 --------------------------------------------------------------------------------
require_once ( dirname(__FILE__) . '/functions/logo.php' );

// プラグインインストーラー
require_once get_template_directory() . '/functions/class-plugin-installer.php';

// ページビルダー --------------------------------------------------------------------------------
// 新ページビルダー
require get_template_directory() . '/pagebuilder/pagebuilder.php';

// 旧ページビルダー
/*require get_template_directory() . '/functions/page_builder.php';
function page_builder_styles() {
  wp_enqueue_style('page_builder_css', get_template_directory_uri() . '/admin/css/page_builder.css');
}
add_action('admin_print_styles', 'page_builder_styles');
function page_builder_scripts() {
  wp_enqueue_script('page_builder_js', get_template_directory_uri().'/admin/js/page_builder.js', '', '1.0.0', true);
}
add_action('admin_print_scripts', 'page_builder_scripts');*/

// カスタムCSS --------------------------------------------------------------------------------
require get_template_directory() . '/functions/custom_css.php';


//トップページ設定用関数 --------------------------------------------------------------------------------
require_once ( dirname(__FILE__) . '/functions/index-page.php' );

// 次のページリンク  --------------------------------------------------------------------------------
require_once ( dirname(__FILE__) . '/functions/next_prev.php' );

// ユーザーエージェントを判定するための関数---------------------------------------------------------------------
function is_mobile() {
  if ( isset( $_SERVER['HTTP_SEC_CH_UA_MOBILE'] ) ) {
    $is_mobile = ( '?1' === $_SERVER['HTTP_SEC_CH_UA_MOBILE'] );
} elseif ( empty( $_SERVER['HTTP_USER_AGENT'] ) ) {
    $is_mobile = false;
} elseif (
    (str_contains( $_SERVER['HTTP_USER_AGENT'], 'Mobile' ) && !str_contains( $_SERVER['HTTP_USER_AGENT'], 'iPad' )) // iPad を除外
    || (str_contains( $_SERVER['HTTP_USER_AGENT'], 'Android' ) && !str_contains( $_SERVER['HTTP_USER_AGENT'], 'Tablet' )) // Android タブレットを除外
    || str_contains( $_SERVER['HTTP_USER_AGENT'], 'iPhone' ) // iPhone を明示的に含む
    || str_contains( $_SERVER['HTTP_USER_AGENT'], 'BlackBerry' )
    || str_contains( $_SERVER['HTTP_USER_AGENT'], 'Opera Mini' )
    || str_contains( $_SERVER['HTTP_USER_AGENT'], 'Opera Mobi' )
) {
    $is_mobile = true;
} else {
    $is_mobile = false;
}
return $is_mobile;

}
  //タブレットも含める場合はwp_is_mobile()

// WordPress5.9 未満、かつPHP7系環境で発生するエラー対策( wp-includes/compat.php  )
if ( ! function_exists( 'str_contains' ) ) {
  function str_contains( $haystack, $needle ) {
    return false !== strpos( $haystack, $needle );
  }
}



// レスポンシブOFF機能を判定するための関数---------------------------------------------------------------------
function is_no_resposive() {
   return FALSE;
}

// body_class名取得関数------------------------------------------------------------------------------------------
function get_body_classname() {
    $classname = '';
    $options = get_desing_plus_option();
    // フォントタイプの旧値（type1 など）を新値（1や2）にマッピング
$convert_font_type = function($value) {
  $map = [
    'meiryo' => 1,
    'yugothic' => 1,
    'yumincho' => 2,
    '1'     => 1,
    '2'     => 2,
    '3'     => 3,
    1       => 1,
    2       => 2,
    3       => 3,
  ];
  return $map[$value] ?? 1;
};

$basefont = $convert_font_type($options['basefont'] ?? 1);

    if($basefont === 1) {
        $classname = 'font_1';
    } elseif($basefont === 2) {
        $classname = 'font_2';
    }else{
        $classname = 'font_3';
    }
    $classname .= is_front_page() ? ' index' : '' ;
    $classname .= $options['fixed_news'] ? ' fixed-news' : '' ;
    
    $classname .= $options['footer_bar_display'] == 'type1' ? ' sp_footer-bar sp_footer-bar_type1' : '';
    $classname .= $options['footer_bar_display'] == 'type2' ? ' sp_footer-bar sp_footer-bar_type2' : '';
    return $classname;
}

function dp_post_thumbnail_e() {
    $image_src = false;
    if ( has_post_thumbnail() ) {
        $image_src = wp_get_attachment_image_src( get_post_thumbnail_id(), 'size450x300' );
        if ($image_src) {
            if($image_src[1] == 450 && $image_src[2] == 300 ) {
                echo '<img class="blog-image" src="' . esc_attr( $image_src[0] ) . '" alt="' . get_the_title() . '" />';
            } else {
                echo '<img class="blog-image blog_list_thumbnail" src="' . esc_attr( $image_src[0] ) . '" alt="' . get_the_title() . '" />';
            }
        }
    }
    if ($image_src == false) {
        echo '<img class="blog-image" src = "'.get_template_directory_uri().'/img/common/no_image_blog.gif" alt = "NO IMAGE" />';
    }
}

function dp_news_thumbnail_e() {
    if ( has_post_thumbnail() ) {
        $image_src = wp_get_attachment_image_src( get_post_thumbnail_id(), 'size450x300' );
        if ($image_src) {
            if($image_src[1] == 450 && $image_src[2] == 300 ) {
                echo '<img class="news-image" src="' . esc_attr( $image_src[0] ) . '" alt="' . get_the_title() . '" />';
            } else {
                echo '<img class="news-image news_list_thumbnail" src="' . esc_attr( $image_src[0] ) . '" alt="' . get_the_title() . '" />';
            }
        }
    }
}

function the_category_names() {
	$names = "";
	$categories = get_the_category();
	foreach ($categories as $cat) {
		if($names != "") {
			$names .= ",";
		}
		$names .= $cat->cat_name;
	}
	echo esc_html($names);
}

function is_blankstr($str) {
	if(is_null($str)) {
		return TRUE;
	}
	if(trim($str) === "") {
		return TRUE;
	}
	return FALSE;
}

// スクリプトのバージョン管理 ----------------------------------------------------------------------------------------------
function version_num() {

 if (function_exists('wp_get_theme')) {
  $theme_data = wp_get_theme( get_template() );
 } else {
   $theme_data = get_theme_data(TEMPLATEPATH . '/style.css');
 };

 $current_version = $theme_data['Version'];

 return $current_version;

};


// ウィジェットの設定 ------------------------------------------------------------------------------
if ( function_exists('register_sidebar') ) {
    register_sidebar(array(
        'before_widget' => '<aside class="widget %2$s" id="%1$s">'."\n",
        'after_widget' => "</aside>\n",
        'before_title' => '<div class="widget-title">',
        'after_title' => "</div>",
        'name' => __('Single page', 'tcd-w'),
        'id' => 'single_side_widget'
    ));
    register_sidebar(array(
        'before_widget' => '<aside class="widget %2$s" id="%1$s">'."\n",
        'after_widget' => "</aside>\n",
        'before_title' => '<div class="widget-title">',
        'after_title' => "</div>",
        'name' => __('Static page', 'tcd-w'),
        'id' => 'static_side_widget'
    ));
    register_sidebar(array(
        'before_widget' => '<aside class="widget %2$s" id="%1$s">'."\n",
        'after_widget' => "</aside>\n",
        'before_title' => '<div class="widget-title">',
        'after_title' => "</div>",
        'name' => __('News page', 'tcd-w'),
        'id' => 'news_side_widget'
    ));
    register_sidebar(array(
        'before_widget' => '<div class="footer_widget col-md-3 col-sm-3 col-xs-3 %2$s" id="%1$s">'."\n",
        'after_widget' => "</div>\n",
        'before_title' => '<div class="footer_headline">',
        'after_title' => "</div>",
        'name' => __('Footer', 'tcd-w'),
        'id' => 'footer_widget'
    ));
    register_sidebar(array(
        'before_widget' => '<aside class="widget %2$s" id="%1$s">'."\n",
        'after_widget' => "</aside>\n",
        'before_title' => '<div class="widget-title">',
        'after_title' => "</div>",
        'name' => __('Single page (mobile)', 'tcd-w'),
        'description' => __('This widget will be replaced with normal widget when a user accesses the site by smartphone.', 'tcd-w'),
        'id' => 'mobile_widget_single'
    ));
    register_sidebar(array(
        'before_widget' => '<aside class="widget %2$s" id="%1$s">'."\n",
        'after_widget' => "</aside>\n",
        'before_title' => '<div class="widget-title">',
        'after_title' => "</div>",
        'name' => __('Static page (mobile)', 'tcd-w'),
        'description' => __('This widget will be replaced with normal widget when a user accesses the site by smartphone.', 'tcd-w'),
        'id' => 'mobile_widget_static'
    ));
    register_sidebar(array(
        'before_widget' => '<aside class="widget %2$s" id="%1$s">'."\n",
        'after_widget' => "</aside>\n",
        'before_title' => '<div class="widget-title">',
        'after_title' => "</div>",
        'name' => __('News page (mobile)', 'tcd-w'),
        'description' => __('This widget will be replaced with normal widget when a user accesses the site by smartphone.', 'tcd-w'),
        'id' => 'mobile_widget_news'
    ));
    register_sidebar(array(
        'before_widget' => '<div class="footer_widget col-xs-6 col-sm-3 %2$s" id="%1$s">'."\n",
        'after_widget' => "</div>\n",
        'before_title' => '<div class="footer_headline">',
        'after_title' => "</div>",
        'name' => __('Footer (mobile)', 'tcd-w'),
        'id' => 'mobile_footer_widget'
    ));
}

// オリジナルの抜粋記事 --------------------------------------------------------------------------------
function new_excerpt($a) {

 if(has_excerpt()) {

   $base_content = get_the_excerpt();
   $base_content = str_replace(array("\r\n", "\r", "\n"), "", $base_content);
   $trim_content = mb_substr($base_content, 0, $a ,"utf-8");

 } else {

   $base_content = get_the_content();
   $base_content = preg_replace('!<style.*?>.*?</style.*?>!is', '', $base_content);
   $base_content = preg_replace('!<script.*?>.*?</script.*?>!is', '', $base_content);
   $base_content = preg_replace('/\[.+\]/','', $base_content);
   $base_content = strip_tags($base_content);
   $trim_content = mb_substr($base_content, 0, $a,"utf-8");
   $trim_content = str_replace(']]>', ']]&gt;', $trim_content);
   $trim_content = str_replace(array("\r\n", "\r", "\n" , "&nbsp;"), "", $trim_content);
   $trim_content = htmlspecialchars($trim_content);

 };

 echo $trim_content . '…';

};

//抜粋からPタグを取り除く
remove_filter( 'the_excerpt', 'wpautop' );


// 記事タイトルの文字数制限 --------------------------------------------------------------------------------
function trim_title($num) {
 $base_title = get_the_title();
 $trim_title = mb_substr($base_title, 0, $num ,"utf-8");
 $count_title = mb_strlen($trim_title,"utf-8");
 if($count_title > $num-1) {
  echo $trim_title . '…';
 } else {
  echo $trim_title;
 };
};


// タイトルをエンコード --------------------------------------------------------------------------------
function get_encoded_title($title){
  return urlencode(mb_convert_encoding($title, "UTF-8"));
}


// RGBからHEXに変換 --------------------------------------------------------------------------------
function hex2rgb($hex) {
   $hex = str_replace("#", "", $hex);

   if(strlen($hex) == 3) {
      $r = hexdec(substr($hex,0,1).substr($hex,0,1));
      $g = hexdec(substr($hex,1,1).substr($hex,1,1));
      $b = hexdec(substr($hex,2,1).substr($hex,2,1));
   } else {
      $r = hexdec(substr($hex,0,2));
      $g = hexdec(substr($hex,2,2));
      $b = hexdec(substr($hex,4,2));
   }
   $rgb = array($r, $g, $b);

   return $rgb;
}


// カスタム投稿アーカイブページのナビにclassを追加 -------------------------------------------------------------------------------------
add_filter('next_posts_link_attributes', 'sdac_next_posts_link_attributes');
function sdac_next_posts_link_attributes(){
        return 'class="next"';
}

add_filter('previous_posts_link_attributes', 'sdac_previous_posts_link_attributes');
function sdac_previous_posts_link_attributes(){
        return 'class="prev"';
}


// セルフピンバックを禁止する -------------------------------------------------------------------------------------
function no_self_ping( &$links ) {
  $home = home_url();
  foreach ( $links as $l => $link )
  if ( 0 === strpos( $link, $home ) )
  unset($links[$l]);
}
add_action( 'pre_ping', 'no_self_ping' );


// RSS用のフィードを追加 ---------------------------------------------------------------------------------------------------
add_theme_support( 'automatic-feed-links' );


//　ヘッダーから余分なMETA情報を削除 --------------------------------------------------------------------
remove_action( 'wp_head', 'wp_generator' );
remove_action( 'wp_head', 'rsd_link' );
remove_action( 'wp_head', 'wlwmanifest_link' );
remove_action( 'wp_head', 'index_rel_link' );
remove_action( 'wp_head', 'parent_post_rel_link', 10, 0 );
remove_action( 'wp_head', 'start_post_rel_link', 10, 0 );
remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0 );


// インラインスタイルを取り除く --------------------------------------------------------------------------------
function remove_recent_comments_style() {
  global $wp_widget_factory;
  if ( isset( $wp_widget_factory->widgets['WP_Widget_Recent_Comments'] ) ) {
    remove_action( 'wp_head', array(
$wp_widget_factory->widgets['WP_Widget_Recent_Comments'],
'recent_comments_style' ) );
}
}
add_action( 'widgets_init', 'remove_recent_comments_style' );

add_action( 'get_header', function() {
    remove_action( 'wp_head', '_admin_bar_bump_cb' );
    remove_action( 'wp_head', 'wp_admin_bar_header' );
    remove_action( 'wp_enqueue_scripts', 'wp_enqueue_admin_bar_bump_styles' );
    remove_action( 'wp_enqueue_scripts', 'wp_enqueue_admin_bar_header_styles' );
} );


// ウィジェットブロックエディターを無効化 --------------------------------------------------------------------------------
function exclude_theme_support() {
    remove_theme_support( 'widgets-block-editor' );
}
add_action( 'after_setup_theme', 'exclude_theme_support' );


//　サムネイルの設定 --------------------------------------------------------------------------------
if (function_exists('add_theme_support')) {
  add_theme_support('post-thumbnails');
  add_image_size('size450x300', 450, 300, true );
  add_image_size('size600x400', 600, 400, true );
  add_image_size('size100x100', 100, 100, true );
  add_image_size('thumbnail_size', 150, 150, true );
	add_image_size( 'size1', 200, 200, true ); // ページビルダー「スライダー」で使用
  add_image_size( 'size8', 850, 500, true ); // ページビルダー「スライダー」で使用
}


// カスタムメニューの設定 --------------------------------------------------------------------------------
if(function_exists('register_nav_menu')) {
  register_nav_menu( 'global-menu', __( 'Global menu', 'tcd-w' ) );
  //register_nav_menu( 'footer-menu1', __( 'Footer menu (first column)', 'tcd-w' ) );
  //register_nav_menu( 'footer-menu2', __( 'Footer menu (second column)', 'tcd-w' ) );
  //register_nav_menu( 'footer-menu3', __( 'Footer menu (third column)', 'tcd-w' ) );
  //register_nav_menu( 'footer-menu4', __( 'Footer menu (fourth column)', 'tcd-w' ) );

    /*
	  register_nav_menu( 'footer-menu1', __( 'Footer menu (first column)', 'tcd-w' ) );
	  register_nav_menu( 'footer-menu2', __( 'Footer menu (second column)', 'tcd-w' ) );
	  register_nav_menu( 'footer-menu3', __( 'Footer menu (third column)', 'tcd-w' ) );
	  register_nav_menu( 'footer-menu4', __( 'Footer menu (fourth column)', 'tcd-w' ) );
	  register_nav_menu( 'footer-menu5', __( 'Footer menu (fifth column)', 'tcd-w' ) );
	  register_nav_menu( 'footer-menu-bottom', __( 'Footer menu (bottom of the page)', 'tcd-w' ) );
	  register_nav_menu( 'product-cat-menu', __( 'Product category menu', 'tcd-w' ) );
	*/
}


// ページナビ用 --------------------------------------------------------------------------------
function show_posts_nav() {
	global $wp_query;
	return ($wp_query->max_num_pages > 1);
};


// カスタム投稿　「お知らせ」を追加 ----------------------------------------------------------------

if ( function_exists('register_post_type') ) {
 $labels = array(
  'name' => __('News', 'tcd-w'),
  'singular_name' => __('News', 'tcd-w'),
  'add_new' => __('Add New', 'tcd-w'),
  'add_new_item' => __('Add New Item', 'tcd-w'),
  'edit_item' => __('Edit', 'tcd-w'),
  'new_item' => __('New item', 'tcd-w'),
  'view_item' => __('View Item', 'tcd-w'),
  'search_items' => __('Search Items', 'tcd-w'),
  'not_found' => __('Not Found', 'tcd-w'),
  'not_found_in_trash' => __('Not found in trash', 'tcd-w'),
  'parent_item_colon' => ''
 );

 register_post_type('news', array(
  'label' => __('News', 'tcd-w'),
  'labels' => $labels,
  'public' => true,
  'publicly_queryable' => true,
  'menu_position' => 5,
  'show_ui' => true,
  'query_var' => true,
  'rewrite' => array('slug' => 'news'),
  'capability_type' => 'post',
  'has_archive' => true,
  'hierarchical' => true,
  'show_in_rest' => true,
  'supports' => array('title','editor','thumbnail')
 ));
};




//アイキャッチをお知らせ一覧に追加
add_filter('manage_news_posts_columns', 'add_thumbnail_column_for_news', 5);
function add_thumbnail_column_for_news($columns){
  $columns['new_post_thumb'] = __('Featured Image', 'tcd-w');
  return $columns;
}

add_action('manage_news_posts_custom_column', 'display_thumbnail_column_for_news', 5, 2);
function display_thumbnail_column_for_news($column_name, $post_id){
  switch($column_name){
    case 'new_post_thumb':
      $post_thumbnail_id = get_post_thumbnail_id($post_id);
      if ($post_thumbnail_id) {
        $post_thumbnail_img = wp_get_attachment_image_src( $post_thumbnail_id, 'thumbnail' );
        echo '<img width="70" src="' . $post_thumbnail_img[0] . '" />';
      }
      break;
  }
}


//アイキャッチを投稿一覧に追加
function manage_posts_columns($columns) {
	$columns['recommend_post'] = __('Recommend post', 'tcd-w');
  $columns['new_post_thumb'] = __('Featured Image', 'tcd-w');
  return $columns;
}
function add_column($column_name, $post_id) {
  switch($column_name){
    case 'new_post_thumb':
      $post_thumbnail_id = get_post_thumbnail_id($post_id);
      if ($post_thumbnail_id) {
        $post_thumbnail_img = wp_get_attachment_image_src( $post_thumbnail_id, 'thumbnail' );
        echo '<img width="70" src="' . $post_thumbnail_img[0] . '" />';
      }
      break;
	  case 'recommend_post':
		  if(get_post_meta($post_id, 'recommend_post1', true)) {  echo __('Recommend post1', 'tcd-w').'<br />'; };
		  if(get_post_meta($post_id, 'recommend_post2', true)) {  echo __('Recommend post2', 'tcd-w').'<br />'; };
		  if(get_post_meta($post_id, 'pickup_post', true)) {  _e('Pickup post<br />', 'tcd-w'); };
		  if(get_post_meta($post_id, 'featured_post', true)) {  _e('Featured post<br />', 'tcd-w'); };
      break;
  }
}
add_filter( 'manage_posts_columns', 'manage_posts_columns' );
add_action( 'manage_posts_custom_column', 'add_column', 10, 2 );



// カスタム投稿の並び順を日付順に変更 --------------------------------------------------------------------------------
function my_post_types_admin_order( $wp_query ) {
  if ( is_admin() && !isset( $_GET['orderby'] ) ) {
    $post_type = $wp_query->query['post_type'];
    if ( in_array( $post_type, array('news') ) ) {
      $wp_query->set('orderby', 'date');
      $wp_query->set('order', 'DESC');
    }
  };
}
add_filter('pre_get_posts', 'my_post_types_admin_order');



// アーカイブページのページングを変更 --------------------------------------------------------------------------------
// add_filter('pre_get_posts', 'limit_posts_per_home_page');
function limit_posts_per_home_page($wp_query) {

  $options = get_desing_plus_option();

  if(!is_admin() && $wp_query->is_main_query() ){
    $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
    $first_page_limit = $options['index_blog_num'];
    $limit = get_option('posts_per_page');

    if (is_front_page()) {
      if ($paged == 1) {
        $limit = $first_page_limit;
      } else {
        $offset = $first_page_limit + (($paged - 2) * $limit);
        set_query_var('offset', $offset);
      }
    }
    set_query_var('posts_per_archive_page', $limit);
    set_query_var('posts_per_page', $limit);
  };
};

//アイキャッチ画像にメッセージを追加 -----------------------------------------------------------------------
add_action( 'current_screen', 'add_message_to_cmb');
function add_message_to_cmb() {
  $currentScreen = get_current_screen();
  if($currentScreen->post_type === "post" || $currentScreen->post_type === "news") {
    add_filter( 'admin_post_thumbnail_html', 'add_featured_image_instruction');
    function add_featured_image_instruction( $content ) {
      return $content .= __('<p>Please upload image by size Width:600px Height:400px.</p>', 'tcd-w');
    };
  } else if($currentScreen->post_type === "page") {
      add_filter( 'admin_post_thumbnail_html', 'add_featured_image_instruction');
      function add_featured_image_instruction( $content ) {
          return $content .= __('<p>This image are not displayed at Static Page.</p>', 'tcd-w');
      };
  }
}



// ブログのヘッダーの文字装飾 ---------------------------------------------------
function dp_blog_headstyle_e($options, $post_type = 'blog') {
    $font_size = $options[$post_type.'_headline_font_size'];
    $font_color = $options[$post_type.'_headline_color'];
    $shadow1 = $options[$post_type.'_headline_shadow1'];
    $shadow2 = $options[$post_type.'_headline_shadow2'];
    $shadow3 = $options[$post_type.'_headline_shadow3'];
    $shadow4 = $options[$post_type.'_headline_shadow_color'];
    if(empty($font_size)) { $font_size = 28; };
    if(empty($font_color)) { $font_color = '333333'; };
    if(empty($shadow1)) { $shadow1 = 0; };
    if(empty($shadow2)) { $shadow2 = 0; };
    if(empty($shadow3)) { $shadow3 = 0; };
    if(empty($shadow4)) { $shadow4 = '333333'; };
    echo "color: #".$font_color.";";
    echo "font-size: ".$font_size."px;";
    if($shadow1 == 0 && $shadow2 == 0 && $shadow3 == 0) {
        // 指定がない場合は処理しない
    } else {
        echo " text-shadow: " . $shadow1 . "px " . $shadow2 . "px " . $shadow3 . "px #" . $shadow4 . ";";
    }
}

// ページネーション ---------------------------------------------------
function dp_pagination() {
    global $wp_query;
    $big = 99999999;
    $page_format = paginate_links( array(
        'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
        'format' => '?paged=%#%',
        'current' => max( 1, get_query_var('paged') ),
        'total' => $wp_query->max_num_pages,
        'type'  => 'array'
    ) );
    if( is_array($page_format) ) {
        $paged = ( get_query_var('paged') == 0 ) ? 1 : get_query_var('paged');
        echo '<ul class="page-numbers">';
        foreach ( $page_format as $page ) {
            echo "<li>$page</li>";
        }
        echo '</ul>';
    }
    wp_reset_query();
}

// 関連記事取得 ------------------------------------------------------------------
function get_related_posts($post_id) {
    $categories = get_the_category($post_id);
    if ($categories) {
        $category_ids = array();
        foreach ( $categories as $individual_category ) {
            $category_ids[] = $individual_category->term_id;
        }
        $args     = array(
            'post_type'           => 'post',
            'ignore_sticky_posts' => 1,
            'category__in'        => $category_ids,
            'post__not_in'        => array($post_id),
            'showposts'           => 6,
            'orderby'             => 'rand'
        );
        $box_list = get_posts($args);
        return $box_list;
    }
    return null;
}
// 絵文字を消す ------------------------------------------------------------------
function disable_emoji() {
  $options = get_design_plus_option();
  if ( $options['use_emoji'] == 0 ) {

    // remove inline script
    remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
    // remove inline style
    remove_action( 'wp_print_styles', 'print_emoji_styles' );
    // remove inline style  6.4 later
    if ( function_exists( 'wp_enqueue_emoji_styles' ) ) {
      remove_action( 'wp_enqueue_scripts', 'wp_enqueue_emoji_styles' );
      remove_action( 'admin_enqueue_scripts', 'wp_enqueue_emoji_styles' );
    }

    // initだと早いため、admin_initで実行
    add_action( 'admin_init', function(){
      // remove inline script
      remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
      // remove inline style
      remove_action( 'admin_print_styles', 'print_emoji_styles' );
      // remove inline style 6.4 later
      if ( function_exists( 'wp_enqueue_emoji_styles' ) ) {
        remove_action( 'admin_enqueue_scripts', 'wp_enqueue_emoji_styles' );
      }
    } );

  }
}
add_action( 'init', 'disable_emoji' );



// カードリンクパーツ --------------------------------------------------------------------------------------
add_image_size( 'size-card', 120, 120, true );

function get_the_custom_excerpt($content, $length) {
  $length = ($length ? $length : 70);//デフォルトの長さを指定する
  $content =  preg_replace('/<!--more-->.+/is',"",$content); //moreタグ以降削除
  $content =  strip_shortcodes($content);//ショートコード削除
  $content =  strip_tags($content);//タグの除去
  $content =  str_replace("&nbsp;","",$content);//特殊文字の削除（今回はスペースのみ）
  $content =  mb_substr($content,0,$length);//文字列を指定した長さで切り取る
  return $content.'...';
}

//カードリンクショートコード
function clink_scode( $atts ) {
$atts = shortcode_atts(
    array(
      'url' => "",
      'title' => "",
      'excerpt' => ""
    ),
    $atts
  );

  // URLから投稿IDを取得
  $post_id = url_to_postid( $atts['url'] );

  // 各投稿データの取得
  $post = get_post( $post_id );
  $date = get_the_date( 'Y.m.d', $post_id );
  $image_url = get_the_post_thumbnail_url( $post_id, 'size-card' );
  $title = get_the_title( $post );
  $excerpt = get_the_custom_excerpt( $post->post_excerpt ? $post->post_excerpt : $post->post_content, 120 );

  // 投稿IDの取得に失敗した場合、外部リンクから取得した情報で上書き
  if( ! $post_id ){

    if ( ! class_exists( 'OpenGraph' ) ) {
      get_template_part( 'functions/OpenGraph' );
	}
    $graph = OpenGraph::fetch( $atts['url'] );
    if( $graph ){
      $date = '';
      $image_url = $graph->image;
      $title = $graph->title;
      $excerpt = $graph->description;

	}
	}
  // 画像がセットされていなければ、no image画像をセット
  if( ! $image_url ){
    $image_url = get_template_directory_uri() . '/img/common/no_image1.gif';
  }
	
  // パラメータでタイトルが入力されていれば上書き
  if( $atts['title'] ){
    $title = $atts['title'];
  }

  // パラメータで抜粋が入力されていれば上書き
  if( $atts['excerpt'] ){
    $excerpt = $atts['excerpt'];
  }
    // カードリンクのHTMLを返す（外部リンクのサムネイル対策で、height:100%;を追加）
  return sprintf(
    '<div class="cardlink">
      <a class="cardlink_thumbnail" href="%1$s">
        <img src="%2$s" alt="%3$s" width="120" height="120" style="height:100%%;"/>
      </a>
      <div class="cardlink_content">
        %4$s
        <div class="cardlink_title">
          <a href="%1$s">%3$s</a>
        </div>
        <div class="cardlink_excerpt">%5$s</div>
      </div>
    </div>',
    esc_url( $atts['url'] ),
    esc_url( $image_url ),
    wp_strip_all_tags( $title ),
    $date ? '<span class="cardlink_timestamp">' . esc_html( $date ) . '</span>' : '',
    wp_strip_all_tags( $excerpt ),
  );
}


add_shortcode("clink", "clink_scode");


// カスタムコメント --------------------------------------------------------------------------------------

if (function_exists('wp_list_comments')) {
	// comment count
	if (!is_admin()) add_filter('get_comments_number', 'comment_count', 0);
	function comment_count( $commentcount ) {
		global $id;
		$_commnets = get_comments('post_id=' . $id);
		$comments_by_type = separate_comments($_commnets);
		return count($comments_by_type['comment']);
	}
}

function custom_comments($comment, $args, $depth) {
	$GLOBALS['comment'] = $comment;
	global $commentcount;
	if(!$commentcount) {
		$commentcount = 0;
	}
?>

 <li class="comment <?php if($comment->comment_author_email == get_the_author_meta('email')) {echo 'admin-comment';} else {echo 'guest-comment';} ?>" id="comment-<?php comment_ID() ?>">
  <div class="comment-meta clearfix">
   <div class="comment-meta-left">
  <?php if (function_exists('get_avatar') && get_option('show_avatars')) { echo get_avatar($comment, 35); } ?>

    <ul class="comment-name-date">
     <li class="comment-name">
<?php if (get_comment_author_url()) : ?>
<a id="commentauthor-<?php comment_ID() ?>" class="url <?php if($comment->comment_author_email == get_the_author_meta('email')) {echo 'admin-url';} else {echo 'guest-url';} ?>" href="<?php comment_author_url() ?>" rel="nofollow">
<?php else : ?>
<span id="commentauthor-<?php comment_ID() ?>">
<?php endif; ?>

<?php comment_author(); ?>

<?php if(get_comment_author_url()) : ?>
</a>
<?php else : ?>
</span>
<?php endif; ?>
     </li>
     <li class="comment-date"><?php echo get_comment_time(__('F jS, Y', 'tcd-w')); echo get_comment_time(__(' g:ia', 'tcd-w')); ?></li>
    </ul>
   </div>

   <ul class="comment-act">
<?php if (function_exists('comment_reply_link')) {
        if ( get_option('thread_comments') == '1' ) { ?>
    <li class="comment-reply"><?php comment_reply_link(array_merge( $args, array('add_below' => 'comment-content', 'depth' => $depth, 'max_depth' => $args['max_depth'], 'reply_text' => '<span><span>'.__('REPLY','tcd-w').'</span></span>'))) ?></li>
<?php   } else { ?>
    <li class="comment-reply"><a href="javascript:void(0);" onclick="MGJS_CMT.reply('commentauthor-<?php comment_ID() ?>', 'comment-<?php comment_ID() ?>', 'comment');"><?php _e('REPLY', 'tcd-w'); ?></a></li>
<?php   }
      } else { ?>
    <li class="comment-reply"><a href="javascript:void(0);" onclick="MGJS_CMT.reply('commentauthor-<?php comment_ID() ?>', 'comment-<?php comment_ID() ?>', 'comment');"><?php _e('REPLY', 'tcd-w'); ?></a></li>
<?php } ?>
    <li class="comment-quote"><a href="javascript:void(0);" onclick="MGJS_CMT.quote('commentauthor-<?php comment_ID() ?>', 'comment-<?php comment_ID() ?>', 'comment-content-<?php comment_ID() ?>', 'comment');"><?php _e('QUOTE', 'tcd-w'); ?></a></li>
    <?php edit_comment_link(__('EDIT', 'tcd-w'), '<li class="comment-edit">', '</li>'); ?>
   </ul>

  </div>
  <div class="comment-content post_content" id="comment-content-<?php comment_ID() ?>">
  <?php if ($comment->comment_approved == '0') : ?>
   <span class="comment-note"><?php _e('Your comment is awaiting moderation.', 'tcd-w'); ?></span>
  <?php endif; ?>
  <?php comment_text(); ?>
  </div>

<?php } ?>
<?php
// 埋め込みコンテンツのレスポンシブ化
add_theme_support( 'responsive-embeds' );

  /**
 * 管理画面 サイトヘルスのWP情報にユーザーエージェント追加
 *
 * NOTE: カスタマーサポート対策
 */
add_filter( 'debug_information', 'tcd_add_debug_information' );
function tcd_add_debug_information( $info ) {
  if( isset( $info['wp-core']['fields'] ) ){
    $info['wp-core']['fields']['user_agent'] = [
      'label' => 'User Agent',
      'value' => $_SERVER['HTTP_USER_AGENT'] ?? 'UA could not be retrieved',
    ];
  }
  return $info;
}

/**
 * PWAプラグイン未インストール時のメッセージ
 *
 * NOTE: TCDユーザーがPWAプラグインを知る・使うための導線を作るために用意
 */
add_action( 'admin_notices', 'tcd_pwa_admin_notice' );
function tcd_pwa_admin_notice(){
  global $plugin_page;

  // テーマオプションページ以外では表示しない
  if( $plugin_page !== 'theme_options' ){
    return;
  }

  // TCD PWA が有効化されていれば表示しない
  if( defined( 'TCDPWA_ACTIVE' ) && TCDPWA_ACTIVE ){
    return;
  }

  // チェックしたいプラグインのメインファイルを指定
  $target_plugin_file = 'tcd-pwa/tcd-pwa.php';

  // すべてのインストール済みプラグインを取得
  $installed_plugins = get_plugins();

  // インストール済みなら終了
  if( isset( $installed_plugins[$target_plugin_file] ) ){
    return;
  }

  // notice作成
  printf(
    '<div class="notice notice-info is-dismissible">
      <p>%1$s</p>
      <p>
        <a class="button" href="%2$s" target="_blank">%3$s</a>
        <a class="button button-primary" href="%4$s" target="_blank">%5$s</a>
      </p>
    </div>',
    // TCDテーマをPWA化できるプラグイン「TCD Progressive Web Apps」を利用できます。
    __( 'The TCD Progressive Web Apps plugin is available to convert TCD themes into PWAs.','tcd-w'  ),
    // 解説記事URL
    'https://tcd-theme.com/2025/05/tcd-pwa.html',
    // 設定・使い方
    __( 'Settings/How to use','tcd-w'  ),
    // マイページの商品URL
    'https://tcd.style/order-history?pname=TCD+Progressive+Web+Apps',
    // 今すぐインストール
    __( 'Install Now','tcd-w' )
  );
}