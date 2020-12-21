<?php
return function ($request, $response, $args) {
  global $api;
  //$get = $request->getAttribute('get');
  $html = $api->template('index', [
    'title' => 'SlimPHP demo',
    'img' => 'static/images/zguillez.png',
    'copy' => '@2020 zguillez'
  ]);
  //for debug
  //$api->log->insert ( $request->getUri () );
  //$api->log->insert ( $html );
  return $api->response($response, $html, 200, 'text/html');
};
