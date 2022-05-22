<?php echo $header; ?>
<!-- Start Doctor List Section -->
<div class="layer-stretch animated-wrapper">
	<div class="layer-wrapper layer-bottom-0">
		<div class="row text-center">
			<div class="col-md-4">
				<?php include DIR.'app/views/doctor/doctor-sidebar.tpl.php'; ?>
			</div>
			<div class="col-md-8">
				<div class="row">
					<?php if (!empty($doctors)) { foreach ($doctors as $value) {
				$value['about'] = json_decode($value['about'], true);
				$value['social'] = json_decode($value['social'], true);
				?>
					<div class="col-sm-6">
						<?php include DIR.'app/views/doctor/doctor-card-1.tpl.php'; ?>
					</div>
					<?php } } ?>
				</div>
			</div>
		</div>
	</div>
</div><!-- End Doctor List Section -->

<?php echo $departments. $footer; ?>