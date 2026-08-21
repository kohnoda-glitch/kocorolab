<?php
/**
 * Created by PhpStorm.
 * User: chisaka
 * Date: 2016/09/02
 * Time: 19:31
 */

// レイアウト選択
add_ml_repeater_field(array(
	'name' => __('Layout selection', 'tcd-w'),
	'id' => 'staff_layout',
	'description' => __('1 column is displayed center, 2 columns is displayed 2 items with Side-by-side.', 'tcd-w'),
	'type' => 'radio',
	'options' => array(array('name' => __('1 column', 'tcd-w'), 'value' => 1), array('name' => __('2 columns', 'tcd-w'), 'value' => 2)),
	'attribute' => array('onclick' => 'onStaffLayoutClicked(this.id);'),
	'group' => 'staff',
));
// 一人目
add_ml_repeater_field(array(
	'name' => __('Image', 'tcd-w'),
	'id' => 'staff_image1',
	'description' => __('Recommend image size. Width:280px, Height:280px', 'tcd-w'),
	'type' => 'image',
	'group' => 'staff',
));

add_ml_repeater_field(array(
	'name' => __('Headline', 'tcd-w'),
	'id' => 'staff_headline1',
	'type' => 'text',
	'class' => 'index_label',    // クラスにindex_labelを指定することで項目ラベルに反映される
	'group' => 'staff',
));

add_ml_repeater_field(array(
	'name' => __('Headline(sub)', 'tcd-w'),
	'id' => 'staff_headline_sub1',
	'type' => 'text',
	'group' => 'staff',
));

add_ml_repeater_field(array(
	'name' => __('Letter body', 'tcd-w'),
	'id' => 'staff_body1',
	'type' => 'tinymce',
	'group' => 'staff',
));
// 二人目(初期状態は非表示)
add_ml_repeater_field(array(
	'name' => __('Image', 'tcd-w').'2',
	'id' => 'staff_image2',
	'description' => __('Recommend image size. Width:280px, Height:280px', 'tcd-w'),
	'type' => 'image',
	'visible' => FALSE,
	'group' => 'staff',
));

add_ml_repeater_field(array(
	'name' => __('Headline', 'tcd-w').'2',
	'id' => 'staff_headline2',
	'type' => 'text',
	'visible' => FALSE,
	'class' => 'index_label',    // クラスにindex_labelを指定することで項目ラベルに反映される
	'group' => 'staff',
));

add_ml_repeater_field(array(
	'name' => __('Headline(sub)', 'tcd-w').'2',
	'id' => 'staff_headline_sub2',
	'type' => 'text',
	'visible' => FALSE,
	'group' => 'staff',
));

add_ml_repeater_field(array(
	'name' => __('Letter body', 'tcd-w').'2',
	'id' => 'staff_body2',
	'type' => 'tinymce',
	'visible' => FALSE,
	'group' => 'staff',
));


// staffショートコード
function ml_repeater_staff_shortcode($atts = array()) {
	global $post;

	// リピーター保存値配列取得
	$values = get_ml_repeater_values($post->ID, 'staff');

	/**********************************************************************
	get_ml_repeater_values()返り値フォーマット
	$values[行番号][field_id] = 入力値

	行番号は1から始まります。
	field_idはadd_ml_repeater_field()で指定したid
	入力値は基本文字列ですが、チェックボックスの場合は配列になります。
	 **********************************************************************/

	if ($values) :
		ob_start();
		?>
		<?php foreach($values as $key => $value) : ?>
			<div class="row align1">
				<?php $num = intval($value['staff_layout']); ?>
				<?php for($i = 1; $i <= $num; $i++) : ?>
					<div class="col-md-6<?php if($num == 1) : echo ' align1 col-md-offset-3'; endif; ?>">
						<?php
						$image = null;
						if (!empty($value['staff_image'.strval($i)])) {
							$image = wp_get_attachment_image_src($value['staff_image'.strval($i)], 'full');
						}
						?>
						<?php if($image != null && empty($image[0]) == FALSE) : ?>
							<div class="staff_archive_thumbnail">
								<img width="280px" height="auto" src="<?php echo $image[0]; ?>" alt="<?php esc_attr_e($value['staff_headline'.strval($i)]) ?>" />
							</div>
						<?php endif; ?>
						<div class="staff_archive_contents">
							<p class="staff_archive_post"><?php esc_html_e($value['staff_headline'.strval($i)]) ?></p>
							<h3 class="staff_archive_name"><?php esc_html_e($value['staff_headline_sub'.strval($i)]) ?></h3>
							<div class="staff_archive_text"><?php echo $value['staff_body'.strval($i)] ?></div>
						</div>
					</div>
				<?php endfor; ?>
			</div>
		<?php endforeach; ?>
		<?php
		return ob_get_clean();
	endif;

	return '';
}
add_shortcode('tcd-w_staff', 'ml_repeater_staff_shortcode');
