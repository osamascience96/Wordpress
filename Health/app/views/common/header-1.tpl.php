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
    <!-- Start Header Section -->
    <header class="hdr-transparent hdr-position-absolute">
        <div class="layer-stretch hdr-center pt-4 pb-4">
            <div class="row align-items-center">
                <div class="col-lg-4 d-none d-sm-none d-md-none d-lg-block d-xl-block">
                    <div class="hdr-center-account text-left p-0">
                        <?php if( empty($user['name']) && empty($user['email']) ) { ?>
                            <a href="<?php echo URL.DIR_ROUTE.'login'; ?>" class="font-14 mr-4">
                                <i class="fas fa-sign-in-alt d-inline-block align-middle"></i>
                                <span class="d-inline-block align-middle"><?php echo $lang['text_login']; ?></span>
                            </a>
                            <a href="<?php echo URL.DIR_ROUTE.'register'; ?>" class="font-14">
                                <i class="fas fa-user-plus d-inline-block align-middle"></i>
                                <span class="d-inline-block align-middle"><?php echo $lang['text_register']; ?></span>
                            </a>
                        <?php } else { ?>
                            <a href="<?php echo URL.DIR_ROUTE.'user/appointments'; ?>" class="font-14">
                                <i class="far fa-calendar-plus d-inline-block align-middle"></i>
                                <span class="d-inline-block align-middle"><?php echo $lang['text_my_appointments']; ?></span>
                            </a>
                        <?php } ?>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="hdr-center-logo">
                        <a href="<?php echo URL; ?>" class="d-inline-block"><img src="<?php echo $logo; ?>" alt="<?php echo $siteinfo['name']; ?>"></a>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4 d-none d-sm-none d-md-block d-lg-block d-xl-block text-right">
                    <ul class="social-list social-list-white">
                        <?php if (!empty($sociallink)) { foreach ($sociallink as $key => $value) { if (!empty($value)) { ?>
                            <li>
                                <a href="<?php echo $value; ?>" class="fab fa-<?php echo $key; ?> rounded" target="_blank"></a>
                            </li>
                        <?php } } } ?>
                    </ul>
                </div>
            </div>
        </div>
        <div class="hdr-transparent-menu hdr-dark-background fixed-on-scroll-colored-background">
            <div class="hdr layer-stretch">
                <div class="row align-items-center">
                    <!-- Start Menu Section -->
                    <ul class="col menu text-left">
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
                        <li class="mobile-menu-close">
                            <i class="fa fa-times"></i>
                        </li>
                    </ul><!-- End Menu Section -->
                    <div id="menu-bar" class="col-2 col-md-auto"><a><i class="fas fa-bars text-white"></i></a></div>
                    <div class="col col-md-auto d-block d-sm-block d-md-block d-lg-block d-xl-block">
                        <?php if ( $whocan['appointment'] ) { ?>
                            <a href="<?php echo URL.DIR_ROUTE."makeanappointment"; ?>" class="btn btn-primary btn-pill pt-2 pb-2"><i class="far fa-calendar-plus mr-2"></i> Make An Appointment</a>
                        <?php } else { ?>
                            <a href="<?php echo URL.DIR_ROUTE."login"; ?>" class="btn btn-primary btn-pill pt-2 pb-2"><i class="far fa-calendar-plus mr-2"></i> Make An Appointment</a>
                        <?php } ?>
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




