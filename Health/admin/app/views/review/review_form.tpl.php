<?php include (DIR_ADMIN.'app/views/common/header.tpl.php'); ?>
<div class="page-title">
	<div class="row align-items-center">
		<div class="col-sm-6">
			<h2 class="page-title-text d-inline-block"><?php echo $page_title; ?></h2>
			<div class="breadcrumbs d-inline-block">
				<ul>
					<li><a href="<?php echo URL_ADMIN; ?>">Dashboard</a></li>
					<li><a href="<?php echo URL_ADMIN.DIR_ROUTE.'reviews'; ?>">Reviews</a></li>
					<li><?php echo $page_title; ?></li>
				</ul>
			</div>
		</div>
		<div class="col-sm-6 text-right"></div>
	</div>
</div>

<div class="row">
	<div class="col-lg-8">
		<form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data">
			<input type="hidden" name="_token" value="<?php echo $token; ?>">
			<div class="panel panel-default">
				<div class="panel-body">
					<div class="form-group">
						<label>Review</label>
						<div class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text"><i class="ti-paragraph"></i></span>
							</div>
							<textarea type="text" name="review[content]" class="form-control" placeholder="Enter Review . . ."><?php echo $result['content']; ?></textarea>
						</div>
					</div>
					<div class="form-group">
						<label>Status</label>
						<div class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text"><i class="ti-check-box"></i></span>
							</div>
							<select name="review[status]" class="custom-select">
								<option value="1" <?php if($result['status'] == '1') { echo "selected";} ?> >Enabled</option>
								<option value="0" <?php if($result['status'] == '0') { echo "selected";} ?> >Disabled</option>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label>Review On</label>
						<div class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text"><i class="ti-tag"></i></span>
							</div>
							<input type="text" class="form-control" value="<?php echo 'Service - '. $result['review_for']; ?>" readonly>
						</div>
					</div>
				</div>
				<input type="hidden" name="review[id]" value="<?php echo $result['id'];?>">
				<div class="panel-footer text-center">
					<button type="submit" name="submit" class="btn btn-primary"><i class="ti-save-alt pr-2"></i> Save</button>
				</div>
			</div>
		</form>
	</div>
	<div class="col-lg-4">
		<div class="panel panel-default">
			<div class="panel-head">
				<div class="panel-title">
					<span class="panel-title-text">Reviewer Info</span>
				</div>
			</div>
			<div class="panel-body">
				<div class="form-group">
					<label>Reviewer Name</label>
					<div class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text"><i class="ti-user"></i></span>
						</div>
						<input type="text" class="form-control" value="<?php echo $result['name']; ?>" readonly>
					</div>
				</div>
				<div class="form-group">
					<label>Reviewer Email</label>
					<div class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text"><i class="ti-email"></i></span>
						</div>
						<input type="text" class="form-control" value="<?php echo $result['email']; ?>" readonly>
					</div>
				</div>
				<div class="form-group">
					<label>Reviewer IP</label>
					<div class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text"><i class="ti-cloud-up"></i></span>
						</div>
						<input type="text" class="form-control" value="<?php echo $result['reviewer_ip']; ?>" readonly>
					</div>
				</div>
				<div class="form-group">
					<label>Created On</label>
					<div class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text"><i class="ti-calendar"></i></span>
						</div>
						<input type="text" class="form-control" value="<?php echo date_format(date_create($result['date_of_joining']), $common['info']['date_format']); ?>" readonly>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- Footer -->
<?php include (DIR_ADMIN.'app/views/common/footer.tpl.php'); ?>