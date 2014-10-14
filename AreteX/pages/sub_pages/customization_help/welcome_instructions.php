<h4>Welcome / Account</h4>
<div class="accordion" >
    <h3>Introduction</h3>
    <div>
    <p>The AreteX&trade; Customer Account Manager (CAM) allows your customers to manage their contact information, administer their rebill agreements and view their payment history. It uses the email address provided at the time of checkout to uniquely identify a customer.
    </p>
    <p> 
    If you make the CAM available, the first time an email address is used, AreteX&trade; automatically sends the customer an email to explain how to get access to the CAM. 
    This section explains how you can create and/or customize that email message to explain to your customer how
    to access their CAM through the WordPress user system (as shown below).   
           <div>
    <img src="<?php echo plugins_url('../images/cam_front.png',__FILE__) ?>" />
    </div>
    
    </div>
    <h3>Access to the Customer Account Manager (CAM)</h3>
    <div class="">
    <h4>Integration with WordPress</h4>
    <div>
    <p>The CAM is integrated into the WordPress Roles and Capabilities system. That means that to access their AreteX&trade; CAM , 
    a customer must <em>also</em> be a registered user on your WordPress site.  </p> 
    
    <p>Specifically, when the "AreteX&trade; eCommerce Services" 
    plugin is "Installed and Active" any user with the Capability <em><strong>access_aretex_cam</strong></em> will have "Account Management" on their user menu. 
    This is usually abreviated to "Account Man...".  Your Customer can access their CAM by selecting that Account Management menu option.
    </p>
    <p>
    If the user does have the  <em><strong>access_aretex_cam</strong></em> Capability it will be shown at the bottom of their profile page. As shown below.
    <div>
    <img src="<?php echo plugins_url('../images/user_profile_bottom.png',__FILE__) ?>" />
    </div>
    <br/><em>Note the availablity of the Account Manager menu item.</em>
    </p>
    <p style="font-size: 75%; padding-left: 30px;">
    <a target="_blank" href="http://codex.wordpress.org/Roles_and_Capabilities">Click here for information about  WordPress Roles and Capabilities</a>  
    <br />
    <a target="_blank" href="http://codex.wordpress.org/Roles_and_Capabilities#Resources">Click here for information about resources that can 
    make manageing Roles and Capabilities convenient.</a>
    </p>
    </div>
    <h4>If the User is Logged In at Time of Purchase</h4>
    <div>
    <p>When your customer selects a "Buy" or "Subscribe" or "Checkout" button, the logged in user id is transmitted to AreteX&trade; in the checkout stream.
    When a transaction has been approved by the credit card processing company, AreteX&trade; automatically associates the logged-in user id with the new customer account.
    The next time the user logs into their WordPress account, AreteX&trade; will confirm the purchase and automatically assign the <em><strong>access_aretex_cam</strong></em> capablity the the user.   
    </p>
    </div>
    <h4>If User is <em>Not</em> Logged In at Time of Purchase</h4>
    <div>    
    <p>If the user is <strong>not</strong> logged in when they select "Buy", "Subscribe" or "Checkout", 
    AreteX&trade; matches the email address used at checkout to the email address provided when
    they registered for a user account on your WordPress site.  If the email addresses match, the user is granted <em><strong>access_aretex_cam</strong></em> Capability. </p>
    </div>
    </div> <!-- END Acordion -->
    <h3>New Account/Welcome Email</h3>
    <div>
    <p>If you have chosen to make the CAM available, the first time an email address is used, AreteX&trade; will automatically send the customer an email to explain how to get access to the CAM.</p>
    <p>This section explains the things that email message should (or could) say. </p>
    <p><strong>Subject Line - </strong> The email subject line will be <strong>{Your Business Name} Billing Account Instructions</strong> </p>
    <p>Since this is very likely to be a first time customer you will probably want a sentence or two of "welcome".  </p>
    <p>After you welcome them, you will need to explain to them several important things:
    <ol>
        <li>How to Register for a User Account on your Web Site - If they don't already have one.</li>
        <li>How to Log In to that User Account </li>
        <li>How to View their Customer Account Manager</li>
    </ol>
    <p>Exactly <i>how</i> your customers need to register and login will depend on things like which themes, plugins and "login widgets" you are using.
    It will be very specific to <i>your</i> WordPress site. 
    </p>  
    <p>Once they are logged in, they will need to select the "Account Management" tab on their user menu to access the CAM.</p>
    </p>
    
    
    </div>
    <h3>Sample</h3>
    <div>
    <p>The slides below show various views of the default Welcome/Account access email including the HTML. Use the Next/Prev buttons to navigate through the examples.
    Some of these Diagrams are repeated under the CSS/Welcome Account menu tab.
    </p>
    <div style="width: 850px; height: 800px; margin-left: auto; margin-right: auto;">
    <!--  Outer wrapper for presentation only, this can be anything you like -->
      <div id="receipt_diagram_slides1">

        <!-- start Basic Jquery Slider -->
        <ul class="bjqs">
          <li>
              <div>
              <strong>Welcome Email Default</strong> - Below is an example of what the default welecome email would look like.   
              <br /><br />
              </div>          
              <img src="<?php echo plugins_url( 'slides_welcome/welcome_email_sample.png', __FILE__ ); ?>" />
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

    
    </div>
</div> <!-- END accordion -->

<script>
jQuery('.accordion').accordion({ heightStyle: "content" });
</script>

      <script >
        

          jQuery(document).ready(function($) {
 
  $('#receipt_diagram_slides1').bjqs({
    height      : 750,
    width       : 800,
    responsive  : false,
    automatic : false,
    
  });

});

        
      </script>