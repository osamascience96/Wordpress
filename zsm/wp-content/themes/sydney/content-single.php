<?php
/**
 * @package Sydney
 */
?>

<?php 
$disable_title 					= get_post_meta( $post->ID, '_sydney_page_disable_title', true );
$disable_featured 				= get_post_meta( $post->ID, '_sydney_page_disable_post_featured', true );
$single_post_image_placement 	= get_theme_mod( 'single_post_image_placement', 'below' );
$single_post_meta_position		= get_theme_mod( 'single_post_meta_position', 'below-title' );
?>

<?php do_action( 'sydney_before_single_entry' ); ?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="content-inner">
	<?php do_action('sydney_inside_top_post'); ?>

	<?php if ( 'above' === $single_post_image_placement ) : ?>
		<?php sydney_single_post_thumbnail( $disable_featured, $class = 'feat-img-top' ); ?>
	<?php endif; ?>

	<?php if ( !$disable_title ) : ?>
	<header class="entry-header">
		<?php if ( 'post' === get_post_type() && 'above-title' === $single_post_meta_position ) : ?>
			<?php sydney_single_post_meta( 'entry-meta-above' ); ?>
		<?php endif; ?>

		<?php the_title( '<h1 class="title-post entry-title" ' . sydney_get_schema( "headline" ) . '>', '</h1>' ); ?>

		<?php if ( 'post' === get_post_type() && 'below-title' === $single_post_meta_position ) : ?>
			<?php sydney_single_post_meta( 'entry-meta-below' ); ?>
		<?php endif; ?>
	</header><!-- .entry-header -->
	<?php endif; ?>

	<?php if ( 'below' === $single_post_image_placement ) : ?>
		<?php sydney_single_post_thumbnail( $disable_featured ); ?>
	<?php endif; ?>	

	<div class="entry-content" <?php sydney_do_schema( 'entry_content' ); ?>>
		<?php the_content(); ?>
		<?php
			wp_link_pages( array(
				'before' => '<div class="page-links">' . __( 'Pages:', 'sydney' ),
				'after'  => '</div>',
			) );
		?>
	</div><!-- .entry-content -->

	<footer class="entry-footer">
		<?php sydney_entry_footer(); ?>
	</footer><!-- .entry-footer -->

	<?php do_action('sydney_inside_bottom_post'); ?>
	</div>

</article><!-- #post-## -->
<?php do_action( 'sydney_after_single_entry' ); ?>