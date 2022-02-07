/* global WPForms, WPFormsBuilder, wpforms_challenge_admin, WPFormsFormEmbedWizard */
/**
 * WPForms Challenge function.
 *
 * @since 1.5.0
 * @since 1.6.2 Challenge v2
 */
'use strict';

var WPFormsChallenge = window.WPFormsChallenge || {};

WPFormsChallenge.builder = window.WPFormsChallenge.builder || ( function( document, window, $ ) {

	/**
	 * Public functions and properties.
	 *
	 * @since 1.5.0
	 *
	 * @type {object}
	 */
	var app = {

		/**
		 * Start the engine.
		 *
		 * @since 1.5.0
		 */
		init: function() {

			$( app.ready );
			$( window ).on( 'load', function() {

				// in case of jQuery 3.+ we need to wait for an `ready` event first.
				if ( typeof $.ready.then === 'function' ) {
					$.ready.then( app.load );
				} else {
					app.load();
				}
			} );
		},

		/**
		 * Document ready.
		 *
		 * @since 1.5.0
		 */
		ready: function() {

			app.setup();
			app.events();
		},

		/**
		 * Window load.
		 *
		 * @since 1.5.0
		 */
		load: function() {

			if ( [ 'started', 'paused' ].indexOf( wpforms_challenge_admin.option.status ) > -1 ) {
				WPFormsChallenge.core.updateTooltipUI();
				app.gotoStep();
			}

			$( '.wpforms-challenge' ).show();
		},

		/**
		 * Initial setup.
		 *
		 * @since 1.5.0
		 */
		setup: function() {

			if ( wpforms_challenge_admin.option.status === 'inited' ) {
				WPFormsChallenge.core.clearLocalStorage();
				app.showWelcomePopup();
			}

			$( '#wpforms-embed' ).addClass( 'wpforms-disabled' );

			var tooltipAnchors = [
				'#wpforms-setup-name',
				'.wpforms-setup-title .wpforms-setup-title-after',
				'#add-fields a i',
				'#wpforms-builder-settings-notifications-title',
			];

			$.each( tooltipAnchors, function( i, anchor ) {

				WPFormsChallenge.core.initTooltips( i + 1, anchor, null );
			} );
		},

		/**
		 * Register JS events.
		 *
		 * @since 1.5.0
		 */
		events: function() {

			// Start the Challenge.
			$( '#wpforms-challenge-welcome-builder-popup' ).on( 'click', 'button', app.startChallenge );

			// Step 1.
			$( '.wpforms-challenge-step1-done' ).on( 'click', function() {
				WPFormsChallenge.core.stepCompleted( 1 );
			} );

			$( '#wpforms-builder' )

				// Register select template event when the setup panel is ready.
				.on( 'wpformsBuilderSetupReady', function() {
					app.eventSelectTemplate();
				} )

				// Restore tooltips when switching builder panels/sections.
				.on( 'wpformsPanelSwitch wpformsPanelSectionSwitch', function() {
					WPFormsChallenge.core.updateTooltipUI();
				} );

			// Step 3 - Add fields.
			$( '.wpforms-challenge-step3-done' ).on( 'click', function() {
				WPFormsChallenge.core.stepCompleted( 3 );
				app.gotoStep( 4 );
			} );

			// Step 4 - Notifications.
			$( document ).on( 'click', '.wpforms-challenge-step4-done', app.showEmbedPopup );

			// Tooltipster ready.
			$.tooltipster.on( 'ready', app.tooltipsterReady );
		},

		/**
		 * Register select template event.
		 *
		 * @since 1.6.8
		 */
		eventSelectTemplate: function() {

			$( '#wpforms-panel-setup' )

				// Step 2 - Select the Form template.
				.off( 'click', '.wpforms-template-select' ) // Intercept Form Builder's form template selection and apply own logic.
				.on( 'click', '.wpforms-template-select', function( e ) {
					app.builderTemplateSelect( this, e );
				} );
		},

		/**
		 * Start the Challenge.
		 *
		 * @since 1.6.2
		 */
		startChallenge: function() {

			WPFormsChallenge.admin.saveChallengeOption( { status: 'started' } );
			WPFormsChallenge.core.initListUI( 'started' );
			$( '.wpforms-challenge-popup-container' ).fadeOut( function() {
				$( '#wpforms-challenge-welcome-builder-popup' ).hide();
			} );
			WPFormsChallenge.core.timer.run( WPFormsChallenge.core.timer.initialSecondsLeft );
			WPFormsChallenge.core.updateTooltipUI();
		},

		/**
		 * Go to Step.
		 *
		 * @since 1.6.2
		 *
		 * @param {number|string} step Last saved step.
		 */
		gotoStep: function( step ) { // eslint-disable-line

			step = step || ( WPFormsChallenge.core.loadStep() + 1 );

			switch ( step ) {
				case 1:
				case 2:
					WPFormsBuilder.panelSwitch( 'setup' );
					break;

				case 3:
					WPFormsBuilder.panelSwitch( 'fields' );
					break;

				case 4:
					WPFormsBuilder.panelSwitch( 'settings' );
					WPFormsBuilder.panelSectionSwitch( $( '.wpforms-panel .wpforms-panel-sidebar-section-notifications' ) );
					break;

				case 5:
					app.showEmbedPopup();
					break;
			}
		},

		/**
		 * Save the second step before a template is selected.
		 *
		 * @since 1.5.0
		 *
		 * @param {string} el Element selector.
		 * @param {object} e  Event.
		 */
		builderTemplateSelect: function( el, e ) {

			if ( wpforms_challenge_admin.option.status === 'paused' ) {
				WPFormsChallenge.core.resumeChallenge();
			}

			var step = WPFormsChallenge.core.loadStep();

			if ( step <= 1 ) {
				WPFormsChallenge.core.stepCompleted( 2 )
					.done( WPForms.Admin.Builder.Setup.selectTemplate.bind( null, e ) );
				return;
			}

			WPForms.Admin.Builder.Setup.selectTemplate.bind( null, e );
		},

		/**
		 * Tooltipster ready event callback.
		 *
		 * @since 1.6.2
		 *
		 * @param {object} e Event object.
		 */
		tooltipsterReady: function( e ) {

			var step = $( e.origin ).data( 'wpforms-challenge-step' );
			var formId = $( '#wpforms-builder-form' ).data( 'id' );

			step = parseInt( step, 10 ) || 0;
			formId = parseInt( formId, 10 ) || 0;

			// Save challenge form ID right after it's created.
			if ( 3 === step && formId > 0 ) {
				WPFormsChallenge.admin.saveChallengeOption( { form_id: formId } ); // eslint-disable-line camelcase
			}
		},

		/**
		 * Display 'Welcome to the Form Builder' popup.
		 *
		 * @since 1.6.2
		 */
		showWelcomePopup: function() {

			$( '#wpforms-challenge-welcome-builder-popup' ).show();
			$( '.wpforms-challenge-popup-container' ).fadeIn();
		},

		/**
		 * Display 'Embed in a Page' popup.
		 *
		 * @since 1.6.2
		 */
		showEmbedPopup: function() {

			WPFormsChallenge.core.stepCompleted( 4 );
			WPFormsFormEmbedWizard.openPopup();
		},
	};

	// Provide access to public functions/properties.
	return app;

}( document, window, jQuery ) );

// Initialize.
WPFormsChallenge.builder.init();
