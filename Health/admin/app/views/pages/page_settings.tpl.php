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
	<input type="hidden" name="_token" value="<?php echo $common['token']; ?>">
	<div class="panel panel-default">
		<div class="panel-body">
			<ul class="nav nav-tabs nav-tabs-line nav-tabs-line-primary">
				<li class="nav-item">
					<a class="nav-link active" href="#settings-general" data-toggle="tab">Settings</a>
				</li>
				<li class="nav-item">  
					<a class="nav-link" href="#settings-customcss" data-toggle="tab">Custom CSS</a>
				</li>
			</ul>
			<div class="tab-content pt-4">
				<div class="tab-pane active" id="settings-general">
					<div class="row align-items-center">
						<div class="col-md-4 col-lg-2">
							<label class="col-form-label m-0">Appointment Settings</label>
						</div>
						<div class="col-md-8 col-lg-10">
							<div class="custom-control custom-checkbox">
								<input type="checkbox" name="generalsettings[appointment]" value="1" class="custom-control-input" id="general-appointment" <?php if (!empty($generalsetting['appointment']) && $generalsetting['appointment'] == 1) { echo "checked"; } ?>>
								<label class="custom-control-label" for="general-appointment">Users must be registered and logged in to Make An Appointment</label>
							</div>
						</div>
					</div>
					<div class="dotted-seprator mt-3 mb-4"></div>
					<div class="row align-items-center">
						<div class="col-md-4 col-lg-2">
							<label class="col-form-label m-0">Comment Settings</label>
						</div>
						<div class="col-md-8 col-lg-10">
							<div class="custom-control custom-checkbox">
								<input type="checkbox" name="generalsettings[comment][post]" value="1" class="custom-control-input" id="comment-post" <?php if (!empty($generalsetting['comment']['post']) && $generalsetting['comment']['post'] == 1) { echo "checked"; } ?>>
								<label class="custom-control-label" for="comment-post">Users must be registered and logged in to comment</label>
							</div>
							<div class="custom-control custom-checkbox">
								<input type="checkbox" name="generalsettings[comment][approve]" value="1" class="custom-control-input" id="comment-approve" <?php if (!empty($generalsetting['comment']['approve']) && $generalsetting['comment']['approve'] == 1) { echo "checked"; } ?>>
								<label class="custom-control-label" for="comment-approve">Comment must be manually approved.</label>
							</div>
						</div>
					</div>
					<div class="dotted-seprator mt-3 mb-4"></div>
					<div class="row align-items-center">
						<div class="col-md-4 col-lg-2">
							<label class="col-form-label m-0">Review Settings</label>
						</div>
						<div class="col-md-8 col-lg-10">
							<div class="custom-control custom-checkbox">
								<input type="checkbox" name="generalsettings[review][post]" value="1" class="custom-control-input" id="review-post" <?php if ( !empty($generalsetting['review']['post']) && $generalsetting['review']['post'] == 1) { echo "checked"; } ?>>
								<label class="custom-control-label" for="review-post">Users must be registered and logged in to Review</label>
							</div>
							<div class="custom-control custom-checkbox">
								<input type="checkbox" name="generalsettings[review][approve]" value="1" class="custom-control-input" id="review-approve" <?php if ( !empty($generalsetting['review']['approve']) && $generalsetting['review']['approve'] == 1) { echo "checked"; } ?>>
								<label class="custom-control-label" for="review-approve">Review must be manually approved.</label>
							</div>
						</div>
					</div>
				</div>
				<div class="tab-pane" id="settings-customcss">
					<div class="form-group">
						<label>Custom CSS for Website</label>
						<textarea name="customcss" class="form-control" rows="15" placeholder="Enter Custom CSS"><?php echo $customcss; ?></textarea>
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