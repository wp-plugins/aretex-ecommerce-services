<div class="ui-widget-content" style="border: none;">
<button onclick="load_main_aretex_content('home');" class="button">Home</button>
<?php
if ($license_info->license_status == 'Good' || $license_info->license_status == 'Trial' || $license_info->license_status == 'Advisory'  ) {
 ?> 
<button class="button" onclick="load_main_aretex_content('set_up');">Setup</button>
<?php } ?>
<button class="button" onclick="load_main_aretex_content('aretex_account');">AreteX&trade; Account</button>
<?php
if ($license_info->license_status == 'Good' || $license_info->license_status == 'Trial' || $license_info->license_status == 'Advisory'  ) {
 ?> 
<button class="button" onclick="load_main_aretex_content('catalog');">Catalog &amp; Products</button> 
<button class="button" onclick="load_main_aretex_content('reports');">Reports &amp; Management</button>
<button class="button" onclick="load_main_aretex_content('integration');">WP Integration</button>  
<?php } ?>
</div>