<h2>Overview</h2>

<?php $commission_groups = AreteX_WPI::getBsuCommissionGroups(); 
    if (count($commission_groups) == 0) {
     
     echo '<p style="font-style: italic; border-style: solid;  border-width: 2px; border-color: black; padding : 3px;"><strong>Note</strong>: <strong>No commission groups</strong> are set up yet. You will not be able to generate tracking codes to pay commissions for referrerals. (After you set up commission groups, you must add referrers.)</p>';   
        
    }
    else {
        $summary = AreteX_WPI::getBsuCommissionSummary();
        $total_payees = $summary['payee_count'];
        $total_assigned = 0;
        if (is_array($summary['commission_groups'])) {
            foreach($summary['commission_groups'] as $group_summary) {
                $total_assigned += $group_summary['number_payees'];
            }
        }
        if ($total_assigned == 0) {
                 echo '<p style="font-style: italic; border-style: solid;  border-width: 2px; border-color: black; padding : 3px;"><strong>Note</strong>: You have <strong>not assigned</strong> any payees to commission groups as <em>referrers</em>. You will not be able to generate tracking codes to pay commissions for referrerals.</p>';   

        }
    }
?>


<p>A Tracking Code is the identifying string of code that AreteX&trade; uses to link a product price, a possible discount, the advertising medium, and payees together. This allows for automatic payment splits, tracking different marketing efforts, as well as puts special incentives before your customers.
</p>
<p>Tracking Codes are always built "on the fly" from components you have previously defined or created.  These components include the Offer Code, the Media Source, and possible payees.  If you create a Splash Code (see Splash Codes below) for a Tracking Code, you will be able to save the Tracking Code string.  
</p>

<p><strong>Simple Tracking Code</strong> -  This wizard can be used to set up basic business tracking codes. Note that the wizard will only generate a non-commission code, but gives information about Referrer assignment. 
</p>
<p><strong>Offer Codes</strong> - These are unique identifiers of the Offers (% discount, standard price, or access permission) you wish to create.  This component can associate products, price, and different types of payees. 
</p>
<p><strong>Source Media </strong>- This code component is used to identify the specific media you use with your offers.  Media can be anything from web site pay-per-click advertisements to radio spots.
</p>
<p><strong>Full Tracking</strong> - If you need more flexibility than the wizard allows, this build screen will let you to put together the components for your Tracking Code.  Under this tab there is also a Tracking Code Validator that lets you see the components that you have assembled.  (The Tracking Code Generator is also where Splash Codes are created.)
</p>
<p><strong>Splash Codes</strong> - This is the listing of unique Splash Codes you have assembled for your marketing efforts.  Note that even though Tracking Codes are built "on the fly," Splash Codes are retained and listed under this tab. They may also be deleted from this list.
</p>

