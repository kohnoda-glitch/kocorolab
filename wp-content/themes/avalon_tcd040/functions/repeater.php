<?php

/**********************************************************************

リピーター フォームフィールド追加サンプル

// 項目ラベルのサンプル
add_ml_repeater_field(array(
	'name' => __('Label', 'tcd-w'),
	'desc' => __('Enter label for this repeater.', 'tcd-w'),
	'id' => 'repeater_label',
	'type' => 'text',
	'class' => 'index_label',    // クラスにindex_labelを指定することで項目ラベルに反映される
	'std' => __('Label', 'tcd-w'),
	'group' => 'repeater1',       // 複数のリピーターがある場合はここで判別可能
	'placeholder' => __('Enter label for this repeater.', 'tcd-w'),
	'attribute' => array('style' => 'background:rgba(0,255,0,0.1);'),

	// select,radio,checkboxの場合の選択肢
	'options' => array(
		array('name' => __('Type1', 'tcd-w'), 'value' => 'type1'),
		array('name' => __('Type2', 'tcd-w'), 'value' => 'type2'),
		array('name' => __('Type3', 'tcd-w'), 'value' => 'type3')
	)

));

対応type

画像選択: 'image','media'
text; 'text'
リッチエディタ―: 'editor','richeditor','tinymce'
テキストエリア: 'textarea'
セレクト: 'select'
ラジオ: 'radio'
チェックボックス: 'checkbox','checkboxes'
hidden: 'hidden'
その他: 'email','url','numeric','tel'等のhtml5対応のinput type属性


/**********************************************************************/


global $ml_repeater_fields;
$ml_repeater_fields = array('fields' => array());

// リピーター初期化
function ml_repeater_init() {
	do_action('ml_repeater_init', get_ml_repeater_fields(null, false, null));
}
add_action('init', 'ml_repeater_init', 20);

// リピーターへフォームフィールド追加
function add_ml_repeater_field($field = array()) {
	global $ml_repeater_fields;

	if (!is_array($ml_repeater_fields)) {
		$ml_repeater_fields = array('fields' => array());
	}

	// idは必須
	if (empty($field['id'])) {
		return false;
	}

	// 現フィールド数
	$field_count = count($ml_repeater_fields['fields']);

	// デフォルト値
	$default_field = array(
		'name'	=> 'repeater-'.($field_count + 1),	// for label/headline
		'id'	=> 'repeater-'.($field_count + 1),	// for id and name
		'desc'	=> '',
		'type'	=> 'text',
		'class'	=> '',
		'std'	=> '',
		'group'	=> 'group',
		'attribute'		=> '',
		'placeholder'	=> '',
		'before_save_function'	=> null,	// 入力値保存前に入力値に対して実行する関数
		'before_save_filter'	=> null		// 入力値保存前に入力値に対して実行するフィルター
	);

	$ml_repeater_fields['fields'][] = array_merge($default_field, (array) $field);
}

// リピーターからフォームフィールド削除
function remove_ml_repeater_field($arg) {
	global $ml_repeater_fields;

	if (!is_array($ml_repeater_fields)) {
		$ml_repeater_fields = array('fields' => array());
	}

	$ret = false;

	if (!empty($arg) && !empty($ml_repeater_fields['fields'])) {
		if (is_string($arg)) {
			foreach($ml_repeater_fields['fields'] as $field_key => $field) {
				if (!empty($field['id']) && $field['id'] === $arg) {
					unset($ml_repeater_fields[$field_key]);
					$ret = true;
				}
			}
		} elseif (is_array($arg)) {
			$removed = 0;
			foreach($arg as $s_key => $s_value) {
				foreach($ml_repeater_fields['fields'] as $field_key => $field) {
					if (!empty($field[$s_key]) && $field[$s_key] === $s_value) {
						unset($ml_repeater_fields['fields'][$field_key]);
						$removed++;
					}
				}
			}
			if (count($arg) === $removed) {
				$ret = true;
			} elseif ($removed) {
				$ret = $removed;
			}
		}
	}

	if ($ret) {
		// 配列キーを振り直す
		$ml_repeater_fields['fields'] = array_merge($ml_repeater_fields['fields']);
	}

	return $ret;
}

// リピーター 全フォームフィールド取得
// $load_valuesで値取得も可能
// $groupでグループ指定可能。nullの場合全グループのフィールドが返る
function get_ml_repeater_fields($post_id = null, $load_values = true, $group = 'group') {
	global $ml_repeater_fields, $ml_repeater_fields_values, $post;

	if (!is_array($ml_repeater_fields)) {
		$ml_repeater_fields = array('fields' => array());
	}

	if (!is_array($ml_repeater_fields_values)) {
		$ml_repeater_fields_values = array();
	}

	if ($load_values && !$post_id && $post) {
		$post_id = $post->ID;
	}

	if ($group && isset($ml_repeater_fields_values[$group])) {
		return $ml_repeater_fields_values[$group];
	}

	// 全フィールド
	if ($group) {
		// グループで絞り込み
		$ret = get_ml_repeater_fields_group_filter($ml_repeater_fields, $group);
		$ret['row_count'] = (int) get_post_meta($post_id, 'repeater_'.$group.'_row_count', true);
	} else {
		$ret = $ml_repeater_fields;
	}


	// 行数
	if ($group) {
	}

	// 値取得
	if ($load_values && $post_id && !empty($ret['row_count'])) {
		foreach($ret['fields'] as $field_key => $field) {
			for($i = 1; $i <= $ret['row_count']; $i++) {
				// メタキー
				$meta_key = 'repeater_'.$i.'_'.$field['id'];
				$meta_value = get_post_meta($post_id, $meta_key, true);
				$ret['values'][$i][$field['id']] = $meta_value;
			}
		}

		// 次回読み込み軽量化のためにグローバル変数に保存
		$ml_repeater_fields_values[$group] = $ret;

	} else {
		$ret['values'] = null;
	}

	return $ret;
}

// リピーター 全フォームフィールド及び値から引数グループで絞り込みする
function get_ml_repeater_fields_group_filter($fields, $group = 'group') {
	if ($group === null) {
		return $fields;
	} elseif ($group) {
		foreach($fields['fields'] as $field_key => $field) {
			if (empty($field['group']) || $field['group'] != $group) {
				unset($fields['fields'][$field_key]);
			}
		}
	}
	return $fields;
}

// リピーター グループ配列取得
function get_ml_repeater_groups() {
	global $ml_repeater_fields;

	$ret = array();

	if (!empty($ml_repeater_fields['fields'])) {
		foreach($ml_repeater_fields['fields'] as $field_key => $field) {
			if (!empty($field['group']) && !in_array($field['group'], $ret)) {
				$ret[] = $field['group'];
			}
		}
	}

	return $ret;
}

// リピーター 保存行数取得
function get_ml_repeater_row_count($post_id = null, $group = 'group') {
	global $post;
	if ($group) {
		if (!$post_id && $post) {
			$post_id = $post->ID;
		}
		return (int) get_post_meta($post_id, 'repeater_'.$group.'_row_count', true);
	}
	return false;
}

// リピーター 全保存値取得
function get_ml_repeater_values($post_id = null, $group = 'group') {
	$fields = get_ml_repeater_fields($post_id, true, $group);
	if (isset($fields['values'])) {
		return $fields['values'];
	}
	return false;
}

// リピーター 指定保存値取得
function get_ml_repeater_value($row_index, $field_id, $post_id = null) {
	$fields = get_ml_repeater_fields($post_id, true);
	if (isset($fields['values'][$row_index][$field_id])) {
		return $fields['values'][$row_index][$field_id];
	}
	return null;
}

// リピーター 項目ラベル取得
function get_ml_repeater_index_label($row_index, $fields = null, $group = 'group') {
	if (!$fields) {
		$fields = get_ml_repeater_fields(null, true, $group);
	}

	if (!empty($fields['fields'])) {
		foreach($fields['fields'] as $field_key => $field) {
			if (!empty($field['class'])) {
				if (is_string($field['class'])) {
					$field['class'] = explode(' ', $field['class']);
				}
				$field['class'] = array_map('trim', $field['class']);
				if (in_array('index_label', $field['class'])) {
					if (isset($fields['values'][$row_index][$field['id']])) {
						return $fields['values'][$row_index][$field['id']];
					} elseif (!empty($field['std'])) {
						return $field['std'];
					}
					break;
				}
			}
		}
	}

	return null;
}

// リピーター フォームフィールド出力
function render_ml_repeater_inputs($row_index, $field, $field_value = null) {
	if (empty($field['id'])) return false;

	if (empty($field['type'])) {
		$field['type'] = 'text';
	}

	$field_id = 'repeater_'.$row_index.'_'.$field['id'];	// メタキーと同じ
	$field_area_id = 'repeater_'.$row_index.'_'.$field['id'].'_area';
	$field_input_name = 'repeater['.$row_index.']['.$field['id'].']';
	$add_attr = '';

	if (is_null($field_value) && !empty($field['std'])) {
		$field_value = $field['std'];
	}

	if (!empty($field['rows']) && is_numeric($field['rows'])) {
		$rows = $field['rows'];
	} else {
		$rows = 0;
	}

	if (is_array($field['class'])) {
		$field['class'] = implode(' ', $field['class']);
	}

	if (in_array($field['type'], array('textarea', 'text', 'password', 'number', 'email', 'url', 'tel', 'date', 'select'))) {
		if (empty($field['class'])) {
			$field['class'] = 'widefat';
		} elseif (strpos($field['class'], 'widefat') === false) {
			$field['class'] .= ' widefat';
		}
	}

	if (!empty($field['attribute'])) {
		if (is_array($field['attribute'])) {
			$attr = array();
			foreach($field['attribute'] as $key => $value) {
				if (is_int($key)) {
					$add_attr .= ' '.$value;
				} elseif (is_string($value)) {
					$add_attr .= ' '.$key.'="'.esc_attr($value).'"';
				}
			}
		} elseif (is_string($field['attribute'])) {
			$add_attr .= ' '.trim($field['attribute']);
		}
	}

	if (!empty($field['placeholder'])) {
		$add_attr .= ' placeholder="'.esc_attr($field['placeholder']).'"';
	}

	if (isset($field['visible']) == FALSE || $field['visible'] == TRUE) {
		echo '<div class="field field-'.$field['type'].'" id="'.$field_area_id.'">';
	} else {
		echo '<div class="field field-'.$field['type'].'" id="'.$field_area_id.'" style="display:none">';
	}

	if ($field['type'] != 'hidden') {
		echo '<h4 class="headline">'.esc_html($field['name']).'</h4>';
	}

	if (!empty($field['description'])) {
		echo '<p class="desc">'.esc_html($field['description']).'</p>';
	}
	switch ($field['type']) {
		case 'image':
		case 'media':
			echo '<p>';
			// 第1引数にはカスタムフィールドキーを渡す必要がある
			mlcf_media_form($field_id, $field['name']);
			echo '</p>';
			break;

		case 'editor':
		case 'richeditor':
		case 'tinymce':
			if ($rows <= 0) {
				$rows = 20;
			}
			wp_editor($field_value, $field_id, array(
				'textarea_name' => $field_input_name,
				'textarea_rows' => $rows
			));
			break;

		case 'textarea':
			if ($rows <= 0) {
				$rows = 8;
			}
			echo '<textarea id="'.esc_attr($field_id).'" name="'.esc_attr($field_input_name).'" class="'.$field['class'].'" cols="40" rows="'.$rows.'" '.$add_attr.'>'.$field_value.'</textarea>';

			break;

		case 'select':
			if (!empty($field['options']) && is_array($field['options'])) {
				echo '<select id="'.esc_attr($field_id).'" name="'.esc_attr($field_input_name).'" class="'.$field['class'].'"'.$add_attr.'>';
				echo '<option value=""></option>';
				foreach($field['options'] as $field_option) {
					$selected = '';
					if (isset($field_option['name']) && isset($field_option['value'])) {
						if ($field_option['value'] == $field_value) {
							$selected .= ' selected="selected"';
						}
						echo '<option value="'.esc_attr($field_option['value']).'"'.$selected.'>'.esc_html($field_option['name']).'</option>';
					} elseif (isset($field_option['name'])) {
						if ($field_option['name'] == $field_value) {
							$selected = ' selected="selected"';
						}
						echo '<option value="'.esc_attr($field_option['name']).'"'.$selected.'>'.esc_html($field_option['name']).'</option>';
					} elseif (isset($field_option['value'])) {
						if ($field_option['value'] == $field_value) {
							$selected = ' selected="selected"';
						}
						echo '<option value="'.esc_attr($field_option['value']).'"'.$selected.'>'.esc_html($field_option['value']).'</option>';
					} elseif (is_string($field_option)) {
						if ($field_option == $field_value) {
							$selected = ' selected="selected"';
						}
						echo '<option value="'.esc_attr($field_option).'"'.$selected.'>'.esc_html($field_option).'</option>';
					}
				}
				echo '</select>';
			}
			break;

		case 'radio':
			if (!empty($field['options']) && is_array($field['options'])) {
				echo '<ul>';
				foreach($field['options'] as $field_option) {
					$label_class = '';
					$checked = '';
					if (isset($field_option['name']) && isset($field_option['value'])) {
						if ($field_option['value'] == $field_value) {
							$label_class = ' class="active"';
							$checked = ' checked="checked"';
						}
						echo '<li><label'.$label_class.'><input type="radio" id="'.esc_attr($field_id).'_'.esc_attr($field_option['value']).'" name="'.esc_attr($field_input_name).'" class="'.$field['class'].'" value="'.esc_attr($field_option['value']).'"'.$add_attr.$checked.' />'.esc_html($field_option['name']).'</label></li>';
					} elseif (isset($field_option['name'])) {
						if ($field_option['name'] == $field_value) {
							$label_class = ' class="active"';
							$checked = ' checked="checked"';
						}
						echo '<li><label'.$label_class.'><input type="radio" id="'.esc_attr($field_id).'_'.esc_attr($field_option['value']).'" name="'.esc_attr($field_input_name).'" class="'.$field['class'].'" value="'.esc_attr($field_option['name']).'"'.$add_attr.$checked.' />'.esc_html($field_option['name']).'</label></li>';
					} elseif (isset($field_option['value'])) {
						if ($field_option['value'] == $field_value) {
							$label_class = ' class="active"';
							$checked = ' checked="checked"';
						}
						echo '<li><label'.$label_class.'><input type="radio" id="'.esc_attr($field_id).'_'.esc_attr($field_option['value']).'" name="'.esc_attr($field_input_name).'" class="'.$field['class'].'" value="'.esc_attr($field_option['value']).'"'.$add_attr.$checked.' />'.esc_html($field_option['value']).'</label></li>';
					} elseif (is_string($field_option)) {
						if ($field_option == $field_value) {
							$label_class = ' class="active"';
							$checked = ' checked="checked"';
						}
						echo '<li><label'.$label_class.'><input type="radio" id="'.esc_attr($field_id).'_'.esc_attr($field_option['value']).'" name="'.esc_attr($field_input_name).'" class="'.$field['class'].'" value="'.esc_attr($field_option).'"'.$add_attr.$checked.' />'.esc_html($field_option).'</label></li>';
					}
				}
				echo '</ul>';
			}
			break;

		case 'checkbox':
		case 'checkboxes':
			if (!empty($field['options']) && is_array($field['options'])) {
				echo '<ul>';
				foreach($field['options'] as $field_option) {
					$label_class = '';
					$checked = '';
					if (isset($field_option['name']) && isset($field_option['value'])) {
						if ($field_value && in_array($field_option['value'], (array) $field_value)) {
							$label_class = ' class="active"';
							$checked = ' checked="checked"';
						}
						echo '<li><label'.$label_class.'><input type="checkbox" id="'.esc_attr($field_id).'" name="'.esc_attr($field_input_name).'[]" class="'.$field['class'].'" value="'.esc_attr($field_option['value']).'"'.$add_attr.$checked.' />'.esc_html($field_option['name']).'</label></li>';
					} elseif (isset($field_option['name'])) {
						if ($field_value && in_array($field_option['name'], (array) $field_value)) {
							$label_class = ' class="active"';
							$checked = ' checked="checked"';
						}
						echo '<li><label'.$label_class.'><input type="checkbox" id="'.esc_attr($field_id).'" name="'.esc_attr($field_input_name).'[]" class="'.$field['class'].'" value="'.esc_attr($field_option['name']).'"'.$add_attr.$checked.' />'.esc_html($field_option['name']).'</label></li>';
					} elseif (isset($field_option['value'])) {
						if ($field_value && in_array($field_option['value'], (array) $field_value)) {
							$label_class = ' class="active"';
							$checked = ' checked="checked"';
						}
						echo '<li><label'.$label_class.'><input type="checkbox" id="'.esc_attr($field_id).'" name="'.esc_attr($field_input_name).'[]" class="'.$field['class'].'" value="'.esc_attr($field_option['value']).'"'.$add_attr.$checked.' />'.esc_html($field_option['value']).'</label></li>';
					} elseif (is_string($field_option)) {
						if ($field_value && in_array($field_option, (array) $field_value)) {
							$label_class = ' class="active"';
							$checked = ' checked="checked"';
						}
						echo '<li><label'.$label_class.'><input type="checkbox" id="'.esc_attr($field_id).'" name="'.esc_attr($field_input_name).'[]" class="'.$field['class'].'" value="'.esc_attr($field_option).'"'.$add_attr.$checked.' />'.esc_html($field_option).'</label></li>';
					}
				}
				echo '</ul>';
			}
			break;

		case 'hidden':
			echo '<input type="hidden" id="'.esc_attr($field_id).'" name="'.esc_attr($field_input_name).'" class="'.$field['class'].'" value="'.esc_attr($field_value).'"'.$add_attr.' />';
			break;

		default :
			echo '<input type="'.$field['type'].'" id="'.esc_attr($field_id).'" name="'.esc_attr($field_input_name).'" class="'.$field['class'].'" value="'.esc_attr($field_value).'"'.$add_attr.' />';
			break;
	}

	if (!empty($field['desc'])) {
		echo '<p class="desc">'.$field['desc'].'</p>';
	}

	echo '</div>'."\n";
}

// クローン用のリッチエディター化処理をしないようにする
// クローン後のリッチエディター化はrepeater.jsで行う
function ml_repeater_tiny_mce_before_init($mceInit, $editor_id) {
	if (strpos($editor_id, 'repeater_addindex_') === 0) {
		$mceInit['wp_skip_init'] = true;
	}
	return $mceInit;
}
add_filter('tiny_mce_before_init', 'ml_repeater_tiny_mce_before_init', 10, 2);

function show_ml_repeater_meta_box($post = null, $metabox = array(), $shortcode_visible = true) {
	// あれば引数からグループ値
	$default_group = 'group';
	if (!empty($metabox['args']['group'])) {
		$group = $metabox['args']['group'];
	} else {
		$group = $default_group;
	}

	// あれば引数からショートコード
	if (!empty($metabox['args']['shortcode'])) {
		$shortcode = '['.trim($metabox['args']['shortcode'], '[] ').']';
	} elseif ($group == $default_group) {
		$shortcode = '[mono-lab_repeater]';
		$group = $metabox['args'];
	} else {
		$shortcode = '[mono-lab_repeater group='.esc_attr($group).']';
	}

	// フィールド取得
	$fields = get_ml_repeater_fields($post->ID, true, $group);
	if (empty($fields['fields'])) return;

	// js
	wp_enqueue_script('ml-repeaters', get_template_directory_uri().'/admin/js/repeater.js', '', '1', true);

	echo '<input type="hidden" name="repeater_meta_box_nonce" value="', wp_create_nonce(basename(__FILE__)), '" />';
?>

<?php // 本文内にショートコードを入力して、任意の箇所に出力する事ができるようにします ?>
<?php if($shortcode_visible == true) { ?>
	<p class="repeater_short_code"><?php _e('Short code', 'tcd-w'); ?>: <input type="text" readonly="readonly" value="<?php echo $shortcode; ?>" /></p>
	<p class="desc"><?php _e('This short code can only set one to one article.', 'tcd-w');  ?></p>
<?php } ?>
<div class="repeater_wrap" data-rows="<?php
	if (isset($fields['row_count'])) {
		echo $fields['row_count'];
	} else {
		echo 0;
	}
?>">
 <div class="repeater_sortable">

<?php
	if (!empty($fields['row_count'])) {
		// 行ループ
		for($i = 1; $i <= $fields['row_count']; $i++) {
?>
  <div class="repeater repeater-<?php echo esc_attr($group); ?>" id="repeater-<?php echo esc_attr($group).'-'.$i; ?>">
   <ul class="repeater_button cf">
    <li><span class="repeater_move"><?php _e('Move', 'tcd-w'); ?></span></li>
    <li><span class="repeater_delete" data-confirm="'<?php _e('Are you sure you want to delete this item?', 'tcd-w'); ?>"><?php _e('Delete', 'tcd-w'); ?></span></li>
   </ul>

   <div class="repeater_content">
    <h3 class="repeater_headline"><span class="index_label"><?php echo esc_html(get_ml_repeater_index_label($i, $fields)); ?></span><a href="#"><?php _e('Open', 'tcd-w'); ?></a></h3>
    <div class="repeater_field">
<?php
			// 行 順番用
			echo '<input type="hidden" name="repeater_'.esc_attr($group).'_index[]" value="'.$i.'" />'."\n";

			// フォームフィールドループ
			foreach($fields['fields'] as $field_key => $field) {
				// 入力値
				if (isset($fields['values'][$i][$field['id']])) {
					$field_value = $fields['values'][$i][$field['id']];
				} else {
					$field_value = null;
				}

				// フォームフィールド出力
				render_ml_repeater_inputs($i, $field, $field_value);
			}
?>
    </div><!-- END .repeater_field -->
   </div><!-- END .repeater_content -->
  </div><!-- END .repeater -->
<?php
		}
	}
?>

 </div><!-- END .repeater_sortable -->

<?php // 項目の追加ボタン ?>
<a href="#" class="add_repeater button-ml"><?php _e('Add item', 'tcd-w'); ?></a>

<?php // 追加ボタン時に差し込むHTML ?>
<div class="add_repeater_clone hidden hide">
 <div class="repeater" id="repeater-<?php echo esc_attr($group); ?>-addindex">
  <ul class="repeater_button cf">
   <li><span class="repeater_move"><?php _e('Move', 'tcd-w'); ?></span></li>
   <li><span class="repeater_delete" data-confirm="'<?php _e('Are you sure you want to delete this item?', 'tcd-w'); ?>"><?php _e('Delete', 'tcd-w'); ?></span></li>
  </ul>

  <div class="repeater_content">
   <h3 class="repeater_headline"><span class="index_label"><?php _e('New item', 'tcd-w'); ?></span><a href="#"><?php _e('Open', 'tcd-w'); ?></a></h3>
   <div class="repeater_field">
<?php
	// 行 順番用
	echo '<input type="hidden" name="repeater_'.esc_attr($group).'_index[]" value="addindex" />';

	// フォームフィールドループ
	foreach($fields['fields'] as $field_key => $field) {
		// フォームフィールド出力
		render_ml_repeater_inputs('addindex', $field);
	}
?>
   </div><!-- END .repeater_field -->
  </div><!-- END .repeater_content -->
 </div><!-- END .repeater -->
</div><!-- END #add_repeater_clone -->

</div><!-- END .repeater_wrap -->

<?php
}

function save_repeater_meta_box( $post_id ) {

	// verify nonce
	if (!isset($_POST['repeater_meta_box_nonce']) || !wp_verify_nonce($_POST['repeater_meta_box_nonce'], basename(__FILE__))) {
		return $post_id;
	}

	// check autosave
	if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
		return $post_id;
	}

	// check permissions
	if ('page' == $_POST['post_type']) {
		if (!current_user_can('edit_page', $post_id)) {
			return $post_id;
		}
	} elseif (!current_user_can('edit_post', $post_id)) {
		return $post_id;
	}

	$update_metas = array();
	global $ml_repeater_fields;

	// フィールドグループループ
	foreach(get_ml_repeater_groups() as $group) {

		// フォームフィールド取得
		$fields = get_ml_repeater_fields($post_id, false, $group);

		// フィールドなし、もしくは POSTに行なし
		if (empty($fields['fields']) || empty($_POST['repeater_'.$group.'_index'])) {
			return $post_id;
		}

		$current_index = 0;

		// 行ループ
		foreach($_POST['repeater_'.$group.'_index'] as $row_index) {

			// クローン用は除外
			if ($row_index == 'addindex') continue;

			$current_index++;

			// フォームフィールドループ
			foreach($fields['fields'] as $field_key => $field) {
				// メタキー
				$meta_key = 'repeater_'.$current_index.'_'.$field['id'];

				// 入力値
				$meta_value = null;

				// 画像フィールドはメタキー形式でpostされる
				$post_image_key = 'repeater_'.$row_index.'_'.$field['id'];
				if (isset($_POST[$post_image_key])) {
					$meta_value = $_POST[$post_image_key];

				// 画像以外のフィールド
				} elseif (isset($_POST['repeater'][$row_index][$field['id']])) {
					$meta_value = $_POST['repeater'][$row_index][$field['id']];
				}

				// フィールド指定の入力値に対して実行する関数
				if (!empty($field['before_save_function'])) {
					$meta_value = call_user_func_array('increment', $meta_value, $field);
				}

				// フィールド指定の入力値に対して実行するフィルター
				if (!empty($field['before_save_filter'])) {
					$meta_value = apply_filters($field['before_save_filter'], $meta_value, $field);
				}

				// 入力値に対して実行するフィルター
				$meta_value = apply_filters('repeater_before_save-'.$field['id'], $meta_value, $field);

				// メタ更新配列にセット
				if (!empty($meta_value)) {
					$update_metas[$meta_key] = $meta_value;
				}
			}
		}

		// 行数を保存
		update_post_meta($post_id, 'repeater_'.$group.'_row_count', $current_index);
	}

	// メタ更新配列を保存
	if ($update_metas) {
		foreach($update_metas as $meta_key => $meta_value) {
			update_post_meta($post_id, $meta_key, $meta_value);
		}
	}

	// 不要なリピーターメタを削除
	foreach(get_post_meta($post_id) as $meta_key => $meta_value) {
		if (substr($meta_key, 0, 9) === 'repeater_') {
			if (strpos($meta_key, 'row_count') !== false) continue;
			if (!isset($update_metas[$meta_key])) {
				delete_post_meta($post_id, $meta_key);
			}
		}
	}
}
add_action('save_post', 'save_repeater_meta_box');
