<div class="section group"> <!-- ROW -->
    <div class="col span_8_of_12"> <!-- Column -->
   
<div class="ui-widget-header ui-corner-top" >
<h2 style="text-align: center; margin-top: 5px; margin-bottom: 5px;">New Paid Content Wizard</h2>
</div>
<div class="ui-widget ui-widget-content  ui-corner-bottom" style="padding: 5px;" >

    
    <div id="wizard">
    <!-- steps will go here -->

    <div data-jwizard-title="Identity" id="s1">
        <!-- step content -->

        <div style="margin: 5px;" id="pd_content_id">
            <form id="new_pd_content_id">
                <label for="prod_name2">Product Name</label><input   id="prod_name2" name="prod_name2" type="text" />
               

                 
                <label style="display: inline-block;">Product/Delivery Code</label><input   id="prod_code2"  name="prod_code2" size="25" style="width: 55px;" type="text" />
                <input id="let_aretx_assign"type="checkbox" onclick="aretex_assigns_code();" /> <span style="display: inline-block;">Let AreteX&trade; Assign the Code</span>
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
                There is no need to enter any "pricing details" on this step, because the donor will be able to enter any amount they wish ($1.00 and up) into the credit card form. 
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
                        <input name="data[rebill_data][trial_period]"  id="trial_period" min="1" value="30" class="digits required" type="text" style="width: 60px;" />    
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
                        <input name="data[rebill_data][max_billing_cycles]" value="" type="text" class="number" style="width: 60px;" /> 
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
                        Unless renewed, access to this content will expire after this many days. Leave blank for "Does not expire".</p>
                        
                    </div>                    
                </div>
                <div id="deliver_on_rebill">
                    <div class="ui-widget">
                     Authorization for availablity will be renewed <span id="dlv_frequency"></span> as long as automatic payment is current.    
                    </div>                    
                </div>
             </form> 
              <br /><br />
              <p>
              <em>Note:</em> Choosing "Next" will save your information to the AreteX&trade; database.  You may view this saved information by going to Catalog and Products button / Add/Edit Products.
              </p>  
        </div>
            
         
    </div>

    <div data-jwizard-title="Short Code" id="s5">
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
        <p>For this browser session only, you may use the <em>AreteX</em> button in the <strong>WordPress Page Editor</strong> to paste this shortcode into your content. Copy and paste this onto your page (<em>in <strong>text mode</strong></em>) and replace the note with actual content.
        </div>
        
    </div>
</div>
<script>

var cancel_pressed;
var prev_pressed;

jQuery(document).ready(function() {
   load_wiz_help('pch1');
   

   
   jQuery("#wizard")
       .on("stepshow", "#s1", function () {
         load_wiz_help('pch1');
         cancel_pressed = false;
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
         
         load_wiz_help('pch4');         
         return true;
      })
      .on('stepshow','#s5',function () {
         load_wiz_help('pch5');         
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
                jQuery('#new_pd_content_id')[0].reset();
                jQuery('#single_price_form')[0].reset();
                jQuery('#rebill_detail_form')[0].reset();
                jQuery("#prod_code2").removeAttr('readonly');
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

     jQuery('#new_pd_content_id').validate({
        rules: {
            prod_name2 : {
               required: true, 
            },
        	prod_code2: {
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
     if ( jQuery('#new_pd_content_id').valid()) {
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
            var prod_name = $('#prod_name2').val();
            var prod_code =  $('#prod_code2').val();
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
                first_delivery: 0,
                duration: duration,
                delivery_cycle: delivery_cycle,
                name: prod_name,
                description: prod_name + ': Paid Content',
                
            }
            
           
            
           
            
            $.ajax({
                  type: 'POST',
                  url: ajaxurl,
                  async: false, // Yes, the A is for Asyncronous... but the X is for XML.
                  dataType: 'json',
                  data: {
                    action: 'atx_create_full_paid_c_prod',
                    product: product_data,
                    deliverable: deliverable_data
                    
                  },
                  success: function(data){
                    
                     $('#short_code_text').val(data);
                    jQuery('#wait_for_save').html('');
                    
                  },
                  error: function(xhr, type, exception) {                     
                    alert("ajax error "+exception);
                    jQuery('#wait_for_save').html('');
                  }
                  
                });
            
               

     

        
    });
    
 }
 
 
 function aretex_assigns_code()
 {
     jQuery(function ($) {
        if ($('#let_aretx_assign').is(':checked')){
            $('#prod_code2').val('*');
            $("#prod_code2").attr('readonly','readonly');
        }
        else {
            $('#prod_code2').val('');
            $("#prod_code2").removeAttr('readonly');
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