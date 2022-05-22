<?php include (DIR_ADMIN.'app/views/common/header.tpl.php'); ?>
<link rel="stylesheet" href="public/css/jquery.fancybox.min.css">
<script src="public/js/jquery.fancybox.min.js"></script>
<script>
	$("a.open-pdf").fancybox({
		'frameWidth': 800,
		'frameHeight': 800,
		'overlayShow': true,
		'hideOnContentClick': false,
		'type': 'iframe'
	});
</script>
<div class="page-title">
	<div class="row align-items-center">
		<div class="col-sm-6">
			<h2 class="page-title-text d-inline-block"><?php echo $page_title; ?></h2>
			<div class="breadcrumbs d-inline-block">
				<ul>
					<li><a href="<?php echo URL_ADMIN; ?>">Dashboard</a></li>
					<li><a href="<?php echo URL_ADMIN.DIR_ROUTE.'users'; ?>">Users</a></li>
					<li><?php echo $page_title; ?></li>
				</ul>
			</div>
		</div>
		<div class="col-sm-6 text-right"></div>
	</div>
</div>
<form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data">
	<input type="hidden" name="_token" value="<?php echo $token; ?>">
	<div class="panel panel-default">
		<div class="panel-body">
			<ul class="nav nav-tabs nav-tabs-line nav-tabs-line-primary">
				<li class="nav-item">
					<a class="nav-link active" href="#user-info" data-toggle="tab">Basic Info</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="#user-address" data-toggle="tab">Address</a>
				</li>
			</ul>
			<div class="tab-content pt-4">
				<div class="tab-pane active" id="user-info">
					<div class="row">
						<div class="col-lg-6">
							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<label>First Name <span class="form-required">*</span></label>
										<div class="input-group">
											<div class="input-group-prepend">
												<span class="input-group-text"><i class="ti-user"></i></span>
											</div>
											<input type="text" name="user[firstname]" class="form-control" value="<?php echo $result['firstname']; ?>" placeholder="Enter First Name . . ." required>
										</div>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label>Last Name <span class="form-required">*</span></label>
										<div class="input-group">
											<div class="input-group-prepend">
												<span class="input-group-text"><i class="ti-user"></i></span>
											</div>
											<input type="text" name="user[lastname]" class="form-control" value="<?php echo $result['lastname']; ?>" placeholder="Enter Last Name . . ." required>
										</div>
									</div>
								</div>
							</div>
							<div class="form-group">
								<label>Email Address <span class="form-required">*</span></label>
								<div class="input-group">
									<div class="input-group-prepend">
										<span class="input-group-text"><i class="ti-email"></i></span>
									</div>
									<input type="text" name="user[mail]" class="form-control" value="<?php echo $result['email']; ?>" placeholder="Enter Email Address . . ." required >
								</div>
							</div>
							<div class="form-group">
								<label>Mobile Number <span class="form-required">*</span></label>
								<div class="input-group">
									<div class="input-group-prepend">
										<span class="input-group-text"><i class="ti-mobile"></i></span>
									</div>
									<input type="text" name="user[mobile]" class="form-control" value="<?php echo $result['mobile']; ?>" placeholder="Enter Mobile Number . . ." required>
								</div>
							</div>
							<div class="form-group">
								<label>Gender</label>
								<div class="input-group">
									<div class="input-group-prepend">
										<span class="input-group-text"><i class="ti-user"></i></span>
									</div>
									<select name="user[gender]" class="custom-select">
										<option value="Male" <?php if ($result['gender'] == 'Male') { echo 'selected'; } ?>>Male</option>
										<option value="Female" <?php if ($result['gender'] == 'Female') { echo 'selected'; } ?>>Female</option>
										<option value="Other" <?php if ($result['gender'] == 'Other') { echo 'selected'; } ?>>Other</option>
									</select>
								</div>
							</div>
						</div>
						<div class="col-lg-6">
							<div class="form-group pb-3">
								<label class="d-block">Picture</label>
								<div class="image-upload" <?php if (!empty($result['picture'])) { echo " style=\"display: none\" "; }?> >
									<a>Upload</a>
								</div>
								<div class="saved-picture" <?php if (empty($result['picture'])) { echo " style=\"display: none\" "; } ?> >
									<?php if (!empty($result['picture'])) { ?>
										<img class="img-thumbnail" src="../public/uploads/<?php echo $result['picture']; ?>" alt="">
									<?php } ?>
									<input type="hidden" name="user[picture]" value="<?php echo $result['picture']; ?>">
								</div>
								<div class="saved-picture-delete" data-toggle="tooltip" data-placement="right" title="Remove" <?php if (empty($result['picture'])) { echo " style=\"display: none\" "; } ?> >
									<a class="ti-trash"></a>
								</div>
							</div>
							<div class="form-group">
								<label>Date of Birth</label>
								<div class="input-group">
									<div class="input-group-prepend">
										<span class="input-group-text"><i class="ti-calendar"></i></span>
									</div>
									<input type="text" id="user-dob" name="user[dob]" class="form-control bg-white" value="<?php if (!empty($result['dob'])) { echo date_format(date_create($result['dob']), $common['info']['date_format']); } ?>" placeholder="Enter Date of Birth . . ." autocomplete="off" readonly>
								</div>
							</div>
							<div class="form-group">
								<label>Blood Group</label>
								<div class="input-group">
									<div class="input-group-prepend">
										<span class="input-group-text"><i class="ti-heart-broken"></i></span>
									</div>
									<select name="user[bloodgroup]" class="custom-select">
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
							<?php if (!empty($result['user_id'])) { ?>
								<div class="form-group">
									<label>Status</label>
									<div class="input-group">
										<div class="input-group-prepend">
											<span class="input-group-text"><i class="ti-check-box"></i></span>
										</div>
										<select name="user[status]" class="custom-select">
											<option value="1" <?php if($result['status'] == '1') { echo "selected";} ?> >Enabled</option>
											<option value="0" <?php if($result['status'] == '0') { echo "selected";} ?> >Disabled</option>
										</select>
									</div>
								</div>
							<?php } ?>
						</div>
					</div>
					<div class="dotted-seprator mt-4 mb-5"></div>
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label>User Role <span class="form-required">*</span></label>
								<div class="input-group">
									<div class="input-group-prepend"><span class="input-group-text"><i class="ti-cloud-up"></i></span></div>
									<select name="user[user_role]" class="custom-select">
										<?php if (!empty($roles)) { foreach ($roles as $key => $value) { ?>
											<option value="<?php echo $value['id']; ?>" <?php if ($value['id'] == $result['user_role']) { echo "selected"; } ?> ><?php echo $value['name']; ?></option>
										<?php } } ?>
									</select>
								</div>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label>User Name <span class="form-required">*</span></label>
								<div class="input-group">
									<div class="input-group-prepend">
										<span class="input-group-text"><i class="ti-cloud-up"></i></span>
									</div>
									<input type="text" name="user[user_name]" class="form-control" value="<?php echo $result['user_name']; ?>" placeholder="Enter User Name . . ." required>
								</div>
							</div>
						</div>
						<?php if (empty($result['user_id'])) { ?>
							<div class="col-md-6">
								<div class="form-group">
									<label>Password <span class="form-required">*</span></label>
									<div class="input-group">
										<div class="input-group-prepend">
											<span class="input-group-text"><i class="ti-key"></i></span>
										</div>
										<input type="password" name="user[password]" class="form-control" placeholder="Enter Password . . ." required="">
									</div>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label>Confirm Password <span class="form-required">*</span></label>
									<div class="input-group">
										<div class="input-group-prepend">
											<span class="input-group-text"><i class="ti-key"></i></span>
										</div>
										<input type="password" name="user[cpassword]" class="form-control" placeholder="Enter Password . . ." required="">
									</div>
								</div>
							</div>
						<?php } ?>
					</div>
				</div>
				<div class="tab-pane" id="user-address">
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label>Address Line 1</label>
								<div class="input-group">
									<div class="input-group-prepend">
										<span class="input-group-text"><i class="ti-location-pin"></i></span>
									</div>
									<input type="text" name="user[address][address1]" class="form-control" value="<?php echo $result['address']['address1']; ?>" placeholder="Enter Address Line 1 . . .">
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
									<input type="text" name="user[address][address2]" class="form-control" value="<?php echo $result['address']['address2']; ?>" placeholder="Enter Address Line 2 . . .">
								</div>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label>City</label>
								<div class="input-group">
									<div class="input-group-prepend">
										<span class="input-group-text"><i class="ti-map-alt"></i></span>
									</div>
									<input type="text" name="user[address][city]" class="form-control" value="<?php echo $result['address']['city']; ?>" placeholder="Enter City . . .">
								</div>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label>Country</label>
								<div class="input-group">
									<div class="input-group-prepend">
										<span class="input-group-text"><i class="ti-map"></i></span>
									</div>
									<input type="text" name="user[address][country]" class="form-control" value="<?php echo $result['address']['country']; ?>" placeholder="Enter Country . . .">
								</div>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label>Postal/Zip Code</label>
								<div class="input-group">
									<div class="input-group-prepend">
										<span class="input-group-text"><i class="ti-pin"></i></span>
									</div>
									<input type="text" name="user[address][postal]" class="form-control" value="<?php echo $result['address']['postal']; ?>" placeholder="Enter Postal/Zip Code . . .">
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<input type="hidden" name="user[user_id]" value="<?php echo $result['user_id'];?>">
		<div class="panel-footer text-center">
			<button type="submit" name="submit" class="btn btn-primary"><i class="ti-save-alt pr-2"></i> Save</button>
		</div>
	</div>
</form>

<!-- Footer -->
<?php include (DIR_ADMIN.'app/views/common/footer.tpl.php'); ?>