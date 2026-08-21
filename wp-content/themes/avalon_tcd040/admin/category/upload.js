(function($) {
	$(function() {

		$('#menu_category_image_button').click(function() {
			formfield =$('#upload_image').attr('name');
			tb_show('', 'media-upload.php?type=image&post_id=&TB_iframe=true');
			return false;
		});
		window.send_to_editor = function(html) {
			imgurl = $('img',html).attr('src');
			$('#menu_category_image').val(imgurl);
			tb_remove();
		}

		$('#menu_category_image_mobile_button').click(function() {
			formfield =$('#upload_image').attr('name');
			tb_show('', 'media-upload.php?type=image&post_id=&TB_iframe=true');
			return false;
		});
		window.send_to_editor = function(html) {
			imgurl = $('img',html).attr('src');
			$('#menu_category_image_mobile').val(imgurl);
			tb_remove();
		}

	});
})(jQuery);