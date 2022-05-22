<?php echo $header; ?>
<!-- Start Blog Section -->
<div id="blog-page" class="layer-stretch">
	<div class="layer-wrapper layer-bottom-0">
		<div class="row">
			<div class="col-md-8 text-left">
				<?php if(!empty($success)) { ?>
				<div class="alert alert-success"><?php echo $success; ?></div>
				<?php } if(!empty($error)) { ?>
				<div class="alert alert-danger"><?php echo $error; ?></div>
				<?php } ?>
				<div class="theme-material-card">
					<div class="theme-img blog-picture text-center">
						<img src="<?php echo 'public/uploads/'.$blog['picture']; ?>" alt="">
					</div>
					<h2 class="blog-page-ttl text-center pt-4 pb-2"><?php echo $blog['title']; ?></h2>
					<ul class="blog-detail text-center">
						<li><i class="far fa-user-circle"></i><?php echo $blog['author']; ?></li>
						<li><i class="far fa-calendar-alt"></i><?php echo date_format(date_create($blog['date_of_joining']),"d M Y"); ?></li>
						<li><i class="far fa-comment"></i><?php if (!empty($comments)) { echo count($comments); } else { echo "0"; } ?></li>
					</ul>
					<div class="blog-post">
						<div class="paragraph-medium paragraph-black"><?php echo html_entity_decode($blog['long_post'], ENT_QUOTES, 'UTF-8'); ?></div>
					</div>
					<div class="row blog-meta">
						<div class="col-12 text-right">
							<ul class="social-list social-list-sm">
								<li>
									<a onclick="shareinsocialmedia('https://www.facebook.com/sharer/sharer.php?u=<?php echo $share_url;?>&title=<?php echo $blog['title'];?>')"><i class="fab fa-facebook"></i></a>
								</li>
								<li>
									<a onclick="shareinsocialmedia('http://twitter.com/home?status=<?php echo $blog['title']; ?>+<?php echo $share_url; ?>')"><i class="fab fa-twitter"></i></a>
								</li>
								<li>
									<a onclick="shareinsocialmedia('https://plus.google.com/share?url=<?php echo $share_url; ?>')"><i class="fab fa-google"></i></a>
								</li>
								<li>
									<a onclick="shareinsocialmedia('http://www.linkedin.com/shareArticle?mini=true&url=<?php echo $share_url; ?>&title=<?php echo $blog['title']; ?>')"><i class="fab fa-linkedin"></i></a>
								</li>
							</ul>
						</div>
					</div>
				</div>
				<div class="theme-material-card">
					<div class="sub-ttl"><?php echo $lang['text_comments']; ?> (<?php if (!empty($comments)) { echo count($comments); } else { echo "0"; } ?>)</div>
					<ul class="comment-list">
						<?php if (!empty($comments)) { foreach ($comments as $key => $value) { ?>
						<li>
							<div class="row">
								<div class="col-auto hidden-xs text-center comment-icon">
									<i class="far fa-user-circle fa-3x"></i>
								</div>
								<div class="col pl-0 comment-detail text-left">
									<div class="comment-meta">
										<span><?php echo $value['author']; ?></span>
										<span><?php echo date_format(date_create($value['date_of_joining']), $siteinfo['date_format']); ?></span>
									</div>
									<div class="comment-post">
										<?php echo $value['content']; ?>
									</div>
								</div>
							</div>
						</li>
						<?php } } else { ?>
						<li class="text-center font-18"><?php echo $lang['text_no_comments_found']; ?></li>
						<?php } ?>
					</ul>
				</div>
				<div class="theme-material-card text-center">
					<div class="sub-ttl layer-ttl-white"><?php echo $lang['text_leave_a_reply']; ?></div>
					<?php if ($whocan['comment']) { ?>
					<form class="row comment-form text-center" action="<?php echo URL.DIR_ROUTE; ?>comment" method="post" enctype="multipart/form-data">
						<div class="col-sm-6">
							<input type="hidden" name="_token" value="<?php echo $token; ?>" required>
							<input type="hidden" name="blog_id" value="<?php echo $blog['id'] ?>" required>
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
								<label for="comment-message"><?php echo $lang['text_your_comment']; ?></label>
							</div>
						</div>
						<div class="col-sm-12">
							<div class="form-submit">
								<button type="submit" name="submit" class="btn btn-primary"><?php echo $lang['text_submit']; ?></button>
							</div>
						</div>
					</form>
					<?php } else { ?>
					<p class="font-16"><?php echo $lang['text_you_must_be_registered_and_logged_in_to_comment']; ?></p>
					<a href="<?php echo URL.DIR_ROUTE."login"; ?>" class="mdl-button mdl-js-button mdl-js-ripple-effect button button-primary"><?php echo $lang['text_login']; ?></a>
					<?php } ?>
				</div>
			</div>
			<div class="col-md-4">
				<?php include DIR.'app/views/blog/blog-sidebar-1.tpl.php'; ?>
			</div>
		</div>
	</div>
</div><!-- End Blog Section -->

<script type="text/javascript" async >
	function shareinsocialmedia(url){
		window.open(url,'sharein','toolbar=0,status=0,width=648,height=405');
		return true;
	}
</script>
<?php echo $footer; ?>
