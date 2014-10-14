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
 
 $pending = getResource('pending_summary'); 

 $tbl = build_summary_table($pending);
 
 $pendingpay_message = get_option('aretex_pending_pay_message');
 $pendingpay_message = trim($pendingpay_message);
 if (empty($pendingpay_message))
    $pendingpay_message = null;
?>
<div class="section group"> <!-- ROW -->

    <div class="col span_2_of_12"> <!-- Column -->
    <a href="javascript:void(0);"  onclick="load_ptr_page('payments');"
class="ui-button  icon_left_button button_link  ui-state-default ui-corner-all"  >
<span class="ui-icon  ui-icon-circle-arrow-w"></span> 
Back to Overview</a>    
    </div> <!-- END Column -->
</div> <!-- END ROW -->
 <?php 
            if ($pendingpay_message)
            {
                echo '<div style="margin: 10px;" class="container ui-widget-content ui-corner-all">';
                echo "<h2>Important Message From $business_name</h2><p>$pendingpay_message</p></div>";                
            }
        ?>
<div class="section group"> <!-- ROW -->
        <div class="col span_11_of_12"> <!-- Column -->
        <h3>Pending Payments</h3>
        <p>Below is a listing of monies owed to you.  These funds are still "pending" in that
        the funds have not completed the full processing cycle with all banks and processing
        services involved. Once a pending payment has cleared, it will be reported in your "Payments Sent" subtab.</p>
        <p> To sort the columns below use the arrows provided.
</p>
        </div> <!-- END Column -->
</div> <!-- END ROW -->
<div class="section group"> <!-- ROW -->    
    <div class="col span_11_of_12"> <!-- Column -->
        <? echo $tbl; ?>
    </div> <!-- END Column -->
</div> <!-- END ROW -->
<script>
$(document).ready(function() {
   init_buttons();
 });
</script>
<pre>
<? // var_dump($pending); ?>
</pre>