<?php echo $header; ?>
<div class="layer-stretch">
	<div class="layer-wrapper">
		<div class="panel panel-default">
			<div class="panel-head d-none">
				<div class="panel-title text-center">
					<span class="panel-title-text"><?php echo $lang['text_cancelled']; ?></span>
				</div>
			</div>
			<div class="panel-body text-center p-5">
				<p class="font-24"><?php echo $lang['text_cancel_message']; ?></p>
				<?php if (isset($payment_message)) { ?>
					<p class="font-18"><?php echo $payment_message; ?></p>
				<?php } ?>
			</div>
			<div class="panel-footer text-center">
				<a href="<?php echo URL.DIR_ROUTE.'home'; ?>" class="btn btn-outline btn-primary btn-pill btn-outline-1x"><?php echo $lang['text_home']; ?></a>
				<a href="<?php echo URL.DIR_ROUTE.'contact'; ?>" class="btn btn-outline btn-secondary btn-pill btn-outline-1x mr-2 ml-2"><?php echo $lang['text_contact']; ?></a>
				<a href="<?php echo URL.DIR_ROUTE.'user/invoices'; ?>" class="btn btn-outline btn-warning btn-pill btn-outline-1x"><?php echo $lang['text_my_invoices']; ?></a>
			</div>
		</div>
	</div>
</div>
<?php echo $footer; ?>