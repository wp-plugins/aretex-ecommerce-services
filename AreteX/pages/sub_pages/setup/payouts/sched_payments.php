<div class="ui-widget-header ui-corner-top" >
<h2 style="text-align: center; margin-top: 5px; margin-bottom: 5px;">Create Payday Schedule</h2>
</div>
<div class="ui-widget ui-widget-content  ui-corner-bottom" style="padding: 5px;" >
<hr />

    <div id="wizard">
    <!-- steps will go here -->
    <div data-jwizard-title="Frequency" id="s1">
       <div style="margin: 5px;">
       <label>Payout Frequency </label>
       <p style="font-size: 11px;">How often do you want to pay your people?</p>
       <select onchange="change_pay_com_freq()" id="pay_com_freq" name="pay_com_freq">
        <option value="Daily">Daily</option>
        <option value="Weekly">Weekly</option>
        <option value="Semi-Monthly">Semi-Monthly</option>
        <option  selected="selected" value="Monthly">Monthly</option>
        </select>
        
      <hr />
      <label>Pay Day(s)</label>
      <div class="paydays" id="monthly_payday">
      <p style="font-size: 11px;">Enter the day of the month. (1 = first day of month), (31=last day of month)</p>
      <form id="monthly_payday_form">
      <label style="display: inline; ">Day of Month</label> <input id="day_of_month" name="day_of_month" size="25" style="width: 75px;" value="1" type="text" /> 
      </form>
      </div>
      
      <div class="paydays" id="weekly_payday">
      <p style="font-size: 11px;">Select the day of the week you will pay. </p>
      <form id="weekly_payday_form">
        <label style="display: inline; ">Day of Week </label> 
         <select  id="day_of_week" name="day_of_week">
        <option value="Monday">Monday</option>
        <option value="Tuesday">Tuesday</option>
        <option value="Wednesday">Wednesday</option>
         <option value="Thursday">Thursday</option>
        <option  selected="selected" value="Friday">Friday</option>
        </select>
      </form>
      </div>
      
      <div class="paydays" id="daily_payday">
      <p style="font-size: 11px;"> Payment due immediately after the waiting period.  (See next screen.)</p>

      </div> 
      
      
      <div class="paydays" id="semimonthly_payday">
      <p style="font-size: 11px;"> Enter the two days of the month you will pay. (1 = first day of month), (31=last day of month)</p>
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
              Payments will be scheduled the first available payday after the specified waiting period has past.
              
               </p> 
                     <form id="monthly_payday_form">
                        <label style="display: inline; ">Number of Days after Completed Sale to Wait</label> <input id="waiting_period" name="waiting_period" size="25" style="width: 75px;" value="7" type="text" /> 
                    </form>  
                    <p>Enter <span style="font-weight: bold; font-size: 110%; font-style: italic;">0</span> for no waiting period.  </p>          
       </div> 
    </div>
    

    
     <div data-jwizard-title="Payout Method" id="s4">
       <div style="margin: 5px;">
      
         <label>Payout Method</label>
                <select onchange="chg_confirm_auto_pay();" id="confirm_auto_pay" name="confirm_auto_pay">
        <option value="enabled">Direct Deposit Fully Automatic</option>
        <option value="spreadsheet">Manual Payment</option>
        <!--
        <option value="confirm">Direct Deposit Confirmation Required</option>
        -->       
        </select>
                
         <hr />
          <p class="confirmation" id="autopay_disabled">Automatic payments by Direct Deposit is disabled.</p>
          <p class="confirmation" id="autopay_enabled">Automatic payment of commissions by Direct Deposit is enabled.
          <br/><strong>Note:</strong> In order for this feature to function properly - You must have a Forte (ACH Direct) account with 
          AreteX&trade; as the <em>authorized transmitter</em> for your ACH account.<br /> <br />
         If you wish to sign up for a Forte account, (<a target="_blank" href="https://aretexhome.com/AreteX/authorize/add_forte?license_key=<?php echo get_option('aretex_license_key'); ?>">click here</a> ).  This opens a new window. </p>
               
          <p class="confirmation" id="autopay_spreadsheet">AreteX&trade; will calculate commissions and payment schedules. 
          A downloadable spreadsheet of payments due to payees is provided.  (<em>Reports &amp; Management / Payees / Manual Batch / Payments Due </em>)

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
         return true;
      }) 
       .jWizard(
       {counter: {
    			enable: true,
                type: "count"
                },
            finish: function(){
                finish_payday_sched();
            },
            cancel: function () {
                cancel_pressed = true;
                reset_to_defaults();                
                //  jQuery("#wizard").jWizard("first");
                load_div_screen('setup/payouts/setup_sched','#payout_content');
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



 
 function finish_payday_sched() {
    
    var is_valid = true;
    jQuery(function ($) {
        
        
        var pay_day =  get_payday();
        var freq = $('#pay_com_freq').val();
        var waiting = $('#waiting_period').val();
        var method = get_pay_method();
        $.ajax({
                  type: 'POST',
                  url: ajaxurl,
                  async: false, // Yes, the A is for Asyncronous... 
                  dataType: 'json', // ... but the X is for XML.
                  data: {
                    action: 'atx_save_pay_sched',
                    pay_frequency: freq ,
                    pay_day: pay_day,
                    wait_days: waiting,
                    pay_method: method
                  },
                  success: function(data){
                     $('#wait_for_save').html('');
                    if (data == "OK") {
                        alert('Payday Schedule Saved');
                        load_div_screen('setup/payouts/setup_sched','#payout_content');
                    }
                    else {
                        is_valid = false;
                        alert(data);
                    }
                    
                  }
                  
                });
                
         function get_payday() {

            var pay_day;
            var freq = $('#pay_com_freq').val();
            switch(freq) {
                case 'Daily':
                    pay_day = '1'; // It doesn't really matter but it needs something
                break;
                case 'Weekly':
                    pay_day = $('#day_of_week').val();
                break;
                case 'Monthly':
                    pay_day = $('#day_of_month').val();                
                break;
                case 'Semi-Monthly':
                    pay_day = $('#day_of_month_a').val() + ',' + $('#day_of_month_b').val();
                break;
            }
            return pay_day;
   
        
        }
        
         function get_pay_method() {
            
                switch($('#confirm_auto_pay').val()) {
                    case 'disabled':
                        return 'None';
                    break;
                    case 'enabled':
                        return 'ACH';
                    break;
                    case 'spreadsheet':
                        return 'Manual';
                    break;
                }
                
                
            
         } 
             
       
    });
    return is_valid;
 }
 

 

 

</script>

    
</div>