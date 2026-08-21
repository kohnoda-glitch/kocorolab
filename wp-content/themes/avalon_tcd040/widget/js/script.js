jQuery(document).ready(function($) {
  if($('body').hasClass('widgets-php')) {

    var current_item;
    var target_id;

    $(document).on('click', '.ml_ad_widget_headline', function(){
      $(this).toggleClass('active');
      $(this).next('.ml_ad_widget_box').toggleClass('open');
    });

  }
});