<?php include (DIR_ADMIN.'app/views/common/header.tpl.php'); ?>
<!-- About page start -->
<div class="page-title">
	<div class="row align-items-center">
		<div class="col-sm-6">
			<h2 class="page-title-text d-inline-block">About Us Page</h2>
			<div class="breadcrumbs d-inline-block">
				<ul>
					<li><a href="<?php echo URL_ADMIN; ?>">Dashboard</a></li>
					<li><a href="<?php echo URL_ADMIN.DIR_ROUTE.'pages'; ?>">Pages</a></li>
					<li>About Us Page</li>
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
					<a class="nav-link active" href="#page-aboutus" data-toggle="tab">About Us Section</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="#page-whoweare" data-toggle="tab">Who We Are</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="#page-doctors" data-toggle="tab">Doctor</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="#page-testimonial" data-toggle="tab">Testimonial</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="#page-meta" data-toggle="tab">Meta/Seo</a>
				</li>
			</ul>
			<div class="tab-content pt-4">
				<div class="tab-pane active" id="page-aboutus">
					<div class="form-group">
						<label>Page Title</label>
						<input type="text" name="page[title]" class="form-control" value="<?php echo $result['page_title'] ?>" placeholder="Enter Page Name . . .">
					</div>
					<div class="row">
						<div class="col-lg-8">
							<div class="form-group">
								<label>Paragraph</label>
								<textarea name="page[content][about][paragraph]" class="summernote" placeholder="About Clinic"><?php echo $result['page_data']['about']['paragraph']; ?></textarea>
							</div>
						</div>
						<div class="col-lg-4">
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
								<div class="form-text">(Size: 620px x 680px)</div>
							</div>
						</div>
					</div>
				</div>
				<div class="tab-pane" id="page-whoweare">
					<div class="form-group">
						<div class="custom-control custom-checkbox custom-checkbox-1 mb-3">
							<input type="checkbox" name="page[content][whoweare][status]" class="custom-control-input" id="page-whoweare-section" value="1" <?php if (!empty($result['page_data']['whoweare']['status']) && $result['page_data']['whoweare']['status']) { echo "checked"; }?> >
							<label class="custom-control-label" for="page-whoweare-section">Want to display this section on website?</label>
						</div>
					</div>
					<div class="row">
						<div class="col-lg-6">
							<div class="form-group">
								<label>Section Title</label>
								<input type="text" name="page[content][whoweare][title]" class="form-control" value="<?php echo $result['page_data']['whoweare']['title']; ?>" placeholder="Who We are Section Title">
							</div>
							<?php foreach ($result['page_data']['whoweare']['block'] as $key => $value) { ?>
								<div class="form-group">
									<label>Block <?php echo $key+1; ?>: </label>
									<div class="row">
										<div class="col-sm-4">
											<input type="text" name="page[content][whoweare][block][<?php echo $key; ?>][icon]" value="<?php echo $value['icon']; ?>" class="form-control" placeholder="Icon Name (Ex: user)">
										</div>
										<div class="col-sm-4">
											<input type="text" name="page[content][whoweare][block][<?php echo $key; ?>][title]" value="<?php echo $value['title']; ?>" class="form-control" placeholder="Title (Ex: Doctor)">
										</div>
										<div class="col-sm-4">
											<input type="text" name="page[content][whoweare][block][<?php echo $key; ?>][count]" value="<?php echo $value['count']; ?>" class="form-control" placeholder="Number or Count (Ex: 9)">
										</div>
									</div>
								</div>
							<?php } ?>
						</div>
						<div class="col-lg-6">
							<div class="form-group">
								<label class="d-block">Right Side Image</label>
								<div class="image-upload" <?php if (!empty($result['page_data']['whoweare']['picture'])) { echo " style=\"display: none\" "; } ?> >
									<a>Upload</a>
								</div>
								<div class="saved-picture" <?php if (empty($result['page_data']['whoweare']['picture'])) { echo " style=\"display: none\" "; } ?> >
									<?php if (!empty($result['page_data']['whoweare']['picture'])) { ?>
										<img class="img-thumbnail" src="../public/uploads/<?php echo $result['page_data']['whoweare']['picture']; ?>" alt="">
									<?php } ?>
									<input type="hidden" name="page[content][whoweare][picture]" value="<?php echo $result['page_data']['whoweare']['picture']; ?>">
								</div>
								<div class="saved-picture-delete" data-toggle="tooltip" data-placement="right" title="Remove" <?php if (empty($result['page_data']['whoweare']['picture'])) { echo " style=\"display: none\" "; } ?> >
									<a class="fa fa-times"></a>
								</div>
								<div class="form-text">(Size: 645px x 405px)</div>
							</div>
							<div class="form-group">
								<label>Mission Title : </label>
								<input type="text" name="page[content][whoweare][mission][title]" class="form-control" value="<?php echo $result['page_data']['whoweare']['mission']['title']; ?>" placeholder="Our Mission Title">
							</div>
							<div class="form-group">
								<label>Mission Description</label>
								<textarea name="page[content][whoweare][mission][description]" class="form-control" placeholder="Our Mission Decription"><?php echo $result['page_data']['whoweare']['mission']['description']; ?></textarea>
							</div>
							<div class="form-group">
								<label>Vission Title</label>
								<input type="text" name="page[content][whoweare][vission][title]" class="form-control" value="<?php echo $result['page_data']['whoweare']['vission']['title']; ?>" placeholder="Our Vission Title">
							</div>
							<div class="form-group">
								<label>Vission Description</label>
								<textarea name="page[content][whoweare][vission][description]" class="form-control" placeholder="Our Vission Decription"><?php echo $result['page_data']['whoweare']['vission']['description']; ?></textarea>
							</div>
						</div>
					</div>
				</div>
				<div class="tab-pane" id="page-doctors">
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
								<input type="text" name="page[content][doctor][title]" class="form-group" value="<?php echo $result['page_data']['doctor']['title']; ?>" placeholder="Doctor Section Name">
							</div>
							<div class="form-group">
								<label>Doctor List</label>
								<div class="form-text">Maximum Three doctors will be displayed according to priority.</div>
							</div>
						</div>
					</div>
				</div>
				<div class="tab-pane" id="page-testimonial">
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
								<input type="text" name="page[content][testimonial][title]" class="form-group" value="<?php echo $result['page_data']['testimonial']['title']; ?>" placeholder="Doctor Section Name">
							</div>
							<div class="form-group">
								<label>Testimonial List</label>
								<div class="form-text">All enabled Testimonial will be displayed If you do not want to display then make them disabled..</div>
							</div>
						</div>
					</div>
				</div>
				<div class="tab-pane" id="page-meta">
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
		<input type="hidden" name="page_name" value="about">
		<div class="panel-footer text-center">
			<button type="submit" name="submit" class="btn btn-primary"><i class="ti-save-alt pr-2"></i> Save</button>
		</div>
	</div>
</form>

<!-- include summernote css/js-->
<link href="public/css/summernote-bs4.css" rel="stylesheet">
<script type="text/javascript" src="public/js/summernote-bs4.min.js"></script>
<script>
	$(document).ready(function() {
		"use strict";

		$('.summernote').summernote({
			disableDragAndDrop: true,
			dialogsFade: true,
			height: 600,
			emptyPara: '',
			toolbar: [
			['style', ['style']],
			['font', ['bold', 'underline', 'clear']],
			['fontname', ['fontname']],
			['fontsize', ['fontsize']],
			['color', ['color']],
			['para', ['ul', 'ol', 'paragraph']],,
			['height', ['height']],
			['table', ['table']],
			['insert', ['link', 'image', 'video']],
			['view', ['fullscreen', 'codeview', 'help']]
			],
			buttons: {
				image: function() {
					var imageButton = $.summernote.ui.button({
						contents: '<i class="note-icon-picture" />',
						tooltip: $.summernote.lang[$.summernote.options.lang].image.image,
						click: function () {
							$("#media-upload").modal('show');
						}
					});
					return imageButton.render();
				}
			}
		});

		$('.media-all').on('click', '.media-all-block div img', function(e) {
			e.preventDefault();
			$('.summernote').summernote('insertImage', $(this).attr('src'));
			$('#media-upload').modal('hide');
		});

		var path = $('input[name=absolute-upload-path]').val();
		JSON.parse($('input[name=media_all]').val()).forEach(function (element) { 
			$('#media-upload .media-all').append(
				'<div class="media-all-block">'+
				'<div>'+
				'<a data-toggle="tooltip" data-placement="top" title="Remove">'+
				'<i class="ti-trash"></i>'+
				'</a>'+
				'<img src="'+path.concat(element)+'" title="'+element+'">'+
				'<input type="radio" name="media-select" id="media-'+element+'" value="'+element+'">'+
				'<label for="media-'+element+'" title="'+element+'">'+element+'</label>'+
				'</div></div>');
		});
	});
</script>

<!-- Footer -->
<?php include (DIR_ADMIN.'app/views/common/footer.tpl.php'); ?>