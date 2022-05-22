<?php include (DIR_ADMIN.'app/views/common/header.tpl.php'); ?>
<div class="page-title">
	<div class="row align-items-center">
		<div class="col-sm-6">
			<h2 class="page-title-text d-inline-block"><?php echo $page_title; ?></h2>
			<div class="breadcrumbs d-inline-block">
				<ul>
					<li><a href="#">Home</a></li>
					<li><a href="<?php echo URL_ADMIN.DIR_ROUTE.'patients'; ?>">Patients</a></li>
					<li><?php echo $page_title; ?></li>
				</ul>
			</div>
		</div>
		<div class="col-sm-6 text-right">
		</div>
	</div>
</div>

<form action="<?php echo $action; ?>" method="post">
	<input type="hidden" name="_token" value="<?php echo $token; ?>">
	<input type="hidden" name="patient[id]" value="<?php echo $result['id']; ?>">
	<div class="panel panel-default">
		<div class="panel-body">
			<ul class="nav nav-tabs nav-tabs-line nav-tabs-line-primary">
				<li class="nav-item">
					<a class="nav-link active" href="#patient-info" data-toggle="tab">Basic Info</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="#patient-address" data-toggle="tab">Address</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="#patient-medical-history" data-toggle="tab">Medical History</a>
				</li>
			</ul>
			<div class="tab-content pt-4">
				<div class="tab-pane active" id="patient-info">
					<div class="row">
						<div class="col-md-3">
							<div class="form-group">
								<label>First Name <span class="form-required">*</span></label>
								<div class="input-group">
									<div class="input-group-prepend">
										<span class="input-group-text"><i class="ti-user"></i></span>
									</div>
									<input type="text" name="patient[firstname]" class="form-control" value="<?php echo $result['firstname']; ?>" placeholder="Enter First Name . . . ">
								</div>
							</div>
						</div>
						<div class="col-md-3">
							<div class="form-group">
								<label>Last Name <span class="form-required">*</span></label>
								<div class="input-group">
									<div class="input-group-prepend">
										<span class="input-group-text"><i class="ti-user"></i></span>
									</div>
									<input type="text" name="patient[lastname]" class="form-control" value="<?php echo $result['lastname']; ?>" placeholder="Enter Last Name . . . ">
								</div>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label>Email Address <span class="form-required">*</span></label>
								<div class="input-group">
									<div class="input-group-prepend">
										<span class="input-group-text"><i class="ti-email"></i></span>
									</div>
									<input type="email" name="patient[mail]" class="form-control" value="<?php echo $result['email']; ?>" placeholder="Enter Email Address . . . ">
								</div>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label>Mobile Number <span class="form-required">*</span></label>
								<div class="input-group">
									<div class="input-group-prepend">
										<span class="input-group-text"><i class="ti-mobile"></i></span>
									</div>
									<input type="text" name="patient[mobile]" class="form-control" value="<?php echo $result['mobile']; ?>" placeholder="Enter Mobile Number . . . ">
								</div>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label>Date of Birth</label>
								<div class="input-group">
									<div class="input-group-prepend">
										<span class="input-group-text"><i class="ti-calendar"></i></span>
									</div>
									<input type="text" id="user-dob" name="patient[dob]" class="form-control bg-white" value="<?php if (!empty($result['dob'])) { echo date_format(date_create($result['dob']), $common['info']['date_format']); } ?>" placeholder="Enter Date of Birth . . . " readonly autocomplete="off">
								</div>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label>Blood Group</label>
								<div class="input-group">
									<div class="input-group-prepend">
										<span class="input-group-text"><i class="ti-heart-broken"></i></span>
									</div>
									<select name="patient[bloodgroup]" class="custom-select">
										<option value="A+" <?php if ($result['bloodgroup'] == 'A+') { echo "selected"; } ?>>A+</option>
										<option value="A-" <?php if ($result['bloodgroup'] == 'A-') { echo "selected"; } ?>>A-</option>
										<option value="B+" <?php if ($result['bloodgroup'] == 'B+') { echo "selected"; } ?>>B+</option>
										<option value="B-" <?php if ($result['bloodgroup'] == 'B-') { echo "selected"; } ?>>B-</option>
										<option value="O+" <?php if ($result['bloodgroup'] == 'O+') { echo "selected"; } ?>>O+</option>
										<option value="O-" <?php if ($result['bloodgroup'] == 'O-') { echo "selected"; } ?>>O-</option>
										<option value="AB+" <?php if ($result['bloodgroup'] == 'AB+') { echo "selected"; } ?>>AB+</option>
										<option value="AB-" <?php if ($result['bloodgroup'] == 'AB-') { echo "selected"; } ?>>AB-</option>
									</select>
								</div>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label>Gender</label>
								<div class="input-group">
									<div class="input-group-prepend"><span class="input-group-text"><i class="ti-check-box"></i></span></div>
									<select name="patient[gender]" class="custom-select">
										<option value="Male" <?php if ($result['gender'] == 'Male') { echo "selected"; } ?>>Male</option>
										<option value="Female" <?php if ($result['gender'] == 'Female') { echo "selected"; } ?>>Female</option>
										<option value="Other" <?php if ($result['gender'] == 'Other') { echo "selected"; } ?>>Other</option>
									</select>
								</div>
							</div>
						</div>
						<?php if (!empty($result['id'])) { ?>
							<div class="col-md-6">
								<div class="form-group">
									<label>Status</label>
									<div class="input-group">
										<div class="input-group-prepend"><span class="input-group-text"><i class="ti-check-box"></i></span></div>
										<select name="patient[status]" class="custom-select">
											<option value="1" <?php if ($result['status'] == '1') { echo "selected";} ?>>Active</option>
											<option value="0" <?php if ($result['status'] == '0') { echo "selected";} ?>>InActive</option>
										</select>
									</div>
								</div>
							</div>
						<?php } ?>
					</div>
				</div>
				<div class="tab-pane" id="patient-address">
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label>Address Line 1</label>
								<div class="input-group">
									<div class="input-group-prepend">
										<span class="input-group-text"><i class="ti-location-pin"></i></span>
									</div>
									<input type="text" name="patient[address][address1]" class="form-control" value="<?php echo $result['address']['address1']; ?>" placeholder="Enter Address Line 1 . . .">
								</div>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label>Address Line 2</label>
								<div class="input-group">
									<div class="input-group-prepend">
										<span class="input-group-text"><i class="ti-location-pin"></i></span>
									</div>
									<input type="text" name="patient[address][address2]" class="form-control" value="<?php echo $result['address']['address2']; ?>" placeholder="Enter Address Line 2 . . .">
								</div>
							</div>
						</div>
					</div>
					<div class="form-group">
						<label>City</label>
						<div class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text"><i class="ti-map-alt"></i></span>
							</div>
							<input type="text" name="patient[address][city]" class="form-control" value="<?php echo $result['address']['city']; ?>" placeholder="Enter City . . .">
						</div>
					</div>
					<div class="form-group">
						<label>Country</label>
						<div class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text"><i class="ti-map"></i></span>
							</div>
							<input type="text" name="patient[address][country]" class="form-control" value="<?php echo $result['address']['country']; ?>" placeholder="Enter Country . . .">
						</div>
					</div>
					<div class="form-group">
						<label>Postal/Zip Code</label>
						<div class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text"><i class="ti-pin"></i></span>
							</div>
							<input type="text" name="patient[address][postal]" class="form-control" value="<?php echo $result['address']['postal']; ?>" placeholder="Enter Postal/Zip Code . . .">
						</div>
					</div>
				</div>
				<div class="tab-pane" id="patient-medical-history">
					<div class="form-group mb-2">
						<label class="d-block mb-2">Do you now or have you ever had:</label>
						<div class="row">
							<?php foreach ($history as $key => $value) { ?>
								<div class="col-md-6 col-lg-4">
									<div class="custom-control custom-checkbox mb-2">
										<input type="checkbox" name="patient[history][]" class="custom-control-input" value="<?php echo $value; ?>" id="<?php echo $key; ?>" <?php if (!empty($result['history'])) { foreach ($result['history'] as $k => $v) { if ($v == $value) { echo "checked"; } } } ?>>
										<label class="custom-control-label" for="<?php echo $key; ?>"><?php echo $value; ?></label>
									</div>
								</div>
							<?php } ?>
						</div>
					</div>
					<div class="form-group">
						<label>Other History :</label>
						<div class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text"><i class="ti-heart-broken"></i></span>
							</div>
							<textarea name="patient[other]" class="form-control" placeholder="Patient other history . . ."><?php echo $result['other']; ?></textarea>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="panel-footer text-center">
			<button type="submit" name="submit" class="btn btn-primary"><i class="ti-save-alt pr-2"></i> Save</button>
		</div>
	</div>
</form>
<!-- Footer -->
<?php include (DIR_ADMIN.'app/views/common/footer.tpl.php'); ?>