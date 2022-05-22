<?php if (isset($page_data['facility']['status']) && $page_data['facility']['status'] == '1') { ?>
<!-- Start Facility List Section -->
<div class="colored-background">
	<div class="layer-stretch">
		<div class="layer-wrapper layer-bottom-0 animated-wrapper">
			<div class="layer-ttl layer-ttl-white">
				<h3 class="animated animated-down"><?php echo $page_data['facility']['title']; ?></h3>
			</div>
			<div class="row">
				<?php if (!empty($facilities)) { foreach ($facilities as $value) { ?>
				<div class="col-12 col-sm-6 col-md-4 col-lg-3 feature-block animated animated-up">
					<div class="icon">
						<i class="<?php echo $value['icon']; ?>"></i>
					</div>
					<span><?php echo $value['name']; ?></span>
					<p class="paragraph-medium paragraph-white"><?php echo $value['description']; ?></p>
				</div>
				<?php } } ?>
			</div>
		</div>
	</div>
</div><!-- End Facility List Section -->
<?php } ?>