<h2>Payees</h2>
<? $icon_path = plugins_url('../../../icons/',__FILE__); ?>
<div class="section group"> <!-- ROW -->

    <div class="col span_12_of_12"> <!-- Column -->
    
    <nav>
        <div class="ui-widget ui-widget-header ui-corner-all" style=" padding: 5px; ">
             <div class="button-set">
                <button id="overview" class="payee_menu_button icon_left_button ui-button"><img class="icon_left" src="<?php echo $icon_path.'eye_open_16.png' ?>"/>Overview</button>        
                <button id="payee_management" class="payee_menu_button icon_left_button ui-button"><img class="icon_left" src="<?php echo $icon_path.'operator_16.png' ?>"/>Payee Management</button>
                <button id="manual_batch" class="payee_menu_button icon_left_button ui-button"><img class="icon_left" src="<?php echo $icon_path.'multilevel_list_16.png' ?>"/>Manual Batch</button>
                <button id="ach_report" class="payee_menu_button icon_left_button ui-button"><img class="icon_left" src="<?php echo $icon_path.'check2_16.png' ?>"/>ACH Report</button>                           
            </div>
        </div>
    </nav>

    </div> <!-- END Column -->
</div> <!-- END ROW -->
<div id="detail_screen">

</div>



<script>
jQuery('.button-set').buttonset();
jQuery('.payee_menu_button').click(
  function() { load_payee_mgm_screen(this.id); }
);

load_payee_mgm_screen('overview');


</script>