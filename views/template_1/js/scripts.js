
$(document).ready(function()
{
 
      $("#phone").mask("8(999) 999-9999");  


      $('.login,.registration').click(function(){
        
          $('.sign h3').toggleClass('active');
          
          if($(this).hasClass('active')){}else{
          
          $('.login,.registration').removeClass('active');
            
          $(this).addClass('active');
            
          $( "form#login_form,form#registration_form" ).slideToggle( "slow", function() {});
        
          }  
        
      });  
      
      

    
});


