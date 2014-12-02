<?php

/**
 * @FeatureName: AreteX Paid Content
 *                   -- The Feature Name must be unique
 * @Description: Enables you to charge for "Premium Content" (Articles, Videos, File Downloads, Apps etc.) on your WordPress site using AreteX&trade; eCommerce Services.
 * @FeatureType: Delivery
 * @FeatureClass: AreteX_paid_content
 * @AreteXMenuPath: Product & Catalog Services/Product Delivery/Deliverables/Authorizations
 *                     -- This menu path must already exist in the AreteX Core
 * @AreteXMenuTitle: Paid Content
 * @IconPath: AreteX_paid_content/images/buttons/treasure_chest_16.png
 *              -- Path is relative to this file 
 * @IconName: Paid Content
 * @LoadFeature: Y
 *        -- Valid Values are: Y (Load it without asking); 
 *                             N (Do not load it - Do not ask); 
 *                             Q (Ask about loading it);
 * @FeatureVersion: 1.00.00
 * @AretexServerVersion: 2.05.00
 * 
 * 
 */

/**
 * Copyright 2014, 3B Alliance, LLC. Some rights reserved.
 * 
 * Licensed under GPL v2
 * 
 * Provided "AS IS" without warranty
 * 
 * */
 
 
if ( ! class_exists( 'AreteX_paid_content' ) ) {
    
    class AreteX_paid_content {       
        
        private static $exists; 
        public function __construct() {
            
            if (self::$exists) // force singleton pattern.
                return;        
            
            add_action('plugins_loaded', array( &$this, 'on_load' ), 1 );            
           
            add_action('wp_ajax_atx_create_pdcnt_delv',array('AreteX_paid_content','atx_create_pdcnt_delv'));
            
            add_action('wp_ajax_atx_save_pdcnt_delv',array('AreteX_paid_content','atx_save_pdcnt_delv'));
            
            add_action('wp_ajax_atx_del_pdcnt_delv',array('AreteX_paid_content','atx_del_pdcnt_delv'));
            
            add_action('wp_ajax_atx_paste_pdcnt_sc',array('AreteX_paid_content','atx_paste_pdcnt_sc'));

          
            add_shortcode('aretex_paid_content', array( 'AreteX_paid_content', 'shortcode_by_user' ) ); 
            
            self::install();
    		self::$exists = true;
    
        }
        
       
       public static function core_failure_notice() {
    ?>
    <div class="error">
        <p><?php _e( 'Paid-Content Feature Failure: Must have AreteX Core Installed and Active with valid License', 'aretex-paid-content' ); ?></p>
    </div>
    <?php
    }

       
       
       public static function admin_sub_page(){
          include (plugin_dir_path( __FILE__ ) .'pages/admin_sub_page.php');
       }
        
        public static function install() {
            
            $license =  get_option('aretex_license_key');
            $valid_license = false;
            $license_key = get_option('aretex_license_key');
            if (! empty($license_key)){
                if (! class_exists('AreteX_WPI'))
                {
                    $aretex_core_path = get_option('aretex_core_path');
                    if (empty($aretex_core_path))
                    {
                       // add_action( 'admin_notices',  array('AreteX_paid_content','core_failure_notice') );
                        return;
                    }
                       
                    if (file_exists($aretex_core_path .'AreteX_WPI.class.php'))
                       require_once($aretex_core_path .'AreteX_WPI.class.php');
                    else
                    {                    
                       // add_action( 'admin_notices',  array('AreteX_paid_content','core_failure_notice') );
                        return;                    
                    }
                    
               
                }
                
                if (class_exists('AreteX_WPI'))        
                    $valid_license = AreteX_WPI::validate_license($license_key);
                
            }
            
            if (! $valid_license) {              
               // add_action( 'admin_notices',  array('AreteX_paid_content','core_failure_notice') );
                return;
            }
            else
            {
                // See if it already exists ...
                $installed = self::checkInstallation();
                if (! $installed)
                    return;
                
                if ($installed['feature_installed'] == 'N' && $installed['load_feature'] == 'Y') {
                     global $wpdb;
                     $table_name = $wpdb->prefix .'aretex_features';
                     self::build_db_tables();
                     $installed['feature_installed'] = 'Y';
                     $wpdb->replace( $table_name, $installed, null ); 
                     
                     //`deliverable_type`, `deliverable_descriptor`, `feature_class`
                     $data['deliverable_type'] = 'authorization';
                     $data['deliverable_descriptor'] = 'paid_content';
                     $data['feature_class'] = __CLASS__;
                     $table_name = $wpdb->prefix .'aretex_deliverable_options';
                     $wpdb->replace( $table_name, $data, null ); 
                }
                  
                  
                
            }
        }
        
         protected static function build_db_tables() {
            // Cache Table
            global $wpdb;
            
            $table_name = $wpdb->prefix .'aretex_pdct_auth_cache';
            $sql = <<<END_SQL
            CREATE TABLE  $table_name (
              authorization_key varchar(255) NOT NULL,
              deliverable_code varchar(20) NOT NULL,
              authorization_status varchar(20)   NOT NULL,
              authorization_expires int NULL DEFAULT NULL,
              cache_expires int NOT NULL,
              full_data TEXT  NULL,
              PRIMARY KEY  (authorization_key,deliverable_code)
            );
END_SQL;
            require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
            @dbDelta( $sql );
            
         }
        
        protected static function checkInstallation() {
              global $wpdb;
              $table_name = $wpdb->prefix .'aretex_features';
              $feature_name = 'AreteX Paid Content';
              $rows = $wpdb->get_results( "SELECT * FROM $table_name WHERE feature_name='$feature_name' ", ARRAY_A  );
              if (! empty($rows[0]['feature_name']))
              {
                 return $rows[0];
              }
              
              return null;
        }
        
        
        
        public static function deactivate() {
             global $wpdb;
             
             $table_name = $wpdb->prefix .'aretex_pdct_auth_cache';
             $wpdb->query("DROP TABLE IF EXISTS $table_name");         
            
        }
                
        public function on_load() {
            // Do "Self Check"
            
            $valid_license = false;
            $license_key = get_option('aretex_license_key');
            if (! empty($license_key)){
                $aretex_core_path = get_option('aretex_core_path');
                if (empty($aretex_core_path))
                {
                    // add_action( 'admin_notices',  array('AreteX_paid_content','core_failure_notice') );
                     return; 
                }
                   
                if (! class_exists('AreteX_WPI'))
                {
                     if (! file_exists($aretex_core_path .'AreteX_WPI.class.php'))
                     {
                                        
                      //  add_action( 'admin_notices',  array('AreteX_paid_content','core_failure_notice') );
                        return;                    
                   
                     } 
                     
                     require_once($aretex_core_path .'AreteX_WPI.class.php');
                }
                   

                $valid_license = AreteX_WPI::validate_license($license_key);
                
            }
            
            if (! $valid_license)
            {
               // add_action( 'admin_notices',  array('AreteX_paid_content','core_failure_notice') );
                return; 
            }
            
            /*
                 `plugin_name`, `menu_title`, `page_title`, `plugin_class_name`, `plugin_path`
                 
                 
            */
            
            
            
        }
        
        public static function load_screen($screen) {
            $screen_file = plugin_dir_path( __FILE__ ).'AreteX_paid_content/pages/'.$screen.'.php';
            if (file_exists($screen_file))
                include ($screen_file);
        }
        
        public static function BuildAuthorization_Fields($duration=-1) {
            if (! class_exists('Authorization_Fields'))
            {
                $aretex_core_path = get_option('aretex_core_path');
                require_once($aretex_core_path.'AreteXClientEngine/AuthorizationDeliverable.class.php');
            }
            $authorization_options = 'authorization_key';
            
            $fields = new Authorization_Fields('paid_content',$duration,$authorization_options);
            
            return $fields;
            
        }
        
        public static function BuildOptions(){
            $current_user = wp_get_current_user();            
            $opts['authorization_key'] = $current_user->user_login; //$current_user->ID;
            // Clear the cache for this user ... it's all changing
            global $wpdb;                         
            $table_name = $wpdb->prefix .'aretex_pdct_auth_cache';
            $wpdb->query("DELETE FROM $table_name WHERE authorization_key='{$opts['authorization_key']}' ");

            
            return $opts;            
        }
        /*
        
         var $first_delivery; // days after confirmed order  			
   var $required_payment_status; // Payment status required before deliery is initiated. 
   var $delivery_cycle;
   var $maximum_deliveries;  // Number of total deliveries: -1 means as  long as subscription is paid up.   

        
        */
        
        
        
        
        public static function atx_del_pdcnt_delv() {
            
            $aretex_core_path = get_option('aretex_core_path');
            require_once($aretex_core_path.'AreteX_WPI_DI.class.php');
            
            $ret = AreteX_WPI_DI::delete_deliverable($_POST['id']);
            if (! $ret)
                $ret = 'Unknown Error deleteing deliverable';
            echo json_encode($ret);
            die();
        }
        
        
        public static function atx_create_pdcnt_delv() {
            $ret = self::CreateDeliverable($_POST);
            if (! $ret)
                $ret = 'Unknown Error creating deliverable';
            echo json_encode($ret);
            die();
        }
        
        
        public static function atx_save_pdcnt_delv() {
            parse_str($_POST['data'],$data);
            $ret = self::SaveDeliverable($data['data']);
            if (! $ret)
                $ret = 'Unknown Error saving deliverable';
            echo json_encode($ret);
            die();
        }
        
        public static function paid_content_list() {
       
            $aretex_core_path = get_option('aretex_core_path');
            if (empty($aretex_core_path))
            {              
                echo 'Error: AreteX core not installed';
                exit();
            }
            if (file_exists($aretex_core_path.'AreteXDT.class.php'))
            {
                require_once($aretex_core_path.'AreteXDT.class.php');
            }
            else
            {
                echo 'Error: AreteX core not installed';
                exit();
            }
            
            if (file_exists($aretex_core_path.'AreteX_WPI_DI.class.php'))
            {
                require_once($aretex_core_path.'AreteX_WPI_DI.class.php');
                $deliverables = AreteX_WPI_DI::get_deliverables_by_type('authorization','paid_content');
                
                // "id":"8","deliverable_code":"TPCD1","name":"Test Paid Content Deliverable","description":"Test "
                
                $headers = array('Deliverable Code'=>'deliverable_code','Name'=>'name','Description'=>'description');
                
                $action['function_name'] = "payout_code";
                $action['icon_path'] = 'images/actions/wire_transfer_24.png';
                $action['parameters'] = array('[deliverable_code]');
                $action['title'] = 'Edit Payouts';
                $actions[] = $action;
                
                $action['function_name'] = "edit_pd_cnt";
                $action['icon_path'] = 'images/actions/Edit.png';
                $action['parameters'] = array('[deliverable_code]');
                $action['title'] = 'Edit Paid Content Authorization';
                $actions[] = $action;
                
                
                $action['function_name'] = "delete_pd_cnt";
                $action['icon_path'] = 'images/actions/Delete.png';
                $action['parameters'] = array('[deliverable_code]');
                $action['title'] = 'Delete Paid Content Authorization';
                $actions[] = $action;
                
                
                $str = AreteXDT::TableList($headers,$actions,$deliverables);
                $str .= <<<END_S
                <script>
                    function payout_code(deliverable_code) {
                        var back_screen = {
                            'feature' : 'AreteX Paid Content',
                            'screen'  : 'pdcnt_mgm' 
                        }
                        load_linked_screen_back('deliverable_payouts',deliverable_code,back_screen);
                    }
                    
                    function edit_pd_cnt(deliverable_code) {
                        var back_screen = {
                            'feature' : 'AreteX Paid Content',
                            'screen'  : 'pdcnt_mgm' 
                        }
                        load_linked_feature_screen_back('AreteX Paid Content','edit_pd_cnt',deliverable_code,back_screen);
                    }
                    
                    function delete_pd_cnt(deliverable_code) {
                        var back_screen = {
                            'feature' : 'AreteX Paid Content',
                            'screen'  : 'pdcnt_mgm' 
                        }
                        load_linked_feature_screen_back('AreteX Paid Content','del_confirm',deliverable_code,back_screen);
                    }
                    
                    jQuery( document ).tooltip();
                    
                </script>
END_S;
                
            }
            
            return $str;

        }
        
        
        public static function paid_content_selector() {
       
            $aretex_core_path = get_option('aretex_core_path');
            if (empty($aretex_core_path))
            {              
                echo 'Error: AreteX core not installed';
                exit();
            }
            if (file_exists($aretex_core_path.'AreteXDT.class.php'))
            {
                require_once($aretex_core_path.'AreteXDT.class.php');
            }
            else
            {
                echo 'Error: AreteX core not installed';
                exit();
            }
            
            if (file_exists($aretex_core_path.'AreteX_WPI_DI.class.php'))
            {
                require_once($aretex_core_path.'AreteX_WPI_DI.class.php');
                $deliverables = AreteX_WPI_DI::get_deliverables_by_type('authorization','paid_content');
                
                // "id":"8","deliverable_code":"TPCD1","name":"Test Paid Content Deliverable","description":"Test "
                
                $headers = array('Deliverable Code'=>'deliverable_code','Name'=>'name');
                
               
                 
                $action['function_name'] = "use_deliverable";
                $action['icon_path'] = 'images/actions/checkmark_20.png';
                $action['parameters'] = array('[deliverable_code]','[name]');
                $action['title'] = 'Use this deliverable';
                $actions[] = $action;
                
                
              
                
                
                $str = AreteXDT::TableList($headers,$actions,$deliverables);
                $str .= <<<END_S
                <script>
                    
                    function use_deliverable(deliverable_code,name) {
                        jQuery('#deliv_code').val(deliverable_code);
                        jQuery('#deliv_name').val(name);
                        jQuery('#search_pd_cnt_list').hide();
                        jQuery('#selected_deliverable').show();
                        add_check('#step1_check');
                        jQuery('#deliverable_status').show(); 
                    }
                    
                                                            
                    
                </script>
END_S;
                
            }
            
            return $str;

        }
        
         public static function deliverable_product_selector($deliverable_id) {
       
            $aretex_core_path = get_option('aretex_core_path');
            if (empty($aretex_core_path))
            {              
                echo 'Error: AreteX core not installed';
                exit();
            }
            if (file_exists($aretex_core_path.'AreteXDT.class.php'))
            {
                require_once($aretex_core_path.'AreteXDT.class.php');
            }
            else
            {
                echo 'Error: AreteX core not installed';
                exit();
            }
            
            if (file_exists($aretex_core_path.'AreteX_WPI_DI.class.php'))
            {
                require_once($aretex_core_path.'AreteX_WPI_DI.class.php');
                $deliverables = AreteX_WPI_DI::get_products_by_deliverable($deliverable_id);
                
                // "id":"8","deliverable_code":"TPCD1","name":"Test Paid Content Deliverable","description":"Test "
                
                $headers = array('Product Code'=>'code','Name'=>'name','Pricing Model'=>'pricing_model','Regular Price'=>'price');
                
               
                 
                $action['function_name'] = "use_product";
                $action['icon_path'] = 'images/actions/checkmark_20.png';
                $action['parameters'] = array('[code]','[name]');
                $action['title'] = 'Use this product';
                $actions[] = $action;
                
                
              
                
                
                $str = AreteXDT::TableList($headers,$actions,$deliverables);
                $str .= <<<END_S
                <script>
                    
                    function use_product(code,name) {
                        jQuery('#product_code').val(code);
                        jQuery('#product_name').val(name);
                        jQuery('#add_prod_div').hide();
                        jQuery('#deliverable_setup').show();
                        add_check('#step3_check');
                        jQuery('#sel_prod_button').hide();
                        jQuery('#product_status').show(); 
                        
                    }
                    
                                                            
                    
                </script>
END_S;
                
            }
            
            return $str;

        }
        
        
        // Data Array: name,description,deliverable_code, first_delivery, delivery_cycle, maximum_deliveries, duration
        public static function CreateDeliverable($data) {
            
            
            $data['auth_flds'] = self::BuildAuthorization_Fields($data['duration']);
            if (empty($data['duration']))
                $data['duration'] = -1;
                
            if (empty($data['maximum_deliveries']))
                $data['maximum_deliveries'] = -1;
                               
            
            $aretex_core_path = get_option('aretex_core_path');
            if (empty($aretex_core_path))
            {              
                return 'Error: AreteX core not installed';
            }
            if (file_exists($aretex_core_path.'AreteXClientEngine/AuthorizationDeliverable.class.php'))
            {
                require_once($aretex_core_path.'AreteXClientEngine/AuthorizationDeliverable.class.php');
            }
            else
            {
                 return 'Error: AreteX core not installed';
            }
            $data['required_payment_status'] = PaymentStatus::complete;                        
            $obj = AuthorizationDeliverable::FromData($data);
            
            
            if (file_exists($aretex_core_path.'AreteX_WPI_DI.class.php'))
            {
                require_once($aretex_core_path.'AreteX_WPI_DI.class.php');
                $ret = AreteX_WPI_DI::create_deliverable($obj);
                return $ret;
            }
            else
                return 'Error: AreteX core Delivery System Interface Not Found';
            
                                    
        }
        
        // Data Array: name,description,deliverable_code, first_delivery, delivery_cycle, maximum_deliveries, duration
        public static function SaveDeliverable($data) {
            
           
            
            $data['auth_flds'] = self::BuildAuthorization_Fields($data['duration']);
            if (empty($data['duration']))
                $data['duration'] = -1;
                
            if (empty($data['maximum_deliveries']))
                $data['maximum_deliveries'] = -1;
                               
            
            $aretex_core_path = get_option('aretex_core_path');
            if (empty($aretex_core_path))
            {              
                return 'Error: AreteX core not installed';
            }
            if (file_exists($aretex_core_path.'AreteXClientEngine/AuthorizationDeliverable.class.php'))
            {
                require_once($aretex_core_path.'AreteXClientEngine/AuthorizationDeliverable.class.php');
            }
            else
            {
                 return 'Error: AreteX core not installed';
            }
            $data['required_payment_status'] = PaymentStatus::complete;                        
            $obj = AuthorizationDeliverable::FromData($data);
            
            
            if (file_exists($aretex_core_path.'AreteX_WPI_DI.class.php'))
            {
                require_once($aretex_core_path.'AreteX_WPI_DI.class.php');
                $ret = AreteX_WPI_DI::save_deliverable($obj);
                return $ret;
            }
            else
                return 'Error: AreteX core Delivery System Interface Not Found';
            
                                    
        }

                
        
        public static function IconURL($iconPath){
            $path = plugins_url( $iconPath, __FILE__ );
            return $path;
        }
        
        protected static function RefeshCache($authorization_key,$deliverable_code_p) {
            global $wpdb;
            
            
                         
            $table_name = $wpdb->prefix .'aretex_pdct_auth_cache';
            $now = time();
            $aretex_core_path = get_option('aretex_core_path');

            if (file_exists($aretex_core_path.'AreteX_WPI_DI.class.php')) {                                         
               $wpdb->query("DELETE FROM $table_name WHERE cache_expires <= $now");
               require_once($aretex_core_path.'AreteX_WPI_DI.class.php');
               $response = AreteX_WPI_DI::get_authorization_by_key('paid_content',$authorization_key);              
               $dummy_cache = true;
               if (is_array($response)) {
                    $data = array();               
                    foreach($response as $authorization) {
                                                                      
                        extract($authorization);
                          if ($deliverable_code_p != $deliverable_code)
                            continue;
                        
                        switch(strtolower($authorization_status)) {
                            case 'authorized':
                            case 'pending':
                                if (! empty($expiration_date)) {
                                    if ($expiration_date <= $now) {
                                        $expiration_date = null;
                                        $authorization_status = 'expired';
                                    }
                                    if (! empty($expiration_date)) {
                                       $cache_expires = $expiration_date - 1;
                                    }                                      
                                }
                                else
                                    $cache_expires = strtotime("+30 Days");
                              
                            break;
                            default:
                                $cache_expires = strtotime("+30 Days");
                                $expiration_date = null;
                            break;
                                                            
                        }
                        
                        $wpdb->query("DELETE FROM $table_name WHERE  deliverable_code='$deliverable_code_p' AND authorization_key='$authorization_key' "); 

                       
                            $dummy_cache = false;
                        //`authorization_key`, `deliverable_code`, `authorization_status`, `auhtorization_expires`, `cache_expires`, `full_data`
                        $data['authorization_key']     = $authorization_key;
                        $data['deliverable_code']      = $deliverable_code;
                        $data['authorization_status']  = $authorization_status; 
                        $data['authorization_expires'] = $expiration_date;
                        $data['cache_expires']         = $cache_expires;
                        $data['full_data']             = serialize($authorization);
                        
                                            
                        $wpdb->replace( $table_name, $data, null ); 
                    }
                    
               }
               if ($dummy_cache) {
                    $data = array();
                    $data['authorization_key']     = $authorization_key;
                    $data['deliverable_code']      = $deliverable_code_p;
                    $data['authorization_status']  = null; 
                    $data['authorization_expires'] = null;
                    $data['cache_expires']         = strtotime("+1 minutes");;
                    $data['full_data']             = null;
                    
                                          
                    $wpdb->replace( $table_name, $data, null ); 
                                  
               }
               
               $rows = $wpdb->get_results("SELECT * FROM $table_name WHERE authorization_key='$authorization_key' AND deliverable_code='$deliverable_code_p' ORDER BY authorization_expires DESC ", ARRAY_A);
           
               if (isset($rows[0]) && is_array($rows[0])) {
                    extract($rows[0]);
                    if (empty($expiration_date))
                        return $authorization_status;
                    if ($expiration_date >= time()) {
                        return $authorization_status;
                    }
               }
              }
              
              return null;
                                                 
        }
        
        protected static function CheckUserAuthorization($deliverable_code){            
            global $wpdb;            
            $table_name = $wpdb->prefix .'aretex_pdct_auth_cache';
            
            $current_user = wp_get_current_user();            
            //$current_user->ID;
            /*
             authorization_key varchar(255) NOT NULL,
              deliverable_code varchar(20) NOT NULL,
            */
            
            $rows = $wpdb->get_results("SELECT * FROM $table_name WHERE authorization_key='{$current_user->user_login}' AND deliverable_code='$deliverable_code' ORDER BY authorization_expires DESC ", ARRAY_A);
          //  error_log("Rows = ".var_export($rows,true));
            $refresh_cache = false;
            if (isset($rows[0]) && is_array($rows[0])) {
                extract($rows[0]);
                if (empty($expiration_date))
                    return $authorization_status;
                if ($expiration_date >= time()) {
                    return $authorization_status;
                }
                else
                    $refresh_cache = true;
                    
                if ($cache_expires <= time())
                    $refresh_cache = true;
                
            }
            else 
                $refresh_cache = true;
            
            if ($refresh_cache) {
             //   error_log("Refereshing Cache $deliverable_code");
                return self::RefeshCache($current_user->user_login,$deliverable_code);
            }
            
            return false;
            
        } 
        
        //----------[Short Code Handling] ------------------
        
        protected static function ProcessShortCodeContent($content) {
            
            $content =  do_shortcode( $content );
             $t = microtime(true);    

            return $content;
            
        }
        
        public static function shortcode_by_user($atts,$content=null) {
           extract( shortcode_atts( array(
        		'deliverable_code' => null,
                'status'=>'Authorized' 
                /** ****************************
                 * Valid Values:
                 *    Authorized, !Authorized, Expired, !Expired, Completed, !Compeleted, Pending, !Pending
                 *    May "OR" i.e 'Authorized|Completed'
                 *    May "AND" i.e '!Authorized&!Pending'
                 *    May not mix AND and OR    
                 *    
                 *    Local Status: LoggedIn, !LoggedIn
                 *  
                 ** ***********************/
        	   ), $atts ) );
           
           $t = microtime(true);    

           $auth = self::CheckUserAuthorization($deliverable_code);
           $auth = strtolower($auth);
           $status = strtolower($status);
           
           if (! empty($auth)) {
               // Process 'AND' First 
               $auth_list = explode('&',$status);
               
               $process = false;
               $test = true;
               foreach($auth_list as $stat_item) {              
                  $stat_item = trim($stat_item);
                  if ($stat_item[0] == '!') {// NOT
                    $stat_item = trim(substr($stat_item,1));
                    $test &= ($stat_item != $auth);
                  }
                  else {
                    $test &= ($stat_item == $auth);                 
                  }
                  if ($stat_item == 'loggedin') {
                    $process = false;
                    $test = false;
                    $stat_item = null;
                    break; // You can't AND logged in with anything ...
                  }              
                  if ($test) // If we pass the first time, we will try to process
                    $process = true;
                  else {
                    $process = false;
                    break;
                  }
                                  
               }
               
               if ($process)   
                 return self::ProcessShortCodeContent($content); 

               if (strstr($status,'&')) // We should have already processed it...
                  return null; 
           }
           
           $auth_list = explode('|',$status); // Now deal with OR
            
           foreach($auth_list as $stat_item) {
              $stat_item = trim($stat_item);
              if ($stat_item[0] == '!') {// NOT
                $stat_item = trim(substr($stat_item,1));
                if ($stat_item == 'loggedin') {
                     if (! is_user_logged_in())
                        return self::ProcessShortCodeContent($content);  
                    
                } 
                else if ($stat_item != $auth) {
                    if (! is_user_logged_in())
                        return null;
                    return self::ProcessShortCodeContent($content);
                }
              }
              else {
                if ($stat_item == 'loggedin') {
                    if (is_user_logged_in())
                        return self::ProcessShortCodeContent($content);                
                  }
                   if (! is_user_logged_in())
                    return null;
                 if ($stat_item == $auth)
                    return self::ProcessShortCodeContent($content);
                 
                 
              } 

           }
                       
           return null;
            
        }
        
        public static function short_code_examples($deliverable_code) {
            $str = <<<END_SC_EX
<div id="show_short_code_example">            
<h4>Paid Content Authorization Shortcode</h4>
<p>The  <em>aretex_paid_content</em> shortcode is used to display different 
content to your users depending on their authorization status for this deliverable.</p>
<p>The short code is of the following format:<br/>                        
<div style=" font-family: 'Courier New', Courier,  monospace; font-size:10pt; padding: 5px; "
class="ui-widget ui-widget-content  ui-corner-bottom">             
[aretex_paid_content deliverable_code="$deliverable_code" status="<strong>--SEE BELOW--</strong>"]
---- YOUR CONTENT APPROPRIATE TO STATUS ---
[/aretex_paid_content]
</div>
<p><em><strong>Important Note:</strong></em> Use "text mode" on the page editor when copying and pasting shortcodes to be sure
all embedded HTML is rendered properly.</p>

<h4>Valid <em>status</em> Values<h4>
<table class="gridtable">
<thead>
<tr><th>Status</th><th>Explanation</th><th>Show/Hide</th></tr>
</thead>
<tbody>
<tr><td>Authorized</td><td>User is authorized to view content.  If no status is specified, this status is the default.</td><td><button type="button" class="sc_example_btn">Example</button></td></tr>
<tr class="sc_example"><td colspan="3">
[aretex_paid_content deliverable_code="$deliverable_code" status="Authorized"]
---- YOUR PAID CONTENT GOES HERE ----
[/aretex_paid_content]
</td></tr>

<tr><td>!Authorized</td><td>User is NOT authorized to view content.  The exclamation mark (!) means "NOT".
The reason the user is not authorized is irrelevant.
</td><td><button  type="button" class="sc_example_btn">Example</button></td></tr>
<tr class="sc_example"><td colspan="3">
[aretex_paid_content deliverable_code="$deliverable_code" status="!Authorized"]
---- YOUR 'You are not authorized' CONTENT GOES HERE ----
[/aretex_paid_content]
</td></tr>

<tr><td>Expired</td><td>Only valid when you have a <strong>Duration</strong> specified. The content within the shortcode with this status will be displayed when the duration has passed and has not been renewed. </td><td><button  type="button" class="sc_example_btn">Example</button></td></tr>
<tr class="sc_example"><td colspan="3">
[aretex_paid_content deliverable_code="$deliverable_code" status="Expired"]
---- YOUR 'Your access authorization has expired' CONTENT GOES HERE ----
[/aretex_paid_content]
</td></tr>

<tr><td>!Expired</td><td>The authorization has NOT expired. The exclamation mark (!) means "NOT". </td><td><button  type="button" class="sc_example_btn">Example</button></td></tr>
<tr class="sc_example"><td colspan="3">
[aretex_paid_content deliverable_code="$deliverable_code" status="!Expired"]
---- YOUR 'Your access authorization has not (yet?) expired' CONTENT GOES HERE ----
[/aretex_paid_content]
</td></tr>

<tr><td>Pending</td><td>Only valid when you have a <strong>Availablity</strong> greater than 0. The content within the shortcode with this status will be displayed when the delivery is pending. </td><td><button  type="button" class="sc_example_btn">Example</button></td></tr>
<tr class="sc_example"><td colspan="3">
[aretex_paid_content deliverable_code="$deliverable_code" status="Pending"]
---- YOUR 'Your access authorization is pending' CONTENT GOES HERE ----
[/aretex_paid_content]
</td></tr>

<tr><td>!Pending</td><td>The content within the shortcode with this status will be displayed any time the content is not pending. The exclamation mark (!) means "NOT". </td><td><button  type="button" class="sc_example_btn">Example</button></td></tr>
<tr class="sc_example"><td colspan="3">
[aretex_paid_content deliverable_code="$deliverable_code" status="!Pending"]
---- YOUR 'Your access authorization is not pending' CONTENT GOES HERE ----
[/aretex_paid_content]
</td></tr>


<tr><td>Completed</td><td>Only valid when you have a <strong>Total Re-Auth</strong> specified. The content within the shortcode with this status will be displayed when the maximum number of deliveries has been completed. </td><td><button  type="button" class="sc_example_btn">Example</button></td></tr>
<tr class="sc_example"><td colspan="3">
[aretex_paid_content deliverable_code="$deliverable_code" status="Completed"]
---- YOUR 'Your access authorization has been completed' CONTENT GOES HERE ----
[/aretex_paid_content]
</td></tr>

<tr><td>!Completed</td><td>The content within the shortcode with this status will be displayed when the maximum number of deliveries has NOT been completed. The exclamation mark (!) means "NOT". </td><td><button  type="button" class="sc_example_btn">Example</button></td></tr>
<tr class="sc_example"><td colspan="3">
[aretex_paid_content deliverable_code="$deliverable_code" status="!Completed"]
---- YOUR 'Your access authorization has not  been completed' CONTENT GOES HERE ----
[/aretex_paid_content]
</td></tr>

<tr><td>Authorized|Completed</td><td> <em>(Advanced Useage)</em> The pipe symbol (|) means OR. This content will displayed if the user is Authorized OR the maximum number of deliveries has beenc completed.<br/>
  <em>Note:</em>ANY of the statuses above may be "OR"ed together. If ANY ONE status in an OR condition is valid, the content will be shown.<br/>
  </td><td><button  type="button" class="sc_example_btn">Example</button></td></tr>
<tr class="sc_example"><td colspan="3">
[aretex_paid_content deliverable_code="$deliverable_code" status="Authorized|Completed"]
---- YOUR APPROPRIATE CONTENT GOES HERE ----
[/aretex_paid_content]
</td></tr>

<tr><td>!Authorized&!Pending</td><td> <em>(Advanced Useage)</em> The and symbol (&) means AND. This content will displayed if the user is NOT Authorized AND NOT Pending.<br/>
  <em>Note:</em>ANY of the statuses above may be "ANDED"ed together. If ALL statuses in an AND condition are valid, the content will be shown.<br/>
  </td><td><button  type="button" class="sc_example_btn">Example</button></td></tr>
<tr class="sc_example"><td colspan="3">
[aretex_paid_content deliverable_code="$deliverable_code" status="!Authorized&!Pending"]
---- YOUR APPROPRIATE CONTENT GOES HERE ----
[/aretex_paid_content]
</td></tr>

<tr><td>LoggedIn</td><td>The content within the shortcode with this status will be displayed when the user is logged in regardless of the user's athorization status for this deliverable.<br/>
<em>Note</em> The AND, OR operators (|, &) -- see above -- will NOT work with this status. 
</td><td><button  type="button" class="sc_example_btn">Example</button></td></tr>
<tr class="sc_example"><td colspan="3">
[aretex_paid_content deliverable_code="$deliverable_code" status="LoggedIn"]
---- YOUR USER IS LOGGED IN CONTENT GOES HERE ----
[/aretex_paid_content]
</td></tr>

<tr><td>!LoggedIn</td><td>The content within the shortcode with this status will be displayed when the user is NOT logged in. The exclamation mark (!) means "NOT". <br/>
<em>Note</em> The AND, OR operators (|, &) -- see above -- will NOT work with this status.  
</td><td><button  type="button" class="sc_example_btn">Example</button></td></tr>
<tr class="sc_example"><td colspan="3">
[aretex_paid_content deliverable_code="$deliverable_code" status="!LoggedIn"]
---- YOUR USER IS NOT LOGGED IN CONTENT GOES HERE ----
[/aretex_paid_content]
</td></tr>

</tbody>
</table>
</div>
<script>
jQuery('.sc_example_btn').click(function(){
    var row = jQuery(this).closest('tr');
    var next = row.next();
    next.toggle();
});
jQuery('.sc_example').hide();
</script>            
            
END_SC_EX;
        return $str;
        }
        
        public static function atx_paste_pdcnt_sc() {
            $post_data = array();
            parse_str($_POST['data'],$post_data);
            $ret = self::shortcode_generator($post_data['deliv_code'],$post_data['status'],$post_data['buy_button'] == 'include_buy',$post_data['product_code']);
            echo $ret;
            die();
        }
        
        public static function shortcode_generator($deliverable_code,$status_array,$include_buy,$product_code) {
            
    $shortcodes['authorized'] = <<<END_LI
[aretex_paid_content deliverable_code="$deliverable_code" status="Authorized"]
---- YOUR PAID CONTENT GOES HERE ----
[/aretex_paid_content]            
END_LI;
            
    $shortcodes['loggedin'] = <<<END_LI
[aretex_paid_content deliverable_code="$deliverable_code" status="LoggedIn"]
---- YOUR USER IS LOGGED IN CONTENT GOES HERE ----
[/aretex_paid_content]            
END_LI;
        
    $shortcodes['!loggedin'] = <<<END_NLI
[aretex_paid_content deliverable_code="$deliverable_code" status="!LoggedIn"]
---- YOUR USER IS NOT LOGGED IN CONTENT GOES HERE ----
[/aretex_paid_content]
END_NLI;


    $shortcodes['autorized|completed'] = <<<END_CA
[aretex_paid_content deliverable_code="$deliverable_code" status="Authorized|Completed"]
---- YOUR APPROPRIATE CONTENT GOES HERE ----
[/aretex_paid_content]
END_CA;

    $shortcodes['!completed'] = <<<END_NC
[aretex_paid_content deliverable_code="$deliverable_code" status="!Completed"]
---- YOUR 'Your access authorization has not  been completed' CONTENT GOES HERE ----
[/aretex_paid_content]
END_NC;

    $shortcodes['completed'] = <<<END_CP
[aretex_paid_content deliverable_code="$deliverable_code" status="Completed"]
---- YOUR 'Your access authorization has been completed' CONTENT GOES HERE ----
[/aretex_paid_content]
END_CP;

    $shortcodes['pending'] = <<<END_PN
[aretex_paid_content deliverable_code="$deliverable_code" status="Pending"]
---- YOUR 'Your access authorization is pending' CONTENT GOES HERE ----
[/aretex_paid_content]
END_PN;

    $shortcodes['expired'] = <<<END_EX
[aretex_paid_content deliverable_code="$deliverable_code" status="Expired"]
---- YOUR 'Your access authorization has expired' CONTENT GOES HERE ----
[/aretex_paid_content]
END_EX;



if ($include_buy) {
    $shortcodes['!pending&!authorized'] = <<<END_NAPB
[aretex_paid_content deliverable_code="$deliverable_code" status="!Authorized&!Pending"]
[aretex_buynow code="$product_code"]<button>Buy Now</button>[/aretex_buynow]
[/aretex_paid_content]
END_NAPB;
}
else {
    $shortcodes['!pending&!authorized'] = <<<END_NAP
[aretex_paid_content deliverable_code="$deliverable_code" status="!Authorized&!Pending"]
---- YOUR APPROPRIATE CONTENT GOES HERE ----
[/aretex_paid_content]
END_NAP;
}

if ($include_buy) {
    $shortcodes['!authorized'] = <<<END_NA
[aretex_paid_content deliverable_code="$deliverable_code" status="!Authorized"]
[aretex_buynow code="$product_code"]<button>Buy Now</button>[/aretex_buynow]
[/aretex_paid_content]
END_NA;
}
else {
    $shortcodes['!authorized'] = <<<END_NA
[aretex_paid_content deliverable_code="$deliverable_code" status="!Authorized"]
---- YOUR 'You are not authorized' CONTENT GOES HERE ----
[/aretex_paid_content]
END_NA;
}

            $ret = '';
            foreach($status_array as $astatus) {
                $ret .= $shortcodes[$astatus];
                $ret .= "<br/>\n";
            }
            
            return $ret;

        }
      
         
    }
    
    
    

}



?>