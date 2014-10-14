 <form id="pcsout_setup_form">
 <div class="section group"> <!-- ROW -->
    <div class="col span_12_of_12"> <!-- Column -->
    <p>Your Forte account (Registered when you activated your "Live" AreteX licence) is set up for direct deposit. </p>
    </div> <!-- END Column -->
 </div> <!-- END ROW -->
 <div class="section group"> <!-- ROW -->
    <div class="col span_6_of_12"> <!-- Column -->
        <span style="text-align:right; float:right; font-weight:bold">Forte' Merchant Id</span>
    </div> <!-- END Column -->
    <div class="col span_6_of_12"> <!-- Column -->
        <? echo $pcs_out_settings->forte_merchant_id; ?>
    </div> <!-- END Column -->
</div> <!-- END ROW -->
<div class="section group"> <!-- ROW -->       
    <div class="col span_6_of_12"> <!-- Column -->    
    <span style="text-align:right; float:right; font-weight:bold">Enable Automatic Direct Deposit?</span>
    </div> <!-- END Column -->
    <div class="col span_1_of_12"> <!-- Column -->
    <?  if ($pcs_out_settings->use_ach_pcs_out == 'Yes') {
            $sel_yes = 'selected="selected"';
            $sel_no = '';
        }
        else {
            $sel_no = 'selected="selected"';
            $sel_yes = '';
        }
    ?>
    <select id="use_ach_pcs_out" name="use_ach_pcs_out">
        <option <? echo $sel_yes; ?>>Yes</option>
        <option <? echo $sel_no; ?>>No</option>
    </select>
    </div> <!-- END Column -->
    <div class="col span_5_of_12"> <!-- Column -->
       <span style="font-size: 80%;">
         <em>Note:</em> Selecting "No" will disable the automatic deposits. Payees will be unable to sign up for direct deposits. Payments you owe will be accrued.
      </span>  
    </div> <!-- END Column -->

  
</div> <!-- END ROW -->
<div class="section group"> <!-- ROW -->
    <div class="col span_12_of_12"> <!-- Column -->
    <h3 style="text-align: center;">Transaction Limits</h3>
    <p>If you enter the transaction limits Forte sent you, AreteX will enforce those limits. You will be notified if there is a need to exceed them.</p>
    </div> <!-- END Column -->
</div> <!-- END ROW -->
<div class="section group"> <!-- ROW -->
    <div class="col span_6_of_12"> <!-- Column -->
    <span style="text-align:right; float:right; font-weight:bold">Transaction Debit Limit</span>
    </div> <!-- END Column -->
    <div class="col span_6_of_12"> <!-- Column -->
    <input name="forte_txn_d_limit" id="forte_txn_d_limit" type="text" style="width: 25%;" value="<?php echo $pcs_out_settings->forte_txn_d_limit; ?>" />
    </div> <!-- END Column -->
</div> <!-- END ROW -->

<div class="section group"> <!-- ROW -->
    <div class="col span_6_of_12"> <!-- Column -->
    <span style="text-align:right; float:right; font-weight:bold">Transaction Credit Limit</span>
    </div> <!-- END Column -->
    <div class="col span_6_of_12"> <!-- Column -->
    <input name="forte_txn_c_limit" id="forte_txn_c_limit" type="text" style="width: 25%;" value="<?php echo $pcs_out_settings->forte_txn_c_limit; ?>"  />
    </div> <!-- END Column -->
</div> <!-- END ROW -->

<div class="section group"> <!-- ROW -->
    <div class="col span_6_of_12"> <!-- Column -->
    <span style="text-align:right; float:right; font-weight:bold">Daily Debit Limit</span>
    </div> <!-- END Column -->
    <div class="col span_6_of_12"> <!-- Column -->
    <input id="forte_daily_d_limit" name="forte_daily_d_limit" type="text" style="width: 25%;"  value="<?php echo $pcs_out_settings->forte_daily_d_limit; ?>" />
    </div> <!-- END Column -->
</div> <!-- END ROW -->
<div class="section group"> <!-- ROW -->
    <div class="col span_6_of_12"> <!-- Column -->
    <span style="text-align:right; float:right; font-weight:bold">Daily Credit Limit</span>
    </div> <!-- END Column -->
    <div class="col span_6_of_12"> <!-- Column -->
    <input type="text" style="width: 25%;" id="forte_daily_c_limit" name="forte_daily_c_limit" value="<?php echo $pcs_out_settings->forte_daily_c_limit; ?>" />
    </div> <!-- END Column -->
</div> <!-- END ROW -->

<div class="section group"> <!-- ROW -->
    <div class="col span_6_of_12"> <!-- Column -->
    <span style="text-align:right; float:right; font-weight:bold">Monthly Debit Limit</span>
    </div> <!-- END Column -->
    <div class="col span_6_of_12"> <!-- Column -->
    <input id="forte_monthly_d_limit" name="forte_monthly_d_limit"  type="text" style="width: 25%;" value="<?php echo $pcs_out_settings->forte_daily_c_limit; ?>" />
    </div> <!-- END Column -->
</div> <!-- END ROW -->
<div class="section group"> <!-- ROW -->
    <div class="col span_6_of_12"> <!-- Column -->
    <span style="text-align:right; float:right; font-weight:bold">Monthly Credit Limit</span>
    </div> <!-- END Column -->
    <div class="col span_6_of_12"> <!-- Column -->
    <input id="forte_monthly_c_limit" name="forte_monthly_c_limit" type="text" style="width: 25%;" value="<?php echo $pcs_out_settings->forte_monthly_c_limit; ?>" />
    </div> <!-- END Column -->
</div> <!-- END ROW -->
<a href="javascript:void(0);"  onclick="save_pcs_out();"
class="ui-button  icon_left_button button_link  ui-state-default ui-corner-all"  >
<span class="ui-icon  ui-icon-disk"></span> 
Save</a>
</form>
<script>
function save_pcs_out() {
    
    var data = jQuery('#pcsout_setup_form').serialize();
    alert(data);
    jQuery.ajax({
          type: 'POST',
          url: ajaxurl,
          async: false, 
          dataType: 'json',
          data: {
            action: 'atx_save_pcs_out',
            data: data
          },
          success: function(data){
            alert('Saved');
              
            
          },
           error: function(data){
            alert('Error');
              
            
          }
          
        });
}
</script>