<?php
// online
$db['db_host'] = "us-cdbr-iron-east-01.cleardb.net";
$db['db_user'] = "b24a3bade5ae0c";
$db['db_pass'] = "baeb3bdf";
$db['db_name'] = "heroku_545ac9ca6d8db43";

// dev
//$db['db_host'] = "localhost";
//$db['db_user'] = "root";
//$db['db_pass'] = "root";
//$db['db_name'] = "planqua";


foreach($db as $key => $value){
    define(strtoupper($key), $value);
}

try{
    $connection = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
}catch(Exception $e){
   exit('Failed to connect to database!');
}


function pdo_connect_mysql(){
    try {
    	return new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8', DB_USER, DB_PASS);
    } catch (PDOException $exception) {
    	exit('Failed to connect to database!');
    }
}