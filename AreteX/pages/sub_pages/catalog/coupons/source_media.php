<h2>Source Media</h2>
<div class="section group"> <!-- ROW -->
    <div class="col span_8_of_12"> <!-- Column -->
        <div id="inner_form">
      <table cellpadding="0" cellspacing="0" border="0"  id="dt_53a897c670d2f">
	<thead>
		<tr>
			<th>Actions</th><th>Source ID</th><th>Description</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td colspan="5" class="dataTables_empty">Loading data from server</td>
		</tr>
	</tbody>
	<tfoot>
		<tr>
			<th>Actions</th><th>Source ID</th><th>Description</th>
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
        
        oTab_media_source_1 = init_datatable_resizeable(
        '<?php echo $ajax_url; ?>',
        'dt_53a897c670d2f','media_source_1',false,
        [{ "mDataProp":"Actions", "bSortable": false },{ "mDataProp": "source_id" },
         { "mDataProp": "description" }],'<? echo $access_token; ?>','catalog/coupons/source_media');
 oTableTst=oTab_media_source_1; 

add_column_filters(oTab_media_source_1,[null,{type: 'text' },{type: 'text' }]);

      set_auth_context('<?php echo $ajax_url; ?>','<?php echo $access_token; ?>','media_source_1','<?php echo plugins_url( '[slug]' , __FILE__ ); ?>');


add_std_buttons(oTab_media_source_1,'#dt_53a897c670d2f','media_source_1','<?php echo $ajax_url; ?>','<?php echo $access_token; ?>');



add_custom_buttons('#dt_53a897c670d2f','<div class="DTTT_container_left ui-buttonset ui-buttonset-multi"><a onclick="dbui_add_new_form(\'media_source_1\',\'<? echo $ajax_url; ?>\',\'#inner_form\',\'<? echo $access_token;  ?>\',\'catalog/coupons/source_media\')" class="DTTT_button ui-button ui-state-default DTTT_button_text"  ><span>Add</span></a></div>');

load_media_list_help();
       
      
      
         }); 
    });
    </script> 
    <iframe id="export_frame" width=0 height=0 frameBorder=0></iframe> 
    
    
    </div>
    </div> <!-- END Column -->
    <div class="col span_4_of_12"> <!-- Column -->
        <div id="coupon_help" class="ui-widget ui-widget-content  ui-corner-all container" >
        <strong>Offer Code ....</strong>
        <p>Make me an offer I can't refuse ...</p>
        </div>
    </div> <!-- END Column -->
</div> <!-- END ROW -->