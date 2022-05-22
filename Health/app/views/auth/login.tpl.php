<?php echo $header; ?>
<!-- Start Login Section -->
<div class="layer-stretch">
    <div class="layer-wrapper">
        <form class="form-container" action="<?php echo URL.DIR_ROUTE; ?>login" method="post" enctype="multipart/form-data">
            <input type="hidden" name="_token" value="<?php echo $token; ?>">
            <div class="input-box">
                <input type="text" name="email" id="login-email" required>
                <label for="login-email"><?php echo $lang['text_email_address']; ?> <em> *</em></label>
                <span class=""><?php echo $lang['text_email_error']; ?></span>
            </div>
            <div class="input-box">
                <input type="password" name="password" id="login-password" required>
                <label for="login-password"><?php echo $lang['text_password']; ?> <em> *</em></label>
                <span><?php echo $lang['text_password_error']; ?></span>
                <a href="<?php echo URL.DIR_ROUTE.'forgot'; ?>" class="forgot-pass"><?php echo $lang['text_forgot_password']; ?>?</a>
            </div>
            <div class="input-box form-bot-check">
                <input class="" type="number" name="bot-check" id="login-bot" required>
                <label class="" for="login-bot"><?php echo $lang['text_what_is'].' '.rand(1,10).' '.$lang['text_plus'].' '. rand(1,10); ?> = <em> *</em></label>
                <span><?php echo $lang['text_what_is_error']; ?></span>
            </div>
            <div class="form-submit text-center">
                <button type="submit" name="login" id="login-submit" class="btn btn-primary"><?php echo $lang['text_login']; ?></button>
            </div>
            <div class="login-link text-center">
                <span class="paragraph-small"><?php echo $lang['text_do_not_have_an_account?']; ?></span>
                <a href="<?php echo URL.DIR_ROUTE.'register'; ?>"><?php echo $lang['text_register_as_new_user']; ?></a>
            </div>
        </form>
    </div>
</div><!-- End Login Section -->
<?php echo $footer; ?>