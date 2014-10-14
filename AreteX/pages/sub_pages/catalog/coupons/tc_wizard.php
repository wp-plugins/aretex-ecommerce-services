<div class="section group"> <!-- ROW -->
    <div class="col span_8_of_12"> <!-- Column -->
   
<div class="ui-widget-header ui-corner-top" >
<h2 style="text-align: center; margin-top: 5px; margin-bottom: 5px;">Simple Tracking Code Wizard</h2>
</div>
<div class="ui-widget ui-widget-content  ui-corner-bottom" style="padding: 5px;" >

    
    <div id="wizard">
    <!-- steps will go here -->

<div data-jwizard-title="Welcome" id="s1">
       <div style="margin: 5px;">
       <strong>Welcome to the Simple Tracking Code Wizard</strong>
       <p>AreteX&trade; uses general tracking codes to link people and products to your sales. This wizard will walk you through (explain) the three parts necessary to create a tracking code. These include 
        <br /><br />
        1) the Offer Code (regular or discount),<br /> 
        2) the Media Source (your sales or advertising site),<br /> 
        3) the Referrer (if you have people you pay). <span style="font-size: 11px;">
        <em>Note:</em> This wizard only creates <em>non-commission generating</em> tracking codes.  To create 
        commission generating tracking codes, you must <em>first</em> set up Commission Groups and then 
        assign people to those groups. (See <em>Setup/Payouts/Commission Structures</em>)
        </span>
        </p>
       
       </div> 
    </div>
    <div data-jwizard-title="Offer Adjustment" id="s2">
       
        <div style="margin: 5px;" >
               

             <div id="std_offer_price">
                <div class="ui-widget">
                    <label for="is_std_price">Pricing Adjustment</label>
                        <select onchange="chg_offer();" id="is_std_price"><option value="STD">Standard Offer </option><option value="DIS">% Discount on Entire Purchase</option></select>

                </div>                
             </div>
             <div id="dis_offer" class="special_offer" >
               <form id="discount_price_form" action="javascript:void(0);">
                    <div class="ui-widget">
                        <label  for="pct_off">Percent Off Total Purchase: </label>
                        <input type="text" class="required number" min="0.01" max="100"   style="width: 75px;" id="pct_off" /> %                        
                    </div>
                </form>
                <p>This discount will be applied to the entire purchase (not including tax and shipping) at the time of checkout.<br />
                <span style="font-size: 11px;"><em>Note:</em> you may apply discounts to particular prodcuts with the <em>Offer Code</em> menu tab. </span>
                </p>
                <hr />
             </div>
             <p>In this wizard, "Standard Offer" Pricing Adjustment means that no discount will be applied when this Offer Adjustment is used. 
             To apply a discount Pricing Adjustment, select "Special Offer - % Discount" in the pull down above.</p>
             
         </div>
    </div>
    <div data-jwizard-title="Offer Time" id="s3">
        <div style="margin: 5px;" >
                <div id="offer_limits">
                <div class="ui-widget">
 
                    <label for="offer_limit_sel">Offer Time Limit</label>
                        <select onchange="chg_offer_limit();" id="offer_limit_sel"><option value="NONE">No Time Limit</option><option value="EXP">Offer Expires ...</option></select>

                </div>
                <div id="offer_exp" class="offer_limit" >
                    <form id="offer_limit_form" action="javascript:void(0);">
                    <div class="ui-widget">
                        <label  for="exp_date">Offer Expiration Date: </label>
                        <input type="text" class="required date"  style="width: 100px;" id="exp_date" /> &nbsp; <span style="font-size: 11px;">(Must included Month, Day and Year)</span>                         
                    </div>
                    </form>               
             </div> 
             <p>With this wizard, you may have "No Time Limit" or have the offer be limited by an expiration date.
                
                </p>               
             </div>             
        </div>
    
    </div>

 <div data-jwizard-title="Offer Identity" id="s4">
        <!-- step content -->
        <div style="margin: 5px;">

        </div>
        <div style="margin: 5px;" id="offer_id">
            <form id="new_offer_form" action="javascript:void(0);">
                <label for="offer_name">Offer Description</label><input required="required"  id="offer_name" name="offer_name" value="Regular Price" type="text" />
                <br /><span style="font-size: 11px;"> You may change this description if you wish.         
                (This description will appear on the reports and be available on the Payment Tracking and Reporting screen.)</span>
                 <br /><br />
                <label style="display: inline-block;">Offer Code</label><input id="offer_code" required="required" name="offer_code" size="25" style="width: 75px;" value="" type="text" />
                <p style="font-size: 11px;"><em>Note:</em>This code was generated based on your choices. If you get a "Code Already" exists, error, you must change it.</p>
                                 
                </form>
                <p>Selecting <em>Next</em> will save the offer code to the AreteX&trade; database.</p>
                <div id="wait_for_save"></div>
                     
        </div>
       
    </div>

    <div data-jwizard-title="Media Source" id="s5">
        <!-- step content -->
        <div id="media_source_panel" style="margin: 5px;" >
             <p>You may select from one of the following media sources, or add a new media source. </p>
             <select id="wz_media_code" onchange="chg_media()">
             <option value="new">(New Media Source)</option>
            <?php
            $source_media = AreteX_WPI::getAllSourceMedia();
            foreach($source_media as $source) {
                $source = get_object_vars($source);
                $sel = '';
                if ($source['source_id'] == 'WEB')
                    $sel = 'selected="selected"';
                echo "<option $sel value=\"{$source['source_id']}\">{$source['source_id']} - {$source['description']}  </option>\n";
        
            }
           
            ?>
            </select>   
             <div id="add_new_media_source">
             <hr />
             <form id="new_media_form" action="javascript:void(0);">
                    <div class="ui-widget">
                        <label  for="wz_media_id">Media Source ID Code: </label>
                        <input type="text" class="required lettersnumbers"  maxlength="7"  style="width: 75px;" id="wz_media_id" /> <input onclick="aretex_assigns_code();" id="let_aretx_assign" type="checkbox" /> Let AreteX Assign
                        <br />
                        <label  for="wz_media_desc">Description: </label>
                        <input type="text" class="required " style="width: 75%;"  maxlength="200" placeholder="(i.e. Web Site, Newsletter, Brochure, Adwords, Yahoo ..)" id="wz_media_desc" />                         
                        <p><br />Selecting <em>Next</em> will save this new media source to the AreteX&trade; Database</p>
                    </div>
                </form>
             </div>
             <script>
             function chg_media() {
                if (jQuery('#wz_media_code').val() == 'new') {
                    jQuery('#add_new_media_source').show();
                }
                else {
                     jQuery('#add_new_media_source').hide();
                }
             }
             </script>           
        </div>
        
    </div>
    <div data-jwizard-title="Referrer" id="s6">
    <!-- step content -->
        <div id="referrer_panel" style="margin: 5px;" >
        <p>This wizard will only generate a non-commission tracking code. (See <em>Full Tracking</em> to generate a
        Tracking Code that allows payment of commissions.)</p>
        <p>The <em>referrer code</em> is unique to each payee. Each payee may recieve his/her own referrer code through 
        your payees' Payment, Tracking, &amp; Reporting screen (PTR).  If you have an off-line sales force, or just want to hand out 
        Splash Codes (see Help and Information - Splash Codes) use the <em>Full Tracking</em> menu tab.</p>
        <p>On the next screen, a  tracking code will be generated for "Payee Number Zero". Any codes with "Payee Zero" do not earn a commission.</p>
        </div>
    
    </div>
    <div data-jwizard-title="Example" id="s7">
    <!-- step content -->
       <div id="example_panel" style="margin: 5px;" >
        <p>This is your simple URL tracking code.</p>
      
          <div  id="final_example" style="font-size: 12px; font-family: Courier New, Courier, monospace;">            
          </div>
          <p> 
          You may instruct your customers to enter the tracking code below into a "Coupon Box" (see <em>WP Integration</em> for coupon box details).</p>
          <div id="tracking_exmple" style="font-size: 12px; font-family: Courier New, Courier, monospace;">
          
          </div>
        </div>

    
    </div>
</div>
<script>

var cancel_pressed;
var prev_pressed;

jQuery(document).ready(function() {
   load_wiz_help('s1');
   
    chg_media();
   
   jQuery("#wizard")
       .on("stepshow", "#s1", function () {
         load_wiz_help('s1');
         cancel_pressed = false;
         return true;
      })
      .on('stepshow','#s2',function () {
         load_wiz_help('s2');         
         return true;
      })
      .on('stepshow','#s3',function () {
         load_wiz_help('s3');         
         return true;
      })
      .on('stepshow','#s4',function () {
         
         load_wiz_help('s4');         
         return true;
      })
      .on('stepshow','#s5',function () {
         load_wiz_help('s5');         
         return true;
      })
      .on('stepshow','#s6',function () {
         load_wiz_help('s6');         
         return true;
      })
      .on('stepshow','#s7',function () {
         load_wiz_help('s7');         
         return true;
      })
       .on("stephide", "#s1", function () {
         return true;
      })
       .on("stephide", "#s2", function () {         
         return validate_pricing();
      })
      .on("stephide", "#s3", function () {         
         
         return finish_offer_limits();
      })
      .on("stephide", "#s4", function () {         
         
         return save_offer_code();      
      })
       .on("stephide", "#s5", function () {         
         
         
         return hide_step_five();      
      })

      
      .on("wizardfinish", function(){
        load_content_screen('catalog/coupons');
      })  
       .jWizard(
       {counter: {
    			enable: true,
                type: "count"
                },
            cancel: function () {
                cancel_pressed = true;
                
                jQuery('.special_offer').hide();
                jQuery('.offer_limit').hide();
                jQuery('input.error').removeClass('error');
                jQuery("label.error").remove(); 
                jQuery('#is_std_price').val('STD');
                jQuery('#offer_name').val('Regular Price');
                jQuery('#offer_code').val('REG');
                jQuery('#offer_limit_sel').val('NONE'); 
                jQuery('#discount_price_form')[0].reset();
                jQuery('#offer_limit_form')[0].reset();
                jQuery('#new_offer_form')[0].reset();
                 
                jQuery('#wait_for_save').html('');
                jQuery("label.error").hide();
                jQuery(".error").removeClass("error");
                jQuery("#wizard").jWizard("first");
            }
       }   
   );
  
   jQuery('.special_offer').hide();
  jQuery('.offer_limit').hide();
   
 });
 
 jQuery('.jw-button-prev').click(function(){
    prev_pressed = true;
   });
 
  jQuery('.jw-button-next').click(function(){
    prev_pressed = false;
   });
   
 
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
        else {
            code = 'REG1';
            change = true; 
        }
                       
        if (change) {
             $('#offer_code').val(code);
        }
           
    }); 
 }
 
 function finish_offer_limits() {
    
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
 
 function validate_pricing()
 {
     if (prev_pressed || cancel_pressed)
        return true;
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
 

 
 function setup_step_3()
 {
    
    
     return true;
 }
 
 
 
 function aretex_assigns_code()
 {
     jQuery(function ($) {
        if ($('#let_aretx_assign').is(':checked')){
            $('#wz_media_id').val('*');
            $("#wz_media_id").attr('readonly','readonly');
            $('#wz_media_id').removeClass('lettersnumbers');
        }
        else {
            $('#wz_media_id').val('');
            $("#wz_media_id").removeAttr('readonly');
            $('#wz_media_id').addClass('lettersnumbers');
        }
        
        
     });
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


 function save_offer_code() {
    
    var is_valid = true;
    if (cancel_pressed)
        return is_valid;
    if (prev_pressed)
        return true;
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
                        lettersnumbers: true,
                        maxlength: 7, 
        				remote: {
        				    url: ajaxurl,
        				    data: {
                        		action: 'atx_check_offer_code'                            		
                        	},
                            async:false
        				}
        			}
                }
                    
      		}
        );
        if (!  $('#new_offer_form').valid() ) {            
             is_valid = false;
        }
        
        
        
        
        if (is_valid) {
             $('#wait_for_save').html('<center>...Saving - Please Wait...</center>');
            var offer_code = $('#offer_code').val();
            var offer_name = $('#offer_name').val();
            var offer_type = $('#is_std_price').val();
            var pct_off = $('#pct_off').val();
            var limits = null;
            var offer_limit_sel = $('#offer_limit_sel').val();
            var exp_date = null;
            if (offer_limit_sel != 'NONE') {
                limits = new Array();
                limits[0] = offer_limit_sel;
                exp_date = $('#exp_date').val();
            }
            
            $.ajax({
                      type: 'POST',
                      url: ajaxurl,
                      async: false, // Yes, the A is for Asyncronous... but the X is for XML.
                      dataType: 'json',
                      data: {
                        action: 'atx_create_offer',
                        offer_code: offer_code,
                        description: offer_name,
                        limits: limits,
                        exp_date: exp_date,
                        offer_type: offer_type,
                        pct_off: pct_off
                      },
                      success: function(data){
                         if (data == 'Error')
                         {
                            alert('Offer Code Not Saved');
                            is_valid = false;
                         }
                         else
                         {
                            $('#final_example').html(data.url);
                            $('#tracking_exmple').html(data.tracking_code);
                         }
                         $('#wait_for_save').html('');
                                                                        
                      }
                      
                    });
                   
          } 
        });
        
    
    return is_valid;
 }

function hide_step_five() {
    var new_media = jQuery('#wz_media_code').val();    
    if (new_media == 'new')
        return save_media_source();
    else 
    {
       var payee = '0';
       var offer_code = jQuery('#offer_code').val();
       var media = new_media;
       jQuery.ajax({
          type: 'POST',
          url: ajaxurl,
          async: false, 
          dataType: 'json',
          data: {
            action: 'atx_full_tracking',
            offer: offer_code,
            media: media,
            payee: payee
          },
          success: function(data){            
            jQuery('#final_example').html(data.url);
            jQuery('#tracking_exmple').html(data.code);                                                            
          }
          
        });
       
    } 
                    
    return true; 
}
        


function save_media_source() {
    
    var is_valid = true;
    if (cancel_pressed)
        return is_valid;
    if (prev_pressed)
        return true;
    jQuery(function ($) {
        
      
        
        $('#new_media_form').validate();
        if (!  $('#new_media_form').valid() ) {            
             is_valid = false;
        }
                
        
        
        if (is_valid) {
             $('#wait_for_save2').html('<center>...Saving - Please Wait...</center>');
            var source_id = $('#wz_media_id').val();
            var description = $('#wz_media_desc').val();
             var offer_code = $('#offer_code').val();            
            
       console.log('C');
                   
            $.ajax({
                      type: 'POST',
                      url: ajaxurl,
                      async: false, // Yes, the A is for Asyncronous... but the X is for XML.
                      dataType: 'json',
                      data: {
                        action: 'atx_create_media_code',
                        source_id: source_id,
                        description: description,
                        offer_code: offer_code
                      },
                      success: function(data){
                         if (data == 'Error')
                         {
                            alert('Media Code Not Saved');
                            is_valid = false;
                         }
                         else
                         {
                            $('#final_example').html(data.url);
                            $('#tracking_exmple').html(data.tracking_code);
                         }
                         $('#wait_for_save2').html('');
                                                                        
                      }
                      
                    });
                   
          } 
        });
        
    console.log('is_valid');
    return is_valid;
 }


function load_wiz_help(screen)
{
    load_div_screen('catalog/coupons/help/tc_wiz/'+screen,'#wizard_help_div');
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