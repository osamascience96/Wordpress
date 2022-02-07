import { __ } from '@wordpress/i18n';
import { decodeEntities } from '@wordpress/html-entities';
import React from 'react';
import { useStateValue } from '../../store/store';
import ICONS from '../../../../assets/icons';

const ImportLoader = () => {
	const [ { importPercent, importStatus } ] = useStateValue();
	const doneClass = 100 === importPercent ? 'import-done' : '';
	let percentClass = '';
	let stepText = '';

	if ( importPercent <= 25 ) {
		percentClass = 'import-1';
		stepText = __(
			'1. Installing required theme, plugins, forms, etc',
			'astra-sites'
		);
	}
	if ( importPercent > 25 && importPercent <= 50 ) {
		percentClass = 'import-2';
		stepText = __( '2. Importing pages, menus, posts, etc', 'astra-sites' );
	}
	if ( importPercent > 50 && importPercent <= 75 ) {
		percentClass = 'import-3';
		stepText = __(
			'3. Setting up customizer settings and the site settings',
			'astra-sites'
		);
	}
	if ( importPercent > 75 && importPercent <= 100 ) {
		percentClass = 'import-4';
		stepText = __( '4. Finalizing last few settings', 'astra-sites' );
	}

	return (
		<div className="ist-import-progress">
			<div className="ist-import-progress-info">
				<div
					className={ `ist-import-progress-info-text ${ doneClass }` }
				>
					<span className="ist-import-text-inner">{ stepText }</span>
					<span className="ist-import-done-inner">
						{ __( 'Done ', 'astra-sites' ) }
						{ ICONS.tada }
					</span>
				</div>
				<div className="ist-import-progress-info-precent">
					{ importPercent }%
				</div>
			</div>
			<div className="ist-import-progress-bar-wrap">
				<div className="ist-import-progress-bar-bg">
					<div
						className={ `ist-import-progress-bar ${ doneClass } ${ percentClass }` }
					/>
				</div>
				<div className="import-progress-gap">
					<span />
					<span />
					<span />
				</div>
			</div>
			<div className="ist-import-progress-info">
				<div
					className={ `ist-import-progress-info-text ${ doneClass }` }
				>
					<span className="import-status-string">
						<p>{ importStatus + decodeEntities( '&nbsp;' ) }</p>
					</span>
					<span className="import-done-counter">
						<p>
							{ __( 'Redirecting you in ', 'astra-sites' ) }
							<span id="redirect-counter">
								{ __( '3 seconds…', 'astra-sites' ) }
							</span>
						</p>
					</span>
				</div>
			</div>
		</div>
	);
};

export default ImportLoader;
