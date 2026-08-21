jQuery(document).ready(function($){

  // theme option tab
  $('#my_theme_option').cookieTab({
   tabMenuElm: '#theme_tab',
   tabPanelElm: '#tab-panel'
  });

  // アコーディオンの開閉
  // $('.sub_box').on('click', '.theme_option_subbox_headline', function(){
  //  $(this).parents('.sub_box').toggleClass('active');
  //  return false;
  // });

  // アコーディオンの開閉
  $(".sub_box").on("click", '.theme_option_subbox_headline', function(){
   $(this).parents('.sub_box').toggleClass('active');
   return false;
  });

  $('.topt_repeater').on('click', '.sub_box .theme_option_subbox_headline', function(){
   $(this).parents('.topt_repeater .sub_box').toggleClass('active');
   return false;
  });

  // Googleマップ
  $('#gmap_marker_type_button_type2').click(function () {
    $('#gmap_marker_type2_area').show();
  });
  $('#gmap_marker_type_button_type1').click(function () {
    $('#gmap_marker_type2_area').hide();
  });
  $('#gmap_custom_marker_type_button_type1').click(function () {
    $('#gmap_custom_marker_type1_area').show();
    $('#gmap_custom_marker_type2_area').hide();
  });
  $('#gmap_custom_marker_type_button_type2').click(function () {
    $('#gmap_custom_marker_type1_area').hide();
    $('#gmap_custom_marker_type2_area').show();
  });

  // overlay
  // $(".use_overlay input:checkbox").click(function(event) {
  //  if ($(this).is(":checked")) {
  //   $(this).parents('.use_overlay').next().show();
  //  } else {
  //   $(this).parents('.use_overlay').next().hide();
  //  }
  // });
  $('.topt_repeater').on('click', '.sub_box .sub_box_content .use_overlay input:checkbox', function(event){
   if ($(this).is(":checked")) {
    $(this).parents('.use_overlay').next().show();
   } else {
    $(this).parents('.use_overlay').next().hide();
   }
  });


  // headline
  // $(".use_headline input:checkbox").click(function(event) {
  //  if ($(this).is(":checked")) {
  //   $(this).parents('.use_headline').next().show();
  //  } else {
  //   $(this).parents('.use_headline').next().hide();
  //  }
  // });
  $('.topt_repeater').on('click', '.sub_box .sub_box_content .use_headline input:checkbox', function(event){
   if ($(this).is(":checked")) {
    $(this).parents('.use_headline').next().show();
   } else {
    $(this).parents('.use_headline').next().hide();
   }
  });

  // desc
  // $(".use_desc input:checkbox").click(function(event) {
  //  if ($(this).is(":checked")) {
  //   $(this).parents('.use_desc').next().show();
  //  } else {
  //   $(this).parents('.use_desc').next().hide();
  //  }
  // });
  $('.topt_repeater').on('click', '.sub_box .sub_box_content .use_desc input:checkbox', function(event){
   if ($(this).is(":checked")) {
    $(this).parents('.use_desc').next().show();
   } else {
    $(this).parents('.use_desc').next().hide();
   }
  });

  // btn
  // $(".use_btn input:checkbox").click(function(event) {
  //  if ($(this).is(":checked")) {
  //   $(this).parents('.use_btn').next().show();
  //  } else {
  //   $(this).parents('.use_btn').next().hide();
  //  }
  // });
  $('.topt_repeater').on('click', '.sub_box .sub_box_content .use_btn input:checkbox', function(event){
   if ($(this).is(":checked")) {
    $(this).parents('.use_btn').next().show();
   } else {
    $(this).parents('.use_btn').next().hide();
   }
  });

  // rebox
  $("#ml_custom_fields_box1").rebox({
   selector:'a',
   zIndex: 99999,
   loading: '&loz;'
  });

	// radio button for page custom fields

   $(".ml_custom_fields_select .template li label").click(function () {
     $(".ml_custom_fields_select .template li label").removeClass('active');
     $(this).addClass('active');
   });

   $("#template_type1").click(function () {
    $("#postdivrich").show();
    $("#ml_custom_fields_box3").hide();
    $("#ml_custom_fields_box4").hide();
    $("#ml_custom_fields_box5").hide();
    $("#ml_custom_fields_box6").hide();
    $("#shopnavi_check").show();
   });

   $("#template_type2").click(function () {
    $("#postdivrich").show();
    $("#ml_custom_fields_box3").hide();
    $("#ml_custom_fields_box4").hide();
    $("#ml_custom_fields_box5").hide();
    $("#ml_custom_fields_box6").hide();
    $("#shopnavi_check").hide();
   });

   $("#template_type3").click(function () {
    $("#postdivrich").hide();
    $("#ml_custom_fields_box3").show();
    $("#ml_custom_fields_box4").hide();
    $("#ml_custom_fields_box5").hide();
    $("#ml_custom_fields_box6").hide();
    $("#shopnavi_check").show();
   });

   $("#template_type4").click(function () {
    $("#postdivrich").hide();
    $("#ml_custom_fields_box3").hide();
    $("#ml_custom_fields_box4").show();
    $("#ml_custom_fields_box5").hide();
    $("#ml_custom_fields_box6").hide();
    $("#shopnavi_check").show();
   });

  $("#template_type5").click(function () {
   $("#postdivrich").hide();
   $("#ml_custom_fields_box3").hide();
   $("#ml_custom_fields_box4").hide();
   $("#ml_custom_fields_box5").show();
   $("#ml_custom_fields_box6").hide();
   $("#shopnavi_check").show();
  });

  $("#template_type6").click(function () {
   $("#postdivrich").hide();
   $("#ml_custom_fields_box3").hide();
   $("#ml_custom_fields_box4").hide();
   $("#ml_custom_fields_box5").hide();
   $("#ml_custom_fields_box6").show();
   $("#shopnavi_check").show();
  });

  // theme option repeater sortable
  $('.topt_repeater').sortable({
    placeholder: 'sortable-placeholder',
    helper: "clone",
    forceHelperSize: true,
    forcePlaceholderSize: true
});

  // theme option repeater add row
  var next_index = 10000;
  $(".topt_repeater_wrapper a.button-add-row").click(function(){
    var clone = $(this).attr("data-clone");
    var $parent = $(this).closest(".topt_repeater_wrapper");
    if (clone && $parent.size()) {
      next_index++;
      clone = clone.replace(/addindex/g, next_index);
      $parent.find(".topt_repeater").append(clone.replace(/addindex/g, next_index));
      $parent.find("#topt_repeater-"+next_index+" .color:input").each(function(){
        try {
          this.color = new jscolor.color(this);
        } catch(e) {
          console.log(e)
        }
      });
    }
    return false;
  });

  // theme option repeater delete row
  $(".topt_repeater").on("click", ".button-delete-row", function(){
    var del = true;
    var confirm_message = $(this).closest(".topt_repeater").attr("data-delete-confirm");
    if (confirm_message) {
      del = confirm(confirm_message);
    }
    if (del) {
      $(this).closest(".topt_repeater-row").remove();
    }
    return false;
  });

 /**
	* スマホ用固定フッターバー
	*/
 // アコーディオンの開閉
 $(".repeater").on("click", ".theme_option_subbox_headline", function() {
  $(this).parents(".sub_box").toggleClass("active");
  return false;
 });
 // ボタンの並び替え
 $(".sortable").sortable({
  placeholder: "sortable-placeholder",
  helper: "clone",
  forceHelperSize: true,
  forcePlaceholderSize: true

 });
 // 新しいアイテムを追加する
 $(".repeater-wrapper").each(function() {
  var next_index = $(this).find(".repeater-item").last().index();
  $(this).find(".button-add-row").click(function() {
   var clone = $(this).attr("data-clone");
   var $parent = $(this).closest(".repeater-wrapper");
   if (clone && $parent.size()) { 
    next_index++;
    clone = clone.replace(/addindex/g, next_index);
    $parent.find(".repeater").append(clone.replace(/addindex/g, next_index));
   }
   return false;
  });
 });
 // アイテムを削除する
 $(".repeater").on("click", ".button-delete-row", function() {
  var del = true;
  var confirm_message = $(this).closest(".repeater").attr("data-delete-confirm");
  if (confirm_message) {
   del = confirm(confirm_message);
  }
  if (del) {
   $(this).closest(".repeater-item").remove();
  }
  return false;
 });
 // ボタンのタイプによって、表示フィールドを切り替える
 $(".repeater").each(function() {
  $(this).on("change", ".footer-bar-type select", function() {
   var sub_box = $(this).parents(".sub_box");
   var target = sub_box.find(".footer-bar-target");
   var url = sub_box.find(".footer-bar-url");
   var number = sub_box.find(".footer-bar-number");
   switch ($(this).val()) {
    case "type1" :
     target.show();
     url.show();
     number.hide();
     break;
    case "type2" :
     target.hide();
     url.hide();
     number.hide();
     break;
    case "type3" :
     target.hide();
     url.hide();
     number.show();
     break;
   }
  });
 });
 // リピーター ボタン名
 $(document).on('change keyup', '.repeater .repeater-label', function(){
  $(this).closest('.repeater-item').find('.theme_option_subbox_headline').text($(this).val());
 }); 
});