( function ( $ ) {

    var WidgetLAEPiechartsHandler = function ($scope, $) {

        $scope.find('.lae-piechart .lae-percentage').each(function () {

            var track_color = $(this).data('track-color');
            var bar_color = $(this).data('bar-color');

            $(this).easyPieChart({
                animate: 2000,
                lineWidth: 10,
                barColor: bar_color,
                trackColor: track_color,
                scaleColor: false,
                lineCap: 'square',
                size: 220

            });

        });

    };

    var WidgetLAEPiechartsHandlerOnScroll = function ($scope, $) {

        $scope.livemeshWaypoint(function (direction) {

            WidgetLAEPiechartsHandler($(this.element), $);

            this.destroy(); // Done with handle on scroll

        }, {
            offset: (window.innerHeight || document.documentElement.clientHeight) - 100
        });

    };

    // Make sure you run this code under Elementor..
    $( window ).on( 'elementor/frontend/init', function () {

        if (elementorFrontend.isEditMode()) {

            elementorFrontend.hooks.addAction( 'frontend/element_ready/lae-piecharts.default', WidgetLAEPiechartsHandler );

        } else {

            elementorFrontend.hooks.addAction( 'frontend/element_ready/lae-piecharts.default', WidgetLAEPiechartsHandlerOnScroll );

        }


    } );

} )( jQuery );