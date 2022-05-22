<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title><?php echo $meta_tag; ?></title>
	<meta name="Description" content="<?php echo $meta_description; ?>">
	<link rel="icon" type="image/x-icon" href="<?php echo $favicon; ?>" />
	<?php if (!empty($siteinfo['ga'])) { ?>
		<!-- Google Analytics -->
		<script>
			(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
				(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
				m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
			})(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

			ga('create', '<?php echo $siteinfo['ga']; ?>', 'auto');
			ga('send', 'pageview');
		</script>
		<!-- End Google Analytics -->
	<?php } ?>
	<!-- Included Stylesheets -->
	<link rel="stylesheet" href="<?php echo $stylesheet; ?>">
	<?php if (isset($custom_css)) { echo '<style>'.$custom_css.'</style>'; } ?>
</head>
<body>
	
	<!-- Start Header -->
	<header class="hdr hdr-position-absolute">
		<!-- Start Header Top Section -->
		<div id="hdr-top-wrapper" class="bg-white">
			<div class="layer-stretch hdr-top">
				<div class="row">
					<div class="col-md-6 text-left d-none d-sm-none d-md-block d-lg-block d-xl-block">
						<div class="hdr-top-block">
							<div id="hdr-social">
								<ul class="social-list social-list-sm">
									<li><a class="width-auto font-13"><?php echo $lang['text_follow_us']; ?> : </a></li>
									<?php if (!empty($sociallink)) { foreach ($sociallink as $key => $value) { if (!empty($value)) { ?>
										<li><a href="<?php echo $value; ?>" target="_blank"><i class="fab fa-<?php echo $key; ?>" ></i></a></li>
									<?php } } } ?>
								</ul>
							</div>
						</div>
					</div>
					<div class="col-md-6 text-right">
						<?php if ( empty($user['name']) && empty($user['email']) ) { ?>
							<div class="hdr-top-block">
								<div class="d-block d-sm-block d-md-block d-lg-block d-xl-block">
									<a href="<?php echo URL.DIR_ROUTE.'login'; ?>" class="font-400 pr-2 pl-2">
										<i class="fas fa-sign-in-alt font-14 text-lesser-dark mr-2 d-inline-block align-middle"></i>
										<span class="d-inline-block align-middle"><?php echo $lang['text_login']; ?></span>
									</a>
								</div>
							</div>
						<?php } else { ?>
							<div class="hdr-top-block">
								<div class="d-none d-sm-block d-md-block d-lg-block d-xl-block">
									<div class="theme-dropdown">
										<a href="<?php echo URL.DIR_ROUTE.'user/appointments'; ?>" class="font-400 pr-2 pl-2">
											<i class="far fa-calendar-plus font-14 text-lesser-dark mr-2 d-inline-block align-middle"></i>
											<span class="d-inline-block align-middle"><?php echo $lang['text_my_appointments']; ?></span>
										</a>
									</div>
								</div>
							</div>
						<?php } ?>
						<div class="hdr-top-line"></div>
						<div class="hdr-top-block">
							<div class="menu-dropdown-wrapper">
								<a>
									<i class="fas fa-user text-lesser-dark d-inline-block align-middle"></i>
									<span class="d-inline-block align-middle profile-menu"><?php if( !empty($user['name']) && !empty($user['email']) ) { echo $user['name']; } else { echo $lang['text_my_account']; } ?></span>
								</a>
								<?php if( !empty($user['name']) && !empty($user['email']) ) { ?>
									<ul class="menu-dropdown menu-dropdown-right">
										<li>
											<a href="<?php echo URL.DIR_ROUTE; ?>user/appointments"><?php echo $lang['text_my_appointments']; ?></a>
										</li>
										<li>
											<a href="<?php echo URL.DIR_ROUTE; ?>user/request"><?php echo $lang['text_my_requests']; ?></a>
										</li>
										<li>
											<a href="<?php echo URL.DIR_ROUTE; ?>user/profile"><?php echo $lang['text_my_profile']; ?></a>
										</li>
										<li>
											<a href="<?php echo URL.DIR_ROUTE; ?>logout"><?php echo $lang['text_logout']; ?></a>
										</li>
									</ul>
								<?php }  else { ?>
									<ul class="menu-dropdown menu-dropdown-right">
										<li>
											<a href="<?php echo URL.DIR_ROUTE; ?>login"><?php echo $lang['text_login']; ?></a>
										</li>
										<li>
											<a href="<?php echo URL.DIR_ROUTE; ?>register"><?php echo $lang['text_register']; ?></a>
										</li>
										<li>
											<a href="<?php echo URL.DIR_ROUTE; ?>forgot"><?php echo $lang['text_forgot_password']; ?></a>
										</li>
									</ul>
								<?php } ?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div><!-- End Header Top Section -->
		<!-- Start Header Center Section -->
		<div class="hdr-center fixed-on-scroll bg-white">
			<div class="layer-stretch">
				<div class="row align-items-center">
					<div class="col-8 col-sm-4 col-md-2">
						<div class="hdr-logo">
							<a href="<?php echo URL; ?>" class="d-inline-block"><img src="<?php echo $logo; ?>" alt="<?php echo $siteinfo['name']; ?>"></a>
						</div>
					</div>
					<div class="col-4 col-sm-8 col-md-10">
						<div class="hdr-center-submenu row justify-content-end align-items-center">
							<div class="col-md-auto d-none d-sm-none d-md-block d-lg-block d-xl-block">
								<div class="tbl-cell">
									<i class="far fa-envelope"></i>
								</div>
								<div class="tbl-cell text-left p-0">
									<p class="font-12 m-0 text-muted"><?php echo $lang['text_have_an_query']; ?></p>
									<p class="font-14 m-0"><?php echo $siteinfo['mail']; ?></p>
								</div>
							</div>
							<div class="col-auto col-md-auto d-none d-sm-block d-md-block d-lg-block d-xl-block">
								<div class="tbl-cell">
									<i class="fas fa-mobile-alt"></i>
								</div>
								<div class="tbl-cell text-left p-0">
									<p class="font-12 m-0 text-muted"><?php echo $lang['text_want_to_clarify']; ?></p>
									<p class="font-14 m-0"><?php echo $siteinfo['emergency']; ?></p>
								</div>
							</div>
							<div class="col-auto col-md-auto d-block d-sm-block d-md-block d-lg-none d-xl-none">
								<div id="menu-bar"><a><i class="fas fa-bars"></i></a></div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div><!-- End Header Center Section -->
		<!-- Start Header Menu Section -->
		<div class="hdr-center-menu hdr-position-absolute hdr-dark-background fixed-on-scroll-colored-background">
			<div class="hdr layer-stretch">
				<div class="row align-items-center justify-content-end">
					<ul class="col menu text-left">
						<?php echo $menu; ?>
						<li class="mobile-menu-close"><i class="fa fa-times"></i></li>
					</ul>
					<div class="col-md-auto d-none d-sm-none d-md-none d-lg-block d-xl-block mt-3 mb-3">
						<?php if ( $whocan['appointment'] ) { ?>
							<a href="<?php echo URL.DIR_ROUTE."makeanappointment"; ?>" class="btn btn-primary btn-pill"><span class="far fa-calendar-plus mr-2"></span> Make An Appointment</a>
						<?php } else { ?>
							<a href="<?php echo URL.DIR_ROUTE."login"; ?>" class="btn btn-primary btn-pill"><span class="far fa-calendar-plus mr-2"></span> Make An Appointment</a>
						<?php } ?>
					</div>
				</div>
			</div>
		</div><!-- End Header Menu Section -->
	</header><!-- End Header -->
	<?php if (isset($page_section) && $page_section == true) { ?>
		<!-- Start Page Title Section -->
		<div class="page-ttl <?php echo $page_padding; ?>">
			<div class="layer-stretch">
				<div class="page-ttl-container">
					<div class="page-ttl-name">
						<h1><?php echo $page_title; ?></h1>
						<p>
							<?php if (!empty($breadcrumbs)) { $lastKey = count($breadcrumbs) - 1; foreach ($breadcrumbs as $key => $value) { ?>
								<a href="<?php echo $value['link']; ?>"><?php echo $value['label'].'</a>'; if ($key != $lastKey) { echo '>>'; } ?>
							<?php } } ?>
						</p>
					</div>
				</div>
			</div>
		</div><!-- End Page Title Section -->
		<?php } ?>