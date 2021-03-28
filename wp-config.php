<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the
 * installation. You don't have to use the web site, you can
 * copy this file to "wp-config.php" and fill in the values.
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
define( 'DB_NAME', 'youngbutterfly_db' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', '' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'N4vr}r5NAbfQYjF8J-8.FKUJ+aE)J.mcGnAax>RI>saWOcB%>:LQEun%njt_8`t[' );
define( 'SECURE_AUTH_KEY',  'WY|&qc4=1JCLH^ht{=06:*o^Z!!RLeH)NA$VdcY(3P_s&VbPMxpLxIg*9F@`}t<-' );
define( 'LOGGED_IN_KEY',    '@# q?>4EsO%|,5Dj#|gYFQdP-wl5b(@~$}cv=wK8j{Y[6aHR6?.9UlwcC`g5Xc-f' );
define( 'NONCE_KEY',        'N!ckB-x=V[-*&8s0mF%qXJp:Je(Cn|Tiz!!I2fOpe3Cm4Y3:.8uTVtJ&R=|F6U(H' );
define( 'AUTH_SALT',        'mGKF|$iD30$v$yMV|>N3W/[lrQikX0lA(Yv=C=ThCr=?1tsyKOvf=FL4 ;592b26' );
define( 'SECURE_AUTH_SALT', 'ffc@P4:-<W|~:scZ>qCp!t2lOjpaX-Q>iQ0%!V*^e^p9f,ocW~h-j^9N0cE%{l5P' );
define( 'LOGGED_IN_SALT',   '.14WAIuIz5ajBZ1p3T.|CH./_wllsDHW8iNhyM%ycA,j`/8_q~>scG!9G1lSm})6' );
define( 'NONCE_SALT',       'f?]rb9m?(Sf4FWofvbh=E5q5griEe?s^Y&5O 5W?Fhy`~i+jloxKJJ$:UD*~B@AA' );

/**#@-*/

/**
 * WordPress Database Table prefix.
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

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
