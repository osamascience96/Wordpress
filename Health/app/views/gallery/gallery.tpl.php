<?php echo $header; ?>
<!-- Start Gallery Section -->
<div id="gallery-page">
	<div class="gallery-container">
		<ul class="portfolio-image">
			<?php if (!empty($galleries)) { foreach ($galleries as $key => $value) { ?>
			<li class="gallery-block">
				<a data-fancybox="gallery" href="public/images/gallery/<?php echo $value['media']; ?>">
					<img src="public/images/gallery/<?php echo $value['media']; ?>" alt="Gallery">
					<div class="gallery-layer">
						<div class="gallery-layer-dark">
							<p><i class="fas fa-search-plus"></i></p>
						</div>
					</div>
				</a>
			</li>
			<?php } } ?>
		</ul>
	</div>
</div><!-- End Gallery Section -->
<?php echo $footer; ?>