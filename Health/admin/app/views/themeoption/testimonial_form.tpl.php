<?php include (DIR_ADMIN.'app/views/common/header.tpl.php'); ?>
<div class="page-title">
	<div class="row align-items-center">
		<div class="col-sm-6">
			<h2 class="page-title-text d-inline-block"><?php echo $page_title; ?></h2>
			<div class="breadcrumbs d-inline-block">
				<ul>
					<li><a href="<?php echo URL_ADMIN; ?>">Dashboard</a></li>
					<li><a href="<?php echo URL_ADMIN.DIR_ROUTE.'testimonials'; ?>">Testimonials</a></li>
					<li><?php echo $page_title; ?></li>
				</ul>
			</div>
		</div>
		<div class="col-sm-6 text-right"></div>
	</div>
</div>

<form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data">
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
							<input type="text" name="testimonial[name]" class="form-control" value="<?php echo $result['name']; ?>" placeholder="Enter Department Name . . ." required>
						</div>
					</div>
					<div class="form-group">
						<label>Email Address</label>
						<div class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text"><i class="ti-email"></i></span>
							</div>
							<input name="testimonial[email]" class="form-control" value="<?php echo $result['email']; ?>" placeholder="Enter Email Address . . .">
						</div>
					</div>
					<div class="form-group">
						<label>Mobile Number</label>
						<div class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text"><i class="ti-mobile"></i></span>
							</div>
							<input type="text" name="testimonial[mobile]" class="form-control" value="<?php echo $result['mobile']; ?>" placeholder="Enter Mobile Number . . .">
						</div>
					</div>
					<div class="form-group">
						<label>Status</label>
						<div class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text"><i class="ti-check-box"></i></span>
							</div>
							<select name="testimonial[status]" class="custom-select">
								<option value="1" <?php if($result['status'] == '1' || $result['status'] == NULL) { echo "selected";} ?> >Enabled</option>
								<option value="0" <?php if($result['status'] == '0') { echo "selected";} ?> >Disabled</option>
							</select>
						</div>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label class="d-block">Picture</label>
						<div class="image-upload" <?php if (!empty($result['picture'])) { echo " style=\"display: none\" "; }?> >
							<a>Upload</a>
						</div>
						<div class="saved-picture" <?php if (empty($result['picture'])) { echo " style=\"display: none\" "; } ?> >
							<?php if (!empty($result['picture'])) { ?>
								<img class="img-thumbnail" src="../public/uploads/<?php echo $result['picture']; ?>" alt="">
							<?php } ?>
							<input type="hidden" name="testimonial[picture]" value="<?php echo $result['picture']; ?>">
						</div>
						<div class="saved-picture-delete" data-toggle="tooltip" data-placement="right" title="Remove" <?php if (empty($result['picture'])) { echo " style=\"display: none\" "; } ?> >
							<a class="ti-trash"></a>
						</div>
						<div class="form-text">(Size: 200px * 200px)</div>
					</div>
					<div class="form-group">
						<label>Description</label>
						<div class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text"><i class="ti-paragraph"></i></span>
							</div>
							<textarea name="testimonial[testimonial]" class="form-control" placeholder="Enter Testimonial . . ."><?php echo $result['testimonial']; ?></textarea>
						</div>
					</div>
				</div>
			</div>
		</div>
		<input type="hidden" name="testimonial[id]" value="<?php echo $result['id'];?>">
		<div class="panel-footer text-center">
			<button type="submit" name="submit" class="btn btn-primary"><i class="ti-save-alt pr-2"></i> Save</button>
		</div>
	</div>
</form>
<!-- Footer -->
<?php include (DIR_ADMIN.'app/views/common/footer.tpl.php'); ?>