<?php include (DIR_ADMIN.'app/views/common/header.tpl.php'); ?>
<div class="page-title">
	<div class="row align-items-center">
		<div class="col-sm-6">
			<h2 class="page-title-text d-inline-block"><?php echo $page_title; ?></h2>
			<div class="breadcrumbs d-inline-block">
				<ul>
					<li><a href="<?php echo URL_ADMIN; ?>">Dashboard</a></li>
					<li><a href="<?php echo URL_ADMIN.DIR_ROUTE.'pages'; ?>">Pages</a></li>
					<li><?php echo $page_title; ?></li>
				</ul>
			</div>
		</div>
		<div class="col-sm-6 text-right"></div>
	</div>
</div>
<!-- FAQ page start -->
<form action="<?php echo $action; ?>" method="post">
	<div class="panel panel-default">
		<div class="panel-body">
			<ul class="nav nav-tabs nav-tabs-line nav-tabs-line-primary">
				<li class="nav-item">
					<a class="nav-link active" href="#page-section" data-toggle="tab">Page</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="#meta" data-toggle="tab">Meta/Seo</a>
				</li>
			</ul>
			<div class="tab-content pt-4">
				<div class="tab-pane active" id="page-section">
					<input type="hidden" name="_token" value="<?php echo $token; ?>">
					<div class="form-group">
						<label>Page Title</label>
						<input type="text" name="page[title]" class="form-control" value="<?php echo $result['page_title']; ?>" placeholder="Enter Page Title . . ." required>
					</div>
					<div class="faq-container">
						<?php if (!empty($result['page_data'])) { foreach ($result['page_data'] as $key => $value) { ?>
							<div class="form-group block">
								<label>Question : </label>
								<input type="text" name="page[content][<?php echo $key; ?>][q]" class="form-control" value="<?php echo $value['q']; ?>" placeholder="Enter Frequently asked question?">
								<div class="">
									<label>Answer : </label>
									<textarea name="page[content][<?php echo $key; ?>][a]" class="form-control" placeholder="Enter Frequently asked question's answer"><?php echo $value['a']; ?></textarea>
								</div>
								<?php if ($key > 0) { ?>
									<div class="faq-remove">x</div>
								<?php } ?>
							</div>
						<?php } } else { ?>
							<div class="form-group block">
								<label>Question : </label>
								<input type="text" name="page[content][0][q]" class="form-control" value="" placeholder="Enter Frequently asked question?">
								<div class="">
									<label>Answer : </label>
									<textarea name="page[content][0][a]" class="form-control" placeholder="Enter Frequently asked question's answer"></textarea>
								</div>
							</div>
						<?php } ?>
					</div>
					<div class="add-more">
						<a class="btn btn-white btn-sm">Add More Faq's Question and Answer</a>
					</div>
				</div>
				<div class="tab-pane" id="meta">
					<div class="row">
						<div class="col-lg-6">
							<div class="form-group">
								<label>Meta Tag</label>
								<input type="text" class="form-control" name="page[meta][tag]" value="<?php echo $result['meta_tag']; ?>" placeholder="Enter Meta Tag Title . . ." required>
							</div>
							<div class="form-group">
								<label>Meta Description</label>
								<textarea name="page[meta][description]" class="form-control" placeholder="Enter Meta Tag Description . . ."><?php echo $result['meta_description']; ?></textarea>
							</div>
						</div>
					</div>
				</div>
				<input type="hidden" name="page[name]" value="<?php echo $result['page_name']; ?>">
				<input type="hidden" name="page[id]" value="<?php echo $result['id']; ?>">
			</div>
		</div>
		<div class="panel-footer text-center">
			<button type="submit" name="submit" class="btn btn-primary"><i class="ti-save-alt pr-2"></i> Save</button>
		</div>
	</div>
</form>
<script>
    //Add More on FAQ
    $('.add-more a').click(function () {
    	var count = $('.faq-container .block:nth-last-child(1) input').attr('name').split('[')[2];
    	count = parseInt(count.split(']')[0]) + 1;
    	$('.faq-container').append('<div class="form-group block">'+
    		'<label>Question : </label>'+
    		'<input type="text" name="page[content]['+count+'][q]" class="form-control" value="" placeholder="Enter Frequently asked question?">'+
    		'<div class="">'+
    		'<label>Answer : </label>'+
    		'<textarea name="page[content]['+count+'][a]" class="form-control" placeholder="Enter Frequently asked question\'s answer"></textarea>'+
    		'</div>'+'</div>');
    });

    //Remove Faq
    $('body').on('click', '.faq-remove', function () {
    	$(this).parent('.block').remove();
    });

</script>
<!-- Footer -->
<?php include (DIR_ADMIN.'app/views/common/footer.tpl.php'); ?>