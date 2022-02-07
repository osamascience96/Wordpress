import React from 'react';
import { __ } from '@wordpress/i18n';
import { decodeEntities } from '@wordpress/html-entities';
import { useStateValue } from '../../store/store';
import Button from '../../components/button/button';
import './style.scss';
import { getSupportLink } from '../../utils/functions';

const ErrorScreen = () => {
	const [
		{
			importErrorMessages,
			importPercent,
			currentIndex,
			tryAgainCount,
			templateId,
		},
		dispatch,
	] = useStateValue();

	const supportLink = getSupportLink(
		templateId,
		importErrorMessages.errorText
	);

	const tryAgain = () => {
		dispatch( {
			type: 'set',
			// Reset errors.
			importErrorMessages: {},
			importErrorResponse: [],
			importError: false,

			// Try again count.
			tryAgainCount: tryAgainCount + 1,

			// Reset import flags.
			xmlImportDone: false,
			resetData: [],
			importStart: false,
			importEnd: false,
			importPercent: 0,
			requiredPluginsDone: false,
			notInstalledList: [],
			notActivatedList: [],

			// Go to previous step.
			currentIndex: currentIndex - 1,
		} );
	};

	let percentClass = '';

	if ( importPercent <= 25 ) {
		percentClass = 'import-1';
	}
	if ( importPercent > 25 && importPercent <= 50 ) {
		percentClass = 'import-2';
	}
	if ( importPercent > 50 && importPercent <= 75 ) {
		percentClass = 'import-3';
	}
	if ( importPercent > 75 && importPercent <= 100 ) {
		percentClass = 'import-4';
	}

	return (
		<div className="ist-import-error">
			<div className="ist-import-progress-info">
				<div className="ist-import-progress-info-text label-text">
					{ __( 'Error Occured!', 'astra-sites' ) }
				</div>
				<div className="ist-import-progress-info-precent">
					{ importPercent }%
				</div>
			</div>
			<div className="ist-import-progress-bar-wrap">
				<div className="ist-import-progress-bar-bg">
					<div
						className={ `ist-import-progress-bar ${ percentClass }` }
					/>
				</div>
				<div className="import-progress-gap">
					<span />
					<span />
					<span />
				</div>
			</div>
			<div className="ist-import-error-wrap ist-import-error-primary-wrap">
				{ importErrorMessages.primaryText && (
					<p className="website-import-subtitle">
						{ importErrorMessages.primaryText }
					</p>
				) }
			</div>
			<div className="ist-import-error-box">
				<div className="ist-import-error-wrap ist-import-error-secondary-wrap">
					{ importErrorMessages.errorText &&
						'object' !== typeof importErrorMessages.errorText && (
							<p>{ importErrorMessages.errorText }</p>
						) }
					{ importErrorMessages.errorText &&
						'object' === typeof importErrorMessages.errorText && (
							<div>
								<pre>
									{ JSON.stringify(
										importErrorMessages.errorText,
										undefined,
										2
									) }
								</pre>
							</div>
						) }
				</div>
			</div>
			<div>
				{ importErrorMessages.secondaryText && (
					<p
						dangerouslySetInnerHTML={ {
							__html: importErrorMessages.secondaryText,
						} }
					/>
				) }
				{ importErrorMessages.solutionText && (
					<p
						className="ist-import-error-solution"
						dangerouslySetInnerHTML={ {
							__html: importErrorMessages.solutionText,
						} }
					/>
				) }
				{ ( ! importErrorMessages.solutionText &&
					! importErrorMessages.tryAgain ) ||
					( importErrorMessages.tryAgain && tryAgainCount > 1 && (
						<p className="ist-import-error-solution">
							{ decodeEntities(
								__(
									'Please report this error&nbsp;',
									'astra-sites'
								)
							) }
							<a
								href={ supportLink }
								target="_blank"
								rel="noreferrer"
							>
								{ 'here' }
							</a>
							{ decodeEntities(
								__( '&nbsp;so we can fix it.', 'astra-sites' )
							) }
						</p>
					) ) }
			</div>
			{ importErrorMessages.tryAgain && tryAgainCount < 4 && (
				<Button className="ist-button" after onClick={ tryAgain }>
					{ __( 'Try Importing Again', 'astra-sites' ) }
				</Button>
			) }
		</div>
	);
};

export default ErrorScreen;
