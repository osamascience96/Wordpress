<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>Purchase</title>
	<link rel="stylesheet" href="<?php echo URL_ADMIN.'public/css/inv-pdf.css'; ?>" type="text/css">
</head>
<body>
	<div class="inv-template">
		<div class="meta pl-30 pr-30" style="border-top: 0">
			<table>
				<tbody>
					<tr>
						<td class="bill-to v-aling-bottom">
							<div class="heading">Supplier</div>
							<div class="title"><?php echo $result['name']; ?></div>
							<div class="text"><?php echo $result['email']; ?></div>
							<div class="text"><?php echo $result['phone']; ?></div>
						</td>
						<td class="info v-aling-bottom">
							<table class="text-right">
								<tbody>
									<tr>
										<td class="text">#</td>
										<td class="text w-min-130"><?php echo str_pad($result['id'], 5, '0', STR_PAD_LEFT); ?></td>
									</tr>
									<tr>
										<td class="text">Purchase Date</td>
										<td class="text w-min-130"><?php echo date_format(date_create($result['date']), $result['info']['date_format']); ?></td>
									</tr>
								</tbody>
							</table>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
		<div class="item pl-30 pr-30">
			<table>
				<thead>
					<tr>
						<th>Name</th>
						<th>Batch No</th>
						<th>Expiry Date</th>
						<th>Packing Qty</th>
						<th>Quantity</th>
						<th>Purchase Price</th>
						<th>Sale Price</th>
						<th>Tax</th>
						<th>Price</th>
					</tr>
				</thead>
				<tbody>
					<?php if (!empty($batches)) { foreach ($batches as $key => $value) { ?>
						<tr>
							<td><?php echo $value['name']; ?></td>
							<td><?php echo $value['batch']; ?></td>
							<td><?php echo date_format(date_create($value['expiry']), $result['info']['date_my_format']); ?></td>
							<td><?php echo $value['pqty']; ?></td>
							<td><?php echo $value['qty']; ?></td>
							<td><?php echo $value['purchaseprice']; ?></td>
							<td><?php echo $value['saleprice']; ?></td>
							<td><?php echo $value['taxprice']; ?></td>
							<td><?php echo $value['price']; ?></td>
						</tr>
					<?php } } ?>
					<tr class="total">
						<td rowspan="5" colspan="5" class="blank">
						</td>
						<td class="title" colspan="2">Sub Total</td>
						<td class="value" colspan="2"><?php echo $result['info']['currency_abbr'].$result['total']; ?></td>
					</tr>
					<tr class="total">
						<td class="title" colspan="2">Tax</td>
						<td class="value" colspan="2"><?php echo $result['info']['currency_abbr'].$result['tax']; ?></td>
					</tr>
					<tr class="total">
						<td class="title" colspan="2">Discount</td>
						<td class="value" colspan="2"><?php echo $result['info']['currency_abbr'].$result['discount_value']; ?></td>
					</tr>
					<tr class="total">
						<td class="title" colspan="2">Amount</td>
						<td class="value" colspan="2"><?php echo $result['info']['currency_abbr'].$result['amount']; ?></td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
	
</body>
</html>