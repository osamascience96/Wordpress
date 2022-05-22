<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Coming soon</title>
	<link rel="stylesheet" href="public/fonts/font-awesome/css/all.min.css" />
	<link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Dosis:400,500,700">
	<style>
		body {
			margin: 0;
			padding: 0;
			width: 100%;
			max-width: 900px;
			margin: 0 auto;
			height: 100%;
			font-family: "Dosis", sans-serif;
			font-size: 12px;
			color: #555;
			background: #fafafa;
		}
		.notfound-wrapper {
			text-align: center;
			margin: 100px 0 0 0;
		}
		.notfound-wrapper h1 {
			font-size: 100px;
			text-transform: uppercase;
			color: #F09E71;
			letter-spacing: 2px;
			font-weight: bold;
			display: block;
			margin: 10px 0;
		}
		.notfound-wrapper p {
			font-size: 36px;
			text-transform: uppercase;
			color: #333;
			margin: 10px 0;
			font-weight: 600;
		}
		.notfound-wrapper span {
			display: block;
			font-size: 32px;
			color: #555;
			margin: 10px 0;
		}
		.notfound-wrapper a {
			display: block;
			font-size: 32px;
			color: #32c1ce;
			margin: 30px 0;
		}
		.social {
			display: block;
			width: 100%;
			position: relative;
			margin: 30px auto;
			text-align: center;
		}
		.social a {
			display: inline-block;
			width: 48px;
			height: 48px;
			line-height: 48px;
			font-size: 28px;
			color: #FFF;
			text-decoration: none;
			background: #999;
			margin: 10px;
			border-radius: 2px;
		}
		.social a:hover {
			background: #32c1ce;
		}
	</style>
</head>
<body>
	<div class="notfound-wrapper">
		<h1><?php echo $lang['text_coming_soon']; ?></h1>
		<p><?php echo $lang['text_briefly_unavailable_for_scheduled_maintenance']; ?></p>
		<span><?php echo $lang['text_check_back_after_some_time']; ?></span>
		<div class="social">
			<?php if (!empty($social)) { foreach ($social as $key => $value) { ?>
			<a href="<?php echo $value; ?>" target="_blank"><i class="fab fa-<?php echo $key; ?>"></i></a>
			<?php } } ?>
		</div>
	</div>
</body>
</html>