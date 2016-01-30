# generator-slimphp

[![Join the chat at https://gitter.im/zguillez/generator-slimphp](https://badges.gitter.im/zguillez/generator-slimphp.svg)](https://gitter.im/zguillez/generator-slimphp?utm_source=badge&utm_medium=badge&utm_campaign=pr-badge&utm_content=badge)

[![npm version](https://badge.fury.io/js/generator-slimphp.svg)](https://badge.fury.io/js/generator-slimphp)
[![Build Status](http://img.shields.io/travis/zguillez/generator-slimphp.svg)](https://travis-ci.org/zguillez/generator-slimphp)
[![Code Climate](http://img.shields.io/codeclimate/github/zguillez/generator-slimphp.svg)](https://codeclimate.com/github/zguillez/generator-slimphp)
[![Dependency Status](https://gemnasium.com/zguillez/generator-slimphp.svg)](https://gemnasium.com/zguillez/generator-slimphp)
[![Installs](https://img.shields.io/npm/dt/generator-slimphp.svg)](https://coveralls.io/r/zguillez/generator-slimphp)
![](https://reposs.herokuapp.com/?path=zguillez/generator-slimphp)
[![License](http://img.shields.io/:license-mit-blue.svg)](http://doge.mit-license.org)
[![Analytics](https://ga-beacon.appspot.com/UA-1125217-30/zguillez/generator-slimphp?pixel)](https://github.com/igrigorik/ga-beacon)

> [Zguillez](https://zguillez.io) | Guillermo de la Iglesia

## Yeoman generator for backend API development with Slimframework 3 (PHP)
![](http://zguillez.github.io/img/slimphp.png)

# Getting Started
## Install Yeoman

```
npm install -g yo
```

## Yeoman Generators
To install generator-slimphp from npm, run:

```
npm install -g generator-slimphp
```

Finally, initiate the generator:

```
yo slimphp
```

Install composer dependences manually:

```bash
./composer.phar install
```

## Requeriments
### [Composer](https://getcomposer.org/)
For update composer

```
./composer.phar self-update
```

**Documentation:**
- [https://getcomposer.org/](https://getcomposer.org/)

# Usage
Develop code on folder **/inc**

```
/inc
    /app.php
    /config.php
    /routes
        /index.php
        /user-add.php
        /user.php
        /etc..
```

## Compile code
Use grunt task to compile code and deploy api

```
grunt serve
```

THis will launch server on port 9001

```
http://localhost:9001/
```

Distribute code is compileded on forder **/dist**

```
/dist
    .htaccess
    /inc
    /index.php
    /vendor
```

# Configuration

Edit file **/inc/config.php** for Database configuration

	// inc/config.php
	
	<?php
	
	$ip = '*.*.*.*';
	$user = '********';
	$password = '********';
	$database = '********';
	
	$api->database($ip, $user, $password, $database);

>If you API don't connect to any database, comment the require of the config file:

	// index.php
	
	<?php
	
	require 'vendor/autoload.php';
	require 'inc/app.php';
	//require 'inc/config.php';
	....

# API Routes

Put all your API urls into the file **/index.php**

	// index.php
	<?php
	
	...
	$api->route('/', 'GET', require 'inc/routes/index.php');
	...

In the **/inc/routes/** folder make a induvidual file for the path function:

	// inc/routes/index.php
	
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

This will return an HTML file for the path http://localhost:9001/

You can change the status response, for example to 404:

	return $api->response($response, $html, 404, 'text/html');

And the header content-type:
	
	return $api->response($response, $html, 200, 'application/json');

## Queries to the database

Make the SQL queries in the routes files to the global object **$api**:
	
	// inc/routes/user.php
	
	<?php
	
	return function ($request, $response, $args) {
		global $api;
		$token = $request->getAttribute('token');
		$data = $api->query("SELECT * FROM users WHERE token='" . $token . "'");
	
		return $api->response($response, json_encode($data), 200, 'application/json');
	};

This will return some data to the dummy api url:

	// index.php
	<?php
	
	...
	$api->route('/user/{token}', 'GET', require 'inc/routes/user.php');
	...

# GET or POST

You can do api call in GET or POST method:

	// index.php
	<?php
	
	...
	$api->route('/user/{token}', 'GET', require 'inc/routes/user.php');
	$api->route('/user/add/', 'POST', require 'inc/routes/user-add.php');
	...

To get POST data use the **getParseBody()** function:

	// inc/routes/user-add.php
	
	<?php
	
	return function ($request, $response, $args) {
		global $api;
		$data = $request->getParsedBody();
		$sql = "INSERT IGNORE INTO users (name, surname, email, phone, contact, token, ip) VALUES('" . $data["name"] . "','" . $data["surname"] . "','" . $data["email"] . "','" . $data["phone"] . "','" . $data["contact"] . "','" . $data["token"] . "','" . $_SERVER['REMOTE_ADDR'] . "')";
		$leadid = $api->query($sql);
		if ($leadid > 0) {
			$status = 1;
			$result["leadid"] = $leadid;
		} else {
			$status = 0;
			$result["error"] = "Not inserted";
		}
	
		return $api->response($response, json_encode(Array('status' => $status, 'result' => $result)), 200, 'application/json');
	};

# Contributing and issues
Contributors are welcome, please fork and send pull requests! If you have any ideas on how to make this project better then please submit an issue or send me an [email](mailto:mail@zguillez.io).

# License
©2016 Zguillez.io

Original code licensed under [MIT](https://en.wikipedia.org/wiki/MIT_License) Open Source projects used within this project retain their original licenses.

# Changelog
### v1.0.0 (January 12, 2016)
- Fix yo install version

### v0.1.0 (January 7, 2016)
Initial Slim Framework skeleton

Features:

* Slimframework
* External route files
* Grunt tasks

