<div class="tabs">
<ul>
<li><a href="#tabs-1">Configuration Settings</a></li>
<li><a href="#tabs-2">Information</a></li>
</ul>
<div id="tabs-1">

<p><em><strong>Note</strong>:</em> These configuration settings are stored in your WordPress database, <em>not</em> the AreteX&trade; Server.</p>

<div class="section group"> <!-- ROW -->
    <div class="col span_7_of_12"> <!-- Column -->
        <form id="ptr_config_form" action="javascript:void(0);">
            <div class="ui-widget-header ui-corner-top" >
            <h2 style="text-align: center; margin-top: 5px; margin-bottom: 5px;">Configuration Settings</h2>
            </div>
            <div class="ui-widget ui-widget-content  ui-corner-bottom dbui-frame" style="padding: 3px;" >

            <div class="section group"> <!-- ROW -->
                <div class="col span_5_of_12"> <!-- Column -->
                <span style="text-align:right; float:right; font-weight:bold">Terms and Conditions  Link</span>
                </div> <!-- END Column -->
                <div class="col span_7_of_12"> <!-- Column -->
                <?php $tos_link = get_option('aretex_ptr_tos_link'); ?>
                <input class="required url" name="ptr_tos_link" value="<?php echo $tos_link; ?>" />
                </div> <!-- END Column -->
            </div> <!-- END ROW -->
            <fieldset>
            <legend>Tracking and Cookies</legend>
            <div class="section group"> <!-- ROW -->
                <div class="col span_5_of_12"> <!-- Column -->
                <span style="text-align:right; float:right; font-weight:bold">Query Tracking Variable</span>
                </div> <!-- END Column -->
                <div class="col span_7_of_12"> <!-- Column -->
                <?php $qvar = get_option('aretex_tracking_qvar'); ?>
                <input style="width: 75px;" class="alphanumeric" name="ptr_qvar" value="<?php echo $qvar; ?>" />
                </div> <!-- END Column -->
            </div> <!-- END ROW -->
            <div class="section group"> <!-- ROW -->
                <div class="col span_5_of_12"> <!-- Column -->
                <span style="text-align:right; float:right; font-weight:bold">Tracking Cookie Duration</span>
                </div> <!-- END Column -->
                <div class="col span_7_of_12"> <!-- Column -->
                <?php $cookie = get_option('aretex_tracking_cookie_days'); ?>
                <input style="width: 75px;" class="digits" name="ptr_cookie_duration" value="<?php echo $cookie; ?>" /> (Days)
                </div> <!-- END Column -->
            </div> <!-- END ROW -->
            </fieldset>
            <fieldset>
            <legend>Permalinks and Deep Linking</legend>
            <?php if ( get_option('permalink_structure') !== "/%postname%/") {
            ?>
                    <p>Your WordPress permalink structure is <em><strong>not</strong></em> set up to allow for deep linking.
                    To change this, go to the <em>Settings / Permalinks</em> page on your WordPress admin menu, select <em><strong>postname</strong></em>
                    and save. For more information, see <strong>Permalinks and Deep Linking</strong> on the <em>Information</em> tab. 
                    </p>                    
                    
            <?php                    
                }
                else {              
             ?>
                <p>Your WordPress permalink structure <strong><em>is currently</em></strong> set up to allow for deep linking.
                For more information, see <strong>Permalinks and Deep Linking</strong> on the <em>Information</em> tab. </p>
                    <div class="section group"> <!-- ROW -->
                <div class="col span_5_of_12"> <!-- Column -->
                <span style="text-align:right; float:right; font-weight:bold">Provide Deep Linking Instructions to Referrers?</span>
                </div> <!-- END Column -->
                <div class="col span_7_of_12"> <!-- Column -->
                <?php
                    $deep = get_option('aretex_explain_deep');
                    if ($deep == 'Yes') {
                        $ysel = ' selected="selected" ';
                        $nsel = '';
                    }
                    else {
                       $nsel = ' selected="selected" ';
                       $ysel = ''; 
                    }
                    
                ?>
                <select name="ptr_deep_link"><option <?php echo $ysel;?> >Yes  </option>
                <option <?php echo $nsel;?> >No </option>
                </select>
                </div> <!-- END Column -->
            </div> <!-- END ROW -->  
             <?php } ?>
            </fieldset>
            <fieldset>
            <legend>Messages to Payees</legend>
              <div class="section group"> <!-- ROW -->
                <div class="col span_12_of_12"> <!-- Column -->
            <label>Home Page Message</label>
            <?php $homem = get_option('aretex_ptr_home_message'); ?>
            <textarea name="home_page_message"><?php echo $homem; ?></textarea>
                            </div> <!-- END Column -->
            </div> <!-- END ROW -->
            <div class="section group"> <!-- ROW -->
                <div class="col span_12_of_12"> <!-- Column -->  
            <label>Pending Payments Message</label>
             <?php $ppmem = get_option('aretex_pending_pay_message'); ?>
            <textarea  name="pending_payments_message"><?php echo $ppmem; ?></textarea>
            </div> <!-- END Column -->
            </div> <!-- END ROW -->
             <div class="section group"> <!-- ROW -->
                <div class="col span_12_of_12"> <!-- Column -->
                <label>Message to Referrers</label>
                <?php $rfmem = get_option('aretex_ptr_referrer_message'); ?>
                <textarea name="referrer_message"><?php echo $rfmem; ?></textarea>
              </div> <!-- END Column -->
            </div> <!-- END ROW -->
            </fieldset>
                        <div class="section group"> <!-- ROW -->
                <div class="col span_1_of_12"> <!-- Column -->
                </div> <!-- END Column -->
                <div class="col span_9_of_12"> <!-- Column -->
                <a href="javascript:void(0);"  onclick="submit_ptr_wp_config();"
class="ui-button  icon_left_button button_link  ui-state-default ui-corner-all"  >
<span class="ui-icon  ui-icon-circle-check"></span> 
Save Configuration Settings</a>
                </div> <!-- END Column -->
            
            </div> <!-- END ROW -->
            
            
            </div>

        </form>
    </div> <!-- END Column -->
    <div class="col span_5_of_12"> <!-- Column -->
        <div class="ui-widget ui-widget-content  ui-corner-all " style="padding: 3px;">
        <strong>WordPress Configuration for PTR</strong>
        <p><strong>Terms and Conditions Link</strong> - For your protection, as well as ours, your AreteX&trade; EULA requires that your payees agree to
        your terms and conditions as well as the AreteX&trade; terms and and conditions - before being able to access their PTR. 
        Enter the URL of your terms and conditions here. There is more information on the "<em>Information</em>" tab.</p>
        
        <p><strong>Query Tracking Variable</strong> - This allows you to change the name of the tracking variable used in 
        your URL (and query strings). For information on why this might be important, see the "<em>Information</em>" tab.
        <strong><em>Important Note:</em></strong> If you <em><strong>change</strong></em> this <strong>after</strong> your referrers start using 
        their tracking URLs, any referals that follow those URLs will get a <em><strong>404 error</strong></em>. </p>

        <p><strong>Cookie Duration</strong> - When a potential customer follows a tracking link or enters a coupon code, a cookie is stored on their browser so 
        that the referrer who sent them to you gets credit, if they come back later and buy. Enter the number of days before that cookie expires.</p>
        
         <p><strong>Permalinks and Deep Linking</strong> - If you select <em>Yes</em>, instructions on "deep linking" will be avaiable on the Referral 
         menu tab on the PTR. 
         <strong><em>Important Note:</em></strong>  Once your referrers start sending people to your site, it is imporant
         <strong>not to change</strong> your Permalink structure. If you do,  any referals that follow those URLs may get a <em><strong>404 error</strong></em>.  </p>
        
         <p><strong>Messages to Payees</strong> - These three fields allow you to post messages to specific pages on the PTR. You <em>may</em> use HTML if you wish.</p>
         <ul style="text-indent: -1.0em; margin-left: 1.5em; font-size: 12px;">
         <li><strong>Home Page Message</strong> - Message appears near the top of the home page and is visiable to all payees.</li>
         <li><strong>Pending Payments Message</strong> - This is intended to communicate specifically about payments (for example if you experience an unexpected banking delay).  
         It appears near the top of the pending payments screen. </li>
         <li><strong>Message to Referrers</strong> -  This appears near the top of the referral page. <em>Remember: </em> the 
         Referral menu tab is <em>only avaiable</em> to payees who are part of a <em>Commission Group</em>.
         </li>
         </ul>
         <p>If any of these boxes is blank, no message <em>or message box</em> will appear for that specific page.</p>
         <p>You may see samples on the <em>Information Tab</em>.</p>
         
        </div>
        
       

    </div> <!-- END Column -->
</div> <!-- END ROW -->
</div>
<div id="tabs-2">

<div class="accordion">
<h3>Configuration and Integration</h3>
<div>
<p>The <em>WP Integraion / PTR Integation</em> menu item allows you to configure your WordPress site settings to integrate into
the AreteX&trade; <strong>Payment Tracking and Reporting</strong> system (PTR).  The PTR allows all your payees (referrers and contributors)
to track payments due to them.  It also provides a place for your referrers to receive instructions on how to promote your site. 
Any user with the <strong>access_aretex_ptr</strong>  capablity will see the PTR panel as illustrated below:<br />
 <img style="margin-top: 5px;" src="<?php echo plugins_url('images/ptr-panel.png',__FILE__); ?>" />
</p>
<p><em>Remember: </em> the <strong>Referral</strong> menu tab is <em>only available</em> to payees who are part of a <em>Commission Group</em>.</p>
<p>The "accordion" sections of this tab explain the various ways in which the PTR is integrated with your WordPress site.</p>
</div>
<h3>Terms and Conditions Link</h3>
<div>
<p>
When you set up your Terms and Conditions Link, your payees will be required to agree to them (as well as the AreteX&trade; Terms and Conditions) to be able to continue
on to their PTR (Payment Tracking and Reporting) screen.  The image below shows you where this link will be seen.  
<br />
 <img src="<?php echo plugins_url('images/ptr-tandc.png',__FILE__); ?>" />
</p>
<p><em>Note:</em> The AreteX&trade; Terms and Conditions check box must also be selected.  These terms and conditions are identical to those you have already
agreed to.  For a reminder <a href="http://3balliance.com/termsandconditions/3B%20Alliance%20T&C-1.pdf" target="_blank">click here</a>.</p>
</div>
<h3>Query  Tracking Variable</h3>
<div>
<p>It is common for search engines, social media and popular web sites to penalize or 
modify known "affiliate" or tracking links in the URL query string. While we actively <strong><em>discourage</em></strong> 
abuse of <em>any</em> business' or system's terms of service, these penalities are often overly broad and applied regardless of your compliance status.   </p>
<p>AreteX&trade; provides two remedies for this: 1) Integration of tracking with Permalinks and 2) A customizeable tracking variable. </p>
<p>By default, the AreteX&trade; tracking variable is: <strong><em>atxcc</em></strong>.
That means a tracking  URL will be of the form:<br />
<strong>https://example.com/<strong><em>atxcc</em></strong>/OFFER-00000-WEB-D1A. </strong>
 </p>
 <p>A search engine or social media linking site, may recognize <strong><em>atxcc</em></strong> as a default tracking variable and assess penalties accordingly. </p>
 <p>If you set your tracking variable to <strong><em>mybiz1</em></strong>, then your tracking url will be of the form:<br />
  <strong>https://example.com/<strong><em>mybiz1</em></strong>/OFFER-00000-WEB-D1A</strong> </p>
  <p>Thus, by changing the tracking variable to something that is unqiue to your site, 
  you may avoid undeserved automated penalties. </p>
</div>
<h3>Permalinks and Deep Linking</h3>
<div>
<p>"Deep Linking" is when you allow (or  encourage) your referrers to link to a <em>specific</em> Page or Post on your site.
This is important when you want to allow them to promote specific product pages or promotions, or to share content on social media and
still get credit for promoting your site. 
</p> 
<p>To allow "Deep Linking" you <em>must</em> have your Permalink structure set to "Post Name" in your <em>WordPress Settings</em> as illustrated below:<br />
 <img src="<?php echo plugins_url('images/ptr-permalink.png',__FILE__); ?>" />
</p>
<p></p>
<p>When your Permalink structure is setup this way, a normal link is of the form:<br />
<strong>https://example.com/<strong><em>page-name</em></strong></strong>
</p>
<p> 
A deep referral link to the same page is  of the form:<br />
<strong>https://example.com/<em>atxcc/OFFER-00000-WEB-D1A</em>/<strong><em>page-name</em></strong>. </strong>
</p>
<p>See the prior accordian section (<em>Query  Tracking Variable</em>) for more information on the tracking link structure.</p>

<p><em>Important Note:</em></strong>  Once your referrers start sending people to your site, it is imporant
         <strong>not to change</strong> your Permalink structure. If you do,  any referrals that follow those URLs may get a <em><strong>404 error</strong></em>.  </p>


</div>
<h3>Messages to Payees</h3>
<div>
<p>You may enter messages to your payees that they will see when they log into their PTR. 
Below are examples of the types of messages you might put on each page.</p>
<h4>Example of Home Page Message</h4>
<img style="margin-top: 5px;" src="<?php echo plugins_url('images/msg-home.png',__FILE__); ?>" />

<h4>Example of Pending Payments Message</h4>
<img style="margin-top: 5px;" src="<?php echo plugins_url('images/ptr-pending-pay-msg.png',__FILE__); ?>" />

<h4>Example of Message to Referrers</h4>
<img style="margin-top: 5px;" src="<?php echo plugins_url('images/ptr-promo-msg.png',__FILE__); ?>" />

</div>
</div>

</div>
</div>
<script>
jQuery('.accordion').accordion({
heightStyle: "content"
});
jQuery('.tabs').tabs();

function submit_ptr_wp_config() {
    jQuery('#ptr_config_form').validate();
    if (jQuery('#ptr_config_form').valid()) {
    
        jQuery.ajax({
                      type: 'POST',
                      url: ajaxurl,                      
                      dataType: 'json',
                      data: {
                        action: 'atx_ptr_wp_cfg',
                        data: jQuery('#ptr_config_form').serialize()
                        
                      },
                      success: function(data){
                        
                        alert(data);
                        
                        
                      },
                      error: function(xhr, type, exception) {                     
                        alert("AJAX Error: "+exception);                    
                      }
                      
                    });
    }
    
}

</script>
