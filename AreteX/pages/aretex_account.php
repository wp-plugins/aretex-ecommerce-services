<?php
  $dir = plugin_dir_path( __FILE__ );
    include($dir.'account_pages/top_menu.php');
?>
<div class="section group"> <!-- ROW -->
    <div class="col span_11_of_12"> <!-- Column -->

<div class="ui-widget-header ui-corner-top" >
<h2 style="text-align: center; margin-top: 5px; margin-bottom: 5px;">AreteX&trade; Account Management</h2>
</div>
<div class="ui-widget ui-widget-content  ui-corner-bottom container" >
<div id="main_content">

<?php include($dir.'account_pages/home.php'); ?>

</div>
</div>    
    </div> <!-- END Column -->
</div> <!-- END ROW -->

<script>
 
 function load_act_content(element)
 {

    load_act_page('account_pages/'+element.id);
    
 }
 
jQuery(document).ready(function() {
jQuery('.menu').menu();
jQuery('.menu').hide();
jQuery('.button-set').buttonset();

jQuery('a.menu_item').click(
            function() { load_act_content(this); }
         ); 

jQuery('button.menu_button').click(
            function() { load_act_content(this); }
         );

        
 });
 
    function init_buttons()
    {
        jQuery('.button-set').buttonset();

        jQuery('a.menu_item').click(
                    function() { load_act_content(this); }
                 ); 
        
        jQuery('button.menu_button').click(
                    function() { load_act_content(this); }
                 );
    } 

    function load_act_page(page_name) {
        jQuery(function ($) {                
    	
        $('#main_content').html('<p style="text-align:center;">...Please Wait...</p>');               
        var data = {
		action: 'load_screen',
       plugin: 'aretex-main',
        screen: page_name
	   };
        
        console.log(page_name);  	
    	$.post(ajaxurl, data, function(response) {
    	   $('#main_content').html(response);
    	});
        
    
    });  
    }    

function submit_act_info(form_id)
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
		      action: 'atx_updatebsucontact',
              data: q 
	          },              
              success: function(data){
                                
                load_act_page('account_pages/contact');
              },
              error: function(xhr, type, exception) {
               
                // if ajax fails display error alert
               // alert("ajax error response type "+type);
                 alert('There was a problem submitting your information.\nPlease be sure all fields are correct when you try again.\nYou may need to enter a different bank account.');
                 load_act_page('account_pages/contact');
              }
            });
        }
    
    });
 }      
 
 
 </script> 