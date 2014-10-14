<h2>ACH Report</h2>
<p style="padding: 5px;">This is a report of all ACH transactions.</p>
<div style="margin-bottom: 10px;">
      <table cellpadding="0" cellspacing="0" border="0"  id="dt_53b568e5c7c7c">
	<thead>
		<tr>
			<th>File Code</th><th>SEC</th><th>Batch Code</th><th>Transaction Code</th><th>Account Identifier</th><th>Amount</th><th>Credit / Debit</th><th>Memo</th><th>Batch Memo</th><th>Send Date</th><th>Status</th><th>Trace Code</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td colspan="5" class="dataTables_empty">Loading data from server</td>
		</tr>
	</tbody>
	<tfoot>
		<tr>
			<th>File Code</th><th>SEC</th><th>Batch Code</th><th>Transaction Code</th><th>Account Identifier</th><th>Amount</th><th>Credit / Debit</th><th>Memo</th><th>Batch Memo</th><th>Send Date</th><th>Status</th><th>Trace Code</th>
		</tr>
	</tfoot>
    </table>
    <script>
     var oTableTst;
    jQuery(function ($) {
        $(document).ready(function() {
           
         
         <?php 
         
            $ajax_url = get_option('aretex_bas_endpoint');
            $ajax_url .= '/dbui/dbui_ajax_JSON.php';
               
            $access_token = AreteX_WPI::ajaxAccessToken(); 
                      
        ?>       
       
        
        oTab_ach_rpt_1 = init_datatable_scroll_x(
        '<?php echo $ajax_url; ?>',
        'dt_53b568e5c7c7c','ach_rpt_1',false,
        [{ "mDataProp": "file_code" },{ "mDataProp": "sec" },{ "mDataProp": "batch_code" },
        { "mDataProp": "txn_code" },{ "mDataProp": "account_identifier" },{ "mDataProp": "amount" },
        { "mDataProp": "C_D" },{ "mDataProp": "memo" },{ "mDataProp": "batch_memo" },
        { "mDataProp": "send_date" },{ "mDataProp": "status" },{ "mDataProp": "tracecode" }],
        '<?php echo $access_token; ?>',''
        );
 oTableTst=oTab_ach_rpt_1; 

add_column_filters(oTab_ach_rpt_1,[{type: 'text' },{type: 'text' },{type: 'text' },{type: 'text' },{type: 'text' },{type: 'text' },{type: 'text' },{type: 'text' },{type: 'text' },{type: 'date-range' },{type: 'text' },{type: 'text' }]);


add_std_buttons(oTab_ach_rpt_1,'#dt_53b568e5c7c7c','ach_rpt_1','<?php echo $ajax_url; ?>','<?php echo $access_token; ?>');




       
      
      
     });
     
     });
    </script> 
    <iframe id="export_frame" width=0 height=0 frameBorder=0></iframe>
    </div> 