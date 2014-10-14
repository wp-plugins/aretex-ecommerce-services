<strong>Register with Role</strong>
<p>You may paste these shortcodes onto a page, which will generate a form with your registration options.
</p>
<div id="includes_free_reg"></div>
<p>Be sure to replace   &quot;<strong>---YOUR BUTTON TEXT---</strong> &quot;. You may also replace all button html with image html, if that is better for your theme. </p>
<script>
var inc_free = jQuery('#allow_free_reg').val();
if (inc_free == 'Yes') {
    jQuery('#includes_free_reg').html('<p>This shortcode set includes the option to allow free registration.</p>')
}
</script>