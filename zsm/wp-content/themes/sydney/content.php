<?php
/**
 * @package Sydney
 */
?>

<?php do_action( 'sydney_before_loop_entry' ); ?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="content-inner">
		<?php do_action( 'sydney_loop_post' ); ?>
	</div>
</article><!-- #post-## -->
<?php do_action( 'sydney_after_loop_entry' ); ?>