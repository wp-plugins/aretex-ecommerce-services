<?php
   global $wpdb;
  
    $table_name = $wpdb->prefix .'aretex_cache';
    $sql =  "DROP TABLE IF EXISTS  $table_name";
    $wpdb->query($sql); 
    
    $table_name = $wpdb->prefix .'aretex_expansions';
    $sql =  "DROP TABLE IF EXISTS  $table_name";
    $wpdb->query($sql); 

    $table_name = $wpdb->prefix ."aretex_deliverable_options";
    $sql =  "DROP TABLE IF EXISTS  $table_name";
    $wpdb->query($sql); 
        
   $table_name = $wpdb->prefix .'aretex_features';
   $rows = $wpdb->get_results( "SELECT * FROM $table_name",ARRAY_A);
   
	foreach($rows as $row) {
		extract($row);
	
		if ( file_exists($feature_path)){
			include_once($feature_path);
			if (class_exists($feature_class) ) {
				$feature_class::deactivate();
			}
		}
	
	
	}

	

    $table_name = $wpdb->prefix .'aretex_features';
    $sql =  "DROP TABLE IF EXISTS  $table_name";
    $wpdb->query($sql); 
            
            


    $areteXOptions = array(
    'aretex_license_key',
    'aretex_api_key',
    'aretex_api_secret',
    'aretex_sand_box_mode',
    'aretex_rest_endpoint',
    'aretex_public_key',
    'aretex_private_key',
    'aretex_hash',
    'aretex_message_id',
    'aretex_central_publickey',
    'aretex_tracking_qvar',
    'aretex_tracking_cookie_days',
    'aretex_core_path',
    'aretex_bas_endpoint',
    'aretex_cam_endpoint',
    'aretex_cat_endpoint',
    'aretex_go_live_endpoint',
    'aretex_pcs_in_endpoint',
    'aretex_ptr_endpoint',
    'aretex_update_endpoint');
    foreach($areteXOptions as $option) {
        delete_option( $option );
    }
	
	$areteXUserMeta = array(
'atx_customer_id',
'atx_cust_email',
'atx_payee_address',
'atx_payee_agree_tos',
'atx_payee_email',
'atx_payee_name',
'atx_payee_phone'
	);
	// delete_user_meta( $user_id, $meta_key, $meta_value )
	
	remove_role('aretex_payee');
	
	$table_name = $wpdb->prefix .'users';
	$rows = $wpdb->get_results( "SELECT * FROM $table_name",ARRAY_A);
	foreach($rows as $row) {
		extract($row);
		foreach($areteXUserMeta as $meta_key) {
			delete_user_meta( $ID, $meta_key);
		}
		$user = new WP_User($ID);
		$user->remove_cap('access_aretex_cam');
		$user->remove_cap('access_aretex_ptr');
		
	}
	
	

?>