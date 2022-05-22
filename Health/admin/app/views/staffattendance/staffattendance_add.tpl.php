<?php include (DIR_ADMIN.'app/views/common/header.tpl.php'); ?>
<div class="page-title">
	<div class="row align-items-center">
		<div class="col-sm-6">
			<h2 class="page-title-text d-inline-block"><?php echo $page_title; ?></h2>
			<div class="breadcrumbs d-inline-block">
				<ul>
					<li><a href="<?php echo URL_ADMIN; ?>">Dashboard</a></li>
					<li><a href="<?php echo URL_ADMIN.DIR_ROUTE.'staffattendance'; ?>">Attendance</a></li>
					<li><?php echo $page_title; ?></li>
				</ul>
			</div>
		</div>
		<div class="col-sm-6 text-right"></div>
	</div>
</div>

<form action="<?php echo $action ?>" class="panel panel-default" method="post">
	<div class="panel-body">
		<input type="hidden" name="_token" value="<?php echo $common['token']; ?>">
		<div class="date_pick row">
			<input type="hidden" name="day">
			<input type="hidden" name="month">
			<input type="hidden" name="year">
			<div class="col-md-6">
				<div class="form-group">
					<label>Select Date for Attendence <span class="form-required">*</span></label>
					<input type="text" name="attendence_date" class="form-control bg-white attendence" required autocomplete="off" readonly>
				</div>
			</div>
		</div>
		<div class="table-responsive attendence-container d-none">
			<table class="table table-middle table-bordered table-striped">
				<thead>
					<tr>
						<th>#</th>
						<th>User Info</th>
						<th>User Role</th>
						<th>
							<div class="custom-control custom-checkbox d-inline-block mt-1 mb-1">
								<input type="checkbox" class="custom-control-input attendence-head" id="attendence-head-P" value="P">
								<label class="custom-control-label font-12" for="attendence-head-P">Persent</label>
							</div>
						</th>
						<th>
							<div class="custom-control custom-checkbox d-inline-block mt-1 mb-1">
								<input type="checkbox" class="custom-control-input attendence-head" id="attendence-head-A" value="A">
								<label class="custom-control-label font-12" for="attendence-head-A">Absent</label>
							</div>
						</th>
						<th>
							<div class="custom-control custom-checkbox d-inline-block mt-1 mb-1">
								<input type="checkbox" class="custom-control-input attendence-head" id="attendence-head-L" value="L">
								<label class="custom-control-label font-12" for="attendence-head-L">Late</label>
							</div>
						</th>
						<th>
							<div class="custom-control custom-checkbox d-inline-block mt-1 mb-1">
								<input type="checkbox" class="custom-control-input attendence-head" id="attendence-head-H" value="H">
								<label class="custom-control-label font-12" for="attendence-head-H">Holiday</label>
							</div>
						</th>
						<th>
							<div class="custom-control custom-checkbox d-inline-block mt-1 mb-1">
								<input type="checkbox" class="custom-control-input attendence-head" id="attendence-head-OL" value="OL">
								<label class="custom-control-label font-12" for="attendence-head-OL">OnLeave</label>
							</div>
						</th>
					</tr>
				</thead>
				<tbody>
					<?php if (!empty($result)) { foreach ($result as $key => $value) { ?>
						<tr>
							<td><?php echo $key+1; ?></td>
							<td>
								<p class="mb-0 text-primary"><?php echo $value['name'];?></p>
								<p class="mb-0"><?php echo $value['email'];?></p>
							</td>						
							<td><?php echo $value['role']; ?></td>
							<td>
								<div class="custom-control custom-radio d-inline-block mt-1 mb-1">
									<input type="radio" class="custom-control-input attendence-P" name="attendence[<?php echo $value['user_id']; ?>]" id="<?php echo 'P-'.$value['user_id']; ?>" value="P">
									<label class="custom-control-label font-12" for="<?php echo 'P-'.$value['user_id']; ?>">Persent</label>
								</div>
							</td>
							<td>
								<div class="custom-control custom-radio d-inline-block mt-1 mb-1">
									<input type="radio" class="custom-control-input attendence-A" name="attendence[<?php echo $value['user_id']; ?>]" id="<?php echo 'A-'.$value['user_id']; ?>" value="A">
									<label class="custom-control-label font-12" for="<?php echo 'A-'.$value['user_id']; ?>">Absent</label>
								</div>
							</td>
							<td>
								<div class="custom-control custom-radio d-inline-block mt-1 mb-1">
									<input type="radio" class="custom-control-input attendence-L" name="attendence[<?php echo $value['user_id']; ?>]" id="<?php echo 'L-'.$value['user_id']; ?>" value="L">
									<label class="custom-control-label font-12" for="<?php echo 'L-'.$value['user_id']; ?>">Late</label>
								</div>
							</td>
							<td>
								<div class="custom-control custom-radio d-inline-block mt-1 mb-1">
									<input type="radio" class="custom-control-input attendence-H" name="attendence[<?php echo $value['user_id']; ?>]" id="<?php echo 'H-'.$value['user_id']; ?>" value="H">
									<label class="custom-control-label font-12" for="<?php echo 'H-'.$value['user_id']; ?>">Holiday</label>
								</div>
							</td>
							<td>
								<div class="custom-control custom-radio d-inline-block mt-1 mb-1">
									<input type="radio" class="custom-control-input attendence-OL" name="attendence[<?php echo $value['user_id']; ?>]" id="<?php echo 'OL-'.$value['user_id']; ?>" value="OL">
									<label class="custom-control-label font-12" for="<?php echo 'OL-'.$value['user_id']; ?>">On Leave</label>
								</div>
							</td>
						</tr>
					<?php } } ?>
				</tbody>
			</table>
		</div>
	</div>
	<div class="panel-footer text-center attendence-submit d-none">
		<button type="submit" name="submit" class="btn btn-primary"><i class="ti-save-alt pr-2"></i> Save</button>
	</div>
</form>
<script>
	$('.attendence').datepicker({
		autoclose: true,
		dateFormat: '<?php echo str_replace(['d', 'm', 'Y'], ['dd', 'mm', 'yy'], $common['info']['date_format']); ?>',
		startDate:'01-01-2019',
		endDate:'31-12-2019',
		onSelect: function (dateText, date) {
			if (dateText != '' && typeof dateText !== "undefined") {
				$('.attendence-container').removeClass('d-none');
				$('.date_pick input[name="day"]').val(date.currentDay);
				$('.date_pick input[name="month"]').val(date.currentMonth);
				$('.date_pick input[name="year"]').val(date.currentYear);
				$('.attendence-submit').removeClass('d-none');
			}
		}
	});

	$('.attendence-container').on('change', '.attendence-head', function() {
		var ele = $(this);
		if (ele.prop("checked") === true) {
			$('.attendence-container .attendence-'+ele.val()).prop("checked", true);
		}
		$('.attendence-container .attendence-head').not('#attendence-head-'+ele.val()).prop("checked", false);
	});
</script>

<!-- Footer -->
<?php include (DIR_ADMIN.'app/views/common/footer.tpl.php'); ?>