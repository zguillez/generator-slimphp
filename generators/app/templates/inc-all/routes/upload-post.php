<?php
return function ($request, $response, $args) {
  global $api;
  session_start();
  $targetPath = dirname(dirname(dirname((dirname(__FILE__))))) . '/uploads/' . session_id();
  if (!is_dir($targetPath)) {
    mkdir($targetPath, 0755, true);
  }
  if (!empty($_FILES)) {
    $tempFile = $_FILES['file']['tmp_name'];
    list($width, $height) = getimagesize($tempFile);
    /**/
    $ext = strtolower(end(explode('.', $_FILES['file']['name'])));
    $targetFile = $targetPath . '/' . md5(date("Y-m-d H:i:s")) . '.' . $ext;
    move_uploaded_file($tempFile, $targetFile);
    $status = 1;
    $url = str_replace('/var/www/vhosts/', 'http://', $targetFile);
    $url = str_replace('/httpdocs/', '/', $url);
    $result["original"] = $url;
    /* thumbnail */
    if ($ext == 'jpeg') {
      $tempFile = imagecreatefromjpeg($targetFile);
    } else if ($ext == 'jpg') {
      $tempFile = imagecreatefromjpeg($targetFile);
    } else if ($ext == 'png') {
      $tempFile = imagecreatefrompng($targetFile);
    } else if ($ext == 'gif') {
      $tempFile = imagecreatefromgif($targetFile);
    } else if ($ext == 'bmp') {
      $tempFile = imagecreatefromwbmp($targetFile);
    }
    $thumbWidth = 400;
    $new_width = $thumbWidth;
    $new_height = floor($height * ($thumbWidth / $width));
    $tempFile2 = imagecreatetruecolor($new_width, $new_height);
    imagecopyresized($tempFile2, $tempFile, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
    $targetFile = $targetPath . '/' . md5(date("Y-m-d H:i:s")) . '_' . $thumbWidth . '.' . $ext;
    imagejpeg($tempFile2, $targetFile);
    $url = str_replace('/var/www/vhosts/', 'http://', $targetFile);
    $url = str_replace('/httpdocs/', '/', $url);
    $result["resize"] = $url;
  } else {
    $status = 0;
    $result["error"] = "FILES EMPTY";
  }
  return $api->response($response, json_encode(Array('status' => $status, 'result' => $result)), 200, 'application/json');
};