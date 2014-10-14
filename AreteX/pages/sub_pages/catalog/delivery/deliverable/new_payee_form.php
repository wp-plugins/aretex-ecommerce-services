<?php 
        $ajax_url = get_option('aretex_bas_endpoint');
        $ajax_url .= '/dbui/dbui_ajax_JSON.php';
        $just_url = $ajax_url;
               
        $access_token = AreteX_WPI::ajaxAccessToken(); 
        $ajax_url .= '?aretex_ajax_auth='.$access_token;
?>        
        <div class=" ui-widget-content ui-corner-all">
        <div class="ui-widget-header"><h3 class="form_view_title"> Add New Contributor Payee</h3></div>
        <div class="dbui-frame">
        <form id="frm_53e63dd708a03">
        <div class="section group">
<div class="col span_1_of_12">&nbsp</div>
<div class="col span_10_of_12">
<div class="section group">
<div class="col span_1_of_2">
<label for="payee_name">Payee Name</label><input name="data[name]" type="text" class="text ui-widget-content ui-corner-all   required"  id="payee_name" value="" style="width:100%;" /></div>
<div class="section group">
<div class="col span_12_of_12">
<label for="payee_address">Address</label><textarea name="data[address]"   class="text ui-widget-content ui-corner-all  required" id="payee_address" style="width:100%;"  ></textarea>
</div>
</div><!-- End Row -->
<div class="section group">
<div class="col span_1_of_3">
<label for="payee_phone">Contact phone</label><input name="data[phone]" type="text" class="text ui-widget-content ui-corner-all   phoneUS"  id="payee_phone" value="" style="width:100%;" /></div>
<div class="col span_1_of_3">
<label for="contact_email">Contact Email</label><input name="data[contact_email]" type="text" class="text ui-widget-content ui-corner-all   required email"  id="contact_email" value="" style="width:100%;" /></div>
<div class="col span_1_of_3">
<label for="fld_53e63dd708bae">Status</label><select  id="fld_53e63dd708bae" name="data[status]"><option value="Active" >Active</option>
<option value="Pending" >Pending</option>
<option value="Suspended" >Suspended</option>
</select></div>
</div><!-- End Row -->
<div class="section group">
<div class="col span_1_of_2">
<label for="fld_53e63dd708c17">Word Press User Name</label>
<input type="text"  id="wp_user_name"  value="" />
<input type="hidden"   id="other_id_1" name="data[other_id_1]" value="" />

<script>


set_wpu_search('#wp_user_name');
set_auth_context('<?php echo $just_url; ?>','<?php echo $access_token; ?>','new_payee_1','<?php echo plugins_url( '[slug]' , __FILE__ ); ?>');

</script>    
</div>
<div class="col span_1_of_2">
<label for="fld_53e63dd708c73">Tax Forms On File?</label><select  id="fld_53e63dd708c73" name="data[w9]"><option value="No" >No</option>
<option value="Yes" >Yes</option>
</select></div>
</div><!-- End Row -->

<input type="hidden" name="cmd" value="Save"/><input type="hidden" name="view" value="Form" />
<input type="hidden" name="config_id" value="new_payee_1" /><div class="section group">
<script>

</script><div class="col span_1_of_6">
<a href="javascript:void(0);"  onclick="save_new_payee('<?php echo $ajax_url; ?>');"   class="icon_left_button  ui-button button_link  ui-state-default ui-corner-all"  ><span class="ui-icon ui-icon-disk"></span>Save</a></div><div class="col span_1_of_6">
<a href="javascript:void(0);"  onclick="jQuery('#frm_53e63dd708a03')[0].reset(); jQuery('#new_payee').hide();"  class="icon_left_button  ui-button button_link  ui-state-default ui-corner-all"  ><span class="ui-icon ui-icon-cancel"></span>Cancel</a></div></div>
</div><div class="col span_1_of_12">&nbsp;</div>
</div>        
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
         </script>
        </form>
        </div>
        </div> 
        </div>       