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
		<div class="col-sm-6 text-right">
			<?php if ($page_history) { ?>
				<a href="<?php echo URL_ADMIN.DIR_ROUTE.'managesalary/history&id='.$result['user_id']; ?>" class="btn btn-warning btn-sm"><i class="ti-timer pr-2"></i>Payment History</a>
			<?php } if ($page_edit) { ?>
				<a href="<?php echo URL_ADMIN.DIR_ROUTE.'managesalary/edit&id='.$result['user_id']; ?>" class="btn btn-primary btn-sm mr-2"><i class="ti-pencil-alt mr-2"></i>Edit</a>
			<?php } ?>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-md-4">
		<div class="panel panel-default">
			<div class="panel-body">
				<div class="user-avtar">
					<?php if (!empty($result['picture']) && file_exists(DIR.'public/uploads/'.$result['picture'])) { ?>
						<img class="img-fluid img-thumbnail" src="<?php echo URL.'public/uploads/'.$result['picture']; ?>" style="width: 100px">
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
								<?php if (!empty($result['dob'])) { ?>
									<td><?php echo date_format(date_create($result['dob']), $common['info']['date_format']); ?></td>
								<?php } else { ?>
									<td></td>
								<?php } ?>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
	<div class="col-md-8">
		<div class="panel panel-default"> 
			<div class="panel-head">
				<div class="panel-title">Salary Info</div>
			</div>
			<div class="panel-body">
				<table class="table table-bordered">
					<tbody>
						<tr>
							<td>Salary Grades</td>
							<td><?php echo $salary['grade']; ?></td>
						</tr>
						<tr>
							<td>Basic Salary</td>
							<td><?php echo $common['info']['currency_abbr'].$salary['basic_salary']; ?></td>
						</tr>
					</tbody>
				</table>
				<div class="row">
					<div class="col-md-6">
						<label class="col-form-label mt-3 mb-0">Allowances</label>
						<table class="table table-bordered table-striped">
							<tbody>
								<?php if (!empty($salary['allowance'])) { foreach ($salary['allowance'] as $key => $value) { ?>
									<tr>
										<td><?php echo $value['label']; ?></td>
										<td><?php echo $common['info']['currency_abbr'].$value['value']; ?></td>
									</tr>
								<?php } } ?>
							</tbody>
						</table>
					</div>
					<div class="col-md-6">
						<label class="col-form-label mt-3 mb-0">Deductions</label>
						<table class="table table-bordered table-striped">
							<tbody>
								<?php if (!empty($salary['deduction'])) { foreach ($salary['deduction'] as $key => $value) { ?>
									<tr>
										<td><?php echo $value['label']; ?></td>
										<td><?php echo $common['info']['currency_abbr'].$value['value']; ?></td>
									</tr>
								<?php } } ?>
							</tbody>
						</table>
					</div>
				</div>
				<label class="col-form-label mt-3 mb-0">Total Salary Details</label>
				<table class="table table-bordered table-striped">
					<tbody>
						<tr>
							<td>Gross Salary</td>
							<td><?php echo $common['info']['currency_abbr'].$salary['gross_salary']; ?></td>
						</tr>
						<tr>
							<td>Total Deduction</td>
							<td><?php echo $common['info']['currency_abbr'].$salary['total_deduction']; ?></td>
						</tr>
						<tr>
							<td>Net Salary</td>
							<td><?php echo $common['info']['currency_abbr'].$salary['net_salary']; ?></td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
<!-- Footer -->
<?php include (DIR_ADMIN.'app/views/common/footer.tpl.php'); ?>