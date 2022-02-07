// External Dependencies.
import React from 'react';

// Internal Dependencies.
import './style.scss';

const Logo = ( { className, text, src, alt, onClick } ) => {
	if ( ! text && ! src ) {
		return '';
	}

	return (
		<span
			className={ `stc-logo ${ className ? className : '' }` }
			onClick={ ( event ) => {
				if ( 'function' === typeof onClick ) {
					onClick( event );
				}
			} }
		>
			{ src ? (
				<a href={ astraSitesVars.st_page_url }>
					<img src={ src } className="stc-logo-image" alt={ alt } />
				</a>
			) : null }

			{ text ? (
				<div className="stc-logo-text" alt={ alt }>
					{ text }
				</div>
			) : null }
		</span>
	);
};

export default Logo;
