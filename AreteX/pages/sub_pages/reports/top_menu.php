<? $icon_path = plugins_url('../../../icons/',__FILE__);?>
<div class="section group"> <!-- ROW -->
    <div class="col span_11_of_12"> <!-- Column -->
    
    <nav>
    <div class="ui-widget ui-widget-header ui-corner-all" style=" padding: 5px;">
    
    
    
    
    <div class="button-set">
        <button id="overview" class="menu_button icon_left_button ui-button"><img class="icon_left" src="<?php echo $icon_path.'eye_open_16.png' ?>"/>Overview</button>
              <button id="customers" class="menu_button icon_left_button ui-button"><img class="icon_left" src="<?php echo $icon_path.'hand_handshake_16.png' ?>"/>Customers</button>    
  
        <button id="sales_report" class="menu_button icon_left_button ui-button"><img class="icon_left" src="<?php echo $icon_path.'invoice_16.png' ?>"/>Sales Report</button>
        <button id="deliveries" onclick="show_delivery_menu();"  class="sub_menu_button  icon_left_button ui-button"><img class="icon_left" src="<?php echo $icon_path.'dispatch_16.png' ?>"/>Deliveries</button>

        <button id="payout_report" class="menu_button icon_left_button ui-button"><img class="icon_left" src="<?php echo $icon_path.'wire_transfer_16.png' ?>"/>Payout Report</button>    
        
 
        <button id="payees" class="menu_button icon_left_button ui-button"><img class="icon_left" src="<?php echo $icon_path.'payment_16.png' ?>"/>Payees</button>    
       
        
    </div>
        <div id="deliveries_menu" class="button-set">
        <hr />
        &nbsp;&nbsp;
            <button id="overview" onclick="load_content_screen('reports/deliveries/overview');" class="sub_menu_button icon_left_button ui-button"><img class="icon_left" src="<?php echo $icon_path.'eye_open_16.png' ?>"/>Overview</button>
            <button id="delivery_log"  class="menu_button icon_left_button ui-button"><img class="icon_left" src="<?php echo $icon_path.'dispatch_order_16.png' ?>"/>Delivery Log</button>                
            <button id="pending_deliveries"  class="menu_button icon_left_button ui-button"><img class="icon_left" src="<?php echo $icon_path.'product_in_progress_16.png' ?>"/>Manage Deliveries</button>                
        </div>

    
    
    </div>
    </nav>

    </div> <!-- END Column -->
</div> <!-- END ROW -->
<script>
function show_delivery_menu() {
    jQuery('#deliveries_menu').show();
    load_content_screen('reports/deliveries/overview');
}

jQuery('#deliveries_menu').hide();
</script>