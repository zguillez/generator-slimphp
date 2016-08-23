<?php

	return function ($request, $response, $args) {
		global $api;
		$data = $request->getParsedBody();
		if ($api->validateData($data, ['nombre', 'email'])) {
			$now   = new DateTime("now");
			$token = sha1($data["email"] . "link3mann" . $now->format('Y-m-d H:i:s'));
			//--------------------------------
			if ($api->validateEmptyData($data, ['nombre', 'email'])) {
				$insert   = false;
				$registro = $api->query("SELECT * FROM registros WHERE email='" . $data["email"] . "' ORDER BY creado DESC");
				if (count($registro) > 0) {
					$status          = 0;
					$result["error"] = "DUPLICATE";
					//$result["registro"] = $registro[0];
				} else {
					$insert = true;
				}
				if ($insert) {
					$sql    = "INSERT IGNORE INTO registros (nombre, email, token, ip) VALUES('" . $data["nombre"] . "','" . $data["email"] . "','" . $token . "','" . $_SERVER['REMOTE_ADDR'] . "')";
					$leadid = $api->query($sql);
					if ($leadid > 0) {
						$status           = 1;
						$result["leadid"] = $leadid;
						$result["data"]   = $data;
					} else {
						$status          = 0;
						$result["error"] = "ERROR ON INSERT";
						$result["data"]  = $data;
					}
				}
			} else {
				$status          = 0;
				$result["error"] = "DATA ERROR: empty fields";
				$result["break"] = $api->break;
				$result["data"]  = $data;
			}
		} else {
			$status          = 0;
			$result["error"] = "DATA ERROR: required fields";
			$result["data"]  = $data;
		}

		return $api->response($response, json_encode(Array('status' => $status, 'result' => $result)), 200, 'application/json');
	};