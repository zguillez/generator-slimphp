<?php
return function ($request, $response, $args) {
  global $api;
  $autenticated = $api->authenticated($request, $response);
  if (!$autenticated) {
    return $response->withRedirect('/signin/?redirect=admin');
  } else {
    $users = $api->query("SELECT * FROM users");
    $uploads = $api->query("SELECT * FROM users_uploads");
    $html = $api->template('admin', ['autenticated' => $autenticated, "users" => $users, "uploads" => $uploads]);

    return $api->response($response, $html, 200, 'text/html');
  }
};