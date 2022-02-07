import React, { useState } from 'react';
import { __ } from '@wordpress/i18n';
import DefaultStep from '../../components/default-step/index';
import { useStateValue } from '../../store/store';
import './style.scss';
import ICONS from '../../../icons';
import { Button } from '../../ui/style';
import { PreviousStepLink } from '../../components';
import { whiteLabelEnabled } from '../../utils/functions';

const Welcome = () => {
	const [ { currentIndex }, dispatch ] = useStateValue();
	const [ showClickToPlay, setShowClickToPlay ] = useState( true );

	const handleClick = () => {
		const target = document.getElementById( 'st-welcome-video' );
		const youtubeLink = target.src.replace(
			'&mute=1&controls=0',
			'&mute=0&controls=1'
		);
		target.src = youtubeLink;
		setShowClickToPlay( false );
	};

	const nextStep = () => {
		dispatch( {
			type: 'set',
			currentIndex: currentIndex + 1,
		} );
	};

	return (
		<DefaultStep
			content={
				<div className="welcome-screen">
					<h1 className="d-flex-center-align">
						{ __(
							'Getting Started with Starter Templates',
							'astra-sites'
						) }
					</h1>
					<p className="screen-description">
						{ __(
							'This is the very beginning of the fastest and easiest website building experience you`ve ever had!',
							'astra-sites'
						) }
					</p>
					{ ! whiteLabelEnabled() && (
						<div className="video-showcase" onClick={ handleClick }>
							{ showClickToPlay && (
								<div className="click-to-play-wrap">
									<span className="click-btn-text">
										{ ICONS.clickToPlay }
									</span>
									<span className="youtube-btn middle-content">
										{ ICONS.youtube }
									</span>
								</div>
							) }
							<iframe
								src="https://www.youtube-nocookie.com/embed/Ch6Yg-9eCyc?rel=0&autoplay=1&mute=1&controls=0&showinfo=0&loop=1&modestbranding=1&loop=1"
								frameBorder="0"
								allow="autoplay; encrypted-media"
								allowFullScreen
								title="st-welcome-video"
								id="st-welcome-video"
							/>
						</div>
					) }
					<div className="get-started-wrap">
						<Button onClick={ nextStep }>
							{ __( 'Build Your Website Now', 'astra-sites' ) }
						</Button>
					</div>
				</div>
			}
			actions={
				<>
					<PreviousStepLink
						before
						customizeStep={ true }
						onClick={ () => {
							window.location.href = starterTemplates.adminUrl;
						} }
					>
						{ __( 'Back', 'astra-sites' ) }
					</PreviousStepLink>
				</>
			}
		/>
	);
};

export default Welcome;
