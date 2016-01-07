<?php

require 'vendor/autoload.php';
require 'inc/app.php';
require 'inc/config.php';
$api->route('/', 'GET', require 'inc/routes/index.php');
$api->route('/user/{token}', 'GET', require 'inc/routes/user.php');
$api->route('/user/add/', 'POST', require 'inc/routes/user-add.php');
$api->run();