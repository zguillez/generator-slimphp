<?php
date_default_timezone_set('Europe/Madrid');
if (extension_loaded('newrelic')) {
  newrelic_set_appname('slimphp');
}
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('Access-Control-Allow-Headers: token, Content-Type');
require 'vendor/autoload.php';
require 'inc/app.php';
require 'inc/routes.php';
require 'inc/config.php';
$api->run();