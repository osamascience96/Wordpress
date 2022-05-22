<?php include (DIR_ADMIN.'app/views/common/header.tpl.php'); ?>
<script type="text/javascript" src="public/js/jquery-ui.multidatespicker.min.js" /></script>
<div class="page-title">
	<div class="row align-items-center">
		<div class="col-sm-6">
			<h2 class="page-title-text d-inline-block"><?php echo $page_title; ?></h2>
			<div class="breadcrumbs d-inline-block">
				<ul>
					<li><a href="<?php echo URL_ADMIN; ?>">Dashboard</a></li>
					<li><a href="<?php echo URL_ADMIN.DIR_ROUTE.'doctors'; ?>">Doctors</a></li>
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
					<a class="nav-link active" href="#doctor-basic" data-toggle="tab">Basic Info</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="#doctor-address" data-toggle="tab">Address</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="#doctor-web" data-toggle="tab">Website Data</a>
				</li>
				<li class="nav-item">  
					<a class="nav-link" href="#doctor-appointment" data-toggle="tab">Appointment Info</a>
				</li>
				<li class="nav-item">  
					<a class="nav-link" href="#doctor-holidays" data-toggle="tab">Holidays</a>
				</li>
			</ul>
			<div class="tab-content pt-4">
				<div class="tab-pane active" id="doctor-basic">
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
											<input type="text" name="doctor[firstname]" class="form-control" value="<?php echo $result['firstname']; ?>" placeholder="Enter Doctor First Name . . ." required>
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
											<input type="text" name="doctor[lastname]" class="form-control" value="<?php echo $result['lastname']; ?>" placeholder="Enter Doctor Last Name . . ." required>
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
									<input type="text" name="doctor[mail]" class="form-control" value="<?php echo $result['email']; ?>" placeholder="Enter Email Address . . ." required>
								</div>
							</div>
							<div class="form-group">
								<label>Mobile Number <span class="form-required">*</span></label>
								<div class="input-group">
									<div class="input-group-prepend">
										<span class="input-group-text"><i class="ti-mobile"></i></span>
									</div>
									<input type="text" name="doctor[mobile]" class="form-control" value="<?php echo $result['mobile']; ?>" placeholder="Enter Mobile Number . . ." required>
								</div>
							</div>
							<div class="form-group">
								<label>Blood Group</label>
								<div class="input-group">
									<div class="input-group-prepend">
										<span class="input-group-text"><i class="ti-user"></i></span>
									</div>
									<select name="doctor[bloodgroup]" class="custom-select">
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
							<div class="form-group">
								<label>Gender</label>
								<div class="input-group">
									<div class="input-group-prepend">
										<span class="input-group-text"><i class="ti-user"></i></span>
									</div>
									<select name="doctor[gender]" class="custom-select">
										<option value="Male" <?php if ($result['gender'] == 'Male') { echo "selected"; } ?>>Male</option>
										<option value="Female" <?php if ($result['gender'] == 'Female') { echo "selected"; } ?>>Female</option>
										<option value="Other" <?php if ($result['gender'] == 'other') { echo "selected"; } ?>>Other</option>
									</select>
								</div>
							</div>
						</div>
						<div class="col-lg-6">
							<div class="form-group">
								<label class="d-block">Picture</label>
								<div class="image-upload" <?php if (!empty($result['picture'])) { echo " style=\"display: none\" "; }?> >
									<a>Upload</a>
								</div>
								<div class="saved-picture" <?php if (empty($result['picture'])) { echo " style=\"display: none\" "; } ?> >
									<?php if (!empty($result['picture'])) { ?>
										<img class="img-thumbnail" src="../public/uploads/<?php echo $result['picture']; ?>" alt="">
									<?php } ?>
									<input type="hidden" name="doctor[picture]" value="<?php echo $result['picture']; ?>">
								</div>
								<div class="saved-picture-delete" data-toggle="tooltip" data-placement="right" title="Remove" <?php if (empty($result['picture'])) { echo " style=\"display: none\" "; } ?> >
									<a class="ti-trash"></a>
								</div>
								<div class="form-text">(Size: 530px * 470px)</div>
							</div>
							<div class="form-group">
								<label>Date of Birth</label>
								<div class="input-group">
									<div class="input-group-prepend">
										<span class="input-group-text"><i class="ti-calendar"></i></span>
									</div>
									<input type="text" id="user-dob" name="doctor[dob]" class="form-control bg-white" value="<?php if (!empty($result['dob'])) { echo date_format(date_create($result['dob']), $common['info']['date_format']); } ?>" placeholder="Select Date of Birth . . ." readonly autocomplete="off" required>
								</div>
							</div>
							<div class="form-group">
								<label>Department <span class="form-required">*</span></label>
								<div class="input-group">
									<div class="input-group-prepend"><span class="input-group-text"><i class="ti-layers-alt"></i></span></div>
									<select name="doctor[department]" class="custom-select" required>
										<?php if(!empty($departments)) { foreach ($departments as $department) { ?>
											<option value="<?php echo $department['id']; ?>" <?php if($department['id'] == $result['department_id']) { echo "selected"; } ?> > <?php echo $department['name']; ?></option>
										<?php } } ?>
									</select>
								</div>
							</div>
							<div class="form-group">
								<label>Status</label>
								<div class="input-group">
									<div class="input-group-prepend">
										<span class="input-group-text"><i class="ti-check-box"></i></span>
									</div>
									<select name="doctor[status]" class="custom-select" required>
										<option value="1" <?php if($result['status'] == '1') { echo "selected";} ?> >Active</option>
										<option value="0" <?php if($result['status'] == '0') { echo "selected";} ?> >InActive</option>
									</select>
								</div>
							</div>
						</div>
					</div>
					<div class="dotted-seprator mt-4 mb-5"></div>
					<div class="row">
						<div class="col-lg-6">
							<div class="form-group">
								<label>Username <span class="form-required">*</span></label>
								<div class="input-group">
									<div class="input-group-prepend">
										<span class="input-group-text"><i class="ti-id-badge"></i></span>
									</div>
									<input type="text" name="doctor[user_name]" class="form-control" value="<?php echo $result['user_name']; ?>" placeholder="Enter Doctor Username . . ." required>
								</div>
							</div>
							<?php if (empty($result['id'])) { ?>
								<div class="form-group">
									<label>Password <span class="form-required">*</span></label>
									<div class="input-group">
										<div class="input-group-prepend">
											<span class="input-group-text"><i class="ti-key"></i></span>
										</div>
										<input type="password" name="doctor[password]" class="form-control" placeholder="Enter Password . . ." required>
									</div>
								</div>
								<div class="form-group">
									<label>Confirm Password <span class="form-required">*</span></label>
									<div class="input-group">
										<div class="input-group-prepend">
											<span class="input-group-text"><i class="ti-key"></i></span>
										</div>
										<input type="password" name="doctor[cpassword]" class="form-control" placeholder="Enter Password . . ." required>
									</div>
								</div>
							<?php } ?>
						</div>
					</div>
				</div>
				<div class="tab-pane" id="doctor-address">
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label>Address Line 1</label>
								<div class="input-group">
									<div class="input-group-prepend">
										<span class="input-group-text"><i class="ti-location-pin"></i></span>
									</div>
									<input type="text" name="doctor[address][address1]" class="form-control" value="<?php echo $result['address']['address1']; ?>" placeholder="Enter Address Line 1 . . .">
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
									<input type="text" name="doctor[address][address2]" class="form-control" value="<?php echo $result['address']['address2']; ?>" placeholder="Enter Address Line 2 . . .">
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
									<input type="text" name="doctor[address][city]" class="form-control" value="<?php echo $result['address']['city']; ?>" placeholder="Enter City . . .">
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
									<input type="text" name="doctor[address][country]" class="form-control" value="<?php echo $result['address']['country']; ?>" placeholder="Enter Country . . .">
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
									<input type="text" name="doctor[address][postal]" class="form-control" value="<?php echo $result['address']['postal']; ?>" placeholder="Enter Postal/Zip Code . . .">
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="tab-pane" id="doctor-web">
					<div class="form-group">
						<label>Do you want to display this data on website?</label>
						<select name="doctor[web_status]" class="custom-select">
							<option value="1" <?php if ($result['web_status'] == '1') { echo "selected"; } ?>>Yes</option>
							<option value="0" <?php if ($result['web_status'] == '0') { echo "selected"; } ?>>No</option>
						</select>
					</div>
					<div class="row">
						<div class="col-lg-6">
							<div class="form-group">
								<label>Priority</label>
								<div class="input-group">
									<div class="input-group-prepend">
										<span class="input-group-text"><i class="ti-shortcode"></i></span>
									</div>
									<input type="number" name="doctor[priority]" class="form-control" value="<?php echo $result['priority'];?>" placeholder="Enter Priority . . .">
								</div>
							</div>
							<div class="form-group">
								<label>Position</label>
								<div class="input-group">
									<div class="input-group-prepend">
										<span class="input-group-text"><i class="ti-info"></i></span>
									</div>
									<input type="text" name="doctor[about][position]" class="form-control" value="<?php echo $result['about']['position'];?>" placeholder="Enter Doctor's Position . . .">
								</div>
							</div>
							<div class="form-group">
								<label>Degree</label>
								<div class="input-group">
									<div class="input-group-prepend">
										<span class="input-group-text"><i class="ti-id-badge"></i></span>
									</div>
									<input type="text" name="doctor[about][degree]" class="form-control" value="<?php echo $result['about']['degree'];?>" placeholder="Enter Doctor's Degree . . .">
								</div>
							</div>
						</div>
						<div class="col-lg-6">
							<div class="form-group">
								<label>Specility</label>
								<div class="input-group">
									<div class="input-group-prepend">
										<span class="input-group-text"><i class="ti-shield"></i></span>
									</div>
									<input type="text" name="doctor[about][specility]" class="form-control" value="<?php echo $result['about']['specility'];?>" placeholder="Enter Doctor's Specility . . .">
								</div>
							</div>
							<div class="form-group">
								<label>Experience</label>
								<div class="input-group">
									<div class="input-group-prepend">
										<span class="input-group-text"><i class="ti-shine"></i></span>
									</div>
									<input type="number" name="doctor[about][experience]" class="form-control" value="<?php echo $result['about']['experience'];?>" placeholder="Enter Doctor's Experience . . .">
								</div>
							</div>
							<div class="form-group">
								<label>Awards</label>
								<div class="input-group">
									<div class="input-group-prepend">
										<span class="input-group-text"><i class="ti-gift"></i></span>
									</div>
									<input type="text" name="doctor[about][awards]" class="form-control" value="<?php echo $result['about']['awards'];?>" placeholder="Enter Awards Count . . .">
								</div>
							</div>
						</div>
						<div class="col-lg-6">
							<div class="form-group">
								<label>Facebook</label>
								<div class="input-group">
									<div class="input-group-prepend">
										<span class="input-group-text"><i class="ti-facebook"></i></span>
									</div>
									<input type="url" name="doctor[social][facebook]" class="form-control" value="<?php echo $result['social']['facebook'];?>" placeholder="Facebook URL">
								</div>
							</div>
							<div class="form-group">
								<label>Twitter</label>
								<div class="input-group">
									<div class="input-group-prepend">
										<span class="input-group-text"><i class="ti-twitter"></i></span>
									</div>
									<input type="url" name="doctor[social][twitter]" class="form-control" value="<?php echo $result['social']['twitter'];?>" placeholder="Twitter URL">
								</div>
							</div>
						</div>
						<div class="col-lg-6">
							<div class="form-group">
								<label>Google +</label>
								<div class="input-group">
									<div class="input-group-prepend">
										<span class="input-group-text"><i class="ti-google"></i></span>
									</div>
									<input type="url" name="doctor[social][google]" class="form-control" value="<?php echo $result['social']['google'];?>" placeholder="Google plus URL">
								</div>
							</div>
							<div class="form-group">
								<label>Instagram</label>
								<div class="input-group">
									<div class="input-group-prepend">
										<span class="input-group-text"><i class="ti-instagram"></i></span>
									</div>
									<input type="url" name="doctor[social][instagram]" class="form-control" value="<?php echo $result['social']['instagram'];?>" placeholder="Instagram URL">
								</div>
							</div>
						</div>
					</div>	
				</div>
				<div class="tab-pane" id="doctor-appointment">
					<div class="form-group">
						<label>Can doctor take appointment? <span class="form-required">*</span></label>
						<select name="doctor[appointment_status]" class="custom-select">
							<option value="1" <?php if ($result['appointment_status'] == '1') { echo "selected"; } ?>>Yes</option>
							<option value="0" <?php if ($result['appointment_status'] == '0') { echo "selected"; } ?>>No</option>
						</select>
					</div>
					<div class="table-responsive">
						<table class="table table-middle table-bordered">
							<thead>
								<tr>
									<th rowspan="2">Day</th>
									<th colspan="2" class="text-center">Before Lunch</th>
									<th colspan="2" class="text-center">After Lunch</th>
									<th rowspan="2">Slot Time(In Minute)</th>
									<th rowspan="2">Holiday</th>
								</tr>
								<tr>
									<th>Start Time</th>
									<th>End Time</th>
									<th>Start Time</th>
									<th>End Time</th>
								</tr>
							</thead>
							<tbody>
								<?php foreach ($week_days as $key => $value) { ?>
									<tr>
										<td><?php echo $value; ?></td>
										<td>
											<input type="time" name="doctor[time][<?php echo $key; ?>][st1]" value="<?php echo $result['time'][$key]['st1']; ?>" class="form-control m-0">
										</td>
										<td>
											<input type="time" name="doctor[time][<?php echo $key; ?>][et1]" value="<?php echo $result['time'][$key]['et1']; ?>" class="form-control m-0">
										</td>
										<td>
											<input type="time" name="doctor[time][<?php echo $key; ?>][st2]" value="<?php echo $result['time'][$key]['st2']; ?>" class="form-control m-0">
										</td>
										<td>
											<input type="time" name="doctor[time][<?php echo $key; ?>][et2]" value="<?php echo $result['time'][$key]['et2']; ?>" class="form-control m-0">
										</td>
										<td>
											<input type="text" name="doctor[time][<?php echo $key; ?>][slot]" value="<?php echo $result['time'][$key]['slot']; ?>" class="form-control m-0">
										</td>
										<td class="text-center">
											<div class="custom-control custom-checkbox d-inline-block">
												<input type="checkbox" name="doctor[time][<?php echo $key; ?>][holiday]" class="custom-control-input doctor-time" id="time-<?php echo $key; ?>" value="1" <?php if (!empty($result['time'][$key]['holiday']) && $result['time'][$key]['holiday'] == '1') { echo "checked"; } ?>>
												<label class="custom-control-label" for="time-<?php echo $key; ?>"></label>
											</div>
										</td>
									</tr>
								<?php } ?>
							</tbody>
						</table>
					</div>
				</div>
				<div class="tab-pane" id="doctor-holidays">
					<div class="form-group">
						<div id="other-holiday"></div>
						<input type="hidden" name="doctor[national]" value="" id="altField">
						<input type="hidden" id="other-holiday-list" value="<?php if(isset($result['national'])) { print_r($result['national']); } ?>">
						<input type="hidden" id="weekly-holiday" value="<?php if (!empty($result['weekly'])) { echo implode(',', $result['weekly']); } ?>">
					</div>
				</div>
			</div>
		</div>
		<input type="hidden" name="doctor[id]" value="<?php echo $result['id'];?>">
		<input type="hidden" name="doctor[user_id]" value="<?php echo $result['user_id'];?>">
		<div class="panel-footer text-center">
			<button type="submit" name="submit" class="btn btn-primary"><i class="ti-save-alt pr-2"></i> Save</button>
		</div>
	</div>
</form>

<script>
	function noWeekendsOrHolidays(date) {
		var doctor_holiday;
		if (typeof $('#weekly-holiday').val() != "undefined" && $('#weekly-holiday').val() != "") {
			doctor_holiday = $('#weekly-holiday').val().split(',');
		} else {
			doctor_holiday = '';
		}
		var day = date.getDay(),
		noWeekend = [(day != doctor_holiday['0'] && day != doctor_holiday['1'] && day != doctor_holiday['2'] && day != doctor_holiday['3'] && day != doctor_holiday['4'] && day != doctor_holiday['5'] && day != doctor_holiday['6'])];
		return noWeekend;
	}

	function holidayCheck(ele) {
		var ele_parent = ele.parents('tr');
		if(ele.is(":checked")) {
			ele_parent.find('input').not(ele).attr('readonly', true);
		} else {
			ele_parent.find('input').not(ele).attr('readonly', false);
		}
	}

	$(document).ready(function () {
		var other_holiday, today;
		if ($('#other-holiday-list').val() != "" && typeof $('#other-holiday-list').val() != "undefined") {
			other_holiday = $('#other-holiday-list').val().split(', ');
		} else {
			other_holiday = ["2000-12-25"];
		}

		$('#other-holiday').multiDatesPicker({
			minDate: 0,
			dateFormat: 'yy-mm-dd',
			addDates: other_holiday,
			numberOfMonths: [2, 3],
			defaultDate: today,
			altField: '#altField',
			beforeShowDay: noWeekendsOrHolidays
		});
		$(".doctor-time").each(function() {
			var ele = $(this);
			holidayCheck(ele);
		});

		$('#doctor-appointment').on('change', '.doctor-time', function () {
			var ele = $(this);
			holidayCheck(ele);
		});
	});
</script>
<!-- Footer -->
<?php include (DIR_ADMIN.'app/views/common/footer.tpl.php'); ?>