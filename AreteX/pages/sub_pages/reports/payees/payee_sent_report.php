<?php 

$payee = AreteX_WPI::getAPayee($_REQUEST['filter_key']);
?>
<h2>Payee Management: Sent Payments: <?php echo $payee->name; ?></h2>
<div>
<a href="javascript:void(0);"   onclick="load_linked_screen('<?php echo $_REQUEST['back_screen'] ?>','<?php echo $_REQUEST['filter_key'] ?>');"

class="ui-button  icon_left_button button_link  ui-state-default ui-corner-all"  >
<span class="ui-icon  ui-icon-circle-arrow-w"></span> 
Back</a>
<br />
<hr />
</div>
<table cellpadding="0" cellspacing="0" border="0"  id="dt_53b354c37c18c">
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
 var oTableTst;
    jQuery(function ($) {
        $(document).ready(function() {
           
         
         <?php 
         
            $ajax_url = get_option('aretex_bas_endpoint');
            $ajax_url .= '/dbui/dbui_ajax_JSON.php';
               
            $access_token = AreteX_WPI::ajaxAccessToken(); 
                      
        ?>       
       
       
        
        oTab_payee_sent_pay_1 = init_datatable_scroll_x('<? echo $ajax_url; ?>','dt_53b354c37c18c',
        'payee_sent_pay_1','<?php echo $_REQUEST['filter_key']; ?>',
        [{ "mDataProp": "payee_name" },{ "mDataProp": "payment_type" },
        { "mDataProp": "payment_amount" },{ "mDataProp": "duedate" },
        { "mDataProp": "payment_status" },{ "mDataProp": "submitted_date" },
        { "mDataProp": "submission_code" },{ "mDataProp": "complete_date" },
        { "mDataProp": "original_txn_id" },{ "mDataProp": "payment_txn_id" }],
        '<?php echo $access_token; ?>','reports/payees/payee_management');
 oTableTst=oTab_payee_sent_pay_1; 

  add_column_filters(oTab_payee_sent_pay_1,[{type: 'text' },{type: 'text' },{type: 'number-range' },{type: 'date-range' },{type: 'text' },{type: 'date-range' },{type: 'text' },{type: 'date-range' },{type: 'text' },{type: 'text' }]);

  set_auth_context('<? echo $ajax_url; ?>','<? echo $access_token; ?>','payee_sent_pay_1','<? echo plugins_url( '[slug]' , __FILE__ ); ?>');


   add_std_buttons(oTab_payee_sent_pay_1,'#dt_53b354c37c18c','payee_sent_pay_1','<?php echo $ajax_url; ?>','<?php echo $access_token; ?>');


    $( document ).tooltip();  

       
      
      
     });
    });
    </script> 
    <iframe id="export_frame" width=0 height=0 frameBorder=0></iframe> 