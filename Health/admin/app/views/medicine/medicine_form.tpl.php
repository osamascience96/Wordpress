<?php include (DIR_ADMIN.'app/views/common/header.tpl.php'); ?>
<div class="page-title">
	<div class="row align-items-center">
		<div class="col-sm-6">
			<h2 class="page-title-text d-inline-block"><?php echo $page_title; ?></h2>
			<div class="breadcrumbs d-inline-block">
				<ul>
					<li><a href="<?php echo URL_ADMIN; ?>">Dashboard</a></li>
					<li><a href="<?php echo URL_ADMIN.DIR_ROUTE.'medicines'; ?>">Medicine</a></li>
					<li><?php echo $page_title; ?></li>
				</ul>
			</div>
		</div>
		<div class="col-sm-6 text-right"></div>
	</div>
</div>

<form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data">
	<input type="hidden" name="_token" value="<?php echo $common['token']; ?>">
	<div class="panel panel-default">
		<div class="panel-body">
			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<label>Medicine Name <span class="form-required">*</span></label>
						<div class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text"><i class="ti-tag"></i></span>
							</div>
							<input type="text" name="medicine[name]" class="form-control" value="<?php echo $result['name']; ?>" placeholder="Enter Medicine Name . . .">
						</div>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label>Medicine Category <span class="form-required">*</span></label>
						<div class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text"><i class="ti-tag"></i></span>
							</div>
							<select name="medicine[category]" class="custom-select">
								<?php if (!empty($category)) { foreach ($category as $key => $value) { ?>
									<option value="<?php echo $value['id'] ?>" <?php if ($result['category'] == $value['id']) { echo "selected"; } ?> ><?php echo $value['name']; ?></option>
								<?php } } ?>
							</select>
						</div>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label>Medicine Company <span class="form-required">*</span></label>
						<div class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text"><i class="ti-tag"></i></span>
							</div>
							<input type="text" name="medicine[company]" class="form-control" value="<?php echo $result['company']; ?>" placeholder="Enter Medicine Company . . .">
						</div>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label>Medicine Generic <span class="form-required">*</span></label>
						<div class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text"><i class="ti-tag"></i></span>
							</div>
							<input type="text" name="medicine[generic]" class="form-control" value="<?php echo $result['generic']; ?>" placeholder="Enter Medicine Generic . . .">
						</div>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label>Medicine Group</label>
						<div class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text"><i class="ti-tag"></i></span>
							</div>
							<input type="text" name="medicine[medicine_group]" class="form-control" value="<?php echo $result['medicine_group']; ?>" placeholder="Enter Medicine Group . . .">
						</div>
					</div>
				</div>
				<div class="col-md-6">
					<div class="row">
						<div class="col-sm-6">
							<div class="form-group">
								<label>Unit<span class="form-required">*</span></label>
								<div class="input-group">
									<div class="input-group-prepend">
										<span class="input-group-text"><i class="ti-tag"></i></span>
									</div>
									<input type="text" name="medicine[unit]" class="form-control" value="<?php echo $result['unit']; ?>" placeholder="Enter Medicine unit . . .">
								</div>
							</div>
						</div>
						<div class="col-sm-6">
							<div class="form-group">
								<label>Unit/Packing</label>
								<div class="input-group">
									<div class="input-group-prepend">
										<span class="input-group-text"><i class="ti-tag"></i></span>
									</div>
									<input type="text" name="medicine[unitpacking]" class="form-control" value="<?php echo $result['unitpacking']; ?>" placeholder="Enter Unit/Packing . . .">
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label>Store Box</label>
						<div class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text"><i class="ti-tag"></i></span>
							</div>
							<input type="text" name="medicine[storebox]" class="form-control" value="<?php echo $result['storebox']; ?>" placeholder="Enter Store Box or Drawer . . .">
						</div>
					</div>
				</div>
				<div class="col-md-6">
					<div class="row">
						<div class="col-sm-6">
							<div class="form-group">
								<label>Min Level</label>
								<div class="input-group">
									<div class="input-group-prepend">
										<span class="input-group-text"><i class="ti-tag"></i></span>
									</div>
									<input type="text" name="medicine[minlevel]" class="form-control" value="<?php echo $result['minlevel']; ?>" placeholder="Enter Min Level . . .">
								</div>
							</div>
						</div>
						<div class="col-sm-6">
							<div class="form-group">
								<label>Re-Order Level</label>
								<div class="input-group">
									<div class="input-group-prepend">
										<span class="input-group-text"><i class="ti-tag"></i></span>
									</div>
									<input type="text" name="medicine[reorderlevel]" class="form-control" value="<?php echo $result['reorderlevel']; ?>" placeholder="Enter Re-Order Level . . .">
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label>Note</label>
						<div class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text"><i class="ti-tag"></i></span>
							</div>
							<textarea name="medicine[note]" class="form-control" placeholder="Enter Re-Order Level . . ."><?php echo $result['note']; ?></textarea>
						</div>
					</div>
				</div>
			</div>
		</div>
		<input type="hidden" name="medicine[id]" value="<?php echo $result['id'];?>">
		<div class="panel-footer text-center">
			<button type="submit" name="submit" class="btn btn-primary"><i class="ti-save-alt pr-2"></i> Save</button>
		</div>
	</div>
</form>
<!-- Footer -->
<?php include (DIR_ADMIN.'app/views/common/footer.tpl.php'); ?>