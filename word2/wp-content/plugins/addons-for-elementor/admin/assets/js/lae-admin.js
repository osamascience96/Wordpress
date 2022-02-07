
/*global jQuery:false*/

jQuery(document).ready(function () {
    LAE_JS.init();
    // Run tab open/close event
    LAE_Tab.event();
});

// Init all fields functions (invoked from ajax)
var LAE_JS = {
    init: function () {
        // Run tab open/close
        LAE_Tab.init();
        // Load colorpicker if field exists
        LAE_ColorPicker.init();
    }
};


var LAE_ColorPicker = {
    init: function () {
        var $colorPicker = jQuery('.lae-colorpicker');
        if ($colorPicker.length > 0) {

            $colorPicker.wpColorPicker();

        }
    }
};

var LAE_Tab = {
    init: function () {
        // display the tab chosen for initial display in content
        jQuery('.lae-tab.selected').each(function () {
            LAE_Tab.check(jQuery(this));
        });
    },
    event: function () {
        jQuery(document).on('click', '.lae-tab', function () {
            LAE_Tab.check(jQuery(this));
        });
    },
    check: function (elem) {
        var chosen_tab_name = elem.data('target');
        elem.siblings().removeClass('selected');
        elem.addClass('selected');
        elem.closest('.lae-inner').find('.lae-tab-content').removeClass('lae-tab-show').hide();
        elem.closest('.lae-inner').find('.lae-tab-content.' + chosen_tab_name + '').addClass('lae-tab-show').show();
    }
};