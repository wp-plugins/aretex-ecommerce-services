<?php

    global $payee;
    global $business_name;
    global $account_id;
    
    require_once(plugin_dir_path( __FILE__ ).'../ptrlib.php');
    
    $signed_up = $_SESSION['current_aretex_payee'];
    $current_user_id = get_current_user_id(); 
    
    if ($signed_up->linked_user_id != $current_user_id) {
        $signed_up = AreteX_WPI::payeeSignedUp($current_user_id);
        $_SESSION['current_aretex_payee'] = $signed_up;
    }
    if (! $signed_up) {
        echo "Problem with Payee User Validation ... ";
        return;
    }
    
    $license = AreteX_WPI::getBasLicense();
    $business_name = $license->Business_Name;
    
    $account_id = $signed_up->id;


  $obj = getResource('');
 
 $sent = getResource('payment_summary'); 
 $html = build_payment_table($sent);
?>
<div class="section group"> <!-- ROW -->

    <div class="col span_2_of_12"> <!-- Column -->
    <a href="javascript:void(0);"  onclick="load_ptr_page('payments');"
class="ui-button  icon_left_button button_link  ui-state-default ui-corner-all"  >
<span class="ui-icon  ui-icon-circle-arrow-w"></span> 
Back to Overview</a>    
    </div> <!-- END Column -->
</div> <!-- END ROW -->
<div class="section group"> <!-- ROW -->
    <div class="col span_11_of_12"> <!-- Column -->
    <h3>Payments Sent</h3>
    <p>Below is a listing of funds that have processed and been sent to the account you provided
    us for automatic payments.  If these funds have not 
    arrived at the financial institution you specified, please contact <? echo $business_name; ?>.  
    (Note: it can take up to a day for some financial institutions to electronically list monies 
    received for your account.  The delay in electronic reporting will vary by financial institution.  
    Contact them for more details.) <br /><br />
<p> To sort the columns below use the arrows provided.
</p>
    </div> <!-- END Column -->
</div> <!-- END ROW -->
<div class="section group"> <!-- ROW -->
    <div class="col span_11_of_12"> <!-- Column -->
    <? echo $html; ?>
    </div> <!-- END Column -->
</div> <!-- END ROW -->
<script>
 $(document).ready(function() {
    init_buttons();
   // put all your jQuery goodness in here.
 });
 </script>  
<pre>
<?//  var_dump($sent); ?>
</pre>