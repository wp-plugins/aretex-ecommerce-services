<?php

function delivery_manifest_list() {
       
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
    else
    {
        echo 'Error: AreteX core not installed';
        exit();
    }
    
    if (file_exists($aretex_core_path.'AreteX_WPI_DI.class.php'))
    {
        require_once($aretex_core_path.'AreteX_WPI_DI.class.php');
        $mainfests= AreteX_WPI_DI::get_manifests();
        /*echo "<pre>";
        print_r($mainfests);
        echo "</pre>";
        */
        // "id":"8","deliverable_code":"TPCD1","name":"Test Paid Content Deliverable","description":"Test "

        $headers = array('Delivery Code'=>'delivery_code','Description'=>'description');
        
        $action['function_name'] = "edit_manifest";
        $action['icon_path'] = 'pages/sub_pages/images/actions/Edit.png';
        $action['parameters'] = array('[delivery_code]');
        $action['title'] = 'Edit Manifest ';
        
        $actions[] = $action;
        
        $action['function_name'] = "delete_manifest";
        $action['icon_path'] = 'pages/sub_pages/images/actions/Delete.png';
        $action['parameters'] = array('[delivery_code]');
        $action['title'] = 'Delete Manifest ';
        
        $actions[] = $action;
               
        
        $str = AreteXDT::TableList($headers,$actions,$mainfests);
        $str .= <<<END_S
        <script>
            function edit_manifest(delivery_code) {
                load_linked_screen('manifest_form',delivery_code);
            }
            
            function delete_manifest(delivery_code) {
                if (confirm('Delete Manifest with Delivery Code: '+delivery_code+'? \\n *WARNING*\\nIf this Manifest has pending deliveries, those deliveries will canceled, regardless of the payment status.')) {
                    
                    jQuery.ajax({
                      type: 'POST',
                      url: ajaxurl,
                      async: false, // Yes, the A is for Asyncronous... but the X is for XML.
                      dataType: 'json',
                      data: {
                        action: 'atx_delete_manifest',
                        delivery_code: delivery_code,
                       
                      },
                      success: function(data){                       
                        var item;
                        if (data.status == 'Error') {
                           alert('Error - Manifest Not Deleted');
                        }
                        else {
                            alert(data.status);
                            if (data.status == 'OK') {
                                nav_max();
                                load_screen('manifests');
                            }
                        }
                        
                      }
                          
                 });
                    
                    
                }
            }
            
            jQuery( document ).tooltip();
            
        </script>
END_S;
        
    }
        
        return $str;

}
 

?>
<div class="section group"> <!-- ROW -->
    <div class="col span_8_of_12"> <!-- Column -->

        <div class="ui-widget-header ui-corner-top" >
        <h2 style="text-align: center; margin-top: 5px; margin-bottom: 5px;">Manifest Management</h2>
        </div>
        <div class="ui-widget ui-widget-content  ui-corner-bottom" >
        <div class="DTTT_container_left" style="padding-right: 0px !important;">
        <a href="javascript:void(0)" onclick="load_screen('manifest_form');" 
        class="DTTT_button" style="margin-right: 0px !important;"><span style="width: 100%;">Add</span></a>
        </div>
        <div>
        <?php
        
        echo delivery_manifest_list();
        
        
        ?>
        </div>
        </div>
    </div> <!-- END Column -->
    <div class="col span_4_of_12"> <!-- Column -->

        <div class="ui-widget ui-widget-content  ui-corner-all container" >
        
        <strong>Manifest Management Help</strong>

<p><em>Manifests</em> are built from <em>Deliverables</em>.  It is the Manifest that contains all the pieces or items (<em>Deliverables</em>) that will be sold as a <em>Product</em>.  It is also the Manifest that holds the record of delivery for each Deliverable, assuring the appropriate delivery schedule of the different Product pieces in a timely fashion.
</p>
<p>On this management screen you will see a list of the Manifests you have created.
</p>
<p><strong>Edit (<em>pencil icon</em>)</strong> - Use to add or remove Deliverables from this Manifest.  Be aware that if you change the Manifest, the next scheduled delivery(ies) will act on the new Manifest.  
</p>
<p><em>Note:</em> If you want to copy a current manifest so that you can add or subtract items without losing the current Manifest, see the Copy Manifest checkbox under Edit.
</p>
<p><strong>Delete (<em>trashcan</em>) </strong>- If this Manifest has pending deliveries, those deliveries will canceled, regardless of the payment status.  Be aware that any Manifest may be used for different products.  You can search for your targeted Manifest in the Product screen under the Delivery Code column.  Proceed with caution.
</p>
        
        
        
        </div>
    </div> <!-- END Column -->
</div> <!-- END ROW -->