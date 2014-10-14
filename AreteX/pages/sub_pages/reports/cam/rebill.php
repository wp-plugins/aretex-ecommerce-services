<?php

global $business_name;
global $customer_id;

if (empty($business_name)) {
    $license = AreteX_WPI::getBasLicense();
    $business_name = $license->Business_Name;
    
}

$biz = AreteX_WPI::getBusiness();

$customer_id= $_REQUEST['linked_id'];

if (empty($customer_id))
    $customer_id  = AreteX_WPI::customerSignedUp();

 require_once(plugin_dir_path( __FILE__ ).'camlib.php');
 
 $obj = getResource('contact');
 
 $for = '';
 if (! empty($obj->business_name)) 
    $for = $obj->business_name.', ';
 $for = $obj->firstname . ' ' .$obj->lastname; 
 
 $rebill = getResource('rebill_agreement'); 
 if (! $rebill ) {
  //  echo '<p class="error" style="padding: 3px;>Error retrieving rebill information</p>';
    $rebill = array();
 }

?>
<div class="section group"> <!-- ROW -->
    <div class="col span_11_of_12"> <!-- Column -->


<div class="ui-widget-header ui-corner-top" >
<h2 style="text-align: center; margin-top: 5px; margin-bottom: 5px;">Rebill Agreements For: <?php echo $for; ?></h2>
</div>
<div class="ui-widget ui-widget-content  ui-corner-bottom" >
<p style="margin: 5px;">
Use the "<em>View</em>" button in the "<em>Details</em>" column to see the details of your customer's rebill authorization.  You will be able to <em><strong>cancel</strong> the subscription</em> or <em>view</em> the rebill payment history.</p>
<table id="customer_rebill_tbl">
<thead>
    <tr><th>Rebill ID</th><th>Billing Start Date</th><th>Product/Service</th><th>Status</th><th>Next Bill Due</th><th>Details</th></tr>
</thead>
<?php
foreach($rebill as $agreement)
{
    echo rebill_row($agreement);
}

?>
<tfoot>
</tfoot>
</table>

</div>

    </div> <!-- END Column -->
</div> <!-- END ROW -->

<?php
function rebill_row($obj)
{
    $id = $obj->rebill_id;
    $start_date = date('M d, Y',strtotime($obj->start_date));
    $prod = $obj->product_name;
    $status = $obj->status;
    $next_bill_due = $obj->next_bill_due;
    
    
    $str = "<tr><td>$id</td><td>$start_date</td><td>$prod</td><td>$status</td><td>$next_bill_due</td><td>" .
    '<a href="javascript:void(0);" onclick="'."view_rebill_detail('$id')".'" '.  
    '   class="ui-button  icon_left_button button_link  ui-state-default ui-corner-all"  > '.
    ' <span class="ui-icon  ui-icon-search"></span> View</a>'.
    "</td></tr>";
    
    return $str;
}
?>

<script>


var oTable = jQuery('#customer_rebill_tbl').dataTable(
{
    
    "bJQueryUI": true,
    "sPaginationType": "full_numbers",                   
    "sDom": '<"H"RlCfr>t<"F"ip>',
    "oColVis": {
    "sSize": "css"
    }
                                                              
}
);

function view_rebill_detail(id)
{

    load_linked_cam_page('reports/cam/rebill_detail',id);
    
}
</script>
