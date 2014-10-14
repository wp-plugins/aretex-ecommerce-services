<h2>Roles and Capabilities</h2>
<p>AreteX&trade; for WordPress makes  use of  the <a href="http://codex.wordpress.org/Roles_and_Capabilities" target="_blank">WordPress Roles and Capabilities</a> features 
to: 1) Control which AreteX&trade; panels are available in the WordPress Admin Menu to specific users and 2) Allow you to set up paid access to specific WordPress roles with the paid membership feature.</p>
<h3>Within the AreteX&trade; Plugin</h3>
<h4>Existing Capability Use</h4>
<p>By default within WordPress, only users with the Administrator role have <strong>manage_options</strong> capability. 
Therefore, when  you activate the AreteX&trade; for WordPress plugin, any user with the 
<strong>manage_options</strong> capability will be able to access the main AreteX&trade; eCommerce control panel.
</p>
<p>(<em>Users with <strong>manage_options</strong> are able to change nearly all the site's settings within the WordPress administration panel.) </em></p>
<h4>New Capabilities</h4>
<p>This plugin adds two new user capabilities to your WordPress installation: 
    <ul style="text-indent: -1.0em; margin-left: 1.5em; font-size: 12px;" >
        <li><strong>access_aretex_cam</strong> - Any user with the 
        <em>access_aretex_cam</em> capability will have the <em>Customer Account Manager</em> option on their menu.
        This capability is assigned by the AreteX&trade; plugin, either 1) When a purchase has been completed by a logged in user, 
        or 2) A new user has been added to your site who has an email address that matches one of your customer records on the AreteX&trade; server.   
        </li>
        <li><strong>access_aretex_ptr</strong> - Any user with the <em>access_aretex_ptr</em> capability will have the
         the <em>Payment Tracking and Reporting</em> option on their menu.  When you add or edit a payee <em>Reports &amp; Management / Payees / Payee Management </em>
         you may find any existing WordPress user and assign them to that Payee record.  When you do, AreteX&trade; 
         adds the <em>access_aretex_ptr</em> capability to that user record when you save the payee record.     
        </li>
    </ul>
</p>
<h4>New Role</h4>
<p>A new role is also made available with this plugin: <em>AreteX Payee</em>.
When you use the <em>[aretex_payee_signup]</em> short code to allow payees to register (either as referrers or contributors),
they are assigned the role <em>AreteX Payee</em>, which by default has the <em>access_aretex_ptr</em> capability assigned to it.   
</p>
<h3>For Membership Management</h3>
<p>The AreteX&trade; Plugin <em>does not</em> have a membership manager itself. Instead, it provides a way to get paid for membership using any of several membership managment plugins.</p>
<p> If you want to operate a paid membership site, 
you may use almost any plugin that helps you manage roles and capabilities, including those listed 
in the <a href="http://codex.wordpress.org/Roles_and_Capabilities#Resources" target="_blank"><em>Resources</em></a> section of the Roles and Capabilities page (such as <strong>Members</strong>).
</p>
<p>The AreteX&trade; membership feature will allow you to sell authorization to any role you have defined within your WordPress 
installation except the following:
<em>administrator</em>,<em>editor</em>,<em>author</em>,<em>contributor</em>,and <em>aretex_payee</em>, as 
these roles are generally considered administrative in nature. 
</p>