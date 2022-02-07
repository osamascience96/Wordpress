( function ( $ ) {

    var WidgetLAEPortfolioHandler = function ($scope, $) {

        if ($().isotope === undefined) {
            return;
        }

        var portfolioElem = $scope.find('.lae-portfolio:not(.lae-custom-grid)');
        if (portfolioElem.length === 0) {
            return; // no items to filter or load and hence don't continue
        }

        var rtl = portfolioElem.attr('dir') === 'rtl';

        var isotopeOptions = portfolioElem.data('isotope-options');

        portfolioElem.isotope({
            // options
            itemSelector: isotopeOptions['itemSelector'],
            layoutMode: isotopeOptions['layoutMode'],
            originLeft: !rtl,
        });

        // layout Isotope after each image load
        portfolioElem.imagesLoaded().progress( function() {
            portfolioElem.isotope('layout');
        });

        /* -------------- Taxonomy Filter --------------- */

        $scope.find('.lae-taxonomy-filter .lae-filter-item a').on('click', function (e) {
            e.preventDefault();

            var selector = $(this).attr('data-value');
            portfolioElem.isotope({filter: selector});
            $(this).closest('.lae-taxonomy-filter').children().removeClass('lae-active');
            $(this).closest('.lae-filter-item').addClass('lae-active');
            return false;
        });

    };

    // Make sure you run this code under Elementor..
    $( window ).on( 'elementor/frontend/init', function () {

        elementorFrontend.hooks.addAction( 'frontend/element_ready/lae-portfolio.default', WidgetLAEPortfolioHandler );

    } );

} )( jQuery );