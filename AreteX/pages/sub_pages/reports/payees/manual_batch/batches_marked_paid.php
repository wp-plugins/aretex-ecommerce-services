<h2>Batches Marked Paid</h2>
<div class="section group"> <!-- ROW -->
    <div class="col span_8_of_12"> <!-- Column -->
<?php
       
    $url = get_option('aretex_bas_endpoint');
    $url .= '/api/pcs/out/batches';
    
    
     
    $list = AreteX_WPI::getGenericResourceByURI($url,false);
    $list = json_encode($list);
    $list = json_decode($list,true);   
    
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
    
    
    
    $headers = array('Batch Code'=>'batch_code',
                     'Batch Date'=>'batch_date','Total Payments'=>'total_payment');

    
    $action['function_name'] = "view_batch";
    $action['icon_path'] = 'pages/sub_pages/images/actions/View.png';
    $action['parameters'] = array('[batch_code]');
    $action['title'] = 'View Batch ';
    
    $actions[] = $action;

    
    $str = AreteXDT::TableList($headers,$actions,$list);
                  
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
    <p>This is a listing of all <em>batch payments</em> you have made.  You may view the details 
    of each batch by selecting the <em>View</em> (<strong>magnifying glass</strong>) icon.</p><p>  <strong><em>Note</em></strong>: Selecting Print/CSV/Excel to have a spreadsheet of paid batches will always result in the entire list available.  This is different from  other such choices in AreteX&trade;.  This spreadsheet function <strong>IS NOT</strong> filtered.</p>
    </div>
    </div> <!-- END Column -->
</div> <!-- END ROW -->

<iframe id="export_frame" width=0 height=0 frameBorder=0></iframe>

<script>
function get_batches_excel() {
    <?php
    
    $auth_token = AreteX_WPI::ajaxAccessToken('master');
    $xls_url = get_option('aretex_bas_endpoint');
    $xls_url .= '/api/pcs/out/batches.xls';
     
    $xls_url .= '?aretex_ajax_auth='.$auth_token;
    
    ?>
    var target_url = '<?php echo $xls_url; ?>';
    jQuery('#export_frame').attr('src',target_url);
    
    
    
}

function get_batches_csv() {
    <?php
    
    $auth_token = AreteX_WPI::ajaxAccessToken('master');
    $xls_url = get_option('aretex_bas_endpoint');
    $xls_url .= '/api/pcs/out/batches.csv';
    
      
    $xls_url .= '?aretex_ajax_auth='.$auth_token;
           
    ?>
    var target_url = '<?php echo $xls_url; ?>';
    jQuery('#export_frame').attr('src',target_url);
    
    
    
}

function get_batches_prn() {
    <?php
    
    $auth_token = AreteX_WPI::ajaxAccessToken('master');
    $xls_url = get_option('aretex_bas_endpoint');
    $xls_url .= '/api/pcs/out/batches.prn';
    
    $xls_url .= '?aretex_ajax_auth='.$auth_token;
                   
    ?>
    var target_url = '<?php echo $xls_url; ?>';
    window.open(target_url);
    
    
    
}

</script>
