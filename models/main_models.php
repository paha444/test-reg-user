<?php if (!defined('TEST_SITE')) exit('No direct script access allowed.');

/*

 Данный класс расширяет основной класс, этот класс содержит в себе методы для работы с БД,
 и методы проверки корректности введенных данных из форм.
 
 
 
 Названия методов интуитивно понятны.
   
    CheckRegData - проверка формы регистрации нового пользователя
    Register - регистрации нового пользователя
    Auth - авторизация нового пользователя
    CheckUpdateData - проверка формы обновления данных авторизованного пользователя, в личном кабинете.
    Update_user - обновления данных авторизованного пользователя, в личном кабинете.
    CheckAuth - проверка авторизован пользователь или нет.
    User_exit - выход
 */



abstract class Models extends Site
{
    



function CheckRegData(){
    
    
    $message = array();


    $query = mysqli_query($this->db,"SELECT * FROM `users` WHERE login='".mysqli_real_escape_string($this->db,$_POST['login'])."' LIMIT 1");
    $result = mysqli_fetch_assoc($query);
    
    if($result){
        $message['login'] = "<p>".$this->get_text_m('text_11')."</p>";
    }
    
    if($_POST['password']!=$_POST['password2']){
        $message['password2'] = "<p>".$this->get_text_m('text_8')."</p>";
    }
    
     
    $email = $_POST['email'];
    
    
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {

        $query = mysqli_query($this->db,"SELECT * FROM `users` WHERE email='".mysqli_real_escape_string($this->db,$_POST['email'])."' LIMIT 1");
        $result2 = mysqli_fetch_assoc($query);

        if($result2){
            $message['email'] = "<p>".$this->get_text_m('text_9')."</p>";
        }
        
    
    
    }else{
        $message['email'] = "<p>".$this->get_text_m('text_10')."</p>";
    }
    
    
    if(empty($_POST['captcha'])){
        
        $message['captcha'] = "<p>".$this->get_text_m('text_12')."</p>"; 
        
    }else{
    

        if($_POST['captcha_code']!=md5($_POST['captcha'].$this->config['solt'])){
            
            $message['captcha'] = "<p>".$this->get_text_m('text_13')."</p>";    
            
        }
    
    }

    if(empty($message)){
        return true;
    }else{
        return $message;
    }
    
    
}




function Register(){

     $this->FormRegData = $_POST;
     
     $result = Models::CheckRegData();
     
     //print_r($result);
     
     if(!is_array($result)){

            $login = mysqli_real_escape_string($this->db,$_POST['login']);
            
            $password = md5($_POST['password'].$this->config['solt']);
            
            $password_db = mysqli_real_escape_string($this->db,$password);
            
            $email = mysqli_real_escape_string($this->db,$_POST['email']);
            $name = mysqli_real_escape_string($this->db,$_POST['name']);
            $phone = mysqli_real_escape_string($this->db,$_POST['phone']);
            $dop_info = mysqli_real_escape_string($this->db,$_POST['dop_info']);
            
            
            
            $path = 'images/avatars/';
            
            $image_info = pathinfo($_FILES['image']['name']);
            
            $new_filename = md5(microtime() . rand(0, 9999)).'.'.$image_info['extension'];
            
            //print_r($path_parts);
            
             if (@copy($_FILES['image']['tmp_name'], $path . $new_filename)){
                $image_name = $new_filename;
             }
            
        
        
            $sql = "INSERT INTO `users` (`login`,`password`,`email`,`name`,`phone`,`dop_info`,`image`) 
                    VALUES ('$login','$password_db','$email','$name','$phone','$dop_info','$image_name')";
            
            //echo $sql;
                    
            if(mysqli_query($this->db,$sql)){
                
                $this->message = '<span class="green">'.$this->get_text_m('text_5').'</span>';   
                
            }
            
                    
        
        
     }else{
        $this->message = '<span class="red">'.$this->get_text_m('text_6').'</span>';
        
        $this->CheckRegData = $result;
        
        
     }
     

}

  
   
    
    function Auth(){
        
    
        $query = mysqli_query($this->db,"SELECT * FROM `users` WHERE login='".mysqli_real_escape_string($this->db,$_POST['login'])."' LIMIT 1");
    
        $data = mysqli_fetch_assoc($query);
        
        $this->user = $data;
    
        if($data['password'] === md5($_POST['password'].$this->config['solt']))
    
        {
    
            $hash = md5($this->generateCode(10));
    
            mysqli_query($this->db,"UPDATE `users` SET hash='".$hash."' WHERE id='".$data['id']."'");
    
            
            $_SESSION['id']=$data['id'];
            $_SESSION['hash']=$hash;
            
                echo'
                    <script language="JavaScript"> 
                    window.location.href = "'.$_SERVER['HTTP_REFERER'].'"
                    </script>
                ';  
    
        }
    
        else
    
        {
    
            $this->message = '<span class="red">'.$this->get_text_m('text_7').'</span>';
    
        }
    
    
    }    
    
    
    


function CheckUpdateData(){
    
    //print_r($_POST);
    
    $message = array();

    
    if($_POST['password']!=$_POST['password2']){
        $message['password2'] = "<p>".$this->get_text_m('text_8')."</p>";
    }
     
    $email = $_POST['email'];
    
    
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {

        $query = mysqli_query($this->db,"SELECT * FROM `users` WHERE email='".mysqli_real_escape_string($this->db,$_POST['email'])."' AND id!='".$_SESSION['id']."' LIMIT 1");
        $result2 = mysqli_fetch_assoc($query);

        if($result2){
            $message['email'] = "<p>".$this->get_text_m('text_9')."</p>";
        }

    }else{
        $message['email'] = "<p>".$this->get_text_m('text_10')."</p>";
    }
    

    if(empty($message)){
        return true;
    }else{
        return $message;
    }
    
    
}



function Update_user(){
    
     $this->FormUpdateData = $_POST;
     
     $result = Models::CheckUpdateData();
     
     
     if(!is_array($result)){

           
            if(!empty($_POST['password']) and !empty($_POST['password2'])){            
                $password = md5($_POST['password'].$this->config['solt']);
                $password_db = mysqli_real_escape_string($this->db,$password);
                
                $set_password = "`password`='$password_db',";
            }
            
            $email = mysqli_real_escape_string($this->db,$_POST['email']);
            
            $name = mysqli_real_escape_string($this->db,$_POST['name']);
            $phone = mysqli_real_escape_string($this->db,$_POST['phone']);
            $dop_info = mysqli_real_escape_string($this->db,$_POST['dop_info']);
            
            
            
            if(isset($_FILES['image'])){
            
                $path = 'images/avatars/';
                
                $image_info = pathinfo($_FILES['image']['name']);
                
                $new_filename = md5(microtime() . rand(0, 9999)).'.'.$image_info['extension'];
                
                //print_r($path_parts);
                
                 if (@copy($_FILES['image']['tmp_name'], $path . $new_filename)){
                    //$image_name = $new_filename;
                    
                    $set_image = ",`image`='$new_filename'";
                 }
            
            
            }
        
        
            $sql = "UPDATE `users` SET $set_password `email`='$email',`name`='$name',`phone`='$phone',`dop_info`='$dop_info' $set_image WHERE id='".$_SESSION['id']."'";
                    
            if(mysqli_query($this->db,$sql)){
                
                //echo $this->get_text('text_2');
                
                $this->message = '<span class="green">'.$this->get_text_m('text_2').'</span>';   
                
                Models::CheckAuth();

            }


     }else{
        $this->message = '<span class="red">'.$this->get_text_m('text_3').'</span>';
        
        $this->CheckUpdateData = $result;
        
     }

    
}



function CheckAuth(){

    

    if (isset($_SESSION['id']) and isset($_SESSION['hash']))
    
    {   
    
        $query = mysqli_query($this->db,"SELECT * FROM `users` WHERE id = '".intval($_SESSION['id'])."' LIMIT 1");
    
        $userdata = mysqli_fetch_assoc($query);
    
    
        if(($userdata['hash'] !== $_SESSION['hash']) or 
        ($userdata['id'] !== $_SESSION['id']))
    
        {
    
            $this->message = "<span class='red'>".$this->get_text_m('text_4')."</span>";
    
        }
    
        else
    
        {
            
            $this->status_auth = 1;
            $this->params =$userdata;
            
    
        }
    
   
    }




}



function User_exit() { 	


    if(isset($_POST['submit']) && isset($_POST['hash']))
    
    {    
    
        if($_POST['hash'] == $_SESSION['hash'])
        
        {
            unset($this->user);
            
            $id = $_SESSION['id'];			 	
            
            mysqli_query($this->db,"UPDATE `users` SET hash='' WHERE id='".$id."'");
            
            unset($_SESSION['id']); //удаляем переменную сессии 
            unset($_SESSION['hash']); //удаляем переменную сессии 
            
            echo'
                <script language="JavaScript"> 
                window.location.href = "'.$_SERVER['HTTP_REFERER'].'"
                </script>
            ';
            
        }
    
    
    }

}

    
    
    
    
}

   
?>