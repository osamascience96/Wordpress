import React from 'react';
import { __ } from '@wordpress/i18n';
import { decodeEntities } from '@wordpress/html-entities';
import { PremiumBadge } from '@brainstormforce/starter-templates';
import { useStateValue } from '../../store/store';
import './style.scss';
import ICONS from '../../../icons';
import { sendPostMessage } from '../../utils/functions';

const ChangeTemplate = () => {
	const [
		{
			selectedTemplateName,
			currentIndex,
			licenseStatus,
			selectedTemplateType,
		},
		dispatch,
	] = useStateValue();

	const goToShowcase = () => {
		sendPostMessage( {
			param: 'clearPreviewAssets',
			data: {},
		} );

		setTimeout( () => {
			dispatch( {
				type: 'set',
				currentIndex: currentIndex - 1,
				currentCustomizeIndex: 0,
			} );
		}, 300 );
	};

	return (
		<div className="change-template-wrap">
			<div className="template-name">
				<p className="label">
					{ __( 'Selected Template:', 'astra-sites' ) }
				</p>
				<h5>{ decodeEntities( selectedTemplateName ) }</h5>
				{ ! licenseStatus && 'free' !== selectedTemplateType && (
					<PremiumBadge />
				) }
			</div>
			<div className="change-btn-wrap" onClick={ goToShowcase }>
				<span className="change-btn">{ ICONS.cross }</span>
			</div>
		</div>
	);
};
export default ChangeTemplate;
