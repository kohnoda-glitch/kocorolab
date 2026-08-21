<?php

function dp_styled_post_list_thumbnail_e() {
  $options = get_desing_plus_option();
  $effect_type = 1;
  if($options['hover_type'] == 'type3') {
    $effect_type = 2;
  } else if($options['hover_type'] == 'type1') {
    $effect_type = 3;
  }
 $a1 = '<a class="image hvr_ef'.$effect_type.'" href="' . get_the_permalink() . '"><div class="img-wrap">';
 $a2 = '</div></a>';
 $image_src = false;
 if ( has_post_thumbnail() ) {
  $image_src = wp_get_attachment_image_src( get_post_thumbnail_id(), 'thumbnail_size' );
  if ($image_src) {
   if($image_src[1] == 100 && $image_src[2] == 100 ) {
    echo $a1.'<img src="' . esc_attr( $image_src[0] ) . '" alt="' . get_the_title() . '" />'.$a2;
   } else {
    echo $a1.'<img src="' . esc_attr( $image_src[0] ) . '" alt="' . get_the_title() . '" width="100px" height="100px" />'.$a2;
   }
  }
 }
 if ($image_src == false) {
  echo $a1.'<img src = "'.get_template_directory_uri().'/img/common/no_image_card.gif" alt = "NO IMAGE" width="100px" height="100px" />'.$a2;
 }
}

 // Start class widget //
 class styled_post_list1_widget extends WP_Widget {

 // Constructor //
	function __construct() {
		parent::__construct(
			'styled_post_list1_widget', // ID
			__( 'Styled post list (tcd ver)', 'tcd-w' ), // Name
			array( 
				'classname' => 'styled_post_list1_widget',
				'description' => __( 'Displays styled post list.', 'tcd-w' ) 
			)
		);
	}

  // Extract Args //
 function widget($args, $instance) {
  extract( $args );
   $title = apply_filters('widget_title', $instance['title']);
   $post_num = $instance['post_num'];
   $post_type = $instance['post_type'];
   $show_date = $instance['show_date'];

   $post_order = $instance['post_order'];
   if($post_order=='date2'){ $order = 'ASC'; } else { $order = 'DESC'; };
   if($post_order=='date1'||$post_order=='date2'){ $post_order = 'date'; };

   // Before widget //
   echo $before_widget;

   // Title of widget //
   if ( $title ) { echo $before_title . $title . $after_title; }

   // Widget output //
   if($post_type == 'recent_post') {
     $args = array('post_type' => 'post', 'posts_per_page' => $post_num, 'ignore_sticky_posts' => 1, 'orderby' => $post_order, 'order' => $order);
   } else {
     $args = array('post_type' => 'post', 'posts_per_page' => $post_num, 'ignore_sticky_posts' => 1, 'orderby' => $post_order, 'order' => $order, 'meta_key' => $post_type, 'meta_value' => 'on');
   };

   $options = get_desing_plus_option();
   $pickup_post=new WP_Query($args);
?>
<ul class="styled_post_list2">
<?php
   if ($pickup_post->have_posts()) {
    while ($pickup_post->have_posts()) : $pickup_post->the_post();
?>
 <li class="clearfix">
   <?php dp_styled_post_list_thumbnail_e() ?>
   <div class="title"><a href="<?php the_permalink() ?>"><?php trim_title(25); ?></a></div>
   <?php if ($show_date == '1'){ ?><time class="date"><?php the_time('Y.m.j'); ?></time><?php }; ?>
 </li>
<?php endwhile; wp_reset_query(); } else { ?>
 <li class="no_post"><?php _e('There is no registered post.', 'tcd-w');  ?></li>
<?php }; ?>
</ul>
<?php

   // After widget //
   echo $after_widget;

} // end function widget

 // Update Settings //
 function update($new_instance, $old_instance) {
  $instance['title'] = strip_tags($new_instance['title']);
  $instance['post_num'] = $new_instance['post_num'];
  $instance['post_order'] = $new_instance['post_order'];
  $instance['post_type'] = $new_instance['post_type'];
  $instance['show_date'] = $new_instance['show_date'];
  return $instance;
 }

 // Widget Control Panel //
 function form($instance) {
  $defaults = array( 'title' => __('Recent post', 'tcd-w'), 'post_num' => 5, 'post_order' => 'date1', 'post_type' => 'recent_post', 'show_date' => 1);
  $instance = wp_parse_args( (array) $instance, $defaults );
?>
<p>
 <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'tcd-w'); ?></label>
 <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>'" type="text" value="<?php echo $instance['title']; ?>" />
</p>
<p>
 <label for="<?php echo $this->get_field_id('post_type'); ?>"><?php _e('Post type:', 'tcd-w'); ?></label>
 <select id="<?php echo $this->get_field_id('post_type'); ?>" name="<?php echo $this->get_field_name('post_type'); ?>" class="widefat" style="width:100%;">
  <option value="recent_post" <?php selected('recent_post', $instance['post_type']); ?>><?php _e('Recent post', 'tcd-w'); ?></option>
  <option value="recommend_post1" <?php selected('recommend_post1', $instance['post_type']); ?>><?php _e('Recommend post1', 'tcd-w'); ?></option>
  <option value="recommend_post2" <?php selected('recommend_post2', $instance['post_type']); ?>><?php _e('Recommend post2', 'tcd-w'); ?></option>
  <option value="pickup_post" <?php selected('pickup_post', $instance['post_type']); ?>><?php _e('Pickup post', 'tcd-w'); ?></option>
  <option value="featured_post" <?php selected('featured_post', $instance['post_type']); ?>><?php _e('Featured post', 'tcd-w'); ?></option>
 </select>
</p>
<p>
 <label for="<?php echo $this->get_field_id('post_num'); ?>"><?php _e('Number of post:', 'tcd-w'); ?></label>
 <select id="<?php echo $this->get_field_id('post_num'); ?>" name="<?php echo $this->get_field_name('post_num'); ?>" class="widefat" style="width:100%;">
  <option value="1" <?php selected('1', $instance['post_num']); ?>>1</option>
  <option value="2" <?php selected('2', $instance['post_num']); ?>>2</option>
  <option value="3" <?php selected('3', $instance['post_num']); ?>>3</option>
  <option value="4" <?php selected('4', $instance['post_num']); ?>>4</option>
  <option value="5" <?php selected('5', $instance['post_num']); ?>>5</option>
  <option value="6" <?php selected('6', $instance['post_num']); ?>>6</option>
  <option value="7" <?php selected('7', $instance['post_num']); ?>>7</option>
  <option value="8" <?php selected('8', $instance['post_num']); ?>>8</option>
  <option value="9" <?php selected('9', $instance['post_num']); ?>>9</option>
  <option value="10" <?php selected('10', $instance['post_num']); ?>>10</option>
 </select>
</p>
<p>
 <label for="<?php echo $this->get_field_id('post_order'); ?>"><?php _e('Post order:', 'tcd-w'); ?></label>
 <select id="<?php echo $this->get_field_id('post_order'); ?>" name="<?php echo $this->get_field_name('post_order'); ?>" class="widefat" style="width:100%;">
  <option value="date1" <?php selected('date1', $instance['post_order']); ?>><?php _e('Date (DESC)', 'tcd-w'); ?></option>
  <option value="date2" <?php selected('date2', $instance['post_order']); ?>><?php _e('Date (ASC)', 'tcd-w'); ?></option>
  <option value="rand" <?php selected('rand', $instance['post_order']); ?>><?php _e('Random', 'tcd-w'); ?></option>
 </select>
</p>
<p>
 <input id="<?php echo $this->get_field_id('show_date'); ?>" name="<?php echo $this->get_field_name('show_date'); ?>" type="checkbox" value="1" <?php checked( '1', $instance['show_date'] ); ?> />
 <label for="<?php echo $this->get_field_id('show_date'); ?>"><?php _e('Display date', 'tcd-w'); ?></label>
</p>
<?php
 } // end function form
}

// End class widget
add_action('widgets_init', function(){register_widget('styled_post_list1_widget');});
?>
