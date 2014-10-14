<h3>Paid Membership Authorization</h3>
<a href="javascript:void(0);" id="add_pc_btn"  onclick="add_a_mem_deliverable();"
class="ui-button  icon_left_button button_link  ui-state-default ui-corner-all"  >
<span class="ui-icon  ui-icon-circle-plus"></span> 
Add a Paid Membership Deliverable</a>
<div class="section group"> <!-- ROW -->
    <div class="col span_8_of_12"> <!-- Column -->

<div class="ui-widget-header ui-corner-top" >
<h2 style="text-align: center; margin-top: 5px; margin-bottom: 5px;">Paid Membership Management</h2>
</div>
<div class="ui-widget ui-widget-content  ui-corner-bottom" >
<?php

echo AreteX_paid_subscriptions::paid_subecription_list();


?>
</div>
 </div> <!-- END Column -->
    <div class="col span_4_of_12"> <!-- Column -->

        <div class="ui-widget ui-widget-content  ui-corner-all container" >
        
        <strong>Paid Membership Help</strong>

<p><em>Paid Membership "Deliverable</em>" - Any individual membership role for which you expect to receive payment.  (Deliverables are used to build Manifests, which are used to define Products.)  
</p>
<p>The WordPress Role must be defined in WordPress before creating this deliverable.
</p>
<p>Shortcodes used for Paid Membership differ from those used for Paid Content.  (See <em>WP Integration / Shortcodes &amp; Widget / Product Presentation / Membership</em> for details.)
</p>
<p>A Paid Membership Deliverable, then, is like a building block.  It is made up of many elements including 
 the unique Deliverable Code,
 <ol> 
<li> a Name and Description that are readily recognizable to you and which are tied to the Deliverable, </li> 
<li> a Contributor link for appropriate payment tracking, and</li> 
<li> a WordPress Role(s) specifically associated with the Deliverable.</li>
 </ol>
</p>
<p>The complete Paid Membership Deliverable component is then ready to be used in building a Manifest for a Product.
</p>
<p><em>Table Notes:</em><br />
<strong>Edit Membership Authorization (<em>Pencil</em>)</strong> - Select this icon to edit the specific elements of your Deliverable.
</p>
<p><strong>Edit Payouts <em>(Dollar/Arrow)</em> </strong>- Select this icon to edit the list of contributors and their fees/payments.
</p>
<p><strong>Delete <em>(Trashcan)</em></strong> - Delete the Deliverable entry.  You will be given the opportunity to confirm.
</p>
<p>Select <em>Add a Paid Membership Deliverable</em> to create a new membership deliverable.</p>
        
        
        
        </div>
    </div> <!-- END Column -->
</div> <!-- END ROW -->
<script>
function add_a_mem_deliverable() {
   
    load_feature_screen('AreteX Subscriptions and Memberships','new_memb_deliv');
    
}
</script>