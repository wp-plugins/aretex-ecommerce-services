<?php $icon_path = plugins_url('../../../icons/',__FILE__);
    
    $license_info = AreteX_WPI::getBasLicense();
    $limit = false;
    if ($license_info->license_status == 'Trial') {
        $products = AreteX_WPI::getProducts('');
        if ($products->total >= 5) {
            $limit = true;
        }
    }
?>
<div class="section group"> <!-- ROW -->
    <div class="col span_12_of_12"> <!-- Column -->

<h2>Wizards</h2>
<div class="ui-widget ui-widget-content  ui-corner-all container" style="margin-right: 5px;" >
<div class="section group"> <!-- ROW -->
    <div class="col span_11_of_12"> <!-- Column -->
    
    <nav>
    <div class="ui-widget ui-widget-header ui-corner-all" style=" padding: 5px;">

    <div class="button-set">
        <button   id="wizard_overview" class="sub_menu_button icon_left_button ui-button"><img class="icon_left" src="<?php echo $icon_path.'eye_open_16.png' ?>"/>Wizard Overview</button>
        <?php 
            if ($limit) {
        ?>
            <strong>&nbsp;&nbsp;Wizards Unavailable: Trial Product Limit Reached</strong>
        <?
            }
            else {
        ?>
        <button id="paid_content" class="sub_menu_button icon_left_button ui-button"><img class="icon_left" src="<?php echo $icon_path.'treasure_chest_16.png' ?>"/>Paid Content Wizard</button>
        
        <button id="paid_membership" class="sub_menu_button icon_left_button ui-button"><img class="icon_left" src="<?php echo $icon_path.'atm_16.png' ?>"/>Paid Membership Wizard</button>  
        <?php } ?>
        
    </div>
       
    </div>
    </nav>
    <hr />
    <div id="wizard_content">
    <?php
    if ($limit) {
        echo "<label class=\"error\"><strong><em>Important Note:</em></strong> Your Sandbox Free Trial 
        License has met or exceeded it's five product limit. Please delete some products, or 
        upgrade your license to use these wizards.</label>";
    }
         
    include(plugin_dir_path(__FILE__).'wizards/wizard_overview.php'); ?>
    </div>

    </div> <!-- END Column -->
</div> <!-- END ROW -->
</div>

    </div> <!-- END Column -->
</div> <!-- END ROW -->
<script>
jQuery('.button-set').buttonset();

jQuery('button.sub_menu_button').click(
            function() { load_wizard_content(this); }
         );

 function load_wizard_content(element)
 {
    
    load_div_screen('setup/wizards/'+element.id,'#wizard_content');
    
 }
 

</script>