import React from 'react';
import { __ } from '@wordpress/i18n';
import { Grid } from '@brainstormforce/starter-templates';
import { decodeEntities } from '@wordpress/html-entities';
import { getDemo, checkRequiredPlugins } from '../../import-site/import-utils';
import { useStateValue } from '../../../store/store';

const SiteGrid = ( { sites } ) => {
	const storedState = useStateValue();
	const [ { favoriteSiteIDs, currentIndex }, dispatch ] = storedState;

	const allSites = [];

	if ( Object.keys( sites ).length ) {
		for ( const siteId in sites ) {
			allSites.push( {
				id: sites[ siteId ].id,
				image: sites[ siteId ][ 'thumbnail-image-url' ],
				title: decodeEntities( sites[ siteId ].title ),
				badge:
					'agency-mini' === sites[ siteId ][ 'astra-sites-type' ]
						? __( 'Premium', 'astra-sites' )
						: '',
				...sites[ siteId ],
			} );
		}
	}

	const quickToggleFavorites = ( siteId, favoriteStatus ) => {
		let favoriteIds = favoriteSiteIDs;
		if ( favoriteStatus && ! favoriteIds.includes( siteId ) ) {
			favoriteIds.push( siteId );
		} else {
			favoriteIds = favoriteSiteIDs.filter(
				( existingId ) => existingId !== siteId
			);
		}

		dispatch( {
			type: 'set',
			favoriteSiteIDs: favoriteIds,
		} );
	};

	const toggleFavorites = async ( event, item, favoriteStatus ) => {
		try {
			event.preventDefault();

			const siteId = `id-${ item.id }`;

			// Quick toggle the favorites.
			quickToggleFavorites( siteId, favoriteStatus );

			// Dispatch toggle favorite.
			const formData = new FormData();
			formData.append( 'action', 'astra-sites-favorite' );
			formData.append( 'is_favorite', favoriteStatus );
			formData.append( 'site_id', siteId );
			const resonse = await fetch( ajaxurl, {
				method: 'post',
				body: formData,
			} );
			const data = await resonse.json();

			// Toggle fail so unset favorite.
			if ( ! data.success ) {
				quickToggleFavorites( siteId, false );
			}
		} catch ( err ) {
			// Do nothing
		}
	};

	return (
		<Grid
			column={ 4 }
			options={ allSites }
			hasFavorite
			onFavoriteClick={ toggleFavorites }
			favoriteList={ favoriteSiteIDs }
			onClick={ async ( event, item ) => {
				event.stopPropagation();
				dispatch( {
					type: 'set',
					currentIndex: currentIndex + 1,
					templateId: item.id,
					selectedTemplateName: item.title,
					selectedTemplateType: item[ 'astra-sites-type' ],
				} );
				await getDemo( item.id, storedState );
				checkRequiredPlugins( storedState );
			} }
		/>
	);
};

export default SiteGrid;
