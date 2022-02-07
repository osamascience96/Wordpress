( function ( $ ) {

    var WidgetLAEStatsBarHandler = function ($scope, $) {

        $scope.find('.lae-stats-bar-content').each(function () {

            var dataperc = $(this).data('perc');

            $(this).animate({"width": dataperc + "%"}, dataperc * 20);

        });

    };

    var WidgetLAEStatsBarHandlerOnScroll = function ($scope, $) {

        $scope.livemeshWaypoint(function (direction) {

            WidgetLAEStatsBarHandler($(this.element), $);

            this.destroy(); // Done with handle on scroll

        }, {
            offset: (window.innerHeight || document.documentElement.clientHeight) - 150
        });

    };

    // Make sure you run this code under Elementor..
    $( window ).on( 'elementor/frontend/init', function () {
        if (elementorFrontend.isEditMode()) {

            elementorFrontend.hooks.addAction( 'frontend/element_ready/lae-stats-bars.default', WidgetLAEStatsBarHandler );

        } else {

            elementorFrontend.hooks.addAction( 'frontend/element_ready/lae-stats-bars.default', WidgetLAEStatsBarHandlerOnScroll );

        }

    } );

} )( jQuery );