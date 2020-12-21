<?php
return function ($request, $response, $args) {
  global $api;
  session_start();
  $data = $request->getParsedBody();
  $result = [];
  if ($api->validateData($data, ['token'])) {
    if ($api->validateEmptyData($data, ['token'])) {
      $token = $data["token"];
      //$api->query("DELETE FROM entity WHERE token='$token'");
      $status = 3;
      $api->query("UPDATE entity SET status='$status' WHERE token='$token'");
      $result["status"] = 1;
      $result["token"] = $token;
      $result["entity_status"] = $status;
    } else {
      $result["status"] = 0;
      $result["error"] = "DATA ERROR: empty fields";
      $result["break"] = $api->break;
      $result["data"] = $data;
    }
  } else {
    $result["status"] = 0;
    $result["error"] = "DATA ERROR: required fields";
    $result["data"] = $data;
  }

  return $api->response($response, json_encode($result), 200, 'application/json');
};