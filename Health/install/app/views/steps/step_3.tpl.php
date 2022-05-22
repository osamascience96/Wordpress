<?php include DIR_APPLICATION.'app/views/common/header.tpl.php'; ?>
<div class="wrapper">
    <div class="logo mb-4">
        <img src="public/images/icon.png" alt="">
        <h1>Configuration Setup</h1>
    </div>
    <div class="form-container">
        <div class="panel panel-default mb-0">
            <div class="panel-wrapper">
                <?php if(is_dir('../install')) { ?>
                    <div class="alert alert-danger mb-3" role="alert">Do not forget to delete installation directory!</div>
                <?php } ?>
                <h4 class="mb-4">Congratulations, Your installation is done. You appointment and patient management system is ready!</h4>
            </div>
            <div class="panel-footer pl-0 pr-0 pb-0">
                <div class="text-center">
                    <a href="../" class="btn btn-outline btn-primary btn-pill btn-outline-2x m-1"><i class="fas fa-globe mr-2"></i> Go To Website</a>
                    <a href="../admin" class="btn btn-outline btn-danger btn-pill btn-outline-2x m-1"><i class="fas fa-cogs mr-2"></i> Admin Panel</a>
                </div>
            </div>
        </div>
        
    </div>
</div>
<?php include DIR_APPLICATION.'app/views/common/footer.tpl.php'; ?>
