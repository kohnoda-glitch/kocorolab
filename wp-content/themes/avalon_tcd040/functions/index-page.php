<?php
/**
 * トップページ設定を取り扱うファイル
 */

/**
 * 背景画像を保存しているディレクトリ名を返す
 * @return string
 */
function dp_bg_image_basedir(){
	$dir = wp_upload_dir();
	return $dir['basedir'].DIRECTORY_SEPARATOR.'tcd-w';
}

/**
 * 背景画像を保存しているディレクトリのURLを返す
 * @return type 
 */
function dp_bg_image_baseurl(){
	$dir = wp_upload_dir();
	return $dir['baseurl'].'/tcd-w';
}

/**
 * 背景画像が存在するか否かを返す
 * @param int $index 背景画像の番号（1-3）
 * @return string|false 存在する場合はファイル名を返す
 */
function dp_bg_image_exists($index){
	$dir = dp_bg_image_basedir();
	//ディレクトリが存在しない
	if(!file_exists($dir) || !is_dir($dir)){
		return false;
	}
	//ファイルが存在するか否かを返す
	foreach(scandir($dir) as $file){
		if(preg_match("/bgimg".$index."\.(jpe?g|png|gif)$/i", $file)){
			return $dir.DIRECTORY_SEPARATOR.$file;
		}
	}
	//ここまで来たということはファイルはない
	return false;
}

/**
 * 背景画像のパスや縦横サイズを返す
 * @param int $index 背景画像の番号（1-3）
 * @uses dp_bg_image_exists
 * @return array name(string), url(string), path(string), width(int)およびheight(int)からなる配列
 */
function dp_bg_image_info($index){
	$file = dp_bg_image_exists($index);
	if($file){
		$size = @getimagesize($file);
		if($size){
			return array(
				'name' => basename($file),
				'url' => dp_bg_image_baseurl().'/'.basename($file),
				'path' => $file,
				'width' => $size[0],
				'height' => $size[1],
				'mime' => $size[2]
			);
		}else{
			return false;
		}
		return $size;
	}else{
		false;
	}
}
/**
 * 数値選択ドロップダウンを描画する
 * @param int $min 数値の最小値
 * @param int $max 数値の最大値
 * @param int $default 数値の初期選択値
 * @param int $step 数値の増分値（min=0,max=6,step=2の場合、リストは0,2,4,6となる）
 * @return なし
 */
function dp_numoptions_e($min, $max, $default, $step = 1) {
	for($i = $min; $i <= $max; $i += $step) {
		if(is_numeric($default) && intval($default) == $i) {
			echo '<option value="'.$i.'" selected="selected">'.$i.'</option>';
		} else {
			echo '<option value="'.$i.'">'.$i.'</option>';
		}
	}
}
/**
 * ドロップシャドウのスタイル要素を描画する
 * @param array $options テーマオプション設定値
 * @param int $index 採用インデックス
 * @param string $kine headline|copy|linkいずれか
 * @param bool $echo_bdcolor 境界線色を出力するかどうか
 * @return なし
 */
function dp_textstyle_e($options, $index, $kind, $echo_bdcolor = false) {
	$suffix = "";
	if($kind == "copy" || $kind == "link") {
		$suffix = "_copy";
	}
	$keyH = "dropshadow".$suffix."_h".$index;
	$keyV = "dropshadow".$suffix."_v".$index;
	$keyB = "dropshadow".$suffix."_b".$index;
	$keyC = "dropshadow".$suffix."_c".$index;
	echo "color: #".$options['color'.$suffix.$index].";";
	if((empty($options[$keyH]) || $options[$keyH] == "0") &&
	   (empty($options[$keyV]) || $options[$keyV] == "0") &&
	   (empty($options[$keyB]) || $options[$keyB] == "0")) {
		// シャドウの設定がない場合は処理しない
	} else if($kind == "link") {
		// リンクボタンにはシャドウを適用しない
	} else {
		echo " text-shadow: " . $options[ $keyH ] . "px " . $options[ $keyV ] . "px " . $options[ $keyB ] . "px #" . $options[ $keyC ] . ";";
	}
	if($kind == "headline" || $kind == "copy") {
		$fontsize = $options[ $kind . "_fontsize" . $index ];
		if ( empty( $fontsize ) ) {
			if ( $kind == "headline" ) {
				$fontsize = 42;
			} else {
				$fontsize = 14;
			}
		}
		echo " font-size: " . $fontsize . "px;";
	}
	if($echo_bdcolor) {
		echo " border-color: #".$options['color'.$index].";";
	}
}
/**
 * 背景画像をアップロードする
 * @global array $dp_upload_error
 * @param int $index 背景画像の番号（1-3）
 * @return array error(boolean)とmessage(string)からなる配列
 */
function _dp_upload_bg_image($index){
	$dp_upload_error = array(
		'error' => false,
		'message' => ''
	);
	$dir = dp_bg_image_basedir();
	$key = 'bg_image_file_'.$index;
	//ファイルのアップロードができるか判定
	if($_FILES[$key]['error'] !== 0){
		$dp_upload_error = array(
			'error' => true,
			'message' => _dp_get_upload_err_msg($_FILES[$key]['error'])
		);
		return $dp_upload_error;
	}
	//ディレクトリの存在を調べる
	if(!file_exists($dir) || !is_dir($dir)){
		//ディレクトリを作成してみる
		if(!@mkdir($dir)){
			$dp_upload_error = array(
				'error' => true,
				'message' => sprintf(
					__('Cannot create upload directory. Please make sure <code>%s</code> is writable.'),
					dirname($dir)
				)
			);
			return $dp_upload_error;
		}
	}
	//ディレクトリが書き込み可能か調べる
	if(!is_writable($dir)){
		$dp_upload_error = array(
			'error' => true,
			'message' => sprintf(
				__('Cannot save uploaded file. Please make sure <code>%s</code> is writable.'),
				$dir
			)
		);
		return $dp_upload_error;
	}
	//拡張子を調べる
	$ext = array();
	if(!preg_match("/(png|gif|jpe?g)$/i", $_FILES[$key]['name'], $ext)){
		$dp_upload_error = array(
			'error' => true,
			'message' => __('Uploaded file type is not allowed. Allowed file types are PNG, JPG and GIF.')
		);
		return $dp_upload_error;
	}
	//既存のファイルを削除する
	$file = dp_bg_image_exists($index);
	if($file){
		//ファイルが存在した場合は削除する
		if(!@unlink($file)){
			$dp_upload_error = array(
				'error' => true,
				'message' => sprintf(__('Cannot delete existing file <code>%s</code>', 'tcd-w'), $file)
			);
			return $dp_upload_error;
		}
	}
	//ファイルを保存する
	if(!@move_uploaded_file($_FILES[$key]['tmp_name'], $dir.DIRECTORY_SEPARATOR.'bgimg'.$index.".".$ext[1])){
		$dp_upload_error = array(
			'error' => true,
			'message' => __('Sorry, but cannot save uploaded file.')
		);
		return $dp_upload_error;
	}
	//ここまで来たということは保存に成功しているので、
	//メッセージを更新する
	$dp_upload_error['message'] = __('Background image file was successfully uploaded.', 'tcd-w');
	return  $dp_upload_error;
}

/**
 * 背景画像を削除する
 * @return void
 */
function _dp_delete_bg_image(){
	if(isset($_REQUEST['page'], $_REQUEST['_wpnonce']) && !isset($_REQUEST['settings-updated']) && $_REQUEST['page'] == 'theme_options'){
		if ( wp_verify_nonce( $_REQUEST['_wpnonce'], 'dp_delete_bg_image_' . get_current_user_id() ) ) {
			if(isset($_REQUEST['index']) && ($_REQUEST['index'] === "1" || $_REQUEST['index'] === "2" || $_REQUEST['index'] === "3")) {
				$index = $_REQUEST['index'];
				$file  = dp_bg_image_exists( $index );
				if($file){
					//ファイルが存在した場合は削除する
					if(@unlink($file)){
						add_action( 'admin_notices', '_dp_bgdelete_message_sucess' );
						return;
					}
				} else {
					error_log("[_dp_delete_bg_image] File not exists(".$file.").");
				}
				add_action( 'admin_notices', '_dp_bgdelete_message_error' );
			} else {
				error_log("[_dp_delete_bg_image] Index paramater is not set.");
			}
		} else {
			error_log("[_dp_delete_bg_image] Verification mismatched.");
		}
	}
}
add_action('admin_init', '_dp_delete_bg_image');

/**
 * 背景画像の削除失敗メッセージ
 */
function _dp_bgdelete_message_error(){
	echo '<div id="message" class="error"><p>'.sprintf(__('Failed to delete image. Please check permisson of %s. All files must be writable.', 'tcd-w'), dp_bg_image_basedir()).'</p></div>';
}

/**
 * ロゴ画像の削除成功メッセージ 
 */
function _dp_bgdelete_message_sucess(){
	echo '<div id="message" class="updated fade"><p>'.__('Images are successfully deleted.', 'tcd-w').'</p></div>';
}
