<?php 
if ($_REQUEST['filter_key']) {
     $aretex_core_path = get_option('aretex_core_path');
    
    $deliverable_id = $_REQUEST['filter_key'];
    if (file_exists($aretex_core_path.'AreteX_WPI_DI.class.php')) {
        require_once($aretex_core_path.'AreteX_WPI_DI.class.php');    
        $deliverable = AreteX_WPI_DI::get_deliverables_by_id($deliverable_id);
        
        $payouts = AreteX_WPI_DI::get_deliverable_payouts($deliverable_id);
        
    }
}


?>
<a href="javascript:void(0);"  onclick="go_back();"
class="ui-button  icon_left_button button_link  ui-state-default ui-corner-all"  >
<span class="ui-icon  ui-icon-circle-arrow-w"></span> 
Back</a>
<div class="section group"> <!-- ROW -->
    <div class="col span_8_of_12"> <!-- Column -->

<div class="ui-widget-header ui-corner-top" >
<h2 style="text-align: center; margin-top: 5px; margin-bottom: 5px;">Deliverable Payouts Plan</h2>
</div>
<div class="ui-widget ui-widget-content  ui-corner-bottom " style="padding: 5px;" >
<div class="section group"> <!-- ROW -->
    <div class="col span_3_of_12"> <!-- Column -->
    <span style="text-align:right; float:right; font-weight:bold">Deliverable:</span>
    </div> <!-- END Column -->
    <div class="col span_9_of_12"> <!-- Column -->
    <?php echo $deliverable['deliverable_code'].': '.$deliverable['name'] ?>
    </div> <!-- END Column -->
</div> <!-- END ROW -->
<div class="section group"> <!-- ROW -->
    <div class="col span_3_of_12"> <!-- Column -->
    <span style="text-align:right; float:right; font-weight:bold">Deliverable Type:</span>
    </div> <!-- END Column -->
    <div class="col span_9_of_12"> <!-- Column -->
    <?php echo $deliverable['delivery_type'].': '.$deliverable['type_details']['descriptor']; ?>
    </div> <!-- END Column -->
</div> <!-- END ROW -->
<div class="section group"> <!-- ROW -->
    <div class="col span_12_of_12"> <!-- Column -->
    <hr />
    </div> <!-- END Column -->
</div> <!-- END ROW -->
<div class="section group"> <!-- ROW -->

    <div class="col span_7_of_12" > <!-- Column -->
    <span style="display: block;  font-weight:bold">Contributor to Pay</span>
    <div><a href="javascript:void(0);" onclick="jQuery('#existing_payee').hide();jQuery('#new_payee').show();"  
class="ui-button  icon_left_button button_link  ui-state-default ui-corner-all"  >
<span class="ui-icon  ui-icon-circle-plus"></span> 
Create New Payee</a> 
<a href="javascript:void(0);"  onclick="jQuery('#existing_payee').show();jQuery('#new_payee').hide();"
class="ui-button  icon_left_button button_link  ui-state-default ui-corner-all"  >
<span class="ui-icon  ui-icon-search"></span>Use Existing Payee</a>
    </div>
    <div id="existing_payee">
        <span style="display: block;  font-weight:bold">Find Payee</span>
    
    <input id="find_payee" type="text" />
    <br /><span style="font-size: 11px;">(Begin Typing Name or Email Address)</span>
    <script>
    <?php echo AreteX_WPI::jsPayeeSearch('find_payee');     
    ?>
    </script>
    </div>

    <script>
    jQuery('#existing_payee').hide();
    jQuery('#new_payee').hide();
    </script>
    <input id="payee_id" type="hidden" />
    <input id="payee_name" type="hidden" />
    <input id="payee_email" type="hidden" />
    <input id="wp_id" type="hidden" />
    
    </div> <!-- END Column -->
    </div> <!-- END ROW -->
    <div class="section group"> <!-- ROW -->
    <div class="col span_7_of_12"> <!-- Column -->
        <span style="display: block;  font-weight:bold">Payout Template</span>
    
    <select id="payout_code_id">
    <option selected="selected" value="">--Select Payout Template---</option>
    <?php
        
        $payout_codes = AreteX_WPI::getPayoutCodes();
        foreach($payout_codes as $payout_code) {
            $value = $payout_code->id;
            $name = "{$payout_code->payout_code}: {$payout_code->payment_type}: ";
            if ($payout_code->paid_on == 'Gross') {
                $name .= "{$payout_code->amount}% Gross";            
            }
            else {
                $amount = number_format($payout_code->amount,2);
                $name .= "$$amount";
            }
            echo "<option value=\"$value\">$name</option>\n";
        }
    ?>
    </select>
    <script>
        var payout_list = {
            <?php foreach($payout_codes as $payout_code) {
                
            if ($payout_code->paid_on == 'Gross') {
                $name = "{$payout_code->amount}% Gross";            
            }
            else {
                $amount = number_format($payout_code->amount,2);
                $name = "$$amount";
            }
                
                $payment_type = addslashes($payout_code->payment_type);
                echo "'{$payout_code->id}': {'payout_code':'{$payout_code->payout_code}', 'payment_type':'$payment_type', 'amount':'$name' },\n ";
            }    
            ?>   
        };                   
    </script>
    </div> <!-- END Column -->
</div> <!-- END ROW -->
<div class="section group"> <!-- ROW -->
    <div class="col span_10_of_12"> <!-- Column -->
        <div id="new_payee">
    <?php $path = plugin_dir_path( __FILE__ );
           include($path.'catalog/delivery/deliverable/new_payee_form.php');
     ?>   
    </div>
    <script>
function save_new_payee(aretexurl)
{
     jQuery('#frm_53e63dd708a03').validate();
     if (!  jQuery('#frm_53e63dd708a03').valid())
        return;
     var payee_data = jQuery('#frm_53e63dd708a03').serialize();
      
       
      var data = {
        cmd: 'Action',
        action: 'special_save',
        config_id: 'new_payee_1',
        data: payee_data
        
      }
      console.log(ajaxurl);
      console.log(data);
      jQuery.ajax({
      type: 'POST',
      url: aretexurl,
      data: data,
      dataType: "json",
      success: function(data){
        // on success use return data here  
        if (data.payee_id) {
           jQuery('#payee_id').val(data.payee_id);
            jQuery('#payee_name').val(data.payee_name);
            jQuery('#payee_email').val(data.payee_email);
            jQuery('#wp_id').val(data.wp_id);
            alert('Payee Saved\n***Click "Add Pair to Plan"***\nTo add '+data.payee_name);
            jQuery('#frm_53e63dd708a03')[0].reset();
            jQuery('#new_payee').hide();   
        }
        else {
            alert('Error: Payee Not Added');
        }            
        
       
      },
      error: function(xhr, type, exception) { 
        // if ajax fails display error alert
        alert("ajax error: "+type+' '+exception);
      }
    });    
}
</script>

    </div> <!-- END Column -->
</div> <!-- END ROW -->
<div class="section group"> <!-- ROW -->
    <div class="col span_12_of_12"> <!-- Column -->
    <a href="javascript:void(0);"  onclick="append_deliverable_payout();"
class="ui-button  icon_left_button button_link  ui-state-default ui-corner-all"  >
<span class="ui-icon  ui-icon-circle-plus"></span> 
Add Pair to Plan</a>

<a href="javascript:void(0);" onclick="save_delverable_payouts('<?php echo $deliverable_id; ?>');"  
class="ui-button  icon_left_button button_link  ui-state-default ui-corner-all"  >
<span class="ui-icon  ui-icon-disk"></span> 
Save Plan</a>



    </div> <!-- END Column -->
</div> <!-- END ROW -->
<div class="section group"> <!-- ROW -->
    <div class="col span_12_of_12"> <!-- Column -->
    <hr />
    </div> <!-- END Column -->
</div> <!-- END ROW -->
<div style="padding: 5px;"  class="section group" style="width: 100%">
<form id="deliverable_payout_form">
<table id="deliverable_payout_table" width="100%" style="width:100%">
<thead>
<tr>
<th>Action</th>
<th>Payee</th>
<th>Payout Template</th>
<th>Payment Type</th>
<th>Amount</th>

</tr>
</thead>
<tbody>
<?php
$delete_from_payouts_icon = plugins_url( '../../images/actions/delete_24.png', __FILE__ );

function  make_del_button($delete_from_payouts_icon,$payee_id,$payout_code_id) {


    return '<img src="'.$delete_from_payouts_icon.'" style="float: right; cursor: pointer;" class="remove-row-button"   title="Remove from deliverable" />'.
           ' <input type="hidden" name="payout_code_id['.$payee_id.'][]" value="'.$payout_code_id.'" /> ';
}


 
foreach($payouts as $payout) {
    $del = make_del_button($delete_from_payouts_icon,$payout->payee_id,$payout->payout_code_id);
    if ($payout->paid_on == 'Gross') {
        $name = "{$payout->amount}% Gross";            
    }
    else {
        $amount = number_format($payout->amount,2);
        $name = "$$amount";
    }
    
    $tr = "<tr><td>$del</td><td>{$payout->payee_name}</td><td>{$payout->payout_code}</td>".
          "<td>{$payout->payment_type}</td><td><span style=\"float: right\" text-align: right>$name</span></td> </tr>\n";
          
    echo $tr;
}
?>
</tbody>
</table>
</form>
</div>

</div>
    </div> <!-- END Column -->
    <div class="col span_4_of_12"> <!-- Column -->

<div class="ui-widget ui-widget-content  ui-corner-all container" >
<strong>Deliverable Payouts Plan Help</strong>

<p>A payout plan is used to add <em>Contributors</em> to your <em>Deliverable</em>.  This will be important later, as having fully set up Deliverables helps to more quickly and efficiently build your Products.
</p>
<p>If you need to <strong>Add a Contributor</strong>, who also is not on your general payee list, select <em>Create New Payee</em>.  Follow the instructions.  Any non-required information may be filled out later.  (Remember that your payees must have a WordPress account with this site. If no account is currently available, the WP account name <strong>MUST</strong> be added later.)  Select <em>Save</em>.
</p>  
<p>If you already have the payee listed and wish to add that person to this Deliverable Plan, select <strong>Use Existing Payee</strong>.  Begin typing that person's name or email addresss.  Select from the generated list.  
</p>
<p>Choose a <strong>Payout Template</strong> from the templates you have already created.  If you have none, first create the template you need by going to <em>Setup / Payouts / Contributor Payouts / Add</em>.  Return to this screen.
</p>
<p><em>Pair</em> - A pair is the combination of both the chosen Payee and the selected Payout Template.  To add your pair to the payout list below, select Add Pair to Plan.  
</p>
<p>To save your work, select <em>Save Plan</em>.
</p>
<p>A table is shown below that lists all the Contributor Pairs you have chosen for this specific Deliverable.  You may remove a pair from the list by choosing the Remove (Minus/Circle icon) button.  
</p>
<p>If you make a mistake, you must delete the incorrect pair and add a new pair.  Deleting a pair will not remove the payee from the general payee list.
</p>
</div>
    </div> <!-- END Column -->
</div> <!-- END ROW -->


<script>
oTable = init_local_datatable_scroll_x('deliverable_payout_table','100%',false);
delete_from_payouts_icon = '<?php echo $delete_from_payouts_icon; ?>';

jQuery('.remove-row-button').tooltip();
jQuery('.remove-row-button').on('click', function (event) {
            
       jQuery(this).tooltip('close');
       var tr = jQuery( this ).closest('tr');                          
                                          
    //   var aPos = oTable.fnGetPosition( tr );
      var nNodes = oTable.fnGetNodes( );
   //   alert(nNodes[0].nodeName);
       
      // var aPos = oTable.fnGetPosition( tr[0] );
      //   alert(aPos); 
       oTable.fnDeleteRow(tr[0]);  
                         
       
    });
    
function go_back() {
    var feature = '<?php echo $_REQUEST['back_screen']['feature']; ?>';
    var screen = '<?php echo $_REQUEST['back_screen']['screen']; ?>'
    
    if (screen == 'edit_pd_cnt' || screen == 'edit_mem')
        load_linked_feature_screen_back(feature,screen,'<?php echo $deliverable_id; ?>',null);
    else
        load_feature_screen(feature,screen);
}    

function append_deliverable_payout() {
    
           var payout_code_id = jQuery('#payout_code_id').val();
           
           if (! payout_code_id ) {
            alert('No Payout Template Selected');
            return;
           }
    
           var item =  payout_list[payout_code_id];
           
           var payee_id = jQuery('#payee_id').val();
           
            if (! payee_id ) {
            alert('No Payee Specified');
            return;
           }
           
           var del_button = '<img  src="'+delete_from_payouts_icon+'" style="float: right; cursor: pointer;" class="remove-row-button"   title="Remove from deliverable" />'+
                            ' <input type="hidden" name="payout_code_id['+payee_id+'][]" value="'+payout_code_id+'" /> ';
                
           var payee_name = jQuery('#payee_name').val();
            
           var row = [del_button,
                     payee_name,
                     item.payout_code,
                     item.payment_type,
                     '<span style="float: right" text-align: right>'+item.amount+'</span>'];
                     
           oTable.fnAddData(row);
           
           
           jQuery('.remove-row-button').tooltip();
           
           jQuery('.remove-row-button').off('click'); // Clear out all the old ones
           
           jQuery('.remove-row-button').on('click', function (event) { // Add it again ... 
            
                   jQuery(this).tooltip('close');
                   var tr = jQuery( this ).closest('tr');                          
                                                      
                //   var aPos = oTable.fnGetPosition( tr );
                  var nNodes = oTable.fnGetNodes( );
                 //  alert(nNodes[0].nodeName);
                   
                 //  var aPos = oTable.fnGetPosition( tr[0] );
                  //   alert(aPos); 
                   oTable.fnDeleteRow(tr[0]);  
                                     
                   
                });
            

            
}

function save_delverable_payouts(deliverable_id) {
    
     var payouts = jQuery('#deliverable_payout_form').serialize();
     
     jQuery.ajax({
              type: 'POST',
              url: ajaxurl,
              async: false, // Yes, the A is for Asyncronous... but the X is for XML.
              dataType: 'json',
              data: {
                action: 'atx_save_deliverable_payouts',
                deliverable_id: deliverable_id,
                payouts: payouts                
              },
              success: function(data){
                console.dir(data);
                var item;
                if (data.status == 'Error') {
                   for (var i = 0; i < data.errors.length; ++i) {
                    item = data.errors[i];
                    console.dir(item);
                    jQuery('#'+item.element).after('<label class="error">'+item.message+'</label>');
                     
                   }  
                }
                else {
                    alert(data.status);
                    if (data.status == 'OK') {
                        nav_max();
                        go_back();
                    }
                }
                
              }
                  
         });     
    
}


</script>
