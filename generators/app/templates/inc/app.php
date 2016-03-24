<?php

class App {
	public $app;
	private $database;
	public function __construct() {
		$this->app = new \Slim\App();
		$this->app->getContainer()['notFoundHandler'] = function ($container) {
			return function ($request, $response) use ($container) {
				return $this->response($container['response'], 'Page not found', 404);
			};
		};
	}
	public function run() {
		$this->app->run();
	}
	public function route($route, $method, $callback) {
		if ($method === 'POST') {
			$this->app->post($route, $callback);
		} else if ($method === 'GET') {
			$this->app->get($route, $callback);
		} else if ($method === 'PUT') {
			$this->app->put($route, $callback);
		} else if ($method === 'DELETE') {
			$this->app->delete($route, $callback);
		}
	}
	public function response($response, $data = '', $status = 200, $type = 'text/html') {
		return $response->withStatus($status)->withHeader('Content-type', $type)->write($data);
	}
	public function database($host, $user, $password, $database) {
		$this->database = mysqli_connect($host, $user, $password, $database);
	}
	public function query($sql) {
		$query = mysqli_query($this->database, $sql);
		if (mysqli_insert_id($this->database) > 0) {
			return mysqli_insert_id($this->database);
		} else {
			$data = [];
			while ($result = $query->fetch_object()) {
				$data[] = $result;
			}

			return $data;
		}
	}
}
$api = new App();