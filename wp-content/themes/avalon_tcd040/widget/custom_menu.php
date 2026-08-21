<?php

 // Start class widget //
 class tcdw_custom_menu_widget extends WP_Widget {

 // Constructor //
	function __construct() {
		parent::__construct(
			'tcdw_custom_menu_widget', // ID
			__( 'Designed custom menu for footer (tcd ver)', 'tcd-w' ), // Name
			array( 
				'classname' => 'tcdw_custom_menu_widget',
				'description' => __( 'Displays designed custom menu for footer.', 'tcd-w' ) 
			)
		);
	}

 // Extract Args //
 function widget($args, $instance) {
  extract( $args );
   $nav_menu = ! empty( $instance['nav_menu'] ) ? wp_get_nav_menu_object( $instance['nav_menu'] ) : false;

   if ( !$nav_menu )
     return;

   $title = apply_filters('widget_title', $instance['title']); // the widget title
   $menu_id = $nav_menu->term_id;

   // Before widget //
   echo $before_widget;

   // Title of widget //
   if ( $title ) { echo $before_title . $title . $after_title; }


   // Widget output //
   wp_nav_menu( array( 'sort_column' => 'menu_order', 'menu' => $menu_id , 'menu_class' => 'collapse_category_list' , 'container' => '' ) );
   //wp_nav_menu( apply_filters( 'widget_nav_menu_args', $nav_menu_args, $nav_menu, $args, $instance ) );

   // After widget //
   echo $after_widget;

} // end function widget


 // Update Settings //
 function update($new_instance, $old_instance) {
  $instance['title'] = strip_tags($new_instance['title']);
  $instance['nav_menu'] = (int) $new_instance['nav_menu'];

  return $instance;
 }

 // Widget Control Panel //
 function form($instance) {
  $defaults = array( 'title' => __('Category list', 'tcd-w'), 'nav_menu' =>'');
  $instance = wp_parse_args( (array) $instance, $defaults );
  $nav_menu = isset( $instance['nav_menu'] ) ? $instance['nav_menu'] : '';
  $menus = wp_get_nav_menus();
?>
<p>
 <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'tcd-w'); ?></label>
 <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>'" type="text" value="<?php echo $instance['title']; ?>" />
</p>
<p class="nav-menu-widget-no-menus-message" <?php if ( ! empty( $menus ) ) { echo ' style="display:none" '; } ?>>
<?php
	if ( isset( $GLOBALS['wp_customize'] ) && $GLOBALS['wp_customize'] instanceof WP_Customize_Manager ) {
		$url = 'javascript: wp.customize.panel( "nav_menus" ).focus();';
	} else {
		$url = admin_url( 'nav-menus.php' );
	}
	?>
	<?php echo sprintf( __( 'No menus have been created yet. <a href="%s">Create some</a>.' ), esc_attr( $url ) ); ?>
</p>
<div class="nav-menu-widget-form-controls" <?php if ( empty( $menus ) ) { echo ' style="display:none" '; } ?>>
	<p>
		<label for="<?php echo $this->get_field_id( 'nav_menu' ); ?>"><?php _e( 'Select Menu:' ); ?></label>
		<select class="widefat" id="<?php echo $this->get_field_id( 'nav_menu' ); ?>" name="<?php echo $this->get_field_name( 'nav_menu' ); ?>">
			<option value="0"><?php _e( '&mdash; Select &mdash;' ); ?></option>
			<?php foreach ( $menus as $menu ) : ?>
				<option value="<?php echo esc_attr( $menu->term_id ); ?>" <?php selected( $nav_menu, $menu->term_id ); ?>>
					<?php echo esc_html( $menu->name ); ?>
				</option>
			<?php endforeach; ?>
		</select>
	</p>
</div>
<?php
 } // end function form
}

// End class widget
add_action('widgets_init', function(){register_widget('tcdw_custom_menu_widget');});
?>
