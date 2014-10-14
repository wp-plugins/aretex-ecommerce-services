<?
global $payee;
global $business_name;
global $account_id;

require_once(plugin_dir_path( __FILE__ ).'../ptrlib.php');

$signed_up = $_SESSION['current_aretex_payee'];
$current_user_id = get_current_user_id(); 

if ($signed_up->linked_user_id != $current_user_id) {
    $signed_up = AreteX_WPI::payeeSignedUp($current_user_id);
    $_SESSION['current_aretex_payee'] = $signed_up;
}
if (! $signed_up) {
    echo "Problem with Payee User Validation ... ";
    return;
}

$license = AreteX_WPI::getBasLicense();
$business_name = $license->Business_Name;

$account_id = $signed_up->id;

 
 $coupons = getResource('coupon_codes'); 
 $couponsA = getCoupons($coupons);

global $business_url;
$qvar = get_option('aretex_tracking_qvar');
$business_url = get_site_url().'/'.$qvar.'/';

global $explain_deep_link;
$explain_deep_link = get_option('aretex_explain_deep') == 'Yes';

// $promo_message = "Mother's Day Offer good through <em>this Sunday</em>.<br/>The <strong>Coupon Box</strong> is now in the <em>Upper Right Corner</em> of <em>every</em> page. "
$promo_message = get_option('aretex_ptr_referrer_message');
$promo_message = trim($promo_message);
if (empty($promo_message))
    $promo_message = null;

?>
<div class="section group"> <!-- ROW -->

    <div class="col span_8_of_12"> <!-- Column -->
    <?php
  if ($promo_message)
            {
                echo '<div style="margin: 10px;" class="container ui-widget-content ui-corner-all">';
                echo "<h2>Important Message From $business_name</h2><p>$promo_message</p></div>";                
            }
?>
       <div class="section group"> <!-- ROW -->
            <div class="col span_12_of_12"> <!-- Column -->
                <div class="ui-widget-header ui-corner-top" >
                <h3 style="text-align: center; margin-top: 5px; margin-bottom: 5px;">Get Credit for Promoting  <? echo $business_name ?> </h3>
                </div>
                <div style="padding: 5px;" class="ui-widget ui-widget-content  ui-corner-bottom" >
                <p><strong>Earn Commissions &amp; Track Results!</strong>  By setting up and using Tracking Codes
                (also known as  <em>referral codes</em> or <em>coupon codes</em>) and instructions provided below, you can track and measure the results of your sales efforts.  </p>
                  
                 <p>Different promotion venues may be tracked through your personal referral codes.  Link your codes directly to available promotion opportunities, by using the instructions given below.</p> 
                </div>
            </div> <!-- END Column -->
        </div> <!-- END ROW -->
        <div class="section group"> <!-- ROW -->
        <div class="col span_12_of_12"> <!-- Column -->
                <div class="ui-widget-header ui-corner-top" >
                <h3 style="text-align: center; margin-top: 5px; margin-bottom: 5px;">Your Tracking Codes</h3>
                    </div>
                <div class="ui-widget ui-widget-content  ui-corner-bottom" style="padding: 10px;" >
                <div class="section group"> <!-- ROW -->
                    <div class="col span_12_of_12" style="padding-left: 3px;"> <!-- Column -->
                    To get your personalized Tracking Code:<br />
                    <ol style="list-style-type: decimal; font-size: 85%;">
                        <li>Choose a media source (Tracking Code are based on the selected media source).</li>
                        <li>From the list of your Tracking Code available, choose a Tracking Code or URL.</li>
                        <li>Then, copy your Tracking Code or URL in order to
                            <ol style="list-style-type: upper-alpha;">
                            <li>paste into your promotion material,</li>
                            <li>have for your webmaster to add to your website,</li> 
                            <li>have handy for your customers to
                                <ol style="list-style-type: lower-alpha;">
                                <li>type the URL address into their browser or</li> 
                                <li>enter the Tracking Code Into the Referral (or Coupon) box at purchase time. </li>
                                </ol>
                            </li>
                            <!--
                            <li><strong>Advanced Usage Note:</strong> You may also <em>deep link</em> to a specific page using the following pattern:<br /> <em>http://example.com/<strong>YOUR-TRACKING-CODE</strong>/path/to/page</em></li>
                            -->
                            </li>
                            </ol>
                    </ol>
    
                    </div> <!-- END Column -->
                </div> <!-- END ROW -->
                <div class="section group"> <!-- ROW -->
                <div class="col span_3_of_3"> <!-- Column -->
                    <div class="ui-widget ui-widget-content  ui-corner-all" style="padding: 10px;" >
    
                    <label>Select Media Source</label>
                    <? echo  build_media_source_selector($couponsA); ?>
                    </div>
                </div> <!-- END Column -->
                </div> <!-- END ROW -->
                <div class="section group"> <!-- ROW -->
                 <div class="col span_3_of_3"> <!-- Column -->
                    <div class="ui-widget ui-widget-content  ui-corner-all" style="padding: 10px;" >
    
                   
                    <? echo  build_coupon_list($couponsA); ?>
                    
                    </div>
                </div> <!-- END Column -->
                </div> <!-- END ROW -->
                </div>
        </div> <!-- END Column -->
</div> <!-- END ROW -->
    </div> <!-- END Column -->

    <div class="col span_4_of_12"> <!-- Column -->
        <div class="ui-widget-content ui-corner-top" >
        <h3 style="text-align: center; margin-top: 5px; margin-bottom: 5px;">How It Works</h3>
        </div>
        <div style="padding: 5px;" class="ui-widget ui-widget-content  ui-corner-bottom" >
        <ul style="text-indent: -1.0em; margin-left: 1.5em; font-size: 12px;">
            <li><strong>Understanding "Media Source"</strong> - A Media Source is the venue used to provide a sales opportunity.  This can be a website, radio or TV spot, brochure, business card, etc. 
            <li><strong>How You Use a Media Source</strong> - Following the instructions given below for different venue types, put your Tracking Code URL into the text, scan code, or advertising copy of the promotion material.  If you do not provide a direct link to click or scan for a sale, you must
                <ol>
                    <li> provide your customer with instructions for typing your URL directly into their browser, or </li> 
                    <li>provide instructions for entering your referral code at purcahse.</li>
                </ol>
            </li> 
            <li><strong>How to Track Your Media Source Use</strong> - On your "Pending Payments" or "Payments Sent" screen, the Media Source column indicates the venue of your sale.  You may group these venues, using the sort arrow provided on the column.  You may also filter by using the search function.  The Media Source column will only track an available media source, if you set it up by following the instructions below.</li>     
        </ul>
          
        </div>
    </div> <!-- END Column -->
</div> <!-- END ROW -->

<script>
jQuery(document).ready(function() {
    // When any dt element is clicked
        jQuery('dt').click(function(e){
            // All dt elements after this dt element until the next dt element
            // Will be hidden or shown depending on it's current visibility
            if (jQuery(this).hasClass('closed'))
            {
             //   alert('Hello!');
                 jQuery(this).removeClass('closed');
                 jQuery(this).addClass('opened');
            }
            else if (jQuery(this).hasClass('opened'))
            {
                 jQuery(this).removeClass('opened');
                 jQuery(this).addClass('closed');
            }   
            jQuery(this).nextUntil('dt').toggle();
        });

        // Hide all dd elements to start with
        
        jQuery('dt').removeClass('opened');
        jQuery('dd').hide();
        jQuery('dt').addClass('closed');

        
        jQuery('.cc_desc').hide();
        jQuery('.ms_WEB').show();
        
        
        
        
 });
 
 function change_media_source()
 {
    jQuery('dt').removeClass('opened');
    jQuery('dd').hide();
    jQuery('dt').addClass('closed');
        
    var sh = jQuery('#med_src').val();
    var sel = '.ms_'+sh;
    jQuery('.cc_desc').hide(200);
    jQuery(sel).show(200);
    
    
 }
 
</script>
<pre>
<?// var_dump($couponsA); ?>
</pre>
<? 

function media_source_abrev($code)
{
    $parts = explode('-',$code);
    return $parts[2];
    
}


function build_media_source_selector($list)
{
    if ((! is_array($list)) || (empty($list)) ) {
        
        return "No Offers Currently Available";
    }  
    $str .= '<select id="med_src" onchange="change_media_source();">';
    foreach($list as $code=>$detail) {
        $val = $detail['src_abrv'];
        $desc = $detail['source_media'];
        $opt[$val] = $desc .'-'.$val;
    }       
    
    foreach($opt as $val=>$desc) {
        if ($val == 'WEB')
            $selected = 'selected="selected"';
        else
            $selected = '';
        $str .= "<option $selected value=\"$val\">$desc</option>\n";
    }
    
    $str .= '</select>';
    
    return $str;
}

function getCoupons($obj)
{
    $list = array();
    if ($obj)
    {
        $arr = get_object_vars($obj);   
        foreach($arr as $code => $coupon)
        {
            $applies = '';
            $list[$code]['description'] = $coupon->summary->description;
            $list[$code]['source_media'] = $coupon->source_media;
            $list[$code]['src_abrv'] = media_source_abrev($code);
            $summary = $coupon->summary;
            if ($summary->applies_to == 'Category')
            {
             foreach($summary->categories as $cat)
                $applies .= $cat->cat_name.'<br/>';
            }
       //     $list[$code]['applies'] = $applies;
            $list[$code]['mnemonics'] = $coupon->mnemonics;                                                              
        }
    }
    return $list;
}

function build_coupon_list($list)
{
    if (empty($list) || (! is_array($list))) {
        return "No Offers Currently Available";
    }
    
    global $business_url;
    global $business_name;
    $str = '<div class="section group"> <!-- ROW -->' ."\n";
    $str .=  '    <div class="col span_12_of_12"> <!-- Column -->';
    $str .= '<label>Your Tracking Codes For Selected Media Source </label>';
    $str .= '<p style="font-size: 80%;"><em>Click the + (<strong>plus sign</strong>) next to the <strong>Offer</strong> you want to promote to get the tracking code for that specific offer.</em></p>';
    $str .= '<hr/><label>Offers</label>';
    $str .= '<dl>';
    
    foreach($list as $code=>$detail)
    {        
        extract($detail);
        if (empty($description))
            $description = 'General Tracking Code';
        
        $remember = '';
        $c = 0;
        if (! empty($mnemonics))
        {
            foreach($mnemonics as $mnem)
            {
                if (! empty($mnem->standard_mnemonic))
                {
                    $remember .= $mnem->standard_mnemonic.', ';
                    $c++;
                }
            }            
        }
        $remember = trim($remember,', ');
        $etor = '';
        $thisval = 'this';
        $codeval = 'code';
        $codevalCap = 'Code';
        $endval = '';
        if ($c > 1)
        {
            $thisval = 'these';
            $codeval = 'codes';
            $codevalCap = 'Codes';
            $endval = '<br/>Because there are several codes that can be used, they are separated by commas.';
        }
        if (! empty($remember))
        {
           $etor =<<<END_ETOR
           <div class="section group"> <!-- ROW -->
                <div class="col span_1_of_10"> <!-- Column -->
                    &nbsp;
                </div> <!-- END Column -->
                <div class="col span_9_of_10"> <!-- Column -->
                    <strong><em>Splash Code</em> Tracking $codevalCap:</strong> $remember  
                    <em><br/> $business_name has provided you with $thisval easy to remember <strong>Splash $codevalCap</strong>.<br/>                     
                     You may give $thisval $codeval to your customers to use in the coupon box at check out. $endval
                     </span> </em>
                </div><!-- END Col -->
            </div><!-- END Row -->
END_ETOR;
        }
        
        $deep_link = '';
        global $explain_deep_link;
        if ($explain_deep_link) {
            $deep_link=<<<END_DL
            <div class="section group"> <!-- ROW -->
                <div class="col span_1_of_10"> <!-- Column -->
                    &nbsp;
                </div> <!-- END Column -->                           
                <div class="col span_9_of_10"> <!-- Column -->
                    <strong>Specific URL:</strong><br/> $business_url$code/<strong>replace-with-page-name</strong><br/>
                    <em>To promote a <ins>specific</ins> page on this  web site, you may use the URL above as a <strong>sample</strong>.
                    Replace the term "replace-with-page-name"" with the actual page name from the site. Contact $business_name if you have any problems. 
                    </em>
                </div><!-- END Col -->
            </div>
END_DL;
        }
        

        $str .=<<<END_CODE
            <div class="ms_$src_abrv cc_desc"  style="border:thin solid #dddddd; padding-left: 3px;" >
            <dt>                             
                $description              
            </dt>
            <dd>
            $etor
            <div class="section group"> <!-- ROW -->
                <div class="col span_1_of_10"> <!-- Column -->
                    &nbsp;
                </div> <!-- END Column -->
                <div class="col span_9_of_10"> <!-- Column -->
                     <strong>Tracking Code:</strong> $code<br/>                      
                   <em>You may give this code to your customers to use in the coupon box at check out.</em> 
                </div><!-- END Col -->
            </div><!-- END Row -->
            <div class="section group"> <!-- ROW -->
                <div class="col span_1_of_10"> <!-- Column -->
                    &nbsp;
                </div> <!-- END Column -->                           
                <div class="col span_9_of_10"> <!-- Column -->
                    <strong>URL:</strong> $business_url$code<br/>
                    <em>You may use this URL as a "click through link" or have your customers type it into the browser.</em>
                </div><!-- END Col -->
            </div>
            $deep_link
            </div>
            </dd> 
END_CODE;
    }

    $str .= '</dl>';
    $str .= '</div> <!-- END Column -->';
    $str .= '</div> <!-- END ROW -->';
    
    return $str;
}

?>