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
 
 $item = getResource('rebill_agreement/'.$_REQUEST['linked_id']);
 
 $detail = getResource('rebill_agreement/'.$_REQUEST['linked_id'].'/payments');
 
 
?>
<div class="section group"> <!-- ROW -->
    <div class="col span_11_of_12"> <!-- Column -->

<div class="ui-widget-header ui-corner-top" >
<h2 style="text-align: center; margin-top: 5px; margin-bottom: 5px;">Payments, Authorizations and Transactions</h2>
</div>
<div class="ui-widget ui-widget-content  ui-corner-bottom" >

<?php 


if ($item->initial_payment > 0)
    $initial_term = 'the initial payment of $'.number_format($item->initial_payment,2).'. ';
else  {
    if ($item->initial_period == 1)
        $days = 'day';
    else
        $days = 'days'; 
    $initial_term = "the initial trial period of {$item->initial_period} $days.";
}
    

?>
    
<a style="margin-left: 5px; margin-top: 3px;" href="javascript:void(0);" onclick="load_linked_cam_page('reports/cam/rebill_detail','<?php echo $_REQUEST['linked_id']; ?>');"  
class="ui-button  icon_left_button button_link  ui-state-default ui-corner-all"  >
<span class="ui-icon  ui-icon-circle-arrow-w"></span> 
Back</a> <span style="font-size: 85%">This is the purchase and payment history for: <?php echo $item->product_name;  ?>.
The transactions listed below are all payments <em>after</em> <?php echo $initial_term; ?> 
</span>   
<hr />
<table id="payment_history_tbl">
<thead>
<tr>
<th>Payment Number</th><th>Payment Status</th><th>Approval Code</th><th>Transaction Id</th><th>Transaction Date</th><th>Payment Due Date</th><th>Payment Amount</th>
</tr>
</thead>
<tbody>
<? 
$details = $detail;
    foreach($details as $detail)
    {
        extract(get_object_vars($detail));
        echo "<tr><td>$payment_number</td>";
        echo "<td>$payment_status</td>";
        echo "<td>$approval_code</td>";
        echo "<td>$txn_id</td>";
        echo "<td>$payment_date</td>";
        echo "<td>$bill_due_date</td>";
        if (empty($payment_amount))
            $payment_amount = '0.00';
        else
            $payment_amount = '$'.number_format($payment_amount,2);
        echo "<td>$payment_amount</td>";        
        echo "</tr>";
    }
?>
</tbody>
<tfoot></tfoot>
</table>
<script>


var oTable = jQuery('#payment_history_tbl').dataTable(
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