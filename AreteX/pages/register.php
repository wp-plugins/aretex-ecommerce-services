<?php
$res = AreteX_WPI::check_sandbox();
$sandbox_message = '';
if ($res['allow_free'] != 'Yes')
{
    if ($res['sandbox_message']) {
        $sandbox_message = $res['sandbox_message'];
    }
    else
        $sandbox_message = 'Free Sandbox Accounts are Temporarily Unavialble';
}


if (! empty($sandbox_message)) {
    $sandbox_message = '<div class="error">'.$sandbox_message.'</div>';
}
?>
<div style="padding: 10px;" > 
<h1>AreteX&trade; eCommerce Services Registration</h1>
<div class="tabs">
<ul>
<li><a href="#tabs-1">Register</a></li>
<li><a href="#tabs-2">Introduction</a></li>
<li><a href="#tabs-3">Identity Key Recovery</a></li>
</ul>
<div id="tabs-1">
<div class="section group"> <!-- ROW -->
    <div class="col span_8_of_12"> <!-- Column -->
        <div class="ui-widget-header ui-corner-top" >
            <h2 style="text-align: center; margin-top: 5px; margin-bottom: 5px;">Register for  30 Day Free AreteX&trade;  Sandbox Account</h2>
        </div>
        <div class="ui-widget ui-widget-content  ui-corner-bottom"  style="padding: 5px;">
        <!-- BRUMBAUGH!!! -->
        <!--
        <p><a onclick="ajax_have_license();" class="ui-button button">I Have a License Key</a>&nbsp;</p>
        -->
        <?php echo $sandbox_message; ?>
        <hr />
        <p id="plz_wait" style="text-align: center;"></p>
            <form id="reg_form">

            <fieldset>
            	<legend>Business Information</legend>
                <div class="section group"> <!-- ROW -->                                    
                    <div class="col span_6_of_12"> <!-- Column -->
                        <label for="biz_name">Business Name</label><input type="text" name="_Business_Name_" id="biz_name" class="required" />
                    </div> <!-- END Column -->
                    <div class="col span_6_of_12"> <!-- Column -->
                        <label for="primary_contact_name">Full Name of Primary Contact</label><input class="required" minlength="5" type="text" name="_Primary_Contact_Name_" id="primary_contact_name" />
                    </div> <!-- END Column -->
                </div> <!-- END ROW -->
                <div class="section group"> <!-- ROW -->                                    
                    <div class="col span_6_of_12"> <!-- Column -->
                        <label for="email_address">Email Address</label><input type="text" id="email_address" name="_Email_Address_" value="<?php echo get_option('admin_email'); ?>" class="required email" />
                    </div> <!-- END Column -->
                    <div class="col span_6_of_12"> <!-- Column -->
                    <label for="primary_phone">Primary Business Phone</label><input name="_Primary_Phone_" id="primary_phone" class="required phoneUS" type="text" />
                        
                    </div> <!-- END Column -->
                </div> <!-- END ROW -->
                <div class="section group"> <!-- ROW -->                                    
                    <div class="col span_12_of_12"> <!-- Column -->
                        <label>Mailing Address</label><textarea id="mailing_address" style="margin-right: 3px;" class="required" name="_Mailing_Address_"></textarea>
                    </div> <!-- END Column -->                    
                </div> <!-- END ROW -->
                <div class="section group"> <!-- ROW -->
                    <div class="col span_12_of_12"> <!-- Column -->
                    <span style="font-size: 80%;"><a href="http://3balliance.com/termsandconditions/3BA%20Privacy%20Policy.pdf" target="_blank">Privacy Policy</a></span>&nbsp;&nbsp;&nbsp;
                    <span style="font-size: 80%;"><a href="https://aretexsaas.com/security-policy/" target="_blank">Security Policies</a></span>
                    </div> <!-- END Column -->
                </div> <!-- END ROW -->
                </fieldset>
                <fieldset>
                <legend>Agreement</legend>
                <div class="section group"> <!-- ROW -->                                     
                    <div class="col span_12_of_12"> <!-- Column -->
                         <label style="display: inline;">I am a developer, this is for a client.</label><input style="width: 30px;" name="am_developer" value="yes" id="am_developer" type="checkbox" />
                        <p>I Agree to <a href="http://www.3balliance.com/termsandconditions/" target="_blank">3B Alliance, LLC Terms &amp; Conditions</a> &amp; the <a target="_blank" href="http://3balliance.com/termsandconditions/AreteX%20EULA.pdf">AreteX&trade; EULA</a></p>
                        <label style="display: inline;">I Agree</label><input style="width: 30px;" class="required" name="i_agree" value="yes" id="i_agree"  type="checkbox" />
                    </div> <!-- END Column -->                
                 </div> <!-- END ROW -->

                 <input type="hidden" name="master_site_url[site_name]" value="<?php echo get_bloginfo('name'); ?>" />
                 <input type="hidden" name="master_site_url[site_url]" value="<?php echo site_url('','https'); ?>" />
                 <div class="section group"> <!-- ROW -->
                    <div class="col span_12_of_12"> <!-- Column -->
                    <?php if (isset($res['ssl']) && $res['ssl'] == 'No') { ?>
                    <strong>Please Use SSL to Allow Registration</strong>
                    <?php } else { ?>
                        <a href="javascript:void(0);"  onclick="ajax_register();" 
                        class="ui-button button icon_left_button button_link  ui-state-default ui-corner-all"  >
                        <span class="ui-icon  ui-icon-check">&nbsp;&nbsp;</span> 
                        &nbsp;&nbsp;Register Now</a>
                    <?php } ?>
                    </div> <!-- END Column -->
                </div> <!-- END ROW -->
               
                </fieldset>
            </form>
        </div>
    </div> <!-- END Column -->
    <div class="col span_4_of_12"> <!-- Column -->

        <div class="ui-widget ui-widget-content  ui-corner-all container" >
        <strong>Free Sandbox Registration</strong>
        <p>Currently, you may only have one site per license/one license per email address.  If you need another license on the same email address, contact us through this <a href="https://aretex.org/support" target="_blank">Support Link</a> and we will work with you.
        </p>
        <p>
        Under the Agreement section you cannot register for the AreteX&trade; plugin without agreeing to the 3B Alliance Terms &amp; Conditions and the AreteX EULA (End User License Agreement).  This is true if you are a developer or not.
        </p>
        <p><em><strong>Note:</strong></em> This plugin for AreteX&trade; is "Serviceware".  Most  of the eCommerce information is stored and all of the major processing occurs on the AreteX&trade; servers.  
        This plugin acts as the interface to AreteX&trade; eCommerce Services.</p>
        <p><em><strong>Important Security Note:</strong></em>You must be running with "Transport Layer Security/SSL" (i.e. <strong>https</strong>) on your server for AreteX&trade; to operate.</p>        
        </div>
    </div> <!-- END Column -->
</div> <!-- END ROW -->
</div>
<div id="tabs-2">
        <div class="ui-widget-header ui-corner-top" >
            <h2 style="text-align: center; margin-top: 5px; margin-bottom: 5px;">Information</h2>
        </div>
        <div class="ui-widget ui-widget-content  ui-corner-bottom dbui-frame" style="padding-left: 5px;" >
            <h4>What is AreteX&trade;?</h4>
            <p>AreteX&trade; is a PCI Compliant, server-based eCommerce solution, which performs and 
            orchestrates a variety of digital transactions from sales and marketing to tracking and 
            reporting. Within WordPress AreteX&trade; handles a variety of digital products: including file access, as well as membership and subscription management.</p>
            <p><em><strong>Note:</strong></em> This plugin for AreteX&trade; is "Serviceware".  Most  of the eCommerce information is stored and all of the major processing occurs on the AreteX&trade; servers.  
        This plugin acts as the interface to AreteX&trade; eCommerce Services.</p>
            <h4>What Does it Do?</h4>
            <ul>
                <li>With AreteX&trade;, you can receive credit card payments (one time or recurring) with the integrated payment gateway through Vantiv.</li> 
                <li>Authenticates access for your customers to download files or view restricted content.</li>
                <li>Instantly computes royalties, commissions, splits and similar monies owed at the time of sale.</li>
                <li>Automatically pays affiliates, sales reps, vendors, suppliers and contributors with Direct Deposit through Forte (formerly ACH Direct).</li>
                <li>Provides a full range of tracking and reporting for affiliates, vendors, contributors and suppliers.</li>
                <li>Allows you to give full purchase and payment history to your customers.</li>
            </ul>
            <h4>What are the Licenses and How Much Does It Cost?</h4>
            <ul>
                <li>The <strong>Sandbox Trial License</strong> is a <em>free 30-day trial period</em> in which you may browse through the AreteX&trade; features and set up a limited number of products for sale.  This license <em><strong>does not</strong> process real money</em>, as it does not connect to "real money gateways."  Fake credit cards are provided so you can see how the whole process works.</li>
                <li>The <strong>Sandbox Paid License</strong> is a <em>fully functional development environment</em> that allows you to set up your business eCommerce site without risking accidental charges.  This license <em><strong>does not</strong> process real money</em>, as it does not connect to "real money gateways."  Fake credit cards are provided so you can see how the whole process works.  The Paid License is only <strong>$5.00 per month</strong> and is set up on a recurring billing cycle.</li>
                <li>The <strong>Live License</strong> is a <em>fully functional eCommerce system of services</em>.  It is accessed by transitioning from one of the Sandbox licenses.  Fees include a <em>one-time setup fee of $50.00</em>; an automatic <em>monthly $15.00</em> license fee; and a gateway service fee of <em>1.5% of all incoming transactions</em>.  Other services may be accessed for additional fees as they become available.</li>
                <li>3rd Party Merchant Account fees will apply.  They will be directly billed to you, separately from the AreteX fees.  Vantiv is our credit card processer.  Forte is our ACH/Direct Deposit processer.  (Note: AreteX&trade; Live License fees may differ for 3rd Party Merchant Accounts not originated through 3B Alliance, LLC.)</li>

            </ul>
            <h4>About Vantiv</h4>
            <ul>
            <li>You will need a Vantiv Merchant account to use AreteX&trade; eCommerce Services.</li>
            <li>Vantiv, Inc. is a publicly-traded listed on the NYSE under the ticker symbol "VNTV".</li>
            <li>Vantiv has been providing innovative payment processing solutions for over 40 years.</li>
            <li>AreteX&trade; is a certified Vantiv Solution Builder application.</li> 
            <li>3B Alliance is an Independant Software Partner with Vantiv.</li>

            </ul>
            <h4>About Forte</h4>
            <ul>
            <li>Forte (formerly known as ACH Direct) has been a leader in ACH processing since 1998.</li>
            <li>You must have an account with Forte to automate direct deposits with AreteX&trade;</li>
            <li>3B Alliance is a Forte Authorized Payment Transmitter.</li>
            <li>3B Alliance is an Independant Software Partner with Forte.</li>
            </ul>
        </div>

</div>
<div id="tabs-3">


<div class="section group"> <!-- ROW -->
    <div class="col span_7_of_12"> <!-- Column -->
    <div class="ui-widget-header ui-corner-top" >
    <h2 style="text-align: center; margin-top: 5px; margin-bottom: 5px;">Replace Identity Keys</h2>
    </div>
    <div class="ui-widget ui-widget-content  ui-corner-bottom" style="padding: 5px;" >
<form id="replace_id_form">
    <a href="javascript:void(0);"  onclick="load_act_page('account_pages/licenses');"
        class="ui-button  icon_left_button button_link  ui-state-default ui-corner-all"  >
        <span class="ui-icon  ui-icon-circle-arrow-w"></span> 
        Back</a>
        <p>Paste the <em>AreteX Key Replacement Request</em> you in your email below.</p>
        <strong>AreteX Key Replacement Request</strong>
        <textarea id="replacement_request" style="width: 100%; height: 300px;"></textarea>
        <a href="javascript:void(0);" onclick="submit_replace_key();" class="ui-button  icon_left_button button_link  ui-state-default ui-corner-all"  >
<span class="ui-icon  ui-icon-circle-check"></span> 
Submit Key Replacement Rquest</a>
</form>
    </div>
    </div> <!-- END Column -->
    <div class="col span_5_of_12"> <!-- Column -->
    <div class="ui-widget ui-widget-content  ui-corner-all container" style="margin-right: 3px;" >
    <strong>Identity Keys</strong>
    <p>For use if: 1) You know or suspect your server has been compromised or 2) You have accidently deleted your identity keys.</p>
    <p>Open a support ticket and ask for an "Aretex Key Replacement Request" from 3B Alliance, LLC. There may be a charge for this service. </p>
    <p>The AreteX Key Replacement Request will be emailed to your Primary Email Address. </p>
    <p>Copy and paste everything in the request starting with<br /> <strong>--- BEGIN ARETEX KEY REPLACEMENT REQUEST ---</strong><br /> 
    up to and including<br /> <strong>--- END ARETEX KEY REPLACEMENT REQUEST ---</strong>.
    </p>
    <p>After you have pasted the <em>AreteX Key Replacement Request</em> into the text area, choose
    <em>Submit Key Replacement Rquest</em>. 
    </p>
    
    </div>
    </div> <!-- END Column -->    
</div> <!-- END ROW -->
<script>
function submit_replace_key()
{
    jQuery(function ($) { 

              $.ajax({
              type: 'POST',
              url: ajaxurl,
              data: {
		      action: 'atx_replace_id_key',
              data: $('#replacement_request').val()
	          },              
              success: function(data){
                                
                alert(data);
                location.reload();
              },
              error: function(xhr, type, exception) {
               
                // if ajax fails display error alert
                  alert("ajax error response type "+type);
                 
              }
            });
        
    
    });
 }  


</script>








</div>
</div>
<script>
jQuery(document).ready(function() {
   jQuery('.tabs').tabs();
 });

</script>



<script>



function ajax_register(){
    jQuery(function ($) {                
    	
        
        $('#reg_form').validate();
        if ($('#reg_form').valid()){
            
            $('#plz_wait').html('<strong>... Please Wait ...</strong>');
            var reg_data  = $('#reg_form').serialize();
            var data = {
    		action: 'register',
    		regdata: reg_data
    	};
            	
        	$.post(ajaxurl, data, function(response) {
        	    location.reload();
        	});
        }
    
    });  
}

</script>