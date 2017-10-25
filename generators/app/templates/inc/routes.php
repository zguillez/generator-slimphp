<?php
  $api->route('/', 'GET', require 'inc/routes/index.php');
  $api->route('/hello/{name}', 'GET', require 'inc/routes/hello.php');
  $api->route('/users', 'GET', require 'inc/routes/user.php');
  $api->route('/user/', 'POST', require 'inc/routes/user-post.php');
  $api->route('/user/{token}', 'GET', require 'inc/routes/user-get.php');
  $api->route('/login/{token}', 'GET', require 'inc/routes/login-get.php');
  $api->route('/login/{user}/{password}', 'GET', require 'inc/routes/login.php');
  $api->route('/participacion/', 'POST', require 'inc/routes/participacion-post.php');
  $api->route('/participacion/{token}', 'GET', require 'inc/routes/participacion-get.php');
  $api->route('/participaciones', 'GET', require 'inc/routes/participaciones.php');
  $api->route('/participaciones/estado/{estado}', 'POST', require 'inc/routes/participaciones-admin.php');
  $api->route('/participacion/{token}/estado/{estado}/', 'POST', require 'inc/routes/participacion-update.php');
  $api->route('/upload/', 'POST', require 'inc/routes/upload-post.php');
  $api->route('/upload/test', 'GET', require 'inc/routes/upload-form.php');
