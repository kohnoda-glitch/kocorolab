<?php
/**
 * Created by PhpStorm.
 * User: chisaka
 * Date: 2016/09/02
 * Time: 19:31
 */

// レイアウト選択
add_ml_repeater_field(array(
	'name' => __('Headline', 'tcd-w'),
	'id' => 'menu_headline',
	'type' => 'text',
	'class' => 'index_label',    // クラスにindex_labelを指定することで項目ラベルに反映される
	'group' => 'menu',
));

add_ml_repeater_field(array(
	'name' => __('Image', 'tcd-w'),
	'id' => 'menu_image',
	'description' => str_replace('<br />', '', __('Register image.<br />Image size. Width:450px Height:330px', 'tcd-w')),
	'type' => 'image',
	'group' => 'menu'
));

add_ml_repeater_field(array(
	'name' => __('Letter body', 'tcd-w'),
	'id' => 'menu_body',
	'description' => __('Please input product name and price like \'Product|Price\'.', 'tcd-w'),
	'type' => 'textarea',
	'group' => 'menu',
));

// menuショートコード
function ml_repeater_menu_shortcode($atts = array()) {
	global $post;

	// リピーター保存値配列取得
	$values = get_ml_repeater_values($post->ID, 'menu');

	/**********************************************************************
	get_ml_repeater_values()返り値フォーマット
	$values[行番号][field_id] = 入力値

	行番号は1から始まります。
	field_idはadd_ml_repeater_field()で指定したid
	入力値は基本文字列ですが、チェックボックスの場合は配列になります。
	 **********************************************************************/

	if ($values) :
		ob_start();
		$count = 0;
		?>
		<?php foreach($values as $key => $value) : $count++; ?>
			<?php if($count % 2 == 1) : echo '<div class="row">'; endif; ?>
				<div class="menu_article col-md-6">
					<?php
					$image = null;
					if (!empty($value['menu_image'])) {
						$image = wp_get_attachment_image_src($value['menu_image'], 'full');
					}
					?>
					<?php if($image != null && empty($image[0]) == FALSE) : ?>
						<div class="menu_thumbnail">
							<img width="450px" height="auto" src="<?php echo $image[0]; ?>" alt="<?php esc_attr_e($value['menu_headline']) ?>" />
						</div>
					<?php endif; ?>
					<div class="menu_contents">
						<h3 class="menu_category"><?php esc_html_e($value['menu_headline']) ?></h3>
						<ul class="menu_names">
							<?php
								$menu_body = $value['menu_body'];
								$array = explode("\n", $menu_body);
								$array = array_map('trim', $array);
								$array = array_filter($array, 'strlen');
								$array = array_values($array);
							?>
							<?php foreach($array as $menu) : $items = explode('|', $menu); ?>
								<?php if(count($items) == 1) : ?>
									<li><?php esc_html_e($items[0]) ?></li>
								<?php else: ?>
									<li><?php esc_html_e($items[0]) ?><span class="menu_price"><?php for($i = 1; $i < count($items); $i++) esc_html_e($items[$i]); ?></span></li>
								<?php endif; ?>
							<?php endforeach; ?>
						</ul>
					</div>
				</div>
			<?php if($count % 2 == 0) : echo '</div>'; endif; ?>
		<?php endforeach; ?>
		<?php if($count % 2 == 1) : echo '</div>'; endif; ?>
		<?php
		return ob_get_clean();
	endif;

	return '';
}
add_shortcode('tcd-w_menu', 'ml_repeater_menu_shortcode');
