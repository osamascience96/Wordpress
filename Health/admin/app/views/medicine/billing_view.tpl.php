<?php include (DIR_ADMIN.'app/views/common/header.tpl.php'); ?>
<div class="page-title">
	<div class="row align-items-center">
		<div class="col-sm-6">
			<h2 class="page-title-text d-inline-block"><?php echo $page_title; ?></h2>
			<div class="breadcrumbs d-inline-block">
				<ul>
					<li><a href="<?php echo URL_ADMIN; ?>">Dashboard</a></li>
					<li><a href="<?php echo URL_ADMIN.DIR_ROUTE.'medicine/billing'; ?>">POS/Bill</a></li>
					<li><?php echo $page_title; ?></li>
				</ul>
			</div>
		</div>
		<div class="col-sm-6 text-right">
			<?php if ($page_pdf) { ?>
				<a href="<?php echo URL_ADMIN.DIR_ROUTE.'medicine/billing/pdf&id='.$result['id']; ?>" class="btn btn-danger btn-sm mr-2" target="_blank"><i class="far fa-file-pdf mr-2"></i>PDF/Print</a>
			<?php } if ($page_edit) { ?>
				<a href="<?php echo URL_ADMIN.DIR_ROUTE.'medicine/billing/edit&id='.$result['id']; ?>" class="btn btn-primary btn-sm"><i class="far ti-pencil-alt mr-2"></i>Edit</a>
			<?php } ?>
		</div>
	</div>
</div>

<div class="inv-template mb-4">
	<div class="inv-template-bdy table-responsive p-4">
		<div class="company table-responsive">
			<table>
				<tbody>
					<tr>
						<td class="info">
							<div class="logo"><img src="../public/uploads/<?php echo $common['info']['logo']; ?>" alt="logo"></div>
							<div class="name"><?php echo $common['info']['legal_name']; ?></div>
							<div class="text"><?php echo $common['info']['address']['address1'].', '.$common['info']['address']['address2'].', '.$common['info']['address']['city'].', '.$common['info']['address']['country'].' - '.$common['info']['address']['postal']; ?></div>
						</td>
						<td class="text-right">
							<div class="title">Invoice</div>
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
							<div class="heading">Bill To</div>
							<div class="title"><?php echo $result['name']; ?></div>
							<div class="text"><?php echo $result['email']; ?></div>
							<div class="text"><?php echo $result['mobile']; ?></div>
						</td>
						<td class="info v-aling-bottom">
							<table class="text-right">
								<tbody>
									<tr>
										<td class="text">#</td>
										<td class="text w-min-130"><?php echo $common['info']['invoice_prefix'].str_pad($result['id'], 5, '0', STR_PAD_LEFT); ?></td>
									</tr>
									<tr>
										<td class="text">Date</td>
										<td class="text w-min-130"><?php echo date_format(date_create($result['date_of_joining']), $common['info']['date_format']); ?></td>
									</tr>
									<tr>
										<td class="text">Doctor</td>
										<td class="text w-min-130">Dr. <?php echo $result['doctor']; ?></td>
									</tr>
									<tr>
										<td class="text">Payment Method</td>
										<td class="text w-min-130"><?php echo $result['payment_method']; ?></td>
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
						<th>Name</th>
						<th>Batch No</th>
						<th>Expiry Date</th>
						<th>Quantity</th>
						<th>Sale Price</th>
						<th>Tax</th>
						<th>Price</th>
					</tr>
				</thead>
				<tbody>
					<?php if (!empty($result['items'])) { foreach ($result['items'] as $key => $value) { ?>
						<tr>
							<td><?php echo $value['name']; ?></td>
							<td><?php echo $value['batch_name']; ?></td>
							<td><?php echo date_format(date_create($value['expiry']), $common['info']['date_my_format']); ?></td>
							<td><?php echo $value['qty']; ?></td>
							<td><?php echo $value['saleprice']; ?></td>
							<td><?php echo $value['taxprice']; ?></td>
							<td><?php echo $value['price']; ?></td>
						</tr>
					<?php } } ?>
					<tr class="total">
						<td rowspan="5" colspan="3" class="blank">
						</td>
						<td class="title" colspan="2">Sub Total</td>
						<td class="value" colspan="2"><?php echo $common['info']['currency_abbr'].$result['subtotal']; ?></td>
					</tr>
					<tr class="total">
						<td class="title" colspan="2">Tax</td>
						<td class="value" colspan="2"><?php echo $common['info']['currency_abbr'].$result['tax']; ?></td>
					</tr>
					<tr class="total">
						<td class="title" colspan="2">Discount</td>
						<td class="value" colspan="2"><?php echo $common['info']['currency_abbr'].$result['discount_value']; ?></td>
					</tr>
					<tr class="total">
						<td class="title" colspan="2">Amount</td>
						<td class="value" colspan="2"><?php echo $common['info']['currency_abbr'].$result['amount']; ?></td>
					</tr>
				</tbody>
			</table>
		</div>
		<div class="note">
			<table>
				<tbody>
					<tr>
						<td class="block align-top">
							<span>Note</span>
							<p><?php echo $result['note']; ?></p>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
</div>

<?php include (DIR_ADMIN.'app/views/common/footer.tpl.php'); ?>