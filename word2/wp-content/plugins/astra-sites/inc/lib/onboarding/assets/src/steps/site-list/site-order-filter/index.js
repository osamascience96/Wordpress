import React from 'react';
import { __ } from '@wordpress/i18n';
import { useStateValue } from '../../../store/store';
import Toggle from '../../../components/toggle';

const SiteOrder = () => {
	const [ { siteOrder }, dispatch ] = useStateValue();

	return (
		<Toggle
			className="site-order-filter"
			value={ siteOrder }
			options={ [
				{
					id: 'popular',
					title: __( 'Popular', 'astra-sites' ),
				},
				{
					id: 'latest',
					title: __( 'Latest', 'astra-sites' ),
				},
			] }
			onClick={ ( event, order ) => {
				dispatch( {
					type: 'set',
					siteOrder: order.id,
					onMyFavorite: false,
				} );
			} }
		/>
	);
};

export default SiteOrder;
