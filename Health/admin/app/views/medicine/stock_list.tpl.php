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
			<a href="<?php echo URL_ADMIN.DIR_ROUTE.'medicine/stock&type=live'; ?>" class="btn btn-white btn-sm mr-2"><i class="ti-calendar text-success mr-2"></i> Live Stock</a>
			<div class="dropdown d-inline-block mr-2">
				<a class="btn btn-white btn-sm dropdown-toggle" data-toggle="dropdown"><i class="ti-calendar text-danger pr-2"></i> Expire Stock</a>
				<ul class="dropdown-menu dropdown-menu-right export-button">
					<li><a href="<?php echo URL_ADMIN.DIR_ROUTE.'medicine/stock&type=expired'; ?>">Expired</a></li>
					<li><a href="<?php echo URL_ADMIN.DIR_ROUTE.'medicine/stock&type=willexpirein1'; ?>">Expire in 1 month</a></li>
					<li><a href="<?php echo URL_ADMIN.DIR_ROUTE.'medicine/stock&type=willexpirein2'; ?>">Expire in 2 month</a></li>
					<li><a href="<?php echo URL_ADMIN.DIR_ROUTE.'medicine/stock&type=willexpirein3'; ?>">Expire in 3 month</a></li>
					<li><a href="<?php echo URL_ADMIN.DIR_ROUTE.'medicine/stock&type=willexpirein6'; ?>">Expire in 6 month</a></li>
				</ul>
			</div>
		</div>
	</div>
</div>

<div class="panel panel-default">
	<div class="panel-body">
		<div class="table-responsive stock-table">
			<table class="table table-middle table-bordered table-striped datatable-table">
				<thead>
					<tr>
						<th>#</th>
						<th>Name</th>
						<th>Batch</th>
						<th>Expiry</th>
						<th>Purchase Price</th>
						<th>Sale Price</th>
						<th>Qty</th>
						<th>Sold</th>
						<th>Available</th>
						<?php if ($page_purchase_view || page_purchase_edit || $page_edit || $page_delete) { ?>
							<th></th>
						<?php } ?>
					</tr>
				</thead>
				<tbody>
					<?php if (!empty($result)) { foreach ($result as $key => $value) { ?>
						<tr>
							<td><?php echo $key+1; ?></td>
							<td class="text-primary medicine"><?php echo $value['name'];?></td>
							<td class="batch"><?php echo $value['batch']; ?></td>
							<td class="expiry text-danger"><?php echo date_format(date_create($value['expiry']), $common['info']['date_my_format']); ?></td>
							<td class="purchase"><?php echo $common['info']['currency_abbr'].$value['purchaseprice']; ?></td>
							<td class="sale"><?php echo $common['info']['currency_abbr'].$value['saleprice'];?></td>
							<td class="qty"><?php echo $value['qty'];?></td>
							<td class="sold"><?php echo $value['sold']; ?></td>
							<td class="available"><?php echo $value['qty']-$value['sold']; ?></td>
							<?php if ($page_purchase_view || page_purchase_edit || $page_edit || $page_delete) { ?>
								<td class="table-action">
									<?php if ($page_edit || $page_purchase_view || $page_purchase_edit) { ?>
										<div class="dropdown d-inline-block">
											<a class="text-primary edit dropdown-toggle" data-toggle="dropdown"><i class="ti-more"></i></a>
											<ul class="dropdown-menu dropdown-menu-right export-button">
												<?php if ($page_edit) { ?>
													<li><a class="edit-stock" data-id="<?php echo $value['id']; ?>" data-medicineid="<?php echo $value['medicine_id']; ?>"><i class="ti-dashboard pr-2"></i>Update Stock</a></li>
												<?php } if ($page_purchase_view) { ?>
													<li><a href="<?php echo URL_ADMIN.DIR_ROUTE.'medicine/purchase/view&id='.$value['purchase_id'];?>"><i class="ti-layout-media-center-alt pr-2"></i>Purchase View</a></li>
												<?php } if ($page_purchase_edit) { ?>
													<li><a href="<?php echo URL_ADMIN.DIR_ROUTE.'medicine/purchase/edit&id='.$value['purchase_id'];?>"><i class="ti-pencil-alt pr-2"></i>Purchase Edit</a></li>	
												<?php } ?>
											</ul>
										</div>
									<?php } if ($page_delete) { ?>
										<a class="table-delete text-danger delete" data-toggle="tooltip" title="Remove from Inventory">
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
						<label>Available in Store <span class="form-required">*</span></label>
						<div class="input-group">
							<div class="input-group-prepend"><span class="input-group-text"><i class="ti-tag"></i></span></div>
							<input type="text" name="available" class="form-control" required>
						</div>
						<span class="form-text">Sold quantity will be updated => Sold = Total - Available in store. <br>If you want to change qunatity or other info please click on edit link.</span>
					</div>
					<table class="table table-bordered table-striped">
						<thead>
							<tr>
								<th>Medicine</th>
								<th>Batch</th>
								<th>Expiry</th>
								<th>Qty</th>
								<th>Sold</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td class="medicine">Combiflam</td>
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
		$('.stock-table').on('click', '.edit-stock', function () {
			var ele = $(this), ele_parent = ele.parents('tr'),
			data = ele.data();
			$('#editstock-modal input[name="available"]').val(ele_parent.find('.available').text());
			$('#editstock-modal input[name="id"]').val(data.id);
			$('#editstock-modal input[name="medicine_id"]').val(data.medicineid);
			$('#editstock-modal .medicine').html(ele_parent.find('.medicine').text());
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
<?php
if ($page_delete) { include DIR_VIEW.'common/delete_modal.tpl.php'; }
include (DIR_ADMIN.'app/views/common/footer.tpl.php'); 
?>