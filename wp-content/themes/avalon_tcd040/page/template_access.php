<?php
get_header();
$options = get_desing_plus_option();
?>
<div id="edit-area" class="post_content">
<?php
if ( have_posts() ) : while ( have_posts() ) : the_post();
	$type6_headline = esc_html(get_post_meta($post->ID, 'type6_headline', true));
	$type6_description = esc_html(get_post_meta($post->ID, 'type6_description', true));
	$type6_body = do_shortcode(get_post_meta($post->ID, 'type6_body', true));
	$type6_sub_left = do_shortcode(get_post_meta($post->ID, 'type6_sub_left', true));
	$type6_sub_right = do_shortcode(get_post_meta($post->ID, 'type6_sub_right', true));
	$type6_map_addr = get_post_meta($post->ID, 'type6_map_addr', true);
	$type6_api_key = get_post_meta($post->ID, 'type6_api_key', true);
	?>
	<div class="container">
    <?php get_template_part('breadcrumb'); ?>
		<h2 class="headline mb15"><?php echo $type6_headline ?></h2>
		<p class="desc1"><?php echo nl2br($type6_description) ?></p>
	</div>
	<div class="align1 mb100"><?php echo wpautop($type6_body) ?></div>
	<div class="container">
		<div class="row mb60">
			<div class="col-md-6">
				<?php echo wpautop($type6_sub_left) ?>
			</div>
			<div class="col-md-6">
				<?php echo wpautop($type6_sub_right) ?>
			</div>
		</div>
	</div>
	<?php if(!empty($type6_map_addr)) : ?>
		<div class="pt_google_map">
			<?php if (strpos($type6_map_addr, '[map ') !== false) : ?>
				<?php echo do_shortcode($type6_map_addr) ?>
			<?php else: ?>
				<div id="map-canvas" class="dp-google-map" style="height:400px; width:100%; "></div>
				<script src="https://maps.googleapis.com/maps/api/js?key=<?php esc_attr_e($type6_api_key) ?>"></script>
				<script type="text/javascript">
					google.maps.event.addDomListener(window, 'load', function(){
						var geocoder = new google.maps.Geocoder();
						var disabled = true ? false : true;
						var draggable = true;
						geocoder.geocode({'address':'<?php echo esc_attr($type6_map_addr); ?>'}, function(results, status) {
							if (status == google.maps.GeocoderStatus.OK){
								var mapOptions = {
									draggable: jQuery(document).width() > 480 && draggable == true ? true : false,
									center: results[0].geometry.location,
									zoom: 18,
									mapTypeId: google.maps.MapTypeId.ROADMAP,
									scrollwheel: false,
									disableDefaultUI: disabled,
									disableDoubleClickZoom: disabled,
									styles: []
								};
								var map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);
								var marker = new google.maps.Marker({
									map: map,
									position: results[0].geometry.location,
								});
								/*
								 var styleMono = [
								 {
								 featureType: 'all',
								 elementType: 'all',
								 stylers: [ { saturation: -100 } ]
								 }
								 ];
								 var styledMapOptions = {
								 map: map,
								 name: 'Mono'
								 };
								 var styledMapType = new google.maps.StyledMapType(styleMono, styledMapOptions);
								 map.mapTypes.set('mono', styledMapType);
								 map.setMapTypeId('mono');
								 */
							}
						})
					});
				</script>
			<?php endif; ?>
		</div>
	<?php endif; ?>
<?php endwhile; endif; ?>
</div><!-- / #edit-area -->
<?php get_footer(); ?>
