// External Dependencies.
import React, { useState } from 'react';

// Internal Dependencies.
import './style.scss';

const Tooltip = ( { children, content } ) => {
	const [ isVisible, setIsVisible ] = useState( false );
	const [ timeOutRef, setTimeOutRef ] = useState( null );

	const visibleTooltip = () => {
		setIsVisible( true );
	};

	const autoHideTooltip = () => {
		setTimeOutRef(
			setTimeout( () => {
				setIsVisible( false );
			}, 50 )
		);
	};

	const clearAutoHide = () => {
		clearTimeout( timeOutRef );
	};

	return (
		<div
			className="stc-tooltip"
			onMouseEnter={ visibleTooltip }
			onMouseLeave={ autoHideTooltip }
		>
			{ children }

			{ content ? (
				<div
					className={ `stc-tooltip-content ${
						isVisible ? 'stc-tooltip-visible' : 'stc-tooltip-hidden'
					}` }
					onMouseEnter={ clearAutoHide }
					onMouseLeave={ autoHideTooltip }
				>
					{ content }
				</div>
			) : null }
		</div>
	);
};

export default Tooltip;
