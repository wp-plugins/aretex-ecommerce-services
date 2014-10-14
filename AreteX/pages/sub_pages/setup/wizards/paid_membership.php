<div class="section group"> <!-- ROW -->
    <div class="col span_8_of_12"> <!-- Column -->
   
<div class="ui-widget-header ui-corner-top" >
<h2 style="text-align: center; margin-top: 5px; margin-bottom: 5px;">New Paid Membership Wizard</h2>
</div>
<div class="ui-widget ui-widget-content  ui-corner-bottom" style="padding: 5px;" >

    
    <div id="wizard">
    <!-- steps will go here -->

    <div data-jwizard-title="Identity" id="s1">
        <!-- step content -->

        <div style="margin: 5px;" id="pd_content_id">
            <form id="new_mem_form">
                <label for="pc_dlv_name">Membership Name</label><input  id="pc_dlv_name" name="pc_dlv_name" type="text" />
                <br />               
                <label for="pc_dlv_desc">Describe the Membership</label><textarea  id="pc_dlv_desc" name="pc_dlv_desc" ></textarea>               
                 
                <label style="display: inline-block;">Product/Deliverable Code</label><input   id="dlv_code" name="dlv_code" size="25" style="width: 55px;" type="text" />
                <br />
                <input id="let_aretx_assign" type="checkbox" onclick="aretex_assigns_code();" /> <span style="display: inline-block;">Let AreteX&trade; Assign the Code</span>
            </form>
        </div>

    </div>
    <div data-jwizard-title="Roles" id="s1a">
    <div style="margin: 5px;" id="member_reg">    
            <form id="reg_role_form">
                <label for="role_type">Select Product Type</label><select required="required" onchange="toggle_free_question()" id="role_type" name="role_type" >
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
                <div id="allow_free">
                <label for="allow_free_reg">Allow Free Registration</label>
                <select id="allow_free_reg">
                    <option>Yes</option>
                    <option>No</option>
                </select>
                </div>                
                <p>If you chooose "Register with Role" the selected role is assigned  when authorization (usually payment) has been confirmed. With "Role Only" a member who is already registered may pay to have his or her role changed (usually an upgrade). </p>
                <script>
                function toggle_free_question() {
                    var rt = jQuery('#role_type').val();
                    if (rt == 'reg_role') {
                        jQuery('#allow_free').show();
                    }
                    else
                       jQuery('#allow_free').hide(); 
                }
                </script>              
             </form>
             
        </div>
    
    </div>
    
    <div data-jwizard-title="Pricing Model" id="s2">
        <div class=" dbui-frame" style="margin: 5px;" >

                <select style="height: 26px;"  name="data[pricing_model]" id="pricing_model" onchange="change_pricing_model();">                    
                    <option value="single_price">Single Price</option>
                    <option value="recurring_billing">Recurring Billing</option>
                    <option value="donation">Donation</option>
                </select>
                <br/>

            
         </div>
    </div>
    <div data-jwizard-title="Price Detail" id="s3">
    
                <form id="single_price_form">
                <div id="single_price_panel"  class="dbui-frame" style="margin: 10px;" >
                <label for="single_price">Price</label>
                <input type="text" id="single_price" class="required number" min="0.01" style="width: 90px;" name="data[price]"  /> 
                </div>
                </form>
                
                <div id="donation_panel"  style="margin: 10px;" >
                The donor will be able to enter any amount they wish ($1.00 and up) into the credit card form. 
                </div>
                
                <div id="rebill_panel_detail" class="dbui-frame" style="margin: 3px;" >
                <form id="rebill_detail_form">
                <div class="section group"> <!-- ROW -->
                    <div class="col span_2_of_3"> <!-- Column -->
                        <label>Immediate Payment</label>                        
                    </div> <!-- END Column --> 
                    <div class="col span_1_of_3"> <!-- Column -->
                        <input name="data[rebill_data][trial_price]" id="trial_price" class="number" value="0.00" class="number" type="text" style="width: 60px;" />
                    </div> <!-- END Column -->                           
                </div> <!-- END ROW -->
                 <div class="section group"> <!-- ROW -->     
                    <div class="col span_2_of_3"> <!-- Column -->
                        <label>Days Until Billing Starts</label>
                    </div> <!-- END Column -->
                     <div class="col span_1_of_3"> <!-- Column -->        
                        <input name="data[rebill_data][trial_period]" id="trial_period" value="30" min="1" class="digits required" type="text" style="width: 60px;" />    
                    </div> <!-- END Column -->                           
                  </div> <!-- END ROW -->
                  <div class="section group"> <!-- ROW -->        
                    <div class="col span_2_of_3"> <!-- Column -->
                        <label>Billing Cycle</label>   
                    </div> <!-- END Column -->
                    <div class="col span_1_of_3"> <!-- Column -->        
                        <select id="billing_cycle" name="data[rebill_data][billing_cycle]">
                           <option value='monthly'>Monthly</option>
                           <option value='weekly'>Weekly</option>
                           <option value='daily'>Daily</option>
                           <option value='yearly'>Yearly</option>
                        </select>                
                    </div> <!-- END Column -->  
                  </div> <!-- END ROW -->
                  <div class="section group"> <!-- ROW -->        
                    <div class="col span_2_of_3"> <!-- Column -->
                        <label>$ Billed per Cycle</label>    
                    </div> <!-- END Column -->
                    <div class="col span_1_of_3"> <!-- Column -->        
                        <input name="data[rebill_data][recurring_price]" min="0.01" value="" id="recurring_price" class="required number" type="text" style="width: 60px;" />    
                    </div> <!-- END Column -->  
                   </div> <!-- END ROW -->
                  
                   <div class="section group"> <!-- ROW -->
                    <div class="col span_2_of_3"> <!-- Column -->
                        <label>Total # of Payments</label>    
                    </div> <!-- END Column -->
                    <div class="col span_1_of_3"> <!-- Column -->       
                        <input id="max_billing_cycles" name="data[rebill_data][max_billing_cycles]" value="" type="text" class="number" style="width: 60px;" /> 
                    </div> <!-- END Column -->     
                     </div> <!-- END ROW -->      
                    </form>   
                </div> 



            
    
    
    </div>
    <div data-jwizard-title="Availablity" id="s4">
        <div style="margin: 5px;" >
        <div id="wait_for_save"></div>             
             <form id="avail_form">
                
                <div id="deliver_single">
                    <div class="ui-widget">
                        <label for="duration">Days of Availablity: </label>
                        <p><input type="text" class="digits" size="25" style="width: 55px; display: inline-block;" type="text" value=""  name="duration"  id="duration"  value="0" />
                        Unless renewed, access to this role will expire after this many days. Leave blank for "Does not expire".</p>
                        
                    </div>                    
                </div>
                <div id="deliver_on_rebill">
                    <div class="ui-widget">
                     Authorization for availablity will be renewed <span id="dlv_frequency"></span> as long as automatic payment is current.    
                    </div>                    
                </div>
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
                <p>
                Note: Choosing "Next" will save your information to the AreteX&trade; database.  You may view this saved information by going to <em>Catalog and Products / Products / Edit (pencil icon)</em> .
                </p>
        </div>
            
         
    </div>

    <div data-jwizard-title="Shortcode" id="s5">
        <!-- step content -->
        <div id="short_code_panel" style="margin: 5px;" >
<textarea id="short_code_text" style="font-family: 'Courier New', Courier, monospace; font-size: 12px;"  
rows="8" spellcheck="false"> 
[aretex_paid_content deliverable_code="APCT1" status="!LoggedIn"]

You must be logged in to view or buy this ...

[/aretex_paid_content]

[aretex_paid_content deliverable_code="APCT1" status="!Authorized"]

To buy this content just click the button below..

[atx_buynow code="APC1"]<button>Buy Now</button>[/atx_buynow]

[/aretex_paid_content]

[aretex_paid_content deliverable_code="APCT1"]

--- REPLACE THIS WITH ACTUAL CONTENT ---

[/aretex_paid_content]
        
        </textarea>
        <p>For this browser session only, you may use the <em>AreteX</em> button in the <strong>WordPress Page Editor</strong> to paste these shortcodes into your content. You may also copy and paste this onto your page (<em>in <strong>Text Mode</strong></em>) and replace the note with actual content. </p>
       
        </div>
        
    </div>
</div>
<script>

var cancel_pressed;
var prev_pressed;

jQuery(document).ready(function() {
   load_wiz_help('mh1');
   
   jQuery("#wizard")
       .on("stepshow", "#s1", function () {
         load_wiz_help('mh1');
         cancel_pressed = false;
         return true;
      })
      .on("stepshow", "#s1a", function () {
         load_wiz_help('mh1a');        
         return true;
      })
      .on('stepshow','#s2',function () {
         load_wiz_help('pch2');         
         return true;
      })
      .on('stepshow','#s3',function () {
         load_wiz_help('pch3');         
         return true;
      })
      .on('stepshow','#s4',function () {
         
         load_wiz_help('mh4');         
         return true;
      })
      .on('stepshow','#s5',function () {
         load_wiz_help('mh5');         
         return true;
      })
      .on('stepshow','#s6',function () {
         load_wiz_help('pch6');         
         return true;
      })
       .on("stephide", "#s1", function () {
         return setup_step_2();
      })
       .on("stephide", "#s2", function () {         
         return setup_step_3();
      })
      .on("stephide", "#s3", function () {         
         
         return setup_step_4();
      })
      .on("stephide", "#s4", function () {         
         
         save_pd_content();
         return true;
      }) 
      .on("wizardfinish", function(){
        load_content_screen('setup/wizards');
      })  
       .jWizard(
       {counter: {
    			enable: true,
                type: "count"
                },
            cancel: function () {
                cancel_pressed = true;
                jQuery('#new_mem_form')[0].reset();
                jQuery('#single_price_form')[0].reset();
                jQuery('#rebill_detail_form')[0].reset();
                jQuery("#dlv_code").removeAttr('readonly');
                jQuery('#wait_for_save').html('');
                jQuery("label.error").hide();
                jQuery(".error").removeClass("error");
                jQuery("#wizard").jWizard("first");
            }
       }   
   );
  
  jQuery('#other_price_panel').hide();
   
 });
 
 jQuery('.jw-button-prev').click(function(){
    prev_pressed = true;
   });
 
  jQuery('.jw-button-next').click(function(){
    prev_pressed = false;
   });
 
 function setup_step_2()
 {
    if (cancel_pressed)
        return true;
        
    if (prev_pressed)
        return true;
        
    // console.log("Starting Validate");

     jQuery('#new_mem_form').validate({
        rules: {
            pc_dlv_name : {
               required: true, 
            },
            pc_dlv_desc: {
                maxlength: 255 
            },
        	dlv_code: {
        	    required: true, 
        		remote: {
        		    url: ajaxurl,
        		    data: {
                		action: 'atx_check_wiz_code'                            		
                	}
        		}
        	}
        }
        
    });
     if ( jQuery('#new_mem_form').valid()) {
        return true;
     }                  
        
    return false;
 }
 
 
 
 function setup_step_4() {

    if (cancel_pressed)
        return true;
        
    if (prev_pressed)
        return true;
        
    var pm = jQuery('#pricing_model').val();
     
    if (pm == 'recurring_billing') {
        
          
            
            jQuery('#rebill_detail_form').validate();
            if (! jQuery('#rebill_detail_form').valid())
                return false;
            jQuery('#deliver_single').hide();
            jQuery('#deliver_on_rebill').show();
            var billing_cycle = jQuery('#billing_cycle').val();
            jQuery('#dlv_frequency').html(billing_cycle);
    }
    else {
          
         if (pm == 'single_price') {
            jQuery('#single_price_form').validate();
            if (! jQuery('#single_price_form').valid()) {
                return false;
            }
         }
         jQuery('#deliver_single').show();
         jQuery('#deliver_on_rebill').hide();    
    }                  
    
    return true;
 }
 
 function setup_step_3()
 {
     change_pricing_model();
    
     return true;
 }
 
 function save_pd_content() {
    
    if (cancel_pressed)
        return true;
   
   if (prev_pressed)
        return true;
    jQuery(function ($) {
        
           
            

            // Ajax complete
            $('#wait_for_save').html('<center>...Please Wait...</center>');
            var prod_name = $('#pc_dlv_name').val();
            var prod_code =  $('#dlv_code').val();
            var pricing_model = $('#pricing_model').val();
            var delivery_cycle;
            if (pricing_model == 'single_price') {
                var price = $('#single_price').val();
                delivery_cycle = 'single';
                var duration = $('#duration').val();
            }
            else {
                var price = $('#rebill_detail_form').serialize();
                delivery_cycle = $('#billing_cycle').val();
                switch (delivery_cycle) {
                    case 'monthly':
                        duration = 31;
                        break;
                    case 'weekly':
                        duration = 7;
                        break;
                    case 'daily':
                        duration = 1;
                        break;
                    case 'yearly':
                        duration = 365;
                        break;
                }
            }
                
            var product_data = {
                name: prod_name,
                code: prod_code,
                pricing_model: pricing_model,
                price: price
            };
            
            
                                    
            
             var deliverable_data = {                    
                    name: prod_name,                   
                    description: $('#pc_dlv_desc').val(),                    
                    role_type: $('#role_type').val(),
                    role_delivered: $('#role_delivered').val(),
                    first_delivery: 0,
                    delivery_cycle: delivery_cycle,
                    maximum_deliveries: $('#max_billing_cycles').val(),
                    duration: duration,
                    role_at_expiration: $('#role_at_expiration').val()
                  };
            
            
            $.ajax({
                  type: 'POST',
                  url: ajaxurl,
                  async: false, // Yes, the A is for Asyncronous... but the X is for XML.
                  dataType: 'json',
                  data: {
                    action: 'atx_create_full_paid_mem_prod',
                    product: product_data,
                    deliverable: deliverable_data,
                    allow_free_reg: $('#allow_free_reg').val()
                    
                  },
                  success: function(data){
                    
                     $('#short_code_text').val(data);
                     $('#wait_for_save').html('');
                    
                    
                  },
                  error: function(xhr, type, exception) {                     
                    alert("ajax error "+exception);
                    $('#wait_for_save').html('');
                  }
                  
                });
            
               

     

        
    });
    
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
 




function change_pricing_model(){
    var pm = jQuery('#pricing_model').val();

    
    if (pm == 'single_price'){
        jQuery('#single_price_panel').show();             
    }
    else {
         jQuery('#single_price_panel').hide();
    }
    
    
    if (pm == 'recurring_billing') {       
        jQuery('#rebill_panel').show();
        jQuery('#rebill_panel_detail').show();        
    }
    else {
        jQuery('#rebill_panel').hide();
        jQuery('#rebill_panel_detail').hide();
    }
    
    if (pm == 'donation'){                
        jQuery('#donation_panel').show();
    }
    else {
        jQuery('#donation_panel').hide();
    }
    
    set_validation_requirements(pm);   
}

function set_validation_requirements(pm) {
    if (pm == 'single_price') {
        jQuery('#single_price').addClass('required');
    }
    else {
       jQuery('#single_price').removeClass('required'); 
    }
    
    if (pm == 'recurring_billing') {
       jQuery('#recurring_price').addClass('required');
       jQuery('#billing_cycle').addClass('required'); 
    }
    else {
        jQuery('#recurring_price').removeClass('required'); 
        jQuery('#billing_cycle').removeClass('required'); 
    }
        
    
}

function load_wiz_help(screen)
{
    load_div_screen('setup/wizards/help/'+screen,'#wizard_help_div');
}

</script>


    
</div>

 </div> <!-- END Column -->
     <div class="col span_4_of_12"> <!-- Column -->

        <div id="wizard_help_div" class="ui-widget ui-widget-content  ui-corner-all container" >
        <p>Content</p>
        </div>
    </div> <!-- END Column -->
</div> <!-- END ROW -->