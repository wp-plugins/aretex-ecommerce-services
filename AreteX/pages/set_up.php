<?php
  $dir = plugin_dir_path( __FILE__ );
    include($dir.'sub_pages/setup/top_menu.php');
?>
<div class="section group"> <!-- ROW -->
    <div class="col span_11_of_12"> <!-- Column -->

<div class="ui-widget-header ui-corner-top" >
<h2 style="text-align: center; margin-top: 5px; margin-bottom: 5px;">AreteX&trade; Setup</h2>
</div>
<div class="ui-widget ui-widget-content  ui-corner-bottom container" >
<div id="main_content">

<?php include(plugin_dir_path(__FILE__).'sub_pages/setup/overview.php'); ?>

</div>
</div>    
    </div> <!-- END Column -->
</div> <!-- END ROW -->
<script>
jQuery('.button-set').buttonset();

jQuery('button.menu_button').click(
            function() { load_content(this); }
         );

 function load_content(element)
 {
    
    load_content_screen('setup/'+element.id);
    
 }
 

</script>