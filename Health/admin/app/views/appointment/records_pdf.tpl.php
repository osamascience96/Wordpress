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
					</tr>
				</tbody>
			</table>
		</div>
		<div class="meta pl-30 pr-30">
			<table>
				<tbody>
					<tr class="ps-patient">
						<td class="v-aling-bottom">
							<div class="name">Name : <?php echo $result['name']; ?></div>
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
				<tbody>
					<?php foreach ($result['notes'] as $key => $value) { ?>
						<tr>
							<td style="padding: 10px; border: 0">
								<div class="title"><?php echo ucfirst($key); ?></div>
								<ul>
									<?php foreach ($value as $s_key => $s_value) { ?>
										<li class="descr"><?php echo htmlspecialchars_decode($s_value); ?></li>
									<?php } ?>
								</ul>
							</td>
						</tr>
					<?php } ?>
				</tbody>
			</table>
		</div>
	</div>
	
</body>
</html>