<?php include (DIR_ADMIN.'app/views/common/header.tpl.php'); ?>
<div class="page-title">
	<div class="row align-items-center">
		<div class="col-sm-6">
			<h2 class="page-title-text d-inline-block">Patients</h2>
			<div class="breadcrumbs d-inline-block">
				<ul>
					<li><a href="#">Home</a></li>
					<li>Patients</li>
				</ul>
			</div>
		</div>
		<div class="col-sm-6 text-right">
			<div class="btn btn-white btn-sm text-left mr-2">
				<i class="ti-filter text-danger pr-2"></i>
				<input type="text" class="table-date-range">
			</div>
			<div class="dropdown d-inline-block mr-2">
				<a class="btn btn-white btn-sm dropdown-toggle" data-toggle="dropdown"><i class="ti-download text-primary pr-2"></i> Export</a>
				<ul class="dropdown-menu dropdown-menu-right export-button">
					<li><a href="#" class="pdf"><i class="far fa-file-pdf pr-2"></i> PDF</a></li>
					<li><a href="#" class="excel"><i class="far fa-file-excel pr-2"></i> Excel</a></li>
					<li><a href="#" class="csv"><i class="ti-clipboard pr-2"></i> CSV</a></li>
					<li><a href="#" class="print"><i class="ti-printer pr-2"></i> Print</a></li>
					<li><a href="#" class="copy"><i class="ti-layers pr-2"></i> Copy</a></li>
				</ul>
			</div>
			<?php if ($page_add) { ?>
				<a href="<?php echo URL_ADMIN.DIR_ROUTE.'patient/add'; ?>" class="btn btn-primary btn-sm"><i class="ti-plus pr-2"></i> New Patient</a>
			<?php } ?>
		</div>
	</div>
</div>
<div class="panel panel-default">
	<div class="panel-body">
		<div class="table-responsive">
			<table id="user-table" class="table table-middle table-bordered table-striped datatable-table">
				<thead>
					<tr class="table-heading">
						<th>#</th>
						<th>Patient Info</th>
						<th>Gender</th>
						<th>Bloodgroup</th>
						<th>Date of Birth</th>
						<th>Status</th>
						<th>Created Date</th>
						<?php if ($page_view || $page_edit || $page_delete) { ?>
							<th></th>
						<?php } ?>
					</tr>
				</thead>
				<tbody>
					<?php if (isset($result) && !empty($result)) { foreach ($result as $key => $value) { ?>
						<tr>
							<td><?php echo $key+1; ?></td>
							<td>
								<p class="m-0 text-primary"><?php echo $value['firstname'] .' '. $value['lastname']; ?></p>
								<p class="m-0"><?php echo $value['email']; ?></p>
								<p class="m-0"><?php echo $value['mobile']; ?></p>
							</td>
							<td><?php echo $value['gender']; ?></td>
							<td><?php echo $value['bloodgroup']; ?></td>
							<td><?php if (!empty($value['dob'])) { echo date_format(date_create($value['dob']), $common['info']['date_format']); } ?></td>
							<td>
								<?php if ($value['status'] == '0') { ?>
									<span class="label label-danger">InActive</span>
								<?php  } else { ?>
									<span class="label label-success">Active</span>
								<?php } ?>
							</td>
							<td><?php echo date_format(date_create($value['date_of_joining']), $common['info']['date_format']); ?></td>
							<?php if ($page_view || $page_edit || $page_delete) { ?>
								<td class="table-action">
									<?php if ($page_view || $page_edit) { ?>
										<div class="dropdown d-inline-block">
											<a class="text-primary edit dropdown-toggle" data-toggle="dropdown"><i class="ti-more"></i></a>
											<ul class="dropdown-menu dropdown-menu-right export-button">
												<?php if ($page_view) { ?>
													<li><a href="<?php echo URL_ADMIN.DIR_ROUTE.'patient/view&id='.$value['id'];?>"><i class="ti-layout-media-center-alt pr-2"></i>View</a></li>
												<?php } if ($page_edit) { ?>
													<li><a href="<?php echo URL_ADMIN.DIR_ROUTE.'patient/edit&id='.$value['id'];?>"><i class="ti-pencil-alt pr-2"></i>Edit</a></li>	
												<?php } ?>
											</ul>
										</div>
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
</div>
<script>
	$(document).ready(function () {
		$('.table-date-range').daterangepicker({
			autoApply: false,
			alwaysShowCalendars: true,
			opens: 'left',
			applyButtonClasses: 'btn-danger',
			cancelClass: 'btn-white',
			locale: {
				format: $('.common_daterange_format').val(),
				separator: " => ",
			},
			startDate: "<?php echo date_format(date_create($period['start']), $common['info']['date_format']); ?>",
			endDate: "<?php echo date_format(date_create($period['end']), $common['info']['date_format']); ?>",
			ranges: {
				'Today': [moment(), moment()],
				'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
				'Last 7 Days': [moment().subtract(6, 'days'), moment()],
				'Last 30 Days': [moment().subtract(29, 'days'), moment()],
				'This Month': [moment().startOf('month'), moment().endOf('month')],
				'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
				'This Year': [moment().startOf('year'), moment().endOf('year')],
				'All Time': [moment('2015-01-01'), moment().add(1, 'days')],
			},
		});

		$('.table-date-range').on('apply.daterangepicker', function(ev, picker) {
			window.location.replace('<?php echo URL_ADMIN.DIR_ROUTE; ?>patients'+'&start='+picker.startDate.format('YYYY-MM-DD')+'&end='+picker.endDate.format('YYYY-MM-DD'));
		});
	});
</script>
<?php
if ($page_delete) { include DIR_VIEW.'common/delete_modal.tpl.php'; }
include (DIR_ADMIN.'app/views/common/footer.tpl.php'); 
?>