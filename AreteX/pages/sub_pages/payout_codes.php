<div id="inner_form">
      <table cellpadding="0" cellspacing="0" border="0"  id="dt_534daef5a47ae">
	<thead>
		<tr>
			<th>Actions</th><th>Payout Code</th><th>Payment Type</th><th>Amount</th><th>Paid On</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td colspan="5" class="dataTables_empty">Loading data from server</td>
		</tr>
	</tbody>
	<tfoot>
		<tr>
			<th>Actions</th><th>Payout Code</th><th>Payment Type</th><th>Amount</th><th>Paid On</th>
		</tr>
	</tfoot>
    </table>
    <script>
    var oTableTst;
      jQuery(function ($) {
            $(document).ready(function() {
            //    nav_min();  
         <?php 
         
            $ajax_url = get_option('aretex_bas_endpoint');
            $ajax_url .= '/dbui/dbui_ajax_JSON.php';
               
            $access_token = AreteX_WPI::ajaxAccessToken(); 
                  
        ?>      
                
       
        set_auth_context('<?php echo $ajax_url; ?>','<?php echo $access_token; ?>','payout_codes_1','<?php echo plugins_url( '[slug]' , __FILE__ ); ?>');
        
        oTab_payout_codes_1 = init_datatable_resizeable('<? echo $ajax_url; ?>','dt_534daef5a47ae','payout_codes_1',false,[{ "mDataProp":"Actions", "bSortable": false },{ "mDataProp": "payout_code" },{ "mDataProp": "payment_type" },{ "mDataProp": "amt" },{ "mDataProp": "paid_on" }],
        '<?php echo $access_token; ?>','payout_codes');

 oTableTst=oTab_payout_codes_1; 

add_column_filters(oTab_payout_codes_1,[null,{type: 'text' },{type: 'text' },{type: 'text' },{type: 'text' }]);


add_std_buttons(oTab_payout_codes_1,'#dt_534daef5a47ae','payout_codes_1','<? echo $ajax_url; ?>','<? echo $access_token; ?>');

$( document ).tooltip();



add_custom_buttons('#dt_534daef5a47ae','<div class="DTTT_container_left ui-buttonset ui-buttonset-multi"><a onclick="dbui_add_new_form(\'payout_codes_1\',\'<?  echo $ajax_url; ?>\',\'#inner_form\',\'<? echo $access_token;  ?>\',\'payout_codes\')" class="DTTT_button ui-button ui-state-default DTTT_button_text"  ><span>Add</span></a></div>');


       
      
      
     });
    });
    
      if (typeof load_list_help == 'function') { 
      load_list_help(); 
    }
    
    </script> 
    <iframe id="export_frame" width=0 height=0 frameBorder=0></iframe>
</div> 