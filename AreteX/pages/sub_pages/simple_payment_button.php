<div class="ui-widget-header ui-corner-top" >
<h2 style="text-align: center; margin-top: 5px; margin-bottom: 5px;">How to Set Up a Simple Payment Button</h2>
</div>
<div class="ui-widget ui-widget-content  ui-corner-bottom" style="padding: 5px;" >
    <p>A Simple Payment Button ... </p>
    
    <div id="wizard">
    <!-- steps will go here -->
    <div data-jwizard-title="New or Existing?" id="s1">
       <div style="margin: 5px;">
        <p>In AreteX&trade;, we refer to anything you get paid for as a "Product". (Even if it's actually a service or donation).</p>
        <!-- step content -->
        <p>
            Is this a new (to AreteX) Product or Service? 
            <select id="new_or_existing"><option value="New">Yes - this is New </option><option value="Existing">No, it's already in AreteX(tm)</option></select>
        </p>
       </div> 
    </div>
    <div data-jwizard-title="Identity" id="s2">
        <!-- step content -->
        <div style="margin: 5px;">
        <p>Identify the product (or service) for which you will recieve payment.</p>
        </div>
        <div style="margin: 5px;" id="new_product">
            <form id="new_prod_form">
                <label for="prod_name2">Enter the Product Name</label><input required="required"  id="prod_name2" name="prod_name2" type="text" />
               
                <p>This will appear on the receipts and invoices and be available in shortcodes. It should succinctly
                say  what your customer is paying for.   </p>
                 
                <label style="display: inline-block;">Product Code</label><input   id="prod_code2" name="prod_code2" size="25" style="width: 55px;" type="text" />
                <input id="let_aretx_assign" type="checkbox" onclick="aretex_assigns_code();" /> <span style="display: inline-block;">Let AreteX&trade; Assign the Product Code</span>
                <p>This is a unqiue short identifier used to refer to this product. You will need it for shortcodes.  It will apppear on invoices and receipts. </p>
            </form>
        </div>
        <div style="margin: 5px;" id="existing_product">
                        
            <div class="ui-widget" id="prod_wrapper">
                <label for="find_prod">Find Product: </label>
                <input id="find_prod">
            </div>
           <div class="ui-widget">
                <label for="prod_name">Product Name: </label>
                <input type="text" readonly="readonly" style="width: 100%" id="prod_name" />
            </div>
            <div class="ui-widget">
                <label for="prod_code">Product Code: </label>
                <input type="text" readonly="readonly" style="width: 55px;" id="prod_code" />
            </div>
               
        </div>
    </div>
    <div data-jwizard-title="Pricing" id="s3">
        <div style="margin: 5px;" >
             <div id="single_price_panel" >
               <form id="prod_price_form">
                    <div class="ui-widget">
                        <label id="price_label" for="prod_price">Price: </label>
                        $ <input type="text" class="required number"  style="width: 75px;" id="prod_price" />
                    </div>
                </form>
                <p>This is the normal amount the customer will pay for this product.</p>
             </div>
             <div id="other_price_panel">
                <div class="ui-widget">
                    <label for="prod_price_model">Pricing Model: </label>
                    <input type="text" readonly="readonly"  id="prod_price_model" />
                </div>
                <div class="ui-widget">
                    <label for="prod_price_detail">Price Detail: </label>
                    <input type="text" readonly="readonly"  id="prod_price_detail" />
                </div>
             </div>
             <div id="wait_for_save"></div>
         </div>
    </div>
    <div data-jwizard-title="Short Code">
        <!-- step content -->
        <div id="short_code_panel" style="margin: 5px;" >
        
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
       .on("stephide", "#s1", function () {
         return setup_step_2();
      })
       .on("stephide", "#s2", function () {         
         return setup_step_3();
      })
      .on("stephide", "#s3", function () {         
         return finish_step_3();
      }) 
       .jWizard(
       {counter: {
    			enable: true,
                type: "count"
                },
            cancel: function () {
                cancel_pressed = true;
                jQuery('#prod_price_form')[0].reset();
                jQuery('#new_prod_form')[0].reset();
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
 
 function setup_step_2()
 {
     jQuery(function ($) {
        if ($('#new_or_existing').val() == 'New')
        {
             $('#new_product').show();
             $('#existing_product').hide();
        }
        else
        {
            $('#new_product').hide();
            $('#existing_product').show();
             set_prodName_search();
            
        }
           
            
     });
 }
 
 
 
 function setup_step_3()
 {
     var is_valid = true;
     jQuery(function ($) {
        if ($('#new_or_existing').val() == 'New' && ! cancel_pressed)
        {
            $('#new_prod_form').validate(
                {
            		rules: {
            			prod_code2: {
            			    required: true, 
            				remote: {
            				    url: ajaxurl,
            				    data: {
                            		action: 'atx_check_prod_code'                            		
                            	}
            				}
            			}
                    }
                    
        		}
            );
            if (!  $('#new_prod_form').valid() )
            {
                 is_valid = false;
            }
            else
            {
                $("#prod_price").removeAttr('readonly');
                $("#price_label").text('Enter the Price:');
            }   
            
            
        }
        else
        {
            $("#prod_price").attr('readonly','readonly');
            $("#price_label").text('The Price Is:');
            
        }
           
            
     });
     
     return is_valid;
 }
 
 function finish_step_3() {
    
    var is_valid = true;
    jQuery(function ($) {
        if ($('#new_or_existing').val() == 'New' && ! cancel_pressed) {
            $('#prod_price_form').validate();
            if (!  $('#prod_price_form').valid() )
            {
                 is_valid = false;
            }
            
            if (is_valid) {
            // Ajax complete
            $('#wait_for_save').html('<center>...Please Wait...</center>');
            var prod_name = $('#prod_name2').val();
            var prod_code =  $('#prod_code2').val();
            var price = $('#prod_price').val();
            $.ajax({
                  type: 'POST',
                  url: ajaxurl,
                  async: false, // Yes, the A is for Asyncronous... but the X is for XML.
                  dataType: 'json',
                  data: {
                    action: 'atx_create_prod',
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
            
               
            }
     
        }
        
    });
    return is_valid;
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
 
</script>

    
</div>