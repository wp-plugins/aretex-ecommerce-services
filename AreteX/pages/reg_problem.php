<div style="padding: 10px;" > 
<h1>AreteX&trade; eCommerce Servcies Registration</h1>
<h2>Please Confirm Registration</h2>
<label style="border-color: #CD0A0A; padding: 3px;" class="error ui-widget ui-widget-content ui-corner-all">You must complete your registration. Please check your email for a confirmation request. If you don't have a confirmation, you may try again.</label>
<!--
<p>You May Also Select From The Following Options</p>
-->
<p>

    

</p>
</div>
<?php if ($complete_problem) { ?>
<div class="container">
<p>We were unable to retrieve your confirmation from the AreteX&trade; server.  If you recieved an email with the subject <em>"AreteX Sandbox Active"</em> please wait a few moments and select <em>I Received Confirmation</em> again. If you continue to recieve this message, please contact 3B Alliance, LLC Support. </p>
</div>
<?php } else {?>

<div class="container">
<p>You should have recieved (or soon will recieve) an email instructing you to confirm your registration. </p>
<p>Shortly after you confirm your registration, you should receive an email with the subject <strong>"AreteX Sandbox Active"</strong>. Select <em>I Received Confirmation</em> after you have recieved that email. </p>
</div>

<div class="button-set" id="button_list">    
    <button id="add_new" onclick="add_new_sandbox();" class="button ui-button">Create Different Sandbox Account</button> &nbsp;
    <button id="confirm_done" onclick="location.reload(true); " class="button ui-button">I Received Confirmation</button>

</div>

<?php } ?>
<script>

jQuery(document).ready(function(){
    jQuery(function ($) {
    	$("#navigation").treeview({
    		collapsed: false,
    		unique: false,
    		persist: "location",
            control: "#nav_control"
    	});
        $('.button-set').buttonset();
        $('.button').button()
         .click(function( event ) {
            event.preventDefault();
            });
        
    });
});

function add_new_sandbox(){
    jQuery(function ($) {                
    	
        $('#button_list').html('<p style="text-align:center;">...Please Wait...</p>')               
        var data = {
		action: 'add_new_sandbox'
	   };
        	
    	$.post(ajaxurl, data, function(response) {
    	   location.reload();
    	});
        
    
    });  
}

</script>

