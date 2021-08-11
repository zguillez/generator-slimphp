<?php
$config = parse_ini_file(__DIR__ . '/../config.ini');
$servername = $config['database']['host'];
$username = $config['database']['username'];
$password = $config['database']['password'];
$dbname = $config['database']['dbname'];
$folder = $config['ssh']['folder'];
$api->database($servername, $username, $password, $dbname);
$api->folder($folder);
