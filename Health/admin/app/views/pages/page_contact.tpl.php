<?php include (DIR_ADMIN.'app/views/common/header.tpl.php'); ?>
<!-- Contact page start -->
<div class="page-title">
	<div class="row align-items-center">
		<div class="col-sm-6">
			<h2 class="page-title-text d-inline-block">Contact Page</h2>
			<div class="breadcrumbs d-inline-block">
				<ul>
					<li><a href="<?php echo URL_ADMIN; ?>">Dashboard</a></li>
					<li><a href="<?php echo URL_ADMIN.DIR_ROUTE.'pages'; ?>">Pages</a></li>
					<li>Contact Page</li>
				</ul>
			</div>
		</div>
		<div class="col-sm-6 text-right"></div>
	</div>
</div>
<form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data">
	<div class="panel panel-default">
		<div class="panel-body">
			<input type="hidden" name="_token" value="<?php echo $token; ?>">
			<input type="hidden" name="page[id]" value="<?php echo $result['id']; ?>">
			<ul class="nav nav-tabs nav-tabs-line nav-tabs-line-primary">
				<li class="nav-item">
					<a class="nav-link active" href="#services" data-toggle="tab">Contact Section</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="#google-map" data-toggle="tab">Google Map</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="#meta" data-toggle="tab">Meta/Seo</a>
				</li>
			</ul>
			<div class="tab-content pt-4">
				<div class="tab-pane active" id="services">
					<div class="form-group">
						<label>Page Title</label>
						<input type="text" name="page[title]" class="form-control" value="<?php echo $result['page_title'] ?>" placeholder="Enter Page Name . . .">
					</div>
					<div class="row">
						<div class="col-lg-6">
							<div class="form-group">
								<label>Appointment Block</label>
								<input type="text" name="page[content][contact][block][0][icon]" value="<?php echo $result['page_data']['contact']['block']['0']['icon']; ?>" placeholder="Icon Name (Ex: fa-user)">
								<input type="text" name="page[content][contact][block][0][title]" value="<?php echo $result['page_data']['contact']['block']['0']['title']; ?>" placeholder="Title (Ex: Doctor)">
								<input type="text" name="page[content][contact][block][0][data1]" value="<?php echo $result['page_data']['contact']['block']['0']['data1']; ?>" placeholder="Appointment Mobile Number">
								<input type="text" name="page[content][contact][block][0][data2]" value="<?php echo $result['page_data']['contact']['block']['0']['data2']; ?>" placeholder="Appointment Email Address">
							</div>
							<div class="form-group">
								<label>Call Us Block</label>
								<input type="text" name="page[content][contact][block][1][icon]" value="<?php echo $result['page_data']['contact']['block']['1']['icon']; ?>" placeholder="Icon Name (Ex: fa-user)">
								<input type="text" name="page[content][contact][block][1][title]" value="<?php echo $result['page_data']['contact']['block']['1']['title']; ?>" placeholder="Title (Ex: Doctor)">
								<input type="text" name="page[content][contact][block][1][data1]" value="<?php echo $result['page_data']['contact']['block']['1']['data1']; ?>" placeholder="Mobile Number First">
								<input type="text" name="page[content][contact][block][1][data2]" value="<?php echo $result['page_data']['contact']['block']['1']['data2']; ?>" placeholder="Mobile Number Second">
							</div>
						</div>
						<div class="col-lg-6">
							<div class="form-group">
								<label>Email Us Block</label>
								<input type="text" name="page[content][contact][block][2][icon]" value="<?php echo $result['page_data']['contact']['block']['2']['icon']; ?>" placeholder="Icon Name (Ex: fa-user)">
								<input type="text" name="page[content][contact][block][2][title]" value="<?php echo $result['page_data']['contact']['block']['2']['title']; ?>" placeholder="Title (Ex: Doctor)">
								<input type="text" name="page[content][contact][block][2][data1]" value="<?php echo $result['page_data']['contact']['block']['2']['data1']; ?>" placeholder="Email Address">
								<input type="text" name="page[content][contact][block][2][data2]" value="<?php echo $result['page_data']['contact']['block']['2']['data2']; ?>" placeholder="Email Address">
							</div>
							<div class="form-group">
								<label>Location Block</label>
								<input type="text" name="page[content][contact][block][3][icon]" value="<?php echo $result['page_data']['contact']['block']['3']['icon']; ?>" placeholder="Icon Name (Ex: fa-user)">
								<input type="text" name="page[content][contact][block][3][title]" value="<?php echo $result['page_data']['contact']['block']['3']['title']; ?>" placeholder="Title (Ex: EMAIL US)">
								<input type="text" name="page[content][contact][block][3][data1]" value="<?php echo $result['page_data']['contact']['block']['3']['data1']; ?>" placeholder="Your Clinic Address">
							</div>
						</div>
					</div>
				</div>
				<div class="tab-pane" id="google-map">
					<div class="form-group">
						<div class="custom-control custom-checkbox custom-checkbox-1 mb-3">
							<input type="checkbox" name="page[content][googlemap][status]" class="custom-control-input" id="page-google-map-section" value="1" <?php if (!empty($result['page_data']['googlemap']['status']) && $result['page_data']['googlemap']['status']) { echo "checked"; }?> >
							<label class="custom-control-label" for="page-google-map-section">Want to display this section on website?</label>
						</div>
					</div>
					<div class="row">
						<div class="col-lg-6">
							<div class="form-group">
								<label><text>*</text>Google Map API Key</label>
								<input type="text" class="form-group" name="page[content][contact][googleapikey]" value="<?php echo $result['page_data']['contact']['googleapikey']; ?>" placeholder="Enter Google map API key">
							</div>
							<div class="form-group">
								<label><text>*</text>Lattitude</label>
								<input type="text" class="form-group" name="page[content][contact][latitude]" value="<?php echo $result['page_data']['contact']['latitude']; ?>" placeholder="Clinic lattitude" required>
							</div>
							<div class="form-group">
								<label><text>*</text>Longitude</label>
								<input type="text" class="form-group" name="page[content][contact][longitude]" value="<?php echo $result['page_data']['contact']['longitude']; ?>" placeholder="Clinic Longitude" required>
							</div>
						</div>
					</div>
				</div>
				<div class="tab-pane" id="meta">
					<div class="row">
						<div class="col-lg-6">
							<div class="form-group">
								<label>Meta Tag</label>
								<input type="text" class="form-control" name="page[meta][tag]" value="<?php echo $result['meta_tag']; ?>" placeholder="Meta Tag Title" required>
							</div>
							<div class="form-group">
								<label>Meta Description</label>
								<textarea class="form-control" name="page[meta][description]" placeholder="Meta Tag Description"><?php echo $result['meta_description']; ?></textarea>
							</div>
						</div>
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