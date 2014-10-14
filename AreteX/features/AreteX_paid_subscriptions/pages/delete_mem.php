<?php
$aretex_core_path = get_option('aretex_core_path');
require_once($aretex_core_path.'AreteX_WPI_DI.class.php');

$title = "Confirm Delete Membership Authorization";
$deliverable = AreteX_WPI_DI::get_deliverables_by_id($_REQUEST['filter_key']);

$deliverable['additional_fields'] = unserialize($deliverable['type_details']['additional_fields']);

/*
echo "<pre>";
var_dump($deliverable);
echo "</pre>";
*/

 ?>
<div class="section group"> <!-- ROW -->
    <div class="col span_8_of_12"> <!-- Column -->
 <form id="paid_mem_form">
 <input type="hidden" id="data_id" name="data[id]" value="<?php echo $deliverable['id'] ?>" />
<div class="ui-widget-header ui-corner-top" >
<h2 style="text-align: center; margin-top: 5px; margin-bottom: 5px;"><?php echo $title; ?> </h2>
</div>
<div class="ui-widget ui-widget-content  ui-corner-bottom dbui-frame" style="padding: 5px;" >
     <p><strong>Warning!</strong> you are about to delete an auhtorization deliverable.
    <br />Existing authorizaitons with this deliverable code will continue to function.
    <br />It Will be removed from any manifests and you will not be able to deliver new ones.
    <br />Deleting this will not impact existing payouts.
    <br />
     </p>

<div class="section group"> <!-- ROW -->
    <div class="col span_3_of_12"> <!-- Column -->
        <label>Deliverable Code</label>
        <input type="text" name="data[deliverable_code]" readonly="readonly" value="<?php echo $deliverable['deliverable_code'];  ?>" />
    </div> <!-- END Column -->
    <div class="col span_7_of_12"> <!-- Column -->
        <label>Membership Name</label>
        <input type="text" readonly="readonly"  name="data[name]" class="required" id="deliverable_name"  value="<?php echo $deliverable['name'];  ?>" />
    </div> <!-- END Column -->
</div> <!-- END ROW -->

<div class="section group"> <!-- ROW -->
    <div class="col span_12_of_12"> <!-- Column -->
    <label>Description of Membership</label>
    <textarea readonly="readonly" name="data[description]"  id="deliverable_description"  ><?php echo $deliverable['description']; ?></textarea>
    </div> <!-- END Column -->
</div> <!-- END ROW -->
<div class="section group"> <!-- ROW -->
    <div class="col span_4_of_12"> <!-- Column -->
    
                 <label for="role_type">Registration or Role Only? </label>
                 <input type="text" readonly="readonly" value="<?php echo $deliverable['additional_fields']['role_type']; ?>" />

                
    </div> <!-- END Column -->
    <div class="col span_4_of_12"> <!-- Column -->
                <label for="role_delivered">Delivered Role</label>
                <input type="text" readonly="readonly" value="<?php echo $deliverable['additional_fields']['role_delivered']; ?>" />
            
    
    
    </div> <!-- END Column -->
    <div class="col span_4_of_12"> <!-- Column -->
        <label for="role_at_expiration">Role at Expiration: </label> 
            <input type="text" readonly="readonly" value="<?php echo $deliverable['additional_fields']['role_at_expiration']; ?>" />

    </div> <!-- END Column -->
</div> <!-- END ROW -->


<div class="section group"> <!-- ROW -->
    <div class="col span_12_of_12"> <!-- Column -->
    <hr />
    <label>Schedule for Duration and Renewal of Authorization</label>
    </div> <!-- END Column -->
</div> <!-- END ROW -->
<div class="section group"> <!-- ROW -->
    <div class="col span_3_of_12"> <!-- Column -->
        <label>Start Date/Time</label>
    </div> <!-- END Column -->
    <div class="col span_2_of_12"> <!-- Column -->
        <label>Availablity</label>
    </div> <!-- END Column -->
    <div class="col span_2_of_12"> <!-- Column -->
        <label>Duration</label>
     </div> <!-- END Column -->

    <div class="col span_3_of_12"> <!-- Column -->
        <label>Renewal Cycle</label>
    </div> <!-- END Column -->
    
        <div class="col span_2_of_12"> <!-- Column -->
        <label>Total Re-Auth</label>
    </div> <!-- END Column -->
</div> <!-- END ROW -->

<div class="section group"> <!-- ROW -->
    <div class="col span_3_of_12"> <!-- Column -->
         <input type="text" readonly="readonly"  class=""  id="start_time"  value="" /><br />
         
    </div> <!-- END Column --> 
    <div class="col span_2_of_12"> <!-- Column -->
         <input type="text" readonly="readonly"  name="data[first_delivery]" class="number"  id="first_delivery"  value="<?php echo $deliverable['schedule']['first_delivery'];  ?>" />
    </div> <!-- END Column -->
    <div class="col span_2_of_12"> <!-- Column -->
        <input type="text" readonly="readonly"  name="data[duration]" class="number" id="deliverable_duration"  value="<?php echo $deliverable['type_details']['duration'];  ?>" />
    </div> <!-- END Column -->

    <div class="col span_3_of_12"> <!-- Column -->
        <input type="text" readonly="readonly" value="<?php echo $deliverable['schedule']['delivery_cycle'];  ?>" /> 

        
    </div> <!-- END Column -->
    <div class="col span_2_of_12"> <!-- Column -->
        <?php 
            if ($deliverable['schedule']['maximum_deliveries'] <= 0)
                $max_del = '';
            else
                $max_del = $deliverable['schedule']['maximum_deliveries'];
        ?>
        <input type="text" readonly="readonly" name="data[maximum_deliveries]" class="number"  id="maximum_deliveries"  value="<?php echo $max_del;  ?>" />
    </div> <!-- END Column -->
</div> <!-- END ROW -->
<div class="section group"> <!-- ROW -->
    <div class="col span_6_of_12"> <!-- Column -->
    <a href="javascript:void(0);"  onclick="del_deliv();"
class="ui-button  icon_left_button button_link  ui-state-default ui-corner-all"  >
<span class="ui-icon  ui-icon-circle-close"></span> 
Confirm Delete</a>
    <a href="javascript:void(0);"  onclick="load_feature_screen('AreteX Subscriptions and Memberships','mem_mgm');"
class="ui-button  icon_left_button button_link  ui-state-default ui-corner-all"  >
<span class="ui-icon  ui-icon-cancel"></span> 
Cancel</a>
    </div> <!-- END Column -->
</div> <!-- END ROW -->



<pre>
<?php

//var_dump($_REQUEST);



//var_dump($deliverable);


?>
</pre>

</form>
</div>
</div> <!-- END Column -->
    <div class="col span_4_of_12"> <!-- Column -->

<div class="ui-widget ui-widget-content  ui-corner-all container" >
<strong>Confirm Delete Membership Authorization</strong>
<p>Look it over, confirm at the bottom</p>
</div>
    </div> <!-- END Column -->
</div> <!-- END ROW --> 
 <script>
    // Credit: http://css-tricks.com/forums/topic/jquery-read-more-less-toggle/
  // Hide the extra content initially, using JS so that if JS is disabled, no problemo:
    jQuery('.read-more-content').addClass('hide')
    jQuery('.read-more-show, .read-more-hide').removeClass('hide')
    
    // Set up the toggle effect:
    jQuery('.read-more-show').on('click', function(e) {
      jQuery(this).next('.read-more-content').removeClass('hide');
      jQuery(this).addClass('hide');
      e.preventDefault();
    });
    
    // Changes contributed by @diego-rzg
    jQuery('.read-more-hide').on('click', function(e) {
      var p = jQuery(this).parent('.read-more-content');
      p.addClass('hide');
      p.prev('.read-more-show').removeClass('hide'); // Hide only the preceding "Read More"
      e.preventDefault();
    });
    
 
 function del_deliv() {
    
    var id = jQuery('#data_id').val();
        
    
    var form_data = jQuery('#paid_content_form').serialize();
    jQuery.ajax({
              type: 'POST',
              url: ajaxurl,
              async: false, // Yes, the A is for Asyncronous... but the X is for XML.
              dataType: 'json',
              data:
              {
                  action: 'atx_del_pdcnt_delv',
                  id: id
              },
              success: function(data){
                console.log(data);                    
                if (data == "OK") {
                  alert("OK");  
                  load_feature_screen('AreteX Paid Content','pdcnt_mgm');
                }
                else {
                    is_valid = false;
                    alert(data);
                }
                
              }
              
            });
     
    
       
    
 }   
    
 </script>

