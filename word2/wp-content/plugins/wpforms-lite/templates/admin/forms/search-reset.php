<?php
/**
 * Search reset block on forms overview page.
 *
 * @since 1.7.2
 *
 * @var string $search_term Current search term.
 * @var int    $count_all   Count all search result.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

?>
<div id="wpforms-reset-filter">
	<?php
	printf(
		wp_kses( /* translators: %1$d - number of forms found, %2$s - search term. */
			_n(
				'Found <strong>%1$d form</strong> containing <em>"%2$s"</em>',
				'Found <strong>%1$d forms</strong> containing <em>"%2$s"</em>',
				(int) $count_all,
				'wpforms-lite'
			),
			[
				'strong' => [],
				'em'     => [],
			]
		),
		(int) $count_all,
		esc_html( $search_term )
	);
	?>
	<i class="reset fa fa-times-circle" title="<?php esc_html_e( 'Clear search and return to All Forms', 'wpforms-lite' ); ?>"></i>
</div>
