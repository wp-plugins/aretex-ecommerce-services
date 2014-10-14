<?php 
    $url = AreteX_WPI::getBasBsuEndPoint();
    $aretex_ajax_auth = AreteX_WPI::ajaxAccessToken('master');
    $url .= '?aretex_ajax_auth='.$aretex_ajax_auth;
    
    $pcsurl = get_option('aretex_pcs_in_endpoint');
    $pcsurl .= '/sample_cc_form.php?aretex_ajax_auth='.$aretex_ajax_auth;
    
?>
<div class="ui-widget-header ui-corner-top" >
<h2 style="text-align: center; margin-top: 5px; margin-bottom: 5px;">Payment Form Style Customization</h2>
</div>
<div class="ui-widget ui-widget-content  ui-corner-bottom dbui-frame container"  style="padding-bottom: 5px; padding-right: 5px;">
<div class="tabs">
<ul>
<li><a href="#tabs-1">Payment Form Setup</a></li>
<li><a href="#tabs-2">Help and Information</a></li>
</ul>
<div id="tabs-1">
<form id="payment_customize_form" enctype="multipart/form-data">
<div class="section group"> <!-- ROW -->
    <div class="col span_12_of_12"> <!-- Column -->

<p>This form is how you (the web designer) can match the "look and feel" of the credit card payment form to your WordPress site.
  If you are not comfortable with terms like "CSS Class" and "Element Tag" you should consult a web designer before making modifications on this screen.</p>

<p><em>Note:</em>This style sheet is being submitted to AreteX&trade;, not your WordPress site.</p>
    </div> <!-- END Column -->
</div> <!-- END ROW -->
<div class="ui-widget-content ui-corner-top" >
<h2 style="text-align: center; margin-top: 5px; margin-bottom: 5px;">Payment Form Customization</h2>
</div>
<div class="ui-widget ui-widget-content  ui-corner-bottom" style="padding: 3px;" >

<div class="section group"> <!-- ROW -->   
    <div class="col span_6_of_12"> <!-- Column -->
          
           <?php 
           
               $card_list = array('Visa','MasterCard','AmericanExpress','Discover');
               foreach($card_list as $card) {
                $val = AreteX_WPI::getBsuConfiguration("accept_$card");
                if ($val == 'Yes') {
                   $card_checked[$card] = 'checked="checked"';  
                }
                else {
                    $card_checked[$card] = '';
                }
                    
               }
           ?>
           
            <fieldset>
            <legend>Accepted Credit Cards</legend>
            <input id="accept_AmericanExpress" <?php echo $card_checked['AmericanExpress']; ?> onchange=" highlight_css_submit();" type="checkbox" name="credit_cards[]" value="AmericanExpress" style="width: 30px !important;" /> AMEX &nbsp;
             <input id="accept_Visa" <?php echo $card_checked['Visa']; ?> onchange=" highlight_css_submit();" type="checkbox" name="credit_cards[]" value="Visa" style="width: 30px !important;" /> Visa &nbsp;
             <input id="accept_MasterCard" <?php echo $card_checked['MasterCard']; ?>  onchange=" highlight_css_submit();" type="checkbox" name="credit_cards[]" value="MasterCard" style="width: 30px !important;" /> Master Card &nbsp;
             <input id="accept_Discover" <?php echo $card_checked['Discover']; ?>  onchange=" highlight_css_submit();" type="checkbox" name="credit_cards[]" value="Discover" style="width: 30px !important;" /> Discover &nbsp;
             <p>Check all that you accept.</p>


            </fieldset>
            <fieldset>
            <legend>CSS File</legend>
            <input id="use_default_css" onchange="check_use_def();  highlight_css_submit();" type="checkbox" name="use_default" value="true" style="width: 30px !important;" /> Use the default style sheet. <span style="font-size: 75%;"><em>(You must hit submit to send this setting.)</em>
            <button type="button" style="margin: 4px; " onclick="download_default_payment_css();" class="small_license_button">Download Default Stylesheet</button> <br />
            </span>
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
            We recommend you begin with the default style sheet, using your favorite CSS editor to match your site's look and feel.<br />
            <em>Note</em> this file will be sanitized after it is submitted to AreteX&trade;. 
            </span> 
            <input name="file" type="file" onchange="highlight_css_submit();" />
            </span>
            <span style="font-size: 70%;">
            <button type="button" style="margin: 4px; " onclick="download_payment_css();" class="small_license_button">Download Current Stylesheet</button> <br />
            </span>
            </fieldset>

            <hr />
            <div id="css_submit_button">
            <a href="javascript:void(0);"  onclick="submit_payment_style();"
        class="ui-button  icon_left_button button_link  ui-state-default ui-corner-all"  >
        <span class="ui-icon  ui-icon-circle-check"></span> 
        Submit</a> (Current Style Sheet is shown below.)
                   <div class="plz_wait" style="width: 60%; margin-left: auto; margin-right: auto; padding: 5px;" ></div>

           </div>
           <script>
            function download_payment_css() {
                     url = ajaxurl+'?action=atx_download_as_attachment&file_id=payment_css';
                    jQuery('#download_frame').attr('src',url);

            }
            
             function download_default_payment_css() {
                     url = ajaxurl+'?action=atx_download_as_attachment&file_id=default_payment_css';
                    jQuery('#download_frame').attr('src',url);

            }
            
            </script>
                    
    </div> <!-- END Column -->
    <div class="col span_6_of_12"> <!-- Column -->
    <fieldset style="margin-right: 5px;">
    <legend>Branding Box</legend>
    <textarea onchange="highlight_css_submit();" id="branding_box" name="branding_box"></textarea>
    <span style="font-size: 75%;"><em>Note</em> The branding box lets you put your business name, logo etc. at the top of the payment form.
    The HTML will be sanitized.  See "Help and Information / Payment Forms" for more details.
    </span>
    </fieldset>
                <fieldset>
            <legend>Current Sample</legend>
            <a href="<?php echo $pcsurl; ?>" target="_blank"  
class="ui-button  icon_left_button button_link  ui-state-default ui-corner-all"  >
<span class="ui-icon  ui-icon-newwin"></span> 
Sample Payment Form</a>
<p>View a sample of the current payment form in a new window. You may need to clear your browser cache to see your latest changes.</p>
            </fieldset> 
        
    </p>

    </div> <!-- END Column -->
</div> <!-- END ROW -->

</div>
<div class="section group"> <!-- ROW -->
        <div class="col span_12_of_12"> <!-- Column -->
        <div class="ui-widget ui-widget-content  ui-corner-all container" >
            
           <p>Your style sheet is stored on the AreteX&trade; server. The current style sheet in use by AreteX&trade; is listed below.</p>
           <p>For your convience, we have provided a default style sheet in the style_sheet_template directory of this plugin. You can modify it to make your "look and feel" consistent with your theme.</p>
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

<script>

function submit_payment_style() {

var form_data = jQuery('#payment_customize_form').serialize();
jQuery('.plz_wait').html('<center>...Please Wait...</center>');

 var ajax_options = {
  type: 'POST',
  url: '<?php echo $url; ?>',
  
  crossDomain: true,
  success: function(data){
    
    alert('Success');
    //jQuery('#current_notification_customizations').html(data);
    get_payment_style();
    unhighlight_css_submit();
  },
  error: function(xhr, type, exception) { 
    
    alert("Error: "+exception);
  }
}
 
   
        
   jQuery('#payment_customize_form').ajaxSubmit(ajax_options); 
 
        
    return false; 
    

}
</script>
<hr />
<h2>Current Payment Form Style Sheet</h2>

<div id="current_payment_form_customizations"></div>

<script>
function get_payment_style()
{

    jQuery.ajax({
      type: 'GET',
      url: '<?php echo $url; ?>',
      data: {        
        resource: 'payment_form_style',
        cmd: 'get'
      },
      dataType: 'jsonp',
      success: function(data){

        jQuery('#current_payment_form_customizations').html(data['css']);
        jQuery('#branding_box').val(data['branding_box']);
      },
      error: function(xhr, type, exception) { 
        // if ajax fails display error alert
        alert("Ajax Error: Exception: "+exception);
      }
    });
}

get_payment_style();
nav_min();

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

<input type="hidden" name="resource" value="payment_form_style" />
<input type="hidden" name="cmd" value="post" />

</form>
</div> <!-- END Tab 1-->

<div id="tabs-2">

<?php include plugin_dir_path( __FILE__ ).'payment_customization_help/top_menu.php'; ?>
<div id="help_info_content">
<?php include plugin_dir_path( __FILE__ ).'payment_customization_help/overview.php';  ?>
</div>

<script>
jQuery('.button-set').buttonset();
jQuery('button.menu_button').click(
            function() { load_payment_help_content(this); }
         );


 function load_payment_help_content(element)
 {
    
    load_payment_help_page(element.id);
    
 }
 
 function load_payment_help_page(screen_id){
    jQuery(function ($) {                
    	if (screen_id) {
            var screen_path = 'payment_customization_help/'+screen_id;
            
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


</div> <!-- END Tab 2 -->
</div> <!-- END Tabs -->
</div> 
<script>
jQuery('.tabs').tabs();
</script>
