<div class="theme-material-card blog-full-block">
	<div class="row">
		<div class="col-sm-4">
			<div class="blog-full-date"><?php echo date_format(date_create($value['date']),"d M Y"); ?></div>
			<div class="theme-img theme-img-scalerotate">
				<img src="public/uploads/<?php echo $value['picture']; ?>" alt="<?php echo $value['title']; ?>">
			</div>
		</div>
		<div class="col-sm-8">
			<div class="blog-full-ttl">
				<h3><a href="<?php echo URL.DIR_ROUTE; ?>blog&name=<?php echo $value['blog_url'];?>"><?php echo $value['title']; ?></a></h3>
			</div>
			<div class="blog-full-description">
				<?php echo $value['short_post']; ?>
			</div>
			<div class="blog-full-ftr">
				<div class="row">
					<div class="col-6 text-left">
						<a class="blog-full-author"><i class="far fa-user-circle"></i> <?php echo $value['author']; ?></a>
					</div>
					<div class="col-6 text-right">
						<a class="text-primary" href="<?php echo URL.DIR_ROUTE.'blog&name='.$value['blog_url'];?>"><?php echo $lang['text_read_more']; ?></a>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>