<div class="theme-accordion">
	<?php $link = preg_replace('/[[:space:]]+/', '-', $value['name']); ?>
	<div class="theme-accordion-hdr">
		<h4><i class="<?php echo $value['icon']; ?>"></i><?php echo $value['name']; ?></h4>
		<div class="theme-accordion-control"><i class="ti-plus"></i></div>
	</div>
	<div class="theme-accordion-bdy">
		<div class="row service-accordian">
			<div class="col-sm-3 theme-accordian-img text-center">
				<img class="img-responsive img-thumbnail" src="public/uploads/<?php echo $value['picture']; ?>" alt="<?php echo $value['name']; ?>">
			</div>
			<div class="col-sm-9">
				<p class="paragraph-medium paragraph-black"><i class="fa fa-<?php echo $value['icon']; ?> theme-dropcap"></i><?php echo $value['short_post']; ?></p>
				<div class="text-right">
					<a class="btn btn-primary btn-outline btn-outline-2x btn-sm" href="<?php echo URL.DIR_ROUTE.'service&name='.$value['service_url']; ?>"><span><?php echo $lang['text_read_more']; ?></span><i class="fa fa-arrow-right"></i></a>
				</div>
			</div>
		</div>
	</div>
</div>