<? 
    $detail = AreteX_WPI::getProductDetailByCode($_REQUEST['filter_key']);   
?>
<div class="section group"> <!-- ROW -->
    <div id="left_product_column" class="col span_8_of_12"> <!-- Column -->
<div id="inner_form">
<div class="ui-widget ui-widget-content  ui-corner-all container" >
<h4>Actual Contributor Payouts for <?php echo $detail->code.':'.$detail->name; ?></h4>

<?php 
        $ajax_url = get_option('aretex_bas_endpoint');
        $ajax_url .= '/dbui/dbui_ajax_JSON.php';
        
        $data_id = $_REQUEST['filter_key'];
           
        $access_token = AreteX_WPI::ajaxAccessToken();
        
        $back_code = "aretex_dbui_Edit('products_1','$ajax_url','#inner_form','$data_id','$access_token','products');"; 


?>

<a href="javascript:void(0);"  onclick="<?php echo $back_code; ?>" 
class="ui-button  icon_left_button button_link  ui-state-default ui-corner-all"  >
<span class="ui-icon  ui-icon-circle-arrow-w"></span> 
Back</a>
<hr />
<div id="inner_inner_form">
      <table cellpadding="0" cellspacing="0" border="0"  id="dt_535ed6248ec7d">
	<thead>
		<tr>
			<th>Actions</th><th>Payee</th><th>Payment Type</th><th>Amount</th><th>Paid On</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td colspan="5" class="dataTables_empty">Loading data from server</td>
		</tr>
	</tbody>
	<tfoot>
		<tr>
			<th>Actions</th><th>Payee</th><th>Payment Type</th><th>Amount</th><th>Paid On</th>
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
        
        oTab_product_payouts_1 = init_datatable_resizeable('<?php echo $ajax_url; ?>','dt_535ed6248ec7d','product_payouts_1','<?php echo $_REQUEST['filter_key']; ?>',[{ "mDataProp":"Actions", "bSortable": false },{ "mDataProp": "name" },{ "mDataProp": "payment_type" },{ "mDataProp": "amt" },{ "mDataProp": "paid_on" }],
        '<?php echo $access_token; ?>','payout_list' );
 oTableTst=oTab_product_payouts_1; 

set_auth_context('<? echo $ajax_url; ?>','<? echo $access_token; ?>','product_payouts_1','<? echo plugins_url( '[slug]' , __FILE__ ); ?>');

add_column_filters(oTab_product_payouts_1,[null,{type: 'text' },{type: 'text' },{type: 'text' },{type: 'text' }]);


add_std_buttons(oTab_product_payouts_1,'#dt_535ed6248ec7d','product_payouts_1','<?php echo $ajax_url; ?>','<?php echo $access_token; ?>');

  $( document ).tooltip();

add_custom_buttons('#dt_535ed6248ec7d','<div class="DTTT_container_left ui-buttonset ui-buttonset-multi"><a onclick="dbui_add_new_linked_form(\'product_payouts_1\',\'<?php echo $ajax_url; ?>\',\'#inner_inner_form\',\'<?php echo $access_token;  ?>\',\'payout_list\',\'<?php echo $_REQUEST['filter_key']; ?>\')" class="DTTT_button ui-button ui-state-default DTTT_button_text"  ><span>Add</span></a></div>');


       
      
      
     });
});
    </script> 
    <iframe id="export_frame" width=0 height=0 frameBorder=0></iframe> 
</div>
</div>
</div>

 </div> <!-- END Column -->
    <div id="right_product_column" class="col span_4_of_12"> <!-- Column -->
    <div  id="product_help_box" class="ui-widget ui-widget-content  ui-corner-all container" >
    </div>
    </div> <!-- END Column -->
</div> <!-- END ROW -->

<script>
show_product_help('payout_help/list_help');



</script>
