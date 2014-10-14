<div id="deliverable_setup">
<strong>1. Select Deliverable</strong>&nbsp;<span id="step1_check"></span><br />
<div id="search_pd_cnt_list">
<?php
$aretex_core_path = get_option('aretex_core_path'); 
echo AreteX_paid_content::paid_content_selector(); 

?>
</div>
<form action="javascript::void(0);" id="pd_content_selector">
<div id="selected_deliverable" style="padding: 5px;">
<div class="section group"> <!-- ROW -->
    <div class="col span_1_of_4"> <!-- Column -->    
<strong>Code: </strong><input readonly="readonly" style="width: 40%;" value="" name="deliv_code" id="deliv_code" />
</div> <!-- END Column -->
<div class="col span_2_of_4"> <!-- Column --> 
<strong>Name:</strong><input readonly="readonly" style="width: 60%;" value="" name="deliv_name" id="deliv_name" />
</div> <!-- END Column -->
<div class="col span_1_of_4"> <!-- Column -->  
<button class="button" onclick="change_deliverable()">Change</button>
</div> <!-- END Column -->
</div> <!-- END ROW -->
</div>
<div id="deliverable_status">
<strong>2. Select Access Authorization Status</strong>&nbsp;<span id="step2_check"></span><br />
<span style="font-size: 11px;">Select the Status(es) to generate shortcodes for.</span><br />
<span style="font-size: 11px;">

<div class="section group"> <!-- ROW -->
    <div class="col span_1_of_6"> <!-- Column -->
    <input type="checkbox" id="loggedin" class="atx_stat_cbx" name="status[]" value="loggedin" />LoggedIn
    </div> <!-- END Column -->
    <div class="col span_1_of_6"> <!-- Column -->
    <input type="checkbox" id="nloggedin" class="atx_stat_cbx" name="status[]" value="!loggedin" />Not LoggedIn    
    </div> <!-- END Column -->
    <div class="col span_1_of_6"> <!-- Column -->
    <input type="checkbox" id="pending" class="atx_stat_cbx" name="status[]" value="pending" />Pending
    </div> <!-- END Column -->
    <div class="col span_1_of_6"> <!-- Column -->
    <input type="checkbox" id="authorized" class="atx_stat_cbx" name="status[]" value="authorized" />Authorized
    </div> <!-- END Column -->
    <div class="col span_1_of_6"> <!-- Column -->
    <input type="checkbox" id="expired" class="atx_stat_cbx" name="status[]" value="expired" />Expired
    </div> <!-- END Column -->
        <div class="col span_1_of_6"> <!-- Column -->
    <input type="checkbox" id="completed" class="atx_stat_cbx" name="status[]" value="completed" />Completed
    </div> <!-- END Column -->
</div> <!-- END ROW -->
<div class="section group"> <!-- ROW -->
    <div class="col span_1_of_6"> <!-- Column -->
    <input type="checkbox" id="notcompleted" class="atx_stat_cbx" name="status[]" value="!completed" />Not Completed
    </div> <!-- END Column --> 
    <div class="col span_3_of_6"> <!-- Column -->
    <input type="checkbox" id="authorized_or_completed" class="atx_stat_cbx" onclick="toggle_buy_button()" name="status[]" value="autorized|completed" />Authorized OR Completed
    </div> <!-- END Column -->
</div> <!-- END ROW -->
<div class="section group"> <!-- ROW -->
<div class="col span_1_of_6"> <!-- Column -->
    <input type="checkbox" id="not_auth" class="atx_stat_cbx" onclick="toggle_buy_button()" name="status[]" value="!authorized" />Not Authorized
    </div> <!-- END Column --> 
    <div class="col span_4_of_6"> <!-- Column -->
    <input type="checkbox" id="not_auth_not_pend" class="atx_stat_cbx" onclick="toggle_buy_button()" name="status[]" value="!pending&!authorized" />Not Pending AND Not Authorized
    </div> <!-- END Column -->
    <div class="col span_1_of_6"> <!-- Column -->
    <span id="buy1">
    <input type="checkbox" id="buyb" onclick="evaluate_buy_button();" name="buy_button" value="include_buy" />Embed Buy Button
    </span>    
    </div> <!-- END Column --> 
</div> <!-- END ROW -->
<div class="section group" id="explain_buy"> <!-- ROW -->
    <div class="col span_6_of_6"> <!-- Column -->
    <span style="font-size: 10px;">Not Authorized and/or Not Pending <em>probably</em> means you want them to buy the content. If so, select <em>Embed Buy Button</em>. </span>
    </div> <!-- END Column --> 
</div> <!-- END ROW -->

</span>
<div id="step_3" style="padding: 3px;"> 
    <div id="paste_button"> 
    <strong>3.Generate &amp; Paste The Shortcode to your Page</strong><br />  
        <button onclick="paste_short_codes()"  class="button">Generate &amp; Paste Shortcodes</button>
    </div>
    <div  id="sel_prod_button">
    <strong>3. Select the Product for your Buy Button</strong><br />      
        <button onclick="add_product();" class="button">Select Product for Buy</button><br />
        <span style="font-size: 10px;">(After you select your product you will be returned this screen to paste the shortcode.)</span>
    </div>
</div>
</div>
<div id="product_status">
<strong>3. Select the Product for your Buy Button</strong>&nbsp;<span id="step3_check"></span><br />
<div id="selected_product" style="padding: 5px;">
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
    <strong>4.Generate &amp; Paste The Shortcode to your Page</strong><br />  
        <button onclick="paste_short_codes()"  class="button">Generate &amp; Paste Shortcodes</button>
    </div> <!-- END Column -->
</div> <!-- END ROW -->
</div>
</div>

</form>
</div>
<div id="add_prod_div">
</div>
<script>
jQuery('.atx_stat_cbx').off('click');
jQuery('#selected_deliverable').hide();
jQuery('#deliverable_status').hide();
jQuery('#buy1').hide();
jQuery('#step_3').hide();
jQuery('#sel_prod_button').hide();
jQuery('#add_prod_div').hide();
jQuery('#explain_buy').hide();
jQuery('#product_status').hide();  

function change_deliverable(){
   jQuery('#search_pd_cnt_list').show();
   jQuery('#selected_deliverable').hide();
   jQuery('#step1_check').html('');
   jQuery('#deliverable_status').hide();  
}

function toggle_buy_button() {
    if (jQuery('#not_auth').is(':checked') || jQuery('#not_auth_not_pend').is(':checked') ) {
        jQuery('#buy1').show();
        jQuery('#explain_buy').show(); 
         
               
    }
    else {
        jQuery('#buy1').hide();
        jQuery('#explain_buy').hide();  
           
    }
}

function add_product() {
    jQuery('#deliverable_setup').hide();
    jQuery('#add_prod_div').show();
    load_product_selector();
    
}

function evaluate_buy_button() {
    if (jQuery('#buyb').is(':checked')) {
        jQuery('#sel_prod_button').show();
        jQuery('#paste_button').hide();        
    }
    else {
        jQuery('#sel_prod_button').hide();
        jQuery('#paste_button').show(); 
    }
    
}

function load_product_selector(){
    jQuery(function ($) {                
    	
        var path = 'editor_pages/product_selector';
        $('#add_prod_div').html('<p style="text-align:center;">...Please Wait...</p>');               
        var data = {
		action: 'load_screen',
        plugin: 'ecommerce-services',
        screen: path,
        deliverable: jQuery('#deliv_code').val()
	   };
        	
    	$.post(ajaxurl, data, function(response) {
    	   $('#add_prod_div').html(response);
    	});
        
    
    });  
}

function evaluate_checks()
{
    if (jQuery('.atx_stat_cbx').is(":checked"))
    {
        jQuery('#step_3').show(); 
        add_check('#step2_check');
    }
    else
    {
        jQuery('#step_3').hide();
        jQuery('#step2_check').html(''); 
    }
}

jQuery('.atx_stat_cbx').on('click',evaluate_checks);

function add_check(div_id) {
var img_src = '<?php echo plugins_url('AreteX/images/actions/checkmark_20.png',$aretex_core_path); ?>';
var img='<img src="'+img_src+'" />';
jQuery(div_id).html(img); 
}

function paste_short_codes(){
    jQuery(function ($) {                
    	
        var form_data = $('#pd_content_selector').serialize();
                          
        var data = {
		action: 'atx_paste_pdcnt_sc',
        data: form_data,
        
	   };
        	
    	$.post(ajaxurl, data, function(response) {
    	   $('#pd_content_selector')[0].reset();
           jQuery('#step1_check').html('');
           jQuery('#step2_check').html('');
           change_deliverable();
    	   window.send_to_editor(response);
    	});
        
    
    });  
}

</script>