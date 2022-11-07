

(function ($) {

    var aThemesTestimonialsCarouselrun = function ($scope, $) {

		if ( $().owlCarouselFork ) {
			$('.roll-testimonials').not('.owl-carousel').owlCarouselFork({
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

    var aThemesTestimonialsSkinCarouselrun = function ($scope, $) {

		var $carousel = $( '.roll-testimonials.athemes-testimonials-skin', $scope);

		if ( $().owlCarouselFork ) {
			$carousel.not('.owl-carousel').owlCarouselFork({
				navigation : true,
				pagination: false,
				navigationText: [$('.tc-next'),$('.tc-prev')],
				responsive: true,
				slideSpeed: 1000,
				transitionStyle: "custfade",
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

		if ( $().owlCarouselFork ) {
			$(".panel-grid-cell .latest-news-wrapper").owlCarouselFork({
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
			}); // end owlCarouselFork

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

	var aThemesPortfolioExt = function ($scope, $) {

		$( '.sydney-portfolio-wrapper' ).each(function() {
			var $gallery = $( '.sydney-portfolio-items', $scope);
			var $filter  = $( '.sydney-portfolio-filter', $scope);

			$gallery.isotope({
				itemSelector: '.sydney-portfolio-item',	
			});

			$gallery.imagesLoaded().progress(function() {
				$gallery.isotope('layout');
			});	
			
			$filter.on( 'click', 'a', function(e) {
				e.preventDefault();
				$( this ).addClass( 'active' );
				$( this ).parent().siblings().find( 'a' ).removeClass( 'active' );
				var filterValue = $( this ).attr('data-filter');
				$gallery.isotope({ filter: filterValue });
			});	
		});	
	};	

    var aThemesTeamSocial = function ($scope, $) {
    	//Moves social bar inside image for aThemes: Employee - style 2
  		$( '.roll-team.type-b.style2').find( '.team-item' ).each( function() {
  			var socials = $(this).find( '.team-social' );
  			socials.appendTo( $(this).find( '.team-inner') );
  		});
	};    
	
    var aThemesHeroSlider = function ($scope, $) {

        $(document).ready(function () {

			var swiperConfig = {
				effect: 'fade',			  
				direction: 'horizontal',
				loop: true,
				autoplay: true,
				speed: 1000,    
				navigation: {
				  nextEl: '.swiper-button-next',
				  prevEl: '.swiper-button-prev',
				},			    
				pagination: {
				  el: '.swiper-pagination',
				  clickable: true,
				},
			}

			if ( 'undefined' === typeof Swiper ) {
				const asyncSwiper = elementorFrontend.utils.swiper;
			   
				new asyncSwiper( $('.athemes-hero-slider'), swiperConfig ).then( ( newSwiperInstance ) => {		   
				  swiperElement = newSwiperInstance;
				} );
			  } else {
				var swiperElement = new Swiper ( $('.athemes-hero-slider'), swiperConfig )
			  }

          });        

    };

    $(window).on('elementor/frontend/init', function () {
        elementorFrontend.hooks.addAction('frontend/element_ready/athemes-testimonials.default', aThemesTestimonialsCarouselrun);
		elementorFrontend.hooks.addAction('frontend/element_ready/athemes-testimonials.athemes-testimonials-skin', aThemesTestimonialsSkinCarouselrun); 
        elementorFrontend.hooks.addAction('frontend/element_ready/athemes-posts.default', aThemesNewsCarouselrun);
		elementorFrontend.hooks.addAction('frontend/element_ready/athemes-portfolio.default', aThemesIsotoperun);    
		elementorFrontend.hooks.addAction('frontend/element_ready/athemes-portfolio-ext.default', aThemesPortfolioExt);    
		elementorFrontend.hooks.addAction('frontend/element_ready/athemes-portfolio-ext.athemes-portfolio-ext-overlap-skin', aThemesPortfolioExt); 
		elementorFrontend.hooks.addAction('frontend/element_ready/athemes-portfolio-ext.athemes-portfolio-ext-classic-skin', aThemesPortfolioExt); 
		elementorFrontend.hooks.addAction('frontend/element_ready/athemes-portfolio-ext.athemes-portfolio-ext-metro-skin', aThemesPortfolioExt); 
		elementorFrontend.hooks.addAction('frontend/element_ready/athemes-employee.default', aThemesTeamSocial);    
		elementorFrontend.hooks.addAction('frontend/element_ready/sydney-hero-slider.default', aThemesHeroSlider); 
    });

}( jQuery, window.elementorFrontend ) );