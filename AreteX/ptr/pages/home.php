<?php

global $payee;
global $business_name;
global $account_id;
global $user_email;
global $user_ID;

$signed_up = $_SESSION['current_aretex_payee'];
wp_get_current_user();

$current_user_id = $user_ID; 

if ($signed_up->linked_user_id != $current_user_id  ) {
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

$obj = AreteX_WPI::payeePaymentAccount($account_id);
if (is_object($obj))
    $payment_account = get_object_vars($obj);
else
    $payment_account = $obj;





$payment_authorized = false;
if ($signed_up->payment_account_type_id != '2') { // 2 = 'None Selected Yet' 
    $payment_authorized = true;
}



$payee = $signed_up->name;

// Get aretex_ptr_home_message option
$home_message = get_option('aretex_ptr_home_message'); 
$home_message = trim($home_message);
if (empty($home_message))
    $home_message = null;
    
 if (strtolower($signed_up->contact_email) != strtolower($user_email)) {
?>    
    <p class="error" style="padding: 4px;">Your profile email address does not match your payee 
contact email address. This could cause reporting problems.</p>
<button class="button" onclick="wp_to_ptr_email('<?php echo $signed_up->contact_email; ?>');" type="button">Change my profile eMail  to <strong><em><?php echo $signed_up->contact_email;  ?></em></strong></button>

<?php
}    
?>


 <div class="section group">      


    <div class="col span_12_of_12">
       <div class="ui-widget ui-widget-header ui-corner-tr ui-corner-tl">
            <h3> Your Payment Tracking and Reporting Panel</h3>
        </div>
        <div class="container ui-widget-content ui-corner-br ui-corner-bl">
        <?php 
            if ($home_message)
            {
                echo '<div style="margin: 10px;" class="container ui-widget-content ui-corner-all">';
                echo "<h2>Important Message From $business_name</h2><p>$home_message</p></div>";                
            }
        ?>
            <p style="font-size: 110%; font-weight: bold;">Welcome <? echo $payee; ?>! </p>
            
            <p>The Payment Tracking and Reporting system (PTR) is your secure panel to track
            your account receivables from <? echo $business_name ?>.</p>
             <p>Through the use of the tabs above, you can - - </p>
            <ul>
                <li>view or update your account information </li>
                <li>view or change your payment authorization, <strong>so you can get paid </strong></li>
                <li>view pending payments owed to you </li>
                <li>view a history of payments sent to you </li>
                 <?php
                    if ($signed_up->tier_1_commission_group_id > 0) {
                ?>
                <li>get instructions on how to use referral codes to <strong>get credit</strong> for your efforts </li>
                <?php
                    }
                ?>
            </ul>  
           <p>Be sure to keep your account information and authorization current, 
           so you get full credit and payment for your efforts!</p>
           
           <? if (! $payment_authorized)
                   {
                 ?>
            <div style="border:thin solid #CD0A0A; padding: 5px; margin: 5px; width:75%;" class="ui-corner-all">
                <label  class="error">You have not yet authorized automatic payments.  To go directly to the payments authorization screen: <a style="color: #CD0A0A; " href="javascript:void(0);"   onclick="load_ptr_page('ach_auth');" > <strong>Click Here</strong></a></label>
                 
            </div> 
            <? }
               else if ($payment_account['authorization_vars']->status == 'Pending' || 
               $payment_account['authorization_vars']->status == 'Waiting'  
               )
               {
                 ?>
            <div style="border:thin solid #CD0A0A; padding: 5px; margin: 5px; width:75%;" class="ui-corner-all">
                <label  class="error">You have not yet verified your bank account.  To confirm the test transactions submitted to your bank: <a style="color: #CD0A0A; " href="javascript:void(0);"   onclick="load_ptr_page('ach_auth');" > <strong>Click Here</strong></a></label>
                 
            </div>   
                 
                 <?
               }
             ?>
           
        </div>
    </div>

 </div>
 <script>
 
 jQuery(document).ready(function() {
  //  init_buttons();
 });
 
 </script>   