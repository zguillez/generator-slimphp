<?php
return function ($request, $response, $args) {
  global $api;
  $name = $request->getAttribute('name');
  $html = $api->template('index', ['name' => $name, 'copy' => 'z']);
  //for debug
  //$api->log->insert ( $request->getUri () );
  //$api->log->insert ( $html );
  return $api->response($response, $html, 200, 'text/html');
};