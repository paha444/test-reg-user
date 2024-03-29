<?php if (!defined('TEST_SITE')) exit('No direct script access allowed.');   // проверка на запуск файла с нашего сайта а не напрямую.


class Site
{
 
// объявляем основные свойства.

public $db;    
public $status_auth;    
public $user;
public $params;
public $site_url;
public $languages;
public $lang;
public $Reg;
public $CheckRegData;
public $CheckUpdateData;
public $FormRegData;



public $captha_queshions;
public $captha_code;
public $active_reg;
public $active_login;
public $config;
public $message;
public $active_lang;

/////////


function __construct() {

    ////////// в этом конструкторе выполняються все основные функции./////////////////
    /////////////////////////////////////////////////////////////////////////////////
   
    $this->getConfig();  // получаем конфиг с настройками
    $this->db = $this->getDB(); // подключаемся к БД

   
    $this->status_auth = 0; // статус пользователя по умолчанию 0, если авторизован становится 1.

    
    $this->get_lang(); // подключаем языковые файлы
    $this->get_captcha(); // подключаем картчу
    $this->CheckAuth(); // проверяем авторизован пользователь или нет
    
    $this->Opers(); // обработка операций в формах метод POST
    
    $this->View(); // подключаем шаблон
    
}

function CheckAuth(){
    Models::CheckAuth();
}


function Opers(){
    
   
    if(isset($_POST['submit'])){
    
        switch ($_POST['oper']) {
             case "login":
                 Models::Auth();
                 break;
             case "registration":
                 Models::Register();
                 break;
             case "logout":
                 Models::User_exit();
                 break;
             case "update_user":
                 Models::Update_user();
                 break;
        }
        
    }

    
}


function getConfig(){
    
    include_once('includes/config.php');
    
}

   
function getDB(){
    
// MySQL hostname
$host = $this->config['host'];
//MySQL basename
$dbname = $this->config['dbname'];
// MySQL user
$uname = $this->config['uname'];
// MySQL password
$upass = $this->config['upass'];

$link_db = @mysqli_connect($host, $uname, $upass);
if(!$link_db) exit('Нет подключения к БД');

            mysqli_select_db($link_db,$dbname);
            mysqli_set_charset($link_db, "utf8");


return $link_db;
    
}




function generateCode($length=6) {

    $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHI JKLMNOPRQSTUVWXYZ0123456789";

    $code = "";

    $clen = strlen($chars) - 1;  
    while (strlen($code) < $length) {

            $code .= $chars[mt_rand(0,$clen)];  
    }

    return $code;

}
   

function get_lang_block(){
    
    switch ($_SESSION['lang']) {
         case "ru":
             echo '<a href="/ru" class="active">RU</a><a href="/en">EN</a>';
             break;
         case "en":
             echo '<a href="/ru">RU</a><a href="/en" class="active">EN</a>';
             break;
         default:
             echo '<a href="/ru" class="active">RU</a><a href="/en">EN</a>';
             break;        
    }
    


    
}

/// этод метод использую в формах в параметре "action" для добавления текущего языка в url.

function Router(){
    
    
    $url = $_SERVER['REQUEST_URI'];
    $q = explode('/',$url);
    $lang = $q[1];
    
    if($lang){
    
        $r = "/".$lang.'/';
    
    }else{
        
        $r = "/ru/";
        
    }
    
    echo $r;
    
}



function get_lang(){
    

    $url = $_SERVER['REQUEST_URI'];
    $q = explode('/',$url);
    
    $lang = $q[1];
    

     
     if($lang!=''){
         
         $_SESSION['lang'] = $lang;
         
         $this->active_lang = $lang;
         
     }
     
 
     switch ($this->active_lang) {
     
         case "ru":
             include_once('languages/ru.php'); 
             break;
         case "en":
             include_once('languages/en.php'); 
             break;
         default:
             include_once('languages/ru.php'); 
             break;
     
     }
    
   
}

function Messages(){
    
    echo '<p>'.$this->message.'</p>';
    
}

// загрузка основного шаблона

function view(){
    include_once('views/'.$this->config['template'].'/index.php');
}



//подгрузка подшаблонов

function LoadTemplate($string){

    if(!@file_exists('views/'.$this->config['template'].'/tmpl/'.$string.'.php') ) {
        echo 'can not include';
    } else {
       include('views/'.$this->config['template'].'/tmpl/'.$string.'.php');
    }

}



///////// эти 2 функции выводят нужные тексты на нужном языке.

function get_text($string,$param_1=''){
    
    if(isset($this->languages[$string])){
        
        echo sprintf($this->languages[$string],$param_1);
        
    }else{
        echo $string;    
    }
}


function get_text_m($string,$param_1=''){
    
    if(isset($this->languages[$string])){
        
        return $this->languages[$string];

    }else{
        return $string;    
    }
}

////////////////






///// простая каптча  

function get_captcha(){

        // подгружаем файл с активным языком
     switch ($this->active_lang) {
     
         case "ru":
             include_once('includes/captcha_ru.php');  
             break;
         case "en":
             include_once('includes/captcha_en.php');  
             break;
         default:
             include_once('includes/captcha_ru.php');  
             break;
     
     }

    
    
    
    shuffle($this->captcha_queshions); //перемешиваем массив, чтобы вопрос был разным
    
    $this->captcha = $this->captcha_queshions[rand(0,count($this->captcha_queshions)-1)]; //берем вопрос каптчи
    
    $this->captcha_code = md5($this->captcha['answer'].$this->config['solt']); //берем ответ каптчи шифруем его в md5 и добавляем соли.
    
}








}



?>

                 













                                                                                                                                                                       