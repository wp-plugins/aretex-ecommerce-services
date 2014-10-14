<?php 
  $pcs_out_settings = AreteX_WPI::getBsuPcsOut();
  $license_info = AreteX_WPI::getBasLicense(); 
?>
<div class="ui-widget-header ui-corner-top" >
<h2 style="text-align: center; margin-top: 5px; margin-bottom: 5px;">ACH Limits Setup</h2>
</div>
<div class="ui-widget ui-widget-content  ui-corner-bottom"  style="padding: 5px;">
<!--
<a href="javascript:void(0);"  onclick="load_screen('pay_people_wizards');"
class="ui-button  icon_left_button button_link  ui-state-default ui-corner-all"  >
<span class="ui-icon  ui-icon-circle-arrow-w"></span> 
Back</a>
-->
<hr />
 <?php if (! empty($pcs_out_settings->forte_merchant_id) && $license_info->license_type == 'Production') { 
    
        include('ach_pages/signedup_live.php');
   } 
   else if (empty($pcs_out_settings->forte_merchant_id) && $license_info->license_type == 'Production') { 
    
        include('ach_pages/not_signed_up.php');
   }
   else {
?>
    <h4>Sandbox Mode</h4>
    <p>ACH is not available in <em>Sandbox Mode</em>.  When you Go Live, you will use this screen to setup your ACH Limits, as provided by Forte (ACH Direct).</p>
<?php    
   }
   ?>

</div>
<? 

/*
stdClass Object
(
    [use_ach_pcs_out] => Yes
    [forte_merchant_id] => ***822
    [forte_daily_d_limit] => 
    [forte_monthly_c_limit] => 
    [forte_monthly_d_limit] => 
    [forte_txn_c_limit] => 
    [forte_txn_d_limit] => 
)
    ----
    stdClass Object
(
    [license_key] => 24A3G0E0200128
    [license_name] => WordPress Plugin
    [license_type] => Production
    [license_status] => Good
    [termination_date] => 2014-05-10 09:50:23
    [Business_Name] => Test Biz
    [Primary_Contact_Name] => David B
    [Email_Address] => david@xk29.com
    [last_payment] => 2014-04-10
    [next_payment] => 2014-05-10
)
*/

?>