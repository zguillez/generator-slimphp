<?php
return function ($request, $response, $args) {
  global $api;
  $token = $request->getAttribute('token');
  $data = $api->query("SELECT * FROM participaciones WHERE token='" . $token . "'");
  $usuario = $api->query("SELECT * FROM usuarios WHERE id='" . $data[0]->usuario_id . "'");
  $data[0]->usuario = $usuario[0];
  return $api->response($response, json_encode($data[0]), 200, 'application/json');
};