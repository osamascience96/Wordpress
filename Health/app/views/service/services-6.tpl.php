<?php echo $header; ?>
<!-- Start Service List Section -->
<div class="layer-stretch animated-wrapper">
	<div class="layer-wrapper layer-bottom-0">
		<div class="row text-center">
			<div class="col-md-4">
				<?php include DIR.'app/views/service/service-sidebar.tpl.php'; ?>
			</div>
			<div class="col-md-8">
				<div class="row">
					<?php if (!empty($services)) { foreach ($services as $value) { ?>
					<div class="col-sm-6">
						<?php include DIR.'app/views/service/service-card-1.tpl.php'; ?>
					</div>
					<?php } } ?>
				</div>
			</div>
		</div>
	</div>
</div><!-- End Service List Section -->
<?php echo $facilities; echo $footer; ?>