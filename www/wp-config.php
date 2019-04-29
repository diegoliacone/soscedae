<?php

/**
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, WordPress Language, and ABSPATH. You can find more information
 * by visiting {@link http://codex.wordpress.org/Editing_wp-config.php Editing
 * wp-config.php} Codex page. You can get the MySQL settings from your web host.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */

require_once dirname(__FILE__) . '/../etc/php/lib/CloudezSettings.php';

define('FS_METHOD', 'direct');

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', CEZ_DBNAME);

/** MySQL database username */
define('DB_USER', CEZ_DBUSER);

/** MySQL database password */
define('DB_PASSWORD', CEZ_DBPASS);

/** MySQL hostname */
define('DB_HOST', CEZ_DBHOST);

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', CEZ_DBCHARSET);

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

define('WP_MEMORY_LIMIT', ini_get('memory_limit'));


/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         '30WJ>$Dr9`s<T%|4P17qs[ca1w*cRZKGUM8TTx>7)c0.^enkVYaDqa2Eny5x');
define('SECURE_AUTH_KEY',  '5K*rz2UT0KXVDC*,YJBKvs+>p(h+g[y+J+}ML9#fw>PNgT,XHNcUc`a*[:.{');
define('LOGGED_IN_KEY',    'DSS!ZMV_Sn|k]WBFq1Lsq5)N`VXV1n2;.00Bn5NH!+*]9EGrKC7J{M][^(Rs');
define('NONCE_KEY',        'aLv7*K]xg+hN,S0j90F{ub:SU+eJKV<yJH1ArTU;.#`*t{BD#S9m@F C CN|');
define('AUTH_SALT',        ' E,ZbZmv+6GS,my2r,%4gYyMtMd:/132:aPgPSq2eAd[dF|T|Q[k_[brFt.S');
define('SECURE_AUTH_SALT', '648fN]nBTC{`wm3,v06+;.pk{AU}5+5;8YdNW<,eu+**s%7X_yC2/+@LQqrw');
define('LOGGED_IN_SALT',   'T.S,p8ns[d^%B201S;U`[aRy!$NJJMz h0.(:tD6,x5FNX#4%jg,wMmKJ@Xq');
define('NONCE_SALT',       'F@#0{_Ug[BnhM9d3DV (/D0$ hjPjX.HR+BWkXnA#vSG2k_at!6>v85Tw{A8');

define('WP_SITEURL', isset($_SERVER['HTTP_HOST']) ? (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == "on") ? 'https://'.$_SERVER['HTTP_HOST'] : 'http://'.$_SERVER['HTTP_HOST'] : 'http://soscedae.com.br');
define('WP_HOME', isset($_SERVER['HTTP_HOST']) ? (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == "on") ? 'https://'.$_SERVER['HTTP_HOST'] : 'http://'.$_SERVER['HTTP_HOST'] : 'http://soscedae.com.br');

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

/**
 * security
 */
define('DISALLOW_FILE_EDIT', true);
define('CONCATENATE_SCRIPTS', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
