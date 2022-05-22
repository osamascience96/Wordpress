<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo $page_title.' | '.$common['info']['name']; ?></title>
    <?php if (!empty($common['theme']['favicon']) && file_exists(DIR.'public/uploads/'.$common['theme']['favicon'])) { ?>
    <link rel="icon" type="image/x-icon" href="<?php echo URL.'public/uploads/'.$common['theme']['favicon']; ?>">
    <?php } else { ?>
    <link rel="icon" type="image/x-icon" href="<?php echo URL_ADMIN.'public/images/favicon.png'; ?>">
    <?php } ?>
    <!-- Include css files -->
    <link rel="stylesheet" type="text/css" href="<?php echo URL_ADMIN.'public/css/style.min.css'; ?>" />
    <!-- Include js files -->
    <script type="text/javascript" src="<?php echo URL_ADMIN.'public/js/vendor.min.js'; ?>"></script>
    <script type="text/javascript" src="<?php echo URL_ADMIN.'public/js/admin.js'; ?>"></script>
</head>
<body>
    <div class="wrapper <?php if (!empty($common['theme']['layout'])) { echo ' '.$common['theme']['layout']; } ?>">
        <!-- Main Container -->
        <div id="main-wrapper" class="<?php if (!empty($common['theme']['layout_fixed'])) { echo ' '.$common['theme']['layout_fixed']; } if (!empty($common['theme']['side_menu'])) { echo ' menu-'.$common['theme']['side_menu']; }  if (!empty($common['theme']['layout_menu'])) { echo ' '.$common['theme']['layout_menu']; }?>">
            <!-- Media Modal -->
            <div id="media-upload" class="modal fade">
                <div class="modal-dialog modal-xl">
                    <div class="modal-content">
                        <div class="modal-header">
                            <div class="media-hdr"><p>Media <span>(Click On Image To Select)</span></p></div>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                        <div class="modal-body">
                            <div class="media-upload-container">
                                <form action="<?php echo URL_ADMIN.DIR_ROUTE.'media/upload';?>" class="dropzone" id="media-dropzone" method="post" enctype="multipart/form-data"><div class="fallback"><input name="file" type="file" /></div></form>
                            </div>
                            <div class="media-all pt-3"></div>
                            <input type="hidden" class="uploaded" value="0">
                        </div>
                    </div>
                </div>
            </div>
            <!-- Menu Wrapper -->
            <div class="menu-wrapper">
                <div class="menu"><?php echo $common['admin_menu']; ?></div>
            </div>
            <div class="page-hdr">
                <div class="row align-items-center">
                    <div class="col-4 col-md-7 page-hdr-left">
                        <!-- Logo Container -->
                        <div id="logo">
                            <div class="logo-icon">
                                <a href="#">
                                    <?php if (!empty($common['theme']['logo_icon']) && file_exists(DIR.'public/uploads/'.$common['theme']['logo_icon'])) { ?>
                                        <img src="<?php echo URL.'public/uploads/'.$common['theme']['logo_icon']; ?>" alt="Icon">
                                    <?php } else { ?>
                                        <img src="<?php echo URL_ADMIN.'public/images/icon.png'; ?>" alt="Icon">
                                    <?php } ?>
                                </a>
                            </div>
                            <div class="logo">
                                <a href="#">
                                    <?php if (!empty($common['theme']['logo']) && file_exists(DIR.'public/uploads/'.$common['theme']['logo'])) { ?>
                                        <img src="<?php echo URL.'public/uploads/'.$common['theme']['logo']; ?>" alt="Logo">
                                    <?php } else { ?>
                                        <img src="<?php echo URL_ADMIN.'public/images/logo.png'; ?>" alt="Logo">
                                    <?php } ?>
                                </a>
                            </div>
                        </div>
                        <div class="page-menu menu-icon pl-2">
                            <a class="animated menu-close icon"><i class="far fa-hand-point-left"></i></a>
                        </div>
                        <div class="page-menu page-fullscreen">
                            <a class="icon"><i class="fas fa-expand"></i></a>
                        </div>
                        <?php if ($common['page_search']) { ?>
                            <div class="page-search"><input type="text" placeholder="Search Patient by Name ..."></div>
                        <?php } ?>
                    </div>
                    <div class="col-8 col-md-5 page-hdr-right">
                        <input type="hidden" class="common_date_format" value="<?php echo str_replace(['d', 'm', 'Y'], ['dd', 'mm', 'yy'], $common['info']['date_format']); ?>">
                        <input type="hidden" class="common_date_my_format" value="<?php echo str_replace(['m', 'Y'], ['mm', 'yy'], $common['info']['date_my_format']); ?>">
                        <input type="hidden" class="common_daterange_format" value="<?php echo str_replace(['d', 'm', 'Y'], ['DD', 'MM', 'YYYY'], $common['info']['date_format']); ?>">
                        <input type="hidden" class="common_daterange_my_format" value="<?php echo str_replace(['m', 'Y'], ['MM', 'YYYY'], $common['info']['date_my_format']); ?>">
                        <input type="hidden" class="site_url" value="<?php echo URL_ADMIN.DIR_ROUTE; ?>">
                        <input type="hidden" class="s_token" value="<?php echo $common['token']; ?>">
                        <div class="page-hdr-desktop">
                            <div class="page-menu">
                                <a href="<?php echo URL_ADMIN; ?>" class="animated icon"><i class="ti-home"></i></a>
                            </div>
                            <div class="page-menu menu-dropdown-wrapper menu-quick-links">
                                <a class="icon"><i class="ti-view-grid font-14"></i></a>
                                <div class="menu-dropdown menu-dropdown-right menu-dropdown-push-right">
                                    <div class="arrow arrow-right"></div> 
                                    <div class="menu-dropdown-inner">
                                        <div class="menu-dropdown-head">Quick Links</div>
                                        <div class="menu-dropdown-body p-0">
                                            <div class="row m-0 box">
                                                <div class="col-6 p-0 box">
                                                    <a href="<?php echo URL_ADMIN.DIR_ROUTE.'patient/add'; ?>"><i class="ti-heart-broken"></i><span>New Patient</span>
                                                    </a>
                                                </div>
                                                <div class="col-6 p-0 box">
                                                    <a href="<?php echo URL_ADMIN.DIR_ROUTE.'appointments'; ?>"><i class="ti-calendar"></i><span>New Appointment</span>
                                                    </a>
                                                </div>
                                                <div class="col-6 p-0 box">
                                                    <a href="<?php echo URL_ADMIN.DIR_ROUTE.'invoice/add'; ?>"><i class="ti-receipt"></i><span>New Invoice</span>
                                                    </a>
                                                </div>
                                                <div class="col-6 p-0 box">
                                                    <a href="<?php echo URL_ADMIN.DIR_ROUTE.'expense/add'; ?>"><i class="ti-rocket"></i><span>New Expense</span>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="page-menu menu-dropdown-wrapper menu-user">
                                <a class="user-link"><div class="icon"><i class="ti-user"></i></div></a>
                                <div class="menu-dropdown menu-dropdown-right menu-dropdown-push-right">
                                    <div class="arrow arrow-right"></div> 
                                    <div class="menu-dropdown-inner">
                                        <div class="menu-dropdown-head pb-3">
                                            <div class="tbl-cell">
                                                <?php if (file_exists('../public/uploads/'.$common['user']['picture']) && !empty($common['user']['picture'])) { ?>
                                                    <img src="<?php echo '../public/uploads/'.$common['user']['picture']; ?>" alt="Klinikal">
                                                <?php } else { ?>
                                                    <i class="ti-user"></i>
                                                <?php } ?>
                                            </div>
                                            <div class="tbl-cell pl-2 text-left">
                                                <p class="m-0 font-18"><?php echo $common['user']['firstname'].' '.$common['user']['lastname']; ?></p>
                                                <p class="m-0 font-14"><?php echo $common['user']['role']; ?></p>
                                            </div>
                                        </div>
                                        <div class="menu-dropdown-body">
                                            <ul class="menu-nav">
                                                <li><a href="<?php echo URL; ?>" target="_blank"><i class="ti-home"></i><span>Visit Website</span></a></li>
                                                <li><a href="<?php echo URL_ADMIN.DIR_ROUTE.'profile'; ?>"><i class="ti-id-badge"></i><span>Profile</span></a></li>
                                                <li><a href="<?php echo URL_ADMIN.DIR_ROUTE.'profile'; ?>"><i class="ti-key"></i><span>Change Password</span></a></li>
                                            </ul>
                                        </div>
                                        <div class="menu-dropdown-footer text-right">
                                            <a href="<?php echo URL_ADMIN.DIR_ROUTE.'logout'; ?>" class="btn btn-outline btn-primary btn-pill btn-outline-2x font-12 btn-sm">Logout</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="page-hdr-mobile">
                            <div class="page-menu open-mobile-search">
                                <a href="#"><i class="ti-search"></i></a>
                            </div>
                            <div class="page-menu open-left-menu">
                                <a href="#"><i class="ti-view-list"></i></a>
                            </div>
                            <div class="page-menu open-page-menu-desktop">
                                <a href="#"><i class="ti-more"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="page-wrapper">
                <div class="page-body">