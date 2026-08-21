<?php

function product_meta_box() {
  add_meta_box(
    'add_product_option',//ID of meta box
    __('Product page contents', 'tcd-w'),//label
    'show_product_meta_box',//callback function
    'product',// post type
    'normal',// context
    'high'// priority
  );
}
add_action('add_meta_boxes', 'product_meta_box');

function show_product_meta_box() {
  global $post;
  $options =  get_desing_plus_option();

  //キャッチフレーズ
  $catch = array( 'name' => __('Main catchphrase for this product', 'tcd-w'), 'desc' => __('This catchphrase will be displayed at product list and product single page..<br />If this field is empty product title will be displayed at product list.', 'tcd-w'), 'id' => 'catch', 'type' => 'textarea', 'std' => '' );
  $catch_meta = esc_html(get_post_meta($post->ID, 'catch', true));

  //1段目 見出し
  $row1_headline = array( 'name' => __('Catchphrase for first row', 'tcd-w'), 'desc' => __('Enter catchphrase for first row.', 'tcd-w'), 'id' => 'row1_headline', 'type' => 'textarea', 'std' => '' );
  $row1_headline_meta = esc_html(get_post_meta($post->ID, 'row1_headline', true));

  //1段目 説明文
  $row1_desc_meta = get_post_meta( $post->ID, 'row1_desc', true );

  //2段目 見出し
  $row2_headline = array( 'name' => __('Catchphrase for second row', 'tcd-w'), 'desc' => __('Enter catchphrase for second row.', 'tcd-w'), 'id' => 'row2_headline', 'type' => 'textarea', 'std' => '' );
  $row2_headline_meta = esc_html(get_post_meta($post->ID, 'row2_headline', true));

  //2段目 説明文
  $row2_desc_meta = get_post_meta( $post->ID, 'row2_desc', true );

  //3段目 見出し
  $row3_headline = array( 'name' => __('Catchphrase for third row', 'tcd-w'), 'desc' => __('Enter catchphrase for third row.', 'tcd-w'), 'id' => 'row3_headline', 'type' => 'textarea', 'std' => '' );
  $row3_headline_meta = esc_html(get_post_meta($post->ID, 'row3_headline', true));

  //3段目 説明文
  $row3_desc_meta = get_post_meta( $post->ID, 'row3_desc', true );

  //4段目 説明文
  $row4_desc_meta = get_post_meta( $post->ID, 'row4_desc', true );

  echo '<input type="hidden" name="product_meta_box_nonce" value="', wp_create_nonce(basename(__FILE__)), '" />';

  echo '<dl class="ml_custom_fields">';

  //メインキャッチフレーズ
  echo '<dt class="label"><label for="' , $catch['id'] , '">' , $catch['name'] , '</label></dt>';
  echo '<dd class="content"><p class="desc">' , $catch['desc'] , '</p>';
  echo '<textarea name="', $catch['id'], '" id="', $catch['id'], '" cols="60" rows="2" style="width:97%">', $catch_meta ? $catch_meta : $catch['std'], '</textarea>';

  //1段目 見出し1
  echo '<dt class="label"><label for="' , $row1_headline1['id'] , '">' , $row1_headline['name'] , '</label></dt>';
  echo '<dd class="content"><p class="desc">' , $row1_headline['desc'] , '</p>';
  echo '<textarea name="', $row1_headline['id'], '" id="', $row1_headline['id'], '" cols="60" rows="1" style="width:97%">', $row1_headline_meta ? $row1_headline_meta : $row1_headline['std'], '</textarea>';

  //1段目 説明文
  echo '<dt class="label"><label>' , __('Description for first row', 'tcd-w') ,'</label></dt>';
  echo '<dd class="content"><p class="desc">' , __('Enter description for first row.', 'tcd-w') , '</p>';
  wp_editor( $row1_desc_meta, 'row1_desc', array(
      'textarea_name' => 'row1_desc',
      'textarea_rows' => 7
  ));
  echo '</dd>';

  //1段目 画像
  echo '<dt class="label"><label>' , __('Image for first row', 'tcd-w') ,'</label></dt>';
  echo '<dd class="content"><p class="desc">' , __('Register image for first row.<br />Image size. Width:600px Height:600px', 'tcd-w') , '</p>';
    mlcf_media_form('row1_image', __('Image', 'tcd-w'));
  echo '</dd>';

  //2段目 見出し1
  echo '<dt class="label"><label for="' , $row2_headline1['id'] , '">' , $row2_headline['name'] , '</label></dt>';
  echo '<dd class="content"><p class="desc">' , $row2_headline['desc'] , '</p>';
  echo '<textarea name="', $row2_headline['id'], '" id="', $row2_headline['id'], '" cols="60" rows="1" style="width:97%">', $row2_headline_meta ? $row2_headline_meta : $row2_headline['std'], '</textarea>';

  //2段目 説明文
  echo '<dt class="label"><label>' , __('Description for second row', 'tcd-w') ,'</label></dt>';
  echo '<dd class="content"><p class="desc">' , __('Enter description for second row.', 'tcd-w') , '</p>';
  wp_editor( $row2_desc_meta, 'row2_desc', array(
      'textarea_name' => 'row2_desc',
      'textarea_rows' => 7
  ));
  echo '</dd>';

  //2段目 画像
  echo '<dt class="label"><label>' , __('Image for second row', 'tcd-w') ,'</label></dt>';
  echo '<dd class="content"><p class="desc">' , __('Register image for second row.<br />Image size. Width:600px Height:600px', 'tcd-w') , '</p>';
    mlcf_media_form('row2_image', __('Image', 'tcd-w'));
  echo '</dd>';

  //3段目 見出し1
  echo '<dt class="label"><label for="' , $row3_headline1['id'] , '">' , $row3_headline['name'] , '</label></dt>';
  echo '<dd class="content"><p class="desc">' , $row3_headline['desc'] , '</p>';
  echo '<textarea name="', $row3_headline['id'], '" id="', $row3_headline['id'], '" cols="60" rows="1" style="width:97%">', $row3_headline_meta ? $row3_headline_meta : $row3_headline['std'], '</textarea>';

  //3段目 説明文
  echo '<dt class="label"><label>' , __('Description for third row', 'tcd-w') ,'</label></dt>';
  echo '<dd class="content"><p class="desc">' , __('Enter description for third row.', 'tcd-w') , '</p>';
  wp_editor( $row3_desc_meta, 'row3_desc', array(
      'textarea_name' => 'row3_desc',
      'textarea_rows' => 7
  ));
  echo '</dd>';

  //3段目 画像
  echo '<dt class="label"><label>' , __('Image for third row', 'tcd-w') ,'</label></dt>';
  echo '<dd class="content"><p class="desc">' , __('Register image for third row.<br />Image size. Width:600px Height:600px', 'tcd-w') , '</p>';
    mlcf_media_form('row3_image', __('Image', 'tcd-w'));
  echo '</dd>';

  //4段目 説明文
  echo '<dt class="label"><label>' , __('Description for fourth row', 'tcd-w') ,'</label></dt>';
  echo '<dd class="content"><p class="desc">' , __('Enter description for fourth row.', 'tcd-w') , '</p>';
  wp_editor( $row4_desc_meta, 'row4_desc', array(
      'textarea_name' => 'row4_desc',
      'textarea_rows' => 10
  ));
  echo '</dd>';

  echo '</dl>';

}

function save_product_meta_box( $post_id ) {

  // verify nonce
  if (!isset($_POST['product_meta_box_nonce']) || !wp_verify_nonce($_POST['product_meta_box_nonce'], basename(__FILE__))) {
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
  $cf_keys = array('catch','row1_headline','row1_desc','row1_image','row2_headline','row2_desc','row2_image','row3_headline','row3_desc','row3_image','row4_desc');
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
add_action('save_post', 'save_product_meta_box');



