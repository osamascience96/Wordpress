<div class="row">
	<div class="col-md-8">
		<div class="user-card">
			<div class="inv-template mb-4">
				<div class="inv-template-hdr text-right">
					<?php if ($result['due'] > "0") { ?>
						<a href="<?php echo URL.DIR_ROUTE.'invoice/paynow&invoice='.$result['id']; ?>" class="btn btn-secondary btn-outline btn-outline-1x btn-sm mr-2"><?php echo $lang['text_pay_now']; ?></a>
					<?php } ?>
					<a href="<?php echo URL.DIR_ROUTE.'user/invoice/pdf&id='.$result['id']; ?>" class="btn btn-danger btn-outline btn-outline-1x btn-sm" target="_blank"><?php echo $lang['text_pdf_print']; ?></a>
				</div>
				<div class="inv-template-bdy pt-3">
					<div class="company table-responsive">
						<table>
							<tbody>
								<tr>
									<td class="info">
										<div class="logo"><img src="<?php echo URL.'public/uploads/'.$siteinfo['logo']; ?>" alt="logo"></div>
										<div class="name"><?php echo $siteinfo['legal_name']; ?></div>
										<div class="text"><?php echo $siteinfo['address']['address1'].', '.$siteinfo['address']['address2'].', '.$siteinfo['address']['city'].', '.$siteinfo['address']['country'].' - '.$siteinfo['address']['postal']; ?></div>
									</td>
									<td class="text-right">
										<div class="title"><?php echo $lang['text_invoice']; ?></div>
									</td>
								</tr>
							</tbody>
						</table>
					</div>
					<div class="meta table-responsive">
						<table>
							<tbody>
								<tr>
									<td class="bill-to v-aling-bottom">
										<div class="heading"><?php echo $lang['text_bill_to']; ?></div>
										<div class="title"><?php echo $result['name']; ?></div>
										<div class="text"><?php echo $result['email']; ?></div>
										<div class="text"><?php echo $result['mobile']; ?></div>
									</td>
									<td class="info v-aling-bottom">
										<table class="text-right">
											<tbody>
												<tr>
													<td class="text">#</td>
													<td class="text w-min-130"><?php echo $siteinfo['invoice_prefix'].str_pad($result['id'], 5, '0', STR_PAD_LEFT); ?></td>
												</tr>
												<tr>
													<td class="text"><?php echo $lang['text_invoice_date']; ?></td>
													<td class="text w-min-130"><?php echo date_format(date_create($result['invoicedate']), $siteinfo['date_format']); ?></td>
												</tr>
												<tr>
													<td class="text"><?php echo $lang['text_due_date']; ?></td>
													<td class="text w-min-130"><?php echo date_format(date_create($result['duedate']), $siteinfo['date_format']); ?></td>
												</tr>
												<tr>
													<td class="text"><?php echo $lang['text_due_amount']; ?></td>
													<td class="text w-min-130"><?php echo $siteinfo['currency_abbr'].$result['due']; ?></td>
												</tr>
												<tr>
													<td class="text"><?php echo $lang['text_payment_method']; ?></td>
													<td class="text w-min-130"><?php echo $result['method']; ?></td>
												</tr>
												<tr>
													<td class="text"><?php echo $lang['text_status']; ?></td>
													<td class="text w-min-130">
														<?php if ($result['inv_status'] == "0") { echo 'Draft'; } 
														else {
															if ($result['status'] == "Paid") { echo $lang['text_paid']; }
															elseif ($result['status'] == "Unpaid") { echo $lang['text_unpaid']; }
															elseif ($result['status'] == "Pending") { echo $lang['text_pending']; }
															elseif ($result['status'] == "In Process") { echo $lang['text_in_process']; }
															elseif ($result['status'] == "Cancelled") { echo $lang['text_cancelled']; }
															elseif ($result['status'] == "Other") { echo $lang['text_other']; }
															elseif ($result['status'] == "Partially Paid") { echo $lang['text_partially_paid']; }
															else { echo $lang['text_unknown']; } 
														} ?>
													</td>
												</tr>
											</tbody>
										</table>
									</td>
								</tr>
							</tbody>
						</table>
					</div>
					<div class="item table-responsive">
						<table>
							<thead>
								<tr>
									<th class="w-min-280"><?php echo $lang['text_item_description']; ?></th>
									<th><?php echo $lang['text_quantity']; ?></th>
									<th><?php echo $lang['text_unit_cost']; ?></th>
									<th><?php echo $lang['text_tax']; ?></th>
									<th><?php echo $lang['text_price']; ?></th>
								</tr>
							</thead>
							<tbody>
								<?php if (!empty($result['items'])) { foreach ($result['items'] as $key => $value) { ?>
									<tr>
										<td class="title">
											<p><?php echo htmlspecialchars_decode($value['name']); ?></p>
											<span><?php echo htmlspecialchars_decode($value['descr']); ?></span>
										</td>
										<td><?php echo $value['quantity']; ?></td>
										<td><?php echo $siteinfo['currency_abbr'].$value['cost']; ?></td>
										<td class="tax">
											<?php if (!empty($value['tax'])) { foreach ($value['tax'] as $tax_key => $tax_value) { ?>
												<div><span><?php echo $siteinfo['currency_abbr'].$tax_value['tax_price']; ?></span><span><?php echo $tax_value['name']; ?></span></div>
											<?php } } ?>
										</td>
										<td><?php echo $siteinfo['currency_abbr'].$value['price']; ?></td>
									</tr>
								<?php } } ?>
								<tr class="total">
									<td rowspan="5" colspan="3" class="blank">
									</td>
									<td class="title"><?php echo $lang['text_sub_total']; ?></td>
									<td class="value"><?php echo $siteinfo['currency_abbr'].$result['subtotal']; ?></td>
								</tr>
								<tr class="total">
									<td class="title"><?php echo $lang['text_tax']; ?></td>
									<td class="value"><?php echo $siteinfo['currency_abbr'].$result['tax']; ?></td>
								</tr>
								<tr class="total">
									<td class="title"><?php echo $lang['text_discount']; ?></td>
									<td class="value"><?php echo $siteinfo['currency_abbr'].$result['discount_value']; ?></td>
								</tr>
								<tr class="total">
									<td class="title"><?php echo $lang['text_total']; ?></td>
									<td class="value"><?php echo $siteinfo['currency_abbr'].$result['amount']; ?></td>
								</tr>
								<tr class="total">
									<td class="title"><?php echo $lang['text_paid']; ?></td>
									<td class="value"><?php echo $siteinfo['currency_abbr'].$result['paid']; ?></td>
								</tr>
							</tbody>
						</table>
					</div>
					<div class="note table-responsive">
						<table>
							<tbody>
								<tr>
									<td class="block align-top">
										<span><?php echo $lang['text_customer_note']; ?></span>
										<p><?php echo $result['note']; ?></p>
									</td>
									<td class="block align-top">
										<span><?php echo $lang['text_terms_condition']; ?></span>
										<p><?php echo $result['tc']; ?></p>
									</td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="col-md-4">
		<div class="user-card">
			<div class="card-hdr"><?php echo $lang['text_payments_history']; ?></div>
			<div class="card-body">
				<table class="table table-bordered table-striped font-12">
					<thead>
						<tr>
							<td><?php echo $lang['text_date']; ?></td>
							<td><?php echo $lang['text_payment_method']; ?></td>
							<td><?php echo $lang['text_amount']; ?></td>
						</tr>
					</thead>
					<tbody>
						<?php $total  = 0; if (!empty($payments)) { foreach ($payments as $key => $value) { ?>
							<tr>
								<td><?php echo date_format(date_create($value['payment_date']), $siteinfo['date_format']); ?></td>
								<td><?php if (!empty($value['method_name'])) { echo $value['method_name']; } else { echo "Paypal"; } ?></td>
								<td><?php echo $siteinfo['currency_abbr'].$value['amount']; ?></td>
							</tr>
							<?php $total = $total + $value['amount']; } ?>
							<tr>
								<td colspan="2" class="text-right"><?php echo $lang['text_total']; ?></td>
								<td><?php echo $siteinfo['currency_abbr'].$total ; ?></td>
							</tr>
						<?php } else { ?>
							<tr>
								<td colspan="3" class="text-center"><?php echo $lang['text_no_data_found']; ?></td>
							</tr>
						<?php } ?>
					</tbody>
				</table>
			</div>
		</div>
		<div class="user-card">
			<div class="card-hdr">Attachements</div>
			<div class="card-body">
				<?php if (!empty($attachments)) { ?>
					<div class="document-container">
						<?php foreach ($attachments as $key => $value) {
							$file_ext = pathinfo($value['file'], PATHINFO_EXTENSION); ?>
							<div class="block">
								<div class="document">
									<?php if ($file_ext == "pdf") { ?>
										<a href="<?php echo URL.'public/uploads/attachments/'.$value['file']; ?>" class="record-pdf" title="<?php echo $value['name']; ?>"><i class="far fa-file-pdf"></i></a>
									<?php } else { ?>
										<a data-fancybox="gallery" href="<?php echo URL.'public/uploads/attachments/'.$value['file']; ?>" class="record-image">
											<img src="<?php echo URL.'public/uploads/attachments/'.$value['file']; ?>" alt="Documents">
										</a>
									<?php } ?>
								</div>
							</div>
						<?php } ?>
					</div>
				<?php } ?>
			</div>
		</div>
	</div>
</div>
