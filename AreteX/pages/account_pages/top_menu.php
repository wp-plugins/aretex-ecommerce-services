<?php $icon_path = plugins_url('../../icons/',__FILE__);?>
<div class="section group"> <!-- ROW -->
    <div class="col span_11_of_12"> <!-- Column -->
    
    <nav>
    <div class="ui-widget ui-widget-header ui-corner-all" style=" padding: 5px;">
    
    
    
    
    <div class="button-set">
        <button id="home" class="menu_button icon_left_button ui-button"><img class="icon_left" src="<?php echo $icon_path.'eye_open_16.png' ?>"/>Overview</button>
        
        <button id="contact" class="menu_button icon_left_button ui-button"><span class="ui-icon ui-icon-person"></span>Contact</button>
        
        <button id="licenses" class="menu_button icon_left_button ui-button"><span class="ui-icon ui-icon-contact"></span>License Management</button>

        
        <button id="payments" class="menu_button icon_left_button ui-button"><span class="ui-icon ui-icon-suitcase"></span>Payments</button>    
        
 
        
        
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