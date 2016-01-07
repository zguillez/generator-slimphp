# generator-slimphp

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

# Contributing and issues
Contributors are welcome, please fork and send pull requests! If you have any ideas on how to make this project better then please submit an issue or send me an [email](mailto:mail@zguillez.io).

# License
©2015 Zguillez.io

Original code licensed under [MIT](https://en.wikipedia.org/wiki/MIT_License) Open Source projects used within this project retain their original licenses.

# Changelog
## v0.1.0 (January 7, 2016)
Initial Slim Framework skeleton

Features:

* Slimframework
* External route files
* Grunt tasks
