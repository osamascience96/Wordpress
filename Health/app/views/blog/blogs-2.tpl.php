<?php echo $header; ?>
<!-- Start Blog List -->
<div id="blog-list" class="animated-wrapper">
	<div class="layer-stretch">
		<div class="layer-wrapper layer-bottom-0 text-center">
			<?php if (!empty($category)) { ?>
				<h2 class="sub-ttl"><?php echo $lang['text_category'].' - '.$category['name']; ?></h2>
			<?php } ?>
			<div class="row">
				<?php if (!empty($blogs)) { foreach ($blogs as $value) {  ?>
					<div class="col-md-6">
						<?php include DIR.'app/views/blog/blog-card-2.tpl.php'; ?>
					</div>
				<?php } } ?>
			</div>
		</div>
	</div>	
</div><!-- End Blog List -->

<?php echo $footer; ?>