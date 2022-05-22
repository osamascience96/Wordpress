/**
 * Appointment JS - Appointment js for klinikal theme
 * @version v3.0
 * @copyright 2020 Pepdev.
 */
 (function($) {
 	"use strict";

 	var container = $('.appointment-wrapper'),
 	doctor = container.find('.doctor'),
 	department = container.find('.department'),
 	date = container.find('.date'),
 	today,disabledDays, weeklyHoliday;

    //National Holidays functions for Appointment Page
    function nationalDaysappointment(d) {
    	var d = new Date(d), month = '' + (d.getMonth() + 1), day = '' + d.getDate(), year = d.getFullYear(), date_string, i;
    	if (month.length < 2) { month = '0' + month; }
    	if (day.length < 2) { day = '0' + day; }

    	date_string = [year, month, day].join('-');
    	for (i = 0; i < disabledDays.length; i++) {
    		if (new Date(disabledDays[i]).toString() === new Date(date_string).toString()) {
    			return [true, 'ui-state-disabled', ''];
    		}
    	}
    	return [true];
    }
    //Weekly Holiday Function  for Appointment Page for Appointment Page
    function noWeekendsOrHolidays(d) {
    	var day = d.getDay(),
    	noWeekend = [true];
    	noWeekend = [(day != weeklyHoliday['0'] && day != weeklyHoliday['1'] && day != weeklyHoliday['2'] && day != weeklyHoliday['3'] && day != weeklyHoliday['4'] && day != weeklyHoliday['5'] && day != weeklyHoliday['6'])];
    	return noWeekend[0] ? nationalDaysappointment(d) : [true, 'ui-state-disabled', ''];
    }

    function clearField(field) {
    	if (field === "doctor") {
    		date.datepicker('destroy');
    		$('.date-box').show();
    		$('.time-box').hide();
        }
        if (field === "date") {
            $('.time-box').show();
        }
        $('.continue-box').hide();
        $('.slot div, .slot input').remove();
        field = '';
    }

    function loading() {
        container.block({
            message: '<div class="font-16"><div class="spinner-5 primary"></div></div>',
            overlayCSS: { backgroundColor: '#fff', opacity: 0.8, cursor: 'wait'},
            css: { border: 0, padding: '10px 15px', color: '#333', width: 'auto', backgroundColor: '#f4f4f4' }
        });
    }

    function unLoading() {
        container.unblock();
    }

    function getAppointmentSlot(data) {
        loading();
        var path = 'index.php?route=gettimeslot';
        $.ajax({
            type: 'post',
            url: path,
            data: { date: data.date, department: data.department, day: data.day, doctor: data.doctor },
            error: function () {
                $('.slot').append('<div class="font-14 text-danger">Error occured during connection.</div> ');
            },
            success: function (response) {
                $('.slot').append(response);
            }
        });
        unLoading();
    }

    //create datepicker
    function initDatepicker(data) {
    	if (typeof data.national !== "undefined" && data.national !== "") { disabledDays = JSON.parse(data.national).split(', '); } else { disabledDays = []; }
    	if (typeof data.weekly !== "undefined") { weeklyHoliday = data.weekly; } else { weeklyHoliday = []; }

    	date.datepicker({
    		dateFormat: $('.common_date_format').val(),
    		minDate: 0,
    		maxDate: "+1M",
    		beforeShowDay: noWeekendsOrHolidays,
    		onSelect: function () {
    			date.parent().addClass('has-content');
    			clearField("date");
    			//$('.slot div, .slot input').remove();
    			var curDate = $(this).datepicker('getDate');
    			data.date = $.datepicker.formatDate("yy-mm-dd", curDate);
    			data.day = curDate.getDay();
    			getAppointmentSlot(data);
    		}
    	});
    }

    doctor.on('change', function () {
    	var ele = $(this), ele_seleted = ele.find('option:selected'),
    	data = ele_seleted.data();
    	//date.datepicker('destroy');
    	clearField("doctor");
    	data.doctor = ele_seleted.val();
        department.val(data.department);
        initDatepicker(data);
    });

    container.on('click', '.continue', function () {
        $('.doctor-text').text(doctor.find('option:selected').text());
        $('.date-text').text(date.val());
        $('.time-text').text($('.slot input[name=time]:checked').val());
        $('.appointment').hide();
        $('.user').show(); 
    });

    $('.slot').on('change', 'input[name=time]', function() {
        var ele = $(this);
        if (ele.val() !== 'undefined' && ele.val() !== "") {
            $('.continue-box').show();
        }
    });

    container.on('click', '.back', function () {
        $('.user').hide();
        $('.appointment').show();
    });

    container.on('click', '.submit', function () {
        var data = {},
        mail_filter = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,4})+$/,
        mob_filter = /^[0-9]*$/;
        $('.appointment-form').serializeArray().map( function(x) { data[x.name] = x.value; });
        if(Math.floor(data.department) != data.department && !$.isNumeric(data.department)) {
            return false;
        }
        if(Math.floor(data.doctor) != data.doctor || !$.isNumeric(data.doctor)) {
            return false;
        }
        if (!$.datepicker.parseDate($('.common_date_format').val(), data.date)) {
            return false;
        }
        if (!mob_filter.test(data.mobile) || data.mobile.trim().length < 4 || data.mobile.trim().length > 16) {
            return false;
        }
        if (!mail_filter.test(data.mail) || data.mail.trim().length > 254) {
            return false;
        }
        if (data.name.trim().length > 100) {
            return false;
        }
        loading();
        var path = 'index.php?route=maekanappointment';
        $.ajax({
            type: 'post',
            url: path,
            data: { data: data },
            error: function () {
                unLoading();
            },
            success: function (response) {
                response = JSON.parse(response);
                if (response.error == true) {
                    if (typeof response.slot !== "undefined") {
                        $('.appointment-form').find('.error-msg').remove();
                        $('.user').hide();
                        $('.appointment').show();
                        $('.continue-box').hide();
                        $('.slot div, .slot input').remove();
                        $('.slot').append(response.slot);
                        $('.appointment-form .appointment').prepend('<div class="error-msg mb-3">'+response.message+'</div>');

                    } else {
                        $('.appointment-form .user').prepend('<div class="error-msg mb-3">'+response.message+'</div>');
                    }
                } else {
                    $('.success-doctor').text(doctor.find('option:selected').text());
                    $('.success-date').text(date.val());
                    $('.success-time').text($('.slot input[name=time]:checked').val());
                    $('.appointment').hide();
                    $('.user').hide();
                    $('.success').show(); 
                }
                unLoading();
            }
        });
        
    });

})(jQuery);





