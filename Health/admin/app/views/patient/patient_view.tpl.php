<?php include (DIR_ADMIN.'app/views/common/header.tpl.php'); ?>

<link rel="stylesheet" href="public/css/jquery.fancybox.min.css">
<script src="public/js/jquery.fancybox.min.js"></script>

<div class="page-title">
	<div class="row align-items-center">
		<div class="col-sm-6">
			<h2 class="page-title-text d-inline-block">Patient View</h2>
			<div class="breadcrumbs d-inline-block">
				<ul>
					<li><a href="<?php echo URL_ADMIN; ?>">Dashboard</a></li>
					<li><a href="<?php echo URL_ADMIN.DIR_ROUTE.'patients'; ?>">Patients</a></li>
					<li><?php echo $result['firstname'].' '.$result['lastname']; ?></li>
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
					<span><?php echo $result['firstname'][0]; ?></span>
				</div>
				<div class="user-details text-center pt-3">
					<h3><?php echo $result['firstname'].' '.$result['lastname']; ?></h3>
					<ul class="v-menu text-left pt-3 nav d-block">
						<li><a href="#patient-info" class="active" data-toggle="tab"><i class="ti-info-alt"></i> <span>Patient Info</span></a></li>
						<?php if ($page_notes) { ?>
							<li><a href="#patient-notes" data-toggle="tab"><i class="ti-files"></i> <span>Clinical Notes</span></a></li>
						<?php } if ($page_documents) { ?>
							<li><a href="#patient-documents" data-toggle="tab"><i class="ti-archive"></i> <span>Documents</span></a></li>
						<?php } if ($page_prescriptions) { ?>
							<li><a href="#patient-prescription" data-toggle="tab"><i class="ti-notepad"></i> <span>Prescription</span></a></li>
						<?php } if ($page_appointments) { ?>
							<li><a href="#patient-appointment" data-toggle="tab"><i class="ti-calendar"></i> <span>Appointments</span></a></li>
						<?php } if ($page_invoices) { ?>
							<li><a href="#patient-invoice" data-toggle="tab"><i class="ti-receipt"></i> <span>Invoices</span></a></li>

						<?php } if ($page_edit) { ?>
							<li><a href="<?php echo URL_ADMIN.DIR_ROUTE.'patient/edit&id='.$result['id']; ?>"><i class="ti-pencil-alt"></i> <span>Edit Patient</span></a></li>
						<?php } if ($page_sendmail) { ?>
							<li><a href="#patient-sendmail" data-toggle="tab"><i class="ti-email"></i> <span>Send Email</span></a></li>
						<?php } ?>
					</ul>
				</div>
			</div>
		</div>
	</div>
	<div class="col-md-8">
		<div class="tab-content">
			<div class="tab-pane fade show active" id="patient-info">
				<div class="panel panel-default">
					<div class="panel-head">
						<div class="panel-title">Patient Info</div>  
					</div>
					<div class="panel-body">
						<table class="table table-striped patient-table">
							<tbody>
								<tr>
									<td>Email Address</td>
									<td><?php echo $result['email']; ?></td>
								</tr>
								<tr>
									<td>Mobile Number</td>
									<td><?php echo $result['mobile']; ?></td>
								</tr>
								<tr>
									<td>Date of Birth</td>
									<td><?php if (!empty($result['dob'])) { echo date_format(date_create($result['dob']), $common['info']['date_format']). '('.$result['age'].' years)'; } ?> </td>
									<?php if (!empty($value['dob'])) { echo date_format(date_create($value['dob']), $common['info']['date_format']); } ?>
								</tr>
								<tr>
									<td>Gender</td>
									<td><?php echo $result['gender']; ?></td>
								</tr>
								<tr>
									<td>Blood Group</td>
									<td><?php echo $result['bloodgroup']; ?></td>
								</tr>
								<tr>
									<td>Address</td>
									<td><?php if (!empty($result['address'])) { echo implode(', ', $result['address']); } ?></td>
								</tr>
								<tr>
									<td>Medical History</td>
									<td><?php if (!empty($result['history'])) { echo implode(', ', $result['history']); } ?></td>
								</tr>
								<tr>
									<td>Other History</td>
									<td><?php echo $result['other']; ?></td>
								</tr>
								<tr>
									<td>Email Confirmation</td>
									<?php if ($result['emailconfirmed'] == '0') { ?>
										<td class="text-danger">Unconfirmed</td>
									<?php  } else { ?>
										<td class="text-success">Confirmed</td>
									<?php } ?>
								</tr>
								<tr>
									<td>Status</td>
									<?php if ($result['status'] == '0') { ?>
										<td class="text-danger">Inactive</td>
									<?php  } else { ?>
										<td class="text-success">Active</td>
									<?php } ?>
								</tr>
								<tr>
									<td>Created Date</td>
									<td><?php echo date_format(date_create($result['date_of_joining']), $common['info']['date_format']); ?></td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
			</div>
			<?php if ($page_appointments) { ?>
				<div class="tab-pane fade" id="patient-appointment">
					<div class="panel panel-default">
						<div class="panel-head">
							<div class="panel-title">Patient's Appointments</div>
							<div class="panel-action">
								<?php if ($appointment_add) { ?>
									<a class="btn btn-primary btn-sm appointment-sidebar"><i class="ti-plus pr-2"></i> New Appointment</a>
								<?php } ?>
							</div>
						</div>
						<div class="panel-body">
							<table class="table table-middle table-bordered table-striped datatable-table">
								<thead>
									<tr class="table-heading">
										<th class="table-srno">#</th>
										<th>DoctorInfo</th>
										<th>DateTime</th>
										<th>Status</th>
										<?php if ($appointment_view) { ?>
											<th></th>
										<?php } ?>
									</tr>
								</thead>
								<tbody>
									<?php if (!empty($appointments)) { foreach ($appointments as $key => $value) { ?>
										<tr>
											<td><?php echo $key+1; ?></td>
											<td class="text-primary">Dr. <?php echo $value['doctor']; ?></td>
											<td><?php echo date_format(date_create($value['date']), $common['info']['date_format']).' AT '.$value['time']; ?></td>
											<td>
												<?php if ($value['status'] == 1) {
													echo '<span class="label label-danger">Cancelled</span>';
												} elseif ($value['status'] == 2) {
													echo '<span class="label label-warning">In process</span>';
												} elseif ($value['status'] == 3) {
													echo '<span class="label label-success">Confirmed</span>';
												} elseif ($value['status'] == 4) {
													echo '<span class="label label-info">Completed</span>';
												} else {
													echo '<span class="label label-primary">New</span>';
												} ?>
											</td>
											<?php if ($appointment_view) { ?>
												<td class="table-action">
													<?php if ($appointment_view) { ?>
														<a href="<?php echo URL_ADMIN.DIR_ROUTE.'appointment/view&id='.$value['id'];?>" class="text-primary edit" data-toggle="tooltip" title="View" target="_blank"><i class="ti-layout-media-center-alt"></i></a>
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
			<?php } if ($page_invoices) { ?>
				<div class="tab-pane fade" id="patient-invoice">
					<div class="panel panel-default">
						<div class="panel-head">
							<div class="panel-title">Patient's Invoices</div>
							<div class="panel-action">
								<?php if ($invoice_add) { ?>
									<a href="<?php echo URL_ADMIN.DIR_ROUTE.'invoice/add'; ?>" class="btn btn-primary btn-sm" target="_blank"><i class="ti-plus pr-2"></i> New Invoice</a>
								<?php } ?>
							</div>
						</div>
						<div class="panel-body">
							<table class="table table-middle table-bordered table-striped datatable-table">
								<thead>
									<tr>
										<th>ID</th>
										<th>Amount</th>
										<th>Due</th>
										<th>Status</th>
										<th>InvoiceDate</th>
										<?php if ($invoice_view || $invoice_delete) { ?>
											<th></th>
										<?php } ?>
									</tr>
								</thead>
								<tbody>
									<?php if (!empty($invoices)) { foreach ($invoices as $key => $value) { ?>
										<tr>
											<td><?php echo $common['info']['invoice_prefix'].str_pad($value['id'], 4, '0', STR_PAD_LEFT); ?></td>
											<td><?php echo $common['info']['currency_abbr'].$value['amount']; ?></td>
											<td><?php echo $common['info']['currency_abbr'].$value['due']; ?></td>
											<td>
												<?php if ($value['status'] == "Paid") { ?>
													<span class="label label-success">Paid</span>
												<?php } elseif ($value['status'] == "Unpaid") { ?>
													<span class="label label-danger">Unpaid</span>
												<?php } elseif ($value['status'] == "Pending") { ?>
													<span class="label label-secondary">Pending</span>
												<?php } elseif ($value['status'] == "In Process") { ?>
													<span class="label label-primary">In Process</span>
												<?php } elseif ($value['status'] == "Cancelled") { ?>
													<span class="label label-warning">Cancelled</span>
												<?php } elseif ($value['status'] == "Other") { ?>
													<span class="label label-default">Other</span>
												<?php } elseif ($value['status'] == "Partially Paid") { ?>
													<span class="label label-info badge-pill badge-sm">Partially Paid</span>
												<?php } else { ?>
													<span class="label label-white">Unknown</span>
												<?php } ?>
											</td>
											<td><?php echo date_format(date_create($value['invoicedate']), $common['info']['date_format']); ?></td>
											<?php if ($invoice_view || $invoice_delete) { ?>
												<td class="table-action">
													<?php if ($invoice_view) { ?>
														<a href="<?php echo URL_ADMIN.DIR_ROUTE.'invoice/view&id='.$value['id'];?>" class="text-primary edit" data-toggle="tooltip" title="View" target="_blank"><i class="ti-layout-media-center-alt"></i></a>
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
			<?php } if ($page_notes) { ?>
				<div class="tab-pane fade" id="patient-notes">
					<div class="panel panel-default">
						<div class="panel-head">
							<div class="panel-title">Clinical Notes</div>  
						</div>
						<div class="panel-body">
							<div class="notes-container">
								<?php if (!empty($notes)) { ?>
									<div class="timeline-1 timeline-2">
										<div class="marker"></div>
										<?php foreach ($notes as $key => $value) { 
											$value['notes'] = json_decode($value['notes'], true); ?>
											<div class="item item-left pb-4">
												<div class="circle"><img src="<?php echo '../public/uploads/'.$value['picture']; ?>" alt=""></div>
												<div class="arrow"></div>
												<div class="time"><?php echo 'Dr. '.$value['doctor'].' ('.date_format(date_create($value['date_of_joining']), $common['info']['date_format']).')'; ?></div>
												<div class="item-content">
													<?php foreach ($value['notes'] as $k => $v) { ?>
														<div class="text-primary pt-1"><?php echo ucfirst($k); ?></div>
														<div class="descr pt-0">
															<?php foreach ($v as $s_key => $s_value) { ?>
																<li><?php echo html_entity_decode($s_value, ENT_QUOTES, 'UTF-8'); ?></li>
															<?php } ?>
														</div>
													<?php } ?>
													<div class="text-secondary mt-2 text-right">
														<a href="<?php echo URL_ADMIN.DIR_ROUTE.'records/pdf&id='.$value['id']; ?>" class="text-primary" target="_blank">PDF/Print</a>
													</div>
												</div>
											</div>
										<?php } ?>

									</div>
								<?php } else { ?>
									<div class="text-danger text-center">No Record Found !!!</div>
								<?php } ?>
							</div>
						</div>
					</div>
				</div>
			<?php } if ($page_documents) { ?>
			<div class="tab-pane fade" id="patient-documents">
				<div class="panel panel-default">
					<div class="panel-head">
						<div class="panel-title">Documents/Reports</div>  
					</div>
					<div class="panel-body">
						<?php if (!empty($reports)) { ?>
							<div class="report-container">
								<?php foreach ($reports as $key => $value) {  $file_ext = pathinfo($value['report'], PATHINFO_EXTENSION); if ($file_ext == "pdf") { ?>
									<div class="report-image report-pdf">
										<a href="../public/uploads/reports/<?php echo $value['report']; ?>" class="open-pdf">
											<img src="../public/images/pdf.png" alt="Reports">
											<span><?php echo $value['name']; ?></span>
											<p><?php echo date_format(date_create($value['date_of_joining']), $common['info']['date_format']); ?></p>
										</a>
									</div>
								<?php } else { ?>
									<div class="report-image">
										<a data-fancybox="gallery" href="../public/uploads/reports/<?php echo $value['report']; ?>">
											<img src="../public/uploads/reports/<?php echo $value['report']; ?>" alt="Reports">
											<span><?php echo $value['name']; ?></span>
											<p><?php echo date_format(date_create($value['date_of_joining']), $common['info']['date_format']); ?></p>
										</a>
									</div>
								<?php } } ?>
							</div>
						<?php } else { ?>
							<p class="text-danger text-center">No Documents Found !!!</p>
						<?php } ?>
					</div>
				</div>
			</div>
			<?php } if ($page_prescriptions) { ?>
			<div class="tab-pane fade" id="patient-prescription">
				<div class="panel panel-default">
					<div class="panel-head">
						<div class="panel-title">Prescription</div>  
					</div>
					<div class="panel-body">
						<div class="timeline-1 timeline-2">
							<div class="marker"></div>
							<?php if (!empty($prescriptions)) { foreach ($prescriptions as $key => $value) { $value['prescription'] = json_decode($value['prescription'], true); if (!empty($value['prescription'][$key]['name'])) { ?>
								<div class="item item-left pb-4">
									<div class="circle"><img src="<?php echo '../public/uploads/'.$value['d_picture']; ?>" alt=""></div>
									<div class="arrow"></div>
									<div class="time"><?php echo 'Dr. '.$value['doctor'].' ('.date_format(date_create($value['date_of_joining']), $common['info']['date_format']).')'; ?></div>
									<div class="item-content">
										<div class="table-responsive">
											<table class="table table-bordered">
												<tr>
													<th>Medicine Name</th>
													<th>Dose</th>
													<th>Duration</th>
													<th>Instruction</th>
												</tr>
												<?php foreach ($value['prescription'] as $s_key => $s_value) { ?>
													<tr>
														<td>
															<p class="text-primary m-0"><?php echo html_entity_decode($s_value['name'], ENT_QUOTES, 'UTF-8'); ?></p>
															<p class="m-0"><?php echo html_entity_decode($s_value['generic'], ENT_QUOTES, 'UTF-8'); ?></p>
														</td>
														<td class="text-center"><p class="font-12"><?php echo $s_value['dose']; ?></p></td>
														<td class="text-center"><p class="font-12"><?php echo $s_value['duration'].' Day'; ?></p></td>
														<td class="text-center"><p class="font-12"><?php echo $s_value['instruction']; ?></p></td>
													</tr>
												<?php } ?>
											</table>
										</div>
										<div class="text-secondary mt-2 text-right">
											<a href="<?php echo URL_ADMIN.DIR_ROUTE.'prescription/pdf&id='.$value['id']; ?>" class="text-primary" target="_blank">PDF/Print</a>
										</div>
									</div>
								</div>
							<?php } } } ?>
						</div>
					</div>
				</div>
			</div>
			<?php } if ($page_sendmail) { ?>
				<div class="tab-pane fade" id="patient-sendmail">
					<div class="panel panel-default">
						<div class="panel-head">
							<div class="panel-title">Send Email to Patient</div>  
						</div>
						<form action="<?php echo URL_ADMIN.DIR_ROUTE.'patient/sendmail'; ?>" method="post">
							<input type="hidden" name="_token" value="<?php echo $common['token']; ?>" readonly>
							<div class="panel-body">
								<div class="form-group">
									<label>To</label>
									<input type="text" value="<?php echo $result['firstname'].' '.$result['lastname']; ?>" class="form-control" readonly>
									<input type="hidden" name="mail[id]" value="<?php echo $result['id']; ?>" readonly>
								</div>
								<div class="form-group">
									<label>Subject</label>
									<input type="text" name="mail[subject]" class="form-control" placeholder="Enter Subject . . .">
								</div>
								<div class="form-group">
									<label>Message</label>
									<textarea name="mail[message]" class="form-control mail-summernote" placeholder="Enter Message . . ."></textarea>
								</div>
							</div>
							<div class="panel-footer text-center">
								<button type="submit" name="submit" class="btn btn-primary">Send</button>
							</div>
						</form>
					</div>
				</div>
			<?php } ?>
		</div>
	</div>
</div>

<?php if ($appointment_add) { ?>
	<div class="sidebar sidebar-right appointmet-sidebar">
		<div class="sidebar-hdr">
			<div class="sidebar-close"><i class="ti-close"></i></div>
			<h3 class="title">Appointment</h3>
		</div>
		<form class="sidebar-bdy" action="<?php echo $action_new_appointment; ?>" method="post">
			<input type="hidden" name="_token" value="<?php echo $common['token']; ?>">
			<div id="apnt-info">
				<input type="hidden" class="apnt-id" name="appointment[id]">
				<div class="form-group mb-2">
					<label>Name</label>
					<div class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text"><i class="ti-timer"></i></span>
						</div>
						<input type="text" name="appointment[name]" class="form-control patient-name" value="<?php echo $result['firstname'].' '.$result['lastname']; ?>" placeholder="Enter Name . . ." required>
						<input type="hidden" name="appointment[patient_id]" value="<?php echo $result['id']; ?>" class="form-control patient-id">
					</div>
				</div>
				<div class="form-group mb-2">
					<label>Email Address</label>
					<div class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text"><i class="ti-timer"></i></span>
						</div>
						<input type="text" name="appointment[mail]" class="form-control patient-mail" value="<?php echo $result['email']; ?>" placeholder="Enter Email Address . . ." required>
					</div>
				</div>
				<div class="form-group mb-2">
					<label>Mobile Number</label>
					<div class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text"><i class="ti-timer"></i></span>
						</div>
						<input type="text" name="appointment[mobile]" class="form-control patient-mobile" value="<?php echo $result['mobile']; ?>" placeholder="Enter Mobile Number . . ." required>
					</div>
				</div>
				<div class="form-group mb-2">
					<label>Doctor</label>
					<div class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text"><i class="ti-timer"></i></span>
						</div>
						<select name="appointment[doctor]" class="custom-select apnt-doctor" data-live-search="true" required>
							<option value="">Select Doctor</option>
							<?php foreach ($doctors as $value) { ?>
								<option value="<?php echo $value['id']; ?>" data-department="<?php echo $value['department_id']; ?>" data-weekly="<?php echo htmlspecialchars($value['weekly'], ENT_QUOTES, 'UTF-8'); ?>" data-national="<?php echo htmlspecialchars($value['national'], ENT_QUOTES, 'UTF-8'); ?>"><?php echo $value['name'].' (' . $value['department'] . ')'; ?></option>
							<?php } ?>
						</select>
						<input type="hidden" class="apnt-department" name="appointment[department]" value="">
					</div>
				</div>
				<div class="form-group mb-2">
					<label>Date</label>
					<div class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text"><i class="ti-timer"></i></span>
						</div>
						<input type="text" name="appointment[date]" class="form-control apnt-date" value="" placeholder="Select Date . . ." required autocomplete="off">
					</div>
				</div>
				<div class="form-group mb-2">
					<label>Time</label>
					<div class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text"><i class="ti-timer"></i></span>
						</div>
						<input type="text" name="appointment[time]" class="form-control apnt-time" value="" required readonly>
						<input type="hidden" name="appointment[slot]" class="apnt-slot-time" value="" required>
					</div>
					<div class="apnt-slot"></div>
				</div>
				<div class="form-group">
					<label>Status</label>
					<div class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text"><i class="ti-check-box"></i></span>
						</div>
						<select name="appointment[status]" class="custom-select apnt-status" required>
							<option value="2">In Process</option>
							<option value="3">Confirmed</option>
							<option value="4">Completed</option>
							<option value="1">Cancelled</option>
						</select>
					</div>
				</div>
			</div>
			<div class="sidebar-ftr text-right">
				<a href="#" class="btn btn-default">View</a>
				<button type="submit" name="submit" class="btn btn-primary">Save</button>
			</div>
		</form>
	</div>
	<script type="text/javascript" src="public/js/appointment.js"></script>
<?php } ?>

<!-- include summernote css/js-->
<link href="public/css/summernote-bs4.css" rel="stylesheet">
<script type="text/javascript" src="public/js/summernote-bs4.min.js"></script>
<script type="text/javascript" src="public/js/klinikal.summernote.js"></script>

<script>
	$("a.open-pdf").fancybox({
		'frameWidth': 800,
		'frameHeight': 800,
		'overlayShow': true,
		'hideOnContentClick': false,
		'type': 'iframe'
	});
</script>
<!-- Footer -->
<?php include (DIR_ADMIN.'app/views/common/footer.tpl.php'); ?>