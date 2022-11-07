<?php
/*
Template Name: Front Page
*/

get_header(); ?>

	<div id="primary" class="fp-content-area">
		<main id="main" class="site-main" role="main">

			<div class="entry-content">
				<?php while ( have_posts() ) : the_post(); ?>
					<?php the_content(); ?>
				<?php endwhile; ?>
			</div><!-- .entry-content -->

		</main><!-- #main -->
	</div><!-- #primary -->

<?php get_footer(); ?>
