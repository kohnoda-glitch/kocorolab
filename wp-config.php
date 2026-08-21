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
define( 'DB_NAME', 'knoda_wp2' );

/** Database username */
define( 'DB_USER', 'knoda_wp2' );

/** Database password */
define( 'DB_PASSWORD', 'ob8pzypqaw' );

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
define( 'AUTH_KEY',         'Nf.iyM(DCu^2BqIx3|k]>*0p>Gr2{o>%J_U$&<9u^-LN(@f%m3l5kc:Gg>Ql=NOA' );
define( 'SECURE_AUTH_KEY',  '-X+Ry!~;Zp%<:i}ji9ndEe)ed:?ZpV#,w[bD4$-;*$-HJ?.cg,lVC ]3nFY73[}`' );
define( 'LOGGED_IN_KEY',    'ng;5 ayhkLbDX[+Wz!V~].+E[6-^ =~QilP*msL?%gnyfpB?$A4=jH%$tpn2^bq!' );
define( 'NONCE_KEY',        '9]v^,@qRW7T@hyw57y|9oFveU2%_TCw(?S9FBHFN5.X0bV7G}$TY%1(jso^&@P.H' );
define( 'AUTH_SALT',        '>>P~Um0or0]<G^tLLCZ]/6r|*.iPBB{@D^J!sVs8~sGm3B!h`<aQF;:&h(YnX6Gi' );
define( 'SECURE_AUTH_SALT', 'Bx[G&^7 YXZ{vN&~M`<_|S}sOe$+M@=7MUe_|^>,[;jYJviA[i&k1CFoyJ}G`Bb^' );
define( 'LOGGED_IN_SALT',   '$u@<*mz]GPcN}/2Jzoi5/|3e@|J39~usBN3MG^@j JQ}h$or`,yAHisiGl<GviM:' );
define( 'NONCE_SALT',       'k-=?k|Y~Do3%uh@tO-YVYL=,[,nX0|fM(Ijy~X,Z),9afOuZdhp/{M,8ltj[I%z=' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 *
 * At the installation time, database tables are created with the specified prefix.
 * Changing this value after WordPress is installed will make your site think
 * it has not been installed.
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/#table-prefix
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
