<?php 
$url = AreteX_WPI::getBasBsuEndPoint();
$aretex_ajax_auth = AreteX_WPI::ajaxAccessToken('master');
$url .= '?aretex_ajax_auth='.$aretex_ajax_auth;

$biz = AreteX_WPI::getBusiness();

$license = AreteX_WPI::getBasLicense();

$public_license_key = $license->public_license_key;
$receipt_url = "https://aretexhome.com/AreteX/receipts/view/$public_license_key/sample.jsonp?aretex_ajax_auth=$aretex_ajax_auth";

$support_url = AreteX_WPI::getBsuConfiguration('support_url');
if (empty($support_url))
    $support_url = get_site_url();
    
$support_phone = AreteX_WPI::getBsuConfiguration('support_phone');
if (empty($support_phone))
    $support_phone = $biz->Customer_Service_Phone;

$support_email = AreteX_WPI::getBsuConfiguration('support_email');
if (empty($support_email))
    $support_email = $biz->Public_Email_Address;

if (empty($support_email))
    $support_email = $biz->Email_Address;

?>

<div class="ui-widget-header ui-corner-top" >
<h2 style="text-align: center; margin-top: 5px; margin-bottom: 5px;">Receipt and Notification Customization</h2>
</div>
<div class="ui-widget ui-widget-content  ui-corner-bottom container"  style="padding-bottom: 5px; padding-right: 5px;">

<div class="tabs">
<ul>
<li><a href="#tabs-1">Style Sheet</a></li>
<li><a href="#tabs-2">Receipt</a></li>
<li><a href="#tabs-3">Welcome/Account Access</a></li>
<li><a href="#tabs-4">Help and Information</a></li>
</ul>
<div id="tabs-1">
<form id="notify_customize_form" enctype="multipart/form-data">
<div class="ui-widget-content ui-corner-top" >
<h2 style="text-align: center; margin-top: 5px; margin-bottom: 5px;">Submit Notification Style Customizations</h2>
</div>
<div class="ui-widget ui-widget-content  ui-corner-bottom dbui-frame container" >
<p>This style sheet is how you (the web designer) can match the "look and feel" of notifications (emails) 
    sent to the end customer by AreteX&trade;.  If you are not comfortable with terms like "CSS Class" and "Element Tag" you should consult a web designer before making modifications on this screen.</p>
<p>For your convience, we have provided a starter style sheet <a class="read-more-show hide" href="#">(More)</a> <span class="read-more-content"> in the <em>style_sheet_template</em> directory of this plugin. You can modify it to make your notification "look and feel" consistent with your theme.<a class="read-more-hide hide" href="#">(Less)</a></span></p> 

<p><em>Note:</em>This style sheet is being submitted to <em>AreteX&trade;</em>, not your WordPress site.</p>

<div class="section group"> <!-- ROW -->   
    <div class="col span_6_of_12"> <!-- Column -->
        <div class="section group"> <!-- ROW -->
            <div class="col span_12_of_12"> <!-- Column -->
           
            <div class="ui-widget ui-widget-content  ui-corner-all dbui-frame " style="padding: 5px;" >
            <input id="use_default_css" onchange="check_use_def();  highlight_css_submit();" type="checkbox" name="use_default" value="true" style="width: 30px !important;" /> Use the default style sheet. <span style="font-size: 75%;"><em>(You must hit submit to send this setting.)</em></span>
            <script>
            function check_use_def()
            {
                if (jQuery('#use_default_css').is(':checked'))
                    jQuery('#css_file_upload').hide();
                else
                     jQuery('#css_file_upload').show();
            }
            function highlight_css_submit()
            {
                // ui-widget-content ui-corner-all ui-widget dont-forget
                jQuery('#css_submit_button').addClass('ui-widget-content');
                jQuery('#css_submit_button').addClass('ui-corner-all');
                jQuery('#css_submit_button').addClass('dont-forget');
                
            }
            
            function unhighlight_css_submit()
            {
                // ui-widget-content ui-corner-all ui-widget dont-forget
                jQuery('#css_submit_button').removeClass('ui-widget-content');
                jQuery('#css_submit_button').removeClass('ui-corner-all');
                jQuery('#css_submit_button').removeClass('dont-forget');
                jQuery('.plz_wait').html('');
                
            }
            
            </script>
            <hr />
            <span id="css_file_upload">
            <label>Upload Your Own CSS Style Sheet File</label>
            <span style="font-size: 70%;">
            We recommend you begin with the starter style sheet, using your favorite CSS editor to match your site's look and feel. 
            <button type="button" style="margin: 4px; " onclick="download_starter();" class="small_license_button">Download Starter Style Sheet</button> <br />
            
            <script>
            function download_starter() {
                     url = ajaxurl+'?action=atx_download_as_attachment&file_id=default_css';
                    jQuery('#download_frame').attr('src',url);

            }
            </script>
            <br/><em>The starter file located is in the <strong>style_sheet_templates</strong> directory of your plugins folder.</em> 
            <em>Note</em> this file will be sanitized after it is submitted to AreteX&trade;. 
            </span> 
            <input name="file" type="file" onchange="highlight_css_submit();" />
            </span>
            <hr />
            <div id="css_submit_button">
            <a href="javascript:void(0);"  onclick="submit_notify_style();"
        class="ui-button  icon_left_button button_link  ui-state-default ui-corner-all"  >
        <span class="ui-icon  ui-icon-circle-check"></span> 
        Submit</a>  <span style="font-size: 70%;">(Current Style Sheet is shown below.)  <button onclick="download_current_css();" type="button" style="margin: 4px; "  class="small_license_button">Download Current Style Sheet</button></span>
        
          <script>
            function download_current_css() {
                     url = ajaxurl+'?action=atx_download_as_attachment&file_id=current_css';
                    jQuery('#download_frame').attr('src',url);

            }
            </script>
            <div class="plz_wait" style="width: 60%; margin-left: auto; margin-right: auto; padding: 5px;" ></div>
 
           </div>
           </div>
            </div> <!-- END Column -->
        </div> <!-- END ROW -->
        <div class="section group"> <!-- ROW -->
        <div class="col span_12_of_12"> <!-- Column -->
        <div class="ui-widget ui-widget-content  ui-corner-all container" >
            
           <p>Your style sheet is stored on the AreteX&trade; server. The current style sheet in use by AreteX&trade; is listed below.</p>
            <p>When you have made your modifications, upload the file to the AreteX&trade; server with this form. <a class="read-more-show hide" href="#">(More)</a> 
<span class="read-more-content">
  (You may revert to the default style sheet at any time by checking the "Use the default style sheet" box and submitting the form.)
           <br/><br/>For your (and your customer's) protection the style sheet will be "sanitized" after being uploaded.
             A "sanitized" style sheet has had potentially harmful code removed to prevent cross-site-scripting or injection attacks. <em>Note:</em> sanitization does not guarantee that all harmful code has been removed.
             You are ultimately responsible for the security of your site. 
             <a class="read-more-hide hide" href="#">(Less)</a></span> 
           </p>

        </div>
        </div> <!-- END Column -->
</div> <!-- END ROW -->
    </div> <!-- END Column -->
    <div class="col span_6_of_12"> <!-- Column -->
    <div class="ui-widget ui-widget-content  ui-corner-all dbui-frame container" style="margin-right: 5px;" >
        <p><strong>The following notifications use this style sheet:</strong>
    <ul>
        <li><strong>Billing Account Instructions</strong><br />
        This email is sent to a first time customer <a class="read-more-show hide" href="#">(More)</a> <span class="read-more-content"> (identified by email address) to explain how to access their Customer Account Manager.  <a class="read-more-hide hide" href="#">(Less)</a></span>  (See the Welcome/Account Access Tab for more details).
        </li>
        <li><strong>Confirmation Notice</strong><br />
        This email is sent to the end customer any time their credit card is authorized but not yet charged. (For example a free trial).
        </li>
        <li><strong>Cancelation Confirmation</strong><br />
        This email is sent to the end customer if they cancel their rebill agreements from their Customer Account Management panel.
        </li>
        <li><strong>Payment Recieved Notification</strong><br />
        This is a receipt sent to the end customer any time their card is actually charged.  This is the same receipt that is displayed after the payment has been completed.
        </li>
        <li><strong>Pending Automatic Charge Notification</strong>
        This email is sent seven days before an automatic charge is applied to the end customer's payment card.
        </li>
    </ul>
    </p>
    </div>
    </div> <!-- END Column -->
</div> <!-- END ROW -->

<input type="hidden" name="resource" value="notify_style" />
<input type="hidden" name="cmd" value="post" />

</form>
<script>

function submit_notify_style() {

var form_data = jQuery('#notify_customize_form').serialize();

jQuery('.plz_wait').html('<center>... Please Wait ...</center>'); 
 var ajax_options = {
  type: 'POST',
  url: '<?php echo $url; ?>',
  
  crossDomain: true,
  success: function(data){
    
    alert('Success');
    //jQuery('#current_notification_customizations').html(data);
    get_notify_style();
    show_receipt();
    get_welcome_email();
    unhighlight_css_submit();
  },
  error: function(xhr, type, exception) { 
    
    alert("Error: "+exception);
  }
}
 
   
        
   jQuery('#notify_customize_form').ajaxSubmit(ajax_options); 
 
        
    return false; 
    

}
</script>
</div>
<h2>Current Style Sheet</h2>

<div id="current_notification_customizations"></div>

<script>
function get_notify_style()
{

    jQuery.ajax({
      type: 'GET',
      url: '<?php echo $url; ?>',
      data: {        
        resource: 'notify_style',
        cmd: 'get'
      },
      dataType: 'jsonp',
      success: function(data){
        jQuery('#current_notification_customizations').html(data);
      },
      error: function(xhr, type, exception) { 
        // if ajax fails display error alert
        alert("Ajax Error: Exception: "+exception);
      }
    });
}

get_notify_style();
</script>





</div>
<div id="tabs-2">

<form id="return_policy_form" >
<div class="ui-widget-content ui-corner-top" >
<h2 style="text-align: center; margin-top: 5px; margin-bottom: 5px;">Submit Receipt Customizations</h2>
</div>
<div class="ui-widget ui-widget-content  ui-corner-bottom dbui-frame container" >
<p><em>Note:</em>This receipt information is being submitted to AreteX&trade;, not your WordPress site.</p>

<div class="section group"> <!-- ROW -->
    <div class="col span_6_of_12"> <!-- Column -->
  <div class="ui-widget ui-widget-content  ui-corner-all container" style="padding-right: 5px;"  >
<div class="section group"> <!-- ROW -->
    <div class="col span_12_of_12"> <!-- Column -->
    <label>Customer Support Phone</label>
    <input onchange="highlight_rct_submit();" name="support_phone" type="text" class="required phoneUS"  value="<?php echo $support_phone; ?>" />
    <label>Customer Support Email</label>
    <input onchange="highlight_rct_submit();" name="support_email" type="text" class="required email"  value="<?php echo $support_email; ?>" />
        <label>Customer Support Web Site</label>
    <input onchange="highlight_rct_submit();" name="support_url" type="text" class="required"  value="<?php echo $support_url; ?>" />


    <label>Return Policy</label>
    <?php $return_policy = AreteX_WPI::getBsuConfiguration('return_policy');  ?>
    <textarea onchange="highlight_rct_submit();" id="return_policy" class="required" name="return_policy"><?php echo $return_policy; ?></textarea>
    <span style="font-size: 70%">HTML <em>is</em> allowed in your return policy. It will be sanitized. (See sanitization notes on Style Sheet tab.)</span>
    <hr />
    <div id="rct_submit_button">
    <a href="javascript:void(0);"  onclick="submit_return_policy();"
class="ui-button  icon_left_button button_link  ui-state-default ui-corner-all"  >
<span class="ui-icon  ui-icon-circle-check"></span> 
Submit</a>
    <div class="plz_wait" style="width: 60%; margin-left: auto; margin-right: auto; padding: 5px;" ></div>

    </div>
    </div> <!-- END Column -->
</div> <!-- END ROW -->

  </div>
  </div> <!-- END Column -->
  <div class="col span_6_of_12"> <!-- Column -->

<div class="ui-widget ui-widget-content  ui-corner-all container" style="margin-right: 5px;">
<p>The customer service information goes at the top of the customer's receipt.
<p>The return policy goes on the bottom. All of this information is required by your credit card processor. 
</p>
<p>The CSS File you set up in the "Style Sheet" tab is used to define the "look and feel" of the receipt.</p>
</div>
   </div> <!-- END Column -->
</div> <!-- END ROW -->

</div>
<input type="hidden" name="resource" value="return_policy" />
<input type="hidden" name="cmd" value="post" />
</form>
<script>

function submit_return_policy() {

    jQuery('#return_policy_form').validate();
    if (jQuery('#return_policy_form').valid()) {
    
        jQuery('.plz_wait').html('<center>...Please Wait ...</center>');
        var form_data = jQuery('#return_policy_form').serialize();
        jQuery('#sample_receipt').html('<center><strong>Please Wait ...</strong></center>');
        
         var ajax_options = {
          type: 'POST',
          url: '<?php echo $url; ?>',
          
          crossDomain: true,
          success: function(data){
            
            alert("Success");
            unhighlight_rct_submit();
            show_receipt();
            
          },
          error: function(xhr, type, exception) { 
            
            alert("Error: "+exception);
          }
        }
         
           
                
           jQuery('#return_policy_form').ajaxSubmit(ajax_options); 
         
                
            return false; 
            
    }
}
</script>
<hr />
<h2>Current Receipt Sample</h2>
<p><em>Note:</em>The style reflected below <em>may also</em> reflect the CSS within your WordPress administration screen.  Use "Display Receipt in New Window" to see what it looks like normally. To print only the receipt (and not this whole page), select "Display Receipt in New Window", then select "Print This Page". </p>
<div id="sample_receipt"></div>
<script>

function show_receipt() {

     
    jQuery.ajax({
      type: 'GET',
      url: '<?php echo $receipt_url; ?>',
      data: {        
        resource: 'notify_style',
        cmd: 'get'
      },
      dataType: 'jsonp',
      success: function(data){
        jQuery('#sample_receipt').html(data);
      },
      error: function(xhr, type, exception) { 
        // if ajax fails display error alert
      
        alert("Ajax Error: Exception: "+exception);
      }
    });
}


function highlight_rct_submit()
{
    // ui-widget-content ui-corner-all ui-widget dont-forget
    jQuery('#rct_submit_button').addClass('ui-widget-content');
    jQuery('#rct_submit_button').addClass('ui-corner-all');
    jQuery('#rct_submit_button').addClass('dont-forget');
    
}

function unhighlight_rct_submit()
{
    // ui-widget-content ui-corner-all ui-widget dont-forget
    jQuery('#rct_submit_button').removeClass('ui-widget-content');
    jQuery('#rct_submit_button').removeClass('ui-corner-all');
    jQuery('#rct_submit_button').removeClass('dont-forget');
    jQuery('.plz_wait').html('');
    
}

show_receipt();
    
    
</script>

</div>
<div id="tabs-3">
<h2>Welcome/Account Access Setup</h2>
<p><strong>The Customer Account Manager - </strong> AreteX&trade; provides you with a Customer Account Manager (CAM) to allow your customers to
    manage their contact information, administer their rebill agreements and view their payment history.</p>
<div class="section group"> <!-- ROW -->
    <div class="col span_6_of_12"> <!-- Column -->

<div class="ui-widget ui-widget-content  ui-corner-all container dbui-frame" style="padding: 3px;"  >



    <form id="welcome_email_upload">
    <label>Use AreteX&trade; Customer Account Manager?</label>
    <?php 
        
        $use_cam = AreteX_WPI::getBsuConfiguration('use_cam');
        if ($use_cam == 'Yes') {
            $sel_yes = 'selected="selected"';
            $sel_no = '';
        }
        else {
            $sel_no = 'selected="selected"';
            $sel_yes = '';
        }
        
        
      
    ?>
    <select onchange="check_cam_use(); highlight_welcome_submit();" id="use_cam" name="use_cam">
    <option <?php echo $sel_yes; ?> >Yes</option>
    <option <?php echo $sel_no; ?> >No</option>        
    </select>&nbsp;<span style="font-size: 75%;"><em>You must submit this for it to be changed.</em></span>
    <script>
    function check_cam_use()
    {
        if (jQuery('#use_cam').val() == 'No')
        {
            jQuery('#welcome_detail_flds').hide();
        }
        else
        {
            jQuery('#welcome_detail_flds').show();
        }
        
    }    
    </script>
    <div id="welcome_detail_flds">
    <p>          <input type="checkbox" onclick="check_use_def_welcome(); highlight_welcome_submit();" id="use_def_welcome" name="use_default" value="true" style="width: 30px !important;" /> Use the default welcome email.&nbsp;<span style="font-size: 75%;"><em>You must submit this for it to be changed.</em>
    <button type="button" style="margin: 4px; " onclick="download_default_email();" class="small_license_button">Download Default Welcome Email</button>
    </span>
  </p>   
  <span id="welcome_upload">      
        <label>Upload Your Own HTML Welcome File</label>
        
     <span style="font-size: 70%;">
            You can use your favorite HTML editor to create your own Welcome email.<br/>
            <em>Note</em> this file will be sanitized after it is submitted to AreteX&trade;. 
            </span> 
     
    <input name="file" type="file" onchange="highlight_welcome_submit();" />
    </div>
  </span>
    <hr />
    <div id="welcome_submit_button" >
    <a  href="javascript:void(0);"  onclick="submit_welcome_email();"
        class="ui-button  icon_left_button button_link  ui-state-default ui-corner-all "  >
        <span class="ui-icon  ui-icon-circle-check "></span> 
        Submit</a><span style="font-size: 70%;">(Current Welcome Email is shown below.)
                    <button type="button" style="margin: 4px; " onclick="download_welcome_email();" class="small_license_button">Download Current Welcome Email</button> <br />
            </span>
            <script>
            function download_welcome_email() {
                     url = ajaxurl+'?action=atx_download_as_attachment&file_id=welcome_email';
                    jQuery('#download_frame').attr('src',url);

            }
            
             function download_default_email() {
                     url = ajaxurl+'?action=atx_download_as_attachment&file_id=default_email';
                    jQuery('#download_frame').attr('src',url);

            }
            
            </script>
    <div class="plz_wait" style="width: 60%; margin-left: auto; margin-right: auto; padding: 5px;" ></div>
    </div>

   <input type="hidden" name="resource" value="welcome_email" />
<input type="hidden" name="cmd" value="post" />

</form>

<script>
            function check_use_def_welcome()
            {
                if (jQuery('#use_def_welcome').is(':checked'))
                    jQuery('#welcome_upload').hide();
                else
                     jQuery('#welcome_upload').show();
                     
                
            }
            </script>

<script>


function highlight_welcome_submit()
{
    // ui-widget-content ui-corner-all ui-widget dont-forget
    jQuery('#welcome_submit_button').addClass('ui-widget-content');
    jQuery('#welcome_submit_button').addClass('ui-corner-all');
    jQuery('#welcome_submit_button').addClass('dont-forget');
    
}

function unhighlight_welcome_submit()
{
    // ui-widget-content ui-corner-all ui-widget dont-forget
    jQuery('#welcome_submit_button').removeClass('ui-widget-content');
    jQuery('#welcome_submit_button').removeClass('ui-corner-all');
    jQuery('#welcome_submit_button').removeClass('dont-forget');
    jQuery('.plz_wait').html('');
    
}

function submit_welcome_email() {

var form_data = jQuery('#welcome_email_upload').serialize();

 var ajax_options = {
  type: 'POST',
  url: '<?php echo $url; ?>',
  
  crossDomain: true,
  success: function(data){
    
    alert('Success');
    get_welcome_email();
    unhighlight_welcome_submit();
  },
  error: function(xhr, type, exception) { 
    
    alert("Error: "+exception);
  }
}
 
   
    jQuery('.plz_wait').html('<center>...Please Wait...</center>');     
   jQuery('#welcome_email_upload').ajaxSubmit(ajax_options); 
 
        
    return false; 
    

}
</script>
    </div>
    </div> <!-- END Column -->
    <div class="col span_6_of_12"> <!-- Column -->
    <div class="ui-widget ui-widget-content  ui-corner-all container" style="margin-right: 5px;" >
    
    <p>If you choose "Yes", under "Use AreteX&trade; Customer Account Manager", the CAM will be integrated into your WordPress user system. </p>
    <p>For more information on how the CAM integrates with the WordPress User/Role/Capablity system see the "Help and Information" Tab.</p>
    <p>AreteX&trade; uses the email address provided at the time of purchase to uniquely identify a customer.  
    If you have chosen to use this CAM, AreteX&trade; will send Account Access instructions to your new customers (new email addresses).  </p>
    <p>This page is also where you can submit your custom email to send to your new customers.</p>
    </div>
    </div> <!-- END Column -->
  
</div> <!-- END ROW -->
<script>
function get_welcome_email()
{
    jQuery.ajax({
      type: 'GET',
      url: '<?php echo $url; ?>',
      data: {        
        resource: 'welcome_email',
        cmd: 'get'
      },
      dataType: 'jsonp',
      success: function(data){
        jQuery('#current_welcome_email').html(data);
      },
      error: function(xhr, type, exception) { 
        // if ajax fails display error alert
        alert("Ajax Error: Exception: "+exception);
      }
    });
    
}

get_welcome_email(); 
<?php 

global $user_email;
get_currentuserinfo();

 ?>
function send_welcome_sample()
{
    jQuery.ajax({
      type: 'POST',
      url: '<?php echo $url; ?>',
      data: {        
        resource: 'welcome_email',
        cmd: 'send_sample',
        to_email: '<?php echo $user_email; ?>'
      },      
      success: function(data){
       alert("Sent - Please Check <?php echo $user_email; ?>");
      },
      error: function(xhr, type, exception) { 
        // if ajax fails display error alert
        alert("Ajax Error: Exception: "+exception);
      }
    });
} 
    
</script>


<div class="section group"> <!-- ROW -->
    <div class="col span_12_of_12"> <!-- Column -->
        <div class="ui-widget ui-widget-content  ui-corner-all container" >
        <strong>About the Welcome/Account Access Email</strong>
        
        <p>
Your welcome email is stored on the AreteX&trade; server. The current welcome email in use by AreteX&trade;  is listed below.
</p>
<p>
For your convience, we have provided a default "Welcome Email" in the email_templates directory of this plugin. You should modify it with specific instructions for your site.
AreteX&trade; uses <strong><em>dynamic content tags</em></strong> (which are similar to WordPress short codes) to allow you to customize your email.  You can find a list of dynamic content tags in the "Help and Information" tab. 
</p>
<p>
When you have made your modifications, upload the file to the AreteX&trade; server with this form. (You may revert to the default welcome email at any time by checking the "Use the default welcome email" box and submitting the form.)
</p>
<p>
For your (and your customer's) protection the welcome email will be "sanitized" after being uploaded. A "sanitized" file has had potentially harmful code removed to prevent cross-site-scripting or injection attacks. Note: sanitization does not guarantee that all harmful code has been removed. You are ultimately responsible for the security of your site.
</p>
        </div>
    </div> <!-- END Column -->
</div> <!-- END ROW -->
<h2>Current Welcome Email</h2>
<p><em>Note: </em> this welcome email uses the notification style sheet you set up on the Style Sheet tab. </p>
<a href="javascript:void(0);"  onclick="send_welcome_sample();"
class="ui-button  icon_left_button button_link  ui-state-default ui-corner-all"  >
<span class="ui-icon  ui-icon-mail-closed"></span> 
Send a Sample Email</a>
<p>The sample email below will be sent to your WordPress user email address.</p>
<hr />
<div id="current_welcome_email"></div>  

</div>
<div id="tabs-4">
<?php include plugin_dir_path( __FILE__ ).'customization_help/top_menu.php'; ?>
<div id="help_info_content">
<?php include plugin_dir_path( __FILE__ ).'customization_help/overview.php';  ?>
</div>

<script>
jQuery('.button-set').buttonset();
jQuery('button.menu_button').click(
            function() { load_notif_help_content(this); }
         );


 function load_notif_help_content(element)
 {
    if (element.id)
        load_notif_help_page(element.id);
    
 }
 
 function load_notif_help_page(screen_id){
    jQuery(function ($) {                
    	
        if (screen_id) {
            var screen_path = 'customization_help/'+screen_id;
            
            $('#help_info_content').html('<p style="text-align:center;">...Please Wait...</p>');               
            var data = {
    		action: 'load_screen',
            plugin: 'ecommerce-services',
            screen: screen_path
    	   };
            	
        	$.post(ajaxurl, data, function(response) {
        	   $('#help_info_content').html(response);
        	});
        }
    
    });  
}
        
</script>
</div>

</div>

</div>
<script>
//nav_min();
jQuery('.tabs').tabs();

check_cam_use();
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