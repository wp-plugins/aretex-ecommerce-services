<div class="ui-widget-header ui-corner-top" >
<h2 style="text-align: center; margin-top: 5px; margin-bottom: 5px;">Deliverable: Paid Content</h2>
</div>
<div class="ui-widget ui-widget-content  ui-corner-bottom" style="padding: 5px;" >
    <p>Explain Paid Content "Deliverable" Here...<a class="read-more-show hide" href="#">(More)</a> 
<span class="read-more-content">
. 
<br/>Explain how this works with Word Press "Short Codes". 
<br/>Explain how this works with Manifests.
<br/>Explain how this works with Contributor Payouts
<br/>Explain how this works with Products 
<a class="read-more-hide hide" href="#">(Less)</a></span></p>
    </p>
    <hr />
<h3>Paid Content Authorization</h3>
<a href="#"  onclick="load_feature_screen('AreteX Paid Content','new_pc_deliv');" class="icon_center_button ui-button button_link  ui-state-default ui-corner-all">

<img src="<? echo  plugins_url( '../images/buttons/cashbox_40.png', __FILE__ ) ?>" /><br />
New Paid <br />
Content Deliverable
</a>

<a href="#"  onclick="load_feature_screen('AreteX Paid Content','pdcnt_mgm');" class="icon_center_button ui-button button_link  ui-state-default ui-corner-all">

<img src="<? echo  plugins_url( '../images/buttons/inventory_category2_40.png', __FILE__ ) ?>" /><br />
Manage<br />
Paid Content
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
 <script>
                // Credit: http://css-tricks.com/forums/topic/jquery-read-more-less-toggle/
              // Hide the extra content initially, using JS so that if JS is disabled, no problemo:
                jQuery('.read-more-content').addClass('hide')
                jQuery('.read-more-show, .read-more-hide').removeClass('hide')
                
                // Set up the toggle effect:
                jQuery('.read-more-show').on('click', function(e) {
                  jQuery(this).next('.read-more-content').removeClass('hide');
                  jQuery(this).addClass('hide');
                  e.preventDefault();
                });
                
                // Changes contributed by @diego-rzg
                jQuery('.read-more-hide').on('click', function(e) {
                  var p = jQuery(this).parent('.read-more-content');
                  p.addClass('hide');
                  p.prev('.read-more-show').removeClass('hide'); // Hide only the preceding "Read More"
                  e.preventDefault();
                });
 </script>