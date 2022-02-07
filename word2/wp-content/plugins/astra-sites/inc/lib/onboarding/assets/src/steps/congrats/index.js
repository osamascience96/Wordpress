import React, { useState } from 'react';
import { __, sprintf } from '@wordpress/i18n';
import confetti from 'canvas-confetti';
import DefaultStep from '../../components/default-step/index';
import { useStateValue } from '../../store/store';
import './style.scss';
import ICONS from '../../../icons';
import { whiteLabelEnabled } from '../../utils/functions';
const { siteUrl } = starterTemplates;

const getTotalTime = ( value ) => {
	const hours = Math.floor( value / 60 / 60 );
	const minutes = Math.floor( value / 60 ) - hours * 60;
	const seconds = value % 60;

	if ( minutes ) {
		return minutes + '.' + seconds;
	}

	return '0.' + seconds;
};

const Congrats = () => {
	const [ { confettiDone, builder }, dispatch ] = useStateValue();

	const istConfetti = confetti.create(
		document.getElementById( 'ist-bashcanvas' ),
		{ resize: true }
	);

	if ( ! confettiDone ) {
		setTimeout( function () {
			istConfetti( {
				particleCount: 250,
				origin: { x: 1, y: 1.4 },
				gravity: 0.4,
				spread: 80,
				ticks: 300,
				angle: 120,
				startVelocity: 100,
				colors: [
					'#0e6ef1',
					'#f5b800',
					'#ff344c',
					'#98e027',
					'#9900f1',
				],
			} );
		}, 100 );

		setTimeout( function () {
			istConfetti( {
				particleCount: 250,
				origin: { x: 0, y: 1.4 },
				gravity: 0.4,
				spread: 80,
				ticks: 300,
				angle: 60,
				startVelocity: 100,
				colors: [
					'#0e6ef1',
					'#f5b800',
					'#ff344c',
					'#98e027',
					'#9900f1',
				],
			} );
			dispatch( {
				type: 'set',
				confettiDone: true,
			} );
		}, 500 );
	}

	const [ {} ] = useStateValue();
	const [ showClickToPlay, setShowClickToPlay ] = useState( true );

	const link = `<a href=${ siteUrl } target="_blank">View Your Website</a>`;

	const start = localStorage.getItem( 'st-import-start' );
	const end = localStorage.getItem( 'st-import-end' );
	const diff = end - start;
	const unixTimeInSeconds = Math.floor( diff / 1000 );

	const totalTime = start && end ? getTotalTime( unixTimeInSeconds ) : 0;
	const typeOfTime = totalTime > 1 ? 'minutes' : 'seconds';

	let timeTaken = totalTime;

	let descMessage;
	let tweetMessage;
	const threshold = 5; // Max 5 mins threshold.

	if ( timeTaken > 0 && timeTaken <= threshold ) {
		timeTaken = timeTaken < 1 ? timeTaken.split( '.' )[ 1 ] : timeTaken;

		descMessage = sprintf(
			//translators: %1$s Time taken %2$s Time Type %3$s Website Url.
			__(
				`Your Website is ready and it took just %1$s %2$s to build. %3$s`,
				'astra-sites'
			),
			timeTaken,
			typeOfTime,
			link
		);
		tweetMessage = `I just built my website in ${ timeTaken } ${ typeOfTime } with Starter Templates by @AstraWP. Can't believe how easy it is! 😍`;
	} else {
		descMessage = sprintf(
			//translators: Website URL.
			__( 'Your Website is up and ready!. %1$s', 'astra-sites' ),
			link
		);
		tweetMessage = `I just built my website with Starter Templates by @AstraWP in minutes. Can't believe how easy it is! 😍`;
	}

	const handleClick = () => {
		const target = document.getElementById( 'st-information-video' );
		const youtubeLink = target.src.replace(
			'&mute=1&controls=0',
			'&mute=0&controls=1'
		);
		target.src = youtubeLink;
		setShowClickToPlay( false );
	};

	const ytId = builder === 'gutenberg' ? 'Zb2DU4vzNWE' : '3dARpNLcL30';

	return (
		<DefaultStep
			content={
				<div className="congrats-screen">
					<h1 className="d-flex-center-align">
						{ __( 'Congratulations!', 'astra-sites' ) }
						{ ICONS.tada }
					</h1>
					<p
						className="screen-description p-bold"
						dangerouslySetInnerHTML={ { __html: descMessage } }
					/>
					{ ! whiteLabelEnabled() && (
						<>
							<div
								className="video-showcase"
								onClick={ handleClick }
							>
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
									src={ `https://www.youtube-nocookie.com/embed/${ ytId }?rel=0&autoplay=1&mute=1&controls=0&showinfo=0&loop=1&modestbranding=1&loop=1` }
									frameBorder="0"
									allow="autoplay; encrypted-media"
									allowFullScreen
									title="st-information-video"
									height="415"
									width="740"
									id="st-information-video"
								/>
							</div>
							<div className="tweet-import-success">
								<p className="tweet-text">{ tweetMessage }</p>
								<a
									href={ `https://twitter.com/intent/tweet?text=${ tweetMessage }` }
									target="_blank"
									className="twitter-btn-wrap"
									rel="noreferrer"
								>
									<p className="tweet-btn">
										{ __(
											'CLICK TO TWEET',
											'astra-sites'
										) }
									</p>
									{ ICONS.twitter }
								</a>
							</div>
						</>
					) }
				</div>
			}
			actions={ null }
		/>
	);
};

export default Congrats;
