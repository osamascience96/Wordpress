<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @package Sydney
 */

get_header(); 

$sidebar_pos = sydney_sidebar_position();

//Get classes for main content area
if ( apply_filters( 'sydney_disable_cart_checkout_sidebar', true ) && class_exists( 'WooCommerce' ) && ( is_checkout() || is_cart() ) ) {
	$width = 'col-md-12';
} else {
	$width = 'col-md-9';
}
?>

	<div id="primary" class="content-area <?php echo esc_attr( $sidebar_pos ); ?> <?php echo esc_attr( apply_filters( 'sydney_content_area_class', $width ) ); ?>">
		<main id="main" class="post-wrap" role="main">

			<?php while ( have_posts() ) : the_post(); ?>

				<?php get_template_part( 'content', 'page' ); ?>

				<?php
					// If comments are open or we have at least one comment, load up the comment template
					if ( comments_open() || get_comments_number() ) :
						comments_template();
					endif;
				?>

			<?php endwhile; // end of the loop. ?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php do_action( 'sydney_get_sidebar' ); ?>
<?php get_footer(); ?>
