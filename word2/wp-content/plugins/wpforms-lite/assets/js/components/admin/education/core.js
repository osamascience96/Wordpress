/* global wpforms_education, WPFormsBuilder */
/**
 * WPForms Education Core.
 *
 * @since 1.6.6
 */

'use strict';

var WPFormsEducation = window.WPFormsEducation || {};

WPFormsEducation.core = window.WPFormsEducation.core || ( function( document, window, $ ) {

	/**
	 * Spinner markup.
	 *
	 * @since 1.7.0
	 *
	 * @type {string}
	 */
	var spinner = '<i class="wpforms-loading-spinner wpforms-loading-white wpforms-loading-inline"></i>';

	/**
	 * Public functions and properties.
	 *
	 * @since 1.6.6
	 *
	 * @type {object}
	 */
	var app = {

		/**
		 * Start the engine.
		 *
		 * @since 1.6.6
		 */
		init: function() {

			$( app.ready );
		},

		/**
		 * Document ready.
		 *
		 * @since 1.6.6
		 */
		ready: function() {

			app.events();
		},

		/**
		 * Register JS events.
		 *
		 * @since 1.6.6
		 */
		events: function() {

			app.dismissEvents();
			app.openModalButtonClick();
		},

		/**
		 * Open education modal.
		 *
		 * @since 1.7.0
		 */
		openModalButtonClick: function() {

			$( document ).on(
				'click',
				'.education-modal',
				function( event ) {

					var $this = $( this );

					event.preventDefault();

					switch ( $this.data( 'action' ) ) {
						case 'activate':
							app.activateModal( $this );
							break;
						case 'install':
							app.installModal( $this );
							break;
					}
				}
			);
		},

		/**
		 * Dismiss button events.
		 *
		 * @since 1.6.6
		 */
		dismissEvents: function() {

			$( '.wpforms-dismiss-container' ).on( 'click', '.wpforms-dismiss-button', function( e ) {

				var $this = $( this ),
					$cont = $this.closest( '.wpforms-dismiss-container' ),
					$out = $cont.find( '.wpforms-dismiss-out' ),
					data = {
						action: 'wpforms_education_dismiss',
						nonce: wpforms_education.nonce,
						section: $this.data( 'section' ),
					};

				if ( $cont.hasClass( 'wpforms-dismiss-out' ) ) {
					$out = $cont;
				}

				if ( $out.length > 0 ) {
					$out.addClass( 'out' );
					setTimeout(
						function() {
							$cont.remove();
						},
						300
					);
				} else {
					$cont.remove();
				}

				$.post( wpforms_education.ajax_url, data );
			} );
		},

		/**
		 * Get UTM content for different elements.
		 *
		 * @since 1.6.9
		 *
		 * @param {jQuery} $el Element.
		 *
		 * @returns {string} UTM content string.
		 */
		getUTMContentValue: function( $el ) {

			// UTM content for Fields.
			if ( $el.hasClass( 'wpforms-add-fields-button' ) ) {
				return $el.data( 'utm-content' ) + ' Field';
			}

			// UTM content for Templates.
			if ( $el.hasClass( 'wpforms-template-select' ) ) {
				return app.slugToUTMcontent( $el.data( 'slug' ) );
			}

			// UTM content for Addons (sidebar).
			if ( $el.hasClass( 'wpforms-panel-sidebar-section' ) ) {
				return app.slugToUTMcontent( $el.data( 'slug' ) ) + ' Addon';
			}

			// UTM content by default with fallback `data-name`.
			return $el.data( 'utm-content' ) || $el.data( 'name' );
		},

		/**
		 * Convert slug to UTM content.
		 *
		 * @since 1.6.9
		 *
		 * @param {string} slug Slug.
		 *
		 * @returns {string} UTM content string.
		 */
		slugToUTMcontent: function( slug ) {

			if ( ! slug ) {
				return '';
			}

			return slug.toString()

				// Replace all non-alphanumeric characters with space.
				.replace( /[^a-z\d ]/gi, ' ' )

				// Uppercase each word.
				.replace( /\b[a-z]/g, function( char ) {
					return char.toUpperCase();
				} );
		},

		/**
		 * Get upgrade URL according to the UTM content and license type.
		 *
		 * @since 1.6.9
		 *
		 * @param {string} utmContent UTM content.
		 * @param {string} type       Feature license type: pro or elite.
		 *
		 * @returns {string} Upgrade URL.
		 */
		getUpgradeURL: function( utmContent, type ) {

			var	baseURL = wpforms_education.upgrade[ type ].url;

			if ( utmContent.toLowerCase().indexOf( 'template' ) > -1 ) {
				baseURL = wpforms_education.upgrade[ type ].url_template;
			}

			// Test if the base URL already contains `?`.
			var appendChar = /(\?)/.test( baseURL ) ? '&' : '?';

			return baseURL + appendChar + 'utm_content=' + encodeURIComponent( utmContent.trim() );
		},

		/**
		 * Addon activate modal.
		 *
		 * @since 1.7.0
		 *
		 * @param {jQuery} $button jQuery button element.
		 */
		activateModal: function( $button  ) {

			var feature = $button.data( 'name' );

			$.alert( {
				title  : false,
				content: wpforms_education.activate_prompt.replace( /%name%/g, feature ),
				icon   : 'fa fa-info-circle',
				type   : 'blue',
				buttons: {
					confirm: {
						text    : wpforms_education.activate_confirm,
						btnClass: 'btn-confirm',
						keys    : [ 'enter' ],
						action  : function() {

							this.$$confirm
								.prop( 'disabled', true )
								.html( spinner + wpforms_education.activating );

							this.$$cancel
								.prop( 'disabled', true );

							app.activateAddon( $button, this );

							return false;
						},
					},
					cancel : {
						text: wpforms_education.cancel,
					},
				},
			} );
		},

		/**
		 * Activate addon via AJAX.
		 *
		 * @since 1.7.0
		 *
		 * @param {jQuery} $button       jQuery button element.
		 * @param {object} previousModal Previous modal instance.
		 */
		activateAddon: function( $button, previousModal ) {

			var path = $button.data( 'path' ),
				pluginType = $button.data( 'type' ),
				nonce = $button.data( 'nonce' ),
				hideOnSuccess = $button.data( 'hide-on-success' );

			$.post(
				wpforms_education.ajax_url,
				{
					action: 'wpforms_activate_addon',
					nonce : nonce,
					plugin: path,
					type  : pluginType,
				},
				function( res ) {

					previousModal.close();

					if ( res.success ) {
						if ( hideOnSuccess ) {
							$button.hide();
						}

						app.saveModal( pluginType === 'plugin' ? wpforms_education.plugin_activated : wpforms_education.addon_activated );
					} else {
						$.alert( {
							title  : false,
							content: res.data,
							icon   : 'fa fa-exclamation-circle',
							type   : 'orange',
							buttons: {
								confirm: {
									text    : wpforms_education.close,
									btnClass: 'btn-confirm',
									keys    : [ 'enter' ],
								},
							},
						} );
					}
				}
			);
		},

		/**
		 * Ask user if they would like to save form and refresh form builder.
		 *
		 * @since 1.7.0
		 *
		 * @param {string} title Modal title.
		 */
		saveModal: function( title ) {

			title = title || wpforms_education.addon_activated;

			$.alert( {
				title  : title.replace( /\.$/, '' ), // Remove a dot in the title end.
				content: wpforms_education.save_prompt,
				icon   : 'fa fa-check-circle',
				type   : 'green',
				buttons: {
					confirm: {
						text    : wpforms_education.save_confirm,
						btnClass: 'btn-confirm',
						keys    : [ 'enter' ],
						action  : function() {

							if ( 'undefined' === typeof WPFormsBuilder ) {
								location.reload();

								return;
							}

							this.$$confirm
								.prop( 'disabled', true )
								.html( spinner + wpforms_education.saving );

							this.$$cancel
								.prop( 'disabled', true );

							if ( WPFormsBuilder.formIsSaved() ) {
								location.reload();
							}

							WPFormsBuilder.formSave().done( function() {
								location.reload();
							} );

							return false;
						},
					},
					cancel : {
						text: wpforms_education.close,
					},
				},
			} );
		},

		/**
		 * Addon install modal.
		 *
		 * @since 1.7.0
		 *
		 * @param {jQuery} $button jQuery button element.
		 */
		installModal: function( $button ) {

			var feature = $button.data( 'name' ),
				url = $button.data( 'url' ),
				licenseType = $button.data( 'license' );

			if ( ! url || '' === url ) {
				app.upgradeModal( feature, '', 'Empty install URL', licenseType, '' );
				return;
			}

			$.alert( {
				title   : false,
				content : wpforms_education.install_prompt.replace( /%name%/g, feature ),
				icon    : 'fa fa-info-circle',
				type    : 'blue',
				boxWidth: '425px',
				buttons : {
					confirm: {
						text    : wpforms_education.install_confirm,
						btnClass: 'btn-confirm',
						keys    : [ 'enter' ],
						isHidden: ! wpforms_education.can_install_addons,
						action  : function() {

							this.$$confirm.prop( 'disabled', true )
								.html( spinner + wpforms_education.installing );

							this.$$cancel
								.prop( 'disabled', true );

							app.installAddon( $button, this );

							return false;
						},
					},
					cancel : {
						text: wpforms_education.cancel,
					},
				},
			} );
		},

		/**
		 * Install addon via AJAX.
		 *
		 * @since 1.7.0
		 *
		 * @param {jQuery} $button       jQuery button element.
		 * @param {object} previousModal Previous modal instance.
		 */
		installAddon: function( $button, previousModal ) {

			var url = $button.data( 'url' ),
				pluginType = $button.data( 'type' ),
				nonce = $button.data( 'nonce' ),
				hideOnSuccess = $button.data( 'hide-on-success' );

			$.post(
				wpforms_education.ajax_url,
				{
					action: 'wpforms_install_addon',
					nonce : nonce,
					plugin: url,
					type  : pluginType,
				},
				function( res ) {

					previousModal.close();

					if ( res.success ) {
						if ( hideOnSuccess ) {
							$button.hide();
						}

						app.saveModal( res.data.msg );
					} else {
						var message = res.data;

						if ( 'object' === typeof res.data ) {
							message = wpforms_education.addon_error;
						}

						$.alert( {
							title  : false,
							content: message,
							icon   : 'fa fa-exclamation-circle',
							type   : 'orange',
							buttons: {
								confirm: {
									text    : wpforms_education.close,
									btnClass: 'btn-confirm',
									keys    : [ 'enter' ],
								},
							},
						} );
					}
				}
			);
		},
	};

	// Provide access to public functions/properties.
	return app;

}( document, window, jQuery ) );

WPFormsEducation.core.init();
