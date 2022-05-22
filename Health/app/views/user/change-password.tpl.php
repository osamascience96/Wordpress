<?php echo $header; ?>
<div class="layer-stretch">
	<div class="layer-wrapper">
		<form class="form-container" action="<?php echo URL.DIR_ROUTE; ?>profile/changepassword" method="post" enctype="multipart/form-data">
			<input type="hidden" name="_token" value="<?php echo $token; ?>">
			<input type="hidden" name="email" value="<?php echo $email; ?>">
			<input type="hidden" name="hash" value="<?php echo $hash; ?>">
			<div class="input-box">
				<input type="password" name="password" id="changepassword">
				<label for="change-password"><?php echo $lang['text_password'] ?> <em>*</em></label>
				<span><?php echo $lang['text_password_error'] ?></span>
			</div>
			<div class="input-box">
				<input type="password" name="confirmpassword" id="changepassword-confirm">
				<label for="change-password-confirm"><?php echo $lang['text_confirm_password'] ?> <em>*</em></label>
				<span><?php echo $lang['text_password_error'] ?></span>
			</div>
			<div class="input-box form-bot-check">
				<input type="number" name="bot-check" id="login-bot">
				<label for="login-bot"><?php echo $lang['text_what_is'].' '.rand(1,10).' '.$lang['text_plus'].' '. rand(1,10); ?> = <em> *</em></label>
				<span><?php echo $lang['text_what_is_error']; ?></span>
			</div>
			<div class="form-submit">
				<button type="submit" name="submit" id="changepassword-submit" class="btn btn-primary"><?php echo $lang['text_change_password']; ?></button>
			</div>
		</form>
	</div>
</div>
<?php echo $footer; ?>