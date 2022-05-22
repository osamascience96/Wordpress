<?php include (DIR_ADMIN.'app/views/common/header.tpl.php'); ?>
<div class="page-title">
	<div class="row align-items-center">
		<div class="col-sm-6">
			<h2 class="page-title-text d-inline-block"><?php echo $page_title; ?></h2>
			<div class="breadcrumbs d-inline-block">
				<ul>
					<li><a href="<?php echo URL_ADMIN; ?>">Dashboard</a></li>
					<li><a href="<?php echo URL_ADMIN.DIR_ROUTE.'services'; ?>">Services</a></li>
					<li><?php echo $page_title; ?></li>
				</ul>
			</div>
		</div>
		<div class="col-sm-6 text-right"></div>
	</div>
</div>

<form action="<?php echo $action ?>" method="post" enctype="multipart/form-data">
	<input type="hidden" name="_token" value="<?php echo $token; ?>">
	<div class="panel panel-default">
		<div class="panel-body">
			<div class="form-group">
				<label>Name <span class="form-required">*</span></label>
				<div class="input-group">
					<div class="input-group-prepend">
						<span class="input-group-text"><i class="ti-tag"></i></span>
					</div>
					<input type="text" name="service[name]" class="form-control" value="<?php echo $result['name']; ?>" placeholder="Enter Services Name . . .">
				</div>
			</div>
			<div id="picture_container" class="form-group">
				<label class="d-block">Picture</label>
				<div class="image-upload" <?php if (!empty($result['picture'])) { echo " style=\"display: none\" "; }?> >
					<a>Upload</a>
				</div>
				<div class="saved-picture" <?php if (empty($result['picture'])) { echo " style=\"display: none\" "; } ?> >
					<?php if (!empty($result['picture'])) { ?>
						<img class="img-thumbnail" src="../public/uploads/<?php echo $result['picture']; ?>" alt="">
					<?php } ?>
					<input type="hidden" name="service[picture]" value="<?php echo $result['picture']; ?>">
				</div>
				<div class="saved-picture-delete" data-toggle="tooltip" data-placement="right" title="Remove" <?php if (empty($result['picture'])) { echo " style=\"display: none\" "; } ?> >
					<a class="ti-trash"></a>
				</div>
				<div class="form-text">(Size: 530px * 470px)</div>
			</div>
			<div class="form-group">
				<label>Short Description</label>
				<div class="input-group">
					<div class="input-group-prepend">
						<span class="input-group-text"><i class="ti-paragraph"></i></span>
					</div>
					<textarea name="service[short_post]" class="form-control" placeholder="Enter Services Description . . ."><?php echo $result['short_post']; ?></textarea>
				</div>
			</div>
			<div class="form-group">
				<label>Full Description</label>
				<textarea name="service[long_post]" class="form-control summernote" placeholder="Enter Services Description . . ."><?php echo $result['long_post']; ?></textarea>
			</div>
			<div class="form-group">
				<label>Icon</label>
				<div class="input-group">
					<div class="input-group-prepend">
						<span class="input-group-text"><i class="ti-marker"></i></span>
					</div>
					<input type="text" name="service[icon]" class="form-control" value="<?php echo $result['icon']; ?>" placeholder="Enter Services Icon . . .">
				</div>
				<span class="form-text">Get icon name icon page (ex : far fa-user-md)</span>
			</div>
			<div class="form-group">
				<label>Status</label>
				<div class="input-group">
					<div class="input-group-prepend">
						<span class="input-group-text"><i class="ti-check-box"></i></span>
					</div>
					<select name="service[status]" class="custom-select">
						<option value="1" <?php if($result['status'] == '1' || $result['status'] == NULL) { echo "selected";} ?> >Enabled</option>
						<option value="0" <?php if($result['status'] == '0') { echo "selected";} ?> >Disabled</option>
					</select>
				</div>
			</div>
			<div class="form-group">
				<label>Priority</label>
				<div class="input-group">
					<div class="input-group-prepend">
						<span class="input-group-text"><i class="ti-shortcode"></i></span>
					</div>
					<input type="text" name="service[priority]" class="form-control" value="<?php echo $result['priority']; ?>" placeholder="Enter Priority . . .">
				</div>
			</div>
		</div>
		<input type="hidden" name="service[id]" value="<?php echo $result['id'];?>">
		<div class="panel-footer text-center">
			<button type="submit" name="submit" class="btn btn-primary"><i class="ti-save-alt pr-2"></i> Save</button>
		</div>
	</div>
</form>

<div class="content d-none">
	<div class="content-block">
		<div class="content-block-ttl">Service details</div>
		<div class="content-block-main">
			<input type="hidden" name="_token" value="<?php echo $token; ?>">
			<div class="content-input">
				<label><text>*</text>Name : </label>
				<input type="text" class="input-text" value="<?php echo $result['name'];?>" name="name" placeholder="Enter Service Name" required>
				<p class="content-input-error-name">Please enter service name!</p>
			</div>
			<div id="picture_container" class="content-input">
				<label>Picture :</label>
				<div class="image-upload" <?php if (!empty($result['picture'])) { echo " style=\"display: none\" "; }?> >
					<a>Upload</a>
				</div>
				<div class="saved-picture" <?php if (empty($result['picture'])) { echo " style=\"display: none\" "; } ?> >
					<?php if (!empty($result['picture'])) { ?>
						<img class="img-thumbnail" src="../public/uploads/<?php echo $result['picture']; ?>" alt="">
					<?php } ?>
					<input type="hidden" name="picture" value="<?php echo $result['picture']; ?>">
				</div>
				<div class="saved-picture-delete" data-toggle="tooltip" data-placement="right" title="Remove" <?php if (empty($result['picture'])) { echo " style=\"display: none\" "; } ?> >
					<a class="fa fa-times"></a>
				</div>
				<div class="content-description">(Size: 530px * 470px)</div>
			</div>
			<div class="content-input">
				<label><text>*</text>Short Description : </label>
				<textarea name="short_post" placeholder="Enter Breif Description" required><?php echo $result['short_post'];?></textarea>
				<p class="content-input-error-name">Please enter service description!</p>
			</div>
			<div class="content-input">
				<label><text>*</text>Full Description : </label>
				<textarea class="summernote" name="long_post" placeholder="Enter Full Description" required><?php echo $result['long_post'];?></textarea>
				<p class="content-input-error-name">Please enter service description!</p>
			</div>
			<div class="content-input">
				<label><text>*</text>Icon :</label>
				<input type="text" class="input-text" value="<?php echo $result['icon'];?>" name="icon" placeholder="Enter Icon Name (Ex. - fa-user)" required>
				<p class="content-input-error-name">Please enter icon name!</p>
				<div class="content-description">Get icon name form font-awesome site (ex : user-md)</div>
			</div>
			<div class="content-input">
				<label>Status : </label>
				<select name="status" id="" class="select-list">
					<option value="0" <?php if($result['status'] == '0') { echo "selected";} ?> >Disabled</option>
					<option value="1" <?php if($result['status'] == '1') { echo "selected";} ?> >Enabled</option>
				</select>
			</div>
			<div class="content-input">
				<label><text>*</text>Priority : </label>
				<input type="number" class="input-number" value="<?php echo $result['priority'];?>" name="priority" placeholder="Enter Priority">
			</div>
		</div>
	</div>
	<input type="hidden" name="id" value="<?php echo $result['id'];?>">
	<div class="content-submit text-center">
		<button type="submit" name="submit" class="btn btn-primary">Save</button>
	</div>
</div>


<!-- include summernote css/js-->
<link href="public/css/summernote-bs4.css" rel="stylesheet">
<script type="text/javascript" src="public/js/summernote-bs4.min.js"></script>
<script type="text/javascript" src="public/js/klinikal.summernote.js"></script>

<!-- Footer -->
<?php include (DIR_ADMIN.'app/views/common/footer.tpl.php'); ?>