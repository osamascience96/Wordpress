( function( $ ) {
	"use strict";

	/*
	 * Change Tabs.
	 */
	$( document ).on( 'click', '.thd-panel-tabs .thd-panel-tab a', function( e ) {

		let $index = $( this ).closest( '.thd-panel-tab' ).index();

		// Nav Tabs.
		$( this ).closest( '.thd-panel-tab' ).addClass( 'thd-panel-tab-active' ).siblings().removeClass( 'thd-panel-tab-active' );

		// Content Tabs.
		$( '.thd-panel-content-tabs .thd-panel-tab' ).eq( $index ).addClass( 'thd-panel-tab-active' ).siblings().removeClass( 'thd-panel-tab-active' );

		e.preventDefault();
	} );

	/*
	 * Go Starter.
	 */
	$( document ).on( 'click', '.thd-hero-go', function( e ) {

		if ( 'redirect' === $( this ).data( 'target' ) && ! $( this ).hasClass( 'init' ) ) {

			var $href = $( this ).attr( 'href' );

			var $caption = $( this ).html();

			var $self = this;

			var data = {
				'action' : 'thd_install_starter_plugin',
				'nonce' : thd_localize.nonce
			};

			$( $self ).addClass( 'init' );

			$( $self ).parent().siblings( '.thd-hero-warning' ).remove();

			$( $self ).html( '<i class="dashicons dashicons-update-alt"></i> Installing…' );

			// Send Request.
			$.post( thd_localize.ajax_url, data, function( responsive ) {

				if ( responsive.success ) {

					$( $self ).html( '<i class="dashicons dashicons-saved"></i> Activated' );

					setTimeout( function() {

						$( $self ).html( 'Redirecting…' );

						$( $self ).parent().siblings( '.thd-hero-warning' ).remove();

						setTimeout( function() {

							window.location = $href;

						}, 1000 );

					}, 500 );

				} else if ( responsive.data ) {
					$( $self ).html( $caption );

					$( $self ).parent().after( `<div class="thd-hero-warning">${responsive.data}</div>` );

					$( $self ).removeClass( 'init' );
				} else {
					$( $self ).html( $caption );

					$( $self ).parent().after( `<div class="thd-hero-warning">${thd_localize.failed_message}</div>` );

					$( $self ).removeClass( 'init' );
				}

			} ).fail( function( xhr, textStatus, e ) {
				$( $self ).html( $caption );

				$( $self ).parent().after( `<div class="thd-hero-warning">${thd_localize.failed_message}</div>` );

				$( $self ).removeClass( 'init' );
			} );

			e.preventDefault();
		}
	} );


	/*
	 * Help toggle
	 */
	$( document ).on( 'click', '.thd-feature-help', function( e ) {
		$( this ).toggleClass( 'is-active' );
		$( this ).next( '.thd-feature-help-text' ).fadeToggle( 'fast' );
	} );	

} )( jQuery );
