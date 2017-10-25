<?php
  return function($request, $response, $args) {
    global $api;
    $data   = $request->getParsedBody();
    $result = $api->query("SELECT e.nombre as estado, u.nombre as usuario, u.email, p.* FROM participaciones as p INNER JOIN estados as e ON p.estado_id=e.id INNER JOIN usuarios as u ON p.usuario_id=u.id WHERE p.estado_id='" . $data['estado'] . "' LIMIT 0,20");

    return $api->response($response, json_encode($result), 200, 'application/json');
  };