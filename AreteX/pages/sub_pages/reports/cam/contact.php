<?php
global $business_name;
global $customer_id;



 $customer_id = $_REQUEST['linked_id'];

 require_once(plugin_dir_path( __FILE__ ).'camlib.php');
 
 $obj = getResource('contact');


?>
<div class="section group"> <!-- ROW -->
    <div class="col span_6_of_12"> <!-- Column -->

<div class="ui-widget-header ui-corner-top" >
<h2 style="text-align: center; margin-top: 5px; margin-bottom: 5px;">Customer Contact Information</h2>
</div>
<div class="ui-widget ui-widget-content  ui-corner-bottom container " >


<form id="customer_contact_form" action="javascript:void(0)" >
 
<div class="section group"> <!-- ROW -->
    <div class="col span_3_of_12"> <!-- Column -->
        <span style="text-align:right; float:right; font-weight:bold">Business Name</span> 
    </div> <!-- END Column -->
    <div class="col span_5_of_12"> <!-- Column -->
    <input readonly="readonly" type="text" name="_business_name_" value="<? echo $obj->business_name; ?>" />
    </div> <!-- END Column -->
</div> <!-- END ROW -->
<div class="section group"> <!-- ROW -->
    <div class="col span_3_of_12"> <!-- Column -->
        <span style="text-align:right; float:right; font-weight:bold">First Name</span>
    </div> <!-- END Column -->
    <div class="col span_5_of_12"> <!-- Column -->
        <input readonly="readonly" type="text" class="required" name="_firstname_" value="<? echo $obj->firstname; ?>" />
    </div> <!-- END Column -->
</div> <!-- END ROW -->
<div class="section group"> <!-- ROW -->
    <div class="col span_3_of_12"> <!-- Column -->
        <span style="text-align:right; float:right; font-weight:bold">Last Name</span>
    </div> <!-- END Column -->
    <div class="col span_5_of_12"> <!-- Column -->
        <input readonly="readonly" class="required" type="text" name="_lastname_" value="<? echo $obj->lastname; ?>" />
    </div> <!-- END Column -->
</div> <!-- END ROW -->

<div class="section group"> <!-- ROW -->
    <div class="col span_3_of_12"> <!-- Column -->
        <span style="text-align:right; float:right; font-weight:bold">Street</span>
    </div> <!-- END Column -->
    <div class="col span_5_of_12"> <!-- Column -->
        <input readonly="readonly" type="text" name="_street_" value="<? echo $obj->street; ?>" />
    </div> <!-- END Column -->
</div> <!-- END ROW -->
<div class="section group"> <!-- ROW -->
    <div class="col span_3_of_12"> <!-- Column -->
        <span style="text-align:right; float:right; font-weight:bold">City</span>
    </div> <!-- END Column -->
    <div class="col span_5_of_12"> <!-- Column -->
        <input readonly="readonly" type="text" name="_city_" value="<? echo $obj->city; ?>" />
    </div> <!-- END Column -->
</div> <!-- END ROW -->
<div class="section group"> <!-- ROW -->
    <div class="col span_3_of_12"> <!-- Column -->
        <span style="text-align:right; float:right; font-weight:bold">State</span>
    </div> <!-- END Column -->
    <div class="col span_5_of_12"> <!-- Column -->
        <input readonly="readonly" type="text" name="_state_" value="<? echo $obj->state; ?>" />
    </div> <!-- END Column -->
</div> <!-- END ROW -->
<div class="section group"> <!-- ROW -->
    <div class="col span_3_of_12"> <!-- Column -->
        <span style="text-align:right; float:right; font-weight:bold">Zip</span>
    </div> <!-- END Column -->
    <div class="col span_5_of_12"> <!-- Column -->
        <input readonly="readonly" type="text" class="required" name="_zip_" value="<? echo $obj->zip; ?>" />
    </div> <!-- END Column -->
</div> <!-- END ROW -->
<div class="section group"> <!-- ROW -->
    <div class="col span_3_of_12"> <!-- Column -->
        <span style="text-align:right; float:right; font-weight:bold">Phone</span>
    </div> <!-- END Column -->
    <div class="col span_5_of_12"> <!-- Column --><input readonly="readonly" type="text" class="phoneUS" name="_phone_" value="<? echo $obj->phone; ?>" /></div> <!-- END Column -->
</div> <!-- END ROW -->
<div class="section group"> <!-- ROW -->
    <div class="col span_3_of_12"> <!-- Column -->
        <span style="text-align:right; float:right; font-weight:bold">Email Address</span>
    </div> <!-- END Column -->
    <div class="col span_5_of_12"> <!-- Column -->
        <input type="text" readonly="readonly" style="background-color: #dddddd;" name="_email_address_" value="<? echo $obj->email_address; ?>" />
    </div> <!-- END Column -->
</div> <!-- END ROW -->
<div class="section group"> <!-- ROW -->
    <div class="col span_1_of_12"> <!-- Column -->
    </div> <!-- END Column -->
    <div class="col span_5_of_12"> <!-- Column -->
    </div> <!-- END Column -->
</div> <!-- END ROW -->


<input type="hidden" name="account_id" value="<? echo $obj->account_id; ?>" />

</form>


</div>

    </div> <!-- END Column -->
        <div class="col span_5_of_12"> <!-- Column -->

        <div class="ui-widget ui-widget-content  ui-corner-all container" >
        <strong>Billing Contact Information</strong>

            <p>Customer contact information is controlled by your customer.  Any changes to these, 
            including mailing address, email and phone number can be accessed by your customer in their <strong>CAM</strong> 
            (Customer Account Manager).
            </p>        
        
        </div>
        </div> <!-- END Column -->
</div> <!-- END ROW -->