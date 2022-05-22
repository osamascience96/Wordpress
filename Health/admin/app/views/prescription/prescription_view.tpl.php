<?php include (DIR_ADMIN.'app/views/common/header.tpl.php'); ?>

<div class="page-title">
	<div class="row align-items-center">
		<div class="col-sm-6">
			<h2 class="page-title-text d-inline-block"><?php echo $page_title; ?></h2>
			<div class="breadcrumbs d-inline-block">
				<ul>
					<li><a href="<?php echo URL_ADMIN; ?>">Dashboard</a></li>
					<li><a href="<?php echo URL_ADMIN.DIR_ROUTE.'prescriptions'; ?>">Prescriptions</a></li>
					<li><?php echo $page_title; ?></li>
				</ul>
			</div>
		</div>
		<div class="col-sm-6 text-right">
			<a href="<?php echo URL_ADMIN.DIR_ROUTE.'prescription/pdf&id='.$result['id']; ?>" class="btn btn-danger btn-sm" target="_blank"><i class="far fa-file-pdf mr-2"></i>PDF/Print</a>
			<a href="<?php echo URL_ADMIN.DIR_ROUTE.'prescription/edit&id='.$result['id']; ?>" class="btn btn-primary btn-sm"><i class="ti-pencil-alt mr-2"></i>Edit</a>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-4">
		<div class="panel panel-default">
			<div class="panel-body">
				<div class="user-avtar">
					<span><?php echo $result['name'][0]; ?></span>
				</div>
				<div class="user-details text-center pt-3">
					<h3><?php echo $result['name']; ?></h3>
					<p><?php echo $result['email']; ?></p>
					<table class="table table-striped">
						<tbody>
							<tr>
								<td>Doctor</td>
								<td><?php echo 'Dr. '.$result['doctor']; ?></td>
							</tr>
							<tr>
								<td>Created Date</td>
								<td><?php echo date_format(date_create($result['date_of_joining']), $common['info']['date_format']); ?></td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
	<div class="col-md-8">
		<div class="panel panel-default">
			<div class="panel-body">
				<div class="table-responsive">
					<table class="table table-striped">
						<tr>
							<th>Medicine Name</th>
							<th>Dose</th>
							<th>Duration</th>
							<th>Instruction</th>
						</tr>
						<?php foreach ($result['prescription'] as $s_key => $s_value) { ?>
							<tr>
								<td>
									<p class="text-primary m-0"><?php echo html_entity_decode($s_value['name'], ENT_QUOTES, 'UTF-8'); ?></p>
									<p class="m-0"><?php echo html_entity_decode($s_value['generic'], ENT_QUOTES, 'UTF-8'); ?></p>
								</td>
								<td class="text-center"><p class="font-12"><?php echo $s_value['dose']; ?></p></td>
								<td class="text-center"><p class="font-12"><?php echo $s_value['duration'].' Day'; ?></p></td>
								<td class="text-center"><p class="font-12"><?php echo $s_value['instruction']; ?></p></td>
							</tr>
						<?php } ?>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- Footer -->
<?php include (DIR_ADMIN.'app/views/common/footer.tpl.php'); ?>