<?php
function getResource($urn)
{
    global $customer_id;
    if (! class_exists('AreteX_WPI'))
    {
        $aretex_core_path = get_option('aretex_core_path');
        require_once($aretex_core_path .'AreteX_WPI.class.php');
    }
    $url = get_option('aretex_cam_endpoint');
    if (! empty($urn))
    {
        $url .= '/account/'.$customer_id.'/'.$urn;
    }
    else
    {
        $url .= '/account/'.$customer_id;
    }
    
    $obj = AreteX_WPI::getGenericResourceByURI($url,AreteX_WPI::no_cache,AreteX_WPI::user_id);
    
    return $obj;
}


function displayObject($obj,$field_prompt)
{
    $start_row = false;
    $end_row = false;
    $i = 0;
    foreach($field_prompt as $field=>$prompt)
    {
        if ($end_row)
        {
            $start_row = false;
            echo "\n</div><!-- END ROW -->";
        }
        if (($i % 2) == 0)
        {
            $start_row = true;
            $end_row = false;
            echo "<div class=\"section group\"> <!-- START ROW --> \n".
                "<div class=\"col span_1_of_12\">&nbsp;</div>";
        }
        $id=uniqid();
        echo 
             "<div class=\"col span_4_of_12\">".
             "<label for=\"$id\">$prompt:</label><span id=\"$id\"> ".$obj->$field.'</span>'.
             "\n</div>";
        $i++;
        if (($i % 2) == 0)
        {
            $end_row = true;
        }
        
    
        
    }
    if ($start_row)
       echo "\n</div><!-- END ROW -->";
}
 


function display_pending_form()
{
    
    $str .= "<div class=\"section group\"> <!-- START ROW --> \n"; 
    $str .= "<div class=\"col span_1_of_2\"> ";
    $str .= <<<END_START_DIV3
          <div class="ui-widget ui-widget-header ui-corner-top">
            <h3>Account Validation Pending</h3>
         </div>
         <div class="container ui-widget-content ui-corner-bottom">
END_START_DIV3;
 
    $str .= '<h3>Trial Transtion Trasmission In Progress</h3>';
    $str .= '<p>You be able to enter the trial amounts in this space when they are ready.</p>';
    
    $str .= "</div>";
    $str .= "</div>";
 $str .= <<<END_INS
     <div class="col span_1_of_2"> <!-- Column -->
     
        <div  style="margin-right: 5px; padding: 5px;" class="ui-widget ui-widget-content  ui-corner-all" >
            <p>Three small amounts (each less than $1.00) are now being transmitted to the bank account number you provided. 
            It can take about four business days for the transactions to appear in your account.</p>
            <p>When these 3 amounts are listed in your bank account, enter all three to validate your agreement.  
            Use the 0.00 format for your entries (10 cents would be entered as 0.10).  </p>
            <p>Contact your bank (or check on-line) for these recent transactions.</p>
            
        </div>
    </div> <!-- END Column -->
END_INS;
   
    $str .= "</div> <!-- END ROW --->";
    
    return $str;
    
}




    
    
    function build_summary_table($summary_data)
    {
            $id=uniqid('tbl_');
            $str = '<table id="'.$id.'">';
            $str .= "<thead><tr><th>Target Payment Date</th><th>Amount</th><th>Payment Type</th><th>Status</th><th>Media Source</th></tr></thead>\n";
            $str .= "<tbody>\n";
            foreach($summary_data as $obj)
            {
                $str  .= "<tr><td>$obj->duedate</td><td align=\"right\">$$obj->payment</td>".
                         "<td>$obj->payment_type</td><td>$obj->payment_status</td><td>$obj->custom_tracking</td></tr>\n"; 
            }
            $str .= '</tbody></table>';
            $str .= <<<END_IT
            <script>
            var oTable = jQuery('#$id').dataTable(
                    {
                    
                    "bJQueryUI": true,
                    "sPaginationType": "full_numbers",                   
                    "sDom": '<"H"RlCfr>t<"F"ip>',
                    "oColVis": {
                    "sSize": "css"
                    }
                                                                                  
                    }
            );
            </script>
END_IT;
            return $str;
    }
    
    function build_payment_table($payment_data)
    {
            $id=uniqid('tbl_');
            $str = '<table id="'.$id.'">';
            $str .= "<thead><tr><th>Settlement Date</th><th>Amount</th><th>Payment Type</th><th>Media Source</th></tr></thead>\n";
            $str .= "<tbody>\n";
            foreach($payment_data as $obj)
            {
                $str  .= "<tr><td>$obj->complete_date</td><td align=\"right\">$$obj->payment</td>".
                         "<td>$obj->payment_type</td><td>$obj->custom_tracking</td></tr>\n"; 
            }
            $str .= '</tbody></table>';
            $str .= <<<END_IT
            <script>
            var oTable = jQuery('#$id').dataTable(
                    {
                    
                    "bJQueryUI": true,
                    "sPaginationType": "full_numbers",                   
                    "sDom": '<"H"RlCfr>t<"F"ip>',
                    "oColVis": {
                    "sSize": "css"
                    }
                                                                                  
                    }
            );
            </script>
END_IT;
            return $str;
    }



?>