<? 
  $pcs_out_settings = AreteX_WPI::getBsuPcsOut();
  $license_info = AreteX_WPI::getBasLicense(); 
?>
<div class="ui-widget-header ui-corner-top" >
<h2 style="text-align: center; margin-top: 5px; margin-bottom: 5px;">Pay Your People</h2>
</div>
<div class="ui-widget ui-widget-content  ui-corner-bottom" style="padding: 5px;" >
<a href="javascript:void(0);"  onclick="load_screen('welcome');"
class="ui-button  icon_left_button button_link  ui-state-default ui-corner-all"  >
<span class="ui-icon  ui-icon-circle-arrow-w"></span> 
Back</a>
<hr />
    <p>AreteX&trade; for WordPress supports two types of automated outbound  (Direct Deposit) payments:
    <ul>
        <li><strong>Referrers:</strong> (Sales Reps, Affiliates, Distributors etc.) who are paid a commission on a sale for promoting your products and/or services. </li>
        <li><strong>Contributors:</strong> (Vendors, Authors, Instructors etc.) who are paid a royalties, fees, wholesale prices etc. when you sell a product or service they have provided or will provide.</li>
    </ul>
    </p>
    
    <p>The wizards below will guide you through setting up these automated payments. </p>
    
    <hr />
<h3>Pay People Wizards</h3>

<a href="#" onclick="load_screen('ach_dd_setup');" class="icon_center_button ui-button button_link  ui-state-default ui-corner-all setup_button">

<img src="<? echo  plugins_url( '../../images/buttons/check2_40.png', __FILE__ ) ?>" /><br />
<? if (! empty($pcs_out_settings->forte_merchant_id) && $license_info->license_type == 'Production') { ?>
Direct Deposit<br />
Settings
<? } else { ?> 
How to Setup<br />
Direct Deposit
<? } ?>
</a>


<a href="#"  onclick="load_screen('simple_tracking_code');" class="icon_center_button ui-button button_link  ui-state-default ui-corner-all">

<img src="<? echo  plugins_url( '../../images/buttons/barcode_40.png', __FILE__ ) ?>" /><br />
Simple Tracking<br />
Code
</a>


<a href="#"  onclick="load_screen('sched_payments');" class="icon_center_button ui-button button_link  ui-state-default ui-corner-all">

<img src="<? echo  plugins_url( '../../images/buttons/clock_40.png', __FILE__ ) ?>" /><br />
Automatic Payment <br />
Schedule
</a>


<a href="#"  onclick="load_screen('simple_commission_stru');" class="icon_center_button ui-button button_link  ui-state-default ui-corner-all">

<img src="<? echo  plugins_url( '../../images/buttons/events_40.png', __FILE__ ) ?>" /><br />
Simple Commission<br />
Structure
</a>


<a href="#"  onclick="load_screen('assign_referrers');" class="icon_center_button ui-button button_link  ui-state-default ui-corner-all">

<img src="<? echo  plugins_url( '../../images/buttons/user_40.png', __FILE__ ) ?>" /><br />
Assigning Referrers<br />
to Groups
</a>

<a href="#"  onclick="load_screen('not_yet');" class="icon_center_button ui-button button_link  ui-state-default ui-corner-all">

<img src="<? echo  plugins_url( '../../images/buttons/operator_40.png', __FILE__ ) ?>" /><br />
Paying<br />
Contributors
</a>

<? if ($license_info->license_type == 'Production') { ?>

<a href="#"  onclick="show_hidden_buttons();" class="icon_center_button ui-button button_link  ui-state-default ui-corner-all show_button">

<img src="<? echo  plugins_url( '../../images/buttons/sun_40.png', __FILE__ ) ?>" /><br />
Show Hidden<br />
Buttons
</a>

<a href="#"  onclick="hide_done_buttons();" class="icon_center_button ui-button button_link  ui-state-default ui-corner-all setup_button">

<img src="<? echo  plugins_url( '../../images/buttons/moon_40.png', __FILE__ ) ?>" /><br />
Hide Completed<br />
Tasks
</a>

<? } ?>    
</div>
<script>
jQuery(document).ready(function() {
    jQuery(function ($) {
    // Hover states on the static widgets
    	$( ".ui-button" ).hover(
    		function() {
    			$( this ).addClass( "ui-state-hover" );
    		},
    		function() {
    			$( this ).removeClass( "ui-state-hover" );
    		}
    	);
        
        $('.icon_center_button').hover(
            function()
            {
                var src = $( this).children('img').attr('src');           
                src = hover_url(src);        
                $(this).children('img').attr('src',src);
                
                
            },
            function()
            {           
                var src = $( this).children('img').attr('src');
                src = off_hover_url(src);
                $(this).children('img').attr('src',src);
    
            }        
        );
        
         <? if ($license_info->license_type == 'Production') { ?> 
            $('.setup_button').hide();
                     
            
         <? } ?>
        
    });
    
    
  
  
 });
 
 function show_hidden_buttons() {
     jQuery(function ($) {
        $('.setup_button').show();
        $('.show_button').hide();
     });
    
 }
 
 function hide_done_buttons() {
     jQuery(function ($) {
        $('.show_button').show();
        $('.setup_button').hide();
     });
    
 }
 
</script>
