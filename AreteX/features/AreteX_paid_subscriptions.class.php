<?php

/**
 * @FeatureName: AreteX Subscriptions and Memberships
 *                   -- The Feature Name must be unique
 * @Description: Enables you to charge for registration and access to your WordPress site using AreteX&trade; eCommerce Services.
 * @FeatureType: Delivery
 * @FeatureClass: AreteX_paid_subscriptions
 * @AreteXMenuPath: Product & Catalog Services/Product Delivery/Deliverables/Authorizations
 *                     -- This menu path must already exist in the AreteX Core
 * @AreteXMenuTitle: Paid Membership
 * @IconPath: AreteX_paid_subscriptions/images/buttons/administrator_16.png
 *              -- Path is relative to this file 
 * @IconName: Paid Membership
 * @LoadFeature: Y
 *        -- Valid Values are: Y (Load it without asking); 
 *                             N (Do not load it - Do not ask); 
 *                             Q (Ask about loading it);
 * @FeatureVersion: 1.00.00
 * @AretexServerVersion: 2.05.00
 * 
 */
 
 if ( ! class_exists( 'AreteX_paid_subscriptions' ) ) {
    
    class AreteX_paid_subscriptions {
        private static $exists; 
         
        public function __construct() {
            if (self::$exists) // force singleton pattern.
                return;
            
            
             add_action('wp_ajax_nopriv_atx_register',array('AreteX_paid_subscriptions','atx_register_callback'));
             add_action('wp_ajax_atx_register',array(&$this,'atx_register_callback'));
             add_action('aretexmemcheck',array('AreteX_paid_subscriptions','atx_membership_authorization_check') );
             add_action('wp_ajax_atx_create_mem_delv',array('AreteX_paid_subscriptions','atx_create_mem_delv'));            
             add_action('wp_ajax_atx_save_mem_delv',array('AreteX_paid_subscriptions','atx_save_mem_delv'));
                          
             add_filter('authenticate',array('AreteX_paid_subscriptions','authorize'),10,3);
             add_filter('registration_errors', array('AreteX_paid_subscriptions','check_free_reg'), 10, 3);
             add_filter( 'cron_schedules', array('AreteX_paid_subscriptions','add_every_two_min') );
             
             add_shortcode('aretex_paid_registration', array( 'AreteX_paid_subscriptions', 'paid_registration_sc' ) );
             add_shortcode('aretex_register_button', array( 'AreteX_paid_subscriptions', 'register_button_sc' ) );
             add_shortcode('aretex_role_button', array( 'AreteX_paid_subscriptions', 'role_button_sc' ) );
                  
             add_action('wp_ajax_atx_paste_pdmem_sc',array('AreteX_paid_subscriptions','atx_paste_pdmem_sc'));
            
                
            self::install();
    		self::$exists = true;    
            
        }
        
        public static function atx_paste_pdmem_sc() {
            $post_data = array();
            parse_str($_POST['data'],$post_data);
            $ret = self::shortcode_generator($post_data['member_option'],$post_data['product_code'],$post_data['allow_free'] == 'allow_free');
            echo $ret;
            die();
        }
        
        protected static function shortcode_generator($member_option,$product_code, $incl_free) {
            if ($member_option == 'reg_role') {
                return self::paid_membership_reg_short_code($product_code,$incl_free);
            }
            else
                return self::paid_membership_role_only_short_code($product_code);
            
        }
        
        protected function paid_membership_role_only_short_code($code) {
            return "[aretex_role_button product_code=\"$code\"]<button> ---YOUR BUTTON TEXT--- </button>[/aretex_role_button]";
        }
        
        protected function paid_membership_reg_short_code($code,$incl_free = true) {
            $free = <<<END_FREE
[aretex_register_button]<button type="button">Free Membership </button>[/aretex_register_button]<br/>
(No credit Card required for Free Membership)
END_FREE;
            if (! $incl_free) {
                $free = '';
            }
            
            $str = <<<END_PDRG
[aretex_paid_registration style="standard"]
$free
[aretex_register_button product_code="$code"]<button type="button"> ---YOUR BUTTON TEXT--- </button>[/aretex_register_button]

[/aretex_paid_registration]
END_PDRG;
            return $str;
        }
        
        public static  function add_every_two_min( $schedules ) {
         	// Adds once every_five_min to the existing schedules.
         	$schedules['every_two_min'] = array(
         		'interval' => 120,
         		'display' => __( 'Every Two Minutes' )
         	);
         	return $schedules;
        }
        
        public static function check_free_reg($errors, $sanitized_user_login, $user_email) {
    
        if (get_option('aretex_only_paid_reg'))
            $errors->add( 'error', __('<strong>ERROR</strong>: Free Regisration Not Allowed.') );
    
        return $errors;
    
        }
        
        public static function core_failure_notice() {
    ?>
    <div class="error">
        <p><?php _e( 'Paid-Subscription Feature Failure: Must have AreteX Core Installed and Active with valid License', 'aretex-paid-content' ); ?></p>
    </div>
    <?php
        }
        
        
       public static function deactivate() {
             global $wpdb;
             wp_clear_scheduled_hook( 'aretexmemcheck' );
             $table_name = $wpdb->prefix .'aretex_paid_sub_auth_cache';
             $wpdb->query("DROP TABLE IF EXISTS $table_name");
             delete_option('aretex_only_paid_reg'); 
             delete_option('aretex_pdsub_hidden_roles');        
            
       } 

       public static function atx_create_mem_delv() {
            $ret = self::CreateDeliverable($_POST);
            if (! $ret)
                $ret = 'Unknown Error creating deliverable';
            echo json_encode($ret);
            die();
        }
        
        public static function atx_save_mem_delv() {
            parse_str($_POST['data'],$data);
           
            $ret = self::SaveDeliverable($data['data']);
            if (! $ret)
                $ret = 'Unknown Error saving deliverable';
            echo json_encode($ret);
            die();
        }
        
        public static function BuildAuthorization_Fields($duration=-1,$additional_fields) {
            if (! class_exists('Authorization_Fields'))
            {
                $aretex_core_path = get_option('aretex_core_path');
                require_once($aretex_core_path.'AreteXClientEngine/AuthorizationDeliverable.class.php');
            }
            $authorization_options = 'username,email,authorization_key';
           
            
            $fields = new Authorization_Fields('paid_subscriptions',$duration,$authorization_options,$additional_fields);
            
            return $fields;
            
        }
        
        
        // Data Array: name,description,deliverable_code, first_delivery, delivery_cycle, maximum_deliveries, duration
        public static function SaveDeliverable($data) {
            
            
            $additional_fields = array();
            $addl_fld_names = array('role_type','role_at_expiration','role_delivered');
            foreach($addl_fld_names as $fld_name){
                $additional_fields[$fld_name] = $data[$fld_name];
            }
            
            $additional_fields = serialize($additional_fields);
            
            if (empty($data['duration']))
                $data['duration'] = -1;
                
            if (empty($data['maximum_deliveries']))
                $data['maximum_deliveries'] = -1;
                               
            $data['auth_flds'] = self::BuildAuthorization_Fields($data['duration'],$additional_fields);

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

        
        
        // Data Array: name,description,deliverable_code, first_delivery, delivery_cycle, maximum_deliveries, duration
        public static function CreateDeliverable($data) {
            
            $additional_fields = array();
            $addl_fld_names = array('role_type','role_at_expiration','role_delivered');
            foreach($addl_fld_names as $fld_name){
                $additional_fields[$fld_name] = $data[$fld_name];
            }
            
            $additional_fields = serialize($additional_fields);
            $data['auth_flds'] = self::BuildAuthorization_Fields($data['duration'],$additional_fields);
            if (empty($data['duration']))
                $data['duration'] = -1;
                
            if (empty($data['maximum_deliveries']))
                $data['maximum_deliveries'] = -1;
                               
            
            $aretex_core_path = get_option('aretex_core_path');
            if (empty($aretex_core_path)) {              
                return 'Error: AreteX core not installed';
            }
            if (file_exists($aretex_core_path.'AreteXClientEngine/AuthorizationDeliverable.class.php')){
                require_once($aretex_core_path.'AreteXClientEngine/AuthorizationDeliverable.class.php');
            }
            else {
                 return 'Error: AreteX core not installed';
            }
            $data['required_payment_status'] = PaymentStatus::complete;                        
            $obj = AuthorizationDeliverable::FromData($data);
            
            
            if (file_exists($aretex_core_path.'AreteX_WPI_DI.class.php')) {
                require_once($aretex_core_path.'AreteX_WPI_DI.class.php');
                $ret = AreteX_WPI_DI::create_deliverable($obj);
                return $ret;
            }
            else
                return 'Error: AreteX core Delivery System Interface Not Found';
            
                                    
        }

       
       public static function admin_sub_page(){
          include (plugin_dir_path( __FILE__ ) .'pages/admin_sub_page.php');
       }
        
       public static function install() {
            $license =  get_option('aretex_license_key');
            $valid_license = false;
            $license_key = get_option('aretex_license_key');
            if (! empty($license_key)){
                if (! class_exists('AreteX_WPI')) {
                    $aretex_core_path = get_option('aretex_core_path');
                    if (empty($aretex_core_path)) {
                        add_action( 'admin_notices',  array('AreteX_paid_subscriptions','core_failure_notice') );
                        return;
                    }
                       
                    if (file_exists($aretex_core_path .'AreteX_WPI.class.php'))
                       require_once($aretex_core_path .'AreteX_WPI.class.php');
                    else
                    {                    
                        add_action( 'admin_notices',  array('AreteX_paid_subscriptions','core_failure_notice') );
                        return;                    
                    }                    
               
                }
                
                if (class_exists('AreteX_WPI'))        
                    $valid_license = AreteX_WPI::validate_license($license_key);
                    
                if (! $valid_license) {              
                    add_action( 'admin_notices',  array('AreteX_paid_subscriptions','core_failure_notice') );
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
                         $data['deliverable_descriptor'] = 'paid_subscriptions';
                         $data['feature_class'] = __CLASS__;
                         $table_name = $wpdb->prefix .'aretex_deliverable_options';
                         $wpdb->replace( $table_name, $data, null ); 
                         
                         update_option('aretex_pdsub_hidden_roles',array('administrator','editor','author','contributor','aretex_payee'));
                    }
                    
                }
            }
       }
       
       
       protected static function build_db_tables() {
            // Cache Table
            global $wpdb;
            
            $table_name = $wpdb->prefix .'aretex_paid_sub_auth_cache';
            $sql = <<<END_SQL
            CREATE TABLE  $table_name (
              user_id varchar(255) NOT NULL,
              deliverable_code varchar(20) NOT NULL,
              txn_id varchar(255) NULL,
              role_type varchar(50) NULL,
              role_delivered varchar(255) NULL,
              role_at_expiration varchar(255) NULL,
              authorization_time int NOT NULL,
              authorization_status varchar(20)   NOT NULL,
              auhtorization_expires int  NULL,
              cache_expires int NOT NULL,
              full_data TEXT  NULL,
              PRIMARY KEY  (user_id,role_delivered)
            );
END_SQL;
            require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
            @dbDelta( $sql );
            
         }
       
        
       protected static function checkInstallation() {
              global $wpdb;
              $table_name = $wpdb->prefix .'aretex_features';
              $feature_name = 'AreteX Subscriptions and Memberships';
              $rows = $wpdb->get_results( "SELECT * FROM $table_name WHERE feature_name='$feature_name' ", ARRAY_A  );
              if (! empty($rows[0]['feature_name']))
              {
                 return $rows[0];
              }
              
              return null;
        }
        
        protected static function unreserveUsername($username) {
             global $wpdb;            
            $table_name = $wpdb->prefix .'aretex_paid_sub_auth_cache';
            $now = time();
            $wpdb->query("DELETE FROM $table_name WHERE cache_expires < $now");
            $wpdb->query("DELETE FROM $table_name WHERE user_id='$username' AND deliverable_code='ATXRSVRVUID'");

        }
        
        protected static function scheduleAuthorizationPolling($username) {
            $args['username'] = $username;
            $timestamp = time() + (60); // Give them a minute  
            
            wp_schedule_event($timestamp, 'every_two_min', 'aretexmemcheck', $args);
        }
        
        protected static $new_user_set;
        public static function atx_membership_authorization_check($username) {            
            $user_data = self::RefeshCache($username);
            
            $auth = self::CheckAuthorization($username);
            if (! empty($auth)) {
              foreach($auth as $authorization) {
                if (empty($authorization))
                    continue;
                extract($authorization);
                if (($role_type == 'reg_role') && strtolower($authorization_status) == 'authorized' ) {
                    if (! empty($txn_id)) {                        
                        self::$new_user_set = false;
                        $wp_user = self::authorize('',$username,$txn_id);                        
                        if (self::$new_user_set) {
                            
                            wp_new_user_notification( $wp_user->ID, $txn_id );                                                                
                        }
                        if ($wp_user->ID) {
                            // Stop checking ...                            
                            $original_args = array();
                            $original_args['username']=$username;
                            $timestamp = wp_next_scheduled( 'aretexmemcheck', $original_args  );                                                                
                            wp_unschedule_event( intval($timestamp), 'aretexmemcheck', $original_args );
                        }
                        
                    }
                }
                
              }
             
            }
            else  {
                
                $original_args = array();
                $original_args['username']=$username;
                $timestamp = wp_next_scheduled( 'aretexmemcheck', $original_args);                
                
                wp_unschedule_event( intval($timestamp), 'aretexmemcheck', $original_args );                
            }
           
            
            
        }
        
        protected static function reserveUsername($username) {
            
          //  error_log("Reserving ... $username");
                                   
            global $wpdb;            
            $table_name = $wpdb->prefix .'aretex_paid_sub_auth_cache';
            $now = time();
            $wpdb->query("DELETE FROM $table_name WHERE cache_expires <= $now");
            $rows = $wpdb->get_results("SELECT * FROM $table_name WHERE user_id='$username' AND deliverable_code='ATXRSVRVUID'", ARRAY_A );
            if (! empty($rows)) {
                if (! empty($rows[0]['user_id'])) {
                    return false;
                }
            }
            $data['user_id'] = $username;
            $data['deliverable_code'] = 'ATXRSVRVUID';
            $data['authorization_status'] = 'Reserved';
            $data['role_delivered'] = 'ATX_TMP_RSRVD';
            $data['authorization_time'] = time();
            $data['auhtorization_expires'] = $now + (8 * 60 * 60); // Reserve for 8 hours 
            $data['cache_expires'] = $now + (8 * 60 * 60); // Reserve for 8 hours 
          //  error_log("Data".var_export($data,true));
            
            $wpdb->replace($table_name,$data,array( '%s','%s','%s','%s','%d','%d','%d' ));
            self::scheduleAuthorizationPolling($username);
            return true;
        }
        
        public static function role_button_sc($atts,$content=null) {
            extract( shortcode_atts( array(
        		'product_code' => 'none',          
        	   ), $atts ) );
                              
               
         //   error_log("Attributes:".var_export($atts,true)."\nContent:$content");
            
            $aretex_core_path = get_option('aretex_core_path');
            require_once($aretex_core_path . 'simple_html_dom.php');
            
            $content =  do_shortcode($content); // Deal with embedded shortcodes first, in this case ... 
            $html = str_get_html($content);
       //     error_log("HTML:".var_export($html,true));
            
            $img = $html->find("img", 0);
            $div_id = uniqid('btn');
            if ($img) {
                 
                $outertext = $img->outertext;
                $style = $img->style;
                
                
               
                 
                $on_click = " onclick=\"atx_role_only('".$product_code."','".$div_id."');\"";
                            
                
                $replace = "img $on_click style=\"cursor: pointer; $style\" ";
                $needle = 'img';
                $pos = strpos($outertext,$needle);
                if ($pos !== false) {
                    $outertext = substr_replace($outertext,$replace,$pos,strlen($needle));
                }
            
            }
            else {
               $button = $html->find("button", 0);
               $outertext = $button->outertext;

               $on_click = " onclick=\"atx_role_only('".$product_code."','".$div_id."');\"";
               
                $replace = "button $on_click style=\"cursor: pointer; $style\" ";
                $needle = 'button';
                $pos = strpos($outertext,$needle);
                if ($pos !== false) {
                    $outertext = substr_replace($outertext,$replace,$pos,strlen($needle));
                }
                
            }
                      
           return '<div id="'.$div_id.'">'.$outertext.'</div>';
            
            
            
        }
        
        public static function paid_registration_sc($atts,$content=null) {
            extract( shortcode_atts( array(
                'style'=>'standard', // Don't mess with this one now either ...         
                /** ****************************
                 * Valid Values:
                 *    Standard, Minimal, Custom                
                 *    Minimal: Username, Email
                 *    Standard: Minimal +  First Name, Last Name
                 *    Custom: Replaces "innards" 
                 ** ***********************/
                 'jqvalidate' => 'false', // Not using Now
                 /** ***
                  *  Use Jquery Validate ... later ....
                  * */
                  'captcha'=>'None' // Not using now ... 
                  /** *
                   *  visualCaptcha
                   *  Use 'None' - to turn it off ... otherwise we will add more later...
                   ** */                           
        	   ), $atts ) );
            
            $style = strtolower(trim($style));   
            $output = '<div class="aretex-paid-reg"><form id="aretex_registration_form" class="aretex-registration-form" >';            
            if ($style == 'custom' ) {
                $output .= $content;
            }
            else {
                $output .= <<<END_STD_FLDS
                <p><em>Note:</em> Your temporary password will be emailed to you when payment has been completed.</p>
                
                <div style="display: block;">
                     <div style="display: inline; padding: 5px;"><label for="username">User Name</label></div>
                     <div><div style="display: inline; padding: 5px;"> <input type="text" id="username" name="username" /></div> 
                </div>
                <div style="display: block;">
                     <div style="display: inline;  padding: 5px;"><label for="email">Email Address</label></div>
                     <div><div style="display: inline;   padding: 5px;"> <input type="text" id="email" name="email" /></div> 
                </div>
                <br/>
END_STD_FLDS;
                $output .= $content;
                
                
                $output =  do_shortcode( $output );
                                
            }
            $output .= '</form></div>';
            return $output;
        }
        
        public static function register_button_sc($atts,$content=null) {
            extract( shortcode_atts( array(
        		'product_code' => 'none',
                'form_id' => 'aretex_registration_form'
        	   ), $atts ) );
                              
               
         //   error_log("Attributes:".var_export($atts,true)."\nContent:$content");
            
            $aretex_core_path = get_option('aretex_core_path');
            require_once($aretex_core_path . 'simple_html_dom.php');
            
            $content =  do_shortcode($content); // Deal with embedded shortcodes first, in this case ... 
            $html = str_get_html($content);
       //     error_log("HTML:".var_export($html,true));
            
            $img = $html->find("img", 0);
            if ($img) {
                 
                $outertext = $img->outertext;
                $style = $img->style;
                
                
               
                 
                $on_click = " onclick=\"atx_register('".$product_code."','".$form_id."');\"";
                            
                
                $replace = "img $on_click style=\"cursor: pointer; $style\" ";
                $needle = 'img';
                $pos = strpos($outertext,$needle);
                if ($pos !== false) {
                    $outertext = substr_replace($outertext,$replace,$pos,strlen($needle));
                }
            
            }
            else {
               $button = $html->find("button", 0);
               $outertext = $button->outertext;
               $style = $button->style;

               $on_click = " onclick=\"atx_register('".$product_code."','".$form_id."');\"";
               
                $replace = "button $on_click style=\"cursor: pointer; $style\" ";
                $needle = 'button';
                $pos = strpos($outertext,$needle);
                if ($pos !== false) {
                    $outertext = substr_replace($outertext,$replace,$pos,strlen($needle));
                }
                
            }
                      
           return $outertext;
            
        }
        
        public static function  atx_register_callback() {
            
            // validate post data:
            //  1. Username must be unique
            //  2. Email must be valid and unique            
            //  -- Role Only ---
            //   User Must be logged in ...
            if ($_POST['options'] == 'role_only')
            {
               $current_user = wp_get_current_user();
               if ($current_user->ID == 0) {
                    $element_id = $_POST['element_id'];
                    $err['element'] = $element_id;
                    $err['message'] = 'You must be logged in for this purchase.';
        			$errors[] = $err;
                    
                    $return['errors'] = $errors;
                    $return = json_encode($return);
                    echo $return; 
                    die(); // this is required to return a proper result
               }
               else
               {
                    $registration_options['username'] = $current_user->user_login;
                    $registration_options['email'] = $current_user->user_email;
                    self::reserveUsername($current_user->user_login); // For Role Update
               }
               
            }
            else
            {
                $options= urldecode($_POST['options']);
                parse_str($options,$registration_options);
                    // this is required for username checks
            //    error_log("Registration Options".var_export($registration_options,true)); 
        		require_once(ABSPATH . WPINC . '/registration.php');
         
                $errors = array(); 
                $registration_options['username'] = sanitize_user( $registration_options['username']);
              //  error_log("Reg Options = ".$registration_options['username']);
        		if(username_exists($registration_options['username'])) {
        			// Username already registered
                    $err['element']='username';
                    $err['message'] = 'Username already exists - please enter another';
        			$errors[] = $err;
        		}
        		if(!validate_username($registration_options['username'])) {
        			// invalid username
        		    $err['element']='username';
                    $err['message'] = 'Username is not valid - please enter another';
        			$errors[] = $err;
        		}
                
                if(email_exists($registration_options['email'])) {
                       $err['element']='email';
                    $err['message'] = 'Email already registered - please enter another';
        			$errors[] = $err;
                }
                
                if ($_SESSION['aretex_reserved_username'] != $registration_options['username']) {
                    if (self::reserveUsername($registration_options['username'])) {
                        $_SESSION['aretex_reserved_username'] = $registration_options['username'];
                    }
                    else {
                        $err['element']='username';
                        $err['message'] = 'Username is reserved pending payment completion.';
            			$errors[] = $err;
                    }
                    
                }
                
        		
                
                if (! empty($errors)){
                    $return['errors'] = $errors;
                    $return = json_encode($return);
                    echo $return; 
                    die(); // this is required to return a proper result
                } // If not valid json_encode the error list and pop it back             
                
               
                
               
               if ($_POST['code'] == 'none') {
                 register_new_user( $registration_options['username'],$registration_options['email'] );
                 $return = json_encode("Check your email for registration info");
                 echo $return; 
                 die();
                    
                
               }
           } 
            $product_data = AreteX_WPI::getProductDetailByCode($_POST['code']);
             

            $registration_options['force_email'] = true;
            $registration_options['authorization_key'] = $registration_options['username']; 
            
            
            
           // $button_code = AreteX_WPI::SingleProductButtonCode($product_data,TxnType::sale,$registration_options);
            if ($product_data->details->pricing->pricing_model == PricingModel::single_price  )
                $button_code =  AreteX_WPI::SingleProductButtonCode($product_data,TxnType::sale,$registration_options);
             else if ($product_data->details->pricing->pricing_model == PricingModel::donation)                
                $button_code =  AreteX_WPI::SingleProductButtonCode($product_data,TxnType::donation,$registration_options);
             else if ($product_data->details->pricing->pricing_model == PricingModel::recurring_billing)
                $button_code =  AreteX_WPI::SingleProductButtonCode($product_data,TxnType::autopay_subscription,$registration_options);
 
         
            
            $url = get_option('aretex_pcs_in_endpoint');
            $url .= '/begin_cc_co.php';
            $return['data'] = $button_code; // Was already JSON encoded ...
            $return['url'] = $url; 
            
            $return = json_encode($return);
            
          //  error_log("Button Code: ".var_export($button_code,true));
            echo $return; 
            
           	die(); // this is required to return a proper result
        }
 
        public static function IconURL($iconPath){
            $path = plugins_url( $iconPath, __FILE__ );
            return $path;
        }
        
        
        public static function load_screen($screen) {
            $screen_file = plugin_dir_path( __FILE__ ).'AreteX_paid_subscriptions/pages/'.$screen.'.php';
            if (file_exists($screen_file))
                include ($screen_file);
        }
        
        protected static function SupercedeRole($username,$old_role) {
            global $wpdb;            
            $table_name = $wpdb->prefix .'aretex_paid_sub_auth_cache';
            
            $stack_dump = debug_backtrace();
          
           
            
            $rows = $wpdb->get_results( "SELECT * FROM $table_name WHERE user_id='$username' AND  role_delivered='$old_role'  ", ARRAY_A  );
            if (!empty($rows[0]['full_data'])) {                
                $full_data = unserialize($rows[0]['full_data']);
                
                AreteX_WPI_DI::update_authorization($full_data['id'],'Completed',null);
            }
            

            
            $wpdb->query("UPDATE $table_name SET authorization_status='Completed', auhtorization_expires=NULL WHERE user_id='$username' AND  role_delivered='$old_role' ");
            
        }
        
         protected static function CheckAuthorization($username){            
            global $wpdb;            
            $table_name = $wpdb->prefix .'aretex_paid_sub_auth_cache';
            
            
            
            $rows = $wpdb->get_results("SELECT * FROM $table_name WHERE user_id='$username' ORDER BY authorization_time DESC ", ARRAY_A);
            $refresh_cache = false;
            $ret_data = array();
            if (is_array($rows)) {
                foreach($rows as $row) {
                    extract($row);
                    if (empty($auhtorization_expires) || $auhtorization_expires == '0')
                        $ret_data[] = $row;
                    if ($auhtorization_expires >= time()) {
                       $ret_data[] = $row;
                    }
                    else
                        $refresh_cache = true;
                        
                    if ($cache_expires <= time())
                        $refresh_cache = true;
                }                
            }
            else 
                $refresh_cache = true;
            
            if ($refresh_cache)
                return self::RefeshCache($username);
            else
                return $ret_data;
                      
            
        }
        
        protected static function RefeshCache($authorization_key,$extend_cache=false) {
            global $wpdb;
                         
            $table_name = $wpdb->prefix .'aretex_paid_sub_auth_cache';
            $now = time();
            $aretex_core_path = get_option('aretex_core_path');

            if (file_exists($aretex_core_path.'AreteX_WPI_DI.class.php')) {                                         
               $wpdb->query("DELETE FROM $table_name WHERE cache_expires <= $now");
               $wpdb->query("DELETE FROM $table_name WHERE user_id='$authorization_key' AND (NOT authorization_status = 'Reserved') "); 
               require_once($aretex_core_path.'AreteX_WPI_DI.class.php');
               // Check with AreteX to see what this user has actually paid for, and what the status of that payment is.
               $response = AreteX_WPI_DI::get_authorization_by_key('paid_subscriptions',$authorization_key);              
               $dummy_cache = true;
               $cache_expires = 0;
               $role_delivered = '';
               if (is_array($response)) {
                    $data = array();
                    $dup_auths = array();               
                    foreach($response as $authorization) {
                        extract($authorization);
                        $delivery_data = json_decode(stripslashes($delivery_data),true);
                        
                        if (isset($dup_auths[$role_delivered]))
                        {
                             if ($authorization_time > $dup_auths[$role_delivered])
                                $dup_auths[$role_delivered] = $authorization_time;
                             else
                                continue;
                        }
                        else
                            $dup_auths[$role_delivered] = $authorization_time;   
                        
                        switch(strtolower($authorization_status)) {
                            case 'authorized':
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
                                $role_delivered = $delivery_data['additional_fields']['role_delivered'];
                                
                            break;
                            default:
                                if ($extend_cache)
                                    $cache_expires = strtotime("+30 Days");
                                $expiration_date = null;
                            break;
                                                            
                        }
                        
                        //`authorization_key`, `deliverable_code`, `authorization_status`, `auhtorization_expires`, `cache_expires`, `full_data`
                        $data['user_id']     = $authorization_key;
                        $data['txn_id']      = $txn_number;
                        $data['role_type']   = $delivery_data['additional_fields']['role_type'];
                        $data['role_delivered'] = $delivery_data['additional_fields']['role_delivered'];
                        $data['role_at_expiration'] =$delivery_data['additional_fields']['role_at_expiration'];
                        $data['deliverable_code']      = $deliverable_code;
                        $data['authorization_time']  =  $authorization_time;
                        $data['authorization_status']  = $authorization_status; 
                        $data['auhtorization_expires'] = $expiration_date;
                        $data['cache_expires']         = $cache_expires;
                        $data['full_data']             = serialize($authorization);
                        
                        $wpdb->replace( $table_name, $data, array('%s','%s','%s','%s','%s','%s','%d','%s','%d','%d','%s') ); 
                    }
                    
               }
               
               
               $rows = $wpdb->get_results("SELECT * FROM $table_name WHERE user_id='$authorization_key' ORDER BY authorization_time DESC ", ARRAY_A);
               if (! empty($rows))
                return $rows; 
               
              }
              
              return null;
                                                 
        }
        
        protected static function get_user_role($user) {
            if ( !empty( $user->roles ) && is_array( $user->roles ) ) {
        		foreach ( $user->roles as $role )
        			return $role;
        	}
        }
        
        // Credit: http://ben.lobaugh.net/blog/7175/wordpress-replace-built-in-user-authentication
        public static function authorize($user,$username, $password) {
             
            // error_log("User? ".var_export($user,true));
             if (empty($username) || empty($password))
                return; // Not trying to login evidently ... 
                        
             $userobj = new WP_User();
             $user = $userobj->get_data_by( 'login', $username ); // Does not return a WP_User object (? See Credits) 
             $user = new WP_User($user->ID); // Attempt to load up the user with that ID
             $original_role = self::get_user_role($user);            
             if( $user->ID == 0 ) { // User does not exist at all
                $auth = self::CheckAuthorization($username);
                if (empty($auth)) {
                    $user = new WP_Error( 'denied', __("<strong>ERROR</strong>: Invalid username or password.") );
                }
                else {  // We don't have a user, but the user has been authorized -- by paying
                    $added_user = false;
                    self::$new_user_set = false;
                    foreach($auth as $authorization) { // Looking for new authorization for this user
                    extract($authorization);
                    if (($role_type == 'reg_role') && strtolower($authorization_status) == 'authorized' ) { 
                        if (trim($txn_id) == trim($password)) { // Password Matches TXN
                             
                             $auth_data = unserialize($full_data);
                             $delivery_data = json_decode(stripslashes($auth_data['delivery_data']),true);
                             $email = $delivery_data['authorization_options']['email'];
                             $userdata = array( 'user_email' => $email,
                                'user_login' => $username,
                                'user_pass' => $password,
                                'role' => $role_delivered
                             );
                                
                            $new_user_id = wp_insert_user( $userdata ); // A new user has been created
                        
                            update_user_meta( $new_user_id, 'atx_cust_email', $email); // This is the customer email on file with AreteX 
                             
                            // Load the new user info
                            $user = new WP_User($new_user_id); 
                            update_user_option( $new_user_id, 'default_password_nag', true, true );                          
                            $added_user = true; 
                            self::$new_user_set = true;
                            break;                                                                                    
                        }
                        
                    }// end new registration authorized
                    
                     
                  } // End for
                  if (! $added_user) {
                        $user = new WP_Error( 'denied', __("<strong>ERROR</strong>: Invalid username or password.") );
                  }
                  else {
                    self::unreserveUsername($username);
                  }
                    
                }                                
             }
             else { // We have a user ...
                  self::$new_user_set = false;  
                  $creds['user_login'] = $username;
                  $creds['user_password'] = $password;                                  
                 // $user = wp_signon( $creds );
                 $password_check = wp_check_password( $password, $user->data->user_pass, $user->ID);
                 
                   
                  $role_ok = false;
                  if ($password_check ) {// Since there is no registration, we need to check the password before we continue
                      
                      $hidden_roles = get_option('aretex_pdsub_hidden_roles',array());
                      if (! in_array($original_role,$hidden_roles)) {
                          // Hidden Roles are not part of the paid membership system.
                          $auth = self::CheckAuthorization($username);
                         
                          if ( empty($auth))
                            $role_ok = true; // Assume they did not go through authorization system. 
                          
                          if (isset($auth[0]) && $auth[0]['deliverable_code'] == 'ATXRSVRVUID')
                          {
                             self::unreserveUsername($username);
                             $auth = self::RefeshCache($username);
                          }
                          
                          foreach($auth as $authorization) {
                            extract($authorization);
                            if ($deliverable_code ==  'ATXRSVRVUID' ) {
                                self::unreserveUsername($username);
                            }
                            if (($role_type == 'role_only') && strtolower($authorization_status) == 'authorized' ) { 
                                if (trim(strtolower($role_delivered)) != trim(strtolower($original_role))) { // New Role Authorized
                               
                                    
                                         $user->roles[0] = $role_delivered;
                                        wp_update_user( array ( 'ID' => $user->ID, 'role' => $role_delivered ) ) ;
                                        self::SupercedeRole($username,$original_role);
                                        $role_ok = true;
                                                                                             
                                }
                                else { // Old role still authorized
                                    
                                   $role_ok = true;
                                }
                            }// end if role_type is authorized with role only
                            else if ($role_delivered == $original_role ) { // reg_only or reg_role
                               $authorization_status = strtolower($authorization_status); 
                               if ($authorization_status != 'authorized') { // Still Authorized in this role?
                                   if ($authorization_status == 'expired') {
                                        if ($role_at_expiration != 'none') {
                                             $user->roles[0] = $role_at_expiration;
                                            wp_update_user( array ( 'ID' => $user->ID, 'role' => $role_at_expiration ) ) ;
                                            self::SupercedeRole($username,$original_role);
                                            $role_ok = true;
                                        }
                                        
                                         
                                   }
                                   
                               }
                                else {
                                     $role_ok = true;
                                   }                             
                            } 
                                                
                          } // End for
                          if (! $role_ok) {
                           
                            wp_clear_auth_cookie(); // Log them back off ...
                            wp_logout();
                            $user = new WP_Error( 'denied', __("<strong>ERROR</strong>: Membership no longer authorized.") );
                          }
                      } // End if ! hidden role                      
                  } // Password Check
                  else
                    $user = new WP_Error( 'denied', __("<strong>ERROR</strong>: Invalid username or password.") );             
             } // End "Existing" User
             
              remove_action('authenticate', 'wp_authenticate_username_password', 20);          
             return $user;   
        }

        
        public static function select_registration_products() {
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
                $deliverables = AreteX_WPI_DI::get_deliverables_by_type('authorization','paid_subscriptions');
                
                $reg_data= array();
                global $wp_roles;              
                foreach($deliverables as $deliv) {
                    
                    $details = unserialize($deliv['type_details']['additional_fields']);
                   
                                        
                    if ($details['role_type'] == 'reg_role') {
                        $reg_item = array();
                        $reg_item['id'] = $deliv['id'];
                        $reg_item['deliverable_code'] = $deliv['deliverable_code'];
                        $reg_item['role_delivered'] = $wp_roles->roles[$details['role_delivered']]['name'];
                        $reg_data[] = $reg_item;
                         
                    } 
                }
                $full_list = array();
                foreach($reg_data as $reg_item){
                    $products = AreteX_WPI_DI::get_products_by_deliverable($reg_item['deliverable_code']);
                    
                    foreach($products as $product) {
                        $prod_item = array();
                        $prod_item = $reg_item;
                        $prod_item['product_code'] = $product['code'];
                        $prod_item['product_name'] = $product['name'];
                        $prod_item['pricing_model'] = $product['pricing_model'];
                        $full_list[] = $prod_item;
                    }
                } 
                $reg_data = null;
                $reg_item = null;
                $headers = array('Deliverable Code'=>'deliverable_code','Role'=>'role_delivered','Product Code'=>'product_code','Name'=>'product_name');
                
               
                 
                $action['function_name'] = "use_product";
                $action['icon_path'] = 'images/actions/checkmark_20.png';
                $action['parameters'] = array('[product_code]','[product_name]');
                $action['title'] = 'Use this product';
                $actions[] = $action;
                
                
                $str = AreteXDT::TableList($headers,$actions,$full_list);
                $str .= <<<END_S
                <script>
                    
                    function use_product(code,name) {
                        jQuery('#product_code').val(code);
                        jQuery('#product_name').val(name);
                        jQuery('#step_2_title').html('2. Select Membership Registration Product');
                        add_check('#step_2');
                        jQuery('#product_selected').show();
                        jQuery('#product_selector').hide();
                        jQuery('#allow_free_a_row').show();
                        if (jQuery('#allow_free_q').is(':checked'))
                        {
                            jQuery('#allow_free_a').prop('checked', true);
                        }
                        else
                        {
                            jQuery('#allow_free_a').prop('checked', false);
                        }
                        
                        
                    }
                    
                                                            
                    
                </script>
END_S;
                
                return $str;

            }
            
        }
        
        
        public static function select_role_only_products() {
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
                $deliverables = AreteX_WPI_DI::get_deliverables_by_type('authorization','paid_subscriptions');
                
                $reg_data= array();
                global $wp_roles;              
                foreach($deliverables as $deliv) {
                    
                    $details = unserialize($deliv['type_details']['additional_fields']);
                   
                                        
                    if ($details['role_type'] == 'role_only') {
                        $reg_item = array();
                        $reg_item['id'] = $deliv['id'];
                        $reg_item['deliverable_code'] = $deliv['deliverable_code'];
                        $reg_item['role_delivered'] = $wp_roles->roles[$details['role_delivered']]['name'];
                        $reg_data[] = $reg_item;
                         
                    } 
                }
                $full_list = array();
                foreach($reg_data as $reg_item){
                    $products = AreteX_WPI_DI::get_products_by_deliverable($reg_item['deliverable_code']);
                    
                    foreach($products as $product) {
                        $prod_item = array();
                        $prod_item = $reg_item;
                        $prod_item['product_code'] = $product['code'];
                        $prod_item['product_name'] = $product['name'];
                        $prod_item['pricing_model'] = $product['pricing_model'];
                        $full_list[] = $prod_item;
                    }
                } 
                $reg_data = null;
                $reg_item = null;
                $headers = array('Deliverable Code'=>'deliverable_code','Role'=>'role_delivered','Product Code'=>'product_code','Name'=>'product_name');
                
               
                 
                $action['function_name'] = "use_product2";
                $action['icon_path'] = 'images/actions/checkmark_20.png';
                $action['parameters'] = array('[product_code]','[product_name]');
                $action['title'] = 'Use this product';
                $actions[] = $action;
                
                
                $str = AreteXDT::TableList($headers,$actions,$full_list);
                $str .= <<<END_S
                <script>
                    
                    function use_product2(code,name) {
                        jQuery('#product_code').val(code);
                        jQuery('#product_name').val(name);
                        jQuery('#step_2_title').html('2. Select Membership Role Upgrade Product');
                        add_check('#step_2');
                        jQuery('#product_selected').show();
                        jQuery('#product_selector').hide();
                        jQuery('#allow_free_a_row').hide();
                        
                        
                    }
                    
                                                            
                    
                </script>
END_S;
                
                return $str;

            }
            
        }

        
        
        
        
        public static function paid_subecription_list() {
       
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
                $deliverables = AreteX_WPI_DI::get_deliverables_by_type('authorization','paid_subscriptions');
                // "id":"8","deliverable_code":"TPCD1","name":"Test Paid Content Deliverable","description":"Test "
                
                $headers = array('Deliverable Code'=>'deliverable_code','Name'=>'name','Description'=>'description');
                
                $action['function_name'] = "payout_code";
                $action['icon_path'] = 'images/actions/wire_transfer_24.png';
                $action['parameters'] = array('[deliverable_code]');
                $action['title'] = 'Edit Payouts';                
                $actions[] = $action;
                
                $action['function_name'] = "edit_mem";
                $action['icon_path'] = 'images/actions/Edit.png';
                $action['parameters'] = array('[deliverable_code]');
                $action['title'] = 'Edit Membershp Authorization';
                $actions[] = $action;
                
                $action['function_name'] = "delete_mem";
                $action['icon_path'] = 'images/actions/Delete.png';
                $action['parameters'] = array('[deliverable_code]');
                $action['title'] = 'Delete Membership Authorization';
                $actions[] = $action;
                
                $str = AreteXDT::TableList($headers,$actions,$deliverables);
                 $str .= <<<END_S
                <script>
                    function payout_code(deliverable_code) {
                        var back_screen = {
                            'feature' : 'AreteX Subscriptions and Memberships',
                            'screen'  : 'mem_mgm' 
                        }
                        load_linked_screen_back('deliverable_payouts',deliverable_code,back_screen);
                    }
                    
                    function edit_mem(deliverable_code) {
                        var back_screen = {
                            'feature' : 'AreteX Subscriptions and Memberships',
                            'screen'  : 'mem_mgm' 
                        }
                        load_linked_feature_screen_back('AreteX Subscriptions and Memberships','edit_mem',deliverable_code,back_screen);
                    }
                    
                     function delete_mem(deliverable_code) {
                        var back_screen = {
                            'feature' : 'AreteX Subscriptions and Memberships',
                            'screen'  : 'mem_mgm' 
                        }
                        load_linked_feature_screen_back('AreteX Subscriptions and Memberships','delete_mem',deliverable_code,back_screen);
                    }
                    jQuery( document ).tooltip();
                    
                </script>
END_S;
            }
            
            return $str;

        }

         
    }
 }

?>