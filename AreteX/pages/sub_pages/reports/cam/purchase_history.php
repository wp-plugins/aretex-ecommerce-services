<?php 

global $business_name;
global $customer_id;

if (empty($business_name)) {
    $license = AreteX_WPI::getBasLicense();
    $business_name = $license->Business_Name;
    
}

$biz = AreteX_WPI::getBusiness();


$customer_id  = $_REQUEST['linked_id'];;

 require_once(plugin_dir_path( __FILE__ ).'camlib.php');

 $obj = getResource('contact');
 
 $for = '';
 if (! empty($obj->business_name)) 
    $for = $obj->business_name.', ';
 $for = $obj->firstname . ' ' .$obj->lastname; 
 
 $history = getResource('purchase_history');
  if (! $history ) {
    echo '<p class="error" style="padding: 3px;>Error retrieving purchase history</p>';
    $history = array();
 }

?>

<div class="section group"> <!-- ROW -->
    <div class="col span_11_of_12"> <!-- Column -->
    <div class="ui-widget-header ui-corner-top" >
<h2 style="text-align: center; margin-top: 5px; margin-bottom: 5px;">Purchase History For: <?php echo $for; ?></h2>
</div>
<div class="ui-widget ui-widget-content  ui-corner-bottom container" >

<table id="purchase_hisotry_tbl">
<thead>
<tr> <th>Date</th><th>Transaction ID</th><th>Transaction Type</th><th>Status</th><th>Total</th><th>Receipt</th><th>Delivery Log</th></tr>
</thead>
<tbody>
<?php 
foreach($history as $obj)
{
    extract(get_object_vars($obj));
    $txn_date = date('F j, Y',strtotime($txn_date));
    $ajaxAccessToken = AreteX_WPI::ajaxAccessToken(null,true);
    $delivery_log_link = "load_linked_cam_page('reports/cam/delivery_log','$id')";
    
    $delivery_log = '<a href="javascript:void(0);"  onclick="'.$delivery_log_link.';" '.
                 'class="ui-button  icon_left_button button_link  ui-state-default ui-corner-all"  >'.
                 '<span class="ui-icon  ui-icon-search"></span>View</a>';
    
    $rct_button ='<a href="javascript:void(0);"  onclick="load_receipt'."('$receipt.jsonp?aretex_ajax_auth=$ajaxAccessToken&using_div=true');".';" '.
                 'class="ui-button  icon_left_button button_link  ui-state-default ui-corner-all"  >'.
                 '<span class="ui-icon  ui-icon-search"></span>View</a>';
    echo "<tr> <td>$txn_date</td><td>$txn_id</td><td>$txn_type</td><td>$status</td><td>$total</td> <td>$rct_button</td>  <td>$delivery_log</td></tr>";
}
?>
</tbody>
<tfoot></tfoot>
</table>
<script>



var oTable = jQuery('#purchase_hisotry_tbl').dataTable(
{
    
    "bJQueryUI": true,
    "sPaginationType": "full_numbers",                   
    "sDom": '<"H"RlCfr>t<"F"ip>',
    "oColVis": {
    "sSize": "css"
    }
                                                              
}
);


</script>
</div>

 </div> <!-- END Column -->
</div> <!-- END ROW -->


