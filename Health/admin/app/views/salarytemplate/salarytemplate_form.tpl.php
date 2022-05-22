<?php include (DIR_ADMIN.'app/views/common/header.tpl.php'); ?>
<div class="page-title">
	<div class="row align-items-center">
		<div class="col-sm-6">
			<h2 class="page-title-text d-inline-block"><?php echo $page_title; ?></h2>
			<div class="breadcrumbs d-inline-block">
				<ul>
					<li><a href="<?php echo URL_ADMIN; ?>">Dashboard</a></li>
					<li><a href="<?php echo URL_ADMIN.DIR_ROUTE.'salarytemplate'; ?>">Salary Template</a></li>
					<li><?php echo $page_title; ?></li>
				</ul>
			</div>
		</div>
		<div class="col-sm-6 text-right"></div>
	</div>
</div>

<form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data">
	<input type="hidden" name="_token" value="<?php echo $token; ?>">
	<div class="panel panel-default">
		<div class="panel-body">
			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<label>Salary Grades <span class="form-required">*</span></label>
						<div class="input-group">
							<div class="input-group-prepend"><span class="input-group-text"><i class="ti-user"></i></span></div>
							<input type="text" name="salary[grade]" class="form-control" value="<?php echo $result['grade']; ?>" placeholder="Salary Grades" required>
						</div>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label>Basic Salary <span class="form-required">*</span></label>
						<div class="input-group">
							<div class="input-group-prepend"><span class="input-group-text"><i class="ti-user"></i></span></div>
							<input type="text" name="salary[basic_salary]" class="form-control basic-salary" value="<?php echo $result['basic_salary']; ?>" placeholder="Basic Salary" required>
							<span class="invalid-feedback">asdasd</span>
						</div>
					</div>
				</div>
				<div class="col-md-6">
					<table class="table table-bordered table-middle mb-5 allowance-container">
						<thead>
							<tr>
								<td colspan="3" class="pt-2 pb-2"><label>Allowances</label></td>
							</tr>
						</thead>
						<tbody>
							<?php if (!empty($result['allowance'])) { foreach ($result['allowance'] as $key => $value) { ?>
								<tr class="item-row">
									<td><input type="text" name="salary[allowance][<?php echo $key; ?>][label]" class="form-control mb-0" value="<?php echo $value['label']; ?>" placeholder="Enter Allowances Label"></td>
									<td>
										<input type="text" name="salary[allowance][<?php echo $key; ?>][value]" class="form-control mb-0 allowance" value="<?php echo $value['value']; ?>" placeholder="Enter Allowances Value">
										<span class="invalid-feedback"></span>
									</td>
									<td><a class="text-danger text-center remove-row" data-name="allowance"><i class="ti-trash"></i></a></td>
								</tr>
							<?php } } else { ?>
								<tr class="item-row">
									<td><input type="text" name="salary[allowance][0][label]" class="form-control mb-0" placeholder="Enter Allowances Label"></td>
									<td>
										<input type="text" name="salary[allowance][0][value]" class="form-control mb-0 allowance" placeholder="Enter Allowances Value">
										<span class="invalid-feedback"></span>
									</td>
									<td><a class="text-danger text-center remove-row" data-name="allowance"><i class="ti-trash"></i></a></td>
								</tr>
							<?php } ?>
							<tr>
								<td colspan="3" class="p-1 text-right"><a class="btn btn-primary btn-sm add-row" data-name="allowance"><i class="ti-plus"></i> Add</a></td>
							</tr>
						</tbody>
					</table>
				</div>
				<div class="col-md-6">
					<table class="table table-bordered table-middle mb-5 deduction-container">
						<thead>
							<tr>
								<td colspan="3" class="pt-2 pb-2"><label>Deduction</label></td>
							</tr>
						</thead>
						<tbody>
							<?php if (!empty($result['deduction'])) { foreach ($result['deduction'] as $key => $value) { ?>
								<tr class="item-row">
									<td><input type="text" name="salary[deduction][<?php echo $key; ?>][label]" class="form-control mb-0" value="<?php echo $value['label']; ?>" placeholder="Enter Deduction Label"></td>
									<td>
										<input type="text" name="salary[deduction][<?php echo $key; ?>][value]" class="form-control mb-0 deduction" value="<?php echo $value['value']; ?>" placeholder="Enter Deduction Value">
										<span class="invalid-feedback"></span>
									</td>
									<td><a class="text-danger text-center remove-row" data-name="deduction"><i class="ti-trash"></i></a></td>
								</tr>
							<?php } } else { ?>
								<tr class="item-row">
									<td><input type="text" name="salary[deduction][0][label]" class="form-control mb-0" placeholder="Enter Deduction Label"></td>
									<td>
										<input type="text" name="salary[deduction][0][value]" class="form-control mb-0 deduction" placeholder="Enter Deduction Value">
										<span class="invalid-feedback"></span>
									</td>
									<td><a class="text-danger text-center remove-row" data-name="deduction"><i class="ti-trash"></i></a></td>
								</tr>
							<?php } ?>
							<tr>
								<td colspan="3" class="p-1 text-right"><a class="btn btn-primary btn-sm add-row" data-name="deduction"><i class="ti-plus"></i> Add</a></td>
							</tr>
						</tbody>
					</table>
				</div>
				<div class="col-md-4"></div>
				<div class="col-md-8">
					<table class="table table-bordered table-middle">
						<thead>
							<tr>
								<td colspan="2" class="pt-2 pb-2"><label>Total Salary Details</label></td>
							</tr>
							<tr>
								<td>Gross Salary</td>
								<td><input type="text" name="salary[gross_salary]" class="form-control mb-0 gross-salary" value="<?php echo $result['gross_salary']; ?>" readonly></td>
							</tr>
							<tr>
								<td>Total Deduction</td>
								<td>
									<input type="text" name="salary[total_deduction]" class="form-control mb-0 total-deduction" value="<?php echo $result['total_deduction']; ?>" readonly>
								</td>
							</tr>
							<tr>
								<td>Net Salary</td>
								<td><input type="text" name="salary[net_salary]" class="form-control mb-0 net-salary" value="<?php echo $result['net_salary']; ?>" readonly></td>
							</tr>
						</thead>
					</table>
				</div>
			</div>
		</div>
		<input type="hidden" name="salary[id]" value="<?php echo $result['id'];?>">
		<div class="panel-footer text-center">
			<button type="submit" name="submit" class="btn btn-primary salarytemplate-submit"><i class="ti-save-alt pr-2"></i> Save</button>
		</div>
	</div>
</form>

<script>
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

	function updateSalarytemplateTotal() {
		var allownces = 0, deductions = 0,
		basic_salary = 0, gross_salary = 0, net_salary = 0;
		if ($('.basic-salary').val() != "") {
			basic_salary = parseFloat($('.basic-salary').val());
		}
		$('.allowance-container .allowance').each(function() {
			ele = $(this);
			if (ele.val() != "") {
				allownces = allownces + parseFloat(ele.val());
			}
		});
		$('.deduction-container .deduction').each(function() {
			ele = $(this);
			if (ele.val() != "") {
				deductions = deductions + parseFloat(ele.val());
			}
		});

		gross_salary = basic_salary + allownces;
		net_salary = gross_salary - deductions;

		$('.gross-salary').val(roundNumber(gross_salary, 2));
		$('.net-salary').val(roundNumber(net_salary, 2));
		$('.total-deduction').val(roundNumber(deductions, 2));
		$('.total-allowance').val(roundNumber(allownces, 2));
	}

	$(document).ready(function() {
		$('body').on('blur', '.basic-salary', function () {
			var ele = $(this), value = ele.val();
			if (checkInputValue(value, ele, 'Basic Salary')) {
				updateSalarytemplateTotal();
			}
		});

		$('.deduction-container').on('blur', '.deduction', function () {
			var ele = $(this), value = ele.val();
			if (checkInputValue(value, ele, 'Deduction')) {
				updateSalarytemplateTotal();
			}
		});

		$('.allowance-container').on('blur', '.allowance', function () {
			var ele = $(this), value = ele.val();
			if (checkInputValue(value, ele, 'Allowance')) {
				updateSalarytemplateTotal();
			}
		});

		$('.allowance-container, .deduction-container').on('click', '.add-row', function () {
			var ele = $(this), ele_parent = ele.parents('table.table'), name = ele.data('name'),
			count = 0;
			if(ele_parent.find(".item-row").length !== 0) {
				count = ele_parent.find('tr.item-row:last input').attr('name').split('[')[2];
				count = parseInt(count.split(']')[0]) + 1;   
			}
			ele_parent.find('.remove-row').show();
			var item_html = '<tr class="item-row">'+
			'<td><input type="text" name="salary['+name+']['+count+'][label]" class="form-control mb-0" placeholder="Enter Label"></td>'+
			'<td><input type="text" name="salary['+name+']['+count+'][value]" class="form-control mb-0 '+name+'" placeholder="Enter Value"><span class="invalid-feedback"></span></td>'+
			'<td><a class="text-danger text-center remove-row" data-name="'+name+'"><i class="ti-trash"></i></a></td>'+
			'</tr>';
			ele_parent.find(".item-row:last").after(item_html);
		});

		$('.allowance-container, .deduction-container').on('click', '.remove-row', function () {
			var ele = $(this), ele_parent = ele.parents('table.table'), name = ele.data('name'),
			count = ele_parent.find('tr.item-row').length;

			if (ele_parent.find('tr.item-row').length > 1) {
				ele.parents('tr.item-row').remove();
			}

			if (count <= 2) {
				ele_parent.find('.remove-row').hide();
			}
			updateSalarytemplateTotal();
		});

		$('.panel .panel-footer').on('click', '.salarytemplate-submit', function () {
			updateSalarytemplateTotal();
		});
	});
</script>
<!-- Footer -->
<?php include (DIR_ADMIN.'app/views/common/footer.tpl.php'); ?>