<div class="section group"> <!-- ROW -->
    <div class="col span_11_of_12"> <!-- Column -->

<div class="ui-widget-header ui-corner-top" >
<h2 style="text-align: center; margin-top: 5px; margin-bottom: 5px;">AreteX&trade; Home</h2>
</div>
<div class="ui-widget ui-widget-content  ui-corner-bottom container" >
<div id="main_content">
<div class="section group"> <!-- ROW -->
    <div class="col span_1_of_8"> <!-- Column -->

<a href="https://aretex.org/knowledgebase/" target="_blank">How Do I ... ?</a><br />
<span style="font-size: 75%;">(Opens a New Window)</span>
    </div> <!-- END Column -->
    <div class="col span_1_of_8"> <!-- Column -->
    
<a target="_blank" href="<?php echo AreteXDocURL().'WhatYouWillNeed-Overview.pdf' ?>" >What You Will Need : Overview</a>
<br />
<span style="font-size: 75%;">(Download as PDF)</span>
</div> <!-- END Column -->
<div class="col span_1_of_8">
    <a href="https://wordpress.org/plugins/aretex-shopping-cart/" target="_blank">AreteX Shopping Cart Plugin</a><br />
    <span style="font-size: 75%;">(Opens a New Window)</span> 
</div>
</div> <!-- END ROW --> 

<?php 

    $license_info = AreteX_WPI::getBasLicense();    
    if ($license_info->license_status != 'Good' && $license_info->license_status != 'Trial'  ) {
?>
    <h3><em>Alert:</em> Your License Status Needs Attention</h3>
<p>    Listed below are the alert status levels and possible needs which may be addressed in order to make 
your license "good."
</p>
<p>(<strong>Note:</strong> A Trial Subscription License is good for only 30 days and then is automatically 
rendered "suspended."  You may apply for another trial, but the work you have on the previous trial 
license will be lost.  If you wish to upgrade your Trial Subscription to Paid Subscription, you have 
two weeks after suspension to do so.)
</p>
<h4><ins>Status Alert Levels for Paid Subscription or Live Licenses:</ins></h4>

<strong>Advisory</strong>
<p>An automatic payment for your license has failed.  Your license will continue to operate for an 
additional 30 days, at which time it will be suspended.  If you select the <em>Update Payment Method</em> button next to the <em>Advisory</em> status alert, you may 
edit your Update Automatic Payment Method.  If you update your payment method and after 48 hours your 
license status has not changed to "good," open a support ticket.
</p>
<strong>Suspended</strong>
<p>Your license has been suspended either for non-payment or license terms violation.  
It will be terminated two weeks after the suspension.  If you believe you have gotten this status in error, 
please open a support ticket.
</p>
<strong>Terminated</strong>
<p>Your license and data are scheduled for deletion within 24 hours.  If you believe you have gotten 
this status in error, please open a support ticket.
</p>
<strong>Pending</strong>
<p>Please check your email for a confirmation action awaiting your reply.  If you have no confirmation in your email, please open a support ticket.
</p>
<strong>Cancel Pending</strong>
<p>You have requested and confirmed a cancelation of your license.  It will be terminated 48 hours from the time of your confirmation.  If you wish to reverse this pending action, please open a support ticket.
</p>
<p><em>(<strong>Note:</strong> Your particular Status Alert for your license has been communicated to you through your email of record.)
</em></p>
            
<?php        
        
    }
    else {
    switch($license_info->license_type) {
        case 'Production':
?>
  <h4>Your Live (Production) License</h4>

<p>Thank you for choosing AreteX eCommerce Services as your eCommerce service provider.  
</p>
<p>Your AreteX License is a fully functional eCommerce system capable of 
processing actual transactions through your Merchant Account(s).  
</p>
<p>To familiarize yourself with the possibilities that AreteX provides, 
be sure to take a quick tour through the Overviews under each menu button above.
</p>
<p>Again, thank you for choosing AreteX eCommerce Services,<br />
The AreteX&trade; Team</p>

            
<?php        
        break;
        case 'Sandbox':
        switch($license_info->license_status) {
            case 'Trial':
?>
<div class="dbui-frame">
<h4>Your Trial Sandbox License</h4>
<p>Thank you for installing this Trial Sandbox License.  You may be interested in the articles and 
discussions of the AreteX developer community.  <a href="https://aretex.org" target="_blank">Join us at AreteX.org</a>.  To familiarize yourself with the possibilities that AreteX provides, be sure to take a quick tour through the Overviews under each menu button above.
</p>
<p>You have 30 days to evaluate this service for free.  Any time within the 30 days you may upgrade this 
license to a Paid Sandbox License.  At that point your license will become a fully functional development 
environment.  If you wait and go past the free 30 day window of this trial, your license will be suspended.
</p>
<p>Limitations on the Trial Sandbox License:</p>
<ul>
<li>Limited to 5 products</li>	
<li>May not use real credit cards (a fake card is provided by default): <strong><a href="https://aretex.org/knowledgebase/sandbox-error-trigger-values/" target="_blank">Click Here for Important Information on Test Transactions</a></strong></li>
<li>There is no ACH/Direct Deposit functionality (see how Outbound works by using Manual Batch functionality)</li>
<li>Is suspended after 30 days</li>
</ul>
<p>The Trial Sandbox License is always the entry point in initiating an AreteX eCommerce Services License.  
You may upgrade to a Paid Sandbox License or go directly to a Live License from this point.  
(See Current AreteX License box below.)
</p>
<p><em>Note:</em> When you are ready and at the last stage of the "Go Live" process, there will be a short 
transition time in which you will not be able to make changes to your AreteX database.  
(For more information <a href="https://aretex.org/knowledgebase/license-info/" target="_blank">click here</a>.)
</p></div>


<?php            
            break;
            case 'Good':
?>

<div class="dbui-frame">

<h4>Your Paid Sandbox License</h4>
<p>Thank you for choosing the AreteX&trade; eCommerce Services plugin.  
Your paid Sandbox License allows you to set up and fully test your 
eCommerce site without the risks inherent in a "real money" environment.  
</p>
<p>You may be interested in the articles and discussions of the AreteX&trade; developer community.  
Join us at <a href="https://aretex.org" target="_blank">AreteX.org</a>.  To familiarize yourself with the possibilities that AreteX&trade; provides, 
be sure to take a quick tour through the Overviews under each menu button above.
</p>
<p>The limitations placed on your Trial Sandbox were lifted when you submitted your 
Paid Sandbox License confirmation - with the exception of processing real money. (<strong><a href="https://aretex.org/knowledgebase/sandbox-error-trigger-values/" target="_blank">Click Here for Important Information on Test Transactions</a></strong>)  
When you are ready to "Go Live," you will be walked through the <em>AreteX Application</em> and 
<em>Merchant Setup</em> processes.  This will include starting your 
Vantiv (credit card) and possibly Forte (ACH) Merchant Account(s).</p>

<p><em>Note:</em> When you are ready and at the last stage of the "Go Live" process, there will be a short 
transition time in which you will not be able to make changes to your AreteX database.  
(For more information <a href="https://aretex.org/knowledgebase/license-info/" target="_blank">click here</a>.)
</p>
</div>


<?php            
            break;
        }
        break;
?>
<?php            
    }
}      
?>   

<div class="dbui-frame">

<h4 style="text-align: center;">Global Settings and Support</h4>
<p>At the top of the control panel/screen, we have provided three boxes that are always available.
</p>
<strong>Current AreteX License box:</strong> This box lets you know the <em>type of license</em> you have (sandbox or live), as well as the <em>status of your license</em>
<a class="read-more-show hide" href="#">(More)</a>
<span class="read-more-content"> 
(trial, good, advisory, suspended, terminated, pending, or cancel pending).  
Next is the Go Live action button, which is your entrance to upgrading your trial or paid sandbox license to a 
live/production license of AreteX&trade;.  
<br /><em>Note 1:</em> If you currently have a Trial Sandbox License an Upgrade button will also be available for you to upgrade to a Paid Sandbox license, if you so desire.  
<br /><em>Note 2:</em> If you currently have a Live License, the Go Live button will not be available.
 <a class="read-more-hide hide" href="#">(Less)</a></span></p>
<p>A <em>Help</em> button is provided to open another window and take you to our License Knowledge Base.</p>

<p>A <em>Refresh License Information</em> (circle arrow) icon is provided to synchronize your 
license status on your WordPress installation with your license status on the AreteX&trade; server.  
You may need to use this after an upgrade or going live.
 
</p>
<p><strong>AreteX&trade; Server Status box:</strong> This box has two <em>status levels</em>: OK and NO.  OK means that your WordPress installation is in 
communication with the AreteX server.  NO means that it is not in communication with the AreteX server.
<a class="read-more-show hide" href="#">(More)</a>
<span class="read-more-content">   
This is likely a network problem.  Start with your hosting provider.  If this continues to 
remain a problem and you are unable to open a support ticket, send an email to support@aretex.org.
 <a class="read-more-hide hide" href="#">(Less)</a></span> 
</p>
<p>Next is the <em>time zone</em> your WordPress license is set for on the AreteX server.  To edit the time zone go to <em>Settings / General</em> in your WordPress admin menu.  Change the Time Zone setting.  (Save.)
<a class="read-more-show hide" href="#">(More)</a>
<span class="read-more-content">  
When you re-open AreteX you may see an exclamation mark, telling you that your local time zone does not match 
the time zone set with the AreteX server for your license.  
(<em>Note</em>: This may also be true when you first open your AreteX license.)  After updating your time zone, select the Refresh (circle arrow) icon next to the Help button.
<a class="read-more-hide hide" href="#">(Less)</a></span>
</p>
<p>The <em>Help</em> button opens a new window and takes you to the AreteX Server Knowledge Base.</p>

<p>The <em>Refresh Server </em>(circle arrow) icon is an immediate check to see if you are connected to the AreteX server, as well as synchronizing your WordPress time zone setting with the AreteX server.
</p>
<p>The <em>Clear Cache </em>button.  The AreteX plugin caches frequently-used information that is stored on the AreteX server.  After you make updates to the database, you may want to clear the Cache to ensure that your WordPress installation has your latest changes.
</p>
<strong>Support:</strong><br />
<p>Select this button to open a new window, search the knowledgebase, ask questions in the forums or submit a support ticket.
</p>

</div>




</div>    
    </div> <!-- END Column -->
</div> <!-- END ROW -->
<script>
jQuery('.button-set').buttonset();
jQuery('.tabs').tabs();
</script>
<script>
                // Credit: http://css-tricks.com/forums/topic/jquery-read-more-less-toggle/
              // Hide the extra content initially, using JS so that if JS is disabled, no problemo:
                jQuery('.read-more-content').addClass('hide')
                jQuery('.read-more-show, .read-more-hide').removeClass('hide')
                
                // Set up the toggle effect:
                jQuery('.read-more-show').on('click', function(e) {
                  jQuery(this).next('.read-more-content').removeClass('hide');
                  jQuery(this).addClass('hide');
                  e.preventDefault();
                });
                
                // Changes contributed by @diego-rzg
                jQuery('.read-more-hide').on('click', function(e) {
                  var p = jQuery(this).parent('.read-more-content');
                  p.addClass('hide');
                  p.prev('.read-more-show').removeClass('hide'); // Hide only the preceding "Read More"
                  e.preventDefault();
                });
 </script>