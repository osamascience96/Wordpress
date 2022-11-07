"use strict";

if (window.NodeList && !NodeList.prototype.forEach) {
    NodeList.prototype.forEach = function (callback, thisArg) {
        thisArg = thisArg || window;
        for (var i = 0; i < this.length; i++) {
            callback.call(thisArg, this[i], i, this);
        }
    };
}

var sydney = sydney || {};

/**
 * Handles toggling the navigation menu for small screens and enables TAB key
 * navigation support for dropdown menus.
 */
 sydney.navigation = {
	
	init: function() {

		var siteNavigation 	=  document.getElementById( 'mainnav' );

		const offCanvas 	= document.getElementsByClassName( 'sydney-offcanvas-menu' )[0];

		// Return early if the navigation don't exist.
		if ( ! siteNavigation ) {
			return;
		}

		//Toggle submenus
		var submenuToggles = siteNavigation.querySelectorAll( '.dropdown-symbol' );

		for ( var submenuToggle of submenuToggles ) {
			submenuToggle.addEventListener('keydown', function(e) {
				var isTabPressed = (e.key === 'Enter' || e.keyCode === 13);

				if (!isTabPressed) { 
					return; 
				}
				e.preventDefault();
				var parent = this.parentNode;
				console.log(parent);
				parent.getElementsByClassName( 'sub-menu' )[0].classList.toggle( 'toggled' );
			});
		}		
	
		const button 		= document.getElementsByClassName( 'menu-toggle' )[ 0 ];
		const closeButton 	= document.getElementsByClassName( 'mobile-menu-close' )[ 0 ];

		// Return early if the button don't exist.
		if ( 'undefined' === typeof button ) {
			return;
		}
	
		const menu = siteNavigation.getElementsByTagName( 'ul' )[ 0 ];

		const mobileMenuClose = siteNavigation.getElementsByClassName( 'mobile-menu-close' )[ 0 ];

		// Hide menu toggle button if menu is empty and return early.
		if ( 'undefined' === typeof menu ) {
			button.style.display = 'none';
			return;
		}
	
		if ( ! menu.classList.contains( 'nav-menu' ) ) {
			menu.classList.add( 'nav-menu' );
		}	

		var focusableEls = offCanvas.querySelectorAll('a[href]:not([disabled]):not(.mobile-menu-close)');

		var firstFocusableEl = focusableEls[0];  

		button.addEventListener( 'click', function(e) {

			e.preventDefault();

			button.classList.add( 'open' );

			offCanvas.classList.add( 'toggled' );

			document.body.classList.add( 'mobile-menu-visible' )
			
			//Toggle submenus
			var submenuToggles = offCanvas.querySelectorAll( '.dropdown-symbol' );

			for ( var submenuToggle of submenuToggles ) {
				submenuToggle.addEventListener( 'touchstart', submenuToggleHandler );
				submenuToggle.addEventListener( 'click', submenuToggleHandler );

				submenuToggle.addEventListener('keydown', function(e) {
					var isTabPressed = (e.key === 'Enter' || e.keyCode === 13);
	
					if (!isTabPressed) { 
						return; 
					}
					e.preventDefault();
					var parent = submenuToggle.parentNode.parentNode;
					parent.getElementsByClassName( 'sub-menu' )[0].classList.toggle( 'toggled' );
				});
			}
			
			//Trap focus inside modal
			firstFocusableEl.focus();
		} );

		function submenuToggleHandler(e) {
			e.preventDefault();
			var parent = e.target.closest( 'li' );
			parent.querySelector( '.sub-menu' ).classList.toggle( 'toggled' );
		}

		var focusableEls = offCanvas.querySelectorAll('a[href]:not([disabled])');
		var firstFocusableEl = focusableEls[0];  
		var lastFocusableEl = focusableEls[focusableEls.length - 1];
		var KEYCODE_TAB = 9;

		lastFocusableEl.addEventListener('keydown', function(e) {
			var isTabPressed = (e.key === 'Tab' || e.keyCode === KEYCODE_TAB);

			if (!isTabPressed) { 
				return; 
			}

			if ( e.shiftKey ) /* shift + tab */ {

			} else /* tab */ {
				firstFocusableEl.focus();
			}
		});		

		closeButton.addEventListener( 'click', function(e) {
			e.preventDefault();

			button.focus();

			button.classList.remove( 'open' );

			offCanvas.classList.remove( 'toggled' );

			document.body.classList.remove( 'mobile-menu-visible' );
		} );

		// Get all the link elements within the menu.
		const links = menu.getElementsByTagName( 'a' );
	
		// Get all the link elements with children within the menu.
		const linksWithChildren = menu.querySelectorAll( '.menu-item-has-children > a, .page_item_has_children > a' );
	
		// Toggle focus each time a menu link is focused or blurred.
		for ( const link of links ) {
			link.addEventListener( 'focus', toggleFocus, true );
			link.addEventListener( 'blur', toggleFocus, true );
		}
	
		// Toggle focus each time a menu link with children receive a touch event.
		for ( const link of linksWithChildren ) {
			link.addEventListener( 'touchstart', toggleFocus, false );
		}
	
		/**
		 * Sets or removes .focus class on an element.
		 */
		function toggleFocus() {
			if ( event.type === 'focus' || event.type === 'blur' ) {
				let self = this;
				// Move up through the ancestors of the current link until we hit .nav-menu.
				while ( ! self.classList.contains( 'nav-menu' ) ) {
					// On li elements toggle the class .focus.
					if ( 'li' === self.tagName.toLowerCase() ) {
						self.classList.toggle( 'focus' );
					}
					self = self.parentNode;
				}
			}
	
			if ( event.type === 'touchstart' ) {
				const menuItem = this.parentNode;

				for ( const link of menuItem.parentNode.children ) {
					if ( menuItem !== link ) {
						link.classList.remove( 'focus' );
					}
				}
				menuItem.classList.toggle( 'focus' );
			}
		}
	},
};

/**
 * Back to top
 */
sydney.backToTop = {
	init: function() {
		this.displayButton();	
	},

	setup: function() {
		const icon 	= document.getElementsByClassName( 'go-top' )[0];

		if ( typeof(icon) != 'undefined' && icon != null ) {
			var vertDist = window.pageYOffset;

			if ( vertDist > 800 ) {
				icon.classList.add( 'show' );
			} else {
				icon.classList.remove( 'show' );
			}
		
			icon.addEventListener( 'click', function() {
				window.scrollTo({
					top: 0,
					left: 0,
					behavior: 'smooth',
				});
			} );
		}
	},

	displayButton: function() {
		
		this.setup();

		window.addEventListener( 'scroll', function() {
			this.setup();
		}.bind( this ) );		
	},
};

/**
 * Remove preloader
 */
sydney.removePreloader = {
	init: function() {
		this.remove();	
	},

	remove: function() {
		const preloader = document.getElementsByClassName( 'preloader' )[0];

		if ( typeof( preloader ) == 'undefined' && preloader == null ) {
			return;
		}

        preloader.classList.add( 'disable' );
        setTimeout(function(){ preloader.classList.add( 'hide' ); }, 600);
	},
};

/**
 * Sticky menu
 * 
 * deprecated
 */
sydney.stickyMenu = {
	init: function() {
        this.headerClone();	
        
		window.addEventListener( 'resize', function() {
			this.headerClone();
        }.bind( this ) );	     
        
        this.sticky();

		window.addEventListener( 'scroll', function() {
			this.sticky();
        }.bind( this ) );	        
	},

	headerClone: function() {

        const header         = document.getElementsByClassName( 'site-header' )[0];
        const headerClone    = document.getElementsByClassName( 'header-clone' )[0];

		if ( ( typeof( headerClone ) == 'undefined' && headerClone == null ) || ( typeof( header ) == 'undefined' && header == null ) ) {
			return;
		}        

        headerClone.style.height = header.offsetHeight + 'px';
    },

	sticky: function() {

        const header = document.getElementsByClassName( 'site-header' )[0];
        
        if ( typeof( header ) == 'undefined' && header == null ) {
			return;
        }
        
		var vertDist = window.pageYOffset;
        var elDist 	 = header.offsetTop;
        

        if ( vertDist >= elDist) {
			header.classList.add( 'fixed' );
            document.body.classList.add( 'siteScrolled' );
        } else {
			header.classList.remove( 'fixed' );
            document.body.classList.remove( 'siteScrolled' );            
        }
        if ( vertDist >= 107 ) {
            header.classList.add( 'float-header' );
        } else {
            header.classList.remove( 'float-header' );
        }

    },

};

/**
 * Sticky header
 */
 sydney.stickyHeader = {
	init: function() {
		const sticky 	= document.getElementsByClassName( 'sticky-header' )[0];
		const body      = document.getElementsByTagName( 'body' )[0];

		if ( 'undefined' === typeof sticky ) {
			return;
		}

		if ( sticky.classList.contains( 'sticky-scrolltop' ) ) {
			var lastScrollTop = 0;
			var elDist 	 = sticky.offsetTop;

			var adminBar 	=  document.getElementsByClassName( 'admin-bar' )[0];
	
			if ( typeof( adminBar ) != 'undefined' && adminBar != null ) {		
				var elDist = elDist + 32;
			}

			window.addEventListener( 'scroll', function() {
			   var scroll = window.pageYOffset || document.documentElement.scrollTop;
			   console.log( elDist, lastScrollTop );
			    if ( scroll < lastScrollTop ) {
					sticky.classList.add( 'is-sticky' );
					body.classList.add( 'sticky-active' );
				} else {
					sticky.classList.remove( 'is-sticky' );
					body.classList.remove( 'sticky-active' );
				}
				if ( lastScrollTop < elDist ) {
					sticky.classList.remove( 'is-sticky' );
				}				
				lastScrollTop = scroll <= 0 ? 0 : scroll;
			}, false);
		} else {

			this.sticky();

			window.addEventListener( 'scroll', function() {
				this.sticky();
			}.bind( this ) );

		}

	},

	sticky: function() {
		const sticky 	= document.getElementsByClassName( 'sticky-header' )[0];
		const body      = document.getElementsByTagName( 'body' )[0];

		if ( sticky.classList.contains( 'header_layout_1' ) || sticky.classList.contains( 'header_layout_2' ) ) {
			var vertDist = window.pageYOffset;
			var elDist 	 = 0;
		} else {
			var vertDist = window.pageYOffset;
			var elDist 	 = sticky.offsetTop;
		}
		
		var adminBar 	=  document.getElementsByClassName( 'admin-bar' )[0];

		if ( typeof( adminBar ) != 'undefined' && adminBar != null ) {		
			var elDist = elDist + 32;
		}


		if ( vertDist > elDist ) {
			sticky.classList.add( 'sticky-active' );
			body.classList.add( 'sticky-active' );
		} else {
			sticky.classList.remove( 'sticky-active' );
			body.classList.remove( 'sticky-active' );
		}
		
	}
};

/**
 * Header search
 */
sydney.headerSearch = {
	init: function() {

		var self            = this;
		var button 		    = document.querySelectorAll( '.header-search' );
		var form 			= window.matchMedia('(max-width: 1024px)').matches ? document.querySelector( '#masthead-mobile .header-search-form' ) : document.querySelector( '#masthead .header-search-form' );

		if ( button.length === 0 ) {
			return;
		}
		
		var searchInput 	= form.getElementsByClassName('search-field')[0];
		var searchBtn 	    = form.getElementsByClassName('search-submit')[0];

		for ( var buttonEl of button ) {
			buttonEl.addEventListener( 'click', function(e){
				e.preventDefault();

				// Hide other search icons 
				if( button.length > 1 ) {
					for ( var btn of button ) {
						btn.classList.toggle( 'hide' );
					}
				}

				form.classList.toggle( 'active' );
				e.target.closest( '.header-search' ).getElementsByClassName( 'icon-search' )[0].classList.toggle( 'active' );
				e.target.closest( '.header-search' ).getElementsByClassName( 'icon-cancel' )[0].classList.toggle( 'active' );
				e.target.closest( '.header-search' ).classList.add( 'active' );
				e.target.closest( '.header-search' ).classList.remove( 'hide' );
				searchInput.focus();

				if( e.target.closest( '.sydney-offcanvas-menu' ) !== null ) {
					e.target.closest( '.sydney-offcanvas-menu' ).classList.remove( 'toggled' );
				}
			} );	
		}	

		searchBtn.addEventListener('keydown', function(e) {
			var isTabPressed = (e.key === 'Tab' || e.keyCode === KEYCODE_TAB);

			if (!isTabPressed) { 
				return; 
			}
			form.classList.remove( 'active' );

			// Back buttons to default state
			self.backButtonsToDefaultState( button );
			button.focus();
		});

		return this;
	},

	backButtonsToDefaultState: function( button ) {
		for ( var btn of button ) {
			btn.classList.remove( 'hide' );
			btn.querySelector( '.icon-cancel' ).classList.remove( 'active' );
			btn.querySelector( '.icon-search' ).classList.add( 'active' );
		}
	}
};

/**
 * Mobile menu
 */
sydney.mobileMenu = {
	init: function() {
        this.menu();
        
		window.addEventListener( 'resize', function() {
			this.menu();
        }.bind( this ) );
	},

	menu: function() {

        if ( window.matchMedia( "(max-width: 1024px)" ).matches ) {
            const mobileMenu = document.getElementsByClassName( 'mainnav' )[0];   
			
			if ( typeof( mobileMenu ) == 'undefined' || mobileMenu == null ) {
				return;
			}

            const menuToggle = document.getElementsByClassName( 'btn-menu' )[0];

            mobileMenu.setAttribute( 'id', 'mainnav-mobi' );

            mobileMenu.classList.add( 'syd-hidden' );

            var itemsWithChildren = mobileMenu.querySelectorAll( '.menu-item-has-children' );
            const svgSubmenu = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path d="M240.971 130.524l194.343 194.343c9.373 9.373 9.373 24.569 0 33.941l-22.667 22.667c-9.357 9.357-24.522 9.375-33.901.04L224 227.495 69.255 381.516c-9.379 9.335-24.544 9.317-33.901-.04l-22.667-22.667c-9.373-9.373-9.373-24.569 0-33.941L207.03 130.525c9.372-9.373 24.568-9.373 33.941-.001z"/></svg>';

			itemsWithChildren.forEach(
				function(currentValue, currentIndex, listObj) {
					currentValue.getElementsByTagName( 'ul' )[0].style.display = 'none';
					currentValue.getElementsByTagName( 'a' )[0].insertAdjacentHTML('beforeend', '<span class="btn-submenu">' + svgSubmenu + '</span>');
				},
				'myThisArg'
			);


            this.toggle( menuToggle, mobileMenu );

            const submenuToggles 	= mobileMenu.querySelectorAll( '.btn-submenu' );

			submenuToggles.forEach(
				function(currentValue, currentIndex, listObj) {
					currentValue.addEventListener( 'click', function(e) {
						e.preventDefault();
						var parent = currentValue.parentNode.parentNode;
						parent.getElementsByClassName( 'sub-menu' )[0].classList.toggle( 'toggled' );
					} );
				},
				'myThisArg'
			  );


        } else {
            const mobile = document.getElementById( 'mainnav-mobi' );

            if ( typeof( mobile ) != 'undefined' && mobile != null ) {
                mobile.setAttribute( 'id', 'mainnav' );
				mobile.classList.remove( 'toggled' );
                const submenuToggles = mobile.querySelectorAll( '.btn-submenu' );

				submenuToggles.forEach(
					function(currentValue, currentIndex, listObj) {
						currentValue.remove(); 
					},
					'myThisArg'
				  );				

            }
        }
    },
    
    toggle: function( menuToggle, mobileMenu ) {

		if ( typeof( menuToggle ) == 'undefined' && menuToggle == null ) {
			return;
        }

        menuToggle.addEventListener( 'click', function(e) {
            e.preventDefault();
            if ( mobileMenu.classList.contains( 'toggled' ) ) {
                mobileMenu.classList.remove( 'toggled' );
            } else {
                mobileMenu.classList.add( 'toggled' ); 
            }
            e.stopImmediatePropagation()
        } );
    },

    submenuToggle: function( submenuToggle ) {
        submenuToggle.addEventListener( 'click', function(e) {
            e.preventDefault();
            var parent = submenuToggle.parentNode.parentNode;
            parent.getElementsByClassName( 'sub-menu' )[0].classList.toggle( 'toggled' );
        } );
    },    
};

/**
 * DOM ready
 */
function sydneyDomReady( fn ) {
	if ( typeof fn !== 'function' ) {
		return;
	}

	if ( document.readyState === 'interactive' || document.readyState === 'complete' ) {
		return fn();
	}

	document.addEventListener( 'DOMContentLoaded', fn, false );
}

sydneyDomReady( function() {
    sydney.backToTop.init();
    sydney.removePreloader.init();
    sydney.stickyMenu.init();
	sydney.mobileMenu.init();
	sydney.navigation.init();
	sydney.stickyHeader.init();
	sydney.headerSearch.init();	
} );

// Vanilla version of FitVids
// Still licencened under WTFPL
window.addEventListener("load", function() {
(function(window, document, undefined) {
	"use strict";
	
	// List of Video Vendors embeds you want to support
	var players = ['iframe[src*="youtube.com"]', 'iframe[src*="vimeo.com"]'];
	
	// Select videos
	var fitVids = document.querySelectorAll(players.join(","));
	
	// If there are videos on the page...
	if (fitVids.length) {
		// Loop through videos
		for (var i = 0; i < fitVids.length; i++) {
		// Get Video Information
		var fitVid = fitVids[i];
		var width = fitVid.getAttribute("width");
		var height = fitVid.getAttribute("height");
		var aspectRatio = height / width;
		var parentDiv = fitVid.parentNode;
	
		// Wrap it in a DIV
		var div = document.createElement("div");
		div.className = "fitVids-wrapper";
		div.style.paddingBottom = aspectRatio * 100 + "%";
		parentDiv.insertBefore(div, fitVid);
		fitVid.remove();
		div.appendChild(fitVid);
	
		// Clear height/width from fitVid
		fitVid.removeAttribute("height");
		fitVid.removeAttribute("width");
		}
	}
	})(window, document);
});

/**
 * Support for isotope + lazyload from third party plugins
 */
 window.addEventListener("load", function() {
	if( 
		typeof Isotope !== 'undefined' && 
		( 
			typeof lazySizes !== 'undefined' || // Autoptimize and others
			typeof lazyLoadOptions !== 'undefined' || // Lazy Load (by WP Rocket)
			typeof a3_lazyload_extend_params !== 'undefined' // a3 Lazy Load
		) 
	) {
		const isotopeContainer = document.querySelectorAll( '.isotope-container' );
		if( isotopeContainer.length ) {
			isotopeContainer.forEach(
				function(container) {
					
					const images = container.querySelectorAll( '.isotope-item img[data-lazy-src], .isotope-item img[data-src]' );
					if( images.length ) {
						images.forEach(function(image){
							if( image !== null ) {
								image.addEventListener( 'load', function(){
									// Currently the isotope container always is a jQuery object
									jQuery( container ).isotope('layout');
								} );
							}
						}, 'myThisArg');
					}
	
				},
				'myThisArg'
			);
		}
	}
});