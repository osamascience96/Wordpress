<div class="blog-block-3 animated animated-up fadeInUp">
	<div class="blog-list-picture">
		<div class="theme-img">
			<img src="public/uploads/<?php echo $value['picture']; ?>" alt="<?php echo $value['title']; ?>">
		</div>
	</div>
	<div class="blog-list-ttl">
		<?php $link = preg_replace('/[[:space:]]+/', '-', $value['title']); ?>
		<h3><a href="<?php echo URL.DIR_ROUTE; ?>blog&name=<?php echo $value['blog_url'];?>" data-toggle="tooltip" title="<?php echo $value['title']; ?>"><?php echo $value['title']; ?></a></h3>
	</div>
	<div class="blog-list-meta">
		<p><?php echo $lang['text_posted_by']; ?> <?php echo $value['author'].' '.$lang['text_on'].' '.date_format(date_create($value['date']),"d M Y"); ?></p>
	</div>	
	<div class="blog-list-post">
		<p class="paragraph-medium paragraph-black">
			<span><?php echo $value['short_post']; ?></span>
			<a href="<?php echo URL.DIR_ROUTE.'blog&name='.$value['blog_url'];?>">(<?php echo $lang['text_read_more']; ?>)</a>
		</p>
	</div>
</div>