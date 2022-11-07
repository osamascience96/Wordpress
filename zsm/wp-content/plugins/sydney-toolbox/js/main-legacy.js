

(function ($) {

    var aThemesTestimonialsCarouselrun = function ($scope, $) {

		if ( $().owlCarousel ) {
			$('.roll-testimonials').not('.owl-carousel').owlCarousel({
				navigation : false,
				pagination: true,
				responsive: true,
				items: 1,
				itemsDesktop: [3000,1],
				itemsDesktopSmall: [1400,1],
				itemsTablet:[970,1],
				itemsTabletSmall: [600,1],
				itemsMobile: [360,1],
				touchDrag: true,
				mouseDrag: true,
				autoHeight: true,
				autoPlay: $('.roll-testimonials').data('autoplay')
			});
		} 

    };    

    var aThemesNewsCarouselrun = function ($scope, $) {

		if ( $().owlCarousel ) {
			$(".panel-grid-cell .latest-news-wrapper").owlCarousel({
				navigation : false,
				pagination: true,
				responsive: true,
				items: 3,
				itemsDesktopSmall: [1400,3],
				itemsTablet:[970,2],
				itemsTabletSmall: [600,1],
				itemsMobile: [360,1],
				touchDrag: true,
				mouseDrag: true,
				autoHeight: false,
				autoPlay: false
			}); // end owlCarousel

		} // end if

    };    

    var aThemesIsotoperun = function ($scope, $) {
	   if ( $('.project-wrap').length ) {

	      $('.project-wrap').each(function() {

	        var self       = $(this);
	        var filterNav  = self.find('.project-filter').find('a');

	        var projectIsotope = function($selector){

	          $selector.isotope({
	            filter: '*',
	            itemSelector: '.project-item',
	            percentPosition: true,
	            animationOptions: {
	                duration: 750,
	                easing: 'liniar',
	                queue: false,
	            }
	          });

	        }

	        self.children().find('.isotope-container').imagesLoaded( function() {
	          projectIsotope(self.children().find('.isotope-container'));
	        });

	        $(window).load(function(){
	          projectIsotope(self.children().find('.isotope-container'));
	        });

	        filterNav.click(function(){
	            var selector = $(this).attr('data-filter');
	            filterNav.removeClass('active');
	            $(this).addClass('active');

	            self.find('.isotope-container').isotope({
	                filter: selector,
	                animationOptions: {
	                    duration: 750,
	                    easing: 'liniar',
	                    queue: false,
	                }
	            });

	            return false;

	        });

	      });

	    }
    };

    var aThemesTeamSocial = function ($scope, $) {
    	//Moves social bar inside image for aThemes: Employee - style 2
  		$( '.roll-team.type-b.style2').find( '.team-item' ).each( function() {
  			var socials = $(this).find( '.team-social' );
  			socials.appendTo( $(this).find( '.team-inner') );
  		});
    };    


    $(window).on('elementor/frontend/init', function () {
        elementorFrontend.hooks.addAction('frontend/element_ready/athemes-testimonials.default', aThemesTestimonialsCarouselrun);
        elementorFrontend.hooks.addAction('frontend/element_ready/athemes-posts.default', aThemesNewsCarouselrun);
		elementorFrontend.hooks.addAction('frontend/element_ready/athemes-portfolio.default', aThemesIsotoperun);    
		elementorFrontend.hooks.addAction('frontend/element_ready/athemes-employee.default', aThemesTeamSocial);    
    });

})(jQuery);