# generator-slimphp

[![npm version](https://badge.fury.io/js/generator-slimphp.svg)](https://badge.fury.io/js/generator-slimphp)
[![Build Status](http://img.shields.io/travis/zguillez/generator-slimphp.svg)](https://travis-ci.org/zguillez/generator-slimphp)
[![Installs](https://img.shields.io/npm/dt/generator-slimphp.svg)](https://coveralls.io/r/zguillez/generator-slimphp)
[![Gitter](https://badges.gitter.im/zguillez/generator-slimphp.svg)](https://gitter.im/zguillez/generator-slimphp?utm_source=badge&utm_medium=badge&utm_campaign=pr-badge&utm_content=badge)

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

## Requeriments

### [Nodejs](https://nodejs.org)

**Documentation:**
- [https://nodejs.org](https://nodejs.org)


### [Yarn](https://yarnpkg.com)

**Documentation:**
- [https://yarnpkg.com](https://yarnpkg.com)

### [Composer](https://getcomposer.org)
For update local composer

```
./composer.phar self-update
```
**Documentation:**
- [https://getcomposer.org](https://getcomposer.org)

# Configuration

**FIRST OF ALL** you need to edit the file *.sshconfig*. 

## configuration file

Edit the **.sshconfig** with the data of your SSH server access and data base configuration.
 
```
{
    "domain": "https://{mydomain.com}",
    "ssh": {
        "host": "{ip}",
        "username": "{username}",
        "password": "{password}",
        "path": "/var/www/vhosts/{mydomain.com}/httpdocs/",
        "folder": "{folder}"
	},
    "ftp": {
        "host": "ftp.{mydomain.com}",
        "port": 21,
        "username": "{username}",
        "password": "{password}",
        "local": "./",
        "remote": "/"
     },
	"database": {
		"host": "{ip}",
		"username": "{username}",
		"password": "{password}",
		"database": "{database}"
	}
}
```

## configure local environment

Run de npm command **prepare-local**. This will edit the file *inc/config.php* with the *.sshconfig* data.

```
yarn prepare-local
```

## configure remote server

Run de npm command **prepare-remote**. Install composer dependencies.

```
yarn prepare-remote
```

## Disable the database connection

If your api don't connect to a database, you need to remove the *require* of the config in the file *index.php*.

```
//require 'inc/config.php';
```

## Log System

All api call create a log file on /log folder. This folder must be created and with writte permitions.

```
/logs/apicalls.log
```

You can send traces to the log file from de routes by:

```
$api->log->insert ( $request->getUri () );
```

to disable the logs system remove or comment the line ```$this->log->insert($data);``` on **app.php** file.

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

## Local server
Run npm task *serve* for development server

```
yarn serve
```

# API Routes

Put all your API urls into the file **/inc/routes.php**

```
// inc/routes
<?php

...
$api->route('/', 'GET', require 'inc/routes/index.php');
...
```

If your app is on a folder (for example '**/api**') uncomment this line:

```
//$api->folder('api');
```
This will work for **http://domain.com/api/** path.

In the **/inc/routes/** folder make a induvidual file for the path function:

```
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
```

This will return an HTML file for the path http://localhost:9001/

You can change the status response, for example to 404:

```
return $api->response($response, $html, 404, 'text/html');
```

And the header content-type:
	
```
return $api->response($response, $html, 200, 'application/json');
```

## Queries to the database

Make the SQL queries in the routes files to the global object **$api**:

```	
// inc/routes/user.php

<?php

return function ($request, $response, $args) {
	global $api;
	$token = $request->getAttribute('token');
	$data = $api->query("SELECT * FROM users WHERE token='" . $token . "'");

	return $api->response($response, json_encode($data), 200, 'application/json');
};
```

This will return some data to the dummy api url:

```
// index.php
<?php

...
$api->route('/user/{token}', 'GET', require 'inc/routes/user.php');
...
```

# GET or POST

You can do api call in GET or POST method:

```
// index.php
<?php

...
$api->route('/user/{token}', 'GET', require 'inc/routes/user.php');
$api->route('/user/add/', 'POST', require 'inc/routes/user-add.php');
...
```

To get POST data use the **getParseBody()** function:

```
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
```

# Mobile-Detect

Mobile detection for api calls is implemented. 

```
{
  "require": {
    "slim/slim": "^3.0",
    "zguillez/slim-mobile-detect": "^1.0"
  }
}
```

So you can edit the **response** function on app.php file:

```
public function response($response, $data = '', $status = 200, $type = 'text/html')
{
	$response = new MobileResponse($response);
	return $response->withStatus($status)->withHeader('Content-type', $type)->write($data);
}
```

For more info check:

* [https://github.com/zguillez/slim-mobile-detect](https://github.com/zguillez/slim-mobile-detect)
* [https://packagist.org/packages/zguillez/slim-mobile-detect](https://packagist.org/packages/zguillez/slim-mobile-detect)

#Templating

Mustache templates is implemented. You can load a template from the route file

```
$name = $request->getAttribute ( 'name' );

$html = $api->template ( 'hello', ['name' => $name] );

return $api->response ( $response , $html , 200 , 'text/html' );
```

The templates files are on folders **/inc/views/** and  **/inc/views/partials/**.

For more info check:

* [https://github.com/bobthecow/mustache.php](https://github.com/bobthecow/mustache.php)

# Publish to production

If you have SSH access to your production server, you can publish and upload the api files to the server by a npm task.

```
yarn deploy
```

To install composer dependencies run the task *prepare-remote*.

```
yarn prepare-remote
```

You must edit the PHP path on the task **prepare-remote** at the file *packaje.json*.

```
'/opt/plesk/php/5.6/bin/php composer.phar update'
```

# Tools

## validateData

This function will check if a list of parameter are passed in POST data:

```
if ($api->validateData($data, ['name', 'email'])) {
	...
} else {
	//error: no 'name' or 'email' parameter
}
```

## validateEmptyData

This function will check if a list of parameter are empty in POST data:

```
if ($api->validateEmptyData($data, ['name', 'email'])) {
	...
} else {
	//error: 'name' or 'email' have empty value
}
```

# Contributing and issues
Contributors are welcome, please fork and send pull requests! If you have any ideas on how to make this project better then please submit an issue or send me an [email](mailto:mail@zguillez.io).

# License
©2017 [Zguillez.io](https://zguillez.io)

Original code licensed under [MIT](https://en.wikipedia.org/wiki/MIT_License) Open Source projects used within this project retain their original licenses.

# Changelog
### v2.6.0 (January 26, 2018)
- Add prompt for web development project

### v2.5.0 (October 26, 2017)
- Update yeoman generator
- Config on .sshconfig file
- Nodejs config tools
- Add yarn dependencie
- Remove grunt
- Remove virtual host

### v2.0.0 (December 21, 2016)
- Setup virtual host
- Config on json file
- Publish api to production by SSH
- Log system
- Templates with Mustache

### v1.3.0 (August 23, 2016)
- Core update
- Update dependencies
- Implements MobileResponse 
- validateData and validateEmptyData methods

### v1.1.0 (March 24, 2016)
- Allow DELETE and PUT methods

### v1.0.0 (January 12, 2016)
- Fix yo install version

### v0.1.0 (January 7, 2016)
Initial Slim Framework skeleton

Features:

* Slimframework
* External route files
* Grunt tasks

[![Analytics](https://ga-beacon.appspot.com/UA-1125217-30/zguillez/generator-slimphp?pixel)](https://github.com/igrigorik/ga-beacon)
