<h2>Delivery Authorizations</h2>
<div id="inner_form" style="padding-bottom: 10px;">
<p style="margin: 5px;">To manage a particular delivery authorization, click the Manage Delivery (<strong>clipboard</strong>) icon.</p>

      <table cellpadding="0" cellspacing="0" border="0"  id="dt_53eceef22d7f1">
	<thead>
		<tr>
			<th>Actions</th><th>Deliverable Code</th><th>Deliverable Name</th><th>First Name</th><th>Last Name</th><th>Email Address</th><th>Authorization Descriptor</th><th>Authorization Status</th><th>Status End Date</th><th>Payment Transaction #</th><th>Product Code</th><th>Product Name</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td colspan="5" class="dataTables_empty">Loading data from server</td>
		</tr>
	</tbody>
	<tfoot>
		<tr>
			<th>Actions</th><th>Deliverable Code</th><th>Deliverable Name</th><th>First Name</th><th>Last Name</th><th>Email Address</th><th>Authorization Descriptor</th><th>Authorization Status</th><th>Authorization Status</th><th>Payment Transaction #</th><th>Product Code</th><th>Product Name</th>
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
       
        
        oTab_authorizations_list_view_1 = init_datatable_scroll_x_no_inner(
        '<?php echo $ajax_url; ?>',
        'dt_53eceef22d7f1','authorizations_list_view_1',false,[{ "mDataProp":"Actions", "bSortable": false },{ "mDataProp": "deliverable_code" },{ "mDataProp": "delivery_name" },{ "mDataProp": "firstname" },{ "mDataProp": "lastname" },{ "mDataProp": "email_address" },{ "mDataProp": "descriptor" },{ "mDataProp": "authorization_status" },{ "mDataProp": "expiration_date" },{ "mDataProp": "txn_number" },{ "mDataProp": "product_code" },{ "mDataProp": "product_name" }],
        '<?php echo $access_token; ?>');
 oTableTst=oTab_authorizations_list_view_1; 

add_column_filters(oTab_authorizations_list_view_1,[null,{type: 'text' },{type: 'text' },{type: 'text' },{type: 'text' },{type: 'text' },{type: 'text' },{type: 'text' },{type: 'date-range' },{type: 'text' },{type: 'text' },{type: 'text' }]);


add_std_buttons(oTab_authorizations_list_view_1,'#dt_53eceef22d7f1','authorizations_list_view_1','<?php echo $ajax_url; ?>','<?php echo $access_token; ?>');





       
      
      
     });
});     
    </script> 
    <iframe id="export_frame" width=0 height=0 frameBorder=0></iframe>
</div> 