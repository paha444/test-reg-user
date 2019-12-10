<?php if (!defined('TEST_SITE')) exit('No direct script access allowed.'); ?>

<div class="wrapper">
    
    <div class="left">
        
        <?php if( $this->params['image']){ ?>
        <div class="user_image">
            <img src="/images/avatars/<?php echo $this->params['image']; ?>"/>
        </div>
        <?php } ?>
        
        <form method="POST">
        <input name="hash" type="hidden" value="<?php echo $_SESSION['hash'] ?>"><br>
        <input type="hidden" name="oper" value="logout"/> 
        <input name="submit" type="submit" value="<?php $this->get_text('Exit'); ?>">
        </form>    
    
    </div>
    
    <div class="right">
        

  <h1><?php $this->get_text('text_1',$this->params['name']); ?></h1>  


  <form action="<?php $this->Router() ?>" id="user_info" name="user_info" method="post" enctype="multipart/form-data"> 

      <div>
        <input class="user-input" type="text" name="login" id="login" value="<?php echo $this->params['login']; ?>" 
        placeholder="<?php $this->get_text('login'); ?>*" disabled="disabled" />
        <?php //echo $this->CheckRegData['login']; ?>
      </div> 

      <div>
        <label class="lock" for="password"></label>
        <input type="password" name="password" id="password" value="" placeholder="<?php $this->get_text('password'); ?>*" />
      </div>
      
      <div>
        <input type="password" name="password2" id="password2" value="" placeholder="<?php $this->get_text('password2'); ?>*" />
        <?php echo $this->CheckUpdateData['password2']; ?>
      </div>
      

      <div>
        <input class="user-input" type="text" name="email" id="email" value="<?php echo $this->params['email']; ?>" placeholder="<?php $this->get_text('Email'); ?>*" required />
        <?php echo $this->CheckUpdateData['email']; ?>
      </div> 

      <div>
        <label class="user" for="text"></label>
        <input class="user-input" type="text" name="name" id="name" value="<?php echo $this->params['name']; ?>" placeholder="<?php $this->get_text('Name'); ?>" />
      </div> 


      <div>
        <input class="user-input" type="text" name="phone" id="phone" value="<?php echo $this->params['phone']; ?>" placeholder="<?php $this->get_text('Phone'); ?>" />
      </div> 

      <div>
        <textarea class="user-input" name="dop_info" id="dop_info" placeholder="<?php $this->get_text('dop_info_pl_txa'); ?>"><?php echo $this->params['dop_info']; ?></textarea>
      </div> 

      <div>
      <fieldset>
        <label><?php $this->get_text('your_image'); ?></label>
        <input type="file" name="image"/>
      </fieldset>  
      </div> 
       
     <div>
      <input type="hidden" name="oper" value="update_user"/>  
      <input name="submit" type="submit" value="<?php $this->get_text('update_bt'); ?>" />
     </div>

      <div class="clear"></div>
  </form>



        
    </div>

</div>