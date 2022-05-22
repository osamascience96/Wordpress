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
	<!-- Start of header div -->
	<header class="hdr-position-absolute hdr-top-2 fixed-on-scroll-colored-background">
		<div class="layer-stretch hdr hdr-transparent">
			<div class="tbl animated slideInDown">
				<div class="tbl-row">
					<div class="tbl-cell hdr-logo">
						<a href="<?php echo URL.DIR_ROUTE; ?>home">
							<img src="<?php echo $logo; ?>" alt="<?php echo $siteinfo['name']; ?>">
						</a>
					</div>
					<div class="tbl-cell hdr-menu">
						<ul class="menu">
							<?php echo $menu; ?>
							<li>
								<a><?php echo $lang['text_my_account']; ?> <i class="fa fa-chevron-down"></i></a>
								<ul class="menu-dropdown">
									<?php if( !empty($user['name']) && !empty($user['email']) ) { ?>
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
									<?php } else { ?>
										<li>
											<a href="<?php echo URL.DIR_ROUTE; ?>login"><?php echo $lang['text_login']; ?></a>
										</li>
										<li>
											<a href="<?php echo URL.DIR_ROUTE; ?>register"><?php echo $lang['text_register']; ?></a>
										</li>
										<li>
											<a href="<?php echo URL.DIR_ROUTE; ?>forgot"><?php echo $lang['text_forgot_password']; ?></a>
										</li>
									<?php } ?>
								</ul>
							</li>
							<li class="mobile-menu-close"><i class="fa fa-times"></i></li>
						</ul>
						<div id="menu-bar"><a><i class="fas fa-bars text-white"></i></a></div>
					</div>
				</div>
			</div>
		</div>
	</header><!-- End Header Section -->
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