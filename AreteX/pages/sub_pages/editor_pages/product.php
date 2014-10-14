<form id="product_selector_frm" action="javascript:void(0);">
<div id="product_selector">
<strong>1. Select Product to Present</strong><br />
<?php

$products = AreteX_WPI::getProducts('');
$product_list = json_decode(json_encode($products->products),true);

$aretex_core_path = get_option('aretex_core_path');
if (empty($aretex_core_path))
{              
    echo 'Error: AreteX core not installed';
    exit();
}
if (file_exists($aretex_core_path.'AreteXDT.class.php')) {
    require_once($aretex_core_path.'AreteXDT.class.php');
    
    
    $headers = array('Product Code'=>'code','Name'=>'name');
        
    $action['function_name'] = "use_product";
    $action['icon_path'] = 'images/actions/checkmark_20.png';
    $action['parameters'] = array('[code]','[name]');
    $action['title'] = 'Use this product';
    $actions[] = $action;
    
    
    $str = AreteXDT::TableList($headers,$actions,$product_list);
    $str .= <<<END_S

END_S;
    
    echo $str;
}

?>
</div>
<div id="product_selected">
<strong>1. Select Product to Present</strong><span id="step_1"></span><br />
<div class="section group"> <!-- ROW -->
    <div class="col span_1_of_4"> <!-- Column -->    
<strong>Code: </strong><input readonly="readonly" style="width: 40%;" value="" name="product_code" id="product_code" />
</div> <!-- END Column -->
<div class="col span_2_of_4"> <!-- Column --> 
<strong>Name:</strong><input readonly="readonly" style="width: 60%;" value="" name="product_name" id="product_name" />
</div> <!-- END Column -->
<div class="col span_1_of_4"> <!-- Column -->  
<button class="button" onclick="change_product()">Change</button>
</div> <!-- END Column -->
</div> <!-- END ROW -->
<div class="section group"> <!-- ROW -->
    <div class="col span_12_of_12"> <!-- Column -->
    <strong>2. Select Attributes to Show</strong><span id="step2_check"></span><br />
    <div class="section group"> <!-- ROW -->
    <div class="col span_1_of_4"> <!-- Column -->
    <input type="checkbox" id="code" class="atx_stat_cbx" name="attrs[]" value="code" />Product Code
    </div> <!-- END Column -->
    <div class="col span_1_of_4"> <!-- Column -->
    <input type="checkbox" id="name" class="atx_stat_cbx" name="attrs[]" value="name" />Product Name   
    </div> <!-- END Column -->
    <div class="col span_1_of_4"> <!-- Column -->
    <input type="checkbox" id="description" class="atx_stat_cbx" name="attrs[]" value="description" />Description
    </div> <!-- END Column -->
    <div class="col span_1_of_4"> <!-- Column -->
    <input type="checkbox" id="regular_price" class="atx_stat_cbx" name="attrs[]" value="regular_price" />Regular Price
    </div> <!-- END Column -->
</div> <!-- END ROW -->
 <div class="section group"> <!-- ROW -->   
    <div class="col span_1_of_4"> <!-- Column -->
    <input type="checkbox" id="current_price" class="atx_stat_cbx" name="attrs[]" value="current_price" />Current Price<br /><span style="font-size: 10px;">(Based on Current Offer)</span>
    </div> <!-- END Column -->
 
 
    <div class="col span_1_of_4"> <!-- Column -->
    <input type="checkbox" id="itemnote" class="atx_stat_cbx" name="attrs[]" value="itemnote" />Item Note
    </div> <!-- END Column -->
    
        <div class="col span_1_of_4"> <!-- Column -->
    <input type="checkbox" id="buybutton" class="atx_stat_cbx" name="buybutton" value="buybutton" /><strong>Buy Button</strong>
    </div> <!-- END Column -->
    
  <?php
  /*
    <div class="col span_1_of_4"> <!-- Column -->
    <input type="checkbox" id="terms_note" class="atx_stat_cbx" name="attrs[]" value="terms_note" />Terms Note
    </div> <!-- END Column -->
    */
 ?>
</div> <!-- END ROW -->
    
    </div> <!-- END Column -->
</div> <!-- END ROW -->
<div id="paste_button_row" class="section group"> <!-- ROW -->
    <div class="col span_12_of_12"> <!-- Column -->
    <strong>3.Generate &amp; Paste The Shortcode to your Page</strong><br />  
        <button onclick="paste_short_codes()"  class="button">Generate &amp; Paste Shortcodes</button><br />
        <span style="font-size: 10px;">After generating the shortcode, you should add your marketing/sales text around the selected attibutes to customize the product presentation to your liking.</span>
    </div> <!-- END Column -->
</div> <!-- END ROW -->

</div>
</form>
<script>
jQuery('#paste_button_row').hide();
jQuery('#product_selected').hide();

function evaluate_checks()
{
    if (jQuery('.atx_stat_cbx').is(":checked"))
    {
        jQuery('#paste_button_row').show(); 
        add_check('#step2_check');
    }
    else
    {
        jQuery('#paste_button_row').hide();
        jQuery('#step2_check').html(''); 
    }
}

jQuery('.atx_stat_cbx').on('click',evaluate_checks);


function use_product(code,name) {
    jQuery('#product_code').val(code);
    jQuery('#product_name').val(name);
    jQuery('#product_selector').hide();
    jQuery('#product_selected').show();
    add_check('#step_1');
           
}

function change_product() {
    jQuery('#step_1').html('');
    jQuery('#product_selector').show();
    jQuery('#product_selected').hide();
}

function add_check(div_id) {
var img_src = '<?php echo plugins_url('AreteX/images/actions/checkmark_20.png',$aretex_core_path); ?>';
var img='<img src="'+img_src+'" />';
jQuery(div_id).html(img); 
}

function paste_short_codes(){
    jQuery(function ($) {                
    	
        var form_data = $('#product_selector_frm').serialize();
                          
        var data = {
		action: 'atx_paste_prod_sc',
        data: form_data,
        
	   };
        	
    	$.post(ajaxurl, data, function(response) {
    	   $('#product_selector_frm')[0].reset();
           jQuery('#step1_check').html('');
           jQuery('#step2_check').html('');
           change_product();
    	   window.send_to_editor(response);
    	});
        
    
    });  
}


</script>