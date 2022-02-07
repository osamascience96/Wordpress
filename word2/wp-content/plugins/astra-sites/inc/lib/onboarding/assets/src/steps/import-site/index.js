import React, { useEffect } from 'react';
import { __, sprintf } from '@wordpress/i18n';
import Lottie from 'react-lottie-player';
import PreviousStepLink from '../../components/util/previous-step-link/index';
import DefaultStep from '../../components/default-step/index';
import ImportLoader from '../../components/import-steps/import-loader';
import ErrorScreen from '../../components/error/index';
import { useStateValue } from '../../store/store';
import lottieJson from '../../../images/website-building.json';
import sseImport from './sse-import';
import {
	installAstra,
	saveTypography,
	setSiteLogo,
	setColorPalettes,
	divideIntoChunks,
	checkRequiredPlugins,
} from './import-utils';
const { reportError } = starterTemplates;

import './style.scss';

const ImportSite = () => {
	const storedState = useStateValue();
	const [
		{
			importStart,
			importEnd,
			importPercent,
			templateResponse,
			reset,
			themeStatus,
			currentIndex,
			importError,
			siteLogo,
			activePalette,
			typography,
			customizerImportFlag,
			widgetImportFlag,
			contentImportFlag,
			themeActivateFlag,
			requiredPluginsDone,
			requiredPlugins,
			notInstalledList,
			notActivatedList,
			tryAgainCount,
			xmlImportDone,
		},
		dispatch,
	] = storedState;

	let percentage = importPercent;

	/**
	 *
	 * @param {string} primary   Primary text for the error.
	 * @param {string} secondary Secondary text for the error.
	 * @param {string} text      Text received from the AJAX call.
	 * @param {string} code      Error code received from the AJAX call.
	 * @param {string} solution  Solution provided for the current error.
	 */
	const report = (
		primary = '',
		secondary = '',
		text = '',
		code = '',
		solution = '',
		stack = ''
	) => {
		dispatch( {
			type: 'set',
			importError: true,
			importErrorMessages: {
				primaryText: primary,
				secondaryText: secondary,
				errorCode: code,
				errorText: text,
				solutionText: solution,
				tryAgain: true,
			},
		} );

		localStorage.removeItem( 'st-import-start' );
		localStorage.removeItem( 'st-import-end' );

		sendErrorReport(
			primary,
			secondary,
			text,
			code,
			solution,
			stack,
			tryAgainCount
		);
	};

	const sendErrorReport = (
		primary = '',
		secondary = '',
		text = '',
		code = '',
		solution = '',
		stack = ''
	) => {
		if ( ! reportError ) {
			return;
		}
		const reportErr = new FormData();
		reportErr.append( 'action', 'report_error' );
		reportErr.append(
			'error',
			JSON.stringify( {
				primaryText: primary,
				secondaryText: secondary,
				errorCode: code,
				errorText: text,
				solutionText: solution,
				tryAgain: true,
				stack,
				tryAgainCount,
			} )
		);
		reportErr.append( 'id', templateResponse.id );
		reportErr.append( 'plugins', JSON.stringify( requiredPlugins ) );
		fetch( ajaxurl, {
			method: 'post',
			body: reportErr,
		} );
	};

	/**
	 * Start Import Part 1.
	 */
	const importPart1 = async () => {
		await resetOldSite();

		await importCartflowsFlows();

		await importForms();

		await importCustomizerJson();

		await importSiteContent();
	};

	/**
	 * Start Import Part 2.
	 */
	const importPart2 = async () => {
		await importSiteOptions();

		await importWidgets();

		await customizeWebsite();

		importDone();
	};

	/**
	 * Install Required plugins.
	 */
	const installRequiredPlugins = () => {
		// Install Bulk.
		if ( notInstalledList.length <= 0 ) {
			return;
		}

		percentage += 2;
		dispatch( {
			type: 'set',
			importStatus: __( 'Installing Required Plugins.', 'astra-sites' ),
			importPercent: percentage,
		} );

		notInstalledList.forEach( ( plugin ) => {
			wp.updates.queue.push( {
				action: 'install-plugin', // Required action.
				data: {
					slug: plugin.slug,
					init: plugin.init,
					name: plugin.name,
					clear_destination: true,
					success() {
						dispatch( {
							type: 'set',
							importStatus: sprintf(
								// translators: Plugin Name.
								__(
									'%1$s plugin installed successfully.',
									'astra-sites'
								),
								plugin.name
							),
						} );

						const inactiveList = notActivatedList;
						inactiveList.push( plugin );

						dispatch( {
							type: 'set',
							notActivatedList: inactiveList,
						} );
						const notInstalledPluginList = notInstalledList;
						notInstalledPluginList.forEach(
							( singlePlugin, index ) => {
								if ( singlePlugin.slug === plugin.slug ) {
									notInstalledPluginList.splice( index, 1 );
								}
							}
						);
						dispatch( {
							type: 'set',
							notInstalledList: notInstalledPluginList,
						} );
					},
					error( err ) {
						report(
							sprintf(
								// translators: Plugin Name.
								__(
									'Could not install the plugin - %s',
									'astra-sites'
								),
								plugin.name
							),
							'',
							err
						);
					},
				},
			} );
		} );

		// Required to set queue.
		wp.updates.queueChecker();
	};

	/**
	 * Activate Plugin
	 */
	const activatePlugin = ( plugin ) => {
		percentage += 2;
		dispatch( {
			type: 'set',
			importStatus: sprintf(
				// translators: Plugin Name.
				__( 'Activating %1$s plugin.', 'astra-sites' ),
				plugin.name
			),
			importPercent: percentage,
		} );

		const activatePluginOptions = new FormData();
		activatePluginOptions.append(
			'action',
			'astra-required-plugin-activate'
		);
		activatePluginOptions.append( 'init', plugin.init );
		activatePluginOptions.append(
			'_ajax_nonce',
			astraSitesVars._ajax_nonce
		);
		fetch( ajaxurl, {
			method: 'post',
			body: activatePluginOptions,
		} )
			.then( ( response ) => response.text() )
			.then( ( text ) => {
				let cloneResponse = [];
				let errorReported = false;
				try {
					const response = JSON.parse( text );
					cloneResponse = response;
					if ( response.success ) {
						const notActivatedPluginList = notActivatedList;
						notActivatedPluginList.forEach(
							( singlePlugin, index ) => {
								if ( singlePlugin.slug === plugin.slug ) {
									notActivatedPluginList.splice( index, 1 );
								}
							}
						);
						dispatch( {
							type: 'set',
							notActivatedList: notActivatedPluginList,
						} );
						percentage += 2;
						dispatch( {
							type: 'set',
							importStatus: sprintf(
								// translators: Plugin Name.
								__( '%1$s activated.', 'astra-sites' ),
								plugin.name
							),
							importPercent: percentage,
						} );
					}
				} catch ( error ) {
					report(
						sprintf(
							// translators: Plugin name.
							__(
								`JSON_Error: Could not activate the required plugin - %1$s.`,
								'astra-sites'
							),
							plugin.name
						),
						'',
						error,
						'',
						sprintf(
							// translators: Support article URL.
							__(
								'<a href="%1$s">Read article</a> to resolve the issue and continue importing template.',
								'astra-sites'
							),
							'https://wpastra.com/docs/enable-debugging-in-wordpress/#how-to-use-debugging'
						),
						text
					);

					errorReported = true;
				}

				if ( ! cloneResponse.success && errorReported === false ) {
					throw cloneResponse;
				}
			} )
			.catch( ( error ) => {
				report(
					sprintf(
						// translators: Plugin name.
						__(
							`Could not activate the required plugin - %1$s.`,
							'astra-sites'
						),
						plugin.name
					),
					'',
					error?.data?.message,
					'',
					sprintf(
						// translators: Support article URL.
						__(
							'<a href="%1$s">Read article</a> to resolve the issue and continue importing template.',
							'astra-sites'
						),
						'https://wpastra.com/docs/enable-debugging-in-wordpress/#how-to-use-debugging'
					),
					error
				);
			} );
	};

	/**
	 * 1. Reset.
	 * The following steps are covered here.
	 * 		1. Reset Customizer
	 * 		2. Reset Site Options
	 * 		3. Reset Widgets
	 * 		4. Reset Forms and Terms
	 * 		5. Reset all posts
	 */
	const resetOldSite = async () => {
		if ( ! reset ) {
			return;
		}
		if ( importError ) {
			return;
		}
		percentage += 2;
		dispatch( {
			type: 'set',
			importStatus: __( 'Reseting site.', 'astra-sites' ),
			importPercent: percentage,
		} );

		/**
		 * Reset Customizer.
		 */
		await performResetCustomizer();

		/**
		 * Reset Site Options.
		 */
		await performResetSiteOptions();

		/**
		 * Reset Widgets.
		 */
		await performResetWidget();

		/**
		 * Reset Terms, Forms.
		 */
		await performResetTermsAndForms();

		/**
		 * Reset Posts.
		 */
		await performResetPosts();

		percentage += 10;
		dispatch( {
			type: 'set',
			importPercent: percentage,
			importStatus: __( 'Reset for old website is done.', 'astra-sites' ),
		} );
	};

	/**
	 * Reset a chunk of posts.
	 */
	const performPostsReset = async ( chunk ) => {
		const data = new FormData();
		data.append( 'action', 'astra-sites-get-deleted-post-ids' );
		data.append( '_ajax_nonce', astraSitesVars._ajax_nonce );

		dispatch( {
			type: 'set',
			importStatus: __( `Resetting posts.`, 'astra-sites' ),
		} );

		const formOption = new FormData();
		formOption.append( 'action', 'astra-sites-reset-posts' );
		formOption.append( 'ids', JSON.stringify( chunk ) );
		formOption.append( '_ajax_nonce', astraSitesVars._ajax_nonce );

		await fetch( ajaxurl, {
			method: 'post',
			body: formOption,
		} )
			.then( ( resp ) => resp.text() )
			.then( ( text ) => {
				let cloneData = [];
				let errorReported = false;
				try {
					const result = JSON.parse( text );
					cloneData = result;
					if ( result.success ) {
						percentage += 2;
						dispatch( {
							type: 'set',
							importPercent: percentage <= 70 ? percentage : 70,
						} );
					}
				} catch ( error ) {
					report(
						__( 'Resetting posts failed.', 'astra-sites' ),
						'',
						error,
						'',
						'',
						text
					);

					errorReported = true;
				}

				if ( ! cloneData.success && errorReported === false ) {
					throw cloneData.data;
				}
			} )
			.catch( ( error ) => {
				report(
					__( 'Resetting posts failed.', 'astra-sites' ),
					'',
					error?.message,
					'',
					'',
					error
				);
			} );
	};

	/**
	 * 1.1 Perform Reset for Customizer.
	 */
	const performResetCustomizer = async () => {
		if ( importError ) {
			return;
		}
		dispatch( {
			type: 'set',
			importStatus: __( 'Resetting customizer.', 'astra-sites' ),
		} );

		const customizerContent = new FormData();
		customizerContent.append(
			'action',
			'astra-sites-reset-customizer-data'
		);
		customizerContent.append( '_ajax_nonce', astraSitesVars._ajax_nonce );

		await fetch( ajaxurl, {
			method: 'post',
			body: customizerContent,
		} )
			.then( ( response ) => response.text() )
			.then( ( text ) => {
				let cloneData = [];
				let errorReported = false;
				try {
					const response = JSON.parse( text );
					cloneData = response;
					if ( response.success ) {
						percentage += 2;
						dispatch( {
							type: 'set',
							importPercent: percentage,
						} );
					}
				} catch ( error ) {
					report(
						__( 'Resetting customizer failed.', 'astra-sites' ),
						'',
						error?.message,
						'',
						'',
						text
					);

					errorReported = true;
				}

				if ( ! cloneData.success && errorReported === false ) {
					throw cloneData.data;
				}
			} )
			.catch( ( error ) => {
				report(
					__( 'Resetting customizer failed.', 'astra-sites' ),
					'',
					error?.message,
					'',
					'',
					error
				);
			} );
	};

	/**
	 * 1.2 Perform reset Site options
	 */
	const performResetSiteOptions = async () => {
		if ( importError ) {
			return;
		}
		dispatch( {
			type: 'set',
			importStatus: __( 'Resetting site options.', 'astra-sites' ),
		} );

		const siteOptions = new FormData();
		siteOptions.append( 'action', 'astra-sites-reset-site-options' );
		siteOptions.append( '_ajax_nonce', astraSitesVars._ajax_nonce );

		await fetch( ajaxurl, {
			method: 'post',
			body: siteOptions,
		} )
			.then( ( response ) => response.text() )
			.then( ( text ) => {
				let cloneData = [];
				let errorReported = false;
				try {
					const data = JSON.parse( text );
					cloneData = data;
					if ( data.success ) {
						percentage += 2;
						dispatch( {
							type: 'set',
							importPercent: percentage,
						} );
					}
				} catch ( error ) {
					report(
						__( 'Resetting site options Failed.', 'astra-sites' ),
						'',
						error?.message,
						'',
						'',
						text
					);

					errorReported = true;
				}

				if ( false === cloneData.success && errorReported === false ) {
					throw cloneData.data;
				}
			} )
			.catch( ( error ) => {
				report(
					__( 'Resetting site options Failed.', 'astra-sites' ),
					'',
					error?.message,
					'',
					'',
					error
				);
			} );
	};

	/**
	 * 1.3 Perform Reset for Widgets
	 */
	const performResetWidget = async () => {
		if ( importError ) {
			return;
		}
		const widgets = new FormData();
		widgets.append( 'action', 'astra-sites-reset-widgets-data' );
		widgets.append( '_ajax_nonce', astraSitesVars._ajax_nonce );

		dispatch( {
			type: 'set',
			importStatus: __( 'Resetting widgets.', 'astra-sites' ),
		} );
		await fetch( ajaxurl, {
			method: 'post',
			body: widgets,
		} )
			.then( ( response ) => response.text() )
			.then( ( text ) => {
				let cloneData = [];
				let errorReported = false;
				try {
					const response = JSON.parse( text );
					cloneData = response;
					if ( response.success ) {
						percentage += 2;
						dispatch( {
							type: 'set',
							importPercent: percentage,
						} );
					}
				} catch ( error ) {
					report(
						__(
							'Resetting widgets JSON parse failed.',
							'astra-sites'
						),
						'',
						error,
						'',
						'',
						text
					);

					errorReported = true;
				}

				if ( ! cloneData.success && errorReported === false ) {
					throw cloneData.data;
				}
			} )
			.catch( ( error ) => {
				report(
					__( 'Resetting widgets failed.', 'astra-sites' ),
					'',
					error,
					'',
					'',
					error
				);
			} );
	};

	/**
	 * 1.4 Reset Terms and Forms.
	 */
	const performResetTermsAndForms = async () => {
		if ( importError ) {
			return;
		}
		const formOption = new FormData();
		formOption.append( 'action', 'astra-sites-reset-terms-and-forms' );
		formOption.append( '_ajax_nonce', astraSitesVars._ajax_nonce );

		dispatch( {
			type: 'set',
			importStatus: __( 'Resetting terms and forms.', 'astra-sites' ),
		} );

		await fetch( ajaxurl, {
			method: 'post',
			body: formOption,
		} )
			.then( ( response ) => response.text() )
			.then( ( text ) => {
				let cloneData = [];
				let errorReported = false;
				try {
					const response = JSON.parse( text );
					cloneData = response;
					if ( response.success ) {
						percentage += 2;
						dispatch( {
							type: 'set',
							importPercent: percentage,
						} );
					}
				} catch ( error ) {
					report(
						__(
							'Resetting terms and forms failed.',
							'astra-sites'
						),
						'',
						error,
						'',
						'',
						text
					);

					errorReported = true;
				}

				if ( ! cloneData.success && errorReported === false ) {
					throw cloneData.data;
				}
			} )
			.catch( ( error ) => {
				report(
					__( 'Resetting terms and forms failed.', 'astra-sites' ),
					'',
					error?.message,
					'',
					'',
					error
				);
			} );
	};

	/**
	 * 1.5 Reset Posts.
	 */
	const performResetPosts = async () => {
		if ( importError ) {
			return;
		}
		const data = new FormData();
		data.append( 'action', 'astra-sites-get-deleted-post-ids' );
		data.append( '_ajax_nonce', astraSitesVars._ajax_nonce );

		dispatch( {
			type: 'set',
			importStatus: __( 'Gathering posts for deletions.', 'astra-sites' ),
		} );

		await fetch( ajaxurl, {
			method: 'post',
			body: data,
		} )
			.then( ( response ) => response.json() )
			.then( async ( response ) => {
				if ( response.success ) {
					const chunkArray = divideIntoChunks( 10, response.data );
					if ( chunkArray.length > 0 ) {
						for (
							let index = 0;
							index < chunkArray.length;
							index++
						) {
							await performPostsReset( chunkArray[ index ] );
						}
					}
				}
			} );

		dispatch( {
			type: 'set',
			importStatus: __( 'Resetting posts done.', 'astra-sites' ),
		} );
	};

	/**
	 * 2. Import CartFlows Flows.
	 */
	const importCartflowsFlows = async () => {
		if ( importError ) {
			return;
		}
		const cartflowsUrl =
			encodeURI( templateResponse[ 'astra-site-cartflows-path' ] ) || '';

		if ( '' === cartflowsUrl || 'null' === cartflowsUrl ) {
			return;
		}

		dispatch( {
			type: 'set',
			importStatus: __( 'Importing CartFlows flows.', 'astra-sites' ),
		} );

		const flows = new FormData();
		flows.append( 'action', 'astra-sites-import-cartflows' );
		flows.append( 'cartflows_url', cartflowsUrl );
		flows.append( '_ajax_nonce', astraSitesVars._ajax_nonce );

		await fetch( ajaxurl, {
			method: 'post',
			body: flows,
		} )
			.then( ( response ) => response.text() )
			.then( ( text ) => {
				let cloneData = [];
				let errorReported = false;
				try {
					const data = JSON.parse( text );
					cloneData = data;
					if ( data.success ) {
						percentage += 2;
						dispatch( {
							type: 'set',
							importPercent: percentage,
						} );
					}
				} catch ( error ) {
					report(
						__(
							'Importing CartFlows flows failed due to parse JSON error.',
							'astra-sites'
						),
						'',
						error,
						'',
						'',
						text
					);

					errorReported = true;
				}

				if ( false === cloneData.success && errorReported === false ) {
					throw cloneData.data;
				}
			} )
			.catch( ( error ) => {
				report(
					__( 'Importing CartFlows flows Failed.', 'astra-sites' ),
					'',
					error
				);
			} );
	};

	/**
	 * 3. Import WPForms.
	 */
	const importForms = async () => {
		if ( importError ) {
			return;
		}
		const wpformsUrl =
			encodeURI( templateResponse[ 'astra-site-wpforms-path' ] ) || '';

		if ( '' === wpformsUrl || 'null' === wpformsUrl ) {
			return;
		}

		dispatch( {
			type: 'set',
			importStatus: __( 'Importing forms.', 'astra-sites' ),
		} );

		const flows = new FormData();
		flows.append( 'action', 'astra-sites-import-wpforms' );
		flows.append( 'wpforms_url', wpformsUrl );
		flows.append( '_ajax_nonce', astraSitesVars._ajax_nonce );

		await fetch( ajaxurl, {
			method: 'post',
			body: flows,
		} )
			.then( ( response ) => response.text() )
			.then( ( text ) => {
				let cloneData = [];
				let errorReported = false;
				try {
					const data = JSON.parse( text );
					cloneData = data;
					if ( data.success ) {
						percentage += 2;
						dispatch( {
							type: 'set',
							importPercent: percentage,
						} );
					}
				} catch ( error ) {
					report(
						__(
							'Importing forms failed due to parse JSON error.',
							'astra-sites'
						),
						'',
						error,
						'',
						'',
						text
					);

					errorReported = true;
				}

				if ( false === cloneData.success && errorReported === false ) {
					throw cloneData.data;
				}
			} )
			.catch( ( error ) => {
				report(
					__( 'Importing forms Failed.', 'astra-sites' ),
					'',
					error
				);
			} );
	};

	/**
	 * 4. Import Customizer JSON.
	 */
	const importCustomizerJson = async () => {
		if ( importError ) {
			return;
		}
		if ( ! customizerImportFlag ) {
			percentage += 5;
			dispatch( {
				type: 'set',
				importPercent: percentage,
			} );
			return;
		}
		dispatch( {
			type: 'set',
			importStatus: __( 'Importing forms.', 'astra-sites' ),
		} );

		const forms = new FormData();
		forms.append( 'action', 'astra-sites-import-customizer-settings' );
		forms.append( '_ajax_nonce', astraSitesVars._ajax_nonce );

		await fetch( ajaxurl, {
			method: 'post',
			body: forms,
		} )
			.then( ( response ) => response.text() )
			.then( ( text ) => {
				let cloneData = [];
				let errorReported = false;
				try {
					const data = JSON.parse( text );
					cloneData = data;
					if ( data.success ) {
						percentage += 5;
						dispatch( {
							type: 'set',
							importPercent: percentage,
						} );
					}
				} catch ( error ) {
					report(
						__(
							'Importing Customizer failed due to parse JSON error.',
							'astra-sites'
						),
						'',
						error,
						'',
						'',
						text
					);

					errorReported = true;
				}

				if ( false === cloneData.success && errorReported === false ) {
					throw cloneData.data;
				}
			} )
			.catch( ( error ) => {
				report(
					__( 'Importing Customizer Failed.', 'astra-sites' ),
					'',
					error
				);
			} );
	};

	/**
	 * 5. Import Site Comtent XML.
	 */
	const importSiteContent = async () => {
		if ( importError ) {
			return;
		}
		if ( ! contentImportFlag ) {
			percentage += 20;
			dispatch( {
				type: 'set',
				importPercent: percentage,
				xmlImportDone: true,
			} );
			return;
		}

		const wxrUrl =
			encodeURI( templateResponse[ 'astra-site-wxr-path' ] ) || '';
		if ( 'null' === wxrUrl || '' === wxrUrl ) {
			const errorTxt = __(
				'The XML URL for the site content is empty.',
				'astra-sites'
			);
			report(
				__( 'Importing Site Content Failed', 'astra-sites' ),
				'',
				errorTxt,
				'',
				astraSitesVars.support_text,
				wxrUrl
			);
			return;
		}

		dispatch( {
			type: 'set',
			importStatus: __( 'Importing Site Content.', 'astra-sites' ),
		} );

		const content = new FormData();
		content.append( 'action', 'astra-sites-import-prepare-xml' );
		content.append( 'wxr_url', wxrUrl );
		content.append( '_ajax_nonce', astraSitesVars._ajax_nonce );

		await fetch( ajaxurl, {
			method: 'post',
			body: content,
		} )
			.then( ( response ) => response.text() )
			.then( ( text ) => {
				try {
					const data = JSON.parse( text );
					percentage += 2;
					dispatch( {
						type: 'set',
						importPercent: percentage <= 80 ? percentage : 80,
					} );
					if ( false === data.success ) {
						const errorMsg = data.data.error || data.data;
						throw errorMsg;
					} else {
						importXML( data.data );
					}
				} catch ( error ) {
					report(
						__(
							'Importing Site Content failed due to parse JSON error.',
							'astra-sites'
						),
						'',
						error,
						'',
						'',
						text
					);
				}
			} )
			.catch( ( error ) => {
				report(
					__( 'Importing Site Content Failed.', 'astra-sites' ),
					'',
					error
				);
			} );
	};

	/**
	 * Imports XML using EventSource.
	 *
	 * @param {JSON} data JSON object for all the content in XML
	 */
	const importXML = ( data ) => {
		// Import XML though Event Source.
		sseImport.data = data;
		sseImport.render( dispatch, percentage );

		const evtSource = new EventSource( sseImport.data.url );
		evtSource.onmessage = ( message ) => {
			const eventData = JSON.parse( message.data );
			switch ( eventData.action ) {
				case 'updateDelta':
					sseImport.updateDelta( eventData.type, eventData.delta );
					break;

				case 'complete':
					if ( false === eventData.error ) {
						evtSource.close();
						dispatch( {
							type: 'set',
							xmlImportDone: true,
						} );
					} else {
						report(
							astraSitesVars.xml_import_interrupted_primary,
							'',
							astraSitesVars.xml_import_interrupted_error,
							'',
							astraSitesVars.xml_import_interrupted_secondary
						);
					}
					break;
			}
		};

		evtSource.onerror = ( error ) => {
			evtSource.close();
			report(
				__(
					'Importing Site Content Failed. - Import Process Interrupted',
					'astra-sites'
				),
				'',
				error
			);
		};

		evtSource.addEventListener( 'log', function ( message ) {
			const eventLogData = JSON.parse( message.data );
			let importMessage = eventLogData.message || '';
			if ( importMessage && 'info' === eventLogData.level ) {
				importMessage = importMessage.replace( /"/g, function () {
					return '';
				} );
			}

			dispatch( {
				type: 'set',
				importStatus: sprintf(
					// translators: Response importMessage
					__( 'Importing - %1$s', 'astra-sites' ),
					importMessage
				),
			} );
		} );
	};

	/**
	 * 6. Import Site Option table values.
	 */
	const importSiteOptions = async () => {
		if ( importError ) {
			return;
		}
		dispatch( {
			type: 'set',
			importStatus: __( 'Importing Site Options.', 'astra-sites' ),
		} );

		const siteOptions = new FormData();
		siteOptions.append( 'action', 'astra-sites-import-options' );
		siteOptions.append( '_ajax_nonce', astraSitesVars._ajax_nonce );

		await fetch( ajaxurl, {
			method: 'post',
			body: siteOptions,
		} )
			.then( ( response ) => response.text() )
			.then( ( text ) => {
				let cloneData = [];
				let errorReported = false;
				try {
					const data = JSON.parse( text );
					cloneData = data;
					if ( data.success ) {
						percentage += 5;
						dispatch( {
							type: 'set',
							importPercent: percentage,
						} );
					}
				} catch ( error ) {
					report(
						__(
							'Importing Site Options failed due to parse JSON error.',
							'astra-sites'
						),
						'',
						error,
						'',
						'',
						text
					);

					errorReported = true;
				}

				if ( false === cloneData.success && errorReported === false ) {
					throw cloneData.data;
				}
			} )
			.catch( ( error ) => {
				report(
					__( 'Importing Site Options Failed.', 'astra-sites' ),
					'',
					error
				);
			} );
	};

	/**
	 * 7. Import Site Widgets.
	 */
	const importWidgets = async () => {
		if ( importError ) {
			return;
		}
		if ( ! widgetImportFlag ) {
			dispatch( {
				type: 'set',
				importPercent: 90,
			} );
			return;
		}
		dispatch( {
			type: 'set',
			importStatus: __( 'Importing Widgets.', 'astra-sites' ),
		} );

		const widgetsData = templateResponse[ 'astra-site-widgets-data' ] || '';

		const widgets = new FormData();
		widgets.append( 'action', 'astra-sites-import-widgets' );
		widgets.append( 'widgets_data', widgetsData );
		widgets.append( '_ajax_nonce', astraSitesVars._ajax_nonce );

		await fetch( ajaxurl, {
			method: 'post',
			body: widgets,
		} )
			.then( ( response ) => response.text() )
			.then( ( text ) => {
				let cloneData = [];
				let errorReported = false;
				try {
					const data = JSON.parse( text );
					cloneData = data;
					if ( data.success ) {
						dispatch( {
							type: 'set',
							importPercent: 90,
						} );
					}
				} catch ( error ) {
					report(
						__(
							'Importing Widgets failed due to parse JSON error.',
							'astra-sites'
						),
						'',
						error,
						'',
						'',
						text
					);

					errorReported = true;
				}

				if ( false === cloneData.success && errorReported === false ) {
					throw cloneData.data;
				}
			} )
			.catch( ( error ) => {
				report(
					__( 'Importing Widgets Failed.', 'astra-sites' ),
					'',
					error
				);
			} );
	};

	/**
	 * 8. Update the website as per the customizations selected by the user.
	 * The following steps are covered here.
	 * 		a. Update Logo
	 * 		b. Update Color Palette
	 * 		c. Update Typography
	 */
	const customizeWebsite = async () => {
		if ( importError ) {
			return;
		}
		await setSiteLogo( siteLogo );
		await setColorPalettes( JSON.stringify( activePalette ) );
		await saveTypography( typography );
	};

	/**
	 * 9. Final setup - Invoking Batch process.
	 */
	const importDone = () => {
		if ( importError ) {
			return;
		}
		dispatch( {
			type: 'set',
			importStatus: __( 'Final finishings.', 'astra-sites' ),
		} );

		const finalSteps = new FormData();
		finalSteps.append( 'action', 'astra-sites-import-end' );
		finalSteps.append( '_ajax_nonce', astraSitesVars._ajax_nonce );
		let counter = 3;

		fetch( ajaxurl, {
			method: 'post',
			body: finalSteps,
		} )
			.then( ( response ) => response.text() )
			.then( ( text ) => {
				let cloneData = [];
				let errorReported = false;
				try {
					const data = JSON.parse( text );
					cloneData = data;
					if ( data.success ) {
						dispatch( {
							type: 'set',
							importPercent: 100,
							importEnd: true,
						} );

						localStorage.setItem( 'st-import-end', +new Date() );
						setInterval( function () {
							counter--;
							const counterEl = document.getElementById(
								'redirect-counter'
							);
							if ( counterEl ) {
								if ( counter < 0 ) {
									dispatch( {
										type: 'set',
										currentIndex: currentIndex + 1,
									} );
								} else {
									const timeType =
										counter <= 1 ? ' second…' : ' seconds…';
									counterEl.innerHTML = counter + timeType;
								}
							}
						}, 1000 );
					}
				} catch ( error ) {
					report(
						__(
							'Final finishings failed due to parse JSON error.',
							'astra-sites'
						),
						'',
						error,
						'',
						'',
						text
					);

					errorReported = true;

					dispatch( {
						type: 'set',
						importPercent: 100,
						importEnd: true,
					} );

					localStorage.setItem( 'st-import-end', +new Date() );
					setInterval( function () {
						counter--;
						const counterEl = document.getElementById(
							'redirect-counter'
						);
						if ( counterEl ) {
							if ( counter < 0 ) {
								dispatch( {
									type: 'set',
									currentIndex: currentIndex + 1,
								} );
							} else {
								const counterText =
									counter <= 1 ? ' second…' : ' seconds…';
								counterEl.innerHTML = counter + counterText;
							}
						}
					}, 1000 );
				}

				if ( false === cloneData.success && errorReported === false ) {
					throw cloneData.data;
				}
			} )
			.catch( ( error ) => {
				report(
					__( 'Final finishings Failed.', 'astra-sites' ),
					'',
					error
				);
			} );
	};

	const preventRefresh = ( event ) => {
		event.returnValue = __(
			'Are you sure you want to cancel the site import process?',
			'astra-sites'
		);
		return event;
	};

	useEffect( () => {
		window.addEventListener( 'beforeunload', preventRefresh ); // eslint-disable-line @wordpress/no-global-event-listener
		return () =>
			window.removeEventListener( 'beforeunload', preventRefresh ); // eslint-disable-line @wordpress/no-global-event-listener
	} );

	/**
	 * When try again button is clicked:
	 * There is a possibility that few/all the required plugins list is already installed.
	 * We cre-check the status of the required plugins here.
	 */
	useEffect( () => {
		if ( tryAgainCount > 0 ) {
			checkRequiredPlugins( storedState );
		}
	}, [ tryAgainCount ] );

	/**
	 * Start the pre import process.
	 * 		1. Install Astra Theme
	 * 		2. Install Required Plugins.
	 */
	useEffect( () => {
		/**
		 * Do not process when Import is already going on.
		 */
		if ( importStart || importEnd ) {
			return;
		}
		if ( ! importError ) {
			localStorage.setItem( 'st-import-start', +new Date() );
			percentage += 5;

			dispatch( {
				type: 'set',
				importStart: true,
				importPercent: percentage,
				importStatus: __( 'Starting Import.', 'astra-sites' ),
			} );
		}

		if ( themeActivateFlag ) {
			installAstra( storedState );
		} else {
			dispatch( {
				type: 'set',
				themeStatus: true,
			} );
		}
		installRequiredPlugins();
	}, [ templateResponse ] );

	/**
	 * Start the process only when:
	 * 		1. Required plugins are installed and activated.
	 * 		2. Astra Theme is installed
	 */
	useEffect( () => {
		if ( requiredPluginsDone && themeStatus ) {
			importPart1();
		}
	}, [ requiredPluginsDone, themeStatus ] );

	/**
	 * Start Part 2 of the import once the XML is imported sucessfully.
	 */
	useEffect( () => {
		if ( xmlImportDone ) {
			importPart2();
		}
	}, [ xmlImportDone ] );

	// This checks if all the required plugins are installed and activated.
	useEffect( () => {
		if ( notActivatedList.length <= 0 && notInstalledList.length <= 0 ) {
			dispatch( {
				type: 'set',
				requiredPluginsDone: true,
			} );
		}
	}, [ notActivatedList.length, notInstalledList.length ] );

	// Whenever a plugin is installed, this code sends an activation request.
	useEffect( () => {
		// Installed all required plugins.
		if ( notActivatedList.length > 0 ) {
			activatePlugin( notActivatedList[ 0 ] );
		}
	}, [ notActivatedList.length ] );

	return (
		<DefaultStep
			content={
				<div className="middle-content middle-content-import">
					<>
						<h1>
							{ __(
								'We are building your website…',
								'astra-sites'
							) }
						</h1>
						{ importError && (
							<div className="ist-import-process-step-wrap">
								<ErrorScreen />
							</div>
						) }
						{ ! importError && (
							<>
								<div className="ist-import-process-step-wrap">
									<ImportLoader />
								</div>
								<Lottie
									loop
									animationData={ lottieJson }
									play
									style={ {
										height: 400,
										margin: '-70px auto -90px auto',
									} }
								/>
							</>
						) }
					</>
				</div>
			}
			actions={
				<>
					<PreviousStepLink before disabled customizeStep={ true }>
						{ __( 'Back', 'astra-sites' ) }
					</PreviousStepLink>
				</>
			}
		/>
	);
};

export default ImportSite;
