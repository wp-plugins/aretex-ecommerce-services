<div style="width: 850px; margin-left: auto; margin-right: auto;">
<h4>CSS Diagrams</h4>
<p>The diagrams below illustrate the CSS class usage as well as the major element tags of the 
style sheet on the payment form.  
You may refer to these diagrams when making changes to the style sheet. (Use the Prev/Next buttons to browse through the diagrams).
</p>
<hr />
<!--  Outer wrapper for presentation only, this can be anything you like -->
      <div id="receipt_diagram_slides">

        <!-- start Basic Jquery Slider -->
        <ul class="bjqs">
          <li>

          
          <img src="<?php echo plugins_url( 'slides_payment_form/form-css-top.png', __FILE__ ); ?>" />

          </li>
          <li>
          <img src="<?php echo plugins_url( 'slides_payment_form/form-css-mid.png', __FILE__ ); ?>" />
              
          </li>
          <li>
           <img src="<?php echo plugins_url( 'slides_payment_form/form-css-bottom.png', __FILE__ ); ?>" />
                          
          </li>
          
          <li>
           <div style="margin-bottom: 10px;">When the customer tries to submit the payment form, but has not entered their data properly, 
           (for example if they fail to enter a required field) the <strong>.error</strong> CSS class is added to the field and a message 
           with the <strong>.error</strong> class is displayed.  You may override the properties of this 
           <strong>.error</strong> class in your custom style sheet.</div>
           <img src="<?php echo plugins_url( 'slides_payment_form/error-class.png', __FILE__ ); ?>" />                          
          </li>
          
          <li>
           <div style="margin-bottom: 10px;">
          <p>The purpose of the <strong>.cluetip</strong> and <strong>.preview</strong> classes  are for the "Hover Help" colors. </p>
            <div style="width: 440px; margin: auto; border-style: solid; border-width: 2px; border-color: black;">
            <img src="<?php echo plugins_url('images/hoverhelp.png',__FILE__);?>" />
            </div>
        <p style="font-size: 75%;"><em>Credit:</em><a target="_blank" href="http://plugins.learningjquery.com/cluetip/">jQuery Clue Tip</a></p>
                        
          </li>
          
        </ul>
        <!-- end Basic jQuery Slider -->

      </div>
      <!-- End outer wrapper -->

      <script >
        

          jQuery(document).ready(function($) {
 
  $('#receipt_diagram_slides').bjqs({
    height      : 475,
    width       : 800,
    responsive  : false,
    automatic : false,
    
  });

});

        
      </script>
</div>