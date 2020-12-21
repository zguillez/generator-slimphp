<?php
return function ($request, $response, $args) {
  global $api;
  $response = $api->authenticate($response, null);
  return $response->withRedirect('/');
};