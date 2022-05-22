/**
* Payment JS - Payment js for klinikal theme
* @version v3.0
* @copyright 2020 Pepdev.
*/
(function($) {
	'use strict';
	var stripe = Stripe('pk_test_JHnerHIUhudJUcuLcqiT4D7k00oxeq9wHr');

	function registerElements(elements, exampleName) {
		var formClass = '.' + exampleName;
		var example = document.querySelector(formClass);

		var form = example.querySelector('form');
		var resetButton = example.querySelector('a.reset');
		var error = form.querySelector('.error');
		var errorMessage = error.querySelector('.message');

		function triggerBrowserValidation() {
			var submit = document.createElement('input');
			submit.type = 'submit';
			submit.style.display = 'none';
			form.appendChild(submit);
			submit.click();
			submit.remove();
		}

  		// Listen for errors from each Element, and show error messages in the UI.
  		var savedErrors = {};
  		elements.forEach(function(element, idx) {
  			element.on('change', function(event) {
  				if (event.error) {
  					error.classList.add('visible');
  					savedErrors[idx] = event.error.message;
  					errorMessage.innerText = event.error.message;
  				} else {
  					savedErrors[idx] = null;
  					var nextError = Object.keys(savedErrors).sort().reduce(function(maybeFoundError, key) {
  						return maybeFoundError || savedErrors[key];
  					}, null);

  					if (nextError) {
          				// Now that they've fixed the current error, show another one.
          				errorMessage.innerText = nextError;
          			} else {
         				// The user fixed the last error; no more errors.
         				error.classList.remove('visible');
         			}
         		}
         	});
  		});

  		// Listen on the form's 'submit' handler...
  		form.addEventListener('submit', function(e) {
  			e.preventDefault();

  			var plainInputsValid = true;
  			Array.prototype.forEach.call(form.querySelectorAll('input'), function(input) {
  				if (input.checkValidity && !input.checkValidity()) {
  					plainInputsValid = false;
  					return;
  				}
  			});

  			if (!plainInputsValid) {
  				triggerBrowserValidation();
  				return;
  			}

    		// Show a loading screen...
    		example.classList.add('submitting');

    		stripe.createToken(elements[0]).then(function(result) {

    			example.classList.remove('submitting');

    			if (result.token) {
	        		example.querySelector('.stripeToken').innerText = result.token.id;
	        		example.classList.add('submitted');
	        		form.submit();
	        	} else {
	        		enableInputs();
	        		return false;
	        	}
	        });
    	});
  	}

  	var elements = stripe.elements();

  	var elementStyles = {
  		base: {
  			color: '#333',
  			fontWeight: 600,
  			fontFamily: 'Dosis, sans-serif',
  			fontSize: '16px',
  			fontSmoothing: 'antialiased',

  			':focus': {
  				color: '#424770',
  			},

  			'::placeholder': {
  				color: '#9BACC8',
  			},

  			':focus::placeholder': {
  				color: '#CFD7DF',
  			},
  		},
  		invalid: {
  			color: '#fff',
  			':focus': {
  				color: '#FA755A',
  			},
  			'::placeholder': {
  				color: '#FFCCA5',
  			},
  		},
  	};

  	var elementClasses = {
  		focus: 'focus',
  		empty: 'empty',
  		invalid: 'invalid',
  	};

  	var cardNumber = elements.create('cardNumber', {
  		style: elementStyles,
  		classes: elementClasses,
  	});
  	cardNumber.mount('#example3-card-number');

  	var cardExpiry = elements.create('cardExpiry', {
  		style: elementStyles,
  		classes: elementClasses,
  	});
  	cardExpiry.mount('#example3-card-expiry');

  	var cardCvc = elements.create('cardCvc', {
  		style: elementStyles,
  		classes: elementClasses,
  	});
  	cardCvc.mount('#example3-card-cvc');

  	registerElements([cardNumber, cardExpiry, cardCvc], 'example3');
  })();