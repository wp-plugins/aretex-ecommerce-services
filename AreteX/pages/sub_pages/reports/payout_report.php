<div class="ui-widget ui-widget-content  ui-corner-all container"  style="padding-bottom: 12px;" >
<h2>Payout Report</h2>
<p>This is a report of all payouts. You may sort it or filter it.</p>

      <table cellpadding="0" cellspacing="0" border="0"  id="dt_53a6163565663">
	<thead>
		<tr>
			<th>Payee</th><th>Payment Type</th><th>Amount</th><th>Due Date</th><th>Payment Status</th><th>Submitted Date</th><th>Submission Code</th><th>Complete Date</th><th>Originating Transaction</th><th>Payment Transaction ID</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td colspan="5" class="dataTables_empty">Loading data from server</td>
		</tr>
	</tbody>
	<tfoot>
		<tr>
			<th>Payee</th><th>Payment Type</th><th>Amount</th><th>Due Date</th><th>Payment Status</th><th>Submitted Date</th><th>Submission Code</th><th>Complete Date</th><th>Originating Transaction</th><th>Payment Transaction ID</th>
		</tr>
	</tfoot>
    </table>
    <script>
    
     <?php $ajax_url = get_option('aretex_bas_endpoint');
            $ajax_url .= '/dbui/dbui_ajax_JSON.php';
               
            $access_token = AreteX_WPI::ajaxAccessToken(); 
            
          //  error_log("Ajax URL = $ajax_url\nAccess Token=$access_token");   
        ?>  
    
        var oTableTst;
    jQuery(function ($) {
    $(document).ready(function() {
       
        
        oTab_payout_report_1 = init_datatable_scroll_x_no_inner('<? echo $ajax_url; ?>','dt_53a6163565663',
        'payout_report_1',false,
        [{ "mDataProp": "payee_name" },{ "mDataProp": "payment_type" },{ "mDataProp": "payment_amount" },{ "mDataProp": "duedate" },{ "mDataProp": "payment_status" },{ "mDataProp": "submitted_date" },{ "mDataProp": "submission_code" },{ "mDataProp": "complete_date" },{ "mDataProp": "original_txn_id" },{ "mDataProp": "payment_txn_id" }],
        '<?php echo $access_token; ?>'
        );
 oTableTst=oTab_payout_report_1; 

add_column_filters(oTab_payout_report_1,[{type: 'text' },{type: 'text' },{type: 'number-range' },{type: 'date-range' },{type: 'text' },{type: 'date-range' },{type: 'text' },{type: 'date-range' },{type: 'text' },{type: 'text' }]);


add_std_buttons(oTab_payout_report_1,'#dt_53a6163565663','payout_report_1','<?php echo $ajax_url; ?>','<?php echo $access_token; ?>');





       
       $( document ).tooltip();   
      
     });
    });
    </script> 
    <iframe id="export_frame" width=0 height=0 frameBorder=0></iframe> 


</div>
