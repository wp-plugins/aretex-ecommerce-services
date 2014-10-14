<?php 
 
 
 $commission_structure = AreteX_WPI::getBsuCommissionStructure($_REQUEST['filter_key']);
 $current_offer_limits = array();
 if (is_array($commission_structure['offer_limits'])){
    foreach($commission_structure['offer_limits'] as $limit){
       $current_offer_limits[] = $limit['offer_code']; 
    }
    
 }
 
 $usage_summary = AreteX_WPI::getBsuCommissionSummary();
 /*
 
 array(2) {
  ["commission_groups"]=>
  array(1) {
    [0]=>
    array(2) {
      ["commission_group_code"]=>
      string(4) "TES2"
      ["number_payees"]=>
      string(1) "0"
    }
  }
  ["payee_count"]=>
  string(1) "7"
}
 
 */
 
 $number_payees = 0;
 foreach($usage_summary['commission_groups'] as $commission_group) {
    if ($commission_group['commission_group_code'] == $_REQUEST['filter_key']) {
        $number_payees = $commission_group['number_payees'];
        break;
    }
 }
 
 $mayormaynaught = 'may';
 if ($number_payees > 0)
    $mayormaynaught = 'may not';
 
 ?>


<div class="ui-widget-header ui-corner-top" >
<h2 style="text-align: center; margin-top: 5px; margin-bottom: 5px;">Confirm Delete Commission Structure</h2>
</div>
<div class="ui-widget ui-widget-content  ui-corner-bottom dbui-frame" style="padding: 5px;" >
 <button onclick="load_div_screen('setup/payouts/commission_structures','#payout_content');"  class="button">Back</button>
<hr />

<form id="commission_structure_form">
<fieldset>
<legend>Commission Structure Usage</legend>

<p>Currently <strong><?php echo $number_payees; ?></strong> payees are in this Commission Group. You <strong><?php echo $mayormaynaught; ?></strong> delete it.</p>
</fieldset>
<fieldset><legend>Commission Group Identity</legend>
<div class="section group"> <!-- ROW -->
    <div class="col span_3_of_12"> <!-- Column -->
    <label>Group Code</label>
    <input name="commission_group_code" type="text" readonly="readonly" value="<?php echo $commission_structure['commission_group']['commission_group_code']; ?> " />
    </div> <!-- END Column -->
    <div class="col span_9_of_12"> <!-- Column -->
    <label>Group Name</label>
    <input type="text" name="group_name" readonly="readonly" id="group_name" value="<?php echo $commission_structure['commission_group']['name']; ?> "/>
    </div> <!-- END Column -->
</div> <!-- END ROW -->
<div class="section group"> <!-- ROW -->
    <div class="col span_12_of_12"> <!-- Column -->
    <label>Description (optional)</label>
    <textarea id="description" readonly="readonly" name="description"><?php echo $commission_structure['commission_group']['description']; ?></textarea>
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
    foreach($rates as $rate) {
        echo "<tr><td><input type=\"text\" readonly=\"readonly\" name=\"commissions[level][0]\" value=\"{$rate['level']}\" /></td>
                  <td><input type=\"text\" readonly=\"readonly\" class=\"required \"  name=\"commissions[type][0]\" value=\"{$rate['type']}\" /></td> 
                  <td><input type=\"text\" readonly=\"readonly\" class=\"required number\" min=\"0.01\" max=\"100\"   name=\"commissions[amount][0]\" value=\"{$rate['amount']}\" /></td>
        ";
    }
 ?>
 </tbody>
 </table>


</fieldset>
<fieldset>
<legend>Offer Limits</legend>
<?php 
    if (empty($current_offer_limits)) 
        $checked = 'checked="checked"';
    else
        $checked = '';
?>
<input disabled="disabled" readonly="readonly" style="display: inline; width: 30px;" id="unlimited_offers"  name="unlimited_offers" type="checkbox" <?php echo $checked; ?> value="unlimited_offers" /> No Limit on offers
         <br />
         <select disabled="disabled" id="offer_limits" name="offer_limits[]"  multiple="multiple" size="6">
                
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
          <br />


</fieldset>

<?php 
if ($number_payees == 0) {
    ?>
<a href="javascript:void(0);"  onclick="delete_commission_structure()" 
class="ui-button  icon_left_button button_link  ui-state-default ui-corner-all"  >
<span class="ui-icon  ui-icon-circle-minus"></span> 
Confirm Delete</a>
<?php } ?>
</form> 
</div>

 <script>
 jQuery('#commission_group_info').load('<?php echo plugins_url('cg_wiz_form_help/hd.html',__FILE__); ?>');        


function delete_commission_structure()
{


        var data = {
            action: 'atx_delete_commission_structure',            
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

 </script>
 