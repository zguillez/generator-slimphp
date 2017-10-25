<?php
  return function($request, $response, $args) {
    global $api;
    $user     = $request->getAttribute('user');
    $password = $request->getAttribute('password');
    $data     = $api->query("SELECT * FROM admin WHERE user='" . $user . "' AND password='" . $password . "'");
    $data     = (count($data) > 0) ? $data[0] : [];

    return $api->response($response, json_encode($data), 200, 'application/json');
  };