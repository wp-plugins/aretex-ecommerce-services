<?php
global $business_name;
$license = AreteX_WPI::getBasLicense();
$business_name = $license->Business_Name;
?>

<div class="dbui-frame" style="padding: 10px;" > 

<h2><?php echo $business_name; ?> Customer Account Management</h2>
<em></a>Powered by AreteX&trade; eCommerce Services</em>
<?
/*
    Is this Customer Reigstered with AreteX?
       No:
          
*/



$customer_id  = AreteX_WPI::customerSignedUp();


if ($customer_id) {
    $dir = plugin_dir_path( __FILE__ );
    include($dir.'pages/top_menu.php');
}
?>

<div id="main_content">

<?   


    if ($customer_id) {
        include($dir.'pages/home.php');
    }
    else {
        include($dir.'pages/notsignedup.php');
    }


?>
</div>
</div>
 <script>
 
 function load_cam_content(element)
 {
    
    load_cam_page(element.id);
    
 }
 
jQuery(document).ready(function() {
jQuery('.menu').menu();
jQuery('.menu').hide();
jQuery('.button-set').buttonset();

jQuery('a.menu_item').click(
            function() { load_cam_content(this); }
         ); 

jQuery('button.menu_button').click(
            function() { load_cam_content(this); }
         );

        
 });
 
    function init_buttons()
    {
        jQuery('.button-set').buttonset();

        jQuery('a.menu_item').click(
                    function() { load_cam_content(this); }
                 ); 
        
        jQuery('button.menu_button').click(
                    function() { load_cam_content(this); }
                 );
    } 

    function load_cam_page(page_name) {
        jQuery(function ($) {                
    	
        $('#main_content').html('<p style="text-align:center;">...Please Wait...</p>');               
        var data = {
		action: 'load_screen',
        plugin: 'cam',
        screen: page_name
	   };
        
        console.log(page_name);  	
    	$.post(ajaxurl, data, function(response) {
    	   $('#main_content').html(response);
    	});
        
    
    });  
  }
  
   function load_linked_cam_page(page_name,linked_id) {
        jQuery(function ($) {                
    	
        $('#main_content').html('<p style="text-align:center;">...Please Wait...</p>');               
        var data = {
		action: 'load_screen',
        plugin: 'cam',
        screen: page_name,
        linked_id: linked_id
	   };
        
        console.log(page_name);  	
    	$.post(ajaxurl, data, function(response) {
    	   $('#main_content').html(response);
    	});
        
    
    });  
    }      
        
<?php 

global $cam_email;
?>        


function wp_to_cam_email(email)
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
                               
                load_cam_page('home');
              },
              error: function(xhr, type, exception) {
               
                // if ajax fails display error alert
               // alert("ajax error response type "+type);
                 alert('There was a problem submitting your information.');
                 load_cam_page('home');
              }
            });
       
    
    });
 } 

        
function submit_cam_info(form_id)
{
    jQuery(function ($) { 
        $(form_id).validate();
        if ($(form_id).valid())
        {
            
            var q = $(form_id).serialize();
            $('#main_content').html('<p style="text-align:center;">...Please Wait...</p>');
            
        
            $.ajax({
              type: 'POST',
              url: ajaxurl,
              data: {
		      action: 'atx_updatecamcontact',
              data: q 
	          },              
              success: function(data){
                                
                load_cam_page('contact');
              },
              error: function(xhr, type, exception) {
               
                // if ajax fails display error alert
               // alert("ajax error response type "+type);
                 alert('There was a problem submitting your information.\nPlease be sure all fields are correct when you try again.\nYou may need to enter a different bank account.');
                 load_cam_page('contact');
              }
            });
        }
    
    });
 }      
 
function cancel_rebill(rebill_id)
{
    if (confirm('By Canceling this subscription,\nyou will no longer be billed and your access to this product/service will expire.\n\nClick OK to Confirm Your Intent to Cancel.'))
    {
        jQuery(function ($) {                
    	
        $('#main_content').html('<p style="text-align:center;">...Please Wait...</p>');               
        var data = {
		action: 'atx_cancelrebill',
        rebill_id: rebill_id 
	   };
        
       	
    	$.post(ajaxurl, data, function(response) {
    	   load_linked_cam_page('rebill_detail',rebill_id);
    	});
        
    
    });  
    }
}

function load_receipt(url)
{
    jQuery('#main_content').html('<button class="ui-button icon_left_button button_link ui-state-default ui-corner-all" onclick="load_cam_page(\'purchase_history\');"><span class="ui-icon ui-icon-circle-arrow-w"></span>Back</button><hr/><div id="rctp_div"></div>'); 
    jQuery.ajax({
      type: 'GET',
      url: url,
      data: null,
      dataType: 'jsonp',
      success: function(data){
        var full_html = '<em>Note:</em> To print only the receipt (and not this whole page), select "Display Receipt in New Window", then select "Print This Page". ';
        full_html = full_html + '<hr/>' + data;
        jQuery('#rctp_div').html(full_html);
      },
      error: function(xhr, type, exception) { 
        // if ajax fails display error alert
        alert("Ajax Error: Exception: "+exception);
      }
    });
    
    
}
   
    </script>