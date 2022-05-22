<?php include (DIR_ADMIN.'app/views/common/header.tpl.php'); ?>
<div class="page-title">
	<div class="row align-items-center">
		<div class="col-sm-6">
			<h2 class="page-title-text d-inline-block"><?php echo $page_title; ?></h2>
			<div class="breadcrumbs d-inline-block">
				<ul>
					<li><a href="<?php echo URL_ADMIN; ?>">Dashboard</a></li>
					<li><a href="<?php echo URL_ADMIN.DIR_ROUTE.'category'; ?>">Category</a></li>
					<li><?php echo $page_title; ?></li>
				</ul>
			</div>
		</div>
		<div class="col-sm-6 text-right"></div>
	</div>
</div>
<form action="<?php echo $action; ?>" method="post">
	<input type="hidden" name="_token" value="<?php echo $token; ?>">
	<div class="panel panel-default">
		<div class="panel-body">
			<div class="form-group">
				<label>Name <span class="form-required">*</span></label>
				<div class="input-group">
					<div class="input-group-prepend">
						<span class="input-group-text"><i class="ti-tag"></i></span>
					</div>
					<input type="text" class="form-control" name="category[name]" value="<?php echo $result['name']; ?>" placeholder="Enter Category Name . . .">
				</div>
			</div>
			<div class="form-group">
				<label>Slug <span class="form-required">*</span></label>
				<div class="input-group">
					<div class="input-group-prepend">
						<span class="input-group-text"><i class="ti-tag"></i></span>
					</div>
					<input type="text" class="form-control" value="<?php echo $result['slug']; ?>" name="category[slug]" placeholder="Enter Slug Name . . ." required>
				</div>
			</div>
			<div class="form-group">
				<label>Icon</label>
				<div class="input-group">
					<div class="input-group-prepend">
						<span class="input-group-text"><i class="ti-marker"></i></span>
					</div>
					<input type="text" class="form-control" value="<?php echo $result['icon']; ?>" name="category[icon]" placeholder="Enter Category Icon . . .">
				</div>
			</div>
			<div class="form-group mb-0">
				<label>Parent Category</label>
				<div class="input-group">
					<div class="input-group-prepend">
						<span class="input-group-text"><i class="ti-check-box"></i></span>
					</div>
					<select name="category[parent]" class="custom-select">
						<option value="" disabled selected>Select Parent Category</option>
						<?php if (!empty($categories)) { foreach ($categories as $key => $value) { ?>
							<option value="<?php echo $value['id']; ?>" <?php if($value['id'] == $result['parent']) { echo "selected"; } ?> ><?php echo $value['name']; ?></option>
						<?php } } ?>
					</select>
				</div>
			</div>
		</div>
		<input type="hidden" name="category[id]" value="<?php echo $result['id'];?>">
		<div class="panel-footer text-center">
			<button type="submit" name="submit" class="btn btn-primary"><i class="ti-save-alt pr-2"></i> Save</button>
		</div>
	</div>
</form>

<!-- Footer -->
<?php include (DIR_ADMIN.'app/views/common/footer.tpl.php'); ?>