<?php
return function ($request, $response, $args) {
  global $api;
  $token = $request->getAttribute('token');
  $data = $api->query("SELECT * FROM usuarios WHERE token='" . $token . "'");
  return $api->response($response, json_encode($data[0]), 200, 'application/json');
};