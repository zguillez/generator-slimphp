<?php
return function ($request, $response, $args) {
  global $api;
  $data = $request->getParsedBody();
  if ($api->validateData($data, ['nombre', 'email', 'imagen'])) {
    $now = new DateTime("now");
    $token = sha1($data["email"] . "link3mann" . $now->format('Y-m-d H:i:s'));
    //--------------------------------
    if ($api->validateEmptyData($data, ['nombre', 'email', 'imagen'])) {
      $insert = false;
      $registro = $api->query("SELECT * FROM usuarios WHERE email='" . $data["email"] . "' ORDER BY creado DESC");
      if (count($registro) > 0) {
        /*DUPLICATE*/
        $status = 1;
        $usuario_id = $registro[0]->id;
      } else {
        $insert = true;
      }
      if ($insert) {
        $sql = "INSERT IGNORE INTO usuarios (nombre, email, token, ip) VALUES('" . $data["nombre"] . "','" . $data["email"] . "','" . $token . "','" . $_SERVER['REMOTE_ADDR'] . "')";
        $api->log2->insert($sql);
        $leadid = $api->query($sql);
        if ($leadid > 0) {
          $status = 1;
          $usuario_id = $leadid;
          $result["data"] = $data;
        } else {
          $status = 0;
          $result["error"] = "ERROR ON INSERT";
          $result["data"] = $data;
        }
      }
    } else {
      $status = 0;
      $result["error"] = "DATA ERROR: empty fields";
      $result["break"] = $api->break;
      $result["data"] = $data;
    }
  } else {
    $status = 0;
    $result["error"] = "DATA ERROR: required fields";
    $result["data"] = $data;
  }
  if ($status === 1) {
    $registro = $api->query("SELECT * FROM participaciones WHERE imagen='" . $data["imagen"] . "' ORDER BY creado DESC");
    if (count($registro) > 0) {
      //$status          = 0;
      //$result["error"] = "DUPLICATE";
      //$result["registro"] = $registro[0];
      $status = 1;
      $result["usuario_id"] = (int)$registro[0]->usuario_id;
      $result["participacion_id"] = (int)$registro[0]->id;
      $result["data"] = $data;
    } else {
      $insert = true;
    }
    if ($insert) {
      $token = sha1($data["imagen"] . "link3mann" . $now->format('Y-m-d H:i:s'));
      $sql = "INSERT IGNORE INTO participaciones (usuario_id, imagen, token) VALUES('" . $usuario_id . "','" . $data["imagen"] . "','" . $token . "')";
      $leadid = $api->query($sql);
      if ($leadid > 0) {
        $status = 1;
        $result["usuario_id"] = (int)$usuario_id;
        $result["participacion_id"] = (int)$leadid;
        $result["data"] = $data;
      } else {
        $status = 0;
        $result["error"] = "ERROR ON INSERT";
        $result["data"] = $data;
        $result["sql"] = $sql;
      }
    }
  }
  return $api->response($response, json_encode(Array('status' => $status, 'result' => $result)), 200, 'application/json');
};