<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title><?php echo $meta_title; ?></title>
	<link rel="stylesheet" href="<?php echo URL_ADMIN.'public/css/inv-pdf.css'; ?>" type="text/css">
</head>
<body>
	<div class="inv-template">
		<div class="company pl-30 pr-30">
			<table>
				<tbody>
					<tr>
						<td class="info">
							<div class="logo"><img src="<?php echo URL.'public/uploads/'.$common['logo']; ?>" alt="logo"></div>
							<div class="name"><?php echo $common['name']; ?></div>
							<div class="text"><?php echo $common['address']['address1'].', '.$common['address']['address2'].', '.$common['address']['city'].', '.$common['address']['country'].' - '.$common['address']['postal']; ?></div>
							<div class="text">Phone Number : <?php echo $common['phone']; ?></div>
						</td>
						<td class="text-right">
							<div class="title">Death Records</div>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
		<div class="meta table-responsive pl-30 pr-30">
			<table>
				<tbody>
					<tr>
						<td class="bill-to">
							<div class="title">Dr. <?php echo $result['doctor_name']; ?></div>
						</td>
						<td class="bill-to text-right">
							<div class="text">Date => <?php echo date_format(date_create($result['date_of_joining']), $common['date_format']); ?></div>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
		<div class="item pl-30 pr-30">
			<table>
				<thead>
					<tr>
						<th></th>
						<th></th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>Paitent Name</td>
						<td class="font-500"><?php echo $result['name']; ?></td>
					</tr>
					<tr>
						<td>Death DateTime</td>
						<td class="font-500"><?php echo date_format(date_create($result['date']), $common['date_format']).' '.$result['time']; ?></td>
					</tr>
					<tr>
						<td>Gender</td>
						<td class="font-500"><?php echo $result['gender']; ?></td>
					</tr>
					<tr>
						<td>Guardian Name</td>
						<td class="font-500"><?php echo $result['guardian_name'].' ( '.$result['guardian_email']. ', ' . $result['guardian_mobile'].' )'; ?></td>
					</tr>
					<tr>
						<td>Report/Remark</td>
						<td class="font-500"><?php echo html_entity_decode($result['remark'], ENT_QUOTES | ENT_XML1, 'UTF-8'); ?></td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
	
</body>
</html>