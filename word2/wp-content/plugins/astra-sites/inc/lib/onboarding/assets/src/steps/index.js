import React, { useEffect, useState } from 'react';
import { useNavigate } from 'react-router-dom';
import { __ } from '@wordpress/i18n';
import { Tooltip } from '@brainstormforce/starter-templates';
import { useStateValue } from '../store/store';
import ICONS from '../../icons';
import Logo from '../components/logo';
import { storeCurrentState } from '../utils/functions';
import { STEPS } from './util';
const { adminUrl } = starterTemplates;

const Steps = () => {
	const [ stateValue, dispatch ] = useStateValue();
	const {
		currentIndex,
		currentCustomizeIndex,
		templateResponse,
		designStep,
		importError,
	} = stateValue;
	const [ settingHistory, setSettinghistory ] = useState( true );
	const [ settingIndex, setSettingIndex ] = useState( true );
	const current = STEPS[ currentIndex ];
	const history = useNavigate();

	useEffect( () => {
		const previousIndex = parseInt( currentIndex ) - 1;
		const nextIndex = parseInt( currentIndex ) + 1;

		if ( nextIndex > 0 && nextIndex < STEPS.length ) {
			document.body.classList.remove( STEPS[ nextIndex ].class );
		}

		if ( previousIndex > 0 ) {
			document.body.classList.remove( STEPS[ previousIndex ].class );
		}

		document.body.classList.add( STEPS[ currentIndex ].class );
	} );

	useEffect( () => {
		if ( importError ) {
			document.body.classList.add( 'st-error' );
		} else {
			document.body.classList.remove( 'st-error' );
		}
	}, [ importError ] );

	useEffect( () => {
		const currentUrlParams = new URLSearchParams( window.location.search );
		const storedStateValue = JSON.parse(
			localStorage.getItem( 'starter-templates-onboarding' )
		);
		const urlIndex = parseInt( currentUrlParams.get( 'ci' ) ) || 0;
		const designIndex =
			parseInt( currentUrlParams.get( 'designStep' ) ) || 0;
		const searchTerm = currentUrlParams.get( 's' ) || '';

		if ( urlIndex !== 0 ) {
			const stateValueUpdates = {};
			for ( const key in storedStateValue ) {
				if ( key === 'currentIndex' || key === 'siteSearchTerm' ) {
					continue;
				}

				stateValueUpdates[ key ] = storedStateValue[ `${ key }` ];
			}

			dispatch( {
				type: 'set',
				currentIndex: urlIndex,
				designStep: designIndex,
				siteSearchTerm: searchTerm,
				...stateValueUpdates,
			} );
		} else {
			localStorage.removeItem( 'starter-templates-onboarding' );
		}

		setSettinghistory( false );
	}, [ history ] );

	useEffect( () => {
		const currentUrlParams = new URLSearchParams( window.location.search );
		const urlIndex = parseInt( currentUrlParams.get( 'ci' ) ) || 0;

		if ( currentIndex === 0 ) {
			currentUrlParams.delete( 'ci' );
			history(
				window.location.pathname + '?' + currentUrlParams.toString()
			);
		}

		if (
			( currentIndex !== 0 && urlIndex !== currentIndex ) ||
			templateResponse !== null
		) {
			storeCurrentState( stateValue );
			currentUrlParams.set( 'ci', currentIndex );
			history(
				window.location.pathname + '?' + currentUrlParams.toString()
			);
		}

		// Execute only for the last Customization step.
		if (
			designStep !== 0 &&
			urlIndex === STEPS.length - 1 &&
			templateResponse !== null
		) {
			storeCurrentState( stateValue );
			currentUrlParams.set( 'designStep', designStep );
			history(
				window.location.pathname + '?' + currentUrlParams.toString()
			);
		}

		if ( currentIndex === 2 ) {
			dispatch( {
				type: 'set',
				activePalette: {},
				activePaletteSlug: 'default',
				typography: {},
				typographyIndex: 0,
			} );
		}

		setSettingIndex( false );
	}, [ currentIndex, templateResponse, designStep ] );

	const goToShowcase = () => {
		dispatch( {
			type: 'set',
			currentIndex: currentIndex - 2,
			currentCustomizeIndex: 0,
		} );
	};

	window.onpopstate = () => {
		const gridIndex = STEPS.findIndex(
			( step ) => step.class === 'step-site-list'
		);

		if ( !! designStep && designStep !== 1 && currentIndex !== gridIndex ) {
			const surveyIndex = STEPS.findIndex(
				( step ) => step.class === 'step-survey'
			);

			if ( currentIndex >= surveyIndex ) {
				dispatch( {
					type: 'set',
					currentIndex: currentIndex - 1,
				} );
			} else {
				dispatch( {
					type: 'set',
					designStep: designStep - 1,
					currentCustomizeIndex: currentCustomizeIndex - 1,
					currentIndex,
				} );
			}
		}
		if ( currentIndex > gridIndex && designStep === 1 ) {
			dispatch( {
				type: 'set',
				currentIndex: currentIndex - 1,
			} );
		}
	};

	return (
		<div className={ `step ${ current.class }` }>
			{ currentIndex !== 3 && (
				<div className="step-header">
					{ current.header ? (
						current.header
					) : (
						<div className="row">
							<div className="col">
								<Logo />
							</div>
							<div className="right-col">
								{ currentIndex === 4 && (
									<div
										className="back-to-main"
										onClick={ goToShowcase }
									>
										<Tooltip
											content={ __(
												'Back to Templates',
												'astra-sites'
											) }
										>
											{ ICONS.cross }
										</Tooltip>
									</div>
								) }
								<div className="col exit-link">
									<a href={ adminUrl }>
										<Tooltip
											content={ __(
												'Exit to Dashboard',
												'astra-sites'
											) }
										>
											{ ICONS.dashboard }
										</Tooltip>
									</a>
								</div>
							</div>
						</div>
					) }

					<canvas
						id="ist-bashcanvas"
						width={ window.innerWidth }
						height={ window.innerHeight }
					/>
				</div>
			) }
			{ settingHistory === false && settingIndex === false && current
				? current.content
				: null }
		</div>
	);
};

export default Steps;
