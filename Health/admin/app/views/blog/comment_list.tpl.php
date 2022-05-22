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
						<th>Person Info</th>
						<th>Comment</th>
						<th>Status</th>
						<th>Created Date</th>
						<?php if ($page_delete || $page_edit) { ?>
							<th></th>
						<?php } ?>
					</tr>
				</thead>
				<tbody>
					<?php if (!empty($result)) { foreach ($result as $key => $value) { ?>
						<tr>
							<td><?php echo $key+1; ?></td>
							<td>
								<p class="m-0 text-primary"><?php echo $value['author'];?></p>
								<p class="m-0"><?php echo $value['email'];?></p>
								<p class="m-0"><?php echo $value['author_ip'];?></p>
							</td>
							<td>
								<p class="m-0"><?php echo $value['content']; ?></p>
								<p class="m-0 text-secondary">Posted On - <?php echo $value['title']; ?></p>
							</td>
							<td>
								<?php if ($value['status'] == '0') { ?>
									<span class="badge badge-sm badge-warning badge-pill">Unapproved</span>
								<?php  } else { ?>
									<span class="badge badge-sm badge-success badge-pill">Approved</span>
								<?php } ?>
							</td>
							<td><?php echo date_format(date_create($value['date_of_joining']), $common['info']['date_format']); ?></td>
							<?php if ($page_delete || $page_edit) { ?>
								<td class="table-action">
									<?php if ($page_edit) { ?>
										<a href="<?php echo URL_ADMIN.DIR_ROUTE.'comment/edit&id='.$value['id'];?>" class="text-primary edit" data-toggle="tooltip" title="Edit"><i class="ti-pencil-alt"></i></a>
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
<?php if ($page_delete) { include DIR_VIEW.'common/delete_modal.tpl.php'; }
include (DIR_ADMIN.'app/views/common/footer.tpl.php'); 
?>