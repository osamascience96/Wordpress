<div class="theme-material-card">
	<div class="sub-ttl"><?php echo $lang['text_our_services']; ?></div>
	<div class="flexslider theme-flexslider">
		<ul class="slides">
			<?php if (!empty($slider_services)) { foreach ($slider_services as $key => $value) { $title = preg_replace('/[[:space:]]+/', '-', $value['name']); ?>
			<li>
				<div class="theme-flexslider-container">
					<img src="<?php echo 'public/uploads/'.$value['picture']; ?>" />
					<h4 class="text-center"><?php echo $value['name']; ?></h4>
					<a href="<?php echo URL.DIR_ROUTE.'service&name='.$value['service_url']; ?>" class="text-primary float-right"><?php echo $lang['text_read_more']; ?> <i class="fa fa-arrow-right"></i></a>
				</div>
			</li>
			<?php } } ?>
		</ul>
	</div>
</div>
<div class="theme-material-card">
	<div class="sub-ttl"><?php echo $lang['text_our_team']; ?></div>
	<div class="flexslider theme-flexslider">
		<ul class="slides">
			<?php if (!empty($slider_doctor)) { foreach ($slider_doctor as $key => $value) { ?>
			<li>
				<div class="theme-flexslider-container text-center">
					<img src="<?php echo 'public/uploads/'.$value['picture']; ?>" />
					<h4><?php echo $value['name']; ?></h4>
					<p><?php echo json_decode($value['about'], true)['specility']; ?></p>
				</div>
			</li>
			<?php } } ?>
		</ul>
	</div>
</div>
<div class="theme-material-card mb-0">
	<div class="sub-ttl"><?php echo $lang['text_recent_post']; ?></div>
	<?php if (!empty($recentblog)) { foreach ($recentblog as $key => $value) { $title = preg_replace('/[[:space:]]+/', '-', $value['title']); ?>
	<a href="<?php echo URL.DIR_ROUTE; ?>blog&name=<?php echo $value['blog_url'];?>" class="row blog-recent">
		<div class="col-4 blog-recent-img">
			<img class="img-responsive img-thumbnail" src="<?php echo 'public/uploads/'.$value['picture']; ?>" alt="">
		</div>
		<div class="col-8 blog-recent-post">
			<h4><?php echo $value['title']; ?></h4>
			<p><?php echo date_format(date_create($value['date_of_joining']),"d M Y"); ?></p>
		</div>
	</a>
	<?php } } ?>
</div>