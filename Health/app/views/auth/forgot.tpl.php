<?php echo $header; ?>
<!-- Start Forgot Password Section -->
<div class="layer-wrapper">
	<form class="form-container" action="<?php echo URL.DIR_ROUTE; ?>forgot" method="post" enctype="multipart/form-data">
		<div class="login-condition text-center mb-4"><?php echo $lang['text_reset_paragraph']; ?></div>
		<input type="hidden" name="_token" value="<?php echo $token; ?>">
		<div class="input-box">
			<input type="text" name="email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,3}$" id="forgot-email">
			<label for="forgot-email"><?php echo $lang['text_email_address']; ?> <em> *</em></label>
			<span><?php echo $lang['text_email_error']; ?></span>
		</div>
		<div class="input-box form-bot-check">
			<input type="number" name="bot-check" id="forgot-bot">
			<label for="forgot-bot"><?php echo $lang['text_what_is'].' '.rand(1,10).' '.$lang['text_plus'].' '. rand(1,10); ?> = <em> *</em></label>
			<span><?php echo $lang['text_what_is_error']; ?></span>
		</div>
		<div class="form-submit text-center">
			<button type="submit" name="forgot" id="forgot-submit" class="btn btn-primary"><?php echo $lang['text_send_reset_link']; ?></button>
		</div>
		<div class="login-link text-center">
			<span class="paragraph-small"><?php echo $lang['text_already_have_an_account?']; ?></span>
			<a href="<?php echo URL.DIR_ROUTE.'login'; ?>"><?php echo $lang['text_login']; ?></a>
		</div>	
	</form>
</div><!-- End Forgot Password Section -->
<?php echo $footer; ?>