<?php if (!defined('TEST_SITE')) exit('No direct script access allowed.'); ?>

<div class="forms">
  
  <div class="header">
   
    <div class="button registration <?php echo $this->active_reg; ?>">
      <?php $this->get_text('register'); ?>
    </div>
    <div class="button login <?php echo $this->active_login; ?>">
      <?php $this->get_text('authorization'); ?>
    </div>

  
    <div class="sign">
        <h3 class="sign-in-reg <?php echo $this->active_reg; ?>"><?php $this->get_text('Sign_in_reg'); ?></h3>
        <h3 class="sign-in <?php echo $this->active_login; ?>"><?php $this->get_text('Sign_in'); ?></h3>
    </div>

  </div>
  
  <div class="clear"></div> 
   
  <form action="<?php $this->Router() ?>" id="login_form" class="<?php echo $this->active_login; ?>" name="login" method="post">
      <div>
        <label class="user" for="text"></label>
        <input class="user-input fa-user" type="text" name="login" id="login" placeholder="<?php $this->get_text('login'); ?>" required />
      </div> 
      <div>
        <label class="lock" for="password"></label>
        <input type="password" name="password" id="password" placeholder="<?php $this->get_text('password'); ?>" required />
      </div> 
     <div>
      <input type="hidden" name="oper" value="login"/>  
      <input name="submit" type="submit" value="<?php $this->get_text('Sign_in_bt'); ?>" />
    </div>

      <div class="clear"></div>
  </form>  
  
  
  <form action="<?php $this->Router() ?>" id="registration_form" class="<?php echo $this->active_reg; ?>" name="registration" method="post" enctype="multipart/form-data"> 

      <div>
        <input class="user-input" type="text" name="login" id="login" value="<?php echo $this->FormRegData['login']; ?>" placeholder="<?php $this->get_text('login'); ?>*" required />
        <?php echo $this->CheckRegData['login']; ?>
      </div> 

      <div>
        <label class="lock" for="password"></label>
        <input type="password" name="password" id="password" value="<?php echo $this->FormRegData['password2']; ?>" placeholder="<?php $this->get_text('password'); ?>*" required />
      </div>
      
      <div>
        <input type="password" name="password2" id="password2" value="<?php echo $this->FormRegData['password2']; ?>" placeholder="<?php $this->get_text('password2'); ?>*" required />
        <?php echo $this->CheckRegData['password2']; ?>
      </div>
      

      <div>
        <input class="user-input" type="text" name="email" id="email" value="<?php echo $this->FormRegData['email']; ?>" placeholder="<?php $this->get_text('Email'); ?>*" required />
        <?php echo $this->CheckRegData['email']; ?>
      </div> 

      <div>
         <label class="user" for="text"></label>
        <input class="user-input" type="text" name="name" id="name" placeholder="<?php $this->get_text('Name'); ?>" />
      </div> 

      <div>
        <input class="user-input" type="text" name="phone" id="phone" placeholder="<?php $this->get_text('Phone'); ?>" />
      </div> 

      <div>
        <textarea class="user-input" name="dop_info" id="dop_info" placeholder="<?php $this->get_text('dop_info_pl_txa'); ?>"></textarea>
      </div> 

      <div>
      <fieldset>
        <label><?php $this->get_text('your_image'); ?>*</label>
        <input type="file" name="image" required/>
      </fieldset>  
      </div> 
      
      <div>
      <fieldset>
        <label><?php $this->get_text('spam_protection'); ?> *</label>
        <p class="captcha_queshion"><?php $this->get_text('how_much_will'); ?> (<?php echo $this->captcha['queshion'] ?>)? (<span class="style_1"><?php $this->get_text('in_numbers'); ?></span>)</p>
        <input class="user-input" type="text" name="captcha" id="captcha" placeholder="<?php $this->get_text('captcha'); ?>" required/>
      </fieldset>
        <?php echo $this->CheckRegData['captcha']; ?>
      </div> 
      
     <div>
      
      <input type="hidden" name="captcha_code" value="<?php echo $this->captcha_code ?>"/>  
     
      <input type="hidden" name="oper" value="registration"/>  
      <input name="submit" type="submit" value="<?php $this->get_text('reg_bt'); ?>" />
    </div>

      <div class="clear"></div>
  </form>
  
</div>