<?php include (DIR_ADMIN.'app/views/common/header.tpl.php'); ?>
<div class="page-title">
	<div class="row align-items-center">
		<div class="col-sm-6">
			<h2 class="page-title-text d-inline-block"><?php echo $page_title; ?></h2>
			<div class="breadcrumbs d-inline-block">
				<ul>
					<li><a href="<?php echo URL_ADMIN; ?>">Dashboard</a></li>
					<li><a href="<?php echo URL_ADMIN.DIR_ROUTE.'deathrecords'; ?>">Death Records</a></li>
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
					<a class="nav-link active" href="#birth-info" data-toggle="tab">Death Info</a>
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
									<select name="death[doctor_id]" class="custom-select doctor-id" required>
										<option value="">Select Doctor</option>
										<?php if (!empty($doctors)) { foreach ($doctors as $key => $value) {  ?>
											<option value="<?php echo $value['id']; ?>" <?php if ($result['doctor_id'] == $value['id']) { echo "selected"; } ?>><?php echo $value['name']; ?></option>
										<?php } } ?>
									</select>
									<input type="hidden" name="death[doctor_name]" class="doctor-name" value="<?php echo $result['doctor_name'] ?>">
								</div>
							</div>
						</div>
						<div class="col-md-8"></div>
						<div class="col-md-4">
							<div class="form-group">
								<label>Patient Name <span class="form-required">*</span></label>
								<div class="input-group">
									<div class="input-group-prepend">
										<span class="input-group-text"><i class="ti-user"></i></span>
									</div>
									<input type="text" name="death[name]" class="form-control patient-name" value="<?php echo $result['name']; ?>" placeholder="Enter Patient Name . . ." required>
									<input type="hidden" name="death[patient_id]" class="patient-id" value="<?php echo $result['patient_id']; ?>">
								</div>
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label>Death Date <span class="form-required">*</span></label>
								<div class="input-group">
									<div class="input-group-prepend">
										<span class="input-group-text"><i class="ti-calendar"></i></span>
									</div>
									<input type="text" name="death[date]" class="form-control bg-white date" value="<?php echo date_format(date_create($result['date']), $common['info']['date_format']); ?>" placeholder="Enter Death date . . ." readonly required autocomplete="off">
								</div>
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label>Death Time <span class="form-required">*</span></label>
								<div class="input-group">
									<div class="input-group-prepend">
										<span class="input-group-text"><i class="ti-alarm-clock"></i></span>
									</div>
									<input type="time" name="death[time]" class="form-control" value="<?php echo $result['time']; ?>" placeholder="Enter Death Time . . ." required>
								</div>
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label>Gender <span class="form-required">*</span></label>
								<div class="input-group">
									<div class="input-group-prepend">
										<span class="input-group-text"><i class="ti-face-smile"></i></span>
									</div>
									<select name="death[gender]" class="custom-select" required>
										<option value="Male" <?php if ($result['gender'] == "Male") { echo "selected"; } ?>>Male</option>
										<option value="Female" <?php if ($result['gender'] == "Female") { echo "selected"; } ?>>Female</option>
										<option value="Other" <?php if ($result['gender'] == "Other") { echo "selected"; } ?>>Other</option>
									</select>
								</div>
							</div>
						</div>
						<div class="col-md-8"></div>
						<div class="col-md-4">
							<div class="form-group">
								<label>Guardian Name <span class="form-required">*</span></label>
								<div class="input-group">
									<div class="input-group-prepend">
										<span class="input-group-text"><i class="ti-tag"></i></span>
									</div>
									<input type="text" name="death[guardian_name]" class="form-control" value="<?php echo $result['guardian_name']; ?>" placeholder="Enter Guardian Name . . ." required>
								</div>
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label>Guardian Email Address</label>
								<div class="input-group">
									<div class="input-group-prepend">
										<span class="input-group-text"><i class="ti-email"></i></span>
									</div>
									<input type="text" name="death[guardian_email]" class="form-control" value="<?php echo $result['guardian_email']; ?>" placeholder="Enter Guardian Email Address . . .">
								</div>
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label>Guardian Mobile Number</label>
								<div class="input-group">
									<div class="input-group-prepend">
										<span class="input-group-text"><i class="ti-mobile"></i></span>
									</div>
									<input type="text" name="death[guardian_mobile]" class="form-control" value="<?php echo $result['guardian_mobile']; ?>" placeholder="Enter Guardian Mobile Number . . .">
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="tab-pane" id="birth-remark">
					<div class="form-group">
						<label>Report/Remark</label>
						<textarea name="death[remark]" class="mail-summernote"><?php echo $result['remark']; ?></textarea>
					</div>
				</div>
			</div>
		</div>
		<input type="hidden" name="death[id]" value="<?php echo $result['id'];?>">
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

	$(".patient-name").autocomplete({
		source: '<?php echo URL_ADMIN.DIR_ROUTE.'patient/search'; ?>',
		minLength: 2,
		focus: function() {return false;},
		select: function( event, ui ) {
			$('.patient-id').val(ui.item.id);
			$('.patient-name').val(ui.item.label);
			return false;
		}
	});
</script>
<!-- Footer -->
<?php include (DIR_ADMIN.'app/views/common/footer.tpl.php'); ?>