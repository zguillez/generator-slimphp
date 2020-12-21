<?php
return function ($request, $response, $args) {
  global $api;
  session_start();
  $targetPath = dirname(dirname((dirname(__FILE__)))) . '/uploads/' . session_id();
  $targetUrl = $api->baseurl . '/uploads/' . session_id();
  if (!is_dir($targetPath)) {
    mkdir($targetPath, 0755, true);
  }
  $result = [];
  $result["path"] = $targetPath;
  if (!empty($_FILES)) {
    $tempFile = $_FILES['file']['tmp_name'];
    list($width, $height) = getimagesize($tempFile);
    /**/
    $ext = strtolower(end(explode('.', $_FILES['file']['name'])));
    $fileName = $api->token();
    $targetFile = $targetPath . '/' . $fileName . '.' . $ext;
    $url = $targetUrl . '/' . $fileName . '.' . $ext;
    move_uploaded_file($tempFile, $targetFile);
    $result["status"] = 0;
    $result["original"] = $url;
    /**
     * thumb
     */
    $thumbWidth = 400;
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
    $new_width = $thumbWidth;
    $new_height = floor($height * ($thumbWidth / $width));
    $tempFile2 = imagecreatetruecolor($new_width, $new_height);
    imagecopyresized($tempFile2, $tempFile, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
    $targetFile = $targetPath . '/' . $fileName . '_' . $thumbWidth . '.jpg';
    imagejpeg($tempFile2, $targetFile);
    $url = $targetUrl . '/' . $fileName . '_' . $thumbWidth . '.jpg';
    $result["thumbnail"] = $url;
  } else {
    $result["status"] = 0;
    $result["error"] = "DATA ERROR: empty fields";
  }

  return $api->response($response, json_encode($result), 200, 'application/json');
};