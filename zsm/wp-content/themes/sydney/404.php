<?php
/**
 * The template for displaying 404 pages (not found).
 *
 * @package Sydney
 */

get_header(); ?>

	<div id="primary" class="content-area col-md-12">
		<main id="main" class="site-main" role="main">
			<?php do_action( 'sydney_404_content' ); ?>
		</main><!-- #main -->
	</div><!-- #primary -->

<?php get_footer(); ?>
