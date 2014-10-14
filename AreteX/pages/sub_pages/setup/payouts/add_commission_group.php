<div class="ui-widget-header ui-corner-top" >
<h2 style="text-align: center; margin-top: 5px; margin-bottom: 5px;">Setup Simple Commission Structure</h2>
</div>
<div class="ui-widget ui-widget-content  ui-corner-bottom" style="padding: 5px;" >
<button onclick="load_div_screen('setup/payouts/commission_structures','#payout_content');"  class="button">Back</button>
<hr />

    <div id="wizard" >
    <!-- steps will go here -->
    <div data-jwizard-title="Basics" id="s1">
       <div style="margin: 5px;">
       <label>Commission Structure</label>
       <p>
A Commission Structure is built from several components.  
These include commission rate, offer codes, and group identity.  
This wizard will walk you through the process of creating a basic Commission Structure.
          
       </p> 

       </div> 
    </div>
    
    
    
    <div data-jwizard-title="Set Commission" id="s2">
       <div style="margin: 5px;" >
         <label>Commission Rate</label>
                
               <form id="commission_rate_form" >
                    <div class="ui-widget">
                        <label  for="pct_comm">Enter Percent of Gross Sale to be Paid as Commisssion: </label>
                        <input type="text" class="required number" min="0.01" max="100" name="pct_comm"  style="width: 75px;" id="pct_comm" /> %                        
                    </div>
                </form>
                <p>(This wizard only creates a single tier commission rate. 
                 To make this struture part of a multi-tier commission structure, 
                edit this group after you complete the wizard.) </p>                            
       </div> 
    </div>
    
     <div data-jwizard-title="Name Payment" id="s3">
       <div style="margin: 5px;">
       <label>Determine Payment Type</label>
       <br /><br />
        <form id="payment_type_form">
                <label for="com_payment_type">Enter name of "Payment Type"</label>
                <input id="com_payment_type" required="required" type="text" name="com_payment_type" value="Commission"  /><br />
                Or select from one of these suggestions: <select onchange="change_pt_sel();" id="com_payment_type_sel">
                  <option value="Commission">Commission</option>
                  <option value="Referral Fee">Referral Fees</option>
                  <option value="Affiliate Payment">Affiliate Payment</option>
                  <option value="Revenue Share">Revenue Share</option>
                  <option value="Promotional Fees">Promotional Fees</option>
                  <option value="Share of Sale">Share of Sale</option>                    
                </select>
                <script>
                    function change_pt_sel() {
                         jQuery(function ($){
                            $('#com_payment_type').val($('#com_payment_type_sel').val())
                         });
                        
                    }
                </script>                               
               
                 
        </form>
         <hr />
             
       </div> 
    </div>
    
     <div data-jwizard-title="Available Offers" id="s4">
       <div style="margin: 5px;">
         <label>Set or limit the "Offers" this commission group can make.</label>
          
         <form id="offer_limits_form">       
         <hr />
         <input id="unlimited_offers" onclick="offer_unlimited();" name="unlimited_offers" type="checkbox" checked="checked" value="unlimited_offers" /> No Limit on offers
         <br />
         <select id="offer_limits" name="offer_limits[]" onclick="offer_limited();" multiple="multiple" size="6">
                
         <?php $offers = AreteX_WPI::getAllOffers();
            foreach($offers as $offer) {
                echo "<option class=\"offer_option\" value=\"{$offer->offer_code}\">({$offer->offer_code}) {$offer->offer_name}</option>";
            }

          ?>
          </select>
          <br />
           
          <em>(Hold the Control or Shift key down to select multiple)  </em>
          <script>
            function offer_limited(){
               jQuery('#unlimited_offers').attr('checked', false); 
            }
            
            function offer_unlimited(){
                if (jQuery('#unlimited_offers').is(':checked')) {
                    jQuery(".offer_option").removeAttr("selected");
                }
            }
          </script>
          </form>
       </div> 
    </div>
    
    
    <div data-jwizard-title="Group Identity" id="s5">
        <!-- step content -->
       
        <div style="margin: 5px;" >
            <form id="new_comm_group_form">
                <label for="comm_grp_name">Commission Group Name</label><input required="required"  id="comm_grp_name" name="comm_grp_name" placeholder="(i.e) Affiliates" value="" type="text" />
                <br />
The name of this group ought to be practical and helpful.
                <br /><br />
               
                 
                <label style="display: inline-block;">Commission Group Code</label><input id="comm_grp_code" name="comm_grp_code" size="25" style="width: 75px;" value="" required="required" type="text" /> 
                <input id="let_aretx_assign" type="checkbox" onclick="aretex_assigns_code();" /> <span style="display: inline-block;">Let AreteX&trade; Assign the Code</span>
                <br />              
                
                 
                <input type="hidden" id="description" name="description" value="" />
                 <p><br/>Click "Next" to save your work onto the AreteX database.</p>              
              
            </form>
        </div>
        <div id="wait_for_save"></div>

    </div>
     <div data-jwizard-title="Finish" id="s6">
      <div style="margin: 5px;">
            <p>Now that you have created a Commission Group, remember there is no one assigned 
            to this group yet. The "offers" associated with the commission group will not be 
            available.  See Help Panel for more information.
            </p>
             
            <p>To get a shortcode to allow people to sign up for this Commission Group visit:
            <em>Setup / Payouts / Commission Structures</em> and Edit (<strong>pencil icon</strong>) the Group. </p>
            
            <p>Click "Finish," you're done creating your commision group.</p>
    </div>
     </div>


</div>
<script>
jQuery('#commission_group_info').load('<?php echo plugins_url('add_cg_wiz_help/s1.html',__FILE__); ?>');        

var cancel_pressed;
var prev_pressed = false;

jQuery(document).ready(function() {
   // put all your jQuery goodness in here.
   jQuery("#wizard")
       .on("stepshow", "#s1", function () {
         jQuery('#commission_group_info').load('<?php echo plugins_url('add_cg_wiz_help/s1.html',__FILE__); ?>');        
         cancel_pressed = false;
         return true;
      })
      .on("stepshow", "#s2", function () {
        jQuery('#commission_group_info').load('<?php echo plugins_url('add_cg_wiz_help/s2.html',__FILE__); ?>'); 
         return true;
      })         
       .on("stephide", "#s2", function () {
         return finish_step_2();
      })
      .on("stepshow", "#s3", function () {  
        jQuery('#commission_group_info').load('<?php echo plugins_url('add_cg_wiz_help/s3.html',__FILE__); ?>'); 
         return finish_step_3();
      })
      .on("stephide", "#s3", function () {         
         return finish_step_3();
      })
       .on("stepshow", "#s4", function () { 
        jQuery('#commission_group_info').load('<?php echo plugins_url('add_cg_wiz_help/s4.html',__FILE__); ?>');                 
      }) 
      .on("stephide", "#s4", function () {         
         return finish_step_4();
      })
      .on("stepshow", "#s5", function () { 
        jQuery('#commission_group_info').load('<?php echo plugins_url('add_cg_wiz_help/s5.html',__FILE__); ?>');                  
      })
       .on("stephide", "#s5", function () {         
         return finish_step_5();
      })
       .on("stepshow", "#s6", function () { 
        jQuery('#commission_group_info').load('<?php echo plugins_url('add_cg_wiz_help/s6.html',__FILE__); ?>');                 
      })   
       .jWizard(
       {counter: {
    			enable: true,
                type: "count"
                },
            finish: function() {
                load_div_screen('setup/payouts/commission_structures','#payout_content');
                            
            },                 
            cancel: function () {
                cancel_pressed = true;
               // reset_to_defaults();               
               load_div_screen('setup/payouts/commission_structures','#payout_content');                
                jQuery("#wizard").jWizard("first");
            }
       }   
   );
  
   

 
   
 });
 
  jQuery('.jw-button-prev').click(function(){
    prev_pressed = true;
   });
 
  jQuery('.jw-button-next').click(function(){
    prev_pressed = false;
   });
 
 function reset_to_defaults() {
    jQuery(function ($) {
        
        cancel_pressed = true;
        jQuery('#commission_rate_form')[0].reset();
        jQuery('#payment_type_form')[0].reset();
        jQuery('#new_comm_group_form')[0].reset();
        jQuery('#offer_limits_form')[0].reset();
        jQuery('label.error').remove();
        jQuery('.error').removeClass('error');
        
      
    });
 }
 
 function jumpto_end() {
     reset_to_defaults();
     jQuery("#wizard").jWizard("step",5);
 }
 
 
 
 function finish_step_2()
 {
            
    if (prev_pressed)
        return true;
        
   
     if ( cancel_pressed)
        return true;
     var is_valid = true;
     jQuery(function ($) {
        $('#commission_rate_form').validate();
        is_valid = $('#commission_rate_form').valid();
           
            
     });
     
     return is_valid;
 }
 

 

 
 function finish_step_3() {
    
            
    if (prev_pressed)
        return true;
        
        
    if ( cancel_pressed)
        return true;    
    var is_valid = true;
    jQuery(function ($) {
       $('#payment_type_form').validate();
       is_valid = $('#payment_type_form').valid(); 
      
       
    });
    return is_valid;
 }
 
 function finish_step_4() {
    return true;
 }
 
 
 function gather_form_data() {
    var commission_rate = jQuery('#commission_rate_form').serialize();
    var payment_type = jQuery('#payment_type_form').serialize();
    var comm_group_id = jQuery('#new_comm_group_form').serialize();
    var offer_limits  = jQuery('#offer_limits_form').serialize();
    
    var form_data = {
        commission_rate: commission_rate,
        payment_type: payment_type,
        comm_group_id: comm_group_id,
        offer_limits: offer_limits
    }
    
    return form_data;
 }
 
 
 
 function finish_step_5() {
    
        
    if (prev_pressed)
        return true;
        
       
    if ( cancel_pressed)
        return true;
    
       
    var is_valid = true;
    jQuery(function ($) {
        $('#new_comm_group_form').validate(
                {
            		rules: {
            			comm_grp_code: {
            			    required: true, 
            				remote: {
            				    url: ajaxurl,
            				    data: {
                            		action: 'atx_check_comm_group_code'                            		
                            	}
            				}
            			},
                        comm_grp_name : {
                            required: true
                        }
                    }
                    
        		}
            );
            if (!  $('#new_comm_group_form').valid() ) {
                 is_valid = false;
            }
            
            if (is_valid) {
               data = gather_form_data(); 
                $('#wait_for_save').html('...Saving ....');
        
                            
   
            $.ajax({
              type: 'POST',
              url: ajaxurl,
              async: false, 
              dataType: 'json',
              data: {
                action: 'atx_new_commision_structure',
                data: data
              },
              success: function(data){
                 $('#wait_for_save').html('');
                if (data.code) {   
                    is_valid = true;                    
                    alert('Saved');
                }
                else {
                    is_valid = false;
                    alert(data);
                }
                
              }
              
            });
        }
          
       
    });
    return is_valid;
 }
 

 function aretex_assigns_code()
 {
     jQuery(function ($) {
        if ($('#let_aretx_assign').is(':checked')){
            $('#comm_grp_code').val('*');
            $("#comm_grp_code").attr('readonly','readonly');
        }
        else {
            $('#comm_grp_code').val('');
            $("#comm_grp_code").removeAttr('readonly');
        }
        
        
     });
 }
 

</script>

    
</div>