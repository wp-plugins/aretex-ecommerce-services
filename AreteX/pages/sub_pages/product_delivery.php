<div class="ui-widget-header ui-corner-top" >
<h2 style="text-align: center; margin-top: 5px; margin-bottom: 5px;">Product Delivery</h2>
</div>
<div class="ui-widget ui-widget-content  ui-corner-bottom" style="padding: 5px;" >

    
    <p>Something profound about AreteX&trade; and product delivery goes here.</p>
    <hr />
<h3>Product Delivery</h3>
<a href="#"  onclick="load_screen('manifest_form');" class="icon_center_button ui-button button_link  ui-state-default ui-corner-all">

<img src="<? echo  plugins_url( '../../images/buttons/dispatch_order_40.png', __FILE__ ) ?>" /><br />
New Manifest<br />
(Delivery Code)
</a>



<a href="#"  onclick="load_screen('manifests');" class="icon_center_button ui-button button_link  ui-state-default ui-corner-all">

<img src="<? echo  plugins_url( '../../images/buttons/inventory_40.png', __FILE__ ) ?>" /><br />
Manifest<br />
Management
</a>

<hr />
<? 
if (! function_exists('delivery_feature_icons'))
{
    function delivery_feature_icons()
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
            }
            $str .= '<a href="#" '.$click.'  class="icon_center_button ui-button button_link  ui-state-default ui-corner-all">';
            $str .= '<img src="'.$icon_src.'" /><br />';
            $str .=  $IconName;
            $str .= '</a> ';
         }
         
         
         return $str;
        
    }
    
    
}

echo delivery_feature_icons();

?>


 <hr />
    
</div>
<script>
jQuery(document).ready(function() {
    jQuery(function ($) {
    // Hover states on the static widgets
    	$( ".ui-button" ).hover(
    		function() {
    			$( this ).addClass( "ui-state-hover" );
    		},
    		function() {
    			$( this ).removeClass( "ui-state-hover" );
    		}
    	);
        
        $('.icon_center_button').hover(
            function()
            {
                var src = $( this).children('img').attr('src');           
                src = hover_url(src);        
                $(this).children('img').attr('src',src);
                
                
            },
            function()
            {           
                var src = $( this).children('img').attr('src');
                src = off_hover_url(src);
                $(this).children('img').attr('src',src);
    
            }        
        );
    });
    
    
  
  
 });
</script>
