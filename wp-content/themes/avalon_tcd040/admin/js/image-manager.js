jQuery(document).ready(function($){
		var dpResizeValueDisplay = function(){
			var percent = parseInt($('#dp_resize_ratio').val(), 10);
			if(isNaN(percent)){
				percent = 100;
			}
			var originalToDisplayRatio = percent / 100 / parseFloat($('input[name=dp_logo_to_resize_ratio]').val());
			$('#dp_resized_height').val(Math.round(parseInt($('input[name=dp_logo_resize_height]').val(), 10) * originalToDisplayRatio));
			$('#dp_resized_width').val(Math.round(parseInt($('input[name=dp_logo_resize_width]').val(), 10) * originalToDisplayRatio));
		};
		$('#dp_logo_to_resize').imgAreaSelect({
			handles: true,
			onSelectChange: function(img, selection){
				$('input[name=dp_logo_resize_height]').val(selection.height);
				$('input[name=dp_logo_resize_width]').val(selection.width);
				$('input[name=dp_logo_resize_left]').val(selection.x1);
				$('input[name=dp_logo_resize_top]').val(selection.y1);
				dpResizeValueDisplay();
			}
		});
		$('#dp_resize_ratio').blur(function(e){
			var percent = parseInt($(this).val(), 10);
			if(isNaN(percent) || percent > 100){
				$(this).val(100);
			}
			dpResizeValueDisplay();
		});
		$('#dp-resize-canceler').click(function(e){
			e.preventDefault();
			$('input[name=dp_logo_resize_left]').val('');
			$('input[name=dp_logo_resize_top]').val('');
			$('#dp_resized_height').val('');
			$('#dp_resized_width').val('');
		});
});