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
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'j0w0_wp');

/** MySQL database username */
define('DB_USER', 'j0w0_wp');

/** MySQL database password */
define('DB_PASSWORD', 'hailmary420*');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8mb4');

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
define('AUTH_KEY',         '~i!X;R5(N<=X#=.?DZ:p0zf|h^uD#S4JECfHoZ}D>z[e9A+[j-~|/y27?Rp6vZ`!');
define('SECURE_AUTH_KEY',  '2/FCNUea-L6:#s*uZS *3@!X[C7<F |9z1`8C(bGX)L!:aUm>/~:`Yp5n$enP!Xz');
define('LOGGED_IN_KEY',    '8`L&4Nt*~:<I.-r*pZ9J=I$@4C|vZZpQh9XJzG&b}EY]Fr[/BO1ZZ|Ldnacd)0]6');
define('NONCE_KEY',        'RX`|NHVp=-_(=(~Otw:oGNM?pR&&%lX~~,fi|>0+VE6&2o!yYVV&g]$UC<(J`:6(');
define('AUTH_SALT',        '616LM{7w* 7cZM2FlBTAN;0NTMME7_OoZLhe=I,;?lJu%+zD88Jg2#_+lgs(F/z-');
define('SECURE_AUTH_SALT', '?2@F4#Z@&x2).-QDb3pl@j^ecTx|vy,iC/SN63Aj5r]7]DlL`_Md>{]0U%:@E%R5');
define('LOGGED_IN_SALT',   'mfO??+~[PxAj+zhCv_fc[ NHMW)MUTPGM:4G}<I2  %uU:JA_r,1|/z*m gZVe6F');
define('NONCE_SALT',       '/1Z66{5^aKz(dt{Go9Ekfi8|g/F~z^H!6Rai oPj~Goxw8GR,S ;^;Dsit3wgjY<');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'j0w0_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
