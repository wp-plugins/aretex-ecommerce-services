<?php 

global $business_name;
global $customer_id;

if (empty($business_name)) {
    $license = AreteX_WPI::getBasLicense();
    $business_name = $license->Business_Name;
    
}

$biz = AreteX_WPI::getBusiness();

if (empty($customer_id))
    $customer_id  = AreteX_WPI::customerSignedUp();

 require_once(plugin_dir_path( __FILE__ ).'../camlib.php');

 $detail = getResource('rebill_agreement/'.$_REQUEST['linked_id']);
 
 $ajaxAccessToken = AreteX_WPI::ajaxAccessToken(null,true);
 


?>
<a style="margin-left: 5px; margin-top: 3px;" href="javascript:void(0);" onclick="load_cam_page('rebill','<?php echo $_REQUEST['linked_id']; ?>');"  
class="ui-button  icon_left_button button_link  ui-state-default ui-corner-all"  >
<span class="ui-icon  ui-icon-circle-arrow-w"></span> 
Back</a>
<div class="section group"> <!-- ROW -->
    <div class="col span_6_of_12"> <!-- Column -->
    <div class="ui-widget-header ui-corner-top" >
<h2 style="text-align: center; margin-top: 5px; margin-bottom: 5px;">Rebill Detail</h2>
</div>
<div class="ui-widget ui-widget-content  ui-corner-bottom" >


<div class="section group"> <!-- ROW -->
<div class="col span_4_of_12"> <!-- Column -->
<span style="text-align:right; float:right; font-weight:bold">Rebill Agreement For</span></div> <!-- END Column -->
<div class="col span_8_of_12"> <!-- Column -->
<?php echo $detail->product_name; ?></div> <!-- END Column -->
</div> <!-- END ROW -->

<div class="section group"> <!-- ROW -->
    <div class="col span_4_of_12"> <!-- Column -->
        <span style="text-align:right; float:right; font-weight:bold">Rebill Authorization</span>
    </div> <!-- END Column -->
    <div class="col span_8_of_12"> <!-- Column -->
        <p>
        Authorizing Transaction Number: <?php echo $detail->original_authorize_id; ?><br />
        <a target="_blank" href="<?php echo $detail->original_confirmation.'?aretex_ajax_auth='.$ajaxAccessToken; ?>">View Receipt</a> (Opens New Window)
        </p>    
    </div> <!-- END Column -->
</div> <!-- END ROW -->

<div class="section group"> <!-- ROW -->
<div class="col span_4_of_12"> <!-- Column -->
<span style="text-align:right; float:right; font-weight:bold">Start Date</span></div> <!-- END Column -->
<div class="col span_8_of_12"> <!-- Column -->
<?php echo date('F j, Y' ,strtotime($detail->start_date)); ?></div> <!-- END Column -->
</div> <!-- END ROW -->

<div class="section group"> <!-- ROW -->
<div class="col span_4_of_12"> <!-- Column -->
<span style="text-align:right; float:right; font-weight:bold">Initial Payment</span></div> <!-- END Column -->
<div class="col span_8_of_12"> <!-- Column -->
<?php  echo '$'.number_format($detail->initial_payment,'2','.',','); ?></div> <!-- END Column -->
</div> <!-- END ROW -->

<div class="section group"> <!-- ROW -->
<div class="col span_4_of_12"> <!-- Column -->
<span style="text-align:right; float:right; font-weight:bold">Time Before Regular Billing Cycle(days)</span></div> <!-- END Column -->
<div class="col span_8_of_12"> <!-- Column -->
<?php  echo $detail->initial_period; ?></div> <!-- END Column -->
</div> <!-- END ROW -->

<div class="section group"> <!-- ROW -->
<div class="col span_4_of_12"> <!-- Column -->
<span style="text-align:right; float:right; font-weight:bold">Billing Cycle</span></div> <!-- END Column -->
<div class="col span_8_of_12"> <!-- Column -->
<?php  echo $detail->rebill_cycle; ?></div> <!-- END Column -->
</div> <!-- END ROW -->

<div class="section group"> <!-- ROW -->
<div class="col span_4_of_12"> <!-- Column -->
<span style="text-align:right; float:right; font-weight:bold">Total Billing Cycles</span></div> <!-- END Column -->
<div class="col span_8_of_12"> <!-- Column -->
<?php if ($detail->max_billing_cycles <= 0)
    echo "Until Canceled";
else
    echo $detail->max_billing_cycles; 
?>
</div> <!-- END Column -->
</div> <!-- END ROW -->



<div class="section group"> <!-- ROW -->
    <div class="col span_4_of_12"> <!-- Column -->
        <span style="text-align:right; float:right; font-weight:bold">Agreement Status</span>     
    </div> <!-- END Column -->
    <div class="col span_8_of_12"> <!-- Column -->
         <?echo $detail->status; ?>
    </div> <!-- END Column -->
</div> <!-- END ROW -->

<?php if ($detail->rebill_method == 'automatic' && ($detail->status == 'active' || $detail->status == 'suspended')) { 
         
        $method_text = "Automatic Payment";
                 
        ?>    
<div class="section group"> <!-- ROW -->
    <div class="col span_4_of_12"> <!-- Column -->
    <span style="text-align:right; float:right; font-weight:bold">Billing Method</span>
    </div> <!-- END Column -->
    <div class="col span_8_of_12"> <!-- Column -->
      <?php echo $method_text; ?>
    </div> <!-- END Column -->
</div> <!-- END ROW -->

<div class="section group"> <!-- ROW -->
    <div class="col span_4_of_12"> <!-- Column -->
        <span style="text-align:right; float:right; font-weight:bold">Card Type</span>
    </div> <!-- END Column -->
    <div class="col span_8_of_12"> <!-- Column -->
        <?php echo $detail->card_type; ?>
    </div> <!-- END Column -->
</div> <!-- END ROW -->
<div class="section group"> <!-- ROW -->
    <div class="col span_4_of_12"> <!-- Column -->
        <span style="text-align:right; float:right; font-weight:bold">Account Number </span>
    </div> <!-- END Column -->
    <div class="col span_8_of_12"> <!-- Column -->
        <?php echo $detail->masked_pan; ?>
    </div> <!-- END Column -->
</div> <!-- END ROW -->
<div class="section group"> <!-- ROW -->
    <div class="col span_4_of_12"> <!-- Column -->
    <span style="text-align:right; float:right; font-weight:bold">Payments</span>
    </div> <!-- END Column -->
    <div class="col span_3_of_12"> <!-- Column -->
    <a href="javascript:void(0);" onclick="atx_update_payment('<?php echo $_REQUEST['linked_id']; ?>');"  
class="ui-button  icon_left_button_bg button_link  ui-state-default ui-corner-all"  >
<img  class="ui_icon" src="<?php echo plugins_url( '../../images/buttons/credit_card_30.png', __FILE__ ); ?>" /> 
<span class="button_text">
Update Card
</span>
</a>
    </div> <!-- END Column -->
    <div class="col span_3_of_12"> <!-- Column -->
    <a href="javascript:void(0);" onclick="cancel_rebill('<?php echo $_REQUEST['linked_id'] ?>');"  
class="ui-button  icon_left_button_bg button_link  ui-state-default ui-corner-all"  >

   <img  class="ui_icon" src="<?php echo plugins_url( '../../images/buttons/block_30.png', __FILE__ ); ?>" />
<span class="button_text">
Cancel
</span> 
</a>    
    </div> <!-- END Column -->
</div> <!-- END ROW -->
    


<?php } ?>

<div class="section group"> <!-- ROW -->
    <div class="col span_4_of_12"> <!-- Column -->
        <span style="text-align:right; float:right; font-weight:bold">Payment History</span>
    </div> <!-- END Column -->
    <div class="col span_8_of_12"> <!-- Column -->
    <button type="button" class="icon_left_button_bg ui-button button_link ui-state-default ui-corner-all" onclick="load_linked_cam_page('rebill_payments','<?php echo $_REQUEST['linked_id'] ?>');" >
       
    <img class="ui_icon" src="<?php echo plugins_url( '../../images/buttons/invoice_30.png', __FILE__ ); ?>" />
    <span class="button_text">
    View History
    </span> 
    </button>
    
    </div> <!-- END Column -->
</div> <!-- END ROW -->

</div>
    </div> <!-- END Column -->
    <div class="col span_5_of_12"> <!-- Column -->

        <div class="ui-widget ui-widget-content  ui-corner-all container" >
        <p>Use this screen to admininister your rebilling agreements with <?php echo $business_name; ?>.</p> 
           <p>Here you can see the details of your authorization,  change the payment card you use, cancel your subscription, and view your rebill payment history.</p>
        </div>
    
    </div> <!-- END Column -->

</div> <!-- END ROW -->
