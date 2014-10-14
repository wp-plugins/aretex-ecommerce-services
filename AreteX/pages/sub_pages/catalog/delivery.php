<?php $icon_path = plugins_url('../../../icons/',__FILE__);
 
if (! function_exists('delivery_feature_buttons'))
{
    function delivery_feature_buttons()
    {
         $str = '';
         global $wpdb;               
         $table_name = $wpdb->prefix .'aretex_features';
         $rows = $wpdb->get_results( "SELECT * FROM $table_name WHERE load_feature='Y' AND feature_installed='Y'", ARRAY_A  );
         foreach($rows as $row)
         {         
            $parameters = unserialize($row['parameters']);
            extract($parameters); 
            if ($FeatureType == 'Delivery')
            {
                $class = $row['feature_class'];
                if (method_exists($class,'IconURL'))
                {
                    $icon_src = $class::IconURL($IconPath);
                }
                $click = 'onclick="load_feature_screen('."'{$row['feature_name']}'".','."'main'".');" ';
                $str .= ' <button '.$click.' class="sub_menu_button icon_left_button ui-button"><img class="icon_left" src="'.$icon_src.'"/>'.$IconName.'</button>';

            }
            /*
            $str .= '<a href="#" '.$click.'  class="icon_center_button ui-button button_link  ui-state-default ui-corner-all">';
            $str .= '<img src="'.$icon_src.'" /><br />';
            $str .=  $IconName;
            $str .= '</a> ';
            */
  
         }
         
         
         return $str;
        
    }
    
    
}


?>

    <div class="section group"> <!-- ROW -->
        <div class="col span_12_of_12"> <!-- Column -->
        
        <nav>
        <div class="ui-widget ui-widget-header ui-corner-all" style=" padding: 5px;">
        
        <div class="button-set">
            <button id="overview" onclick="load_delivery_screen('catalog/delivery/overview');" class="sub_menu_button icon_left_button ui-button"><img class="icon_left" src="<?php echo $icon_path.'eye_open_16.png' ?>"/>Overview</button>
            <button id="deliverables" onclick="show_deliverables();" class="sub_menu_button icon_left_button ui-button"><img class="icon_left" src="<?php echo $icon_path.'dispatch_order_16.png' ?>"/>Deliverables</button>         
           <button id="manifests" onclick="load_delivery_screen('manifests');" class="sub_menu_button icon_left_button ui-button"><img class="icon_left" src="<?php echo $icon_path.'inventory_16.png' ?>"/>Manifests</button>         
            
        </div>
        <div id="deliverables_menu" class="button-set">
        <hr />
        &nbsp;&nbsp;
            <button id="overview" onclick="load_screen('catalog/delivery/deliverable/overview');" class="sub_menu_button icon_left_button ui-button"><img class="icon_left" src="<?php echo $icon_path.'eye_open_16.png' ?>"/>Overview</button>
            <?php echo delivery_feature_buttons(); ?>
 <!--
            <button id="paid_content" onclick="load_feature_screen('AreteX Paid Content','pdcnt_mgm');" class="sub_menu_button icon_left_button ui-button"><img class="icon_left" src="<?php echo $icon_path.'treasure_chest_16.png' ?>"/>Paid Content</button>                
            <button id="paid_membership" onclick="load_feature_screen('AreteX Subscriptions and Memberships','mem_mgm');" class="sub_menu_button icon_left_button ui-button"><img class="icon_left" src="<?php echo $icon_path.'administrator_16.png' ?>"/>Paid Membership</button>
-->                
        </div>
        
        </div>
        </nav>
    
        </div> <!-- END Column -->
    </div> <!-- END ROW -->
<div id="detail_screen">
</div>




<script>
jQuery('.button-set').buttonset();
jQuery('#deliverables_menu').hide();

load_screen('catalog/delivery/overview');

function load_delivery_screen(path) {
    jQuery('#deliverables_menu').hide();
    load_screen(path);
}

function show_deliverables() {
    jQuery('#deliverables_menu').show();
    load_screen('catalog/delivery/deliverable/overview');
}
</script>

