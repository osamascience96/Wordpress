import React, { memo } from 'react';
import { decodeEntities } from '@wordpress/html-entities';

import './style.scss';

const SuggestionList = ( { value, options, onClick } ) => {
	if ( ! options.length ) {
		return '';
	}

	return (
		<div className="stc-suggestion-list">
			{ options.map( ( option, index ) => {
				const suggession = decodeEntities( option ).replace(
					new RegExp( '(' + value + ')', 'gi' ),
					'<span class="stc-suggestion-highlight">$1</span>'
				);

				return (
					<div
						key={ index }
						className="stc-suggession"
						dangerouslySetInnerHTML={ {
							__html: suggession,
						} }
						onClick={ ( event ) => {
							if ( 'function' === typeof onClick ) {
								onClick( event, option );
							}
						} }
					/>
				);
			} ) }
		</div>
	);
};

export default memo( SuggestionList );
