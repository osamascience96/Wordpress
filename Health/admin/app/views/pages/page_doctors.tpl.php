<?php include (DIR_ADMIN.'app/views/common/header.tpl.php'); ?>
<!-- Doctor page start -->
<div class="page-title">
	<div class="row align-items-center">
		<div class="col-sm-6">
			<h2 class="page-title-text d-inline-block">Doctor Page</h2>
			<div class="breadcrumbs d-inline-block">
				<ul>
					<li><a href="<?php echo URL_ADMIN; ?>">Dashboard</a></li>
					<li><a href="<?php echo URL_ADMIN.DIR_ROUTE.'pages'; ?>">Pages</a></li>
					<li>Doctor Page</li>
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
					<a class="nav-link active" href="#doctors" data-toggle="tab">Doctor Section</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="#departments" data-toggle="tab">Department Section</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="#meta" data-toggle="tab">Meta/Seo</a>
				</li>
			</ul>
			<div class="tab-content pt-4">
				<div class="tab-pane active" id="doctors">
					<div class="form-group">
						<label>Page Title</label>
						<input type="text" name="page[title]" class="form-control" value="<?php echo $result['page_title']; ?>" placeholder="Service Section Name">
					</div>
					<div class="row">
						<div class="col-lg-6">
							<div class="form-group">
								<label>Doctor List</label>
								<div class="form-text">
									All enabled Doctors will be displayed If you do not want to display then make them disabled.
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="tab-pane" id="departments">
					<div class="form-group">
						<div class="custom-control custom-checkbox custom-checkbox-1 mb-3">
							<input type="checkbox" name="page[content][department][status]" class="custom-control-input" id="page-department-section" value="1" <?php if (!empty($result['page_data']['department']['status']) && $result['page_data']['department']['status']) { echo "checked"; }?> >
							<label class="custom-control-label" for="page-department-section">Want to display this section on website?</label>
						</div>
					</div>
					<div class="row">
						<div class="col-lg-6">
							<div class="form-group">
								<label>Section Title</label>
								<input type="text" name="page[content][department][title]" class="form-control" value="<?php echo $result['page_data']['department']['title']; ?>" placeholder="Department Section Name">
							</div>
							<div class="form-group">
								<label>Department List</label>
								<div class="form-text">
									All enabled Departments will be displayed If you do not want to display then make them disabled.
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