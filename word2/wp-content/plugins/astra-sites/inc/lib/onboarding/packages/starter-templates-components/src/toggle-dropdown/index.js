// External Dependencies.
import React, { useEffect, useState, forwardRef } from 'react';

// Internal Dependencies.
import './style.scss';
import { Logo } from '../index';
import { ICONS } from '../icons';

const ToggleDropdown = forwardRef(
	(
		{ label, options, className, value, onClick, toggle, onToggle },
		ref
	) => {
		const [ state, setState ] = useState( {
			option: {
				id: '',
				title: '',
				image: '',
			},
		} );

		useEffect( () => {
			let activeItem = {
				id: '',
				title: '',
				image: '',
			};
			options.map( ( single ) => {
				if ( value === single.id ) {
					activeItem = single;
				}
				return activeItem;
			} );

			setState( { ...state, option: activeItem } );
		}, [ value ] );

		if ( ! options.length ) {
			return '';
		}

		return (
			<div ref={ ref } className={ `stc-toggle-dropdown ${ className }` }>
				<div
					className="stc-toggle-dropdown-selected"
					onClick={ ( event ) => {
						if ( 'function' === typeof onToggle ) {
							onToggle( event, ! toggle );
						}
					} }
				>
					{ label && '' === state.option.title ? (
						label
					) : (
						<>
							{ state.option.image ? (
								<Logo
									text={ state.option.title }
									src={ state.option.image }
								/>
							) : (
								state.option.title
							) }
						</>
					) }

					{ ICONS.dropdown }
				</div>
				{ toggle && (
					<div className="stc-toggle-dropdown-popup">
						<div className="stc-toggle-dropdown-popup-content">
							{ options.map( ( option, index ) => {
								return (
									<div
										className={ `stc-toggle-dropdown-popup-item ${
											state.option.id === option.id
												? 'active'
												: ''
										}` }
										onClick={ ( event ) => {
											setState( {
												...state,
												option,
											} );

											if (
												'function' === typeof onClick
											) {
												onClick( event, option );
											}
										} }
										key={ index }
									>
										{ option.image ? (
											<Logo
												text={ option.title }
												src={ option.image }
											/>
										) : (
											option.title
										) }
									</div>
								);
							} ) }
						</div>
					</div>
				) }
			</div>
		);
	}
);

export default ToggleDropdown;
