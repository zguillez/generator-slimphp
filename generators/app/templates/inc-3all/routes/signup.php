<?php
return function ($request, $response, $args) {
  global $api;
  $html = $api->template('signup', [
      'title' => 'Sign in',
      'copy' => '@2020 zguillez'
  ]);

  return $api->response($response, $html, 200, 'text/html');
};
