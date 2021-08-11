<?php
return function ($request, $response, $args) {
  global $api;
  $html = "Hello world!";
  //for debug
  //$api->log->insert ( $request->getUri () );
  //$api->log->insert ( $html );
  return $api->response($response, $html, 200, "text/html");
};
