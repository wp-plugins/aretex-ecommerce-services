<?php 
 
 
 $commission_structure = AreteX_WPI::getBsuCommissionStructure($_REQUEST['filter_key']);
 $current_offer_limits = array();
 if (is_array($commission_structure['offer_limits'])){
    foreach($commission_structure['offer_limits'] as $limit){
       $current_offer_limits[] = $limit['offer_code']; 
    }
    
 }
 
 ?>


<div class="ui-widget-header ui-corner-top" >
<h2 style="text-align: center; margin-top: 5px; margin-bottom: 5px;">Commission Structure Details</h2>
</div>
<div class="ui-widget ui-widget-content  ui-corner-bottom dbui-frame" style="padding: 5px;" >
 <button onclick="load_div_screen('setup/payouts/commission_structures','#payout_content');"  class="button">Back</button>
<hr />
<form id="commission_structure_form">
<fieldset><legend>Commission Group Identity</legend>
<div class="section group"> <!-- ROW -->
    <div class="col span_3_of_12"> <!-- Column -->
    <label>Group Code</label>
    <input name="commission_group_code" type="text" readonly="readonly" value="<?php echo $commission_structure['commission_group']['commission_group_code']; ?> " />
    </div> <!-- END Column -->
    <div class="col span_9_of_12"> <!-- Column -->
    <label>Group Name</label>
    <input type="text" name="group_name" id="group_name" value="<?php echo $commission_structure['commission_group']['name']; ?> "/>
    </div> <!-- END Column -->
</div> <!-- END ROW -->
<div class="section group"> <!-- ROW -->
    <div class="col span_12_of_12"> <!-- Column -->
    <label>Description (optional)</label>
    <textarea id="description" name="description"><?php echo $commission_structure['commission_group']['description']; ?></textarea>
    </div> <!-- END Column -->
</div> <!-- END ROW -->
</fieldset>
<fieldset>
<legend>Commission Rates</legend>
<?php $rates = $commission_structure['commissions'];

 ?>
 <table id="commission_table">
 <thead>
 <tr><th>Level</th><th>Payment Type</th><th>% of Gross Sale</th></tr>
 </thead>
 <tbody>
 <?php
    $i = 0; 
    foreach($rates as $rate) {
        
        echo "<tr><td><input type=\"text\" readonly=\"readonly\" name=\"commissions[level][$i]\" value=\"{$rate['level']}\" /></td>
                  <td><input type=\"text\" class=\"required \"  name=\"commissions[type][$i]\" value=\"{$rate['type']}\" /></td> 
                  <td><input type=\"text\" class=\"required number\" min=\"0.01\" max=\"100\"   name=\"commissions[amount][$i]\" value=\"{$rate['amount']}\" /></td>
        ";
        ++$i;
    }
 ?>
 </tbody>
 </table>
 <hr />
 <a href="javascript:void(0);"  onclick="add_a_level();"
class="ui-button  icon_left_button button_link  ui-state-default ui-corner-all"  >
<span class="ui-icon  ui-icon-circle-plus"></span> 
Add a Level</a>

 <a href="javascript:void(0);"  onclick="remove_a_level();"
class="ui-button  icon_left_button button_link  ui-state-default ui-corner-all"  >
<span class="ui-icon  ui-icon-circle-minus"></span> 
Remove Last Level</a> 

</fieldset>
<div class="section group"> <!-- ROW -->
    <div class="col span_6_of_12"> <!-- Column -->    

<label>Offer Limits</label>
<?php 
    if (empty($current_offer_limits)) 
        $checked = 'checked="checked"';
    else
        $checked = '';
?>
<input style="display: inline; width: 30px;" id="unlimited_offers" onclick="offer_unlimited();" name="unlimited_offers" type="checkbox" <?php echo $checked; ?> value="unlimited_offers" /> No Limit on offers
         <br />
         <div style="overflow-x:scroll; width:98%; overflow: -moz-scrollbars-horizontal;">
         <select id="offer_limits" name="offer_limits[]" onclick="offer_limited();" multiple="multiple" size="6">
                
         <?php $offers = AreteX_WPI::getAllOffers();
            foreach($offers as $offer) {
                if (in_array($offer->offer_code,$current_offer_limits))
                    $selected = 'selected="selected"';
                else
                    $selected = '';
                echo "<option $selected class=\"offer_option\" value=\"{$offer->offer_code}\">({$offer->offer_code}) {$offer->offer_name}</option>";
            }

          ?>
          </select>
          </div>
          <br />
           
          <em>(Hold the Control or Shift key down to select multiple)  </em>
          <script>
            function offer_limited(){
               jQuery('#unlimited_offers').attr('checked', false); 
            }
            
            function offer_unlimited(){
                if (jQuery('#unlimited_offers').is(':checked')) {
                    jQuery(".offer_option").removeAttr("selected");
                }
            }
          </script>


</div> <!-- END Column -->
<div class="col span_6_of_12"> <!-- Column -->

<label>Shortcode</label>
<p>If you wish to put a signup form on your website (i.e., for <em>affiliates</em>) use this generated shortcode.</p>
<textarea readonly="readonly" class="sc_example">
[aretex_payee_signup commission_group="<?php echo $commission_structure['commission_group']['commission_group_code']; ?>"]<button type="button">Sign Up Now</button>[/aretex_payee_signup]
</textarea>
<p>Copy and paste the shortcode above, into your "Sign Up" page to create a form to allow people to sign up for this Commission Group.
(See <em>WP Integration / Shortcode &amp; Widget / Payee Registration</em> for more details.)
</p>

</div> <!-- END Column -->
</div> <!-- END ROW -->
<a href="javascript:void(0);"  onclick="save_commission_structure();"
class="ui-button  icon_left_button button_link  ui-state-default ui-corner-all"  >
<span class="ui-icon  ui-icon-circle-check"></span> 
Save</a>

<a href="javascript:void(0);"  onclick="load_div_screen('setup/payouts/commission_structures','#payout_content');" 
class="ui-button  icon_left_button button_link  ui-state-default ui-corner-all"  >
<span class="ui-icon  ui-icon-circle-close"></span> 
Cancel</a>
</form> 
</div>

 <script>
 jQuery('#commission_group_info').load('<?php echo plugins_url('cg_wiz_form_help/h1.html',__FILE__); ?>');        

function build_a_row()
{
    var rowCount = jQuery('#commission_table tr').length;
    var index = rowCount - 1;
    
    var html = '<tr><td><input type="text" name="commissions[level]['+index+']" readonly="readonly" value="'+rowCount+'" /></td>'+
            '<td><input type="text" class="required"  name="commissions[type]['+index+']" /></td>' +
            '<td><input type="text" class="required number" min="0.01" max="100"   name="commissions[amount]['+index+']" /></td>'+
            '</tr>';
    return html;
}

function add_a_level()
{
    var row = build_a_row();
    jQuery('#commission_table tr:last').after(row); 
}

function remove_a_level()
{
    var rowCount = jQuery('#commission_table tr').length;

    if (rowCount <= 2)
        alert('Cannot remove Level 1');
    else
        jQuery('#commission_table tr:last').remove();
}

function save_commission_structure()
{
    jQuery('#commission_structure_form').validate();
    if (jQuery('#commission_structure_form').valid())
    {
        var form_data = jQuery('#commission_structure_form').serialize();
        var data = {
            action: 'atx_save_commision_structure',
            data: form_data,
            code: '<?php echo $commission_structure['commission_group']['commission_group_code']; ?>'
        }
        jQuery.ajax({
          type: 'POST',
          url: ajaxurl,
          data: data,
          success: function(data){
            alert('OK');
            load_div_screen('setup/payouts/commission_structures','#payout_content');
          },
          error: function(xhr, type, exception) { 
            // if ajax fails display error alert
            alert("Ajax error:  "+exception);
          }
        });
    }
    
    
}

 </script>
 