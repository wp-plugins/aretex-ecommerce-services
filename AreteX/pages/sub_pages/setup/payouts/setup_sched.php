<?php   $payment_sched = AreteX_WPI::getBsuPaymentSchedule(); ?>

<div class="tabs">
<ul>
<li><a href="#tabs-1">Payday Schedule</a></li>
<li><a href="#tabs-2">Help &amp Information</a></li>
</ul>
<div id="tabs-1">
<div class="ui-widget ui-widget-content  ui-corner-all container"  style="margin: 3px;">
<div class="section group"> <!-- ROW -->
    <div class="col span_4_of_12"> <!-- Column -->
        
        <h4 style="text-align: center;">Current Payday Schedule</h4>
       
        <div class="section group"> <!-- ROW -->
            <div class="col span_6_of_12"> <!-- Column -->
            <span style="text-align:right; float:right; font-weight:bold">Frequency</span>
            </div> <!-- END Column -->
            <div class="col span_6_of_12"> <!-- Column -->
            <?php echo $payment_sched->pay_frequency; ?>
            </div> <!-- END Column -->
        </div> <!-- END ROW -->
        <div class="section group"> <!-- ROW -->
            <div class="col span_6_of_12"> <!-- Column -->
            <span style="text-align:right; float:right; font-weight:bold">Pay Day</span>
            </div> <!-- END Column -->
            <div class="col span_6_of_12"> <!-- Column -->
            <?php echo $payment_sched->pay_day; ?>
            </div> <!-- END Column -->
        </div> <!-- END ROW -->
        <div class="section group"> <!-- ROW -->
            <div class="col span_6_of_12"> <!-- Column -->
            <span style="text-align:right; float:right; font-weight:bold">Wait Days</span>
            </div> <!-- END Column -->
            <div class="col span_6_of_12"> <!-- Column -->
            <?php echo $payment_sched->wait_days; ?>
            </div> <!-- END Column -->
        </div> <!-- END ROW -->
        <div class="section group"> <!-- ROW -->
            <div class="col span_6_of_12"> <!-- Column -->
            <span style="text-align:right; float:right; font-weight:bold">Pay Method</span>
            </div> <!-- END Column -->
            <div class="col span_6_of_12"> <!-- Column -->
            <?php echo $payment_sched->pay_method; ?>
            </div> <!-- END Column -->
        </div> <!-- END ROW -->
        <div class="section group"> <!-- ROW -->
    <div class="col span_1_of_12"> <!-- Column -->
    &nbsp;
    </div> <!-- END Column -->
</div> <!-- END ROW -->
        <div class="section group"> <!-- ROW -->
            <div class="col span_2_of_12"> <!-- Column -->
    </div> <!-- END Column --> 
            <div class="col span_8_of_12"> <!-- Column -->
                <a href="javascript:void(0);" style="width:100%"  onclick="jQuery('#sched_payments_wiz').toggle();jQuery('#sched_pay_ins').toggle();"
    class="ui-button  icon_left_button button_link  ui-state-default ui-corner-all"  >
    <span class="ui-icon  ui-icon-calendar"></span> 
    Payday Scheduler Wizard (On/Off)</a><br />
            </div> <!-- END Column -->  
            <div class="col span_2_of_12"> <!-- Column -->
            </div> <!-- END Column -->     
       </div> <!-- END ROW -->        
    </div> <!-- END Column -->
    <div class="col span_8_of_12"> <!-- Column -->
    <div id="sched_pay_ins">
    <div class="ui-widget-content ui-corner-top" >
        <h2 style="text-align: center; margin-top: 5px; margin-bottom: 5px;">About the Payday Schedule</h2>
        </div>
        <div class="ui-widget ui-widget-content  ui-corner-bottom container" style="margin-bottom: 3px;" >
        <p>
       
<p><strong>Figuring our Payday</strong></p>

<p>Payday is a vastly important day for the people you will pay.  The Payday Scheduler will help you implement your payout policies.  There are three modes that AreteX will support:
</p>
<p><strong>In Sandbox Mode </strong>- In this configuration the only method allowed is "Manual."  This is because the automatic ACH Direct (Forte) connection is not yet available.  In the "Go Live" sequence, you will be given the opportunity to sign up for automatic Direct Deposit.  
    In Sandbox Mode the PayDay Scheduler allows you to set the pay date for payment.  A downloadable spreadsheet of payments due to payees is provided.  (<em>Reports &amp; Management / Payees / Manual Batch / Payments Due</em>)
</p>
<p><strong>In Live Mode</strong>
    <ul style="text-indent: -1.0em; margin-left: 1.5em; font-size: 12px;">
    	<li><strong>Without Forte</strong> - A downloadable payee spreadsheet is provided, as in Sandbox Mode.  Your Pay Method in the Payday Schedule should be set to Manual.  You may add Forte automatic payments later if you wish.  You can sign up now for this automated payout service. (<a target="_blank" href="https://aretexhome.com/AreteX/authorize/add_forte?license_key=<?php echo get_option('aretex_license_key'); ?>">click here</a> ).  This opens a new window.</li>
        <li>
    	<strong>With Forte</strong> - Using Direct Deposit, the schedule you set in the Payday Scheduler allows AreteX to automatically determine payments owed to payees, combine them into a batch format, and submit them to Forte for distribution.  
        As in the other Payday modes, full reporting is found in the <em>Payment Tracking and Reporting</em> (PTR) function.
        </li>
    </ul>
</p>

        </p>
        </div>
    </div>
    <div id="sched_payments_wiz" style="margin: 3px;">
    <?php include(plugin_dir_path(__FILE__).'sched_payments.php'); ?>
    </div>    
    <script>jQuery('#sched_payments_wiz').hide()</script>


    </div> <!-- END Column -->
</div> <!-- END ROW -->
</div>
</div>
<div id="tabs-2">

<h2>Payday Schedule Help</h2>


<p>Creating the payday schedule you wish to implement with AreteX is an important part of automating the timely availablility of downloadable spreadsheets, Direct Deposit payments, as well as enabling the reporting functions for yourself and your payees.
</p>
<p>The "Current Payday Schedule" is set up by using the Payday Scheduler Wizard.  You may change your current schedule at any time using this wizard.
</p>
<p><strong>Current Payday Schedule fields:</strong></p>
 <ul style="text-indent: -1.0em; margin-left: 1.5em; font-size: 12px;">
 <li>
   <strong>Frequency</strong> - This tells how often you plan to pay your people.  It can be Daily, Weekly, Semi-Monthly, or Monthly.
  </li><li>
   <strong>Pay Day</strong> - Depending on the Frequency of your payouts, this will let you set the day(s) of the month or week you plan on paying your people.
</li>
<li>
   <strong>Wait Days </strong>- AreteX allows you to build in "Wait Days" according to your business policies.  Wait Days take into account such things as waiting for credit card payments to clear, allowing for quick refunds, etc.  You can set the wait time to zero (0) if you wish.
</li>
<li>
   <strong>Pay Method</strong> - There are two basic methods of payout:
    <ul style="text-indent: -1.0em; margin-left: 1.5em; font-size: 12px;"> 
      <li><strong>Manual</strong> (found in Sandbox Mode and in Live Mode with no Forte account) and </li>
      <li><strong>Direct Deposit</strong> (only in Live Mode using Forte ACH Deposit).</li>
      
      </ul>
</li>
</ul>  


</div>
</div>
<script>
jQuery('.tabs').tabs();
</script>