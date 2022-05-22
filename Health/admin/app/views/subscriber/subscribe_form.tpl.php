<?php include (DIR_ADMIN.'app/views/common/header.tpl.php'); ?>

<div class="page-title">
	<div class="row align-items-center">
		<div class="col-sm-6">
			<h2 class="page-title-text d-inline-block"><?php echo $page_title; ?></h2>
			<div class="breadcrumbs d-inline-block">
				<ul>
					<li><a href="<?php echo URL_ADMIN; ?>">Dashboard</a></li>
					<li><a href="<?php echo URL_ADMIN.DIR_ROUTE.'subscribers'; ?>">Subscribers</a></li>
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
				<label>Email Address <span class="form-required">*</span></label>
				<div class="input-group">
					<div class="input-group-prepend">
						<span class="input-group-text"><i class="ti-email"></i></span>
					</div>
					<input type="text" name="subscriber[mail]" class="form-control" value="<?php echo $result['email']; ?>" placeholder="Enter Subscribers Email Address . . .">
				</div>
			</div>
			<?php if (!empty($result['id'])) { ?>
				<div class="form-group">
					<label>Status</label>
					<div class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text"><i class="ti-check-box"></i></span>
						</div>
						<select name="subscriber[status]" class="custom-select">
							<option value="1" <?php if($result['status'] == '1') { echo "selected";} ?> >Enabled</option>
							<option value="0" <?php if($result['status'] == '0') { echo "selected";} ?> >Disabled</option>
						</select>
					</div>
				</div>
			<?php } ?>
		</div>
		<input type="hidden" name="subscriber[id]" value="<?php echo $result['id'];?>">
		<div class="panel-footer text-center">
			<button type="submit" name="submit" class="btn btn-primary"><i class="ti-save-alt pr-2"></i> Save</button>
		</div>
	</div>
</form>


<!-- Footer -->
<?php include (DIR_ADMIN.'app/views/common/footer.tpl.php'); ?>