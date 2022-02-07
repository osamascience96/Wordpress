// External Dependencies.
import React, { useState } from 'react';

// Internal Dependencies.
import { ICONS } from '../icons';
import './style.scss';

const Toaster = ( {
	type,
	message,
	autoHideDuration = 3,
	topLeft,
	topRight,
	topCenter,
	bottomLeft,
	bottomRight,
	bottomCenter,
	leftCenter,
	style,
} ) => {
	const [ isVisible, setIsVisible ] = useState( true );
	const [ removeFromDOM, setRemoveFromDOM ] = useState( false );

	const handleOnClick = ( event ) => {
		event.stopPropagation();
		setIsVisible( false );
	};

	setTimeout( () => {
		setIsVisible( false );
	}, autoHideDuration * 1000 );

	if ( ! isVisible ) {
		setTimeout( () => {
			setRemoveFromDOM( true );
		}, 500 );
	}

	const position = [
		topLeft && 'top-left',
		topRight && 'top-right',
		topCenter && 'top-center',
		bottomLeft && 'bottom-left',
		bottomRight && 'bottom-right',
		bottomCenter && 'bottom-center',
		leftCenter && 'left-center',
	]
		.filter( Boolean )
		.join( '' );

	return ! removeFromDOM ? (
		<div
			className={ `st-toaster ${ isVisible ? 'visible' : 'hidden' } ${
				position || ''
			}` }
			style={ style }
		>
			<div className="content">
				<div
					className={ `status-icon ${
						type === 'error' ? 'failed' : type
					}` }
				>
					{ ICONS[ type ] }
				</div>
				<div className="message">
					<p>{ message }</p>
				</div>
			</div>
			<div className="toaster-close">
				<button className="close-btn" onClick={ handleOnClick }>
					{ ICONS.close }
				</button>
			</div>
		</div>
	) : null;
};

export default Toaster;
