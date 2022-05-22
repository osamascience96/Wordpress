<?php if (isset($page_data['department']['status']) && $page_data['department']['status'] == '1') { ?>
	<!-- Start Department div -->
	<div class="colored-background">
		<div class="layer-stretch">
			<div class="layer-wrapper layer-bottom-0 animated-wrapper">
				<div class="layer-ttl layer-ttl-white">
					<h3 class="animated animated-down"><?php echo $page_data['department']['title']; ?></h3>
				</div>
				<div class="layer-container">
					<div class="row">
						<?php if (!empty($departments)) { foreach ($departments as $value) { ?>
							<div class="col-sm-6 col-md-4 department-block animated animated-up">
								<div class="tbl-cell icon"><i class="<?php echo $value['icon']; ?>"></i></div>
								<div class="tbl-cell detail">
									<a><?php echo $value['name']; ?></a>
									<p class="paragraph-medium paragraph-white"><?php echo $value['description']; ?></p>
								</div>
							</div>
						<?php } } ?>
					</div>
				</div>
			</div>
		</div>
	</div><!-- End Department List Section -->
	<?php } ?>