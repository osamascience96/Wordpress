<?php include (DIR_ADMIN.'app/views/common/header.tpl.php'); ?>
<!-- Home page start -->
<div class="page-title">
	<div class="row align-items-center">
		<div class="col-sm-6">
			<h2 class="page-title-text d-inline-block">Home</h2>
			<div class="breadcrumbs d-inline-block">
				<ul>
					<li><a href="<?php echo URL_ADMIN; ?>">Dashboard</a></li>
					<li><a href="<?php echo URL_ADMIN.DIR_ROUTE.'pages'; ?>">Pages</a></li>
					<li>Home</li>
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
					<a class="nav-link active" href="#page-home-slider" data-toggle="tab">Slider</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="#page-home-services" data-toggle="tab">Service</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="#page-home-about" data-toggle="tab">About Us</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="#page-home-facilities" data-toggle="tab">Facility</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="#page-home-doctors" data-toggle="tab">Doctor</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="#page-home-blogs" data-toggle="tab">Blog</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="#page-home-testimonials" data-toggle="tab">Testimonial</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="#page-home-meta" data-toggle="tab">Meta/Seo</a>
				</li>
			</ul>
			<div class="tab-content pt-4">
				<div class="tab-pane active" id="page-home-slider">
					<div class="form-group">
						<label>Page Title</label>
						<input type="text" name="page[title]" class="form-control" value="<?php echo $result['page_title'] ?>" placeholder="Enter Page Name . . .">
					</div>
					<div class="row">
						<?php foreach ($result['page_data']['slider'] as $key => $value) { ?>
							<div class="col-lg-4">
								<div class="form-group">
									<label class="d-block">Slide <?php echo $key+1; ?> Picture : </label>
									<div class="image-upload" <?php if (!empty($value['img'])) { echo " style=\"display: none\" "; }?> >
										<a>Upload</a>
									</div>
									<div class="saved-picture" <?php if (empty($value['img'])) { echo " style=\"display: none\" "; } ?> >
										<?php if (!empty($value['img'])) { ?>
											<img class="img-thumbnail" src="../public/uploads/<?php echo $value['img']; ?>" alt="">
										<?php } ?>
										<input type="hidden" name="page[content][slider][<?php echo $key; ?>][img]" value="<?php echo $value['img']; ?>">
									</div>
									<div class="saved-picture-delete" data-toggle="tooltip" data-placement="right" title="Remove" <?php if (empty($value['img'])) { echo " style=\"display: none\" "; } ?> >
										<a class="fa fa-times"></a>
									</div>
									<div class="form-text">(Size: 1920px x 800px)</div>
								</div>
								<div class="form-group">
									<label>Slide <?php echo $key+1; ?> tag line : </label>
									<input type="text" class="form-control" name="page[content][slider][<?php echo $key; ?>][tag]" value="<?php echo $value['tag']; ?>" placeholder="Slide Tag Line">
								</div>
								<div class="form-group">
									<label>Slide <?php echo $key+1; ?> content : </label>
									<textarea class="form-control" name="page[content][slider][<?php echo $key; ?>][content]" placeholder="Slide content"><?php if (!empty($value['content'])) { echo $value['content']; } ?></textarea>
								</div>
							</div>
						<?php } ?>
					</div>
				</div>
				<div class="tab-pane" id="page-home-services">
					<div class="form-group">
						<div class="custom-control custom-checkbox custom-checkbox-1 mb-3">
							<input type="checkbox" name="page[content][service][status]" class="custom-control-input" id="page-service-section" value="1" <?php if (!empty($result['page_data']['service']['status']) && $result['page_data']['service']['status']) { echo "checked"; }?> >
							<label class="custom-control-label" for="page-service-section">Want to display this section on website?</label>
						</div>
					</div>
					<div class="row">
						<div class="col-lg-6">
							<div class="form-group">
								<label>Section Title</label>
								<input type="text" class="form-control" name="page[content][service][title]" value="<?php echo $result['page_data']['service']['title']; ?>" placeholder="Service Section Name">
							</div>
							<div class="form-group">
								<label>Section Description</label>
								<textarea name="page[content][service][description]" class="form-control" placeholder="Service Section About"><?php echo $result['page_data']['service']['description']; ?></textarea>
							</div>
							<div class="form-group">
								<label>Services List</label>
								<div class="form-text">Maximum six services will be displayed according to priority.</div>
							</div>
						</div>
						<div class="col-lg-6">
							<div class="form-group">
								<label class="d-block">Section Picture</label>
								<div class="image-upload" <?php if (!empty($result['page_data']['service']['picture'])) { echo " style=\"display: none\" "; }?> >
									<a>Upload</a>
								</div>
								<div class="saved-picture" <?php if (empty($result['page_data']['service']['picture'])) { echo " style=\"display: none\" "; } ?> >
									<?php if (!empty($result['page_data']['service']['picture'])) { ?>
										<img class="img-thumbnail" src="../public/uploads/<?php echo $result['page_data']['service']['picture']; ?>" alt="">
									<?php } ?>
									<input type="hidden" name="page[content][service][picture]" value="<?php echo $result['page_data']['service']['picture']; ?>">
								</div>
								<div class="saved-picture-delete" data-toggle="tooltip" data-placement="right" title="Remove" <?php if (empty($result['page_data']['service']['picture'])) { echo " style=\"display: none\" "; } ?> >
									<a class="fa fa-times"></a>
								</div>
								<div class="form-text">(Size: 620px * 680px)</div>
							</div>
						</div>
					</div>
				</div>
				<div class="tab-pane" id="page-home-about">
					<div class="form-group">
						<div class="custom-control custom-checkbox custom-checkbox-1 mb-3">
							<input type="checkbox" name="page[content][about][status]" class="custom-control-input" id="page-about-section" value="1" <?php if (!empty($result['page_data']['about']['status']) && $result['page_data']['about']['status']) { echo "checked"; }?> >
							<label class="custom-control-label" for="page-about-section">Want to display this section on website?</label>
						</div>
					</div>
					<div class="row">
						<div class="col-lg-6">
							<div class="form-group">
								<label>Section Title</label>
								<input type="text" class="form-control" name="page[content][about][title]" value="<?php echo $result['page_data']['about']['title']; ?>" placeholder="About Section Name">
							</div>
							<?php foreach ($result['page_data']['about']['block'] as $key => $value) { ?>
								<div class="form-group">
									<label>Block <?php echo $key+1; ?></label>
									<div class="row">
										<div class="col-sm-4">
											<input type="text" class="form-control" name="page[content][about][block][<?php echo $key; ?>][icon]" value="<?php echo $value['icon']; ?>" placeholder="Icon Name (Ex: fa-user)">
										</div>
										<div class="col-sm-4">
											<input type="text" class="form-control" name="page[content][about][block][<?php echo $key; ?>][title]" value="<?php echo $value['title']; ?>" placeholder="Title (Ex: Doctor)">
										</div>
										<div class="col-sm-4">
											<input type="text" class="form-control" name="page[content][about][block][<?php echo $key; ?>][count]" value="<?php echo $value['count']; ?>" placeholder="Number or Count (Ex: 9)">
										</div>
									</div>

								</div>
							<?php } ?>
						</div>
						<div class="col-lg-6">
							<div class="form-group">
								<label class="d-block">Section Picture</label>
								<div class="image-upload" <?php if (!empty($result['page_data']['about']['picture'])) { echo " style=\"display: none\" "; } ?> >
									<a>Upload</a>
								</div>
								<div class="saved-picture" <?php if (empty($result['page_data']['about']['picture'])) { echo " style=\"display: none\" "; } ?> >
									<?php if (!empty($result['page_data']['about']['picture'])) { ?>
										<img class="img-thumbnail" src="../public/uploads/<?php echo $result['page_data']['about']['picture']; ?>" alt="">
									<?php } ?>
									<input type="hidden" name="page[content][about][picture]" value="<?php echo $result['page_data']['about']['picture']; ?>">
								</div>
								<div class="saved-picture-delete" data-toggle="tooltip" data-placement="right" title="Remove" <?php if (empty($result['page_data']['about']['picture'])) { echo " style=\"display: none\" "; } ?> >
									<a class="fa fa-times"></a>
								</div>
								<div class="form-text">(Size: 660px x 750px)</div>
							</div>
							<div class="form-group">
								<label>Section Description</label>
								<textarea name="page[content][about][description]" class="form-control" placeholder="About Section Moto"><?php echo $result['page_data']['about']['description']; ?></textarea>
							</div>
							<div class="form-group">
								<label class="d-block">Section Background Image</label>
								<div class="image-upload" <?php if (!empty($result['page_data']['about']['background'])) { echo " style=\"display: none\" "; }?> >
									<a>Upload</a>
								</div>
								<div class="saved-picture" <?php if (empty($result['page_data']['about']['background'])) { echo " style=\"display: none\" "; } ?> >
									<?php if (!empty($result['page_data']['about']['background'])) { ?>
										<img class="img-thumbnail" src="../public/uploads/<?php echo $result['page_data']['about']['background']; ?>" alt="">
									<?php } ?>
									<input type="hidden" name="page[content][about][background]" value="<?php echo $result['page_data']['about']['background']; ?>">
								</div>
								<div class="saved-picture-delete" data-toggle="tooltip" data-placement="right" title="Remove" <?php if (empty($result['page_data']['about']['background'])) { echo " style=\"display: none\" "; } ?> >
									<a class="fa fa-times"></a>
								</div>
								<div class="form-text">(Size: 1920px * 800px)</div>
							</div>
						</div>
					</div>
				</div>
				<div class="tab-pane" id="page-home-facilities">
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
								<input type="text" name="page[content][facility][title]" class="form-control" value="<?php echo $result['page_data']['facility']['title']; ?>" placeholder="Facility Section Name">
							</div>
							<div class="form-group">
								<label>Facility Lists</label>
								<div class="form-text">
									All enabled facilities will be displayed If you do not want to display then make them disabled.
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="tab-pane" id="page-home-doctors">
					<div class="form-group">
						<div class="custom-control custom-checkbox custom-checkbox-1 mb-3">
							<input type="checkbox" name="page[content][doctor][status]" class="custom-control-input" id="page-doctor-section" value="1" <?php if (!empty($result['page_data']['doctor']['status']) && $result['page_data']['doctor']['status']) { echo "checked"; }?> >
							<label class="custom-control-label" for="page-doctor-section">Want to display this section on website?</label>
						</div>
					</div>
					<div class="row">
						<div class="col-lg-6">
							<div class="form-group">
								<label>Section Title</label>
								<input type="text" name="page[content][doctor][title]" class="form-control" value="<?php echo $result['page_data']['doctor']['title']; ?>" placeholder="Doctor Section Title">
							</div>
							<div class="form-group">
								<label>Doctor Slider</label>
								<div class="form-text">Maximum six doctors will be displayed according to priority.</div>
							</div>
						</div>
						<div class="col-lg-6">
							<div class="form-group">
								<label class="d-block">Section Background Image</label>
								<div class="image-upload" <?php if (!empty($result['page_data']['doctor']['background'])) { echo " style=\"display: none\" "; }?> >
									<a>Upload</a>
								</div>
								<div class="saved-picture" <?php if (empty($result['page_data']['doctor']['background'])) { echo " style=\"display: none\" "; } ?> >
									<?php if (!empty($result['page_data']['doctor']['background'])) { ?>
										<img class="img-thumbnail" src="../public/uploads/<?php echo $result['page_data']['doctor']['background']; ?>" alt="">
									<?php } ?>
									<input type="hidden" name="page[content][doctor][background]" value="<?php echo $result['page_data']['doctor']['background']; ?>">
								</div>
								<div class="saved-picture-delete" data-toggle="tooltip" data-placement="right" title="Remove" <?php if (empty($result['page_data']['doctor']['background'])) { echo " style=\"display: none\" "; } ?> >
									<a class="fa fa-times"></a>
								</div>
								<div class="form-text">(Size: 1920px * 800px)</div>
							</div>
						</div>
					</div>
				</div>
				<div class="tab-pane" id="page-home-blogs">
					<div class="form-group">
						<div class="custom-control custom-checkbox custom-checkbox-1 mb-3">
							<input type="checkbox" name="page[content][blog][status]" class="custom-control-input" id="page-blog-section" value="1" <?php if (!empty($result['page_data']['blog']['status']) && $result['page_data']['blog']['status']) { echo "checked"; }?> >
							<label class="custom-control-label" for="page-blog-section">Want to display this section on website?</label>
						</div>
					</div>
					<div class="row">
						<div class="col-lg-6">
							<div class="form-group">
								<label>Section Title</label>
								<input type="text" name="page[content][blog][title]" class="form-control" value="<?php echo $result['page_data']['blog']['title']; ?>" placeholder="Blog Section Title">
							</div>
							<div class="form-group">
								<label>Blog Lists : </label>
								<div class="form-text">
									Latest three blog will be displayed on home page.
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="tab-pane" id="page-home-testimonials">
					<div class="form-group">
						<div class="custom-control custom-checkbox custom-checkbox-1 mb-3">
							<input type="checkbox" name="page[content][testimonial][status]" class="custom-control-input" id="page-testimonial-section" value="1" <?php if (!empty($result['page_data']['testimonial']['status']) && $result['page_data']['testimonial']['status']) { echo "checked"; }?> >
							<label class="custom-control-label" for="page-testimonial-section">Want to display this section on website?</label>
						</div>
					</div>
					<div class="row">
						<div class="col-lg-6">
							<div class="form-group">
								<label>Section Title</label>
								<input type="text" name="page[content][testimonial][title]" class="form-group" value="<?php echo $result['page_data']['testimonial']['title']; ?>" placeholder="Testimonial Section Name">
							</div>
							<div class="form-group">
								<label>Testimonial Lists</label>
								<div class="form-text">
									All enabled Testimonial will be displayed If you do not want to display then make them disabled.
								</div>
							</div>
						</div>
						<div class="col-lg-6">
							
						<div class="col-lg-6">
							<div class="form-group">
								<label class="d-block">Section Background Image</label>
								<div class="image-upload" <?php if (!empty($result['page_data']['testimonial']['background'])) { echo " style=\"display: none\" "; }?> >
									<a>Upload</a>
								</div>
								<div class="saved-picture" <?php if (empty($result['page_data']['testimonial']['background'])) { echo " style=\"display: none\" "; } ?> >
									<?php if (!empty($result['page_data']['testimonial']['background'])) { ?>
										<img class="img-thumbnail" src="../public/uploads/<?php echo $result['page_data']['testimonial']['background']; ?>" alt="">
									<?php } ?>
									<input type="hidden" name="page[content][testimonial][background]" value="<?php echo $result['page_data']['testimonial']['background']; ?>">
								</div>
								<div class="saved-picture-delete" data-toggle="tooltip" data-placement="right" title="Remove" <?php if (empty($result['page_data']['testimonial']['background'])) { echo " style=\"display: none\" "; } ?> >
									<a class="fa fa-times"></a>
								</div>
								<div class="form-text">(Size: 1920px * 800px)</div>
							</div>
						</div>
						</div>
					</div>
				</div>
				<div class="tab-pane" id="page-home-meta">
					<div class="row">
						<div class="col-lg-6">
							<div class="form-group">
								<label>Meta Tag</label>
								<input type="text" class="form-control" name="page[meta][tag]" value="<?php echo $result['meta_tag']; ?>" placeholder="Meta Tag Title" required>
							</div>
							<div class="form-group">
								<label>Meta Description</label>
								<textarea name="page[meta][description]" class="form-control" placeholder="Meta Tag Description"><?php echo $result['meta_description']; ?></textarea>
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