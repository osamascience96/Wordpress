<div class="theme-material-card text-left">
	<div class="input-box pb-0">
		<input type="text" class="mb-0" id="search-services">
		<label  class="mb-0" for="search-services"><?php echo $lang['text_search_services_by_name']; ?></label>
	</div>
</div>
<div class="theme-material-card">
	<div class="sub-ttl"><?php echo $lang['text_our_team']; ?></div>
	<div class="flexslider theme-flexslider">
		<ul class="slides">
			<?php if (!empty($slider_doctor)) { foreach ($slider_doctor as $key => $value) { ?>
				<li>
					<div class="theme-flexslider-container">
						<img src="public/uploads/<?php echo $value['picture']; ?>" alt="doctor"/>
						<h4><?php echo $value['name']; ?></h4>
						<p><?php echo json_decode($value['about'], true)['specility']; ?></p>
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