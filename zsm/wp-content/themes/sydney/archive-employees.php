<?php
/**
 * Services archives template
 *
 * @package Sydney
 */

get_header(); ?>

	<?php do_action('sydney_before_content'); ?>

	<div id="primary" class="content-area">
		<main id="main" class="post-wrap roll-team no-carousel" role="main">

		<?php if ( have_posts() ) : ?>

			<?php while ( have_posts() ) : the_post(); ?>
				<?php //Get the custom field values
					$photo 	  = get_post_meta( get_the_ID(), 'wpcf-photo', true );
					$position = get_post_meta( get_the_ID(), 'wpcf-position', true );
					$facebook = get_post_meta( get_the_ID(), 'wpcf-facebook', true );
					$twitter  = get_post_meta( get_the_ID(), 'wpcf-twitter', true );
					$google   = get_post_meta( get_the_ID(), 'wpcf-google-plus', true );
					$emplink     = get_post_meta( get_the_ID(), 'wpcf-custom-link', true );
				?>
			<div class="team-item col-md-4">
			    <div class="team-inner">
					<?php if ( has_post_thumbnail() ) : ?>
					<div class="avatar">
						<?php the_post_thumbnail('employees-image'); ?>
					</div>
					<?php endif; ?>
			    </div>
			    <div class="team-content">
			        <div class="name">
			        	<?php if ($emplink == '') : ?>
			        		<?php the_title(); ?>
			        	<?php else : ?>
			        		<a href="<?php echo esc_url($emplink); ?>"><?php the_title(); ?></a>
			        	<?php endif; ?>
			        </div>
			        <div class="pos"><?php echo esc_html($position); ?></div>

						<?php 
						// Get fontawesome prefix
						$fa_prefix = sydney_get_fontawesome_prefix( 'fab ' ); ?>
							
						<ul class="team-social">
							<?php if ($facebook != '') : ?>
								<li><a class="facebook" href="<?php echo esc_url($facebook); ?>" target="_blank"><i class="<?php echo esc_attr( $fa_prefix ); ?>fa-facebook"></i></a></li>
							<?php endif; ?>
							<?php if ($twitter != '') : ?>
								<li><a class="twitter" href="<?php echo esc_url($twitter); ?>" target="_blank"><i class="<?php echo esc_attr( $fa_prefix ); ?>fa-twitter"></i></a></li>
							<?php endif; ?>
							<?php if ($google != '') : ?>
								<li><a class="google" href="<?php echo esc_url($google); ?>" target="_blank"><i class="<?php echo esc_attr( $fa_prefix ); ?>fa-google-plus"></i></a></li>
							<?php endif; ?>
						</ul>			        
			    </div>
			</div><!-- /.team-item -->
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
