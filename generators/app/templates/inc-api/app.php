<?php

use Slim\Http\MobileResponse;
use Z\Log;

class App
{
  public $baseurl;
  public $host;
  public $app;
  public $log;
  public $log2;
  public $break;
  private $database;
  private $last_insert_id;
  private $mustache;

  public function __construct()
  {
    $this->host = 'http://' . $_SERVER['SERVER_NAME'];
    $this->baseurl = ($this->host === 'http://127.0.0.1') ? 'http://localhost:8000' : $this->host;
    $this->routes = [];
    $this->break = "";
    $this->app = new \Slim\App();
    $this->app->getContainer()['notFoundHandler'] = function ($container) {
      return function ($request, $response) use ($container) {
        return $this->response($container['response'], 'Page not found', 404);
      };
    };
    $params["filename"] = "apicalls";
    $params["path"] = "./logs/";
    $this->log = new Log($params);
    $params["filename"] = "apisql";
    $params["path"] = "./logs/";
    $this->log2 = new Log($params);
    $options = ['loader' => new Mustache_Loader_FilesystemLoader(dirname(__FILE__) . '/views', ['extension' => '.html']), 'partials_loader' => new Mustache_Loader_FilesystemLoader(dirname(__FILE__) . '/views/partials', ['extension' => '.html'])];
    $this->mustache = new Mustache_Engine($options);
  }

  public function run()
  {
    $this->app->run();
  }

  public function route($route, $method, $callback)
  {
    if ($method === 'POST') {
      $this->app->post($route, $callback);
    } else if ($method === 'GET') {
      $this->app->get($route, $callback);
    } else if ($method === 'PUT') {
      $this->app->put($route, $callback);
    } else if ($method === 'DELETE') {
      $this->app->delete($route, $callback);
    }
    array_push($this->routes, $route);
  }

  public function response($response, $data = '', $status = 200, $type = 'text/html')
  {
    $response = new MobileResponse($response);
    $this->log->insert($data);
    return $response->withStatus($status)->withHeader('Content-type', $type)->write($data);
  }

  public function database($host, $user, $password, $database)
  {
    $this->database = mysqli_connect($host, $user, $password, $database);
    $this->database->set_charset("utf8");
  }

  public function folder($folder)
  {
    $this->baseurl = ($this->host === 'http://127.0.0.1') ? 'http://localhost:8000' : $this->host . '/' . $folder;
  }

  public function query($sql, $forceResults = false)
  {
    $this->last_insert_id = 0;
    $query = mysqli_query($this->database, $sql);
    if (mysqli_insert_id($this->database) > 0 && !$forceResults) {
      $this->last_insert_id = mysqli_insert_id($this->database);
      return $this->last_insert_id;
    } else {
      if (gettype($query) === 'object') {
        $data = [];
        while ($result = $query->fetch_object()) {
          $data[] = $result;
        }
      } else if (gettype($query) === 'boolean') {
        if ($forceResults) {
          $data = $query;
        } else {
          $data = $this->last_insert_id;
        }
      } else {
        $data = $query;
      }
      return $data;
    }
  }

  public function validateData($data, $params)
  {
    foreach ($params as $param) {
      if (!isset($data[$param])) {
        return false;
      }
    }
    return true;
  }

  public function validateEmptyData($data, $params)
  {
    foreach ($params as $param) {
      if (!isset($data[$param]) || $data[$param] === '') {
        $this->break = $param;
        return false;
      }
    }
    return true;
  }

  public function template($tpl, $data = [])
  {
    $template = $this->mustache->loadTemplate($tpl);
    $html = $template->render($data);
    return $html;
  }
}

$api = new App();
