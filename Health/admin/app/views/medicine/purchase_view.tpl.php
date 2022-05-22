<?php include (DIR_ADMIN.'app/views/common/header.tpl.php'); ?>
<div class="page-title">
	<div class="row align-items-center">
		<div class="col-sm-6">
			<h2 class="page-title-text d-inline-block"><?php echo $page_title; ?></h2>
			<div class="breadcrumbs d-inline-block">
				<ul>
					<li><a href="<?php echo URL_ADMIN; ?>">Dashboard</a></li>
					<li><a href="<?php echo URL_ADMIN.DIR_ROUTE.'medicine/purchase'; ?>">Purchase</a></li>
					<li><?php echo $page_title; ?></li>
				</ul>
			</div>
		</div>
		<div class="col-sm-6 text-right">
			<?php if ($page_pdf) { ?>
				<a href="<?php echo URL_ADMIN.DIR_ROUTE.'medicine/purchase/pdf&id='.$result['id']; ?>" class="btn btn-danger btn-sm" target="_blank"><i class="far fa-file-pdf mr-2"></i>PDF/Print</a>
			<?php } if ($page_edit) { ?>
				<a href="<?php echo URL_ADMIN.DIR_ROUTE.'medicine/purchase/edit&id='.$result['id']; ?>" class="btn btn-primary btn-sm"><i class="ti-pencil-alt mr-2"></i>Edit</a>
			<?php } ?>
		</div>
	</div>
</div>

<div class="inv-template mb-4">
	<div class="inv-template-bdy table-responsive p-4">
		<div class="meta table-responsive" style="border-top: 0">
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
										<td class="text w-min-130"><?php echo date_format(date_create($result['date']), $common['info']['date_format']); ?></td>
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
							<td><?php echo date_format(date_create($value['expiry']), $common['info']['date_my_format']); ?></td>
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
						<td class="value" colspan="2"><?php echo $common['info']['currency_abbr'].$result['total']; ?></td>
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