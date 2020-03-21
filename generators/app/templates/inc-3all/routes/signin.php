<?php
return function ($request, $response, $args) {
  global $api;
  $redirect = (isset($_GET['redirect'])) ? "/" . $_GET['redirect'] . "/" : "/";
  $html = $api->template('signin', [
      "redirect" => $redirect,
      'title' => 'Sign up',
      'img' => '/static/images/zguillez.png',
      'copy' => '@2020 zguillez'
  ]);

  return $api->response($response, $html, 200, 'text/html');
};
