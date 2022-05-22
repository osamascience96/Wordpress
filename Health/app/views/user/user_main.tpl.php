<?php echo $header; ?>
<div class="user-wrapper">
	<div>	
		<div class="row usr-hdr">
			<div class="col-md-3 col-lg-2 p-0">
				<div class="user-name">
					<div class="tbl-cell"><i class="far fa-user-circle"></i></div>
					<div class="tbl-cell">
						<span><?php echo $lang['text_hello']; ?></span>
						<h2><?php echo $user['name']; ?></h2>
					</div>
					<a class="user-menu-icon"><i class="fas fa-ellipsis-v"></i></a>
				</div>
				<div class="user-menu">
					<ul>
						<li class="user-appointments <?php if ($active == 'appointments') { echo 'active'; } ?>">
							<a href="<?php echo URL.DIR_ROUTE.'user/appointments'; ?>"><i class="far fa-calendar-plus"></i><?php echo $lang['text_appointments']; ?></a>
						</li>
						<li class="user-records <?php if ($active == 'records') { echo 'active'; } ?>">
							<a href="<?php echo URL.DIR_ROUTE.'user/records'; ?>"><i class="fas fa-laptop-medical"></i><?php echo $lang['text_medical_records']; ?></a>
						</li>
						<li class="user-invoices <?php if ($active == 'invoices') { echo 'active'; } ?>">
							<a href="<?php echo URL.DIR_ROUTE.'user/invoices'; ?>"><i class="far fa-money-bill-alt"></i><?php echo $lang['text_invoices']; ?></a>
						</li>
						<li class="user-request <?php if ($active == 'request') { echo 'active'; } ?>">
							<a href="<?php echo URL.DIR_ROUTE.'user/request'; ?>"><i class="fas fa-envelope-open-text"></i><?php echo $lang['text_requests']; ?></a>
						</li>
						<li class="user-profile <?php if ($active == 'profile') { echo 'active'; } ?>">
							<a href="<?php echo URL.DIR_ROUTE.'user/profile'; ?>"><i class="fas fa-user-injured"></i><?php echo $lang['text_profile']; ?></a>
						</li>
						<li class="user-change-password <?php if ($active == 'change-password') { echo 'active'; } ?>">
							<a href="<?php echo URL.DIR_ROUTE.'user/profile/password'; ?>"><i class="fas fa-unlock-alt"></i><?php echo $lang['text_change_password']; ?></a>
						</li>
						<li><a href="<?php echo URL.DIR_ROUTE.'logout'; ?>"><i class="fas fa-sign-out-alt"></i><?php echo $lang['text_logout']; ?></a></li>
					</ul>
				</div>
			</div>
			<div class="col-md-9 col-lg-10 p-0">
				<h1 class="user-ttl"><?php echo $title; ?></h1>
				<div class="user-container">
					<div class="user-body"><?php echo $user_page; ?></div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php echo $footer; ?>