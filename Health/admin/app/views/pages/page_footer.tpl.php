<?php include (DIR_ADMIN.'app/views/common/header.tpl.php'); ?>
<div class="page-title">
	<div class="row align-items-center">
		<div class="col-sm-6">
			<h2 class="page-title-text d-inline-block">Footer</h2>
			<div class="breadcrumbs d-inline-block">
				<ul>
					<li><a href="<?php echo URL_ADMIN; ?>">Dashboard</a></li>
					<li><a href="<?php echo URL_ADMIN.DIR_ROUTE.'pages'; ?>">Pages</a></li>
					<li>Footer</li>
				</ul>
			</div>
		</div>
		<div class="col-sm-6 text-right"></div>
	</div>
</div>
<!-- Home page start -->
<form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data">
	<div class="panel panel-default">
		<div class="panel-body">
			<input type="hidden" name="_token" value="<?php echo $token; ?>">
			<ul class="nav nav-tabs nav-tabs-line nav-tabs-line-primary">
				<li class="nav-item">
					<a class="nav-link active" href="#footer-timetable" data-toggle="tab">Time Table Section</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="#footer-emergency" data-toggle="tab">Emergency Section</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="#footer-footermenu" data-toggle="tab">Footer Menu</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="#footer-social" data-toggle="tab">Social Link</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="#footer-copyright" data-toggle="tab">Copyright</a>
				</li>
			</ul>
			<div class="tab-content pt-4">
				<div class="tab-pane active" id="footer-timetable">
					<div class="form-group">
						<div class="custom-control custom-checkbox custom-checkbox-1 mb-3">
							<input type="checkbox" name="page[timetable][status]" class="custom-control-input" id="page-timetable-section" value="1" <?php if (!empty($result['data']['timetable']['status']) && $result['data']['timetable']['status']) { echo "checked"; }?>>
							<label class="custom-control-label" for="page-timetable-section">Want to display this section on website?</label>
						</div>
					</div>
					<div class="row">
						<div class="col-lg-6">
							<div class="form-group">
								<label>Section Title</label>
								<input type="text" name="page[timetable][title]" value="<?php echo $result['data']['timetable']['title']; ?>" placeholder="Time Table Section Title">
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label>Sunday Time</label>
								<input type="text" name="page[timetable][timing][sun]" value="<?php echo $result['data']['timetable']['timing']['sun']; ?>" placeholder="Enter Sunday Time . . .">
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label>Monday Time</label>
								<input type="text" name="page[timetable][timing][mon]" value="<?php echo $result['data']['timetable']['timing']['mon']; ?>" placeholder="Enter Monday Time . . .">
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label>Tuesday Time</label>
								<input type="text" name="page[timetable][timing][tue]" value="<?php echo $result['data']['timetable']['timing']['tue']; ?>" placeholder="Enter Tuesday Time . . .">
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label>Wednesday Time</label>
								<input type="text" name="page[timetable][timing][wed]" value="<?php echo $result['data']['timetable']['timing']['wed']; ?>" placeholder="Enter Wednesday Time . . .">
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label>Thursday Time</label>
								<input type="text" name="page[timetable][timing][thu]" value="<?php echo $result['data']['timetable']['timing']['thu']; ?>" placeholder="Enter Thursday Time . . .">
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label>Friday Time</label>
								<input type="text" name="page[timetable][timing][fri]" value="<?php echo $result['data']['timetable']['timing']['fri']; ?>" placeholder="Enter Friday Time . . .">
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label>Saturday Time</label>
								<input type="text" name="page[timetable][timing][sat]" value="<?php echo $result['data']['timetable']['timing']['sat']; ?>" placeholder="Enter Saturday Time . . .">
							</div>
						</div>
					</div>
				</div>
				<div class="tab-pane" id="footer-emergency">
					<div class="form-group">
						<div class="custom-control custom-checkbox custom-checkbox-1 mb-3">
							<input type="checkbox" name="page[emergency][status]" class="custom-control-input" id="page-service-section" value="1" <?php if (!empty($result['data']['emergency']['status']) && $result['data']['emergency']['status']) { echo "checked"; }?>>
							<label class="custom-control-label" for="page-service-section">Want to display this section on website?</label>
						</div>
					</div>
					<div class="row">
						<div class="col-lg-6">
							<div class="form-group">
								<label>Section Title</label>
								<input type="text" name="page[emergency][title]" value="<?php echo $result['data']['emergency']['title']; ?>" placeholder="Emergency Section Title">
							</div>
							<div class="form-group">
								<label>Section Description</label>
								<textarea name="page[emergency][description]" class="form-control" placeholder="Emergency Section Description"><?php echo $result['data']['emergency']['description']; ?></textarea>
							</div>
						</div>
					</div>
				</div>
				<div class="tab-pane" id="footer-footermenu">
					<div class="form-group">
						<label>Select Footer Menu</label>
						<div class="row">
							<div class="col-md-4">
								<div class="theme-accordion-container">
									<div class="theme-accordion">
										<div class="theme-accordion-hdr">
											<h4 class="text-primary">Pages</h4>
											<div class="theme-accordion-control"><i class="ti-plus"></i></div>
										</div>
										<div class="theme-accordion-bdy">
											<div class="pages-list">
												<div class="h-300">
													<?php if (!empty($pages)) { foreach ($pages as $key => $value) { ?>
														<div class="custom-control custom-checkbox custom-checkbox-1 mb-3">
															<input type="checkbox" class="custom-control-input" id="<?php echo 'pages-'.$value['id'] ?>" data-id="<?php echo $value['id']; ?>">
															<label class="custom-control-label" for="<?php echo 'pages-'.$value['id'] ?>"><?php echo $value['page_title'] ?></label>
														</div>
													<?php } } ?>
												</div>
												<div class="text-right">
													<a class="btn btn-primary btn-sm add-page-link">Add to Menu</a>
												</div>
											</div>
										</div>
									</div>
									<div class="theme-accordion">
										<div class="theme-accordion-hdr">
											<h4 class="text-primary">Custom Link</h4>
											<div class="theme-accordion-control"><i class="ti-plus"></i></div>
										</div>
										<div class="theme-accordion-bdy">
											<div class="form-group">
												<label>URL/Link</label>
												<input type="text" class="form-control custom-link-url" value="http://" placeholder="Enter URL/Link . . .">
											</div>
											<div class="form-group">
												<label>Label</label>
												<input type="text" class="form-control custom-link-text" placeholder="Enter navigation label . . .">
											</div>
											<div class="text-right">
												<a class="btn btn-primary btn-sm add-custom-link">Add to Menu</a>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="col-md-8">
								<div class="col-md-8">
									<input type="hidden" name="_token" value="<?php echo $token; ?>">
									<input type="hidden" name="page[id]" value="<?php echo $result['id']; ?>">
									<h4>Footer Menu Structure</h4>
									<p>Drag each item into the order you prefer, Click the arrow on the right of the item to reveal additional configuration options.</p>
									<ol class="web-menu sortable">
										<?php if (!empty($result['data']['footermenu'])) {  echo $result['data']['footermenu']; } ?>
									</ol>
									<input type="hidden" class="footer-menu-data" name="page[footermenu]" value="">
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="tab-pane" id="footer-social">
					<div class="row">
						<div class="col-md-6 col-lg-4">
							<div class="form-group">
								<label>Facebook</label>
								<input type="text" name="page[social][facebook]" value="<?php echo $result['data']['social']['facebook']; ?>" placeholder="Enter Facebook Social Link . . .">
							</div>
						</div>
						<div class="col-md-6 col-lg-4">
							<div class="form-group">
								<label>Twitter</label>
								<input type="text" name="page[social][twitter]" value="<?php echo $result['data']['social']['twitter']; ?>" placeholder="Enter Twitter Social Link . . .">
							</div>
						</div>
						<div class="col-md-6 col-lg-4">
							<div class="form-group">
								<label>Google +</label>
								<input type="text" name="page[social][google]" value="<?php echo $result['data']['social']['google']; ?>" placeholder="Enter Google + Social Link . . .">
							</div>
						</div>
						<div class="col-md-6 col-lg-4">
							<div class="form-group">
								<label>Instagram</label>
								<input type="text" name="page[social][instagram]" value="<?php echo $result['data']['social']['instagram']; ?>" placeholder="Enter Instagram Social Link . . .">
							</div>
						</div>
						<div class="col-md-6 col-lg-4">
							<div class="form-group">
								<label>Youtube</label>
								<input type="text" name="page[social][youtube]" value="<?php echo $result['data']['social']['youtube']; ?>" placeholder="Enter Youtube Social Link . . .">
							</div>
						</div>
						<div class="col-md-6 col-lg-4">
							<div class="form-group">
								<label>Linkedin</label>
								<input type="text" name="page[social][linkedin]" value="<?php echo $result['data']['social']['linkedin']; ?>" placeholder="Enter Linkedin Social Link . . .">
							</div>
						</div>
						<div class="col-md-6 col-lg-4">
							<div class="form-group">
								<label>Flickr</label>
								<input type="text" name="page[social][flickr]" value="<?php echo $result['data']['social']['flickr']; ?>" placeholder="Enter Flickr Social Link . . .">
							</div>
						</div>
						<div class="col-md-6 col-lg-4">
							<div class="form-group">
								<label>RSS</label>
								<input type="text" name="page[social][rss]" value="<?php echo $result['data']['social']['rss']; ?>" placeholder="Enter RSS Feed Link . . .">
							</div>
						</div>
					</div>
				</div>
				<div class="tab-pane" id="footer-copyright">
					<div class="form-group">
						<label>Copyright Tag</label>
						<input name="page[copyright]" value="<?php echo $result['data']['copyright']; ?>" placeholder="Footer Bottom line(Ex: 2020 © Pepdev, ALL RIGHTS RESERVED.)">
						<input type="hidden" name="page_name" value="footer">
					</div>
				</div>
			</div>
		</div>
		<input type="hidden" name="page[page_name]" value="footer">
		<div class="panel-footer text-center">
			<button type="submit" name="submit" class="btn btn-primary"><i class="ti-save-alt pr-2"></i> Save</button>
		</div>
	</div>
</form>
<script>
	$(document).ready(function() {
		$(document).on('click', '.w-hdr', function () {
			var ele = $(this), ele_parent = ele.parent('.w-accordion');
			$('.w-bdy').slideUp();
			if (ele_parent.find('.w-bdy').css('display') == 'none') {
				ele_parent.find('.w-bdy').slideDown();
			} else {
				ele_parent.find('.w-bdy').slideUp();
			}
		});

		$(document).on('click', '.add-page-link', function () {
			var selected = [];
			$('.pages-list input:checked').each(function() {
				selected.push($(this).data('id'));
			});

			if(selected.length > 0) {
				$.ajax({
					type: 'POST',
					url: '<?php echo URL_ADMIN.DIR_ROUTE.'getmenupages'; ?>',
					data: { 'pages' : selected, _token: $('.s_token').val() },
					dataType: "html",
					success: function(data) {
						$('.sortable').append(data);
						$('.pages-list input').prop( "checked", false);
					}
				});
			}
		});

		$(document).on('click', '.add-custom-link', function () {
			var custom_url = $('.custom-link-url').val();
			var custom_text = $('.custom-link-text').val();

			var error = 0;

			if(custom_url == 'http://' || custom_url == 'https://' || custom_url == '' ) {
				error++;
				$('.custom-link-url').addClass('form-control-error');
			} else {
				$('.custom-link-url').removeClass('form-control-error');
			}

			if (custom_text.length < 1) {
				error++;
				$('.custom-link-text').addClass('form-control-error');
			} else {
				$('.custom-link-text').removeClass('form-control-error');
			}

			if(error == 0) {
				$.ajax({
					type: 'POST',
					url: '<?php echo URL_ADMIN.DIR_ROUTE.'getmenulink'; ?>',
					data: { 'custom_url' : custom_url, 'custom_text' : custom_text, _token: $('.s_token').val() },
					dataType: "html",
					success: function(data) {
						$('.sortable').append(data);
						$('.custom-link-url').val('http://');
						$('.custom-link-text').val('');
					}
				});
			} else {
				return false;
			}
		});

		$(document).on('click', '.menu-remove', function () {
			var ele = $(this), id = ele.data('id');
			$('#'+id).slideUp("normal", function() { $('#'+id).remove(); } );
		});

		$('.panel-footer button').click(function(e) {
			var arr = [];
			$('ol.sortable > li').each(function(index, value) {
				var ele = $(this);
				arr.push({
					'menu_id': $(value).children().attr('data-id'), 
					'menu_type_id' : $(value).children().attr('data-type-id'),
					'menu_page_id' : $(value).children().attr('data-page-id'),
					'menu_parent' : '0',
					'menu_label' : $(value).find('.w-bdy .menu-label').val(),
					'menu_custom' : $(value).find('.w-bdy .menu-custom').val(),
					'menu_link' : $(value).find('.w-bdy .menu-link').val(),
					'menu_theme' : $(value).find('.w-bdy .menu-theme').val()
				});
			});

			//console.log(arr);
			//return false;
			$('.footer-menu-data').val(JSON.stringify(arr));
		});

		$('.sortable').nestedSortable({
			forcePlaceholderSize: true,
			handle: 'div',
			items: 'li',
			placeholder: 'placeholder',
			toleranceElement: '> div',
			maxLevels: 1,
			isTree: true,
		});

	});
</script>
<!-- Footer -->
<?php include (DIR_ADMIN.'app/views/common/footer.tpl.php'); ?>