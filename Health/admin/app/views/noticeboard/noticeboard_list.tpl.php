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
			<?php if ($page_add) { ?>
				<a href="<?php echo URL_ADMIN.DIR_ROUTE.'noticeboard/add'; ?>" class="btn btn-primary btn-sm"><i class="ti-plus pr-2"></i> New Notice</a>
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
						<th>Title</th>
						<th>Description</th>
						<th>StartDate</th>
						<th>EndDate</th>
						<th>Status</th>
						<?php if ($page_edit || $page_view || $page_delete) { ?>
							<th></th>
						<?php } ?>
					</tr>
				</thead>
				<tbody>
					<?php if (!empty($result)) { foreach ($result as $key => $value) { ?>
						<tr>
							<td><?php echo $key+1; ?></td>
							<td class="text-primary"><?php echo $value['title']; ?></td>
							<td><?php echo $value['description']; ?></td>
							<td><?php echo date_format(date_create($value['start_date']), $common['info']['date_format']); ?></td>
							<td><?php echo date_format(date_create($value['end_date']), $common['info']['date_format']); ?></td>
							<td>
								<?php if ($value['status'] == '1') {
									echo '<span class="label label-success">Active</span>';
								} elseif ($value['status'] == '0') {
									echo '<span class="label label-danger">Inactive</span>';
								}?>
							</td>
							<?php if ($page_edit || $page_view || $page_delete) { ?>
								<td class="table-action">
									<?php if ($page_edit || $page_view) { ?>
										<div class="dropdown d-inline-block">
											<a class="text-primary edit dropdown-toggle" data-toggle="dropdown"><i class="ti-more"></i></a>
											<ul class="dropdown-menu dropdown-menu-right export-button">
												<?php if ($page_view) { ?>
													<li><a href="<?php echo URL_ADMIN.DIR_ROUTE.'noticeboard/view&id='.$value['id'];?>"><i class="ti-layout-media-center-alt pr-2"></i>View</a></li>
												<?php } if ($page_edit) { ?>
													<li><a href="<?php echo URL_ADMIN.DIR_ROUTE.'noticeboard/edit&id='.$value['id'];?>"><i class="ti-pencil-alt pr-2"></i>Edit</a></li>
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
<?php
if ($page_delete) { include DIR_VIEW.'common/delete_modal.tpl.php'; }
include (DIR_ADMIN.'app/views/common/footer.tpl.php'); 
?>