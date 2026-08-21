<?php

function tcd_template_meta_box() {
  add_meta_box(
    'add_custom_fields',//ID of meta box
    __('Page template setting', 'tcd-w'),//label
    'show_tcd_template_meta_box',//callback function
    'page',// post type
    'advanced',// context
    'high'// priority
  );
}
add_action('add_meta_boxes', 'tcd_template_meta_box');

function show_tcd_template_meta_box() {
  global $post;
  $options =  get_desing_plus_option();

  //テンプレートのタイプ
  $page_tcd_template_type =
		array(
			'name' => __('Page template type', 'tcd-w'),
			'id' => 'page_tcd_template_type',
			'type' => 'radio',
      'std' => 'type1',
			'options' => array(
				array('name' => __('Normal template', 'tcd-w'), 'value' => 'type1'),
                array('name' => __('Template_Sideless', 'tcd-w'), 'value' => 'type2'),
				array('name' => __('Template_About', 'tcd-w'), 'value' => 'type3', 'img' => 'template_about.jpg'),
                array('name' => __('Template_Staff', 'tcd-w'), 'value' => 'type4', 'img' => 'template_staff.jpg'),
                array('name' => __('Template_Menu', 'tcd-w'), 'value' => 'type5', 'img' => 'template_menu.jpg'),
				array('name' => __('Template_Access', 'tcd-w'), 'value' => 'type6', 'img' => 'template_access.jpg'),
			)
    );
  $page_tcd_template_type_meta = get_post_meta($post->ID, 'page_tcd_template_type', true);

  //キャッチフレーズ
  //$catch = array( 'name' => __('Main catchphrase for this page', 'tcd-w'), 'desc' => '', 'id' => 'catch', 'type' => 'textarea', 'std' => '' );
  //$catch_meta = esc_html(get_post_meta($post->ID, 'catch', true));

  //Aboutテンプレート
  /*
  $type3_row1_headline = array( 'name' => __('Headline for row1', 'tcd-w'), 'id' => '$type3_row1_headline', 'type' => 'text', 'std' => '' );
  $type3_row1_meta_headline = get_post_meta($post->ID, '$type3_row1_headline', true);
  $type3_row2_content = array( 'name' => __('Content for row2 left col', 'tcd-w'), 'id' => '$type3_row2_content', 'type' => 'textarea', 'std' => '' );
  $type3_row2_content_meta = get_post_meta($post->ID, '$type3_row2_content', true);
  */

  //テンプレート2 見出し
  $type2_headline = array( 'name' => __('Catchphrase', 'tcd-w'), 'desc' => __('Enter catchphrase for sub description area.', 'tcd-w'), 'id' => 'type2_headline', 'type' => 'textarea', 'std' => '' );
  $type2_headline_meta = esc_html(get_post_meta($post->ID, 'type2_headline', true));

  //テンプレート2 説明文
  $type2_desc_meta = get_post_meta( $post->ID, 'type2_desc', true );

  //テンプレート3 見出し
  $type3_headline = array( 'name' => __('Catchphrase', 'tcd-w'), 'desc' => __('Enter catchphrase for sub description area.', 'tcd-w'), 'id' => 'type3_headline', 'type' => 'textarea', 'std' => '' );
  $type3_headline_meta = esc_html(get_post_meta($post->ID, 'type3_headline', true));

  //テンプレート3 説明文
  $type3_desc_meta = get_post_meta( $post->ID, 'type3_desc', true );

  //ショップナビを表示しない
  $hide_shopnavi = array( 'name' => __('Hide shop navi', 'tcd-w'), 'desc' => '', 'id' => 'hide_shopnavi', 'type' => 'checkbox');
  $hide_shopnavi_meta = get_post_meta($post->ID, 'hide_shopnavi', true);

  echo '<input type="hidden" name="custom_fields_meta_box_nonce" value="', wp_create_nonce(basename(__FILE__)), '" />';

  //テンプレートの選択 ***********************************************************************************************************************************************************************************
  echo '<dl class="ml_custom_fields_select" id="ml_custom_fields_box1">';

  echo '<dt class="label"><label for="' , $page_tcd_template_type['id'] , '">' , $page_tcd_template_type['name'] , '</label></dt>';
  echo '<dd class="content"><ul class="radio template cf">';
	foreach ($page_tcd_template_type['options'] as $page_tcd_template_type_option) {
    if($page_tcd_template_type_option['value'] == 'type1' || $page_tcd_template_type_option['value'] == 'type2') {
      echo '<li><label', ( ( empty($page_tcd_template_type_meta) && $page_tcd_template_type_option['value'] == 'type1' ) || $page_tcd_template_type_meta == $page_tcd_template_type_option['value'] ) ? ' class="active"' : '' ,'><input type="radio" id ="template_', $page_tcd_template_type_option['value'], '" name="', $page_tcd_template_type['id'], '" value="', $page_tcd_template_type_option['value'], '"', ($page_tcd_template_type_meta == $page_tcd_template_type_option['value'] || $page_tcd_template_type['std'] == $page_tcd_template_type_option['value']) ? ' checked="checked"' : '', ' />', $page_tcd_template_type_option['name'] , '</label></li>';
    } else {
      echo '<li><label', ( ( empty($page_tcd_template_type_meta) && $page_tcd_template_type_option['value'] == 'type1' ) || $page_tcd_template_type_meta == $page_tcd_template_type_option['value'] ) ? ' class="active"' : '' ,'><input type="radio" id ="template_', $page_tcd_template_type_option['value'], '" name="', $page_tcd_template_type['id'], '" value="', $page_tcd_template_type_option['value'], '"', ($page_tcd_template_type_meta == $page_tcd_template_type_option['value'] || $page_tcd_template_type['std'] == $page_tcd_template_type_option['value']) ? ' checked="checked"' : '', ' />', $page_tcd_template_type_option['name'] , '</label><a href="' , bloginfo('template_url') , '/admin/img/' ,  $page_tcd_template_type_option['img'] , '" class="fancybox" rel="group1" title="' , $page_tcd_template_type_option['name'] , '">' , __('View image', 'tcd-w') ,'</a></li>';
    }
  }
  echo '</ul></dd>';

  echo '</dl>';

  if(empty($page_tcd_template_type_meta) || $page_tcd_template_type_meta == 'type1' || $page_tcd_template_type_meta == 'type2') { } else {
    echo '<style>#postdivrich { display:none; }</style>';
  };

  show_page_meta_box($post, $options);

  //メインキャッチフレーズの登録 ***********************************************************************************************************************************************************************************
  /*
  echo '<dl class="ml_custom_fields" id="ml_custom_fields_box0">';

  echo '<dt class="label"><label for="' , $catch['id'] , '">' , $catch['name'] , '</label></dt>';
  echo '<dd class="content"><p class="desc">' , $catch['desc'] , '</p>';
  echo '<textarea name="', $catch['id'], '" id="', $catch['id'], '" cols="60" rows="2" style="width:97%">', $catch_meta ? $catch_meta : $catch['std'], '</textarea>';
  echo '</dl>';
*/
  //デフォルト ***************************************************************************************************************************************************************************************

  //サイドバー無し ***************************************************************************************************************************************************************************************

  //Aboutページ ***************************************************************************************************************************************************************************************
  echo '<dl class="ml_custom_fields type2" id="ml_custom_fields_box3"' , ( $page_tcd_template_type_meta == 'type3' ) ? ' style="display:block;"' : ' style="display:none;"' , '>';

  //見出し
  echo '<dt class="headline"><label>' , __('Template_About', 'tcd-w') , '</label></dt>';

  //row1
  echo '<dt class="label"><label for="type3_row1_headline">' , __('Headline for row1', 'tcd-w') , '</label></dt>';
  echo '<dd class="content"><p class="desc"></p>';
  echo '<input type="text" name="type3_row1_headline" id="type3_row1_headline" style="width:97%" value="', esc_attr(get_post_meta($post->ID, 'type3_row1_headline', true)), '" />';
  echo '</dd>';
  //row2
  echo '<dt class="label"><label for="type3_row2_content">' , __('Content for row2 left col', 'tcd-w') , '</label></dt>';
  echo '<dd class="content"><p class="desc"></p>';
  echo '<textarea name="type3_row2_content" id="type3_row2_content" cols="60" rows="2">', esc_textarea(get_post_meta($post->ID, 'type3_row2_content', true)), '</textarea>';
  echo '</dd>';
  echo '<dt class="label"><label>' , __('Image for row2 right col', 'tcd-w') ,'</label></dt>';
  echo '<dd class="content"><p class="desc">' , __('Register image.<br />Image size. Width:450px Height:330px', 'tcd-w') , '</p>';
    mlcf_media_form('type3_row2_image', __('Image', 'tcd-w'));
  echo '</dd>';
  //row3
  echo '<dt class="label"><label>' , __('Image for row3 left col', 'tcd-w') ,'</label></dt>';
  echo '<dd class="content"><p class="desc">' , __('Register image.<br />Image size. Width:450px Height:330px', 'tcd-w') , '</p>';
  mlcf_media_form('type3_row3_image', __('Image', 'tcd-w'));
  echo '</dd>';
  echo '<dt class="label"><label for="type3_row3_content">' , __('Content for row3 right col', 'tcd-w') , '</label></dt>';
  echo '<dd class="content"><p class="desc"></p>';
  echo '<textarea name="type3_row3_content" id="type3_row3_content" cols="60" rows="2">', esc_textarea(get_post_meta($post->ID, 'type3_row3_content', true)), '</textarea>';
  echo '</dd>';
  //row4
  echo '<dt class="label"><label>' , __('Image for row4', 'tcd-w') ,'</label></dt>';
  echo '<dd class="content"><p class="desc">' , __('Register image.<br />Image size. Width:1180px Height:350px', 'tcd-w') , '</p>';
  mlcf_media_form('type3_row4_image', __('Image', 'tcd-w'));
  echo '</dd>';
  echo '<dt class="label"><label for="type3_row4_headline">' , __('Headline for row4', 'tcd-w') , '</label></dt>';
  echo '<dd class="content"><p class="desc"></p>';
  echo '<input type="text" name="type3_row4_headline" id="type3_row4_headline" style="width:97%" value="', esc_attr(get_post_meta($post->ID, 'type3_row4_headline', true)), '" />';
  echo '</dd>';
  echo '<dt class="label"><label for="type3_row4_content">' , __('Content for row4', 'tcd-w') , '</label></dt>';
  echo '<dd class="content"><p class="desc"></p>';
  echo '<textarea name="type3_row4_content" id="type3_row4_content" cols="60" rows="2">', esc_textarea(get_post_meta($post->ID, 'type3_row4_content', true)), '</textarea>';
  echo '</dd>';
  //row5
  echo '<dt class="label"><label for="type3_row5_content">' , __('Content for row5', 'tcd-w') , '</label></dt>';
  echo '<dd class="content"><p class="desc"></p>';
  echo '<textarea name="type3_row5_content" id="type3_row5_content" cols="60" rows="2">', esc_textarea(get_post_meta($post->ID, 'type3_row5_content', true)), '</textarea>';
  echo '</dd>';
  //row6
  echo '<dt class="label"><label>' , __('Image for row6 left col', 'tcd-w') ,'</label></dt>';
  echo '<dd class="content"><p class="desc">' , __('Register image.<br />Image size. Width:450px Height:330px', 'tcd-w') , '</p>';
  mlcf_media_form('type3_row6_image', __('Image', 'tcd-w'));
  echo '</dd>';
  echo '<dt class="label"><label for="type3_row6_content">' , __('Content for row6 right col', 'tcd-w') , '</label></dt>';
  echo '<dd class="content"><p class="desc"></p>';
  echo '<textarea name="type3_row6_content" id="type3_row6_content" cols="60" rows="2">', esc_textarea(get_post_meta($post->ID, 'type3_row6_content', true)), '</textarea>';
  echo '</dd>';
  //row7
  echo '<dt class="label"><label for="type3_row7_content">' , __('Content for row7 left col', 'tcd-w') , '</label></dt>';
  echo '<dd class="content"><p class="desc"></p>';
  echo '<textarea name="type3_row7_content" id="type3_row7_content" cols="60" rows="2">', esc_textarea(get_post_meta($post->ID, 'type3_row7_content', true)), '</textarea>';
  echo '</dd>';
  echo '<dt class="label"><label>' , __('Image for row7 right col', 'tcd-w') ,'</label></dt>';
  echo '<dd class="content"><p class="desc">' , __('Register image.<br />Image size. Width:450px Height:330px', 'tcd-w') , '</p>';
  mlcf_media_form('type3_row7_image', __('Image', 'tcd-w'));
  echo '</dd>';


  echo '</dl>';

  //Staffページ ***************************************************************************************************************************************************************************************

  echo '<dl class="ml_custom_fields type2" id="ml_custom_fields_box4"' , ( $page_tcd_template_type_meta == 'type4' ) ? ' style="display:block;"' : ' style="display:none;"' , '>';

  //見出し
  echo '<dt class="headline"><label>' , __('Template_Staff', 'tcd-w') , '</label></dt>';

  //row1
  echo '<dt class="label"><label for="type4_row1_headline">' , __('Headline for row1', 'tcd-w') , '</label></dt>';
  echo '<dd class="content"><p class="desc"></p>';
  echo '<input type="text" name="type4_row1_headline" id="type4_row1_headline" style="width:97%" value="', esc_attr(get_post_meta($post->ID, 'type4_row1_headline', true)), '" />';
  echo '</dd>';
  //row2
  echo '<dt class="label"><label for="type4_row2_content">' , __('Content for row2 left col', 'tcd-w') , '</label></dt>';
  echo '<dd class="content"><p class="desc"></p>';
  echo '<textarea name="type4_row2_content" id="type4_row2_content" cols="60" rows="2">', esc_textarea(get_post_meta($post->ID, 'type4_row2_content', true)), '</textarea>';
  echo '</dd>';
  echo '<dt class="label"><label>' , __('Image for row2 right col', 'tcd-w') ,'</label></dt>';
  echo '<dd class="content"><p class="desc">' , __('Register image.<br />Image size. Width:450px Height:330px', 'tcd-w') , '</p>';
  mlcf_media_form('type4_row2_image', __('Image', 'tcd-w'));
  echo '</dd>';
  //row3
  echo '<dt class="label"><label>' , __('Image for row3 left col', 'tcd-w') ,'</label></dt>';
  echo '<dd class="content"><p class="desc">' , __('Register image.<br />Image size. Width:450px Height:330px', 'tcd-w') , '</p>';
  mlcf_media_form('type4_row3_image', __('Image', 'tcd-w'));
  echo '</dd>';
  echo '<dt class="label"><label for="type4_row3_content">' , __('Content for row3 right col', 'tcd-w') , '</label></dt>';
  echo '<dd class="content"><p class="desc"></p>';
  echo '<textarea name="type4_row3_content" id="type4_row3_content" cols="60" rows="2">', esc_textarea(get_post_meta($post->ID, 'type4_row3_content', true)), '</textarea>';
  echo '</dd>';
  //row4
  echo '<dt class="label"><label>' , __('Image for row4', 'tcd-w') ,'</label></dt>';
  echo '<dd class="content"><p class="desc">' , __('Register image.<br />Image size. Width:1180px Height:350px', 'tcd-w') , '</p>';
  mlcf_media_form('type4_row4_image', __('Image', 'tcd-w'));
  echo '</dd>';
  echo '<dt class="label"><label for="type4_row4_headline">' , __('Headline for row4', 'tcd-w') , '</label></dt>';
  echo '<dd class="content"><p class="desc"></p>';
  echo '<input type="text" name="type4_row4_headline" id="type4_row4_headline" style="width:97%" value="', esc_attr(get_post_meta($post->ID, 'type4_row4_headline', true)), '" />';
  echo '</dd>';
  echo '<dt class="label"><label for="type4_row4_content">' , __('Content for row4', 'tcd-w') , '</label></dt>';
  echo '<dd class="content"><p class="desc"></p>';
  echo '<textarea name="type4_row4_content" id="type4_row4_content" cols="60" rows="2">', esc_textarea(get_post_meta($post->ID, 'type4_row4_content', true)), '</textarea>';
  echo '</dd>';
  // staff
  echo '<dt class="label"><label>' , __('Settings for staff contents', 'tcd-w') , '</label></dt>';
  echo '<dd class="content"><p class="desc">', __('You can register plural group of image and sentence, and use as Shortcode.', 'tcd-w'), '</p>';
  show_ml_repeater_meta_box($post, array('args' => array('group' => 'staff', 'shortcode' => 'tcd-w_staff')));
  echo '</dd>';
  // row5
  echo '<dt class="label"><label>' , __('Letter body for row5', 'tcd-w') , '</label></dt>';
  echo '<dd class="content"><p class="desc">', __('Enter letter body for row5. You can use Shortcode that is made in above.', 'tcd-w') ,'</p>';
  wp_editor(get_post_meta($post->ID, 'type4_body', true), 'type4_body', array(
      'textarea_name' => 'type4_body',
      'textarea_rows' => 7
  ));
  echo '</dd>';

  echo '</dl>';

  echo '<script type="text/javascript">';
  echo '  var rowcount = "'.strval(get_post_meta($post->ID, 'repeater_staff_row_count', true)).'";';
  echo '  if(rowcount != "") {';
  echo '    for(var i = 1; i <= Number(rowcount); i++) {';
  echo '      var checked = document.getElementById("repeater_" + i + "_staff_layout_2").getAttribute("checked");';
  echo '      if(checked != null && checked == "checked") {';
  echo '        document.getElementById("repeater_" + i + "_staff_image2_area").style.display = "block";';
  echo '        document.getElementById("repeater_" + i + "_staff_headline2_area").style.display = "block";';
  echo '        document.getElementById("repeater_" + i + "_staff_headline_sub2_area").style.display = "block";';
  echo '        document.getElementById("repeater_" + i + "_staff_body2_area").style.display = "block";';
  echo '      }';
  echo '    }';
  echo '  }';
  echo '  function onStaffLayoutClicked(id) { ';
  echo '    var arry = id.split("_");';
  echo '    var row = arry[1];';
  echo '    var value = arry[4];';
  echo '    if(value == "1") {';
  echo '        document.getElementById("repeater_" + row + "_staff_image2_area").style.display = "none";';
  echo '        document.getElementById("repeater_" + row + "_staff_headline2_area").style.display = "none";';
  echo '        document.getElementById("repeater_" + row + "_staff_headline_sub2_area").style.display = "none";';
  echo '        document.getElementById("repeater_" + row + "_staff_body2_area").style.display = "none";';
  echo '    } else {';
  echo '        document.getElementById("repeater_" + row + "_staff_image2_area").style.display = "block";';
  echo '        document.getElementById("repeater_" + row + "_staff_headline2_area").style.display = "block";';
  echo '        document.getElementById("repeater_" + row + "_staff_headline_sub2_area").style.display = "block";';
  echo '        document.getElementById("repeater_" + row + "_staff_body2_area").style.display = "block";';
  echo '    }';
  echo '  }';
  echo '</script>';

  //Menuページ ***************************************************************************************************************************************************************************************

  echo '<dl class="ml_custom_fields type2" id="ml_custom_fields_box5"' , ( $page_tcd_template_type_meta == 'type5' ) ? ' style="display:block;"' : ' style="display:none;"' , '>';
  echo '<dt class="headline"><label>' , __('Template_Menu', 'tcd-w') , '</label></dt>';

  //見出し
  echo '<dt class="label"><label for="type5_headline">' , __('Headline', 'tcd-w') , '</label></dt>';
  echo '<dd class="content"><p class="desc"></p>';
  echo '<input type="text" name="type5_headline" id="type5_headline" style="width:97%" value="', esc_attr(get_post_meta($post->ID, 'type5_headline', true)), '" />';
  echo '</dd>';
  //説明文
  echo '<dt class="label"><label for="type5_description">' , __('Description', 'tcd-w') , '</label></dt>';
  echo '<dd class="content"><p class="desc"></p>';
  echo '<textarea name="type5_description" id="type5_description" cols="60" rows="2">', esc_textarea(get_post_meta($post->ID, 'type5_description', true)), '</textarea>';
  echo '</dd>';
  //本文
  echo '<dt class="label"><label>' , __('Settings for menu contents', 'tcd-w') , '</label></dt>';
  echo '<dd class="content"><p class="desc">', __('You can register plural group of image and sentence for menu.', 'tcd-w'), '</p>';
  show_ml_repeater_meta_box($post, array('args' => array('group' => 'menu', 'shortcode' => 'tcd-w_menu')), false);
  echo '</dd>';
  echo '</dl>';

  //Accessページ ***************************************************************************************************************************************************************************************

  echo '<dl class="ml_custom_fields type2" id="ml_custom_fields_box6"' , ( $page_tcd_template_type_meta == 'type6' ) ? ' style="display:block;"' : ' style="display:none;"' , '>';

  //見出し
  echo '<dt class="headline"><label>' , __('Template_Access', 'tcd-w') , '</label></dt>';

  //見出し
  echo '<dt class="label"><label for="type6_headline">' , __('Headline', 'tcd-w') , '</label></dt>';
  echo '<dd class="content"><p class="desc"></p>';
  echo '<input type="text" name="type6_headline" id="type6_headline" style="width:97%" value="', esc_attr(get_post_meta($post->ID, 'type6_headline', true)), '" />';
  echo '</dd>';
  //説明文
  echo '<dt class="label"><label for="type6_description">' , __('Description', 'tcd-w') , '</label></dt>';
  echo '<dd class="content"><p class="desc"></p>';
  echo '<textarea name="type6_description" id="type6_description" cols="60" rows="2">', esc_textarea(get_post_meta($post->ID, 'type6_description', true)), '</textarea>';
  echo '</dd>';
  //自由項目
  echo '<dt class="label"><label>' , __('Free entry', 'tcd-w') ,'</label></dt>';
  echo '<dd class="content"><p class="desc">' , __('You can use HTML tags.', 'tcd-w') ,'</p>';
  wp_editor(get_post_meta($post->ID, 'type6_body', true), 'type6_body', array(
      'textarea_name' => 'type6_body',
      'textarea_rows' => 7
  ));
  echo '</dd>';
  //補足説明（左）
  echo '<dt class="label"><label>' , __('Sub description(Left)', 'tcd-w') ,'</label></dt>';
  echo '<dd class="content"><p class="desc">' , __('You can use HTML tags.', 'tcd-w') ,'</p>';
  wp_editor(get_post_meta($post->ID, 'type6_sub_left', true), 'type6_sub_left', array(
      'textarea_name' => 'type6_sub_left',
      'textarea_rows' => 7
  ));
  echo '</dd>';
  //補足説明（右）
  echo '<dt class="label"><label>' , __('Sub description(Right)', 'tcd-w') ,'</label></dt>';
  echo '<dd class="content"><p class="desc">' , __('You can use HTML tags.', 'tcd-w') ,'</p>';
  wp_editor(get_post_meta($post->ID, 'type6_sub_right', true), 'type6_sub_right', array(
      'textarea_name' => 'type6_sub_right',
      'textarea_rows' => 7
  ));
  echo '</dd>';
  //Googleマップ住所
  echo '<dt class="label"><label for="type6_map_addr">' , __('Google map', 'tcd-w') , '</label></dt>';
  echo '<dd class="content"><p class="desc">', __('Enter address. Google map will automatically build.', 'tcd-w') , '</p>';
  echo '<input type="text" name="type6_map_addr" id="type6_map_addr" style="width:97%" value="', esc_attr(get_post_meta($post->ID, 'type6_map_addr', true)), '" />';
  echo '</dd>';
  //GoogleマップAPIキー
  echo '<dt class="label"><label for="type6_api_key">' , __('API Key', 'tcd-w') , '</label></dt>';
  echo '<dd class="content"><p class="desc">', __('Enter API Key for Google Maps.', 'tcd-w') , '</p>';
  echo '<input type="text" name="type6_api_key" id="type6_api_key" style="width:97%" value="', esc_attr(get_post_meta($post->ID, 'type6_api_key', true)), '" />';
  echo '</dd>';

  echo '</dl>';

}

function save_custom_fields_meta_box( $post_id ) {

  // verify nonce
  if (!isset($_POST['custom_fields_meta_box_nonce']) || !wp_verify_nonce($_POST['custom_fields_meta_box_nonce'], basename(__FILE__))) {
    return $post_id;
  }

  // check autosave
  if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
    return $post_id;
  }

  // check permissions
  if ('page' == $_POST['post_type']) {
    if (!current_user_can('edit_page', $post_id)) {
      return $post_id;
    }
  } elseif (!current_user_can('edit_post', $post_id)) {
      return $post_id;
  }

  // save or delete
  $cf_keys = array(
      'page_tcd_template_type',
      'type3_row1_headline', 'type3_row2_content', 'type3_row2_image', 'type3_row3_content', 'type3_row3_image', 'type3_row4_image', 'type3_row4_headline', 'type3_row4_content', 'type3_row5_content', 'type3_row6_image', 'type3_row6_content', 'type3_row7_content', 'type3_row7_image',
      'type4_row1_headline', 'type4_row2_content', 'type4_row2_image', 'type4_row3_content', 'type4_row3_image', 'type4_row4_image', 'type4_row4_headline', 'type4_row4_content', 'type4_body',
      'type5_headline', 'type5_description', 'type5_body',
      'type6_headline', 'type6_description', 'type6_body', 'type6_sub_left', 'type6_sub_right', 'type6_map_addr', 'type6_api_key',
  );
  foreach ($cf_keys as $cf_key) {
    $old = get_post_meta($post_id, $cf_key, true);

    if (isset($_POST[$cf_key])) {
      $new = $_POST[$cf_key];
    } else {
      $new = '';
    }

    if ($new && $new != $old) {
      update_post_meta($post_id, $cf_key, $new);
    } elseif ('' == $new && $old) {
      delete_post_meta($post_id, $cf_key, $old);
    }
  }

}
add_action('save_post', 'save_custom_fields_meta_box');


/* フォーム用 画像フィールド出力 */
function mlcf_media_form($cf_key, $label) {
	global $post;
	if (empty($cf_key)) return false;
	if (empty($label)) $label = $cf_key;

	$media_id = get_post_meta($post->ID, $cf_key, true);
?>
  <div class="cf cf_media_field hide-if-no-js <?php echo esc_attr($cf_key); ?>">
    <input type="hidden" class="cf_media_id" name="<?php echo esc_attr($cf_key); ?>" id="<?php echo esc_attr($cf_key); ?>" value="<?php echo esc_attr($media_id); ?>" />
    <div class="preview_field"><?php if ($media_id) the_mlcf_image($post->ID, $cf_key); ?></div>
    <div class="buttton_area">
     <input type="button" class="cfmf-select-img button" value="<?php _e('Select Image', 'tcd-w'); ?>" />
     <input type="button" class="cfmf-delete-img button<?php if (!$media_id) echo ' hidden'; ?>" value="<?php _e('Remove Image', 'tcd-w'); ?>" />
    </div>
  </div>
<?php
}




/* 画像フィールドで選択された画像をimgタグで出力 */
function the_mlcf_image($post_id, $cf_key, $image_size = 'medium') {
	echo get_mlcf_image($post_id, $cf_key, $image_size);
}

/* 画像フィールドで選択された画像をimgタグで返す */
function get_mlcf_image($post_id, $cf_key, $image_size = 'medium') {
	global $post;
	if (empty($cf_key)) return false;
	if (empty($post_id)) $post_id = $post->ID;

	$media_id = get_post_meta($post_id, $cf_key, true);
	if ($media_id) {
		return wp_get_attachment_image($media_id, $image_size, $image_size);
	}

	return false;
}

/* 画像フィールドで選択された画像urlを返す */
function get_mlcf_image_url($post_id, $cf_key, $image_size = 'medium') {
	global $post;
	if (empty($cf_key)) return false;
	if (empty($post_id)) $post_id = $post->ID;

	$media_id = get_post_meta($post_id, $cf_key, true);
	if ($media_id) {
		$img = wp_get_attachment_image_src($media_id, $image_size);
		if (!empty($img[0])) {
			return $img[0];
		}
	}

	return false;
}

/* 画像フィールドで選択されたメディアのURLを出力 */
function the_mlcf_media_url($post_id, $cf_key) {
	echo get_mlcf_media_url($post_id, $cf_key);
}

/* 画像フィールドで選択されたメディアのURLを返す */
function get_mlcf_media_url($post_id, $cf_key) {
	global $post;
	if (empty($cf_key)) return false;
	if (empty($post_id)) $post_id = $post->ID;

	$media_id = get_post_meta($post_id, $cf_key, true);
	if ($media_id) {
		return wp_get_attachment_url($media_id);
	}

	return false;
}


