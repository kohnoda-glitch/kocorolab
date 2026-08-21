<?php
/**
 * Created by PhpStorm.
 * User: chisaka
 * Date: 2016/09/12
 * Time: 21:30
 */
if(is_page()) { ?>
	<?php // 固定ページの場合 ?>
	<?php if( !is_mobile() || is_no_resposive() ) { ?>
		<?php if(is_active_sidebar('static_side_widget')) { ?>
			<div class="col-md-4 entry-sidebar side_widget">
				<?php dynamic_sidebar('static_side_widget'); ?>
			</div>
		<?php }; ?>
	<?php } else { ?>
		<?php if(is_active_sidebar('mobile_widget_static')) { ?>
			<div class="col-md-4 entry-sidebar side_widget">
				<?php dynamic_sidebar('mobile_widget_static'); ?>
			</div>
		<?php }; ?>
	<?php }; ?>
<?php }elseif(is_singular('news')) { ?>
	<?php // Newsページの場合 ?>
	<?php if( !is_mobile() || is_no_resposive() ) { ?>
		<?php if(is_active_sidebar('news_side_widget')) { ?>
			<div class="col-md-4 entry-sidebar side_widget">
				<?php dynamic_sidebar('news_side_widget'); ?>
			</div>
		<?php }; ?>
	<?php } else { ?>
		<?php if(is_active_sidebar('mobile_widget_news')) { ?>
			<div class="col-md-4 entry-sidebar side_widget">
				<?php dynamic_sidebar('mobile_widget_news'); ?>
			</div>
		<?php }; ?>
	<?php }; ?>
<?php } else { ?>
	<?php // それ以外の場合 ?>
	<?php if( !is_mobile() || is_no_resposive() ) { ?>
		<?php if(is_active_sidebar('single_side_widget')) { ?>
			<div class="col-md-4 entry-sidebar side_widget">
				<?php dynamic_sidebar('single_side_widget'); ?>
			</div>
		<?php }; ?>
	<?php } else { ?>
		<?php if(is_active_sidebar('mobile_widget_single')) { ?>
			<div class="col-md-4 entry-sidebar side_widget">
				<?php dynamic_sidebar('mobile_widget_single'); ?>
			</div>
		<?php }; ?>
	<?php }; ?>
<?php }; ?>