<?php

require_once __DIR__ . '/../autoRequireClass.php';

//PDO Connection
$dsn = 'mysql:host=localhost;dbname=buysupermarket';
$userDB = 'root';
$passDB = '';
$pdoConn = new PDOConnection($dsn, $userDB, $passDB);

//ConnectionDB
$connectionDB = new ConnectionDB($pdoConn);

//Connect to Database
$connectionDB->connect();
