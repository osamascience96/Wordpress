/**
 * Demos.
 */

import {
	$,
	$window,
	$doc,
	$body
} from './utility';

/*
 * Filter.
 */
function atssDemosFilter() {
	var atssCategory = $( '.atss-categories-select' ).val();
	var atssBuilder  = $( '.atss-builders-select' ).val();

	// Remove active.
	$( `.atss-demos .atss-demo-item` ).removeClass( 'atss-demo-item-active' );

	// Add active.
	$( `.atss-demos .atss-demo-item[data-categories*="[${atssCategory}]"][data-builders*="[${atssBuilder}]"]` ).addClass( 'atss-demo-item-active' );
}

/*
 * Category Select.
 */
$( document ).on( 'change', '.atss-categories-select', function( e ) {
	atssDemosFilter();

	e.preventDefault();
} );

/*
 * Builder Select.
 */
$( document ).on( 'change', '.atss-builders-select', function( e ) {
	atssDemosFilter();

	e.preventDefault();
} );
