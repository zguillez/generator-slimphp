<?php

return function ($request, $response, $args) {
	global $api;

	$name = $request->getAttribute('name');

	$result = json_encode('Hello ' . $name);

	//for debug
	$api->log->insert($request->getUri());
	$api->log->insert($result);

	return $api->response($response, $result, 200, 'application/json');
};