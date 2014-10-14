<?php
global $business_name;
global $customer_id;

if (empty($business_name)) {
    $license = AreteX_WPI::getBasLicense();
    $business_name = $license->Business_Name;
}

if (empty($customer_id))
    $customer_id  = AreteX_WPI::customerSignedUp();

 require_once(plugin_dir_path( __FILE__ ).'../camlib.php');

 $obj = getResource('');
 $name = $obj->firstname . ' ' . ' '.$obj->lastname;
 
 $obj = getResource('contact');
 global $user_email;
 
 global $cam_email;
 $cam_email =  $obj->email_address; 
 
if (strtolower($obj->email_address) != strtolower($user_email))
{
?>
<p class="error" style="padding: 4px;">Your profile email address does not match your customer 
contact email address. This could cause reporting problems.</p>
<button class="button" onclick="wp_to_cam_email('<?php echo $cam_email; ?>');" type="button">Change my profile eMail  to <strong><em><?php echo $obj->email_address;  ?></em></strong></button>&nbsp;&nbsp;<button class="button" onclick="submit_cam_info('#hidden_contact_info'); "  type="button">Change my Contact eMail to <strong><em><?php echo $user_email; ?></em></strong></button>
<form id="hidden_contact_info">
<input type="hidden" name="_business_name_" value="<?php echo $obj->business_name; ?>" />
<input type="hidden" name="_firstname_" value="<?php echo $obj->firstname; ?>" />
<input type="hidden" name="_lastname_" value="<?php echo $obj->lastname; ?>" />
<input type="hidden" name="_street_" value="<?php echo $obj->street; ?>" />
<input type="hidden" name="_city_" value="<?php echo $obj->city; ?>" />
<input type="hidden" name="_state_" value="<?php echo $obj->state; ?>" />
<input type="hidden" name="_zip_" value="<?php echo $obj->zip; ?>" />
<input type="hidden" name="_phone_" value="<?php echo $obj->phone; ?>" />
<input type="hidden" name="_email_address_" value="<?php echo $user_email; ?>" />
<input type="hidden" name="account_id" value="<?php echo $obj->account_id; ?>" />

</form>
<?php    
}

?>
 
<div class="section group">   
<div class="col span_11_of_12">
   <div class="ui-widget ui-widget-header ui-corner-tr ui-corner-tl">
        <h3> Your Customer Account Management Panel</h3>
    </div>
    <div class="container ui-widget-content ui-corner-br ui-corner-bl">
        <p style="font-size: 110%; font-weight: bold;">Welcome <? echo $name; ?> to your Customer Account Manager! </p>
        <p> Using the tabs above you can:
<ul>
<li>Manage your customer contact information. <div style="position: relative; left: 40px;">(This is different from your WordPress user profile.)</div></li>


<li>Administer your Rebill Agreements.  <div style="position: relative; left: 40px;">(This includes being able to change the payment card you use,</div>
 <div style="position: relative; left: 40px;">canceling your subscription, and viewing your rebill payment history.)</div></li>
</ul>

<li>Track your Purchase History.  
  <div style="position: relative; left: 40px;">(You can view your receipts here.)</div></li>

        </p>
        
    </div>
</div>
</div>