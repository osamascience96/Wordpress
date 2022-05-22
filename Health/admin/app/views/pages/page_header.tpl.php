<?php include (DIR_ADMIN.'app/views/common/header.tpl.php'); ?>
<!-- Menu page start -->
<div class="page-title">
	<div class="row align-items-center">
		<div class="col-sm-6">
			<h2 class="page-title-text d-inline-block">Header/Menu</h2>
			<div class="breadcrumbs d-inline-block">
				<ul>
					<li><a href="<?php echo URL_ADMIN; ?>">Dashboard</a></li>
					<li><a href="<?php echo URL_ADMIN.DIR_ROUTE.'pages'; ?>">Pages</a></li>
					<li>Header/Menu</li>
				</ul>
			</div>
		</div>
		<div class="col-sm-6 text-right"></div>
	</div>
</div>
<form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data">
	<div class="panel panel-default">
		<div class="panel-body">
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
					<input type="hidden" name="_token" value="<?php echo $token; ?>">
					<input type="hidden" name="page[id]" value="<?php echo $result['id']; ?>">
					<h4>Menu Structure</h4>
					<p>Drag each item into the order you prefer, Click the arrow on the right of the item to reveal additional configuration options.</p>
					<ol class="web-menu sortable">
						<?php if (!empty($result['data'])) {  echo $result['data']; } ?>
					</ol>
					<input type="hidden" class="menu-page-data" name="page[page_data]" value="">
				</div>
			</div>
		</div>
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

				$('ol.sortable > li#'+$(value).attr('id')+' > ol > li').each(function(index1, value1) {
					arr.push({
						'menu_id': $(value1).children().attr('data-id'),
						'menu_type_id' : $(value1).children().attr('data-type-id'),
						'menu_page_id' : $(value1).children().attr('data-page-id'),
						'menu_parent' : $(value).children().attr('data-id'),
						'menu_label' : $(value1).find('.w-bdy .menu-label').val(),
						'menu_custom' : $(value1).find('.w-bdy .menu-custom').val(),
						'menu_link' : $(value1).find('.w-bdy .menu-link').val(),
						'menu_theme' : $(value1).find('.w-bdy .menu-theme').val()
					});

					$('ol.sortable > li > ol > li#'+$(value1).attr('id')+' > ol > li').each(function(index2, value2) {
						arr.push({
							'menu_id': $(value2).children().attr('data-id'), 
							'menu_type_id' : $(value2).children().attr('data-type-id'),
							'menu_page_id' : $(value2).children().attr('data-page-id'),
							'menu_parent' : $(value1).children().attr('data-id'),
							'menu_label' : $(value2).find('.w-bdy .menu-label').val(),
							'menu_custom' : $(value2).find('.w-bdy .menu-custom').val(),
							'menu_link' : $(value2).find('.w-bdy .menu-link').val(),
							'menu_theme' : $(value2).find('.w-bdy .menu-theme').val()
						});
					});
				});
			});

			//console.log(arr);
			//return false;
			$('.menu-page-data').val(JSON.stringify(arr));
		});

		$('.sortable').nestedSortable({
			forcePlaceholderSize: true,
			handle: 'div',
			items: 'li',
			placeholder: 'placeholder',
			toleranceElement: '> div',
			maxLevels: 3,
			isTree: true,
		});

	});
</script>

<!-- Footer -->
<?php include (DIR_ADMIN.'app/views/common/footer.tpl.php'); ?>