<!-- Start Request Section -->
<?php if (!empty($request)) { foreach ( $request as $key => $value ) { ?>
	<div class="user-card">
		<div class="card-hdr">
			<div class="row align-items-center">
				<div class="col-lg-6">
					<?php if ($value['status'] == '1') { ?>
						<div class="label label-danger"><?php echo $lang['text_open']; ?></div>
					<?php } else { ?>
						<div class="label label-success"><?php echo $lang['text_closed']; ?></div>
					<?php } ?>

				</div>
				<div class="col-lg-6 text-right">
					<div><?php echo $lang['text_created_on'].' => '.date_format(date_create($value['date_of_joining']), $siteinfo['date_format']); ?></div>
				</div>
			</div>
		</div>
		<div class="card-body">
			<div class="row">
				<div class="col-lg-4">
					<div class="icon tbl-cell"><i class="far fa-user"></i></div>
					<div class="user-info tbl-cell">
						<span><?php echo $lang['text_requester']; ?></span>
						<h4 class="name"><?php echo $value['name']; ?></h4>
					</div>
				</div>
				<div class="col-lg-3">
					<div class="info">
						<span><?php echo $lang['text_subject']; ?></span>
						<p><?php echo $value['subject']; ?></p>
					</div>
				</div>
				<div class="col-lg-5">
					<div class="info">
						<span><?php echo $lang['text_message']; ?></span>
						<p><?php echo $value['message']; ?></p>
					</div>
				</div>
			</div>
		</div>
		<div class="card-ftr">
			<div class="font-14 text-dark"><span class="text-lesser-dark font-12"><?php echo $lang['text_reply'].' => '; ?> </span><?php echo $value['remark']; ?></div>
		</div>
	</div>
<?php } } else { ?>
	<div class="apnt-block text-center mt-5 pt-5">
		<i class="fas fa-envelope-open-text fa-5x"></i>
		<p class="font-16 mt-3 mb-3"><?php echo $lang['text_no_request_found']; ?></p>
	</div>
<?php } ?>
<!-- End Request Section -->
