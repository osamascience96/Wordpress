<?php include (DIR_ADMIN.'app/views/common/header.tpl.php'); ?>
<div class="page-title">
	<div class="row align-items-center">
		<div class="col-sm-6">
			<h2 class="page-title-text d-inline-block"><?php echo $page_title; ?></h2>
			<div class="breadcrumbs d-inline-block">
				<ul>
					<li><a href="<?php echo URL_ADMIN; ?>">Dashboard</a></li>
					<li><a href="<?php echo URL_ADMIN.DIR_ROUTE.'medicine/purchase'; ?>">Purchase</a></li>
					<li><?php echo $page_title; ?></li>
				</ul>
			</div>
		</div>
		<div class="col-sm-6 text-right"></div>
	</div>
</div>

<form action="<?php echo $action; ?>" method="post">
	<input type="hidden" name="_token" value="<?php echo $common['token']; ?>">
	<div class="panel panel-default">
		<div class="panel-body">
			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<label>Suppliers <span class="form-required">*</span></label>
						<div class="input-group">
							<div class="input-group-prepend"><span class="input-group-text"><i class="ti-tag"></i></span></div>
							<select name="purchase[supplier]" class="custom-select" required>
								<option value="">Select Suppliers</option>
								<?php if (!empty($suppliers)) { foreach ($suppliers as $key => $value) { ?>
									<option value="<?php echo $value['id']; ?>" <?php if ($result['supplier'] == $value['id']) { echo "selected"; } ?> ><?php echo $value['name']; ?></option>
								<?php } } ?>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label>Purchase Date <span class="form-required">*</span></label>
						<div class="input-group">
							<div class="input-group-prepend"><span class="input-group-text"><i class="ti-tag"></i></span></div>
							<input type="text" name="purchase[date]" class="form-control bg-white date" value="<?php echo date_format(date_create($result['date']), $common['info']['date_format']); ?>" placeholder="Purchase Date" readonly required>
						</div>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label>Note</label>
						<div class="input-group">
							<div class="input-group-prepend"><span class="input-group-text"><i class="ti-paragraph"></i></span></div>
							<textarea name="purchase[note]" class="form-control" placeholder="Enter Note or Comment . . ."><?php echo $result['note']; ?></textarea>
						</div>
					</div>	
				</div>
			</div>
			<div class="purchase-items table-responsive">
				<table class="table table-input">
					<thead>
						<tr>
							<th>Name<span class="form-required">*</span></th>
							<th>Batch No<span class="form-required">*</span></th>
							<th>Expiry Date<span class="form-required">*</span></th>
							<th>Packing Qty</th>
							<th>Quantity<span class="form-required">*</span></th>
							<th>Purchase Price<span class="form-required">*</span></th>
							<th>Sale Price<span class="form-required">*</span></th>
							<th>Tax</th>
							<th>Price<span class="form-required">*</span></th>
							<th></th>
						</tr>
					</thead>
					<tbody>
						<?php if (!empty($batches)) { foreach ($batches as $key => $value) { ?>
							<tr class="item-row">
								<td>
									<textarea class="item-name" name="purchase[items][<?php echo $key; ?>][name]" required><?php echo $value['name']; ?></textarea>
									<input type="hidden" class="item-id" name="purchase[items][<?php echo $key; ?>][medicine_id]" value="<?php echo $value['medicine_id']; ?>" required>
									<input type="hidden" name="purchase[items][<?php echo $key; ?>][id]" value="<?php echo $value['id']; ?>" required>
								</td>
								<td>
									<textarea class="item-batch" name="purchase[items][<?php echo $key; ?>][batch]" required><?php echo $value['batch']; ?></textarea>
								</td>
								<td>
									<input type="text" class="item-expiry exp-date p-2 datetimepicker-input" name="purchase[items][<?php echo $key; ?>][expiry]" value="<?php echo date_format(date_create($value['expiry']), $common['info']['date_my_format']); ?>" required>
								</td>
								<td>
									<textarea class="item-pqty" name="purchase[items][<?php echo $key; ?>][pqty]"><?php echo $value['pqty']; ?></textarea>
								</td>
								<td>
									<textarea class="item-qty" name="purchase[items][<?php echo $key; ?>][qty]" required><?php echo $value['qty']; ?></textarea>
								</td>
								<td>
									<textarea class="item-purchaseprice" name="purchase[items][<?php echo $key; ?>][purchaseprice]" required><?php echo $value['purchaseprice']; ?></textarea>
								</td>
								<td>
									<textarea class="item-saleprice" name="purchase[items][<?php echo $key; ?>][saleprice]" required><?php echo $value['saleprice']; ?></textarea>
								</td>
								<td class="invoice-tax">
									<?php if (!empty($value['tax'])) { $value['tax'] = json_decode($value['tax'], true); 
									foreach ($value['tax'] as $tax_key => $tax_value) { ?>
										<p class="badge badge-light badge-sm badge-pill">
											<?php echo $tax_value['name']; ?>
											<input type="text" name="purchase[items][<?php echo $key ?>][tax][<?php echo $tax_key ?>][tax_price]" class="single-tax-price" value="<?php echo $tax_value['tax_price']; ?>" readonly>
											<input type="hidden" name="purchase[items][<?php echo $key ?>][tax][<?php echo $tax_key ?>][id]" class="invoice-tax-id" value="<?php echo $tax_value['id']; ?>"> 
											<input type="hidden" name="purchase[items][<?php echo $key ?>][tax][<?php echo $tax_key ?>][name]" value="<?php echo $tax_value['name']; ?>">
											<input type="hidden" class="invoice-tax-rate" name="purchase[items][<?php echo $key ?>][tax][<?php echo $tax_key ?>][rate]" value="<?php echo $tax_value['rate']; ?>">
										</p>
									<?php } } ?>
									<input type="hidden" class="item-tax-price" name="purchase[items][<?php echo $key; ?>][taxprice]" value="0" readonly>
								</td>
								<td>
									<textarea class="bg-white item-price" name="purchase[items][<?php echo $key; ?>][price]" required readonly><?php echo $value['price']; ?></textarea>
								</td>
								<td>
									<a class="badge badge-warning badge-sm badge-pill add-taxes m-1">Add Taxes</a>
									<a class="badge badge-danger badge-sm badge-pill delete m-1">Delete</a>
								</td>
							</tr>
						<?php } } else { ?>
							<tr class="item-row">
								<td>
									<textarea class="item-name" name="purchase[items][0][name]" required></textarea>
									<input type="hidden" class="item-id" name="purchase[items][0][medicine_id]" required>
									<input type="hidden" name="purchase[items][0][id]" required>
								</td>
								<td>
									<textarea class="item-batch" name="purchase[items][0][batch]" required></textarea>
								</td>
								<td>
									<input type="text" class="item-expiry exp-date p-2 datetimepicker-input" name="purchase[items][0][expiry]" required>
								</td>
								<td>
									<textarea class="item-pqty" name="purchase[items][0][pqty]"></textarea>
								</td>
								<td>
									<textarea class="item-qty" name="purchase[items][0][qty]" required></textarea>
								</td>
								<td>
									<textarea class="item-purchaseprice" name="purchase[items][0][purchaseprice]" required></textarea>
								</td>
								<td>
									<textarea class="item-saleprice" name="purchase[items][0][saleprice]" required></textarea>
								</td>
								<td class="invoice-tax">
									<input type="hidden" class="item-tax-price" name="purchase[items][0][taxprice]" value="0" readonly>
								</td>
								<td>
									<textarea class="bg-white item-price" name="purchase[items][0][price]" required readonly></textarea>
								</td>
								<td>
									<a class="badge badge-warning badge-sm badge-pill add-taxes m-1">Add Taxes</a>
									<a class="badge badge-danger badge-sm badge-pill delete m-1">Delete</a>
								</td>
							</tr>
						<?php } ?>
						<tr>
							<td colspan="10">
								<div class="add-items d-inline-block">
									<a class="btn btn-success btn-sm m-1"><i class="icon-plus mr-1"></i> Add Item</a>
								</div>
							</td>
						</tr>
						<tr>
							<td colspan="3" class="blank"></td>
							<td colspan="3" class="total-line"><label class="p-2">Sub Total</label></td>
							<td colspan="4" class="total-value">
								<input type="text" name="purchase[total]" class="form-transparent p-2 total-price" value="<?php echo $result['total']; ?>" readonly>
							</td>
						</tr>
						<tr>
							<td colspan="3" class="blank"></td>
							<td colspan="3" class="total-line"><label class="p-2">Tax</label></td>
							<td colspan="4" class="total-value">
								<input type="text" name="purchase[tax]" class="form-transparent p-2 total-tax" value="<?php echo $result['tax']; ?>" readonly>
							</td>
						</tr>
						<tr>
							<td colspan="3" class="blank"></td>
							<td colspan="3" class="total-line">
								<div class="row align-items-center">
									<div class="col-8"><label class="p-2">Discount</label></div>
									<div class="col-4">
										<select name="purchase[discounttype]" class="discount-type">
											<option value="1" <?php if ($result['discounttype'] == '1') { echo "selected"; } ?>>%</option>
											<option value="2" <?php if ($result['discounttype'] == '2') { echo "selected"; } ?>>Flat</option>
										</select>
									</div>
								</div>
							</td>
							<td colspan="4" class="total-value">
								<input type="text" name="purchase[discount]" class="form-transparent p-2 discount-total" value="<?php echo $result['discount']; ?>">
								<input type="hidden" class="discount-amount" name="purchase[discount_value]"  value="<?php echo $result['discount_value']; ?>">
							</td>
						</tr>
						<tr>
							<td colspan="3" class="blank"></td>
							<td colspan="3" class="total-line"><label class="p-2">Amount</label></td>
							<td colspan="4" class="total-value">
								<input type="text" name="purchase[amount]" class="form-transparent p-2 total-amount" value="<?php echo $result['amount']; ?>" readonly>
							</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
		<input type="hidden" name="purchase[id]" value="<?php echo $result['id'];?>">
		<div class="panel-footer text-center">
			<button type="submit" name="submit" class="btn btn-primary"><i class="ti-save-alt pr-2"></i> Save</button>
		</div>
	</div>
</form>

<div class="modal fade" id="addTax">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Tax</h5>
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span></button>
			</div>
			<div class="modal-body">
				<?php if ($taxes) { foreach ($taxes as $key => $value) { ?>
					<div class="custom-control custom-checkbox custom-checkbox-1 mb-3">
						<input type="checkbox" class="custom-control-input" id="inv-taxes-<?php echo $value['id'] ?>" value="<?php echo $value['id'] ?>" data-rate="<?php echo $value['rate'] ?>" data-name="<?php echo $value['name'] ?>" name="modaltax">
						<label class="custom-control-label" for="inv-taxes-<?php echo $value['id'] ?>"><?php echo $value['name'].' ('.$value['rate'].'%)'; ?></label>
					</div>
				<?php } } ?>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-warning add-modal-taxes">Add Taxes</button>
			</div>
		</div>
	</div>
</div>


<link rel="stylesheet" href="public/css/bootstrap-datetimepicker.min.css">
<script type="text/javascript" src="public/js/bootstrap-datetimepicker.min.js"></script>

<script type="text/javascript">
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

	function updateTotal() {
		var total = 0;
		$('.item-price').each(function(i) {
			price = $(this).val();
			if (!isNaN(price)) { total += Number(price); }
		});

		var discount = Number($(".discount-total").val());
		var after_discount = 0;

		if ($('.discount-type').val() === "2") {
			after_discount = total - discount;
			after_discount = after_discount;
		} else {
			discount = discount * total * 0.01;
			after_discount = total - discount;
			after_discount = roundNumber(after_discount, 2);
		}

		var taxtotal = 0;
		$('.item-tax-price').each(function(i) {
			taxprice = $(this).val();
			if (!isNaN(taxprice)) { taxtotal += Number(taxprice); }
		});

		taxprice = roundNumber(taxtotal, 2);
		var amount = +after_discount + +taxprice;

		$('.total-price').val(total);
		$('.total-tax').val(taxprice);
		$('.total-amount').val(amount);
		$('.discount-amount').val(discount);
	}

	function updatePrice() {
		$('.item-row').each(function(){
			var row = $(this),
			price = row.find('.item-purchaseprice').val() * row.find('.item-qty').val(),
			tax_price = roundNumber(row.find('.item-tax').find(':selected').data( "rate" ) * price * 0.01, 2);
			var tax = 0;
			row.find('.invoice-tax p').each(function() {
				var ele = $(this);
				tax_amount = roundNumber(ele.find('.invoice-tax-rate').val() * price * 0.01, 2);
				ele.find('.single-tax-price').val(tax_amount);
				tax += Number($(this).find('input.invoice-tax-rate').val()) * price * 0.01;
			});
			tax_price = roundNumber(tax, 2);
			price = Number(roundNumber(price, 2));

			var unit_price = (+price) + (+tax_price);
			isNaN(price) ? row.find('.item-price').val("N/A") : row.find('.item-price').val(price);
			isNaN(tax_price) ? row.find('.item-tax-price').html("N/A") : row.find('.item-tax-price').val(tax_price);
		});
		updateTotal();
	}

	function bind() {
		$(".item-purchaseprice").on('blur', updatePrice);
		$(".item-qty").on('blur', updatePrice);
		$(".discount-total").on('blur', updatePrice);
		$("body").on('change', '.item-tax', updatePrice);
		$("body").on('change', '.discount-type', updatePrice);
	}
	
	function initDatepicker() {
		$('.exp-date').datetimepicker({
			viewMode: 'years',
			format: $('.common_daterange_my_format').val(),
			widgetPositioning: {
				horizontal: 'auto',
				vertical: 'auto'
			},
			collapse: true,
			icons: {
				time: "far fa-clock",
				date: "far fa-calendar-alt",
				up: "fas fa-angle-up",
				down: "fas fa-angle-down",
				previous: 'fas fa-angle-left',
				next: 'fas fa-angle-right',

			}
		});
	}

	function initAutocomplete() {
		$(".item-name").autocomplete({
			minLength: 0,
			source: '<?php echo URL_ADMIN.DIR_ROUTE.'getmedicine'; ?>',
			focus: function( event, ui ) {
				$(this).parents('tr').find('.item-name').val( ui.item.label );
				return false;
			},
			select: function( event, ui ) {
				$(this).parents('tr').find('.item-name').val( ui.item.label );
				$(this).parents('tr').find('.item-id').val( ui.item.id );
				return false;
			}
		});
	}

	function item_html(count) {
		var item_html = '<tr class="item-row">'+
		'<td>'+
		'<textarea class="item-name" name="purchase[items]['+count+'][name]" required></textarea>'+
		'<input type="hidden" class="item-id" name="purchase[items]['+count+'][medicine_id]" required>'+
		'<input type="hidden" name="purchase[items]['+count+'][id]" required>'+
		'</td>'+
		'<td>'+
		'<textarea class="item-batch" name="purchase[items]['+count+'][batch]" required></textarea>'+
		'</td>'+
		'<td>'+
		'<input type="text" class="item-expiry exp-date p-2 datetimepicker-input bg-white" name="purchase[items]['+count+'][expiry]" required>'+
		'</td>'+
		'<td>'+
		'<textarea class="item-pqty" name="purchase[items]['+count+'][pqty]"></textarea>'+
		'</td>'+
		'<td>'+
		'<textarea class="item-qty" name="purchase[items]['+count+'][qty]" required></textarea>'+
		'</td>'+
		'<td>'+
		'<textarea class="item-purchaseprice" name="purchase[items]['+count+'][purchaseprice]" required></textarea>'+
		'</td>'+
		'<td>'+
		'<textarea class="item-saleprice" name="purchase[items]['+count+'][saleprice]" required></textarea>'+
		'</td>'+
		'<td class="invoice-tax">'+
		'<input type="hidden" class="item-tax-price" name="purchase[items]['+count+'][taxprice]" value="0" readonly>'+
		'</td>'+
		'<td>'+
		'<textarea class="bg-white item-price" name="purchase[items]['+count+'][price]" required readonly></textarea>'+
		'</td>'+
		'<td>'+
		'<a class="badge badge-warning badge-sm badge-pill add-taxes m-1">Add Taxes</a>'+
		'<a class="badge badge-danger badge-sm badge-pill delete m-1">Delete</a>'+
		'</td>'+
		'</tr>';

		if (count === 0) {
			$(".purchase-items tbody").prepend(item_html);
		} else {
			$(".purchase-items .item-row:last").after(item_html);
		}
	}


	$(document).ready(function () {
		"use strict";
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
			price = ele_target.find('.item-purchaseprice').val() * ele_target.find('.item-qty').val(),
			count = ele_target.find('.item-name').attr('name').split('[')[2];
			count = parseInt(count.split(']')[0]);

			$("input:checkbox[name=modaltax]:checked").each(function(index, element){
				var ele = $(this), name = ele.siblings("label").text(), id = ele.val(), rate = ele.data('rate'),
				tax_amount = roundNumber(rate * price * 0.01, 2);

				$('.tax-modal-open').prepend('<p class="badge badge-light badge-sm badge-pill">'+
					name+
					'<input type="text" class="single-tax-price" name="purchase[items]['+count+'][tax]['+index+'][tax_price]" value="'+tax_amount+'" readonly>'+
					'<input type="hidden" class="invoice-tax-id" name="purchase[items]['+count+'][tax]['+index+'][id]" value="'+id+'">'+ 
					'<input type="hidden" name="purchase[items]['+count+'][tax]['+index+'][name]" value="'+name+'">' +
					'<input type="hidden" class="invoice-tax-rate" name="purchase[items]['+count+'][tax]['+index+'][rate]" value="' +rate+'">' +
					'</p>');
			});
			updatePrice();
			$('.tax-modal-open').removeClass('tax-modal-open');
			$('#addTax').modal('hide')
		});

		$('.purchase-items').on('click', '.add-items', function () {
			if($(".item-row").length === 0) {
				item_html(0);
			} else {
				var count = $('.purchase-items table tr.item-row:last .item-name').attr('name').split('[')[2];
				count = parseInt(count.split(']')[0]) + 1;
				item_html(count);
			}
			initAutocomplete();
			initDatepicker();
			bind();
		});

		$('.purchase-items').on('click', '.delete', function () {
			var ele = $(this);
			ele.parents('.item-row').remove();
			bind();
			return false;
		});

		initAutocomplete();
		initDatepicker();
		bind();
	});
</script>

<!-- Footer -->
<?php include (DIR_ADMIN.'app/views/common/footer.tpl.php'); ?>