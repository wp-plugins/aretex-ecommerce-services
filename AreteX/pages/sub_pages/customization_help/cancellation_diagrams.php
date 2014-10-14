<div style="overflow: auto;">
<div style="width: 850px; margin-left: auto; margin-right: auto;">
<h5>Cancellation</h5>
<p>The diagrams below illustrate the CSS class usage as well as the major element tags of the style sheet on the customer cancellation notice.  
You may refer to these diagrams when making changes to the style sheet. (Use the Prev/Next buttons to browse through the diagrams).
</p>
<hr />
<!--  Outer wrapper for presentation only, this can be anything you like -->
      <div id="cancel_diagram_slides">

        <!-- start Basic Jquery Slider -->
        <ul class="bjqs">
          <li>

          
          <img src="<?php echo plugins_url( 'slides_cancel/cancel_top.png', __FILE__ ); ?>" />

          </li>
          <li>
          <img src="<?php echo plugins_url( 'slides_cancel/cancel_head.png', __FILE__ ); ?>" />
              
          </li>
          <li>
           <img src="<?php echo plugins_url( 'slides_cancel/cancel_body.png', __FILE__ ); ?>" />
                
          
          </li>
        </ul>
        <!-- end Basic jQuery Slider -->

      </div>
      <!-- End outer wrapper -->

      <script >
        

          jQuery(document).ready(function($) {
 
  $('#cancel_diagram_slides').bjqs({
    height      : 575,
    width       : 800,
    responsive  : false,
    automatic : false,
    
  });

});

        
      </script>
</div>
</div>