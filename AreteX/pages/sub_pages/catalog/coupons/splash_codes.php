<?
    $splashcodes = AreteX_WPI::get_splash_codes();
    
    /*
    array(1) {
  ["Test 1"]=>
  array(2) {
    ["coupon_code"]=>
    string(18) "REG-00000-CARD-61D"
    ["summary"]=>
    array(8) {
      ["type"]=>
      string(6) "Access"
      ["description"]=>
      string(13) "Regular Price"
      ["amount"]=>
      string(6) "0.0000"
      ["applies_to"]=>
      string(15) "Entire Purchase"
      ["expires"]=>
      string(13) "No Time Limit"
      ["rep"]=>
      string(35) "No referrer for this tracking code."
      ["rep_id"]=>
      string(1) "0"
      ["commission_group_count"]=>
      int(0)
    }
  }
}
    */
    
function splash_code_list() {

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
    
$splashcodes = AreteX_WPI::get_splash_codes();
$splash_code_list = array();
foreach($splashcodes as $splash_code=>$data) {
    $splash_code_row = array();
    $splash_code_row['splash_code'] = $splash_code;
    $splash_code_row['coupon_code'] = $data['coupon_code'];
    $splash_code_row['description'] = $data['summary']['description'];
    $splash_code_row['expires'] = $data['summary']['expires'];
    $splash_code_row['applies_to'] = $data['summary']['applies_to'];
    $splash_code_row['referrer'] = $data['summary']['rep'];
    $splash_code_row['normalize_splash_code'] = $data['nomalized_mnemonic'];
    $splash_code_list[] = $splash_code_row;
    
}

//'ID'=>'id'
$headers = array('Splash Code'=>'splash_code','Standard Tracking Code'=>'coupon_code',
'Description'=>'description','Applies To'=>'applies_to','Expires'=>'expires','Referrer'=>'referrer');
        
       
        
        $action['function_name'] = "delete_splash_code";
        $action['icon_path'] = 'pages/sub_pages/images/actions/Delete.png';
        $action['parameters'] = array('[normalize_splash_code]');
        $action['title'] = 'Delete Splash Code ';
        
        $actions[] = $action;
               
        
        $str = AreteXDT::TableList($headers,$actions,$splash_code_list);
        $str .= <<<END_S
        <script>
            
            
            function delete_splash_code(normalize_splash_code) {
                if (confirm('Are you sure you want to delete this splash code?')) {
                    var data = {
                        action: 'atx_delete_splash_code',            
                        code: normalize_splash_code
                    }
                    jQuery.ajax({
                      type: 'POST',
                      url: ajaxurl,
                      data: data,
                      success: function(data){
                        alert('OK');
                        load_screen('catalog/coupons/splash_codes');                        
                      },
                      error: function(xhr, type, exception) { 
                        // if ajax fails display error alert
                        alert("Ajax error:  "+exception);
                      }
                    });

                }
            }
            
            jQuery( document ).tooltip();
            
        </script>
END_S;
        return $str; 
}    
?>

<div class="section group"> <!-- ROW -->
    <div class="col span_9_of_12"> <!-- Column -->
    
<div id="detail_screen">
<div class="ui-widget-content ui-corner-top" >
<h2 style="text-align: center; margin-top: 5px; margin-bottom: 5px;">Splash Codes</h2>
</div>
<div class="ui-widget ui-widget-content  ui-corner-bottom" >
<div class="DTTT_container_left" style="padding-right: 0px !important;">
</div>
<div>
<?php

echo splash_code_list();


?>
</div>
</div>
</div>




</div> <!-- END Column -->
    <div class="col span_3_of_12"> <!-- Column -->
    

<div id="commission_group_info" class="ui-widget ui-widget-content  ui-corner-all container dbui-frame" >

<label>Splash Codes</label>

<p><strong>Splash Codes</strong> are easy-to-remember tracking codes that you can "splash" all over your marketing material.</p>
<p>To create a <strong>Splash Code</strong> select <em><strong>Full Tracking</strong></em> and assign a Splash Code to a particular tracking code.</p>
</div>
    </div> <!-- END Column -->

</div> <!-- END ROW -->

