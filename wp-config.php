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

@ini_set( 'upload_max_size' , '512M' );
@ini_set( 'post_max_size', '512M');
@ini_set( 'memory_limit', '512M' );


function fromenv($key, $default = null) {
  $value = getenv($key);
  if ($value === false) {
    $value = $default;
  }
  return $value;
}
$DSN = parse_url(fromenv('DATABASE_URL', 'mysql://mysql:b99da7357695c645@dokku-mysql-ras-wordpress:3306/ras_wordpress'));
// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', substr($DSN['path'], 1));
/** MySQL database username */
define('DB_USER', $DSN['user']);
/** MySQL database password */
define('DB_PASSWORD', $DSN['pass']);
/** MySQL hostname */
define('DB_HOST', $DSN['host']);
/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');
/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');


// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         fromenv('AUTH_KEY', 'd`(/_geDo~im/C(RWg`)UDly#}FVu`d*furKmB|G2h*lYt/`9GVLsSA~E~u8QBM4'));
define('SECURE_AUTH_KEY',  fromenv('SECURE_AUTH_KEY', '}Z=Pas>qMg:b5;_tj$zwb}Ze{~AVC$aR;AP}]Sfd1NQa!uk(P]YfA2d1Tiv5.5SU'));
define('LOGGED_IN_KEY',    fromenv('LOGGED_IN_KEY', 'P{E0`]p71N}G]QIMUF|2rr{w<KgG3G+qfQzTE*nn>:s(*Dnf ]%p?eSVd?o8x*l,'));
define('NONCE_KEY',        fromenv('NONCE_KEY', 'r`L/D3&y/zcnX.MUPvA2~6{+Mf|Wd~!/^ou2-WUzkm zutzZsI}3%(b6`Px[rtO$'));
define('AUTH_SALT',        fromenv('AUTH_SALT', '6&Obsn`jL:7..21PZ*o7^WpxuidO7&98A>>29-w?8C~Rgo?t@B6vDMs<ZlzMDp,4'));
define('SECURE_AUTH_SALT', fromenv('SECURE_AUTH_SALT', 'OxK2)PT#ZY#XATu/1]bDMeNpSO-cyJG-7#E2U9ozztCGrPJ9yCd}_-AskxU^L.=}'));
define('LOGGED_IN_SALT',   fromenv('LOGGED_IN_SALT', 'S=Cf1:[3bb>_W$M.e0S0#&A1R*r-#&7mp)(PK:~![C/9bCtXz,9$V72`x=&(rMte'));
define('NONCE_SALT',       fromenv('NONCE_SALT', 'd)9U&hgt[+{t(2_}Ynz%F*6#6VfzlW&c=&Y2#[vxDytA?}4]9!lANGJ>X&G|]38Q'));

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = fromenv('TABLE_PREFIX', 'wp_');

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
define('WP_DEBUG', (bool)fromenv('WP_DEBUG', false));
// If we're behind a proxy server and using HTTPS, we need to alert Wordpress of that fact
// see also http://codex.wordpress.org/Administration_Over_SSL#Using_a_Reverse_Proxy
if ( isset($_SERVER['HTTP_X_FORWARDED_PROTO'] )
    && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https' )
{
    $_SERVER['HTTPS'] = 'on';
}
/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', dirname( __FILE__ ) . '/' );
}

/** Sets up WordPress vars and included files. */
require_once( ABSPATH . 'wp-settings.php' );
