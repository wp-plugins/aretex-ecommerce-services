<h3>Paid Content Authorization</h3>
<a href="javascript:void(0);" id="add_pc_btn"  onclick="add_a_pc_deliverable();"
class="ui-button  icon_left_button button_link  ui-state-default ui-corner-all"  >
<span class="ui-icon  ui-icon-circle-plus"></span> 
Add a Paid Content Deliverable</a>
<div class="section group"> <!-- ROW -->
    <div class="col span_8_of_12"> <!-- Column -->

<div class="ui-widget-header ui-corner-top" >
<h2 style="text-align: center; margin-top: 5px; margin-bottom: 5px;">Paid Content Authorization Management</h2>
</div>
<div class="ui-widget ui-widget-content  ui-corner-bottom" >
<?php

echo AreteX_paid_content::paid_content_list();


?>
</div>

 </div> <!-- END Column -->
    <div class="col span_4_of_12"> <!-- Column -->

        <div class="ui-widget ui-widget-content  ui-corner-all container" >
        
        <strong>Paid Content Help</strong>

<p><em>Paid Content "Deliverable"</em> - Any individual piece of Product content for which you expect to receive payment.  (Deliverables are used to build <em>Manifests</em>, which are used to define <em>Products</em>.)
</p>
<p>The AreteX plugin uses shortcodes for each Deliverable so that you can define how your Product content is displayed from marketing to delivery.  
This allows you to use the shortcodes in various ways, as well as keep your customers informed of the delivery status of different pieces of the total product. (See <em>Edit Content Authorization (<strong>Pencil</strong>)/WP Shortcodes (Button) /Valid Status Values (Table).</em>)
</p>
<p>For a more complete view of Paid Content shortcodes see <em>WP Integration / Shortcodes &amp; Widget / Product Presentation / Paid Content</em>.</p>
<p>A Paid Content Deliverable, then, is like a building block.  It is made up of many elements including
<ol > 
    <li>the unique Deliverable Code,</li> 
    <li>a Name and Description that are readily recognizable to you and which are tied to the Deliverable,</li>   
    <li> a Contributor link for appropriate payment tracking, and</li>   
    <li> a shortcode specifically associated with the Deliverable.</li>
</ol>
</p>
<p>The complete Paid Content Deliverable component is then ready to be used in building a Manifest for a Product.
</p>
<p><strong>Table Notes:</strong><br />
<strong>Edit Content Authorization</strong> (<strong><em>Pencil</em></strong>) - Select this icon to edit the specific elements of your Deliverable.
</p>
<p><strong>Edit Payouts <em>(Dollar/Arrow)</em></strong> - Select this icon to edit the list of contributors and their fees/payments.
</p>
<p><strong>Delete <em>(Trashcan)</em></strong> - Delete the Deliverable entry.  You will be given the opportunity to confirm.
</p>        
        </div>
    </div> <!-- END Column -->
</div> <!-- END ROW -->
<script>


function add_a_pc_deliverable() {
   
    load_feature_screen('AreteX Paid Content','new_pc_deliv');
    
}
</script>