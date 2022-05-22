<div class="apnt-view">
	<div class="mb-4">
		<div class="card-hdr">
			<div class="row align-items-center">
				<div class="col-md-6">
					<div class="title"><?php echo $siteinfo['appointment_prefix'].str_pad($appointment['id'], 5, '0', STR_PAD_LEFT); ?></div>
				</div>
				<div class="col-md-6 text-right">
					<?php if ($appointment['status'] == 1) {
						echo '<span class="label label-danger">'.$lang['text_cancelled'].'</span>';
					} elseif ($appointment['status'] == 2) {
						echo '<span class="label label-warning">'.$lang['text_in_process'].'</span>';
					} elseif ($appointment['status'] == 3) {
						echo '<span class="label label-success">'.$lang['text_confirmed'].'</span>';
					} elseif ($appointment['status'] == 4) {
						echo '<span class="label label-primary">'.$lang['text_completed'].'</span>';
					} else {
						echo '<span class="label label-info">'.$lang['text_new'].'</span>';
					} ?>
				</div>
			</div>
		</div>
		<div class="card-body">
			<div class="row">
				<div class="col-md-3">
					<?php if (!empty($appointment['picture'])) { ?>
						<div class="picture tbl-cell">
							<img src="<?php echo URL.'public/uploads/'.$appointment['picture']; ?>" alt="Doctor">
						</div>
					<?php } else { ?>
						<div class="icon tbl-cell">
							<i class="far fa-user"></i>
						</div>
					<?php } ?>
					<div class="user-info tbl-cell">
						<span><?php echo $lang['text_doctor_info']; ?></span>
						<h4 class="name"><?php echo $appointment['doctor']; ?></h4>
						<p class="text"><?php echo $appointment['department']; ?></p>
					</div>
				</div>
				<div class="col-md-3">
					<div class="info">
						<span><?php echo $lang['text_patient']; ?></span>
						<p><?php echo $appointment['name']; ?></p>
					</div>
				</div>
				<div class="col-md-3">
					<div class="info">
						<span><?php echo $lang['text_date_time']; ?></span>
						<p><?php echo date_format(date_create($appointment['date']), $siteinfo['date_format']).' at '.date_format(date_create($appointment['time']), 'H:i A'); ?></p>
					</div>
				</div>
				<div class="col-md-3">
					<div class="info">
						<span><?php echo $lang['text_reason_problem']; ?></span>
						<p><?php echo $appointment['message']; ?></p>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="mb-4">
		<div class="card-hdr">
			<div class="row align-items-center">
				<div class="col-md-6">
					<div class="title"><?php echo $lang['text_clinical_notes']; ?></div>
				</div>
				<div class="col-md-6 text-right">
					<?php if (!empty($appointment['notes'])) { ?>
						<a href="<?php echo URL.DIR_ROUTE.'user/records/print&id='.$appointment['id']; ?>" class="btn btn-white btn-sm" target="_blank"><?php echo $lang['text_print']; ?></a>
					<?php } ?>
				</div>
			</div>
		</div>
		<div class="card-body">
			<div class="info">
				<span><?php echo $lang['text_problem']; ?></span>
				<ul>
					<?php if (!empty($appointment['notes']['problem'])) { foreach ($appointment['notes']['problem'] as $key => $value) { echo '<li>'.$value.'</li>'; } } else { echo '<li>'.$lang['text_none'].'</li>'; } ?>
				</ul>
				<span><?php echo $lang['text_observation']; ?></span>
				<ul>
					<?php if (!empty($appointment['notes']['observation'])) { foreach ($appointment['notes']['observation'] as $key => $value) { echo '<li>'.$value.'</li>'; } } else { echo '<li>'.$lang['text_none'].'</li>'; } ?>
				</ul>
				<span><?php echo $lang['text_diagnosis']; ?></span>
				<ul>
					<?php if (!empty($appointment['notes']['diagnosis'])) { foreach ($appointment['notes']['diagnosis'] as $key => $value) { echo '<li>'.$value.'</li>'; } } else { echo '<li>'.$lang['text_none'].'</li>'; } ?>
				</ul>
				<span><?php echo $lang['text_investigation']; ?></span>
				<ul>
					<?php if (!empty($appointment['notes']['investigation'])) { foreach ($appointment['notes']['investigation'] as $key => $value) { echo '<li>'.$value.'</li>'; } } else { echo '<li>'.$lang['text_none'].'</li>'; } ?>
				</ul>
				<span><?php echo $lang['text_doctor_notes']; ?></span>
				<ul>
					<?php if (!empty($appointment['notes']['notes'])) { foreach ($appointment['notes']['notes'] as $key => $value) { echo '<li>'.$value.'</li>'; } } else { echo '<li>'.$lang['text_none'].'</li>'; } ?>
				</ul>
			</div>
		</div>
	</div>
	<div class="mb-4">
		<div class="card-hdr">
			<div class="row align-items-center">
				<div class="col-md-6">
					<div class="title"><?php echo $lang['text_reports_documents']; ?></div>
				</div>
			</div>
		</div>
		<div class="card-body">
			<div class="row document-container">
				<?php if (!empty($reports)) { foreach ($reports as $key => $value) { 
					$file_ext = pathinfo($value['report'], PATHINFO_EXTENSION); ?>
					<div class="col-12 col-sm-6 col-md-4 col-lg-3">
						<div class="block">
							<div class="title">
								<span><?php echo $value['name']; ?></span>
								<p><?php echo date_format(date_create($value['date_of_joining']), $siteinfo['date_format']); ?></p>
							</div>
							<div class="document">
								<?php if ($file_ext == "pdf") { ?>
									<a href="<?php echo URL.'public/uploads/reports/'.$value['report']; ?>" class="record-pdf" title="<?php echo $value['name']; ?>"><i class="far fa-file-pdf"></i></a>
								<?php } else { ?>
									<a data-fancybox="gallery" href="<?php echo URL.'public/uploads/reports/'.$value['report']; ?>" class="record-image">
										<img src="<?php echo URL.'public/uploads/reports/'.$value['report']; ?>" alt="Documents">
									</a>
								<?php } ?>
							</div>
						</div>
					</div>
				<?php } } ?>
			</div>
		</div>
	</div>
	<div class="mb-4">
		<div class="card-hdr">
			<div class="row align-items-center">
				<div class="col-md-6">
					<div class="title"><?php echo $lang['text_prescription']; ?></div>
				</div>
				<div class="col-md-6 text-right">
					<?php if (!empty($prescription['id'])) { ?>
						<a href="<?php echo URL.DIR_ROUTE.'user/prescription&id='.$prescription['id']; ?>" class="btn btn-sm btn-white" target="_blank"><?php echo $lang['text_print']; ?></a>
					<?php } ?>
				</div>
			</div>
		</div>
		<div class="card-block">
			<?php if (!empty($prescription)) {  ?>
				<table class="table table-striped">
					<tr>
						<th><?php echo $lang['text_medicine_name']; ?></th>
						<th><?php echo $lang['text_dose']; ?></th>
						<th><?php echo $lang['text_duration']; ?></th>
						<th><?php echo $lang['text_instruction']; ?></th>
					</tr>
					<?php foreach (json_decode($prescription['prescription'], true) as $key => $value) { ?>
						<tr>
							<td>
								<p class="font-14 text-primary m-0"><?php echo $value['name']; ?></p>
								<p class="font-12 m-0"><?php echo $value['generic']; ?></p>
							</td>
							<td><?php echo $value['dose']; ?></td>
							<td><?php echo $value['duration'].' '.$lang['text_day']; ?></td>
							<td><?php echo $value['instruction']; ?></td>
						</tr>
					<?php } ?>
				</table>
			<?php } else { ?>
				<p><?php echo $lang['text_prescription_does_not_created']; ?></p>
			<?php } ?>
		</div>
	</div>
</div>