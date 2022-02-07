// External Dependencies.
import React from 'react';
import { __ } from '@wordpress/i18n';
// Internal Dependencies.
import SiteGrid from '../sites-grid';

const RelatedSites = ( { sites } ) => {
	return (
		<>
			<div className="st-sites-grid">
				<div className="st-sites-found-message">
					{ __( 'Other suggested Starter Templates', 'astra-sites' ) }
				</div>
				<SiteGrid sites={ sites } />
			</div>
		</>
	);
};

export default RelatedSites;
