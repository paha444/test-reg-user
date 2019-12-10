<?php 
session_start();       //создаем сессию
define('TEST_SITE', TRUE);   // создаем константу для запрета запуска *.php файлов напрямую.

// подключаем основной класс и модель

include_once('controllers/site.php');  
include_once('models/main_models.php'); 

// создаем основной объект

$Site = new Site;




    
?>