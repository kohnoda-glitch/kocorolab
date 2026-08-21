<?php

class Walker_Category_Find_Parents extends Walker_Category {
	function start_el( &$output, $category, $depth = 0, $args = array(), $id = 0 ) {
	extract($args);
	$cat_name = esc_attr( $category->name );
	$cat_name = apply_filters( 'list_cats', $cat_name, $category );
	$link = '<a href="' . esc_url( get_term_link($category) ) . '" ';
	if ( $use_desc_for_title == 0 || empty($category->description) )
		$link .= 'title="' . esc_attr( sprintf(__( 'View all posts filed under %s', 'tcd-w' ), $cat_name) ) . '"';
	else
		$link .= 'title="' . esc_attr( strip_tags( apply_filters( 'category_description', $category->description, $category ) ) ) . '"';
		$link .= '>';
		$link .= $cat_name . '</a>';
		if ( !empty($show_count) )
			$link .= ' (' . intval($category->count) . ')';
			if ( 'list' == $args['style'] ) {
				$output .= "\t<li";
				$class = 'cat-item cat-item-' . $category->term_id;
				$termchildren = get_term_children( $category->term_id, $category->taxonomy );
				if(count($termchildren)>0){
					$class .=  ' parent_category';
				}
				if ( !empty($current_category) ) {
					$_current_category = get_term( $current_category, $category->taxonomy );
					if ( $category->term_id == $current_category )
						$class .=  ' current-cat';
					elseif ( $category->term_id == $_current_category->parent )
						$class .=  ' current-cat-parent';
				}
					$output .=  ' class="' . $class . '"';
					$output .= ">$link\n";
			} else {
				$output .= "\t$link<br />\n";
			}
	}
}

 // Start class widget //
 class tcdw_category_list_widget extends WP_Widget {

 // Constructor //
	function __construct() {
		parent::__construct(
			'tcdw_category_list_widget', // ID
			__( 'Category list (tcd ver)', 'tcd-w' ), // Name
			array( 
				'classname' => 'tcdw_category_list_widget',
				'description' => __( 'Displays designed category list.', 'tcd-w' ) 
			)
		);
	}

 // Extract Args //
 function widget($args, $instance) {
  extract( $args );
   $title = apply_filters('widget_title', $instance['title']); // the widget title
   $exclude_cat_num = $instance['exclude_cat_num']; // category id to exclude

   // Before widget //
   echo $before_widget;

   // Title of widget //
   if ( $title ) { echo $before_title . $title . $after_title; }

   // Widget output //

$args = array(
  'exclude'   => $exclude_cat_num,
  'title_li'     => '',
  'hierarchical' => 1,
  'walker'       => new Walker_Category_Find_Parents(),
);

?>
<ul class="collapse_category_list">
 <?php wp_list_categories($args); ?>
</ul>
<?php

   // After widget //
   echo $after_widget;

} // end function widget


 // Update Settings //
 function update($new_instance, $old_instance) {
  $instance['title'] = strip_tags($new_instance['title']);
  $instance['exclude_cat_num'] = $new_instance['exclude_cat_num'];
  return $instance;
 }

 // Widget Control Panel //
 function form($instance) {
  $defaults = array( 'title' => __('Category list', 'tcd-w'), 'exclude_cat_num' => '');
  $instance = wp_parse_args( (array) $instance, $defaults );
?>
<p>
 <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'tcd-w'); ?></label>
 <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>'" type="text" value="<?php echo $instance['title']; ?>" />
</p>
<p>
 <label for="<?php echo $this->get_field_id('exclude_cat_num'); ?>"><?php _e('Categories To Exclude:', 'tcd-w'); ?></label>
 <input class="widefat" id="<?php echo $this->get_field_id('exclude_cat_num'); ?>" name="<?php echo $this->get_field_name('exclude_cat_num'); ?>'" type="text" value="<?php echo $instance['exclude_cat_num']; ?>" />
 <span><?php _e('Enter a comma-seperated list of category ID numbers, example 2,4,10<br />(Don\'t enter comma for last number).', 'tcd-w'); ?></span>
</p>
<?php
 } // end function form
}

// End class widget
add_action('widgets_init', function(){register_widget('tcdw_category_list_widget');});
?>
