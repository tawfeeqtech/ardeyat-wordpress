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
define( 'DB_NAME', 'ardeyat-wordpress' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', '' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

/** The database collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

if ( !defined('WP_CLI') ) {
    define( 'WP_SITEURL', $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] );
    define( 'WP_HOME',    $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] );
}



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
define( 'AUTH_KEY',         'F49KrbXACvAmaQXwvR0pi5l3iP3V4YrlVCEUEd3quKMvxYxbXIXD6Q2RwuRKYomS' );
define( 'SECURE_AUTH_KEY',  'AmfQNDmqLD2tqDSWIP0PjQA59BQcwrIj2CUbg7tavT1nKJg0rkE2dmOwdDArYyxP' );
define( 'LOGGED_IN_KEY',    'lz9EUIAYnAgb0KUG0UvKAPGuL2ZW2wbNkWr8qJ570g7yEkMHuVWRJDPrSTGQKLhY' );
define( 'NONCE_KEY',        'sP8uJL39Vit1g30GzCrVNYbNoaoz7ZDpPAupeMCEERjrq7nGudTa1tbeldZ5N3BB' );
define( 'AUTH_SALT',        'YTyfKdr30xMAnaqORCzUVukdb6XI76LsGycpa4GLa7iLDPmdHxhE81uCY0kzKIWo' );
define( 'SECURE_AUTH_SALT', 'TKABRnPA1FNLhXQbuCg0CdoEmdJw53pD15Ybq1ingFcUa483akHfq8jCx9TyI2ts' );
define( 'LOGGED_IN_SALT',   'zoNs7mtONcvfBbOsCEs0M9DXErd3OFw6IVbfHU9eJg8O88rk4JzUVS2qypvJ9boh' );
define( 'NONCE_SALT',       'dLBuIpgxf5ncNc25HhNCu99N7UTvCzk3eOHjdWYOgWbpYUVl1ryiGR6eb6koQKhA' );

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
