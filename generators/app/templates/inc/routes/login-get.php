<?php
return function ($request, $response, $args) {
  global $api;
  $token = $request->getAttribute('token');
  $data = $api->query("SELECT * FROM admin WHERE token='" . $token . "'");
  $data = (count($data) > 0) ? $data[0] : [];
  return $api->response($response, json_encode($data), 200, 'application/json');
};