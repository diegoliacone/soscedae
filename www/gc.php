<?php
$new_api_key = 'c1120f10b87496d2770aa53198e246b9';
$gocache_domain = 'app905.2d4f1609.configr.cloud';
include_once 'wp-config.php';
include_once 'wp-load.php';
@include_once 'wp-includes/functions.php';
@include_once 'wp-admin/includes/plugin.php';
if (!defined('DB_NAME'))
	die('ERROR: DB_NAME not defined. Are you in the wordpress directory?
');
$installed_plugins = get_plugins();
foreach ($installed_plugins as $pkey => $pval) {
	if (!is_plugin_active($pkey) && strstr($pkey, 'gocache-cdn') != FALSE) {
		if(activate_plugin('gocache-cdn/gocache-manager.php', '', /* network wide? */ false, /* silent? */ false) != null) {
			print('Error activating plugin!
');
		} else {
			print('Plugin activated successfully!
');
		}
		break;
	}
}
$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
if (!$conn) {
    die('Error connecting to the database!
');
}
echo 'connected!
';
function set_gocache_wp_option($conn, $name, $value) {
    global $wpdb;
	$sql_update_key = 'INSERT INTO '.$wpdb->prefix.'options (option_name, option_value, autoload) VALUES(\'' . $name . '\', \'' . $value . '\', \'yes\') ON DUPLICATE KEY UPDATE option_name = \''.$name.'\',option_value = \'' . $value . '\'';
	$result = mysqli_query($conn, $sql_update_key);
	return $result;
}
set_gocache_wp_option($conn, 'gocache_option-api_key', $new_api_key);
if( $gocache_domain != 'MYDOMAIN' && strlen($gocache_domain) > 0 ) {
	set_gocache_wp_option($conn, 'gocache_option-domain', $gocache_domain);
}
set_gocache_wp_option($conn, 'gocache_option-status', 1);
mysqli_close($conn);
echo 'updated!
';
exit(0);
?>
