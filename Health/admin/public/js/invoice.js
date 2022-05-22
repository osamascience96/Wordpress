var path = $('.site_url').val();

function fourdigits(number) {
    return (number < 1000) ? number + 1900 : number;
}

function roundNumber(number, decimals) {
    var newString;
    decimals = Number(decimals);
    if (decimals < 1) {
        newString = (Math.round(number)).toString();
    } else {
        var numString = number.toString();
        if (numString.lastIndexOf(".") == -1) {
            numString += ".";
        }
        var cutoff = numString.lastIndexOf(".") + decimals;
        var d1 = Number(numString.substring(cutoff, cutoff + 1)); 
        var d2 = Number(numString.substring(cutoff + 1, cutoff + 2)); 
        if (d2 >= 5) {
            if (d1 == 9 && cutoff > 0) {
                while (cutoff > 0 && (d1 == 9 || isNaN(d1))) {
                    if (d1 != ".") {
                        cutoff -= 1;
                        d1 = Number(numString.substring(cutoff, cutoff + 1));
                    } else {
                        cutoff -= 1;
                    }
                }
            }
            d1 += 1;
        }
        if (d1 == 10) {
            numString = numString.substring(0, numString.lastIndexOf("."));
            var roundedNum = Number(numString) + 1;
            newString = roundedNum.toString() + '.';
        } else {
            newString = numString.substring(0, cutoff) + d1.toString();
        }
    }
    if (newString.lastIndexOf(".") == -1) {
        newString += ".";
    }
    var decs = (newString.substring(newString.lastIndexOf(".") + 1)).length;
    for (var i = 0; i < decimals - decs; i++) newString += "0";
        return newString;
}

function update_total() {
    var total = 0;
    $('.item-price').each(function(i) {
        price = $(this).val();
        if (!isNaN(price)) { total += Number(price); }
    });

    var taxtotal = 0;
    $('.item-tax-price').each(function(i) {
        taxprice = $(this).val();
        if (!isNaN(taxprice)) { taxtotal += Number(taxprice); }
    });

    total = roundNumber(total, 2);
    taxprice = roundNumber(taxtotal, 2);
    var amount = roundNumber(+total + +taxprice , 2);

    $('.sub-total').val(total);
    $('.tax-total').val(taxprice);
    $('.total-amount').val(amount);
    $('.due-amount').val(amount);

    update_balance();
}

function update_balance() {
    var subtotal = Number($(".sub-total").val()),
    tax = Number($(".tax-total").val()),
    discount = Number($(".discount-total").val());
    var after_discount = (+subtotal) + (+tax);

    if ($('.discount-type').val() === "2") {
        var after_discount = subtotal - discount;
        after_discount = after_discount;
    } else {
        discount = discount * subtotal * 0.01;
        var after_discount = subtotal - discount;
        after_discount = roundNumber(after_discount, 2);
    }

    var due = (+after_discount + +tax) - $(".paid-amount").val();
    due = roundNumber(due, 2);
    var total = +after_discount + +tax;
    $('.discount_amount').val(discount);
    $('.total-amount').val(roundNumber(total, 2));
    $('.due-amount').val(due);
}

function update_price() {
    $('.item-row').each(function(){
        var row = $(this),
        price = row.find('.item-cost').val() * row.find('.item-quantity').val(),
        tax_price = roundNumber(row.find('.item-tax').find(':selected').data( "rate" ) * price * 0.01, 2);
        var tax = 0;
        row.find('.invoice-tax p').each(function() {
            var ele = $(this);
            tax_amount = roundNumber(ele.find('.invoice-tax-rate').val() * price * 0.01, 2);
            ele.find('.single-tax-price').val(tax_amount);
            tax += Number($(this).find('input.invoice-tax-rate').val()) * price * 0.01;
            
        });
        price = roundNumber(price, 2);
        tax_price = roundNumber(tax, 2);

        var unit_price = (+price) + (+tax_price);

        isNaN(price) ? row.find('.item-price').val("N/A") : row.find('.item-price').val(price);
        isNaN(unit_price) ? row.find('.item-total-price').val("N/A") : row.find('.item-total-price').val(price);
        isNaN(tax_price) ? row.find('.item-tax-price').html("N/A") : row.find('.item-tax-price').val(tax_price);
        update_total();
    });
}

function bind() {
    $(".item-cost").on('blur', update_price);
    $(".item-quantity").on('blur', update_price);
    $("body").on('change', '.item-tax', update_price);
    $("body").on('change', '.discount-type', update_price);
}

function item_html(count) {
    var item_html = '<tr class="item-row">'+
    '<td class="">'+
    '<textarea name="invoice[item]['+count+'][name]" class="item-name" required></textarea>'+
    '</td>'+
    '<td class="invoice-item">'+
    '<textarea name="invoice[item]['+count+'][descr]" class="item-descr"></textarea>'+
    '</td>'+
    '<td class="">'+
    '<textarea type="text" name="invoice[item]['+count+'][quantity]" class="item-quantity" required>1</textarea>'+
    '</td>'+
    '<td class="">'+
    '<textarea type="text" name="invoice[item]['+count+'][cost]" class="item-cost" required></textarea>'+
    '</td>'+
    '<td class="invoice-tax">'+
    '<input type="hidden" name="invoice[item]['+count+'][taxprice]" class="item-tax-price" value="0" readonly>' +
    '</td>'+
    '<td class="">'+
    '<textarea type="text" name="invoice[item]['+count+'][price]" class="item-total-price" readonly></textarea>'+
    '<input type="hidden" class="item-price">'+
    '</td>' +
    '<td>' +
    '<a class="badge badge-warning badge-sm badge-pill add-taxes m-1">Add Taxes</a>' +
    '<a class="badge badge-danger badge-sm badge-pill delete m-1">Delete</a>' +
    '</td>' +
    '</tr>';

    if (count === 0) {
        $(".invoice-items tbody").prepend(item_html);
    } else {
        $(".item-row:last").after(item_html);
    }
}

function initAutocomplete() {
    $(".item-name").autocomplete({
        source: path.concat('item/search'),
        minLength: 2,
        focus: function() { return false; },
        select: function( event, ui ) {
            var ele = $(this).parents('tr');
            ele.find(".item-name").val(ui.item.label);
            ele.find(".item-descr").val(ui.item.description);
            ele.find(".item-cost" ).val(roundNumber(ui.item.price, 2));
            ele.find(".item-total-price" ).val(roundNumber(ui.item.price,2));
            ele.find(".item-price" ).val(roundNumber(ui.item.price,2));
            update_price();
            return false;
        }
    });
}

$(document).ready(function () {
    "use strict";
    var tax_html = '', items = [];

    $(".discount-total").on('blur', update_balance);
    $(".paid-amount").on('blur', update_balance);

    $(".patient-doctor").autocomplete({
        source: path.concat('doctor/search'),
        minLength: 2,
        focus: function() {return false;},
        select: function( event, ui ) {
            $('.patient-doctor').val(ui.item.label);
            $('.patient-doctor-id').val(ui.item.id);
            return false;
        }
    });

    $('.invoice-items').on('click', '.add-items', function () {
        if($(".item-row").length === 0) {
            item_html(0);
        } else {
            var count = $('.invoice-items table tr.item-row:last .item-name').attr('name').split('[')[2];
            count = parseInt(count.split(']')[0]) + 1;
            item_html(count);
        }
        initAutocomplete();
        bind();
    });

    $('body').on('click', `.add-taxes, .invoice-tax p`, function () {
        var ele = $(this).parents('.item-row').find('.invoice-tax');
        ele.addClass('tax-modal-open');
        ele.find('p').each(function() {
            var id = $(this).find('.invoice-tax-id').val();
            $('#addTax').find('#inv-taxes-'+id).prop('checked', true)
        });
        $('#addTax').modal('show');
    });
    
    $('#addTax').on('hidden.bs.modal', function (e) {
        $('.tax-modal-open').removeClass('tax-modal-open');
        $("#addTax input").prop("checked", false);
    });

    $('body').on('click', '.add-modal-taxes', function () {
        $('.tax-modal-open p').remove();
        
        var ele_target  = $('.tax-modal-open').parents('.item-row'),
        price = ele_target.find('.item-cost').val() * ele_target.find('.item-quantity').val(),
        count = ele_target.find('.item-name').attr('name').split('[')[2];
        count = parseInt(count.split(']')[0]);
        
        $("input:checkbox[name=modaltax]:checked").each(function(index, element){
            var ele = $(this), name = ele.siblings("label").text(), id = ele.val(), rate = ele.data('rate'),
            tax_amount = roundNumber(rate * price * 0.01, 2);

            $('.tax-modal-open').prepend('<p class="badge badge-light badge-sm badge-pill">'+
                name+
                '<input type="text" class="single-tax-price" name="invoice[item]['+count+'][tax]['+index+'][tax_price]" value="'+tax_amount+'" readonly>'+
                '<input type="hidden" class="invoice-tax-id" name="invoice[item]['+count+'][tax]['+index+'][id]" value="'+id+'">'+ 
                '<input type="hidden" name="invoice[item]['+count+'][tax]['+index+'][name]" value="'+name+'">' +
                '<input type="hidden" class="invoice-tax-rate" name="invoice[item]['+count+'][tax]['+index+'][rate]" value="' +rate+'">' +
                '</p>');
        });

        update_price();
        $('.tax-modal-open').removeClass('tax-modal-open');
        $('#addTax').modal('hide')
    });

    $('.invoice-items').on('click', '.delete', function () {
        var ele = $(this), ele_par = ele.parents('.item-row');
        if ($('.item-row').length > 1) {
            ele.parents('.item-row').remove();
        } else {
            toastr.error('One row is compulsory for invoice.', 'Warning');
        }
        bind();
        return false;
    });

    bind();

    initAutocomplete();
});