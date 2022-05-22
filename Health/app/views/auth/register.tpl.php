<?php echo $header; ?>
<!-- Start Register Section -->
<div class="layer-stretch">
    <div class="layer-wrapper">
        <form class="form-full-container" action="<?php echo URL.DIR_ROUTE.'register'; ?>" method="post" enctype="multipart/form-data">
            <input type="hidden" name="_token" value="<?php echo $token; ?>">
            <div class="row">
                <div class="col-md-6">
                    <div class="input-box">
                        <input type="text" name="firstname" pattern="[A-Z,a-z, ]*" id="register-first-name">
                        <label for="register-first-name"><?php echo $lang['text_first_name']; ?> <em> *</em></label>
                        <span><?php echo $lang['text_name_error']; ?></span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="input-box">
                        <input type="text" name="lastname" pattern="[A-Z,a-z, ]*" id="register-last-name">
                        <label for="register-last-name"><?php echo $lang['text_last_name']; ?> <em> *</em></label>
                        <span><?php echo $lang['text_name_error']; ?></span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="input-box">
                        <input type="text" name="email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,3}$" id="register-email">
                        <label for="register-email"><?php echo $lang['text_email_address']; ?> <em> *</em></label>
                        <span><?php echo $lang['text_email_error']; ?></span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="input-box">
                        <input type="text" name="mobile" pattern="[0-9]*" id="register-mobile">
                        <label for="register-mobile"><?php echo $lang['text_mobile_number']; ?> <em> *</em></label>
                        <span><?php echo $lang['text_mobile_error']; ?></span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="input-box">
                        <input type="password" name="password" id="register-password">
                        <label for="register-password"><?php echo $lang['text_password']; ?> <em> *</em></label>
                        <span><?php echo $lang['text_password_error']; ?></span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="input-box">
                        <input type="password" name="confirmpassword" id="register-confirm-password">
                        <label for="register-confirm-password"><?php echo $lang['text_confirm_password']; ?> <em> *</em></label>
                        <span><?php echo $lang['text_password_error']; ?></span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="input-box form-bot-check">
                        <input type="number" name="bot-check" id="register-bot">
                        <label for="register-bot"><?php echo $lang['text_what_is'].' '.rand(1,10).' '.$lang['text_plus'].' '. rand(1,10); ?> = <em> *</em></label>
                        <span><?php echo $lang['text_what_is_error']; ?></span>
                    </div>
                </div>
            </div>
            <div class="login-condition text-center"><?php echo $lang['text_by__clicking_creat_Account_you_aggree_to_our']; ?> <a><?php echo $lang['text_terms_condition']; ?></a></div>
            <div class="form-submit text-center pt-3">
                <button type="submit" id="register-submit" class="btn btn-primary" name="register"><?php echo $lang['text_create_account']; ?></button>
            </div>
            <div class="login-link text-center">
                <span class="paragraph-small"><?php echo $lang['text_already_have_an_account?']; ?></span>
                <a href="<?php echo URL.DIR_ROUTE.'login'; ?>"><?php echo $lang['text_login']; ?></a>
            </div>
        </form>
    </div>
</div><!-- End Register Section -->
<?php echo $footer; ?>