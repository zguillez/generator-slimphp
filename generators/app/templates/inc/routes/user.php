<?php
return function ($request, $response, $args) {
  global $api;
  $data = $api->query("SELECT * FROM usuarios");
  return $api->response($response, json_encode($data), 200, 'application/json');
};