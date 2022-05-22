<?php include (DIR_ADMIN.'app/views/common/header.tpl.php'); ?>
<div class="page-title">
	<div class="row align-items-center">
		<div class="col-sm-6">
			<h2 class="page-title-text d-inline-block"><?php echo $page_title; ?></h2>
			<div class="breadcrumbs d-inline-block">
				<ul>
					<li><a href="<?php echo URL_ADMIN; ?>">Dashboard</a></li>
					<li><a href="<?php echo URL_ADMIN.DIR_ROUTE.'staffattendance'; ?>">Attendence</a></li>
				</ul>
			</div>
		</div>
		<div class="col-sm-6 text-right">
			<div class="btn btn-white btn-sm text-left mr-2">
				<i class="ti-filter text-danger"></i>
				<input type="text" class="month-range" style="width: 85px;" value="<?php echo date_format(date_create($monthyear), 'M Y') ?>" readonly>
				<input type="hidden" class="range-month" value="<?php echo date_format(date_create($monthyear), 'Y-m') ?>" readonly>
			</div>
			<div class="dropdown d-inline-block">
				<a class="btn btn-white btn-sm dropdown-toggle" data-toggle="dropdown"><i class="ti-download text-primary pr-2"></i> Export</a>
				<ul class="dropdown-menu dropdown-menu-right export-button">
					<li><a href="#" class="pdf"><i class="far fa-file-pdf pr-2"></i>PDF</a></li>
					<li><a href="#" class="excel"><i class="far fa-file-excel pr-2"></i>Excel</a></li>
					<li><a href="#" class="csv"><i class="ti-clipboard pr-2"></i>CSV</a></li>
					<li><a href="#" class="print"><i class="ti-printer pr-2"></i>Print</a></li>
					<li><a href="#" class="copy"><i class="ti-layers pr-2"></i>Copy</a></li>
				</ul>
			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-lg-4">
		<div class="panel panel-default">
			<div class="panel-body">
				<div class="user-avtar d-inline-block align-top">
					<?php if (!empty($staff['picture']) && file_exists(DIR.'public/uploads/'.$staff['picture'])) { ?>
						<img class="img-fluid img-thumbnail" src="<?php echo URL.'public/uploads/'.$staff['picture']; ?>" style="width: 100px">
					<?php } else { ?>
						<span><?php echo $staff['firstname'][0]; ?></span>
					<?php } ?>
				</div>
				<div class="user-details d-inline-block align-top pl-3">
					<h2 class="font-20 m-0"><?php echo $staff['firstname'].' '.$staff['lastname']; ?></h2>
					<p class="m-0 font-12"><?php echo $staff['email']; ?></p>
					<p class="m-0 font-12"><?php echo $staff['mobile']; ?></p>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-6 col-md-3 col-lg-12 col-xl-6">
				<div class="panel panel-default">
					<div class="widget-12">
						<div class="row align-items-center">
							<div class="col-7 text-left">
								<h3 class="text-primary m-0"><?php echo $summary['P']; ?></h3>
								<h6>Present</h6>
							</div>
							<div class="col-5 icon text-right">
								<i class="far fa-calendar-check text-primary"></i>
							</div>
						</div>
						<div class="progress progress-sm mt-1">
							<div class="progress-bar progress-bar-primary" style="width: <?php echo $summary['p_percentage']; ?>%" aria-valuenow="<?php echo $summary['p_percentage']; ?>" aria-valuemin="0" aria-valuemax="100"></div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-sm-6 col-md-3 col-lg-12 col-xl-6">
				<div class="panel panel-default">
					<div class="widget-12">
						<div class="row align-items-center">
							<div class="col-7 text-left">
								<h3 class="text-primary m-0"><?php echo $summary['A']; ?></h3>
								<h6>Absent</h6>
							</div>
							<div class="col-5 icon text-right">
								<i class="far fa-calendar-times text-danger"></i>
							</div>
						</div>
						<div class="progress progress-sm mt-1">
							<div class="progress-bar progress-bar-danger" style="width: <?php echo $summary['a_percentage']; ?>%" aria-valuenow="<?php echo $summary['a_percentage']; ?>" aria-valuemin="0" aria-valuemax="100"></div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-sm-6 col-md-3 col-lg-12 col-xl-6">
				<div class="panel panel-default">
					<div class="widget-12">
						<div class="row align-items-center">
							<div class="col-7 text-left">
								<h3 class="text-warning m-0"><?php echo $summary['L']; ?></h3>
								<h6>Late</h6>
							</div>
							<div class="col-5 icon text-right">
								<i class="far fa-calendar-minus text-warning"></i>
							</div>
						</div>
						<div class="progress progress-sm mt-1">
							<div class="progress-bar progress-bar-warning" style="width: <?php echo $summary['l_percentage']; ?>%" aria-valuenow="<?php echo $summary['l_percentage']; ?>" aria-valuemin="0" aria-valuemax="100"></div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-sm-6 col-md-3 col-lg-12 col-xl-6">
				<div class="panel panel-default">
					<div class="widget-12">
						<div class="row align-items-center">
							<div class="col-7 text-left">
								<h3 class="text-info m-0"><?php echo $summary['H']; ?></h3>
								<h6>Holiday</h6>
							</div>
							<div class="col-5 icon text-right">
								<i class="far fa-calendar text-info"></i>
							</div>
						</div>
						<div class="progress progress-sm mt-1">
							<div class="progress-bar progress-bar-info" style="width: <?php echo $summary['h_percentage']; ?>%" aria-valuenow="<?php echo $summary['h_percentage']; ?>" aria-valuemin="0" aria-valuemax="100"></div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-sm-6 col-md-3 col-lg-12 col-xl-6">
				<div class="panel panel-default">
					<div class="widget-12">
						<div class="row align-items-center">
							<div class="col-7 text-left">
								<h3 class="text-secondary m-0"><?php echo $summary['OL']; ?></h3>
								<h6>On Leave</h6>
							</div>
							<div class="col-5 icon text-right">
								<i class="far fa-calendar-alt text-secondary"></i>
							</div>
						</div>
						<div class="progress progress-sm mt-1">
							<div class="progress-bar progress-bar-secondary" style="width: <?php echo $summary['ol_percentage']; ?>%" aria-valuenow="<?php echo $summary['ol_percentage']; ?>" aria-valuemin="0" aria-valuemax="100"></div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="col-lg-8">
		<div class="panel panel-default">
			<div class="panel-head">
				<div class="panel-title"><?php echo date_format(date_create($monthyear), 'M Y'); ?></div>
			</div>
			<div class="panel-body">
				<table class="table table-bordered table-stripped datatable-table">
					<thead>
						<tr>
							<th>Day</th>
							<th>Attendance</th>
						</tr>
					</thead>
					<tbody>
						<?php if (!empty($result)) { foreach ($result as $key => $value) { ?>
							<tr>
								<td><?php echo date_format(date_create($key), $common['info']['date_format']); ?></td>
								<td>
									<?php if ($value == 'P') {
										echo '<span class="label label-primary">Present</span>';
									} elseif ($value == 'A') {
										echo '<span class="label label-danger">Absent</span>';
									} elseif ($value == 'L') {
										echo '<span class="label label-warning">Late</span>';
									} elseif ($value == 'H') {
										echo '<span class="label label-info">Holiday</span>';
									} elseif ($value == 'OL') {
										echo '<span class="label label-secondary">On Leave</span>';
									} ?>
								</td>
							</tr>
						<?php } } ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
<style>
	.ui-datepicker-calendar {
		display: none;
	}
</style>
<script>
	$(".month-range").datepicker( {
		dateFormat: 'M yy',
		changeMonth: true,
		changeYear: true,
		showButtonPanel: true,
		beforeShow: function(input, inst) {
			inst.dpDiv.css({marginTop: '10px', marginLeft: -input.offsetWidth + 'px'});
		},
		onClose: function(dateText, inst) { 
			var month = (inst.selectedMonth+1);
			month = (month < 10 ? "0"+month : month);
			var date = inst.selectedYear + '-' + month;
			if (date !== $('.range-month').val()) {
				window.location.href = '<?php echo URL_ADMIN.DIR_ROUTE."staffattendance/view&id=".$staff['user_id']; ?>&monthyear='+date;
			}
		}
	});
</script>

<!-- Footer -->
<?php include (DIR_ADMIN.'app/views/common/footer.tpl.php'); ?>