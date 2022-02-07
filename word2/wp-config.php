<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the web site, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'word2' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', 'root' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The database collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication unique keys and salts.
 *
 * Change these to different unique phrases! You can generate these using
 * the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}.
 *
 * You can change these at any point in time to invalidate all existing cookies.
 * This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'dYDi*kQ}FI*(9tE|Z/w!FLA?7/)HM~hn[prfJyRJcc|Mf-9XmzA1 /H:qb8Ez4KE' );
define( 'SECURE_AUTH_KEY',  '>Pk#_SWb%WZK3NT=w`waLrz%qS;0ms#sQs4ARk,$,>x{s_zo*q#~.p1:wetl+vUj' );
define( 'LOGGED_IN_KEY',    'hWQ.A|SLK3( 9#`JCzwz)N5Lf*]}}DVN1Qtd(EY5$)xrzQ:Cax@TeiJye{gq|OUx' );
define( 'NONCE_KEY',        '=+Jfcy{|lHkDq^Gtd:;sDC.dIWmj=3v|2~OdE~NF6v$,K.&.rW.gAPjB&.#nPD<7' );
define( 'AUTH_SALT',        'nvN,2n@m5_ue JK)!FT`NyaqH$jq9ro^3c-so$[2-`~>T*.OM[>.9%z*i7%oC|He' );
define( 'SECURE_AUTH_SALT', 'o]8rRD>vpn_t<Lak@;2q;BEdMIX%<Y|kYeGCIQY+[-N 9Je-%=3L% nhrq9j{HoX' );
define( 'LOGGED_IN_SALT',   '%,-(z1NwE d4~QM1<mK={&z-yt^{8}n~jEq&ueR J|WSO*Bo|>! X1+2G&#vOTNf' );
define( 'NONCE_SALT',       'm`W%S){)G!^p)yAR5o:).iyfP5b#r$l9@;?acb@H -{(9i?0gV$$OO:Wd:;]+cZ?' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the documentation.
 *
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', false );

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
