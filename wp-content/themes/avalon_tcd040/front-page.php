<?php
	get_header();
	$options = get_desing_plus_option();
	$effect_type = 1;
	if($options['hover_type'] == 'type3') {
		$effect_type = 2;
	} else if($options['hover_type'] == 'type1') {
		$effect_type = 3;
	}
	$i = 0;
?>
<div id="edit-area" class="mt0 <?php if ($options['front_scroll_no_animation'] === 1){ ?> scroll_no_animation<?php } ?>">
	<?php if($options['news_visible'] === 1): ?>
		<?php
		$news_posts =
			get_posts(
				array(
					'post_type' => 'news',
					'numberposts' => $options['news_count'],
					'order' => 'DESC',
					'orderby' => 'post_date')
			);
		?>
		<?php if($news_posts && count($news_posts) > 0): ?>
			<div id="index_news">
				<div id="newsticker">
					<div class="row no-gutters">
						<div class="ticker col-md-10" rel="fade">
							<ul>
								<?php foreach($news_posts as $post): setup_postdata($post) ?>
									<li>
										<time class="date" datetime="<?php echo get_the_date("Y-m-d") ?>"><?php echo get_the_date("Y.m.d") ?></time>
										<span class="title"><a href="<?php the_permalink() ?>"><?php the_title() ?></a></span>
									</li>
								<?php endforeach; wp_reset_postdata(); ?>
							</ul>
						</div>
						<div class="archive_link col-md-2">
							<a href="<?php echo get_post_type_archive_link('news'); ?>"><?php esc_html_e($options['news_linktext']) ?></a>
						</div>
					</div>
				</div>
			</div>
		<?php endif; ?>
	<?php endif; ?>
	<div id="fullpage">

		<?php
				$nav_template = '';
				$nav_template_array = array();
				$block_count = 0; // ブログ・フリースペース含めたブロック数
				$contents_count = 0; // ブログ・フリースペースのみのブロック数
				
				 // スクロールコンテンツに設定されているブロック数をカウントする
				if(count($options['index_section_items']) > 0):
					$block_count = count($options['index_section_items']);
				endif;
				 // ブログが表示の場合はカウントする
				if($options['show_index_blog']):
					$block_count ++;
					$contents_count ++;
				endif;
				// フリースペースが表示の場合はカウントする
				if($options['show_index_freespace']):
					$block_count ++;
					$contents_count ++;
				endif;
				
				// ページャーの作成
				for($i=0;$i < $block_count; $i++){
					$nav_template = '';
					for($j=0;$j< $block_count;$j++){
						if($i>$j){
							$dir = 'up';
						}else{
							$dir = 'down';
						}
						if($j == $i+1 || $j == $i-1){
							$show_flag = ' show';
						}else{
							$show_flag = '';
						}
						$nav_template .= '<li data-menuanchor="Page'.$j.'" class="icon-'.$dir.$show_flag.'"><a href="#Page'.$j.'"><span>'.$dir.'</span></a></li>';
					}
					$nav_template_array[] = $nav_template;
				}
				
				// ブロックのHTML作成
				if (count($options['index_section_items']) > 0 || !empty($options['show_index_blog']) || !empty($options['show_index_freespace'])) {
				$i = 0;
				if ($options['front_scroll_no_animation'] === 0){
				$section_item_template = <<< EOM
						<div class="section" id="section%i%" style="background:url(%image%) no-repeat center center; background-size:cover;">
							<div class="container">
								<div class="row">
									<div class="top-container col-md-8%right_flag%">
										<h2 class="headline movein" style="%headline_style%">%headline%</h2>
										<p class="disc movein" style="%desc_style%">%desc%</p>
										<p class="movein"><a href="%btn_url%"%a_attr% class="btn_%btntype%" style="%btn_style%">%btn_label%</a></p>
									</div>
								</div>
							</div>
							<ul class="fp-nav movein sp-none">
								%nav_menu%
							</ul>
						</div>
				EOM;
				}else{
					$section_item_template = <<< EOM
						<div class="section" id="section%i%" style="background:url(%image%) no-repeat center center; background-size:cover;">
						<div class="container-wrap">
							<div class="container">
								<div class="row">
									<div class="top-container col-md-8%right_flag%">
										<h2 class="headline movein" style="%headline_style%">%headline%</h2>
										<p class="disc movein" style="%desc_style%">%desc%</p>
										<p class="movein"><a href="%btn_url%"%a_attr% class="btn_%btntype%" style="%btn_style%">%btn_label%</a></p>
									</div>
								</div>
							</div>
						</div>
						</div>
				EOM;
			}
				
			// スクロールコンテンツに設定されているコンテンツの表示設定
			foreach($options['index_section_items'] as $section_item) {
				$next_i = $i+1;
				if($i>0){ $prev_i = $i-1; }else{ $prev_i = 0; };

				if (empty($section_item['image']) && empty($section_item['headline'])) {
					continue;
				}
				$image = '';
				$headline = '';
				$headline_style ='';
				$desc = '';
				$desc_style = '';
				$btn_label = '';
				$a_attr = '';
				$nav_menu = '';
				$btntype = '';
				$btn_style = '';

				if ($section_item['image']) {
					$_image = wp_get_attachment_image_src($section_item['image'], 'full');
					if (!empty($_image[0])) {
						$image = $_image[0];
					}else{
						continue;
					}
				}

				if ($section_item['headline']&&$section_item['use_headline']) {
					$headline = nl2br( esc_html($section_item['headline']));
				}

				if ($section_item['desc']&&$section_item['use_desc']) {
					$desc = nl2br( esc_html($section_item['desc']));
				}

				if ($section_item['btn_label']&&$section_item['use_btn']) {
					$btn_label = esc_html($section_item['btn_label']);
				}

				if ($section_item['btn_url']) {
					$btn_url = $section_item['btn_url'];
				} else {
					$btn_url = 'javascript:void(0)';
				}

				if ($section_item['btn_url_target']) {
					$a_attr = ' target="_blank"';
				}

				if ($section_item['headline_color']) {
					$headline_style .= 'color:#'.esc_attr($section_item['headline_color']).';';
					$headline_style .= 'font-size:'.esc_attr($section_item['headline_fontsize']).'px;';
					$headline_style .= 'text-shadow:'.esc_attr($section_item['dropshadow_h']).'px '.esc_attr($section_item['dropshadow_v']).'px '.esc_attr($section_item['dropshadow_b']).'px #'.esc_attr($section_item['dropshadow_c']).';';
				}

				if ($section_item['desc_color']) {
					$desc_style .= 'color:#'.esc_attr($section_item['desc_color']).' !important;';
					$desc_style .= 'font-size:'.esc_attr($section_item['desc_fontsize']).'px;';
					$desc_style .= 'text-shadow:'.esc_attr($section_item['dropshadow_desc_h']).'px '.esc_attr($section_item['dropshadow_desc_v']).'px '.esc_attr($section_item['dropshadow_desc_b']).'px #'.esc_attr($section_item['dropshadow_desc_c']).';';
				}

				//if(!is_mobile()){
					if($section_item['use_ghost_btn']){
						$btntype = 'gst';
					}else{
						$btntype = 'def';
					}
				/*}else{
					$btntype = 'def';
				}*/

				if ($section_item['btn_color']&&$section_item['use_btn']) {
					$btn_style .= 'color:#'.esc_attr($section_item['btn_color']).';';
				}else{
					$btn_style .= 'display:none;';
				}

				if($i%2){
					$right_flag = ' fr';
				}else{
					$right_flag = '';
				}

				$nav_menu = $nav_template_array[$i];

				echo str_replace(
					array('%headline%', '%btn_url%', '%a_attr%', '%image%', '%desc%', '%headline_style%', '%desc_style%', '%btn_style%', '%btn_label%', '%show_flag%', '%i%', '%next_i%', '%prev_i%', '%right_flag%', '%nav_menu%', '%btntype%'),
					array($headline, $btn_url, $a_attr, $image, $desc, $headline_style, $desc_style, $btn_style, $btn_label, $show_flag, $i, $next_i, $prev_i, $right_flag, $nav_menu, $btntype),
					$section_item_template
				);

				$i++;
			}
		}
		?>

		<?php if($options['show_index_blog']): ?>
		<div class="section fp-auto-height top-blog-list_wrap" id="section<?php echo $i; $blog_index = $i; $i++; ?>">
			<div class="container top-blog-list movein">
			<?php
				$blogfontsize = $options['front_blog_headline_fontsize'];
				$blogfontcolor = $options['front_blog_headline_color'];
				if(empty($blogfontsize)) {
					$blogfontsize = 42;
				}
				if(empty($blogfontcolor)) {
					$blogfontcolor = 'FFFFFF';
				}
			?>
			<div class="top_blog_header_wrap">
				<h2 id="top_blog_header" class="headline" style="font-size:<?php echo $blogfontsize; ?>px; color:#<?php echo $blogfontcolor; ?>;"><?php echo esc_html($options['front_blog_headline']) ?></h2>
				<p class="blog_archive_link sp-none"><a href="<?php echo get_permalink(get_option('page_for_posts')) ?>"><?php echo esc_html($options['front_blog_linktext']) ?></a></p>
			</div>
			<?php
				query_posts("posts_per_page=".$options['front_blog_count']."&paged=1&order=DESC&orderby=post_date");
				$postcount = 0;
			?>
			<?php if (have_posts()) : ?>
				<?php while(have_posts()) : the_post(); $postcount++; ?>
					<?php if($postcount % 2 == 1) : echo '<div class="row">'; endif; ?>
					<div class="col-sm-6 archive_post">
						<article class="blog-item">
							<a class="hvr_ef<?php echo $effect_type ?>" href="<?php the_permalink() ?>">
								<div class="img-wrap"><?php dp_post_thumbnail_e() ?></div>
							</a>
							<div class="blog-content">
								<h3 class="blog-title"><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h3>
								<p class="blog-meta">
									<?php if($options['archive_show_category'] && $options['archive_show_date']) : ?>
										<span class="blog-category"><?php the_category(", ") ?></span> | <time class="blog-date" datetime="<?php echo get_the_date("Y-m-d") ?>"><?php echo get_the_date("Y.m.d") ?></time>
									<?php elseif($options['archive_show_category']) : ?>
										<span class="blog-category"><?php the_category(", ") ?></span>
									<?php elseif($options['archive_show_date']) : ?>
										<time class="blog-date" datetime="<?php echo get_the_date("Y-m-d") ?>"><?php echo get_the_date("Y.m.d") ?></time>
									<?php endif; ?>
								</p>
							</div>
						</article>
					</div>
					<?php if($postcount % 2 == 0) : echo '</div>'; endif; ?>
				<?php endwhile; ?>
				<?php wp_reset_query(); ?>
				<?php if($postcount % 2 == 1) : echo '</div>'; endif; ?>
			<?php else: ?>
				<div class="row"><?php _e('There is no registered post.','tcd-w'); ?></div>
			<?php endif; ?>
			<p class="blog_archive_link pc-none"><a href="<?php echo get_permalink(get_option('page_for_posts')) ?>"><?php echo esc_html($options['front_blog_linktext']) ?></a></p>
		</div><!-- / blog contents -->
		<?php if ($options['front_scroll_no_animation'] === 0){ ?>
		<ul class="fp-nav movein sp-none mt80 fp-nav-last">
			<?php echo $nav_template_array[$blog_index]; ?>
		</ul>
		<?php } ?>
		</div>
		<?php endif; ?>
		<?php if($options['show_index_freespace']): // フリースペースの内容を表示 ?>
		<div class="section fp-auto-height top-freespace_wrap" id="section<?php echo $i; $freespace_index = $i; ?>">
			<div class="container top-freespace movein">
			<?php
				$blogfontsize = $options['front_freespace_headline_fontsize'];
				$blogfontcolor = $options['front_freespace_headline_color'];
				if(empty($blogfontsize)) {
					$blogfontsize = 42;
				}
				if(empty($blogfontcolor)) {
					$blogfontcolor = 'FFFFFF';
				}
			?>
			<?php if(isset($options['front_freespace_headline'])){ ?>
				<h2 id="top_freespace_header" class="headline" style="font-size:<?php echo $blogfontsize; ?>px; color:#<?php echo $blogfontcolor; ?>;"><?php echo esc_html($options['front_freespace_headline']) ?></h2>
				<?php } ?>
				<?php if(isset($options['front_freespace_editor'])){ ?>
				<div class="post_content front_post_content">
					<div class="front_entry-content entry-content">
						<?php echo wpautop(do_shortcode($options['front_freespace_editor'])) ?>
					</div>
				<?php } ?>
				</div>
			</div><!-- / freespace contents -->
			<?php if ($options['front_scroll_no_animation'] === 0){ ?>
			<ul class="fp-nav movein sp-none mt80 fp-nav-last">
				<?php echo $nav_template_array[$freespace_index];?>
			</ul>
			<?php } ?>
		</div>
		<?php endif; ?>
	</div><!-- / #fullpage -->
</div><!-- / #edit-area -->
<script>
	$(function() {
		$('.movein').on('inview', function(event, isInView, visiblePartX, visiblePartY) {
			if(isInView){
				$(this).stop().addClass('movein_ef');
			}
			else{
				$(this).stop().removeClass('movein_ef');
			}
		});
	});
</script>
<?php get_footer(); ?>
