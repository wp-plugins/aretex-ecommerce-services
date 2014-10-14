<script>
function load_form_help() {
             jQuery('#ach_dd_info').load('<?php echo plugins_url('ach_setup_help/help.html',__FILE__); ?>');        

}  
</script>
<h3>ACL Limits Setup</h3>

<div class="section group"> <!-- ROW -->
    <div class="col span_8_of_12"> <!-- Column -->
    
<div id="detail_screen">

<div id="inner_form">

</div> 


</div>
</div> <!-- END Column -->
    <div class="col span_4_of_12"> <!-- Column -->
    

<div id="ach_dd_info" class="ui-widget ui-widget-content  ui-corner-all container dbui-frame" >
       
&nbsp;
</div>

    </div> <!-- END Column -->

</div> <!-- END ROW -->



<script>



load_screen('ach_dd_setup');
load_form_help();

</script>