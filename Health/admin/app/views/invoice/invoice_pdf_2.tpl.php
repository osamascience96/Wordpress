<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>Invoice</title>
	<link rel="stylesheet" href="<?php echo URL_ADMIN.'public/css/inv-pdf.css'; ?>" type="text/css">
</head>
<body>
	<div class="inv-template inv-template-1">
		<div class="company pl-30 pr-30">
			<table>
				<tbody>
					<tr>
						<td class="info">
							<div class="logo"><img src="<?php echo URL.'public/uploads/'.$result['info']['logo']; ?>" alt="logo"></div>
							<div class="name"><?php echo $result['info']['legal_name']; ?></div>
							<div class="text"><?php echo $result['info']['address']['address1'].', '.$result['info']['address']['address2'].', '.$result['info']['address']['city'].', '.$result['info']['address']['country'].' - '.$result['info']['address']['postal']; ?></div>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
		<div class="strip"><p>Invoice</p></div>
		<div class="meta pl-30 pr-30">
			<table>
				<tbody>
					<tr>
						<td class="bill-to v-align-bottom">
							<div class="heading">Bill To</div>
							<div class="title"><?php echo $result['name']; ?></div>
							<div class="text"><?php echo $result['email']; ?></div>
							<div class="text"><?php echo $result['mobile']; ?></div>
						</td>
						<td class="info v-align-bottom">
							<table class="text-right">
								<tbody>
									<tr>
										<td class="text">#</td>
										<td class="text w-min-130"><?php echo $result['info']['invoice_prefix'].str_pad($result['id'], 5, '0', STR_PAD_LEFT); ?></td>
									</tr>
									<tr>
										<td class="text">Invoice Date</td>
										<td class="text w-min-130"><?php echo date_format(date_create($result['invoicedate']), $result['info']['date_format']); ?></td>
									</tr>
									<tr>
										<td class="text">Due Date</td>
										<td class="text w-min-130"><?php echo date_format(date_create($result['duedate']), $result['info']['date_format']); ?></td>
									</tr>
									<tr>
										<td class="text">Due Amount</td>
										<td class="text w-min-130"><?php echo $result['info']['currency_abbr'].$result['due']; ?></td>
									</tr>
									<tr>
										<td class="text">Payment Method</td>
										<td class="text w-min-130"><?php echo $result['method']; ?></td>
									</tr>
									<tr>
										<td class="text">Status</td>
										<td class="text w-min-130"><?php echo $result['status']; ?></td>
									</tr>
								</tbody>
							</table>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
		<div class="item pl-30 pr-30">
			<table cellspacing="0">
				<thead>
					<tr>
						<th>Item & description</th>
						<th>Qty</th>
						<th>Unit Cost</th>
						<th>Tax</th>
						<th>Price</th>
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
							<td><?php echo $result['info']['currency_abbr'].$value['cost']; ?></td>
							<td class="tax">
								<?php if (!empty($value['tax'])) { foreach ($value['tax'] as $tax_key => $tax_value) { ?>
									<div><span><?php echo $result['info']['currency_abbr'].$tax_value['tax_price']; ?></span><span><?php echo $tax_value['name']; ?></span></div>
								<?php } } ?>
							</td>
							<td><?php echo $result['info']['currency_abbr'].$value['price']; ?></td>
						</tr>
					<?php } } ?>
				</tbody>
			</table>
		</div>
		<div class="payment-total">
			<table>
				<tbody>
					<tr>
						<td class="v-align-top pr-30 pl-30"></td>
						<td class="v-align-top pr-30">
							<div class="total">
								<table cellspacing="0">
									<tbody>
										<tr>
											<td>Sub Total</td>
											<td><?php echo $result['info']['currency_abbr'].$result['subtotal']; ?></td>
										</tr>
										<tr>
											<td>Tax</td>
											<td><?php echo $result['info']['currency_abbr'].$result['tax']; ?></td>
										</tr>
										<tr>
											<td>Discount</td>
											<td><?php echo $result['info']['currency_abbr'].$result['discount_value']; ?></td>
										</tr>
										<tr>
											<td>Paid</td>
											<td><?php echo $result['info']['currency_abbr'].$result['paid']; ?></td>
										</tr>
										<tr class="main">
											<td>Total</td>
											<td><?php echo $result['info']['currency_abbr'].$result['amount']; ?></td>
										</tr>
									</tbody>
								</table>
							</div>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
		<div class="note pl-30 pr-30">
			<table>
				<tbody>
					<tr>
						<td class="block v-align-top">
							<span>Customer Note</span>
							<p><?php echo $result['note']; ?></p>
						</td>
						<td class="block v-align-top">
							<span>Terms & Conditions</span>
							<p><?php echo $result['tc']; ?></p>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
	<?php if ($printInvoice == '1') { ?>
		<script type="text/javascript"> 
			this.print(true);
		</script>
	<?php } ?>
</body>
</html>