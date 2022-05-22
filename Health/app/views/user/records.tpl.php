<div class="row">
	<?php if (!empty($records)) { foreach ($records as $key => $value) { ?>
		<div class="col-md-12 col-lg-12 col-xl-6">
			<div class="user-card">
				<div class="card-hdr">
					<div class="row align-items-center">
						<div class="col-md-6">
							<div class="title"><?php echo $value['type']; ?></div>
						</div>
					</div>
				</div>
				<div class="card-body pl-0 pr-0">
					<?php if ($value['type'] == 'Clinical Notes') { 
						$value['notes'] = json_decode($value['notes'], true); ?>
						<div class="document-container">
							<div class="block">
								<div class="title">
									<div class="row align-items-center">
										<div class="col-md-6">
											<span><?php echo 'Dr. '.$value['doctor']; ?></span>
											<p><?php echo date_format(date_create($value['date_of_joining']), $siteinfo['date_format']); ?></p>
										</div>
										<div class="col-md-6 text-right">
											<a href="<?php echo URL.DIR_ROUTE.'user/records/print&id='.$value['id']; ?>" class="btn btn-primary btn-outline btn-outline-1x btn-sm" target="_blank"><?php echo $lang['text_print']; ?></a>
										</div>
									</div>
								</div>
								<?php foreach ($value['notes'] as $k => $v) { ?>
									<div class="info">
										<span><?php echo $lang['text_'.$k]; ?></span>
										<ul class="descr pt-0">
											<?php foreach ($v as $s_key => $s_value) { ?>
												<li><?php echo htmlspecialchars_decode($s_value); ?></li>
											<?php } ?>
										</ul>
									</div>
								<?php } ?>
							</div>
						</div>
					<?php } elseif ($value['type'] == 'Prescription') {
						$value['prescription'] = json_decode($value['prescription'], true); ?>
						<div class="document-container">
							<div class="block">
								<div class="title">
									<div class="row align-items-center">
										<div class="col-md-6">
											<span><?php echo 'Dr. '.$value['doctor']; ?></span>
											<p><?php echo date_format(date_create($value['date_of_joining']), $siteinfo['date_format']); ?></p>
										</div>
										<div class="col-md-6 text-right">
											<a href="<?php echo URL.DIR_ROUTE.'user/prescription&id='.$value['id']; ?>" class="btn btn-sm btn-primary btn-outline btn-outline-1x" target="_blank"><?php echo $lang['text_print']; ?></a>
										</div>
									</div>
								</div>
								<div class="table-responsive">
									<table class="table table-striped">
										<tr>
											<th><?php echo $lang['text_medicine_name']; ?></th>
											<th><?php echo $lang['text_dose']; ?></th>
											<th><?php echo $lang['text_duration']; ?></th>
											<th><?php echo $lang['text_instruction']; ?></th>
										</tr>
										<?php foreach ($value['prescription'] as $k => $v) { ?>
											<tr>
												<td>
													<p class="font-14 text-primary m-0"><?php echo htmlspecialchars_decode($v['name']); ?></p>
													<p class="font-12 m-0"><?php echo htmlspecialchars_decode($v['generic']); ?></p>
												</td>
												<td><?php echo $v['dose']; ?></td>
												<td><?php echo $v['duration'].' '.$lang['text_day']; ?></td>
												<td><?php echo $v['instruction']; ?></td>
											</tr>
										<?php } ?>		
									</table>
								</div>
							</div>
						</div>
					<?php } elseif ($value['type'] == 'Reports') {
						$file_ext = pathinfo($value['reports'], PATHINFO_EXTENSION); ?>
						<div class="document-container">
							<div class="block">
								<div class="title">
									<span><?php echo $value['name']; ?></span>
									<p><?php echo date_format(date_create($value['date_of_joining']), $siteinfo['date_format']); ?></p>
									<div class="action"><a><i class="ti-download"></i></a></div>
								</div>
								<div class="document">
									<?php if ($file_ext == "pdf") { ?>
										<a href="<?php echo URL.'public/uploads/reports/'.$value['reports']; ?>" class="record-pdf" title="<?php echo $value['name']; ?>"><i class="far fa-file-pdf"></i></a>
									<?php } else { ?>
										<a data-fancybox="gallery" href="<?php echo URL.'public/uploads/reports/'.$value['reports']; ?>" class="record-image">
											<img src="<?php echo URL.'public/uploads/reports/'.$value['reports']; ?>" alt="Documents">
										</a>
									<?php } ?>
								</div>
							</div>
						</div>
					<?php } ?>
				</div>
			</div>
		</div>
	<?php } } else { ?>
		<div class="col-md-12">
			<div class="apnt-block text-center mt-5 pt-5">
				<i class="fas fa-laptop-medical fa-5x"></i>
				<p class="font-16 mt-3 mb-3"><?php echo $lang['text_no_data_found']; ?></p>
			</div>
		</div>
	<?php } ?>
</div>