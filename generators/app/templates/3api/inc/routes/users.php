<?php
return function ($request, $response, $args) {
  global $api;
  $data = $api->query("SELECT * FROM users");

  return $api->response($response, json_encode($data), 200, 'application/json');
};
