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

<form action="<?php echo $action; ?>" method="post">
	<input type="hidden" name="_token" value="<?php echo $token; ?>">
	<div class="panel panel-default">
		<div class="panel-body">
			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<label>Name <span class="form-required">*</span></label>
						<div class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text"><i class="ti-user"></i></span>
							</div>
							<input type="text" name="request[name]" class="form-control" value="<?php echo $result['name']; ?>" placeholder="Enter Requester Name . . .">
						</div>
					</div>
					<div class="form-group">
						<label>Email Address <span class="form-required">*</span></label>
						<div class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text"><i class="ti-email"></i></span>
							</div>
							<input type="text" name="request[mail]" class="form-control" value="<?php echo $result['email']; ?>" placeholder="Enter Requester Email Address . . .">
						</div>
					</div>
					<div class="form-group">
						<label>Mobile Number</label>
						<div class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text"><i class="ti-mobile"></i></span>
							</div>
							<input type="text" name="request[mobile]" class="form-control" value="<?php echo $result['mobile']; ?>" placeholder="Enter Requester Mobile Number . . .">
						</div>
					</div>
					<div class="form-group">
						<label>Subject <span class="form-required">*</span></label>
						<div class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text"><i class="ti-tag"></i></span>
							</div>
							<input type="text" name="request[subject]" class="form-control" value="<?php echo $result['subject']; ?>" placeholder="Enter Subject . . .">
						</div>
					</div>
					<div class="form-group">
						<label>Created Date</label>
						<div class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text"><i class="ti-calendar"></i></span>
							</div>
							<input type="text" class="form-control" value="<?php echo date_format(date_create($result['date_of_joining']), $common['info']['date_format']); ?>">
						</div>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label>Message <span class="form-required">*</span></label>
						<div class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text"><i class="ti-paragraph"></i></span>
							</div>
							<textarea name="request[message]" class="form-control" placeholder="Enter Message . . ."><?php echo $result['message']; ?></textarea>
						</div>
					</div>
					<div class="form-group">
						<label>Remark/Reply</label>
						<div class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text"><i class="ti-quote-left"></i></span>
							</div>
							<textarea name="request[remark]" class="form-control" placeholder="Enter Remark . . ."><?php echo $result['remark']; ?></textarea>
						</div>
					</div>
					<div class="form-group">
						<label>Status</label>
						<div class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text"><i class="ti-check-box"></i></span>
							</div>
							<select name="request[status]" class="custom-select">
								<option value="1" <?php if($result['status'] == '1' || $result['status'] == NULL) {echo "selected";} ?>>Open</option>
								<option value="0" <?php if($result['status'] == '0') { echo "selected";} ?>>Closed</option>
							</select>
						</div>
					</div>
				</div>
			</div>
		</div>
		<input type="hidden" name="request[id]" value="<?php echo $result['id'];?>">
		<div class="panel-footer text-center">
			<button type="submit" name="submit" class="btn btn-primary"><i class="ti-save-alt pr-2"></i> Save</button>
		</div>
	</div>
</form>

<!-- Footer -->
<?php include (DIR_ADMIN.'app/views/common/footer.tpl.php'); ?>