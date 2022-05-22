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
    <link rel="stylesheet" href="<?php echo $stylesheet; ?>">
    <?php if (isset($custom_css)) { echo '<style>'.$custom_css.'</style>'; } ?>
</head>
<body>

    <!-- Header Start -->
    <header class="hdr-position-absolute">
        <div id="hdr-top-wrapper" class="bg-white">
            <div class="layer-stretch hdr-top">
                <div class="hdr-top-block hidden-xs">
                    <div id="hdr-social">
                        <ul class="social-list social-list-sm">
                            <li><a class="width-auto font-13"><?php echo $lang['text_follow_us']; ?> : </a></li>
                            <?php if (!empty($sociallink)) { foreach ($sociallink as $key => $value) { if (!empty($value)) { ?>
                                <li><a href="<?php echo $value; ?>" target="_blank"><i class="fab fa-<?php echo $key; ?>" ></i></a></li>
                            <?php } } } ?>
                        </ul>
                    </div>
                </div>
                <div class="hdr-top-line hidden-xs"></div>
                <div class="hdr-top-block hdr-number">
                    <div class="font-13">
                        <i class="fas fa-mobile-alt tbl-cell"></i>
                        <span class="hidden-xs tbl-cell"> <?php echo $lang['text_emergency_number']; ?> : </span>
                        <span class="tbl-cell"><?php echo $siteinfo['emergency']; ?></span>
                    </div>
                </div>
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
        <div id="hdr-wrapper" class="fixed-on-scroll">
            <div class="layer-stretch hdr">
                <div class="tbl">
                    <div class="tbl-row">
                        <div class="tbl-cell hdr-logo">
                            <a href="<?php echo URL; ?>">
                                <img src="<?php echo $logo; ?>" alt="<?php echo $siteinfo['name']; ?>">
                            </a>
                        </div>
                        <div class="tbl-cell hdr-menu">
                            <ul class="menu">
                                <?php echo $menu; ?>
                                <li class="mobile-menu-close">
                                    <i class="fa fa-times"></i>
                                </li>
                            </ul>
                            <div id="menu-bar">
                                <a><i class="fa fa-bars"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <!-- Header End -->
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