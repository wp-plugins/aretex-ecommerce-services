<?php 

$biz = AreteX_WPI::getBusiness();

?>
<form id="biz_contact">
<div class="section group dbui-frame"> <!-- ROW -->
    <div class="col span_7_of_12"> <!-- Column -->
   
<div class="ui-widget-header ui-corner-top" >
<h2 style="text-align: center; margin-top: 5px; margin-bottom: 5px;">Business Contact Information</h2>
</div>
<div class="ui-widget ui-widget-content  ui-corner-bottom container" style="padding-right: 5px;" >
<div class="section group"> <!-- ROW -->
    <div class="col span_6_of_12"> <!-- Column -->
        <label>Business Name</label>
        <input name="_Business_Name_" class="required"  value="<?php echo $biz->Business_Name; ?>" />
    </div> <!-- END Column -->
    <div class="col span_6_of_12"> <!-- Column -->
        <label>Primary Contact Name</label>
        <input name="_Primary_Contact_Name_" class="required"  value=" <?php echo $biz->Primary_Contact_Name; ?>" />
    </div> <!-- END Column -->
    
</div> <!-- END ROW -->
<div class="section group"> <!-- ROW -->
     <div class="col span_12_of_12"> <!-- Column -->
    <label>Mailing Address</label>
    <textarea  style="margin-right: 3px;" name="_Mailing_Address_" class="required"><?php echo $biz->Mailing_Address; ?></textarea>
    
    </div> <!-- END Column -->

</div> <!-- END ROW -->
<div class="section group"> <!-- ROW -->
    <div class="col span_4_of_12"> <!-- Column -->
        <label>Primary Phone Number</label>
        <input name="_Primary_Phone_" class="required phoneUS"  value="<?php echo $biz->Primary_Phone; ?>" />

    </div> <!-- END Column -->
    <div class="col span_4_of_12"> <!-- Column -->
        <label>Customer Service Phone</label>
    <input name="_Customer_Service_Phone_" class="required phoneUS"  value="<?php echo $biz->Customer_Service_Phone; ?>" />

    </div> <!-- END Column -->
    
    <div class="col span_4_of_12"> <!-- Column -->
        <label>Text Message Phone</label>
    <input name="_Text_Message_Phone_" class="phoneUS"  value="<?php echo $biz->Text_Message_Phone; ?>" />
     <span style="font-size: 60%;">
        <em>Note:</em>If you leave this blank, AreteX&trade; will use your Primary or Alert Email Address for high priority alerts.
        </span>
    </div> <!-- END Column -->


</div> <!-- END ROW -->

<div class="section group"> <!-- ROW -->
    <div class="col span_4_of_12"> <!-- Column -->
        <label>Primary Email Address</label>
       <input class="readonly" value="<?php echo $biz->Email_Address; ?>" />
           
    </div> <!-- END Column -->
    <div class="col span_4_of_12"> <!-- Column -->
        <label>Customer Service Email</label>
        <input name="_Public_Email_Address_" class="email" value="<?php echo $biz->Public_Email_Address ?>" />
        <span style="font-size: 60%;">
        <em>Note:</em>If you leave this blank, AreteX&trade; will use your Primary Email Address as the return address for customer service emails.
        </span>
    </div> <!-- END Column -->
   
   <div class="col span_4_of_12"> <!-- Column -->
        <label>Alert Email Address</label>
        <input name="_Alert_Email_Address_" class="email" value="<?php echo $biz->Alert_Email_Address ?>" />
        <span style="font-size: 60%;">
        <em>Note:</em>If you leave this blank, AreteX&trade; will send automated alerts about problems to your Primary Email Address.
        </span>
    </div> <!-- END Column -->
    
</div> <!-- END ROW -->

<hr />
<a href="javascript:void(0);"  onclick="submit_act_info('#biz_contact');"
class="ui-button  icon_left_button button_link  ui-state-default ui-corner-all"  >
<span class="ui-icon  ui-icon-circle-check"></span> 
Update Contact Information</a>

<hr />
<!--
<a href="javascript:void(0);"  
class="ui-button  icon_left_button button_link  ui-state-default ui-corner-all"  >
<span class="ui-icon  ui-icon-arrowthick-1-s"></span> 
Other Licenses</a>
<hr />
-->

</div>

 </div> <!-- END Column -->

     <div class="col span_5_of_12"> <!-- Column -->
     <div class="ui-widget ui-widget-content  ui-corner-all container" style="margin-right: 1%;" >
        
        <strong>Business Contact Information Help</strong>


<p>Information on this page is usual demographic signup data required for payment processing services.
</p>
<p>The Primary Email Address is your ID within AreteX.  To change this email address, open a support ticket.  A "change identifier security fee" will apply.  A manual confirmation is part of the process to help mitigate risk for all involved.
</p>
<p>The Text Message Phone is used for high priority alerts.</p>

<p><strong>Note</strong>: Be sure to click the "Update" button to save any changes you make on this screen.  This information will be stored on the AreteX&trade; database. </p>        
        
     </div>
    </div> <!-- END Column -->
</div> <!-- END ROW -->

 </form>