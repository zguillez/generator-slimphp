<?php
return function ($request, $response, $args) {
  global $api;
  $data = $request->getParsedBody();
  $query = "UPDATE participaciones SET estado_id=" . $data['estado'] . " WHERE token='" . $data['token'] . "'";
  $result = $api->query($query);
  return $api->response($response, json_encode(Array('result' => $query)), 200, 'application/json');
};