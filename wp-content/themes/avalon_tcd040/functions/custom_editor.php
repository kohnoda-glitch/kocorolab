<?php
/**
 * エディターに関連する記述をここにまとめる
 *
 * NOTE: TCD Classic Editorの個別対応もここ
 */

/**
 * プラグインが有効化されている場合の処理
 *
 * NOTE: TCDCE_ACTIVEは、プラグインで定義された定数（有効化されていればtrue）
 */
if ( defined( 'TCDCE_ACTIVE' ) && TCDCE_ACTIVE ) {
	/**
	 * スタートガイド
	 */
	// 告知追加： このプラグインを有効化している間、TCDテーマの「クイックタグ」機能は利用できません。
	add_action( 'tcdce_top_menu', 'tcdce_top_menu_common_caution', 9 );
	/**
	 * 基本設定
	 */
	// 告知追加： TCDテーマオプションの設定が本文に反映されるため、基本設定はお使いいただけません。
	add_action( 'tcdce_submenu_tcd_classic_editor_basic', 'tcdce_submenu_basic_common_caution' );
	// 基本設定のスタイルを読み込まない
	remove_filter( 'tcdce_render_quicktag_style', 'tcdce_render_quicktag_basic_style' );
	/**
	 * クイックタグ
	 */
	// フロントの use_quicktagオプションを強制的にオフにする（元テーマの関連スタイルを除去）
	add_filter( 'option_dp_options', 'tcdce_disable_theme_quicktag' );
	/**
	 * Googleマップ
	 */
	// 特に無し
	/**
	 * 目次
	 */
	// スマホ用目次ウィジェットアイコンを表示するブレイクポイント
	add_filter( 'tcdce_toc_show_breakpoint', fn() => 767 );
	// 目次のスタイル調整
	add_filter( 'tcdce_enqueue_inline_style', function( $style ){
		$style .=
		// 目次ウィジェットとヘッダーの距離
		'body { --tcdce-toc-sticky-top: 40px; }' .
		'@media only screen and (max-width: 1199px) { body.fix_top { --tcdce-toc-sticky-top: 100px; } }' .
		// スマホフッターバー表示時の対策
		'body:has(.dp-footer-bar) .p-toc-open { margin-bottom: 50px; }' .
		// トップに戻るボタンを非表示
		'body:has(.p-toc-open) #return_top { display:none!important; }' .
    //フッター広告
    'body:has(#js-tcd-footer-a2hs) .p-toc-open { margin-bottom: 60px; }' .
		// ドロワーメニュー表示に目次アイコン非表示
		// 'html.open_menu .p-toc-open { display:none; }';
		'';
		return $style;
	} );
		// 目次の投稿タイプから不要なものを削除
		add_filter( 'tcdce_toc_setting_post_types_options', function( $post_types ){
			return array_filter( $post_types, function ( $post_type ) {
				return ! in_array( $post_type, [ 'course','faq' ] );
			} );
		} );
	
	/**
	 * design-plus.cssを取り除く
	 */
	add_action( 'wp_enqueue_scripts', function(){
		wp_dequeue_style( 'design-plus' );
	}, 12 );
	/**
	 * エディタ独自スタイル対応
	 */
	add_filter( 'tcdce_enqueue_inline_style', function( $style ){
		global $dp_options;
		$style .=
		// レイアウト
		'.tcdce-body { padding-block: 0.7em; }' .
		// ページビルダー
		'.pb-widget-editor:has(.tcdce-body) { margin-top:0; }' .
		'@media only screen and (min-width: 768px) { .tcd-pb-row-inner:has(.col2) .pb-widget-editor .tcdce-body { padding-block:0; } }' .
		'.pb-widget-editor .tcdce-body > :last-child { margin-bottom:0; }' .
		'.tcdce-body blockquote { margin-inline:0; }' .
		'.tcdce-body .pb_font_family_1 { font-family: var(--tcd-font-type1); }' .
		'.tcdce-body .pb_font_family_2 { font-family: var(--tcd-font-type2); }' .
		'.tcdce-body .pb_font_family_3 { font-family: var(--tcd-font-type3); }' .
		'';
		return $style;
	} );
	/**
	 * 有効化されていれば、ココで処理を止める
	 */
	return;
}

/**
 * 以下はテーマのエディタ周りの機能
 *
 * NOTE: プラグイン有効化時は、以下は実行されない
 */
/**
 * the_contentで実行されているもの
 */

 // クラシックエディターのtable スクロール対応 ------------------------------------------------------------------------
add_filter('the_content', function( $content ){
  if( !has_blocks() ){
  $content = str_replace( '<table', '<div class="s_table"><table', $content );
  $content = str_replace( '</table>', '</table></div>', $content );
  }
  return $content;
  } );


// ビジュアルエディタ用スタイルシートの読み込み --------------------------------------------------------------------------------
function avalon_add_editor_styles() {
	add_theme_support('editor-styles'); /*追記*/
  add_editor_style( get_template_directory_uri()."/editor-style.css?d=".date('YmdGis', filemtime(get_template_directory().'/editor-style.css')) );
}
add_action( 'admin_init', 'avalon_add_editor_styles' );

function tcd_quicktag_admin_init() {
  global $dp_options;
  if ( ! $dp_options ) $dp_options = get_desing_plus_option();

  if ( current_user_can( 'edit_posts' ) || current_user_can( 'edit_pages' ) ) {
    add_filter( 'mce_external_plugins', 'tcd_add_tinymce_plugin' );

    add_filter( 'mce_buttons', 'tcd_register_mce_button' );
    
    add_action( 'admin_print_footer_scripts', 'tcd_add_quicktags' );

    // Dynamic css for classic visual editor
    add_filter( 'editor_stylesheets', 'editor_stylesheets_tcd_visual_editor_dynamic_css' );

    // Dymamic css for visual editor on block editor
    // wp_enqueue_style( 'tcd-quicktags', get_tcd_quicktags_dynamic_css_url(), false, version_num() );
  }
}
add_action( 'admin_init', 'tcd_quicktag_admin_init' );

// Declare script for new button
function tcd_add_tinymce_plugin( $plugin_array ) {
	$plugin_array['my_mce_button'] = get_template_directory_uri() .'/admin/js/mce-button.js?ver=2.0.0';
	return $plugin_array;
}

// Register new button in the editor
function tcd_register_mce_button( $buttons ) {
	array_push( $buttons, 'my_mce_button' );
	return $buttons;
}


function tcd_add_quicktags() {
  if (wp_script_is('quicktags')){
?>
<script type="text/javascript">
  QTags.addButton('ytube', 'Youtube動画', '<div class="ytube">ここにYoutubeのコードを入力してください</div>' + '\n' + '\n', '');
  QTags.addButton('relatedcardlink', '関連記事カードリンク', '[clink url="ここに表示させたい記事URL"]' + '\n' + '\n', '');
  QTags.addButton('post_col-2', 'レイアウト2c', '<div class="post_row"><div class="post_col post_col-2">ここに左カラムに表示させたい任意のテキストや画像タグを入力します。</div><div class="post_col post_col-2">ここに右カラムに表示させたい任意のテキストや画像タグを入力します。</div></div>' + '\n' + '\n', '');
  QTags.addButton('post_col-3', 'レイアウト3c', '<div class="post_row"><div class="post_col post_col-3">ここに左カラムに表示させたい任意のテキストや画像タグを入力します。</div><div class="post_col post_col-3">ここに中央カラムに表示させたい任意のテキストや画像タグを入力します。</div><div class="post_col post_col-3">ここに右カラムに表示させたい任意のテキストや画像タグを入力してください。</div></div>' + '\n' + '\n', '');
  QTags.addButton('style3a', 'H3見出しa', '<h3 class="style3a">H3見出しa</h3>' + '\n' + '\n', '');
  QTags.addButton('style3b', 'H3見出しb', '<h3 class="style3b">H3見出しb</h3>' + '\n' + '\n', '');
  QTags.addButton('style4a', 'H4見出しa', '<h4 class="style4a">H4見出しa</h4>' + '\n' + '\n', '');
  QTags.addButton('style4b', 'H4見出しb', '<h4 class="style4b">H4見出しb</h4>' + '\n' + '\n', '');
  QTags.addButton('style5a', 'H5見出しa', '<h5 class="style5a">H5見出しa</h5>' + '\n' + '\n', '');
  QTags.addButton('style5b', 'H5見出しb', '<h5 class="style5b">H5見出しb</h5>' + '\n' + '\n', '');
  QTags.addButton('well', '囲み枠a', '<div class="well">囲み枠a</div>' + '\n' + '\n', '');
  QTags.addButton('well2', '囲み枠b', '<div class="well2">囲み枠b</div>' + '\n' + '\n', '');
  QTags.addButton('well3', '囲み枠c', '<div class="well3">囲み枠c</div>' + '\n' + '\n', '');
  QTags.addButton('q_button', 'フラットボタン', '<div class="q_button_wrap"><a href="#" class="q_button">フラットボタン</a></div>' + '\n' + '\n', '');
  QTags.addButton('q_button_l', 'フラットボタン-L', '<div class="q_button_wrap"><a href="#" class="q_button sz_l">フラットボタン-L</a></div>' + '\n' + '\n', '');
  QTags.addButton('q_button_s', 'フラットボタン-S', '<div class="q_button_wrap"><a href="#" class="q_button sz_s">フラットボタン-S</a></div>' + '\n' + '\n', '');
  QTags.addButton('q_button_blue', 'フラットボタン-blue', '<div class="q_button_wrap"><a href="#" class="q_button bt_blue">フラットボタン-blue</a></div>' + '\n' + '\n', '');
 QTags.addButton('q_button_green', 'フラットボタン-green', '<div class="q_button_wrap"><a href="#" class="q_button bt_green">フラットボタン-green</a></div>' + '\n' + '\n', '');
 QTags.addButton('q_button_red', 'フラットボタン-red', '<div class="q_button_wrap"><a href="#" class="q_button bt_red">フラットボタン-red</a></div>' + '\n' + '\n', '');
 QTags.addButton('q_button_yellow', 'フラットボタン-yellow', '<div class="q_button_wrap"><a href="#" class="q_button bt_yellow">フラットボタン-yellow</a></div>' + '\n' + '\n', '');
  QTags.addButton('q_button_rounded', '角丸ボタン', '<div class="q_button_wrap"><a href="#" class="q_button rounded">角丸ボタン</a></div>' + '\n' + '\n', '');
  QTags.addButton('q_button_rounded_l', '角丸ボタン-L', '<div class="q_button_wrap"><a href="#" class="q_button rounded sz_l">角丸ボタン-L</a></div>' + '\n' + '\n', '');
  QTags.addButton('q_button_rounded_s', '角丸ボタン-S', '<div class="q_button_wrap"><a href="#" class="q_button rounded sz_s">角丸ボタン-S</a></div>' + '\n' + '\n', '');
  QTags.addButton('q_button_pill', 'ラウンドボタン', '<div class="q_button_wrap"><a href="#" class="q_button pill">ラウンドボタン</a></div>' + '\n' + '\n', '');
  QTags.addButton('q_button_pill_l', 'ラウンドボタン-L', '<div class="q_button_wrap"><a href="#" class="q_button pill sz_l">ラウンドボタン-L</a></div>' + '\n' + '\n', '');
  QTags.addButton('q_button_pill_s', 'ラウンドボタン-S', '<div class="q_button_wrap"><a href="#" class="q_button pill sz_s">ラウンドボタン-S</a></div>' + '\n' + '\n', '');
  QTags.addButton('single_banner', '広告', '[s_ad]' + '\n' + '\n', '');
</script>
<?php
  }
}

// Get dymamic css url
function get_tcd_quicktags_dynamic_css_url() {
  return admin_url( 'admin-ajax.php?action=tcd_quicktags_dynamic_css' );
}

// add_editor_style()だとテーマ内のcssが最後になるためここで最後尾にcss追加
function editor_stylesheets_tcd_visual_editor_dynamic_css( $stylesheets ) {
  $stylesheets[] = get_tcd_quicktags_dynamic_css_url();
  $stylesheets = array_unique( $stylesheets );
  return $stylesheets;
}

?>