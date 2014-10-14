<?php
$aretex_core_path = get_option('aretex_core_path');
require_once($aretex_core_path.'AreteX_WPI_DI.class.php');

$title = "Edit Paid Content Authorization";
$deliverable = AreteX_WPI_DI::get_deliverables_by_id($_REQUEST['filter_key']);

   // Data Array: name,description,deliverable_code,required_payment_status ,first_delivery, delivery_cycle, maximum_deliveries, duration



 ?>
<div class="section group"> <!-- ROW -->
    <div class="col span_8_of_12"> <!-- Column -->

 <form id="paid_content_form" accept-charset="javascript:void(0);">
 <input type="hidden" value="<?php echo $deliverable['id'] ?>" />
<div class="ui-widget-header ui-corner-top" >
<h2 style="text-align: center; margin-top: 5px; margin-bottom: 5px;"><?php echo $title; ?> </h2>
</div>
<div class="ui-widget ui-widget-content  ui-corner-bottom dbui-frame" style="padding: 5px;" >

<div class="section group"> <!-- ROW -->
    <div class="col span_3_of_12"> <!-- Column -->
        <label>Deliverable Code</label>
        <input type="text" name="data[deliverable_code]" readonly="readonly" value="<?php echo $deliverable['deliverable_code'];  ?>" />
    </div> <!-- END Column -->
    <div class="col span_7_of_12"> <!-- Column -->
        <label>Content Name</label>
        <input type="text"  name="data[name]" class="required" id="deliverable_name"  value="<?php echo $deliverable['name'];  ?>" />
    </div> <!-- END Column -->
</div> <!-- END ROW -->

<div class="section group"> <!-- ROW -->
    <div class="col span_12_of_12"> <!-- Column -->
    <label>Description</label>
    <textarea name="data[description]"  id="deliverable_description"  ><?php echo $deliverable['description']; ?></textarea>
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
        <label>
        Duration</label>
     </div> <!-- END Column -->

    <div class="col span_3_of_12"> <!-- Column -->
        <label>
        Re-Authorization Cycle</label>
    </div> <!-- END Column -->
    
        <div class="col span_2_of_12"> <!-- Column -->
        <label>Total Re-Auth</label>
    </div> <!-- END Column -->
</div> <!-- END ROW -->

<div class="section group"> <!-- ROW -->
<div class="col span_3_of_12"> <!-- Column -->
         <input type="text"  class=""  name="data[start_time]" id="start_time"  value="<?php echo $deliverable['schedule']['start_time'];  ?>" /><br />
         <span style="font-size: 11px;">(YYYY-MM-DD HH:MM:SS)</span>
    </div> <!-- END Column -->

    <div class="col span_2_of_12"> <!-- Column -->
         <input type="text"  name="data[first_delivery]" class="number"  id="first_delivery"  value="<?php echo $deliverable['schedule']['first_delivery'];  ?>" />
         <br /><span style="font-size: 11px;">(Days after start)</span>
    </div> <!-- END Column -->
    <div class="col span_2_of_12"> <!-- Column -->
        <input type="text"  name="data[duration]" class="number" id="deliverable_duration"  value="<?php echo $deliverable['type_details']['duration'];  ?>" />
    </div> <!-- END Column -->

    <div class="col span_3_of_12"> <!-- Column -->
         
        <select id="delivery_cycle" name="data[delivery_cycle]" class="required" style="display: inline-block;">
                    <option value="single">Single</option>
                    <optgroup label="Recurring">
                        <option value="daily">Daily</option>
                        <option value="weekly">Weekly</option>
                        <option value="monthly" selected="selected">Monthly</option>
                        <option value="quarterly">Quarterly</option>
                        <option value="yearly">Yearly</option>
                    </optgroup>
        </select>
        <script>
            jQuery('#delivery_cycle').val('<?php echo $deliverable['schedule']['delivery_cycle'];  ?>');
        </script>
        
    </div> <!-- END Column -->
    <div class="col span_2_of_12"> <!-- Column -->
        <?php 
            if ($deliverable['schedule']['maximum_deliveries'] <= 0)
                $max_del = '';
            else
                $max_del = $deliverable['schedule']['maximum_deliveries'];
        ?>
        <input type="text"  name="data[maximum_deliveries]" class="number"  id="maximum_deliveries"  value="<?php echo $max_del;  ?>" />
    </div> <!-- END Column -->
</div> <!-- END ROW -->
<div class="section group"> <!-- ROW -->
    <div class="col span_6_of_12"> <!-- Column -->
    <a href="javascript:void(0);"  onclick="save_deliv();"
class="ui-button  icon_left_button button_link  ui-state-default ui-corner-all"  >
<span class="ui-icon  ui-icon-disk"></span> 
Save</a>
    <a href="javascript:void(0);"  onclick="load_feature_screen('AreteX Paid Content','pdcnt_mgm');"
class="ui-button  icon_left_button button_link  ui-state-default ui-corner-all"  >
<span class="ui-icon  ui-icon-cancel"></span> 
Cancel</a>
    </div> <!-- END Column -->
</div> <!-- END ROW -->
<div class="section group"> <!-- ROW -->
    <div class="col span_12_of_12"> <!-- Column -->
    <hr />
    <label>Additional Actions</label>
    </div> <!-- END Column -->
</div> <!-- END ROW -->
<div class="section group"> <!-- ROW -->
    <div class="col span_4_of_12"> <!-- Column -->
    <a href="#"  onclick="payout_code2('<?php echo $deliverable['deliverable_code']; ?>');" class="icon_center_button_sm  ui-button button_link  ui-state-default ui-corner-all">

<img src="<? echo  plugins_url( '../../../images/actions/wire_transfer_30.png', __FILE__ ) ?>" /><br />
Deliverable
Payout Plan
</a>
<a href="javascript:void(0);"  onclick="short_codes('<?php echo $deliverable['deliverable_code']; ?>');" class="icon_center_button_sm  ui-button button_link  ui-state-default ui-corner-all">

<img src="<? echo  plugins_url( '../../../images/actions/text_box_30.png', __FILE__ ) ?>" /><br />
WP Shortcodes<br />
&nbsp;
</a>
<script>
        function payout_code2(deliverable_code) {
            var back_screen = {
                'feature' : 'AreteX Paid Content',
                'screen'  : 'edit_pd_cnt' 
            }
            load_linked_screen_back('deliverable_payouts',deliverable_code,back_screen);
        }
        
        function short_codes(deliverable_code) {
           jQuery('#show_short_code_example').toggle();
        }

</script>
    </div> <!-- END Column -->
</div> <!-- END ROW -->
<div>
<?php echo AreteX_paid_content::short_code_examples($deliverable['deliverable_code']); ?>
</div>
<pre>
<?php

//var_dump($_REQUEST);



//var_dump($deliverable);


?>
</pre>
</div>
</form>
</div> <!-- END Column -->
    <div class="col span_4_of_12"> <!-- Column -->

<div class="ui-widget ui-widget-content  ui-corner-all container" >
<strong>Edit Paid Content Help</strong>



<p><strong>Content Name/Description </strong>- Meaningful words or phrases for this Deliverable.
</p>
<p><strong>Start Date/Time</strong> - The specific date and time you wish the content to be available or subscription to begin.  If you leave this field blank, it will be delivered immediately upon payment.  If you insert a date but not a time, the default time will be midnight +1 second on the date of delivery.  
</p>
<p><strong>Availability</strong> - If you wish to have "wait" days before delivering (most useful when no start date is specified) insert them here.  Otherwise leave at 0 for delivery according to the Start Date and payment.
</p>
<p><strong>Duration</strong> - Enter into this box how many days your customer will have access to the content.  Leaving blank will assume that the availability does not expire.
</p>
<p><strong>Re-authorization Cycle</strong> - This is the frequency you wish AreteX to check the validity of your customer's authorization.  Note: "Single" means that AreteX will not check for a valid Authorization after the initial delivery.
</p>
<p><strong>Total ReAuth</strong> - If you chose a <strong>Re-Authorization Cycle</strong>, you may enter how many re-authorizations you want AreteX&trade; to perform.
</p>
<p>Be sure to <em>Save</em> your work or <em>Cancel</em>.</p>

<p><strong>Delieverable Payout Plan</strong> - To link a <em>Contributor</em> to this <em>Deliverable</em>, select the <em>Deliverable Payout Plan</em> button at the bottom of your screen.
</p>
<p><strong>WP Shortcodes</strong> - Select the <em>WP Shortcodes</em> button to access shortcode examples and instructions.
</p></div>
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
    
 
 function save_deliv() {
    
    jQuery('#paid_content_form').validate();
    if (jQuery('#paid_content_form').valid() )
    {
        var form_data = jQuery('#paid_content_form').serialize();
        jQuery.ajax({
                  type: 'POST',
                  url: ajaxurl,
                  async: false, // Yes, the A is for Asyncronous... but the X is for XML.
                  dataType: 'json',
                  data:
                  {
                      action: 'atx_save_pdcnt_delv',
                      data: form_data
                  },
                  success: function(data){
                    console.log(data);                    
                    if (data.deliverable_code) {
                      load_feature_screen('AreteX Paid Content','pdcnt_mgm');
                    }
                    else {
                        is_valid = false;
                        alert(data);
                    }
                    
                  }
                  
                });
         
         return;
    }    
    
 }   
 
 jQuery('#show_short_code_example').hide();   
 </script>

