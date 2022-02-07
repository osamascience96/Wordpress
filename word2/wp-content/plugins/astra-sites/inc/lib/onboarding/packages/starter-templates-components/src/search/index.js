// External Dependencies.
import React, { memo } from 'react';
import { __ } from '@wordpress/i18n';

// Internal Dependencies.
import './style.scss';
import { ICONS } from '../icons';

const Search = ( { onSearch, value, placeholder, onKeyUp } ) => {
	const searchPlaceholder = placeholder
		? placeholder
		: __( 'Search..', 'astra-sites' );

	return (
		<div
			className={ `stc-search ${ value ? 'stc-search-have-input' : '' }` }
		>
			<input
				className="stc-search-input"
				type="search"
				value={ value }
				placeholder={ searchPlaceholder }
				onChange={ ( event ) => {
					if ( 'function' === typeof onSearch ) {
						onSearch( event, event.target.value );
					}
				} }
				onKeyUp={ ( event ) => {
					if ( 'function' === typeof onKeyUp ) {
						onKeyUp( event );
					}
				} }
			/>
			<button className="stc-search-icon">{ ICONS.search }</button>
			<button
				className="stc-cross-icon"
				onClick={ ( event ) => {
					if ( 'function' === typeof onSearch ) {
						onSearch( event, '' );
						document
							.getElementsByClassName( 'stc-search-input' )[ 0 ]
							.focus();
					}
				} }
			>
				{ ICONS.cross }
			</button>
		</div>
	);
};

export default memo( Search );
