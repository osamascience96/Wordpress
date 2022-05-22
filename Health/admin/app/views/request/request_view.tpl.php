<?php include (DIR_ADMIN.'app/views/common/header.tpl.php'); ?>
<div class="page-title">
	<div class="row align-items-center">
		<div class="col-sm-6">
			<h2 class="page-title-text d-inline-block"><?php echo $page_title; ?></h2>
			<div class="breadcrumbs d-inline-block">
				<ul>
					<li><a href="<?php echo URL_ADMIN; ?>">Dashboard</a></li>
					<li><a href="<?php echo URL_ADMIN.DIR_ROUTE.'request'; ?>">Requests</a></li>
					<li><?php echo $page_title; ?></li>
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
					<span><?php echo $result['name'][0]; ?></span>
				</div>
				<div class="user-details text-center pt-3">
					<h3><?php echo $result['name']; ?></h3>
					<ul class="v-menu text-left pt-3 nav d-block">
						<li><a href="#request-info" class="active" data-toggle="tab"><i class="ti-info-alt"></i> <span>Request</span></a></li>
						<?php if ($page_edit) { ?>
							<li><a href="<?php echo URL_ADMIN.DIR_ROUTE.'request/edit&id='.$result['id']; ?>"><i class="ti-pencil-alt"></i> <span>Edit Request</span></a></li>
						<?php } ?>
						<li><a href="#request-mail" data-toggle="tab"><i class="ti-email"></i> <span>Send Email</span></a></li>
					</ul>
				</div>
			</div>
		</div>
	</div>
	<div class="col-md-8">
		<div class="tab-content">
			<div class="tab-pane fade show active" id="request-info">
				<div class="panel panel-default">
					<div class="panel-head">
						<div class="panel-title">Request Info</div>
					</div>
					<div class="panel-body">
						<div class="table-responsive">
							<table class="table table-striped patient-table">
								<tbody>
									<tr>
										<td>Name</td>
										<td><?php echo $result['name']; ?></td>
									</tr>
									<tr>
										<td>Email Address</td>
										<td><?php echo $result['email']; ?></td>
									</tr>
									<tr>
										<td>Mobile Number</td>
										<td><?php echo $result['mobile']; ?></td>
									</tr>
									<tr>
										<td>Subject</td>
										<td><?php echo $result['subject']; ?></td>
									</tr>
									<tr>
										<td>Message</td>
										<td><?php echo $result['message']; ?></td>
									</tr>
									<tr>
										<td>Reply/Remark</td>
										<td><?php echo $result['remark']; ?></td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
			<div class="tab-pane fade" id="request-mail">
				<div class="panel panel-default">
					<div class="panel-head">
						<div class="panel-title">Send Email to Patient</div>  
					</div>
					<form action="<?php echo URL_ADMIN.DIR_ROUTE.'request/sendmail'; ?>" method="post">
						<div class="panel-body">
							<div class="form-group">
								<label>To</label>
								<input type="text" value="<?php echo $result['name']; ?>" class="form-control" readonly>
								<input type="hidden" name="mail[id]" value="<?php echo $result['id']; ?>" readonly>
								<input type="hidden" name="_token" value="<?php echo $common['token']; ?>" readonly>
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
		</div>
	</div>
</div>

<!-- include summernote css/js-->
<link href="public/css/summernote-bs4.css" rel="stylesheet">
<script type="text/javascript" src="public/js/summernote-bs4.min.js"></script>
<script type="text/javascript" src="public/js/klinikal.summernote.js"></script>

<!-- Footer -->
<?php include (DIR_ADMIN.'app/views/common/footer.tpl.php'); ?>