<?php
return function ($request, $response, $args) {
  global $api;
  $post = $request->getParsedBody();
  if ($api->validateData($post, ['name', 'lastname', 'email', 'password1', 'password2', 'redirect']) && $api->validateEmptyData($post, ['name', 'lastname', 'email', 'password1', 'password2', 'redirect'])) {
    if ($post["password1"] === $post["password2"]) {
      $data = $api->query("SELECT * FROM users_oauth WHERE email='" . $post["email"] . "'");
      if (count($data) === 0) {
        $token = $api->token();
        $user_entity_id = $api->query("INSERT IGNORE INTO entity VALUES(NULL,'1','1','$token','" . date("Y-m-d H:i:s") . "','" . date("Y-m-d H:i:s") . "')");
        $api->query("INSERT IGNORE INTO user VALUES( '$user_entity_id','" . $post["name"] . "','" . $post["lastname"] . "','" . $post["email"] . "')");
        $oauth_entity_id = $api->query("INSERT IGNORE INTO entity VALUES(NULL,'2','1','" . $api->token() . "','" . date("Y-m-d H:i:s") . "','" . date("Y-m-d H:i:s") . "')");
        $api->query("INSERT IGNORE INTO oauth VALUES( '$oauth_entity_id','1','" . md5($post["password1"]) . "')");
        $user_oauth_id = $api->query("INSERT IGNORE INTO user_oauth VALUES(NULL,'$user_entity_id','$oauth_entity_id')");
        if ($user_oauth_id > 0) {
          $api->authenticate($response, $token);

          return $response->withRedirect($post["redirect"]);
        } else {
          $api->query("DELETE FROM entity WHERE id='$user_entity_id' OR id='$oauth_entity_id'");

          return $response->withRedirect('/signup/?err=4');
        }
      } else {
        return $response->withRedirect('/signup/?err=3');
      }
    } else {
      return $response->withRedirect('/signup/?err=2');
    }
  } else {
    return $response->withRedirect('/signup/?err=1');
  }
};
