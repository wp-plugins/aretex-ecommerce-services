<?php
  $dir = plugin_dir_path( __FILE__ );
    include($dir.'sub_pages/reports/top_menu.php');
?>
<div class="section group"> <!-- ROW -->
    <div class="col span_11_of_12"> <!-- Column -->

<div class="ui-widget-header ui-corner-top" >
<h2 style="text-align: center; margin-top: 5px; margin-bottom: 5px;">Reports &amp; Management</h2>
</div>
<div class="ui-widget ui-widget-content  ui-corner-bottom container" >
<div id="main_content">

<?php include(plugin_dir_path(__FILE__).'sub_pages/reports/overview.php'); ?>

</div>
</div>    
    </div> <!-- END Column -->
</div> <!-- END ROW -->
<script>
jQuery('.button-set').buttonset();

jQuery('button.menu_button').click(
            function() { load_content(this); }
         );

 function load_content(element)
 {
    if (element.id != 'delivery_log'  && element.id != 'pending_deliveries') {
         jQuery('#deliveries_menu').hide();
    }
    load_content_screen('reports/'+element.id);
 
   
    
 }
 
    function aretex_dbui_Manage(config_id,dbui_url,target_div,row_id,auth,call_back) {

        
        load_linked_div_page('reports/cam/manage',row_id,'#inner_form');
    }
    

  function aretex_dbui_Manage_Delivery(config_id,dbui_url,target_div,row_id,auth,call_back) {

        
        load_linked_div_page('reports/deliveries/manage',row_id,'#inner_form');
  }
  
  
  function load_linked_div_page(page_name,linked_id,div) {
        jQuery(function ($) {                
    	
        $(div).html('<p style="text-align:center;">...Please Wait...</p>');               
        var data = {
		action: 'load_screen',
        plugin: 'ecommerce-services',
        screen: page_name,
        linked_id: linked_id
	   };
        
        
    	$.post(ajaxurl, data, function(response) {
    	   $(div).html(response);
    	});
        
    
    });
    
      
    }      
    

function load_linked_cam_page(page_name,linked_id) {
        jQuery(function ($) {                
    	
        $('#cam_content').html('<p style="text-align:center;">...Please Wait...</p>');               
        var data = {
		action: 'load_screen',
        plugin: 'ecommerce-services',
        screen: page_name,
        linked_id: linked_id
	   };
        
        	
    	$.post(ajaxurl, data, function(response) {
    	   $('#cam_content').html(response);
    	});
        
    
    });  
    } 
    
function load_payee_mgm_screen(base_name)
{
    var full_screen = 'reports/payees/'+base_name;
    load_div_screen(full_screen,'#detail_screen');
}
         
</script>