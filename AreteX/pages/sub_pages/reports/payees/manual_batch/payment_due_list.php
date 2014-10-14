<h3>Payments Due (non-ACH)</h3>
<a href="javascript:void(0);"  onclick="load_div_screen('reports/payees/manual_batch/payment_now_due','#manual_batch_content');"
class="ui-button  icon_left_button button_link  ui-state-default ui-corner-all"  >
<span class="ui-icon  ui-icon-circle-arrow-w"></span> 
Back</a>
<hr />
<?php 
$search_criteria = array();
parse_str($_REQUEST['filter_key'],$search_criteria);
// var_dump($search_criteria);
/*
array(2) {
  ["duedate"]=>
  string(12) "Jun 18, 1962"
  ["payee_acct_id"]=>
  string(18) "TEMP_5387C9E4C307D"
}
*/
?>
<?php 
if (! empty($search_criteria['duedate'])) {
    echo "<strong>Due On or Before: </strong>".date('Y-m-d',strtotime($search_criteria['duedate']));    
}
else {
    echo "<strong>Due On or Before: </strong>".date('Y-m-d');    
}

if (! empty($search_criteria['payee_acct_id'])) {
    echo "   <strong>For Payee Account: </strong>". $search_criteria['payee_acct_id'];   
}
else {
    echo "  <strong>For All Payees </strong>";    
}

?>
<div class="section group"> <!-- ROW -->
    <div class="col span_8_of_12"> <!-- Column -->
<?php
    
    $url = get_option('aretex_bas_endpoint');
    $url .= '/api/pcs/out';
    if (! empty($search_criteria['duedate']))
         $url .= '/duedate/'.date('Y-m-d',strtotime($search_criteria['duedate']));
         
    if (! empty($search_criteria["payee_acct_id"]))
    {
        $url .= '?payment_account='.$search_criteria["payee_acct_id"];
    }
    
      
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
    
   
    
    $headers = array('Payee Account ID'=>'payee_account_identifier',
                     'Payee Name'=>'payee_name','Payee Email'=>'contact_email',
                     'Payment Due'=>'payment_due');
    
    $str = AreteXDT::TableList($headers,array(),$list);
?>
<a href="javascript:void(0);"  onclick="mark_paid();"
class="ui-button  icon_left_button button_link  ui-state-default ui-corner-all"  >
<span class="ui-icon  ui-icon-check"></span> 
Mark Paid</a>

<a href="javascript:void(0);"  onclick="get_payments_due_excel();"
style="float: right;"
class="ui-button  icon_left_button button_link  ui-state-default ui-corner-all"  >
<span class="ui-icon  ui-icon-document"></span> 
Excel</a>

<a href="javascript:void(0);"  onclick="get_payments_due_csv();"
style="float: right;"
class="ui-button  icon_left_button button_link  ui-state-default ui-corner-all"  >
<span class="ui-icon  ui-icon-document-b"></span> 
CSV</a>

<a href="javascript:void(0);"  style="float: right;" onclick="get_payments_due_prn();"
class="ui-button  icon_left_button button_link  ui-state-default ui-corner-all"  >
<span class="ui-icon  ui-icon-print"></span> 
Print</a>
<?php    
    
    echo $str;
    
  

?>
    </div> <!-- END Column -->
    <div class="col span_4_of_12"> <!-- Column -->

    <div class="ui-widget ui-widget-content  ui-corner-all container" >
    <p>Be sure to select <strong>Mark as Paid</strong> when appropriate.  This will allow 
    AreteX&trade; 
    to clear its listing of payments pending, as well as record payments made.  </p>
<p>
<em>Note of Caution</em>: Even if you filter your search for a specific payee(s), the entire list will be 
marked as paid, when you select that button. This is true regardless of your search filtering.</p>
    <p><strong><em>Note: </em></strong>Selecting <em>Print/CSV/Excel</em> to have a spreadsheet of paid batches will always result in the <em>entire list</em> available.  This is different from  other such choices in AreteX&trade;.  This spreadsheet function IS <strong>NOT</strong> filtered.</p>
    </div>
    </div> <!-- END Column -->
</div> <!-- END ROW -->

<iframe id="export_frame" width=0 height=0 frameBorder=0></iframe>

<script>
function get_payments_due_excel() {
    <?php
    
    $auth_token = AreteX_WPI::ajaxAccessToken('master');
    $xls_url = get_option('aretex_bas_endpoint');
    $xls_url .= '/api/pcs/out';
    
    if (! empty($search_criteria['duedate']))
         $xls_url .= '/duedate/'.date('Y-m-d',strtotime($search_criteria['duedate']));
    
    $xls_url .= '.xls';     
    $xls_url .= '?aretex_ajax_auth='.$auth_token;
    if (! empty($search_criteria["payee_acct_id"]))
    {
        $xls_url .= '&payment_account='.$search_criteria["payee_acct_id"];
    }                
    ?>
    var target_url = '<?php echo $xls_url; ?>';
    jQuery('#export_frame').attr('src',target_url);
    
    
    
}

function get_payments_due_csv() {
    <?php
    
    $auth_token = AreteX_WPI::ajaxAccessToken('master');
    $xls_url = get_option('aretex_bas_endpoint');
    $xls_url .= '/api/pcs/out';
    
    if (! empty($search_criteria['duedate']))
         $xls_url .= '/duedate/'.date('Y-m-d',strtotime($search_criteria['duedate']));
    
    $xls_url .= '.csv';     
    $xls_url .= '?aretex_ajax_auth='.$auth_token;
    if (! empty($search_criteria["payee_acct_id"]))
    {
        $xls_url .= '&payment_account='.$search_criteria["payee_acct_id"];
    }                
    ?>
    var target_url = '<?php echo $xls_url; ?>';
    jQuery('#export_frame').attr('src',target_url);
    
    
    
}

function mark_paid() {
    
    <?php 
    
    if (! empty($search_criteria['duedate']))
         $duedate = "'" .date('Y-m-d',strtotime($search_criteria['duedate'])). "'";
    else
        $duedate = 'null';
    
    if (! empty($search_criteria["payee_acct_id"]))
        $acct_id = "'{$search_criteria['payee_acct_id']}'";
    else
        $acct_id = 'null';
    
    ?>
    
    
    jQuery.ajax({
              type: 'POST',
              url: ajaxurl,
              async: false, 
              dataType: 'json',
              data: {
                action: 'atx_post_manual_payments',
                duedate: <?php echo $duedate; ?>,
                account_id: <?php echo $acct_id; ?>
              },
              success: function(result){
                
                if (result) {                    
                    load_linked_man_bat_screen_back('reports/payees/manual_batch/view_batch',
    result,'reports/payees/manual_batch/payment_due_list');
                    
                }
                else {
                    
                    alert('No Result');
                }
                
              }
              
            });
    
}

function get_payments_due_prn() {
    <?php
    
    $auth_token = AreteX_WPI::ajaxAccessToken('master');
    $xls_url = get_option('aretex_bas_endpoint');
    $xls_url .= '/api/pcs/out';
    
    if (! empty($search_criteria['duedate']))
         $xls_url .= '/duedate/'.date('Y-m-d',strtotime($search_criteria['duedate']));
    
    $xls_url .= '.prn';     
    $xls_url .= '?aretex_ajax_auth='.$auth_token;
    if (! empty($search_criteria["payee_acct_id"]))
    {
        $xls_url .= '&payment_account='.$search_criteria["payee_acct_id"];
    }                
    ?>
    var target_url = '<?php echo $xls_url; ?>';
    window.open(target_url);
    
    
    
}

</script>