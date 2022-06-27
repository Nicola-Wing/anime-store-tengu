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
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'wp_anime_store_tengu' );

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
define( 'AUTH_KEY',         '!PN&yvplHpiqV}bZ<P-2O^n6h4,i6?02$;%nO.x/_pP[pf?n3!F>p&x(;qEcU{%C' );
define( 'SECURE_AUTH_KEY',  '*KEE7$tJ_L}8DuyIx/s-euLYJMB !2;&QrO_P0Wpq]ilpAsqN}(pjMw)fO<W5fec' );
define( 'LOGGED_IN_KEY',    'Ea0+,z^)0Y|FtF$t0n`]q>(g}d6*x?EZXp;N}U4Hl4l]s}a)xZvAbvBT;*J;=)7I' );
define( 'NONCE_KEY',        'ij0ccRQr17t]<RX$Bsw)TU[S-B30&-a#+V8lM@bh)z{r{F4mSnG|>o`OJ<BJGO|[' );
define( 'AUTH_SALT',        'y ~6800MwFyWz#(:!HFeXnncgQ!W6)&cL_ 5`HrI_.X6:86enF0T_{KVoGp/lt^S' );
define( 'SECURE_AUTH_SALT', '&hre]>UXW1J)=3j/e$_;l=:&Y>=MTCTt:U)T?KGaVz+)9Eu;c!m@3L#JzC.]a%nB' );
define( 'LOGGED_IN_SALT',   'Is=$%{U=H`eY{sIc<jS;(oMt]ln~3$*T>T84FV|1^|]7qNV$=/iU4e5$FfPLz$}P' );
define( 'NONCE_SALT',       '%P-w?8ZKV>9Ym9geUOcW&wmNhM+f&fIy]@_?2Wp+*2M_J<flHeE{t}vymwN/j:Y>' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'ast_';

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
define( 'WP_DEBUG', true );

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
