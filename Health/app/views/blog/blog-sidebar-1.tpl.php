<div class="theme-material-card">
	<div class="sub-ttl"><?php echo $lang['text_recent_post']; ?></div>
	<?php if (!empty($recentblog)) { foreach ($recentblog as $key => $value) { $title = preg_replace('/[[:space:]]+/', '-', $value['title']); ?>
	<a href="<?php echo URL.DIR_ROUTE.'blog&name='.$value['blog_url'];?>" class="row blog-recent">
		<div class="col-4 blog-recent-img">
			<img class="img-responsive img-thumbnail" src="public/uploads/<?php echo $value['picture']; ?>" alt="">
		</div>
		<div class="col-8 blog-recent-post">
			<h4><?php echo $value['title']; ?></h4>
			<p><?php echo date_format(date_create($value['date_of_joining']),"d M Y"); ?></p>
		</div>
	</a>
	<?php } } ?>
</div>
<div class="theme-material-card">
	<div class="sub-ttl"><?php echo $lang['text_trending_post']; ?></div>
	<div class="flexslider theme-flexslider">
		<ul class="slides">
			<?php if (!empty($trendingblog)) { foreach ($trendingblog as $key => $value) { $title = preg_replace('/[[:space:]]+/', '-', $value['title']); ?>
			<li>
				<div class="theme-flexslider-container">
					<img src="public/uploads/<?php echo $value['picture']; ?>" />
					<h4 class="font-16 text-left">
						<a href="<?php echo URL.DIR_ROUTE.'blog&name='.$value['blog_url'];?>"><?php echo $value['title']; ?></a>
					</h4>
					<p class="text-left primary-color pull-left"><?php echo date_format(date_create($value['date_of_joining']),"d M Y"); ?></p>
					<div class="font-12 pull-right">( <?php echo $value['hits'].' '.$lang['text_views']; ?> )</div>
				</div>
			</li>
			<?php } } ?>
		</ul>
	</div>
</div>
<div class="theme-material-card">
	<div class="sub-ttl"><?php echo $lang['text_categories']; ?></div>
	<ul class="category-list">
		<?php if (!empty($categories)) { foreach ($categories as $key => $value) { if (!empty($value['count'])) { ?>
		<li><a href="<?php echo URL.DIR_ROUTE.'category&id='.$value['id'].'/'.$value['slug']; ?>"><i class="<?php if(!empty($value['icon'])) { echo $value['icon']; } else { echo "fa-newspaper-o"; } ?>"></i><?php echo $value['name']; ?></a><span>(<?php echo $value['count']; ?>)</span></li>
		<?php } } } ?>
	</ul>
</div>