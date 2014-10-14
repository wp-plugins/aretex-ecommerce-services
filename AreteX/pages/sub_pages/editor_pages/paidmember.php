<?php
$aretex_core_path = get_option('aretex_core_path');
?>
<form id="paid_mem_selector" action="javascript:void(0);">
<strong>1. Select Membership Option</strong><span id="step_1"></span> <br />
<div class="section group"> <!-- ROW -->
    <div class="col span_12_of_12"> <!-- Column -->
        <select name="member_option" id="member_option" onchange="select_mem_option();">
        <option></option>
        <option value="reg_role">Paid Registration</option>
        <option value="role_only">Role Upgrade</option>
        </select>
  </div> <!-- END Column -->
</div> <!-- END ROW -->
<div id="product_selector">
<div id="sel_reg">
<strong>2. Select Membership Registration Product</strong><br />
<div class="section group"> <!-- ROW -->
    <div class="col span_12_of_12"> <!-- Column -->
    <input type="checkbox" id="allow_free_q" style="display: inline;" /> Allow Free Registration Option<br />
    </div> <!-- END Column -->
    
   
</div> <!-- END ROW -->
<?php 
     echo AreteX_paid_subscriptions::select_registration_products();
    
    
 ?> 

</div>
<div id="sel_role">
<strong>2. Select Membership Role Upgrade Product</strong><br />
<div class="section group"> <!-- ROW -->
<div class="col span_12_of_12"> <!-- Column -->
    <?php
        echo AreteX_paid_subscriptions::select_role_only_products();
    ?>
</div> <!-- END Column -->
</div> <!-- END ROW -->

</div>
</div>
<div id="product_selected">
<strong><span id="step_2_title">2. Select Membership Registration Product</span></strong><span id="step_2"></span><br />
<div id="allow_free_a_row" class="section group"> <!-- ROW -->
    <div class="col span_12_of_12"> <!-- Column -->
        <input type="checkbox" id="allow_free_a" readonly="readonly" onclick="return false" name="allow_free" value="allow_free" style="display: inline;" /> Allow Free Registration Option<br />
    </div> <!-- END Column -->
</div> <!-- END ROW -->
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
    <strong>3.Generate &amp; Paste The Shortcode to your Page</strong><br />  
        <button onclick="paste_short_codes()"  class="button">Generate &amp; Paste Shortcodes</button>
    </div> <!-- END Column -->
</div> <!-- END ROW -->

</div>
</form>

<script>
function add_check(div_id) {
    var img_src = '<?php echo plugins_url('AreteX/images/actions/checkmark_20.png',$aretex_core_path); ?>';
    var img='<img src="'+img_src+'" />';
    jQuery(div_id).html(img); 
}

 jQuery('#sel_reg').hide();
 jQuery('#sel_role').hide();
 jQuery('#product_selected').hide();

function select_mem_option() {
    var option = jQuery('#member_option').val();
    if (option)
    {
        jQuery('#product_selector').show();
        jQuery('#product_selected').hide();
        add_check('#step_1');
        if (option == 'reg_role') {
            jQuery('#sel_reg').show();
            jQuery('#sel_role').hide();
        }
        else {
             jQuery('#sel_reg').hide();
            jQuery('#sel_role').show();
        }
        
    }        
    else
    {
        jQuery('#step_1').html('');
        jQuery('#product_selector').hide();
        jQuery('#sel_reg').hide();
        jQuery('#sel_role').hide();
        jQuery('#product_selected').hide();
    }
        
    
}

function change_product() {
    select_mem_option();
}

function paste_short_codes(){
    jQuery(function ($) {                
    	
        var form_data = $('#paid_mem_selector').serialize();
                          
        var data = {
		action: 'atx_paste_pdmem_sc',
        data: form_data,
        
	   };
        	
    	$.post(ajaxurl, data, function(response) {
    	   $('#paid_mem_selector')[0].reset();
           jQuery('#step1_check').html('');
           jQuery('#step2_check').html('');
           change_product();
    	   window.send_to_editor(response);
    	});
        
    
    });  
}

</script>