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
define( 'DB_NAME', 'adlabfac_woo' );

/** MySQL database username */
define( 'DB_USER', 'adlabfac_woo' );

/** MySQL database password */
define( 'DB_PASSWORD', 'D[EDg3{Ge5bS' );

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
define( 'AUTH_KEY',         'caF`1T8&R[bnc9bkwx{z{/?8No=:vv::260V|,W!)7@)8=JlFdvxGB>lZpwdF<!2' );
define( 'SECURE_AUTH_KEY',  'a&.J<7U>p#uN*CI4A@[l}h8V9wu)YCl@_5{_!P$F:nEoY{t=/1j]l1)]Bw mfG-&' );
define( 'LOGGED_IN_KEY',    '[uAs6O0Qn>k1pgMlVu6G~c,%~Ix0UdXT:k0Vx!,<yGLL)kepCCT|i#KmGy}YKU)y' );
define( 'NONCE_KEY',        '.IT[.B96mm%G?#ImvX!&cB&w{hq9x8aJ4JrOgd!`uoi1bA@+rG%WL9e>Jj;M5dKF' );
define( 'AUTH_SALT',        '[>r]I!}o)#J`a<:Iv%}0KvD5O{z?;ELcjs2-Q9:RU+_[~x7B1=21K)vY+a=H=vHh' );
define( 'SECURE_AUTH_SALT', '!S]<_,Jq*-flH`NB=H;+:-n.em_9+&]bm{YN*-E&CHWR7cmb3sj%W%1]qB<bm^%Z' );
define( 'LOGGED_IN_SALT',   '35}0GFIYS33m3;?H#XLfRh%5zS^RO[/!c2=<9 e;@283{@SE90=W/tQGaO!~,XsQ' );
define( 'NONCE_SALT',       '6if)G)0||d8S7R@9wQH@a/S9@q0$jYZA(ACQVopuR_AfS8Cu#KUqB(tR^yIfh]Z5' );

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
 * visit the Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define( 'WP_DEBUG', true );
define('SCRIPT_DEBUG', false);

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', dirname( __FILE__ ) . '/' );
}

/** Sets up WordPress vars and included files. */
require_once( ABSPATH . 'wp-settings.php' );
