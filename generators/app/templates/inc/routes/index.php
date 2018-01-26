<?php
return function ($request, $response, $args) {
  global $api;
  $html = '<h2>Routes</h2><ul>';
  function addroute($api, $html, $route)
  {
    $route2 = str_replace('{', '', $route);
    $route2 = str_replace('}', '', $route2);
    $html .= '<li><a target="_blank" href="' . $api->baseurl . $route2 . '">' . $api->baseurl . $route . '</a></li>';
    return $html;
  }

  foreach ($api->routes as $route) {
    $html = addroute($api, $html, $route);
  }
  $html .= '</ul>';
  return $api->response($response, $html, 200, 'text/html');
};