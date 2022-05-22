/**
 * Custom JS - Custom js for klinikal theme
 * @version v3.0
 * @copyright 2018 Pepdev.
 */
 $(document).ready(function () {
    "use strict";
    
    function inputBox(ele) {
        var ele_parent = ele.parent('.input-box');
        if ($.trim(ele.val()).length > 0) {
            ele_parent.addClass('has-content');
        } else {
            ele_parent.removeClass('has-content');
        }
    }

    $(document).on('blur', '.input-box input, .input-box select, .input-box textarea', function () {
        inputBox($(this));
    });

    $(document).on('change', '.input-box select', function () {
        inputBox($(this));
    });

    $(".input-box input, .input-box select, .input-box textarea").each(function() {
        inputBox($(this));
    });

    function showError(ele) {
        ele.parent('.input-box').addClass('has-error');
        ele.focus();
        return 1;
    }

    /*Form Validation*/
    $('#install-submit').click(function () {
        var clck_invld = 0,
        mail_filter = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,4})+$/,
        mob_filter = /^[0-9]*$/;
        $('.form-full-container').find('.input-box').removeClass('has-error');
        if ($('#user-password').val().trim().length < 7) {
           var ele = $('#user-password');
            clck_invld = showError(ele);
        }
        if ($('#user-username').val().trim().length < 4) {
            var ele = $('#user-username');
            clck_invld = showError(ele);
        }
        if (!mail_filter.test($('#user-email').val())) {
            var ele = $('#user-email');
            clck_invld = showError(ele);
        }
        if ($('#user-lastname').val().trim().length < 3) {
            var ele = $('#user-lastname');
            clck_invld = showError(ele);
        }
        if ($('#user-firstname').val().trim().length < 3) {
            var ele = $('#user-firstname');
            clck_invld = showError(ele);
        }


        
        if (!mob_filter.test($('#clinic-phone').val())) {
            var ele = $('#clinic-phone');
            clck_invld = showError(ele);
        }
        if ($('#clinic-phone').val().trim().length < 4) {
            var ele = $('#clinic-phone');
            clck_invld = showError(ele);
        }
        if (!mail_filter.test($('#clinic-email').val())) {
            var ele = $('#clinic-email');
            clck_invld = showError(ele);
        }
        if ($('#clinic-name').val().trim().length < 3) {
            var ele = $('#clinic-name');
            clck_invld = showError(ele);
        }
        if ($('#db-prefix').val().trim().length < 1) {
            var ele = $('#db-prefix');
            clck_invld = showError(ele);
        }
        if ($('#db-hostname').val().trim().length < 2) {
            var ele = $('#db-hostname');
            clck_invld = showError(ele);
        }
        if ($('#db-password').val().trim().length < 2) {
            var ele = $('#db-password');
            clck_invld = showError(ele);
        }
        if ($('#db-username').val().trim().length < 2) {
            var ele = $('#db-username');
            clck_invld = showError(ele);
        }
        if ($('#db-name').val().trim().length < 2) {
            var ele = $('#db-name');
            clck_invld = showError(ele);
        }

        if (clck_invld === 1) {
            return false;
        }
    });
});





