<?php
return function ($request, $response, $args) {
  global $api;
  $post = $request->getParsedBody();
  if ($api->validateData($post, ['name', 'lastname', 'email', 'redirect']) && $api->validateEmptyData($post, ['name', 'lastname', 'email', 'redirect'])) {
    if ($post["password1"] === $post["password2"]) {
      $data = $api->query("SELECT * FROM users WHERE email='" . $post["email"] . "'");
      if (count($data) === 0) {
        $token = $api->token();
        $user_entity_id = $api->query("INSERT IGNORE INTO entity VALUES(NULL,'1','$token','" . date("Y-m-d H:i:s") . "','" . date("Y-m-d H:i:s") . "')");
        $api->query("INSERT IGNORE INTO user VALUES( '$user_entity_id','" . $post["name"] . "','" . $post["lastname"] . "','" . $post["email"] . "')");
        $data = $api->query("SELECT * FROM users WHERE token='$token'");
        if (count($data) > 0) {
          $api->authenticate($response, $token);

          return $response->withRedirect($post["redirect"]);
        } else {
          $api->query("DELETE FROM entity WHERE id='$user_entity_id'");

          return $response->withRedirect('/?err=4');
        }
      } else {
        return $response->withRedirect('/?err=3');
      }
    } else {
      return $response->withRedirect('/?err=2');
    }
  } else {
    return $response->withRedirect('/?err=1');
  }
};
