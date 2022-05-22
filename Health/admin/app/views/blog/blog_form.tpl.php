<?php include (DIR_ADMIN.'app/views/common/header.tpl.php'); ?>
<div class="page-title">
	<div class="row align-items-center">
		<div class="col-sm-6">
			<h2 class="page-title-text d-inline-block"><?php echo $page_title; ?></h2>
			<div class="breadcrumbs d-inline-block">
				<ul>
					<li><a href="<?php echo URL_ADMIN; ?>">Dashboard</a></li>
					<li><a href="<?php echo URL_ADMIN.DIR_ROUTE.'blogs'; ?>">Blogs</a></li>
					<li><?php echo $page_title; ?></li>
				</ul>
			</div>
		</div>
		<div class="col-sm-6 text-right"></div>
	</div>
</div>
<form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data">
	<input type="hidden" name="_token" value="<?php echo $token; ?>">
	<input type="hidden" name="blog[id]" value="<?php echo $result['id'];?>">
	<div class="row">
		<div class="col-lg-8">
			<div class="panel panel-default">
				<div class="panel-body">
					<div class="form-group">
						<label>Name <span class="form-required">*</span></label>
						<div class="input-group">
							<div class="input-group-prepend"><span class="input-group-text"><i class="ti-tag"></i></span></div>
							<input type="text" name="blog[title]" class="form-control" value="<?php echo $result['title']; ?>" placeholder="Enter Blog Name . . ." required>
						</div>
					</div>
					<div class="form-group">
						<label class="d-block">Picture</label>
						<div class="image-upload" <?php if (!empty($result['picture'])) { echo " style=\"display: none\" "; }?> >
							<a>Upload</a>
						</div>
						<div class="saved-picture" <?php if (empty($result['picture'])) { echo " style=\"display: none\" "; } ?> >
							<?php if (!empty($result['picture'])) { ?>
								<img class="img-thumbnail" src="../public/uploads/<?php echo $result['picture']; ?>" alt="">
							<?php } ?>
							<input type="hidden" name="blog[picture]" value="<?php echo $result['picture']; ?>">
						</div>
						<div class="saved-picture-delete" data-toggle="tooltip" data-placement="right" title="Remove" <?php if (empty($result['picture'])) { echo " style=\"display: none\" "; } ?> >
							<a class="ti-trash"></a>
						</div>
						<div class="content-description">(Size: 530px * 470px)</div>
					</div>
					<div class="form-group">
						<label>Short Description <span class="form-required">*</span></label>
						<div class="input-group">
							<div class="input-group-prepend"><span class="input-group-text"><i class="ti-paragraph"></i></span></div>
							<textarea class="form-control" name="blog[short_post]" required><?php echo $result['short_post']; ?></textarea>
						</div>
					</div>
					<div class="form-group">
						<label>Full Post <span class="form-required">*</span></label>
						<textarea name="blog[long_post]" class="summernote" required><?php echo $result['long_post']; ?></textarea>
					</div>
				</div>
			</div>
		</div>
		<div class="col-lg-4">
			<div class="panel panel-default">
				<div class="panel-head">
					<div class="panel-title">
						<span class="panel-title-text">Blogger Info</span>
					</div>
				</div>
				<div class="panel-body">
					<div class="form-group">
						<label>Author Name <span class="form-required">*</span></label>
						<div class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text"><i class="ti-user"></i></span>
							</div>
							<input type="text" name="blog[author]" class="form-control" value="<?php echo $result['author']; ?>" placeholder="Enter Author Name . . ." required>
						</div>
					</div>
					<div class="form-group">
						<label>Status</label>
						<div class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text"><i class="ti-check-box"></i></span>
							</div>
							<select name="blog[status]" class="custom-select" required>
								<option value="0" <?php if($result['status'] == '0') { echo "selected";} ?> >Save as Draft</option>
								<option value="1" <?php if($result['status'] == '1') { echo "selected";} ?> >Publish</option>
							</select>
						</div>
					</div>
					<?php if (!empty($result['id'])) { ?>
						<div class="form-group">
							<label>Created By</label>
							<div class="input-group">
								<div class="input-group-prepend">
									<span class="input-group-text"><i class="ti-user"></i></span>
								</div>
								<input type="text" class="form-control" value="<?php echo $result['name']; ?>" readonly>
							</div>
						</div>
						<div class="form-group">
							<label>Created Date</label>
							<div class="input-group">
								<div class="input-group-prepend">
									<span class="input-group-text"><i class="ti-calendar"></i></span>
								</div>
								<input type="text" class="form-control" value="<?php echo date_format(date_create($result['date_of_joining']), $common['info']['date_format']); ?>" readonly>
							</div>
						</div>
					<?php } ?>
				</div>
			</div>
			<div class="panel panel-default">
				<div class="panel-head">
					<div class="panel-title">
						<span class="panel-title-text">Category</span>
					</div>
				</div>
				<div class="panel-body">
					<?php echo $categories; ?>
				</div>
			</div>
		</div>
	</div>
	<div class="panel panel-default">
		<div class="panel-footer text-center">
			<button type="submit" name="submit" class="btn btn-primary"><i class="ti-save-alt pr-2"></i> Save</button>
		</div>
	</div>
</form>
<div class="panel panel-default">
	<div class="panel-head">
		<div class="panel-title">
			<div class="panel-title-text">Comments</div>
		</div>
	</div>
	<div class="panel-wrapper">
		<div class="panel-body">
			<ul class="comment-list">
				<?php if (!empty($comments)) { foreach ($comments as $key => $value) { ?>
					<li>
						<div class="comment-detail text-left">
							<div class="comment-meta">
								<span><?php echo $value['author']; ?></span>
								<span><?php echo date_format(date_create($value['date_of_joining']), $common['info']['date_format']); ?></span>
							</div>
							<div class="comment-post"><?php echo $value['content']; ?> </div>
							<?php if ($comment_edit) { ?>
								<ul class="comment-action">
									<li><a href="<?php echo URL_ADMIN.DIR_ROUTE.'comment/edit&id='.$value['id'];?>" class="text-primary"><i class="ti-layout-media-center-alt pr-2"></i>View</a></li>
									<li><a href="<?php echo URL_ADMIN.DIR_ROUTE.'comment/edit&id='.$value['id'];?>" class="text-primary"><i class="ti-pencil-alt pr-2"></i>Edit</a></li>
								</ul>
							<?php } ?>
						</div>
					</li>
				<?php } } else { ?>
					<li>
						<div class="comment-detail text-left text-danger">No Comments found</div>
					</li>
				<?php } ?>
			</ul>
		</div>
	</div>
</div>
<!-- include summernote css/js-->
<link href="public/css/summernote-bs4.css" rel="stylesheet">
<script type="text/javascript" src="public/js/summernote-bs4.min.js"></script>
<script type="text/javascript" src="public/js/klinikal.summernote.js"></script>

<!-- Footer -->
<?php include (DIR_ADMIN.'app/views/common/footer.tpl.php'); ?>