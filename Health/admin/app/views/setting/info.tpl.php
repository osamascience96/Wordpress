<?php include (DIR_ADMIN.'app/views/common/header.tpl.php'); ?>
<div class="page-title">
	<div class="row align-items-center">
		<div class="col-sm-6">
			<h2 class="page-title-text d-inline-block"><?php echo $page_title; ?></h2>
			<div class="breadcrumbs d-inline-block">
				<ul>
					<li><a href="#">Home</a></li>
					<li><?php echo $page_title; ?></li>
				</ul>
			</div>
		</div>
		<div class="col-sm-6 text-right">
		</div>
	</div>
</div>
<form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data">
	<input type="hidden" name="_token" value="<?php echo $token; ?>">
	<div class="panel panel-default">
		<div class="panel-body">
			<ul class="nav nav-tabs nav-tabs-line nav-tabs-line-primary">
				<li class="nav-item">
					<a class="nav-link active" href="#setting-info" data-toggle="tab">Basic Info</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="#setting-address" data-toggle="tab">Address</a>
				</li>
				<li class="nav-item">  
					<a class="nav-link" href="#settings-sociallink" data-toggle="tab">Social Link</a>
				</li>
			</ul>
			<div class="tab-content pt-4">
				<div class="tab-pane active" id="setting-info">
					<div class="row">
						<div class="col-md-6">
							<div class="row pb-2">
								<div class="col-md-6">
									<div class="form-group">
										<label class="d-block">Logo</label>
										<div class="image-upload" <?php if (!empty($siteinfo['logo'])) { echo " style=\"display: none\" "; }?> >
											<a>Upload</a>
										</div>
										<div class="saved-picture" <?php if (empty($siteinfo['logo'])) { echo " style=\"display: none\" "; } ?> >
											<?php if (!empty($siteinfo['logo'])) { ?>
												<img class="img-thumbnail" src="../public/uploads/<?php echo $siteinfo['logo']; ?>" alt="">
											<?php } ?>
											<input type="hidden" name="info[logo]" value="<?php echo $siteinfo['logo']; ?>">
										</div>
										<div class="saved-picture-delete" data-toggle="tooltip" data-placement="right" title="Remove" <?php if (empty($siteinfo['logo'])) { echo " style=\"display: none\" "; } ?> >
											<a class="fa fa-times"></a>
										</div>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label class="d-block">Favicon</label>
										<div class="image-upload" <?php if (!empty($siteinfo['favicon'])){echo " style=\"display: none\" ";}?> >
											<a>Upload</a>
										</div>
										<div class="saved-picture" <?php if (empty($siteinfo['favicon'])) {echo " style=\"display: none\" ";}?> >
											<?php if (!empty($siteinfo['favicon'])) { ?>
												<img class="img-thumbnail" src="../public/uploads/<?php echo $siteinfo['favicon']; ?>" alt="">
											<?php } ?>
											<input type="hidden" name="info[favicon]" value="<?php echo $siteinfo['favicon']; ?>">
										</div>
										<div class="saved-picture-delete" data-toggle="tooltip" data-placement="right" title="Remove" <?php if (empty($siteinfo['favicon'])) { echo " style=\"display: none\" "; } ?> >
											<a class="fa fa-times"></a>
										</div>
									</div>
								</div>
							</div>
							<div class="form-group">
								<label>Clinic Name <span class="form-required">*</span></label>
								<div class="input-group">
									<div class="input-group-prepend">
										<span class="input-group-text"><i class="ti-tag"></i></span>
									</div>
									<input type="text" name="info[name]" class="form-control" value="<?php echo $siteinfo['name']; ?>" placeholder="Enter Clinic Name . . ." required>
								</div>
							</div>
							<div class="form-group">
								<label>Clinic Legal Name <span class="form-required">*</span></label>
								<div class="input-group">
									<div class="input-group-prepend">
										<span class="input-group-text"><i class="ti-id-badge"></i></span>
									</div>
									<input type="text" name="info[legal_name]" class="form-control" value="<?php echo $siteinfo['legal_name']; ?>" placeholder="Enter Clinic Legal Name . . ." required>
								</div>
							</div>
							<div class="form-group">
								<label>Email Address <span class="form-required">*</span></label>
								<div class="input-group">
									<div class="input-group-prepend">
										<span class="input-group-text"><i class="ti-email"></i></span>
									</div>
									<input type="email" name="info[mail]" class="form-control" value="<?php echo $siteinfo['mail']; ?>" placeholder="Enter Email Address . . ." required>
								</div>
							</div>
							<div class="form-group">
								<label>Phone Number <span class="form-required">*</span></label>
								<div class="input-group">
									<div class="input-group-prepend">
										<span class="input-group-text"><i class="ti-mobile"></i></span>
									</div>
									<input type="text" name="info[phone]" class="form-control" value="<?php echo $siteinfo['phone']; ?>" placeholder="Enter Phone Number . . ." required>
								</div>
							</div>
							<div class="form-group">
								<label>Emergency Number</label>
								<div class="input-group">
									<div class="input-group-prepend">
										<span class="input-group-text"><i class="ti-headphone-alt"></i></span>
									</div>
									<input type="text" name="info[emergency]" class="form-control" value="<?php echo $siteinfo['emergency']; ?>" placeholder="Enter Emergency Number . . .">
								</div>
							</div>
						</div>
						<div class="col-md-6">
							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<label>Site Mode <span class="form-required">*</span></label>
										<div class="input-group">
											<div class="input-group-prepend"><span class="input-group-text"><i class="ti-settings"></i></span></div>
											<select name="info[mode]" class="custom-select" required>
												<option value="1" <?php if ($siteinfo['mode'] == 1) { echo "selected"; } ?> >Live</option>
												<option value="2" <?php if ($siteinfo['mode'] == 2) { echo "selected"; } ?>>Comming Soon</option>
												<option value="3" <?php if ($siteinfo['mode'] == 3) { echo "selected"; } ?>>Maintenance mode</option>
											</select>
										</div>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label>Theme Color</label>
										<div class="input-group">
											<div class="input-group-prepend">
												<span class="input-group-text"><i class="ti-paint-bucket"></i></span>
											</div>
											<select name="info[color]" class="custom-select">
												<option value="blue" <?php if ($siteinfo['color'] == 'blue') { echo "selected"; } ?> >Blue</option>
												<option value="green" <?php if ($siteinfo['color'] == 'green') { echo "selected"; } ?>>Green</option>
												<option value="orange" <?php if ($siteinfo['color'] == 'orange') { echo "selected"; } ?>>Orange</option>
												<option value="purple" <?php if ($siteinfo['color'] == 'purple') { echo "selected"; } ?>>Purple</option>
											</select>
										</div>
									</div>
								</div>
							</div>
							<div class="form-group">
								<label>Language</label>
								<div class="input-group">
									<div class="input-group-prepend">
										<span class="input-group-text"><i class="ti-world"></i></span>
									</div>
									<select name="info[language]" class="custom-select">
										<option value="en" <?php if ($siteinfo['language'] == "en") { echo "selected"; } ?>>English</option>
										<option value="custom" <?php if ($siteinfo['language'] == "custom") { echo "selected"; } ?>>Local Language</option>
									</select>
								</div>
							</div>
							<div class="form-group">
								<label>Google Analytics ID</label>
								<div class="input-group">
									<div class="input-group-prepend">
										<span class="input-group-text"><i class="ti-world"></i></span>
									</div>
									<input type="text" name="info[ga]" class="form-control" value="<?php echo $siteinfo['ga']; ?>" placeholder="Tracking ID (UA-XXXXX-Y)">
								</div>
							</div>
							<div class="form-group">
								<label>Timezone</label>
								<div class="input-group">
									<div class="input-group-prepend">
										<span class="input-group-text"><i class="ti-calendar"></i></span>
									</div>
									<select name="info[timezone]" class="custom-select">
										<?php foreach ($timezone as $key => $value) { ?>
											<option value="<?php echo $key; ?>" <?php if ($siteinfo['timezone'] == $key) { echo "selected"; } ?>><?php echo $value; ?></option>
										<?php } ?>
									</select>
								</div>
							</div>
							<div class="form-group">
								<label>Date Format</label>
								<div class="row">
									<div class="col-md-6">
										<div class="input-group">
											<div class="input-group-prepend">
												<span class="input-group-text"><i class="ti-timer"></i></span>
											</div>
											<select name="info[date_format]" class="custom-select">
												<option value="d/m/Y" <?php if ($siteinfo['date_format'] == 'd/m/Y') { echo "selected"; } ?>><?php echo 'd/m/Y'.' ( '.date("d/m/Y").' ) '; ?></option>
												<option value="d.m.Y" <?php if ($siteinfo['date_format'] == 'd.m.Y') { echo "selected"; } ?>><?php echo 'd.m.Y'.' ( '.date("d.m.Y").' ) '; ?></option>
												<option value="d-m-Y" <?php if ($siteinfo['date_format'] == 'd-m-Y') { echo "selected"; } ?>><?php echo 'd-m-Y'.' ( '.date("d-m-Y").' ) '; ?></option>
												<option value="m/d/Y" <?php if ($siteinfo['date_format'] == 'm/d/Y') { echo "selected"; } ?>><?php echo 'm/d/Y'.' ( '.date("m/d/Y").' ) '; ?></option>
												<option value="m-d-Y" <?php if ($siteinfo['date_format'] == 'm-d-Y') { echo "selected"; } ?>><?php echo 'm-d-Y'.' ( '.date("m-d-Y").' ) '; ?></option>
												<option value="Y/m/d" <?php if ($siteinfo['date_format'] == 'Y/m/d') { echo "selected"; } ?>><?php echo 'Y/m/d'.' ( '.date("Y/m/d").' ) '; ?></option>
												<option value="Y-m-d" <?php if ($siteinfo['date_format'] == 'Y-m-d') { echo "selected"; } ?>><?php echo 'Y-m-d'.' ( '.date("Y-m-d").' ) '; ?></option>
											</select>
										</div>
									</div>
									<div class="col-md-6">
										<div class="input-group">
											<div class="input-group-prepend">
												<span class="input-group-text"><i class="ti-timer"></i></span>
											</div>
											<select name="info[date_my_format]" class="custom-select">
												<option value="m-Y" <?php if ($siteinfo['date_my_format'] == 'm-Y') { echo "selected"; } ?>><?php echo 'm-Y'.' ( '.date("m-Y").' ) '; ?></option>
												<option value="m/Y" <?php if ($siteinfo['date_my_format'] == 'm/Y') { echo "selected"; } ?>><?php echo 'm/Y'.' ( '.date("m/Y").' ) '; ?></option>
												<option value="Y/m" <?php if ($siteinfo['date_my_format'] == 'Y/m') { echo "selected"; } ?>><?php echo 'Y/m'.' ( '.date("Y/m").' ) '; ?></option>
												<option value="Y-m" <?php if ($siteinfo['date_my_format'] == 'Y-m') { echo "selected"; } ?>><?php echo 'Y-m'.' ( '.date("Y-m").' ) '; ?></option>
											</select>
										</div>
									</div>
								</div>
							</div>
							
							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<label>Currency Code</label>
										<div class="input-group">
											<div class="input-group-prepend">
												<span class="input-group-text"><i class="ti-timer"></i></span>
											</div>
											<input type="text" name="info[currency]" class="form-control" value="<?php echo $siteinfo['currency'] ?>" placeholder="Currency Code . . .">
										</div>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label>Currency Abbreviation</label>
										<div class="input-group">
											<div class="input-group-prepend">
												<span class="input-group-text"><i class="ti-timer"></i></span>
											</div>
											<input type="text" name="info[currency_abbr]" class="form-control" value="<?php echo $siteinfo['currency_abbr'] ?>" placeholder="Currency Abbreviation . . .">
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="dotted-seprator mt-3 mb-4"></div>
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label>Appointment Prefix</label>
								<div class="input-group">
									<div class="input-group-prepend">
										<span class="input-group-text"><i class="ti-flag"></i></span>
									</div>
									<input type="text" name="info[appointment_prefix]" class="form-control" value="<?php echo $siteinfo['appointment_prefix']; ?>" placeholder="Enter Appointment Prefix . . .">
								</div>
							</div>
						</div>
					</div>
					<div class="dotted-seprator mt-3 mb-4"></div>
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label>Invoice Prefix</label>
								<div class="input-group">
									<div class="input-group-prepend">
										<span class="input-group-text"><i class="ti-flag"></i></span>
									</div>
									<input type="text" name="info[invoice_prefix]" class="form-control" value="<?php echo $siteinfo['invoice_prefix']; ?>" placeholder="Enter Invoice Prefix . . .">
								</div>
							</div>
						</div>
						<div class="col-md-3">
							<div class="form-group">
								<label>Predefined Customer Note</label>
								<div class="input-group">
									<div class="input-group-prepend">
										<span class="input-group-text"><i class="ti-flag"></i></span>
									</div>
									<textarea name="info[invoice_cnote]" class="form-control" placeholder="Invoice Predefined Customer Note"><?php echo $siteinfo['invoice_cnote']; ?></textarea>
								</div>
							</div>
						</div>
						<div class="col-md-3">
							<div class="form-group">
								<label>Predefined Terms & Conditions</label>
								<div class="input-group">
									<div class="input-group-prepend">
										<span class="input-group-text"><i class="ti-flag"></i></span>
									</div>
									<textarea name="info[invoice_tc]" class="form-control" placeholder="Invoice Terms & Conditions"><?php echo $siteinfo['invoice_tc']; ?></textarea>
								</div>
							</div>
						</div>
					</div>
					<div class="dotted-seprator mt-3 mb-4"></div>
					<div class="row">
						<div class="col-md-3">
							<div class="form-group invoice-template-img">
								<label>Prescription Template</label>
								<div>
									<div class="custom-control custom-radio custom-radio-1 d-inline-block">
										<input type="radio" name="info[prescription_template]" class="custom-control-input" value="1" id="prescription_template-template-1" <?php if ($siteinfo['prescription_template'] == '1') { echo "checked"; } ?>>
										<label class="custom-control-label" for="prescription_template-template-1"><img src="public/images/invoice-1.png" alt="Invoice Template 1"></label>
									</div>
									<div class="custom-control custom-radio custom-radio-1 d-inline-block">
										<input type="radio" name="info[prescription_template]" class="custom-control-input" value="2" id="prescription_template-template-2" <?php if ($siteinfo['prescription_template'] == '2') { echo "checked"; } ?>>
										<label class="custom-control-label" for="prescription_template-template-2"><img src="public/images/invoice-2.png" alt="Invoice Template 1"></label>
									</div>
								</div>
							</div>
						</div>
						<div class="col-md-3">
							<div class="form-group invoice-template-img">
								<label>Invoice Template</label>
								<div>
									<div class="custom-control custom-radio custom-radio-1 d-inline-block">
										<input type="radio" name="info[invoice_template]" class="custom-control-input" value="1" id="invoice-template-1" <?php if ($siteinfo['invoice_template'] == '1') { echo "checked"; } ?>>
										<label class="custom-control-label" for="invoice-template-1"><img src="public/images/invoice-1.png" alt="Invoice Template 1"></label>
									</div>
									<div class="custom-control custom-radio custom-radio-1 d-inline-block">
										<input type="radio" name="info[invoice_template]" class="custom-control-input" value="2" id="invoice-template-2" <?php if ($siteinfo['invoice_template'] == '2') { echo "checked"; } ?>>
										<label class="custom-control-label" for="invoice-template-2"><img src="public/images/invoice-2.png" alt="Invoice Template 1"></label>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="dotted-seprator mt-3 mb-4"></div>
					<div class="row">
						<div class="col-md-12">
							<label class="col-form-label mr-3 mb-0">Doctor Access</label>
							<div class="custom-control custom-checkbox custom-checkbox-1 d-inline-block">
								<input type="checkbox" name="info[doctor_access]" class="custom-control-input" value="1" id="doctor_access" <?php if ($siteinfo['doctor_access'] == '1') { echo "checked"; } ?>>
								<label class="custom-control-label" for="doctor_access">Doctor can see only their data like Patient, Appointment, Invoice and Prescription.</label>
							</div>
							<span class="form-text">By Enabling this option. doctor can see only their own data which is created by doctor or doctor have their name in. For example, One appointment is made by patient or admin staff for one doctor then that doctor can see that appointment and patient history (All history).</span>
							<span class="form-text">By Disabling this, Doctor can see all Patient, Appointment, Invoice and Prescription.</span>
						</div>
					</div>
				</div>
				<div class="tab-pane" id="setting-address">
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label>Address Line 1</label>
								<div class="input-group">
									<div class="input-group-prepend">
										<span class="input-group-text"><i class="ti-location-pin"></i></span>
									</div>
									<input type="text" name="info[address][address1]" class="form-control" value="<?php echo $siteinfo['address']['address1']; ?>" placeholder="Enter Address Line 1 . . .">
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
									<input type="text" name="info[address][address2]" class="form-control" value="<?php echo $siteinfo['address']['address2']; ?>" placeholder="Enter Address Line 2 . . .">
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
									<input type="text" name="info[address][city]" class="form-control" value="<?php echo $siteinfo['address']['city']; ?>" placeholder="Enter City . . .">
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
									<input type="text" name="info[address][country]" class="form-control" value="<?php echo $siteinfo['address']['country']; ?>" placeholder="Enter Country . . .">
								</div>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label>Postal/ZIP Code</label>
								<div class="input-group">
									<div class="input-group-prepend">
										<span class="input-group-text"><i class="ti-pin"></i></span>
									</div>
									<input type="text" name="info[address][postal]" class="form-control" value="<?php echo $siteinfo['address']['postal']; ?>" placeholder="Enter Postal/ZIP Code . . .">
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="tab-pane" id="settings-sociallink">
					<div class="row">
						<div class="col-md-6 col-lg-4">
							<div class="form-group">
								<label>Facebook</label>
								<input type="text" name="sociallink[facebook]" value="<?php echo $sociallink['facebook']; ?>" placeholder="Enter Facebook Social Link . . .">
							</div>
						</div>
						<div class="col-md-6 col-lg-4">
							<div class="form-group">
								<label>Twitter</label>
								<input type="text" name="sociallink[twitter]" value="<?php echo $sociallink['twitter']; ?>" placeholder="Enter Twitter Social Link . . .">
							</div>
						</div>
						<div class="col-md-6 col-lg-4">
							<div class="form-group">
								<label>Google +</label>
								<input type="text" name="sociallink[google]" value="<?php echo $sociallink['google']; ?>" placeholder="Enter Google + Social Link . . .">
							</div>
						</div>
						<div class="col-md-6 col-lg-4">
							<div class="form-group">
								<label>Instagram</label>
								<input type="text" name="sociallink[instagram]" value="<?php echo $sociallink['instagram']; ?>" placeholder="Enter Instagram Social Link . . .">
							</div>
						</div>
						<div class="col-md-6 col-lg-4">
							<div class="form-group">
								<label>Youtube</label>
								<input type="text" name="sociallink[youtube]" value="<?php echo $sociallink['youtube']; ?>" placeholder="Enter Youtube Social Link . . .">
							</div>
						</div>
						<div class="col-md-6 col-lg-4">
							<div class="form-group">
								<label>Linkedin</label>
								<input type="text" name="sociallink[linkedin]" value="<?php echo $sociallink['linkedin']; ?>" placeholder="Enter Linkedin Social Link . . .">
							</div>
						</div>
						<div class="col-md-6 col-lg-4">
							<div class="form-group">
								<label>Flickr</label>
								<input type="text" name="sociallink[flickr]" value="<?php echo $sociallink['flickr']; ?>" placeholder="Enter Flickr Social Link . . .">
							</div>
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