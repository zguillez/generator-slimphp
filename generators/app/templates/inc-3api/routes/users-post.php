<?php
return function ($request, $response, $args) {
  global $api;
  $post = $request->getParsedBody();
  $result = [];
  $name = $post["name"];
  $lastname = $post["lastname"];
  $email = $post["email"];
  $upload = $post["upload"];
  if ($api->validateData($post, ['name', 'lastname', 'email']) && $api->validateEmptyData($post, ['name', 'lastname', 'email'])) {
    $data1 = $api->query("SELECT * FROM users WHERE email='$email'");
    if (count($data1) === 0) {
      $token = $api->token();
      $user_entity_id = $api->query("INSERT IGNORE INTO entity VALUES (NULL,'1','1','$token','" . date("Y-m-d H:i:s") . "','" . date("Y-m-d H:i:s") . "')");
      $api->query("INSERT IGNORE INTO user VALUES( '$user_entity_id','$name','$lastname','$email')");
      $data2 = $api->query("SELECT * FROM users WHERE token='$token'");
      if (count($data2) > 0) {
        $data3 = $api->query("SELECT * FROM upload WHERE filename='$upload'");
        if (count($data3) > 0) {
          $api->query("INSERT IGNORE INTO  user_upload VALUES (NULL,'" . $data2[0]->id . "','" . $data3[0]->id . "')");
          $data4 = $api->query("SELECT * FROM users_uploads WHERE email='$email' AND filename='$upload'");
          if (count($data4) > 0) {
            $api->authenticate($response, $token);
            $result['status'] = 1;
          } else {
            $result['status'] = 0;
            $result['error'] = 'insert2 error';
            $api->query("DELETE FROM entity WHERE id='$user_entity_id'");
          }
        } else {
          $result['status'] = 0;
          $result['error'] = 'upload not found';
          $api->query("DELETE FROM entity WHERE id='$user_entity_id'");
        }
      } else {
        $result['status'] = 0;
        $result['error'] = 'insert1 error';
        $api->query("DELETE FROM entity WHERE id='$user_entity_id'");
      }
    } else {
      $result['status'] = 0;
      $result['error'] = 'duplicate email';
    }
  } else {
    $result['status'] = 0;
    $result['error'] = 'invalid data';
  }

  return $api->response($response, json_encode($result), 200, 'application/json');
};
