<?php include (DIR_ADMIN.'app/views/common/header.tpl.php'); ?>
<div class="page-title">
	<div class="row align-items-center">
		<div class="col-sm-6">
			<h2 class="page-title-text d-inline-block"><?php echo $page_title; ?></h2>
			<div class="breadcrumbs d-inline-block">
				<ul>
					<li><a href="<?php echo URL_ADMIN; ?>">Dashboard</a></li>
					<li><a href="<?php echo URL_ADMIN.DIR_ROUTE.'managesalary'; ?>">Manage Salary</a></li>
					<li><?php echo $page_title; ?></li>
				</ul>
			</div>
		</div>
		<div class="col-sm-6 text-right"></div>
	</div>
</div>

<div class="row">
	<div class="col-md-4">
		<div class="panel panel-default">
			<div class="panel-body">
				<div class="user-avtar">
					<?php if (!empty($result['picture']) && file_exists(DIR.'public/uploads/'.$result['picture'])) { ?>
						<img class="img-fluid img-thumbnail" src="<?php echo URL.'public/uploads/'.$result['picture']; ?>">
					<?php } else { ?>
						<span><?php echo $result['firstname'][0]; ?></span>
					<?php } ?>
				</div>
				<div class="user-details pt-2  pb-2 text-center">
					<h2 class="font-20"><?php echo $result['firstname'].' '.$result['lastname']; ?></h2>
				</div>
				<div class="table-responsive">
					<table class="table table-striped">
						<tbody>
							<tr>
								<td>Email Address</td>
								<td><?php echo $result['email']; ?></td>
							</tr>
							<tr>
								<td>Mobile No.</td>
								<td><?php echo $result['mobile']; ?></td>
							</tr>
							<tr>
								<td>Gender</td>
								<td><?php echo $result['gender']; ?></td>
							</tr>
							<tr>
								<td>Bloodgroup</td>
								<td><?php echo $result['bloodgroup']; ?></td>
							</tr>
							<tr>
								<td>DOB</td>
								<td><?php if(!empty($result['dob'])) { echo date_format(date_create($result['dob']), $common['info']['date_format']); } ?></td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
	<div class="col-md-8">
		<div class="panel panel-default"> 
			<div class="panel-body">
				<table class="table table-middle table-bordered table-striped datatable-table">
					<thead>
						<tr>
							<th>#</th>
							<th>Month</th>
							<th>Date</th>
							<th>Net Salary</th>
							<th>Payment Amount</th>
							<?php if ($page_delete || $page_view) { ?>
								<th></th>
							<?php } ?>
						</tr>
					</thead>
					<tbody>
						<?php if (!empty($history)) { foreach ($history as $key => $value) { ?>
							<tr>
								<td><?php echo $key+1; ?></td>
								<td><?php echo date_format(date_create($value['month_year']), $common['info']['date_my_format']); ?></td>
								<td><?php echo date_format(date_create($value['date_of_joining']), $common['info']['date_format']); ?></td>
								<td><?php echo $common['info']['currency_abbr'].$value['net_salary'];?></td>
								<td><?php echo $common['info']['currency_abbr'].$value['amount'];?></td>
								<?php if ($page_delete || $page_view) { ?>
									<td class="table-action">
										<?php if ($page_view) { ?>
											<a href="<?php echo URL_ADMIN.DIR_ROUTE.'managesalary/history/view&id='.$value['id'];?>" class="text-info edit" data-toggle="tooltip" title="View"><i class="ti-layout-media-center-alt"></i></a>
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
</div>
<?php if ($page_delete) { include DIR_VIEW.'common/delete_modal.tpl.php'; }
include (DIR_ADMIN.'app/views/common/footer.tpl.php'); ?>