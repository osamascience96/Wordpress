<?php include (DIR_ADMIN.'app/views/common/header.tpl.php'); ?>
<div class="page-title">
	<div class="row align-items-center">
		<div class="col-sm-6">
			<h2 class="page-title-text d-inline-block"><?php echo $page_title; ?></h2>
			<div class="breadcrumbs d-inline-block">
				<ul>
					<li><a href="<?php echo URL_ADMIN; ?>">Dashboard</a></li>
					<li><a href="<?php echo URL_ADMIN.DIR_ROUTE.'noticeboard'; ?>">Noticeboard</a></li>
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
				<label>Title <span class="form-required">*</span></label>
				<div class="input-group">
					<div class="input-group-prepend">
						<span class="input-group-text"><i class="ti-tag"></i></span>
					</div>
					<input type="text" name="notice[title]" class="form-control" value="<?php echo $result['title']; ?>" placeholder="Enter Title . . ." required>
				</div>
			</div>
			<div class="form-group">
				<label>Description</label>
				<div class="input-group">
					<div class="input-group-prepend">
						<span class="input-group-text"><i class="ti-paragraph"></i></span>
					</div>
					<textarea name="notice[description]" class="form-control" placeholder="Enter Description . . ."><?php echo $result['description']; ?></textarea>
				</div>
			</div>
			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<label>Start Date <span class="form-required">*</span></label>
						<div class="input-group">
							<div class="input-group-prepend"><span class="input-group-text"><i class="ti-calendar"></i></span></div>
							<input type="text" name="notice[start_date]" class="form-control date" value="<?php echo date_format(date_create($result['start_date']), $common['info']['date_format']); ?>" placeholder="Enter Start Date . . ." readonly required>
						</div>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label>End Date <span class="form-required">*</span></label>
						<div class="input-group">
							<div class="input-group-prepend"><span class="input-group-text"><i class="ti-calendar"></i></span></div>
							<input type="text" name="notice[end_date]" class="form-control date" value="<?php echo date_format(date_create($result['end_date']), $common['info']['date_format']); ?>" placeholder="Enter End Date . . ." readonly required>
						</div>
					</div>
				</div>
			</div>
			<div class="form-group">
				<label>Status</label>
				<div class="input-group">
					<div class="input-group-prepend">
						<span class="input-group-text"><i class="ti-check-box"></i></span>
					</div>
					<select name="notice[status]" class="custom-select">
						<option value="1" <?php if($result['status'] == '1' || $result['status'] == NULL) { echo "selected";} ?> >Active</option>
						<option value="0" <?php if($result['status'] == '0') { echo "selected";} ?> >Inactive</option>
					</select>
				</div>
			</div>
		</div>
		<input type="hidden" name="notice[id]" value="<?php echo $result['id'];?>">
		<div class="panel-footer text-center">
			<button type="submit" name="submit" class="btn btn-primary"><i class="ti-save-alt pr-2"></i> Save</button>
		</div>
	</div>
</form>


<!-- Footer -->
<?php include (DIR_ADMIN.'app/views/common/footer.tpl.php'); ?>