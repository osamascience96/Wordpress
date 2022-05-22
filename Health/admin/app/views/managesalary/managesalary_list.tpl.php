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
			<div class="dropdown d-inline-block m-2">
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
						<th>User Info</th>
						<th>User Role</th>
						<th>Salary Grade</th>
						<th>Status</th>
						<?php if ($page_view || $page_edit || $page_add || $page_history) { ?>
							<th></th>
						<?php } ?>
					</tr>
				</thead>
				<tbody>
					<?php if (!empty($result)) { foreach ($result as $key => $value) { ?>
						<tr>
							<td><?php echo $key+1; ?></td>
							<td>
								<p class="text-primary m-0"><?php echo $value['name'];?></p>
								<p class="m-0"><?php echo $value['email'];?></p>
							</td>
							<td><?php echo $value['role']; ?></td>
							<td><?php echo $value['grade']; ?></td>
							<td>
								<?php if ($value['status'] == "1") { ?>
									<span class="label label-success">Active</span>
								<?php } else { ?>
									<span class="label label-danger">inactive</span>
								<?php } ?>
							</td>
							<?php if ($page_view || $page_edit || $page_add || $page_history) { ?>
								<td class="table-action">
									<?php if (!empty($value['salarytemplate_id'])) { if ($page_view || $page_edit) { ?>
										<div class="dropdown d-inline-block">
											<a class="text-primary edit dropdown-toggle" data-toggle="dropdown"><i class="ti-more"></i></a>
											<ul class="dropdown-menu dropdown-menu-right export-button">
												<?php if ($page_view) { ?>
													<li><a href="<?php echo URL_ADMIN.DIR_ROUTE.'managesalary/view&id='.$value['user_id'];?>"><i class="ti-layout-media-center-alt pr-2"></i>View</a></li>
												<?php } if ($page_edit) { ?>
													<li><a href="<?php echo URL_ADMIN.DIR_ROUTE.'managesalary/edit&id='.$value['user_id'];?>"><i class="ti-pencil-alt pr-2"></i>Edit</a></li>
												<?php } if ($page_history) { ?>
													<li><a href="<?php echo URL_ADMIN.DIR_ROUTE.'managesalary/history&id='.$value['user_id'];?>"><i class="ti-timer pr-2"></i>Payment History</a></li>
												<?php } ?>
											</ul>
										</div>
									<?php } } else { ?>
										<a href="<?php echo URL_ADMIN.DIR_ROUTE.'managesalary/add&id='.$value['user_id'];?>" data-toggle="tooltip" title="Add Salary Template"><i class="ti-plus text-primary"></i></a>
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

<!-- Footer -->
<?php include (DIR_ADMIN.'app/views/common/footer.tpl.php'); ?>