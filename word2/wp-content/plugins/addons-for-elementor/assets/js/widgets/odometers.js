( function ( $ ) {

    var WidgetLAEOdometersHandler = function ($scope, $) {

        $scope.find('.lae-odometer .lae-number').each(function () {

            var odometer = $(this);

            setTimeout(function () {
                var data_stop = odometer.attr('data-stop');
                $(odometer).text(data_stop);

            }, 100);

        });

    };

    var WidgetLAEOdometersHandlerOnScroll = function ($scope, $) {

        $scope.livemeshWaypoint(function (direction) {

            WidgetLAEOdometersHandler($(this.element), $);

            this.destroy(); // Done with handle on scroll

        }, {
            offset: (window.innerHeight || document.documentElement.clientHeight) - 100
        });
    };

    // Make sure you run this code under Elementor..
    $( window ).on( 'elementor/frontend/init', function () {

        if (elementorFrontend.isEditMode()) {

            elementorFrontend.hooks.addAction( 'frontend/element_ready/lae-odometers.default', WidgetLAEOdometersHandler );

        } else {

            elementorFrontend.hooks.addAction( 'frontend/element_ready/lae-odometers.default', WidgetLAEOdometersHandlerOnScroll );
        }

    } );

} )( jQuery );