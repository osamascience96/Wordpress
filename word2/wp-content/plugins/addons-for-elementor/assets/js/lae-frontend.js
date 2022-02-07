/**
 * Reviews JS
 */
if (typeof (jQuery) != 'undefined') {

    (function ($) {
        "use strict";

        $(function () {

            var LAE_Frontend = {

                init: function () {
                    this.output_custom_css();

                    this.setup_animations();
                },

                setup_animations: function () {

                    /* Hide the elements if required to prepare for animation */
                    $(".lae-visible-on-scroll:not(.animated)").css('opacity', 0);

                    "function" != typeof window.lae_animate_widgets && (window.lae_animate_widgets = function () {
                        "undefined" != typeof $.fn.livemeshWaypoint && $(".lae-animate-on-scroll:not(.animated)").livemeshWaypoint(function () {
                            var animateClass = $(this.element).data("animation");
                            $(this.element).addClass("animated " + animateClass).css('opacity', 1);
                        }, {
                            offset: "85%"
                        })
                    });

                    window.setTimeout(lae_animate_widgets, 500)
                },

                output_custom_css: function () {

                    var custom_css = lae_js_vars.custom_css;
                    if (custom_css !== undefined && custom_css != '') {
                        custom_css = '<style type="text/css">' + custom_css + '</style>';
                        $('head').append(custom_css);
                    }
                },

                isMobile: function () {
                    "use strict";
                    if (/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
                        return true;
                    }
                    return false;
                }
            };


            /* Initialize the common JS for elements */

            LAE_Frontend.init();

        });

    }(jQuery));

}