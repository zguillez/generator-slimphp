<?php

	//$api->folder('api');  // http://domain.com/api/

	$api->route('/', 'GET', require 'inc/routes/index.php');
	$api->route('/user/{token}', 'GET', require 'inc/routes/user.php');
	$api->route('/user/add/', 'POST', require 'inc/routes/user-add.php');