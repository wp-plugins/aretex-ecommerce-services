<div class="section group"> <!-- ROW -->
    <div class="col span_8_of_12"> <!-- Column -->

<div class="ui-widget-header ui-corner-top" >
<h2 style="text-align: center; margin-top: 5px; margin-bottom: 5px;">Setup a New Paid Content Deliverable</h2>
</div>
<div class="ui-widget ui-widget-content  ui-corner-bottom" style="padding: 5px;" >
    <a href="javascript:void(0);" id="pcmgm_btn"  onclick="mg_pc_deliverable();"
class="ui-button  icon_left_button button_link  ui-state-default ui-corner-all"  >
<span class="ui-icon  ui-icon-circle-arrow-w"></span> 
Back</a>
    <hr />
  
    <div id="wizard">
    <!-- steps will go here -->

    <div data-jwizard-title="Identity" id="s1">
        <!-- step content -->

        <div style="margin: 5px;" id="new_pc_deliverable">
            <form id="new_pc_form">
                <label for="prod_name2">Enter the Content Name</label><input required="required"  id="pc_dlv_name" name="pc_dlv_name" type="text" />               
                <label for="prod_name2">Describe the Content</label><textarea   id="pc_dlv_desc" name="pc_dlv_desc" ></textarea>               
                <p>This will be available in reports and shortcodes. It is optional.   </p>
 
                 
                <label style="display: inline-block;">Deliverable Code</label><input required="required"   id="dlv_code" name="dlv_code" size="25" style="width: 55px;" type="text" />
                <input id="let_aretx_assign" type="checkbox" onclick="aretex_assigns_code();" /> <span style="display: inline-block;">Let AreteX&trade; Assign the Deliverable Code</span>
                <p>This is a unqiue short identifier used to refer to this deliverable. You will need it for shortcodes.  </p>
            </form>
        </div>
        
    </div>
    <div data-jwizard-title="Availablity" id="s2">
        <div style="margin: 5px;" >             
             <form id="avail_form">
                <div class="ui-widget">
                    <label for="start_time">Start Date/Time:</label>
                    <p><input type="text" class="" size="25" style="width: 100px; display: inline-block;" type="text"  name="start_time"  id="start_time"  value="" />
                    This is the start of the availablity. (YYYY-MM-DD HH:MM:SS)  Leave blank for "upon payment"  </p>

                
                    <label for="first_delivery">Number of Days to Wait: </label>
                    <p><input type="text" class="required digits" size="25" style="width: 55px; display: inline-block;" type="text"  name="first_delivery"  id="first_delivery"  value="0" />
                    This is for "Drip Delivery" or "Timed Delivery". This is useful for lessons, for example. (i.e.) "First Week" wait 0 Days, "Second Week" wait 7 Days etc.</p>
                </div>
                
                
             </form>   
                
        </div>
            
         
    </div>
    <div  data-jwizard-title="Re-Authorization" id="s3">
         <div style="margin: 5px;" > 
            <form id="cycle_form">
                <div class="ui-widget">
                <div class="ui-widget">
                    <label for="duration">Days of Authorization Availablity: </label>
                    <p><input type="text" class="digits" size="25" style="width: 55px; display: inline-block;" type="text" value=""  name="duration"  id="duration"  />
                    Unless renewed, access authorization to this content will expire after this many days. Leave blank for "Does not expire".</p>
                    
                </div>
                
                
                    <label for="delivery_cycle">Access Re-Authorization Cycle: </label>
                     <p><select id="delivery_cycle" name="delivery_cycle" onchange="change_reauth()" style="display: inline-block;">
                    <option value="single" selected="selected">Single</option>
                    <optgroup label="Recurring">
                        <option value="daily">Daily</option>
                        <option value="weekly">Weekly</option>
                        <option value="monthly" >Monthly</option>
                        <option value="quarterly">Quarterly</option>
                        <option value="yearly">Yearly</option>
                    </optgroup>
                    </select>
                   How often to check for access authorization renewal. If payment has been canceled or has failed, access to content will expire based on "Days of Availablity" .</p>
                </div>

            </form>
            <script>
            function change_reauth() 
            {
                var cycle = jQuery('#delivery_cycle').val();
                var days = '';
                switch(cycle)
                {
                    case 'single':
                        days = '';
                    break;
                    case 'daily':
                        days = '1';
                    break;
                    case 'weekly':
                        days = '7';
                    break;
                    case 'monthly':
                        days = '31';
                    break;
                    case 'quarterly':
                        days = '90';
                    break;
                    case 'yearly':
                        days = '365';
                    break;                    
                }
                jQuery('#duration').val(days);    
            }
            </script>
            </div>
       
    </div>
    <div  data-jwizard-title="Total Number" id="s4">
         <div style="margin: 5px;" >
           <div id="not_single">
            <form id="cycle_form2">
                <div class="ui-widget">
                    <label for="maximum_deliveries">Total Number of Re-Authorizations: </label>
                    <p><input type="text" class="digits" size="25" style="width: 55px; display: inline-block;" type="text" value=""  name="maximum_deliveries"  id="maximum_deliveries"  />
                    This is the total number of Re-Authorizations AreteX&trade; will perform. Leave blank for "Until Canceled". (Ignored for "Single" Deliveries)</p>
                    
                </div>
            </form>
            </div>
            <div id="is_single">
            <p>You have chosen single authorization without renewal. There will be no renewal cycles.</p>
            </div>
            </div>
            <p>When you select <em>Next</em> your deliverable will be created on the AreteX&trade; Server</p>
      <div id="wait_for_save"></div>    
    </div>

   
    <div data-jwizard-title="Shortcodes" id="s5">
        <!-- step content -->
        <div id="short_code_panel"  class="ui-widget ui-widget-content  ui-corner-all sc_example" >
        
        </div>
        <p>Copy and paste the shortcode(s) onto your content page. Substitute your apporpriate content where noted.</p>

        
    </div>
</div>

<script>
jQuery('.tabs').tabs();
var cancel_pressed;
var prev_pressed;

load_pc_help('s1');

jQuery(document).ready(function() {
   // put all your jQuery goodness in here.
   jQuery("#wizard")
       .on("stepshow", "#s1", function () {
         load_pc_help('s1');
         cancel_pressed = false;
         return true;
      })
       .on("stephide", "#s1", function () {
         return setup_step_2();
      })
      .on('stepshow','#s2', function() {
        load_pc_help('s2');
      })
       .on("stephide", "#s2", function () {         
         return setup_step_3();
      })
      .on('stepshow','#s3', function() {
        load_pc_help('s3');
      })
      .on("stephide", "#s3", function () {         
         return finish_step_3();
      })
      .on('stepshow','#s4', function() {
         load_pc_help('s4');
         if (jQuery('#delivery_cycle').val() == 'single') {
            jQuery('#not_single').hide();
            jQuery('#is_single').show();
         }
         else {
            jQuery('#not_single').show();
            jQuery('#is_single').hide();
         }
      }
      )
      .on('stephide','#s4', function() {
        return save_pd_cnt();
      })
      .on("wizardfinish", function(){
        mg_pc_deliverable();
      })   
       .jWizard(
       {counter: {
    			enable: true,
                type: "count"
                },
            cancel: function () {
                cancel_pressed = true;
                jQuery('#new_pc_form')[0].reset();
                jQuery("#dlv_code").removeAttr('readonly');                
                jQuery('#wait_for_save').html('');
                jQuery("label.error").hide();
                jQuery(".error").removeClass("error");
                jQuery("#wizard").jWizard("first");
                mg_pc_deliverable();
            }
       }   
   );
  
  jQuery('.jw-button-prev').click(function(){
    prev_pressed = true;
   });
 
  jQuery('.jw-button-next').click(function(){
    prev_pressed = false;
   });
   
 });
 
 function finish_step_3()
 {
     if (cancel_pressed)
        return true;
        
    if (prev_pressed)
        return true;
        
    var is_valid = true;
    jQuery('#cycle_form').validate();
    if (!  jQuery('#cycle_form').valid() )
    {
         is_valid = false;
    } 
    return is_valid;
 }
 
 function setup_step_2()
 {
      if (cancel_pressed)
        return true;
        
    if (prev_pressed)
        return true;
        
      var is_valid = true;
     jQuery(function ($) {
        
       
        if ( ! cancel_pressed)
        {
            $('#new_pc_form').validate(
                {
            		rules: {
            			dlv_code: {
            			    required: true, 
            				remote: {
            				    url: ajaxurl,
            				    data: {
                            		action: 'atx_check_dlv_code'                            		
                            	}
            				}
            			}
                    }
                    
        		}
            );
            if (!  $('#new_pc_form').valid() )
            {
                 is_valid = false;
            }
             
            
            
        }
        
           
            
     });
     
     return is_valid;
 }
 
 
 
 function setup_step_3()
 {
     if (cancel_pressed)
        return true;
        
    if (prev_pressed)
        return true;
        
     var is_valid = true;
     jQuery(function ($) {
        if (! cancel_pressed){
            $('#avail_form').validate();
            if (!  $('#avail_form').valid() )
            {
                 is_valid = false;
            }                          
             
        }           
            
     });
     
     return is_valid;
 }
 
 
 
 function save_pd_cnt() {
    
    var is_valid = true;
     if (cancel_pressed)
        return true;
        
    if (prev_pressed)
        return true;
        
    jQuery(function ($) {
        if (! cancel_pressed) {
            
                                     
            
          
            
            if (is_valid ) {
            // Ajax complete
            $('#wait_for_save').html('<center>...Please Wait...</center>');
                       
            $.ajax({
                  type: 'POST',
                  url: ajaxurl,
                  async: false, // Yes, the A is for Asyncronous... but the X is for XML.
                  dataType: 'json',
                  data: {
                    action: 'atx_create_pdcnt_delv',
                    name: $('#pc_dlv_name').val(),
                    description: $('#pc_dlv_desc').val(),
                    deliverable_code: $('#dlv_code').val(),
                    first_delivery: $('#first_delivery').val(),
                    delivery_cycle: $('#delivery_cycle').val(),
                    maximum_deliveries: $('#maximum_deliveries').val(),
                    start_time: $('#start_time').val(),
                    duration: $('#duration').val()
                  },
                  success: function(data){
                     $('#wait_for_save').html('');
                    if (data.deliverable_code) {
                        // Populate all the shortcode notes etc.
                         load_pc_help('s5');
                        var sc = build_short_code(data.deliverable_code)
                        $('#short_code_panel').html(sc);
                    }
                    else {
                        is_valid = false;
                        alert(data);
                    }
                    
                  }
                  
                });
            
               
            }
     
        }
        
    });
    return is_valid;
 }
 
 
 function aretex_assigns_code()
 {
     jQuery(function ($) {
        if ($('#let_aretx_assign').is(':checked')){
            $('#dlv_code').val('*');
            $("#dlv_code").attr('readonly','readonly');
        }
        else {
            $('#dlv_code').val('');
            $("#dlv_code").removeAttr('readonly');
        }
        
        
     });
 }
 
 function mg_pc_deliverable() {
  
    load_feature_screen('AreteX Paid Content','pdcnt_mgm');
}
 
function load_pc_help(screen_id) {
    load_feature_screen_div('AreteX Paid Content','help/'+screen_id,'#pc_help');
}

function build_short_code(deliv_id) {
    var pending = '[aretex_paid_content deliverable_code="'+deliv_id+'" status="Pending"] ---- YOUR CONTENT APPROPRIATE TO PENDING AUTHORIZATION --- [/aretex_paid_content]';
    var authorized = '[aretex_paid_content deliverable_code="'+deliv_id+'" status="Authorized"] ---- YOUR CONTENT APPROPRIATE FOR AUTHORIZED USERS --- [/aretex_paid_content]';
    var expired = '[aretex_paid_content deliverable_code="'+deliv_id+'" status="Expired"] ---- YOUR CONTENT APPROPRIATE FOR EXPIRED AUTHORIZATION --- [/aretex_paid_content]';
    var completed = '[aretex_paid_content deliverable_code="'+deliv_id+'" status="Completed"] ---- YOUR CONTENT APPROPRIATE FOR COMPLETED AUTHORIZATION RENEWALS --- [/aretex_paid_content]';
    
    var sc='';
    if (jQuery('#first_delivery').val() > 0) {
        sc += pending + '<br/>';
    }
    sc += authorized + '<br/>';
    if (jQuery('#duration').val() > 0) {
        sc += expired + '<br/>';
    }
    if (jQuery('#delivery_cycle').val() != 'single' && jQuery('#maximum_deliveries').val() > 0) {
        sc += completed;
    }

    return sc;
}
 
</script>

    
</div>

    </div> <!-- END Column -->
        <div class="col span_4_of_12"> <!-- Column -->
<div id="pc_help" class="ui-widget ui-widget-content  ui-corner-all container" >
<strong>New Paid Content Authorization</strong>
<p>As each screen changes ...</p>
</div>
    </div> <!-- END Column -->
</div> <!-- END ROW -->
