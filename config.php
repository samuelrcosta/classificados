<?php
require 'environment.php';
$config = array();
if(ENVIRONMENT == 'development'){
    define("BASE_URL", 'http://localhost/php/classificados_mvc');
    $config['dbname'] = 'classificados';
    $config['host'] = 'localhost';
    $config['dbuser'] = 'root';
    $config['dbpass'] = 'root';
} else{
    define("BASE_URL", 'http://halfpet.com/mvc');
    $config['dbname'] = 'id880758_teste123';
    $config['host'] = 'localhost';
    $config['dbuser'] = 'id880758_samuel';
    $config['dbpass'] = 'costa123';
}

global $db;
try {
    $db = new PDO("mysql:dbname=".$config['dbname'].";host=".$config['host'].";charset=utf8", $config['dbuser'], $config['dbpass']);
}catch (PDOExeption $e){
    echo "ERRO: ".$e->getMessage();
}