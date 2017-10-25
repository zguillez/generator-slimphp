<?php
  return function($request, $response, $args) {
    global $api;
    session_start();
    $data = $request->getParsedBody();
    if($api->validateData($data, ['base64'])) {
      $now   = new DateTime("now");
      $token = sha1($data["email"] . "link3mann" . $now->format('Y-m-d H:i:s'));
      //--------------------------------
      if($api->validateEmptyData($data, ['base64'])) {
        $targetPath = dirname(dirname(dirname((dirname(__FILE__))))) . '/uploads';
        if(! is_dir($targetPath)) {
          mkdir($targetPath, 0755, true);
        }
        $output_file = $targetPath . '/' . $token . '.jpg';
        $ifp         = fopen($output_file, 'wb');
        $filedata    = explode(',', $data["base64"]);
        fwrite($ifp, base64_decode($filedata[1]));
        fclose($ifp);
        /**
         * thumb
         */
        $desired_width = 400;
        /**  */
        list($width, $height) = getimagesize($output_file);
        $desired_height = floor($height * ($desired_width / $width));
        $source_image   = imagecreatefromstring(base64_decode($filedata[1]));
        $thumb          = imagecreatetruecolor($desired_width, $desired_height);
        imagecopyresized($thumb, $source_image, 0, 0, 0, 0, $desired_width, $desired_height, $width, $height);
        $output_file2 = $targetPath . '/' . $token . '_thumb.jpg';
        imagejpeg($thumb, $output_file2);
        /**/
        $status         = 1;
        $result["path"] = $output_file2;
        $result["url"]  = "https://" . $_SERVER['HTTP_HOST'] . "/uploads/" . $token . ".jpg";
        $result["data"] = $data;
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

  /** js */
  /*
   let reader = new FileReader();
    let file = document.querySelector('input[type="file"]').files[0];
    reader.readAsDataURL(file);
    reader.onload = function() {
      axios.post('https://cafeterasmarcilla.es/api/upload/', {
          base64: reader.result
        })
        .then(response => {
          console.log(response.data);
        })
        .catch(error => {
          console.log('Error: ', error);
        });
    };
    reader.onerror = function(error) {
      console.log('Error: ', error);
    };
   */