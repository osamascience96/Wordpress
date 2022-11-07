jQuery( document ).ready(function($) {
	"use strict";

	$('.customize-control-sydney-multiple-select').each(function(){
		$('.customize-control-sydney-multiple-select select').select2({
			allowClear: false
		});
	});

	$(".customize-control-sydney-multiple-select select").on("change", function() {
		var select2Val = $(this).val();
		$(this).parent().find('.customize-control-dropdown-select2').val(select2Val).trigger('change');
	});

});