<?php 

$license = AreteX_WPI::getBasLicense();

$payment_auth = AreteX_WPI::paymentAuthToken();
$payment_auth = urlencode($payment_auth);


?>
<div class="section group dbui-frame"> <!-- ROW -->
    <div class="col span_7_of_12"> <!-- Column -->
   
<div class="ui-widget-header ui-corner-top" >
<h2 style="text-align: center; margin-top: 5px; margin-bottom: 5px;">Current Installed License</h2>
</div>
<div class="ui-widget ui-widget-content  ui-corner-bottom container" >
<div class="section group"> <!-- ROW -->
    <div class="col span_4_of_12"> <!-- Column -->
    <label>License Key</label>
    <?php echo $license->license_key; ?>
    </div> <!-- END Column -->
    <div class="col span_4_of_12"> <!-- Column -->
    <label>License Name</label>
    <?php echo $license->license_name; ?>
    </div> <!-- END Column -->
     <div class="col span_4_of_12"> <!-- Column -->
    <label>Licensed To</label>
    <?php echo $license->Business_Name; ?>
    </div> <!-- END Column -->
</div> <!-- END ROW -->
<div class="section group"> <!-- ROW -->
     <div class="col span_4_of_12"> <!-- Column -->
    <label>License Type</label>
    <?php echo $license->license_type; ?>
    </div> <!-- END Column -->
    <div class="col span_4_of_12"> <!-- Column -->
        <label>License Status</label>
    <?php echo $license->license_status; ?>
    </div> <!-- END Column -->
    <div class="col span_4_of_12"> <!-- Column -->
        <label>Last Payment</label>
    <?php echo $license->last_payment; ?>
    </div> <!-- END Column -->
</div> <!-- END ROW -->
<div class="section group"> <!-- ROW -->
    <div class="col span_4_of_12"> <!-- Column -->
        <label>Status Valid Thru</label>
    <?php echo $license->termination_date; ?>
    </div> <!-- END Column -->
    <div class="col span_4_of_12"> <!-- Column -->
        <label>Next Payment Scheduled</label>
    <?php echo $license->next_payment ?>
    </div> <!-- END Column -->
    <div class="col span_4_of_12"> <!-- Column -->
    &nbsp;
    <!--
    <label>More Details</label>
    <a href="javascript:void(0);"  
class="ui-button  icon_left_button button_link  ui-state-default ui-corner-all"  >
<span class="ui-icon  ui-icon-search"></span> 
View</a>
-->
    </div> <!-- END Column -->
</div> <!-- END ROW -->
<hr />

<?php

    $access_token = AreteX_WPI::ajaxAccessToken('master',true); 
    $update_url = get_option('aretex_update_endpoint');
    $cancel_url = $update_url.'/request_cancel?license='.$license->license_key.'&aretex_ajax_auth='.$access_token.'&payment_auth='.$payment_auth;   

    $update_url .= '?license='.$license->license_key.'&aretex_ajax_auth='.$access_token.'&payment_auth='.$payment_auth;
        
    
    if ($license->license_status != 'Trial')  {
?>

<a href="<?php echo $update_url;  ?>"  target="_blank"
class="ui-button  icon_left_button button_link  ui-state-default ui-corner-all"  >
<span class="ui-icon  ui-icon-suitcase"></span> 
Update Payment Information</a>
<?php } ?>

<a href="<?php echo $cancel_url;  ?>"  target="_blank"
class="ui-button  icon_left_button button_link  ui-state-default ui-corner-all"  >
<span class="ui-icon  ui-icon-cancel"></span> 
Cancel This License</a>

<a href="javascript:void(0);"  onclick="load_act_page('account_pages/replace_id_keys');"
class="ui-button  icon_left_button button_link  ui-state-default ui-corner-all"  >
<span class="ui-icon  ui-icon-key"></span>Replace Identity Keys</a>

<hr />
<!--
<a href="javascript:void(0);"  
class="ui-button  icon_left_button button_link  ui-state-default ui-corner-all"  >
<span class="ui-icon  ui-icon-arrowthick-1-s"></span> 
Other Licenses</a>
<hr />
-->

</div>

 </div> <!-- END Column -->
     <div class="col span_5_of_12"> <!-- Column -->
     <div class="ui-widget ui-widget-content  ui-corner-all container" style="margin-right: 1%;" >
        <strong>Account Management Help</strong>
        
        <p>This is the information on your current AreteX&trade; License.  To change your payment particulars (like method of payment), click "Update Payment Information" button and follow instructions.
</p>
<p><strong>Cancellation of License:</strong></p>

<p>   <strong>For a Live License</strong> - Be sure to cancel your license before uninstalling the AreteX&trade; plugin.  You will receive a confirmation email.  After you confirm the cancellation, your billing will cease and all of your current data will be purged within 30 days.
</p>
 <p>  <strong>For a paid Sandbox License </strong>- Upon cancellation your billing will cease and your data will be purged at the end of the current billing cycle.
</p>
<p>   <strong><em>Note:</em></strong> Cancellation of an AreteX&trade; License does not cancel any agreements you might have with Vantiv, Forte, or any other third party.
</p>        
        
     </div>
    </div> <!-- END Column -->
</div> <!-- END ROW -->