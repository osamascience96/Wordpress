<?php include (DIR_ADMIN.'app/views/common/header.tpl.php'); ?>
<div class="page-title">
	<div class="row align-items-center">
		<div class="col-sm-6">
			<h2 class="page-title-text d-inline-block"><?php echo $page_title; ?></h2>
			<div class="breadcrumbs d-inline-block">
				<ul>
					<li><a href="<?php echo URL_ADMIN; ?>">Dashboard</a></li>
					<li><?php echo $page_title; ?></li>
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
					<li><a href="#" class="pdf"><i class="far fa-file-pdf pr-2"></i>PDF</a></li>
					<li><a href="#" class="excel"><i class="far fa-file-excel pr-2"></i>Excel</a></li>
					<li><a href="#" class="csv"><i class="ti-clipboard pr-2"></i>CSV</a></li>
					<li><a href="#" class="print"><i class="ti-printer pr-2"></i>Print</a></li>
					<li><a href="#" class="copy"><i class="ti-layers pr-2"></i>Copy</a></li>
				</ul>
			</div>
			<?php if ($page_add) { ?>
				<a href="<?php echo URL_ADMIN.DIR_ROUTE.'prescription/add'; ?>" class="btn btn-primary btn-sm"><i class="ti-plus pr-2"></i> New Prescription</a>
			<?php } ?>
		</div>
	</div>
</div>

<div class="panel panel-default">
	<div class="panel-body">
		<div class="table-responsive" data-name="appointments">
			<table class="table table-middle table-bordered table-striped datatable-table">
				<thead>
					<tr>
						<th>#</th>
						<th>Patient</th>
						<th>Doctor</th>
						<th>Appointment ID</th>
						<?php if ($page_edit || $page_view || $page_delete || $page_pdf) { ?>
							<th></th>
						<?php } ?>
					</tr>
				</thead>
				<tbody>
					<?php if (!empty($result)) { foreach ($result as $key => $value) { ?>
						<tr>
							<td><?php echo $key+1; ?></td>
							<td>
								<a class="m-0 text-primary"><?php echo $value['name'];?></a>
								<p class="m-0"><?php echo $value['email']; ?></p>
							</td>
							<td>Dr. <?php echo $value['doctor']; ?></td>
							<td><?php if (!empty($value['appointment_id'])) { echo $common['info']['appointment_prefix'].str_pad($value['appointment_id'], 5, '0', STR_PAD_LEFT); } ?></td>
							<?php if ($page_edit || $page_view || $page_delete || $page_pdf) { ?>
								<td class="table-action">
									<?php if ($page_edit || $page_view || $page_pdf) { ?>
										<div class="dropdown d-inline-block">
											<a class="text-primary edit dropdown-toggle" data-toggle="dropdown"><i class="ti-more"></i></a>
											<ul class="dropdown-menu dropdown-menu-right export-button">
												<?php if ($page_view) { ?>
													<li><a href="<?php echo URL_ADMIN.DIR_ROUTE.'prescription/view&id='.$value['id'];?>"><i class="ti-layout-media-center-alt pr-2"></i>View</a></li>
												<?php } if ($page_edit) { ?>
													<li><a href="<?php echo URL_ADMIN.DIR_ROUTE.'prescription/edit&id='.$value['id'];?>"><i class="ti-pencil-alt pr-2"></i>Edit</a></li>
												<?php } if ($page_pdf) { ?>
													<li><a href="<?php echo URL_ADMIN.DIR_ROUTE.'prescription/pdf&id='.$value['id'];?>" target="_blank"><i class="ti-pencil-alt pr-2"></i>PDF/Print</a></li>
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
				'Tomorrow': [moment().add(1, 'days'), moment().add(1, 'days')],
				'Last 7 Days': [moment().subtract(6, 'days'), moment()],
				'Last 30 Days': [moment().subtract(29, 'days'), moment()],
				'This Month': [moment().startOf('month'), moment().endOf('month')],
				'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
				'All Time': [moment('2015-01-01'), moment().add(30, 'days')]
			},
		});

		$('.table-date-range').on('apply.daterangepicker', function(ev, picker) {
			window.location.replace('<?php echo URL_ADMIN.DIR_ROUTE; ?>prescriptions'+'&start='+picker.startDate.format('YYYY-MM-DD')+'&end='+picker.endDate.format('YYYY-MM-DD'));
		});
	});
</script>

<?php if ($page_delete) {
	include DIR_VIEW.'common/delete_modal.tpl.php'; 
}
include (DIR_ADMIN.'app/views/common/footer.tpl.php'); ?>