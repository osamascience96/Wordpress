<?php include (DIR_ADMIN.'app/views/common/header.tpl.php'); ?>
<script>$('#setting').show();</script>
<div class="page-hdr">
	<div class="row">
		<div class="col-8 page-name">
			<h1><i class="fa fa-exclamation-triangle"></i>Error Log</h1>
		</div>
		<div class="col-4 page-menu">
			<a id="cancel" href="<?php echo URL_ADMIN.DIR_ROUTE; ?>errorlog" data-toggle="tooltip" data-placement="left" title="Reload"><i class="fa fa-refresh"></i></a>
		</div>
	</div>
</div>
<div class="content">
	<div class="content-block">
		<div class="content-block-ttl">Error Log</div>
		<div class="content-block-main">
			<div class="padding-10">
				<p class="font-12">
					<?php 
					$file = fopen("error.log","r");

					while(! feof($file))
					{
						echo fgets($file). "<br />";
					}

					fclose($file); ?>
				</p>
			</div>
		</div>
	</div>
</div>

<!-- Footer -->
<?php include (DIR_ADMIN.'app/views/common/footer.tpl.php'); ?>