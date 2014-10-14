<div class="ui-widget-header ui-corner-top" >
<h2 style="text-align: center; margin-top: 5px; margin-bottom: 5px;">Sales Management</h2>
</div>
<div class="ui-widget ui-widget-content  ui-corner-bottom" style="padding: 5px;" >
    <p>Use these reports and functions to manage your sales through your WordPress site.</p>
    
    <p>The links under <strong>Sales Management</strong> ...</p>
    
    
    <hr />
<h3>Sales Management Functions</h3>
<a href="#"  onclick="load_screen('sales_report');" class="icon_center_button ui-button button_link  ui-state-default ui-corner-all">

<img src="<? echo  plugins_url( '../../images/buttons/table_40.png', __FILE__ ) ?>" /><br />
Sales<br />
Report
</a>

<a href="#"  onclick="load_screen('not_yet');" class="icon_center_button ui-button button_link  ui-state-default ui-corner-all">

<img src="<? echo  plugins_url( '../../images/buttons/thread_40.png', __FILE__ ) ?>" /><br />
Commission<br />
Structures
</a>

<a href="#"  onclick="load_screen('not_yet');" class="icon_center_button ui-button button_link  ui-state-default ui-corner-all">

<img src="<? echo  plugins_url( '../../images/buttons/barcode_40.png', __FILE__ ) ?>" /><br />
Coupons &amp;<br />
Tracking
</a>

<a href="#"  onclick="load_screen('not_yet');" class="icon_center_button ui-button button_link  ui-state-default ui-corner-all">

<img src="<? echo  plugins_url( '../../images/buttons/group_40.png', __FILE__ ) ?>" /><br />
Manage<br />
Referrers
</a>

<a href="#"  onclick="load_screen('not_yet');" class="icon_center_button ui-button button_link  ui-state-default ui-corner-all">

<img src="<? echo  plugins_url( '../../images/buttons/invoice_40.png', __FILE__ ) ?>" /><br />
Receipt<br />
Customization
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
