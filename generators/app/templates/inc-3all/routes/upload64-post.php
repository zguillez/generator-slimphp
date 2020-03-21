<?php
return function ($request, $response, $args) {
  global $api;
  session_start();
  $data = $request->getParsedBody();
  $result = [];
  if ($api->validateData($data, ['fileName', 'base64'])) {
    if ($api->validateEmptyData($data, ['fileName', 'base64'])) {
      $targetPath = dirname(dirname((dirname(__FILE__)))) . '/uploads/' . session_id();
      $targetUrl = $api->baseurl . '/uploads/' . session_id();
      if (!is_dir($targetPath)) {
        mkdir($targetPath, 0755, true);
      }
      $token = $api->token();
      $fileExt = strtolower(end(explode('.', $data["fileName"])));
      $output_file = $targetPath . '/' . $token . '.' . $fileExt;
      $output_url = $targetUrl . '/' . $token . '.' . $fileExt;
      $ifp = fopen($output_file, 'wb');
      $filedata = explode(',', $data["base64"]);
      fwrite($ifp, base64_decode($filedata[1]));
      fclose($ifp);
      /**
       * thumb
       * $desired_width = 400;
       * list($width, $height) = getimagesize($output_file);
       * $desired_height = floor($height * ($desired_width / $width));
       * $source_image = imagecreatefromstring(base64_decode($filedata[1]));
       * $thumb = imagecreatetruecolor($desired_width, $desired_height);
       * imagecopyresized($thumb, $source_image, 0, 0, 0, 0, $desired_width, $desired_height, $width, $height);
       * $output_file2 = $targetPath . '/' . $token . '_thumb.jpg';
       * imagejpeg($thumb, $output_file2);
       */
      /** db */
      $data = $api->query("SELECT * FROM users WHERE token='" . $api->authenticated($request) . "'");
      $user_id = (count($data) > 0) ? $data[0]->id : $user_id = 1;
      $data = $api->query("SELECT * FROM upload_type WHERE type='$fileExt'");
      $type_id = (count($data) > 0) ? intval($data[0]->id) : $api->query("INSERT IGNORE INTO upload_type VALUES(NULL,'$fileExt')");
      $upload_entity_id = $api->query("INSERT IGNORE INTO entity VALUES(NULL,'3','1','$token','" . date("Y-m-d H:i:s") . "','" . date("Y-m-d H:i:s") . "')");
      $api->query("INSERT IGNORE INTO upload VALUES( '$upload_entity_id','$type_id','$token','$output_file','$output_url')");
      //$user_upload_id = $api->query("INSERT IGNORE INTO user_upload VALUES(NULL,'$user_id','$upload_entity_id')");
      //if ($user_upload_id > 0) {
      $data = $api->query("SELECT * FROM upload WHERE id='$upload_entity_id'");
      if (count($data) > 0) {
        $result["status"] = 1;
        $result["token"] = $token;
      } else {
        $api->query("DELETE FROM entity WHERE id='$upload_entity_id'");
        $result["status"] = 0;
        $result["error"] = "DATABASE ERROR: entity not created";
        $result["token"] = $token;
        $result["user_id"] = $user_id;
        $result["type_id"] = $type_id;
        $result["upload_entity_id"] = $upload_entity_id;
        //$result["user_upload_id"] = $user_upload_id;
      }
      /** */
      $result["path"] = $output_file;
      $result["url"] = $output_url;
      $result["data"] = $data;
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