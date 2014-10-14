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


$obj = AreteX_WPI::payeeAccountInfo($account_id);

$biz_info  = AreteX_WPI::getBusiness();
// Get some preferences set up here as far as contact info goes ..
$business_contact_phone = $biz_info->Primary_Phone;
$business_contact_email = $biz_info->Email_Address;

?>
 <div class="section group">      
     
    
    <div class="col span_11_of_12">
        <div class="ui-widget ui-widget-header ui-corner-top">
            <h3>Payments </h3>
        </div>
            <nav>
    <div class="ui-widget ui-widget-header " style=" padding: 5px;">   
     <div class="sub-button-set">
        <button id="ach_auth" class="sub_menu_button icon_left_button ui-button"><span class="ui-icon ui-icon-check"></span>Authorization</button>
        
        <button id="pending_pay" class="sub_menu_button icon_left_button ui-button"><span class="ui-icon ui-icon-clock"></span>Pending Payments</button>
    
        <button id="payments_sent" class="sub_menu_button icon_left_button ui-button"><span class="ui-icon ui-icon-document"></span>Payments Sent</button>                    
    </div>
        
    </div>
        <div class="container ui-widget-content ui-corner-bottom">
        <h2>Payments Overview</h2>
        <p>The menu above offers the following options: </p>
            <ul>
            <li><strong>Authorization </strong> 
                <br /> The Authorization page allows you to view or change your 
                payment permission, which allows <? echo $business_name; ?> to pay you automatically. <br /><em>Note: </em><?php echo $business_name ?> cannot send you payments without your authorization.
                <br /><br />
            </li>
            <li><strong>Pending Payments</strong> 
                <br />This page allows you to track the payments due to you.
                <br /><br />
            </li>
            <li><strong>Payments Sent</strong>
                <br />This page lets you view a history of payments that have already been sent
                to you from <? echo $business_name; ?>. 
                <br /> If you have not received these payments, please contact <? echo $business_name; ?>.
                <ul style="list-style-type:square;">
                <li><strong>Phone:</strong> <?php echo $business_contact_phone; ?></li>
                <li><strong>Email:</strong> <?php echo $business_contact_email; ?></li>
                </ul>
                <br />
            </li>
            </ul>
            <p>Be sure to keep your payment authorization current to continue receiving money
            owed to you by <? echo $business_name; ?>.</p>
        </div>
    </div>
 </div> 
 <script>
 jQuery(document).ready(function() {
    

        jQuery('.sub-button-set').buttonset();


        
        jQuery('button.sub_menu_button').click(
                    function() { load_ptr_content(this); }
                 );     
   
 });
 </script>  