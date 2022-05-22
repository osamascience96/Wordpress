<?php echo $header; ?>
<!-- Start About Section  -->
<div class="layer-stretch animated-wrapper">
	<div class="layer-wrapper text-center">
		<div class="row">
			<div class="col-md-5 hm-service-left">
				<img class="animated animated-up" src="public/uploads/<?php echo $page['page_data']['about']['picture']; ?>" alt="">
			</div>
			<div class="col-md-7 hm-service-right animated animated-up">
				<div class="paragraph-medium paragraph-black"><?php echo html_entity_decode($page['page_data']['about']['paragraph'], ENT_QUOTES, 'UTF-8'); ?></div>
			</div>
		</div>
	</div>
</div><!-- End About section  -->
<?php if (isset($page['page_data']['whoweare']['status']) && $page['page_data']['whoweare']['status'] == '1') { ?>
<!-- Start Who we are Section -->
<div class="colored-background">
	<div class="layer-stretch">
		<div class="layer-wrapper layer-bottom-0 animated-wrapper">
			<div class="layer-ttl layer-ttl-white">
				<h3 class=" animated animated-down"><?php echo $page['page_data']['whoweare']['title']; ?></h3>
			</div>
			<div class="row">
				<div class="col-md-7">
					<?php if(!empty($page['page_data']['whoweare']['block'])) { foreach ($page['page_data']['whoweare']['block'] as $key => $value) { ?>
						<div class="hm-about-block animated animated-up">
							<div class="tbl-cell hm-about-icon">
								<i class="<?php echo $value['icon']; ?>"></i>
							</div>
							<div class="tbl-cell hm-about-number">
								<span><?php echo $value['count']; ?></span>
								<p><?php echo $value['title']; ?></p>
							</div>
						</div>
					<?php } } ?>
				</div>
				<div class="col-md-5">
					<img class="img-thumbnail animated animated-up" src="public/uploads/<?php echo $page['page_data']['whoweare']['picture']; ?>" alt="">
				</div>
				<div class="row about-mission-vission text-center">
					<div class="col-md-6 about-mission animated animated-up">
						<span><?php echo $page['page_data']['whoweare']['mission']['title']; ?></span>
						<p class="paragraph-medium paragraph-white"><?php echo $page['page_data']['whoweare']['mission']['description']; ?></p>
					</div>
					<div class="col-md-6 about-vission animated animated-up">
						<span><?php echo $page['page_data']['whoweare']['vission']['title']; ?></span>
						<p class="paragraph-medium paragraph-white"><?php echo $page['page_data']['whoweare']['vission']['description']; ?></p>
					</div>
				</div>
			</div>
		</div>
	</div>
</div><!-- End Who we are section  -->
<?php } if (isset($page['page_data']['doctor']['status']) && $page['page_data']['doctor']['status'] == '1') { ?>
<!-- Start Doctor Section -->
<div class="layer-stretch animated-wrapper">
	<div class="layer-wrapper layer-bottom-0">
		<div class="layer-ttl">
			<h3 class="animated animated-down"><?php echo $page['page_data']['doctor']['title']; ?></h3>
		</div>
		<div class="row">
			<?php echo $doctor; ?>
		</div>
	</div>
</div><!-- End About section  -->
<?php } if (isset($page['page_data']['testimonial']['status']) && $page['page_data']['testimonial']['status'] == '1') { ?>
<!-- Start Testimonial section -->	
<div id="testimonial" class="colored-background">
	<div class="layer-stretch">
		<div class="layer-wrapper layer-bottom-0 animated-wrapper">
			<div class="layer-ttl layer-ttl-white">
				<h3 class="animated animated-down"><?php echo $page['page_data']['testimonial']['title']; ?></h3>
			</div>
			<?php echo $testimonial; ?>
		</div>
	</div>
</div><!-- End Testimonial Section -->
<?php } echo $footer; ?>