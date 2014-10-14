<h3>Paid Content Authorization</h3>
<a href="javascript:void(0);" id="add_pc_btn"  onclick="add_a_pc_deliverable();"
class="ui-button  icon_left_button button_link  ui-state-default ui-corner-all"  >
<span class="ui-icon  ui-icon-circle-plus"></span> 
Add a Paid Content Deliverable</a>

<a href="javascript:void(0);" id="pcmgm_btn"  onclick="mg_pc_deliverable();"
class="ui-button  icon_left_button button_link  ui-state-default ui-corner-all"  >
<span class="ui-icon  ui-icon-circle-arrow-w"></span> 
Back</a>

<div class="section group"> <!-- ROW -->
    <div class="col span_8_of_12"> <!-- Column -->

        <div id="feature_detail">
        
        </div>

    </div> <!-- END Column -->
    <div class="col span_4_of_12"> <!-- Column -->

        <div class="ui-widget ui-widget-content  ui-corner-all container" >
        <strong>Paid Content</strong>
         <p>Explain Paid Content "Deliverable" Here... 
<br/>Explain how this works with Word Press "Short Codes". 
<br/>Explain how this works with Manifests.
<br/>Explain how this works with Contributor Payouts
<br/>Explain how this works with Products. 
        </div>
    </div> <!-- END Column -->
</div> <!-- END ROW -->
<script>
jQuery('#pcmgm_btn').hide();
load_feature_sub_screen('AreteX Paid Content','pdcnt_mgm');

function mg_pc_deliverable() {
    jQuery('#pcmgm_btn').hide();
    jQuery('#add_pc_btn').show();
    load_feature_sub_screen('AreteX Paid Content','pdcnt_mgm');
}

function add_a_pc_deliverable() {
    jQuery('#add_pc_btn').hide();
    jQuery('#pcmgm_btn').show();
    load_feature_sub_screen('AreteX Paid Content','new_pc_deliv');
    
}
</script>