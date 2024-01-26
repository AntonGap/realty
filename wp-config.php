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
 * @link https://wordpress.org/documentation/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'tehplan124_realty' );

/** Database username */
define( 'DB_USER', 'tehplan124_realt' );

/** Database password */
define( 'DB_PASSWORD', 'Realty123' );

/** Database hostname */
define( 'DB_HOST', 'tehplan124.mysql' );

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
define( 'AUTH_KEY',         'yC)V[xF<aL=e(fcsX]S=GX;J/_]1>W6N/. >%^8*|9q;|(_g4YLj!m1+bG7z`+M)' );
define( 'SECURE_AUTH_KEY',  'Ck1TJz;#(L`D`$G@D;,}1Qk*VJjKQ.sxC>azDZ(;/CtasuJfGO_?WJ^sa:T2,LFG' );
define( 'LOGGED_IN_KEY',    'sih40WXzjiyp[4ClP/P6mFrpx*&tyGz=Q)?/LAoY*Vn.$ctYl[L?l32|+z;Bbng ' );
define( 'NONCE_KEY',        'F:jmB~qX<dk$~%=+4Y=G]|=|rb<^9rL*Tsk0#u0I/1s+/~nQ4vodE`dg-7g3`H| ' );
define( 'AUTH_SALT',        'DBVzY>n;<-CT{ketA6qf=XBWfv[pCtXH;JQrzL1m7*%uvCEwuvG9}s:A|=YEEF5O' );
define( 'SECURE_AUTH_SALT', 'Gx8xD9]Z%{TP7-nenSpho-lKG;Ub[IRYP4W7V@#=fP>Z]-DMWQY(ZN,hwIhzP9;D' );
define( 'LOGGED_IN_SALT',   'S~i#u[a6I]N0g@Ep:rn/F(}kW,Ih%q..y$2~YUeeje/49tSg#(/fNikT=R}C^Wsm' );
define( 'NONCE_SALT',       'I[NhEEe8AVjI4;Mn*j0u<UfgVK=-j6p3CqK2wg0jp/0Z>AF|lYlzuf2^hbvQ[+wB' );

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
 * @link https://wordpress.org/documentation/article/debugging-in-wordpress/
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
