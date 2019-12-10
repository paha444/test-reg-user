<?php if (!defined('TEST_SITE')) exit('No direct script access allowed.');

if(!empty($this->CheckRegData)){
    $this->active_reg='active';
}else{
    $this->active_login='active';
} 
    
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
    
<title>Reg-Form</title>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />



<link rel="stylesheet" href="/views/<?php echo $this->config['template'] ?>/css/style.css">


<script type="text/javascript" src="/views/<?php echo $this->config['template'] ?>/js/jquery-1.9.1.min.js"></script>  

<script type="text/javascript" src="/views/<?php echo $this->config['template'] ?>/js/jquery.maskedinput.js"></script>  

<script type="text/javascript" src="/views/<?php echo $this->config['template'] ?>/js/scripts.js"></script>  
    
</head>

<body>

<div class="lang">
    <?php $this->get_lang_block(); ?>
</div>


<?php 

if($this->status_auth){

    $this->LoadTemplate('personal_area');
    
}else{ 

    $this->LoadTemplate('forms');

} ?>

<div class="system_message"><?php $this->messages() ?></div>


</body>
</html>
