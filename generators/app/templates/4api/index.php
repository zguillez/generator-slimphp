<?php
ini_set('display_startup_errors', 1);
ini_set('display_errors', 1);
error_reporting(-1);
date_default_timezone_set('Europe/Madrid');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('Access-Control-Allow-Headers: token, Content-Type');
require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/inc/app.php';
require __DIR__ . '/inc/routes.php';
//require __DIR__ . '/inc/config.php';
$api->run();




