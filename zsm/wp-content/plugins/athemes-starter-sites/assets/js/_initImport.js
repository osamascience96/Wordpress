/**
 * Import.
 */

import {
	$,
	$window,
	$doc,
	$body
} from './utility';

/*
 * Open import demo.
 */
$( document ).on( 'click', '.atss-demo-import-open', function( e ) {

	var $this = this;

	// Get demo id.
	var $demo_id = $( $this ).data( 'id' );

	// Body import.
	$( 'body' ).addClass( 'atss-import-theme-active' );

	// Variables.
	var data = {
		'action': 'atss_html_import_data',
		'nonce': atss_localize.nonce,
		'demo_id': $demo_id,
	};

	// Reset current step.
	$( '.atss-import-step' ).removeClass( 'atss-import-step-active' );
	$( '.atss-import-step' ).first().addClass( 'atss-import-step-active' );

	// Remove warning.
	$( '.atss-import-theme .atss-msg-warning' ).remove();

	// Reset variables.
	$( '.atss-import-start .atss-import-output' ).html( '' );

	$( '.atss-import-start .atss-import-output' ).addClass( 'atss-import-load' );

	$( '.atss-import-process .atss-import-progress-label' ).html( '' );

	$( '.atss-import-process .atss-import-progress-indicator' ).attr( 'style', '--atss-indicator: 0%;' );

	$( '.atss-import-process .atss-import-progress-sublabel' ).html( '0%' );

	// Send Request.
	$.post( atss_localize.ajax_url, data, function( response ) {

		$( '.atss-import-start .atss-import-output' ).removeClass( 'atss-import-load' );

		if ( response.success ) {

			$( '.atss-import-start .atss-import-output' ).html( response.data );

		} else if ( response.data ) {

			$( '.atss-import-start .atss-import-output' ).html( `<div class="atss-msg-warning">${response.data}</div>` );
		} else {

			$( '.atss-import-start .atss-import-output' ).html( `<div class="atss-msg-warning">${atss_localize.failed_message}</div>` );
		}

	} ).fail( function( xhr, textStatus, e ) {
		$( '.atss-import-start .atss-import-output' ).removeClass( 'atss-import-load' );

		$( '.atss-import-start .atss-import-output' ).html( `<div class="atss-msg-warning">${atss_localize.failed_message}</div>` );
	} );

	e.preventDefault();
} );

/*
 * Close import.
 */
$( document ).on( 'click', '.atss-demo-import-close, .atss-import-overlay', function( e ) {

	// Remove import from body.
	$( 'body' ).removeClass( 'atss-import-theme-active' );

	e.preventDefault();
} );

/*
 * Import Indicator.
 */
function atssImportIndicator( $this, $e, $data ) {
	// Set indicator.
	var indicator = Math.round( 100 / $data.steps * $data.index );

	// Change indicator.
	$( '.atss-import-process .atss-import-progress-indicator' ).attr( 'style', `--atss-indicator: ${indicator}%;` );
	$( '.atss-import-process .atss-import-progress-sublabel' ).html( `${indicator}%` );
}

/*
 * Import Step.
 */
function atssImportStep( $this, $e, $data ) {

	if ( ! $( 'body' ).hasClass( 'atss-import-theme-active' ) ) {
		return;
	}

	// Done.
	if ( $data.index >= $data.steps ) {
		// Change step.
		setTimeout(function(){
			$( '.atss-import-step' ).removeClass( 'atss-import-step-active' );
			$( '.atss-import-finish' ).addClass( 'atss-import-step-active' );

			$( document ).trigger( 'DOMImportFinish' );
		}, 200 );

		return;
	}

	// Set progress label.
	$( '.atss-import-progress-label' ).html( $( $data.forms ).eq( $data.index ).find( 'input[name="step_name"]').val()  );

	// Send Request.
	$.post( {
		url: atss_localize.ajax_url,
		type: 'POST',
		data: $( $data.forms ).eq( $data.index ).serialize(),
		timeout: 0,
	} ).done( function( response ) {

		if ( response.success ) {

			if ( 'undefined' !== typeof response.status && 'newAJAX' === response.status ) {

				atssImportStep( $this, $e, $data );

			} else {
				$data.index = $data.index + 1;

				atssImportIndicator( $this, $e, $data );
				atssImportStep( $this, $e, $data );
			}

		} else if ( response.data ) {

			$( '.atss-import-progress' ).after( `<div class="atss-msg-warning">${response.data}</div>` );
		} else {

			$( '.atss-import-progress' ).after( `<div class="atss-msg-warning">${atss_localize.failed_message}</div>` );
		}

	} ).fail( function() {
		$( '.atss-import-progress' ).after( `<div class="atss-msg-warning">${atss_localize.failed_message}</div>` )
	} );
}

/*
 * Import Content.
 */
function atssImportContent( $this, $e ) {
	var forms = $( '.atss-import-start form' ).filter(function( index, element ){
		if ( $( element ).find( '.atss-checkbox' ).prop( 'checked' ) ) {
			return true;
		} else {
			return false;
		}
	});

	var steps = forms.length;

	if ( steps <= 0 ) {
		return
	}

	atssImportStep( $this, $e, {
		'forms': forms,
		'steps': steps,
		'index': 0
	} );
}

/*
 * Start import.
 */
$( document ).on( 'click', '.atss-demo-import-start', function( e ) {

	var $this = this;

	var $e = e;

	// Change process.
	$( '.atss-import-step' ).removeClass( 'atss-import-step-active' );
	$( '.atss-import-process' ).addClass( 'atss-import-step-active' );

	// Run Import.
	setTimeout( function() {
		atssImportContent( $this, $e );
	}, 10 );

	e.preventDefault();
} );
