<?php 

global $user_email;
get_currentuserinfo();

$url = AreteX_WPI::getBasBsuEndPoint();
$aretex_ajax_auth = AreteX_WPI::ajaxAccessToken('master');
$url .= '?aretex_ajax_auth='.$aretex_ajax_auth;

$license = AreteX_WPI::getBasLicense();

$public_license_key = $license->public_license_key;
$receipt_url = "https://aretexhome.com/AreteX/receipts/view/$public_license_key/sample?aretex_ajax_auth=$aretex_ajax_auth";


 ?>
    <div class="ui-widget ui-widget-content  ui-corner-all dbui-frame container" style="margin-right: 5px;" >
    <h4>Notification Samples</h4>
    <p>Use the buttons below to test or view your current customer notifications.  
    All "eMail Sample" buttons will send sample notifications to your WordPress user email address.  
    </p>    

        <a href="javascript:void(0);"  onclick="send_welcome_sample();"
class="ui-button  icon_left_button button_link  ui-state-default ui-corner-all"  >
<span class="ui-icon  ui-icon-mail-closed"> </span> 
eMail Sample</a>&nbsp;<a href="<?php echo $url; ?>&resource=welcome_email&cmd=get"  target="_blank"
class="ui-button  icon_left_button button_link  ui-state-default ui-corner-all"  >
<span class="ui-icon  ui-icon-newwin"></span> 
View in New Window</a> &nbsp;
<strong>Billing Account Instructions</strong> (Welcome email)<br /><br />

<a href="javascript:void(0);"  onclick="send_confirmation_sample();" 
class="ui-button  icon_left_button button_link  ui-state-default ui-corner-all"  >
<span class="ui-icon  ui-icon-mail-closed"> </span> 
eMail Sample</a>&nbsp;<a  href="<?php echo $receipt_url; ?>&other_type=Approved" target="_blank"    
class="ui-button  icon_left_button button_link  ui-state-default ui-corner-all"  >
<span class="ui-icon  ui-icon-newwin"></span> 
View in New Window</a> &nbsp;
       <strong>Confirmation Notice</strong><br /><br />

<a href="javascript:void(0);"  onclick="send_cancel_sample();"
class="ui-button  icon_left_button button_link  ui-state-default ui-corner-all"  >
<span class="ui-icon  ui-icon-mail-closed"> </span> 
eMail Sample</a>&nbsp;<a href="<?php echo $receipt_url; ?>&other_type=Cancel" target="_blank"  
class="ui-button  icon_left_button button_link  ui-state-default ui-corner-all"  >
<span class="ui-icon  ui-icon-newwin"></span> 
View in New Window</a> &nbsp;        
        <strong>Cancellation Confirmation</strong><br /><br />
        
<a href="javascript:void(0);"  onclick="send_refund_sample();"
class="ui-button  icon_left_button button_link  ui-state-default ui-corner-all"  >
<span class="ui-icon  ui-icon-mail-closed"> </span> 
eMail Sample</a>&nbsp;<a href="<?php echo $receipt_url; ?>&other_type=Refund" target="_blank"  
class="ui-button  icon_left_button button_link  ui-state-default ui-corner-all"  >
<span class="ui-icon  ui-icon-newwin"></span> 
View in New Window</a> &nbsp;        
        <strong>Refund Notification</strong><br /><br />        

<a href="javascript:void(0);"  onclick="send_receipt_sample();"
class="ui-button  icon_left_button button_link  ui-state-default ui-corner-all"  >
<span class="ui-icon  ui-icon-mail-closed"> </span> 
eMail Sample</a>&nbsp;<a href="<?php echo $receipt_url; ?>" target="_blank"  
class="ui-button  icon_left_button button_link  ui-state-default ui-corner-all"  >
<span class="ui-icon  ui-icon-newwin"></span> 
View in New Window</a> &nbsp;  
        <strong>Payment Recieved Notification</strong> (Receipt) <br /><br />

<a href="javascript:void(0);"  onclick="send_pending_sample();"
class="ui-button  icon_left_button button_link  ui-state-default ui-corner-all"  >
<span class="ui-icon  ui-icon-mail-closed"> </span> 
eMail Sample</a>&nbsp;<a href="<?php echo $url; ?>&resource=pending_auto_charge&cmd=get"  
target="_blank"  class="ui-button  icon_left_button button_link  ui-state-default ui-corner-all"  >
<span class="ui-icon  ui-icon-newwin"></span> 
View in New Window</a> &nbsp;
        <strong>Pending Automatic Charge Notification</strong>
<br /><br />        
     
    </div>
<script>
function send_pending_sample()
{
    jQuery.ajax({
      type: 'POST',
      url: '<?php echo $url; ?>',
      data: {        
        resource: 'pending_auto_charge',
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

function send_cancel_sample()
{
    jQuery.ajax({
      type: 'POST',
      url: '<?php echo $url; ?>',
      data: {        
        resource: 'cancelation_notice',
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

function send_refund_sample()
{
    jQuery.ajax({
      type: 'POST',
      url: '<?php echo $url; ?>',
      data: {        
        resource: 'refund_notice',
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


function send_receipt_sample()
{
    jQuery.ajax({
      type: 'POST',
      url: '<?php echo $url; ?>',
      data: {        
        resource: 'receipt',
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

function send_confirmation_sample()
{
    jQuery.ajax({
      type: 'POST',
      url: '<?php echo $url; ?>',
      data: {        
        resource: 'confirmation_notice',
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