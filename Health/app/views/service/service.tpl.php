<?php echo $header; ?>
<!-- Start Service List Section -->
<div class="layer-stretch">
	<div class="row layer-wrapper">
		<div class="col-md-8 text-left">
			<div class="theme-material-card">
				<div class="blog"></div>
				<div class="theme-img blog-picture theme-img-scalerotate text-center">
					<img src="public/uploads/<?php echo $service['picture']; ?>" alt="<?php echo $service['name']; ?>">
				</div>
				<div class="pl-2 pr-2">
					<p></p>
					<div class="paragraph-medium paragraph-black text-left"><?php echo html_entity_decode($service['long_post'], ENT_QUOTES, 'UTF-8'); ?></div>
				</div>
			</div>
			<div class="theme-material-card">
				<div class="sub-ttl"><?php echo $lang['text_reviews']; ?> (<?php if (!empty($reviews)) { echo count($reviews); } else { echo "0"; } ?>)</div>
				<ul class="comment-list">
					<?php if (!empty($reviews)) { foreach ($reviews as $key => $value) { ?>
						<li>
							<div class="row">
								<div class="col-auto hidden-xs comment-icon text-center"><i class="far fa-user-circle fa-3x"></i></div>
								<div class="col pl-0 comment-detail text-left">
									<div class="comment-meta">
										<span><?php echo $value['name']; ?></span>
										<span><?php echo date_format(date_create($value['date_of_joining']), $siteinfo['date_format']); ?></span>
									</div>
									<div class="comment-post"><?php echo $value['content']; ?></div>
								</div>
							</div>
						</li>
					<?php } } else { ?>
						<li class="text-center font-18"><?php echo $lang['text_no_review_found']; ?></li>
					<?php } ?>
				</ul>
			</div>
			<div class="theme-material-card text-center">
				<div class="sub-ttl layer-ttl-white"><?php echo $lang['text_write_a_review']; ?></div>
				<?php if ($whocan['review']) { ?>
					<form class="row comment-form text-center" action="<?php echo URL.DIR_ROUTE; ?>review" method="post" enctype="multipart/form-data">
						<div class="col-sm-6">
							<input type="hidden" name="_token" value="<?php echo $token; ?>" required>
							<input type="hidden" name="review_for_id" value="<?php echo $service['id'] ?>" required>
							<div class="input-box">
								<input type="text" name="name" pattern="[A-Z,a-z, ]*" id="comment-name" required>
								<label for="comment-name"><?php echo $lang['text_name']; ?> <em> *</em></label>
							</div>
						</div>
						<div class="col-sm-6">
							<div class="input-box">
								<input type="text" name="email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,3}$" id="comment-email" required>
								<label for="comment-email"><?php echo $lang['text_email_address']; ?> <em> *</em></label>
							</div>
						</div>
						<div class="col-sm-12">
							<div class="input-box">
								<textarea type="text" name="content" rows="4" id="comment-message" required></textarea>
								<label for="comment-message"><?php echo $lang['text_your_review']; ?></label>
							</div>
						</div>
						<div class="col-sm-12">
							<div class="form-submit">
								<button type="submit" name="submit" class="btn btn-primary"><?php echo $lang['text_submit']; ?></button>
							</div>
						</div>
					</form>
				<?php } else { ?>
					<p class="font-16"><?php echo $lang['text_you_must_be_registered_and_logged_in_to_review']; ?></p>
					<a href="<?php echo URL.DIR_ROUTE."login"; ?>" class="btn btn-primary"><?php echo $lang['text_login']; ?></a>
				<?php } ?>
			</div>
		</div>
		<div class="col-md-4 service-page-left text-center visible-md visible-lg">
			<div class="theme-material-card">
				<div class="sub-ttl"><?php echo $lang['text_our_services']; ?></div>
				<ul class="category-list">
					<?php foreach ($services as $key => $value) { ?>
						<li>
							<?php $name = preg_replace('/[[:space:]]+/', '-', $value['name']); ?>
							<a href="<?php echo URL.DIR_ROUTE.'service&name='.$value['service_url']; ?>">
								<i class="fa fa-<?php echo $value['icon']; ?>"></i><?php echo $value['name']; ?>
							</a>
						</li>
					<?php } ?>
				</ul>
			</div>
		</div>
	</div>
</div><!-- End Service List Section -->
<!-- Start Facility List Section -->

<?php echo $footer; ?>