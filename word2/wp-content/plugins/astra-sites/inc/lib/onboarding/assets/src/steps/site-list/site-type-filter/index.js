import React from 'react';
import { __ } from '@wordpress/i18n';
import { useStateValue } from '../../../store/store';
import Toggle from '../../../components/toggle';

const SiteType = () => {
	const [ { siteType }, dispatch ] = useStateValue();

	return (
		<Toggle
			className="site-type-filter"
			value={ siteType }
			options={ [
				{
					id: '',
					title: __( 'All', 'astra-sites' ),
				},
				{
					id: 'agency-mini',
					title: __( 'Premium', 'astra-sites' ),
				},
			] }
			onClick={ ( event, type ) => {
				dispatch( {
					type: 'set',
					siteType: type.id,
					onMyFavorite: false,
				} );
			} }
		/>
	);
};

export default SiteType;
