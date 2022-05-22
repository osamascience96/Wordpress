<?php include (DIR_ADMIN.'app/views/common/header.tpl.php'); ?>
<!-- Blog page start -->
<div class="page-title">
	<div class="row align-items-center">
		<div class="col-sm-6">
			<h2 class="page-title-text d-inline-block">Icon</h2>
			<div class="breadcrumbs d-inline-block">
				<ul>
					<li><a href="<?php echo URL_ADMIN; ?>">Dashboard</a></li>
					<li><a>Icons</a></li>
				</ul>
			</div>
		</div>
		<div class="col-sm-6 text-right"></div>
	</div>
</div>
<div class="panel panel-default">
	<div class="panel-body">
		<div class="icon-container">
			<ul class="row"></ul>
		</div>
	</div>
</div>

<script>
	jQuery.getJSON("<?php echo URL_ADMIN.'public/fonts/font-awesome/fontawesome-list.json'; ?>", function(data) {
		console.log(data);
		var items = [];
		$.each( data, function( key, val ) {
			items.push( "<li class='col-md-2'><div><i class='" + val + "'></i> <span>" + val + "</span></div></li>" );
		});

		$('.icon-container ul').append(items);
	});
</script>
<!-- Footer -->
<?php include (DIR_ADMIN.'app/views/common/footer.tpl.php'); ?>