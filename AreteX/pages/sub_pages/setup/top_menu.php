<? $icon_path = plugins_url('../../../icons/',__FILE__);?>
<div class="section group"> <!-- ROW -->
    <div class="col span_11_of_12"> <!-- Column -->
    
    <nav>
    <div class="ui-widget ui-widget-header ui-corner-all" style=" padding: 5px;">
    
    
    
    
    <div class="button-set">
        <button id="overview" class="menu_button icon_left_button ui-button"><img class="icon_left" src="<?php echo $icon_path.'eye_open_16.png' ?>"/>Overview</button>
        
        <button id="wizards" class="menu_button icon_left_button ui-button"><img class="icon_left" src="<?php echo $icon_path.'star_16.png' ?>"/>Wizards</button>

       
        <button id="payout_setup" class="menu_button icon_left_button ui-button"><img class="icon_left" src="<?php echo $icon_path.'wire_transfer_16.png' ?>"/>Payouts</button>    
        <?php /*
        <button id="other_setup" class="menu_button icon_left_button ui-button"><img class="icon_left" src="<?php echo $icon_path.'technical_wrench_16.png' ?>"/>Other Setup</button>    
            */ ?>
        
        <?php 
         $license_info = AreteX_WPI::getBasLicense(); 
        if ($license_info->license_type != 'Production') { ?>
        <button id="golive"class="menu_button icon_left_button ui-button"><img class="icon_left" src="<?php echo $icon_path.'bank_transaction_16.png' ?>"/>Going Live</button>
        <?php } ?>
        
    </div>
    

    
    
    </div>
    </nav>

    </div> <!-- END Column -->
</div> <!-- END ROW -->
<script>
function back_to_main()
{
    
    window.location = '<?php echo admin_url().'admin.php?page=AreteX_Main_Admin_Menu' ?>'
}
</script>