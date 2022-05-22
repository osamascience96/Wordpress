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
			<?php if ($page_upload) { ?>
				<a class="btn btn-white btn-sm mr-2" data-toggle="modal" data-target="#uploadmedicine-modal"><i class="ti-cloud-up text-primary pr-2"></i> Import Medicines</a>
			<?php } ?>
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
				<a href="<?php echo URL_ADMIN.DIR_ROUTE.'medicine/add'; ?>" class="btn btn-primary btn-sm"><i class="ti-plus pr-2"></i> New Medicine</a>
			<?php } ?>
		</div>
	</div>
</div>

<div class="panel panel-default">
	<div class="panel-body">
		<div class="table-responsive">
			<table class="table table-middle table-bordered table-striped datatable-table">
				<thead>
					<tr>
						<th>#</th>
						<th>Medicine</th>
						<th>Company</th>
						<th>Unit</th>
						<th>Unit/Packing</th>
						<th>Category</th>
						<th>Storebox</th>
						<th>Reorderlevel</th>
						<th>Live Stock</th>
						<th>Status</th>
						<?php if ($page_view || $page_edit || $page_delete) { ?>
							<th></th>
						<?php } ?>
					</tr>
				</thead>
				<tbody>
					<?php if (!empty($result)) { foreach ($result as $key => $value) { ?>
						<tr>
							<td><?php echo $key+1; ?></td>
							<td>
								<p class="text-primary mb-0"><?php echo $value['name'];?></p>
								<p class="mb-0"><?php echo $value['generic']; ?></p>
							</td>
							<td><?php echo $value['company']; ?></td>
							<th><?php echo $value['unit'];?></th>
							<td><?php echo $value['unitpacking']; ?></td>
							<td><?php echo $value['category_name']; ?></td>
							<td><?php echo $value['storebox'];?></td>
							<td><?php echo $value['reorderlevel'];?></td>
							<td><?php echo $value['livestock'];?></td>
							<td>
								<?php if ($value['minlevel'] >= $value['livestock']) {
									echo '<span class="badge badge-sm badge-danger">Minlevel</span>';
								} elseif ($value['reorderlevel'] >= $value['livestock']) {
									echo '<span class="badge badge-sm badge-warning">Reorderlevel</span>';
								} else {
									echo '<span class="badge badge-sm badge-primary">Normal</span>';
								} ?>
							</td>
							<?php if ($page_view || $page_edit || $page_delete) { ?>
								<td class="table-action">
									<?php if ($page_view || $page_edit) { ?>
										<div class="dropdown d-inline-block">
											<a class="text-primary edit dropdown-toggle" data-toggle="dropdown"><i class="ti-more"></i></a>
											<ul class="dropdown-menu dropdown-menu-right export-button">
												<?php if ($page_view) { ?>
													<li><a href="<?php echo URL_ADMIN.DIR_ROUTE.'medicine/view&id='.$value['id'];?>"><i class="ti-layout-media-center-alt pr-2"></i>View</a></li>
												<?php } if ($page_edit) { ?>
													<li><a href="<?php echo URL_ADMIN.DIR_ROUTE.'medicine/edit&id='.$value['id'];?>"><i class="ti-pencil-alt pr-2"></i>Edit</a></li>	
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

<div class="modal fade" id="uploadmedicine-modal">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Import Medicines</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form action="<?php echo URL_ADMIN.DIR_ROUTE.'medicine/upload'; ?>" method="post" enctype="multipart/form-data">
				<input type="hidden" name="_token" value="<?php echo $common['token']; ?>">
				<div class="modal-body">
					<div class="form-group">
						<label>Medicine Category</label>
						<div class="input-group">
							<div class="input-group-prepend"><span class="input-group-text"><i class="ti-tag"></i></span></div>
							<select name="category" class="custom-select">
								<?php if (!empty($category)) { foreach ($category as $key => $value) { ?>
									<option value="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></option>
								<?php } } ?>
							</select>
						</div>
					</div>
					<div class="form-group mb-0">
						<div class="input-group">
							<div class="custom-file">
								<input type="file" name="medicine" class="custom-file-input m-0" id="medicinefile" accept=".csv" required>
								<label class="custom-file-label" for="medicinefile">Choose file (Only CSV file)</label>
							</div>
							<div class="input-group-append">
								<a href="<?php echo URL_ADMIN.DIR_ROUTE.'medicine/sample' ?>" class="input-group-text">Download Sample</a>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="submit" name="submit" class="btn btn-primary">Upload</button>
				</div>
			</form>
		</div>
	</div>
</div>
<script>
	$(document).ready(function(){

		$("#medicinefile").on('change', function(e) {
			if (e.target.files.length > 0) {
				$(this).siblings('label').text(e.target.files[0].name);
			}
		});
	});

</script>
<?php
if ($page_delete) { include DIR_VIEW.'common/delete_modal.tpl.php'; }
include (DIR_ADMIN.'app/views/common/footer.tpl.php'); 
?>