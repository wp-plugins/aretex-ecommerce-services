<?php
$aretex_core_path = get_option('aretex_core_path');
require_once($aretex_core_path.'AreteX_WPI_DI.class.php');

$title = "Edit Paid Membership Authorization";
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
 <input type="hidden" value="<?php echo $deliverable['id'] ?>" />
<div class="ui-widget-header ui-corner-top" >
<h2 style="text-align: center; margin-top: 5px; margin-bottom: 5px;"><?php echo $title; ?> </h2>
</div>
<div class="ui-widget ui-widget-content  ui-corner-bottom dbui-frame" style="padding: 5px;" >


<div class="section group"> <!-- ROW -->
    <div class="col span_3_of_12"> <!-- Column -->
        <label>
        Deliverable Code</label>
        <input type="text" name="data[deliverable_code]" readonly="readonly" value="<?php echo $deliverable['deliverable_code'];  ?>" />
    </div> <!-- END Column -->
    <div class="col span_7_of_12"> <!-- Column -->
        <label>
        Membership Name</label>
        <input type="text"  name="data[name]" class="required" id="deliverable_name"  value="<?php echo $deliverable['name'];  ?>" />
    </div> <!-- END Column -->
</div> <!-- END ROW -->

<div class="section group"> <!-- ROW -->
    <div class="col span_12_of_12"> <!-- Column -->
    <label>Description of Membership</label>
    <textarea name="data[description]"  id="deliverable_description"  ><?php echo $deliverable['description']; ?></textarea>
    </div> <!-- END Column -->
</div> <!-- END ROW -->
<div class="section group"> <!-- ROW -->
    <div class="col span_4_of_12"> <!-- Column -->
    

                <label for="role_type">Registration or Role Only? </label>
                <select required="required"  id="role_type" name="data[role_type]" >
                    <option value="reg_role">Register with Role</option>                   
                    <option value="role_only">Role Only</option>
                </select> 
                <script>
                    jQuery('#role_type').val('<?php echo $deliverable['additional_fields']['role_type']; ?>');
                </script>
    </div> <!-- END Column -->
    <div class="col span_4_of_12"> <!-- Column -->
                <label for="role_delivered">Select Delivered Role</label>
                <select required="required"  id="role_delivered" name="data[role_delivered]" >
                <?php  global $wp_roles;
                    $default_role = get_option('default_role');
                    if (is_array($wp_roles->roles)) {
                        $hidden_roles = get_option('aretex_pdsub_hidden_roles',array());
                        foreach ($wp_roles->roles as $key=>$role) {
                            if (in_array($key,$hidden_roles))
                                continue;
                            $sel = '';
                            $name = $role['name'];
                            if ($key == $default_role) {
                                 $sel = 'selected="selected"';
                                 $name .= ' - Default';
                            }
                               
                            echo "<option value=\"$key\" $sel>$name</option>\n";
                        }
                        
                    }
                     
                
                ?>
                </select>
                <script>
                    jQuery('#role_delivered').val('<?php echo $deliverable['additional_fields']['role_delivered']; ?>');
                </script>
                   
    
    
    </div> <!-- END Column -->
    <div class="col span_4_of_12"> <!-- Column -->
        <label for="role_at_expiration">Role at Expiration: </label> 
            <select required="required"  id="role_at_expiration" name="data[role_at_expiration]" >
                <option value="none">None - User is "Locked Out"</option>
                <?php  global $wp_roles;
                    $default_role = get_option('default_role');
                    $hidden_roles = get_option('aretex_pdsub_hidden_roles',array());
                    if (is_array($wp_roles->roles)) {
                        foreach ($wp_roles->roles as $key=>$role) {
                            if (in_array($key,$hidden_roles))
                                continue;
                            $sel = '';
                            $name = $role['name'];
                            if ($key == $default_role) {
                                 $sel = 'selected="selected"';
                                 $name .= ' - Default';
                            }
                               
                            echo "<option value=\"$key\" $sel>$name</option>\n";
                        }
                        
                    }
                     
                
                ?>
            </select>
            <script>
                jQuery('#role_at_expiration').val('<?php echo $deliverable['additional_fields']['role_at_expiration']; ?>');
            </script> 
    </div> <!-- END Column -->
</div> <!-- END ROW -->
<div class="section group"> <!-- ROW -->
    <div class="col span_12_of_12"> <!-- Column -->
    If you chooose "Register with Role" the selected role is assigned  when authorization (usually payment) has been confirmed.
    <a class="read-more-show hide" href="#">(More)</a> 
    <span class="read-more-content"> With "Role Only" a member who is already registered may pay to 
    have his or her role changed (usually an upgrade). <a class="read-more-hide hide" href="#">(Less)</a></span>
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
         <input type="text"  class="datetime"  id="start_time" name="data[start_time]" value="<?php echo $deliverable['schedule']['start_time'];  ?>" /><br />
         <span style="font-size: 11px;">(YYYY-MM-DD HH:MM)</span>
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
    <a href="javascript:void(0);"  onclick="load_feature_screen('AreteX Subscriptions and Memberships','mem_mgm');"
class="ui-button  icon_left_button button_link  ui-state-default ui-corner-all"  >
<span class="ui-icon  ui-icon-cancel"></span> 
Cancel</a>
    </div> <!-- END Column -->
</div> <!-- END ROW -->
<div class="section group"> <!-- ROW -->
    <div class="col span_12_of_12"> <!-- Column -->
    <hr />
    <label>Contributor Payouts Plan</label>
    </div> <!-- END Column -->
</div> <!-- END ROW -->
<div class="section group"> <!-- ROW -->
    <div class="col span_2_of_12"> <!-- Column -->
    <a href="#"  onclick="payout_code2('<?php echo $deliverable['deliverable_code']; ?>');" class="icon_center_button_sm  ui-button button_link  ui-state-default ui-corner-all">

<img src="<? echo  plugins_url( '../../../images/actions/wire_transfer_30.png', __FILE__ ) ?>" /><br />
Deliverable
Payouts Plan
</a>

<script>
        function payout_code2(deliverable_code) {
            var back_screen = {
                'feature' : 'AreteX Subscriptions and Memberships',
                'screen'  : 'edit_mem' 
            }
            load_linked_screen_back('deliverable_payouts',deliverable_code,back_screen);
        }
        
        

</script>
    </div> <!-- END Column -->
    <div class="col span_8_of_12"> <!-- Column -->
    <p>Use this button to create a plan of who may be paid when a product containing this deliverable in its manifest is sold. Don't forget to <em>Copy</em> to <em>Actual Contributor Payouts</em> when you are completing the assembly of your Product. (You may modify your plan for each specific product after you copy it without impacting the original plan.)</p>
    </div>
    
</div> <!-- END ROW -->

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
<strong>Edit Paid Membership Help</strong>

<p><strong>Membership Name/Description</strong> - Meaningful words or phrases for this Deliverable.
</p>
<p><strong>Registration or Role Only?</strong> - If you chooose "Register with Role" the selected role is assigned when authorization (usually payment) has been confirmed. With "Role Only" a member who is already registered may pay to have his or her role changed (usually an upgrade). 
</p>
<p><strong>Select Delivered Role/Role at Expiration</strong> - The Role(s) you desire must already exist in WordPress Roels and Capabilities before chosen here.
</p>

<p><strong>Start Date/Time</strong> - The specific date and time you wish the membership or subscription to begin.  If you leave this field blank, it will be delivered immediately upon payment.  If you insert a date but not a time, the default time will be midnight +1 second on the date of delivery.  
</p>
<p><strong>Availability</strong> - If you wish to have "wait" days before delivering (most useful when no start date is specified) insert them here.  Otherwise leave at 0 for immediate delivery according to the Start Date.
</p>
<p><strong>Duration</strong> - Enter into this box how many days your customer will be a member of the specified role (subscription length).  Leaving blank will assume that the availability does not expire.
</p>
<p><strong>Re-authorization Cycle </strong>- This is the frequency you wish AreteX to check the validity of your customer's authorization.  Note: "Single" means that AreteX will not check for a valid Authorization after the initial delivery.
</p>
<p><strong>Total ReAuth</strong> - If you chose a Re-Authorization Cycle, you may enter how many re-authorizations you want AreteX to perform.
</p>
<p>Be sure to <em>Save</em> your work or <em>Cancel</em>.
</p>
<p>To link a <strong>Contributor</strong> to this Deliverable, select the <em>Deliverable Payouts Plan</em> button at the bottom of your screen.
</p>
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
    
 
 function save_deliv() {
    
    jQuery('#paid_mem_form').validate();
    if (jQuery('#paid_mem_form').valid() )
    {
        var form_data = jQuery('#paid_mem_form').serialize();
        jQuery.ajax({
                  type: 'POST',
                  url: ajaxurl,
                  async: false, // Yes, the A is for Asyncronous... but the X is for XML.
                  dataType: 'json',
                  data:
                  {
                      action: 'atx_save_mem_delv',
                      data: form_data
                  },
                  success: function(data){
                    console.log(data);                    
                    if (data.deliverable_code) {
                      load_feature_screen('AreteX Subscriptions and Memberships','mem_mgm');
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

