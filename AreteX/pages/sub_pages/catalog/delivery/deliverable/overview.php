<?php

if (! function_exists('delivery_feature_descriptions'))
{
    function delivery_feature_descriptions()
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
                $str .= "<strong>{$row['feature_name']}</strong> - {$row['description']}<br/><br/>";
            }
   
         }
         
         
         return $str;
        
    }
    
    
}


?>

<h2>Deliverables Overview</h2>

<p><em><strong>Deliverables</strong></em> are a major building block and component of your Product Assembly within AreteX&trade;.  Very simple Products might have only 1 deliverable.  However, more complex products will probably have many Deliverables (Content and Membership) with spread out delivery times for the different Deliverable components.
</p>
<p>AreteX&trade; allows you to build the <em>Product</em> you want to sell with the granularity of <em>time</em> and <em>access availability</em> you wish.  This is one reason why Deliverables are created and stored as separate units within AreteX&trade;.  A major benefit of this is your ability to use a <em><strong>single</strong> Deliverable</em> for <em><strong>multiple</strong> Products</em> that need that component.
</p>
<p><strong>AreteX&trade; Paid Content</strong> - Enables you to charge for "Premium Content" (Articles, Videos, File Downloads, Apps etc.) on your WordPress site.
</p>
<p><strong>AreteX&trade; Subscriptions and Memberships</strong>- Enables you to charge for registration and access to your WordPress site.
</p>
<p>Remember that <strong>Deliverables</strong> are basically <em>building blocks</em> that will be used to help create your Products.  They have to do with the information content or community access you wish to deliver to your customers.
</p>
