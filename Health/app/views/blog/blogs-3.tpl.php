<?php echo $header; ?>
<!-- Start Blog List -->
<div class="layer-stretch animated-wrapper">
	<div class="layer-wrapper layer-bottom-0">
		<div class="row text-center">
			<div class="col-md-8">
				<?php if (!empty($category)) { ?>
				<h2 class="sub-ttl"><?php echo $lang['text_category'].' - '.$category['name']; ?></h2>
				<?php } ?>
				<?php if (!empty($blogs)) { foreach ($blogs as $value) { ?>
					<?php include DIR.'app/views/blog/blog-card-4.tpl.php'; ?>
				<?php } } ?>
			</div>
			<div class="col-md-4">
				<?php include DIR.'app/views/blog/blog-sidebar-1.tpl.php'; ?>
			</div>
			
		</div>
	</div>
</div><!-- End Blog List -->

<?php echo $footer; ?>