import React from 'react';
import { __ } from '@wordpress/i18n';
import { Logo as SiteLogo } from '@brainstormforce/starter-templates';
import './style.scss';
import { whiteLabelEnabled, getWhileLabelName } from '../../utils/functions';
const { imageDir } = starterTemplates;

const Logo = () => {
	return (
		<div className="branding-wrap">
			{ whiteLabelEnabled() ? (
				<h3>{ getWhileLabelName() }</h3>
			) : (
				<SiteLogo
					className="ist-logo"
					src={ `${ imageDir }logo.svg` }
					alt={ __( 'Starter Templates', 'astra-sites' ) }
				/>
			) }
		</div>
	);
};

export default Logo;
