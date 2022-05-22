<?php include (DIR_ADMIN.'app/views/common/header.tpl.php'); ?>

<div class="page-title">
	<div class="row align-items-center">
		<div class="col-sm-8">
			<h2 class="page-title-text d-inline-block"><?php echo $page_title; ?></h2>
			<div class="breadcrumbs d-inline-block">
				<ul>
					<li><a href="<?php echo URL_ADMIN; ?>">Dashboard</a></li>
					<li><a href="<?php echo URL_ADMIN.DIR_ROUTE.'medicines'; ?>">Medicines</a></li>
					<li><?php echo $page_title; ?></li>
				</ul>
			</div>
		</div>
		<div class="col-sm-4 text-right"></div>
	</div>
</div>

<div class="row">
	<div class="col-lg-4">
		<div class="panel panel-default">
			<div class="panel-body">
				<div class="user-avtar">
					<span><?php echo $result['name'][0]; ?></span>
				</div>
				<div class="user-details text-center pt-3">
					<h3><?php echo $result['name']; ?></h3>
					<ul class="v-menu text-left pt-3 nav d-block">
						<li><a href="#medicine-info" class="active" data-toggle="tab"><i class="ti-info-alt"></i> <span>Medicine Info</span></a></li>
						<li><a href="#medicine-stock" data-toggle="tab"><i class="ti-archive"></i> <span>Live Stock</span></a></li>
						<li><a href="#medicine-badstock" data-toggle="tab"><i class="ti-files"></i> <span>Bad Stock</span></a></li>
						<?php if ($page_edit) { ?>
							<li><a href="<?php echo URL_ADMIN.DIR_ROUTE.'medicine/edit&id='.$result['id']; ?>"><i class="ti-pencil-alt"></i> <span>Edit</span></a></li>
						<?php } ?>
					</ul>
				</div>
			</div>
		</div>
	</div>
	<div class="col-lg-8">
		<div class="tab-content">
			<div class="tab-pane fade show active" id="medicine-info">
				<div class="panel panel-default">
					<div class="panel-head">
						<div class="panel-title">Medicine Info</div>
					</div>
					<div class="panel-body">
						<div class="table-responsive">
							<table class="table table-striped patient-table">
								<tbody>
									<tr>
										<td>Medicine Name</td>
										<td><?php echo $result['name']; ?></td>
									</tr>
									<tr>
										<td>company</td>
										<td><?php echo $result['company']; ?></td>
									</tr>
									<tr>
										<td>generic</td>
										<td><?php echo $result['generic']; ?></td>
									</tr>
									<tr>
										<td>unit</td>
										<td><?php echo $result['unit']; ?></td>
									</tr>
									<tr>
										<td>unitpacking</td>
										<td><?php echo $result['unitpacking']; ?></td>
									</tr>
									<tr>
										<td>medicine_group</td>
										<td><?php echo $result['medicine_group']; ?></td>
									</tr>
									<tr>
										<td>category</td>
										<td><?php echo $result['category_name']; ?></td>
									</tr>
									<tr>
										<td>storebox</td>
										<td><?php echo $result['storebox']; ?></td>
									</tr>
									<tr>
										<td>minlevel</td>
										<td><?php echo $result['minlevel']; ?></td>
									</tr>
									<tr>
										<td>reorderlevel</td>
										<td><?php echo $result['reorderlevel']; ?></td>
									</tr>
									<tr>
										<td>note</td>
										<td><?php echo $result['note']; ?></td>
									</tr>
									<tr>
										<td>Created Date</td>
										<td><?php echo $result['date_of_joining']; ?></td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
			<div class="tab-pane fade" id="medicine-stock">
				<div class="panel panel-default">
					<div class="panel-head">
						<div class="panel-title">Live Stock</div>
					</div>
					<div class="panel-body">
						<div class="table-responsive stock-table">
							<table class="table table-middle table-bordered table-striped livestock-table">
								<thead>
									<tr>
										<th>#</th>
										<th>Batch</th>
										<th>Expiry</th>
										<th>Purchase Price</th>
										<th>Sale Price</th>
										<th>Qty</th>
										<th>Sold</th>
										<th>Live Stock</th>
										<?php if ($page_purchase_view || $page_purchase_edit || $page_edit_stock || $page_delete_stock) { ?>
											<th></th>
										<?php } ?>
									</tr>
								</thead>
								<tbody>
									<?php if (!empty($livestock)) { foreach ($livestock as $key => $value) { ?>
										<tr>
											<td><?php echo $key+1; ?></td>
											<td class="batch text-primary"><?php echo $value['batch']; ?></td>
											<td class="expiry text-danger"><?php echo date_format(date_create($value['expiry']), $common['info']['date_my_format']); ?></td>
											<td><?php echo $common['info']['currency_abbr'].$value['purchaseprice']; ?></td>
											<td><?php echo $common['info']['currency_abbr'].$value['saleprice']; ?></td>
											<td class="qty"><?php echo $value['qty']; ?></td>
											<td class="sold"><?php echo $value['sold']; ?></td>
											<td class="available"><?php echo $value['qty']-$value['sold']; ?></td>
											<?php if ($page_purchase_view || $page_purchase_edit || $page_edit_stock || $page_delete_stock) { ?>
												<td class="table-action">
													<?php if ($page_purchase_view || $page_purchase_edit || $page_edit_stock) { ?>
														<div class="dropdown d-inline-block">
															<a class="text-primary edit dropdown-toggle" data-toggle="dropdown"><i class="ti-more"></i></a>
															<ul class="dropdown-menu dropdown-menu-right export-button">
																<?php if ($page_edit_stock) { ?>
																	<li><a class="edit-stock" data-id="<?php echo $value['id']; ?>" data-medicineid="<?php echo $value['medicine_id']; ?>"><i class="ti-dashboard pr-2"></i>Update Stock</a></li>
																<?php } if ($page_purchase_view) { ?>
																	<li><a href="<?php echo URL_ADMIN.DIR_ROUTE.'medicine/purchase/view&id='.$value['purchase_id'];?>"><i class="ti-layout-media-center-alt pr-2"></i>Purchase View</a></li>
																<?php } if ($page_purchase_edit) { ?>
																	<li><a href="<?php echo URL_ADMIN.DIR_ROUTE.'medicine/purchase/edit&id='.$value['purchase_id'];?>"><i class="ti-pencil-alt pr-2"></i>Purchase Edit</a></li>	
																<?php } ?>
															</ul>
														</div>
													<?php } if ($page_delete_stock) { ?>
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
										<th></th>
										<?php if ($page_purchase_view || $page_purchase_edit || $page_edit_stock || $page_delete_stock) { ?>
											<th></th>
										<?php } ?>
									</tr>
								</tfoot>
							</table>
						</div>
					</div>
				</div>
			</div>
			<div class="tab-pane fade" id="medicine-badstock">
				<div class="panel panel-default">
					<div class="panel-head">
						<div class="panel-title">Bad Stock</div>
					</div>
					<div class="panel-body">
						<div class="table-responsive stock-table">
							<table class="table table-middle table-bordered table-striped badstock-table">
								<thead>
									<tr>
										<th>#</th>
										<th>Batch</th>
										<th>Expiry</th>
										<th>Purchase Price</th>
										<th>Sale Price</th>
										<th>Qty</th>
										<th>Sold</th>
										<?php if ($page_delete_stock) { ?>
											<th></th>
										<?php } ?>
									</tr>
								</thead>
								<tbody>
									<?php if (!empty($badstock)) { foreach ($badstock as $key => $value) { ?>
										<tr>
											<td><?php echo $key+1; ?></td>
											<td class="text-primary"><?php echo $value['batch']; ?></td>
											<td class="text-danger"><?php echo date_format(date_create($value['expiry']), $common['info']['date_my_format']); ?></td>
											<td><?php echo $common['info']['currency_abbr'].$value['purchaseprice']; ?></td>
											<td><?php echo $common['info']['currency_abbr'].$value['saleprice']; ?></td>
											<td><?php echo $value['qty']; ?></td>
											<td><?php echo $value['sold']; ?></td>
											<?php if ($page_delete_stock) { ?>
												<td class="table-action">
													<?php if ($page_delete_stock) { ?>
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
										<?php if ($page_purchase_view || $page_purchase_edit || $page_edit_stock || $page_delete_stock) { ?>
											<th></th>
										<?php } ?>
									</tr>
								</tfoot>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="editstock-modal">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Stock Adjustment</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form action="<?php echo $action; ?>" method="post">
				<input type="hidden" name="_token" value="<?php echo $common['token']; ?>">
				<input type="hidden" name="id" value="">
				<input type="hidden" name="medicine_id" value="">
				<div class="modal-body">
					<div class="form-group">
						<label>Available in Store<span class="form-required">*</span></label>
						<div class="input-group">
							<div class="input-group-prepend"><span class="input-group-text"><i class="ti-tag"></i></span></div>
							<input type="text" name="available" class="form-control" required>
						</div>
						<span class="form-text">Sold quantity will be updated => Sold = Total - Available in store. <br>If you want to change qunatity or other info please click on edit link.</span>
					</div>
					<table class="table table-bordered table-striped">
						<thead>
							<tr>
								<th>Batch</th>
								<th>Expiry</th>
								<th>Qty</th>
								<th>Sold</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td class="batch">Batch</td>
								<td class="expiry">Expiry</td>
								<td class="qty">Qty</td>
								<td class="sold">Sold</td>
							</tr>
						</tbody>
					</table>
				</div>
				<div class="modal-footer">
					<button type="submit" name="submit" class="btn btn-primary">Update Stock</button>
				</div>
			</form>
		</div>
	</div>
</div>

<script>
	$(document).ready(function () {
		"use strict";
		$('.livestock-table').DataTable({
			aLengthMenu: [[10, 25, 50, 75, -1], [10, 25, 50, 75, "All"]],
			iDisplayLength: 10,
			pagingType: 'full_numbers',
			order: [],
			dom: "<'row align-items-center pb-3'<'col-sm-6 text-left'l><'col-sm-6 text-right'f>><'row'<'col-sm-12'tr>><'row align-items-center pt-3'<'col-sm-12 col-md-4'i><'col-sm-12 col-md-8 text-right dataTables_pager'p>>",
			responsive: true,
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
					return typeof i === 'string' ?
					i.replace(/[\$,]/g, '')*1 :
					typeof i === 'number' ?
					i : 0;
				};
				var column3 = api.column(3).data().reduce( function (a, b) {
					return intVal(a) + intVal(b);
				}, 0 );
				$( api.column(3).footer() ).html('<?php echo $common['info']['currency_abbr']; ?>'+column3);
				
				var column4 = api.column(4).data().reduce( function (a, b) {
					return intVal(a) + intVal(b);
				}, 0 );
				$( api.column(4).footer() ).html('<?php echo $common['info']['currency_abbr']; ?>'+column4);
				
				var column5 = api.column(5).data().reduce( function (a, b) {
					return intVal(a) + intVal(b);
				}, 0 );
				$( api.column(5).footer() ).html(column5);
				
				var column6 = api.column(6).data().reduce( function (a, b) {
					return intVal(a) + intVal(b);
				}, 0 );
				$( api.column(6).footer() ).html(column6);
				
				var column7 = api.column(7).data().reduce( function (a, b) {
					return intVal(a) + intVal(b);
				}, 0 );
				$( api.column(7).footer() ).html(column7);
			}
		});
		$('.badstock-table').DataTable({
			aLengthMenu: [[10, 25, 50, 75, -1], [10, 25, 50, 75, "All"]],
			iDisplayLength: 10,
			pagingType: 'full_numbers',
			order: [],
			dom: "<'row align-items-center pb-3'<'col-sm-6 text-left'l><'col-sm-6 text-right'f>><'row'<'col-sm-12'tr>><'row align-items-center pt-3'<'col-sm-12 col-md-4'i><'col-sm-12 col-md-8 text-right dataTables_pager'p>>",
			responsive: true,
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
					return typeof i === 'string' ?
					i.replace(/[\$,]/g, '')*1 :
					typeof i === 'number' ?
					i : 0;
				};
				var column3 = api.column(3).data().reduce( function (a, b) {
					return intVal(a) + intVal(b);
				}, 0 );
				$( api.column(3).footer() ).html('<?php echo $common['info']['currency_abbr']; ?>'+column3);
				
				var column4 = api.column(4).data().reduce( function (a, b) {
					return intVal(a) + intVal(b);
				}, 0 );
				$( api.column(4).footer() ).html('<?php echo $common['info']['currency_abbr']; ?>'+column4);
				
				var column5 = api.column(5).data().reduce( function (a, b) {
					return intVal(a) + intVal(b);
				}, 0 );
				$( api.column(5).footer() ).html(column5);
				
				var column6 = api.column(6).data().reduce( function (a, b) {
					return intVal(a) + intVal(b);
				}, 0 );
				$( api.column(6).footer() ).html(column6);
			}
		});

		$('.stock-table').on('click', '.edit-stock', function () {
			var ele = $(this), ele_parent = ele.parents('tr'),
			data = ele.data();
			$('#editstock-modal input[name="available"]').val(ele_parent.find('.available').text());
			$('#editstock-modal input[name="id"]').val(data.id);
			$('#editstock-modal input[name="medicine_id"]').val(data.medicineid);
			$('#editstock-modal .batch').html(ele_parent.find('.batch').text());
			$('#editstock-modal .expiry').html(ele_parent.find('.expiry').text());
			$('#editstock-modal .qty').html(ele_parent.find('.qty').text());
			$('#editstock-modal .sold').html(ele_parent.find('.sold').text());
			$('#editstock-modal').modal('show');
		});
		$('#editstock-modal').on('hidden.bs.modal', function (e) {
			$('#editstock-modal input').not( "[name='_token']" ).val('');
		})
	});
</script>
<?php if ($page_delete) { include DIR_VIEW.'common/delete_modal.tpl.php'; } include (DIR_ADMIN.'app/views/common/footer.tpl.php'); ?>