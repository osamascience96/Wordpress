<?php
/*
Template Name: Page builder ready
Template Post Type: post, projects, employees
*/

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

		<?php
			while ( have_posts() ) : the_post();
				the_content();
			endwhile;
		?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_footer();
