<h2>Delivery Log</h2>

      <table cellpadding="0" cellspacing="0" border="0"  id="dt_53a6281f7bcea">
	<thead>
		<tr>
			<th>Attempt Time</th><th>Business Name</th><th>First Name</th><th>Last Name</th><th>Email Address</th><th>Transaction ID</th><th>Product Code</th><th>Method</th><th>Detail</th><th>Result</th><th>Status</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td colspan="5" class="dataTables_empty">Loading data from server</td>
		</tr>
	</tbody>
	<tfoot>
		<tr>
			<th>Attempt Time</th><th>Business Name</th><th>First Name</th><th>Last Name</th><th>Email Address</th><th>Transaction ID</th><th>Product Code</th><th>Method</th><th>Detail</th><th>Result</th><th>Status</th>
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
       
        
        oTab_delivery_log_1 = init_datatable_scroll_x(
        '<? echo $ajax_url; ?>',
        'dt_53a6281f7bcea','delivery_log_1',false,
        [{ "mDataProp": "Attempt_Time" },{ "mDataProp": "Business_Name" },{ "mDataProp": "First_Name" },
        { "mDataProp": "Last_Name" },{ "mDataProp": "Email_Address" },{ "mDataProp": "Transaction_Id" },
        { "mDataProp": "Product_Code" },{ "mDataProp": "Delivery_Method" },
        { "mDataProp": "Delivery_Detail" },{ "mDataProp": "Delivery_Result" },
        { "mDataProp": "Delivery_Status" }],'<?php echo $access_token; ?>');
 oTableTst=oTab_delivery_log_1; 

add_column_filters(oTab_delivery_log_1,[{type: 'date-range' },{type: 'text' },{type: 'text' },{type: 'text' },{type: 'text' },{type: 'text' },{type: 'text' },{type: 'text' },{type: 'text' },{type: 'text' },{type: 'text' }]);


add_std_buttons(oTab_delivery_log_1,'#dt_53a6281f7bcea','delivery_log_1','<?php echo $ajax_url; ?>','<?php echo $access_token; ?>');




       
       $( document ).tooltip();   
      
     });
    });
    </script>  
    <iframe id="export_frame" width=0 height=0 frameBorder=0></iframe> 




<script>
jQuery('.tabs').tabs();
</script>