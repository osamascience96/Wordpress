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
							<div class="title">Birth Records</div>
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
							<div class="name">Dr. <?php echo $result['doctor_name']; ?></div>
						</td>
						<td class="v-aling-bottom">
							<div class="date text-right">Date => <?php echo date_format(date_create($result['date_of_joining']), $common['date_format']); ?></div>
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
						<td>Mother Name</td>
						<td><?php echo $result['mother_name']; ?></td>
					</tr>
					<tr>
						<td>Father Name</td>
						<td><?php echo $result['father_name']; ?></td>
					</tr>
					<tr>
						<td>Child Name</td>
						<td><?php echo $result['child']; ?></td>
					</tr>
					<tr>
						<td>Birth DateTime</td>
						<td><?php echo date_format(date_create($result['date']), $common['date_format']).' '.$result['time']; ?></td>
					</tr>
					<tr>
						<td>Gender</td>
						<td><?php echo $result['gender']; ?></td>
					</tr>
					<tr>
						<td>Weight</td>
						<td><?php echo $result['weight']; ?></td>
					</tr>
					<tr>
						<td>Height</td>
						<td><?php echo $result['height']; ?></td>
					</tr>
					<tr>
						<td>Report/Remark</td>
						<td><?php echo html_entity_decode($result['remark'], ENT_QUOTES | ENT_XML1, 'UTF-8'); ?></td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
	
</body>
</html>