<div class="dbui-frame" style="padding: 10px;" > 

<h2>AreteX&trade; Payment Tracking And Reporting</h2>
<?
/*
    Is this Payee Reigstered with AreteX?
       No:
          A. Agree to TOC
          B. 
             Complete  ACH Approval
*/
$user_id = get_current_user_id();
$signed_up = AreteX_WPI::payeeSignedUp($user_id);
$_SESSION['current_aretex_payee'] = $signed_up;

$dir = plugin_dir_path( __FILE__ );

if ($signed_up) {
    
    include($dir.'pages/top_menu.php');
}
?>

<div id="main_content">

<?   

    if ($signed_up) {
        $tos = get_user_meta($user_id, 'atx_payee_agree_tos', true);
        if ($tos == 'Yes')
            include($dir.'pages/home.php');
        else
            include($dir.'pages/no_tos.php');
    }
    else {
        include($dir.'pages/notsignedup.php');
    }
?>
</div>
</div>
 <script>
 
 function load_ptr_content(element)
 {
   
    load_ptr_page(element.id);
    
 }
 
jQuery(document).ready(function() {
jQuery('.menu').menu();
jQuery('.menu').hide();
jQuery('.button-set').buttonset();

jQuery('a.menu_item').click(
            function() { load_ptr_content(this); }
         ); 

jQuery('button.menu_button').click(
            function() { load_ptr_content(this); }
         );

        
 });
 
    function init_buttons()
    {
        jQuery('.button-set').buttonset();

        jQuery('a.menu_item').click(
                    function() { load_ptr_content(this); }
                 ); 
        
        jQuery('button.menu_button').click(
                    function() { load_ptr_content(this); }
                 );
    } 

    function load_ptr_page(page_name) {
        jQuery(function ($) {                
    	
        $('#main_content').html('<p style="text-align:center;">...Please Wait...</p>');               
        var data = {
		action: 'load_screen',
        plugin: 'ptr',
        screen: page_name
	   };
        
        console.log(page_name);  	
    	$.post(ajaxurl, data, function(response) {
    	   $('#main_content').html(response);
    	});
        
    
    });  
    }    
<?php 

$ptr_direct_url = AreteX_WPI::ptrAjaxDirect();
$ajax_access_token = AreteX_WPI::ajaxAccessToken('master',true);
$ptr_direct_url = $ptr_direct_url."/index.php?aretex_ajax_auth=".$ajax_access_token;
?>        
        
function submit_info(form_id)
{
    jQuery(function ($) { 
        $(form_id).validate();
        if ($(form_id).valid())
        {
            
            var q = $(form_id).serialize();
            $('#main_content').html('<p style="text-align:center;">...Please Wait...</p>');
            
        
            $.ajax({
              type: 'POST',
              url: '<?php echo $ptr_direct_url; ?>',
              dataType: 'json',
              crossDomain: true,  
              data: q,
              success: function(data){
                
                if (data != 'OK')
                    alert('There was a problem connecting to the server.\nPlease Try Again Later');
                load_ptr_page('ach_auth');
              },
              error: function(xhr, type, exception) {
               
                // if ajax fails display error alert
               // alert("ajax error response type "+type);
                 alert('There was a problem submitting your information.\nPlease be sure all fields are correct when you try again.\nYou may need to enter a different bank account.');
                 load_ptr_page('ach_auth');
              }
            });
        }
    
    });
 }      
 
 function validate_payment_auth()
{
         
     data = jQuery('#form_validate').serialize();
     jQuery.ajax({
      type: 'POST',
      url: '<?php echo $ptr_direct_url; ?>',
      dataType: 'json',
      crossDomain: true,  
      data: data,
      success: function(data){
        // on success use return data here
        if (data == 'OK')
            load_ptr_page('ach_auth');
        else
            alert('Amounts Entered Not Valid \n- Please check your entry\'s format or with your bank for valid entry values');
      },
      error: function(xhr, type, exception) { 
        // if ajax fails display error alert
        alert('Amounts Entered Not Valid \n- Please check your entry\'s format or with your bank for valid entry values');

      }
    });
     
     
}

function wp_to_ptr_email(email)
{
    jQuery(function ($) { 

            
           
            $('#main_content').html('<p style="text-align:center;">...Please Wait...</p>');
            
        
            $.ajax({
              type: 'POST',
              url: ajaxurl,
              dataType: 'json',
              data: {
		      action: 'atx_cam_to_wp',
              email: email, 
	          },              
              success: function(data){
                if (data != 'OK')
                    alert('There was a problem submitting your information.');
                               
                load_ptr_page('home');
              },
              error: function(xhr, type, exception) {
               
                // if ajax fails display error alert
               // alert("ajax error response type "+type);
                 alert('There was a problem submitting your information.');
                 load_ptr_page('home');
              }
            });
       
    
    });
 } 

   
    </script>