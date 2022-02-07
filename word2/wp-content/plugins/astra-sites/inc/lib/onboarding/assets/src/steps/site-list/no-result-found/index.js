/** External dependencies */
import React from 'react';
import { decodeEntities } from '@wordpress/html-entities';
import { sprintf, __ } from '@wordpress/i18n';
import { useStateValue } from '../../../store/store';

/** Internal dependencies */
import './style.scss';

const NoResultFound = () => {
	const [ { siteSearchTerm } ] = useStateValue();

	if ( ! siteSearchTerm ) {
		return null;
	}

	return (
		<div className="st-sites-no-results">
			<h4>
				{ sprintf(
					/* translators: %1$s - search term. */
					__(
						'Your search - %1$s - did not match any Starter Templates.',
						'astra-sites'
					),
					decodeEntities( siteSearchTerm )
				) }
			</h4>
		</div>
	);
};

export default NoResultFound;
