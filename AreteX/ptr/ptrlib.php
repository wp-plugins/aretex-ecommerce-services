<?php
function getResource($urn)
{
    global $account_id;
    if (! class_exists('AreteX_WPI'))
    {
        $aretex_core_path = get_option('aretex_core_path');
        require_once($aretex_core_path .'AreteX_WPI.class.php');
    }
    $url = get_option('aretex_ptr_endpoint');
    if (! empty($urn))
    {
        $url .= '/account/'.$account_id.'/'.$urn;
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
 
    $str .= '<h3>Trial Transaction Trasmission In Progress</h3>';
    $str .= '<p><strong>Note:</strong>You be able to enter the trial amounts in <em>this space</em> when they are ready.</p>';
    
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


function build_authorization_details($type, $flds, $title,$fee, $current_option,$acct)
{
        if ($acct['authorization_vars']->status == 'Pending' )
            $details = display_pending_form();
        else if ($acct['authorization_vars']->status == 'Waiting' )
            $details = display_validation_form();
        else if ($acct['authorization_vars']->status == 'Authorized')
            $details = display_payment_details();
    
        global $payee;
        global $account_id;
        $str = "<div id=\"form_div_$type\" > \n";
        $str .= <<<END_START_DIV2
         <div class="ui-widget ui-widget-header ui-corner-top">
            <h3><i>$title</i> Payment Authorization Details</h3>
         </div>
         <div class="container ui-widget-content ui-corner-bottom">
         <div class="section group"> <!-- ROW -->
            <div class="col span_1_of_3"> <!-- Column -->
                <div class="ui-widget ui-widget-header ui-corner-top">
                    For Your Files 
                </div>
               <div class="container ui-widget-content ui-corner-bottom" style="padding-bottom: 3px;">
                To save a PDF copy of your current Account Authorization agreement:<br/><br/>
                <a href="javascript:void(0);"  
                class="ui-button  icon_left_button button_link  ui-state-default ui-corner-all"  onclick="dl_pdf();" >
                <span class="ui-icon  ui-icon-circle-arrow-s"></span> 
                Download Agreement</a>
 
            <iframe width="0" height="0" id="dl_pdf_frame"></iframe>
              </div>
            </div> <!-- END Column --> 
            <div class="col span_2_of_3"> <!-- Column -->
                <div class="container ui-widget-content ui-corner-all" style="margin-right: 5px; padding-bottom: 3px; ">
                <div style="margin-bottom: 5px;">
                    <em><strong>Note:</strong> </em>To change your current Authorization, you must Revoke your existing 
                    Authorization before entering a new one. After revocation a new Authorization Agreement
                    screen will appear.
                    <div style="margin-top: 3px;">
                    - To Revoke your Authorization for $current_option select the button below. 
                    </div>
                   </div>
                
               
                    
                    

                     <a href="javascript:void(0);"  onclick="revoke_payment_auth();" class="ui-button  icon_left_button button_link  ui-state-default ui-corner-all"  ><span class="ui-icon  ui-icon-circle-close"></span> Revoke  $current_option Authorization</a>
                    
                 </div>
            </div> <!-- END Column -->
            
        </div> <!-- END ROW -->

         $details
         
         </div>
         </div>
END_START_DIV2;

        return $str;

}

function display_payment_details()
{
    $obj = getResource('payment_account');
    if (is_object($obj))
        $payment_account = get_object_vars($obj);
    else
        $payment_account = $obj;
        
    $str .= "<div class=\"section group\"> <!-- START ROW --> \n"; 
    $str .= "<div class=\"col span_3_of_4\"> ";
     $str .= <<<END_START_DIV4
          <div class="ui-widget ui-widget-header ui-corner-top">
            <h3>Current Account Authorization </h3>
         </div>
         <div class="container ui-widget-content ui-corner-bottom">
END_START_DIV4;
    foreach($payment_account as $key=>$value)
    {
        if ($value->name)
        {
             $str .= "<div class=\"section group\"> <!-- START ROW --> \n"; 
             $str .= "<div class=\"col span_1_of_4\"> ";
             $str .= "<strong>".$value->name."</strong>";
             $str .= "</div><!-- END COL -->\n";
             $str .= "<div class=\"col span_3_of_4\"> ";
             $str .=  $value->value;
             $str .= "</div><!-- END COL -->\n";
             $str .= "</div><!-- END ROW -->\n";
        }
    }
    $str .= "</div></div></div><!-- END_ROW -->\n";
    
    return $str;
}

function display_validation_form()
{
    global $payee;
    global $business_name;
    global $account_id;
    
    $str .= "<div class=\"section group\"> <!-- START ROW --> \n"; 
    $str .= "<div class=\"col span_1_of_2\"> ";
    $str .= <<<END_START_DIV3
          <div class="ui-widget ui-widget-header ui-corner-top">
            <h3>Account Validation </h3>
         </div>
         <div class="container ui-widget-content ui-corner-bottom">
END_START_DIV3;

             
    $str .= "<form id=\"form_validate\" >\n";
    $str .= "<div class=\"section group\"> <!-- START ROW --> \n";
    $str .= "<div class=\"col span_1_of_3\"> ";
    $str.= "<label for=\"trial_1\">Amount 1</label><input id=\"trial_1\" class=\"text $validator_class ui-widget-content  ui-corner-all\" type=\"text\" style=\"width: 100%;\" name=\"_amt_[0]\" type=\"text\"/>";
    $str .= "\n</div><!-- END COL-->\n";
    
    $str .= "<div class=\"col span_1_of_3\"> ";
    $str.= "<label for=\"trial_1\">Amount 2</label><input id=\"trial_1\" class=\"text $validator_class ui-widget-content  ui-corner-all\" type=\"text\" style=\"width: 100%;\" name=\"_amt_[1]\" type=\"text\"/>";
    $str .= "\n</div><!-- END COL-->\n";
    
     $str .= "<div class=\"col span_1_of_3\"> ";
    $str.= "<label for=\"trial_1\">Amount 3</label><input id=\"trial_1\" class=\"text $validator_class ui-widget-content  ui-corner-all\" type=\"text\" style=\"width: 100%;\" name=\"_amt_[2]\" type=\"text\"/>";
    $str .= "\n</div><!-- END COL-->\n";
    $str .= <<<END_BUTTON
        <a href="javascript:void(0);"  onclick="validate_payment_auth()"
class="ui-button  icon_left_button button_link  ui-state-default ui-corner-all"  >
<span class="ui-icon  ui-icon-circle-check"></span> Validate</a>

        <input type="hidden" name="cmd" value="validate_auth" />
        <input type="hidden" name="account_id" value="$account_id" />

END_BUTTON;
    
    if (! $start_row)
        $str .= "\n</div><!-- END ROW -->\n";
    $str .= "</form>";
    $str .= '<hr/><p>It is important that you wait until <em>all three</em> transactions have been confirmed by your bank.</p>';
    $str .= "</div>";
    $str .= "</div>";
 $str .= <<<END_INS
     <div class="col span_1_of_2"> <!-- Column -->
     
        <div  style="margin-right: 5px; padding: 5px;" class="ui-widget ui-widget-content  ui-corner-all" >
            <p>Three small amounts (each less than $1.00) have been transmitted to the bank account number you provided. 
            It can take about four business days for the all of these transactions to appear in your account.</p>
            <p>When these 3 amounts are listed in your bank account, enter <em>all three</em> to validate your agreement.  
            Use the 0.00 format for your entries (10 cents would be entered as 0.10).  </p>
            <p>Contact your bank (or check on-line) for these recent transactions.</p>
            
        </div>
    </div> <!-- END Column -->
END_INS;
   
    $str .= "</div> <!-- END ROW --->";
    
    return $str;
    
}

function build_authorization_form($type, $flds, $title,$fee, $config_option)
{
        global $payee;
        global $business_name;
        global $account_id;
        $str = "<div id=\"form_div_$type\" > \n";
        $str .= <<<END_START_DIV
         <div class="ui-widget ui-widget-header ui-corner-top">
            <h3><i>$title</i> Payment Authorization Details</h3>
         </div>
         <div class="container ui-widget-content ui-corner-bottom" style="padding: 4px;">
        
END_START_DIV;
        
        
        $str .= "<p>Please provide the following payment account details so you can receive your automatic payments via $title.  <br/>";
        if ($fee)
        {
            $fee = trim($fee,'$');
            if (is_numeric($fee) && $fee > 0)
            {
                $fee = number_format($fee,2);
                $str .= " (A processing fee of $$fee will be deducted from your payment for this option).</p>";
            }
        }        
        $str .= "</p><form id=\"form_$type\" action=\"javascript:void(0);\">\n";
        $str .= "<input type=\"hidden\" name=\"_id_payment_type_\" value=\"$type\"/>\n";
        $str .= '<input type="hidden" name="account_id" value="'.$account_id.'" />';
        $str .= '<input type="hidden" name="config_option" value="'.$config_option.'" />';
      //  $str .= "<p><i><b>$payee</b> will be the designated Payee.</i></p>";
       $str .= "<p>The agreement below is between <i><b>$payee</b> (Payee) and $business_name <b>(The Company)</b> .</i></p>";
        $str .= '<input type="hidden" name="cmd" value="post" />';
        $str .= '<input type="hidden" name="urn" value="payment_account" />';
        // $str .= "<table>\n";
        $start_row = false;
       
        $col_count = 1;
         $cols_span = "span_12_of_12";
        foreach($flds as $key=>$value)
        {
            $post_name ='_'.$key.'_';
            if (is_array($value))
            {
                $name = $value[0];                
                $validator = $value[1];
                if ($validator == 'fixed')
                    continue;
                if ($name == 'row')
                {
                    $start_row = true;
                    $col_count = $value[1];
                    if ($col_count == 1)
                        $cols_span = "span_12_of_12";
                    else
                        $cols_span = "span_1_of_$col_count";
                     $str .= "<div class=\"section group\"> <!-- START ROW --> \n";                    
                    continue;
                }
                if ($name == 'end_row')
                {                   
                    $start_row = false;
                    $col_count = 1;
                    $str .= "\n</div><!-- END ROW -->\n";
                    $cols_span = "span_12_of_12";
                    continue;
                    
                }
                if ($name == 'text')
                {
                    $value = $value[1];
                    if (! $start_row)
                        $str .= "<div class=\"section group\"> <!-- START ROW --> \n";
                    $str .= "<div class=\"col $cols_span\"> ";
                    $str .= $value;
                    $str .= "\n</div><!-- END COL-->\n";
                     if (! $start_row)
                        $str .= "\n</div><!-- END ROW -->\n";
                    continue;
                }
                if ($validator == 'text' || $validator == 'masked')
                {
                
                    if ($validator == 'text')
                        $validator_class = $value[2];
                    else
                        $validator_class = $value[3];
                    
                    $input_id = uniqid();    
                    if (! $start_row)
                        $str .= "<div class=\"section group\"> <!-- START ROW --> \n";
                    $str .= "<div class=\"col $cols_span\"> ";
                    $str.= "<label for=\"$input_id\">$name</label><input id=\"$input_id\" class=\"text $validator_class ui-widget-content  ui-corner-all\" type=\"text\" style=\"width: 100%;\" name=\"$post_name\" type=\"text\"/>";
                    $str .= "\n</div><!-- END COL-->\n";
                    if (! $start_row)
                        $str .= "\n</div><!-- END ROW -->\n";
                    continue;
                }
                if ($validator == 'choice')
                {
                    $sel_id = uniqid();
                    if (! $start_row)
                        $str .= "<div class=\"section group\"> <!-- START ROW --> \n";
                    $str .= "<div class=\"col $cols_span\"> ";
                    $str .= "<label for=\"$sel_id\">$name</label> ";
                    $choices = $value[2];
                    $choices = explode(',',$choices);
                    
                    $str .= "<select id=\"$sel_id\" name=\"$post_name\">";
                    foreach($choices as $choice)
                    {
                        $str .= "<option>$choice</option>\n";
                    }
                    $str .= "</select>";
                    $str .= "\n</div><!-- END COL-->\n";
                     if (! $start_row)
                        $str .= "\n</div><!-- END ROW -->\n";
                    continue;
                }
                
            }
            else
            {   
                
                $name = $value;
                
            }
            
            $input_id = uniqid();    
            if (! $start_row)
                $str .= "<div class=\"section group\"> <!-- START ROW --> \n";
            $str .= "<div class=\"col $cols_span\"> ";
            $str.= "<label for=\"$input_id\">$name</label><input id=\"$input_id\" class=\"text ui-widget-content ui-corner-all\" type=\"text\" style=\"width: 100%;\" name=\"$post_name\" type=\"text\"/>";
            $str .= "\n</div><!-- END COL-->\n";
            if (! $start_row)
                $str .= "\n</div><!-- END ROW -->\n";
        }
     //   $str .= "</table>\n";
         // $str .= "<input name=\"submit\" type=\"submit\" value=\"I Wish to Recieve Payments Via: $title  \"/>";
        $str .= '<a href="javascript:void(0);"  onclick="submit_info('."'#form_$type'".');" class="icon_left_button ui-button button_link  ui-state-default ui-corner-all"  ><span class="ui-icon ui-icon-radio-off"></span>I Wish to Recieve Payments Via: '.$title.'   </a>';
        $str .= "<p>By submitting this form you are agreeing to receive future payments to the account or address information described above. <br /><br/>All pending and future payments will be sent, as described above, until the agreement is revoked.</p>";
        $str .= "</form>";
        $str .= "\n</div>\n</div>\n";
        return $str;
    }
    
    function send_pdf()
    {
        $obj = getResource('payment_account');
        $payment_account = get_object_vars($obj); 
        // We'll be outputting a PDF

         header('HTTP/1.1 200 OK');
         header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
         header('Date: ' . date("D M j G:i:s T Y"));
         header('Last-Modified: ' . date("D M j G:i:s T Y"));
         header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
         header("Cache-Control: private",false); // required for certain browsers 
         header("Pragma: public");        
         header('Content-type: application/pdf');
         $pdf = $payment_account['authorization_vars']->authorization_snapshot;
         $pdf = base64_decode($pdf);
       
         header("Content-Length: " . strlen($pdf));
         header("Content-Transfer-Encoding: Binary"); // add
         header('Content-Disposition: attachment; filename="authorization.pdf"');
        
        
       
        print $pdf;
        
    }
    
    function validate_payment_account()
    {
        $obj = getResource('payment_account');
        $payment_account = get_object_vars($obj);
      
        $auth = $payment_account['authorization_vars'];
        $trial[] = $auth->trial_amt_1;
        $trial[] = $auth->trial_amt_2;
        $trial[] = $auth->trial_amt_3;
        
        $amt = $_POST['_amt_'];
          
        sort($amt);
        sort($trial);
        
    //    error_log('amt :'.var_export($amt,true));
        error_log('trial :'.var_export($trial,true));
    //    foreach($amt as $key=>$value)
        {
            if ($trial[$key] != $value)
                return "NO MATCH";
        }
        
        error_log("Got past ... ");
        return postResource('payment_account/validation');
    
        
           
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