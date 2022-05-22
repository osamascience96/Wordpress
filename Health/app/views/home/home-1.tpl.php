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
			<div class="layer-wrapper">
				<div class="layer-ttl">
					<h3 class="animated animated-down"><?php echo $page['page_data']['service']['title']; ?></h3>
				</div>
				<div class="layer-container row">
					<div class="hm-service-left col-md-5">
						<img class="animated animated-up" src="public/uploads/<?php echo $page['page_data']['service']['picture']; ?>" alt="<?php echo $siteinfo['name']; ?>">
					</div>
					<div class="hm-service-right col-md-7">
						<div class="paragraph-medium paragraph-black animated animated-up"><?php echo $page['page_data']['service']['description']; ?></div>
						<div class="hm-service row">
							<?php if (!empty($services)) { foreach ($services as $value) { ?>
								<div class="col-6 col-sm-4 col-md-6 col-lg-4 block animated animated-up">
									<i class="<?php echo $value['icon']; ?>"></i>
									<span><?php echo $value['name']; ?></span>
								</div>
							<?php } } ?>
						</div>
						<div class="hm-service-view text-center">
							<a href="<?php echo URL.DIR_ROUTE; ?>service" class="btn btn-outline btn-primary btn-outline-2x">
								<i class="fa fa-eye mr-2"></i><span><?php echo $lang['text_view_all_services']; ?></span>
							</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div><!-- End Home Service Section -->
<?php } if (isset($page['page_data']['about']['status']) && $page['page_data']['about']['status'] == '1') { ?>
	<!-- Start Home About Section -->
	<div id="hm-about" class="parallax-background" style="background-image: url(<?php echo 'public/uploads/'.$page['page_data']['about']['background']; ?>);">
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
			<div class="layer-container">
				<div class="row">
					<?php if (!empty($facilities)) { foreach ($facilities as $key => $value) { ?>
						<div class="col-sm-6 col-md-4 col-lg-3 hm-feature-block animated animated-up">
							<div class="icon">
								<i class="<?php echo $value['icon']; ?>"></i>
							</div>
							<span><?php echo $value['name']; ?></span>
							<p class="paragraph-small paragraph-black"><?php echo $value['description']; ?></p>
						</div>
					<?php } } ?>
				</div>
			</div>
		</div>
	</div><!-- End Home Facility Section -->
<?php } if (isset($page['page_data']['doctor']['status']) && $page['page_data']['doctor']['status'] == '1') { ?>
	<!-- Start Doctor Section -->
	<div class="parallax-background" style="background-image: url(<?php echo 'public/uploads/'.$page['page_data']['doctor']['background']; ?>);">
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
	<div id="testimonial" class="parallax-background" style="background-image: url(<?php echo 'public/uploads/'.$page['page_data']['testimonial']['background']; ?>);">
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