import React, { useEffect } from 'react';
import DefaultStep from '../../components/default-step';
import SitePreview from '../../components/site-preview';
import { useStateValue } from '../../store/store';
import { CustomizeSteps } from './customize-steps';

const CustomizeSite = () => {
	const [
		{ currentCustomizeIndex, currentIndex, builder },
		dispatch,
	] = useStateValue();
	const currentStepObject = CustomizeSteps[ currentCustomizeIndex ];
	let CurrentStepContent;
	let CurrentStepControls;

	if ( typeof currentStepObject !== 'undefined' ) {
		CurrentStepContent = currentStepObject.content;
		CurrentStepControls = currentStepObject.controls;
	}

	useEffect( () => {
		const previousIndex = parseInt( currentCustomizeIndex ) - 1;
		const nextIndex = parseInt( currentCustomizeIndex ) + 1;

		if ( nextIndex > 0 && nextIndex < CustomizeSteps.length ) {
			document.body.classList.remove( CustomizeSteps[ nextIndex ].class );
		}

		if ( previousIndex >= 0 ) {
			document.body.classList.remove(
				CustomizeSteps[ previousIndex ].class
			);
		}

		document.body.classList.add(
			CustomizeSteps[ currentCustomizeIndex ].class
		);
	} );

	const setNextStep = () => {
		if ( CustomizeSteps.length - 1 === currentCustomizeIndex ) {
			return null;
		}
		if ( builder === 'beaver-builder' || builder === 'brizy' ) {
			dispatch( {
				type: 'set',
				currentIndex: currentIndex + 1,
			} );
		} else {
			dispatch( {
				type: 'set',
				currentCustomizeIndex: currentCustomizeIndex + 1,
			} );
		}
	};

	const setPreviousStep = () => {
		if ( 0 === currentCustomizeIndex ) {
			return null;
		}
		dispatch( {
			type: 'set',
			currentCustomizeIndex: currentCustomizeIndex - 1,
		} );
	};

	return (
		<DefaultStep
			stepName={ CustomizeSteps[ currentCustomizeIndex ].class }
			content={
				<CurrentStepContent
					customizeStep={ true }
					onNextClick={ setNextStep }
					onPreviousClick={ setPreviousStep }
				/>
			}
			controls={
				CurrentStepControls && (
					<CurrentStepControls
						customizeStep={ true }
						onNextClick={ setNextStep }
						onPreviousClick={ setPreviousStep }
					/>
				)
			}
			actions={ null }
			preview={ <SitePreview /> }
		/>
	);
};

export default CustomizeSite;
