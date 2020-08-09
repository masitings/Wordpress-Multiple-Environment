<?php 

$environments = [
	'local'	=> 'wordpress.test',
	'staging'	=> 'staging.masiting.co',
	'production'	=> 'masiting.co' 
];

$http_host = $_SERVER['HTTP_HOST'];

foreach ($environments as $environment => $hostname) {
	if (stripos($http_host, $hostname) !== false) {
		define('ENVIRONMENT', $environment);
		break;
	}
}

// Kalo environment tidak ditemukan.
if (!defined('ENVIRONMENT')) exit('Tidak ada database yang diset pada hostname ini');

$wp_db_config = 'wp-config/wp-db-'. ENVIRONMENT . '.php';
$config = 'wp-config/config.php';

// Error handling kalo db config tidak ditemukan.
if (file_exists(__DIR__ . '/'. $wp_db_config)) {
	require_once($wp_db_config);
} else {
	exit('Tidak ada konfigurasi database ditemukan untuk hostname ini.');
}

require_once($config);

// Absolute path ke wordpress directory.
if(!defined('ABSPATH')) {
	define('ABSPATH', dirname(__FILE__) . '/');
}
// Setup wordpress variable dan file yang dibutuhkan.
require_once(ABSPATH . 'wp-settings.php');