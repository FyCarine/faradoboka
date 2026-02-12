<?php

date_default_timezone_set('UTC');
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);


if (function_exists('mb_internal_encoding') === true) {
	mb_internal_encoding('UTF-8');
}

if (function_exists('setlocale') === true) {
	setlocale(LC_ALL, 'en_US.UTF-8');
}


if (empty($app) === true) {
	$app = Flight::app();
}
$ds = DIRECTORY_SEPARATOR;
$app->path(__DIR__ . $ds . '..' . $ds . '..');

$app->set('flight.base_url', '/',);
$app->set('flight.case_sensitive', false);
$app->set('flight.log_errors', true);
$app->set('flight.handle_errors', false);
$app->set('flight.views.path', __DIR__ . $ds . '..' . $ds . 'views');
$app->set('flight.views.extension', '.php');
$app->set('flight.content_length', false);

$nonce = bin2hex(random_bytes(16));
$app->set('csp_nonce', $nonce);

return [

	'database' => [
		'host'     => 'localhost',
		'dbname'   => 'takalo',
		'user'     => 'root',
		'password' => '',

	],

];
