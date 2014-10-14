<strong>Edit a Product</strong>
<div class="folding-container">
<div style="margin-top: 8px; font-size: 110%; font-weight: bold; font-style: italic;">
Product Presentation
</div>
<div id="product_pres_help" class="expanding-frame">
<p><strong>Product Code:</strong> Unique, short identifier.</p>
<p><strong>Product Name: </strong> Name of product shows up on invoice</p>
<p><strong>Notes and Details:</strong> (Basic HTML is allowed) </p>
<div style="padding: 3px;">
<strong>Description:</strong> General textual description of product.<br />
<strong>Line Item Note:</strong> Goes into the receipt below the item name.<br />
<strong>Top Note:</strong> Goes near the top of the receipt under "Important Notes".<br />
<strong>Terms Note:</strong> Goes at the bottom of the receipt under the "Terms" label.
</div>
<p><strong>Pricing Model: </strong> Select how you wish to recieve payment for the product.</p>
<div id="price_detail_help">
</div>
</div>
<div style="margin-top: 8px; font-size: 110%; font-weight: bold; font-style: italic;">Product Delivery</div>
<div id="product_delv_help" class="expanding-frame">
<p><strong>Delivery Manifest:</strong> The compiled list of deliverables and the delivery schedule. 
If the <strong>Delivery Manifest</strong> box is blank, you may use it as a search box. Begin typing a manifest 
code, or description, and list will appear for you to choose from.  
For a complete list of current Delivery Manifests go to the <em>Delivery Specifications</em> menu button. Be 
sure to <em>Save</em> your work.<br />

To <em>Create</em> a new Manifest or <em>Edit</em> your current Manifest, click the appropriate button.
</p>
</div>
<div style="margin-top: 8px; font-size: 110%; font-weight: bold; font-style: italic;">Actual Contributor Payouts</div>
<div id="product_payout_help" class="expanding-frame">
<p><strong>Actual Contributor Payouts:</strong>  Identifies who and how much is paid each time this product is 
sold (or paid for in re-bill). You may copy the payout plans from the deliverables in the manifest, or go to the <em><strong>Manage Contributors</strong></em> button to add or modify paid contributors for this product.
When you copy, you may <em><strong>Replace</strong></em> the current Contributor Payout list, or <em><strong>Append</strong></em> to it.   
</p>
<p></p>
</div>
</div>
<p>
<hr />
<em>Reminder:</em>All product and catalog data are stored on the AreteX&trade; server.</p>
<script>
jQuery(document).ready(function() {
   var pm = jQuery('#pricing_model').val();
    load_pricing_help(pm);
    
    jQuery('#product_pres_help').show();
    
 });

</script>
