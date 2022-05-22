<?php include DIR_APPLICATION.'app/views/common/header.tpl.php'; ?>
<div class="wrapper">
    <div class="logo mb-4">
        <img src="public/images/icon.png" alt="">
        <h1>Pre Installation</h1>
    </div>
    <div class="form-container">
        <div class="panel panel-default mb-0">
            <div class="panel-wrapper">
                <p class="font-16">
                    Welcome to klinikal. Before we proceed, we need some information on the database. You will need to know the following items before proceeding.
                </p>
                <ul class="font-16">
                    <li>1. Database name</li>
                    <li>2. Database username</li>
                    <li>3. Database password</li>
                    <li>4. Database host</li>
                </ul>
                <p class="font-16">
                    We’re going to use this information to create a configuration file.	If for any reason this automatic installer doesn’t work, don’t worry. You can go for manual process which is described in documentation.
                    Need more help? <a href="http://www.pepdev.com" class="text-secondary" target="_blank">Live Support</a>
                </p>
            </div>
            <div class="panel-footer pl-0 pr-0 pb-0 text-right">
                <a class="btn btn-outline btn-primary btn-pill btn-outline-2x m-1" href="index.php?route=step_2"><i class="fas fa-hourglass-start mr-2"></i>let's Start</a>
            </div>
        </div>
    </div>
</div>
<?php include DIR_APPLICATION.'app/views/common/footer.tpl.php'; ?>