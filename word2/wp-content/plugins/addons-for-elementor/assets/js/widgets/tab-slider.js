( function ( $ ) {

    var WidgetLAETabSliderHandler = function ($scope, $) {

        var slider_elem = $scope.find('.lae-tab-slider').eq(0);

        if (slider_elem.length > 0) {

            var rtl = slider_elem.attr('dir') === 'rtl';

            var settings = slider_elem.data('settings');

            var autoplay = settings['autoplay'];

            var adaptive_height = settings['adaptive_height'];

            var infinite = settings['infinite_looping'];

            var autoplay_speed = parseInt(settings['autoplay_speed']) || 3000;

            var animation_speed = parseInt(settings['animation_speed']) || 300;

            var pause_on_hover = settings['pause_on_hover'];

            var pause_on_focus = settings['pause_on_focus'];

            slider_elem.slick({
                arrows: false,
                dots: true,
                customPaging: function(slider, index) {
                    return $(slider.$slides[index]).find('.lae-tab-slide-nav');
                },
                infinite: infinite,
                autoplay: autoplay,
                autoplaySpeed: autoplay_speed,
                speed: animation_speed,
                fade: false,
                pauseOnHover: pause_on_hover,
                pauseOnFocus: pause_on_focus,
                adaptiveHeight: adaptive_height,
                slidesToShow: 1,
                slidesToScroll: 1,
                rtl: rtl,
            });
        }

    };

    // Make sure you run this code under Elementor..
    $( window ).on( 'elementor/frontend/init', function () {

        elementorFrontend.hooks.addAction( 'frontend/element_ready/lae-tab-slider.default', WidgetLAETabSliderHandler );

    } );

} )( jQuery );