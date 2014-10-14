<?php  
global $payee;
global $business_name;
global $account_id;

require_once(plugin_dir_path( __FILE__ ).'../ptrlib.php');

$signed_up = $_SESSION['current_aretex_payee'];
$current_user_id = get_current_user_id(); 

if ($signed_up->linked_user_id != $current_user_id) {
    $signed_up = AreteX_WPI::payeeSignedUp($current_user_id);
    $_SESSION['current_aretex_payee'] = $signed_up;
}
if (! $signed_up) {
    echo "Problem with Payee User Validation ... ";
    return;
}

$license = AreteX_WPI::getBasLicense();
$business_name = $license->Business_Name;

$account_id = $signed_up->id;

$obj = AreteX_WPI::payeeAccountInfo($account_id);


?>
<?php 
//$obj = getResource('');
$payee = $obj->name; 
$obj = AreteX_WPI::payeePaymentAccount($account_id);
if (is_object($obj))
    $payment_account = get_object_vars($obj);
else
    $payment_account = $obj;


//$payment_options = getGeneralResource('options');

$payment_options =  AreteX_WPI::getPayeePaymentOptions($account_id); 


$current_option = 'Currently, you have no valid payment authorization within this system. To receive payments from '.$business_name.
                  ', you must authorize automatic payments as described below.';


$options = '';
$payment_authorized = false;
$sel_opt = false;
foreach($payment_options as $opt)
{
  //  echo $payment_account['payment_type']->value. '---' .$opt->id_payment_type . '<br/>';
    
    if ((! empty($payment_account['payment_type'])) && is_object($payment_account['payment_type']) && ( $payment_account['payment_type']->value == $opt->id_payment_type) )
    {        
        $payment_authorized = true;
        $opt_name = $opt->name;

        $current_option = 'Your account is now authorized for payment to you with <strong>'.$opt->name.'</strong>. '.
                          ' You can now track your payments through "Payments Pending" and "Payments Sent" on the Payments menu.';
        $options .= '<option value="'.$opt->id_payment_type.'" selected="selected">'.$opt->name;
        $options .= '</option>'."\n";
        
        $sel_opt = $opt;
      
    }
    else
    {
      // echo "\nPayment Account Not = ".$opt->name;
        $options .= '<option value="'.$opt->id_payment_type.'" >'.$opt->name;
        $options .= '</option>'."\n";
    }
}



?>
<div class="section group"> <!-- ROW -->

    <div class="col span_2_of_12"> <!-- Column -->
    <a href="javascript:void(0);"  onclick="load_ptr_page('payments');"
class="ui-button  icon_left_button button_link  ui-state-default ui-corner-all"  >
<span class="ui-icon  ui-icon-circle-arrow-w"></span> 
Back to Overview</a>    
    </div> <!-- END Column -->
</div> <!-- END ROW -->
<!-- Row 1 -->	
<div class="section group">      

<div class="col span_11_of_12">
    
    <div class="ui-widget ui-widget-header ui-corner-top">
    <h3>Payment Authorization Summary </h3>
    </div>
    <div class="container ui-widget-content ui-corner-bottom">
        <div class="section group">      
            <div class="col span_12_of_12">
                <h4>Current Authorizaton:</h4>
                <?php  echo $current_option ?>
            </div>
        </div>
        <?php  
            $require_3ba_xmit_ok = false;
        
           if (count($payment_options) > 1)
           { ?>
        <div class="section group">      
            <div class="col span_12_of_12">
                
                <?php  if (! $payment_authorized)
                   {
                 ?>
                <label style="margin-bottom: 3px;" for="select_how">Select How You Would Like to be Paid</label>
                <select id="select_how"><?php  echo $options; ?></select>
                <?php  }
                   else
                   {
                    ?>
                     <p>To Revoke Your Authorization For <?php  echo $opt_name; ?> select the button below. 
                     </p>
                     
                     <a href="javascript:void(0);"  class="ui-button  icon_left_button button_link  ui-state-default ui-corner-all"  ><span class="ui-icon  ui-icon-circle-close"></span> Revoke <? echo $opt_name; ?> Authorization</a>
                     <blockquote class="note_box"><em>Note: </em>You must revoke your current authorization before selecting a new one.</blockquote>
                     
                <?php                      
                   }
                 ?>
                
                
            </div>
        </div>
        
        <?php  
            $below = "";
            }
           else if (count($payment_options) == 0)
           {
         ?>
            <div class="section group">      
                <div class="col span_12_of_12">
                    <p><?php  echo $business_name; ?> does not support automatic payments.  </p>
                </div>
            </div>
            
         <?php   
            $below = '';   
           }
           else
           {
           ?>
             
             <p>(<?php echo $business_name; ?> supports <b><?php  echo $payment_options[0]->name; ?></b> 
             to automatically send payments owed to you.) </p>
           <?php 
             if (! $payment_authorized)
             {
                $require_3ba_xmit_ok = true;
                $below = build_authorization_form($payment_options[0]->id_payment_type,$payment_options[0]->fields,$payment_options[0]->name,0,$payment_options[0]->config_option);
             }
             else
             {
                $below = build_authorization_details($sel_opt->id_payment_type,
                $sel_opt->fields,$sel_opt->name,0,$opt_name, $payment_account);
             }
           }
         ?>
    
    </div>
   

</div>
<?php 
 if ($require_3ba_xmit_ok) {
 ?>
 <div class="section group"> <!-- ROW -->
    <div class="col span_11_of_12"> <!-- Column -->

<div class="ui-widget ui-widget-content  ui-corner-all container" >
<p><em>Note: </em> To continue with this authorization to deposit funds into your checking acount, you must explictly agree to the terms below.</p>
<p>

    <input style="width: 30px !important;" id="I_Agree_xmit" type="checkbox" onchange="show_below()" /> I Acknowledge and Agree that this payment account information 
    will not be transmitted to, or stored upon <?php echo $business_name ?> servers, but will be transmitted to AreteX&trade; for encryption and automated payouts. AreteX&trade; is an authorized ACH transmitter for <?php echo $business_name; ?>.
    For more information on AreteX&trade; security and privacy policies, <a href="https://aretexsaas.com/security-policy/" target="_blank">click here</a>.
  </p>  
    <script>
 function show_below() {
    if (jQuery('#I_Agree_xmit').is(':checked'))
        jQuery('#detail_below').show();
    else
        jQuery('#detail_below').hide();
 }
 </script>
 </div>
     </div> <!-- END Column -->
</div> <!-- END ROW -->
 <?php   
    
 }
 
 ?>
 
 </div>
 <!-- End Row 1 -->
 <!-- Row 2 -->	
<div id="detail_below"> 
    <div class="section group">      
        <div class="col span_11_of_12">
        <?php 
            echo $below;  
        ?>
        </div>
    </div>
</div>
 <!-- End Row 2 -->
 <script>
 <?php 
 if ($require_3ba_xmit_ok) {
 ?>
 
    jQuery('#detail_below').hide();
 <?php   
    
 }
 
 ?>
 
jQuery(document).ready(function() {
 // init_buttons();
  
  jQuery.validator.addMethod("routing", function(value, element) {
return this.optional(element) || checkABA(value);
}, "Please enter a valid Bank Routing Number");
  
 });
 
function dl_pdf()
{
   // alert('hi');
   url = ajaxurl+'?action=atx_send_ptr_pdf&account_id=<?php echo $account_id; ?>';
   jQuery('#dl_pdf_frame').attr('src',url);
}

<?php 

$ptr_direct_url = AreteX_WPI::ptrAjaxDirect();
$ajax_access_token = AreteX_WPI::ajaxAccessToken('master',true);
$ptr_direct_url = $ptr_direct_url."/index.php?aretex_ajax_auth=".$ajax_access_token;
?> 

function revoke_payment_auth()
{
     if (confirm('Please Confirm Revocation'))
     {
        
                  
         jQuery.ajax({
          type: 'POST',
          url: '<?php echo $ptr_direct_url;  ?>',
          data: {cmd:'del', urn:'payment_account', account_id:'<?php echo $account_id; ?>'  },
          success: function(data){
            // on success use return data here
            load_ptr_page('ach_auth');
          },
          error: function(xhr, type, exception) { 
            // if ajax fails display error alert
            alert("There was a problem deleting your account, you may try again later.");
          }
        });
     
     }
}



function checkABA(s) 
{

  var i, n, t;

  // First, remove any non-numeric characters.

  t = "";
  for (i = 0; i < s.length; i++) {
    c = parseInt(s.charAt(i), 10);
    if (c >= 0 && c <= 9)
      t = t + c;
  }

  // Check the length, it should be nine digits.

  if (t.length != 9)
    return false;

  // Now run through each digit and calculate the total.

  n = 0;
  for (i = 0; i < t.length; i += 3) {
    n += parseInt(t.charAt(i),     10) * 3
      +  parseInt(t.charAt(i + 1), 10) * 7
      +  parseInt(t.charAt(i + 2), 10);
  }

  // If the resulting sum is an even multiple of ten (but not zero),
  // the aba routing number is good.

  if (n != 0 && n % 10 == 0)
    return true;
  else
    return false;
}

 jQuery('#dl_pdf_frame').hide();
</script>
 
