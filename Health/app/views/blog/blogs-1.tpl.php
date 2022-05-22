<?php echo $header; ?>
<!-- Start Blog List -->
<div class="layer-stretch animated-wrapper">
	<div class="layer-wrapper layer-bottom-0">
		<div class="row text-center">
			<?php if (!empty($category)) { ?>
				<h2 class="col-md-12 sub-ttl"><?php echo $lang['text_category'].' - '.$category['name']; ?></h2>
			<?php } ?>
			<?php if (!empty($blogs)) { foreach ($blogs as $value) { ?>
			<div class="col-sm-6 col-md-4">
				<?php include DIR.'app/views/blog/blog-card-1.tpl.php'; ?>
			</div>
			<?php } } ?>
		</div>
	</div>
</div><!-- End Blog List -->

<?php echo $footer; ?>