<?php include (DIR_ADMIN.'app/views/common/header.tpl.php'); ?>
<div class="page-title">
	<div class="row align-items-center">
		<div class="col-sm-6">
			<h2 class="page-title-text d-inline-block"><?php echo $page_title; ?></h2>
			<div class="breadcrumbs d-inline-block">
				<ul>
					<li><a href="<?php echo URL_ADMIN; ?>">Dashboard</a></li>
					<li><a href="<?php echo URL_ADMIN.DIR_ROUTE.'pages'; ?>">Pages</a></li>
					<li><?php echo $page_title; ?></li>
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
			<ul class="nav nav-tabs nav-tabs-line nav-tabs-line-primary">
				<li class="nav-item">
					<a class="nav-link active" href="#page-section" data-toggle="tab">Page</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="#meta" data-toggle="tab">Meta/Seo</a>
				</li>
			</ul>
			<div class="tab-content pt-4">
				<div class="tab-pane active" id="page-section">
					<div class="form-group">
						<label>Page Title</label>
						<input type="text" name="page[title]" class="form-control" value="<?php echo $result['page_title']; ?>" placeholder="Enter Page Title . . ." required>
					</div>
					<div class="form-group">
						<label>Page Content</label>
						<textarea class="summernote" name="page[content]" class="form-control" placeholder="Enter Page Content . . ." required><?php echo $result['page_data']; ?></textarea>
					</div>
				</div>
				<div class="tab-pane" id="meta">
					<div class="row">
						<div class="col-lg-6">
							<div class="form-group">
								<label>Meta Tag</label>
								<input type="text" class="form-control" name="page[meta][tag]" value="<?php echo $result['meta_tag']; ?>" placeholder="Enter Meta Tag Title . . ." required>
							</div>
							<div class="form-group">
								<label>Meta Description</label>
								<textarea name="page[meta][description]" class="form-control" placeholder="Enter Meta Tag Description . . ."><?php echo $result['meta_description']; ?></textarea>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<input type="hidden" name="page[name]" value="<?php echo $result['page_name']; ?>">
		<input type="hidden" name="page[id]" value="<?php echo $result['id']; ?>">
		<div class="panel-footer text-center">
			<button type="submit" name="submit" class="btn btn-primary"><i class="ti-save-alt pr-2"></i> Save</button>
		</div>
	</div>
</form>

<!-- include summernote css/js-->
<link href="public/css/summernote-bs4.css" rel="stylesheet">
<script type="text/javascript" src="public/js/summernote-bs4.min.js"></script>
<script type="text/javascript" src="public/js/klinikal.summernote.js"></script>
<!-- Footer -->
<?php include (DIR_ADMIN.'app/views/common/footer.tpl.php'); ?>