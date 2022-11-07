/**
 * Select.
 */

import {
	$,
	$window,
	$doc,
	$body
} from './utility';


$( document ).ready( function() {

	function selectImage( opt ) {
		if ( ! opt.id ) {
			return opt.text;
		}

		var optimage = $( opt.element ).data( 'image' );

		if ( !optimage ) {
			return opt.text;

		} else {
			var $opt = $(
				'<span class="select-line"><img width="24px" src="' + optimage + '" class="select-image" /> ' + $( opt.element ).text() + '</span>'
			);

			return $opt;
		}
	};

	$( '.atss-categories-select' ).select2( {
		dropdownAutoWidth : true,
		width: 'auto',
		minimumResultsForSearch: -1,
		dropdownCssClass: 'atss-select-dropdown',
	} );

	$( '.atss-builders-select' ).select2( {
		dropdownAutoWidth : true,
		width: 'auto',
		minimumResultsForSearch: -1,
		templateResult: selectImage,
		templateSelection: selectImage,
		dropdownCssClass: 'atss-select-dropdown',
	} );
} );
