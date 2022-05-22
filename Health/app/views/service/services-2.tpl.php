<?php echo $header; ?>
<!-- Start Service List Section -->
<div class="layer-stretch animated-wrapper">
	<div class="layer-wrapper layer-bottom-0">
		<div class="row text-center">
			<?php if (!empty($services)) { foreach ($services as $value) { ?>
			<div class="col-sm-6 col-md-4">
				<?php include DIR.'app/views/service/service-card-2.tpl.php'; ?>
			</div>
			<?php } } ?>
		</div>
	</div>
</div><!-- End Service List Section -->
<?php echo $facilities; echo $footer; ?>