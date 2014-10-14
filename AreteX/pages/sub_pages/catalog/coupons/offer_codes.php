<h2>Offer Codes</h2>
<div class="section group"> <!-- ROW -->
    <div id="offer_code_main_box" class="col span_12_of_12"> <!-- Column -->
    <div id="inner_form">
          <table cellpadding="0" cellspacing="0" border="0"  id="dt_53a865ec615c7">
	<thead>
		<tr>
			<th>Actions</th><th>Offer Code</th><th>Description</th><th>Expiration Date</th><th>Offer Type</th><th>Amount</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td colspan="5" class="dataTables_empty">Loading data from server</td>
		</tr>
	</tbody>
	<tfoot>
		<tr>
			<th>Actions</th><th>Offer Code</th><th>Description</th><th>Expiration Date</th><th>Offer Type</th><th>Amount</th>
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
            
          
        ?>      
                
       
        set_auth_context('<? echo $ajax_url; ?>','<? echo $access_token; ?>','offer_codes_1','<? echo plugins_url( '[slug]' , __FILE__ ); ?>');

       
        
        oTab_offer_codes_1 = init_datatable_resizeable(
        '<? echo $ajax_url; ?>',
        'dt_53a865ec615c7','offer_codes_1',false,
        [{ "mDataProp":"Actions", "bSortable": false },{ "mDataProp": "code" },{ "mDataProp": "description" },{ "mDataProp": "expires" },{ "mDataProp": "coupon_type" },{ "mDataProp": "amount" }],
        '<? echo $access_token; ?>','catalog/coupons/offer_codes');
 oTableTst=oTab_offer_codes_1; 

add_column_filters(oTab_offer_codes_1,[null,{type: 'text' },{type: 'text' },{type: 'date-range' },{type: 'text' },{type: 'number-range' }]);


add_std_buttons(oTab_offer_codes_1,'#dt_53a865ec615c7','offer_codes_1','<? echo $ajax_url; ?>','<? echo $access_token; ?>');

$( document ).tooltip();

add_custom_buttons('#dt_53a865ec615c7','<div class="DTTT_container_left ui-buttonset ui-buttonset-multi"><a onclick="dbui_add_new_form(\'offer_codes_1\',\'<? echo $ajax_url; ?>\',\'#inner_form\',\'<? echo $access_token;  ?>\',\'catalog/coupons/offer_codes\')" class="DTTT_button ui-button ui-state-default DTTT_button_text"  ><span>Add</span></a></div>');

load_list_help();
       
      
      
         }); 
    });
    </script> 
    <iframe id="export_frame" width=0 height=0 frameBorder=0></iframe> 
    
    </div>
    </div> <!-- END Column -->
    <div id="offer_code_help_box" class="col span_4_of_12"> <!-- Column -->
        <div id="coupon_help" class="ui-widget ui-widget-content  ui-corner-all container" >
        <strong>Offer Code ....</strong>
        <p>Make me an offer I can't refuse ...</p>
        </div>
    </div> <!-- END Column -->
</div> <!-- END ROW -->
<script>
</script>