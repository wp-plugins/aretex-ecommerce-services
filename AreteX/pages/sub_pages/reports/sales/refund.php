<?php 
$obj = AreteX_WPI::getBasSaleDetail($_POST['filter_key']);


?>
<a href="javascript:void(0);" onclick="load_screen('sales_report');"  
class="ui-button  icon_left_button button_link  ui-state-default ui-corner-all"  >
<span class="ui-icon  ui-icon-circle-arrow-w"></span> 
Back</a>
<div class="section group"> <!-- ROW -->
    <div class="col span_8_of_12"> <!-- Column -->
    <div class="ui-widget-header ui-corner-top" >
       <h2 style="text-align: center; margin-top: 5px; margin-bottom: 5px;">Issue Refund</h2>
    </div>
    <div class="ui-widget ui-widget-content  ui-corner-bottom" >
     <div class="section group"> <!-- ROW -->
        <div class="col span_1_of_4"> <!-- Column -->
        <span style="text-align:right; float:right; font-weight:bold">Transaction ID</span>
        </div> <!-- END Column -->
        <div class="col span_3_of_4"> <!-- Column -->
        <?php echo $obj->sale_header->processor_txn_id; ?>
        </div> <!-- END Column -->
    </div> <!-- END ROW -->
    <div class="section group"> <!-- ROW -->
        <div class="col span_1_of_4"> <!-- Column -->
        <span style="text-align:right; float:right; font-weight:bold">Customer Name</span>
        </div> <!-- END Column -->
        <div class="col span_3_of_4"> <!-- Column -->
        <?php echo $obj->sale_header->firstname. ' '.$obj->sale_header->lastname ; ?>
        </div> <!-- END Column -->
    </div> <!-- END ROW -->
        <div class="section group"> <!-- ROW -->
        <div class="col span_1_of_4"> <!-- Column -->
        <span style="text-align:right; float:right; font-weight:bold">Contact Information</span>
        </div> <!-- END Column -->
        <div class="col span_3_of_4"> <!-- Column -->
        <?php echo $obj->sale_header->email_address. ', '.$obj->sale_header->phone ; ?>
        </div> <!-- END Column -->
    </div> <!-- END ROW -->
    
    <div class="section group"> <!-- ROW -->
        <div class="col span_1_of_4"> <!-- Column -->
        <span style="text-align:right; float:right; font-weight:bold">Transaction Amount</span>
        </div> <!-- END Column -->
        <div class="col span_3_of_4"> <!-- Column -->
        <?php echo '$'. number_format($obj->sale_header->amount,2); ?>
        </div> <!-- END Column -->
    </div> <!-- END ROW --> 
    <div class="section group"> <!-- ROW -->
        <div class="col span_1_of_4"> <!-- Column -->
        <span style="text-align:right; float:right; font-weight:bold">Card Information</span>
        </div> <!-- END Column -->
        <div class="col span_3_of_4"> <!-- Column -->
        <?php echo $obj->sale_header->card_type. ', '.$obj->sale_header->masked_pan ; ?>
        </div> <!-- END Column -->
    </div> <!-- END ROW -->   
    <form id="refund_form" action="javascript:void(0);">
    <div class="section group"> <!-- ROW -->
        <div class="col span_1_of_4"> <!-- Column -->
        <span style="text-align:right; float:right; font-weight:bold">Refund Amount</span>
        </div> <!-- END Column -->
        <div class="col span_1_of_8"> <!-- Column -->
        <input type="text" id="refund_amount" class="number" value="<?php echo $obj->sale_header->amount; ?>" max="<? echo $obj->sale_header->amount; ?>" /><br />
        <span style="font-size: 75%;"><strong>Blank</strong> will refund the entire amount. </span>
        </div> <!-- END Column -->
        <div class="col span_1_of_8"> <!-- Column -->
        <a href="javascript:void(0);"  onclick="issue_refund();"
        class="ui-button  icon_left_button button_link  ui-state-default ui-corner-all"  >
        <span class="ui-icon  ui-icon-arrowreturnthick-1-w"></span> 
        Issue Refund</a>
         </div> <!-- END Column -->
    </div> <!-- END ROW -->
    </form>
    <div class="section group" id="refund_status"> <!-- ROW -->
        <div class="col span_1_of_5"> <!-- Column -->
        </div> <!-- END Column -->
        <div class="col span_3_of_5"> <!-- Column -->
            <div id="refund_status_result"><center><strong>...Please Wait...</strong></center></div>
        </div> <!-- END Column -->
    </div> <!-- END ROW -->
    <div class="folding-container">
        <div class="container-handle" id="products_sold">
           <span class="fold-button"> + </span><span>Products Sold</span>
        </div>
        <div class="expanding-frame section group">
            <div class="col span_2_of_12"> <!-- Column -->
            &nbsp;
            </div> <!-- END Column -->
            <div class="col span_8_of_12"> <!-- Column -->
    
   
        <?php
         
        if (is_array($obj->sales_detail)) {
            echo '<table class="gridtable"><thead>';
            echo "<tr><th>Product Code</th><th>Name</th><th>Price</th></tr>";
            echo '</thead><tbody>';
            foreach($obj->sales_detail as $detail) {
                $prc = '$'.number_format($detail->price,2);
                echo "<tr><td>{$detail->code}</td><td>{$detail->name}</td><td>$prc</td></tr>\n";                
                
            }
            echo '</tbody></table>';
        }
        else {
            echo "No Product Details are Avaiable for this Transaction";
        }
        
        ?>
            </div> <!-- END Column -->
        </div>
       
    </div> 
        <div class="folding-container">
        <div class="container-handle" id="payouts">
           <span class="fold-button"> + </span><span>Payouts From Sale</span>
        </div>
        <div class="expanding-frame section group">
            <div class="col span_2_of_12"> <!-- Column -->
            &nbsp;
            </div> <!-- END Column -->
            <div class="col span_8_of_12"> <!-- Column -->
    
   
        <?php
         
        if (is_array($obj->payouts)) {
            echo '<table class="gridtable"><thead>';
            echo "<tr><th>Payee Name</th><th>Account Identifier</th><th>Payment Type</th><th>Amount</th></tr>";
            echo '</thead><tbody>';
            foreach($obj->payouts as $detail) {
                if ($detail->payee_account_identifier == '3BALLIANCE')
                    continue;
                $amount = '$'.number_format($detail->payment_amount,2);
                echo "<tr><td>{$detail->payee_name}</td><td>{$detail->payee_account_identifier}</td><td>{$detail->payment_type}</td><td>$amount</td></tr>\n";                
                
            }
            echo '</tbody></table>';
        }
        else {
            echo "No Payout Details are Avaiable for this Transaction";
        }
        
        ?>
            </div> <!-- END Column -->
        </div>
       
    </div>
    
      
    </div>
       

    
    </div> <!-- END Column -->
    <div class="col span_4_of_12"> <!-- Column -->
        <div class="ui-widget ui-widget-content  ui-corner-all container" >
        <strong>Issuing a Refund</strong>
        <p><strong>Transaction ID</strong> - This is the transaction identifier provided by the payment processor.  
           <em>Note:</em> If you adjust commissions or contributor payments this is the "<em><strong>Original Transaction</strong></em>" when you go to: <em>Reports &amp; Management / Payees / Payee Management</em>. 
           If you need to cancel a delivery authorization, find the <strong><em>Payment Transaction #</em></strong> when you go to <em>Reports &amp; Management / Deliveries / Manage Deliveries</em> </p>
        <p><strong>Customer Name</strong>, <strong>Contact Information</strong> -  The customer you are refunding to.</p>
        <p><strong>Card Information</strong> - The card that will be credited on this refund.</p>
        <p><strong>Refund Amount</strong> - You may issue a partial refund by entering an amount less than the total sale. You may not refund more than the original transaction amount.</p>
        <p><strong>Issue Refund Button</strong> - When you select this button: 1) The amount of the refund will be credited to the customer's card. 2)The customer will be notified. 3)A record of the refund will appear in
        the <em>Sales Report</em> and the customer's <em>Purchase History</em>. 4. The customer will be able to see the refund on their CAM.</p>
        <p><strong>Products Sold</strong> - List of products sold in this transaction.</p>
        <p><strong>Payouts From Sale</strong> - List of payouts to <strong>Referrers</strong> <em>and</em> 
        <strong>Contributors</strong>. <em>Note: </em> Payout corrections due to refunds 
        <em><strong>are not</strong></em> automtatic.  
        Go to <em>Reports &amp; Management / Payees / Payee Management / Pending Payments (icon). </em>
         If the payout has already occurred, select the "Add" button above the list inside 
         <em>Pending Payments</em>, otherwise adjust the appropriate pending payment.</p>   
        </div>
    </div> <!-- END Column -->
</div> <!-- END ROW -->
<script>
jQuery(".container-handle").click(function () {

    header = jQuery(this);
    foldbutton = header.find('.fold-button');
    //getting the next element
    content = header.next();
    /*
    var id = jQuery(this).attr('id');
    var sel = '#'+id+'_help';
    */
        
    //open up the content needed - toggle the slide- if visible, slide up, if not slidedown.
    content.slideToggle(500, function () {
        //execute this after slideToggle is done
        //change text of header based on visibility of content div
        foldbutton.text(function () {
            //change text based on condition
            /*
            Not Changing Help ... 
            if (content.is(":visible"))
                jQuery(sel).show(100);
            else
                jQuery(sel).hide(100);
            */
            return content.is(":visible") ? " - " : " + ";
        });
    });
});

jQuery('#refund_status').hide();
function issue_refund() {
    
    jQuery('#refund_form').validate();
    if (! jQuery('#refund_form').valid())
        return false;
    
    jQuery('#refund_status').show();
    
    jQuery.ajax({
      type: 'POST',
      url: ajaxurl,
      async: false, 
      dataType: 'json',
      data: {
        action: 'atx_post_refund',
        data: {
          txn:  '<?php echo $obj->sale_header->processor_txn_id; ?>',
          amount: jQuery('#refund_amount').val() 
        }
        
      },
      success: function(data){
        console.log(data);
        if (data.Status) {
            var str = '<div style="width: 60%; margin-right: auto; margin-left:auto;"><strong>Status:</strong> '+data.Status+'<br/>';
               str += '<strong>Status Message: </strong>'+data.StatusMessage+'<br/>';
               str += '<strong>Status Code: </strong>'+data.StatusCode+'<br/>';
               jQuery('#refund_status').html(str);
            
        }            
        else
            alert('There was an unknown problem');
                                                        
      },
       error: function(xhr, type, exception) {         
        alert("Ajax Error  "+exception);
      } 
          
    });
    
    
}
</script>