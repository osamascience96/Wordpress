<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title><?php echo $common['name'].' | Reset Password'; ?></title>
	<?php if (!empty($theme['favicon']) && file_exists(URL.'public/uploads/'.$theme['favicon'])) { ?>
		<link rel="icon" type="image/x-icon" href="<?php echo URL.'public/uploads/'.$theme['favicon']; ?>">
	<?php } else { ?>
		<link rel="icon" type="image/x-icon" href="<?php echo URL_ADMIN.'public/images/favicon.png'; ?>">
	<?php } ?>
	<link rel="stylesheet" href="<?php echo URL_ADMIN.'public/css/style.min.css'; ?>" />
	<script src="<?php echo URL_ADMIN.'public/js/vendor.min.js'; ?>"></script>
	<script src="<?php echo URL_ADMIN.'public/js/custom.js'; ?>"></script>
</head>
<body>
	<div class="lgn-background" style="background-image: url(../public/uploads/<?php echo $theme['lg_background']; ?>);">		
		<div class="lgn-wrapper">
			<div class="lgn-logo text-center">
				<a href="<?php echo URL_ADMIN; ?>">
					<?php if (!empty($theme['logo']) && file_exists(URL.'public/uploads/'.$theme['logo'])) { ?>
						<img src="<?php echo URL.'public/uploads/'.$theme['logo']; ?>" alt="<?php echo $common['name']; ?>">
					<?php } else { ?>
						<img src="<?php echo URL_ADMIN.'public/images/logo.png'; ?>" alt="Logo">
					<?php } ?>
				</a>
			</div>
			<div class="lgn-title">Reset Password</div>
			<div class="lgn-form">
				<form class="form-vertical" action="<?php echo $action ?>" method="post">
					<?php if(!empty($error)) { ?>
						<div class="alert alert-danger alert-dismissable">
							<?php echo $error ?>
							<a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
						</div>
					<?php } ?>
					<input type="hidden" name="_token" value="<?php echo $token; ?>">
					<input type="hidden" name="email" value="<?php echo $email; ?>">
					<input type="hidden" name="hash" value="<?php echo $hash; ?>">
					<div class="lgn-input form-group">
						<label class="control-label">New Password</label>
						<input type="password" name="new" id="lgn-new" class="form-control" placeholder="Enter your Password" autocomplete="off" required>
					</div>
					<div class="lgn-input form-group">
						<label class="control-label">Confirm Password</label>
						<input type="password" name="confirm" id="lgn-confirm" class="form-control" placeholder="Enter your confirm Password" autocomplete="off" required>
					</div>
					<div class="lgn-input form-group">
						<label class="control-label">What is <?php echo(rand(1,10)); ?> plus <?php echo(rand(1,20)); ?> =</label>
						<input type="text" id="lgn-bot" class="form-control" placeholder="Answer" autocomplete="off" required>
					</div>
					
					<div class="lgn-submit text-center">
						<button type="submit" id="reset-submit" class="btn btn-primary" name="forgot">Reset Now</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</body>
</html>


