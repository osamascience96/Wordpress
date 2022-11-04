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
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'zsm' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', 'root' );

/** Database hostname */
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
define( 'AUTH_KEY',         'gkU9PV G33tj,bp8hLV*9itqQ)(Fx];cky/R,e:i/C?`x W18}d=J`oRCw*]a+C<' );
define( 'SECURE_AUTH_KEY',  'sZ{ (~zl=@|p=.Lc`slF?ZkT&__3)$*zTtAj# w5g1;Ej8nn!G:m-@qp4UVHX!R#' );
define( 'LOGGED_IN_KEY',    '$D8Zu!Sc(`sEg=E^x//ooJ=DP^(8H;.tI.I&s{ Xm4#I~bXnpd1XZz/6A@z`Un(m' );
define( 'NONCE_KEY',        't~+>z4%m}Co@m4s?C)RSGBS3#&~.*6RCsOWY:Gw+F&kA4.7~;c%%YTHrwLPK//5:' );
define( 'AUTH_SALT',        '*!i)HrwuG$C$).:@YNeJcQ>%N$M>tU@RHM=W) U~~t;7D<(/9V*0 K!blY~CPk[T' );
define( 'SECURE_AUTH_SALT', 'Sx0X]7GDI{eY7Ets!H3]4.nMSs0tn1]]#c8z^LzfB{*v7=e7tT$*PMnQA{v(=RSb' );
define( 'LOGGED_IN_SALT',   'BiW,`Wa=*_}vz]/vha5c4FlkP!K-XjS$8>i1[Qd&NOtPaehEoaWXAw_1q*we5%wp' );
define( 'NONCE_SALT',       '~&_`0`|ZoomJ3xILUexr4@0FRN15xm?)iLs+n/#<u}2b|OJTyOUpYf[?2xLlk[C,' );

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
