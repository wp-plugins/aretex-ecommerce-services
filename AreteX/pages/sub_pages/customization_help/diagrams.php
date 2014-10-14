<div class="section group"> <!-- ROW -->
        <div class="col span_1_of_12"> <!-- Column -->
    </div> <!-- END Column -->
    <div class="col span_10_of_12"> <!-- Column -->
        <h4>CSS Diagrams</h4>
    <p>The purpose of the CSS diagrams is to make it easier for web designers to see how the CSS  
    classes and element tags from the notification style sheets are mapped to the HTML of the 
    various customer notifications. Select the specific notification document in the menu below to 
    see the mapping diagrams for your selection.
    </p>
    
    <nav>
    <div class="ui-widget ui-widget-header ui-corner-all" style=" padding: 5px;">
    
    
    
    
    <div class="sub-menu-button-set">
        <button id="receipt_diagrams" class="sub_menu_button icon_left_button ui-button"><span class="ui-icon ui-icon-tag"></span>Receipts</button>
        
        <button id="confirmation_diagrams" class="sub_menu_button icon_left_button ui-button"><span class="ui-icon ui-icon-circle-check"></span>Confirmation</button>
    
        <button id="cancellation_diagrams" class="sub_menu_button icon_left_button ui-button"><span class="ui-icon ui-icon-cancel"></span>Cancellation</button>    
    
        <button id="welcome_diagrams" class="sub_menu_button icon_left_button ui-button"><span class="ui-icon ui-icon-mail-closed"></span>Welcome/Account</button>
       
       <button id="pending_diagrams" class="sub_menu_button icon_left_button ui-button"><span class="ui-icon ui-icon-calendar"></span>Notice of Pending Charge</button>

    </div>
    
    
    
    
    </div>
    </nav>

    </div> <!-- END Column -->
</div> <!-- END ROW --><div class="section group"> <!-- ROW -->
    <div class="col span_12_of_12"> <!-- Column -->
    

    <div id="diagram_content" class="ui-widget ui-widget-content  ui-corner-all" >

    </div>
    
    </div> <!-- END Column -->
</div> <!-- END ROW -->

<script>
jQuery('.sub-menu-button-set').buttonset();
jQuery('button.sub_menu_button').click(
            function() { load_diagram_help_content(this); }
         );


 function load_diagram_help_content(element)
 {
    
    load_diagram_help_page(element.id);
    
 }
 
 function load_diagram_help_page(screen_id){
    jQuery(function ($) {                
    	
        var screen_path = 'customization_help/'+screen_id;
        
        $('#diagram_content').html('<p style="text-align:center;">...Please Wait...</p>');               
        var data = {
		action: 'load_screen',
        plugin: 'ecommerce-services',
        screen: screen_path
	   };
        	
    	$.post(ajaxurl, data, function(response) {
    	   $('#diagram_content').html(response);
    	});
        
    
    });  
}
        
</script>