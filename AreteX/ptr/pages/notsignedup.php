<?php $license = AreteX_WPI::getBasLicense(); 
$biz_toc_url = get_option('aretex_biz_toc');

?>
<div class="ui-widget-header ui-corner-top" >
<h2 style="text-align: center; margin-top: 5px; margin-bottom: 5px;"><?php echo $license->Business_Name; ?> Payee Agreement</h2>
</div>
<div class="ui-widget ui-widget-content  ui-corner-bottom container">
<div  id="plz_wait"></div>


<div class="section group"> <!-- ROW -->
    <div class="col span_11_of_12"> <!-- Column -->
    <p>To continue the authorization process, you must accept the Terms and Conditions of <?php echo $license->Business_Name; ?> and the 3B Alliance, AreteX&trade; terms and conditions.</p>
    </div> <!-- END Column -->
</div> <!-- END ROW -->
<div class="section group"> <!-- ROW -->
    <div class="col span_3_of_12"> <!-- Column -->
    <span style="text-align:right; float:right; font-weight:bold"><em><?php echo $license->Business_Name; ?></em> Terms and Conditions </span>
    </div> <!-- END Column -->
    <div class="col span_3_of_12"> <!-- Column -->
    <input style="width: 30px !important;" type="checkbox" id="biz_tos" onclick="agree_checked();"   />&nbsp; I Agree
    </div> <!-- END Column -->
    
</div> <!-- END ROW -->
<div class="section group"> <!-- ROW -->
    <div class="col span_4_of_12"> <!-- Column -->
    <span style=" float:right;">
       <a href="<?php echo $biz_toc_url; ?>" target="_blank">Click here for <?php echo $license->Business_Name;   ?> Terms and Conditions</a>
    </span>

    </div> <!-- END Column -->
</div> <!-- END ROW -->
<div class="section group"> <!-- ROW -->
    <div class="col span_3_of_12"> <!-- Column -->    
    <span style="text-align:right; float:right; font-weight:bold"><em>AreteX&trade;</em> Terms and Conditions</span>
     </div> <!-- END Column -->
    <div class="col span_3_of_12"> <!-- Column -->
    <input style="width: 30px !important;" type="checkbox" id="atx_tos" onclick="agree_checked();"  />&nbsp; I Agree
    </div> <!-- END Column -->
</div> <!-- END ROW -->
<div class="section group"> <!-- ROW -->
    <div class="col span_4_of_12"> <!-- Column -->
    <span style=" float:right;">
       <a href="http://3balliance.com/termsandconditions/3B%20Alliance%20T&C-1.pdf" target="_blank">Click here for AreteX&trade; Terms and Conditions</a>
    </span>

    </div> <!-- END Column -->
</div> <!-- END ROW -->

<div class="section group"> <!-- ROW -->
    <div class="col span_11_of_12"> <!-- Column -->            
    <div class="ui-widget-header ui-corner-top" >
    <h2 style="text-align: center; margin-top: 5px; margin-bottom: 5px;">Tax Form Notice</h2>
    </div>
    <div class="ui-widget ui-widget-content  ui-corner-bottom container" >
   <p>We know you are in a hurry to start earning revenues, but there is a Federal tax form that needs attention.
    We are required, by law, to collect a W9 from you for tax purposes. Your payouts will be limited until we receive your W9. </p>
    <p>You may download a W9 Form from the IRS at: <a href="http://www.irs.gov/Forms-&-Pubs" target="_blank">http://www.irs.gov/Forms-&-Pubs</a>. 
    When you have filled out the form, please mail it to:
    <div style="padding-left: 20px;">
<pre> 
<?php echo $license->Business_Name; ?> 
Attention: Payee Manager
<?php echo $license->Mailing_Address; ?> 
    </pre>
    </div>
     </p>
    </div>    
    </div> <!-- END Column -->
</div> <!-- END ROW -->

<div id="ready_to_sign_up">
<form id="reg_form" action="javascript:void(0);">
<?php  
    /*
     update_user_meta( $new_user_id, 'atx_payee_email', $registration_options['email']); // This is the payee email on file with AreteX
                update_user_meta( $new_user_id, 'atx_payee_name', $registration_options['_name_']); // This is the payee name (pay to the order of ...) on file with AreteX
                update_user_meta( $new_user_id, 'atx_payee_address', $registration_options['_address_']); // This is the payee mailing address on file with AreteX
                update_user_meta( $new_user_id, 'atx_payee_phone', $registration_options['_phone_']); // This is the payee phone on file with AreteX

    */
        $user_id =  get_current_user_id();
        $payee_email = get_user_meta($user_id, 'atx_payee_email', true);
        $payee_name  = get_user_meta($user_id, 'atx_payee_name', true );
        $atx_payee_address  = get_user_meta($user_id, 'atx_payee_address', true );
        
        $atx_payee_phone  = get_user_meta($user_id, 'atx_payee_phone', true );   
?>
<div class="section group"> <!-- ROW -->
    <div class="col span_3_of_12"> <!-- Column -->
    <span style="text-align:right; float:right; font-weight:bold">Payee Email</span>
    </div> <!-- END Column -->
    <div class="col span_4_of_12"> <!-- Column -->
    <input id="payee_email" name="_contact_email_" class="required email" value="<?php echo $payee_email ?>" />
    </div> <!-- END Column -->
</div> <!-- END ROW -->


<div class="section group"> <!-- ROW -->
    <div class="col span_3_of_12"> <!-- Column -->
    <span style="text-align:right; float:right; font-weight:bold">Payee Name</span>
    </div> <!-- END Column -->
    <div class="col span_4_of_12"> <!-- Column -->
    <input id="payee_name" class="required" name="_name_" value="<?php echo $payee_name ?>" />
    </div> <!-- END Column -->
</div> <!-- END ROW -->

<div class="section group"> <!-- ROW -->
    <div class="col span_3_of_12"> <!-- Column -->
    <span style="text-align:right; float:right; font-weight:bold">Payee Address</span>
    </div> <!-- END Column -->
    <div class="col span_4_of_12"> <!-- Column -->
    <textarea id="payee_address" class="required" name="_address_"  ><?php echo $atx_payee_address; ?></textarea>
    </div> <!-- END Column -->
</div> <!-- END ROW -->

<div class="section group"> <!-- ROW -->
    <div class="col span_3_of_12"> <!-- Column -->
    <span style="text-align:right; float:right; font-weight:bold">Payee Phone</span>
    </div> <!-- END Column -->
    <div class="col span_4_of_12"> <!-- Column -->
    <input id="payee_phone" name="_phone_" class="required phoneUS" value="<?php echo $atx_payee_phone;?>" />
    </div> <!-- END Column -->
</div> <!-- END ROW -->

<div class="section group"> <!-- ROW -->
    <div class="col span_3_of_12"> <!-- Column -->
    <span style="text-align:right; float:right; font-weight:bold">Register to Recieve Payments</span>
    </div> <!-- END Column -->
    <div class="col span_4_of_12"> <!-- Column -->
    <button type="button" style="padding: 3px;" onclick="ajax_payee_register();" class="ui-button button_link  ui-state-default ui-corner-all"  ><span style="display: inline-block; position: relative; top:3px;" class="ui-icon ui-icon-circle-check"></span>Register</button>
    </div> <!-- END Column -->
</div> <!-- END ROW -->
<div class="section group"> <!-- ROW -->
    <div class="col span_7_of_12"> <!-- Column -->
    <p><em>Note:</em>This information will be sent to the AreteX&trade; payment servers. <a href="https://aretexsaas.com/security-policy/" target="_blank">Click here</a> for our privacy and security information.</p>
    </div> <!-- END Column -->
</div> <!-- END ROW -->

</div>
</div>
<script>
 jQuery('#ready_to_sign_up').hide();
 function agree_checked() {
   if (jQuery('#biz_tos').is(':checked') && jQuery('#atx_tos').is(':checked')) {
        jQuery('#ready_to_sign_up').show();
   }
   else {
        jQuery('#ready_to_sign_up').hide();
   }
    
 }
 
 function ajax_payee_register(){
    jQuery(function ($) {                
    	
        
        $('#reg_form').validate();
        if ($('#reg_form').valid()){
            
            $('#plz_wait').html('<hr/><center><strong>... Please Wait ...</strong></center><hr/>');
            var reg_data  = $('#reg_form').serialize();
            var data = {
        		action: 'atx_payee_complete',
        		data: reg_data
            };
            	
        	$.post(ajaxurl, data, function(response) {
        	   var obj = JSON.parse(response);
                if (obj.errors) {
                     $('#plz_wait').html('');
                for(var i = 0; i < obj.errors.length; ++i ){
                      err = obj.errors[i];
                      $('#'+err.element).after('<label class="error aretex_reg_error">'+err.message+'</label>');
                    }
                    return;
                }                     	  
                else
        	       location.reload();
        	});
        }
    
    });  
}
 
</script>