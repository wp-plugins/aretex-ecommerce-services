<h4>AreteX&trade; Shortcode Generator</h4>
<p>Use this screen to put AreteX shortcodes into your pages and posts.</p>
<?php 
    $shortcode = '';
    if (! empty($_SESSION['AreteX_Wizard']['shortcode'])) {
        
        $shortcode = nl2br(trim($_SESSION['AreteX_Wizard']['shortcode']));
        $aretex_core_path = get_option('aretex_core_path');
        $url = plugins_url( 'AreteX/images/buttons/wizard_16.png', $aretex_core_path );
        echo "<p id=\"wizard_here\"><em>Notice:</em>There is a shortcode avaialable from a wizard. You may paste it into your page by selecting the <em>Paste From Wizard Button</em> Below <br/>";
        echo '<button class="button  " onclick="paste_from_wizard()";>'."<img src='{$url}' style='display: inline;' />".'&nbsp;&nbsp;Paste From Wizard</button>';
        echo '&nbsp;&nbsp;&nbsp;<a href="javascript:void(0);" onclick="dismiss();" 
class="button  icon_left_button button_link  "  >
<span class="ui-icon  ui-icon-circle-close"></span>&nbsp;&nbsp; 
Dismiss</a>';
        echo '</p>';
        
    }
    
?>
<p><strong>Overview:</strong> This screen. <br />
 <strong>Paid Content:</strong> Generate short codes related your paid content. <br />
 <strong>Paid Memberships:</strong> Generate short codes related registration or upgrade of paid membership. <br />
<strong>Product Presentation: </strong> Allows you to embed information related to a speicific product (including information based on the current offer) into your page or post. </p>
<script>
function paste_from_wizard() {
    var from_wizard = <?php echo json_encode($shortcode);  ?>;
        
    console.log(from_wizard);
    window.send_to_editor(from_wizard);
}

function dismiss() {
    jQuery('#wizard_here').remove();
}

</script>