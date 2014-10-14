<?php 

global $business_name;
global $customer_id;

if (empty($business_name)) {
    $license = AreteX_WPI::getBasLicense();
    $business_name = $license->Business_Name;
    
}

$biz = AreteX_WPI::getBusiness();

if (empty($customer_id))
    $customer_id  = AreteX_WPI::customerSignedUp();

 require_once(plugin_dir_path( __FILE__ ).'camlib.php');

 $id = $_REQUEST['linked_id'];
 $log = getResource("purchase_history/$id/delivery_log"); 


?>
<div class="section group"> <!-- ROW -->
    <div class="col span_11_of_12"> <!-- Column -->

<div class="ui-widget-header ui-corner-top" >
<h2 style="text-align: center; margin-top: 5px; margin-bottom: 5px;">Payments, Authorizations and Transactions</h2>
</div>
<div class="ui-widget ui-widget-content  ui-corner-bottom" >

<a style="margin-left: 5px; margin-top: 3px;" href="javascript:void(0);" onclick="load_cam_page('purchase_history');"  
class="ui-button  icon_left_button button_link  ui-state-default ui-corner-all"  >
<span class="ui-icon  ui-icon-circle-arrow-w"></span> 
Back</a>

<hr />
<table id="log_tbl">
<thead>
<tr><th>Time</th><th>Product Code</th><th>Method</th><th>Result</th><th>Status</th><th>Detail</th></tr>
</thead>
<tbody>
<?php
    foreach($log as $entry)
    {
        $arr = get_object_vars ($entry);
        extract($arr);
        echo "<tr><td>$time</td><td>$product_code</td>".
        "<td>$method</td><td>$result</td><td>$status</td><td>$detail</td>".
        "</tr>";
    } 
?>
</tbody>
<tfoot></tfoot>
</table>
<script>


var oTable = jQuery('#log_tbl').dataTable(
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
</div> <!-- End Column -->
</div> <!-- End Row -->