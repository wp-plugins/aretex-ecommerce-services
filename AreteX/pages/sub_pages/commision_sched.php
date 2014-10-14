<div class="ui-widget-header ui-corner-top" >
<h2 style="text-align: center; margin-top: 5px; margin-bottom: 5px;">Schedule Automatic Commission Payments</h2>
</div>
<div class="ui-widget ui-widget-content  ui-corner-bottom" style="padding: 5px;" >
<button onclick="load_screen('pay_people_wizards');"  class="button">Back</button>
<hr />

    <div id="wizard">
    <!-- steps will go here -->
    <div data-jwizard-title="Frequency" id="s1">
       <div style="margin: 5px;">
       <label>Commission Payment Frequency </label>
       <p style="font-size: 11px;">How often should AreteX&trade; automatically pay referrers?</p>
       <select onchange="change_pay_com_freq()" id="pay_com_freq" name="pay_com_freq">
        <option value="Daily">Daily</option>
        <option value="Weekly">Weekly</option>
        <option value="Semi-Monthly">Semi-Monthly</option>
        <option  selected="selected" value="Monthly">Monthly</option>
        </select>
        
      <hr />
      <label>Pay Day(s)</label>
      <div class="paydays" id="monthly_payday">
      <p style="font-size: 11px;">Enter the day of the month to auto pay. (1 = first day of month), (31=last day of month)</p>
      <form id="monthly_payday_form">
      <label style="display: inline; ">Day of Month</label> <input id="day_of_month" name="day_of_month" size="25" style="width: 75px;" value="1" type="text" /> 
      </form>
      </div>
      
      <div class="paydays" id="weekly_payday">
      <p style="font-size: 11px;">Select the day of the week to auto pay. </p>
      <form id="weekly_payday_form">
        <label style="display: inline; ">Day of Week </label> 
         <select onchange="chg_day_of_week()" id="day_of_week" name="day_of_week">
        <option value="Monday">Monday</option>
        <option value="Tuesday">Tuesday</option>
        <option value="Wednesday">Wednesday</option>
         <option value="Thursday">Thursday</option>
        <option  selected="selected" value="Friday">Friday</option>
        </select>
      </form>
      </div>
      
      <div class="paydays" id="daily_payday">
      <p style="font-size: 11px;"> AreteX&trade; will make automatic payments once per day.</p>

      </div> 
      
      
      <div class="paydays" id="semimonthly_payday">
      <p style="font-size: 11px;"> Enter the two days of the month to auto pay. (1 = first day of month), (31=last day of month)</p>
      <form id="semimonthly_payday_form">
      <label style="display: inline; ">Day of Month (1st Payment)</label> <input id="day_of_month_a" name="day_of_month_a" size="25" style="width: 75px;" value="1" type="text" />
      <label style="display: inline; ">(2nd Payment)</label> <input id="day_of_month_b" name="day_of_month_b" size="25" style="width: 75px;" value="15" type="text" /> 
 
      </form>
      </div>      
      
       </div> 
    </div>
    
    
    
    <div data-jwizard-title="Waiting Period" id="s2">
       <div style="margin: 5px;">
         <label>Set Waiting Period</label>
                
               <p>
              If you want to have a waiting period to allow time for returns, refunds, confirmation of sales, etc.  
              specify the number of days to wait below.  
              Commissions will be scheduled  for payment on the first available payday after the specified waiting period has past.
              
               </p> 
                     <form id="monthly_payday_form">
                        <label style="display: inline; ">Number of Days after Completed Sale to Wait</label> <input id="waiting_period" name="waiting_period" size="25" style="width: 75px;" value="7" type="text" /> 
                    </form>  
                    <p>Enter <span style="font-weight: bold; font-size: 110%; font-style: italic;">0</span> for no waiting period.  </p>          
       </div> 
    </div>
    

    
     <div data-jwizard-title="Confirmation" id="s4">
       <div style="margin: 5px;">
      
         <label>Confirmation</label>
                <select onchange="chg_confirm_auto_pay();" id="confirm_auto_pay" name="confirm_auto_pay">
        <option value="disabled">Direct Deposit Autopay - Disabled</option>
        <option value="enabled">Direct Deposit Fully Automatic</option>
        <option value="spreadsheet">Calculate For Manual Payment</option>
        <!--
        <option value="confirm">Direct Deposit Confirmation Required</option>
        -->       
        </select>
                
         <hr />
          <p class="confirmation" id="autopay_disabled">Automatic payment of commissions by Direct Deposit is disabled.</p>
          <p class="confirmation" id="autopay_enabled">Automatic payment of commissions by Direct Deposit is enabled.
          <br/><strong>Note:</strong> You must have a Forte (ACH Direct) account with AreteX&trade; as the <em>authorized transmitter</em> for your ACH account in order for this feature to be completely enabled.
          See "How to Set Up Direct Deposit".
          </p>
          <p class="confirmation" id="autopay_spreadsheet">AreteX&trade; will calculate commissions and payment schedules. 
          You will be presented with an opportunity to download them in spreadsheet format. (Click Here for More Info) </p>

       </div> 
    </div>
    
    
     <div data-jwizard-title="Complete" id="s4">
       <div style="margin: 5px;">
      
         <label>Complete</label>
            <p >Automatic Commission Schedule Setup is Complete.</p>

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
  
   
   change_pay_com_freq();
   chg_confirm_auto_pay();
 
   
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
 
 function change_pay_com_freq() {
    jQuery(function ($) { 
        
        $('.paydays').hide();
        var freq = $('#pay_com_freq').val();
        switch(freq)
        {
            case 'Monthly':
                $('#monthly_payday').show();
            break;
            case 'Weekly':
                $('#weekly_payday').show();
            break;
            case 'Semi-Monthly':
                $('#semimonthly_payday').show();
            break;
            case 'Daily':
                $('#daily_payday').show();
            break;
        }
       
           
    }); 
 }
 
 
 function chg_confirm_auto_pay() {    
    jQuery(function ($) {
        
        $('.confirmation').hide();
        var confirm  = $('#confirm_auto_pay').val();
        switch(confirm)
        {
            case 'disabled':
                $('#autopay_disabled').show();
            break;
            case 'enabled':
                $('#autopay_enabled').show();
            break;
            case 'spreadsheet':
                $('#autopay_spreadsheet').show();
            break;
            
        }
       
           
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