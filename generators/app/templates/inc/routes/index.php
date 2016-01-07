<?php

return function ($request, $response, $args) {
	global $api;
	$html = '
		<h2>Routes</h2>
		<ul>
		<li>/</li>
		<li>/user/{token}</li>
		<li>/user/add/</li>
		</ul>
		';

	return $api->response($response, $html, 200, 'text/html');
};