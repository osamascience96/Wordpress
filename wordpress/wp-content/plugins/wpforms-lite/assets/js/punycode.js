//Javascript Punycode converter derived from example in RFC3492.
//This implementation is created by some@domain.name and released into public domain

'use strict';

var punycode = new function Punycode() { // eslint-disable-line

	// This object converts to and from puny-code used in IDN
	//
	// punycode.ToASCII ( domain )
	//
	// Returns a puny coded representation of "domain".
	// It only converts the part of the domain name that
	// has non ASCII characters. I.e. it dosent matter if
	// you call it with a domain that already is in ASCII.
	//
	// punycode.ToUnicode (domain)
	//
	// Converts a puny-coded domain name to unicode.
	// It only converts the puny-coded parts of the domain name.
	// I.e. it dosent matter if you call it on a string
	// that already has been converted to unicode.
	//
	//
	this.utf16 = {

		// The utf16-class is necessary to convert from javascripts internal character representation to unicode and back.
		decode:function( input ) {
			var output = [],
				i = 0,
				len = input.length,
				value, extra;
			while ( i < len ) {
				value = input.charCodeAt( i++ );
				if ( ( value & 0xF800 ) === 0xD800 ) {
					extra = input.charCodeAt( i++ );
					if ( ( ( value & 0xFC00 ) !== 0xD800 ) || ( ( extra & 0xFC00 ) !== 0xDC00 ) ) {
						throw new RangeError( 'UTF-16(decode): Illegal UTF-16 sequence' );
					}
					value = ( ( value & 0x3FF ) << 10 ) + ( extra & 0x3FF ) + 0x10000;
				}
				output.push( value );
			}
			return output;
		},
		encode:function( input ) {
			var output = [],
				i = 0,
				len = input.length,
				value;
			while ( i < len ) {
				value = input[i++];
				if ( ( value & 0xF800 ) === 0xD800 ) {
					throw new RangeError( 'UTF-16(encode): Illegal UTF-16 value' );
				}
				if ( value > 0xFFFF ) {
					value -= 0x10000;
					output.push( String.fromCharCode( ( ( value >>> 10 ) & 0x3FF ) | 0xD800 ) );
					value = 0xDC00 | ( value & 0x3FF );
				}
				output.push( String.fromCharCode( value ) );
			}
			return output.join( '' );
		},
	};

	//Default parameters
	var initialN = 0x80;
	var initialBias = 72;
	var delimiter = '\x2D';
	var base = 36;
	var damp = 700;
	var tmin = 1;
	var tmax = 26;
	var skew = 38;
	var maxint = 0x7FFFFFFF;

	/**
	 * Dode_digit(cp) returns the numeric value of a basic code
	 * point (for use in representing integers) in the range 0 to
	 * base-1, or base if cp is does not represent a value.
	 *
	 * @param {string} cp String to decode.
	 *
	 * @returns {numeric} Decoded digit.
	 */
	function decodeDigit( cp ) {
		return cp - 48 < 10 ? cp - 22 : cp - 65 < 26 ? cp - 65 : cp - 97 < 26 ? cp - 97 : base;
	}

	/**
	 * Bias adaptation function.
	 *
	 * @param {string} delta Delta.
	 * @param {string} numpoints Numpoints.
	 * @param {string} firsttime Firsttime.
	 *
	 * @returns {string} Adapted string.
	 */
	function adapt( delta, numpoints, firsttime ) {
		var k;
		delta = firsttime ? Math.floor( delta / damp ) : ( delta >> 1 );
		delta += Math.floor( delta / numpoints );

		for ( k = 0; delta > ( ( ( base - tmin ) * tmax ) >> 1 ); k += base ) {
			delta = Math.floor( delta / ( base - tmin ) );
		}
		return Math.floor( k + ( base - tmin + 1 ) * delta / ( delta + skew ) );
	}

	// Main decode
	this.decode = function( input, preserveCase ) { // eslint-disable-line

		// Dont use utf16
		var output = [];
		var caseFlags = [];
		var inputLength = input.length;

		var n, out, i, bias, basic, j, ic, oldi, w, k, digit, t, len;

		// Initialize the state:

		n = initialN;
		i = 0;
		bias = initialBias;

		// Handle the basic code points: Let basic be the number of input code
		// points before the last delimiter, or 0 if there is none, then
		// copy the first basic code points to the output.

		basic = input.lastIndexOf( delimiter );
		if ( basic < 0 ) {
			basic = 0;
		}

		for ( j = 0; j < basic; ++j ) {
			if ( preserveCase ) {
				caseFlags[output.length] = ( input.charCodeAt( j ) - 65 < 26 );
			}
			if ( input.charCodeAt( j ) >= 0x80 ) {
				throw new RangeError( 'Illegal input >= 0x80' );
			}
			output.push( input.charCodeAt( j ) );
		}

		// Main decoding loop: Start just after the last delimiter if any
		// basic code points were copied; start at the beginning otherwise.

		for ( ic = basic > 0 ? basic + 1 : 0; ic < inputLength; ) {

			// ic is the index of the next character to be consumed,

			// Decode a generalized variable-length integer into delta,
			// which gets added to i. The overflow checking is easier
			// if we increase i as we go, then subtract off its starting
			// value at the end to obtain delta.
			for ( oldi = i, w = 1, k = base; ; k += base ) {
				if ( ic >= inputLength ) {
					return;
				}
				digit = decodeDigit( input.charCodeAt( ic++ ) );

				if ( digit >= base ) {
					return;
				}
				if ( digit > Math.floor( ( maxint - i ) / w ) ) {
					return;
				}
				i += digit * w;
				t = k <= bias ? tmin : k >= bias + tmax ? tmax : k - bias;
				if ( digit < t ) {
					break;
				}
				if ( w > Math.floor( maxint / ( base - t ) ) ) {
					return;
				}
				w *= ( base - t );
			}

			out = output.length + 1;
			bias = adapt( i - oldi, out, oldi === 0 );

			// i was supposed to wrap around from out to 0,
			// incrementing n each time, so we'll fix that now:
			if ( Math.floor( i / out ) > maxint - n ) {
				return;
			}
			n += Math.floor( i / out ) ;
			i %= out;

			// Insert n at position i of the output:
			// Case of last character determines uppercase flag:
			if ( preserveCase ) {
				caseFlags.splice( i, 0, input.charCodeAt( ic - 1 ) - 65 < 26 );
			}

			output.splice( i, 0, n );
			i++;
		}
		if ( preserveCase ) {
			for ( i = 0, len = output.length; i < len; i++ ) {
				if ( caseFlags[i] ) {
					output[i] = ( String.fromCharCode( output[i] ).toUpperCase() ).charCodeAt( 0 );
				}
			}
		}
		return this.utf16.encode( output );
	};

	this.toUnicode = function( domain ) {
		var domainArray = domain.split( '.' );
		var out = [];
		for ( var i = 0; i < domainArray.length; ++i ) {
			var s = domainArray[i];
			out.push(
				s.match( /^xn--/ ) ?
					punycode.decode( s.slice( 4 ) ) :
					s
			);
		}
		return out.join( '.' );
	};
}();
