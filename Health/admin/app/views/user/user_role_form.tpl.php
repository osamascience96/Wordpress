<?php include (DIR_ADMIN.'app/views/common/header.tpl.php'); ?>
<div class="page-title">
	<div class="row align-items-center">
		<div class="col-sm-6">
			<h2 class="page-title-text d-inline-block"><?php echo $page_title; ?></h2>
			<div class="breadcrumbs d-inline-block">
				<ul>
					<li><a href="<?php echo URL_ADMIN; ?>">Dashboard</a></li>
					<li><a href="<?php echo URL_ADMIN.DIR_ROUTE.'role'; ?>">User Roles</a></li>
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
			<input type="hidden" name="id" value="<?php echo $result['id']; ?>">
			<div class="form-group">
				<label class="col-form-label">User Role Name</label>
				<div class="input-group">
					<div class="input-group-prepend">
						<span class="input-group-text"><i class="ti-tag"></i></span>
					</div>
					<input type="text" name="name" class="form-control" value="<?php echo $result['name']; ?>" placeholder="Enter User Role Name . . .">
				</div>
			</div>
			<div class="form-group">
				<label class="col-form-label">Description</label>
				<div class="input-group">
					<div class="input-group-prepend">
						<span class="input-group-text"><i class="ti-paragraph"></i></span>
					</div>
					<textarea name="description" class="form-control" rows="3"><?php echo $result['description']; ?></textarea>
				</div>
			</div>
			<div class="mb-2">
				<label class="col-form-label">Permission</label>
				<table class="table table-bordered table-striped userrole-table table-middle">
					<tbody>
						<?php foreach ($role as $key => $value) { ?>
							<tr>
								<td><?php echo $key; ?></td>
								<?php foreach ($value as $sub_key => $sub_value) { ?>
									<td>
										<?php if (!empty($sub_value)) { ?>
											<div class="custom-control custom-checkbox">
												<input type="checkbox" class="custom-control-input" name="role[]" id="<?php echo $sub_key; ?>" value="<?php echo $sub_key; ?>" <?php if($role_selected) { foreach ($role_selected as $key => $value) { if ($value == $sub_key) { echo "checked"; } } } ?> >
												<label class="custom-control-label" for="<?php echo $sub_key; ?>"><?php echo $sub_value; ?></label>
											</div>
										<?php } ?>
									</td>
								<?php } ?>
							</tr> 
						<?php } ?>
					</tbody>
				</table>
			</div>
		</div>
		<div class="panel-footer text-center">
			<button type="submit" name="submit" class="btn btn-primary"><i class="ti-save-alt pr-2"></i> Save</button>
		</div>
	</div>
</form>


<!-- Footer -->
<?php include (DIR_ADMIN.'app/views/common/footer.tpl.php'); ?>