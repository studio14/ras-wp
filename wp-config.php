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
// $DSN = parse_url(fromenv('DATABASE_URL', 'mysql://root:root@localhost:8889/ras_wp'));
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

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'jc9bO@j;NlIwblNA3ubl-<][gBPh)Sek5D]mP;hoB49o4&2~Skm2<aY(2mARlJ$@' );
define( 'SECURE_AUTH_KEY',  'GF/]S9MSi-IeT*U)x(ji,Y_kXtagQi;lL7v|L@/rD:3.g(kC=~UV|6%4=@Fs*kF%' );
define( 'LOGGED_IN_KEY',    'z|pMYC,Ib&_d9TQj*#lfZU^Z`vv:lI C<FJaDf,8b0?(X0qZb<3g)cJRQ~RK A%x' );
define( 'NONCE_KEY',        '4CE)u/860{37Wyvb`X/}4&Z.8RH z@eY<j]SXFAxT!8BJ2?o^g#R(.iE;9wsy<-&' );
define( 'AUTH_SALT',        'c,QQfqL=QnqyDoifYZ9YG~[A+fK}/{VN7r.V59h*B }e!kj2nNwr]kst!Kj3wyDi' );
define( 'SECURE_AUTH_SALT', 'ix*1%u~_,8z]|ZIHcPv5qTIFJ(yq```?91WVFL!5fhwL^,SqdAduBoDjds(X#2HS' );
define( 'LOGGED_IN_SALT',   '.DbzL?^ZQy[dQf0ZnvjAu!BJC}FB9>7MOl0qUb[og)zF}q&}k,!QvM;/<vK0504g' );
define( 'NONCE_SALT',       '`qe7Ky[]S/44mtJ}VXa@bLcoAbrWJOR,H-RAH_*G#O;hzVN6iX)mT44NM6iUqbv/' );

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
define('WP_DEBUG', (bool)fromenv('WP_DEBUG', false));
// define('WP_DEBUG', true);

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
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
