<h3>Customizing the Payment Form</h3>
<p>The AreteX&trade; credit card payment form is hosted on a PCI Compliant server. 
You may use the <em>Payment Form Setup</em>  tab, to submit your customizations to the AreteX&trade; payment 
server for branding your payment form. </p>
<div class="accordion" >
<h4>Accepted Credit Cards</h4>
<div>
<p>Be sure to check the card types you accept. Your customer will be presented with the choices you check on this form.</p>
<div class="section group"> <!-- ROW -->
    <div class="col span_6_of_12"> <!-- Column -->
    <div><strong>All Card Types Checked</strong></div>
    <img src="<?php echo plugins_url('images/cardsallchecked.png',__FILE__);?>" />
    </div> <!-- END Column -->
    <div class="col span_6_of_12"> <!-- Column -->
    <div><strong>American Express Not Checked</strong></div>
    <img src="<?php echo plugins_url('images/noamex.png',__FILE__);?>" />
    </div> <!-- END Column -->
</div> <!-- END ROW -->
</div>
<h4>Style Sheet</h4>
<div>
<p>You may use your favorite CSS editor to create or modify a style sheet for the payment form that matches the look and feel of your site. A sample style sheet named <em>payment-form-sample.css</em> can be found in the <em>style_sheet_templates</em> subdirectory of this plugin.
When you have completed your changes you may upload your customer style sheet to the AreteX&trade; server.  
</p>
<p>For your (and your customer's) protection the style sheet will be "sanitized" after being uploaded. 
A "sanitized" style sheet has had potentially harmful code removed to prevent 
cross-site-scripting or injection attacks.  Since the sanititizer may remove some of your CSS, the <em>actual</em> current style sheet in use by the payment form is  shown at the bottom of the "Payment Form Setup" tab.

Note: sanitization does not guarantee that all harmful code has been removed. You are ultimately responsible for the security of your site.</p>
</div>
<h4>Branding Box</h4>
<div>
<p>
The branding box should contain such things as your logo, business name, address, and customer service phone number.
If you leave the branding box blank, AreteX&trade; will put your business name within an <strong>h1</strong> tag above the payment form.
</p>
<p>
You should put raw HTML into  the branding box field, so your fonts, colors and images match or compliment your web site.  If you add an image tag for your logo, your image source <em><strong>must</strong></em> use an <em>https</em> scheme. For example:
<div style="font-family: monospace; font-size: 12px; width: 440px; margin-top: 12px; margin-bottom: 12px; margin-right: auto; margin-left: auto; border-style: solid; border-width: 3px; border-color: black; padding: 10px;">
&lt;img src=&quot;<strong>https:</strong>//yoursite.example.com/yourlogo.png&quot; &gt;
</div> 
Like the style sheet, the HTML will be santitized before being stored on the AreteX&trade; server. Any potentially harmful code (like an image with an <em>http</em> rather than an <em>https</em> scheme) will be removed.
Therefore, after you submit the form, the <em>actual</em> HTML for the branding box is displayed in the Branding Box field.  
</div>
<h4>View the Sample</h4>
<div>
<p>It is obviously important that the payment form be attractive, informative and functional. 
The View Sample button allows you (the web designer) to see how your style sheet and branding box look on the payment form so you can make adjustments until you are satisfied.</p>
<p> 
It will often be necessary to clear your browser's cache before viewing the sample payment form, to be sure all of your latest changes are reflected in the sample.
</p>
</div>
</div>
<script>
jQuery('.accordion').accordion({ heightStyle: "content" });
</script>