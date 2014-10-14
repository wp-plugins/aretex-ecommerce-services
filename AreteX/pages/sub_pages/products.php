<div class="section group"> <!-- ROW -->
    <div id="left_product_column" class="col span_12_of_12"> <!-- Column -->

<div id="inner_form">
      <table cellpadding="0" cellspacing="0" border="0"  id="dt_535bd244770a2">
	<thead>
		<tr>
			<th>Actions</th><th>Product Code</th><th>Product Name</th><th>Pricing Model</th><th>Price</th><th>Delivery Code</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td colspan="5" class="dataTables_empty">Loading data from server</td>
		</tr>
	</tbody>
	<tfoot>
		<tr>
			<th>Actions</th><th>Product Code</th><th>Product Name</th><th>Pricing Model</th><th>Price</th><th>Delivery Code</th>
		</tr>
	</tfoot>
    </table>
</div>
    <script>
    var oTableTst;
    jQuery(function ($) {
            $(document).ready(function() {
            //    nav_min();  
         <?php 
         
            $ajax_url = get_option('aretex_bas_endpoint');
            $ajax_url .= '/dbui/dbui_ajax_JSON.php';               
            $access_token = AreteX_WPI::ajaxAccessToken(); 
            
          //  error_log("Ajax URL = $ajax_url\nAccess Token=$access_token");   
        ?>      
                
       
        set_auth_context('<? echo $ajax_url; ?>','<? echo $access_token; ?>','products_1','<? echo plugins_url( '[slug]' , __FILE__ ); ?>');
        
        
        oTab_products_1 = init_datatable_resizeable('<? echo $ajax_url; ?>','dt_535bd244770a2','products_1',false,[{ "mDataProp":"Actions", "bSortable": false },{ "mDataProp": "code" },{ "mDataProp": "name" },{ "mDataProp": "pricing_model" },{ "mDataProp": "price" },{ "mDataProp": "delivery_code" }],
         '<? echo $access_token; ?>','products');
 oTableTst=oTab_products_1; 

add_column_filters(oTab_products_1,[null,{type: 'text' },{type: 'text' },{type: 'text' },{type: 'text' },{type: 'text' }]);


add_std_buttons(oTab_products_1,'#dt_535bd244770a2','products_1','<? echo $ajax_url; ?>','<? echo $access_token; ?>');



add_custom_buttons('#dt_535bd244770a2','<div class="DTTT_container_left ui-buttonset ui-buttonset-multi"><a onclick="dbui_add_new_form(\'products_1\',\'<?  echo $ajax_url; ?>\',\'#inner_form\',\'<? echo $access_token;  ?>\',\'products\')" class="DTTT_button ui-button ui-state-default DTTT_button_text"  ><span>Add</span></a></div>');

$( document ).tooltip();
       
      
      
     });
    });
    </script> 
    <iframe id="export_frame" width=0 height=0 frameBorder=0></iframe> 
    </div> <!-- END Column -->
    <div id="right_product_column" class="col span_4_of_12"> <!-- Column -->
    <div  id="product_help_box" class="ui-widget ui-widget-content  ui-corner-all container" >
    </div>
    </div> <!-- END Column -->
</div> <!-- END ROW -->

<script>
jQuery('#right_product_column').hide();



</script>    