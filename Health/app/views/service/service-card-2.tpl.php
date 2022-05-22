<div class="theme-block animated animated-up">
	<?php $link = preg_replace('/[[:space:]]+/', '-', $value['name']); ?>
	<div class="theme-block-picture">
		<img src="public/uploads/<?php echo $value['picture']; ?>" alt="<?php echo $value['name']; ?>">
	</div>
	<div class="theme-block-data service-block-data">
		<div class="icon">
			<i class="<?php echo $value['icon']; ?>"></i>
		</div>
		<h4><a><?php echo $value['name']; ?></a></h4>
	</div>
	<div class="theme-block-hidden service-hidden-block">
		<i class="fa fa-stethoscope"></i>
		<h4>
			<a href="<?php echo URL.DIR_ROUTE; ?>service&id=<?php echo $value['id'].'/'.$link; ?>"><?php echo $value['name']; ?></a>
		</h4>
		<p class="description paragraph-medium paragraph-black">
			<span><?php echo $value['short_post']; ?></span>
		</p>
		<div class="text-right">
			<a class="text-primary" href="<?php echo URL.DIR_ROUTE.'service&name='.$value['service_url']; ?>"><?php echo $lang['text_read_more']; ?></a>
		</div>
	</div>
</div>