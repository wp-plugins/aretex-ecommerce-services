<? 
/*

array(5) {
  ["action"]=>
  string(11) "load_screen"
  ["plugin"]=>
  string(18) "ecommerce-services"
  ["screen"]=>
  string(38) "reports/payees/manual_batch/view_batch"
  ["filter_key"]=>
  string(13) "53b6f430530ee"
  ["back_screen"]=>
  string(47) "reports/payees/manual_batch/batches_marked_paid"
}


*/


$filter_key = $_REQUEST['filter_key'];
$back_screen = $_REQUEST['back_screen'];


$url = get_option('aretex_bas_endpoint');
    $url .= '/api/pcs/out/batches/'.$filter_key;
    
    
     
    $list = AreteX_WPI::getGenericResourceByURI($url,false);
    $list = json_encode($list);
    $list = json_decode($list,true); 

$date = date('Y-m-d',strtotime($list[0]['batch_date'])); 


?>
<a href="javascript:void(0);"  onclick="load_man_bat_screen('<?php echo $back_screen; ?>','<?php echo $filter_key; ?>');"
class="ui-button  icon_left_button button_link  ui-state-default ui-corner-all"  >
<span class="ui-icon  ui-icon-circle-arrow-w"></span> 
Back</a>
<hr />
<h2>Viewing Batch: <?php echo $filter_key; ?>  - <?php echo $date; ?></h2>
<div class="section group"> <!-- ROW -->
    <div class="col span_8_of_12"> <!-- Column -->
<?php
       
    
    
    $aretex_core_path = get_option('aretex_core_path');
    if (empty($aretex_core_path))
    {              
        echo 'Error: AreteX core not installed';
        exit();
    }
    if (file_exists($aretex_core_path.'AreteXDT.class.php'))
    {
        require_once($aretex_core_path.'AreteXDT.class.php');
    }
    

    
    $headers = array('Payment Transaction ID' => 'payment_txn_id',
                     'Payee Account ID'=>'payee_account_identifier',
                     'Payee Name'=>'payee_name','Payee Email'=>'contact_email','Payment'=>'total_payment');

    
    
    $str = AreteXDT::TableListScrollX($headers,null,$list);
                  
?>

<a href="javascript:void(0);"  onclick="get_batches_excel();"
style="float: right;"
class="ui-button  icon_left_button button_link  ui-state-default ui-corner-all"  >
<span class="ui-icon  ui-icon-document"></span> 
Excel</a>

<a href="javascript:void(0);"  onclick="get_batches_csv();"
style="float: right;"
class="ui-button  icon_left_button button_link  ui-state-default ui-corner-all"  >
<span class="ui-icon  ui-icon-document-b"></span> 
CSV</a>

<a href="javascript:void(0);"  style="float: right;" onclick="get_batches_prn();"
class="ui-button  icon_left_button button_link  ui-state-default ui-corner-all"  >
<span class="ui-icon  ui-icon-print"></span> 
Print</a>
<?php    
    
    echo $str;

?>
</div> <!-- END Column -->
    <div class="col span_4_of_12"> <!-- Column -->

    <div class="ui-widget ui-widget-content  ui-corner-all container" >
        <p>This is a report of the batch payment you selected. </p> <p>  <strong><em>Note</em></strong>: Selecting Print/CSV/Excel to have a spreadsheet of paid batches will always result in the entire list available.  This is different from  other such choices in AreteX&trade;.  This spreadsheet function <strong>IS NOT</strong> filtered.</p>

    </div>
    </div> <!-- END Column -->
</div> <!-- END ROW -->

<iframe id="export_frame" width=0 height=0 frameBorder=0></iframe>

<script>
function get_batches_excel() {
    <?php
    
    $auth_token = AreteX_WPI::ajaxAccessToken('master');
    $xls_url = get_option('aretex_bas_endpoint');
    $xls_url .= '/api/pcs/out/batches/'.$filter_key.'.xls';
     
    $xls_url .= '?aretex_ajax_auth='.$auth_token;
    
    ?>
    var target_url = '<?php echo $xls_url; ?>';
    jQuery('#export_frame').attr('src',target_url);
    
    
    
}

function get_batches_csv() {
    <?php
    
    $auth_token = AreteX_WPI::ajaxAccessToken('master');
    $xls_url = get_option('aretex_bas_endpoint');
    $xls_url .= '/api/pcs/out/batches/'.$filter_key.'.csv';
    
      
    $xls_url .= '?aretex_ajax_auth='.$auth_token;
           
    ?>
    var target_url = '<?php echo $xls_url; ?>';
    jQuery('#export_frame').attr('src',target_url);
    
    
    
}

function get_batches_prn() {
    <?php
    
    $auth_token = AreteX_WPI::ajaxAccessToken('master');
    $xls_url = get_option('aretex_bas_endpoint');
    $xls_url .= '/api/pcs/out/batches/'.$filter_key.'.prn';
    
    $xls_url .= '?aretex_ajax_auth='.$auth_token;
                   
    ?>
    var target_url = '<?php echo $xls_url; ?>';
    window.open(target_url);
    
    
    
}

</script>