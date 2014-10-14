<div class="ui-widget-header ui-corner-top" >
<h2 style="text-align: center; margin-top: 5px; margin-bottom: 5px;">Setup Simple Commission Structure</h2>
</div>
<div class="ui-widget ui-widget-content  ui-corner-bottom" style="padding: 5px;" >
<button onclick="load_screen('pay_people_wizards');"  class="button">Back</button>
<hr />

    <div id="wizard">
    <!-- steps will go here -->
    <div data-jwizard-title="Basics" id="s1">
       <div style="margin: 5px;">
       <label>Commission Groups</label>
       <p>In AreteX&trade;, <strong>Commission Groups</strong> are how you group referrers (i.e. sales reps, 
       affiliates, etc.) to receive commissions and may limit which tracking codes are available
       for those groups to use.  Thus, a referrer's Commission Group membership determines: 
       
            <br /><strong>Commission Amounts</strong> - How much money a referrer receives from a sale.
            <br/><strong>Available Offer Codes</strong> - The Offer Codes available to specific Commission Groups.
            <br /><br />
               
       </p> 

       </div> 
    </div>
    
    
    
    <div data-jwizard-title="Set Commission" id="s2">
       <div style="margin: 5px;">
         <label>Setting the Commission Rate</label>
                
               <form id="commission_rate_form">
                    <div class="ui-widget">
                        <label  for="pct_off">Enter Percent of Gross Sale to be Paid as Commisssion: </label>
                        <input type="text" class="required number" min="0.01" max="100"   style="width: 75px;" id="pct_off" /> %                        
                    </div>
                </form>
                <p>This commisssion will be applied to the entire purchase (not including tax and shipping) at the time of payment.
                Every member of this commission Group will receive this commmision rate when their tracking code is used in a sale.</p>
                <hr />
                <blockquote style="font-size: 11px;"><em>Note:</em> While AreteX&trade; supports Multi-Tier Commission Structures, this wizard only deals with single tiers.
                  For more information on Multi-Tier Commissions, click here. )</blockquote>
             
       </div> 
    </div>
    
     <div data-jwizard-title="Name Payment" id="s3">
       <div style="margin: 5px;">
       <label>Setting the Payment Type Name</label>
        <form id="payment_type_form">
                <label for="com_payment_type">Enter "Payment Type" Name</label>
                <input id="com_payment_type" type="text" name="com_payment_type" value="Commission"  /><br />
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
                <p>This "Payment Type" name will appear on the payment reports so the payee can see what they are being paid for.
                It should accurately reflect why they are receiving money as the result of a compelted sale. 
                 </p>
                 
        </form>
         <hr />
             
       </div> 
    </div>
    
     <div data-jwizard-title="Available Offers" id="s4">
       <div style="margin: 5px;">
         <label>Limit Offers Group Can Make</label>
         List current offers, have "Unlimited" offers pre-selected.
                
         <hr />
             
       </div> 
    </div>
    
    
    <div data-jwizard-title="Group Identity" id="s5">
        <!-- step content -->
       
        <div style="margin: 5px;" id="offer_id">
            <form id="new_comm_group_form">
                <label for="comm_grp_name">Set Commission Group Name</label><input required="required"  id="comm_grp_name" name="comm_grp_name" value="Normal Affiliates" type="text" />
                <br />The name of this group will be available in WordPress "short codes".
                <br /><br />
               
                 
                <label style="display: inline-block;">Set Commission Group Code</label><input id="comm_grp_code" name="comm_grp_code" size="25" style="width: 75px;" value="AFF" type="text" /> 
                <input id="let_aretx_assign" type="checkbox" onclick="aretex_assigns_code();" /> <span style="display: inline-block;">Let AreteX&trade; Assign the Commision Group Code</span>              
                <p>This is a unqiue short identifier used to refer to this Commission Group in WordPress "short codes". You may change this if you wish.  </p>
            </form>
        </div>
       
    </div>
     <div data-jwizard-title="Next Steps" id="s5">
      <div style="margin: 5px;">
            <p>Other Wizards:
            <ul>
            <li>Assign Referrers to Groups</li>
            <li>Setting Up Direct Deposit</li>
            </ul>
            </p>
    </div>
     </div>


</div>
<script>

var cancel_pressed;

jQuery(document).ready(function() {
   // put all your jQuery goodness in here.
   jQuery("#wizard")
       .on("stepshow", "#s1", function () {
         cancel_pressed = false;
         return true;
      })       
       .on("stephide", "#s2", function () {         
         return finish_step_2();
      })
      .on("stephide", "#s3", function () {         
         return finish_step_3();
      })
      .on("stephide", "#s4", function () {         
         return finish_step_4();
      }) 
       .jWizard(
       {counter: {
    			enable: true,
                type: "count"
                },
            cancel: function () {
                cancel_pressed = true;
                reset_to_defaults();                
                jQuery("#wizard").jWizard("first");
            }
       }   
   );
  
   

 
   
 });
 

 function reset_to_defaults() {
    jQuery(function ($) {
        
        cancel_pressed = true;
    });
 }
 
 function jumpto_end() {
     reset_to_defaults();
     jQuery("#wizard").jWizard("step",5);
 }
 
 
 
 function finish_step_2()
 {
    return true;
     var is_valid = true;
     jQuery(function ($) {
        
           
            
     });
     
   
     
     return is_valid;
 }
 
 function setup_offer_code() {
    jQuery(function ($) {       
       
           
    }); 
 }
 
 
 function build_new_name() {    
    jQuery(function ($) {
       
           
    });    
 }
 
 function finish_step_3() {
    
    return true;
    
    var is_valid = true;
    jQuery(function ($) {
        
      
       
    });
    return is_valid;
 }
 
 
 function finish_step_4() {
    
    return true;
    var is_valid = true;
    jQuery(function ($) {
        
        
        
        /*
        $.ajax({
                  type: 'POST',
                  url: ajaxurl,
                  async: false, // Yes, the A is for Asyncronous... but the X is for XML.
                  dataType: 'json',
                  data: {
                    action: 'atx_create_offer',
                    name: prod_name,
                    code: prod_code,
                    pricing_model: 'single_price',
                    price: price
                  },
                  success: function(data){
                     $('#wait_for_save').html('');
                    if (data.code) {
                        // Populate all the short code notes etc.
                        $('#short_code_panel').html(data.id+'|'+data.code+'|'+data.name+'|'+data.pricing.offers['default'].price);
                    }
                    else {
                        is_valid = false;
                        alert(data);
                    }
                    
                  }
                  
                });
          */      
       
    });
    return is_valid;
 }
 
 

</script>

    
</div>