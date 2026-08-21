<?php

function news_link_meta_box() {
  add_meta_box(
    'add_product_option',//ID of meta box
    __('News link setting', 'tcd-w'),//label
    'show_news_link_meta_box',//callback function
    'news',// post type
    'normal',// context
    'low'// priority
  );
}
add_action('add_meta_boxes', 'news_link_meta_box');

function show_news_link_meta_box() {
  global $post;
  $options =  get_desing_plus_option();

  //記事のリンク先
  $news_link = array( 'name' => __('Link URL for this post', 'tcd-w'), 'desc' => __('Please enter URL if you want to link this post to other website', 'tcd-w'), 'id' => 'news_link', 'type' => 'input', 'std' => '' );
  $news_link_meta = esc_html(get_post_meta($post->ID, 'news_link', true));

  echo '<input type="hidden" name="news_link_meta_box_nonce" value="', wp_create_nonce(basename(__FILE__)), '" />';

  echo '<dl class="ml_custom_fields">';

  echo '<dt class="label"><label for="' , $news_link['id'] , '">' , $news_link['name'] , '</label></dt>';
  echo '<dd class="content"><p class="desc">' , $news_link['desc'] , '</p>';
  echo '<input type="text" name="', $news_link['id'], '" id="', $news_link['id'], '" value="', $news_link_meta ? $news_link_meta : $news_link['std'], '" size="30" style="width:100%" /></dd>';

  echo '</dl>';

}

function save_news_link_meta_box( $post_id ) {

  // verify nonce
  if (!isset($_POST['news_link_meta_box_nonce']) || !wp_verify_nonce($_POST['news_link_meta_box_nonce'], basename(__FILE__))) {
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
  $cf_keys = array('news_link');
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
add_action('save_post', 'save_news_link_meta_box');



