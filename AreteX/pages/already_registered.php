<div style="padding: 10px;" > 
<h1>AreteX&trade; eCommerce Servcies Registration</h1>
<h2>Already Registered</h2>
<label style="border-color: #CD0A0A; padding: 3px;" class="error ui-widget ui-widget-content ui-corner-all">The eMail address you provided already has an AreteX&trade; account associated with it.</label>
<p>Please Select From The Following Options</p>
<div class="button-set" id="button_list">    
    <button id="add_new" onclick="add_new_sandbox();" class="button ui-button">Create Different Sandbox Account</button>    
</div>
</div>


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

