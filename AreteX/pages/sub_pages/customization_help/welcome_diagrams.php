<div style="overflow: auto;">
    <div style="width: 850px; height: 800px; margin-left: auto; margin-right: auto;">
    <h5>Welcome / Account</h5>
    <p>The slides below show various views of the default Welcome/Account access email including the HTML. Use the Next/Prev buttons to navigate through the examples.</p>
    <div style="width: 850px; height: 800px; margin-left: auto; margin-right: auto;">
    <!--  Outer wrapper for presentation only, this can be anything you like -->
      <div id="receipt_diagram_slides">

        <!-- start Basic Jquery Slider -->
        <ul class="bjqs">
          <li>
              <div>
              <strong>Welcome Email Default</strong> - Below is an example of what the default welcome email would look like.   
              <br /><br />
              </div>          
              <img src="<?php echo plugins_url( 'slides_welcome/welcome_email_sample.png', __FILE__ ); ?>" />
          </li>
          
          <li>
              <div>
               <strong>With Class and Element Tags</strong> - The element and class tags we put in the default email are show below. Notice the <strong><em>.atx-notification</em></strong> tag.
               AreteX&trade; puts that class in the <em>body</em> tag of the email.  The email html you supply should <em>not</em> have <em>html</em>,<em>head</em> or <em>body</em> tags, as AreteX&trade; supplies those. 
               
              <br /><br />
              </div>          
              <img src="<?php echo plugins_url( 'slides_welcome/welcome_email_tags.png', __FILE__ ); ?>" />
          </li>
          
          <li>
          <div>
              <strong>Code Formated HTML</strong> - Below you can see the color-formated HTML that generates the default Welcome/Account information email.  Note that there are no <em>html</em>,<em>head</em> or <em>body</em> tags. 
              <br /><br />
              </div>         
              <img src="<?php echo plugins_url( 'slides_welcome/welcome_html_raw.png', __FILE__ ); ?>" />
          </li>
          
        </ul>
        <!-- end Basic jQuery Slider -->

      </div>
      <!-- End outer wrapper -->
    </div>
      <script >
        

          jQuery(document).ready(function($) {
 
  $('#receipt_diagram_slides').bjqs({
    height      : 750,
    width       : 800,
    responsive  : false,
    automatic : false,
    
  });

});

        
      </script>
    
    </div>
</div>