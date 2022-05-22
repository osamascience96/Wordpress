<?php echo $header; ?>
<!-- Start Slider Section -->
<div id="slider" class="slider">
	<div class="flexslider slider-wrapper">
		<ul class="slides colored-background">
			<?php if (!empty($page['page_data']['slider'])) { foreach ($page['page_data']['slider'] as $key => $value) { if (!empty($value)) { ?>
				<li>
					<div class="slider-info">
						<h1 class="animated fadeInDown"><?php echo $value['tag']; ?></h1>
						<p class="animated fadeInDown"><?php echo $value['content']; ?></p>
					</div>
					<div class="slider-backgroung-image" style="background-image: url(public/uploads/<?php echo $value['img']; ?> );"></div>
				</li>
			<?php } } } ?>
		</ul>
		<div class="slider-appointment">
			<?php if ( $whocan['appointment'] ) { ?>
				<a href="<?php echo URL.DIR_ROUTE."makeanappointment"; ?>" class="animated fadeInUp"><i class="far fa-calendar-plus mr-2"></i><?php echo $lang['text_make_an_appointment']; ?></a>
			<?php } else { ?>
				<a href="<?php echo URL.DIR_ROUTE."login"; ?>" class="animated fadeInUp"><i class="far fa-calendar-plus mr-2"></i><?php echo $lang['text_make_an_appointment']; ?></a>
			<?php } ?>
		</div>
	</div>
</div><!-- End Slider Section -->
<?php if (isset($page['page_data']['service']['status']) && $page['page_data']['service']['status'] == '1') { ?>
	<!-- Start Home Service Section -->
	<div id="hm-service" class="animated-wrapper">
		<div class="layer-stretch">
			<div class="layer-wrapper layer-bottom-0">
				<div class="layer-ttl">
					<h3 class="animated animated-down"><?php echo $page['page_data']['service']['title']; ?></h3>
				</div>
				<div class="row">
					<?php if (!empty($services)) { foreach ($services as $value) { ?>
						<div class="col-12 col-md-6 col-lg-4 feature-block feature-block-dark animated animated-up">
							<div class="icon"><i class="<?php echo $value['icon']; ?>"></i></div>
							<span><?php echo $value['name']; ?></span>
							<p><?php echo $value['short_post']; ?></p>
						</div>
					<?php } } ?>
				</div>
			</div>
		</div>
	</div><!-- End Home Service Section -->
<?php } if (isset($page['page_data']['about']['status']) && $page['page_data']['about']['status'] == '1') { ?>
	<!-- Start Home About Section -->
	<div id="hm-about" class="colored-background">
		<div class="layer-stretch">
			<div class="layer-wrapper animated-wrapper">
				<div class="layer-ttl layer-ttl-white">
					<h3 class="animated animated-down"><?php echo $page['page_data']['about']['title']; ?></h3>
				</div>
				<div class="row align-items-center">
					<div class="col-md-7">
						<?php if(!empty($page['page_data']['about']['block'])) { foreach ($page['page_data']['about']['block'] as $key => $value) { ?>
							<div class="hm-about-block">
								<div class="tbl-cell hm-about-icon"><i class="<?php echo $value['icon']; ?>"></i></div>
								<div class="tbl-cell hm-about-number">
									<span><?php echo $value['count']; ?></span>
									<p><?php echo $value['title']; ?></p>
								</div>
							</div>
						<?php } } ?>
						<div class="hm-about-paragraph animated animated-up">
							<p class="paragraph-medium paragraph-white"><?php echo $page['page_data']['about']['description']; ?></p>
						</div>
					</div>
					<div class="col-md-5 animated animated-up fadeInUp">
						<img class="img-thumbnail" src="public/uploads/<?php echo $page['page_data']['about']['picture']; ?>" alt="">
					</div>
				</div>
			</div>
		</div>
	</div><!-- End Home About Section -->
<?php } if (isset($page['page_data']['facility']['status']) && $page['page_data']['facility']['status'] == '1') { ?>
	<!-- Start Home Facility Section -->
	<div id="hm-feature" class="layer-stretch animated-wrapper">
		<div class="layer-wrapper layer-bottom-0">
			<div class="layer-ttl">
				<h3 class="animated animated-down"><?php echo $page['page_data']['facility']['title']; ?></h3>
			</div>
			<div class="row">
				<?php if (!empty($facilities)) { foreach ($facilities as $value) { ?>
					<div class="col-sm-6 col-lg-4 animated animated-up">
						<div class="department-block department-card">
							<div class="tbl-cell icon"><i class="<?php echo $value['icon']; ?>"></i></div>
							<div class="tbl-cell detail">
								<h5><?php echo $value['name']; ?></h5>
								<p class="paragraph-small paragraph-white"><?php echo $value['description']; ?></p>
							</div>
						</div>
					</div>
				<?php } } ?>
			</div>
		</div>
	</div><!-- End Home Facility Section -->
<?php } if (isset($page['page_data']['doctor']['status']) && $page['page_data']['doctor']['status'] == '1') { ?>
	<!-- Start Doctor Section -->
	<div class="colored-background">
		<div class="layer-stretch">
			<div class="layer-wrapper animated-wrapper">
				<div class="layer-ttl layer-ttl-white">
					<h3 class="animated animated-down"><?php echo $page['page_data']['doctor']['title']; ?></h3>
				</div>
				<div class="layer-container">
					<?php echo $sliderdoctor; ?>
				</div>
			</div>
		</div>
	</div><!-- End Doctor Section -->
<?php } if (isset($page['page_data']['blog']['status']) && $page['page_data']['blog']['status'] == '1') { ?>
	<!-- Start Home Blog Section -->
	<div id="hm-blog" class="layer-stretch animated-wrapper">
		<div class="layer-wrapper layer-bottom-0">
			<div class="layer-ttl">
				<h3 class="animated animated-down"><?php echo $page['page_data']['blog']['title']; ?></h3>
			</div>
			<div class="row text-center">
				<?php echo $blog; ?>
			</div>
		</div>
	</div><!-- End Home Blog Section -->
<?php } if (isset($page['page_data']['testimonial']['status']) && $page['page_data']['testimonial']['status'] == '1') { ?>
	<!-- Start Home Testimonial Section -->
	<div id="testimonial" class="colored-background">
		<div class="layer-stretch">
			<div class="layer-wrapper animated-wrapper">
				<div class="layer-ttl layer-ttl-white">
					<h3 class="animated animated-down"><?php echo $page['page_data']['testimonial']['title']; ?></h3>
				</div>
				<?php echo $testimonial; ?>
			</div>
		</div>
	</div><!-- End Home Testimonial Section -->
	<?php } echo $footer; ?>