<div class="ui-widget-header ui-corner-top" >
<h2 style="text-align: center; margin-top: 5px; margin-bottom: 5px;">Deliverable: Subscriptions and Memberships</h2>
</div>
<div class="ui-widget ui-widget-content  ui-corner-bottom" style="padding: 5px;" >
    <p>Explain Paid Membership "Deliverable" Here...</p>
    <hr />
<h3>Paid Memberships</h3>
<a href="#"  onclick="load_feature_screen('AreteX Subscriptions and Memberships','new_memb_deliv');" class="icon_center_button ui-button button_link  ui-state-default ui-corner-all">

<img src="<? echo  plugins_url( '../images/buttons/atm_40.png', __FILE__ ) ?>" /><br />
New Paid Membership Deliverable
</a>

<a href="#"  onclick="load_feature_screen('AreteX Subscriptions and Memberships','mem_mgm');" class="icon_center_button ui-button button_link  ui-state-default ui-corner-all">

<img src="<? echo  plugins_url( '../images/buttons/stamped_document_40.png', __FILE__ ) ?>" /><br />
Manage<br />
Paid Memberships
</a>



 <hr />
    
</div>
<script>
jQuery(document).ready(function() {
    jQuery(function ($) {
    // Hover states on the static widgets
    	$( ".ui-button" ).hover(
    		function() {
    			$( this ).addClass( "ui-state-hover" );
    		},
    		function() {
    			$( this ).removeClass( "ui-state-hover" );
    		}
    	);
        
        $('.icon_center_button').hover(
            function()
            {
                var src = $( this).children('img').attr('src');           
                src = hover_url(src);        
                $(this).children('img').attr('src',src);
                
                
            },
            function()
            {           
                var src = $( this).children('img').attr('src');
                src = off_hover_url(src);
                $(this).children('img').attr('src',src);
    
            }        
        );
    });
    
    
  
  
 });
</script>
