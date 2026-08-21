jQuery(document).ready(function($){

  if ($('#pb_contents').size() == 0) return;

  // アコーディオンの開閉
  $('#pb_contents').on('click', '.pb_header .open', function(){
    $(this).parents('.pb_wrap').toggleClass('active');
    return false;
  });

  // pb_layout_box_innerの開閉
  $('#pb_contents').on('click', '.pb_layout_box_inner .pb_layout_box_headline', function(){
    $(this).parents('.pb_layout_box_inner').toggleClass('open');
    return false;
  });

  // レイアウトのボックスをレスポンシブにする
  function mediaQueryClass(width) {
    if (width < 700) {
      $('#page_builder_meta_box').addClass('small');
    } else {
      $('#page_builder_meta_box').removeClass('small');
    }
  }

  var ww = $('#page_builder_meta_box').width();
  var timer = false;

  mediaQueryClass(ww);

  $(window).bind("resize orientationchange", function() {
    if (timer !== false) {
      clearTimeout(timer);
    }
    timer = setTimeout(function() {
      var ww = $('#page_builder_meta_box').width();
      mediaQueryClass(ww);
    }, 200);
  })

  // Google Mapの選択
  $('#pb_contents').on('change', '.pb_input_area-map_type :radio', function(){
    var $cl = $(this).closest('.pb_content');
    if (this.value == 'type2') {
      $cl.find('.pb_input_area-map_code1').hide();
      $cl.find('.pb_input_area-map_code2').show();
    } else {
      $cl.find('.pb_input_area-map_code2').hide();
      $cl.find('.pb_input_area-map_code1').show();
    }
  });
  $('.pb_input_area-map_type :radio:checked').each(function(){
    $(this).trigger('change');
  });

  // コンテンツ追加
  $('#pb_button_list a[data-layout]').click(function(){
    var layout = $(this).attr('data-layout');
    if (!layout) return false;

    var $contents = $('#pb_contents');
    var $wrap = $(this).closest('.postbox');
    var html = $wrap.find('.add_page_builder_clone .pb_layout-'+layout).prop('outerHTML');
    var next_index = parseInt($contents.attr('data-max-index')) || 0;

    next_index++;
    $contents.attr('data-max-index', next_index);
    $contents.append(html.replace(/pb_add_index/g, next_index));

    // リピーターの場合ソータブル
    if (html.indexOf('pb_repeater_sortable') > -1) {
      $contents.find('.pb_index-'+next_index+' .pb_repeater_sortable').sortable({       handle: '.pb_repeater_move'
      });
    }

    // リッチエディターがある場合
    if (html.indexOf('wp-editor-area') > -1) {
      var $row = $contents.find('.pb_index-'+next_index);

      // クローン元のリッチエディターをループ
      $wrap.find('.add_page_builder_clone .pb_layout-'+layout+' .wp-editor-area').each(function(){
        // id
        var id_clone = $(this).attr('id');
        var id_new = id_clone.replace(/pb_add_index/g, next_index);

        // リピーターの場合は除外
        if (id_clone.indexOf('pb_repeater_add_index') > -1) return;

        // クローン元のmceInitをコピー置換
        if (typeof tinyMCEPreInit.mceInit[id_clone] != 'undefined') {
          // オブジェクトを=で代入すると参照渡しになるため$.extendを利用
          var mce_init_new = $.extend(true, {}, tinyMCEPreInit.mceInit[id_clone]);
          mce_init_new.body_class = mce_init_new.body_class.replace(/pb_add_index/g, next_index);
          mce_init_new.selector = mce_init_new.selector.replace(/pb_add_index/g, next_index);
          tinyMCEPreInit.mceInit[id_new] = mce_init_new;

          // リッチエディター化
          tinymce.init(mce_init_new);
        }

        // クローン元のqtInitをコピー置換
        if (typeof tinyMCEPreInit.qtInit[id_clone] != 'undefined') {
          // オブジェクトを=で代入すると参照渡しになるため$.extendを利用
          var qt_init_new = $.extend(true, {}, tinyMCEPreInit.qtInit[id_clone]);
          qt_init_new.id = qt_init_new.id.replace(/pb_add_index/g, next_index);
          tinyMCEPreInit.qtInit[id_new] = qt_init_new;

          // リッチエディター化
          quicktags(tinyMCEPreInit.qtInit[id_new]);
        }

        // ビジュアル/テキストをビジュアル状態に
        $row.find('.wp-editor-wrap').removeClass('html-active').addClass('tmce-active');
      });
    }

    $(this).blur();
    return false;
  });

  // コンテンツ削除
  $('#pb_contents').on('click', '.delete_button', function(){
    var del = true;
    if ($(this).attr('data-confirm')) {
      del = confirm($(this).attr('data-confirm'));
    }
    if (del) {
      $(this).closest('.pb_wrap').slideUp('fast', function(){
        $(this).remove();
      });
    }
    return false;
  });

  // リピーター ソータブル
  $('.pb_repeater_wrap .pb_repeater_sortable').sortable({
    handle: '.pb_repeater_move'
  });

  // リピーター アコーディオンの開閉
  $('#pb_contents').on('click', '.pb_repeater_headline', function(){
    $(this).parents('.pb_repeater').toggleClass('open');
    return false;
  });
  $('#pb_contents').on('click', '.pb_repeater_headline a', function(){
    $(this).parents('.pb_repeater').toggleClass('open');
    return false;
  });

  // リピーター タブ名
  $('#pb_contents').on('change keyup', '.pb_repeater .index_label:input', function(){
    $(this).closest('.pb_repeater').find('span.index_label').text($(this).val());
  });

  // リピーター 追加ボタン
  $('#pb_contents').on('click', '.pb_add_repeater', function(){
    var $wrap = $(this).closest('.pb_repeater_wrap');
    var html = $wrap.find('.add_pb_repeater_clone').html();
    var next_index = parseInt($wrap.attr('data-rows')) || 0;

    next_index++;
    $wrap.find('.pb_repeater_sortable').append(html.replace(/pb_repeater_add_index/g, next_index));
    $wrap.attr('data-rows', next_index);

    // リッチエディターがある場合
    if (html.indexOf('wp-editor-area') > -1) {
      var $meta_wrap = $(this).closest('.postbox');
      var $row = $wrap.find('.pb_repeater-'+next_index);
      var pb_index = $(this).closest('.pb_wrap').attr('data-index');
      var layout = $(this).closest('.pb_wrap').attr('data-layout');

      // クローン元のリッチエディターをループ（リピーターではなくページビルダーのクローン元）
      $meta_wrap.find('.add_page_builder_clone .pb_layout-'+layout+' .add_pb_repeater_clone .wp-editor-area').each(function(){
        // id
        var id_clone = $(this).attr('id');
        var id_new = id_clone.replace(/pb_add_index/g, pb_index).replace(/pb_repeater_add_index/g, next_index);

        // クローン元のmceInitをコピー置換
        if (typeof tinyMCEPreInit.mceInit[id_clone] != 'undefined') {
          // オブジェクトを=で代入すると参照渡しになるため$.extendを利用
          var mce_init_new = $.extend(true, {}, tinyMCEPreInit.mceInit[id_clone]);
          mce_init_new.body_class = mce_init_new.body_class.replace(/pb_add_index/g, pb_index).replace(/pb_repeater_add_index/g, next_index);
          mce_init_new.selector = mce_init_new.selector.replace(/pb_add_index/g, pb_index).replace(/pb_repeater_add_index/g, next_index);
          tinyMCEPreInit.mceInit[id_new] = mce_init_new;

          // リッチエディター化
          tinymce.init(mce_init_new);
        }

        // クローン元のqtInitをコピー置換
        if (typeof tinyMCEPreInit.qtInit[id_clone] != 'undefined') {
          // オブジェクトを=で代入すると参照渡しになるため$.extendを利用
          var qt_init_new = $.extend(true, {}, tinyMCEPreInit.qtInit[id_clone]);
          qt_init_new.id = qt_init_new.id.replace(/pb_add_index/g, pb_index).replace(/pb_repeater_add_index/g, next_index);
          tinyMCEPreInit.qtInit[id_new] = qt_init_new;

          // リッチエディター化
          quicktags(tinyMCEPreInit.qtInit[id_new]);
        }

        // ビジュアル/テキストをビジュアル状態に
        $row.find('.wp-editor-wrap').removeClass('html-active').addClass('tmce-active');
      });
    }

    $(this).blur();
    return false;
  });

  // リピーター 削除ボタン
  $('#pb_contents').on('click', '.pb_repeater_delete', function(){
    var del = true;
    if ($(this).attr('data-confirm')) {
      del = confirm($(this).attr('data-confirm'));
    }
    if (del) {
      $(this).closest('.pb_repeater').fadeOut('fast', function(){
        $(this).remove();
      });
    }
    return false;
  });

  // ショートコードフォーカス
  $('#pb_contents').on('focus', 'div.short_code input:text', function(){
    this.select();
  });

});