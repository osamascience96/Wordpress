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
define( 'DB_NAME', 'wordpress' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', '' );

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
define( 'AUTH_KEY',         '8idz$B!H6,sx>5:X0gH-YW#?0;Vr_TX+At_0j)BD:%ATZZ9tFf0maFv7vjVocmjV' );
define( 'SECURE_AUTH_KEY',  'ZY}/%q(LBik^=[MIog;YV8*!4+*6J%{=$(xZ10}#&tG#?b])uZvPch2/Nz5$rU?_' );
define( 'LOGGED_IN_KEY',    'LMt5,-! VvsLzl<^UYc7x/$%o=t.a2jeml>Cvbl%m_/nh4doGTXcz<OF]{ZL/(,Y' );
define( 'NONCE_KEY',        'r}tmI+u){{fI)d/oIP/rVI7:%60/c!~#mVZm,Kh(s[/U)Wqt#<^_Tw6xpl C`eK}' );
define( 'AUTH_SALT',        'k-hVO<Hn>got)h1sY@;?N!)&9EO6t rz]Z[W%?MNK6FvPCE6w)#|(EFJV<SePb.l' );
define( 'SECURE_AUTH_SALT', 'J4pRg`)7p!2.!7.UhJv?}B.wmp/`Bf#:y!D2NPQtSfWM|j>e7!T6uv5bbt4X@ED:' );
define( 'LOGGED_IN_SALT',   '?2p,9ue[bDMJHMFrl{w>LbCXE/]x:<cQLu#b4DKgla9T}>^3`47}b)RYULR42$V5' );
define( 'NONCE_SALT',       '; 3@E/9Uc%s-0Tag @b25iBV&n`lFpykHaCbO{p*lBhJ>SnKI4O?g1C9T^:gmN0n' );

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
