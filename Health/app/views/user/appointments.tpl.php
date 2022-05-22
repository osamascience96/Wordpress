<?php if (!empty($appointments)) { foreach ($appointments as $key => $value) { ?>
	<!-- Start My Appointment Section -->
	<div class="user-card">
		<div class="card-hdr">
			<div class="row align-items-center">
				<div class="col-md-6">
					<a href="<?php echo URL.DIR_ROUTE.'user/appointment&id='.$value['id']; ?>" class="title"><?php echo $siteinfo['appointment_prefix'].str_pad($value['id'], 5, '0', STR_PAD_LEFT); ?></a>
				</div>
				<div class="col-md-6 text-right">
					<?php if ($value['status'] == 1) {
						echo '<span class="label label-danger">'.$lang['text_cancelled'].'</span>';
					} elseif ($value['status'] == 2) {
						echo '<span class="label label-warning">'.$lang['text_in_process'].'</span>';
					} elseif ($value['status'] == 3) {
						echo '<span class="label label-success">'.$lang['text_confirmed'].'</span>';
					} elseif ($value['status'] == 4) {
						echo '<span class="label label-primary">'.$lang['text_completed'].'</span>';
					} else {
						echo '<span class="label label-sm label-info">'.$lang['text_new'].'</span>';
					} ?>
				</div>
			</div>
		</div>
		<div class="card-body">
			<div class="row align-items-center">
				<div class="col-md-4">
					<?php if (!empty($value['picture'])) { ?>
						<div class="picture tbl-cell">
							<img src="<?php echo URL.'public/uploads/'.$value['picture']; ?>" alt="Doctor">
						</div>
					<?php } else { ?>
						<div class="icon tbl-cell">
							<i class="far fa-user"></i>
						</div>
					<?php } ?>
					<div class="user-info tbl-cell">
						<span><?php echo $lang['text_doctor_info']; ?></span>
						<h4 class="name"><?php echo $value['doctor']; ?></h4>
						<p class="text"><?php echo $value['department']; ?></p>
					</div>
				</div>
				<div class="col-md-4">
					<div class="info">
						<span><?php echo $lang['text_patient']; ?></span>
						<p><?php echo $value['name']; ?></p>
					</div>
				</div>
				<div class="col-md-4">
					<div class="info">
						<span><?php echo $lang['text_date_time']; ?></span>
						<p><?php echo date_format(date_create($value['date']), $siteinfo['date_format']).' at '.date_format(date_create($value['time']), 'H:i A'); ?></p>
					</div>
				</div>
			</div>
		</div>
		<div class="card-ftr">
			<div class="row align-items-center">
				<div class="col-md-6">
					<span class="font-12 text-dark"><?php echo $lang['text_created_on'].' => '.date_format(date_create($value['date_of_joining']), $siteinfo['date_format']); ?></span>
				</div>
				<div class="col-md-6 text-right">
					<a href="<?php echo URL.DIR_ROUTE.'user/appointment&id='.$value['id']; ?>" class="btn btn-primary btn-outline btn-outline-1x btn-sm"><?php echo $lang['text_read_more']; ?></a>
				</div>	
			</div>
		</div>
	</div>
<?php } } else { ?>
	<div class="apnt-block text-center mt-5 pt-5">
		<i class="far fa-calendar-plus fa-5x"></i>
		<p class="font-16 mt-3 mb-3"><?php echo $lang['text_no_appointment_found']; ?></p>
	</div>
<?php } ?>
	<!-- End Appointment Section -->