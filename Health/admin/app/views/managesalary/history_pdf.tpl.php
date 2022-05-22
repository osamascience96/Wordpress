<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>Invoice</title>
	<link rel="stylesheet" href="<?php echo URL_ADMIN.'public/css/inv-pdf.css'; ?>" type="text/css">
</head>
<body>
	<div class="inv-template">
		<div class="company pl-30 pr-30">
			<table>
				<tbody>
					<tr>
						<td class="info">
							<div class="logo"><img src="<?php echo URL.'public/uploads/'.$result['info']['logo']; ?>" alt="logo"></div>
							<div class="name"><?php echo $result['info']['legal_name']; ?></div>
							<div class="text"><?php echo $result['info']['address']['address1'].', '.$result['info']['address']['address2'].', '.$result['info']['address']['city'].', '.$result['info']['address']['country'].' - '.$result['info']['address']['postal']; ?></div>
						</td>
						<td class="text-right"></td>
					</tr>
				</tbody>
			</table>
		</div>
		<div class="meta pl-30 pr-30">
			<table>
				<tbody>
					<tr>
						<td class="bill-to v-aling-bottom">
							<div class="title"><?php echo $result['firstname'].' '.$result['lastname']; ?></div>
							<div class="text"><?php echo $result['email']; ?></div>
							<div class="text"><?php echo $result['mobile']; ?></div>
						</td>
						<td class="info v-aling-bottom">
							<table class="text-right">
								<tbody>
									<tr>
										<td>Salary Grades</td>
										<td><?php echo $result['salarytemplate']['grade']; ?></td>
									</tr>
									<tr>
										<td>Basic Salary</td>
										<td><?php echo $result['info']['currency_abbr'].$result['salarytemplate']['basic_salary']; ?></td>
									</tr>
									<tr>
										<td>Month</td>
										<td><?php echo date_format(date_create($result['month_year']), $result['info']['date_my_format']); ?></td>
									</tr>
									<tr>
										<td>Date</td>
										<td><?php echo date_format(date_create($result['date_of_joining']), $result['info']['date_format']); ?></td>
									</tr>
									<tr>
										<td>Payment Method</td>
										<td><?php echo $result['payment_method']; ?></td>
									</tr>
								</tbody>
							</table>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
		<div class="item pl-30 pr-30">
			<div style="display: inline-block; vertical-align: top; width: 48%; margin-right: 3%">
				<table>
					<thead>
						<tr>
							<th colspan="2">Allowances</th>
						</tr>
					</thead>
					<tbody>
						<?php if (!empty($result['salarytemplate']['allowance'])) { foreach ($result['salarytemplate']['allowance'] as $key => $value) { ?>
						<tr>
							<td><?php echo $value['label']; ?></td>
							<td><?php echo $result['info']['currency_abbr'].$value['value']; ?></td>
						</tr>
						<?php } } ?>
					</tbody>
				</table>
			</div>
			<div style="display: inline-block; vertical-align: top; width: 48%;">
				<table>
					<thead>
						<tr>
							<th colspan="2">Deductions</th>
						</tr>
					</thead>
					<tbody>
						<?php if (!empty($result['salarytemplate']['deduction'])) { foreach ($result['salarytemplate']['deduction'] as $key => $value) { ?>
						<tr>
							<td><?php echo $value['label']; ?></td>
							<td><?php echo $result['info']['currency_abbr'].$value['value']; ?></td>
						</tr>
						<?php } } ?>
					</tbody>
				</table>
			</div>
		</div>
		<div class="item pl-30 pr-30">
			<div style="display: inline-block; vertical-align: top; width: 29%;">
			</div>
			<div style="display: inline-block; vertical-align: top; width: 70%">
				<table>
					<thead>
						<tr>
							<th colspan="2">Total Salary Details</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>Gross Salary</td>
							<td><?php echo $result['info']['currency_abbr'].$result['salarytemplate']['gross_salary']; ?></td>
						</tr>
						<tr>
							<td>Total Deduction</td>
							<td><?php echo $result['info']['currency_abbr'].$result['salarytemplate']['total_deduction']; ?></td>
						</tr>
						<tr>
							<td>Net Salary</td>
							<td><?php echo $result['info']['currency_abbr'].$result['salarytemplate']['net_salary']; ?></td>
						</tr>
						<tr>
							<td>Advance</td>
							<td><?php echo $result['info']['currency_abbr'].$result['advance']; ?></td>
						</tr>
						<tr>
							<td>Deduction</td>
							<td><?php echo $result['info']['currency_abbr'].$result['deduction']; ?></td>
						</tr>
						<tr>
							<td class="text-dark font-500">Payment Amount</td>
							<td class="text-primary"><?php echo $result['info']['currency_abbr'].$result['amount']; ?></td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</body>
</html>