<?php include DIR_APPLICATION.'app/views/common/header.tpl.php'; ?>
<div class="wrapper">
    <div class="logo mb-4">
        <img src="public/images/icon.png" alt="">
        <h1>Pre Installation</h1>
    </div>
    <div class="form-container">
        <div class="panel panel-default mb-0">
            <div class="panel-wrapper">
                <p class="text-danger text-center mb-0"><?php echo $error; ?></p>
            </div>
        </div>
    </div>
</div>
<?php include DIR_APPLICATION.'app/views/common/footer.tpl.php'; ?>