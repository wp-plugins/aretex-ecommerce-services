<h2>Overview</h2>
<h3>Wizards</h3>
<div style="padding-left: 20px;">
<p>We have provided two wizards to help you get a "quick and easy" win.  The setup provided in 
each of these wizards will help you understand the basic process involved in either a Paid 
Content product offering, or a Paid Membership/Subscription service.  Very simple setup 
processes ... minimal bells and whistles.</p>
</div>
<h3>Payouts</h3>
<div style="padding-left: 20px;">
<p>AreteX&trade; for WordPress supports two types of automated outbound (Direct Deposit) payments:</p>
<p><strong>Referrers:</strong> (Sales Reps, Affiliates, Distributors etc.) who are paid a commission on a sale for promoting your products and/or services.<br />
    <strong>Contributors:</strong> (Vendors, Authors, Instructors etc.) who are paid a royalties, fees, wholesale prices etc. when you sell a product or service they have provided or will provide.<br />
</p>
<p>Below is a summary of the curerent payout settings. See each menu tab for more details.</p>
<h4>Payout Setting Summary</h4>


<div class="section group"> <!-- ROW -->
    <div class="col span_4_of_12"> <!-- Column -->
    <span style="text-align:right; float:right; font-weight:bold">Current Payday Schedule:</span>
    </div> <!-- END Column -->
    <div class="col span_6_of_12"> <!-- Column -->
    <?php   $payment_sched = AreteX_WPI::getBsuPaymentSchedule(); echo $payment_sched->pay_frequency; ?>

    </div> <!-- END Column -->
</div> <!-- END ROW -->

 <div class="section group"> <!-- ROW -->
    <div class="col span_4_of_12"> <!-- Column -->
    <span style="text-align:right; float:right; font-weight:bold">Commission Structures:</span>
    </div> <!-- END Column -->
    <div class="col span_6_of_12"> <!-- Column -->
    <?php $commission_groups = AreteX_WPI::getBsuCommissionGroups(); ?>
 <strong><? echo count($commission_groups); ?></strong> - Currently Setup

    </div> <!-- END Column -->
</div> <!-- END ROW -->

 <div class="section group"> <!-- ROW -->
    <div class="col span_4_of_12"> <!-- Column -->
    <span style="text-align:right; float:right; font-weight:bold">Referrer Groups:</span>
    </div> <!-- END Column -->
    <div class="col span_6_of_12"> <!-- Column -->
    <?php  
    
    $summary = AreteX_WPI::getBsuCommissionSummary();
    $total_payees = $summary['payee_count'];
    $total_assigned = 0;
    if (is_array($summary['commission_groups'])) {
        foreach($summary['commission_groups'] as $group_summary) {
            $total_assigned += $group_summary['number_payees'];
        }
    }
    $payout_code_count = $summary['payout_code_count'];
    ?>
    <strong><?php  echo $total_assigned; ?></strong> - Referrers out of <strong><?php echo $total_payees; ?></strong> total Payees have been assigned to a Commission Group.
    </div> <!-- END Column -->
</div> <!-- END ROW -->

 <div class="section group"> <!-- ROW -->
    <div class="col span_4_of_12"> <!-- Column -->
    <span style="text-align:right; float:right; font-weight:bold">Contributor Payout Templates:</span>
    </div> <!-- END Column -->
    <div class="col span_6_of_12"> <!-- Column -->
    <strong><?php echo $payout_code_count; ?></strong> - Currently Setup
    </div> <!-- END Column -->
</div> <!-- END ROW -->

 <div class="section group"> <!-- ROW -->
    <div class="col span_4_of_12"> <!-- Column -->
    <span style="text-align:right; float:right; font-weight:bold">ACH (Direct Deposit) Setup:</span>
    </div> <!-- END Column -->
    <div class="col span_6_of_12"> <!-- Column -->
    <? $pcs_out_settings = AreteX_WPI::getBsuPcsOut();
       if ($pcs_out_settings->use_ach_pcs_out == 'Yes')
         $ach_setup = 'Yes';
       else
         $ach_setup = 'No'; 
    ?>
    <strong><?php echo $ach_setup; ?></strong>
    </div> <!-- END Column -->
</div> <!-- END ROW -->



</div>
<h3>Going Live</h3>
<div style="padding-left: 20px;">
<p>An overview of the Going Live process is provided.  A flow chart to follow your progress is included.</p>
</div>

