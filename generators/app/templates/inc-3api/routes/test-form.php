<?php
return function ($request, $response, $args) {
  global $api;
  $html = $api->template('test-form', ['url' => '/upload/']);

  return $api->response($response, $html, 200, 'text/html');
};
