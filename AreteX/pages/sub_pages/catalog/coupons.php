<div class="tabs">
<ul>
<li><a href="#tabs-1">Coupons &amp; Tracking Codes</a></li>
<li><a href="#tabs-2">Information</a></li>
</ul>
<div id="tabs-1">

<? $icon_path = plugins_url('../../../icons/',__FILE__);?>
<div class="section group"> <!-- ROW -->
    <div class="col span_12_of_12"> <!-- Column -->
        
<nav>
<div class="ui-widget ui-widget-header ui-corner-all" style=" padding: 5px;">

<div class="button-set">
    <button id="overview" onclick="load_screen('catalog/coupons/overview');" class="sub_menu_button icon_left_button ui-button"><img class="icon_left" src="<?php echo $icon_path.'eye_open_16.png' ?>"/>Overview</button>
    <button  onclick="load_screen('catalog/coupons/tc_wizard');" class="sub_menu_button icon_left_button ui-button"><img class="icon_left" src="<?php echo $icon_path.'barcode_16.png' ?>"/>Simple Tracking Code</button>         
    <button  onclick="load_screen('catalog/coupons/offer_codes');" class="sub_menu_button icon_left_button ui-button"><img class="icon_left" src="<?php echo $icon_path.'coin_dollar_16.png' ?>"/>Offer Codes</button>         
    <button  onclick="load_screen('catalog/coupons/source_media');" class="sub_menu_button icon_left_button ui-button"><img class="icon_left" src="<?php echo $icon_path.'newspaper_16.png' ?>"/>Source Media</button>
     <button  onclick="load_screen('catalog/coupons/tracking_code');" class="sub_menu_button icon_left_button ui-button"><img class="icon_left" src="<?php echo $icon_path.'time_frame_16.png' ?>"/>Full Tracking</button>         
   <button  onclick="load_screen('catalog/coupons/splash_codes');" class="sub_menu_button icon_left_button ui-button"><img class="icon_left" src="<?php echo $icon_path.'icq_16.png' ?>"/>Splash Codes</button>          

</div>


</div>
</nav>
        </div> <!-- END Column -->
    </div> <!-- END ROW -->
    
<div id="detail_screen">
</div>

<script>
jQuery('.button-set').buttonset();
load_screen('catalog/coupons/overview');
</script>

</div>
<div id="tabs-2" class="dbui-frame">
<h2>Coupons &amp; Tracking Codes Information</h2>
<h4>Tracking Codes</h4>
<p>AreteX&trade; Tracking Codes are similar to standard affiliate referral codes. Like standard affiliate 
codes, they can be used to track commissions of referrers. However, they also have the following 
advanced features:
<br />1. They can be used either directly in the URL or as a "Coupon Code". That means they are not 
limited to "click throughs".
<br />2. They have the flexibiltiy to be built around Commision Groups, date, and/or product(s).
<br />3. They may be used to automatically compute discounts - thus providing an incentive for their use.
<br />4. They are case and font in-senstive. Not only does it not matter if the user types upper or lower case 
into the coupon box, AreteX will treat letters and numbers that are easily confused as identical characters.
(For example - The letter z and the numeral 2 are treated identically, as are the letter o and the numeral zero).
<br />5. They are "tamper resistent."  Unauthorized alterations to the code that could change the offer, 
referrer, or media source will invalidate the code, rendering it useless.
<p><strong>Tracking Code Components</strong><br />
<img src="<?php echo plugins_url('coupon-diagram.png',__FILE__); ?>" />
</p>
<p>To set up each component:<br />
(The <em>Simple Tracking Code</em> wizard is a good place to start.)<br />
<strong>Offer Code: </strong> <em>Catalog &amp; Products / Coupons &amp; Tracking / Offer Codes </em><br />
<strong>Referrer: </strong> See <em>Setup / Commission Structures / Help &amp; Information </em> for more details.<br />
<strong>Media Source: </strong> <em>Catalog &amp; Products / Coupons &amp; Tracking / Source Media </em><br />
 
</p>
<h4>Splash Codes</h4>
Splash codes are "easy to remember" words or phrases that you can assign to a particular tracking code. 
They are are also case and font in-senstive. 

</p>

</div>
<script>
jQuery('.tabs').tabs();
function load_form_help()
{
    load_div_screen('catalog/coupons/help/form_help','#coupon_help')
}

function load_list_help()
{
    load_div_screen('catalog/coupons/help/list_help','#coupon_help')
}



function load_media_form_help()
{
    load_div_screen('catalog/coupons/help/media_form_help','#coupon_help')
}

function load_media_list_help()
{
    load_div_screen('catalog/coupons/help/media_list_help','#coupon_help')
}

function load_offer_edit_help()
{
     load_div_screen('catalog/coupons/help/form_edit_help','#coupon_help') 
}

</script>
