const ajaxQueue = ( function () {
	let requests = [];

	return {
		/**
		 * Add AJAX request
		 *
		 * @since x.x.x
		 */
		add( opt ) {
			requests.push( opt );
		},

		/**
		 * Remove AJAX request
		 *
		 * @since x.x.x
		 */
		remove( opt ) {
			if ( requests.includes( opt ) ) {
				requests.splice( requests.indexOf( opt ), 1 );
			}
		},

		/**
		 * Run / Process AJAX request
		 *
		 * @since x.x.x
		 */
		run() {
			const self = this;
			let oriSuc;

			if ( requests.length ) {
				oriSuc = requests[ 0 ].complete;

				requests[ 0 ].complete = function () {
					if ( typeof oriSuc === 'function' ) oriSuc();
					requests.shift();
					self.run( self, [] );
				};
				fetch( ajaxurl, {
					method: 'post',
					body: requests[ 0 ],
				} );
			} else {
				self.tid = setTimeout( function () {
					self.run( self, [] );
				}, 1000 );
			}
		},

		/**
		 * Stop AJAX request
		 *
		 * @since x.x.x
		 */
		stop() {
			requests = [];
			clearTimeout( this.tid );
		},
	};
} )();

export default ajaxQueue;
