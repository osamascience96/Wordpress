<?php include (DIR_ADMIN.'app/views/common/header.tpl.php'); ?>
<div class="page-title">
	<div class="row align-items-center">
		<div class="col-sm-6">
			<h2 class="page-title-text d-inline-block"><?php echo $page_title; ?></h2>
			<div class="breadcrumbs d-inline-block">
				<ul>
					<li><a href="<?php echo URL_ADMIN; ?>">Dashboard</a></li>
					<li><a href="<?php echo URL_ADMIN.DIR_ROUTE.'makepayment'; ?>">Make Payment</a></li>
					<li><?php echo $page_title; ?></li>
				</ul>
			</div>
		</div>
		<div class="col-sm-6 text-right"></div>
	</div>
</div>

<div class="row">
	<div class="col-md-4">
		<div class="panel panel-default">
			<div class="panel-body">
				<div class="user-avtar">
					<?php if (!empty($staff['picture']) && file_exists(DIR.'public/uploads/'.$staff['picture'])) { ?>
						<img class="img-fluid img-thumbnail" src="<?php echo '../public/uploads/'.$staff['picture']; ?>">
					<?php } else { ?>
						<span><?php echo $staff['firstname'][0]; ?></span>
					<?php } ?>
				</div>
				<div class="user-details pt-2  pb-2 text-center">
					<h2 class="font-20"><?php echo $staff['firstname'].' '.$staff['lastname']; ?></h2>
				</div>
				<div class="table-responsive">
					<table class="table table-striped">
						<tbody>
							<tr>
								<td>Email Address</td>
								<td><?php echo $staff['email']; ?></td>
							</tr>
							<tr>
								<td>Mobile No.</td>
								<td><?php echo $staff['mobile']; ?></td>
							</tr>
							<tr>
								<td>Gender</td>
								<td><?php echo $staff['gender']; ?></td>
							</tr>
							<tr>
								<td>Bloodgroup</td>
								<td><?php echo $staff['bloodgroup']; ?></td>
							</tr>
							<tr>
								<td>DOB</td>
								<?php if (!empty($staff['dob'])) { ?>
									<td><?php echo date_format(date_create($staff['dob']), $common['info']['date_format']); ?></td>
								<?php } else { ?>
									<td></td>
								<?php } ?>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
	<div class="col-md-8">
		<div class="panel panel-default"> 
			<form action="<?php echo $action; ?>" method="post">
				<input type="hidden" name="_token" value="<?php echo $common['token']; ?>">
				<input type="hidden" name="staff_id" value="<?php echo $staff['user_id']; ?>">
				<input type="hidden" name="salarytemplate_id" value="<?php echo $salary['id']; ?>">
				<div id="makepayment-container" class="panel-body pb-1">
					<div class="row">
						<div class="col-md-6 form-group">
							<label>Month <span class="form-required">*</span></label>
							<input type="text" name="month_year" class="form-control" id="month" placeholder="Select Month" readonly required>
						</div>
						<div class="col-md-6 form-group">
							<label>Gross Salary <span class="form-required">*</span></label>
							<input type="text" name="gross_salary" class="form-control" value="<?php echo $salary['gross_salary']; ?>" placeholder="" readonly required>
						</div>
						<div class="col-md-6 col-md-6 form-group">
							<label>Total Deduction</label>
							<input type="text" name="total_deduction" class="form-control" value="<?php echo $salary['total_deduction']; ?>" readonly>
						</div>
						<div class="col-md-6 form-group">
							<label>Net Salary <span class="form-required">*</span></label>
							<input type="text" name="amount" class="form-control t-amount" value="<?php echo $salary['net_salary']; ?>" readonly  required>
							<input type="hidden" name="net_salary" value="<?php echo $salary['net_salary']; ?>">
						</div>
						<div class="col-md-6 form-group">
							<label>Advance</label>
							<input type="text" name="advance" class="form-control t-advance">
						</div>
						<div class="col-md-6 form-group">
							<label>Deduction</label>
							<input type="text" name="deduction" class="form-control t-deduction">
						</div>
						<div class="col-md-6 form-group">
							<label>Payment Amount <span class="form-required">*</span></label>
							<input type="text" name="paid" class="form-control t-total" value="<?php echo $salary['net_salary']; ?>" required>
						</div>
						<div class="col-md-6 form-group">
							<label>Payment Method <span class="form-required">*</span></label>
							<select name="method" class="custom-select" required>
								<?php if (!empty($methods)) { foreach ($methods as $key => $value) { ?>
									<option value="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></option>
								<?php } } ?>
							</select>
						</div>
						<div class="col-md-12 form-group">
							<label>Comments</label>
							<input type="text" name="comments" class="form-control" placeholder="Enter comments . . .">
						</div>
					</div>
				</div>
				<div class="panel-footer text-center">
					<button type="submit" name="submit" class="btn btn-primary makepayment-submit" disabled><i class="ti-save-alt pr-2"></i> Save</button>
				</div>
			</form>
		</div>
	</div>
</div>
<div class="panel panel-default"> 
	<div class="panel-head">
		<div class="panel-title">Payment History</div>
	</div>
	<div class="panel-body">
		<table class="table table-middle table-bordered table-striped datatable-table">
			<thead>
				<tr>
					<th>#</th>
					<th>Month</th>
					<th>Date</th>
					<th>Net Salary</th>
					<th>Payment Amount</th>
					<?php if ($page_delete || $page_view) { ?>
						<th></th>
					<?php } ?>
				</tr>
			</thead>
			<tbody>
				<?php if (!empty($history)) { foreach ($history as $key => $value) { ?>
					<tr>
						<td><?php echo $key+1; ?></td>
						<td><?php echo date_format(date_create($value['month_year']), $common['info']['date_my_format']); ?></td>
						<td><?php echo date_format(date_create($value['date_of_joining']), $common['info']['date_format']); ?></td>
						<td><?php echo $common['info']['currency_abbr'].$value['net_salary'];?></td>
						<td><?php echo $common['info']['currency_abbr'].$value['amount'];?></td>
						<?php if ($page_delete || $page_view) { ?>
							<td class="table-action">
								<?php if ($page_view) { ?>
									<a href="<?php echo URL_ADMIN.DIR_ROUTE.'managesalary/history/view&id='.$value['id'];?>" class="text-info edit" data-toggle="tooltip" title="View"><i class="ti-layout-media-center-alt"></i></a>
								<?php } if ($page_delete) { ?>
									<a class="table-delete text-danger delete" data-toggle="tooltip" title="Delete">
										<i class="ti-trash"></i><input type="hidden" value="<?php echo $value['id'];?>">
									</a>
								<?php } ?>
							</td>
						<?php } ?>
					</tr>
				<?php } } ?>
			</tbody>
		</table>
	</div>
</div>
<style>
	.ui-datepicker-calendar {
		display: none;
	}
</style>
<script>
	$("#month").datepicker( {
		dateFormat: $('.common_date_my_format').val(),
		changeMonth: true,
		changeYear: true,
		showButtonPanel: true,
		onClose: function(dateText, inst) { 
			$(this).datepicker('setDate', new Date(inst.selectedYear, inst.selectedMonth, 1));
			var month = (inst.selectedMonth+1);
			month = (month < 10 ? "0"+month : month);
			var date = inst.selectedYear + '-' + month;

			$.ajax({
				type: 'post',
				url: 'index.php?route=checkstaffsalary',
				data: { date: date, id: <?php echo $staff['user_id']; ?>, _token: '<?php echo $common['token']; ?>' },
				error: function () {

				},
				success: function (response) {
					response = JSON.parse(response);
					if (response.error == false) {
						$('.makepayment-submit').attr('disabled', false);
					} else {
						toastr.error(response.msg, 'Error');
						$('.makepayment-submit').attr('disabled', true);
						$('#month').val('');
					}
				}
			});
		}
	});
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

	function checkInputValue(ele_value, ele_class, error_field = 'Input') {
		if(ele_value != '') {
			if($.isNumeric(ele_value)) {
				$(ele_class).parent().find('.invalid-feedback').html('');
				$(ele_class).parent().find('.invalid-feedback').hide();
				ele_value = parseFloat(ele_value);
				if(ele_value >= 0) {
					return true;
				} else {
					ele_class.parent().find('.invalid-feedback').html('The '+error_field+' field is not negative number.');
					ele_class.parent().find('.invalid-feedback').show();
				}
			} else {
				ele_class.parent().find('.invalid-feedback').html('The '+error_field+' field is only number.');
				ele_class.parent().find('.invalid-feedback').show();
			}
		} else {
			ele_class.parent().find('.invalid-feedback').html('');
			ele_class.parent().find('.invalid-feedback').hide();
		}
	}

	function updateTotal(value, ele) {
		var advance = 0, deduction = 0,
		total = 0, month_salary = 0;
		if ($('.t-amount').val() != "") {
			month_salary = parseFloat($('.t-amount').val());
		} else {
			month_salary = 0;
		}

		if ($('.t-advance').val() != "") {
			advance = parseFloat($('.t-advance').val());
		} else {
			advance = 0;
		}

		if ($('.t-deduction').val() != "") {
			deduction = parseFloat($('.t-deduction').val());
		} else {
			deduction = 0;
		}

		total = parseFloat(month_salary) + parseFloat(advance) - parseFloat(deduction);
		$('.t-total').val(roundNumber(total, 2));
	}

	$('#makepayment-container').on('blur', '.t-advance', function () {
		var ele = $(this), value = ele.val();
		if (checkInputValue(value, ele)) {
			updateTotal();
		} else {
			updateTotal();
		}
	});

	$('#makepayment-container').on('blur', '.t-deduction', function () {
		var ele = $(this), value = ele.val();
		if (checkInputValue(value, ele)) {
			updateTotal();
		} else {
			updateTotal();
		}
	});

	$('.makepayment-submit').on('click', function () {
		updateTotal();
	});
</script>

<?php if ($page_delete) { include DIR_VIEW.'common/delete_modal.tpl.php'; } 
include (DIR_ADMIN.'app/views/common/footer.tpl.php'); ?>