import React, { useEffect, useRef, useState } from 'react';
import { ToggleDropdown } from '@brainstormforce/starter-templates';

const Toggle = ( { value, options, onClick, className } ) => {
	const [ toggle, setToggle ] = useState( false );
	const ref = useRef();

	const handleToggle = ( event ) => {
		if ( ref && ! ref.current.contains( event.target ) ) {
			setToggle( false );
		}
	};

	useEffect( () => {
		document
			.getElementById( 'starter-templates-ai-root' )
			.addEventListener( 'click', handleToggle );
		return () =>
			document
				.getElementById( 'starter-templates-ai-root' )
				.removeEventListener( 'click', handleToggle );
	}, [] );

	return (
		<ToggleDropdown
			ref={ ref }
			toggle={ toggle }
			onToggle={ ( event, newToggle ) => {
				setToggle( newToggle );
			} }
			value={ value }
			options={ options }
			onClick={ ( event, option ) => {
				setToggle( false );
				onClick( event, option );
			} }
			className={ className || '' }
		/>
	);
};

export default Toggle;
