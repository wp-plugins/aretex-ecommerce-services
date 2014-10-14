<?php

function commission_group_list() {

$aretex_core_path = get_option('aretex_core_path');
if (empty($aretex_core_path))
{              
    echo 'Error: AreteX core not installed';
    exit();
}
if (file_exists($aretex_core_path.'AreteXDT.class.php'))
{
    require_once($aretex_core_path.'AreteXDT.class.php');
}    
    
$commission_groups = AreteX_WPI::getBsuCommissionGroups();

//'ID'=>'id'
$headers = array('Group Code'=>'commission_group_code','Group Name'=>'commission_group_name');
        
        $action['function_name'] = "edit_commission_group";
        $action['icon_path'] = 'pages/sub_pages/images/actions/Edit.png';
        $action['parameters'] = array('[commission_group_code]');
        $action['title'] = 'Edit Commission Group ';
        
        $actions[] = $action;
        
        $action['function_name'] = "delete_commission_group";
        $action['icon_path'] = 'pages/sub_pages/images/actions/Delete.png';
        $action['parameters'] = array('[commission_group_code]');
        $action['title'] = 'Delete Commission Group ';
        
        $actions[] = $action;
               
        
        $str = AreteXDT::TableList($headers,$actions,$commission_groups);
        $str .= <<<END_S
        <script>
            function edit_commission_group(commission_group_code) {
                load_linked_screen('setup/payouts/commission_group_form',commission_group_code);
            }
            
            function delete_commission_group(commission_group_code) {
                load_linked_screen('setup/payouts/delete_commission_group',commission_group_code);
            }
            
            jQuery( document ).tooltip();
            
        </script>
END_S;
        return $str; 
}
        
       

?>

<h3>Commission Structures</h3>
<p>
Commission Structures are used by  AreteX&trade; to organize individuals (referrers) within 
unique commission groups for the purpose of identifying both what they are paid for and how 
much they are paid for their work.  Each commssion group has it's own structure. To create a new commission group, click the "Add" button below.</p>
<div class="tabs">
<ul>
<li><a href="#tabs-1">Commission Groups</a></li>
<li><a href="#tabs-2">Help &amp; Information</a></li>
</ul>
<div id="tabs-1">
<div class="section group"> <!-- ROW -->
    <div class="col span_8_of_12"> <!-- Column -->
    
<div id="detail_screen">
<div class="ui-widget-content ui-corner-top" >
<h2 style="text-align: center; margin-top: 5px; margin-bottom: 5px;">Commission Group Management</h2>
</div>
<div class="ui-widget ui-widget-content  ui-corner-bottom" >
<div class="DTTT_container_left" style="padding-right: 0px !important;">
<a href="javascript:void(0)" onclick="load_screen('setup/payouts/add_commission_group');" 
class="DTTT_button" style="margin-right: 0px !important;"><span style="width: 100%;">Add</span></a>
</div>



<div>
<?php

echo commission_group_list();


?>
</div>
</div>
</div>




</div> <!-- END Column -->
    <div class="col span_4_of_12"> <!-- Column -->
    

<div id="commission_group_info" class="ui-widget ui-widget-content  ui-corner-all container dbui-frame" >

<label>Managing Commission Group Structures</label>

<p>Once you have created at least 1 commission group, you may edit the group structure by clicking the edit 
(<strong>pencil</strong>) icon on the left.
</p>
<p>The delete (<strong>trash can</strong>) icon takes you to a "confirm delete" screen.  You will not be allowed to 
delete if the group already has members. To delete the group, first remove the members. 
</p>
<p>(To assign or remove payees from a group, either go to the individual payee screen or 
see information in <em>WP Integration / Shortcodes &amp; Widget / Payee Registration</em> for automatic group assignment.)
</p>
<p><strong>Group Code</strong> and <strong>Group Name</strong> on the listing are simply identifiers to help you recognize the group 
structure you want to edit.  You may <em>Search</em> for a particular group by the group code or group name as well.
</p>


</div>
    </div> <!-- END Column -->

</div> <!-- END ROW -->
</div>
<div id="tabs-2">

<h2>Commission Structure Help and Information</h2>

<p><strong>Payee Distinction: </strong> In AreteX there are two types of payout groups - referrers and contributors.
   <ul style="text-indent: -1.0em; margin-left: 1.5em; font-size: 12px; list-style-type: none;">  
<li>   <strong>Referrers</strong> - commissioned sales reps, affiliates, etc.  This group is paid off of the 
gross of a sale.  It is figured off of Offers you create and which are associated with commission groups.  
Individual referrers are associated with groups.  Offers are associated with groups.  Therefore, individual 
referrers are paid commissions according to the group they are associated with.
</li>   
<li>    <strong>Contributors</strong> - those who earn royalties, fees, or wholesale payments on a product, 
materials, etc.  This group is paid off of either the net or the gross, according to the agreement you have 
with your contributors.  The contributor payout is linked to individual items or products.  
</li>   </ul>  
</p>

<p><em>Note:</em> Be familiar with of the laws in your state for definitions and rules concerning Referrers 
and Contributors.  It can make a difference in how you and they will be taxed.  For instance - there are some 
states that require a commission to be paid off of the gross for it to be considered a commission.  In these 
states being paid off of the net may make it a "profit share." (This distinction may be important in naming 
your payment types.) 
</p>
<p>In AreteX all commission payouts are built off of a percent of gross of a sale.  Contributor payouts may 
be figured off of either the net or gross of the sale of a product, or be a fixed amount.
</p>
<p>To sign Up Referrers to Groups - Go to either
    <ul style="text-indent: -1.0em; margin-left: 1.5em; font-size: 12px; list-style-type: none;">  
   <li>1) Payee Control Panel, see <em>Reports &amp; Management /Payees / Payee Management / Add (or Edit)</em></li>
   <li>2) Sign Up Form (using WordPress shortcodes), see <em>WP Integration / Shortcode &amp; Widget / Payee Registration</em></li>
   </ul>
</p>

<br />
<br />
<strong>Multi-Level (Tier) Commission Structures</strong><br />
<p>	Multi-Level Commission Structures can be challenging to implement.  
Before assigning commission tiers to groups, have a solid understanding of the upline 
structure(s) you wish to implement in your business. 
There is a difference between a "hard coded" hierarchy and a dynamic tracking structure.  
(This is explained in more detail in <em>WP Integration / Shortcodes &amp; Widget / Payee Registration</em>. See dicussion of the "<em>parent</em>" attribute. )
</p>
<p>   All commission group tiers are built off of the base level (Level 1) group.  This group 
is the "face" of your sales or commission group.  If you have more than 1 level of commissions 
to pay (example - you have sales supervisors that are paid commissions), you will need more 
levels that are associated with your Level 1 group.  These will be labeled Level 2, 3, etc. as 
you progress to the top of your commission structure.
</p>
 <p>  Note that the percent paid to higher levels (Level 2, 3, etc.) is still figured off of 
 the gross.  Therefore, a 10% Level 1 commission + a 2% Level 2 commission will mean that a 
 total of 12% will come off of the gross sale to pay commissions for that sale.
</p>

<p>
The structure of a multi-tiered group includes all of its levels.  To add a level onto the structured group you have already created, click the edit (<strong>pencil</strong>) icon next to the group you wish to make multi-level.  Then choose the "Add a Level" button.  A new level row will appear.  Fill out the row.
</p>


</div>
</div>
<script>
jQuery('.tabs').tabs();
</script>