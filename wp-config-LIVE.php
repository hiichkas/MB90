<?php
/**
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, and ABSPATH. You can find more information by visiting
 * {@link http://codex.wordpress.org/Editing_wp-config.php Editing wp-config.php}
 * Codex page. You can get the MySQL settings from your web host.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
//define('WP_CACHE', true); //Added by WP-Cache Manager
define( 'WPCACHEHOME', '/home/paulcotter/public_html/wp-content/plugins/wp-super-cache/' ); //Added by WP-Cache Manager
define('DB_NAME', 'mybody');


/** MySQL database username */
define('DB_USER', 'paul');


/** MySQL database password */
define('DB_PASSWORD', 'Fuckoff747ok!');


/** MySQL hostname */
define('DB_HOST', 'localhost');


/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'M*B:Q&f$jNr,a+ec[P3VvQ+Hw!bn?CgVGPBgf7]r{_aP56NRWYnG<|GM~g)-Y7*[');

define('SECURE_AUTH_KEY',  '5[Z~_IQfWnI3x(SMT}rtTzeiZBa2Q[ss[ni8~WCK:cRU=t[*#V~m;9bF*}i876rr');

define('LOGGED_IN_KEY',    '|Bd}N.V.{PKA%=RA$[c96d/3hL-yam[_+(gAb~*~<dkm:L@j<ah|-4`T@+ps}iku');

define('NONCE_KEY',        '`780;Ed/XR_i#D0(nb?!bw`NNI-E32R6dH0+GGbOb8btn_+T/Q5w.1`~D #,lb6/');

define('AUTH_SALT',        '9bW 0Z!30JSwB|Az$19Fp.?L-]H$Ws+&Y*lR#i;(0Q7Cok$jKdy5 ^VN/KL|N)g]');

define('SECURE_AUTH_SALT', '.<4I`|TSz35Y:A4z~+UCJpwmN]+@O%!XT%)E-w*o6`IZfj+)<X}O;mUT|?,f-QY/');

define('LOGGED_IN_SALT',   'o76Br+7;ICI8Plc^[TdEQ![zK8}HhEj^J? = JU]Ex&f=JelZf}u*i Q8BQ{Ri7.');

define('NONCE_SALT',       '|z4}1(OlRS/z{ZW-}kyn_OA:NypSOY3DDOZ8RKI_,hA<1fidT>=kRr~VE=(Wp9o+');


/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';


/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');

ini_set('log_errors','On');
ini_set('display_errors','Off');
ini_set('error_reporting', E_ALL );
/*define('WP_DEBUG', false);
define('WP_DEBUG_LOG', true);
define('WP_DEBUG_DISPLAY', false);
*/