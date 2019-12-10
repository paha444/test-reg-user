<?php if (!defined('TEST_SITE')) exit('No direct script access allowed.');

$this->config = array(
    
    // настройки подключения к БД
    "host"   => "localhost",     // хост
    "dbname" => "test-reg-user", // имя БД
    "uname"  => "invest",        // логин
    "upass"  => "invest",        // пароль
    
    
    
    
    //параметры(по умолчанию)
    "solt"   => "keyasdac235tgw", // соль, добавляется для создания и шифрования пароля и каптчи
    "template" => "template_1" // название папки шаблона в папке views
);

?>