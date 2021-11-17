<?php
ini_set('display_errors', 'On');
error_reporting(E_ALL);
header('Cache-Control: no cache');
require_once "functions/db.php";
require_once "functions/query.php";
session_start();

if(isMobile()){
    echo "";
}
else {
    die;
}


?>