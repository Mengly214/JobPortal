<?php
// Copy this file to config.php and fill in your own values
define('DB_HOST',    'localhost');
define('DB_USER',    'root');
define('DB_PASS',    '');             // your DB password
define('DB_NAME',    'job_portal_testing2');  // your DB name
define('DB_CHARSET', 'utf8mb4');

define('SITE_NAME',  'Jobs Agency');
define('SITE_EMAIL', 'contact@company.com');

$protocol  = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
$host      = $_SERVER['HTTP_HOST'];

$scriptName = $_SERVER['SCRIPT_NAME'];          // assign to variable first
$parentDir  = dirname($scriptName);             // /mvc/JobPortal/public
$base       = dirname($parentDir);              // /mvc/JobPortal
$base       = rtrim($base, '/');

define('SITE_URL', $protocol . '://' . $host . $base . '/public');

define('JSEARCH_API_KEY',  'c3750ffd41msh456db7fb5e4641cp193aebjsn28311744d84f');        // your API key

define('ROOT_PATH',  dirname(__DIR__));
define('APP_PATH',   ROOT_PATH . '/app');
define('VIEW_PATH',  APP_PATH  . '/Views');
define('CORE_PATH',  ROOT_PATH . '/core');

$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if ($conn->connect_error) {
    die('Database connection failed: ' . $conn->connect_error);
}
$conn->set_charset(DB_CHARSET);