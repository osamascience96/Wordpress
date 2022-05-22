<?php include (DIR_ADMIN.'app/views/common/header.tpl.php'); ?>
<link rel="stylesheet" href="public/css/bootstrap-datetimepicker.min.css">
<script type="text/javascript" src="public/js/bootstrap-datetimepicker.min.js"></script>
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
				<a href="<?php echo URL_ADMIN.DIR_ROUTE.'medicine/billing/add'; ?>" class="btn btn-primary btn-sm"><i class="ti-plus pr-2"></i> New Bill</a>
			<?php } ?>
		</div>
	</div>
</div>

<div class="panel panel-default">
	<div class="panel-body">
		<div class="table-responsive">
			<table class="table table-middle table-bordered table-striped billing-table">
				<thead>
					<tr>
						<th>#</th>
						<th>Name</th>
						<th>Subtotal</th>
						<th>Tax</th>
						<th>Discount</th>
						<th>Amount</th>
						<th>Date</th>
						<?php if ($page_view || $page_edit || $page_delete || $page_pdf) { ?>
							<th></th>
						<?php } ?>
					</tr>
				</thead>
				<tbody>
					<?php if (!empty($result)) { foreach ($result as $key => $value) { ?>
						<tr>
							<td><?php echo $key+1; ?></td>
							<td class="text-primary"><?php echo $value['name'];?></td>
							<td><?php echo $common['info']['currency_abbr'].$value['subtotal']; ?></td>
							<td><?php echo $common['info']['currency_abbr'].$value['tax']; ?></td>
							<th><?php echo $common['info']['currency_abbr'].$value['discount_value'];?></th>
							<td><?php echo $common['info']['currency_abbr'].$value['amount']; ?></td>
							<th><?php echo date_format(date_create($value['date_of_joining']), $common['info']['date_format']); ?></th>
							<?php if ($page_view || $page_edit || $page_delete || $page_pdf) { ?>
								<td class="table-action">
									<?php if ($page_edit || $page_view || $page_pdf) { ?>
										<div class="dropdown d-inline-block">
											<a class="text-primary edit dropdown-toggle" data-toggle="dropdown"><i class="ti-more"></i></a>
											<ul class="dropdown-menu dropdown-menu-right export-button">
												<?php if ($page_view) { ?>
													<li><a href="<?php echo URL_ADMIN.DIR_ROUTE.'medicine/billing/view&id='.$value['id'];?>"><i class="ti-layout-media-center-alt pr-2"></i>View</a></li>
												<?php } if ($page_edit) { ?>
													<li><a href="<?php echo URL_ADMIN.DIR_ROUTE.'medicine/billing/edit&id='.$value['id'];?>"><i class="ti-pencil-alt pr-2"></i>Edit</a></li>
												<?php } if ($page_pdf) { ?>
													<li><a href="<?php echo URL_ADMIN.DIR_ROUTE.'medicine/billing/pdf&id='.$value['id'];?>" target="_blank"><i class="far fa-file-pdf pr-2"></i>PDF</a></li>
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
				<tfoot>
					<tr>
						<th></th>
						<th></th>
						<th></th>
						<th></th>
						<th></th>
						<th></th>
						<th></th>
						<?php if ($page_view || $page_edit || $page_delete || $page_pdf) { ?>
							<th></th>
						<?php } ?>
					</tr>
				</tfoot>
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
				'All Time': [moment('2015-01-01'), moment().add(30, 'days')]
			},
		});

		$('.table-date-range').on('apply.daterangepicker', function(ev, picker) {
			window.location.href = '<?php echo URL_ADMIN.DIR_ROUTE; ?>medicine/billing'+'&start='+picker.startDate.format('YYYY-MM-DD')+'&end='+picker.endDate.format('YYYY-MM-DD');
		});

		var billingTable = $('.billing-table').DataTable({
			aLengthMenu: [[10, 25, 50, 75, -1], [10, 25, 50, 75, "All"]],
			iDisplayLength: 10,
			pagingType: 'full_numbers',
			order: [],
			dom: "<'row align-items-center pb-3'<'col-sm-6 text-left'l><'col-sm-6 text-right'f>><'row'<'col-sm-12'tr>><'row align-items-center pt-3'<'col-sm-12 col-md-4'i><'col-sm-12 col-md-8 text-right dataTables_pager'p>>",
			responsive: false,
			buttons: ["print", "copyHtml5", "excelHtml5", "csvHtml5", "pdfHtml5"],
			language: {
				"paginate": {
					"first":       '<i class="fa fa-angle-double-left"></i>',
					"previous":    '<i class="fa fa-angle-left"></i>',
					"next":        '<i class="fa fa-angle-right"></i>',
					"last":        '<i class="fa fa-angle-double-right"></i>'
				},
			},
			footerCallback: function ( row, data, start, end, display ) {
				var api = this.api(), data;
				var intVal = function ( i ) {
					return typeof i === 'string' ? i.replace(/[\$,]/g, '')*1 : typeof i === 'number' ? i : 0;
				};

				for (var i = row.childElementCount - 1; i >= 0; i--) {
					if (i > 1 && i < 6) {
						column = api.column(i).data().reduce( function (a, b) {
							return intVal(a) + intVal(b);
						}, 0 );
						if ($.isNumeric(column)) {
							$( api.column(i).footer() ).html('<?php echo $common['info']['currency_abbr']; ?>'+column);
						}
					}	
				}
			}
		});

		$(".export-button .print").on("click", function(e) {
			e.preventDefault(); billingTable.button(0).trigger()
		});

		$("export-button .copy").on("click", function(e) {
			e.preventDefault(); billingTable.button(1).trigger()
		});

		$(".export-button .excel").on("click", function(e) {
			e.preventDefault(); billingTable.button(2).trigger()
		});

		$(".export-button .csv").on("click", function(e) {
			e.preventDefault(); billingTable.button(3).trigger()
		});

		$(".export-button .pdf").on("click", function(e) {
			e.preventDefault(); billingTable.button(4).trigger()
		});
	});
</script>

<?php
if ($page_delete) { include DIR_VIEW.'common/delete_modal.tpl.php'; }
include (DIR_ADMIN.'app/views/common/footer.tpl.php'); 
?>