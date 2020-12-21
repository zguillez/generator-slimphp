<?php
return function ($request, $response, $args) {
  global $api;
  $html = $api->template('upload-form');

  return $api->response($response, $html, 200, 'text/html');
};