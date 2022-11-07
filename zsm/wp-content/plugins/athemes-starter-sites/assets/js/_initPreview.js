/**
 * Preview.
 */

import {
	$,
	$window,
	$doc,
	$body
} from './utility';

/*
 * Open preview.
 */
function atssOpenPreview( $this, e ) {
	let demo_id = $( $this ).data( 'id' );
	let preview = $( $this ).data( 'preview' );
	let name = $( $this ).data( 'name' );
	let type = $( $this ).data( 'type' );

	if ( 'false' === preview ) {
		return;
	}

	// Remove current class from siblings items.
	$( $this ).siblings().removeClass( 'atss-demo-item-open' );

	// Current item.
	$( $this ).addClass( 'atss-demo-item-open' );

	// Set demo id.
	$( '.atss-preview .atss-demo-import-open' ).attr( 'data-id', demo_id );

	// Prev Next Buttons.
	$( '.atss-preview' ).find( '.atss-prev-demo, .atss-next-demo' ).removeClass( 'atss-inactive' );

	let prev = $( $this ).prev( '.atss-demo-item-active' );
	if ( prev.length <= 0 ) {
		$( '.atss-preview .atss-prev-demo' ).addClass( 'atss-inactive' );
	}

	let next = $( $this ).next( '.atss-demo-item-active' );
	if ( next.length <= 0 ) {
		$( '.atss-preview .atss-next-demo' ).addClass( 'atss-inactive' );
	}

	// Reset header info.
	$( '.atss-preview .atss-header-info' ).html( '' );

	// Add name to info.
	if ( name ) {
		$( '.atss-preview .atss-header-info' ).append( `<div class="atss-demo-name">${name}</div>` );
	}

	// Add badge to info.
	if ( type ) {
		$( '.atss-preview .atss-header-info' ).append( `<div class="atss-demo-badge atss-badge atss-badge-success">${type}</div>` );
	}

	$( '.atss-preview .atss-preview-actions' ).html( $( $this ).find( '.atss-demo-actions' ).html() );

	// Set url in iframe.
	$( '.atss-preview .atss-preview-iframe' ).attr( 'src', preview );

	// Body preview.
	$( 'body' ).addClass( 'atss-preview-active' );
}

/*
 * Open preview demo.
 */
$( document ).on( 'click', '.atss-demo-item', function( e ) {
	if ( ! $( e.target ).is( '.atss-demo-import-open, .atss-demo-import-url' ) ) {
		atssOpenPreview( this, e );

		e.preventDefault();
	}
} );

/*
 * Open preview prev demo.
 */
$( document ).on( 'click', '.atss-prev-demo', function( e ) {

	var prev = $( '.atss-demo-item-open' ).prev( '.atss-demo-item-active' );

	if ( prev.length > 0 ) {
		atssOpenPreview( prev, e );
	}

	e.preventDefault();
} );

/*
 * Open preview next demo.
 */
$( document ).on( 'click', '.atss-next-demo', function( e ) {

	var next = $( '.atss-demo-item-open' ).next( '.atss-demo-item-active' );

	if ( next.length > 0 ) {
		atssOpenPreview( next, e );
	}

	e.preventDefault();
} );

/*
 * Close preview.
 */
$( document ).on( 'click', '.atss-preview-cancel a', function( e ) {

	// Remove current class from items.
	$( '.atss-demo-item' ).removeClass( 'atss-demo-item-open' );

	// Remove preview from body.
	$( 'body' ).removeClass( 'atss-preview-active' );

	// Remove url from iframe.
	$( '.atss-preview .atss-preview-iframe' ).removeAttr( 'src' );

	e.preventDefault();
} );
