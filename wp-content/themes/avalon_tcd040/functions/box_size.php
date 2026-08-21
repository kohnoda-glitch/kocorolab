<?php

function box_size_meta_box() {
  add_meta_box(
    'add_box_size_option',//ID of meta box
    __('Set box size for post list', 'tcd-w'),//label
    'show_box_size_meta_box',//callback function
    'product',// post type
    'side',// context
    'low'// priority
  );
}
add_action('add_meta_boxes', 'box_size_meta_box');

function show_box_size_meta_box() {
  global $post;
  $options =  get_desing_plus_option();

  //レイアウトのタイプ
  $box_size =
		array(
			'name' => __('Box size', 'tcd-w'),
			'id' => 'box_size',
			'type' => 'radio',
      'std' => 'type1',
			'options' => array(
				array('name' => __('Box size1<br />(Width:600px Height:600px)', 'tcd-w'), 'value' => 'type1'),
				array('name' => __('Box size2<br />(Width:1200px Height:600px)', 'tcd-w'), 'value' => 'type2')
			)
    );
  $box_size_meta = get_post_meta($post->ID, 'box_size', true);


  echo '<input type="hidden" name="box_size_meta_box_nonce" value="', wp_create_nonce(basename(__FILE__)), '" />';

  //テンプレートの選択 ***********************************************************************************************************************************************************************************
  echo '<dl class="ml_custom_fields_select" id="ml_box_select">';

  echo '<dt class="label"><label for="' , $box_size['id'] , '">' , $box_size['name'] , '</label></dt>';
  echo '<dd class="content"><ul class="radio template cf">';
	foreach ($box_size['options'] as $box_size_option) {
    echo '<li><label', ( ( empty($box_size_meta) && $box_size_option['value'] == 'type1' ) || $box_size_meta == $box_size_option['value'] ) ? ' class="active"' : '' ,'><input type="radio" id ="box_size_', $box_size_option['value'], '" name="', $box_size['id'], '" value="', $box_size_option['value'], '"', ($box_size_meta == $box_size_option['value'] || $box_size['std'] == $box_size_option['value']) ? ' checked="checked"' : '', ' />', $box_size_option['name'] , '</label></li>';
  }
  echo '</ul></dd>';

  echo '</dl>';

}

function save_box_size_meta_box( $post_id ) {

  // verify nonce
  if (!isset($_POST['box_size_meta_box_nonce']) || !wp_verify_nonce($_POST['box_size_meta_box_nonce'], basename(__FILE__))) {
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
  $cf_keys = array('box_size');
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
add_action('save_post', 'save_box_size_meta_box');



