import { __ } from '@wordpress/i18n';
const { themeStatus, nonce } = starterTemplates;

export const getDemo = async ( id, storedState ) => {
	const [ { currentIndex }, dispatch ] = storedState;

	const generateData = new FormData();
	generateData.append( 'action', 'astra-sites-api-request' );
	generateData.append( 'url', 'astra-sites/' + id );
	generateData.append( '_ajax_nonce', astraSitesVars._ajax_nonce );

	await fetch( ajaxurl, {
		method: 'post',
		body: generateData,
	} )
		.then( ( response ) => response.json() )
		.then( ( response ) => {
			if ( response.success ) {
				starterTemplates.previewUrl =
					'https:' + response.data[ 'astra-site-url' ];
				dispatch( {
					type: 'set',
					templateId: id,
					templateResponse: response.data,
					importErrorMessages: {},
					importErrorResponse: [],
					importError: false,
				} );
			} else {
				let errorMessages = {};

				if ( undefined !== response.data.response_code ) {
					const code = response.data.code.toString();
					switch ( code ) {
						case '401':
						case '404':
							errorMessages = {
								primaryText:
									astraSitesVars.server_import_primary_error,
								secondaryText: '',
								errorCode: code,
								errorText: response.data.message,
								solutionText: '',
								tryAgain: true,
							};
							break;
						case '500':
							errorMessages = {
								primaryText:
									astraSitesVars.server_import_primary_error,
								secondaryText: '',
								errorCode: code,
								errorText: response.data.message,
								solutionText:
									astraSitesVars.ajax_request_failed_secondary,
								tryAgain: true,
							};
							break;

						case 'WP_Error':
							errorMessages = {
								primaryText:
									astraSitesVars.client_import_primary_error,
								secondaryText: '',
								errorCode: code,
								errorText: response.data.message,
								solutionText: '',
								tryAgain: true,
							};
							break;

						case 'Cloudflare':
							errorMessages = {
								primaryText:
									astraSitesVars.cloudflare_import_primary_error,
								secondaryText: '',
								errorCode: code,
								errorText: response.data.message,
								solutionText: '',
								tryAgain: true,
							};
							break;

						default:
							errorMessages = {
								primaryText: __(
									'Fetching related demo failed.',
									'astra-sites'
								),
								secondaryText: '',
								errorCode: '',
								errorText: response.data,
								solutionText:
									astraSitesVars.ajax_request_failed_secondary,
								tryAgain: false,
							};
							break;
					}
					dispatch( {
						type: 'set',
						importError: true,
						importErrorMessages: errorMessages,
						importErrorResponse: response.data,
						templateResponse: null,
						currentIndex: currentIndex + 3,
					} );
				}
			}
		} )
		.catch( ( error ) => {
			dispatch( {
				type: 'set',
				importError: true,
				importErrorMessages: {
					primaryText: __(
						'Fetching related demo failed.',
						'astra-sites'
					),
					secondaryText: astraSitesVars.ajax_request_failed_secondary,
					errorCode: '',
					errorText: error,
					solutionText: '',
					tryAgain: false,
				},
			} );
		} );
};

export const checkRequiredPlugins = ( storedState ) => {
	const [ {}, dispatch ] = storedState;

	const reqPlugins = new FormData();
	reqPlugins.append( 'action', 'astra-required-plugins' );
	reqPlugins.append( '_ajax_nonce', astraSitesVars._ajax_nonce );

	fetch( ajaxurl, {
		method: 'post',
		body: reqPlugins,
	} )
		.then( ( response ) => response.json() )
		.then( ( response ) => {
			if ( response.success ) {
				const rPlugins = response.data.required_plugins;
				const notInstalledPlugin = rPlugins.notinstalled || '';
				const notActivePlugins = rPlugins.inactive || '';
				dispatch( {
					type: 'set',
					requiredPlugins: response.data,
					notInstalledList: notInstalledPlugin,
					notActivatedList: notActivePlugins,
				} );
			}
		} );
};

export const installAstra = ( storedState ) => {
	const [ { importPercent }, dispatch ] = storedState;
	const themeSlug = 'astra';
	let percentage = importPercent;

	if ( 'not-installed' === themeStatus ) {
		if (
			wp.updates.shouldRequestFilesystemCredentials &&
			! wp.updates.ajaxLocked
		) {
			wp.updates.requestFilesystemCredentials();
		}

		percentage += 5;
		dispatch( {
			type: 'set',
			importPercent: percentage,
			importStatus: __( 'Installing Astra Theme…', 'astra-sites' ),
		} );

		wp.updates.installTheme( {
			slug: themeSlug,
		} );

		// eslint-disable-next-line no-undef
		jQuery( document ).on(
			'wp-theme-install-success',
			function ( event, response ) {
				dispatch( {
					type: 'set',
					themeStatus: response,
					importStatus: __( 'Astra Theme Installed.', 'astra-sites' ),
				} );
			}
		);
	}

	if ( 'installed-but-inactive' === themeStatus ) {
		// WordPress adds "Activate" button after waiting for 1000ms. So we will run our activation after that.
		setTimeout( function () {
			const data = new FormData();
			data.append( 'action', 'astra-sites-activate-theme' );
			data.append( '_ajax_nonce', astraSitesVars._ajax_nonce );

			fetch( ajaxurl, {
				method: 'post',
				body: data,
			} )
				.then( ( response ) => response.json() )
				.then( ( response ) => {
					if ( response.success ) {
						dispatch( {
							type: 'set',
							themeStatus: response,
							importStatus: __(
								'Astra Theme Installed.',
								'astra-sites'
							),
						} );
					} else {
						dispatch( {
							type: 'set',
							importError: true,
							importErrorMessages: {
								primaryText: __(
									'Astra theme installation failed.',
									'astra-sites'
								),
								secondaryText: '',
								errorCode: '',
								errorText: response.data,
								solutionText: '',
								tryAgain: true,
							},
						} );
					}
				} )
				.catch( ( error ) => {
					/* eslint-disable-next-line no-console -- We are displaying errors in the console. */
					console.error( error );
				} );
		}, 3000 );
	}

	if ( 'installed-and-active' === themeStatus ) {
		dispatch( {
			type: 'set',
			themeStatus: true,
		} );
	}
};

export const setSiteLogo = async ( logo ) => {
	if ( '' === logo.id ) {
		return;
	}
	const data = new FormData();
	data.append( 'action', 'astra_sites_set_site_data' );
	data.append( 'param', 'site-logo' );
	data.append( 'logo', logo.id );
	data.append( 'logo-width', logo.width );
	data.append( 'security', nonce );

	await fetch( ajaxurl, {
		method: 'post',
		body: data,
	} );
};

export const setColorPalettes = async ( palette ) => {
	if ( ! palette ) {
		return;
	}

	const data = new FormData();
	data.append( 'action', 'astra_sites_set_site_data' );
	data.append( 'param', 'site-colors' );
	data.append( 'palette', palette );
	data.append( 'security', nonce );

	await fetch( ajaxurl, {
		method: 'post',
		body: data,
	} );
};

export const saveTypography = async ( selectedValue ) => {
	const data = new FormData();
	data.append( 'action', 'astra_sites_set_site_data' );
	data.append( 'param', 'site-typography' );
	data.append( 'typography', JSON.stringify( selectedValue ) );
	data.append( 'security', nonce );

	await fetch( ajaxurl, {
		method: 'post',
		body: data,
	} );
};

export const divideIntoChunks = ( chunkSize, inputArray ) => {
	const values = Object.keys( inputArray );
	const final = [];
	let counter = 0;
	let portion = {};

	for ( const key in inputArray ) {
		if ( counter !== 0 && counter % chunkSize === 0 ) {
			final.push( portion );
			portion = {};
		}
		portion[ key ] = inputArray[ values[ counter ] ];
		counter++;
	}
	final.push( portion );

	return final;
};
