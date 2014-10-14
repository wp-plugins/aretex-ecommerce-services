<? $icon_path = plugins_url('../../../../icons/',__FILE__);?>
<h2>Manual Batch</h2>
<div style="padding: 10px;">
    
    <nav>
    <div class="ui-widget ui-widget-header ui-corner-all" style=" padding: 5px;">
    
    
    
    
    <div class="button-set">
        <button id="overview" class="man_bat_menu_button icon_left_button ui-button"><img class="icon_left" src="<?php echo $icon_path.'eye_open_16.png' ?>"/>Overview</button>
        
        <button id="payment_now_due" class="man_bat_menu_button icon_left_button ui-button"><img class="icon_left" src="<?php echo $icon_path.'tax_16.png' ?>"/>Payments Due</button>
        <button id="batches_marked_paid" class="man_bat_menu_button icon_left_button ui-button"><img class="icon_left" src="<?php echo $icon_path.'stamp_16.png' ?>"/>Batches Marked Paid</button>

       
        
    </div>
    

    
    
    </div>
    </nav>
</div>
<div style="padding: 10px;" id="manual_batch_content">

</div>
  
<script>
jQuery('.button-set').buttonset();

jQuery('.man_bat_menu_button') .click(function( event ) {
           var screen = 'reports/payees/manual_batch/'+this.id;
           
           load_div_screen(screen,'#manual_batch_content');
           
            });

load_div_screen('reports/payees/manual_batch/overview','#manual_batch_content');

function man_bat_search() {
    jQuery('#man_bat_search_form').validate();
    if (jQuery('#man_bat_search_form').valid()) {
        
        var duedate = jQuery('#duedate').val();
        var acct_id = jQuery('#payee_acct_id').val();
        
        var data = jQuery('#man_bat_search_form').serialize();
        
       load_man_bat_screen('reports/payees/manual_batch/payment_due_list',data); 
            
        
    }
}

function load_man_bat_screen(screen_id,filter_key){
    jQuery(function ($) {                
    	
        $('#manual_batch_content').html('<p style="text-align:center;">...Please Wait...</p>');               
        var data = {
		action: 'load_screen',
        plugin: 'ecommerce-services',
        screen: screen_id,
        filter_key: filter_key
	   };
        	
    	$.post(ajaxurl, data, function(response) {
    	   $('#manual_batch_content').html(response);
    	});
        
    
    });  
}

function load_linked_man_bat_screen_back(screen_id,filter_key,back_screen){
    jQuery(function ($) {                
    	
        
        
        $('#manual_batch_content').html('<p style="text-align:center;">...Please Wait...</p>');               
        var data = {
		action: 'load_screen',
        plugin: 'ecommerce-services',
        screen: screen_id,
        filter_key: filter_key,
        back_screen: back_screen
        
	   };
        	
    	$.post(ajaxurl, data, function(response) {
    	   $('#manual_batch_content').html(response);
    	});
        
    
    });  
}

function view_batch(bat_code) {
    load_linked_man_bat_screen_back('reports/payees/manual_batch/view_batch',
    bat_code,'reports/payees/manual_batch/batches_marked_paid');
}

</script>