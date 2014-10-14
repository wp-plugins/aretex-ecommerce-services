
<div class="section group"> <!-- ROW -->
    <div class="col span_7_of_12"> <!-- Column -->
    <div class="ui-widget-header ui-corner-top" >
    <h2 style="text-align: center; margin-top: 5px; margin-bottom: 5px;">Replace Identity Keys</h2>
    </div>
    <div class="ui-widget ui-widget-content  ui-corner-bottom" style="padding: 5px;" >
<form id="replace_id_form">
    <a href="javascript:void(0);"  onclick="load_act_page('account_pages/licenses');"
        class="ui-button  icon_left_button button_link  ui-state-default ui-corner-all"  >
        <span class="ui-icon  ui-icon-circle-arrow-w"></span> 
        Back</a>
        <p>Paste the <em>AreteX Key Replacement Request</em> you in your email below.</p>
        <strong>AreteX Key Replacement Request</strong>
        <textarea id="replacement_request" style="width: 100%; height: 300px;"></textarea>
        <a href="javascript:void(0);" onclick="submit_replace_key();" class="ui-button  icon_left_button button_link  ui-state-default ui-corner-all"  >
<span class="ui-icon  ui-icon-circle-check"></span> 
Submit Key Replacement Rquest</a>
</form>
    </div>
    </div> <!-- END Column -->
    <div class="col span_5_of_12"> <!-- Column -->
    <div class="ui-widget ui-widget-content  ui-corner-all container" style="margin-right: 3px;" >
    <strong>Identity Keys</strong>
    <p>For use if: 1) You know or suspect your server has been compromised or 2) You have accidently deleted your identity keys.</p>
    <p>Open a support ticket and ask for an "Aretex Key Replacement Request" from 3B Alliance, LLC. There may be a charge for this service. </p>
    <p>The AreteX Key Replacement Request will be emailed to your Primary Email Address. </p>
    <p>Copy and paste everything in the request starting with<br /> <strong>--- BEGIN ARETEX KEY REPLACEMENT REQUEST ---</strong><br /> 
    up to and including<br /> <strong>--- END ARETEX KEY REPLACEMENT REQUEST ---</strong>.
    </p>
    <p>After you have pasted the <em>AreteX Key Replacement Request</em> into the text area, choose
    <em>Submit Key Replacement Rquest</em>. 
    </p>
    
    </div>
    </div> <!-- END Column -->    
</div> <!-- END ROW -->
<script>
function submit_replace_key()
{
    jQuery(function ($) { 

              $.ajax({
              type: 'POST',
              url: ajaxurl,
              data: {
		      action: 'atx_replace_id_key',
              data: $('#replacement_request').val()
	          },              
              success: function(data){
                                
                alert(data);
              },
              error: function(xhr, type, exception) {
               
                // if ajax fails display error alert
                  alert("ajax error response type "+type);
                 
              }
            });
        
    
    });
 }  


</script>

