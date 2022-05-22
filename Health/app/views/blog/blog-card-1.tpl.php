<div class="theme-block theme-block-hover animated animated-up fadeInUp">
	<div class="theme-block-picture">
		<div class="blog-card-date"><?php echo date_format(date_create($value['date']),"d M Y"); ?></div>
		<img src="public/uploads/<?php echo $value['picture']; ?>" alt="<?php echo $value['title']; ?>">
	</div>
	<div class="blog-card-ttl">
		<h3><a href="<?php echo URL.DIR_ROUTE; ?>blog&name=<?php echo $value['blog_url'];?>" data-toggle="tooltip" title="<?php echo $value['title']; ?>"><?php echo $value['title']; ?></a></h3>
	</div>
	<div class="blog-card-details">
		<div class="row align-items-center">
			<div class="col-6 author">
				<p><i class="far fa-user-circle"></i><?php echo $value['author']; ?></p>
			</div>
			<div class="col-6">
				<a href="<?php echo URL.DIR_ROUTE.'blog&name='.$value['blog_url'];?>"><i class="far fa-eye mr-2"></i><?php echo $lang['text_read_more']; ?></a>
			</div>
		</div>
	</div>
</div>