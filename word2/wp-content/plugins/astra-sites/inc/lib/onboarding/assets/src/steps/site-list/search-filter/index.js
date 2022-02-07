import React, { useState, useRef, useEffect, useCallback } from 'react';
import { __ } from '@wordpress/i18n';
import { Search } from '@brainstormforce/starter-templates';
import { decodeEntities } from '@wordpress/html-entities';
import { useNavigate } from 'react-router-dom';
import { useStateValue } from '../../../store/store';
import { initialState } from '../../../store/reducer';
import './style.scss';
import { setURLParmsValue } from '../../../utils/url-params';
const $ = jQuery;

const SiteSearch = () => {
	const [
		{ siteSearchTerm, searchTerms, searchTermsWithCount, builder },
		dispatch,
	] = useStateValue();
	const [ searchTerm, setSearchTerm ] = useState( siteSearchTerm );

	const useDebouncedEffect = ( effect, delay, deps ) => {
		const callback = useCallback( effect, deps );

		useEffect( () => {
			const handler = setTimeout( () => {
				callback();
			}, delay );

			return () => {
				clearTimeout( handler );
			};
		}, [ callback, delay ] );
	};

	useEffect( () => {
		$( document ).on( 'heartbeat-send', sendHeartbeat );
		$( document ).on( 'heartbeat-tick', heartbeatDone );
	}, [] );

	useDebouncedEffect( () => collectTerms(), 1000, [ searchTerm ] );

	const heartbeatDone = ( e, data ) => {
		// Check for our data, and use it.
		if ( ! data[ 'ast-sites-search-terms' ] ) {
			return;
		}
		dispatch( {
			type: 'set',
			searchTerms: [],
			searchTermsWithCount: [],
		} );
	};

	const sendHeartbeat = ( e, data ) => {
		// Add additional data to Heartbeat data.
		if ( searchTerms.length > 0 ) {
			data[ 'ast-sites-search-terms' ] = searchTermsWithCount;
			data[ 'ast-sites-builder' ] = builder;
		}
	};

	const collectTerms = () => {
		const term = searchTerm.toLowerCase();
		const allTerms = searchTerms;
		const allTermsWithCount = searchTermsWithCount;
		// Skip blank words and words smaller than 3 characters.
		if ( '' === term || term.length < 3 ) {
			return;
		}

		if ( ! searchTerms.includes( term ) ) {
			const count = document.getElementsByClassName(
				'stc-grid-wrap'
			)[ 0 ].childElementCount;
			allTerms.push( term );
			allTermsWithCount.push( {
				term,
				count,
			} );
			dispatch( {
				type: 'set',
				searchTerms: allTerms,
				searchTermsWithCount: allTermsWithCount,
				onMyFavorite: false,
			} );
		}
	};

	const ref = useRef();
	const parentRef = useRef();

	const handleScroll = ( event ) => {
		event.preventDefault();

		if ( ref && parentRef ) {
			const header = document.querySelector( '.site-list-header' );
			let topCross = 0;
			if ( header && header.clientHeight ) {
				topCross = header.clientHeight;
			}

			// Remove the search box height too.
			topCross = topCross - ref.current.clientHeight;

			// Check the search wrapper scrool top.
			const parentTop =
				parentRef.current.getBoundingClientRect().top || 0;
			if ( parentTop <= topCross ) {
				document.body.classList.add( 'st-search-box-fixed' );
			} else {
				document.body.classList.remove( 'st-search-box-fixed' );
			}
		}
	};

	useEffect( () => {
		document
			.querySelector( '.step-content' )
			.addEventListener( 'scroll', handleScroll );
		return () =>
			document
				.querySelector( '.step-content' )
				.removeEventListener( 'scroll', handleScroll );
	}, [] );

	const onSearchKeyUp = ( event ) => {
		event.preventDefault();
		const content = document.querySelector( '.st-templates-content' );
		const top = content
			? parseInt( content.getBoundingClientRect().top )
			: 0;
		if (
			top < 0 &&
			32 !== event.keyCode &&
			16 !== event.keyCode &&
			17 !== event.keyCode &&
			18 !== event.keyCode
		) {
			const header = document.querySelector( '.site-list-header' );
			const headerHeight = header ? parseInt( header.clientHeight ) : 0;
			document.querySelector( '.step-content' ).scrollTo( {
				behavior: 'smooth',
				left: 0,
				top: content.offsetTop - headerHeight - 20,
			} );
		}
	};
	const history = useNavigate();
	return (
		<div className="st-search-box-wrap" ref={ parentRef }>
			<div className="st-search-filter st-search-box" ref={ ref }>
				<Search
					value={ decodeEntities( siteSearchTerm ) }
					placeholder={ __(
						'Search for Starter Templates',
						'astra-sites'
					) }
					onSearch={ ( event, newSearchTerm ) => {
						setSearchTerm( newSearchTerm );
						dispatch( {
							type: 'set',
							siteSearchTerm: newSearchTerm,
							onMyFavorite: initialState.onMyFavorite,
							siteCategory: initialState.siteCategory,
							siteType: initialState.siteType,
							siteOrder: initialState.siteOrder,
						} );
						const urlParam = setURLParmsValue( 's', newSearchTerm );
						history( `?${ urlParam }` );
					} }
					onKeyUp={ onSearchKeyUp }
				/>
			</div>
		</div>
	);
};

export default SiteSearch;
