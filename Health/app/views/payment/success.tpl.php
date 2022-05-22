<?php echo $header; ?>
	<div class="layer-stretch">
		<div class="layer-wrapper">
			<div class="panel panel-default mb-0">
				<div class="panel-head d-none">
					<div class="panel-title text-center">
						<span class="panel-title-text"><?php echo $lang['text_thank_you_message']; ?></span>
					</div>
				</div>
				<div class="panel-wrapper">
					<div class="panel-body text-center">
						<div class="font-16"><?php echo $lang['text_thank_you_message']; ?></div>
						<div class="font-20">
							<p><?php echo $lang['text_transaction_id'].' - '.$txn_id; ?></p>
							<div>
								<a href="<?php echo URL.DIR_ROUTE.'home'; ?>" class="btn btn-outline btn-primary btn-pill btn-outline-1x mr-3"><?php echo $lang['text_home']; ?></a>
								<a href="<?php echo URL.DIR_ROUTE.'user/invoices'; ?>" class="btn btn-outline btn-warning btn-pill btn-outline-1x"><?php echo $lang['text_my_invoices']; ?></a>
							</div>
							<p class="font-12 mt-4"><?php echo $lang['text_thank_you_for_being_loyal_customer']; ?></p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php echo $footer; ?>