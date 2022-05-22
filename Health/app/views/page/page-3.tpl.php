<?php echo $header; ?>
<div class="layer-stretch">
	<div class="layer-wrapper pb-0">
		<div class="row">
			<div class="col-lg-4">
				<?php echo $page_sidebar; ?>
			</div>
			<div class="col-lg-8">
				<?php echo html_entity_decode($page['page_data'], ENT_QUOTES, 'UTF-8'); ?>
			</div>
		</div>
	</div>
</div>
<?php echo $footer; ?>