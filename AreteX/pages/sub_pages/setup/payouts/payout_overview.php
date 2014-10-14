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