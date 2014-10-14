<h2>Payee Management</h2>
<div class="section group"> <!-- ROW -->
    <div class="col span_8_of_12"> <!-- Column -->
 <div id="inner_form">

       <table cellpadding="0" cellspacing="0" border="0"  id="dt_53ae01326d21a">
	<thead>
		<tr>
			<th>Actions</th><th>Account Identifier</th><th>Payee Name</th><th>Contact Email</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td colspan="5" class="dataTables_empty">Loading data from server</td>
		</tr>
	</tbody>
	<tfoot>
		<tr>
			<th>Actions</th><th>Account Identifier</th><th>Payee Name</th><th>Contact Email</th>
		</tr>
	</tfoot>
    </table>
    <script>
 var oTableTst;
    jQuery(function ($) {
        $(document).ready(function() {
           
         
         <?php 
         
            $ajax_url = get_option('aretex_bas_endpoint');
            $ajax_url .= '/dbui/dbui_ajax_JSON.php';
               
            $access_token = AreteX_WPI::ajaxAccessToken(); 
                      
        ?>       
       
        
        oTab_payee_manage_1 = init_datatable_resizeable(
        '<?php echo $ajax_url; ?>',
        'dt_53ae01326d21a','payee_manage_1',false,
        [{ "mDataProp":"Actions", "bSortable": false },{ "mDataProp": "payee_account_identifier" },
         { "mDataProp": "name" },{ "mDataProp": "contact_email" }],        
         '<?php echo $access_token; ?>','reports/payees/payee_management');
     
      oTableTst=oTab_payee_manage_1; 
      add_column_filters(oTab_payee_manage_1,[null,{type: 'text' },{type: 'text' },{type: 'text' }]);
      
      set_auth_context('<? echo $ajax_url; ?>','<? echo $access_token; ?>','payee_manage_1','<? echo plugins_url( '[slug]' , __FILE__ ); ?>');

      
      add_std_buttons(oTab_payee_manage_1,'#dt_53ae01326d21a','payee_manage_1','<?php echo $ajax_url; ?>','<?php echo $access_token; ?>');
      add_custom_buttons('#dt_53ae01326d21a','<div class="DTTT_container_left ui-buttonset ui-buttonset-multi"><a onclick="dbui_add_new_form(\'payee_manage_1\',\'<?php echo $ajax_url; ?>\',\'#inner_form\',\'<?php echo $access_token;  ?>\',\'reports/payees/payee_management\')" class="DTTT_button ui-button ui-state-default DTTT_button_text"  ><span>Add</span></a></div>');
      
          $( document ).tooltip();      
      
     });
});
    </script> 
    <iframe id="export_frame" width=0 height=0 frameBorder=0></iframe> 

</div>

</div> <!-- END Column -->
    <div class="col span_4_of_12"> <!-- Column -->
        <div class="ui-widget ui-widget-content  ui-corner-all container" >
        <strong>Payee Management</strong>

<p>This is a general listing of all of your payees, whether they receive monies from you as <em>contriubtors</em> or as <em>referrers</em>.  <em><strong>Note</strong></em>: you may add new payees by selecting the <em>Add</em> button.
</p>
<p>The Action column allows four actions:</p>
<ul style="text-indent: -1.0em; margin-left: 1.5em; font-size: 12px;">
<li>The <em>Edit</em> (<strong>pencil</strong>) icon lets you edit the details concerning a particular payee.  Editing allows you to view the ACH authorization agreement you have with your payee, check the contact details of your payee, manage the Commission Group of a payee if applicable, and note if their Tax Form <strong>(W-9)</strong> is on file.  (Note: AreteX&trade; will not deliver payments in excess of $300.00, if this value is set to "No.")
</li>
<li>The <em>Delete</em> (<strong>trashcan</strong>) icon shows the payee details, but only allows you to Confirm or Cancel your decision to delete the payee record.
</li>
<li>The <em>PendingPayment</em> (<strong>dollar</strong>) icon takes you to all of the 
pending transactions a particular payee is associated with.  
Here you may add a new transaction to a payee, or adjust the payment to a payee. <br /> When you need to adjust a payment because of a refund: if the payout has already occurred, select the "Add" button above the Pending Payouts list, otherwise adjust the appropriate pending payment.
</li>
<li>The <em>SentPayments</em> (<strong>dollar/arrow</strong>) icon shows a report of payments already sent to a particular payee.
</li></ul>
        </div>
   </div> <!-- END Column -->
</div> <!-- END ROW -->
<script>


set_wpu_search('#wp_user_name');



function before_dbui_save_function(form_id) {
 
    
 	jQuery(function($) {
	  
      var wp_id = $('#other_id_1').val();
      if (! wp_id)
        return;
       
      var payee_name = $('#payee_name').val();
      var payee_address = $('#payee_address').val();
      var contact_email = $('#contact_email').val();
      var payee_phone = $('#payee_phone').val();
       
      var data = {
        action: 'atx_set_can_ptr',
        wp_id: wp_id,
        payee_name: payee_name,
        payee_address: payee_address,
        payee_email: contact_email,
        payee_phone: payee_phone
        
      }
       
       $.ajax({
      type: 'POST',
      url: ajaxurl,
      data: data,
      dataType: "json",
      success: function(data){
        // on success use return data here
        $(ctrl_id).val(data);
      },
      error: function(xhr, type, exception) { 
        // if ajax fails display error alert
        alert("ajax error  "+exception);
      }
    });
       
	});
}
 





</script>