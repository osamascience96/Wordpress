<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package Sydney
 */
?>
			</div>
		</div>
	</div><!-- #content -->

	<?php do_action('sydney_before_footer'); ?>

	<?php if ( is_active_sidebar( 'footer-1' ) ) : ?>
		<?php get_sidebar('footer'); ?>
	<?php endif; ?>

	<?php $container 	= get_theme_mod( 'footer_credits_container', 'container' ); ?>
	<?php $credits 		= sydney_footer_credits(); ?>

	<footer id="colophon" class="site-footer">
		<div class="<?php echo esc_attr( $container ); ?>">
			<div class="site-info">
				<div class="row">
					<div class="col-md-6">
						<?php echo wp_kses_post( $credits ); ?>
					</div>
					<div class="col-md-6">
						<?php sydney_social_profile( 'social_profiles_footer' ); ?>
					</div>					
				</div>
			</div>
		</div><!-- .site-info -->
	</footer><!-- #colophon -->

	<?php do_action('sydney_after_footer'); ?>

</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
