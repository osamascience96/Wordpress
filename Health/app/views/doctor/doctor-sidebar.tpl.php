<div class="theme-material-card">
	<div class="input-box pb-0">
		<input type="text" class="mb-0" id="search-doctors">
		<label class="mb-0" for="search-doctors"><?php echo $lang['text_search_doctor_by_name']; ?></label>
	</div>
</div>
<div class="theme-material-card">
	<div class="sub-ttl"><?php echo $lang['text_our_services']; ?></div>
	<div class="flexslider theme-flexslider">
		<ul class="slides">
			<?php if (!empty($slider_services)) { foreach ($slider_services as $key => $value) { $title = preg_replace('/[[:space:]]+/', '-', $value['name']); ?>
			<li>
				<div class="theme-flexslider-container">
					<img src="<?php echo 'public/uploads/'.$value['picture']; ?>" />
					<h4><a href="<?php echo URL.DIR_ROUTE.'service&name='.$value['service_url']; ?>"><?php echo $value['name']; ?></a></h4>
					<div class="text-right">
						<a href="<?php echo URL.DIR_ROUTE.'service&name='.$value['service_url']; ?>" class="text-primary"><?php echo $lang['text_read_more']; ?> <i class="fa fa-arrow-right"></i></a>
					</div>
				</div>
			</li>
			<?php } } ?>
		</ul>
	</div>
</div>
<div class="theme-material-card">
	<div class="sub-ttl"><?php echo $lang['text_recent_post']; ?></div>
	<?php if (!empty($recentblog)) { foreach ($recentblog as $key => $value) { $title = preg_replace('/[[:space:]]+/', '-', $value['title']); ?>
	<a href="<?php echo URL.DIR_ROUTE; ?>blog&name=<?php echo $value['blog_url'];?>" class="row blog-recent">
		<div class="col-4 blog-recent-img">
			<img class="img-responsive img-thumbnail" src="<?php echo 'public/uploads/'.$value['picture']; ?>" alt="blog">
		</div>
		<div class="col-8 blog-recent-post">
			<h4><?php echo $value['title']; ?></h4>
			<p><?php echo date_format(date_create($value['date_of_joining']),"d M Y"); ?></p>
		</div>
	</a>
	<?php } } ?>
</div>