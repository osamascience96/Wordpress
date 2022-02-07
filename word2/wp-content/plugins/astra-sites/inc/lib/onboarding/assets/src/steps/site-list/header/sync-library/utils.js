const { post } = wp.ajax;
const { nonce } = starterTemplates;

// Store current sync status.
let syncStatus = [];
let syncEnded = false;

export const getFormData = ( action, value ) => {
	const formData = new FormData();
	formData.append( action, value );
	return formData;
};

// Check if library synced syccessfully.
export const isSyncSuccess = () => {
	if ( !! syncStatus && syncEnded ) {
		const status = syncStatus.every( Boolean );
		syncStatus = [];
		syncEnded = false;
		return status;
	}
};

export const SyncStart = async () => {
	// Sync Start.
	try {
		const response = await fetch( ajaxurl, {
			method: 'post',
			body: getFormData( 'action', 'astra-sites-update-library' ),
		} );
		const jsonData = await response.json();
		const data = await jsonData.data;

		let allSitesData = null;
		let categories = null;
		let categoriesAndTags = null;
		syncStatus = [];

		if ( data === 'updated' ) {
			syncStatus.push( true );
			syncEnded = true;
		} else {
			allSitesData = await SyncImportAllSites();
			syncStatus.push( await SyncAllCategoriesAndTags() );
			syncStatus.push( await SyncAllCategories() );
			syncStatus.push( await SyncPageBuilders() );
			syncStatus.push( await SyncBlocks() );
			syncStatus.push( await SyncBlockCategories() );
			syncStatus.push( await SyncLibraryComplete() );
			syncStatus.push( allSitesData );
			categories = await SyncAndGetAllCategories();
			categoriesAndTags = await SyncAndGetAllCategoriesAndTags();
			syncEnded = true;
		}

		return {
			sites: allSitesData,
			categories,
			categoriesAndTags,
		};
	} catch ( error ) {
		syncStatus.push( false );
		syncEnded = true;
		return false;
	}
};

export const SyncLibraryComplete = async () => {
	// Sync complete.
	try {
		const response = await fetch( ajaxurl, {
			method: 'post',
			body: getFormData(
				'action',
				'astra-sites-update-library-complete'
			),
		} ).then( ( res ) => res.json() );

		if ( response.success === true ) {
			return true;
		}

		return false;
	} catch ( error ) {
		return false;
	}
};

export const SyncBlockCategories = async () => {
	// Import Block Categories.
	try {
		const response = await fetch( ajaxurl, {
			method: 'post',
			body: getFormData( 'action', 'astra-sites-import-page-builders' ),
		} ).then( ( res ) => res.json() );

		if ( response.success === true ) {
			return true;
		}

		return false;
	} catch ( error ) {
		return false;
	}
};

export const SyncBlocks = async () => {
	// Import Blocks.
	try {
		const totalBlocks = await fetch( ajaxurl, {
			method: 'post',
			body: getFormData(
				'action',
				'astra-sites-get-blocks-request-count'
			),
		} )
			.then( ( res ) => res.json() )
			.then( ( data ) => data.data );

		if ( totalBlocks ) {
			const allBlocksRequest = [];

			for ( let i = 1; i <= totalBlocks; i++ ) {
				const formData = new FormData();
				formData.append( 'action', 'astra-sites-import-blocks' );
				formData.append( 'page_no', i );

				allBlocksRequest.push(
					fetch( ajaxurl, {
						method: 'post',
						body: formData,
					} )
				);
			}

			const response = await Promise.allSettled(
				allBlocksRequest
			).then( ( res ) =>
				Promise.all( res.map( ( val ) => val.value.json() ) )
			);

			return response.every( ( res ) => res.success === true );
		}
	} catch ( error ) {
		return false;
	}
};

export const SyncPageBuilders = async () => {
	// Import page builders.
	try {
		const response = await fetch( ajaxurl, {
			method: 'post',
			body: getFormData( 'action', 'astra-sites-import-page-builders' ),
		} ).then( ( res ) => res.json() );

		if ( response.success === true ) {
			return true;
		}

		return false;
	} catch ( error ) {
		return false;
	}
};

export const SyncAllCategories = async () => {
	// Import all categories.
	try {
		const response = await fetch( ajaxurl, {
			method: 'post',
			body: getFormData( 'action', 'astra-sites-import-all-categories' ),
		} ).then( ( res ) => res.json() );

		if ( response.success === true ) {
			return true;
		}

		return false;
	} catch ( error ) {
		return false;
	}
};

export const SyncAllCategoriesAndTags = async () => {
	// Import all categories and tags.
	try {
		const response = await fetch( ajaxurl, {
			method: 'post',
			body: getFormData(
				'action',
				'astra-sites-import-all-categories-and-tags'
			),
		} ).then( ( res ) => res.json() );

		if ( response.success === true ) {
			return true;
		}

		return false;
	} catch ( error ) {
		return false;
	}
};

export const SyncImportAllSites = async () => {
	try {
		// Get sites request count.
		const totalRequest = await post( {
			action: 'astra-sites-get-sites-request-count',
			_ajax_nonce: nonce,
		} );

		// Import all sites.
		if ( totalRequest ) {
			const allSitesRequests = [];

			for ( let i = 1; i <= totalRequest; i++ ) {
				const formData = new FormData();
				formData.append( 'action', 'astra-sites-import-sites' );
				formData.append( 'page_no', i );
				allSitesRequests.push(
					await fetch( ajaxurl, {
						method: 'post',
						body: formData,
					} )
				);
			}

			const results = await Promise.allSettled( allSitesRequests )
				.then( ( res ) =>
					Promise.all( res.map( ( item ) => item.value.json() ) )
				)
				.then( ( items ) => {
					let res = {};
					for ( const item of items ) {
						if ( typeof item.data === 'object' ) {
							res = { ...res, ...item.data };
						}
					}
					return res;
				} );

			return results;
		}
		return null;
	} catch ( error ) {
		return null;
	}
};

export const SyncAndGetAllCategories = async () => {
	try {
		const response = await fetch( ajaxurl, {
			method: 'post',
			body: getFormData( 'action', 'astra-sites-get-all-categories' ),
		} );
		const data = await response.json();

		return ! data.data.length ? null : data.data;
	} catch ( error ) {
		return null;
	}
};

export const SyncAndGetAllCategoriesAndTags = async () => {
	try {
		const response = await fetch( ajaxurl, {
			method: 'post',
			body: getFormData(
				'action',
				'astra-sites-get-all-categories-and-tags'
			),
		} );
		const data = await response.json();

		return ! data.data.length ? null : data.data;
	} catch ( error ) {
		return null;
	}
};
