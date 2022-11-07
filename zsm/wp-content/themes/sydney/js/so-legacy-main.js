;(function($) {

	'use strict'
	
    var testMobile;
    var isMobile = {
        Android: function() {
            return navigator.userAgent.match(/Android/i);
        },
        BlackBerry: function() {
            return navigator.userAgent.match(/BlackBerry/i);
        },
        iOS: function() {
            return navigator.userAgent.match(/iPhone|iPad|iPod/i);
        },
        Opera: function() {
            return navigator.userAgent.match(/Opera Mini/i);
        },
        Windows: function() {
            return navigator.userAgent.match(/IEMobile/i);
        },
        any: function() {
            return (isMobile.Android() || isMobile.BlackBerry() || isMobile.iOS() || isMobile.Opera() || isMobile.Windows());
        }
    };	

	var rollAnimation = function() {
		$('.orches-animation').each( function() {
		var orElement = $(this),
			orAnimationClass = orElement.data('animation'),
			orAnimationDelay = orElement.data('animation-delay'),
			orAnimationOffset = orElement.data('animation-offset');

			orElement.css({
				'-webkit-animation-delay':  orAnimationDelay,
				'-moz-animation-delay':     orAnimationDelay,
				'animation-delay':          orAnimationDelay
			});

			orElement.waypoint(function() {
				orElement.addClass('animated').addClass(orAnimationClass);
			},{ triggerOnce: true, offset: orAnimationOffset });
		});
	};

	var detectViewport = function() {
		$('[data-waypoint-active="yes"]').waypoint(function() {
			$(this).trigger('on-appear');
		}, { offset: '90%', triggerOnce: true });

		$(window).on('load', function() {
			setTimeout(function() {
				$.waypoints('refresh');
			}, 100);
		});
    };
    
	var projectEffect = function() {
		var effect = $('.project-wrap').data('portfolio-effect');

		$('.project-item').children('.item-wrap').addClass('orches-animation');

		$('.project-wrap').waypoint(function(direction) {
			$('.project-item').children('.item-wrap').each(function(idx, ele) {
				setTimeout(function() {
					$(ele).addClass('animated ' + effect);
				}, idx * 150);
			});
		}, { offset: '75%' });
    };
    
	var counter = function() {
		$('.roll-counter').on('on-appear', function() {
			$(this).find('.numb-count').each(function() {
				var to = parseInt($(this).attr('data-to'));
				$(this).countTo({
					to: to,
				});
			});
		}); //counter
    };   
    
	var progressBar = function() {
		$('.progress-bar').on('on-appear', function() {
			$(this).each(function() {
				var percent = $(this).data('percent');

				$(this).find('.progress-animate').animate({
					"width": percent + '%'
				},3000);

				$(this).parent('.roll-progress').find('.perc').addClass('show').animate({
					"width": percent + '%'
				},3000);
			});
		});
    };    
    
	var panelsStyling = function() {
		$(".panel-row-style").each( function() {
			if ($(this).data('hascolor')) {
				$(this).find('h1,h2,h3,h4,h5,h6,a,.fa, div, span').css('color','inherit');
			}
			if ($(this).data('hasbg') && $(this).data('overlay') ) {
				$(this).append( '<div class="overlay"></div>' );
				var overlayColor = $(this).data('overlay-color');
				$(this).find('.overlay').css('background-color', overlayColor );				
			}
		});
		$('.panel-grid .panel-widget-style').each( function() {
			var titleColor = $(this).data('title-color');
			var headingsColor = $(this).data('headings-color');
			if ( titleColor ) {
				$(this).find('.widget-title').css('color', titleColor );
			}
			if ( headingsColor ) {
				$(this).find('h1:not(.ignore),h2:not(.ignore),h3:not(.widget-title):not(.ignore),h4:not(.ignore),h5:not(.ignore),h6:not(.ignore),h3:not(.ignore) a').css('color', headingsColor );
			}			
		});	
	};    

	var videoPopup = function() {

		function closePopup() {
			if ( $('.sydney-video.vid-lightbox .video-overlay').hasClass('popup-show') ) {
			    
				var popup = $('.sydney-video.vid-lightbox .video-overlay.popup-show');

			    if ( popup.find('iframe').hasClass('yt-video') ) {
			    	var vid = popup.find('iframe').attr('src').replace("&autoplay=1", "");
			    } else {
			    	var vid = popup.find('iframe').attr('src').replace("?autoplay=1", "");
			    }
			    popup.find('iframe').attr('src', vid);
			    popup.removeClass('popup-show');			    		
			}			
		}

		$('.toggle-popup').on('click',function (e) {
			e.preventDefault();
			$(this).siblings().addClass('popup-show');
			
			var url =$(this).siblings().find('iframe').attr('src');

			if (url.indexOf('youtube.com') !== -1) {
        		$(this).siblings().find('iframe')[0].src += "&autoplay=1";
        		$(this).siblings().find('iframe').addClass('yt-video');
    		} else if (url.indexOf('vimeo.com') !== -1) {
        		$(this).siblings().find('iframe')[0].src += "?autoplay=1";
        		$(this).siblings().find('iframe').addClass('vimeo-video');
    		}

		});

		$(document).keyup(function(e) {
			if (e.keyCode == 27) {
			    closePopup();
			}
		});

		$('.sydney-video.vid-lightbox .video-overlay').on('click',function () {
			closePopup();
		});

		$('.sydney-video.vid-lightbox').parents('.panel-row-style').css({'z-index': '12', 'overflow': 'visible'});	

	};	

	var panelscrolls = function() {
		testMobile = isMobile.any();
		if (testMobile == null) {
			$(".panel-row-style").parallax("50%", 0.3);
		}
	};	

	var teamCarousel = function(){
		if ( $().owlCarouselFork ) {
			$(".roll-team:not(.roll-team.no-carousel)").owlCarouselFork({
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
				autoPlay: false,
			}); // end owlCarouselFork
		} // end if
	};

	var testimonialCarousel = function(){
		if ( $().owlCarouselFork ) {
			$('.roll-testimonials').owlCarouselFork({
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

	var socialMenu = function() {
	    $('.widget_fp_social a').attr( 'target','_blank' );
	};

	var portfolioIsotope = function(){

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

	// Dom Ready
	$(function() {       
		counter();
		progressBar();
		detectViewport();
		videoPopup();
        rollAnimation();
		panelsStyling();
		projectEffect();
		teamCarousel();
		socialMenu();
		testimonialCarousel();
		portfolioIsotope();
		panelscrolls();
   	});
})(jQuery); 