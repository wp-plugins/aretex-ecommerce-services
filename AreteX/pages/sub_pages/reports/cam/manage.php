<?php $icon_path = plugins_url('../../../../icons/',__FILE__);

 global $customer_id;
 
 $customer_id = $_REQUEST['linked_id'];
 
  require_once(plugin_dir_path( __FILE__ ).'camlib.php');
 
 $obj = getResource('contact');
 
 
?>

<h4>Customer: <?php echo $obj->firstname . ' '.$obj->lastname. ' -  '.$obj->email_address; ?></h4>
<a href="javascript:void(0);"  onclick="load_content_screen('reports/customers');"
class="ui-button  icon_left_button button_link  ui-state-default ui-corner-all"  >
<span class="ui-icon  ui-icon-circle-arrow-w"></span> 
Back</a>&nbsp;&nbsp;To return to the customer list, click the back button.
<hr />
    <nav>
    <div class="ui-widget ui-widget-header ui-corner-all" style=" padding: 5px;">
    
    
    
    
    <div class="button-set">
        <button id="overview" class="cam_menu_button icon_left_button ui-button"><img class="icon_left" src="<?php echo $icon_path.'eye_open_16.png' ?>"/>Overview</button>        
        <button id="contact" class="cam_menu_button icon_left_button ui-button"><span class="ui-icon ui-icon-person"></span>Billing Contact</button>    
        <button id="rebill" class="cam_menu_button icon_left_button ui-button"><span class="ui-icon ui-icon-tag"></span>Rebill Agreements</button>        
        <button id="purchase_history" class="cam_menu_button icon_left_button ui-button"><span class="ui-icon ui-icon-clock"></span>Purchase History</button>
       
        
    </div>
    
    
    
    
    </div>
    </nav>
<hr />
<div id="cam_content">

</div>
<script>
jQuery('.button-set').buttonset();

jQuery('.cam_menu_button').click(
            function() { load_cam_content(this); }
         );

 function load_cam_content(element)
 {
    
    load_cam_page(element.id);
    
 }
 
 function load_cam_page(screen)
 {
    load_linked_cam_page('reports/cam/'+screen,'<?php echo $customer_id; ?>');
 }

load_cam_page('overview');


function submit_cam_info(form_id)
{
    jQuery(function ($) { 
        $(form_id).validate();
        if ($(form_id).valid())
        {
            
            var q = $(form_id).serialize();
            $('#cam_content').html('<p style="text-align:center;">...Please Wait...</p>');
            
        
            $.ajax({
              type: 'POST',
              url: ajaxurl,
              data: {
		      action: 'atx_updatecamcontact',
              data: q 
	          },              
              success: function(data){
                                
                load_cam_page('contact');
              },
              error: function(xhr, type, exception) {
               
                // if ajax fails display error alert
               // alert("ajax error response type "+type);
                 alert('There was a problem submitting your information.\nPlease be sure all fields are correct when you try again.\nYou may need to enter a different bank account.');
                 load_cam_page('contact');
              }
            });
        }
    
    });
 }
 
  
               
 
function cancel_rebill(rebill_id)
{
    if (confirm('By Canceling this subscription,\nyou will no longer be billed and your access to this product/service will expire.\n\nClick OK to Confirm Your Intent to Cancel.'))
    {
        jQuery(function ($) {                
    	
        $('#cam_content').html('<p style="text-align:center;">...Please Wait...</p>');               
        var data = {
		action: 'atx_cancelrebill',
        rebill_id: rebill_id 
	   };
        
       	
    	$.post(ajaxurl, data, function(response) {
    	   load_linked_cam_page('reports/cam/rebill_detail',rebill_id);
    	});
        
    
    });  
    }
}

function load_receipt(url)
{
    jQuery('#cam_content').html('<button class="ui-button icon_left_button button_link ui-state-default ui-corner-all" onclick="load_cam_page(\'purchase_history\');"><span class="ui-icon ui-icon-circle-arrow-w"></span>Back</button><hr/><div id="rctp_div"></div>'); 
    jQuery.ajax({
      type: 'GET',
      url: url,
      data: null,
      dataType: 'jsonp',
      success: function(data){
        var full_html = '<em>Note:</em> To print only the receipt (and not this whole page), select "Display Receipt in New Window", then select "Print This Page". ';
        full_html = full_html + '<hr/>' + data;
        jQuery('#rctp_div').html(full_html);
      },
      error: function(xhr, type, exception) { 
        // if ajax fails display error alert
        alert("Ajax Error: Exception: "+exception);
      }
    });
    
    
}

</script>    
    