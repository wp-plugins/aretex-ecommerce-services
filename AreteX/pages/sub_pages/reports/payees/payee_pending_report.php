<?php 

$payee = AreteX_WPI::getAPayee($_REQUEST['filter_key']);
?>
<h2>Payee Management: Pending Payments: <?php echo $payee->name; ?></h2>
<div>
<a href="javascript:void(0);"   onclick="load_linked_screen('reports/payees/payee_management','<?php echo $_REQUEST['filter_key'] ?>');"

class="ui-button  icon_left_button button_link  ui-state-default ui-corner-all"  >
<span class="ui-icon  ui-icon-circle-arrow-w"></span> 
Back</a>
<br />
<hr />
</div>
<div class="section group"> <!-- ROW -->
    <div id="pending_report_main_div" class="col span_12_of_12"> <!-- Column -->
 <div id="inner_form">
      <table cellpadding="0" cellspacing="0" border="0"  id="dt_53b42c2f32259">
	<thead>
		<tr>
			<th>Actions</th><th>Payee</th><th>Payment Type</th><th>Amount</th><th>Due Date</th><th>Payment Status</th><th>Submitted Date</th><th>Submission Code</th><th>Complete Date</th><th>Originating Transaction</th><th>Payment Transaction ID</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td colspan="5" class="dataTables_empty">Loading data from server</td>
		</tr>
	</tbody>
	<tfoot>
		<tr>
			<th>Actions</th><th>Payee</th><th>Payment Type</th><th>Amount</th><th>Due Date</th><th>Payment Status</th><th>Submitted Date</th><th>Submission Code</th><th>Complete Date</th><th>Originating Transaction</th><th>Payment Transaction ID</th>
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
  
        oTab_payee_pending_pay_1 = init_datatable_scroll_x('<? echo $ajax_url; ?>','dt_53b42c2f32259','payee_pending_pay_1',
        '<?php echo $_REQUEST['filter_key']; ?>',
        [{ "mDataProp":"Actions", "bSortable": false },{ "mDataProp": "payee_name" },
         { "mDataProp": "payment_type" },{ "mDataProp": "payment_amount" },{ "mDataProp": "duedate" },
         { "mDataProp": "payment_status" },{ "mDataProp": "submitted_date" },{ "mDataProp": "submission_code" },
         { "mDataProp": "complete_date" },{ "mDataProp": "original_txn_id" },{ "mDataProp": "payment_txn_id" }],
          '<?php echo $access_token; ?>','reports/payees/payee_pending_report');
          
 oTableTst=oTab_payee_pending_pay_1; 

add_column_filters(oTab_payee_pending_pay_1,[null,{type: 'text' },{type: 'text' },{type: 'number-range' },{type: 'date-range' },{type: 'text' },{type: 'date-range' },{type: 'text' },{type: 'date-range' },{type: 'text' },{type: 'text' }]);

set_auth_context('<? echo $ajax_url; ?>','<? echo $access_token; ?>','payee_pending_pay_1','<? echo plugins_url( '[slug]' , __FILE__ ); ?>');

add_std_buttons(oTab_payee_pending_pay_1,'#dt_53b42c2f32259','payee_pending_pay_1','<?php echo $ajax_url; ?>','<?php echo $access_token; ?>');

add_custom_buttons('#dt_53b42c2f32259','<div class="DTTT_container_left ui-buttonset ui-buttonset-multi"><a onclick="dbui_add_new_payment_form(\'payee_pending_pay_1\',\'<?php echo $ajax_url; ?>\',\'#inner_form\',\'<?php echo $access_token;  ?>\',\'reports/payees/payee_pending_report\')" class="DTTT_button ui-button ui-state-default DTTT_button_text"  ><span>Add</span></a></div>');
    
          $( document ).tooltip();      
       
 
      
        });
    });
    </script> 
    <iframe id="export_frame" width=0 height=0 frameBorder=0></iframe>
    <input type="hidden" id="filter_key" value="<?php echo $_REQUEST['filter_key'] ?>" />
    </div>
    </div> <!-- END Column -->
    <div id="pending_report_help_div" class="col span_4_of_12"> <!-- Column -->
        <div class="ui-widget ui-widget-content  ui-corner-all container" >
        <p>This Payment Detail screen allows you to edit most fields.  This will allow you to change the <em>type of payment</em> you are sending, the <em>amount</em>, the associated <em>dates</em> of payment, as well as making <em>notes</em> about any changes you make.  This could be very beneficial in regards to <em>refunds</em>.</p>
        </div>
   </div> <!-- END Column -->
</div> <!-- END ROW -->
<script>
jQuery('#pending_report_help_div').hide();
</script>
     