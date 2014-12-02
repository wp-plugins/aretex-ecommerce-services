<?php
    if (! AreteX_WPI::isSecure()) {
        echo '<div class="error"> You must be running your site with SSL (i.e. https) to use AreteX&trade; .<br/>'.
            '<p>It is an AreteX&trade; requirement that <em>all</em> communication use Transport Layer Secuirty (i.e. https, ssl).</p>'.
            '<p>Please install and use an SSL certificate for your site. If you have already installed your SSL certificate, please log out, and log back in using <strong>https:</strong> .</p></div>';
        return false;
    }
?>
<div style="padding: 10px;" class="outer-wrapper" > 

<h2>AreteX&trade; eCommerce Services</h2>
<p>Integrate AreteX&trade; eCommerce Services. Receive credit card payments. 
Automate payouts to contributors and affiliates with Direct Deposit. Track marketing. Automate digital delivery. </p>
<div class="license_info" style="display: inline-block;">
Current AreteX License:&nbsp; 
<?php $license_info = AreteX_WPI::getBasLicense();
    $lt = '';
    switch($license_info->license_type)
    {
        case 'Production':
            $lt = 'Live';
        break;
        default:
            $lt = $license_info->license_type;
    }
    echo  $lt. ':&nbsp';  
    switch($license_info->license_status) {
        case 'Good':
            echo '<span class="license_good">Good</span> ';    
        break;
        case 'Trial':
            if (strtotime($license_info->termination_date) < time() ) {
                echo '<span class="license_invalid">Trial Expired</span> ';
            }
            else {
                echo '<span class="license_good">Free Trial</span> '; 
            }
                
        break;
        case 'Advisory':
             echo '<span class="license_warn">Advisory</span> ';    
        break;
        default:
            echo '<span class="license_invalid">'.$license_info->license_status.'</span>';
        break;
    
    }
    $buttons = AreteX_plugin::topPayButton($license_info);
    echo $buttons;
?>
&nbsp;&nbsp;

<button  onclick="window.open('https://aretex.org/section/setting-up/license-info/');" class="small_license_button">Help</button>
&nbsp;
<img title="Refresh License Info" onclick="jQuery('#refresh_license').submit();" style="position: relative; top: 6px; cursor: pointer;" src="<?php echo plugins_url('../icons/reload_20.png',__FILE__); ?>" />
<form id="refresh_license" method="post"><input type="hidden" name="referesh_cache" value="license_key" /></form>
</div>&nbsp;&nbsp;
<?php  
$gmt =  get_option('gmt_offset');
// $tz_name =  get_option('timezone_string');
$server_time_zone = AreteX_WPI::getTimeZone();
if ($server_time_zone)
{
    $server_status = '<span class="license_good">OK</span> ';
    if ($gmt != $server_time_zone)
    {
        $tzmismatch = '&nbsp;&nbsp;<span  title="Local Timezone does not match Server Timezone." style="font-size: 110%;" class="tz_warn"><strong>&nbsp;!&nbsp;</strong></span>';
    }
    else
        $tzmismatch = '';
}
else
{
    $server_status = '<span class="license_invalid">NO</span> '; 
    $server_time_zone = '<span class="license_invalid">Unavailable</span> ';
    $tzmismatch = '';
}
   

?>
<div class="license_info" style="display: inline-block;">
AreteX Server Status: <?php echo $server_status; ?>&nbsp; Timezone:&nbsp;(UTC <?php echo $server_time_zone?>)<?php echo $tzmismatch; ?>&nbsp;&nbsp; <button  onclick="window.open('https://aretex.org/knowledgebase/about-the-aretex-server/');" class="small_license_button">Help</button>
 
<img title="Refresh Server Status" onclick="jQuery('#refresh_server_status').submit();" style="position: relative; top: 6px; cursor: pointer;" src="<?php echo plugins_url('../icons/reload_20.png',__FILE__); ?>" />

<button type="button"  onclick="jQuery('#clean_cache').submit();" class="small_license_button">Clear Cache</button>
<form id="refresh_server_status" method="post"><input type="hidden" name="referesh_cache" value="server_status" /></form>

<form id="clean_cache" method="post"><input type="hidden" name="referesh_cache" value="all" /></form>

</div>
&nbsp;&nbsp;<div class="license_info" style="display: inline-block; padding: 3px;"><button type="button" style="margin-top: 4px; margin-right: 3px;" onclick="window.open('https://aretex.org');" class="small_license_button">Support</button>
</div>
<?php
    if ($license_info->license_type == 'Transition') {
        echo '<div class="updated" style="width: 80%;" >Access to AreteX&trade; Frozen during transition from "Sandbox" to "Live". 
        When you receive your "Live License" confirmation, please refresh your License Status with "Refresh" icon in the <em>Current AreteX&trade; License</em> block (above). </div>';
    }
    else {
       include (plugin_dir_path(__FILE__).'top_menu.php');  
    } 
    ?>
<div id="main_aretex_content">
 


</div> <!-- End Main AreteX Content -->

</div>
<script>

jQuery(document).ready(function(){
    jQuery(function ($) {
    	$("#navigation").treeview({
    		collapsed: true,
    		unique: false,
    		persist: "location",
            control: "#nav_control"
    	});
        $('#nav_small').hide();
        $('.button').button()
         .click(function( event ) {
            event.preventDefault();
            });
        
    });
});

function load_screen(screen_id){
    jQuery(function ($) {                
    	
        $('#detail_screen').html('<p style="text-align:center;">...Please Wait...</p>');               
        var data = {
		action: 'load_screen',
        plugin: 'ecommerce-services',
        screen: screen_id
	   };
        	
    	$.post(ajaxurl, data, function(response) {
    	   $('#detail_screen').html(response);
    	});
        
    
    });  
}

function load_content_screen(screen_id){
    jQuery(function ($) {                
    	
        $('#main_content').html('<p style="text-align:center;">...Please Wait...</p>');               
        var data = {
		action: 'load_screen',
        plugin: 'ecommerce-services',
        screen: screen_id
	   };
        	
    	$.post(ajaxurl, data, function(response) {
    	  $('#main_content').html(response);
    	});
        
    
    });  
}

function load_div_screen(screen_id,div_id){
    jQuery(function ($) {                
    	
        $(div_id).html('<p style="text-align:center;">...Please Wait...</p>');               
        var data = {
		action: 'load_screen',
        plugin: 'ecommerce-services',
        screen: screen_id
	   };
        	
    	$.post(ajaxurl, data, function(response) {
    	  $(div_id).html(response);
    	});
        
    
    });  
}

function load_linked_screen(screen_id,filter_key){
    jQuery(function ($) {                
    	
        $('#detail_screen').html('<p style="text-align:center;">...Please Wait...</p>');               
        var data = {
		action: 'load_screen',
        plugin: 'ecommerce-services',
        screen: screen_id,
        filter_key: filter_key
	   };
        	
    	$.post(ajaxurl, data, function(response) {
    	   $('#detail_screen').html(response);
    	});
        
    
    });  
}

function load_linked_screen_back(screen_id,filter_key,back_screen){
    jQuery(function ($) {                
    	
        
        
        $('#detail_screen').html('<p style="text-align:center;">...Please Wait...</p>');               
        var data = {
		action: 'load_screen',
        plugin: 'ecommerce-services',
        screen: screen_id,
        filter_key: filter_key,
        back_screen: back_screen
        
	   };
        	
    	$.post(ajaxurl, data, function(response) {
    	   $('#detail_screen').html(response);
    	});
        
    
    });  
}


function load_feature_screen(feature_name, screen_id){
    jQuery(function ($) {                
    	
        $('#detail_screen').html('<p style="text-align:center;">...Please Wait...</p>');               
        var data = {
		action: 'load_screen',
        plugin: 'ecommerce-services',
        screen: screen_id,
        feature: feature_name
	   };
        	
    	$.post(ajaxurl, data, function(response) {
    	   $('#detail_screen').html(response);
    	});
        
    
    });  
}

function load_feature_screen_div(feature_name, screen_id,div_id){
    jQuery(function ($) {                
    	
        $(div_id).html('<p style="text-align:center;">...Please Wait...</p>');               
        var data = {
		action: 'load_screen',
        plugin: 'ecommerce-services',
        screen: screen_id,
        feature: feature_name
	   };
        	
    	$.post(ajaxurl, data, function(response) {
    	   $(div_id).html(response);
    	});
        
    
    });  
}

function load_feature_sub_screen(feature_name, screen_id){
    jQuery(function ($) {                
    	
        $('#feature_detail').html('<p style="text-align:center;">...Please Wait...</p>');               
        var data = {
		action: 'load_screen',
        plugin: 'ecommerce-services',
        screen: screen_id,
        feature: feature_name
	   };
        	
    	$.post(ajaxurl, data, function(response) {
    	   $('#feature_detail').html(response);
    	});
        
    
    });  
}

function load_linked_feature_screen_back(feature_name, screen_id, filter_key,back_screen){
    jQuery(function ($) {                
    	
        $('#detail_screen').html('<p style="text-align:center;">...Please Wait...</p>');               
        var data = {
		action: 'load_screen',
        plugin: 'ecommerce-services',
        screen: screen_id,
        feature: feature_name,
        filter_key: filter_key,
        back_screen: back_screen
	   };
        	
    	$.post(ajaxurl, data, function(response) {
    	   $('#detail_screen').html(response);
    	});
        
    
    });  
}

function nav_min() {

    jQuery(function ($) {
        $('#nav_col').removeClass('span_4_of_10');
        $('#nav_col').addClass('span_1_of_12');
        $('#admin_menu').hide();
        $('#content_col').removeClass('span_6_of_10');
        $('#content_col').addClass('span_11_of_12');
        $('#nav_small').show();
    });
    
}

function nav_max() {
    
    jQuery(function ($) {
        $('#nav_small').hide();
        $('#nav_col').removeClass('span_1_of_12');
        $('#nav_col').addClass('span_4_of_10');
         $('#content_col').removeClass('span_11_of_12');
        $('#content_col').addClass('span_6_of_10');
        $('#admin_menu').show();
        }
    );
}


function load_main_aretex_content(screen_name) {
    jQuery(function ($) {
        $('#main_aretex_content').html('<p style="text-align:center;">...Please Wait...</p>');               
        var data = {
		action: 'load_screen',
        plugin: 'aretex-main',
        screen: screen_name
	   };
        	
    	$.post(ajaxurl, data, function(response) {
    	   $('#main_aretex_content').html(response);
    	});
    }
  );
}

function download_payee_pdf(payee_id,wp_id) {
    url = ajaxurl+'?action=atx_send_admin_ptr_pdf&account_id='+payee_id+'&wp_id='+wp_id;
   
   jQuery('#dl_pdf_frame').attr('src',url);
}

load_main_aretex_content('home');
</script>