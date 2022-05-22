<?php include (DIR_ADMIN.'app/views/common/header.tpl.php'); ?>

<div class="page-title">
	<div class="row align-items-center">
		<div class="col-sm-6">
			<h2 class="page-title-text d-inline-block"><?php echo $page_title; ?></h2>
			<div class="breadcrumbs d-inline-block">
				<ul>
					<li><a href="<?php echo URL_ADMIN; ?>">Dashboard</a></li>
					<li><a href="<?php echo URL_ADMIN.DIR_ROUTE.'departments'; ?>">Departments</a></li>
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
					<input type="text" name="department[name]" class="form-control" value="<?php echo $result['name']; ?>" placeholder="Enter Department Name . . ." required>
				</div>
			</div>
			<div class="form-group">
				<label>Description</label>
				<div class="input-group">
					<div class="input-group-prepend">
						<span class="input-group-text"><i class="ti-paragraph"></i></span>
					</div>
					<textarea name="department[description]" class="form-control" placeholder="Enter Department Description . . ."><?php echo $result['description']; ?></textarea>
				</div>
			</div>
			<div class="form-group">
				<label>Icon</label>
				<div class="input-group">
					<div class="input-group-prepend">
						<span class="input-group-text"><i class="ti-marker"></i></span>
					</div>
					<input type="text" name="department[icon]" class="form-control" value="<?php echo $result['icon']; ?>" placeholder="Enter Department Name . . .">
				</div>
				<span class="form-text">Get icon name icon page (ex : far fa-user-md)</span>
			</div>
			<div class="form-group">
				<label>Status</label>
				<div class="input-group">
					<div class="input-group-prepend">
						<span class="input-group-text"><i class="ti-check-box"></i></span>
					</div>
					<select name="department[status]" class="custom-select">
						<option value="1" <?php if($result['status'] == '1' || $result['status'] == NULL) { echo "selected";} ?> >Enabled</option>
						<option value="0" <?php if($result['status'] == '0') { echo "selected";} ?> >Disabled</option>
					</select>
				</div>
			</div>
		</div>
		<input type="hidden" name="department[id]" value="<?php echo $result['id'];?>">
		<div class="panel-footer text-center">
			<button type="submit" name="submit" class="btn btn-primary"><i class="ti-save-alt pr-2"></i> Save</button>
		</div>
	</div>
</form>


<!-- Footer -->
<?php include (DIR_ADMIN.'app/views/common/footer.tpl.php'); ?>