/**
 * Finish Animation.
 */

import {
	$,
	$window,
	$doc,
	$body
} from './utility';

'use strict';

var _window$popmotion = window.popmotion;
var tween = _window$popmotion.tween;
var physics = _window$popmotion.physics;
var easing = _window$popmotion.easing;
var transform = _window$popmotion.transform;
var easeIn = easing.easeIn;
var interpolate = transform.interpolate;

function showTick() {

	if ( $( '.atss-import-logo' ).data( 'init' ) ) {
		$( '.atss-import-logo' ).html( $( '.atss-import-logo' ).data( 'init' ) );
	} else {
		$( '.atss-import-logo' ).data( 'init', $( '.atss-import-logo' ).html() )
	}

	var circleStyler = styler( document.getElementById( 'tick-outline-path' ) );
	var tickStyler = styler( document.getElementById( 'tick-path' ) );

	var spinCircle = physics( {
		velocity: -400,
		onUpdate: function onUpdate( v ) {
			return circleStyler.set( 'rotate', v );
		}
	} );

	var mapCircleOpacityToLength = interpolate( [ 0, 1 ], [ 0, 65 ] );
	var openOutline = tween( {
		ease: easeIn,
		onUpdate: function onUpdate( v ) {
			return circleStyler.set( {
				opacity: v,
				pathLength: mapCircleOpacityToLength( v )
			} );
		},
		onComplete: function onComplete() {
			return spinCircle.start();
		}
	} ).start();

	setTimeout( function() {
		// Complete the circle
		tween( {
			from: circleStyler.get( 'pathLength' ),
			to: 100,
			onUpdate: function onUpdate( v ) {
				return circleStyler.set( 'pathLength', v );
			}
		} ).start();

		// Slow the spinning
		spinCircle.setProps( {
			friction: 0.6
		} );

		// Draw tick
		tween( {
			onUpdate: function onUpdate( v ) {
				return tickStyler.set( {
					opacity: v,
					pathLength: v * 100
				} );
			}
		} ).start();
	}, 1000 );
}

$( document ).on( 'DOMImportFinish', showTick );
