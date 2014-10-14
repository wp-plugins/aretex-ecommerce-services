<div class="tabs">
<ul>
<li><a href="#tabs-1a">Tracking Code Generator</a></li>
<li><a href="#tabs-2a">Tracking Code Validator</a></li>
</ul>
<div id="tabs-1a">

<?php $commission_groups = AreteX_WPI::getBsuCommissionGroups(); 
    if (count($commission_groups) == 0) {
     
     echo '<label class="error">Warning: No commission groups are set up yet. You will not be able to generate tracking codes to pay commissions for referrerals. (After you set up commession groups, you must add referrers.)</label>';   
        
    }
    else {
        $summary = AreteX_WPI::getBsuCommissionSummary();
        $total_payees = $summary['payee_count'];
        $total_assigned = 0;
        if (is_array($summary['commission_groups'])) {
            foreach($summary['commission_groups'] as $group_summary) {
                $total_assigned += $group_summary['number_payees'];
            }
        }
        if ($total_assigned == 0) {
                 echo '<label class="error">Warning: You have <strong>not assigned</strong> any payees to commission groups as <em>referrers</em>. You will not be able to generate tracking codes to pay commissions for referrerals.</label>';   

        }
    }
?>

<div class="section group"> <!-- ROW -->
    <div class="col span_8_of_12"> <!-- Column -->
    <div class="ui-widget-header ui-corner-top" >
<h2 style="text-align: center; margin-top: 5px; margin-bottom: 5px;">Tracking Code Generator</h2>
</div>
<div class="ui-widget ui-widget-content  ui-corner-bottom" >
<div class="section group"> <!-- ROW -->
    <div class="col span_5_of_12"> <!-- Column -->
    <span style="text-align:right; float:right; font-weight:bold">Offer Code</span>
    </div> <!-- END Column -->
    <div class="col span_6_of_12"> <!-- Column -->
    <select id="gen_offer_offer_code">
     <?php
        $offer_codes = AreteX_WPI::getAllOffers();
        foreach($offer_codes as $offer_code) {
            $offer_code = get_object_vars($offer_code);
            $offer_name = substr($offer_code['offer_name'],0,25);
            echo "<option value=\"{$offer_code['offer_code']}\">{$offer_code['offer_code']} - $offer_name </option>\n";
        }
     ?>
     </select>      
    </div> <!-- END Column -->
</div> <!-- END ROW -->

<div class="section group"> <!-- ROW -->
    <div class="col span_5_of_12"> <!-- Column -->
    <span style="text-align:right; float:right; font-weight:bold">Source Media</span>
    </div> <!-- END Column -->
    <div class="col span_6_of_12"> <!-- Column -->
    <select id="media_code">
    <?php
    $source_media = AreteX_WPI::getAllSourceMedia();
    foreach($source_media as $source) {
        $source = get_object_vars($source);
        echo "<option value=\"{$source['source_id']}\">{$source['source_id']} - {$source['description']}  </option>\n";

    }
   
    ?>
    </select>   
    </div> <!-- END Column -->
</div> <!-- END ROW -->

<div class="section group"> <!-- ROW -->
    <div class="col span_5_of_12"> <!-- Column -->
    <span style="text-align:right; float:right; font-weight:bold">Referrer Search</span>
    </div> <!-- END Column -->
    <div class="col span_4_of_12"> <!-- Column -->
   <input id="find_payee" type="text" />
    <script>
    <?php echo AreteX_WPI::jsPayeeSearchByOffer('find_payee','gen_offer_offer_code');     
    ?>
    </script>
    <span id="payee_req_note"><br /><label class="error">You must have a valid referrer or select "No Referrer".</label></span>
    <input id="payee_id" type="hidden" />
    <input id="payee_name" type="hidden" />
    <input id="payee_email" type="hidden" />
    <input id="wp_id" type="hidden" />
    </div> <!-- END Column -->
    <div class="col span_3_of_12"> <!-- Column -->
    <input id="no_payee_id" type="checkbox" onclick="clear_referrer();"  /> No Referrer
    </div> <!-- END Column -->
</div> <!-- END ROW -->

<div class="section group"> <!-- ROW -->
    <div class="col span_5_of_12"> <!-- Column -->
    <span style="text-align:right; float:right; font-weight:bold">Splash Code</span>
    <br /><span style="text-align:right; float:right;">(Optional)</span>
    </div> <!-- END Column -->
    <div class="col span_3_of_12"> <!-- Column -->
    <input id="splash_code" /> <br />
       
    </div> <!-- END Column -->
</div> <!-- END ROW -->
<div class="section group"> <!-- ROW -->    
    <div class="col span_5_of_12"> <!-- Column -->
    <div style="float: right;">
    <a href="javascript:void(0);"  onclick="generate_tracking_code();"
class="ui-button  icon_left_button button_link  ui-state-default ui-corner-all"  >
<span class="ui-icon  ui-icon-tag"></span> 
Generate</a>
    </div>
    </div> <!-- END Column -->
</div> <!-- END ROW -->

<div class="section group"> <!-- ROW -->
    <div class="col span_12_of_12"> <!-- Column -->

<div id="advanced_tracking_code" class="ui-widget ui-widget-content  ui-corner-all dbui-frame" style="padding: 10px; margin: 10px;" >
<div style="width: 100%; text-align:center; font-weight:bold;"> Generated Tracking Code </div><br /><br />

<label>Standard Tracking Code</label>
<span style="font-family: 'Courier New', Courier, monospace; font-size: 10pt;" id="std_trck_code"></span><br />
<p>Copy and paste this tracking code into your marketing materials (or other communication) with instructions to enter it into your "Coupon Box". (See <em>WP Integration / Shortcodes &amp; Widgets / Coupons &amp; Tracking</em> for information on Coupon boxes).</p>
<p>You may wish to copy and paste this Standard Tracking Code into the Tracking Code Validator.</p>
<label>Tracking URL</label>
<span style="font-family: 'Courier New', Courier, monospace; font-size: 10pt;" id="std_trck_code_url"></span>
<p>You may copy and paste this onto websites, emails, social media etc. for "click through" based tracking.</p>

<br /><br />
<div id="splash_code_section">
<label>Splash Code</label>
<span style="font-family: 'Courier New', Courier, monospace; font-size: 10pt;" id="the_splash_code"></span>
<br /><br />
<a href="javascript:void(0);"  onclick="confirm_splash_code();"
class="ui-button  icon_left_button button_link  ui-state-default ui-corner-all"  >
<span class="ui-icon  ui-icon-circle-check"></span> 
Confirm Splash Code</a>
<p>If you confirm, the Splash Code: <span style="text-decoration: underline; font-weight: bold; font-family: 'Courier New', Courier, monospace; font-size: 10pt;" id="the_splash_code2"></span>
will be a synoymn for: <span style="text-decoration: underline; font-weight: bold;  font-family: 'Courier New', Courier, monospace; font-size: 10pt;" id="std_trck_code2"></span><br /> 
</p>
</div>
<div id="splash_code_invalid">
<p>The Splash Code: <span style="text-decoration: underline; font-weight: bold; font-family: 'Courier New', Courier, monospace; font-size: 10pt;" id="the_splash_code3"></span>
is already in use or is invalid. 
</p>
</div>


</div>
<div id="no_validtracking_code" class="ui-widget ui-widget-content  ui-corner-all dbui-frame" style="padding: 10px; margin: 10px;" >
<p><strong>No valid tracking code</strong> can be generated for the options you selected.</p>
1. Be sure your payee is registered<br />
2. Be certain your payee is a member of a Commission Group<br />
3. Be certain your payee's Commission Group is authorized to present the offer you selected<br />
4. Be certain the offer you selected has not expired<br />
 

</div>



    </div> <!-- END Column -->
</div> <!-- END ROW -->

</div>
    
    
    </div> <!-- END Column -->
    <div class="col span_4_of_12"> <!-- Column -->

<div class="ui-widget ui-widget-content  ui-corner-all container" >
<strong>Tracking Code Generator</strong>
<p>This form will allow you to generate tracking codes (and optionally allows you to a assign a Splash Code) for specific Referrers and specific offers.
<br /><br /><strong>Offer Code</strong> - Select from any offer you set up on the <em>Offer Codes</em> menu tab.
<br /><strong>Source Media</strong> - Select from any Source Media you set up in the <em>Source Media</em> menu tab.
<br /><strong>Referrer Search</strong> - Begin typing a Referrer's name or email address. Only payees authorized to present the selected offer will be shown in the search results.
<br /><strong>Splash Code</strong> - Splash codes are "easy to remember" words or phrases that you 
can assign to a particular tracking code. They allow you to "splash" your specific offer across 
advertisements. Each Splash Code must be unique and assigned to a specific offer. 
</p>
<p><em><strong>Note</strong></em> - When you select <em>Generate</em> to create your Tracking Code, and you have assigned a 
Splash Code - You Will Need to Confirm the Splash Code choice.</p>
</div>
    </div> <!-- END Column -->
</div> <!-- END ROW -->
</div>
<div id="tabs-2a">

<div class="section group"> <!-- ROW -->
    <div class="col span_8_of_12"> <!-- Column -->
    
    <div class="ui-widget-header ui-corner-top" >
    <h2 style="text-align: center; margin-top: 5px; margin-bottom: 5px;">Validate Tracking Code</h2>
    </div>
    <div class="ui-widget ui-widget-content  ui-corner-bottom" >
     
    <div class="section group"> <!-- ROW -->
        <div class="col span_5_of_12"> <!-- Column -->
        <span style="text-align:right; float:right; font-weight:bold">Tracking (or Splash) Code to Validate</span>
        </div> <!-- END Column -->
        <div class="col span_4_of_12"> <!-- Column -->
        <input id="tracking_to_validate"  />
        </div> <!-- END Column -->
        <div class="col span_3_of_12"> <!-- Column -->
        <a href="javascript:void(0);"  onclick="validate_this();"
        class="ui-button  icon_left_button button_link  ui-state-default ui-corner-all"  >
        <span class="ui-icon  ui-icon-circle-check"></span> 
        Validate</a>
        </div> <!-- END Column -->
    </div> <!-- END ROW -->
    <div class="section group"> <!-- ROW -->
        <div class="col span_1_of_12"> <!-- Column -->
        </div> <!-- END Column -->
        <div class="col span_10_of_12"> <!-- Column -->
        <div id="tracking_code_summary_box" class="ui-widget ui-widget-content  ui-corner-all container" style="padding: 10px;" >
        
        
        
        </div>
        </div> <!-- END Column -->
    </div> <!-- END ROW -->
     
    </div>
    
    </div> <!-- END Column -->
    <div class="col span_4_of_12"> <!-- Column -->

    <div class="ui-widget ui-widget-content  ui-corner-all container" >
    <p>Enter a Tracking Code (or Splash Code) to validate. (Do not enter the URL.) If the Tracking Code/Splash 
    Code is valid, you will see a summary of what it will track.</p>
    </div>
    </div> <!-- END Column -->
</div> <!-- END ROW -->



</div>

</div>
<script>
jQuery('.tabs').tabs();
jQuery('#advanced_tracking_code').hide();
jQuery('#splash_code_section').hide();
jQuery('#splash_code_invalid').hide();
jQuery('#tracking_code_summary_box').hide();
jQuery('#no_validtracking_code').hide();
 jQuery('#payee_req_note').hide();

function clear_referrer() {
    
    jQuery('#payee_req_note').hide();
    if (jQuery('#no_payee_id').is(':checked')) {
        jQuery('#find_payee').val('');
        jQuery('#payee_id').val('');        
    }
}

function validate_payee() {
    if (jQuery('#no_payee_id').is(':checked')) {
        jQuery('#no_validtracking_code').hide();
        return true;
    }
    var payee_id = jQuery('#payee_id').val();
    if (! payee_id) {
        jQuery('#payee_req_note').show();
        jQuery('#no_validtracking_code').show();
        return false;  
    }
    return true;
}

function validate_this()
{
    var tr = jQuery('#tracking_to_validate').val();
    var is_valid = validate_tracking_code(tr);
    if (! is_valid) {
        jQuery('#tracking_code_summary_box').html('<strong>'+tr+'</strong> is not a valid tracking code');
        jQuery('#tracking_code_summary_box').show();
    }
    else
    {

      

        var valid_html = '';
        valid_html += '<strong>Valid Tracking Code Summary</strong>';        
        valid_html += '<p><strong>Tracking Code as Submitted: </strong>'+is_valid.original+'<br/>';
        valid_html += '<strong>Standard Tracking Code: </strong>'+is_valid.standard+'<br/>';
        valid_html += '<strong>Offer Description: </strong>'+is_valid.summary.description+'<br/>';
        valid_html += '<strong>Offer Expires: </strong>'+is_valid.summary.expires+'<br/>';
        if (is_valid.summary.commission_group_count == 0) {
            valid_html += '<strong>Offer Not Limited by Commission Group </strong><br/>';
        }
        if (is_valid.summary.commission_group_count > 0) {
            valid_html += '<strong>Number of Commission Groups:'+is_valid.summary.commission_group_count+'</strong><br/>';
            valid_html += '<span style="font-size="11px;">See <em>Offer Codes</em> menu tab for which Commission Group(s).</span><br/>'
        }
        valid_html += '<strong>Offer Applies To: </strong>'+is_valid.summary.applies_to+'<br/>';
        valid_html += '<strong>Referrer Name: </strong>'+is_valid.summary.rep+'<br/>';
        valid_html += '<strong>Referrer Payee ID: </strong>'+is_valid.summary.rep_id+'<br/>';
        valid_html += '<strong>Media Source ID: </strong>'+is_valid.summary.media+'<br/>';
        valid_html += '</p>';
        jQuery('#tracking_code_summary_box').html(valid_html);
        jQuery('#tracking_code_summary_box').show();

    }applies_to
    console.log(is_valid);
}

var current_tracking_code;
function confirm_splash_code() {
    
         var splash_code = jQuery('#splash_code').val();
    
       jQuery.ajax({
          type: 'POST',
          url: ajaxurl,
          async: false, 
          dataType: 'json',
          data: {
            action: 'atx_create_splash_code',
            data: {
              tracking_code:  current_tracking_code,
              splash_code: splash_code 
            }
            
          },
          success: function(data){
            if (data)
                alert('Splash Code Confirmed');
            else
                alert('There was a problem');
                                                            
          },
           error: function(xhr, type, exception) { 
            // if ajax fails display error alert
            alert("ajax error  "+exception);
          } 
          
        });
    
    
}

function generate_tracking_code() {
   jQuery('#no_validtracking_code').hide();
   
   if (! validate_payee()) {
    return false;
   }
   var offer_code = jQuery('#gen_offer_offer_code').val();
   var media = jQuery('#media_code').val();
   var payee = jQuery('#payee_id').val();
   if (! payee) {
        payee = '0';
   }
   var splash_code = jQuery('#splash_code').val();
   if (splash_code) {
    
    var splash_valid = validate_tracking_code(splash_code);
    console.log(splash_valid);
    if (! splash_valid) { // Not valid, so it's "open"
        jQuery('#the_splash_code').html(splash_code);
        jQuery('#the_splash_code2').html(splash_code);
        jQuery('#splash_code_section').show();
    }
    else{
        jQuery('#splash_code_section').hide();
        jQuery('#the_splash_code3').html(splash_code);
        jQuery('#splash_code_invalid').show();
    }
    
    
   }
   jQuery.ajax({
          type: 'POST',
          url: ajaxurl,
          async: false, 
          dataType: 'json',
          data: {
            action: 'atx_full_tracking',
            offer: offer_code,
            media: media,
            payee: payee
          },
          success: function(data){
            
             current_tracking_code = data.code;
             if (! current_tracking_code) {
                 jQuery('#no_validtracking_code').show();
                 jQuery('#advanced_tracking_code').hide();
             }
             else {
                 jQuery('#advanced_tracking_code').show();
                 jQuery('#std_trck_code').html(data.code);
                 jQuery('#std_trck_code2').html(data.code);
                 jQuery('#std_trck_code_url').html(data.url);
             }
                                                            
          }
          
        });
       
} 
   
   
   
</script>