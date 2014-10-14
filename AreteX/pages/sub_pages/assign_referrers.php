<div class="ui-widget-header ui-corner-top" >
<h2 style="text-align: center; margin-top: 5px; margin-bottom: 5px;">Assign Referrers</h2>
</div>
<div class="ui-widget ui-widget-content  ui-corner-bottom" style="padding: 5px;" >



    <div id="wizard">
    <!-- steps will go here -->
       
    <div data-jwizard-title="Referrers" id="s2aa">
       <div style="margin: 5px;">
       <label>Commissioned Referrers</label>
       <p>A<strong> Commissioned Referrer</strong> is an individual who is placed in a commission group to receive 
       tracking codes for use in promotions and sales, as well as receive commission payments after a sale.</p>
 
       
       </div> 
    </div>
    
    <div data-jwizard-title="Assignment" id="s3bb">
       <div style="margin: 5px;">
         <label>Individual Referrer Assignment</label>
         <p>Individal referrers must be assigned to a commission group. After using this wizard to
         set up your commission group(s), you may assign your referrers, through either a:
          <ul>
            <li><em>Sign Up Form</em>, using WordPress short codes</li>
            <li><em>Payee Control Panel</em>, payee management place</li>
          </ul>
         
          </p> 
          
       </div> 
    </div>
    
    <div data-jwizard-title="Sign Up Form" id="s3bb">
       <div style="margin: 5px;">
         <label>Referrer Sign Up Form</label>
         <p>
            Talk about the default form, short codes and customization.
          </p> 
          
       </div> 
    </div>
    

    <div data-jwizard-title="Sign Up Tiers" id="s3bb">
       <div style="margin: 5px;">
         <label>Single and Multi-Tier at Sign Up</label>
                    <p>Although AreteX allows for multi-tiered commissions, this wizard only deals with Single Tier 
       commission structures. (For more on multi-tiered commissions, click here.)
       <em>Note</em>: A Single Tier commission structure allows an individual to be a member of only one Commission 
       Group. </p>
          
       </div> 
    </div>
   
    <div data-jwizard-title="Control Panel" id="s3bb">
       <div style="margin: 5px;">
         <label>Payee Control Panel</label>
         <p>
            Talk about the Payee Control Panel.
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
  
  jQuery('.special_offer').hide();
  jQuery('.offer_limit').hide();
   
 });
 

 function reset_to_defaults() {
    jQuery(function ($) {
        $('.special_offer').hide();
        $('.offer_limit').hide();
        $('#is_std_price').val('STD');
        $('#offer_name').val('Regular Price');
        $('#offer_code').val('REG');
        $('#offer_limit_sel').val('NONE'); 
        $('#discount_price_form')[0].reset();
        $('#offer_limit_form')[0].reset();
        $('#new_offer_form')[0].reset();
        cancel_pressed = true;
    });
 }
 
 function jumpto_end() {
     reset_to_defaults();
     jQuery("#wizard").jWizard("step",5);
 }
 
 function chg_offer() {
    jQuery(function ($) {
        if ($('#is_std_price').val() == 'STD') {
            $('.special_offer').hide();
        }
        else if ($('#is_std_price').val() == 'DIS') {
            $('#dis_offer').show();
            
        }
    });
 }
 
 function chg_offer_limit() {
     jQuery(function ($) {
        if ($('#offer_limit_sel').val() == 'NONE') {
            $('.offer_limit').hide();
        }
        else if ($('#offer_limit_sel').val() == 'EXP') {
            $('#offer_exp').show();
            
        }
    });
    
 }
 
 function finish_step_2()
 {
     var is_valid = true;
     jQuery(function ($) {
        if ($('#is_std_price').val() == 'DIS' && ! cancel_pressed)
        {
            $('#discount_price_form').validate();
            if (!  $('#discount_price_form').valid() )
            {
                 is_valid = false;
            }
                                             
        }
        else
        {
            $('#discount_price_form')[0].reset();
            
        }
           
            
     });
     
   
     
     return is_valid;
 }
 
 function setup_offer_code() {
    jQuery(function ($) {       
        var change = false;
        var amt = '';
        var code = '';
        if ($('#is_std_price').val() == 'DIS') {
            amt = $('#pct_off').val();
            code = amt.replace('.','X');
            code = 'D'+code;
            change = true;  
        }
                       
        if (change) {
             $('#offer_code').val(code);
        }
           
    }); 
 }
 
 
 function build_new_name() {    
    jQuery(function ($) {
        var name = '';
        var change = false;
        if ($('#is_std_price').val() == 'DIS') {
            name = $('#pct_off').val() + '% Discount ';
            change = true;  
        }
        
        if ($('#offer_limit_sel').val() == 'EXP') {
            name += 'Expires:'+ $('#exp_date').val();
            change = true;
        }
        
        if (change) {
             $('#offer_name').val(name);
        }
           
    });    
 }
 
 function finish_step_3() {
    
    var is_valid = true;
    jQuery(function ($) {
        
        if ($('#offer_limit_sel').val() == 'EXP' && ! cancel_pressed)
        {
            $('#offer_limit_form').validate();
            if (!  $('#offer_limit_form').valid() ) {
                 is_valid = false;
            }
                                               
        }
        else
        {
            $('#offer_limit_form')[0].reset();
            
        }
        
        if (is_valid && ! cancel_pressed)
        {
            build_new_name();
            setup_offer_code();
        }
       
    });
    return is_valid;
 }
 
 
 function finish_step_4() {
    
    var is_valid = true;
    jQuery(function ($) {
        
        /*
            Validate:
                Name must not be blank
                Code must not be blank
                Code must be unique
                
                Create the offer
        */
        
        $('#new_offer_form').validate(
            {
        		rules: {
        			offer_code: {
        			    required: true, 
        				remote: {
        				    url: ajaxurl,
        				    data: {
                        		action: 'atx_check_offer_code'                            		
                        	}
        				}
        			}
                }
                    
      		}
        );
        if (!  $('#new_offer_form').valid() ) {
             is_valid = false;
        }
        
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