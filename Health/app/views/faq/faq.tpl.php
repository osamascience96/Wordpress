<?php echo $header; ?>
<!-- Start Faq Section -->
<div class="layer-stretch animated-wrapper">
	<div class="layer-wrapper">
		<div class="theme-accordion-container">
			<?php if (!empty($page['page_data'])) { foreach ($page['page_data'] as $key => $value) { ?>
				<div class="faq-block animated animated-up d-none">
					<div class="paragraph-medium paragraph-black faq-q"><b><?php echo $lang['text_question']; ?> : </b> <?php echo $value['q']; ?></div>
					<div class="paragraph-medium paragraph-black faq-a"><b><?php echo $lang['text_answer']; ?> : </b> <?php echo $value['a']; ?></div>
				</div>
			<?php } } ?>

			<?php if (!empty($page['page_data'])) { foreach ($page['page_data'] as $key => $value) { ?>
				<div class="theme-accordion">
					<div class="theme-accordion-hdr">
						<h4><i class="far fa-question-circle"></i><?php echo $value['q']; ?></h4>
						<div class="theme-accordion-control"><i class="ti-plus"></i></div>
					</div>
					<div class="theme-accordion-bdy">
						<div class="service-accordian">
							<p class="paragraph-medium paragraph-black">
								<i class="far fa-clipboard theme-dropcap"></i>
								<?php echo $value['a']; ?>
							</p>
						</div>
					</div>
				</div>
			<?php } } ?>



		</div>
	</div>
</div><!-- End FAQ Section -->
<?php echo $footer; ?>