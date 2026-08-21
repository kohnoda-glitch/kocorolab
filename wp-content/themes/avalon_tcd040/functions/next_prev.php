<?php

function next_prev_post_link() {
	$prev_post = get_adjacent_post(false, '', true);
	$next_post = get_adjacent_post(false, '', false);
	$url = get_bloginfo('template_url');
	if ($prev_post) {
		if(is_mobile()){
			$prev_title = __('Prev', 'tcd-w');
		}else{
			$prev_title = esc_attr(get_the_title($prev_post->ID));
		}
		$prev_url = get_permalink($prev_post->ID);
		echo "<a class='prev_post' href='$prev_url' title='$prev_title'><p class='clearfix'><span class='title'>$prev_title</span></p></a>";
	}
    if ($next_post) {
		if(is_mobile()){
			$next_title = __('Next', 'tcd-w');
		}else{
			$next_title = esc_attr(get_the_title($next_post->ID));
		}
		$next_url = get_permalink($next_post->ID);
		echo "<a class='next_post' href='$next_url' title='$next_title'><p class='clearfix'><span class='title'>$next_title</span></p></a>";
	}
}
?>