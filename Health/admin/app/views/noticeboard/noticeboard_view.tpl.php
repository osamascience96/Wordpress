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
		<div class="col-sm-6 text-right">
			<?php if ($page_edit) { ?>
				<a href="<?php echo URL_ADMIN.DIR_ROUTE.'noticeboard/edit&id='.$result['id'];?>" class="btn btn-sm btn-primary"><i class="ti-pencil-alt mr-2"></i> Edit</a>
			<?php } ?>
		</div>
	</div>
</div>

<div class="panel panel-default">
	<div class="panel-head">
		<div class="panel-title"><?php echo $result['title']; ?></div>
	</div>
	<div class="panel-body">
		<p class="mb-0"><?php echo $result['description']; ?></p>
		
	</div>
	<div class="panel-footer">
		<p class="mb-0">Start : <?php echo date_format(date_create($result['start_date']), $common['info']['date_format']); ?> End : <?php echo date_format(date_create($result['end_date']), $common['info']['date_format']); ?></p>
	</div>
</div>

<!-- Footer -->
<?php include (DIR_ADMIN.'app/views/common/footer.tpl.php'); ?>