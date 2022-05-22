<!-- Start Doctor Card 1 -->
<div class="theme-block theme-block-hover animated animated-up">
	<div class="theme-block-picture">
		<img src="public/uploads/<?php echo $value['picture']; ?>" alt="<?php echo $value['name']; ?>">
	</div>
	<div class="doctor-name">
		<h4><a><?php echo $value['name']; ?></a></h4>
	</div>
	<div class="doctor-details">
		<div class="doctor-specility">
			<p><?php echo $value['about']['specility']; ?></p>
		</div>
		<div class="doctor-details-extra">
			<p><i class="fas fa-shield-alt"></i><?php echo $value['about']['position']; ?></p>
			<p><i class="fas fa-graduation-cap"></i><?php echo $value['about']['degree']; ?></p>
			<p><i class="fas fa-award"></i><?php echo $lang['text_awards'].': '.$value['about']['awards']; ?></p>
			<p><i class="fas fa-star-of-david"></i><?php echo $lang['text_experience'].': '.$value['about']['experience'].' '.$lang['text_year']; ?></p>
		</div>
	</div>
	<div class="doctor-social">
		<ul class="social-list social-list-bordered social-list-rounded">
			<?php if (!empty($value['social']['facebook'])) { ?>
				<li><a href="<?php echo $value['social']['facebook']; ?>" class="fab fa-facebook" target="_blank"></a></li>
			<?php } if (!empty($value['social']['twitter'])) { ?>
				<li><a href="<?php echo $value['social']['twitter']; ?>" class="fab fa-twitter" target="_blank"></a></li>
			<?php } if (!empty($value['social']['google'])) { ?>
				<li><a href="<?php echo $value['social']['google']; ?>" class="fab fa-google" target="_blank"></a></li>
			<?php } if (!empty($value['social']['instagram'])) { ?>
				<li><a href="<?php echo $value['social']['instagram']; ?>" class="fab fa-instagram" target="_blank"></a></li>
			<?php } ?>
		</ul>
	</div>
</div><!-- End Doctor Card 1 -->