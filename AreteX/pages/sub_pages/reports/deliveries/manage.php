<?php

$delivery_id = $_REQUEST['linked_id'];

$url = get_option('aretex_bas_endpoint');
$url .= '/api/delivery/authorizations/'.$delivery_id;
             
$ret = AreteX_WPI::getGenericResourceByURI($url,AreteX_WPI::no_cache);


?>
<a href="javascript:void(0);"  onclick=" load_content_screen('reports/pending_deliveries');"
class="ui-button  icon_left_button button_link  ui-state-default ui-corner-all"  >
<span class="ui-icon  ui-icon-circle-arrow-w"></span> 
Back</a>
<div class="section group"> <!-- ROW -->
    <div class="col span_8_of_12"> <!-- Column -->
    <div class="ui-widget-header ui-corner-top" >
    <h2 style="text-align: center; margin-top: 5px; margin-bottom: 5px;">Manage Delivery Authorization</h2>
    </div>
    <div class="ui-widget ui-widget-content  ui-corner-bottom dbui-frame" style="padding: 10px;" >
    <form id="auth_update_form" action="javascript:void(0);">
    <fieldset>
    <legend>Delivery Authorization</legend>
    <div class="section group"> <!-- ROW -->
    <div class="col span_1_of_4"> <!-- Column -->
    <label>Authorization Status</label>    
    <select id="authorization_status">
    
    <?php 
        $status_list = array('Authorized','Suspended','Expired','Terminated','Completed','Pending');
        foreach($status_list as $status)
        {
            if ($ret->authorization_status == $status)
                echo "<option  value=\"$status\" selected=\"selected\"> $status </option>\n";
            else
                echo "<option  value=\"$status\"> $status </option>\n";
        }
    ?>
        
    </select>
    </div> <!-- END Column -->
    <div class="col span_1_of_4"> <!-- Column -->
    <label>Status End Date</label>    
    <input id="expiration_date" name="expiration_date" class="datetime" value="<?php echo $ret->expiration_date; ?>" />

    </div> <!-- END Column -->
    <div class="col span_2_of_4"> <!-- Column -->
    <label>Delivery Authorization Management</label>    
    <a href="javascript:void(0);"  onclick="post_update();"
    class="ui-button  icon_left_button button_link  ui-state-default ui-corner-all"  >
    <span class="ui-icon  ui-icon-circle-check"></span> 
    Save</a> &nbsp;&nbsp;
    <a href="javascript:void(0);"  onclick="delete_auth();"
    class="ui-button  icon_left_button button_link  ui-state-default ui-corner-all"  >
    <span class="ui-icon  ui-icon-closethick"></span> 
    Delete Authorization Record</a>

    </div> <!-- END Column -->
</div> <!-- END ROW -->
    </fieldset>
    </form>
    <fieldset>
    <legend>Customer Information</legend>
    <div class="section group"> <!-- ROW -->
    <div class="col span_1_of_3"> <!-- Column -->
    <label>Customer First Name</label>
    <?php echo $ret->firstname; ?>
    </div> <!-- END Column -->
    <div class="col span_1_of_3"> <!-- Column -->
    <label>Customer Last Name</label>
    <?php echo $ret->lastname; ?>
    </div> <!-- END Column -->
    <div class="col span_1_of_3"> <!-- Column -->
    <label>Customer Email Address</label>
    <?php echo $ret->email_address; ?>
    </div> <!-- END Column -->
   </div> <!-- END ROW -->
   </fieldset>
   <fieldset>
   <legend>Deliverable / Product Information</legend>
    <div class="section group"> <!-- ROW -->
    <div class="col span_1_of_4"> <!-- Column -->
    <label>Deliverable Code</label>
    <?php echo $ret->deliverable_code; ?>
    </div> <!-- END Column -->
    <div class="col span_1_of_4"> <!-- Column -->
    <label>Deliverable Name</label>
    <?php echo $ret->delivery_name; ?>
    </div> <!-- END Column -->
    <div class="col span_1_of_4"> <!-- Column -->
    <label>Product Code</label>
    <?php echo $ret->product_code; ?>
    </div> <!-- END Column -->
        <div class="col span_1_of_4"> <!-- Column -->
    <label>Product Name</label>
    <?php echo $ret->product_name; ?>
    </div> <!-- END Column -->
</div> <!-- END ROW -->
    </fieldset>

    </div>
    </div> <!-- END Column -->
    <div class="col span_4_of_12"> <!-- Column -->

    <div class="ui-widget ui-widget-content  ui-corner-all container" >
    <strong>Manage Deliveries Help</strong><br /><br />
    <strong>Delivery Authorization for a Particular Sale</strong><br />
    

<p><strong>Authorization Status:</strong> This dropdown box allows you to override the particular status of this deliverable/sale. This authorization override will be recorded on the AreteX&trade; server.  <em>Note</em>: A "<strong>Pending</strong>" status means that you are making sales for product that will be available to your customers in the future.</p>
<p><strong>Status End Date</strong>: What this date means depends on the <em>Authorization Status</em>.  1) If a status is "<strong>Pending</strong>" and the <em>Status End Date</em> has passed, AreteX&trade; will set the status to <strong>Authorized</strong>. In this instance "<em>pending</em>" signifies that the delivery has been approved, but is not to be made available yet.  2) If the status is <strong>Authorized</strong>, AreteX will set the status to <strong>Expired</strong> after the <em>Status End Date</em>. This allows you to limit how long the authorization is valid.  3) The <em>Status End Date</em> is ignored for all other status values. 4) If the <em>Status End Date</em> is <strong>blank</strong>, AreteX&trade; is not scheduled to change the status.</p>

    
    <p>
    <strong>Buttons</strong><br />
    <strong>Save:</strong>  This will save your <em>Authorization Status</em> and <em>Status End Date</em> changes to the AreteX&trade; server. You will probably want to select the <em>Clear Cache</em> button at the top of the screen after you <em>Save</em>. <br />
    <strong>Delete Authorization Record:</strong> This will remove the authorization record from the AreteX&trade; server. You will probably want to select the <em>Clear Cache</em> button at the top of the screen after you <em>Delete</em>.  
  
    </p>
    <p><em><strong>Note:</strong></em> If you delete this authorization and it is on a <em>rebill plan</em>, AreteX&trade; may create a new deliverable authorization when the next payment is successfully completed.  Therefore, you may wish to <em>cancel</em> the associated <em>rebill agreement</em>. </p>
    <p><strong>Customer Information:</strong> This is your customer.</p>
       <p><strong>Deliverable / Product Information:</strong> These are the codes and names of both the product purchased and the deliverables authorized.</p>

    </div>
    </div> <!-- END Column -->
</div> <!-- END ROW -->
<script>
function post_update() {
    
       jQuery('#auth_update_form').validate();
       if (jQuery('#auth_update_form').valid()) { 
           jQuery.ajax({
                  type: 'POST',
                  url: ajaxurl,
                  async: false, 
                  dataType: 'json',
                  data: {
                    action: 'atx_post_deliverable_auth',
                    data: {
                       expiration_date: jQuery('#expiration_date').val(),
                       authorization_status: jQuery('#authorization_status').val() 
                    },
                    id: <?php echo $delivery_id; ?>
                  },
                  success: function(result){
                    
                    if (result == 'OK') {                    
                        alert('OK');
                        load_content_screen('reports/pending_deliveries');
                    }
                    else {
                        
                        alert(result);
                    }
                    
                  }
                  
                });
       }
    
    
}

function delete_auth() {
    
       if (confirm('If you confirm, this authorization record will be deleted.\nAre you sure?')) {      
           jQuery.ajax({
                  type: 'POST',
                  url: ajaxurl,
                  async: false, 
                  dataType: 'json',
                  data: {
                    action: 'atx_delete_deliverable_auth',
                    
                    id: <?php echo $delivery_id; ?>
                  },
                  success: function(result){
                    
                    if (result == 'OK') {                    
                        alert('OK');
                        load_content_screen('reports/pending_deliveries');
                    }
                    else {
                        
                        alert(result);
                    }
                    
                  }
                  
                });       
    }
    
}

</script>