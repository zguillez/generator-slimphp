<?php
$api->route('/', 'GET', require 'inc/routes/index.php');
$api->route('/api/', 'GET', require 'inc/routes/api.php');
$api->route('/users/', 'GET', require 'inc/routes/users.php');
$api->route('/users/', 'POST', require 'inc/routes/users-post.php');
$api->route('/users/{token}/', 'GET', require 'inc/routes/users-get.php');
$api->route('/signup/', 'GET', require 'inc/routes/signup.php');
$api->route('/signup/', 'POST', require 'inc/routes/signup-post.php');
$api->route('/signin/', 'GET', require 'inc/routes/signin.php');
$api->route('/signin/', 'POST', require 'inc/routes/signin-post.php');
$api->route('/signout/', 'GET', require 'inc/routes/signout.php');
$api->route('/upload/', 'GET', require 'inc/routes/upload-form.php');
$api->route('/upload/', 'POST', require 'inc/routes/upload64-post.php');
$api->route('/upload/delete/', 'POST', require 'inc/routes/upload-delete.php');
$api->route('/admin/', 'GET', require 'inc/routes/admin.php');
