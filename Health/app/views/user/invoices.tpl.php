<!-- Start Invoice Section -->
<?php if (!empty($invoices)) { foreach ($invoices as $key => $value) { ?>
	<div class="user-card">
		<div class="card-hdr">
			<div class="row align-items-center">
				<div class="col-lg-6">
					<a href="<?php echo URL.DIR_ROUTE.'user/invoice&id='.$value['id']; ?>" class="title" target="_blank"><?php echo $siteinfo['invoice_prefix'].str_pad($value['id'], 4, '0', STR_PAD_LEFT); ?></a>
				</div>
				<div class="col-lg-6 text-right">
					<?php if ($value['status'] == "Paid") { ?>
						<span class="label label-success"><?php echo $lang['text_paid']; ?></span>
					<?php } elseif ($value['status'] == "Unpaid") { ?>
						<span class="label label-danger"><?php echo $lang['text_unpaid']; ?></span>
					<?php } elseif ($value['status'] == "Pending") { ?>
						<span class="label label-secondary"><?php echo $lang['text_pending']; ?></span>
					<?php } elseif ($value['status'] == "In Process") { ?>
						<span class="label label-primary"><?php echo $lang['text_in_process']; ?></span>
					<?php } elseif ($value['status'] == "Cancelled") { ?>
						<span class="label label-warning"><?php echo $lang['text_cancelled']; ?></span>
					<?php } elseif ($value['status'] == "Other") { ?>
						<span class="label label-default"><?php echo $lang['text_other']; ?></span>
					<?php } elseif ($value['status'] == "Partially Paid") { ?>
						<span class="label label-info"><?php echo $lang['text_partially_paid']; ?></span>
					<?php } else { ?>
						<span class="label label-white"><?php echo $lang['text_unknown']; ?></span>
					<?php } ?>
				</div>
			</div>
		</div>
		<div class="card-body">
			<div class="row align-items-center">
				<div class="col-md-6 col-lg-3">
					<div class="icon tbl-cell">
						<i class="far fa-user-circle"></i>
					</div>
					<div class="user-info tbl-cell">
						<span><?php echo $lang['text_bill_to']; ?></span>
						<h4 class="name"><?php echo $value['name']; ?></h4>
					</div>
				</div>
				<div class="col-md-6 col-lg-3">
					<div class="info tbl-cell">
						<span><?php echo $lang['text_doctor']; ?></span>
						<p><?php echo $value['doctor']; ?></p>
					</div>
				</div>
				<div class="col-md-4 col-lg-2">
					<div class="info">
						<span><?php echo $lang['text_amount']; ?></span>
						<p><?php echo $siteinfo['currency_abbr'].$value['amount']; ?></p>
					</div>
				</div>
				<div class="col-md-4 col-lg-2">
					<div class="info">
						<span><?php echo $lang['text_paid']; ?></span>
						<p><?php if (!empty($value['paid'])) { echo $siteinfo['currency_abbr'].$value['paid']; } else { echo "0"; } ?></p>
					</div>
				</div>
				<div class="col-md-4 col-lg-2">
					<div class="info">
						<span><?php echo $lang['text_due']; ?></span>
						<p><?php echo $siteinfo['currency_abbr'].$value['due']; ?></p>
					</div>
				</div>
			</div>
		</div>
		<div class="card-ftr">
			<div class="row align-items-center">
				<div class="col-md-6">
					<span class="font-12 text-dark"><?php echo $lang['text_created_on'].' => '.date_format(date_create($value['invoicedate']), $siteinfo['date_format']); ?></span>
				</div>
				<div class="col-md-6 text-right">
					<?php if ($value['due'] > "0") { ?>
						<a href="<?php echo URL.DIR_ROUTE.'invoice/paynow&invoice='.$value['id']; ?>" class="btn btn-secondary btn-outline btn-outline-1x btn-sm mr-2"><?php echo $lang['text_pay_now']; ?></a>
					<?php } ?>
					<a href="<?php echo URL.DIR_ROUTE.'user/invoice/pdf&id='.$value['id']; ?>" class="btn btn-danger btn-outline btn-outline-1x btn-sm mr-2" target="_blank"><?php echo $lang['text_pdf_print']; ?></a>
					<a href="<?php echo URL.DIR_ROUTE.'user/invoice&id='.$value['id']; ?>" class="btn btn-primary btn-outline btn-outline-1x btn-sm"><?php echo $lang['text_view']; ?></a>
				</div>	
			</div>
		</div>
	</div>
<?php } } else { ?>
	<div class="apnt-block text-center mt-5 pt-5">
		<i class="far fa-money-bill-alt fa-5x"></i>
		<p class="font-16 mt-3 mb-3"><?php echo $lang['text_no_invoice_found']; ?></p>
	</div>
<?php } ?>
	<!-- End Invoice Section -->