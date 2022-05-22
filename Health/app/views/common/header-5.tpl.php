<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $meta_tag; ?></title>
    <meta name="Description" content="<?php echo $meta_description; ?>">
    <link rel="icon" type="image/x-icon" href="<?php echo $favicon; ?>" />
    <?php if (empty($siteinfo['ga'])) { ?>
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
    <header>
        <div id="hdr-wrapper" class="fixed-on-scroll">
            <div class="hdr">
                <div class="tbl">
                    <div class="tbl-row">
                        <div class="tbl-cell hdr-logo p-3">
                            <a href="<?php echo URL; ?>">
                                <img src="<?php echo $logo; ?>" alt="<?php echo $siteinfo['name']; ?>">
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <!-- Header End -->