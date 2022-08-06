<?php

//username
define('MYSQL_USER','root');
//password
define('MYSQL_PASSWORD','');
//host
define('MYSQL_HOST','localhost');
//databasename
define('MYSQL_DATABASE','blog_system');

$pdoOptions = array(
    PDO::ATTR_ERRMODE =>PDO::ERRMODE_EXCEPTION,
);

//Connetion code

$pdo = new PDO(
    'mysql:host='.MYSQL_HOST.';dbname='.MYSQL_DATABASE,
    MYSQL_USER,MYSQL_PASSWORD,
    $pdoOptions
);

?>