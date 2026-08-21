<?php

// output scripts in footer
wp_enqueue_script(
	'share_button',
	get_stylesheet_directory_uri().'/js/share_button.js',
	array('jquery'),
	version_num(),
	true
);

// share button setting
global $share_button_options;

// merge default setting
$share_button_options = array_merge(
	array(
		'post_id'			=> null,
		'url'				=> null,
		'title'				=> null,
		'class'				=> 'share_button_design_type1',
		'style'				=> null,
		'show_twitter'		=> true,
		'show_facebook'		=> true,
		'show_hatebu'		=> true,
		'show_googleplus'	=> true,
	),
	(array) $share_button_options
);

if (empty($share_button_options['post_id'])) {
	$share_button_options['post_id'] = get_the_ID();
}
if (empty($share_button_options['url'])) {
	$share_button_options['url'] = get_permalink($share_button_options['post_id']);
}
if (empty($share_button_options['title'])) {
	$share_button_options['title'] =  get_the_title($share_button_options['title']);
}
if (!empty($share_button_options['class']) && is_array($share_button_options['class'])) {
	$share_button_options['class'] =  implode(' ', $share_button_options['title']);
}

?>
<div class="share_button <?php echo $share_button_options['class']; ?> clearfix" data-share-url="<?php echo esc_attr($share_button_options['url']); ?>"<?php if (!empty($share_button_options['style'])) echo ' style="'.esc_attr($share_button_options['style']).'"'; ?>>
  <ul class="snsb snsb-balloon clearfix">
<?php
	if (!empty($share_button_options['show_twitter'])) {
?>
    <li class="balloon-btn twitter-balloon-btn clearfix">
      <span class="balloon-btn-set">
        <span class="arrow-box">
          <a href="https://twitter.com/search?q=<?php echo urlencode(get_the_permalink()); ?>" target="blank" class="arrow-box-link twitter-arrow-box-link" rel="nofollow" title="Twitter">
            <span class="social-count twitter-count-new"><span class="word">Post</span></span>
          </a>
        </span>
        <a href="http://twitter.com/share?text=<?php echo urlencode($share_button_options['title']); ?>&url=<?php echo rawurlencode($share_button_options['url']); ?>" target="blank" class="balloon-btn-link twitter-balloon-btn-link" rel="nofollow" title="Twitter">
          <span class="icon">Twitter</span>
        </a>
      </span>
    </li>
<?php
	}
	if (!empty($share_button_options['show_facebook'])) {
?>
    <li class="balloon-btn facebook-balloon-btn clearfix">
      <span class="balloon-btn-set">
        <span class="arrow-box">
          <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo rawurlencode($share_button_options['url']); ?>&t=<?php echo urlencode($share_button_options['title']); ?>" target="blank" class="arrow-box-link facebook-arrow-box-link" rel="nofollow" title="Facebook">
            <span class="social-count facebook-count"><i class="fa fa-spinner fa-spin"></i></span>
          </a>
        </span>
        <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo rawurlencode($share_button_options['url']); ?>&t=<?php echo urlencode($share_button_options['title']); ?>" target="blank" class="balloon-btn-link facebook-balloon-btn-link" rel="nofollow" title="Facebook">
          <span class="icon">Facebook</span>
        </a>
      </span>
    </li>
<?php
	}
	if (!empty($share_button_options['show_hatebu'])) {
?>
    <li class="balloon-btn hatena-balloon-btn clearfix">
      <span class="balloon-btn-set">
        <span class="arrow-box">
          <a href="http://b.hatena.ne.jp/entry/<?php echo $share_button_options['url']; ?>" target="blank" class="arrow-box-link hatena-arrow-box-link" rel="nofollow" title="はてなブックマーク">
            <span class="social-count hatebu-count"><i class="fa fa-spinner fa-spin"></i></span>
          </a>
        </span>
        <a href="http://b.hatena.ne.jp/add?mode=confirm&url=<?php echo rawurlencode($share_button_options['url']); ?>&title=<?php echo urlencode($share_button_options['title']); ?>" target="blank" class="balloon-btn-link hatena-balloon-btn-link" rel="nofollow" title="はてなブックマーク">
          <span class="icon">はてなブックマーク</span>
        </a>
      </span>
    </li>
<?php
	}
	if (!empty($share_button_options['show_googleplus'])) {
?>
    <li class="balloon-btn googleplus-balloon-btn clearfix">
      <span class="balloon-btn-set">
        <span class="arrow-box">
          <a href="https://plus.google.com/share?url=<?php echo rawurlencode($share_button_options['url']); ?>" onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;" target="blank" class="arrow-box-link googleplus-arrow-box-link" rel="nofollow" title="Google Plus">
            <span class="googleplus-count"><i class="fa fa-spinner fa-spin"></i></span>
          </a>
        </span>
        <a href="https://plus.google.com/share?url=<?php echo rawurlencode($share_button_options['url']); ?>" onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;" target="blank" class="balloon-btn-link googleplus-balloon-btn-link" rel="nofollow" title="Google Plus">
          <span class="icon">Google Plus</span>
        </a>
      </span>
    </li>
<?php
	}
?>
  </ul>
</div>

