
;(function($) {

	$('.sydney-tab-nav a').on('click',function (e) {
		e.preventDefault();
		$(this).addClass('active').siblings().removeClass('active');
	});

	$('.sydney-tab-nav .begin').on('click',function (e) {		
		$('.sydney-tab-wrapper .begin').addClass('show').siblings().removeClass('show');
	});	
	$('.sydney-tab-nav .actions, .sydney-tab .actions').on('click',function (e) {		
		e.preventDefault();
		$('.sydney-tab-wrapper .actions').addClass('show').siblings().removeClass('show');

		$('.sydney-tab-nav a.actions').addClass('active').siblings().removeClass('active');

	});	
	$('.sydney-tab-nav .support').on('click',function (e) {		
		$('.sydney-tab-wrapper .support').addClass('show').siblings().removeClass('show');
	});	
	$('.sydney-tab-nav .table').on('click',function (e) {		
		$('.sydney-tab-wrapper .table').addClass('show').siblings().removeClass('show');
	});	

})(jQuery);
