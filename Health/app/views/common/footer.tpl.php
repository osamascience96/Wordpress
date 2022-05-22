	<!-- Start of Time Table Section -->
	<div id="tt" class="animated-wrapper">
		<div class="layer-stretch">
			<div class="layer-wrapper">
				<div class="layer-ttl">
					<h3 class="animated animated-down"><?php echo $footer['timetable']['title']; ?></h3>
				</div>
				<div class="layer-container">
					<?php if (!empty($footer['timetable']['timing'])) { foreach ($footer['timetable']['timing'] as $key => $value) { ?>
						<div class="tt-block animated animated-up">
							<p><i class="far fa-calendar-plus"></i><span><?php echo $lang['text_'.$key]; ?></span></p>
							<p><i class="fas fa-hourglass-half"></i><span><?php echo $value; ?></span></p>
							<p>
								<?php if ( $whocan['appointment'] ) { ?>
									<a href="<?php echo URL.DIR_ROUTE."makeanappointment"; ?>" class="btn btn-primary"><?php echo $lang['text_make_an_appointment']; ?></a>
								<?php } else { ?>
									<a href="<?php echo URL.DIR_ROUTE."login"; ?>" class="btn btn-primary"><?php echo $lang['text_make_an_appointment']; ?></a>
								<?php } ?>
							</p>
						</div>
					<?php } } ?>
				</div>
			</div>
		</div>
	</div><!-- End of Time Table Section -->
	<!-- Start of Emergency Section -->
	<div id="emergency">
		<div class="layer-stretch">
			<div class="layer-wrapper animated-wrapper">
				<div class="layer-ttl">
					<h3 class="animated animated-down"><?php echo $footer['emergency']['title']; ?></h3>
				</div>
				<div class="layer-container">
					<div class="paragraph-medium paragraph-black animated animated-up"><?php echo $footer['emergency']['description']; ?></div>
					<div class="emergency-number"><?php echo $lang['text_call']. ' : ' .$siteinfo['emergency']; ?></div>
				</div>
			</div>
		</div>
	</div><!-- End of Emergency Section -->
	<!-- Start of Footer Section -->
	<footer id="footer">
		<div class="layer-stretch">
			<div class="row layer-wrapper">
				<div class="col-md-4 footer-block">
					<div class="footer-ttl">
						<p><?php echo $lang['text_basic_info']; ?></p>
					</div>
					<div class="footer-container footer-a">
						<div class="tbl">
							<div class="tbl-row">
								<div class="tbl-cell"><i class="far fa-map"></i></div>
								<div class="tbl-cell">
									<p class="paragraph-medium paragraph-white"><?php echo implode(', ', $siteinfo['address']); ?></p>
								</div>
							</div>
							<div class="tbl-row">
								<div class="tbl-cell"><i class="fas fa-mobile-alt"></i></div>
								<div class="tbl-cell">
									<p class="paragraph-medium paragraph-white"><?php echo $siteinfo['phone']; ?></p>
								</div>
							</div>
							<div class="tbl-row">
								<div class="tbl-cell"><i class="far fa-envelope-open"></i></div>
								<div class="tbl-cell">
									<p class="paragraph-medium paragraph-white"><?php echo $siteinfo['mail']; ?></p>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-4 footer-block">
					<div class="footer-ttl">
						<p><?php echo $lang['text_quick_links']; ?></p>
					</div>
					<div class="footer-container footer-b">
						<div class="tbl">
							<div class="tbl-row">
								<ul class="tbl-cell">
									<?php if (!empty($footer['footermenu'])) { echo $footer['footermenu']; } ?>
								</ul>
								<ul class="tbl-cell">
									<?php if( !empty($user['name']) && !empty($user['email']) ) { ?>
										<li><a href="<?php echo URL.DIR_ROUTE; ?>user/appointment"><?php echo $lang['text_my_appointments']; ?></a></li>
										<li><a href="<?php echo URL.DIR_ROUTE; ?>user/invoices"><?php echo $lang['text_my_invoices']; ?></a></li>
										<li><a href="<?php echo URL.DIR_ROUTE; ?>user/request"><?php echo $lang['text_my_requests']; ?></a></li>
										<li><a href="<?php echo URL.DIR_ROUTE; ?>user/profile"><?php echo $lang['text_my_profile']; ?></a></li>
										<li><a href="<?php echo URL.DIR_ROUTE; ?>logout"><?php echo $lang['text_logout']; ?></a></li>
									<?php } else { ?>
										<li><a href="<?php echo URL.DIR_ROUTE; ?>login"><?php echo $lang['text_login']; ?></a></li>
										<li><a href="<?php echo URL.DIR_ROUTE; ?>register"><?php echo $lang['text_register']; ?></a></li>
										<li><a href="<?php echo URL.DIR_ROUTE; ?>forgot"><?php echo $lang['text_forgot_password']; ?></a></li>
									<?php } ?>
								</ul>
							</div>
						</div>

					</div>
				</div>
				<div class="col-md-4 footer-block">
					<div class="footer-ttl">
						<p><?php echo $lang['text_newsletter'] ?></p>
					</div>
					<div class="footer-container footer-c">
						<div class="footer-subscribe">
							<form action="<?php echo URL.DIR_ROUTE; ?>subscribe" method="post">
								<div class="input-box pb-0">
									<input type="text" name="email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,3}$" id="subscribe-email">
									<label for="subscribe-email"><?php echo $lang['text_email_address']; ?></label>
								</div>
								<div class="footer-subscribe-button">
									<button type="submit" id="subscribe-submit" name="subscribe" class="btn btn-primary"><?php echo $lang['text_submit']; ?></button>
								</div>
							</form>
						</div>
						<div class="social-list social-list-colored footer-social">
							<?php if (!empty($sociallink)) { foreach ($sociallink as $key => $value) { if (!empty($value)) { ?>
								<li>
									<a href="<?php echo $value; ?>" target="_blank" class="fab fa-<?php echo $key; ?>"></a>
								</li>
							<?php } } } ?>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- Start of Copyright Section -->
		<div id="copyright">
			<div class="layer-stretch">
				<div class="paragraph-medium paragraph-white">
					<?php echo $footer['copyright']; ?>
				</div>
			</div>
		</div><!-- End of Copyright Section -->
	</footer><!-- End of Footer Section -->

	<input type="hidden" class="common_date_format" value="<?php echo str_replace(['d', 'm', 'Y'], ['dd', 'mm', 'yy'], $siteinfo['date_format']); ?>">
	<!-- Included Scripts -->
	<script src="<?php echo URL.'public/js/vendor.min.js'; ?>"></script>
	<?php echo $script; ?>
	<script src="<?php echo URL.'public/js/custom.js'; ?>"></script>
	<?php
	if (isset($active)) { ?><script>$('#menu-<?php echo $active; ?>').addClass('active');</script><?php }
	if (isset($message) && !empty($message)) { ?>
		<!-- Set Confirmation Message on create, update and delete -->
		<script>
			/*Set toastr Option*/
			toastr.options = {
				"closeButton": true,
				"debug": false,
				"newestOnTop": false,
				"progressBar": false,
				"positionClass": "toast-top-center",
				"preventDuplicates": false,
				"onclick": null,
				"showDuration": "10000",
				"hideDuration": "10000",
				"timeOut": "5000",
				"extendedTimeOut": "800",
				"showEasing": "swing",
				"hideEasing": "linear",
				"showMethod": "fadeIn",
				"hideMethod": "fadeOut"
			}
			toastr.<?php echo $message['alert']; ?>('<?php echo $message['value']; ?>', '<?php echo ucfirst($message['alert']); ?>');
		</script>
	<?php } ?>
</body>
</html>