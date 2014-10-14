<?php
/*
array(5) {
  ["action"]=>
  string(11) "load_screen"
  ["plugin"]=>
  string(18) "ecommerce-services"
  ["screen"]=>
  string(13) "manifest_form"
  ["filter_key"]=>
  string(3) "ABC"
  ["back_screen"]=>
  string(1) "4"
}

*/

$aretex_core_path = get_option('aretex_core_path');
 if (file_exists($aretex_core_path.'AreteX_WPI_DI.class.php')) {
                require_once($aretex_core_path.'AreteX_WPI_DI.class.php');

if ((! empty($_REQUEST['filter_key'])) && ($_REQUEST['filter_key'] == 'none'))
    $_REQUEST['filter_key'] = false;

    
if (! empty($_REQUEST['filter_key']))
{
    $title = "Edit Delivery Manifest";
    // Load the manifest
    $manifest = AreteX_WPI_DI::get_delivery_code($_REQUEST['filter_key'],true);
 
    $delivery_code = 'value="'.$manifest['delivery_code'].'" readonly="readonly" ';
    $description = 'value="'.$manifest['description'].'" ';
    
    
}
else
{
    $title = "Add New Delivery Manifest";
    $delivery_code = '';
    $description = '';
}

?>

<?php 
    $back_code = "load_screen('manifests')";
    if (! empty($_REQUEST['back_screen'])) {
        
          $ajax_url = get_option('aretex_bas_endpoint');
            $ajax_url .= '/dbui/dbui_ajax_JSON.php';
            
            $data_id = $_REQUEST['back_screen'];
               
            $access_token = AreteX_WPI::ajaxAccessToken();
            
            $back_code = "aretex_dbui_Edit('products_1','$ajax_url','#inner_form','$data_id','$access_token','products');"; 
               
              
    }
    
?>


<a href="javascript:void(0);" onclick=" <?php echo $back_code; ?>  ;" 
class="ui-button  icon_left_button button_link  ui-state-default ui-corner-all"  >
<span class="ui-icon  ui-icon-circle-arrow-w"></span> 
Back</a>
<div class="section group"> <!-- ROW -->
    <div id="left_product_column" class="col span_12_of_12"> <!-- Column -->
<div id="inner_form">
<div class="ui-widget-header ui-corner-top" >
<h2 style="text-align: center; margin-top: 5px; margin-bottom: 5px;"><?php echo $title;  ?></h2>
</div>
<div class="ui-widget ui-widget-content  ui-corner-bottom container" >
<div class="section group"> <!-- ROW -->
    <div class="col span_7_of_12"> <!-- Column -->

   <form id="manifest_id_form">
    <div class="section group"> <!-- ROW -->
        <div class="col span_3_of_12"> <!-- Column -->
            
            <span style="text-align:right; float:right; font-weight:bold">Delivery Code</span>
        </div> <!-- END Column -->
        <div class="col span_2_of_12"> <!-- Column -->
            <input id="delivery_code" class="required" name="data[delivery_code]"  <?php echo $delivery_code; ?> style="width: 80px;" />            
        </div> <!-- END Column -->
        <div class="col span_7_of_12"> <!-- Column -->
        <div id="aretex_check_box">
        <input type="checkbox" id="let_aretx_assign"  onclick="aretex_assigns_code();" />&nbsp;Let AreteX&trade; Assign Delivery Code
        </div>
        <script>var new_manifest;</script>

        <?php if (empty($_REQUEST['filter_key'])) { ?>
            <script>
                new_manifest = true;
            </script>
         <?php } else { ?>
           <script> var original_delivery_code = '<?php echo $manifest['delivery_code']; ?>';
           jQuery('#aretex_check_box').hide();
           new_manifest = false;
            </script>
                    <div class="section group"> <!-- ROW -->
                    <input type="checkbox" id="copy_as_new"  onclick="copy_as_new_manifest();" />&nbsp;Copy as New Manifest
                    </div> <!-- END ROW -->                    

        <?php }
                   
         ?>
            
            <script>
            function aretex_assigns_code(){
                 jQuery(function ($) {
                    if ($('#let_aretx_assign').is(':checked')){
                        $('#delivery_code').val('*');
                        $("#delivery_code").attr('readonly','readonly');
                    }
                    else {
                        $('#delivery_code').val('');
                        $("#delivery_code").removeAttr('readonly');
                    }                
                 });
             }
             
             function copy_as_new_manifest() {
                jQuery(function ($) {
                if ($('#copy_as_new').is(':checked')){                    
                    $('#aretex_check_box').show();
                    new_manifest = true;
                    aretex_assigns_code();
                }
                else {
                    $('#aretex_check_box').hide();
                    $('#delivery_code').val(original_delivery_code);
                    $("#delivery_code").attr('readonly','readonly');
                    new_manifest = false;
                }
                
                });
                set_help();
             }
             function set_help() {
                if (new_manifest) {
                    jQuery('.add_help').show();
                    jQuery('.edit_help').hide();
                }
                else {
                    jQuery('.add_help').hide();
                    jQuery('.edit_help').show();
                }
                
             }
             set_help();
            </script>
       
        </div> <!-- END Column -->                
    </div> <!-- END ROW -->
    <div class="section group"> <!-- ROW -->
        <div class="col span_3_of_12"> <!-- Column -->
            <span style="text-align:right; float:right; font-weight:bold">Manifest Description</span>
        </div> <!-- END Column -->
        <div class="col span_7_of_12"> <!-- Column -->
            <input type="text" class="required" name="data[description]" <?php echo $description; ?>  id="manifest_description" />
        </div> <!-- END Column -->        
    </div> <!-- END ROW -->
    </form>
    
        
    <div class="section group"> <!-- ROW -->
        <div class="col span_12_of_12"> <!-- Column -->
 
        <span style="padding-left: 5px; font-size: 11px;">
        Type the name or deliverable code of the deliverable you want to add to this manifest. Select from the filtered list.
        </span>
        </div> <!-- END Column -->
    </div> <!-- END ROW -->
    <div class="section group"> <!-- ROW -->
        <div class="col span_3_of_12"> <!-- Column -->
            <span style="text-align:right; float:right; font-weight:bold">Find Deliverable:</span>
        </div> <!-- END Column -->
        <div class="col span_6_of_12"> <!-- Column -->
        <input type="text" id="find_deliverable" />
        </div> <!-- END Column --> 
        <div class="col span_3_of_12"> <!-- Column -->
        <a href="javascript:void(0);"  onclick="jQuery('#find_deliverable').val('');"
class="ui-button  icon_left_button button_link  ui-state-default ui-corner-all"  >
<span class="ui-icon  ui-icon-circle-close"></span> 
Clear Find Box</a>
        </div> <!-- END Column -->               
    </div> <!-- END ROW -->
 

<div class="section group"> <!-- ROW -->
        <div class="col span_1_of_12"> <!-- Column -->
    </div> <!-- END Column -->
    <div class="col span_8_of_12"> <!-- Column -->
 

<a href="javascript:void(0);" onclick="save_manifest();" 
class="ui-button  icon_left_button button_link  ui-state-default ui-corner-all"  >
<span class="ui-icon  ui-icon-disk"></span> 
Save Manifest</a> 
    </div> <!-- END Column -->
</div> <!-- END ROW -->
<div class="section group"> <!-- ROW -->
    <div class="col span_1_of_12"> <!-- Column -->
    </div> <!-- END Column -->
    <div class="col span_11_of_12"> <!-- Column -->
    
<span style="font-size: 12px;">(See the table below for a list of current deliverables on this manifest.)</span>
 
    </div> <!-- END Column -->
</div> <!-- END ROW -->
</div> <!-- END Column -->
<div class="col span_5_of_12"> <!-- Column -->

        <div class="ui-widget ui-widget-content  ui-corner-all container" >
        
        <span class="add_help"><strong>Add Manifest Help</strong></span>
        <span class="edit_help"><strong>Edit Manifest Help</strong></span>

<p><em>Manifests</em> are built from deliverables.  Build and manage your manifests for your Products here.
</p>
<p class="edit_help">If you wish to copy this Manifest in order to save work, check the <em>Copy as New Manifest</em> box.  
</p>
<p class="add_help">To add a Manifest, type in a unique <strong>Delivery Code</strong> or let AreteX&trade; assign one.  
</p>
<p>Be sure the <strong>Description</strong> is meaningful to better understand what this Manifest contains.</p>
<p><strong>Find Deliverable</strong> - Begin typing the name or code to see a filtered listing of your Deliverables.  <em>Click on the Deliverable</em> to add it to the list below.  To clear the <strong>Find</strong> search box, select <strong>Clear Find Box</strong>.
</p>
<p>If you wish to delete a Deliverable from this manifest, click the <strong>Delete (Circle/Minus)</strong> icon below.  This will only delete the Deliverable from this particular Manifest, and not from your full listing of Deliverables available.
</p>
<p>Be sure to <em>Save</em> your work when you are done.</p>
        
        
        
        </div>
        </div> <!-- END Column -->
    </div> <!-- END ROW -->
<script>

</script>
<pre>
<? 
  
?>
</pre>
<div style="padding: 5px;"  class="section group" style="width: 100%">
<form id="manifest_content_form">
<table id="manifest_table" width="100%" style="width:100%">
<thead>
<tr>
<th>Action</th>
<th>Deliverable Code</th>
<th>Name</th>
<th>Description</th>
<th>Delivery Type</th>
<th>Deliv. Type Descriptor</th>
<th>First Delivery (Days after Purchase)</th>
<th>Authorization Duration (Days)</th>
<th>Re-Authorization Cycle</th>
<th>Total ReAuth</th>
</tr>
</thead>
<tbody>
<? 
    function make_del_button($deliverable_id) {
        $img = plugins_url( '../../images/actions/delete_24.png', __FILE__ );
        
        $del_button = '<img src="'.$img.'" style="float: right; cursor: pointer;" class="remove-row-button"  title="Remove from manifest" />'.
                            ' <input type="hidden" name="deliverable_id[]" value="'.$deliverable_id.'" /> ';
                            
        return $del_button;
        
    }
    // deliverables
    if (! empty($_REQUEST['filter_key'])) {
        
        foreach($manifest['deliverables'] as $deliverable) {
            $str = '<tr><td>'.make_del_button($deliverable['id']).'</td>';
            $str .= "<td>{$deliverable['deliverable_code']}</td>";
            $str .= "<td>{$deliverable['name']}</td>";
            $str .= "<td>{$deliverable['description']}</td>";
            $str .= "<td>{$deliverable['delivery_type']}</td>";
            $str .= "<td>{$deliverable['type_details']['descriptor']}</td>";
            $str .= "<td><span style=\"float: right\" text-align: right>{$deliverable['schedule']['first_delivery']}</span></td>";
            if (empty($deliverable['type_details']['duration']))
                $duration = 'Unlimited';
            else
                $duration = $deliverable['type_details']['duration'];
            $str .= "<td><span style=\"float: right\" text-align: right>$duration</span></td>";
            $str .= "<td>{$deliverable['schedule']['delivery_cycle']}</td>";
            
            if ($deliverable['schedule']['maximum_deliveries'] <= 0)
                $deliverable['schedule']['maximum_deliveries'] = 'Until Canceled';
            
            $str .= "<td><span style=\"float: right\" text-align: right>{$deliverable['schedule']['maximum_deliveries']}</span></td>";
            
            $str .= '</tr>';
            
            echo $str;

        }
        
    }
    
    
?>
</tbody>
<tfoot>
</tfoot>

</table>
</form>
<script>

delete_from_manifest_icon = '<?php echo plugins_url( '../../images/actions/delete_30.png', __FILE__ ); ?>';
//console.log(delete_from_manifest_icon);

oTable = init_local_datatable_scroll_x('manifest_table','110%',false);

</script>

<script>

<?php 
 

    echo AreteX_WPI_DI::jsDeliverableSearch('find_deliverable');
 }  

?>

</script>
<script>

jQuery('.remove-row-button').tooltip();

jQuery('.remove-row-button').on('click', function (event) {

       jQuery(this).tooltip('close');
       var tr = jQuery( this ).closest('tr');                          
      
     
       
    //   var aPos = oTable.fnGetPosition( tr );
      var nNodes = oTable.fnGetNodes( );
     //  alert(nNodes[0].nodeName);
       
      // var aPos = oTable.fnGetPosition( tr[0] );
      //   alert(aPos); 
       oTable.fnDeleteRow(tr[0]);  
       
      
       
    });



function save_manifest() {
    <?php 
    if ($_REQUEST['back_screen']) {
        echo "var linked_product='{$_REQUEST['back_screen']}';\n";
    }
    else
        echo "var linked_product = 'none';\n";
    ?>
    
    
    jQuery('.error').remove();
    jQuery('#manifest_id_form').validate();
    if (jQuery('#manifest_id_form').valid()) {
         var nNodes = oTable.fnGetNodes( );
         if (nNodes == 0) {
            alert('No Deliverables in Manifest - Not Saved');
            return;
         }
         var manifest_id = jQuery('#manifest_id_form').serialize();
         var manifest_content = jQuery('#manifest_content_form').serialize();        
         jQuery.ajax({
              type: 'POST',
              url: ajaxurl,
              async: false, // Yes, the A is for Asyncronous
              dataType: 'json', //... but the X is for XML.
              data: {
                action: 'atx_create_manifest',
                manifest_id: manifest_id,
                manifest_content: manifest_content,
                new_manifest: new_manifest,
                linked_product: linked_product
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
                         <?php echo $back_code; ?> 
                    }
                }
                
              }
                  
         });
         
        
    }
}


</script>

</div>
</div>
</div>
    </div> <!-- END Column -->
    <div id="right_product_column" class="col span_4_of_12"> <!-- Column -->
    <div  id="product_help_box" class="ui-widget ui-widget-content  ui-corner-all container" >
    </div>
    </div> <!-- END Column -->
</div> <!-- END ROW -->

<script>
jQuery('#right_product_column').hide();



</script>