<?php
return function ($request, $response, $args) {
  global $api;
  $token = $request->getAttribute('token');
  $data = $api->query("SELECT * FROM users WHERE token='" . $token . "'");

  return $api->oauthResponse($request, $response, json_encode($data[0]), 200, 'application/json');
};