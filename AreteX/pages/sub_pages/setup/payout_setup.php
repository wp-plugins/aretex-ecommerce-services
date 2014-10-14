<?php $icon_path = plugins_url('../../../icons/',__FILE__);?>
<h2>Payouts Setup</h2>
<div class="ui-widget ui-widget-content  ui-corner-all container" style="padding-right: 3px; margin-right: 5px; margin-bottom: 5px;" >
<div class="section group"> <!-- ROW -->
    <div class="col span_12_of_12"> <!-- Column -->
    
    <nav>
    <div class="ui-widget ui-widget-header ui-corner-all" style=" padding: 5px;">

    <div class="button-set">
        <button id="payout_overview"   class="sub_menu_button icon_left_button ui-button"><img class="icon_left" src="<?php echo $icon_path.'allow_list2_16.png' ?>"/>Summary</button>
        <button id="setup_sched" class="sub_menu_button icon_left_button ui-button"><img class="icon_left" src="<?php echo $icon_path.'calendar_16.png' ?>"/>Payday Schedule</button>
        <button id="commission_structures" class="sub_menu_button icon_left_button ui-button"><img class="icon_left" src="<?php echo $icon_path.'multilevel_list_16.png' ?>"/>Commission Structures</button>
         <button id="contributor_payouts" class="sub_menu_button icon_left_button ui-button"><img class="icon_left" src="<?php echo $icon_path.'operator_16.png' ?>"/>Contributor Payouts</button>
        <button id="forte_limits" class="sub_menu_button icon_left_button ui-button"><img class="icon_left" src="<?php echo $icon_path.'check2_16.png' ?>"/>ACH Setup</button>  
  

        
    </div>
       
    </div>
    </nav>
    <hr />
    <div id="payout_content">
    <?php include(plugin_dir_path(__FILE__).'payouts/payout_overview.php'); ?>
    </div>

    </div> <!-- END Column -->
</div> <!-- END ROW -->
</div>

    </div> <!-- END Column -->
</div> <!-- END ROW -->
<script>
jQuery('.button-set').buttonset();

jQuery('button.sub_menu_button').click(
            function() { load_payout_content(this); }
         );

 function load_payout_content(element)
 {
    
     load_div_screen('setup/payouts/'+element.id,'#payout_content');
    
 }
 

</script>