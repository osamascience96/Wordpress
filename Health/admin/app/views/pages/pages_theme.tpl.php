<?php include (DIR_ADMIN.'app/views/common/header.tpl.php'); ?>
<!-- Doctor page start -->
<div class="page-title">
	<div class="row align-items-center">
		<div class="col-sm-6">
			<h2 class="page-title-text d-inline-block">Page Theme</h2>
			<div class="breadcrumbs d-inline-block">
				<ul>
					<li><a href="<?php echo URL_ADMIN; ?>">Dashboard</a></li>
					<li>Page Theme</li>
				</ul>
			</div>
		</div>
		<div class="col-sm-6 text-right"></div>
	</div>
</div>
<div class="panel panel-default">
	<form action="<?php echo $action; ?>" method="post">
		<input type="hidden" name="_token" value="<?php echo $token; ?>">
		<div class="panel-body">
			<div class="table-responsive">
				<table class="table table-bordered table-middle datatable-table">
					<thead>
						<tr>
							<th>Page Name</th>
							<th>Page Theme</th>
							<th>Page Header</th>
							<th class="d-none"></th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>Home</td>
							<td>
								<select name="page[home][theme]" class="custom-select mb-0">
									<option value="home-1" <?php if ($result['home']['theme'] == "home-1") { echo "selected"; } ?>>Home Style 1</option>
									<option value="home-2" <?php if ($result['home']['theme'] == "home-2") { echo "selected"; } ?>>Home Style 2</option>
									<option value="home-3" <?php if ($result['home']['theme'] == "home-3") { echo "selected"; } ?>>Home Style 3</option>
									<option value="home-4" <?php if ($result['home']['theme'] == "home-4") { echo "selected"; } ?>>Home Style 4</option>
								</select>
							</td>
							<td>
								<select name="page[home][header]" class="custom-select mb-0">
									<option value="header-1" <?php if ($result['home']['header'] == "header-1") { echo "selected"; } ?>>Header Style 1</option>
									<option value="header-2" <?php if ($result['home']['header'] == "header-2") { echo "selected"; } ?>>Header Style 2</option>
									<option value="header-3" <?php if ($result['home']['header'] == "header-3") { echo "selected"; } ?>>Header Style 3</option>
									<option value="header-4" <?php if ($result['home']['header'] == "header-4") { echo "selected"; } ?>>Header Style 4</option>
								</select>
							</td>
							<td class="d-none">
								<div class="custom-control custom-checkbox">
									<input type="checkbox" name="page[home][status]" class="custom-control-input" id="page-theme-home" value="1" <?php if (isset($result['home']['status']) && $result['home']['status'] == "1") { echo "checked"; } ?>>
									<label class="custom-control-label" for="page-theme-home">Show on Website</label>
								</div>
							</td>
						</tr>
						<tr>
							<td>Service</td>
							<td>
								<select name="page[services][theme]" class="custom-select mb-0">
									<option value="services-1" <?php if ($result['services']['theme'] == "services-1") { echo "selected"; } ?>>Service Style 1</option>
									<option value="services-2" <?php if ($result['services']['theme'] == "services-2") { echo "selected"; } ?>>Service Style 2</option>
									<option value="services-3" <?php if ($result['services']['theme'] == "services-3") { echo "selected"; } ?>>Service Style 3</option>
									<option value="services-4" <?php if ($result['services']['theme'] == "services-4") { echo "selected"; } ?>>Service Style 1 with Right Sidebar</option>
									<option value="services-5" <?php if ($result['services']['theme'] == "services-5") { echo "selected"; } ?>>Service Style 2 with Right Sidebar</option>
									<option value="services-6" <?php if ($result['services']['theme'] == "services-6") { echo "selected"; } ?>>Service Style 1 with Left Sidebar</option>
									<option value="services-7" <?php if ($result['services']['theme'] == "services-7") { echo "selected"; } ?>>Service Style 2 with Left Sidebar</option>
								</select>
							</td>
							<td>
								<select name="page[services][header]" class="custom-select mb-0">
									<option value="header-1" <?php if ($result['services']['header'] == "header-1") { echo "selected"; } ?>>Header Style 1</option>
									<option value="header-2" <?php if ($result['services']['header'] == "header-2") { echo "selected"; } ?>>Header Style 2</option>
									<option value="header-3" <?php if ($result['services']['header'] == "header-3") { echo "selected"; } ?>>Header Style 3</option>
									<option value="header-4" <?php if ($result['services']['header'] == "header-4") { echo "selected"; } ?>>Header Style 4</option>
								</select>
							</td>
							<td class="d-none">
								<div class="custom-control custom-checkbox">
									<input type="checkbox" name="page[services][status]" class="custom-control-input" id="page-theme-service" value="1" <?php if (isset($result['services']['status']) && $result['services']['status'] == "1") { echo "checked"; } ?>>
									<label class="custom-control-label" for="page-theme-service">Show on Website</label>
								</div>
							</td>
						</tr>
						<tr>
							<td>Doctor</td>
							<td>
								<select name="page[doctors][theme]" class="custom-select mb-0">
									<option value="doctors-1" <?php if ($result['doctors']['theme'] == "doctors-1") { echo "selected"; } ?>>Doctor Style 1</option>
									<option value="doctors-2" <?php if ($result['doctors']['theme'] == "doctors-2") { echo "selected"; } ?>>Doctor Style 2</option>
									<option value="doctors-3" <?php if ($result['doctors']['theme'] == "doctors-3") { echo "selected"; } ?>>Doctor Style 3</option>
									<option value="doctors-4" <?php if ($result['doctors']['theme'] == "doctors-4") { echo "selected"; } ?>>Doctor Style 1 with Right Sidebar</option>
									<option value="doctors-5" <?php if ($result['doctors']['theme'] == "doctors-5") { echo "selected"; } ?>>Doctor Style 2 with Right Sidebar</option>
									<option value="doctors-6" <?php if ($result['doctors']['theme'] == "doctors-6") { echo "selected"; } ?>>Doctor Style 3 with Right Sidebar</option>
									<option value="doctors-7" <?php if ($result['doctors']['theme'] == "doctors-7") { echo "selected"; } ?>>Doctor Style 1 with Left Sidebar</option>
									<option value="doctors-8" <?php if ($result['doctors']['theme'] == "doctors-8") { echo "selected"; } ?>>Doctor Style 2 with Left Sidebar</option>
									<option value="doctors-9" <?php if ($result['doctors']['theme'] == "doctors-9") { echo "selected"; } ?>>Doctor Style 3 with Left Sidebar</option>
								</select>
							</td>
							<td>
								<select name="page[doctors][header]" class="custom-select mb-0">
									<option value="header-1" <?php if ($result['doctors']['header'] == "header-1") { echo "selected"; } ?>>Header Style 1</option>
									<option value="header-2" <?php if ($result['doctors']['header'] == "header-2") { echo "selected"; } ?>>Header Style 2</option>
									<option value="header-3" <?php if ($result['doctors']['header'] == "header-3") { echo "selected"; } ?>>Header Style 3</option>
									<option value="header-4" <?php if ($result['doctors']['header'] == "header-4") { echo "selected"; } ?>>Header Style 4</option>
								</select>
							</td>
							<td class="d-none">
								<div class="custom-control custom-checkbox">
									<input type="checkbox" name="page[doctors][status]" class="custom-control-input" id="page-theme-doctor" value="1" <?php if (isset($result['doctors']['status']) && $result['doctors']['status'] == "1") { echo "checked"; } ?>>
									<label class="custom-control-label" for="page-theme-doctor">Show on Website</label>
								</div>
							</td>
						</tr>
						<tr>
							<td>Blog</td>
							<td>
								<select name="page[blogs][theme]" class="custom-select mb-0">
									<option value="blogs-1" <?php if ($result['blogs']['theme'] == "blogs-1") { echo "selected"; } ?>>Blog Style 1</option>
									<option value="blogs-2" <?php if ($result['blogs']['theme'] == "blogs-2") { echo "selected"; } ?>>Blog Style 2</option>
									<option value="blogs-3" <?php if ($result['blogs']['theme'] == "blogs-3") { echo "selected"; } ?>>Blog Style 3 with Right Sidebar</option>
									<option value="blogs-4" <?php if ($result['blogs']['theme'] == "blogs-4") { echo "selected"; } ?>>Blog Style 1 with Right Sidebar</option>
									<option value="blogs-5" <?php if ($result['blogs']['theme'] == "blogs-5") { echo "selected"; } ?>>Blog Style 2 with Right Sidebar</option>
									<option value="blogs-6" <?php if ($result['blogs']['theme'] == "blogs-6") { echo "selected"; } ?>>Blog Style 1 with Left Sidebar</option>
									<option value="blogs-7" <?php if ($result['blogs']['theme'] == "blogs-7") { echo "selected"; } ?>>Blog Style 2 with Left Sidebar</option>
									<option value="blogs-8" <?php if ($result['blogs']['theme'] == "blogs-8") { echo "selected"; } ?>>Blog Style 3 with Left Sidebar</option>
								</select>
							</td>
							<td>
								<select name="page[blogs][header]" class="custom-select mb-0">
									<option value="header-1" <?php if ($result['blogs']['header'] == "header-1") { echo "selected"; } ?>>Header Style 1</option>
									<option value="header-2" <?php if ($result['blogs']['header'] == "header-2") { echo "selected"; } ?>>Header Style 2</option>
									<option value="header-3" <?php if ($result['blogs']['header'] == "header-3") { echo "selected"; } ?>>Header Style 3</option>
									<option value="header-4" <?php if ($result['blogs']['header'] == "header-4") { echo "selected"; } ?>>Header Style 4</option>
								</select>
							</td>
							<td class="d-none">
								<div class="custom-control custom-checkbox">
									<input type="checkbox" name="page[blogs][status]" class="custom-control-input" id="page-theme-blog" value="1" <?php if (isset($result['blogs']['status']) && $result['blogs']['status'] == "1") { echo "checked"; } ?>>
									<label class="custom-control-label" for="page-theme-blog">Show on Website</label>
								</div>
							</td>
						</tr>
						<tr>
							<td>About</td>
							<td>
								<select name="page[about][theme]" class="custom-select mb-0">
									<option value="about" <?php if ($result['about']['theme'] == "about") { echo "selected"; } ?>>About Style</option>
								</select>
							</td>
							<td>
								<select name="page[about][header]" class="custom-select mb-0">
									<option value="header-1" <?php if ($result['about']['header'] == "header-1") { echo "selected"; } ?>>Header Style 1</option>
									<option value="header-2" <?php if ($result['about']['header'] == "header-2") { echo "selected"; } ?>>Header Style 2</option>
									<option value="header-3" <?php if ($result['about']['header'] == "header-3") { echo "selected"; } ?>>Header Style 3</option>
									<option value="header-4" <?php if ($result['about']['header'] == "header-4") { echo "selected"; } ?>>Header Style 4</option>
								</select>
							</td>
							<td class="d-none">
								<div class="custom-control custom-checkbox">
									<input type="checkbox" name="page[about][status]" class="custom-control-input" id="page-theme-about" value="1" <?php if (isset($result['about']['status']) && $result['about']['status'] == "1") { echo "checked"; } ?>>
									<label class="custom-control-label" for="page-theme-about">Show on Website</label>
								</div>
							</td>
						</tr>
						<tr>
							<td>Contact</td>
							<td>
								<select name="page[contact][theme]" class="custom-select mb-0">
									<option value="contact" <?php if ($result['contact']['theme'] == "contact") { echo "selected"; } ?>>Contact Style</option>
								</select>
							</td>
							<td>
								<select name="page[contact][header]" class="custom-select mb-0">
									<option value="header-1" <?php if ($result['contact']['header'] == "header-1") { echo "selected"; } ?>>Header Style 1</option>
									<option value="header-2" <?php if ($result['contact']['header'] == "header-2") { echo "selected"; } ?>>Header Style 2</option>
									<option value="header-3" <?php if ($result['contact']['header'] == "header-3") { echo "selected"; } ?>>Header Style 3</option>
									<option value="header-4" <?php if ($result['contact']['header'] == "header-4") { echo "selected"; } ?>>Header Style 4</option>
								</select>
							</td>
							<td class="d-none">
								<div class="custom-control custom-checkbox">
									<input type="checkbox" name="page[contact][status]" class="custom-control-input" id="page-theme-contact" value="1" <?php if (isset($result['contact']['status']) && $result['contact']['status'] == "1") { echo "checked"; } ?>>
									<label class="custom-control-label" for="page-theme-contact">Show on Website</label>
								</div>
							</td>
						</tr>
						<tr>
							<td>Gallery</td>
							<td>
								<select name="page[gallery][theme]" class="custom-select mb-0">
									<option value="gallery" <?php if ($result['gallery']['theme'] == "gallery") { echo "selected"; } ?>>Gallery Style</option>
								</select>
							</td>
							<td>
								<select name="page[gallery][header]" class="custom-select mb-0">
									<option value="header-1" <?php if ($result['gallery']['header'] == "header-1") { echo "selected"; } ?>>Header Style 1</option>
									<option value="header-2" <?php if ($result['gallery']['header'] == "header-2") { echo "selected"; } ?>>Header Style 2</option>
									<option value="header-3" <?php if ($result['gallery']['header'] == "header-3") { echo "selected"; } ?>>Header Style 3</option>
									<option value="header-4" <?php if ($result['gallery']['header'] == "header-4") { echo "selected"; } ?>>Header Style 4</option>
								</select>
							</td>
							<td class="d-none">
								<div class="custom-control custom-checkbox">
									<input type="checkbox" name="page[gallery][status]" class="custom-control-input" id="page-theme-gallery" value="1" <?php if (isset($result['gallery']['status']) && $result['gallery']['status'] == "1") { echo "checked"; } ?>>
									<label class="custom-control-label" for="page-theme-gallery">Show on Website</label>
								</div>
							</td>
						</tr>
						<tr>
							<td>Faq</td>
							<td>
								<select name="page[faq][theme]" class="custom-select mb-0">
									<option value="faq" <?php if ($result['faq']['theme'] == "faq") { echo "selected"; } ?>>Faq Style</option>
								</select>
							</td>
							<td>
								<select name="page[faq][header]" class="custom-select mb-0">
									<option value="header-1" <?php if ($result['faq']['header'] == "header-1") { echo "selected"; } ?>>Header Style 1</option>
									<option value="header-2" <?php if ($result['faq']['header'] == "header-2") { echo "selected"; } ?>>Header Style 2</option>
									<option value="header-3" <?php if ($result['faq']['header'] == "header-3") { echo "selected"; } ?>>Header Style 3</option>
									<option value="header-4" <?php if ($result['faq']['header'] == "header-4") { echo "selected"; } ?>>Header Style 4</option>
								</select>
							</td>
							<td class="d-none">
								<div class="custom-control custom-checkbox">
									<input type="checkbox" name="page[faq][status]" class="custom-control-input" id="page-theme-faq" value="1" <?php if (isset($result['faq']['status']) && $result['faq']['status'] == "1") { echo "checked"; } ?>>
									<label class="custom-control-label" for="page-theme-faq">Show on Website</label>
								</div>
							</td>
						</tr>
						<tr>
							<td>Other Pages</td>
							<td>
								<select name="page[other][theme]" class="custom-select mb-0">
									<option value="page-1" <?php if ($result['other']['theme'] == "page-1") { echo "selected"; } ?>>Page Style</option>
									<option value="page-2" <?php if ($result['other']['theme'] == "page-2") { echo "selected"; } ?>>Page with Right Sidebar Style</option>
									<option value="page-3" <?php if ($result['other']['theme'] == "page-3") { echo "selected"; } ?>>Page with Left Sidebar Style</option>
								</select>
							</td>
							<td>
								<select name="page[other][header]" class="custom-select mb-0">
									<option value="header-1" <?php if ($result['other']['header'] == "header-1") { echo "selected"; } ?>>Header Style 1</option>
									<option value="header-2" <?php if ($result['other']['header'] == "header-2") { echo "selected"; } ?>>Header Style 2</option>
									<option value="header-3" <?php if ($result['other']['header'] == "header-3") { echo "selected"; } ?>>Header Style 3</option>
									<option value="header-4" <?php if ($result['other']['header'] == "header-4") { echo "selected"; } ?>>Header Style 4</option>
								</select>
							</td>
							<td class="d-none">
								<div class="custom-control custom-checkbox">
									<input type="checkbox" name="page[other][status]" class="custom-control-input" id="page-theme-other" value="1" <?php if (isset($result['other']['status']) && $result['other']['status'] == "1") { echo "checked"; } ?>>
									<label class="custom-control-label" for="page-theme-other">Show on Website</label>
								</div>
							</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
		<div class="panel-footer text-center">
			<button type="submit" name="submit" class="btn btn-primary"><i class="ti-save-alt pr-2"></i> Save</button>
		</div>
	</form>
</div>

<?php include (DIR_ADMIN.'app/views/common/footer.tpl.php'); ?>