<?php  

global $payee;
global $business_name;
global $account_id;
global $user_email;
global $user_ID;

require_once(plugin_dir_path( __FILE__ ).'../ptrlib.php');

wp_get_current_user();

$current_user_id = $user_ID;


$signed_up = AreteX_WPI::payeeSignedUp($current_user_id);
$_SESSION['current_aretex_payee'] = $signed_up;

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

 if (strtolower($signed_up->contact_email) != strtolower($user_email)) {
?>    
    <p class="error" style="padding: 4px;">Your profile email address does not match your payee 
contact email address. This could cause reporting problems.</p>
<button class="button" onclick="wp_to_ptr_email('<?php echo $signed_up->contact_email; ?>');" type="button">Change my profile eMail  to <strong><em><?php echo $signed_up->contact_email;  ?></em></strong></button>

<?php
}    
?>
 <!-- Row 1 -->	
 <div class="section group">      
    

    
<div class="col span_6_of_12">

    <h2 style="text-align: center;"><? echo $business_name; ?> Payee Contact</h2>
    <div class="ui-widget ui-widget-header ui-corner-tr ui-corner-tl">
    <h3>Payee Contact Details </h3>
    </div>
    <div class="container ui-widget-content ui-corner-br ui-corner-bl">
    <? 
        $field_prompt=array('name'=>'Name',
                            'account_identifier'=>'Internal Payee Account Number');   
        displayObject($obj,$field_prompt);
        
        $obj = getResource('contact'); 
    ?>
    <form id="contact_form" action="javascript:void(0);" method="post"> 
    
    <div class="section group"> <!-- START ROW -->
        <div class="col span_1_of_12">&nbsp;</div>
        <div class="col span_8_of_12">
            <label for="name">Name</label><input style="width: 100%;" class="required text ui-widget-content ui-corner-all"  id="name" type="text" name="_name_" value="<? echo $obj->name; ?>" />
        </div>
    </div> <!-- END ROW -->
    <div class="section group"> <!-- START ROW -->
        <div class="col span_1_of_12">&nbsp;</div>
        <div class="col span_8_of_12">
            <label for="address">Address</label><textarea style="width: 100%" id="address" name="_address_" ><? echo $obj->address; ?></textarea>
        </div>
     </div> <!-- END ROW -->
     <div class="section group"> <!-- START ROW -->
        <div class="col span_1_of_12">&nbsp;</div>
        <div class="col span_8_of_12">            
            <label for="phone">Contact Phone</label><input style="width: 100%;" class="text ui-widget-content ui-corner-all"  id="phone" type="text" name="_phone_" value="<? echo $obj->phone; ?>" />
        </div>
     </div> <!-- END ROW -->
    <div class="section group"> <!-- START ROW -->
        <div class="col span_1_of_12">&nbsp;</div>
        <div class="col span_8_of_12">       <!-- readonly="readonly" -->
            <label for="email_address">Contact Email Address</label><input style="width: 100%;"  class="required email  ui-widget-content ui-corner-all"  id="email_address" type="text" name="_contact_email_" value="<? echo $obj->contact_email; ?>" />
        </div>
    </div><!-- END ROW -->
    
    
    
    <input type="hidden" name="account_id" value="<? echo $account_id; ?>" />
    <input type="hidden" name="urn" value="contact" />
    <div class="section group"> <!-- START ROW -->
        <div class="col span_1_of_12">&nbsp;</div>
        <div class="col span_8_of_12">       
    
          <a href="javascript:void(0);"  onclick="submit_contact_info();" class="icon_left_button ui-button button_link  ui-state-default ui-corner-all"  ><span class="ui-icon ui-icon-person"></span>Submit </a>
        </div>
    </div><!-- END ROW -->
    
     <input type="hidden" name="cmd" value="post" />
    
    </form>
</div>
</div>
<div class="col span_4_of_12">
 <h2 style="text-align: center;">Updating your Contact Information</h2>
    <div class="section group"> <!-- ROW -->
       <div class="col span_12_of_12"> <!-- Column -->
    
    <div class="ui-widget ui-widget-content ui-corner-all" style="padding-left: 10px;">
    <p>This contact information is how <? echo $business_name; ?>  (or its payment service providers) can get in touch with you regarding payments to you. This information is stored on AreteX&trade; servers, not <?php echo $business_name; ?> servers or your member profile on this site.
        For AreteX&trade; privacy and security information, <a href="https://aretexsaas.com/security-policy/" target="_blank">Click Here</a>.  
    If the information is not current, please fill out the form and select "Submit". </p>
    <h4>To Contact <? echo $business_name; ?></h4>
    <ul>
    <li><span style="text-align:right;  font-weight:bold">By Phone: </span><span id="by_phone"><? echo $business_contact_phone; ?></span></li>
    <li><span style="text-align:right;  font-weight:bold">By Email: </span><span id="by_email"><? echo $business_contact_email; ?></span></li>

    </ul>
        </div> <!-- END Column -->
    </div> <!-- END ROW -->
    <div class="section group"> <!-- ROW -->
      <div class="col span_12_of_12"> <!-- Column -->
        <div class="ui-widget ui-widget-content ui-corner-all" style="padding-left: 10px;">
        <p>Your contact email address is how you recieve automatic notifications regarding your payments.  Be certain it is accurate and up-to-date.</p>
        </div>
      </div> <!-- END Column -->
    </div> <!-- END ROW -->

    
    </div>
</div>

 </div>
 <!-- End Row 1 -->

<script>
jQuery(document).ready(function() {
  // init_buttons();
 });

<?php 

$ptr_direct_url = AreteX_WPI::ptrAjaxDirect();
$ajax_access_token = AreteX_WPI::ajaxAccessToken('master',true);
$ptr_direct_url = $ptr_direct_url."/index.php?aretex_ajax_auth=".$ajax_access_token;
?>
 
 function submit_contact_info()
 {
    jQuery('#contact_form').validate();
    if (jQuery('#contact_form').valid())
    {
        var q = jQuery('#contact_form').serialize();
        jQuery.ajax({
          type: 'POST',
          url: '<?php echo $ptr_direct_url;  ?>',
          data: q,
          success: function(data){
            load_ptr_page('contact');
          },
          error: function(xhr, type, exception) { 
            // if ajax fails display error alert
            alert("There was a problem updating your contact information. ");
          }
        });
    }
 }

</script>