<?php include (DIR_ADMIN.'app/views/common/header.tpl.php'); ?>
<div class="page-title">
	<div class="row align-items-center">
		<div class="col-sm-6">
			<h2 class="page-title-text d-inline-block"><?php echo $page_title; ?></h2>
			<div class="breadcrumbs d-inline-block">
				<ul>
					<li><a href="<?php echo URL_ADMIN; ?>">Dashboard</a></li>
					<li><a href="<?php echo URL_ADMIN.DIR_ROUTE.'birthrecords'; ?>">Birth Records</a></li>
					<li><?php echo $page_title; ?></li>
				</ul>
			</div>
		</div>
		<div class="col-sm-6 text-right"></div>
	</div>
</div>
<form action="<?php echo $action; ?>" method="post">
	<input type="hidden" name="_token" value="<?php echo $common['token']; ?>">
	<div class="panel panel-default">
		<div class="panel-body">
			<ul class="nav nav-tabs nav-tabs-line nav-tabs-line-primary">
				<li class="nav-item">
					<a class="nav-link active" href="#birth-info" data-toggle="tab">Birth Info</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="#birth-remark" data-toggle="tab">Report/Remark</a>
				</li>
			</ul>
			<div class="tab-content pt-4">
				<div class="tab-pane show active" id="birth-info">
					<div class="row">
						<div class="col-md-4">
							<div class="form-group">
								<label>Doctor <span class="form-required">*</span></label>
								<div class="input-group">
									<div class="input-group-prepend"><span class="input-group-text"><i class="ti-user"></i></span></div>
									<select name="birth[doctor_id]" class="custom-select doctor-id" required>
										<option value="">Select Doctor</option>
										<?php if (!empty($doctors)) { foreach ($doctors as $key => $value) {  ?>
											<option value="<?php echo $value['id']; ?>" <?php if ($result['doctor_id'] == $value['id']) { echo "selected"; } ?>><?php echo $value['name']; ?></option>
										<?php } } ?>
									</select>
									<input type="hidden" name="birth[doctor_name]" class="doctor-name" value="<?php echo $result['doctor_name'] ?>">
								</div>
							</div>
						</div>
						<div class="col-md-8"></div>
						<div class="col-md-4">
							<div class="form-group">
								<label>Child Name <span class="form-required">*</span></label>
								<div class="input-group">
									<div class="input-group-prepend"><span class="input-group-text"><i class="ti-user"></i></span></div>
									<input type="text" name="birth[child]" class="form-control" value="<?php echo $result['child']; ?>" placeholder="Enter Child Name . . ." required>
								</div>
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label>Birth Date <span class="form-required">*</span></label>
								<div class="input-group">
									<div class="input-group-prepend"><span class="input-group-text"><i class="ti-calendar"></i></span></div>
									<input type="text" name="birth[date]" class="form-control bg-white date" value="<?php echo date_format(date_create($result['date']), $common['info']['date_format']); ?>" placeholder="Enter Birth date . . ." readonly required autocomplete="off">
								</div>
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label>Birth Time <span class="form-required">*</span></label>
								<div class="input-group">
									<div class="input-group-prepend"><span class="input-group-text"><i class="ti-alarm-clock"></i></span></div>
									<input type="time" name="birth[time]" class="form-control" id="birth-time" value="<?php echo $result['time']; ?>" placeholder="Enter Birth Time . . ." required>
								</div>
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label>Gender <span class="form-required">*</span></label>
								<div class="input-group">
									<div class="input-group-prepend"><span class="input-group-text"><i class="ti-face-smile"></i></span></div>
									<select name="birth[gender]" class="custom-select" required>
										<option value="Male" <?php if ($result['gender'] == "Male") { echo "selected"; } ?>>Male</option>
										<option value="Female" <?php if ($result['gender'] == "Female") { echo "selected"; } ?>>Female</option>
										<option value="Other" <?php if ($result['gender'] == "Other") { echo "selected"; } ?>>Other</option>
									</select>
								</div>
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label>Weight <span class="form-required">*</span></label>
								<div class="input-group">
									<div class="input-group-prepend"><span class="input-group-text"><i class="ti-tag"></i></span></div>
									<input type="text" name="birth[weight]" class="form-control" value="<?php echo $result['weight']; ?>" placeholder="Enter weight . . ." required>
								</div>
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label>Height</label>
								<div class="input-group">
									<div class="input-group-prepend"><span class="input-group-text"><i class="ti-ruler-alt-2"></i></span></div>
									<input type="text" name="birth[height]" class="form-control" value="<?php echo $result['height']; ?>" placeholder="Enter Height . . ." required>
								</div>
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label>Mother <span class="form-required">*</span></label>
								<div class="input-group">
									<div class="input-group-prepend"><span class="input-group-text"><i class="ti-user"></i></span></div>
									<input type="text" name="birth[mother_name]" class="form-control mother-name" value="<?php echo $result['mother_name']; ?>" placeholder="Enter Mother Name . . ." required>
									<input type="hidden" name="birth[mother_id]" class="mother-id" value="<?php echo $result['mother_id']; ?>">
								</div>
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label>Mother Email Address</label>
								<div class="input-group">
									<div class="input-group-prepend"><span class="input-group-text"><i class="ti-email"></i></span></div>
									<input type="text" name="birth[mother_email]" class="form-control mother-mail" value="<?php echo $result['mother_email']; ?>" placeholder="Enter Mother Name . . .">
								</div>
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label>Mother Mobile Number</label>
								<div class="input-group">
									<div class="input-group-prepend"><span class="input-group-text"><i class="ti-mobile"></i></span></div>
									<input type="text" name="birth[mother_mobile]" class="form-control mother-mobile" value="<?php echo $result['mother_mobile']; ?>" placeholder="Enter Mother Name . . .">
								</div>
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label>Father</label>
								<div class="input-group">
									<div class="input-group-prepend"><span class="input-group-text"><i class="ti-user"></i></span></div>
									<input type="text" name="birth[father_name]" class="form-control father-name" value="<?php echo $result['father_name']; ?>" placeholder="Enter Father Name . . .">
									<input type="hidden" name="birth[father_id]" class="father-id" value="<?php echo $result['father_id']; ?>">
								</div>
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label>Father Email Address</label>
								<div class="input-group">
									<div class="input-group-prepend"><span class="input-group-text"><i class="ti-email"></i></span></div>
									<input type="text" name="birth[father_email]" class="form-control father-mail" value="<?php echo $result['father_email']; ?>" placeholder="Enter Father Email Address . . .">
								</div>
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label>Father Mobile Number</label>
								<div class="input-group">
									<div class="input-group-prepend"><span class="input-group-text"><i class="ti-mobile"></i></span></div>
									<input type="text" name="birth[father_mobile]" class="form-control father-mobile" value="<?php echo $result['father_mobile']; ?>" placeholder="Enter Father Mobile Number . . .">
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="tab-pane" id="birth-remark">
					<div class="form-group">
						<label>Report/Remark</label>
						<textarea name="birth[remark]" class="mail-summernote"><?php echo $result['remark']; ?></textarea>
					</div>
				</div>
			</div>
		</div>
		<input type="hidden" name="birth[id]" value="<?php echo $result['id'];?>">
		<div class="panel-footer text-center">
			<button type="submit" name="submit" class="btn btn-primary"><i class="ti-save-alt pr-2"></i> Save</button>
		</div>
	</div>
</form>

<!-- include summernote css/js-->
<link href="public/css/summernote-bs4.css" rel="stylesheet">
<script type="text/javascript" src="public/js/summernote-bs4.min.js"></script>
<script type="text/javascript" src="public/js/klinikal.summernote.js"></script>

<script>
	
	$('body').on('change', '.doctor-id', function () {
		$('.doctor-name').val($(this).find('option:selected').text());
	});

	$(".mother-name").autocomplete({
		source: '<?php echo URL_ADMIN.DIR_ROUTE.'patient/search'; ?>',
		minLength: 2,
		focus: function() {return false;},
		select: function( event, ui ) {
			$('.mother-id').val(ui.item.id);
			$('.mother-name').val(ui.item.label);
			$('.mother-mail').val(ui.item.email);
			$('.mother-mobile').val(ui.item.mobile);
			return false;
		}
	});
	$(".father-name").autocomplete({
		source: '<?php echo URL_ADMIN.DIR_ROUTE.'patient/search'; ?>',
		minLength: 2,
		focus: function() {return false;},
		select: function( event, ui ) {
			$('.father-id').val(ui.item.id);
			$('.father-name').val(ui.item.label);
			$('.father-mail').val(ui.item.email);
			$('.father-mobile').val(ui.item.mobile);
			return false;
		}
	});
</script>
<!-- Footer -->
<?php include (DIR_ADMIN.'app/views/common/footer.tpl.php'); ?>