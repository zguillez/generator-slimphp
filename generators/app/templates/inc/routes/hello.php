<?php

return function ($request, $response, $args) {
	global $api;
	$name = $request->getAttribute('name');

	return $api->response($response, json_encode('Hello ' . $name), 200, 'application/json');
};
