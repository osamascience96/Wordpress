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
							<div class="name"><?php echo 'Dr. '.$result['doctor']; ?></div>
							<div class="text"><?php echo $common['address']['address1'].', '.$common['address']['address2'].', '.$common['address']['city'].', '.$common['address']['country'].' - '.$common['address']['postal']; ?></div>
							<div class="text">Phone Number : <?php echo $common['phone']; ?></div>
						</td>
						<td class="text-right">
							<div class="title">Prescrition</div>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
		<div class="meta pl-30 pr-30">
			<table>
				<tbody>
					<tr class="ps-patient">
						<td class="v-aling-bottom">
							<div class="name">Name : <?php echo $result['patient']; ?></div>
						</td>
						<td class="v-aling-bottom">
							<div class="date text-right">Date : <?php echo date_format(date_create($result['date_of_joining']), $common['date_format']); ?></div>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
		<div class="item pl-30 pr-30">
			<table>
				<thead>
					<tr>
						<th>Medicine Name</th>
						<th>Dose</th>
						<th>Duration</th>
						<th>Instruction</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($result['prescription'] as $key => $value) { ?>
						<tr>
							<td>
								<div class="title"><?php echo $value['name']; ?></div>
								<div class="generic"><?php echo htmlspecialchars_decode($value['generic']); ?></div>
							</td>
							<td><p><?php echo $value['dose']; ?></p></td>
							<td><p><?php echo $value['duration'].' Day'; ?></p></td>
							<td><p><?php echo $value['instruction']; ?></p></td>
						</tr>
					<?php } ?>
				</tbody>
			</table>
		</div>
	</div>
	
</body>
</html>