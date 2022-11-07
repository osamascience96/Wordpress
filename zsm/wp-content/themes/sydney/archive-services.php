<?php
/**
 * Services archives template
 *
 * @package Sydney
 */

get_header(); ?>

	<?php do_action('sydney_before_content'); ?>

	<div id="primary" class="content-area">
		<main id="main" class="post-wrap" role="main">

		<?php 
			// Get fontawesome prefix
			$fa_prefix = sydney_get_fontawesome_prefix( 'fab ' );
		
			if ( have_posts() ) :
				while ( have_posts() ) : the_post(); ?>

				<?php $icon = get_post_meta( get_the_ID(), 'wpcf-service-icon', true ); ?>
				<?php $servicelink = get_post_meta( get_the_ID(), 'wpcf-service-link', true ); ?>
				<div class="service col-md-4">
					<div class="roll-icon-box">
						<?php if ($icon) : ?>
						<div class="icon">
						<?php if ($servicelink) : ?>
							<?php echo '<a href="' . esc_url( $servicelink ) . '"><i class="' . esc_html( $fa_prefix . $icon ) . '"></i></a>'; ?>
						<?php else : ?>
							<?php echo '<i class="' . esc_html( $fa_prefix . $icon ) . '"></i>'; ?>
						<?php endif; ?>
						</div>
						<?php endif; ?>							
						<div class="content">
							<h3>
								<?php if ($servicelink) : ?>
								<a href="<?php echo esc_url($servicelink); ?>"><?php the_title(); ?></a>
								<?php else : ?>
								<?php the_title(); ?>
								<?php endif; ?>
							</h3>
							<?php the_content(); ?>
						</div>	
					</div>
				</div>
			<?php endwhile; ?>

		<?php
			the_posts_pagination( array(
				'mid_size'  => 1,
			) );
		?>

		<?php else : ?>

			<?php get_template_part( 'content', 'none' ); ?>

		<?php endif; ?>

		</main><!-- #main -->
	</div><!-- #primary -->

	<?php do_action('sydney_after_content'); ?>

<?php get_footer(); ?>
