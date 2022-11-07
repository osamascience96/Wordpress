/* Typography */
jQuery( document ).ready(function($) {
	"use strict";

	$('.google-fonts-list').each(function (i, obj) {
		if (!$(this).hasClass('select2-hidden-accessible')) {
			$(this).select2();
		}
	});

	$('.google-fonts-list').on('change', function() {
		var elementRegularWeight = $(this).parent().parent().find('.google-fonts-regularweight-style');
		var elementItalicWeight = $(this).parent().parent().find('.google-fonts-italicweight-style');
		var elementBoldWeight = $(this).parent().parent().find('.google-fonts-boldweight-style');
		var selectedFont = $(this).val();
		var customizerControlName = $(this).attr('control-name');
		var elementItalicWeightCount = 0;
		var elementBoldWeightCount = 0;

		// Clear Weight/Style dropdowns
		elementRegularWeight.empty();
		elementItalicWeight.empty();
		elementBoldWeight.empty();
		// Make sure Italic & Bold dropdowns are enabled
		elementItalicWeight.prop('disabled', false);
		elementBoldWeight.prop('disabled', false);

		// Get the Google Fonts control object
		var bodyfontcontrol = _wpCustomizeSettings.controls[customizerControlName];

		// Find the index of the selected font
		var indexes = $.map(bodyfontcontrol.botigafontslist, function(obj, index) {
			if(obj.family === selectedFont) {
				return index;
			}
		});
		var index = indexes[0];

		// For the selected Google font show the available weight/style variants
		$.each(bodyfontcontrol.botigafontslist[index].variants, function(val, text) {

			elementRegularWeight.append(
				$('<option></option>').val(text).html(text)
			);

			//Set default value
			if ( $(elementRegularWeight).find( 'option[value="regular"]').length > 0 ) {
				$( elementRegularWeight ).val( 'regular' );
			} else if ( $(elementRegularWeight).find( 'option[value="400"]').length > 0 ) {
				$( elementRegularWeight ).val( '400' );
			} else if ( $(elementRegularWeight).find( 'option[value="300"]').length > 0 ) {
				$( elementRegularWeight ).val( '300' );
			}

			if (text.indexOf("italic") >= 0) {
				elementItalicWeight.append(
					$('<option></option>').val(text).html(text)
				);
				elementItalicWeightCount++;

				if ( $(elementItalicWeight).find( 'option[value="italic"]').length > 0 ) {
					$( elementItalicWeight ).val( 'italic' );
				} else if ( $(elementItalicWeight).find( 'option[value="400italic"]').length > 0 ) {
					$( elementItalicWeight ).val( '400italic' );
				} else if ( $(elementItalicWeight).find( 'option[value="300italic"]').length > 0 ) {
					$( elementItalicWeight ).val( '300italic' );
				}				
			} else {
				elementBoldWeight.append(
					$('<option></option>').val(text).html(text)
				);
				elementBoldWeightCount++;

				if ( $(elementBoldWeight).find( 'option[value="600"]').length > 0 ) {
					$( elementBoldWeight ).val( '600' );
				} else if ( $(elementBoldWeight).find( 'option[value="500"]').length > 0 ) {
					$( elementBoldWeight ).val( '500' );
				} else if ( $(elementBoldWeight).find( 'option[value="700"]').length > 0 ) {
					$( elementBoldWeight ).val( '700' );
				}				
			}
		});

		if(elementItalicWeightCount == 0) {
			elementItalicWeight.append(
				$('<option></option>').val('').html('Not Available for this font')
			);
			elementItalicWeight.prop('disabled', 'disabled');
		}
		if(elementBoldWeightCount == 0) {
			elementBoldWeight.append(
				$('<option></option>').val('').html('Not Available for this font')
			);
			elementBoldWeight.prop('disabled', 'disabled');
		}

		// Update the font category based on the selected font
		$(this).parent().parent().find('.google-fonts-category').val(bodyfontcontrol.botigafontslist[index].category);

		botigaGetAllSelects($(this).parent().parent().parent().parent());
	});

	$('.google_fonts_select_control select').on('change', function() {
		botigaGetAllSelects($(this).parent().parent().parent().parent());
	});

	function botigaGetAllSelects($element) {
		var selectedFont = {
			font: $element.find('.google-fonts-list').val(),
			regularweight: $element.find('.google-fonts-regularweight-style').val(),
			italicweight: $element.find('.google-fonts-italicweight-style').val(),
			boldweight: $element.find('.google-fonts-boldweight-style').val(),
			category: $element.find('.google-fonts-category').val()
		};

		// Important! Make sure to trigger change event so Customizer knows it has to save the field
		$element.find('.customize-control-google-font-selection').val(JSON.stringify(selectedFont)).trigger('change');
  }
  
});