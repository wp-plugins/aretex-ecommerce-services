<h3>Get Payments Due</h3>

<div class="ui-widget ui-widget-content  ui-corner-all" >

<div class="section group"> <!-- ROW -->
<form id="man_bat_search_form">    
    <div class="col span_8_of_12"> <!-- Column -->
    <div style="padding: 10px;">    
    <div class="ui-widget-header ui-corner-top" >
<h2 style="text-align: center; margin-top: 5px; margin-bottom: 5px;">Payments Due Criteria</h2>
</div>
<div class="ui-widget ui-widget-content  ui-corner-bottom dbui-frame container" >
    <div class="section group"> <!-- ROW -->
        <div class="col span_4_of_12"> <!-- Column -->
        <label>Due Date: On or Before</label>
        <input style="width: 90%" id="duedate" name="duedate" class="date" />
        </div> <!-- END Column -->    
    
    <div class="col span_8_of_12"> <!-- Column -->
    <label>Payee </label>
    <input style="display: inline; width: 30%" id="payee_acct_id" name="payee_acct_id" readonly="readonly" />
    <input style="display: inline; width: 60%" id="find_payee" />
    </div> <!-- END Column -->
</div> <!-- END ROW -->
<div class="section group"> <!-- ROW -->
    <div class="col span_8_of_12"> <!-- Column -->
    <a href="javascript:void(0);"  onclick="man_bat_search();"
class="ui-button  icon_left_button button_link  ui-state-default ui-corner-all"  >
<span class="ui-icon  ui-icon-search"></span> 
Search</a>
<a href="javascript:void(0);" onclick="clear_serach();"  
class="ui-button  icon_left_button button_link  ui-state-default ui-corner-all"  >
<span class="ui-icon  ui-icon-circle-close"></span> 
Clear Search Criteria</a> 
    </div> <!-- END Column -->

</div> <!-- END ROW -->
</div>
</div>
    </div> <!-- END Column -->
    <div class="col span_4_of_12"> <!-- Column -->

<div class="ui-widget ui-widget-content  ui-corner-all" style="margin: 10px; padding: 3px;" >

<p>Use this search function to find payees you want to pay.  This is for <em>Non-ACH payments only</em>.  
</p>
<p>To search for payees and/or payments you wish to make outside of AreteX&trade;, type in the date and/or payee you wish to have in your <em>Payments Due</em> report.
</p>
<p><strong>Blank Due Date</strong> = "Today"
</p>
<p><strong>Blank Payee </strong>= "Everybody"</p>

<p>After getting your report, download the <em>Payments Due Spreadsheet</em> for your finance officer to use in making payments.  Be sure to mark as <strong>Paid</strong>, all entries you have paid.  This will allow AreteX&trade; to clear its listing of payments pending, as well as record the payment made within AreteX&trade;.
</p>



</div>    
    </div> <!-- END Column -->
</form>
</div> <!-- END ROW -->

</div>
<script>
<?php 
    $js = AreteX_WPI::jsPayeeSearch('find_payee');
    echo $js;
?>

function clear_serach()
{
    jQuery('#payee_acct_id').val('');
    jQuery('#find_payee').val('');
    jQuery('#duedate').val('');
}
</script>