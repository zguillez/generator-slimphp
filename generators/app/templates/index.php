<?php

	date_default_timezone_set('Europe/Madrid');

	header('Access-Control-Allow-Origin: *');
	header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');

	require 'vendor/autoload.php';
	require 'inc/app.php';
	require 'inc/routes.php';
	//require 'inc/config.php';

	$api->run();