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
			<a href="<?php echo URL_ADMIN.DIR_ROUTE.'managesalary/history/pdf&id='.$result['id']; ?>" class="btn btn-danger btn-sm" target="_blank"><i class="far fa-file-pdf mr-1"></i>PDF Preview</a>
		</div>
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
				<div class="panel-title">Salary</div>
			</div>
			<div class="panel-body">
				<div class="row align-items-center">
					<div class="col-4"><p class="font-12 text-dark">Salary Grades</p></div>
					<div class="col-8"><p class="font-12 text-primary"><?php echo $result['salarytemplate']['grade']; ?></p></div>
					<div class="col-4"><p class="font-12 text-dark">Basic Salary</p></div>
					<div class="col-8"><p class="font-12 text-dark"><?php echo $common['info']['currency_abbr'].$result['salarytemplate']['basic_salary']; ?></p></div>
					<div class="col-4"><p class="font-12 text-dark">Month</p></div>
					<div class="col-8"><p class="font-12 text-dark"><?php echo date_format(date_create($result['month_year']), $common['info']['date_my_format']); ?></p></div>
					<div class="col-4"><p class="font-12 text-dark">Date</p></div>
					<div class="col-8"><p class="font-12 text-dark"><?php echo date_format(date_create($result['date_of_joining']), $common['info']['date_format']); ?></p></div>
					<div class="col-4"><p class="font-12 text-dark">Payment Method</p></div>
					<div class="col-8"><p class="font-12 text-dark"><?php echo $result['payment_method']; ?></p></div>
				</div>
				<div class="row align-items-start">
					<div class="col-md-6">
						<label class="col-form-label mt-1 mb-0">Allowances</label>
						<table class="table table-bordered table-striped">
							<tbody>
								<?php if (!empty($result['salarytemplate']['allowance'])) { foreach ($result['salarytemplate']['allowance'] as $key => $value) { ?>
									<tr>
										<td><?php echo $value['label']; ?></td>
										<td><?php echo $common['info']['currency_abbr'].$value['value']; ?></td>
									</tr>
								<?php } } ?>
							</tbody>
						</table>
					</div>
					<div class="col-md-6">
						<label class="col-form-label mt-1 mb-0">Deductions</label>
						<table class="table table-bordered table-striped">
							<tbody>
								<?php if (!empty($result['salarytemplate']['deduction'])) { foreach ($result['salarytemplate']['deduction'] as $key => $value) { ?>
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
							<td><?php echo $common['info']['currency_abbr'].$result['salarytemplate']['gross_salary']; ?></td>
						</tr>
						<tr>
							<td>Total Deduction</td>
							<td><?php echo $common['info']['currency_abbr'].$result['salarytemplate']['total_deduction']; ?></td>
						</tr>
						<tr>
							<td>Net Salary</td>
							<td><?php echo $common['info']['currency_abbr'].$result['salarytemplate']['net_salary']; ?></td>
						</tr>
						<tr>
							<td>Advance</td>
							<td><?php echo $common['info']['currency_abbr'].$result['advance']; ?></td>
						</tr>
						<tr>
							<td>Deduction</td>
							<td><?php echo $common['info']['currency_abbr'].$result['deduction']; ?></td>
						</tr>
						<tr>
							<td class="text-dark font-500">Payment Amount</td>
							<td class="text-primary"><?php echo $common['info']['currency_abbr'].$result['amount']; ?></td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
<!-- Footer -->
<?php include (DIR_ADMIN.'app/views/common/footer.tpl.php'); ?>