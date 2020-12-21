<?php
return function ($request, $response, $args) {
  global $api;
  $post = $request->getParsedBody();
  if ($api->validateData($post, ['email', 'password', 'redirect']) && $api->validateEmptyData($post, ['email', 'password', 'redirect'])) {
    $password = md5($post["password"]);
    $data = $api->query("SELECT * FROM users_oauth WHERE email='" . $post["email"] . "' AND password='" . $password . "'");
    if (count($data) > 0) {
      $response = $api->authenticate($response, $data[0]->token);

      return $response->withRedirect($post["redirect"]);
    } else {
      $response = $api->authenticate($response, null);

      return $response->withRedirect('/signin/');
    }
  } else {
    return $response->withRedirect('/signin/?err=1');
  }
};
