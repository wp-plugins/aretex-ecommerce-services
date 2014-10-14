<script>
function load_list_help() {
             jQuery('#payout_code_info').load('<?php echo plugins_url('payout_code_help/list_help.html',__FILE__); ?>');        

}  
</script>
<h3>Contributor Payout Templates</h3>
<div class="tabs">
<ul>
<li><a href="#tabs-1">Payout Templates</a></li>
<li><a href="#tabs-2">Help &amp; Information</a></li>
</ul>
<div id="tabs-1">
<div class="section group"> <!-- ROW -->
    <div class="col span_8_of_12"> <!-- Column -->
    
<div id="detail_screen">

<div id="inner_form">

</div> 


</div>
</div> <!-- END Column -->
    <div class="col span_4_of_12"> <!-- Column -->
    

<div id="payout_code_info" class="ui-widget ui-widget-content  ui-corner-all container dbui-frame" >
       
&nbsp;
</div>

    </div> <!-- END Column -->

</div> <!-- END ROW -->

</div>
<div id="tabs-2">
<h2>Contributor Payout Template Help and Information</h2>

<p><strong>Payee Distinction:</strong>  In AreteX there are two types of payout groups - referrers and contributors.
    <ul style="text-indent: -1.0em; margin-left: 1.5em; font-size: 12px;">  
    <li><strong>Referrers</strong> - commissioned sales reps, affiliates, etc.  This group is paid off of the gross of a sale.  It is figured off of Offers you create and which are associated with commission groups.  Individual referrers are associated with groups.  Offers are associated with groups.  Therefore, individual referrers are paid commissions according to the group they are associated with.</li>
    <li><strong>Contributors</strong> - those who earn royalties, fees, or wholesale payments on a 
    product, materials, etc.  These people are paid off of either the net or the gross, according to the 
    agreement you have with your contributors.  Contributor Payout Templates are linked to individual items 
    or products, not to contributors themselves.  Individual contributors are linked to individual items or 
    products.  Therefore, contributors are paid a predetermined amount, based on the amount (percentage or fixed)
     you build into the product definition.</li>
   </ul>  
</p>

<p><em><strong>Note 1:</strong></em> An AreteX&trade; Contributor is not necessarily the same thing as a WordPress Contributor, though that is common.
</p>
<p><em><strong>Note 2:</strong></em> In AreteX&trade; all commission payouts are built off of a percent of gross of a sale.  Contributor payouts may be figured off of either the net or gross of the sale of a product, or be a fixed amount.
</p>
<p><em><strong>Note 3:</strong></em> Contributors can be assigned to products in the <em>Catalog &amp; Products / Products / Edit (<strong>pencil</strong>)</em> screens.  
They can be assigned when creating or editing deliverables in <em>Catalog &amp; Products / Delivery Specifications / Deliverables (Appropriate Deliverable) </em>.
</p>
<p>
<strong>Why Use Contributor Payout Templates?</strong>
</p>

<p>A Payout Template is a short, unique identifier for a particular contributor payout policy. They can be used to:

   <br />- Make it Easier to setup Contributor Payouts according to your agreements or policy
   <br />- Are assigned particular Deliverable(s), which make up a Product(s)
</p>
<p>Although not strictly necessary, Contributor Payout Templates can help you standardize how you pay your 
contributors, making your life easier.  This is especially true if you have a number of contributors or a lot 
of products.
</p>
</div>
<script>
jQuery('.tabs').tabs();
function show_payout_code_help(screen) {
            var payout_help_url = '<?php echo plugins_url('payout_code_help',__FILE__); ?>/'+screen+'.html';
            jQuery('#payout_code_info').load(payout_help_url);        

}

load_screen('payout_codes');

</script>