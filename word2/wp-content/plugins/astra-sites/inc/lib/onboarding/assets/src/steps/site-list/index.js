// External Dependencies.
import React, { useEffect, useState } from 'react';
import { sprintf, __ } from '@wordpress/i18n';
import { decodeEntities } from '@wordpress/html-entities';
import { sortBy } from 'underscore';

// Internal Dependencies.
import { DefaultStep, PreviousStepLink, Button } from '../../components/index';
import './style.scss';
import { getSitesBySearchTerm } from '../../utils/search';
import { useStateValue } from '../../store/store';
import {
	isPro,
	whiteLabelEnabled,
	storeCurrentState,
	getAllSites,
} from '../../utils/functions';
import SiteListSkeleton from './site-list-skeleton';
import SiteGrid from './sites-grid/index';
import SiteSearch from './search-filter';
import SiteType from './site-type-filter';
import SiteOrder from './site-order-filter';
import SiteCategory from './site-category-filter';
import NoResultFound from './no-result-found';
import NoFavoriteSites from './no-favorite-sites';
import RelatedSites from './related-sites';

const SiteList = () => {
	const [ loadingSkeleton, setLoadingSkeleton ] = useState( true );
	const [ siteData, setSiteData ] = useState( {
		sites: {},
		tags: [],
		defaultSites: {},
		allFavorites: [],
	} );
	const [ storedState, dispatch ] = useStateValue();
	const {
		favoriteSiteIDs,
		onMyFavorite,
		builder,
		siteSearchTerm,
		siteType,
		siteOrder,
		siteCategory,
		allSitesData,
		allCategories,
		allCategoriesAndTags,
	} = storedState;

	useEffect( () => {
		dispatch( {
			type: 'set',
			templateResponse: null,
			selectedTemplateName: '',
			selectedTemplateType: '',
			shownRequirementOnce: false,
		} );

		const response = getSitesBySearchTerm(
			siteSearchTerm,
			siteType,
			'',
			builder,
			allSitesData,
			allCategories,
			allCategoriesAndTags
		);

		let sites = { ...response.sites, ...response.related };
		if ( 'latest' === siteOrder && Object.keys( sites ).length ) {
			sites = sortBy( sites, 'publish-date' ).reverse();
		}

		const allFavorites = [];
		const allSites = getAllSites();
		if ( onMyFavorite && Object.keys( allSites ).length > 0 ) {
			for ( const siteId in allSites ) {
				if (
					favoriteSiteIDs.length &&
					favoriteSiteIDs.includes( siteId )
				) {
					allFavorites.push( {
						id: siteId.replace( 'id-', '' ),
						image: allSites[ siteId ][ 'thumbnail-image-url' ],
						title: decodeEntities( allSites[ siteId ].title ),
						badge:
							'agency-mini' ===
							allSites[ siteId ][ 'astra-sites-type' ]
								? __( 'Premium', 'astra-sites' )
								: '',
						...allSites[ siteId ],
					} );
				}
			}
		}

		setSiteData( {
			...siteData,
			...response,
			defaultSites: getSitesBySearchTerm(
				'',
				'',
				'',
				builder,
				allSitesData,
				allCategories,
				allCategoriesAndTags
			).sites,
			sites,
			allFavorites,
		} );
		setTimeout( () => {
			setLoadingSkeleton( false );
		}, 300 );
	}, [
		favoriteSiteIDs,
		onMyFavorite,
		builder,
		siteSearchTerm,
		siteType,
		siteOrder,
		siteCategory,
		allSitesData,
	] );

	storeCurrentState( storedState );

	const siteCount = Object.keys( siteData.sites ).length;

	return (
		<DefaultStep
			content={
				<div
					className={ `site-list-screen-container ${
						loadingSkeleton ? 'site-loading' : 'site-loaded'
					}` }
				>
					<SiteListSkeleton />
					<div className="site-list-screen-wrap">
						<h1>
							{ __(
								'What type of website are you building?',
								'astra-sites'
							) }
						</h1>

						<div className="site-list-content">
							<SiteSearch />

							<div className="st-templates-content">
								<div className="st-other-filters">
									<div className="st-category-filter">
										<SiteCategory />
									</div>
									<div className="st-type-and-order-filters">
										{ builder !== 'gutenberg' && (
											<SiteType />
										) }
										<SiteOrder />
									</div>
								</div>

								{ onMyFavorite ? (
									<>
										{ siteData.allFavorites.length ? (
											<div className="st-sites-grid">
												<SiteGrid
													sites={
														siteData.allFavorites
													}
												/>
											</div>
										) : (
											<>
												<NoFavoriteSites />
												<RelatedSites
													sites={
														siteData.defaultSites
													}
												/>
											</>
										) }
									</>
								) : (
									<>
										{ siteCount ? (
											<>
												<div className="st-sites-grid">
													{ siteSearchTerm && (
														<div className="st-sites-found-message">
															{ sprintf(
																/* translators: %1$s: search term. */
																__(
																	'Starter Templates for %1$s:',
																	'astra-sites'
																),
																decodeEntities(
																	siteSearchTerm
																)
															) }
														</div>
													) }
													<SiteGrid
														sites={ siteData.sites }
													/>
												</div>
											</>
										) : (
											<>
												<NoResultFound />
												<RelatedSites
													sites={
														siteData.defaultSites
													}
												/>
											</>
										) }
									</>
								) }
							</div>
						</div>
					</div>
				</div>
			}
			actions={
				<>
					<PreviousStepLink before>
						{ __( 'Back', 'astra-sites' ) }
					</PreviousStepLink>

					{ ! isPro() && ! whiteLabelEnabled() && (
						<div className="cta-strip-right">
							<h5>
								{ __(
									'Get unlimited access to all Premium Starter Templates and more, at a single low cost!',
									'astra-sites'
								) }
							</h5>
							<Button
								className="st-access-btn"
								onClick={ () =>
									window.open(
										astraSitesVars.cta_links[ builder ]
									)
								}
							>
								{ __( 'Get Essential Bundle', 'astra-sites' ) }
							</Button>
						</div>
					) }
				</>
			}
		/>
	);
};

export default SiteList;
