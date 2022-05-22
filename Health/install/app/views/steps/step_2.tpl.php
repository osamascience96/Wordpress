<?php include DIR_APPLICATION.'app/views/common/header.tpl.php'; ?>
<div class="wrapper">
    <div class="logo mb-4">
        <img src="public/images/icon.png" alt="">
        <h1>Configuration Setup</h1>
    </div>
    <div class="container">
        <form action="<?php echo $action; ?>" class="form-full-container" method="post">
            <div class="panel panel-default mb-0">
                <div class="panel-wrapper">
                    <?php if (!empty($error)) { ?>
                        <div class="alert alert-danger" role="alert">Please enter valid <?php echo $error; ?></div>
                    <?php } ?>
                    <div class="db-form">
                        <h3 class="font-16 font-weight-bold mb-4">1. Please enter your database credentials.</h3>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="input-box">
                                    <input type="text" name="db_name" id="db-name" required>
                                    <label for="db-name">Database Name<em> *</em></label>
                                    <span>Please Enter Valid Database Name!</span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="input-box">
                                    <input type="text" name="db_username" id="db-username" required>
                                    <label for="db-username">Database Username<em> *</em></label>
                                    <span>Please Enter Valid Database Username!</span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="input-box">
                                    <input type="text" name="db_password" id="db-password" required>
                                    <label for="db-password">Database Password<em> *</em></label>
                                    <span>Please Enter Valid Database Password!</span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="input-box">
                                    <input type="text" name="db_hostname" value="localhost" id="db-hostname" required>
                                    <label for="db-hostname">Database Hostname<em> *</em></label>
                                    <span>Please Enter Valid Hostname!</span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="input-box">
                                    <input type="text" name="db_prefix" value="kk_" id="db-prefix" required>
                                    <label for="db-prefix">Table Prefix<em> *</em></label>
                                    <span>Please Enter Valid Table Prefix!</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="clinic-form">
                        <h3 class="font-14 font-weight-bold mb-4">2. Please enter clinic information.</h3>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="input-box">
                                    <input type="text" name="name" id="clinic-name" required>
                                    <label for="clinic-name">Clinic Name or Site Name<em> *</em></label>
                                    <span>Please Enter Name!</span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="input-box">
                                    <input type="text" name="email" id="clinic-email" required>
                                    <label for="clinic-email">Clinic Email Address<em> *</em></label>
                                    <span>Please Enter Valid Email Address!</span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="input-box">
                                    <input type="text" name="phone" id="clinic-phone" required>
                                    <label for="clinic-phone">Clinic Phone Number<em> *</em></label>
                                    <span>Please Enter Valid Phone Number!</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="user-form">
                        <h3 class="font-14 font-weight-bold mb-4">3. Please enter admin user credentials for admin panel.</h3>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="input-box">
                                    <input type="text" name="firstname" id="user-firstname" required>
                                    <label for="user-firstname">First Name<em> *</em></label>
                                    <span>Please Enter Valid First Name!</span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="input-box">
                                    <input type="text" name="lastname" id="user-lastname" required>
                                    <label for="user-lastname">Last Name<em> *</em></label>
                                    <span>Please Enter Valid Last Name!</span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="input-box">
                                    <input type="text" name="usermail" id="user-email" required>
                                    <label for="user-email">Email Address<em> *</em></label>
                                    <span>Please Enter Valid Email Address!</span>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="input-box">
                                    <input type="text" name="username" id="user-username" required>
                                    <label for="user-username">Username<em> *</em></label>
                                    <span>Please Enter Valid username!</span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="input-box">
                                    <input type="password" name="password" id="user-password" required>
                                    <label for="user-password">Password<em> *</em></label>
                                    <span>Please Enter Valid Password(Min 8 Characters)!</span>
                                </div>
                            </div>
                            <div class="col-md-4"></div>
                        </div>
                    </div>
                </div>
                <div class="panel-footer pl-0 pr-0 pb-0">
                    <div class="row">
                        <div class="col-6">
                            <a class="btn btn-default back" href="index.php?route=install/1">Back</a>
                        </div>
                        <div class="col-6 text-right">
                            <button type="submit" id="install-submit" name="submit" class="btn btn-primary">Run Installation</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<?php include DIR_APPLICATION.'app/views/common/footer.tpl.php'; ?>