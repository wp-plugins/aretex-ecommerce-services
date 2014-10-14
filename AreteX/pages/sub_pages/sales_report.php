<div class="ui-widget ui-widget-content  ui-corner-all container" >
<p>This is a report of all sales.  You may <em>sort</em> or <em>filter</em> the listing with the <em>search box</em>, as well as with the <em>Show/Hide Columns</em> button.</p>
<p>
Click the <em>Receipt</em> <strong>($)</strong> icon to view the receipt.  To <em>Refund</em> your customer, click the <strong>bill/arrow</strong> icon.
</p>
</div>
      <table cellpadding="0" cellspacing="0" border="0"  id="dt_52f3ec327908b">
	<thead>
		<tr>
			<th>Actions</th><th>Date</th><th>Total Amount</th><th>Transaction Type</th><th>Transaction ID</th><th>First Name</th><th>Last Name</th><th>Email Address</th><th>Tracking Code Used</th><th>Offer Code</th><th>Media Source</th><th>Referrer Payee ID</th><th>Transaction Status</th><th>Total Contributor Payments</th><th>Total Commissions</th><th>Original Transaction ID</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td colspan="5" class="dataTables_empty">Loading data from server</td>
		</tr>
	</tbody>
	<tfoot>
		<tr>
			<th>Actions</th><th>Date</th><th>Total Amount</th><th>Transaction Type</th><th>Transaction ID</th><th>First Name</th><th>Last Name</th><th>Email Address</th><th>Tracking Code Used</th><th>Offer Code</th><th>Media Source</th><th>Referrer Payee ID</th><th>Transaction Status</th><th>Total Contributor Payments</th><th>Total Commissions</th><th>Original Transaction ID</th>
		</tr>
	</tfoot>
    </table>    
 <script>
    var oTableTst;
    jQuery(function ($) {
        $(document).ready(function() {
           
         
         <?php $ajax_url = get_option('aretex_bas_endpoint');
            $ajax_url .= '/dbui/dbui_ajax_JSON.php';
               
            $access_token = AreteX_WPI::ajaxAccessToken(); 
            
          //  error_log("Ajax URL = $ajax_url\nAccess Token=$access_token");   
        ?>       
        
        oTab_sales_report_view_1 = init_datatable_scroll_x_no_inner('<?php echo $ajax_url; ?>','dt_52f3ec327908b','sales_report_view_1',false,
[{ "mDataProp":"Actions", "bSortable": false },{ "mDataProp": "creation_date" },
        { "mDataProp": "gross" },{ "mDataProp": "txn_type" },{ "mDataProp": "processor_txn_id" },
        { "mDataProp": "firstname" },{ "mDataProp": "lastname" },{ "mDataProp": "email_address" },
        { "mDataProp": "coupon_codes" },{ "mDataProp": "offer_code" },{ "mDataProp": "tracking_code" },
        { "mDataProp": "submitter" },{ "mDataProp": "txn_status" },{ "mDataProp": "total_royalties" },
        { "mDataProp": "total_commissions" },{ "mDataProp": "original_txn_id" }],        
         '<?php echo $access_token; ?>');
 oTableTst=oTab_sales_report_view_1; 

add_column_filters(oTab_sales_report_view_1,[null,{type: 'date-range' },{type: 'number-range' },{type: 'text' },{type: 'text' },{type: 'text' },{type: 'text' },{type: 'text' },{type: 'text' },{type: 'text' },{type: 'text' },{type: 'number-range' },{type: 'text' },{type: 'number-range' },{type: 'number-range' },{type: 'text' }]);


add_std_buttons(oTab_sales_report_view_1,'#dt_52f3ec327908b','sales_report_view_1','<?php echo $ajax_url; ?>','<?php echo $access_token; ?>');

    $( document ).tooltip();
       
      
      
     });
});
    </script> 
    <iframe id="export_frame" width=0 height=0 frameBorder=0></iframe> 