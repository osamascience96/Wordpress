<?php echo $header; ?>
<!-- Start Service List Section -->
<div class="layer-stretch animated-wrapper">
	<div class="layer-wrapper text-center">
		<div class="theme-accordion-container">
			<?php if (!empty($services)) { foreach ($services as $value) { include DIR.'app/views/service/service-card-3.tpl.php'; } } ?>
		</div>
	</div>
</div><!-- End Service List Section -->
<?php echo $facilities; echo $footer; ?>