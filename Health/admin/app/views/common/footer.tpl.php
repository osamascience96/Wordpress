
					<?php if (isset($message) && !empty($message)) { ?>
						<!-- Set Confirmation Message on create, update and delete -->
						<script>
							/*Set toastr Option*/
							toastr.options = {
								"closeButton": true,
								"debug": false,
								"newestOnTop": false,
								"progressBar": false,
								"positionClass": "toast-top-right",
								"preventDuplicates": false,
								"onclick": null,
								"showDuration": "10000",
								"hideDuration": "10000",
								"timeOut": "2000",
								"extendedTimeOut": "800",
								"showEasing": "swing",
								"hideEasing": "linear",
								"showMethod": "fadeIn",
								"hideMethod": "fadeOut"
							}
							toastr.<?php echo $message['alert']; ?>("<?php echo $message['value']; ?>", "<?php echo ucfirst($message['alert']); ?>");
						</script>
					<?php } ?>
				</div>
			</div>
		</div>
	</div>
</body>
</html>