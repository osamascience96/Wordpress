<?php include (DIR_ADMIN.'app/views/common/header.tpl.php'); ?>
<!-- Service page start -->
<div class="page-title">
	<div class="row align-items-center">
		<div class="col-sm-6">
			<h2 class="page-title-text d-inline-block">Service Page</h2>
			<div class="breadcrumbs d-inline-block">
				<ul>
					<li><a href="<?php echo URL_ADMIN; ?>">Dashboard</a></li>
					<li><a href="<?php echo URL_ADMIN.DIR_ROUTE.'pages'; ?>">Pages</a></li>
					<li>Service Page</li>
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
					<a class="nav-link active" href="#services" data-toggle="tab">Service Section</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="#facilities" data-toggle="tab">Facility Section</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="#meta" data-toggle="tab">Meta/Seo</a>
				</li>
			</ul>
			<div class="tab-content pt-4">
				<div class="tab-pane active" id="services">
					<div class="form-group">
						<label>Page Title</label>
						<input type="text" name="page[title]" class="form-control" value="<?php echo $result['page_title']; ?>" placeholder="Enter Page Name . . .">
					</div>
					<div class="row">
						<div class="col-lg-6">	
							<div class="form-group">
								<label>Service List</label>
								<div class="form-text">All enabled services will be displayed If you do not want to display then make them disabled.</div>
							</div>
						</div>
					</div>
				</div>
				<div class="tab-pane" id="facilities">
					<div class="form-group">
						<div class="custom-control custom-checkbox custom-checkbox-1 mb-3">
							<input type="checkbox" name="page[content][facility][status]" class="custom-control-input" id="page-facility-section" value="1" <?php if (!empty($result['page_data']['facility']['status']) && $result['page_data']['facility']['status']) { echo "checked"; }?> >
							<label class="custom-control-label" for="page-facility-section">Want to display this section on website?</label>
						</div>
					</div>
					<div class="row">
						<div class="col-lg-6">
							<div class="form-group">
								<label>Section Title</label>
								<input type="text" name="page[content][facility][title]" value="<?php echo $result['page_data']['facility']['title']; ?>" placeholder="Facility Section Name">
							</div>
							<div class="form-group">
								<label>Facility List</label>
								<div class="form-text">
									All enabled Facilities will be displayed If you do not want to display then make them disabled.
								</div>
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