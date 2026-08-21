<?php
	$options = get_desing_plus_option();
	$side_col_align = 'left';
	if($options['layout'] === 'type2') {
		$side_col_align = 'right';
	}
?>
<div id="side_col" class="col-md-2 side_col_<?php echo $side_col_align ?>">
	<!-- logo -->
	<?php header_logo(); ?>
	
	<a href="#" class="menu_button pc-none"><span>menu</span></a>
	<div id="global_menu" class="clearfix">
		<?php if (has_nav_menu('global-menu')) { ?>
			<?php wp_nav_menu( array( 'sort_column' => 'menu_order', 'theme_location' => 'global-menu' , 'container' => '' ) ); ?>
		<?php } ?>
	</div>
	<!-- social button -->
	<ul class="user_sns clearfix sp-none">
		<?php if(is_blankstr($options['snsurl_tiktok']) == FALSE): ?><li class="tiktok"><a href="<?php esc_attr_e($options['snsurl_tiktok']) ?>" target="_blank"><span>TikTok</span></a></li><?php endif; ?>
		<?php if(is_blankstr($options['snsurl_twitter']) == FALSE): ?><li class="twitter"><a href="<?php esc_attr_e($options['snsurl_twitter']) ?>" target="_blank"><span>Twitter</span></a></li><?php endif; ?>
		<?php if(is_blankstr($options['snsurl_facebook']) == FALSE): ?><li class="facebook"><a href="<?php esc_attr_e($options['snsurl_facebook']) ?>" target="_blank"><span>Facebook</span></a></li><?php endif; ?>
		<?php if(is_blankstr($options['snsurl_instagram']) == FALSE): ?><li class="insta"><a href="<?php esc_attr_e($options['snsurl_instagram']) ?>" target="_blank"><span>Instagram</span></a></li><?php endif; ?>
		<?php if(is_blankstr($options['snsurl_pinterest']) == FALSE): ?><li class="pint"><a href="<?php esc_attr_e($options['snsurl_pinterest']) ?>" target="_blank"><span>Pinterest</span></a></li><?php endif; ?>
		<?php if(is_blankstr($options['snsurl_flickr']) == FALSE): ?><li class="flickr"><a href="<?php esc_attr_e($options['snsurl_flickr']) ?>" target="_blank"><span>Flickr</span></a></li><?php endif; ?>
		<?php if(is_blankstr($options['snsurl_tumblr']) == FALSE): ?><li class="tumblr"><a href="<?php esc_attr_e($options['snsurl_tumblr']) ?>" target="_blank"><span>Tumblr</span></a></li><?php endif; ?>
	</ul>
	<div class="store-information sp-none">
		<?php if(is_blankstr($options['shop_name']) == FALSE): ?><p class="store-name"><?php esc_html_e($options['shop_name']) ?></p><?php endif; ?>
		<?php if(is_blankstr($options['shop_addr']) == FALSE): ?><p class="store-address"><?php echo nl2br(esc_html($options['shop_addr'])) ?></p><?php endif; ?>
		<?php if(is_blankstr($options['shop_tel']) == FALSE): ?><p class="store-tel"><span>TEL.</span><?php esc_html_e($options['shop_tel']) ?></p><?php endif; ?>
	</div>
</div>
