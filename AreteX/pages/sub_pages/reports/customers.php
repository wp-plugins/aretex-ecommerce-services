<h2>Customer Management</h2>
<div id="inner_form">
<p style="margin: 5px;">To manage individual customers, click the appropriate manage (<strong>handshake</strong>) icon under the Action column.</p>
<p>
(<em>Note: </em> To turn on the ability of your <em>customers</em> to access their CAM, go to <em>WP Integration / Form Customization / Receipts and Customer Accounts / Welcome Account Access</em>.)
</p>
      <table cellpadding="0" cellspacing="0" border="0"  id="dt_53ab22849c756">
	<thead>
		<tr>
			<th>Actions</th><th>Customer ID</th><th>First Name</th><th>Last Name</th><th>Email Address</th><th>WP User Name</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td colspan="5" class="dataTables_empty">Loading data from server</td>
		</tr>
	</tbody>
	<tfoot>
		<tr>
			<th>Actions</th><th>Customer ID</th><th>First Name</th><th>Last Name</th><th>Email Address</th><th>WP User Name</th>
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
        
       
        
        oTab_wp_customer_list_view_1 = init_datatable_resizeable(
        '<?php echo $ajax_url; ?>'
        ,'dt_53ab22849c756','wp_customer_list_view_1',false,
        [{ "mDataProp":"Actions", "bSortable": false },{ "mDataProp": "id" },{ "mDataProp": "firstname" },{ "mDataProp": "lastname" },{ "mDataProp": "email_address" },{ "mDataProp": "wp_user_name" }],
        '<?php echo $access_token; ?>');
        
        oTableTst=oTab_wp_customer_list_view_1; 
        
        add_column_filters(oTab_wp_customer_list_view_1,[null,{type: 'text' },{type: 'text' },{type: 'text' },{type: 'text' },{type: 'text' }]);
 
        add_std_buttons(oTab_wp_customer_list_view_1,'#dt_53ab22849c756','wp_customer_list_view_1','<?php echo $ajax_url; ?>','<?php echo $access_token; ?>');



   $( document ).tooltip();

       
      
      
     });
     
});



    </script> 
    <iframe id="export_frame" width=0 height=0 frameBorder=0></iframe> 

</div>



<script>
jQuery('.tabs').tabs();
</script>
