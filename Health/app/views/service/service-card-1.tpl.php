<div class="theme-block theme-block-hover animated animated-up">
	<?php $link = preg_replace('/[[:space:]]+/', '-', $value['name']); ?>
	<div class="theme-block-picture">
		<img src="public/uploads/<?php echo $value['picture']; ?>" alt="<?php echo $value['name']; ?>">
	</div>
	<div class="theme-block-data service-block-data">
		<div class="icon">
			<i class="<?php echo $value['icon']; ?>"></i>
		</div>
		<h4>
			<a href="<?php echo URL.DIR_ROUTE.'service&id='.$value['id'].'/'.$link; ?>"><?php echo $value['name']; ?></a>
		</h4>
		<p class="paragraph-medium paragraph-black description">
			<span><?php echo $value['short_post']; ?></span>
		</p>
		<div class="text-right">
			<a class="text-primary" href="<?php echo URL.DIR_ROUTE.'service&name='.$value['service_url']; ?>"><?php echo $lang['text_read_more']; ?></a>
		</div>
	</div>
</div>