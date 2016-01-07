<?php

return function ($request, $response, $args) {
	global $api;
	$data = $request->getParsedBody();
	$sql = "INSERT IGNORE INTO registros (nombre, apellidos, email, telefono, contacto, token, ip) VALUES('" . $data["nombre"] . "','" . $data["apellidos"] . "','" . $data["email"] . "','" . $data["telefono"] . "','" . $data["contacto"] . "','" . $data["token"] . "','" . $_SERVER['REMOTE_ADDR'] . "')";
	$leadid = $api->query($sql);
	if ($leadid > 0) {
		$status = 1;
		$result["leadid"] = $leadid;
	} else {
		$status = 0;
		$result["error"] = "DUPLICADO";
	}

	return $api->response($response, json_encode(Array('status' => $status, 'result' => $result)), 200, 'application/json');
};