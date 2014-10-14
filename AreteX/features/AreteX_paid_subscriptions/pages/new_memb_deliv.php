<div class="section group"> <!-- ROW -->
    <div class="col span_8_of_12"> <!-- Column -->

<div class="ui-widget-header ui-corner-top" >
<h2 style="text-align: center; margin-top: 5px; margin-bottom: 5px;">Setup a New Membership Deliverable</h2>
</div>
<div class="ui-widget ui-widget-content  ui-corner-bottom" style="padding: 5px;" >
     <a href="javascript:void(0);" id="pcmgm_btn"  onclick="mg_mem_deliverable();"
class="ui-button  icon_left_button button_link  ui-state-default ui-corner-all"  >
<span class="ui-icon  ui-icon-circle-arrow-w"></span> 
Back</a>
    <hr />   
    <div id="wizard">
    <!-- steps will go here -->

    <div data-jwizard-title="Identity" id="s1">
        <!-- step content -->

        <div style="margin: 5px;" id="new_mem_deliverable">
            <form id="new_pc_form">
                <label for="pc_dlv_name">Enter the Membership Name</label><input required="required"  id="pc_dlv_name" name="pc_dlv_name" type="text" />
                <br />               
                <label for="pc_dlv_desc">Describe the Membership</label><textarea   id="pc_dlv_desc" name="pc_dlv_desc" ></textarea>               
                <p>The description will be available in reports and shortcodes. It is optional.   </p>
 
                 
                <label style="display: inline-block;">Deliverable Code</label><input required="required"   id="dlv_code" name="dlv_code" size="25" style="width: 55px;" type="text" />
                <br />
                <input id="let_aretx_assign" type="checkbox" onclick="aretex_assigns_code();" /> <span style="display: inline-block;">Let AreteX&trade; Assign the Deliverable Code</span>
                <p>This is a unqiue short identifier used to refer to this deliverable. You will need it for manifests.  </p>
            </form>
        </div>
        
    </div>
    <div data-jwizard-title="Roles" id="s2">
    <div style="margin: 5px;" id="member_reg">    
            <form id="role_form">
                <label for="role_type">Registration or Role Only? </label><select required="required"  id="role_type" name="role_type" >
                    <option value="reg_role">Register with Role</option>                   
                    <option value="role_only">Role Only</option>
                </select> <br />
                <label for="role_delivered">Select Delivered Role</label>
                <select required="required"  id="role_delivered" name="role_delivered" >
                <?  global $wp_roles;
                    $default_role = get_option('default_role');
                    if (is_array($wp_roles->roles)) {
                        $hidden_roles = get_option('aretex_pdsub_hidden_roles',array());
                        foreach ($wp_roles->roles as $key=>$role) {
                            if (in_array($key,$hidden_roles))
                                continue;
                            $sel = '';
                            $name = $role['name'];
                            if ($key == $default_role) {
                                 $sel = 'selected="selected"';
                                 $name .= ' - Default';
                            }
                               
                            echo "<option value=\"$key\" $sel>$name</option>\n";
                        }
                        
                    }
                     
                
                ?>
                </select>
                 
                 <div class="ui-widget">
                <label for="role_at_expiration">Role at Expiration: </label> <select required="required"  id="role_at_expiration" name="role_at_expiration" >
                <option value="none">None - User is "Locked Out"</option>
                <?  global $wp_roles;
                    $default_role = get_option('default_role');
                    $hidden_roles = get_option('aretex_pdsub_hidden_roles',array());
                    if (is_array($wp_roles->roles)) {
                        foreach ($wp_roles->roles as $key=>$role) {
                            if (in_array($key,$hidden_roles))
                                continue;
                            $sel = '';
                            $name = $role['name'];
                            if ($key == $default_role) {
                                 $sel = 'selected="selected"';
                                 $name .= ' - Default';
                            }
                               
                            echo "<option value=\"$key\" $sel>$name</option>\n";
                        }
                        
                    }
                     
                
                ?>
                </select>
                </div>
                              
             </form>
             
        </div>
    
    </div>
    <div data-jwizard-title="Availablity" id="s3">
        <div style="margin: 5px;" >             
             <form id="avail_form">
                <div class="ui-widget">
                    <label for="start_time">Start Date/Time:</label>
                    <p><input type="text" class="" size="25" style="width: 100px; display: inline-block;" type="text"  name="start_time"  id="start_time"  value="" />
                    This is the start date and time of authorization for access. (YYYY-MM-DD HH:MM) Leave blank for "upon payment." </p>
                    <label for="first_delivery">Number of Days to Wait: </label>
                    <p><input type="text" class="required digits" size="25" style="width: 55px; display: inline-block;" type="text"  name="first_delivery"  id="first_delivery"  value="0" />
                    If you have a number of days you wish to wait before authorization is allowed, enter them here.  This can be used in conjunction with the Start Date/Time, especially with subscriptions. </p>
                </div>


                
             </form>   
                
        </div>
            
         
    </div>
    <div  data-jwizard-title="Re-Authorization " id="s4">
         <div style="margin: 5px;" > 
                    <div class="ui-widget">
                    <label for="duration">Days of Auhtorized Availablity: </label>
                    <p><input type="text" class="digits" size="25" style="width: 55px; display: inline-block;" type="text" value=""  name="duration"  id="duration"   />
                    Unless re-authorized, access to the delivered role will expire after this many days. Leave blank for "Does not expire".                    
                </div>
            
            <form id="cycle_form">
                <div class="ui-widget">
                    <label for="delivery_cycle">Re-Authorization Cycle: </label>
                     <p><select id="delivery_cycle" name="delivery_cycle" onchange="change_reauth()" style="display: inline-block;">
                    <option selected="selected" value="single">Single</option>
                    <optgroup>Recurring</optgroup>
                    <option value="daily">Daily</option>
                    <option value="weekly">Weekly</option>
                    <option value="monthly" >Monthly</option>
                    <option value="quarterly">Quarterly</option>
                    <option value="yearly">Yearly</option>
                    </select>
                This is the frequency you wish AreteX to check the validity of your customer's authorization.  (Total number of checks may be entered on the next screen.)  If payment has been cancelled or has failed, access to content will expire based on "Days of Availability" above.

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
    <div  data-jwizard-title="Total Number" id="s5">
         <div style="margin: 5px;" >
           <div id="not_single">
            <form id="cycle_form2">
                <div class="ui-widget">
                    <label for="maximum_deliveries">Total Number of Re-Authorizations: </label>
                    <p><input type="text" class="digits" size="25" style="width: 55px; display: inline-block;" type="text" value=""  name="maximum_deliveries"  id="maximum_deliveries"  />
                    
This is the total number of Re-Authorizations AreteX&trade; will perform in the Cycle you have chosen.  (A Weekly Cycle with a Total Number of Re-Authorization checks of 3 would give you a check every week for three weeks.)  Leave blank for "until cancelled".
                    
                </div>
            </form>
            </div>
            <div id="is_single">
            <p>You have chosen single authorization without renewal. There will be no renewal cycles.</p>
            </div>
            </div>
            <p>When you select <em>Next</em>, your Deliverable Code will be created on the AreteX server.</p>
      <div id="wait_for_save"></div>    
    </div>
    
    <div data-jwizard-title="Deliverable Code" id="s6">
        <!-- step content -->
        
        <p>This is the deliverable code for this Paid Membership Deliverable: <span id="deliverable_code_span" style="font-weight: bold;" ></span></p>
        <p>Do not use this Deliverable Code in shortcodes.</p>
        
    </div>
</div>
<script>

var cancel_pressed;
var prev_pressed;

function load_mem_help(screen_id) {
    load_feature_screen_div('AreteX Subscriptions and Memberships','help/'+screen_id,'#pm_help');
}

jQuery(document).ready(function() {
   // put all your jQuery goodness in here.
   jQuery("#wizard")
       .on("stepshow", "#s1", function () {
        load_mem_help('s1');
         cancel_pressed = false;
         return true;
      })
       .on("stephide", "#s1", function () {
       
         return setup_step_2();
        return true;
      })
      .on("stepshow", "#s2", function () {         
          load_mem_help('s2');
       return true;
      })
       .on("stepshow", "#s3", function () {         
         return setup_step_3();
       return true;
      })
      .on("stephide", "#s3", function () {         
         return finish_step_3();
       return true;
      })
      .on('stepshow','#s4',function () {         
       load_mem_help('s4');
       return true;
      })
      .on('stephide','#s4',function (){
        if (jQuery('#delivery_cycle').val() == 'single') {
            jQuery('#not_single').hide();
            jQuery('#is_single').show();
         }
         else {
            jQuery('#not_single').show();
            jQuery('#is_single').hide();
         }
      })
      .on('stepshow','#s5',function () {         
       load_mem_help('s5');
       return true;
      })
      .on('stephide','#s5',function () {         
       return save_mem_delv();
       
      })
       .on('stepshow','#s6',function () {         
       load_mem_help('s6');
       return true;
      })
      .on("wizardfinish", function(){
        mg_mem_deliverable();
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
                mg_mem_deliverable();
            }
       }   
   );
  
  load_mem_help('s1');
  
  jQuery('.jw-button-prev').click(function(){
    prev_pressed = true;
   });
 
  jQuery('.jw-button-next').click(function(){
    prev_pressed = false;
   });
  
   
 });
 
 function setup_step_2()
 {
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
    load_mem_help('s3');
    return true;
 }
 
 function finish_step_3() {
    if (cancel_pressed)
        return true;
    if (prev_pressed)
        return true;
    jQuery('#avail_form').validate();
    if (! jQuery('#avail_form').valid()) {
        return false;
    }
    
    
 }
 
 function save_mem_delv() {
     if (cancel_pressed)
        return true;
    if (prev_pressed)
        return true;
    
    var is_valid = true;
    
    jQuery(function ($) {
        if (! cancel_pressed) {
            
            /*
            // No way to setup invalid ... 
            $('#cycle_form').validate();
            if (!  $('#cycle_form').valid() )
            {
                 is_valid = false;
            }                          
            */
          
            
            if (is_valid ) {
            // Ajax complete
            $('#wait_for_save').html('<center>...Please Wait...</center>');
                       
            $.ajax({
                  type: 'POST',
                  url: ajaxurl,
                  async: false, // Yes, the A is for Asyncronous... but the X is for XML.
                  dataType: 'json',
                  data: {
                    action: 'atx_create_mem_delv',
                    name: $('#pc_dlv_name').val(),                   
                    description: $('#pc_dlv_desc').val(),
                    deliverable_code: $('#dlv_code').val(),
                    role_type: $('#role_type').val(),
                    role_delivered: $('#role_delivered').val(),
                    first_delivery: $('#first_delivery').val(),
                    delivery_cycle: $('#delivery_cycle').val(),
                    maximum_deliveries: $('#maximum_deliveries').val(),
                    start_time: $('#start_time').val(),
                    duration: $('#duration').val(),
                    role_at_expiration: $('#role_at_expiration').val()
                  },
                  success: function(data){
                     $('#wait_for_save').html('');
                    if (data.deliverable_code) {
                        // Populate all the short code notes etc.
                        $('#deliverable_code_span').html(data.deliverable_code);
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
 
  function mg_mem_deliverable() {
  
    load_feature_screen('AreteX Subscriptions and Memberships','mem_mgm');
}
 
</script>

    
</div>
    </div> <!-- END Column -->
        <div class="col span_4_of_12"> <!-- Column -->
<div id="pm_help" class="ui-widget ui-widget-content  ui-corner-all container" >

</div>
    </div> <!-- END Column -->
</div> <!-- END ROW -->