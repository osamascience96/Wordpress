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
				<div class="panel-title">Salary Template</div>
			</div>
			<form action="<?php echo $action; ?>" method="post">
				<div class="panel-body">
					<input type="hidden" name="_token" value="<?php echo $common['token']; ?>">
					<input type="hidden" name="id" value="<?php echo $result['user_id']; ?>">
					<div class="form-group">
						<label>Salary Template <span class="form-required">*</span></label>
						<div class="input-group">
							<div class="input-group-prepend"><span class="input-group-text"><i class="ti-mobile"></i></span></div>
							<select name="salarytemplate" class="custom-select" required>
								<option value="">Select Salary Template</option>
								<?php if (!empty($salarytemplate)) { foreach ($salarytemplate as $key => $value) { ?>
									<option value="<?php echo $value['id'] ?>" <?php if ($value['id'] == $result['salarytemplate_id']) { echo "selected"; } ?>><?php echo $value['grade']; ?></option>
								<?php } } ?>
							</select>
						</div>
					</div>
				</div>
				<div class="panel-footer text-center">
					<button type="submit" name="submit" class="btn btn-primary"><i class="ti-save-alt pr-2"></i> Save</button>
				</div>
			</form>
		</div>
	</div>
</div>
<!-- Footer -->
<?php include (DIR_ADMIN.'app/views/common/footer.tpl.php'); ?>