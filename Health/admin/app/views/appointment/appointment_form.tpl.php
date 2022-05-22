<?php include (DIR_ADMIN.'app/views/common/header.tpl.php'); ?>
<link rel="stylesheet" href="public/css/jquery.fancybox.min.css">
<script src="public/js/jquery.fancybox.min.js"></script>
<script src="public/js/appointment.js"></script>
<div class="page-title">
	<div class="row align-items-center">
		<div class="col-sm-6">
			<h2 class="page-title-text d-inline-block"><?php echo $page_title; ?></h2>
			<div class="breadcrumbs">
				<ul>
					<li><a href="<?php echo URL_ADMIN; ?>">Dashboard</a></li>
					<li><a href="<?php echo URL_ADMIN.DIR_ROUTE.'appointments'; ?>">Appointments</a></li>
					<li><?php echo $page_title; ?></li>
				</ul>
			</div>
		</div>
		<div class="col-sm-6 text-right">
			<a href="<?php echo URL_ADMIN.DIR_ROUTE.'appointment/view&id='.$result['id']; ?>" class="btn btn-white btn-sm"><i class="ti-calendar text-primary mr-2"></i> View Appointment</a>
		</div>
	</div>
</div>

<form action="<?php echo $action ?>" method="post">
	<input type="hidden" name="_token" value="<?php echo $token; ?>">
	<div class="panel panel-default">
		<div class="panel-body">
			<ul class="nav nav-tabs nav-tabs-line nav-tabs-line-primary">
				<li class="nav-item">
					<a class="nav-link active" href="#appointment-info" data-toggle="tab">Appointment Info</a>
				</li>
				<?php if ($page_notes) { ?>
					<li class="nav-item">
						<a class="nav-link" href="#appointment-records" data-toggle="tab">Clinical Notes</a>
					</li>
				<?php } if ($page_prescriptions) { ?>
					<li class="nav-item">
						<a class="nav-link" href="#appointment-prescription" data-toggle="tab">Prescription</a>
					</li>
				<?php } if ($page_document_upload || $page_documents) { ?>
					<li class="nav-item">
						<a class="nav-link" href="#appointment-documents" data-toggle="tab">Documents</a>
					</li>
				<?php } if ($invoice_view || $invoice_add) { ?>
					<li class="nav-item">
						<a class="nav-link" href="#appointment-invoice" data-toggle="tab">Invoice</a>
					</li>
				<?php } ?>
			</ul>
			<div class="tab-content pt-4">
				<div class="tab-pane active" id="appointment-info">
					<div id="apnt-info" class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label>Doctor <span class="form-required">*</span></label>
								<div class="input-group">
									<div class="input-group-prepend">
										<span class="input-group-text"><i class="ti-user"></i></span>
									</div>
									<select name="appointment[doctor]" class="custom-select apnt-doctor" required>
										<option value="">Select Doctor</option>
										<?php foreach ($doctors as $value) { ?>
											<option value="<?php echo $value['id']; ?>" data-department="<?php echo $value['department_id']; ?>" data-weekly="<?php echo htmlspecialchars($value['weekly'], ENT_QUOTES, 'UTF-8'); ?>" data-national="<?php echo htmlspecialchars($value['national'], ENT_QUOTES, 'UTF-8'); ?>" <?php if ($result['doctor_id'] == $value['id']) { echo "selected"; } ?> ><?php echo $value['name'].' (' . $value['department'] . ')'; ?></option>
										<?php } ?>
									</select>
									<input type="hidden" class="apnt-department" name="appointment[department]" value="<?php echo $result['department_id']; ?>">
								</div>
							</div>
							<div class="form-group">
								<label>Date <span class="form-required">*</span></label>
								<div class="input-group">
									<div class="input-group-prepend">
										<span class="input-group-text"><i class="ti-calendar"></i></span>
									</div>
									<input type="text" class="form-control apnt-date" name="appointment[date]" placeholder="Select Date . . ." value="<?php echo date_format(date_create($result['date']), $common['info']['date_format']); ?>" required autocomplete="off">
								</div>
							</div>
							<div class="form-group">
								<label>Time <span class="form-required">*</span></label>
								<div class="input-group">
									<div class="input-group-prepend">
										<span class="input-group-text"><i class="ti-timer"></i></span>
									</div>
									<input type="text" name="appointment[time]" class="form-control apnt-time" value="<?php echo $result['time']; ?>" readonly>
									<input type="hidden" name="appointment[slot]" class="apnt-slot-time" value="<?php echo $result['slot']; ?>" required>
								</div>
								<div class="apnt-slot"></div>
							</div>
							<div class="form-group">
								<label>Status <span class="form-required">*</span></label>
								<div class="input-group">
									<div class="input-group-prepend">
										<span class="input-group-text"><i class="ti-check-box"></i></span>
									</div>
									<select name="appointment[status]" class="custom-select" required>
										<option value="">Status</option>
										<option value="2" <?php if($result['status'] == '2') { echo "selected";} ?> >In Process</option>
										<option value="3" <?php if($result['status'] == '3') { echo "selected";} ?> >Confirmed</option>
										<option value="4" <?php if($result['status'] == '4') { echo "selected";} ?> >Completed</option>
										<option value="1" <?php if($result['status'] == '1') { echo "selected";} ?> >Cancelled</option>
									</select>
								</div>
							</div>
							<div class="form-group">
								<label>Reason/Problem</label>
								<div class="input-group">
									<div class="input-group-prepend">
										<span class="input-group-text"><i class="ti-comment-alt"></i></span>
									</div>
									<textarea class="form-control" name="appointment[message]"><?php echo $result['message']; ?></textarea>
								</div>
							</div>
						</div>
						<div class="col-md-6">
							<div class="apnt-user">
								<div class="edit"><i class="ti-pencil-alt"></i></div>
								<div class="user-container">
									<div class="row">
										<div class="col-auto">
											<div class="img">
												<!-- <img src="../public/uploads/author-1.jpg" alt=""> -->
												<span><?php echo $result['name'][0]; ?></span>
											</div>
										</div>
										<div class="col-auto pl-0">
											<div class="title mt-2">
												<h4 class="m-0"><a href="#" class="d-block text-primary"><?php echo $result['name']; ?></a></h4>
												<p class="font-12 mb-0 mt-2"><?php echo $result['email']; ?></p>
												<p class="font-12 mb-0"><?php echo $result['mobile']; ?></p>
											</div>
										</div>
									</div>
								</div>
								<div class="info">
									<p><i class="ti-heart-broken"></i> <span><?php echo $result['bloodgroup']; ?></span></p>
									<p><i class="ti-user"></i> <span><?php echo $result['gender']; ?></span></p>
									<p><i class="ti-calendar"></i> <span><?php echo $result['age_year'].' Years '.$result['age_month'].' Month'; ?></span></p>
									<p class="d-block mt-3">
										<i class="ti-wheelchair"></i> <?php if (!empty($result['history'])) { echo implode(', ', json_decode($result['history'], true)); } ?>
									</p>
								</div>
							</div>
							<div class="apnt-user-input">
								<div class="form-group">
									<label>Patient Name <span class="form-required">*</span></label>
									<div class="input-group">
										<div class="input-group-prepend">
											<span class="input-group-text"><i class="ti-user"></i></span>
										</div>
										<input type="text" class="form-control apnt-name" name="appointment[name]" value="<?php echo $result['name'] ?>" placeholder="Enter Patient Name . . ." required>
										<input type="hidden" class="patient-id" name="appointment[patient_id]" value="<?php echo $result['patient_id'] ?>">

									</div>
								</div>
								<div class="form-group">
									<label>Patient Email Address <span class="form-required">*</span></label>
									<div class="input-group">
										<div class="input-group-prepend">
											<span class="input-group-text"><i class="ti-email"></i></span>
										</div>
										<input type="text" class="form-control apnt-email" name="appointment[mail]" value="<?php echo $result['email'] ?>" placeholder="Enter Patient Email Address . . ." required>
									</div>
								</div>
								<div class="form-group">
									<label>Patient Mobile Number <span class="form-required">*</span></label>
									<div class="input-group">
										<div class="input-group-prepend">
											<span class="input-group-text"><i class="ti-mobile"></i></span>
										</div>
										<input type="text" class="form-control apnt-mobile" name="appointment[mobile]" value="<?php echo $result['mobile'] ?>" placeholder="Enter Patient Mobile Number . . ." required>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<?php if ($page_prescriptions) { ?>
					<div class="tab-pane" id="appointment-prescription">
						<input type="hidden" name="prescription[id]" value="<?php echo $result['prescription_id']; ?>">
						<div class="table-responsive">
							<table class="table table-bordered medicine-table">
								<thead>
									<tr class="medicine-row">
										<th style="width: 20%;">Drug Name</th>
										<th>Generic</th>
										<th style="width: 11%;">Frequency</th>
										<th style="width: 13%;">Duration</th>
										<th style="width: 20%;">Instruction</th>
										<th style="width: 5%;"></th>
									</tr>
								</thead>
								<tbody>
									<?php if (!empty($prescription['prescription'])) { foreach ($prescription['prescription'] as $key => $value) { ?>
										<tr class="medicine-row">
											<td>
												<input class="form-control prescription-name" name="prescription[medicine][<?php echo $key; ?>][name]" value="<?php echo $value['name'] ?>" placeholder="Medicine Name">
											</td>
											<td>
												<textarea class="form-control prescription-generic" name="prescription[medicine][<?php echo $key; ?>][generic]" rows="3" placeholder="Generic"><?php echo $value['generic'] ?></textarea>
											</td>
											<td>
												<select name="prescription[medicine][<?php echo $key; ?>][dose]" class="form-control">
													<option value="1-0-0" <?php if ($value['dose'] == '1-0-0') { echo "selected";} ?> >1-0-0</option>
													<option value="1-0-1" <?php if ($value['dose'] == '1-0-1') { echo "selected";} ?> >1-0-1</option>
													<option value="1-1-1" <?php if ($value['dose'] == '1-1-1') { echo "selected";} ?> >1-1-1</option>
													<option value="0-0-1" <?php if ($value['dose'] == '0-0-1') { echo "selected";} ?> >0-0-1</option>
													<option value="0-1-0" <?php if ($value['dose'] == '0-1-0') { echo "selected";} ?> >0-1-0</option>
												</select>
											</td>
											<td>
												<select name="prescription[medicine][<?php echo $key; ?>][duration]" class="form-control">
													<option value="1" <?php if ($value['duration'] == '1') { echo "selected";} ?> >1 Days</option>
													<option value="2" <?php if ($value['duration'] == '2') { echo "selected";} ?> >2 Days</option>
													<option value="3" <?php if ($value['duration'] == '3') { echo "selected";} ?> >3 Days</option>
													<option value="4" <?php if ($value['duration'] == '4') { echo "selected";} ?> >4 Days</option>
													<option value="5" <?php if ($value['duration'] == '5') { echo "selected";} ?> >5 Days</option>
													<option value="6" <?php if ($value['duration'] == '6') { echo "selected";} ?> >6 Days</option>
													<option value="8" <?php if ($value['duration'] == '8') { echo "selected";} ?> >8 Days</option>
													<option value="10" <?php if ($value['duration'] == '10') { echo "selected";} ?> >10 Days</option>
													<option value="15" <?php if ($value['duration'] == '15') { echo "selected";} ?> >15 Days</option>
													<option value="20" <?php if ($value['duration'] == '20') { echo "selected";} ?> >20 Days</option>
													<option value="30" <?php if ($value['duration'] == '30') { echo "selected";} ?> >30 Days</option>
													<option value="60" <?php if ($value['duration'] == '60') { echo "selected";} ?> >60 Days</option>
												</select>
											</td>
											<td>
												<textarea name="prescription[medicine][<?php echo $key; ?>][instruction]" class="form-control" rows="3" placeholder="Instruction"><?php echo $value['instruction']; ?></textarea>
											</td>
											<td>
												<a class="table-action-button medicine-delete"><i class="ti-trash text-danger"></i></a>
											</td>
										</tr>
									<?php } } else { ?>
										<tr class="medicine-row">
											<td>
												<input class="form-control prescription-name" name="prescription[medicine][0][name]" placeholder="Medicine Name">
											</td>
											<td>
												<textarea name="prescription[medicine][0][generic]" class="form-control prescription-generic" rows="3" placeholder="Generic"></textarea>
											</td>
											<td>
												<select name="prescription[medicine][0][dose]" class="form-control">
													<option value="1-0-0">1-0-0</option>
													<option value="1-0-1">1-0-1</option>
													<option value="1-1-1">1-1-1</option>
													<option value="0-0-1">0-0-1</option>
													<option value="0-1-0">0-1-0</option>
												</select>
											</td>
											<td>
												<select name="prescription[medicine][0][duration]" class="form-control">
													<option value="1">1 Days</option>
													<option value="2">2 Days</option>
													<option value="3">3 Days</option>
													<option value="4">4 Days</option>
													<option value="5">5 Days</option>
													<option value="6">6 Days</option>
													<option value="8">8 Days</option>
													<option value="10">10 Days</option>
													<option value="15">15 Days</option>
													<option value="20">20 Days</option>
													<option value="30">30 Days</option>
													<option value="60">60 Days</option>
												</select>
											</td>
											<td>
												<textarea name="prescription[medicine][0][instruction]" class="form-control" rows="3" placeholder="Instruction"></textarea>
											</td>
											<td><a class="table-action-button medicine-delete"><i class="ti-trash text-danger"></i></a></td>
										</tr>
									<?php } ?>
									<tr>
										<td colspan="6">
											<a id="add-medicine" class="font-12 text-primary cursor-pointer">Add Medicine</a>
											<?php if (!empty($result['prescription_id'])) { ?>
												<a href="<?php echo URL_ADMIN.DIR_ROUTE.'prescription/pdf&id='.$result['prescription_id']; ?>" class="color-green cursor-pointer pull-right" target="_blank">Print Prescription</a>
											<?php } ?>
										</td>
									</tr>
								</tbody>
							</table>
						</div>
						<script>
							function medicine_autocomplete() {
								$(".prescription-name").autocomplete({
									minLength: 0,
									source: '<?php echo URL_ADMIN.DIR_ROUTE.'getmedicine'; ?>',
									focus: function( event, ui ) {
										$(this).parents('tr').find('.prescription-name').val( ui.item.label );
										return false;
									},
									select: function( event, ui ) {
										$(this).parents('tr').find('.prescription-name').val( ui.item.label );
										$(this).parents('tr').find('.prescription-generic').val( ui.item.generic );
										return false;
									}
								}).autocomplete( "instance" )._renderItem = function( ul, item ) {
									return $( "<li>" )
									.append( "<div>" + item.label + "<br>" + item.generic + "</div>" )
									.appendTo( ul );
								};
							}

							$('body').on('keydown.autocomplete', '.prescription-name', function() {
								medicine_autocomplete();
							});
							if ($(".medicine-delete").length < 2) { $(".medicine-delete").hide(); }
							else { $(".medicine-delete").show(); }

							$('body').on('click', '.medicine-delete', function() {
								$(this).parents('tr').remove();
								if ($(".medicine-delete").length < 2) $(".medicine-delete").hide();
							});

							$('#add-medicine').click(function () {
								if ($(".medicine-delete").length < 1) { $(".medicine-delete").hide(); }
								else { $(".medicine-delete").show(); }
								var count = $('.medicine-table .medicine-row:last .prescription-name').attr('name').split('[')[2];
								count = parseInt(count.split(']')[0]) + 1;
								$(".medicine-row:last").after('<tr class="medicine-row">'+
									'<td><input class="form-control prescription-name" name="prescription[medicine]['+count+'][name]" value="" placeholder="Medicine Name"></td>'+
									'<td><textarea class="form-control prescription-generic" name="prescription[medicine]['+count+'][generic]" rows="3" placeholder="Generic"></textarea></td>'+
									'<td><select name="prescription[medicine]['+count+'][dose]" class="form-control"><option value="1-0-0">1-0-0</option><option value="1-0-1">1-0-1</option><option value="1-1-1">1-1-1</option><option value="0-0-1">0-0-1</option><option value="0-1-0">0-1-0</option></select></td>'+
									'<td><select name="prescription[medicine]['+count+'][duration]" class="form-control"><option value="1">1 Days</option><option value="2">2 Days</option><option value="3">3 Days</option><option value="4">4 Days</option><option value="5">5 Days</option><option value="6">6 Days</option><option value="8">8 Days</option><option value="10">10 Days</option><option value="15">15 Days</option><option value="20">20 Days</option><option value="30">30 Days</option><option value="60">60 Days</option></select></td>'+
									'<td><textarea name="prescription[medicine]['+count+'][instruction]" class="form-control" rows="3" placeholder="Instruction"></textarea></td>'+
									'<td><a class="table-action-button medicine-delete"><i class="ti-trash text-danger"></i></a></td>'+
									'</tr>');
							});
						</script>
					</div>
				<?php } if ($page_notes) { ?>
					<div class="tab-pane" id="appointment-records">
						<div class="row clinical-notes">
							<div class="col-lg-4">
								<div class="notes-form">
									<div class="form-group">
										<label>Problem</label>
										<div class="input-group">
											<input type="text" class="form-control" data-name="problem" placeholder="Add Patient Problem . . .">
											<div class="input-group-append">
												<span class="input-group-text">Add</span>
											</div>
										</div>
									</div>
									<div class="form-group">
										<label>Observation</label>
										<div class="input-group">
											<input type="text" class="form-control" data-name="observation" placeholder="Add Observation. . .">
											<div class="input-group-append">
												<span class="input-group-text">Add</span>
											</div>
										</div>
									</div>
									<div class="form-group">
										<label>Diagnosis</label>
										<div class="input-group">
											<input type="text" class="form-control" data-name="diagnosis" placeholder="Add Diagnosis . . .">
											<div class="input-group-append">
												<span class="input-group-text">Add</span>
											</div>
										</div>
									</div>
									<div class="form-group">
										<label>Test Request/Investigation</label>
										<div class="input-group">
											<input type="text" class="form-control" data-name="investigation" placeholder="Add Test Request/Investigation . . .">
											<div class="input-group-append">
												<span class="input-group-text">Add</span>
											</div>
										</div>
									</div>
									<div class="form-group">
										<label>Notes/Advice</label>
										<div class="input-group">
											<input type="text" class="form-control" data-name="notes" placeholder="Add Notes . . .">
											<div class="input-group-append">
												<span class="input-group-text">Add</span>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="col-lg-8">
								<div class="notes-container">
									<div class="timeline-1 timeline-2">
										<div class="marker"></div>
										<div class="item item-left notes-problem">
											<div class="circle"><i class="ti-help-alt"></i></div>
											<div class="arrow"></div>
											<div class="item-content">
												<div class="title">Problems</div>
												<div class="descr">
													<ul>
														<?php if (!empty($notes['notes']['problem'])) { foreach ($notes['notes']['problem'] as $key => $value) { ?>
															<li><?php echo $value; ?><input type="hidden" name="notes[notes][problem][]" value="<?php echo $value; ?>"><span class="ti-close delete"></span></li>
														<?php } } ?>
													</ul>
												</div> 
											</div>
										</div>
										<div class="item item-left notes-observation">
											<div class="circle"><i class="ti-panel text-info"></i></div>
											<div class="arrow"></div>
											<div class="item-content">
												<div class="title">Observation</div>
												<div class="descr">
													<ul>
														<?php if (!empty($notes['notes']['observation'])) { foreach ($notes['notes']['observation'] as $key => $value) { ?>
															<li><?php echo $value; ?><input type="hidden" name="notes[notes][observation][]" value="<?php echo $value; ?>"><span class="ti-close delete"></span></li>
														<?php } } ?>
													</ul>
												</div> 
											</div>
										</div>
										<div class="item item-left notes-diagnosis">
											<div class="circle"><i class="ti-heart-broken text-secondary"></i></div>
											<div class="arrow"></div>
											<div class="item-content">
												<div class="title">Diagnosis</div>
												<div class="descr">
													<ul>
														<?php if (!empty($notes['notes']['diagnosis'])) { foreach ($notes['notes']['diagnosis'] as $key => $value) { ?>
															<li><?php echo $value; ?><input type="hidden" name="notes[notes][diagnosis][]" value="<?php echo $value; ?>"><span class="ti-close delete"></span></li>
														<?php } } ?>
													</ul>
												</div> 
											</div>
										</div>
										<div class="item item-left notes-investigation">
											<div class="circle"><i class="ti-agenda text-success"></i></div>
											<div class="arrow"></div>
											<div class="item-content">
												<div class="title">Test Request/Investigation</div>
												<div class="descr">
													<ul>
														<?php if (!empty($notes['notes']['investigation'])) { foreach ($notes['notes']['investigation'] as $key => $value) { ?>
															<li><?php echo $value; ?><input type="hidden" name="notes[notes][investigation][]" value="<?php echo $value; ?>"><span class="ti-close delete"></span></li>
														<?php } } ?>
													</ul>
												</div> 
											</div>
										</div>
										<div class="item item-left notes-notes">
											<div class="circle"><i class="ti-write text-primary"></i></div>
											<div class="arrow"></div>
											<div class="item-content">
												<div class="title">Notes</div>
												<div class="descr">
													<ul>
														<?php if (!empty($notes['notes']['notes'])) { foreach ($notes['notes']['notes'] as $key => $value) { ?>
															<li><?php echo $value; ?><input type="hidden" name="notes[notes][notes][]" value="<?php echo $value; ?>"><span class="ti-close delete"></span></li>
														<?php } } ?>
													</ul>
												</div> 
											</div>
										</div>
									</div>
								</div>
								<input type="hidden" name="notes[id]" value="<?php echo $notes['id']; ?>">
							</div>
						</div>
					</div>
				<?php } if ($page_document_upload || $page_documents) { ?>
					<div class="tab-pane" id="appointment-documents">
						<?php if ($page_document_upload) { ?>
							<div class="form-group">
								<a class="btn btn-warning btn-sm" data-toggle="modal" data-target="#reports-modal"><i class="ti-cloud-up mr-2"></i> Upload Document/Report</a>
							</div>
						<?php } if($page_documents) { ?>
							<div class="report-container">
								<?php if (!empty($reports)) { foreach ($reports as $key => $value) { $file_ext = pathinfo($value['report'], PATHINFO_EXTENSION); if ($file_ext == "pdf") { ?>
									<div class="report-image report-pdf">
										<a href="../public/uploads/reports/<?php echo $value['report']; ?>" class="open-pdf">
											<img src="../public/images/pdf.png" alt="">
											<span><?php echo $value['name']; ?></span>
										</a>
										<?php if ($page_document_remove) { ?>
											<div class="report-delete" data-toggle="tooltip" title="Delete"><a class="ti-close"></a></div>
											<input type="hidden" name="report_name" value="<?php echo $value['report']; ?>">
										<?php } ?>
									</div>
								<?php } else { ?>
									<div class="report-image">
										<a data-fancybox="gallery" href="../public/uploads/reports/<?php echo $value['report']; ?>">
											<img src="../public/uploads/reports/<?php echo $value['report']; ?>" alt="">
											<span><?php echo $value['name']; ?></span>
										</a>
										<?php if ($page_document_remove) { ?>
											<div class="report-delete" data-toggle="tooltip" title="Delete"><a class="ti-close"></a></div>
											<input type="hidden" name="report_name" value="<?php echo $value['report']; ?>">
										<?php } ?>
									</div>
								<?php } } } ?>
							</div>
						<?php } ?>
					</div>
				<?php } if ($invoice_view || $invoice_add) { ?>
					<div class="tab-pane" id="appointment-invoice">
						<div class="text-center">
							<?php if ($result['invoice_id'] && $invoice_view) { ?>
								<p>Invoice is Generated</p>
								<a href="<?php echo URL_ADMIN.DIR_ROUTE.'invoice/view&id='.$result['invoice_id']; ?>" class="btn btn-danger btn-sm" target="_blank"><i class="far fa-file-pdf mr-2"></i>View</a>
								<a href="<?php echo URL_ADMIN.DIR_ROUTE.'invoice/pdf&id='.$result['invoice_id']; ?>" class="btn btn-danger btn-sm" target="_blank"><i class="far fa-file-pdf mr-2"></i>PDF</a>
								<a href="<?php echo URL_ADMIN.DIR_ROUTE.'invoice/print&id='.$result['invoice_id']; ?>" class="btn btn-success btn-sm" target="_blank"><i class="ti-printer mr-2"></i>Print</a>
								<a href="<?php echo URL_ADMIN.DIR_ROUTE.'invoice/edit&id='.$result['invoice_id']; ?>" class="btn btn-info btn-sm" target="_blank"><i class="ti-pencil-alt mr-2"></i>Edit</a>
							<?php } elseif ($invoice_add) { ?>
								<p>Invoice is not Generated</p>
								<a href="<?php echo URL_ADMIN.DIR_ROUTE.'invoice/add&appointment='.$result['id']; ?>" class="btn btn-primary btn-sm" target="_blank"><i class="ti-plus pr-2"></i>Generate Invoice Now</a>
							<?php } ?>
						</div>
					</div>
				<?php } ?>
			</div>
		</div>
		<input type="hidden" class="appointment-id" name="appointment[id]" value="<?php echo $result['id'];?>">
		<div class="panel-footer text-center">
			<button type="submit" name="submit" class="btn btn-primary"><i class="ti-save-alt pr-2"></i> Save</button>
		</div>
	</div>
</form>

<!-- Reports upload modal -->
<div id="reports-modal" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Upload Reports/Documents</h4>
				<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>
			<div class="modal-body">
				<div class="form-group">
					<label>Report/Document Name</label>
					<div class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text"><i class="ti-tag"></i></span>
						</div>
						<input type="text" name="report_name" class="form-control" placeholder="Enter Report/Document Name">
					</div>
				</div>
				<div class="media-upload-container" style="max-width: 100%;">
					<form action="<?php echo URL_ADMIN.DIR_ROUTE ?>report/reportUpload" class="dropzone" id="report-upload" method="post" enctype="multipart/form-data">
						<div class="fallback"><input name="file" type="file" /></div>
					</form>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-primary upload-report">Done</button>
			</div>
		</div>

	</div>
</div>

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