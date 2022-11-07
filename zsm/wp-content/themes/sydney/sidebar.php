<?php
/**
 * The sidebar containing the main widget area.
 *
 * @package Sydney
 */

if ( ! is_active_sidebar( 'sidebar-1' ) ) {
	return;
}
?>

<div id="secondary" class="widget-area col-md-3" role="complementary" <?php sydney_do_schema( 'sidebar' ); ?>>
	<?php dynamic_sidebar( 'sidebar-1' ); ?>
</div><!-- #secondary -->
