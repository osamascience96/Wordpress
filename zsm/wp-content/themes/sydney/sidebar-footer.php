<?php
/**
 *
 * @package Sydney
 */

//Footer widgets options
$container 	= get_theme_mod( 'footer_container', 'container' );
$layout 	= get_theme_mod( 'footer_widget_areas', '3' );
$alignment 	= get_theme_mod( 'footer_widgets_alignment', 'top' );
$visibility = get_theme_mod( 'footer_widgets_visibility', 'all' );

if ( !is_active_sidebar( 'footer-1' ) || 'disabled' === $layout ) {
	return;
}

switch ($layout) {

	case '4':
	case 'col4-bigleft':
	case 'col4-bigright':	
		$column_no  = 4;
		break;

	case '3':
	case 'col3-bigleft':
	case 'col3-bigright':
		$column_no  = 3;
		break;

	case '2':
	case 'col2-bigleft':
	case 'col2-bigright':
		$column_no  = 2;
		break;

	default:
		$column_no  = 1;
		break;
}

?>

<div id="sidebar-footer" class="footer-widgets visibility-<?php echo esc_attr( $visibility ); ?>">
	<div class="<?php echo esc_attr( $container ); ?>">
		<div class="footer-widgets-grid footer-layout-<?php echo esc_attr( $layout ); ?> align-<?php echo esc_attr( $alignment ); ?>">
		<?php for ( $i = 1; $i <= $column_no; $i++ ) { ?>
			<?php if ( is_active_sidebar( 'footer-' . $i ) ) : ?>
			<div class="sidebar-column">
				<?php dynamic_sidebar( 'footer-' . $i); ?>
			</div>
			<?php endif; ?>	
		<?php } ?>
		</div>
	</div>
</div>	