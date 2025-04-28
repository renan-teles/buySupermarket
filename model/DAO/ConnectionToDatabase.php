<?php

require_once __DIR__ . '/../autoRequireClass.php';
require_once __DIR__ . '/hostdb.php';

//PDO Connection
$dsn = "mysql:host=$databaseHost; dbname=$databaseName";
$userDB = 'root';
$passDB = '';
$pdoConn = new PDOConnection($dsn, $userDB, $passDB);

//ConnectionDB
$connectionDB = new ConnectionDB($pdoConn);

//Connect to Database
$connectionDB->connect();