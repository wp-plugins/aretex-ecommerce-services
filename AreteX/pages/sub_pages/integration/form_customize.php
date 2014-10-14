<?php $icon_path = plugins_url('../../../icons/',__FILE__);?>
<h2>Form Customization</h2>
<div class="section group"> <!-- ROW -->
    <div class="col span_12_of_12"> <!-- Column -->
    
    <nav>
    <div class="ui-widget ui-widget-header ui-corner-all" style=" padding: 5px;">   
    <div class="button-set">
        <button onclick="load_screen('integration/forms/overview');" id="overview" class="menu_button icon_left_button ui-button"><img class="icon_left" src="<?php echo $icon_path.'eye_open_16.png' ?>"/>Overview</button>
        
        <button onclick="load_screen('customize_receipts');" class="menu_button icon_left_button ui-button"><img class="icon_left" src="<?php echo $icon_path.'invoice_16.png' ?>"/>Receipts and Customer Accounts</button>
        <button onclick="load_screen('payment_form_setup');" class="menu_button icon_left_button ui-button"><img class="icon_left" src="<?php echo $icon_path.'credit_card2_16.png' ?>"/>Payment Form</button>    

        
    </div>
    

    
    
    </div>
    </nav>

    </div> <!-- END Column -->
</div> <!-- END ROW -->
<hr />
<div id="detail_screen">
</div>
 <iframe id="download_frame" width=0 height=0 frameBorder=0></iframe>
<script>
jQuery('.button-set').buttonset();
load_screen('integration/forms/overview');
</script>