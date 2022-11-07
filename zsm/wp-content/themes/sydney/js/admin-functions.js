(function($){

    'use strict';

    $( document ).on( 'click', '.sydney-update-fontawesome', function(e){
        e.preventDefault();

        if( confirm( sydneyadm.fontawesomeUpdate.confirmMessage ) ) {
            $.ajax({
                type: 'post',
                url: ajaxurl,
                data: {
                    action: 'sydney_update_fontawesome_callback',
                    nonce: $(this).data('nonce')
                },
                success: function (response) {
                    if( response.success ) {
                        window.location.reload();
                    } else {
                        alert( sydneyadm.fontawesomeUpdate.errorMessage );
                    }
                }
            });
        }
        
    } );
}(jQuery));


/**
 * Header update
 */
 (function($){

    'use strict';

    $( document ).on( 'click', '.sydney-update-header', function(e){
        e.preventDefault();

        if( confirm( sydneyadm.headerUpdate.confirmMessage ) ) {
            $.ajax({
                type: 'post',
                url: ajaxurl,
                data: {
                    action: 'sydney_header_update_notice_1_8_1_callback',
                    nonce: $(this).data('nonce')
                },
                success: function (response) {
                    if( response.success ) {
                        window.location.reload();
                    } else {
                        alert( sydneyadm.headerUpdate.errorMessage );
                    }
                }
            });
        }
        
    } );
}(jQuery));

/**
 * Header update dismiss
 */
 (function($){

    'use strict';

    $( document ).on( 'click', '.sydney-update-header-dismiss', function(e){
        e.preventDefault();

        if( confirm( sydneyadm.headerUpdateDimiss.confirmMessage ) ) {
            $.ajax({
                type: 'post',
                url: ajaxurl,
                data: {
                    action: 'sydney_header_update_dismiss_notice_1_8_2_callback',
                    nonce: $(this).data('nonce')
                },
                success: function (response) {
                    if( response.success ) {
                        window.location.reload();
                    } else {
                        alert( sydneyadm.headerUpdateDimiss.errorMessage );
                    }
                }
            });
        }
        
    } );
}(jQuery));