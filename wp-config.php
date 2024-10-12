<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the website, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'schooluniversitys' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', '' );

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
define( 'AUTH_KEY',         'sIQ0b5qqczYP1[*Ai8`|K]Vf<mK&6D;,G~j#R2}/6a~Ux| [c?J^t}f?8ob!>*-m' );
define( 'SECURE_AUTH_KEY',  '~O?PeF4,Bis[$Rcq#rKab(.^LH%E>gXw C_V7-Ag+Pmjjmm+2 ,pz4{ R;A_3 wk' );
define( 'LOGGED_IN_KEY',    ';P43)[}-tqj,i n9I{G?6p8PDT*?hR[Ei6f?*Rj X%Xh2)G!Jf$J6t;6;c8{e/~5' );
define( 'NONCE_KEY',        'Puh5<9D:R/s]f5Aa@q38g1@oMKCqe{@0GDI`:kQnX]7_$1BwIM4U`Qx^lC+tpLLy' );
define( 'AUTH_SALT',        'Weun0)0Kx{(&`.T:R7visyOtV{iON#_K_U_/`YH4*4xwCf&b0TzWBdU;B|OPo(O-' );
define( 'SECURE_AUTH_SALT', '0,^8bl+[dc<D`!q>]v#zNDmkWLa5xV@_)(<RU|Ra6hFLa5 U qvM=b uCq7VzBMR' );
define( 'LOGGED_IN_SALT',   'i-zaqOHvu;#ZNx7b*r-iFV56hU>WDOn}#7~b48tiPZr7kCno}4sV.S(>Mc<AL2h{' );
define( 'NONCE_SALT',       '#/7`AT:%<6x4||iS9r:Vma^[Vr,H*b&=Mb]rxGFtI2`7!4FWrE_2M%<w5Fuv:p[7' );

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
 * @link https://developer.wordpress.org/advanced-administration/debug/debug-wordpress/
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
