<?php
global $business_name;
global $customer_id;

if (empty($business_name)) {
    $license = AreteX_WPI::getBasLicense();
    $business_name = $license->Business_Name;
    
}

$biz = AreteX_WPI::getBusiness();
global $user_email;

if (empty($customer_id))
    $customer_id  = AreteX_WPI::customerSignedUp();

 require_once(plugin_dir_path( __FILE__ ).'../camlib.php');
 
 $obj = getResource('contact');

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
<?    
}

?>
<div class="section group"> <!-- ROW -->
    <div class="col span_6_of_12"> <!-- Column -->

<div class="ui-widget-header ui-corner-top" >
<h2 style="text-align: center; margin-top: 5px; margin-bottom: 5px;">Customer Contact Information</h2>
</div>
<div class="ui-widget ui-widget-content  ui-corner-bottom container " >


<form id="customer_contact_form" action="javascript:void(0)" >
 
<div class="section group"> <!-- ROW -->
    <div class="col span_4_of_12"> <!-- Column -->
        <span style="text-align:right; float:right; font-weight:bold">Business Name</span> 
    </div> <!-- END Column -->
    <div class="col span_4_of_12"> <!-- Column -->
    <input type="text" name="_business_name_" value="<?php echo $obj->business_name; ?>" />
    </div> <!-- END Column -->
</div> <!-- END ROW -->
<div class="section group"> <!-- ROW -->
    <div class="col span_4_of_12"> <!-- Column -->
        <span style="text-align:right; float:right; font-weight:bold">First Name</span>
    </div> <!-- END Column -->
    <div class="col span_4_of_12"> <!-- Column -->
        <input type="text" class="required" name="_firstname_" value="<?php echo $obj->firstname; ?>" />
    </div> <!-- END Column -->
</div> <!-- END ROW -->
<div class="section group"> <!-- ROW -->
    <div class="col span_4_of_12"> <!-- Column -->
        <span style="text-align:right; float:right; font-weight:bold">Last Name</span>
    </div> <!-- END Column -->
    <div class="col span_4_of_12"> <!-- Column -->
        <input class="required" type="text" name="_lastname_" value="<?php echo $obj->lastname; ?>" />
    </div> <!-- END Column -->
</div> <!-- END ROW -->

<div class="section group"> <!-- ROW -->
    <div class="col span_4_of_12"> <!-- Column -->
        <span style="text-align:right; float:right; font-weight:bold">Street</span>
    </div> <!-- END Column -->
    <div class="col span_4_of_12"> <!-- Column -->
        <input type="text" name="_street_" value="<?php echo $obj->street; ?>" />
    </div> <!-- END Column -->
</div> <!-- END ROW -->
<div class="section group"> <!-- ROW -->
    <div class="col span_4_of_12"> <!-- Column -->
        <span style="text-align:right; float:right; font-weight:bold">City</span>
    </div> <!-- END Column -->
    <div class="col span_4_of_12"> <!-- Column -->
        <input type="text" name="_city_" value="<?php echo $obj->city; ?>" />
    </div> <!-- END Column -->
</div> <!-- END ROW -->
<div class="section group"> <!-- ROW -->
    <div class="col span_4_of_12"> <!-- Column -->
        <span style="text-align:right; float:right; font-weight:bold">State</span>
    </div> <!-- END Column -->
    <div class="col span_4_of_12"> <!-- Column -->
        <input type="text" name="_state_" value="<?php echo $obj->state; ?>" />
    </div> <!-- END Column -->
</div> <!-- END ROW -->
<div class="section group"> <!-- ROW -->
    <div class="col span_4_of_12"> <!-- Column -->
        <span style="text-align:right; float:right; font-weight:bold">Zip</span>
    </div> <!-- END Column -->
    <div class="col span_4_of_12"> <!-- Column -->
        <input type="text" class="required" name="_zip_" value="<?php echo $obj->zip; ?>" />
    </div> <!-- END Column -->
</div> <!-- END ROW -->
<div class="section group"> <!-- ROW -->
    <div class="col span_4_of_12"> <!-- Column -->
        <span style="text-align:right; float:right; font-weight:bold">Phone</span>
    </div> <!-- END Column -->
    <div class="col span_4_of_12"> <!-- Column -->
    <input type="text" class="phoneUS" name="_phone_" value="<?php echo $obj->phone; ?>" />
    </div> <!-- END Column -->
</div> <!-- END ROW -->
<div class="section group"> <!-- ROW -->
    <div class="col span_4_of_12"> <!-- Column -->
        <span style="text-align:right; float:right; font-weight:bold">Email Address</span>
    </div> <!-- END Column -->
    <div class="col span_4_of_12"> <!-- Column -->
        <input type="text"  name="_email_address_" value="<?php echo $obj->email_address; ?>" />
    </div> <!-- END Column -->
</div> <!-- END ROW -->
<div class="section group"> <!-- ROW -->
    <div class="col span_1_of_12"> <!-- Column -->
    </div> <!-- END Column -->
    <div class="col span_5_of_12"> <!-- Column -->
    <button type="button" class="button ui-button ui-widget ui-state-default ui-button-text-only form_button" onclick="submit_cam_info('#customer_contact_form'); ">Submit</button>
    </div> <!-- END Column -->
</div> <!-- END ROW -->


<input type="hidden" name="account_id" value="<?php echo $obj->account_id; ?>" />

</form>


</div>

    </div> <!-- END Column -->
        <div class="col span_5_of_12"> <!-- Column -->

        <div class="ui-widget ui-widget-content  ui-corner-all container" >
        <p>Billing Contact Details ...</p>
        <p>Changes to your payment card and/or customer contact information are made directly to 
        (bix name website).</p>
        <p>For Privacy and Security information <a  target="_blank" href="https://aretexsaas.com/revolution-slider-fullwidth/security-policy/">(click here).</a></p>
        <hr />
        <p>To Contact 
            <?php echo $business_name;
            $email = $biz->Email_Address; 
            if (! empty($biz->Public_Email_Address))
                $email = $biz->Public_Email_Address;
        
            ?> ...
        </p>
        <div class="section group"> <!-- ROW -->
            <div class="col span_5_of_12"> <!-- Column -->
                <span style="text-align:right; float:right; font-weight:bold">Email</span>
            </div> <!-- END Column -->
            <div class="col span_6_of_12"> <!-- Column -->
                <?php echo $email; ?>
            </div> <!-- END Column -->
        </div> <!-- END ROW -->
        <div class="section group"> <!-- ROW -->
            <div class="col span_5_of_12"> <!-- Column -->
                <span style="text-align:right; float:right; font-weight:bold">Phone</span>
            </div> <!-- END Column -->
            <div class="col span_6_of_12"> <!-- Column -->
                <?php echo $biz->Customer_Service_Phone; ?>
            </div> <!-- END Column -->
        </div> <!-- END ROW -->
        <div class="section group"> <!-- ROW -->
            <div class="col span_5_of_12"> <!-- Column -->
                <span style="text-align:right; float:right; font-weight:bold">Mailing Address</span>
            </div> <!-- END Column -->
            <div class="col span_6_of_12"> <!-- Column -->
                <?php echo $biz->Mailing_Address; ?>
            </div> <!-- END Column -->
        </div> <!-- END ROW -->
        
        
        </div>
        </div> <!-- END Column -->
</div> <!-- END ROW -->