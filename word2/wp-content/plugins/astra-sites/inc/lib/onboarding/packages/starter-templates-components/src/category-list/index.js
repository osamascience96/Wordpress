// External Dependencies.
import React, { useState, memo, useEffect } from 'react';
import { __ } from '@wordpress/i18n';
import { decodeEntities } from '@wordpress/html-entities';

// Internal Dependencies.
import './style.scss';
import { ToggleDropdown } from '..';

const CategoryList = ( { options, value, onClick, limit } ) => {
	let initialActive = '';
	if ( value !== undefined ) {
		initialActive = value;
	} else if ( options.length ) {
		initialActive = options[ 0 ].id;
	}
	const [ activeItem, setActiveItem ] = useState( initialActive );
	const [ showMore, setShowMore ] = useState( false );
	const [ more, setMore ] = useState( [] );
	const [ cats, setCats ] = useState( options );

	useEffect( () => {
		if ( limit ) {
			let moreList = options.slice( limit, limit + options.length );
			const limitedCats = options.slice( 0, limit );

			if ( moreList.length ) {
				moreList = moreList.map( ( item ) => {
					item.title = decodeEntities( item.name );
					return item;
				} );
			}
			setMore( moreList );
			setCats( limitedCats );
		}
	}, [] );

	const getActiveClass = ( id ) => {
		return activeItem === id ? 'active' : '';
	};

	useEffect( () => {
		setActiveItem( initialActive );
	}, [ value ] );

	const setActiveCategory = ( event, category ) => {
		if ( 'function' === typeof onClick ) {
			onClick( event, category );
		}
	};

	return (
		<div className={ `stc-category-list` }>
			{ cats.length ? (
				<>
					{ cats.map( ( category, index ) => {
						return (
							<div
								className={ `stc-category-list-item ${ getActiveClass(
									category.id
								) }` }
								onClick={ ( event ) => {
									setActiveItem( category.id );
									setActiveCategory( event, category );
								} }
								key={ index }
							>
								<span className="stc-category-list-title">
									{ decodeEntities( category.name ) }
								</span>
							</div>
						);
					} ) }

					{ more.length ? (
						<ToggleDropdown
							className={ `stc-category-list-item stc-category-list-more` }
							toggle={ showMore }
							onToggle={ ( event, newToggle ) => {
								setShowMore( newToggle );
							} }
							label={ __( 'More', 'astra-sites' ) }
							value={ activeItem }
							options={ more }
							onClick={ ( event, option ) => {
								setShowMore( false );
								setActiveCategory( event, option );
							} }
						/>
					) : null }
				</>
			) : (
				<span>{ __( 'No Categories', 'astra-sites' ) }</span>
			) }
		</div>
	);
};

export default memo( CategoryList );
