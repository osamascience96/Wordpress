<?php include (DIR_ADMIN.'app/views/common/header.tpl.php'); ?>
<div class="page-title">
    <div class="row align-items-center">
        <div class="col-sm-6">
            <h2 class="page-title-text d-inline-block"><?php echo $page_title; ?></h2>
            <div class="breadcrumbs d-inline-block">
                <ul>
                    <li><a href="#">Dashboard</a></li>
                    <li><?php echo $page_title; ?></li>
                </ul>
            </div>
        </div>
        <div class="col-sm-6 text-right">
        </div>
    </div>
</div>

<!-- payment Type page start -->
<form action="<?php echo $action; ?>" method="post">
    <input type="hidden" name="_token" value="<?php echo $common['token']; ?>">
    <div class="panel panel-default">
        <div class="panel-body">
            <div class="customization-container">
                <div class="row text-left">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="d-block">Admin Panel Logo</label>
                            <div class="image-upload" <?php if (!empty($result['logo'])) { echo " style=\"display: none\" "; }?> >
                                <a>Upload</a>
                            </div>
                            <div class="saved-picture" <?php if (empty($result['logo'])) { echo " style=\"display: none\" "; } ?> >
                                <?php if (!empty($result['logo'])) { ?>
                                    <img class="img-thumbnail" src="../public/uploads/<?php echo $result['logo']; ?>" alt="">
                                <?php } ?>
                                <input type="hidden" name="logo" value="<?php echo $result['logo']; ?>">
                            </div>
                            <div class="saved-picture-delete" data-toggle="tooltip" data-placement="right" title="Remove" <?php if (empty($result['logo'])) { echo " style=\"display: none\" "; } ?> >
                                <a class="ti-trash"></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="d-block">Admin Panel Logo Icon</label>
                            <div class="image-upload" <?php if (!empty($result['logo_icon'])) { echo " style=\"display: none\" "; }?> >
                                <a>Upload</a>
                            </div>
                            <div class="saved-picture" <?php if (empty($result['logo_icon'])) { echo " style=\"display: none\" "; } ?> >
                                <?php if (!empty($result['logo_icon'])) { ?>
                                    <img class="img-thumbnail" src="../public/uploads/<?php echo $result['logo_icon']; ?>" alt="">
                                <?php } ?>
                                <input type="hidden" name="logo_icon" value="<?php echo $result['logo_icon']; ?>">
                            </div>
                            <div class="saved-picture-delete" data-toggle="tooltip" data-placement="right" title="Remove" <?php if (empty($result['logo_icon'])) { echo " style=\"display: none\" "; } ?> >
                                <a class="ti-trash"></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="d-block">Admin Panel Favicon</label>
                            <div class="image-upload" <?php if (!empty($result['favicon'])){echo " style=\"display: none\" ";}?> >
                                <a>Upload</a>
                            </div>
                            <div class="saved-picture" <?php if (empty($result['favicon'])) {echo " style=\"display: none\" ";}?> >
                                <?php if (!empty($result['favicon'])) { ?>
                                    <img class="img-thumbnail" src="../public/uploads/<?php echo $result['favicon']; ?>" alt="">
                                <?php } ?>
                                <input type="hidden" name="favicon" value="<?php echo $result['favicon']; ?>">
                            </div>
                            <div class="saved-picture-delete" data-toggle="tooltip" data-placement="right" title="Remove" <?php if (empty($result['favicon'])) { echo " style=\"display: none\" "; } ?> >
                                <a class="ti-trash"></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="d-block">Login background</label>
                            <div class="image-upload" <?php if (!empty($result['lg_background'])){echo " style=\"display: none\" ";}?> >
                                <a>Upload</a>
                            </div>
                            <div class="saved-picture" <?php if (empty($result['lg_background'])) {echo " style=\"display: none\" ";}?> >
                                <?php if (!empty($result['lg_background'])) { ?>
                                    <img class="img-thumbnail" src="../public/uploads/<?php echo $result['lg_background']; ?>" alt="">
                                <?php } ?>
                                <input type="hidden" name="lg_background" value="<?php echo $result['lg_background']; ?>">
                            </div>
                            <div class="saved-picture-delete" data-toggle="tooltip" data-placement="right" title="Remove" <?php if (empty($result['lg_background'])) { echo " style=\"display: none\" "; } ?> ><a class="ti-trash"></a></div>
                        </div>
                    </div>
                </div>
                <div class="customization-layout">
                    <h5 class="text-left font-20 font-500">Layout</h5>
                    <div class="layout text-left ml-2">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="custom-control custom-radio custom-radio-1 mb-3">
                                    <input type="radio" class="custom-control-input" name="layout" id="layout-wide" value="" <?php if ($result['layout'] == "") { echo "checked"; } ?>>
                                    <label class="custom-control-label font-12" for="layout-wide">Wide Layout</label>
                                </div>
                                <div class="custom-control custom-radio custom-radio-1 mb-3">
                                    <input type="radio" class="custom-control-input" name="layout" id="layout-boxed" value="boxed" <?php if ($result['layout'] == "boxed") { echo "checked"; } ?>>
                                    <label class="custom-control-label font-12" for="layout-boxed">Boxed Layout</label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="custom-control custom-radio custom-radio-1 mb-3">
                                    <input type="radio" class="custom-control-input" name="layout_fixed" id="layout-static" value="" <?php if ($result['layout_fixed'] == "") { echo "checked"; } ?>>
                                    <label class="custom-control-label font-12" for="layout-static">Static Layout</label>
                                </div>
                                <div class="custom-control custom-radio custom-radio-1 mb-3">
                                    <input type="radio" class="custom-control-input" name="layout_fixed" id="layout-fixed" value="menu-fixed page-hdr-fixed" <?php if ($result['layout_fixed'] == "menu-fixed page-hdr-fixed") { echo "checked"; } ?>>
                                    <label class="custom-control-label font-12" for="layout-fixed">Fixed Layout</label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="custom-control custom-checkbox custom-checkbox-1 mb-3">
                                    <input type="checkbox" class="custom-control-input" name="layout_menu" id="layout-collapsed" value="page-menu-small" <?php if ($result['layout_menu'] == "page-menu-small") { echo "checked"; } ?>>
                                    <label class="custom-control-label font-12" for="layout-collapsed">Collapsed Menu</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="ml-2">
                    <div class="text-left">
                        <h5 class="text-left font-20 font-500">Side Menu Background</h5>
                        <div class="custom-control custom-radio custom-radio-1 mb-3">
                            <input type="radio" class="custom-control-input" name="side-menu" id="side-menu-light" value="light" <?php if ($result['side_menu'] == "light") { echo "checked"; } ?>>
                            <label class="custom-control-label font-12" for="side-menu-light">Light Background</label>
                        </div>
                        <div class="custom-control custom-radio custom-radio-1 mb-3">
                            <input type="radio" class="custom-control-input" name="side-menu" id="side-menu-dark" value="dark" <?php if ($result['side_menu'] == "dark") { echo "checked"; } ?>>
                            <label class="custom-control-label font-12" for="side-menu-dark">Dark Background</label>
                        </div>
                    </div>
                </div>
                <div class="customization-color text-left">
                    <h5 class="text-left font-20 font-500">Header Background</h5>
                    <div>
                        <div class="customization-color-checkbox">
                            <input type="radio" name="header-color" id="light-sidebar-white" value="bg-white" <?php if ($result['header_color'] == "bg-white") { echo "checked"; } ?>>
                            <label for="light-sidebar-white" style="background-color: #fff"><i class="fas fa-check"></i></label>
                        </div>
                        <div class="customization-color-checkbox">
                            <input type="radio" name="header-color" id="light-sidebar-primary" value="page-hdr-colored bg-primary" <?php if ($result['header_color'] == "page-hdr-colored bg-primary") { echo "checked"; } ?>>
                            <label for="light-sidebar-primary" style="background-color: #3483FF"><i class="fas fa-check"></i></label>
                        </div>
                        <div class="customization-color-checkbox">
                            <input type="radio" name="header-color" id="light-sidebar-success" value="page-hdr-colored bg-success" <?php if ($result['header_color'] == "page-hdr-colored bg-success") { echo "checked"; } ?>>
                            <label for="light-sidebar-success" style="background-color: #0bc36e"><i class="fas fa-check"></i></label>
                        </div>
                        <div class="customization-color-checkbox">
                            <input type="radio" name="header-color" id="light-sidebar-secondary" value="page-hdr-colored bg-secondary" <?php if ($result['header_color'] == "page-hdr-colored bg-secondary") { echo "checked"; } ?>>
                            <label for="light-sidebar-secondary" style="background-color: #282a3c"><i class="fas fa-check"></i></label>
                        </div>
                        <div class="customization-color-checkbox">
                            <input type="radio" name="header-color" id="light-sidebar-warning" value="page-hdr-colored bg-warning" <?php if ($result['header_color'] == "page-hdr-colored bg-warning") { echo "checked"; } ?>>
                            <label for="light-sidebar-warning" style="background-color: #fec107"><i class="fas fa-check"></i></label>
                        </div>
                        <div class="customization-color-checkbox">
                            <input type="radio" name="header-color" id="light-sidebar-danger" value="page-hdr-colored bg-danger" <?php if ($result['header_color'] == "page-hdr-colored bg-danger") { echo "checked"; } ?>>
                            <label for="light-sidebar-danger" style="background-color: #fb9678"><i class="fas fa-check"></i></label>
                        </div>
                        <div class="customization-color-checkbox">
                            <input type="radio" name="header-color" id="light-sidebar-info" value="page-hdr-colored bg-info" <?php if ($result['header_color'] == "page-hdr-colored bg-info") { echo "checked"; } ?>>
                            <label for="light-sidebar-info" style="background-color: #03a9f3"><i class="fas fa-check"></i></label>
                        </div>
                        <div class="customization-color-checkbox">
                            <input type="radio" name="header-color" id="light-sidebar-dark" value="page-hdr-colored bg-dark" <?php if ($result['header_color'] == "page-hdr-colored bg-dark") { echo "checked"; } ?>>
                            <label for="light-sidebar-dark" style="background-color: #555"><i class="fas fa-check"></i></label>
                        </div>
                    </div>
                    <h5 class="text-left font-20 font-500 mt-3">Header Gradient Background</h5>
                    <div class="">
                        <div class="customization-color-checkbox">
                            <input type="radio" value="bg-white" name="header-color" id="light-gr-sidebar-white" <?php if ($result['header_color'] == "bg-white") { echo "checked"; } ?>>
                            <label for="light-gr-sidebar-white" style="background-color: #fff"><i class="fas fa-check"></i></label>
                        </div>
                        <div class="customization-color-checkbox">
                            <input type="radio" value="page-hdr-colored page-hdr-gradient bg-primary" name="header-color" id="light-gr-sidebar-primary" <?php if ($result['header_color'] == "page-hdr-colored page-hdr-gradient bg-primary") { echo "checked"; } ?>>
                            <label for="light-gr-sidebar-primary" style="background-color: #3483FF"><i class="fas fa-check"></i></label>
                        </div>
                        <div class="customization-color-checkbox">
                            <input type="radio" value="page-hdr-colored page-hdr-gradient bg-success" name="header-color" id="light-gr-sidebar-success" <?php if ($result['header_color'] == "page-hdr-colored page-hdr-gradient bg-success") { echo "checked"; } ?>>
                            <label for="light-gr-sidebar-success" style="background-color: #0bc36e"><i class="fas fa-check"></i></label>
                        </div>
                        <div class="customization-color-checkbox">
                            <input type="radio" value="page-hdr-colored page-hdr-gradient bg-secondary" name="header-color" id="light-gr-sidebar-secondary" <?php if ($result['header_color'] == "page-hdr-colored page-hdr-gradient bg-secondary") { echo "checked"; } ?>>
                            <label for="light-gr-sidebar-secondary" style="background-color: #282a3c"><i class="fas fa-check"></i></label>
                        </div>
                        <div class="customization-color-checkbox">
                            <input type="radio" value="page-hdr-colored page-hdr-gradient bg-warning" name="header-color" id="light-gr-sidebar-warning" <?php if ($result['header_color'] == "page-hdr-colored page-hdr-gradient bg-warning") { echo "checked"; } ?>>
                            <label for="light-gr-sidebar-warning" style="background-color: #fec107"><i class="fas fa-check"></i></label>
                        </div>
                        <div class="customization-color-checkbox">
                            <input type="radio" value="page-hdr-colored page-hdr-gradient bg-danger" name="header-color" id="light-gr-sidebar-danger" <?php if ($result['header_color'] == "page-hdr-colored page-hdr-gradient bg-danger") { echo "checked"; } ?>>
                            <label for="light-gr-sidebar-danger" style="background-color: #fb9678"><i class="fas fa-check"></i></label>
                        </div>
                        <div class="customization-color-checkbox">
                            <input type="radio" value="page-hdr-colored page-hdr-gradient bg-info" name="header-color" id="light-gr-sidebar-info" <?php if ($result['header_color'] == "page-hdr-colored page-hdr-gradient bg-info") { echo "checked"; } ?>>
                            <label for="light-gr-sidebar-info" style="background-color: #03a9f3"><i class="fas fa-check"></i></label>
                        </div>
                        <div class="customization-color-checkbox">
                            <input type="radio" value="page-hdr-colored page-hdr-gradient bg-dark" name="header-color" id="light-gr-sidebar-dark" <?php if ($result['header_color'] == "page-hdr-colored page-hdr-gradient bg-dark") { echo "checked"; } ?>>
                            <label for="light-gr-sidebar-dark" style="background-color: #555"><i class="fas fa-check"></i></label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="panel-footer text-center">
            <button type="submit" name="submit" class="btn btn-primary"><i class="ti-save-alt pr-2"></i> Save</button>
        </div>
    </div>
</form>
<script>

    $('body').on('change', 'input:radio[name=layout]', function () {
        var ele = $(this), ele_val = $(this).val();
        if (ele_val === "boxed") {
            $('.wrapper').addClass('boxed');
        } else {
            $('.wrapper').removeClass('boxed');
        }
    });

    $('body').on('change', 'input:radio[name=layout_fixed]', function () {
        var ele = $(this), ele_val = $(this).val();
        if (ele_val === "menu-fixed page-hdr-fixed") {
            $('#main-wrapper').addClass('menu-fixed page-hdr-fixed');
        } else {
            $('#main-wrapper').removeClass('menu-fixed page-hdr-fixed');
        }
    });

    $('body').on('change', 'input:checkbox[name=layout_menu]', function () {
        var ele = $(this), ele_val = $(this).val();
        if (ele.prop('checked') === true) {
            $('#main-wrapper').addClass('page-menu-small');
        } else {
            $('#main-wrapper').removeClass('page-menu-small');
        }
    });

    $('body').on('change', 'input:radio[name=side-menu]', function () {
        var ele = $(this), ele_val = $(this).val();
        if (ele_val === 'light') {
            $('#main-wrapper').addClass('menu-light');
        } else {
            $('#main-wrapper').removeClass('menu-light');
        }
    });

    $('body').on('change', 'input:radio[name=header-color]', function () {
        var ele = $(this), ele_val = $(this).val(), hdr = $('.page-hdr');
        hdr.removeClass('page-hdr-colored');
        hdr.removeClass('page-hdr-gradient');
        hdr.removeClass('bg-primary');
        hdr.removeClass('bg-success');
        hdr.removeClass('bg-secondary');
        hdr.removeClass('bg-warning');
        hdr.removeClass('bg-danger');
        hdr.removeClass('bg-info');
        hdr.removeClass('bg-dark');
        hdr.addClass(ele_val);
    });
</script>
<!-- Footer -->
<?php include (DIR_ADMIN.'app/views/common/footer.tpl.php'); ?>