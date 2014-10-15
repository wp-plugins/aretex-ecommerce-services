<?php

/**
 * AreteX_plugin
 * 
 * @package AreteX For WordPress
 * @author 3B Alliance, LLC
 * @copyright 2013
 * @access public
 * 
 * Encapsulates the functionality for the AreteX ecommerce services plugin for 
 * Wordpress.
 */
if ( ! class_exists( 'AreteX_plugin' ) ) {
    
     require_once(plugin_dir_path( __FILE__ ).'AreteXClientEngine/AreteXAPI.php');
     require_once(plugin_dir_path( __FILE__ ) . 'AreteX_WPI.class.php');
    
    class AreteX_plugin {
        /**
         * AreteX_plugin::__construct()
         * Register the action hooks for the plugin.
         * @return void
         */
        public function __construct() {            
            add_action('plugins_loaded', array( &$this, 'on_load' ), 1 ); 
            
            add_action('_user_admin_menu', array( &$this, 'user_menu' ));
                       
            add_action('admin_menu', array( &$this, 'admin_menu' ));
            add_action('admin_enqueue_scripts', array(&$this, 'on_queue_admin_scripts'));
            add_action('admin_head',array( &$this, 'admin_head' ));
            add_action('admin_footer', array( &$this, 'ajax_script' ) );
            add_action('init', array(&$this,'on_init'), 1);                                                 
            add_action('wp_enqueue_scripts', array(&$this, 'on_queue_scripts')); 
            // register widget
            add_action('widgets_init', create_function('', 'return register_widget("AreteXCouponWidget");'));
            
            // Short codes in the editor
           	add_action('media_buttons_context',  array(&$this, 'aretex_editor_button'));
            add_action( 'admin_footer',  array(&$this, 'add_inline_aretex_popup') );
                       
            $this->add_admin_ajax_actions();
            $this->add_user_ajax_actions();                         
            $this->add_referral_tracking();                                  
            $this->add_shortcodes();
                                   
            // Add more features ... 
            self::loadFeatures();
    
        }
        
        public function aretex_editor_button($context) {
            $current_screen = get_current_screen();
			if( $current_screen->base == 'post' ) {
			     $url = plugins_url( 'images/buttons/bank_transaction_16.png', __FILE__ );
                 
                 $context .= "<a class='thickbox button sfd_download_link' title='AreteX(tm) eCommerce Shortcode Generator' href='#TB_inline?width=400&height=500&inlineId=AreteXPopUp'>
						<img src='{$url}' / style='display: inline;' />AreteX&trade;</a>";

                 
                return $context;
			}
            return false;
        }
        
        public function add_inline_aretex_popup() {
            $content =<<<END_POP
            <div id="AreteXPopUp" style="display:none;">              
              <button class="button" onclick="load_aretex_generator('overview');">Overview</button>&nbsp;&nbsp;<button onclick="load_aretex_generator('paidcontent');" class="button">Paid Content</button>&nbsp;&nbsp;<button onclick="load_aretex_generator('paidmember');"  class="button">Paid Membership</button>&nbsp;&nbsp;<button  onclick="load_aretex_generator('product');" class="button">Product Presentation</button>&nbsp;

            <div class="ui-widget ui-widget-content  ui-corner-all " style="margin-top: 5px; padding: 4px;" id='aretex_editor_box' >
            <p></p>
            </div>
            </div>
            <script>
            
            function load_aretex_generator(screen_id){
    jQuery(function ($) {                
    	
        var path = 'editor_pages/'+screen_id;
        $('#aretex_editor_box').html('<p style="text-align:center;">...Please Wait...</p>');               
        var data = {
		action: 'load_screen',
        plugin: 'ecommerce-services',
        screen: path
	   };
        	
    	$.post(ajaxurl, data, function(response) {
    	   $('#aretex_editor_box').html(response);
    	});
        
    
    });  
}
            load_aretex_generator('overview');
            
            </script>
END_POP;
            echo $content;
        }
        
        protected function add_admin_ajax_actions() {
            
            add_action('wp_ajax_have_license', array( &$this,'have_license_callback' ) );
            add_action('wp_ajax_atx_complete_wizard',array(&$this,'atx_complete_wizard'));
            add_action('wp_ajax_register', array( &$this,'register_callback' ) );
            add_action('wp_ajax_add_new_sandbox',array(&$this,'add_new_sandbox_callback'));
            add_action('wp_ajax_load_screen',array(&$this,'load_screen_callback'));
            add_action('wp_ajax_atx_buynow',array(&$this,'atx_buynow_callback'));
            add_action('wp_ajax_atx_updatepayment',array(&$this,'atx_updatepayment'));
            add_action('wp_ajax_atx_updatecamcontact', array(&$this,'atx_updatecamcontact'));
            
             add_action('wp_ajax_atx_updatebsucontact', array(&$this,'atx_updatebsucontact'));
            
             add_action('wp_ajax_atx_cancelrebill',array(&$this,'atx_cancelrebill'));
            
            add_action('wp_ajax_atx_check_prod_code',array(&$this,'atx_check_prod_code'));
            add_action('wp_ajax_atx_check_offer_code',array(&$this,'atx_check_offer_code'));
            add_action('wp_ajax_atx_check_dlv_code',array(&$this,'atx_check_dlv_code'));
            add_action('wp_ajax_atx_check_wiz_code',array(&$this,'atx_check_wiz_code'));
            add_action('wp_ajax_atx_check_comm_group_code',array(&$this,'atx_check_comm_group_code'));
            add_action('wp_ajax_atx_new_commision_structure',array(&$this,'atx_new_commision_structure'));
            add_action('wp_ajax_atx_save_commision_structure',array(&$this,'atx_save_commision_structure'));
            add_action('wp_ajax_atx_delete_commission_structure',array(&$this,'atx_delete_commission_structure'));


            add_action('wp_ajax_atx_delete_splash_code',array(&$this,'atx_delete_splash_code'));

           
            add_action('wp_ajax_atx_create_full_paid_c_prod',array(&$this,'atx_create_full_paid_c_prod'));
            add_action('wp_ajax_atx_create_full_paid_mem_prod',array(&$this,'atx_create_full_paid_mem_prod'));
            
            add_action('wp_ajax_atx_create_prod',array(&$this,'atx_create_prod'));
            add_action('wp_ajax_atx_create_offer',array(&$this,'atx_create_offer'));
            add_action('wp_ajax_atx_create_manifest',array(&$this,'atx_create_manifest'));
            
            add_action('wp_ajax_atx_delete_manifest',array(&$this,'atx_delete_manifest'));            
            add_action('wp_ajax_atx_save_deliverable_payouts',array(&$this,'atx_save_deliverable_payouts'));            
            add_action('wp_ajax_atx_save_pcs_out',array(&$this,'atx_save_pcs_out'));            
            add_action('wp_ajax_atx_full_tracking',array(&$this,'atx_full_tracking'));          
            add_action('wp_ajax_atx_validate_tracking_code',array(&$this,'atx_validate_tracking_code'));            
            add_action('wp_ajax_atx_create_splash_code',array(&$this,'atx_create_splash_code')); 
            
            add_action('wp_ajax_atx_create_media_code',array(&$this,'atx_create_media_code'));
            
            
            add_action('wp_ajax_atx_save_pay_sched',array(&$this,'atx_save_pay_sched'));
            add_action('wp_ajax_atx_receipt',array(&$this,'atx_receipt'));
            add_action('wp_ajax_features_yes_to_all',array(&$this,'features_yes_to_all_cb'));  
            add_action('wp_ajax_features_no_to_all',array(&$this,'features_no_to_all_cb'));
            add_action('wp_ajax_answer_feature',array(&$this,'answer_feature_cb'));
            
            add_action('wp_ajax_atx_send_ptr_pdf',array(&$this,'send_ptr_pdf')); 
            add_action('wp_ajax_atx_send_admin_ptr_pdf',array(&$this,'send_admin_ptr_pdf'));
            
            add_action('wp_ajax_atx_download_as_attachment',array(&$this,'download_as_attachment'));
                        
            add_action('wp_ajax_atx_get_wp_user_name',array(&$this,'atx_get_wp_user_name'));
            add_action('wp_ajax_atx_find_wp_user',array(&$this,'atx_find_wp_user'));
            add_action('wp_ajax_atx_set_can_ptr',array(&$this,'atx_set_can_ptr'));
            add_action('wp_ajax_atx_payee_agree',array(&$this,'atx_payee_agree'));
            
            
            add_action('wp_ajax_atx_post_manual_payments',array(&$this,'atx_post_manual_payments'));
            
            add_action('wp_ajax_atx_post_refund',array(&$this,'atx_post_refund'));
            
            add_action('wp_ajax_atx_cam_to_wp',array(&$this,'atx_cam_to_wp'));

            
            // Is this one necessary ... ?
            add_action('wp_ajax_atx_payee_reg',array(&$this,'atx_payee_reg_callback'));
            add_action('wp_ajax_atx_payee_complete',array(&$this,'atx_payee_complete_callback'));
            
            // Deliverable Authorization
            add_action('wp_ajax_atx_post_deliverable_auth',array(&$this,'atx_post_deliverable_auth'));
            add_action('wp_ajax_atx_delete_deliverable_auth',array(&$this,'atx_delete_deliverable_auth'));
            
            // Paste Short code ...
            add_action('wp_ajax_atx_paste_prod_sc',array('AreteX_plugin','atx_paste_prod_sc'));
            
            // PTR Configuration 
            add_action('wp_ajax_atx_ptr_wp_cfg',array(&$this,'atx_ptr_wp_cfg'));
            
            // Replace Identity Key
            add_action('wp_ajax_atx_replace_id_key',array(&$this,'atx_replace_id_key'));
                       
            
        }
        
        protected function add_referral_tracking() {
             // This is for tracking the referal codes ...
             // Hook our function into query_vars - This lets us find the tag
            add_filter('query_vars', array(&$this,'add_query_vars'));            
            // Hook the function into rewrite_rules_array - This let's us parse the get
            //  add_filter('rewrite_rules_array', array(&$this,'add_rewrite_rules'));
             // add_tracking_rewrite_rule
             add_action('init', array(&$this,'add_tracking_rewrite_rule'));             
            // Hook the function into template_redirect -This puts it back where it's supposed to be'
            add_action( 'template_redirect', array('AreteX_plugin','get_atx_tc'));
            
        }
        
        protected function add_user_ajax_actions() {
            
             add_action('wp_ajax_nopriv_atx_buynow',array(&$this,'atx_buynow_callback')); 
             add_action('wp_ajax_nopriv_atx_payee_reg',array(&$this,'atx_payee_reg_callback'));           
            
        }
        
        protected function add_shortcodes() {
            
             add_shortcode('atx_buynow', array( 'AreteX_plugin', 'buynow' ) );
             add_shortcode('aretex_buynow', array( 'AreteX_plugin', 'buynow' ) );            
             add_shortcode('aretex_payee_signup', array( 'AreteX_plugin', 'payee_signup' ) );
             add_shortcode('aretex_coupon_box',array( 'AreteX_plugin', 'coupon_box' ));
             add_shortcode('aretex_coupon_info',array( 'AreteX_plugin', 'coupon_info' ));
             add_shortcode('aretex_product_info',array( 'AreteX_plugin', 'product_info' ));
             // aretex_product_info :code:, :name:, :description:, :price:, :topnote:, :itemnote:, :termsnote:
             // artex_coupon_code status="!valid" product_code=""
            
        }
        
        static protected function loadFeatures() {
            if (get_option('aretex_core_path')) { // We have installed
                self::loadInternalFeatures();
                self::installFeatures();
            
                
            }
        }
        
        static protected function loadInternalFeatures() {
            foreach (new DirectoryIterator(plugin_dir_path( __FILE__ ).'features') as $fileInfo) {
                if($fileInfo->isDot()) continue;
                    $filename = $fileInfo->getFilename();
                
                if (strpos($filename,'.class')) {
                    $params = self::ParamsFromComments($fileInfo->getPathname());                                     
                    $feature_name = $params['FeatureName'];
                    if (empty($feature_name))
                        continue;
                    
                   global $wpdb;               
                   $table_name = $wpdb->prefix .'aretex_features';
                   $rows = $wpdb->get_results( "SELECT * FROM $table_name WHERE feature_name='$feature_name'", ARRAY_A  );
                   if (empty($rows[0]['feature_name'])) {
                      $data = array();
                      $data['feature_name'] = $feature_name;
                      $data['feature_class'] = $params['FeatureClass'];
                      $data['description'] = $params['Description'];
                      $data['feature_path'] = $fileInfo->getPathname();
                      $data['menu_path']= $params['AreteXMenuPath'];
                      $data['parameters'] = serialize($params);
                      $data['load_feature'] = $params['LoadFeature'];
                      $data['feature_version'] = $params['FeatureVersion'];  
                      $data['aretex_server_version'] = $params['AretexServerVersion'];
                      $data['replacement_for'] = $params['ReplacementFor'];                                          
                      $wpdb->replace( $table_name, $data, null ); 
                   }
                    
                }    
                    
            }
        }
                
        
        static protected $updateRequestList;
        static protected $features;
        
        static public function ask_about_features(){
            $str = ' <div class="updated">';
            $str .= '<p><strong>AreteX&trade; Features Installation</strong></p>';
            if (count(self::$updateRequestList) > 0) {
                if (count(self::$updateRequestList) > 1) {
                    $str .= '<p><button onclick="features_yes_to_all();" type="button" class="button button-primary button-large">';
                    $str .= 'Yes to All</button>&nbsp;&nbsp;';
                    
                    $str .= '<button onclick="features_no_to_all();" type="button" class="button button-primary button-large">';
                    $str .= 'No to All</button>';
                    $str .= '<br/><hr/></p>';
                }
                $str .= '<ul>';
                foreach(self::$updateRequestList as $feature_name=>$ask) {
                    $str .= '<li>'.$ask.'&nbsp;&nbsp;';
                    $str .= '<button type="button" onclick="answer_feature(';
                    $str .= "'$feature_name','Y'";
                    $str .=')" class="button button-primary ">';
                    $str .= 'Yes</button>&nbsp;&nbsp;';
                    
                    $str .= '<button type="button" onclick="answer_feature(';
                    $str .= "'$feature_name','N'";
                    $str .=')" class="button button-primary ">';
                    $str .= 'No</button></li>';
                    
                    
                }
                $str .= '</ul>';
                /*
                <input type="submit" value="Update" accesskey="p" id="publish" class="button button-primary button-large" name="save">
                */
            }
            $str .= '</div>';
            
            echo $str;
        }
        
        
        static protected function installFeatures() {
            self::$updateRequestList = array();
            global $wpdb;
            
            $table_name = $wpdb->prefix .'aretex_features';
            $rows = $wpdb->get_results( "SELECT * FROM $table_name ", ARRAY_A  );
            if (is_array($rows)) {
                foreach($rows as $row) {
                    extract($row);
                    
                        
                    if ($load_feature == 'Y' && file_exists($feature_path)){
                        include_once($feature_path);
                        if (class_exists($feature_class) ) {
                            self::$features[$feature_class] = new $feature_class();
                        }
                    }
                    else if (! $load_feature || $load_feature=='Q') {
                        $parameters = unserialize($parameters);
                                            
                        $feature_type = $parameters['FeatureType'];
                        $ask = "Install  $feature_type Feature: <strong>$feature_name ?</strong><br/>\n ".
                               "&nbsp;&nbsp;&nbsp;&nbsp;$description";
                        self::$updateRequestList[$feature_name] = $ask; 
                    }
                }
            }

            
            
            if (! empty(self::$updateRequestList)) {
                add_action( 'admin_notices',  array('AreteX_plugin','ask_about_features') );

            }
            
        }
        
        static protected function add_roles() {
            if (! get_role('aretex_payee')) {
                add_role('aretex_payee','AreteX Payee',array('access_aretex_ptr'=>true, 'read'=>true));
            }
        }
        
        static public function install() {
            
            /*
                security check:
                https - mandatory               
                writable directory        
            */
            
            add_option('aretex_license_key');
            add_option('aretex_api_key','b45969cac7227765c61e3414ea577cd3');
            add_option('aretex_api_secret','Only Registration Allowed');
            add_option('aretex_sand_box_mode','Yes');
            add_option('aretex_rest_endpoint','https://aretexhome.com/api');
            
            add_option('aretex_tracking_qvar','atxcc');
            add_option('aretex_tracking_cookie_days','30');
            
            update_option('aretex_core_path',plugin_dir_path( __FILE__ ));
            
            self::add_roles();
            
            $hash = get_option('aretex_hash');
            if (! $hash) {
                $hash = md5(uniqid('ARETEX',true).rand(42,4200)); 
                add_option('aretex_hash',$hash); 
            }
            
           $public_key = get_option('aretex_public_key');
           $protect_file = plugin_dir_path( __FILE__ ) . 'protect.ini.php';
          
            $crypton = new Crypton();
            if ((!$public_key)){
                $keys = AreteX_API::ClientKeys();                
                update_option('aretex_public_key',$keys['publickey']);
                
                
                
                $password = base64_encode($crypton->generate_sym_key());
                $ini_code=<<<END_INI_CODE
;<? if (; //Cause parse error to hide from prying eyes?>
; Protect this file .... it has an important key in it
; Of course! The key is the key
bflat="$password"
END_INI_CODE;
                
                file_put_contents($protect_file,$ini_code);
 
                $crypton->store_keys($keys,'aretex_wp',$password,true);
                update_option('aretex_hash',$password);
                $enc_keys = $crypton->get_keys_for_backup();
                update_option('aretex_private_key',$enc_keys);                                              
            }

            
/*            
                        
            $ini_code=<<<END_INI3_CODE
;<? if (; //Cause parse error to hide from prying eyes?>
 callback_id=b45969cac7227765c61e3414ea577cd3
 callback_secret="$hash"
END_INI3_CODE;
         
             $ini_file = plugin_dir_path( __FILE__ ) . 'callback_access.ini.php';
             file_put_contents($ini_file,$ini_code);  
            
  */          
                                    
            self::build_db_tables();
            
            
            
         }
         
         public static function deactivate() {
             
            delete_option( 'aretex_core_path');
            
        }
        
        /**
         * AreteX_plugin::on_queue_admin_scripts()
         * Register and enqueue the javascripts /css for the admin UI. 
         *  - jQuery
         *  - jQuery UI
         *  - Responsive Grid System
         *  - Tree View
         * @return void
         */
        public function on_queue_admin_scripts(){
            
            // jQuery, jQuery UI
            wp_enqueue_script('json2');
            wp_enqueue_script('jquery');
           
           
          
            
            wp_enqueue_script( 'jquery-ui-core' );
           
            wp_enqueue_script( 'jquery-ui-widget' );
            wp_enqueue_script( 'jquery-ui-position' );
            wp_enqueue_script( 'jquery-ui-menu' );
            wp_enqueue_script( 'jquery-ui-progressbar' );
            wp_enqueue_script( 'jquery-ui-mouse' );
            wp_enqueue_script( 'jquery-ui-accordion' );
            wp_enqueue_script( 'jquery-ui-autocomplete' );
            wp_enqueue_script( 'jquery-ui-slider' );
            wp_enqueue_script( 'jquery-ui-tabs' );
            wp_enqueue_script( 'jquery-ui-sortable' );
            wp_enqueue_script( 'jquery-ui-draggable' );
            wp_enqueue_script( 'jquery-ui-droppable' );
            wp_enqueue_script( 'jquery-ui-datepicker' );
            wp_enqueue_script( 'jquery-ui-resize' );
            wp_enqueue_script( 'jquery-ui-dialog' );
            wp_enqueue_script( 'jquery-ui-button' );
            wp_enqueue_script( 'jquery-ui-resizable' );
            wp_enqueue_script( 'jquery-ui-selectable' );
            wp_enqueue_script( 'jquery-ui-spinner' );
            wp_enqueue_script( 'jquery-ui-tooltip' );
            
            wp_register_style('jquery-ui', plugins_url( 'css/jquery-ui-1.9.2.custom.min.css', __FILE__ ));
            wp_enqueue_style( 'jquery-ui' );
            
            
            // Responsive Grid System
            // Credit: http://www.responsivegridsystem.com/
            wp_register_style('rg-col', plugins_url( 'css/col.css', __FILE__ ));
            wp_register_style('c2-col', plugins_url( 'css/2cols.css', __FILE__ ));
            wp_register_style('c3-col', plugins_url( 'css/3cols.css', __FILE__ ));
            wp_register_style('c4-col', plugins_url( 'css/4cols.css', __FILE__ ));
            wp_register_style('c5-col', plugins_url( 'css/5cols.css', __FILE__ ));
            wp_register_style('c12-col', plugins_url( 'css/12cols.css', __FILE__ ));
            wp_register_style('c10-col', plugins_url( 'css/10cols.css', __FILE__ ));
            
            wp_enqueue_style('rg-col' );
            wp_enqueue_style('c2-col');
            wp_enqueue_style('c3-col');
            wp_enqueue_style('c4-col');
            wp_enqueue_style('c5-col');
            wp_enqueue_style('c12-col');
            wp_enqueue_style('c10-col');
            
            // General look ...
            wp_register_style('aretex-look', plugins_url( 'css/look.css', __FILE__ ));            
            wp_enqueue_style('aretex-look' ); 
             
            
            //Tree View:
            wp_enqueue_script('jquery-treeview',plugins_url('js/jquery.treeview.js', __FILE__ ),array('jquery'));
            wp_enqueue_style('jquery-treeview-css',plugins_url('css/jquery.treeview.css', __FILE__ ));
            
            // Validator
            // Date Validator
            wp_enqueue_script('js-date-format',plugins_url('js/dateFormat.js', __FILE__ ));
            wp_enqueue_script('jquery-validate',plugins_url('js/jquery.validate.js', __FILE__ ),array('jquery'));
            wp_enqueue_script('jquery-validate-addl',plugins_url('js/additional-methods.js', __FILE__ ),array('jquery','jquery-validate'));
            wp_enqueue_script('jquery-validate-aretex',plugins_url('js/aretex.validators.js', __FILE__ ),array('jquery','jquery-validate','js-date-format'));
            

            // Lightbox
            wp_enqueue_script('jquery-lightbox-me',plugins_url('js/jquery.lightbox_me.js', __FILE__ ),array('jquery'));
 
            
            // AjaXForm 
            wp_enqueue_script('jquery-ajaxform',plugins_url('js/jquery.form.js', __FILE__ ),array('jquery'));
 
            //Wizard
            wp_register_style('jquery-wizard-style', plugins_url( 'css/jquery.jWizard.min.css', __FILE__ ));
            wp_enqueue_style('jquery-wizard-style');
            wp_enqueue_script('jquery-wizard',plugins_url('js/jquery.jWizard.min.js', __FILE__ ), array('jquery','jquery-ui-core','jquery-ui-widget','jquery-ui-button','jquery-ui-menu','jquery-ui-position','jquery-ui-progressbar','jquery-ui-autocomplete'));
            
            //Basic jQuery Slider
            wp_enqueue_style('jquery-basic-slider-style', plugins_url( 'css/bjqs.css', __FILE__ ));
            wp_enqueue_script('jquery-basic-slider',plugins_url('js/bjqs-1.3.js', __FILE__ ), array('jquery'));

            
            // Data Tables            
           wp_enqueue_style('datatables-css-1',plugins_url( 'css/jquery.dataTables.css', __FILE__ )); 
           wp_enqueue_style('datatables-css-2',plugins_url( 'css/jquery.dataTables_themeroller.css', __FILE__ ),array('datatables-css-1'));
           wp_enqueue_style('datatables-css-3',plugins_url( 'css/TableTools_JUI.css', __FILE__ ),array('datatables-css-2'));
           wp_enqueue_style('datatables-css-4',plugins_url( 'css/ColVis.css', __FILE__ ),array('datatables-css-3'));
           
           wp_enqueue_script('datatables-migrate',plugins_url('js/datatables/jquery.migrate.js', __FILE__ ), array('jquery','jquery-ui-core','jquery-ui-button'));
        
           wp_enqueue_script('datatables-1',plugins_url('js/datatables/jquery.dataTables.js', __FILE__ ), array('jquery','jquery-ui-core','jquery-ui-button','datatables-migrate'));
           wp_enqueue_script('datatables-2',plugins_url('js/datatables/ColVis.js', __FILE__ ), array('datatables-1'));
           wp_enqueue_script('datatables-3',plugins_url('js/datatables/FixedColumnBeta.js', __FILE__ ), array('datatables-2'));
           wp_enqueue_script('datatables-4',plugins_url('js/datatables/ColReorderWithResize.js', __FILE__ ), array('datatables-3'));
           wp_enqueue_script('datatables-5',plugins_url('js/datatables/jquery.dataTables.columnFilter.js', __FILE__ ), array('datatables-4'));
           wp_enqueue_script('datatables-6',plugins_url('js/datatables/TableTools.js', __FILE__ ), array('datatables-5'));           
           wp_enqueue_script('datatables-7',plugins_url('js/datatables/aretex.datatables.js', __FILE__ ), array('jquery','datatables-1'));

            
            // Some utilties for the admin screens
            wp_enqueue_script('aretx-admin',plugins_url('js/aretex.admin.js', __FILE__ ), array('jquery','jquery-ui-core','jquery-ui-button'));
            
          
            
 

          
            
        }
        
        
        public function on_init() {
            if (!session_id())
                session_start();
            if (!isset($_COOKIE['aretex_tc'])) {
                
                $qvar = get_option('aretex_tracking_qvar');
                $tc_days = get_option('aretex_tracking_cookie_days');
                if (isset($_GET[$qvar])) {
                    $val = $_GET[$qvar];
                    setcookie('aretex_tc', $val, strtotime("+$tc_days day"), COOKIEPATH, COOKIE_DOMAIN, false);
                }
                else if (isset($_SESSION['aretex_tc'])) {
                    $val = $_SESSION['aretex_tc'];
                    setcookie('aretex_tc', $val, strtotime("+$tc_days day"), COOKIEPATH, COOKIE_DOMAIN, false);
                }
                
         	}
        }
        
       
        public function on_queue_scripts(){
            
            // jQuery, jQuery UI
            wp_enqueue_script('json2');
            wp_enqueue_script('jquery');
            
            // AreteX Core
            wp_enqueue_script('aretex-core-js',plugins_url('js/aretex.core.js', __FILE__ ),array('jquery'));            
            wp_localize_script( 'aretex-core-js', 'AreteXCoreJS', array( 'ajaxurl' => admin_url( 'admin-ajax.php' )));
            
            

            // Visual captcha
               // Needs jQuery UI
            wp_enqueue_script( 'jquery-ui-core' );
            wp_enqueue_script( 'jquery-ui-widget' );
            wp_enqueue_script( 'jquery-ui-position' );
            wp_enqueue_script( 'jquery-ui-menu' );
            wp_enqueue_script( 'jquery-ui-progressbar' );
            wp_enqueue_script( 'jquery-ui-mouse' );
            wp_enqueue_script( 'jquery-ui-accordion' );
            wp_enqueue_script( 'jquery-ui-autocomplete' );
            wp_enqueue_script( 'jquery-ui-slider' );
            wp_enqueue_script( 'jquery-ui-tabs' );
            wp_enqueue_script( 'jquery-ui-sortable' );
            wp_enqueue_script( 'jquery-ui-draggable' );
            wp_enqueue_script( 'jquery-ui-droppable' );
            wp_enqueue_script( 'jquery-ui-datepicker' );
            wp_enqueue_script( 'jquery-ui-resize' );
            wp_enqueue_script( 'jquery-ui-dialog' );
            wp_enqueue_script( 'jquery-ui-button' );
            wp_enqueue_script( 'jquery-ui-resizable' );
            wp_enqueue_script( 'jquery-ui-selectable' );
            wp_enqueue_script( 'jquery-ui-spinner' );
            wp_enqueue_script( 'jquery-ui-tooltip' );
            // And it's own files of course 
            wp_enqueue_style('visualcaptcha-css',plugins_url( 'css/visualcaptcha.css', __FILE__ ));
            wp_enqueue_script('visualcaptcha-js',plugins_url('js/visualcaptcha.js', __FILE__) ,array('jquery-ui-core', 'jquery-ui-position','jquery-ui-draggable','jquery-ui-droppable' ),null,true);            

             


   
            
        }
        
        
        
        public function on_load() {
            // Do "Self Check"
            
            $crypton = new Crypton();
            
            
            if (! $crypton->key_file_exists()) { // Try to restore from backup
                $enc_keys = get_option('aretex_private_key');               
                if ($enc_keys) {
                    $crypton->restore_keys_from_backup($enc_keys);
                }    
                
            }
            
            $should_reencrypt = false;            
            $protect_file = plugin_dir_path( __FILE__ ) . 'protect.ini.php';
            
            if (! file_exists($protect_file)) {
                $should_reencrypt = true;
                $oldpassword = get_option('aretex_hash');                                
            }
            else {
                $should_reencrypt = false;
                // Add some logic on when to change this later ..
                $ini = parse_ini_file($protect_file);
                $oldpassword = $ini['bflat'];
            }
                                                                        
            
            if ($should_reencrypt) {
                
                $password = base64_encode($crypton->generate_sym_key());
                $ini_code=<<<END_INI2_CODE
;<? if (; //Cause parse error to hide from prying eyes?>
; Protect this file .... it has an important key in it
; Of course! The key is the key
bflat="$password"
END_INI2_CODE;
                
                file_put_contents($protect_file,$ini_code);
                $crypton->change_password($oldpassword,$password);
                update_option('aretex_hash',$password);
                $enc_keys = $crypton->get_keys_for_backup();
                update_option('aretex_private_key',$enc_keys);
                 
            }
            
        }
        
        /*
          Credit: http://www.wpexplorer.com/the-wordpress-rewrite-api/
        |--------------------------------------------------------------------------
        | Start Rewrite. Sample: http://mysite.com/referrer/remi
        |--------------------------------------------------------------------------
        */
        
        // Register a new var
        function  add_query_vars( $vars) {
            $qvar = get_option('aretex_tracking_qvar');
        	$vars[] = $qvar; // name of the var as seen in the URL
          //  error_log("add_query_vars");
            return $vars;
        }
        
       
        // Replacement for below ...
        
        function add_tracking_rewrite_rule() {
            $qvar = get_option('aretex_tracking_qvar');
         //  add_rewrite_rule($qvar.'/?([^/]*)','index.php?'.$qvar.'=$matches[1]','top');
           add_rewrite_rule($qvar.'/([^/]+)/?([^/]+)/?$','index.php?'.$qvar.'=$matches[1]&pagename=$matches[2]','top');
           add_rewrite_rule($qvar.'/([^/]+)/?$','index.php?'.$qvar.'=$matches[1]','top');

            /*
            global $wp_rewrite;
            $wp_rewrite->flush_rules(false);  
            */
        }
        
        // Add the new rewrite rule to existings ones -- Old one
        function add_rewrite_rules($rules) {
            $qvar = get_option('aretex_tracking_qvar');
            
        //	$new_rules = array($qvar.'/([^/]+)/?$' => 'index.php?'.$qvar.'=$matches[1]');
            $new_rules = array($qvar.'/([^/]+)/([^/]+)/?$' => 'index.php?'.$qvar.'=$matches[1]&pagename=$matches[2]');
        	$rules = $new_rules + $rules;
         //   error_log("New Rules".var_export($rules,true));
         //  Look for deep linking regex rules
         // https://example.com/artx_cc/referrer/pg/path/to/page
         
        	return $rules;
        }
        
        
        // Retrieve URL var
        public static function get_atx_tc() {
        	global $wp_query;
        	$qvar = get_option('aretex_tracking_qvar');
            
         
            if (! empty($_POST[$qvar])) { // See if it came from a form
                $val = $_POST[$qvar];
                $tc_days = get_option('aretex_tracking_cookie_days');
                setcookie('aretex_tc', $val, strtotime("+$tc_days day"), COOKIEPATH, COOKIE_DOMAIN, false);
                $_SESSION['aretex_tc'] = $val;
                                            
            } 
            else if(isset($wp_query->query_vars[$qvar])) {        
        		$aretex_tc = get_query_var($qvar);         
                $_SESSION['aretex_tc'] = $aretex_tc;
        	}
            else {
            //     error_log("$qvar NOT SET");
            }
            
        }
        
        /*
        
          public function on_template_redirect() {
            $qvar = get_option('aretex_tracking_qvar');
            if ($_POST[$qvar]) {
                if (isset($_COOKIE['aretex_tc'])) {
                    setcookie("aretex_tc", "", time()-3600);
                }
                
            }
        }
        
        */

  
        
        
        public function admin_head(){
            $url1 = plugins_url( 'css/1024.css', __FILE__ );
            $url2 = plugins_url( 'css/768.css', __FILE__ );
            $url3 = plugins_url( 'css/480.css', __FILE__ );
            $url4 = plugins_url( 'images/ajax-loader.gif', __FILE__ );
            $url5 = plugins_url( 'images/buttons/invoice_30.png', __FILE__ );
            $url6 = plugins_url( 'images/actions/Edit.png', __FILE__ );
            $url7 = plugins_url( 'images/actions/Delete.png', __FILE__ );
            $url8 = plugins_url( 'images/actions/View.png', __FILE__ );
            $url9 = plugins_url( 'images/actions/delete_24.png', __FILE__ );
            $url10 = plugins_url( 'images/actions/wire_transfer_30.png', __FILE__ );
            $url11 = plugins_url( 'images/actions/hand_handshake_30.png', __FILE__ );
            $url12 = plugins_url( 'images/actions/debt2_24.png', __FILE__ );
            $url13 = plugins_url( 'images/actions/payment_24.png', __FILE__ );
            $url14 = plugins_url( 'images/actions/refund_30.png', __FILE__ );
            $url15 = plugins_url( 'images/actions/inventory2_30.png', __FILE__ );
            
           $prod_name_search_js = AreteX_WPI::jsProductSearch('#find_prod');
            
            $str =<<<END_HD
           	<!-- Responsive Stylesheets -->
        	<link rel="stylesheet" media="only screen and (max-width: 1024px) and (min-width: 769px)" href="$url1">
        	<link rel="stylesheet" media="only screen and (max-width: 768px) and (min-width: 481px)" href="$url2">
        	<link rel="stylesheet" media="only screen and (max-width: 480px)" href="$url3">
            <style>
              
               .ui-button-text 
               {                 
                  display: inline !important;
               }
            
            
            .jw-progress {
                
                color: #000000;
                border-color: #000000;
                
            }
            
             
             .ui-autocomplete-loading {
                background: white url('$url4') right center no-repeat;
                }
            
            
            .aretex-action-Receipt {
                display: inline-block;
                height: 30px;
                width: 30px;
                background: transparent url('$url5') right center no-repeat;
                cursor: pointer;
                text-decoration: none;
                margin: 0px;                
            }
            
            .aretex-action-Edit {
                display: inline-block;
                height: 24px;
                width: 24px;
                background: transparent url('$url6') right center no-repeat;
                cursor: pointer;
                text-decoration: none;
                 margin: 0px;                
            }
            
             .aretex-action-Delete {
                display: inline-block;
                height: 24px;
                width: 24px;
                background: transparent url('$url7') right center no-repeat;
                cursor: pointer;
                text-decoration: none;
                margin: 0px;                
            }
            
            .aretex-action-View {
                display: inline-block;
                height: 24px;
                width: 24px;
                background: transparent url('$url8') right center no-repeat;
                cursor: pointer;
                text-decoration: none;
                margin: 0px;                
            }
            
            .aretex-action-Remove {
                display: inline-block;
                height: 24px;
                width: 24px;
                background: transparent url('$url9') right center no-repeat;
                cursor: pointer;
                text-decoration: none;                
            }
            
            .aretex-action-Payout {
                display: inline-block;
                height: 30px;
                width: 30px;
                background: transparent url('$url10') right center no-repeat;
                cursor: pointer;
                text-decoration: none;                
            }
            
            
            .aretex-action-Manage {
                display: inline-block;
                height: 30px;
                width: 30px;
                background: transparent url('$url11') right center no-repeat;
                cursor: pointer;
                text-decoration: none;
                margin: 0px;                
            }
            
             .aretex-action-Manage_Delivery {
                display: inline-block;
                height: 30px;
                width: 30px;
                background: transparent url('$url15') right center no-repeat;
                cursor: pointer;
                text-decoration: none;
                margin: 0px;                
            }
            
            .aretex-action-PendingPayments {
                display: inline-block;
                height: 24px;
                width: 24px;
                background: transparent url('$url12') right center no-repeat;
                cursor: pointer;
                text-decoration: none;
                margin: 0px;                
            }
            
             .aretex-action-SentPayments {
                display: inline-block;
                height: 24px;
                width: 24px;
                background: transparent url('$url13') right center no-repeat;
                cursor: pointer;
                text-decoration: none;
                margin: 0px;                
            }
            
            .aretex-action-Adjust {
                display: inline-block;
                height: 30px;
                width: 30px;
                background: transparent url('$url14') right center no-repeat;
                cursor: pointer;
                text-decoration: none;
                margin: 0px;                
            }
            
            .aretex-action-Refund {
                display: inline-block;
                height: 30px;
                width: 30px;
                background: transparent url('$url14') right center no-repeat;
                cursor: pointer;
                text-decoration: none;
                margin: 0px;                
            }
            
            </style>
	        <script>
            function set_prodName_search() {
               $prod_name_search_js 
                             
                
            }
                        

            
            </script>

END_HD;
            echo $str;
           
        }
        
        public function admin_menu(){
            add_menu_page( 'AreteX&trade; eCommerce Services', 'eCommerce',
                'manage_options','AreteX_Main_Admin_Menu', array(&$this,'admin_page'),
                plugins_url( 'images/bank_transaction_20.png', __FILE__ ));
                
             add_submenu_page('AreteX_Main_Admin_Menu', 
                              'AreteX&trade; eCommerce Services', 
                              'Main', 
                              'manage_options', 
                              'AreteX_Main_Admin_Menu',array(&$this,'admin_page') );
                              
             
           add_menu_page( 'AreteX&trade; Payment Tacking and Reporting', 'Payment Tr...',
                'access_aretex_ptr','AreteX_PTR_Menu', array(&$this,'ptr_page'),
                plugins_url( 'images/salary_20.png', __FILE__ ));
                
           
           if (! current_user_can( 'access_aretex_cam')) {
                AreteX_WPI::customerSignedUp(); // Check AreteX for sign up ...  
                $user_id = get_current_user_id();
                $customer_id = get_user_meta($user_id, 'atx_customer_id', true);
                if ($customer_id) {                                        
                    $user = new WP_User( $user_id  );
                    $user->add_cap( 'access_aretex_cam');
                }
                
           }
          
                                                 
           add_menu_page( 'AreteX&trade; Customer Account Management', 'Account Man...',
                'access_aretex_cam','AreteX_CAM_Menu', array(&$this,'cam_page'),
                plugins_url( 'images/invoice_20.png', __FILE__ ));
                
           
        }
        
        
        
        protected static function build_db_tables() {
            // Cache Table
            global $wpdb;
            
            $table_name = $wpdb->prefix .'aretex_cache';
            
            $sql = <<<END_SQL
            CREATE TABLE  $table_name (
              hash_key varchar(32) NOT NULL,
              data text  NOT NULL,
              expires datetime NOT NULL,
              PRIMARY KEY  (hash_key)
            );
END_SQL;
            
            require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
            @dbDelta( $sql );
            
            $table_name = $wpdb->prefix .'aretex_features';
            $sql = <<<END_SQL2
            CREATE TABLE  $table_name (
              feature_name varchar(45) NOT NULL,
              description varchar(255) NOT NULL,
              feature_class varchar(255) NOT NULL,
              feature_path varchar(255) NOT NULL,
              menu_path varchar(255) NOT NULL,
              parameters text NOT NULL,
              load_feature char(1) NULL,
              feature_installed char(1) NOT NULL DEFAULT 'N',
              feature_version varchar(10) NULL,
              aretex_server_version varchar(10) NULL,
              replacement_for varchar(255) NULL,
              PRIMARY KEY  (feature_name)
            );
END_SQL2;

            @dbDelta( $sql );
            
            $table_name = $wpdb->prefix .'aretex_deliverable_options';
            $sql = <<<END_SQL3
            CREATE TABLE  $table_name (
              deliverable_type varchar(255) NOT NULL,
              deliverable_descriptor varchar(255) NOT NULL,
              feature_class varchar(255) NOT NULL,             
              PRIMARY KEY  (deliverable_type,deliverable_descriptor)
            );
END_SQL3;
         @dbDelta( $sql );
            
        }
        
        
        protected static function build_price_string($pricing,$offer_code='default') {
            if (empty($pricing->offers[$offer_code]))
                $offer_code = 'default';
            switch($pricing->pricing_model) {
                case PricingModel::single_price:
                    $price = number_format($pricing->offers[$offer_code]->price,2);
                    return "$$price";                    
                break;
                case PricingModel::donation:
                    return "Donation ($1.00 or more)";
                break;
                case PricingModel::free_product:
                    return "Free";
                break;
                case PricingModel::recurring_billing:
                    $str = '';
                    if ($pricing->offers[$offer_code]->trial_price == 0.00) {
                        $str .= 'Pay nothing now, ';                        
                    }
                    else {
                        $price = number_format($pricing->offers[$offer_code]->trial_price,2);
                        $str .= 'Pay $'.$price.' now, '; 
                    }
                    $str .= 'then in '. $pricing->offers[$offer_code]->trial_period . ' days, begin paying '.
                           $pricing->offers[$offer_code]->recurring_price . ' ' .$pricing->offers[$offer_code]->billing_cycle.'. ';
                    if (isset($pricing->max_billing_cycles) && $pricing->max_billing_cycles > 0) {
                        $str .= ' Re-Billing will stop automatically after '.$pricing->max_billing_cycles . ' payments. You may cancel at any time. ';
                    }
                    else {
                        $str .= ' You may cancel at any time';
                    }
                    return $str;
                        
                break;
            }
            
        }
        
        public static function atx_paste_prod_sc() {
            $post_data = array();
            parse_str($_POST['data'],$post_data);
            $str = '';
            if (is_array($post_data['attrs'])) {
            $str = "[aretex_product_info code=\"{$post_data['product_code']}\"]<br/>\n";
            $atts = array('code','name','description','itemnote','regular_price','current_price');
            foreach($atts as $att) {
                if (in_array($att,$post_data['attrs'])) {
                    $str .= ":$att:<br/>\n";
                }
            }
            $str .= '[/aretex_product_info]';
            }
            if ($post_data['buybutton'] == 'buybutton') {
                $str .= "\n<br/>[aretex_buynow code=\"{$post_data['product_code']}\"]<button>Buy Now</button>[/aretex_buynow]";
            }
            
            echo $str;
            die();
        }
        
        public static function product_info($atts, $content=null) {
            extract( shortcode_atts( 
                array('code'=>''
                ), $atts));
            // aretex_product_info :code:, :name:, :description:, :price:, :topnote:, :itemnote:, :termsnote:, :regular_price:
            
            if (! empty($code)) {
                $product = AreteX_WPI::getProductDetailByCode($code);               
                               
                $content = str_replace(':description:',$product->details->description, $content );
                $content = str_replace(':name:',$product->name, $content );
                $content = str_replace(':code:',$product->code, $content );
                $content = str_replace(':itemnote:',$product->details->receipt_note, $content );
                $regular_price = self::build_price_string($product->details->pricing);
                $content = str_replace(':regular_price:',$regular_price, $content );
                $coupon = AreteX_WPI::getCurrentTrackingCode(); 
                                                   
                if ($coupon->valid) {
                    $current_price = self::build_price_string($product->details->pricing,$coupon->summary->normalized_offer);
                    $content = str_replace(':current_price:',$current_price, $content );
                }
                else {
                    $content = str_replace(':current_price:',$regular_price, $content );
                }
                
                
            }
            
            $content = do_shortcode( $content ); 
            return $content;
        }
        
        public static function coupon_info($atts, $content=null) {
             extract( shortcode_atts( 
                array('referrer'=>'',
                      'description'=>'',
                      'tracking'=>'',
                      'allow_invalid'=>false
                ), $atts));
            $coupon = AreteX_WPI::getCurrentTrackingCode();
            $output = $content;
                     
            if ($coupon->valid) {
                $ref = (! empty($coupon->summary->rep)) ? $coupon->summary->rep : $referrer; 
                $desc = (! empty($coupon->summary->description)) ? $coupon->summary->description : $description; 
                $orig = (! empty($coupon->original)) ? $coupon->original : $tracking;
                
                $output = str_replace(':description:',$desc, $output );
                $output = str_replace(':referrer:',$ref, $output );
                $output = str_replace(':tracking:',$orig, $output );
                
            }
            else if (! $allow_invalid)
            {
                $output = str_replace(':description:',$description, $output );
                $output = str_replace(':referrer:',$referrer, $output );
                $output = str_replace(':tracking:',$tracking, $output );
                return '';
            }
                
                
            $output = do_shortcode( $output ); 
            return $output;
        }
        
        public static function coupon_box($atts, $content=null) {
            extract( shortcode_atts( array('submit'=>'Submit Coupon Code'), $atts));
            $content = do_shortcode( $content ); 
            
            $qvar = get_option('aretex_tracking_qvar');
            $output =<<<END_COUPON_BOX
            <div class="aretex_coupon_form_wrapper" >
            $content
            <form class="aretex_coupon_form" method="POST">
            <input type="text" name="$qvar" />
            <input class="aretex_coupon_submit" type="submit" value="$submit" />
            </form>
            </div>
END_COUPON_BOX;
            return $output;
            
        }
        
        public static function payee_signup($atts, $content=null) {
            extract( shortcode_atts( array(
                  'style'=>'standard', // Custom may come later ...         
                 'jqvalidate' => 'false',
                 /** ***
                  *  Use Jquery Validate ... later ....
                  * */
                  'captcha'=>'visualCaptcha',
                  /** *
                   *  Use 'None' - to turn it off ... otherwise we will add more later...
                   *      'visualCaptcha' - Horizontal
                   *      'visualCaptcha1' - Vertical
                   ** */
                   'parent'=>'None', // Case sensitive
                    /** *                 
                   *  Use 'None' - to turn it off ... no-multi-tier sign up.
                   *      'tracking' - Extract Parent From Tracking Code
                   *      [upline_id] - Use the wordpress user name to "hard code" the upline  
                   ** */
                   'commission_group'=> 'None',
                   /**
                    *  Use the commision group in the short code.  Default is the "first group". 
                    *   Note if there are more than one, the default could change.
                    * 
                    *  Use "None" if sign up form is for Contributors rather than 
                    * */                          
        	   ), $atts ) );
               
            $parent_hidden = '';
            if ($parent != 'None') {
            
                if ($parent == 'tracking') {
                    
                    $tracking_code = AreteX_WPI::getCurrentTrackingCode();
                    if ($tracking_code) {
                        $account_id = $tracking_validation->summary->rep_id;
                        $parent_hidden = '<input type="hidden" name="_parent_"  value="'.$account_id.'" />';
                    }
                }
                else { 
                    $user = get_user_by( 'login', $parent );
                    if ($user) {
                        $payee_info = AreteX_WPI::payeeSignedUp($user->ID);
                        if ($payee_info->id) { 
                            $account_id = $payee_info->id;
                            $parent_hidden = '<input type="hidden" name="_parent_"  value="'.$account_id.'" />';
                        }
                    }
                }   
            }
            
            $commission_group_hidden = '';
            if ($commission_group != 'None') {
                
                $group_info = AreteX_WPI::getBsuCommissionGroups($commission_group);
                if ($group_info) {
                    $com_cat_id = $group_info['id'];
                    $commission_group_hidden = '<input type="hidden" name="_commission_category_id_"  value="'.$com_cat_id.'" />';

                }
            }
               
            $style = strtolower(trim($style));   
            $output = '<div class="aretex-payee-reg" id="aretex_payee_reg_div"><form id="aretex_payee_reg_form" class="aretex-registration-form" >';            
            if ($style == 'custom' ) {
                $output .= $content;
            }
            else {
                $output .= <<<END_STD_FLDS
                <p><em>Note:</em> Your temporary password will be emailed to you.</p>
                
                <div style="display: block;">
                     <div style="display: inline; padding: 5px;"><label for="username">User Name</label></div>
                     <div><div style="display: inline; padding: 5px;"> <input type="text" id="username" name="username" /></div> 
                </div>
                <div style="display: block;">
                     <div style="display: inline;  padding: 5px;"><label for="email">Email Address</label></div>
                     <div><div style="display: inline;   padding: 5px;"> <input type="text" id="email" name="email" /></div> 
                </div>
                <hr/>
                <div style="display: block;">
                     <div style="display: inline; padding: 5px;"><label class="aretex-title" >Payee Information</label></div>
                </div>
                 <div style="display: block;">
                     <div style="display: inline;  padding: 5px;"><label for="payee_name">Payee Name</label></div>
                     <div><div style="display: inline;   padding: 5px;"> <input type="text" id="payee_name" name="_name_" /></div> 
                </div>
                <div style="display: block;">
                     <div style="display: inline;  padding: 5px;"><label for="payee_address">Payee Address</label></div>
                     <div><div style="display: inline;   padding: 5px;"> <textarea id="payee_address" name="_address_" ></textarea></div> 
                </div>
                <div style="display: block;">
                     <div style="display: inline;  padding: 5px;"><label for="payee_phone">Payee Phone #</label></div>
                     <div><div style="display: inline;   padding: 5px;"> <input type="text" id="payee_phone" name="_phone_" /></div> 
                </div>
 
                
END_STD_FLDS;

                $captchaType = '0';
                switch($captcha)
                {
                    case 'visualCaptcha1':
                        $captchaType = '1'; // Deliberate fall through ... no "break" on purpose..
                    case 'visualCaptcha':
                       $_FIELD_NAME = uniqid();
                       $accessibilityFieldName = uniqid('vc-afn');
                       $_SESSION['visualCaptcha-fieldName'] = $_FIELD_NAME; 
                       $_SESSION['visualCaptcha-accessibilityFieldName'] = $accessibilityFieldName;                                            
                        $output .= self::getVisualCaptcha('aretex_payee_reg_form',$captchaType,$_FIELD_NAME,$accessibilityFieldName);
                    break; 
                    // More Captcha Types Later ..
                }
                
                $content = do_shortcode( $content ); 
                                                              
                require_once(plugin_dir_path( __FILE__ ) . 'simple_html_dom.php');
           
                $html = str_get_html($content); 
                if (is_object($html)) {                 
                    $img = $html->find("img", 0);
                    if ($img) {
                         
                        $outertext = $img->outertext;
                        $style = $img->style;
                        
    
                        $on_click = " onclick=\"atx_register_payee('aretex_payee_reg_form','$captchaType');\"";
                                    
                        
                        $replace = "img $on_click style=\"cursor: pointer; $style\" ";
                        $needle = 'img';
                        $pos = strpos($outertext,$needle);
                        if ($pos !== false) {
                            $outertext = substr_replace($outertext,$replace,$pos,strlen($needle));
                        }
                    
                    }
                    else {
                       $button = $html->find("button", 0);
                       $style = $button->style;
                       $outertext = $button->outertext;
                       if ($button->type != 'button') {
                         $type=' type="button" ';
                       }
                       
                       $on_click = " onclick=\"atx_register_payee('aretex_payee_reg_form','$captchaType');\"";
                       
                       $replace = "button $type $on_click style=\"cursor: pointer; $style\" ";
                       $needle = 'button';
                       $pos = strpos($outertext,$needle);
                       if ($pos !== false) {
                           $outertext = substr_replace($outertext,$replace,$pos,strlen($needle));
                       }
                        
                    }
                }
                else {
                    $on_click = " onclick=\"atx_register_payee('aretex_payee_reg_form','$captchaType');\"";
                    $outertext = "<button type=\"button\" $on_click style=\"cursor: pointer; \" >Register</button>";
                    
                    
                }
                $output .= $outertext; 
                                 
            }
            $output .= $parent_hidden;
            $output .= $commission_group_hidden;
            $output .= '</form></div>';
            return $output;
                                          
            
        }
        
        public static function validVisualCaptcha( $formId = NULL, $type = NULL, $fieldName = NULL, $accessibilityFieldName = NULL ) {
	        require_once(plugin_dir_path( __FILE__ ) . 'visualCaptcha/inc/visualcaptcha.class.php');
	
        	$visualCaptcha = new \visualCaptcha\Captcha( $formId, $type, $fieldName, $accessibilityFieldName );
        	return $visualCaptcha->isValid();
        }
        
        public static function getVisualCaptcha($formId = NULL, $type = NULL, $fieldName = NULL, $accessibilityFieldName = NULL) {
            require_once(plugin_dir_path( __FILE__ ) . 'visualCaptcha/inc/visualcaptcha.class.php');
            
            $visualCaptcha = new \visualCaptcha\Captcha( $formId, $type, $fieldName, $accessibilityFieldName );
            // Capture the output buffer ... because we aren't ready to show yet.
            ob_start();
            echo '<div id="atx_payee_reg_captcha" class="'."type-$type;".'">';
	        $visualCaptcha->show();
            echo '</div>';
            $ret = ob_get_clean();
            
            return $ret;
        } 
        
        public static function buynow($atts,$content=null) {
            extract( shortcode_atts( array(
        		'code' => null,
        		'id' => '0'
        	   ), $atts ) );
               
         //   error_log("Attributes:".var_export($atts,true)."\nContent:$content");
            
            require_once(plugin_dir_path( __FILE__ ) . 'simple_html_dom.php');
            
            $content =  do_shortcode($content); // Deal with embedded shortcodes first, in this case ... 
            $html = str_get_html($content);
       //     error_log("HTML:".var_export($html,true));
            
            $img = $html->find("img", 0);
            if ($img) {
                 
                $outertext = $img->outertext;
                $style = $img->style;
                
                if ($code)
                    $on_click = " onclick=\"atx_buynow_code('".$code."');\"";
                            
                
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
               
               if ($code)
                    $on_click = " onclick=\"atx_buynow_code('".$code."');\"";
               
                $replace = "button $on_click style=\"cursor: pointer; $style\" ";
                $needle = 'button';
                $pos = strpos($outertext,$needle);
                if ($pos !== false) {
                    $outertext = substr_replace($outertext,$replace,$pos,strlen($needle));
                }
                
            }
                      
           return $outertext;
            
        } 
        
        
        /**
         * AreteX_plugin::admin_page()
         * 
         * Display main plugin page, or registration if AreteX license not valid.
         * 
         * @return void
         */
        public function admin_page() {
            
            if (! empty($_POST['referesh_cache'])) {
                if ($_POST['referesh_cache'] == 'license_key') {
                    AreteX_WPI::getBasLicense(AreteX_WPI::no_cache);
                }
                
                if ($_POST['referesh_cache'] == 'server_status') {
                    $gmt =  get_option('gmt_offset');
                    AreteX_WPI::postTimeZone($gmt);
                    AreteX_WPI::getTimeZone(AreteX_WPI::no_cache);
                }
                
                if ($_POST['referesh_cache'] == 'all') {
                    AreteX_WPI::cleanCache(true);
                }
            
            }
            
            $valid_license = false;
            $license_key = get_option('aretex_license_key');
            if (! empty($license_key)){
                
                require_once(plugin_dir_path( __FILE__ ) . 'AreteX_WPI.class.php');
                $valid_license = AreteX_WPI::validate_license($license_key);
            }
            if ($valid_license){
                $license_info = AreteX_WPI::getBasLicense(); 
                if (strtolower($license_info->license_status) == 'cancelpending')
                {
                    
                    $this->cancelCleanUp();
                    include(plugin_dir_path( __FILE__ ) . 'pages/register.php');
                    return;
                }
                else
                    $load_admin = true;
                $registred_site_info = get_option('aretex_register_site_info');
                if (! AreteX_WPI::isSecure()) {
                    echo '<div class="error"> You must be running your site with SSL (i.e. https) to use AreteX&trade; .<br/>'.
                        '<p>It is an AreteX&trade; requirement that <em>all</em> communication use Transport Layer Secuirty (i.e. https, ssl).</p>'.
                        '<p>Please install and use an SSL certificate for your site. If you have already installed your SSL certificate, please log out, and log back in using <strong>https:</strong> .</p></div>';
                        $load_admin = false;

                }
                if (! $registred_site_info) {
                    $site_name= get_bloginfo( 'name' );
                    $site_url = network_site_url( '/' );
                    // Require https:
                    $urlparts = parse_url($site_url);
                    if (strtolower($urlparts['scheme']) == 'https'){
                        
                        $registred_site_info['site_name'] = $site_name;
                        $registred_site_info['site_url'] = $site_url;                                            
                        $site_id = 'master';// For now, no multi-site...
                        $res = AreteX_WPI::saveSiteInfo($registred_site_info,$site_id);
                        if ($res == 'OK') {
                            update_option('aretex_register_site_info',$registred_site_info);
                        }
                        else {
                            $load_admin = false;
                        echo <<<END_ECHO
                        <div class="error">
                            <p>$res</p>
                        </div>
END_ECHO;
                        }
                    }
                    else {
                        $this_url = '<strong>'.$urlparts['scheme'].'</strong>://'.$urlparts['host'];
                        $sec_url = '<strong>https</strong>://'.$urlparts['host'];
                        $load_admin = false;
                        echo <<<END_ECHO2
                        <div class="error">
                            <p>Your site scheme is not <em>https</em> by default. Please change <em>$this_url</em> to <em>$sec_url</em> in the <em>Settings / General</em> WordPress admin screen. </p>
                        </div>
END_ECHO2;
                    }
                }
                
                if ($load_admin)  
                    include(plugin_dir_path( __FILE__ ) . 'pages/admin_main.php');   
            }               
            else  {
                
                $license_info = AreteX_WPI::getBasLicense(); 
                if (strtolower($license_info->license_status) == 'cancelpending')
                {
                    
                    $this->cancelCleanUp();
                }
                                                           
                $complete_problem = false;
                $message_id = get_option('aretex_message_id');
                if ($message_id == 'Already Registered')
                    include(plugin_dir_path( __FILE__ ) . 'pages/already_registered.php');                
                else if ($message_id) {
                    $registration_packet = AreteX_WPI::getRegistrationPacket($message_id);
                    if ($registration_packet) {
                        
                        if (AreteX_WPI::complete_sandbox_registration($registration_packet)) {
                           include(plugin_dir_path( __FILE__ ) . 'pages/admin_main.php'); 
                        }
                        else if ($license_info) {                     
                           $complete_problem = true; 
                           include(plugin_dir_path( __FILE__ ) . 'pages/reg_problem.php'); 
                        }
                        
                    } 
                    else {                        
                      include(plugin_dir_path( __FILE__ ) . 'pages/reg_problem.php');
                    }
                }
                else
                    include(plugin_dir_path( __FILE__ ) . 'pages/register.php');
            }
                
        }
        
        protected function cancelCleanUp() {
            
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
        	
            global $wpdb;
            
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
            
            self::install();
            
            
        }
        
        public function ptr_page() {
            $valid_license = false;
            $license_key = get_option('aretex_license_key');
            if (! empty($license_key)){
                
                require_once(plugin_dir_path( __FILE__ ) . 'AreteX_WPI.class.php');
                $valid_license = AreteX_WPI::validate_license($license_key);
            }
            if ($valid_license) {
                 include(plugin_dir_path( __FILE__ ) . 'ptr/ptr_main.php');                
            }
            
        }
        
        public function cam_page() {
            $valid_license = false;
            $license_key = get_option('aretex_license_key');
            if (! empty($license_key)){
                
                require_once(plugin_dir_path( __FILE__ ) . 'AreteX_WPI.class.php');
                $valid_license = AreteX_WPI::validate_license($license_key);
            }
            if ($valid_license) {
                
                 $user_id = get_current_user_id();
                 $customer_id = get_user_meta($user_id, 'atx_customer_id', true);
                 if (! $customer_id) { // Not even pending ...
                    return false;
                    
                 }                 
                 include(plugin_dir_path( __FILE__ ) . 'cam/cam_main.php');                
            }
            
        }
        
        function add_new_sandbox_callback() {
            delete_option('aretex_message_id');
            die();
        }
        
        function have_license_callback() {
        	global $wpdb; // this is how you get access to the database
        
        	$whatever = intval( $_POST['whatever'] );
        
        	$whatever += 10;
        
                echo $whatever;
        
        	die(); // this is required to return a proper result
        }
        
        public function register_callback() {
        	
            require_once(plugin_dir_path( __FILE__ ).'AreteX_WPI.class.php');
            
          //  error_log(var_export($_POST['regdata'],true));
            
            $regdata = array();
            parse_str($_POST['regdata'],$regdata);
            
            if (AreteX_WPI::sandbox_registration($regdata))
                echo "OK";
            else
                echo "Error";
        
        	die(); // this is required to return a proper result
        }
        
        public function load_screen_callback() {
                       
            if ($_POST['plugin'] == 'ecommerce-services' && empty($_POST['feature']))
                self::load_screen($_POST['screen']);
            else if ($_POST['plugin'] == 'ptr' && empty($_POST['feature']))
                self::load_ptr_screen($_POST['screen']); 
            else if ($_POST['plugin'] == 'cam' && empty($_POST['feature']))
                self::load_cam_screen($_POST['screen']);
            else if ($_POST['plugin'] == 'aretex-main') {
                self::load_screen('../'.$_POST['screen']);
            }                  
            else if ($_POST['plugin'] == 'ecommerce-services' && ! empty($_POST['feature'])){
                $feature_name = $_POST['feature'];
                                
               global $wpdb;
               $plugin = $_POST['plugin']; 
               $table_name = $wpdb->prefix .'aretex_features';
               $rows = $wpdb->get_results( "SELECT * FROM $table_name WHERE feature_name='$feature_name'", ARRAY_A  );
               if (! empty($rows[0]['feature_class']))
               {
                  $class = $rows[0]['feature_class'];

                  if (method_exists($class,'load_screen'))
                    $class::load_screen($_POST['screen']);
                  
               }
                               
            }
            
           	die(); // this is required to return a proper result
        }
        
        
        public function features_yes_to_all_cb() {
            global $wpdb;
            
            $table_name = $wpdb->prefix .'aretex_features';
            $wpdb->query( "UPDATE $table_name SET load_feature='Y'  WHERE load_feature='Q'" );
            
            die();
        }
        
        
        public function features_no_to_all_cb() {
            global $wpdb;
            
            $table_name = $wpdb->prefix .'aretex_features';
            $wpdb->query( "UPDATE $table_name SET load_feature='N'  WHERE load_feature='Q'" );
            
            die();
        }
        
        public function answer_feature_cb() {
            global $wpdb;
            
            $answer = $_POST['answer'];
            $feature_name = $_POST['feature_name'];
            
            $table_name = $wpdb->prefix .'aretex_features';
            $wpdb->query( "UPDATE $table_name SET load_feature='$answer'  WHERE feature_name='$feature_name'" );
            
            die();
        }
        
        protected function get_the_user_ip() {
            if ( ! empty( $_SERVER['HTTP_CLIENT_IP'] ) ) {
                //check ip from share internet
                $ip = $_SERVER['HTTP_CLIENT_IP'];
            } 
            elseif ( ! empty( $_SERVER['HTTP_X_FORWARDED_FOR'] ) ) {
                //to check ip is pass from proxy
                $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
            } 
            else {
                $ip = $_SERVER['REMOTE_ADDR'];
            }
            
            return $ip;
        }
        public function atx_payee_complete_callback()  {
             $options= urldecode($_POST['data']);
            parse_str($options,$registration_options);
            
            
            if(!is_email($registration_options['_contact_email_'])) {    			
    			$err['element']='payee_email';
                $err['message'] = 'Invalid email address';
    			$errors[] = $err;
    		}
                            		    	
            
             if (empty($registration_options['_name_'])) {
                $err['element']='payee_name';
                $err['message'] = 'This field is required. ';
       	        $errors[] = $err; 
                
            }
            
            if (empty($registration_options['_address_'])) {
                $err['element']='payee_address';
                $err['message'] = 'This field is required. ';
       	        $errors[] = $err; 
                
            }
            
            if (empty($registration_options['_phone_'])) {
                $err['element']='payee_phone';
                $err['message'] = 'This field is required. ';
       	        $errors[] = $err; 
                
            }
            
            $num = preg_replace('(\D+)', '', $registration_options['_phone_']);
            if (! ((strlen($num) == 10) || (($num[0] == '1') && (strlen($num) == 11)))) {
                $err['element']='payee_phone';
                $err['message'] = 'Please enter a valid US Phone Number. ';
       	        $errors[] = $err; 
            }
            
            
            
            if (! empty($errors)){ // If not valid json_encode the error list and pop it back   
                $return['errors'] = $errors;
                $return = json_encode($return);
                echo $return; 
                die(); // this is required to return a proper result
            }   
            
            $registration_options['ip_addy'] = $this->get_the_user_ip();
            $registration_options['ptr_url'] = get_site_url(null,null,'https');
            $current_site =  get_option( 'blogname', 'the website' );;
            $registration_options['ptr_site_name'] = $current_site;
            $user_id =  get_current_user_id();
            $registration_options['other_id_1'] = $user_id;
            
            $parent = get_user_meta($user_id, 'atx_payee_parent', true);
            $commission_category_id  = get_user_meta($user_id, 'atx_payee_commmision_cat_id', true);
             
            
            update_user_meta($user_id,'atx_payee_agree_tos','Yes');
            
            if (! empty($parent))
                $registration_options['parent'] = $parent;
            
            if (! empty($commission_category_id))
                $registration_options['commission_category_id'] = $commission_category_id;
            
            
            $ret = AreteX_WPI::signUpPayee($registration_options);
            $return = json_encode($ret);
            echo $return;
            die(); 
            
        }
        
        public function atx_payee_reg_callback()  {
            
             $errors = array();
                 // validate post data:
            //  1. Username must be unique
            //  2. Email must be valid and unique            
            //
            
            $options= urldecode($_POST['options']);
            parse_str($options,$registration_options);
            
            
             // start with a captcha check ...
            if ($_SESSION['visualCaptcha-fieldName']) {// Yep ... need to check captcha
                $_POST[$_SESSION['visualCaptcha-fieldName']] = $registration_options[$_SESSION['visualCaptcha-fieldName']]; // Move this to where CAPTCHA expects it ... 
                if (! self::validVisualCaptcha($_POST['form_id'],$_POST['capcha_type'],$_SESSION['visualCaptcha-fieldName'],$_SESSION['visualCaptcha-accessibilityFieldName'])) {
                    $err['element']='atx_payee_reg_captcha';
                    $err['message'] = "<br/>Invalid CAPTCHA<br/>";
	                $errors[] = $err; 
                }                
                
            } 
            
                // this is required for username checks
        //    error_log("Registration Options".var_export($registration_options,true)); 
    		require_once(ABSPATH . WPINC . '/registration.php');
     
            
            $registration_options['username'] = sanitize_user( $registration_options['username']);
           // error_log("Reg Options = ".$registration_options['username']);
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
                        
            
    		if(empty($registration_options['username'])) {
    
    		    $err['element']='username';
                $err['message'] = 'Cannot be empty - please enter a Username. ';
    			$errors[] = $err;
    		}
    		if(!is_email($registration_options['email'])) {    			
    			$err['element']='email';
                $err['message'] = 'Invalid email address';
    			$errors[] = $err;
    		}
    		if(email_exists($registration_options['email'])) {
    		    $err['element']='email';
                $err['message'] = 'Email address already registered. ';
       	        $errors[] = $err;  
    		}
                            		    	
            
             if (empty($registration_options['_name_'])) {
                $err['element']='payee_name';
                $err['message'] = 'This field is required. ';
       	        $errors[] = $err; 
                
            }
            
            if (empty($registration_options['_address_'])) {
                $err['element']='payee_address';
                $err['message'] = 'This field is required. ';
       	        $errors[] = $err; 
                
            }
            
            if (empty($registration_options['_phone_'])) {
                $err['element']='payee_phone';
                $err['message'] = 'This field is required. ';
       	        $errors[] = $err; 
                
            }
            
            $num = preg_replace('(\D+)', '', $registration_options['_phone_']);
            if (! ((strlen($num) == 10) || (($num[0] == '1') && (strlen($num) == 11)))) {
                $err['element']='payee_phone';
                $err['message'] = 'Please enter a valid US Phone Number. ';
       	        $errors[] = $err; 
            }
            
            
            
            if (! empty($errors)){
                $return['errors'] = $errors;
                $return = json_encode($return);
                echo $return; 
                die(); // this is required to return a proper result
            } // If not valid json_encode the error list and pop it back             
            
            // If it's valid, put them into the array ...
                     
             $new_user_id = register_new_user( $registration_options['username'],$registration_options['email'] );
             if ( !is_wp_error($new_user_id) ){
                
                
                update_user_meta( $new_user_id, 'atx_payee_email', $registration_options['email']); // This is the payee email on file with AreteX
                update_user_meta( $new_user_id, 'atx_payee_name', $registration_options['_name_']); // This is the payee name (pay to the order of ...) on file with AreteX
                update_user_meta( $new_user_id, 'atx_payee_address', $registration_options['_address_']); // This is the payee mailing address on file with AreteX
                update_user_meta( $new_user_id, 'atx_payee_phone', $registration_options['_phone_']); // This is the payee phone on file with AreteX
                update_user_meta( $new_user_id, 'atx_payee_parent', $registration_options['_parent_']); // "Upline Payee"
                update_user_meta( $new_user_id, 'atx_payee_commmision_cat_id', $registration_options['_commission_category_id_']); // "Upline Payee"

   
                $role_delivered = 'aretex_payee';                
                wp_update_user( array ( 'ID' => $new_user_id, 'role' => $role_delivered ) ) ;

               
                
             }
             else {
                $err['element'] = 'username'; // Gotta put it someplace
                $err['message'] = $new_user_id->get_error_message();
                $errors[] = $err;
                $return = json_encode($return);
                echo $return; 
                die();  
             } 
             

             
             $return = json_encode("Check your email for registration info");
             echo $return; 
             die();
                
            
           
            
        }
        
        public function atx_cancelrebill() {
            $return = AreteX_WPI::CancelRebillAgreement($_POST['rebill_id']);
            $return = json_encode($return);
            echo $return;
            die();
            
        }
        
        public function atx_updatebsucontact() {
            
            $data = urldecode($_POST['data']);
            $form_data = array();
            $send_data = array();
            $data =  parse_str($data,$form_data);
            
            foreach($form_data as $key=>$value)
            {
                if (substr($key,0,1) == '_')
                {
                   $back_key = strrev($key);
                   if (substr($back_key,0,1) == '_')
                   {
                      $key = trim($key,'_');
                      $send_data[$key] = $value;              
                   } 
                }
                
            }
                        
            $return = AreteX_WPI::saveBsuBusiness($send_data);
            $return = json_encode($return);
            echo $return;
            die();
            
        }

        
        
        public function atx_updatecamcontact() {
            
            $data = urldecode($_POST['data']);
            $form_data = array();
            $send_data = array();
            $data =  parse_str($data,$form_data);
            
            foreach($form_data as $key=>$value)
            {
                if (substr($key,0,1) == '_')
                {
                   $back_key = strrev($key);
                   if (substr($back_key,0,1) == '_')
                   {
                      $key = trim($key,'_');
                      $send_data[$key] = $value;              
                   } 
                }
                
            }
                        
            $return = AreteX_WPI::UpdateCustomerContact($send_data);
            $return = json_encode($return);
            echo $return;
            die();
            
        }
        
        public function atx_updatepayment() {
            $button_code = AreteX_WPI::UpdatePaymentButtonCode($_POST['rebill_id']);
            $url = get_option('aretex_pcs_in_endpoint');
            $url .= '/begin_cc_co.php';
            $return['data'] = $button_code; // Was already JSON encoded ...
            $return['url'] = $url; 
            
            $return = json_encode($return);
            
          //  error_log("Button Code: ".var_export($button_code,true));
            echo $return; 
            
           	die(); // this is required to return a proper result
        }
        
        public function atx_buynow_callback() {
                       
        //    echo 'Buy Now: '.$_POST['code'];
       //  error_log("In atx_buynow_callback".var_export($_POST,true));
            
            $product_data = AreteX_WPI::getProductDetailByCode($_POST['code']);
       //     error_log("Product Data".var_export($product_data,true));
            
            $button_code = AreteX_WPI::BuyNowButtonCode($product_data);
            
      //      error_log("Button Code: ".var_export($button_code,true));
         
            
            
         /*
            $data['id'] = '111';
            $data['code'] = 'CODE';
            $data['name'] = 'nAME';
            //*/
            
            
            $url = get_option('aretex_pcs_in_endpoint');
            $url .= '/begin_cc_co.php';
            $return['data'] = $button_code; // Was already JSON encoded ...
            $return['url'] = $url; 
            
            $return = json_encode($return);
            
          //  error_log("Button Code: ".var_export($button_code,true));
            echo $return; 
            
           	die(); // this is required to return a proper result
        }
        
        
         public function atx_receipt() {
            
            $return = AreteX_WPI::getReceiptURL($_POST['receipt_id']);
            $return = json_encode($return);
             echo $return; 
            die();  
        }
        
        protected  function get_paid_content_obj() {
            global $wpdb;
            
            $table_name = $wpdb->prefix .'aretex_features';
            $rows = $wpdb->get_results( "SELECT * FROM $table_name WHERE `feature_name` = 'AreteX Paid Content' AND `load_feature` = 'Y' AND `feature_installed` = 'Y'", ARRAY_A  );
            if (is_array($rows)) {
                $feature_class = $rows[0]['feature_class'];
                if ( self::$features[$feature_class] )
                    return   self::$features[$feature_class];
                    
                if (file_exists($rows[0]['feature_path'])) {
                    require_once($rows[0]['feature_path']);
                    if (class_exists($rows[0]['feature_class'])) {
                        self::$features[$feature_class] = new $feature_class();
                        return self::$features[$feature_class];
                    }
                }
            }
            
            return null;
        }
        
        protected  function get_paid_mem_obj() {
            global $wpdb;
            
            $table_name = $wpdb->prefix .'aretex_features';
            $rows = $wpdb->get_results( "SELECT * FROM $table_name WHERE `feature_name` = 'AreteX Subscriptions and Memberships' AND `load_feature` = 'Y' AND `feature_installed` = 'Y'", ARRAY_A  );
            if (is_array($rows)) {
                $feature_class = $rows[0]['feature_class'];
                if ( self::$features[$feature_class] )
                    return   self::$features[$feature_class];
                    
                if (file_exists($rows[0]['feature_path'])) {
                    require_once($rows[0]['feature_path']);
                    if (class_exists($rows[0]['feature_class'])) {
                        self::$features[$feature_class] = new $feature_class();
                        return self::$features[$feature_class];
                    }
                }
            }
            
            return null;
        }
        
        public function atx_create_full_paid_mem_prod() {
            $product = $_POST['product'];
         //   error_log("Product:".var_export($product,true));
            if ($product['pricing_model'] == 'recurring_billing')
            {
                $data = array();
                parse_str($product['price'],$data);
                $product['price']= $data['data']['rebill_data'];
            }
         //    error_log("Product:".var_export($product,true));
            $prod = AreteX_WPI::createProduct($product);
            
            /* 
                   {"id":"27","code":"TES5","name":"Test","pricing":{"pricing_model":"single_price","offers":{"default":{"price":"1.00"}}},"delivery":{"id":null,"delivery_code":false,"description":null,"deliverables":[]},"uri":"https://aretexhome.com/AreteX/3ccfa21ff24/cat/api/products/27"}
            */
            

            $pd_cnt = self::get_paid_mem_obj();
            $delv = $_POST['deliverable'];  
            $delv['deliverable_code'] = $prod->code;          
            //$data['name'] = $product[''],$data['description'],$data['deliverable_code']
            
            $res = $pd_cnt->CreateDeliverable($delv);
            /*
            {"id":"14","deliverable_code":"ABT1","name":"ABTest1","description":"ABTest1: Paid Content","uri":"/cat/api/delivery/deliverables/14"}
            */

            if (is_object($res)) {
             
                $manifest_id['delivery_code'] = $prod->code;
                $manifest_id['description'] = $res->description;                                
                $manifest_deliverables = array();
                $manifest_deliverables[] = $res->id;       
                $delivery_code = $manifest_id['data']['delivery_code'];
                $linked_product = $prod->code;
                $response = AreteX_WPI_DI::save_manifest($manifest_id,$manifest_deliverables,true,$linked_product);
                /* {"id":"18","delivery_code":"TES9","description":"Test: Paid Content","deliverable_ids":["16"]}   */
                
                if ($delv['role_type'] == 'reg_role' ) {
                    $allow_free = $_POST['allow_free_reg'] == 'Yes';
                    $short_code = self::paid_membership_reg_short_code($prod->code,$allow_free);
                } 
                else {
                    $short_code = self::paid_membership_role_only_short_code($prod->code);
                }
                
                $_SESSION['AreteX_Wizard']['shortcode'] = $short_code;                 
                echo json_encode($short_code);
                die();
            }
            
            echo json_encode("There was an Error");
            die();
        }
        
        public function atx_create_full_paid_c_prod() {
            $product = $_POST['product'];
         //   error_log("Product:".var_export($product,true));
            if ($product['pricing_model'] == 'recurring_billing')
            {
                $data = array();
                parse_str($product['price'],$data);
                $product['price']= $data['data']['rebill_data'];
            }
         //    error_log("Product:".var_export($product,true));
            $prod = AreteX_WPI::createProduct($product);
            
            /* 
                   {"id":"27","code":"TES5","name":"Test","pricing":{"pricing_model":"single_price","offers":{"default":{"price":"1.00"}}},"delivery":{"id":null,"delivery_code":false,"description":null,"deliverables":[]},"uri":"https://aretexhome.com/AreteX/3ccfa21ff24/cat/api/products/27"}
            */
            

            $pd_cnt = self::get_paid_content_obj();
            error_log("Paid Content: ".var_export($pd_cnt,true));
            $delv = $_POST['deliverable'];  
            $delv['deliverable_code'] = $prod->code;          
            //$data['name'] = $product[''],$data['description'],$data['deliverable_code']
            
            $res = $pd_cnt->CreateDeliverable($delv);
            /*
            {"id":"14","deliverable_code":"ABT1","name":"ABTest1","description":"ABTest1: Paid Content","uri":"/cat/api/delivery/deliverables/14"}
            */

            if (is_object($res)) {
             
                $manifest_id['delivery_code'] = $prod->code;
                $manifest_id['description'] = $res->description;                                
                $manifest_deliverables = array();
                $manifest_deliverables[] = $res->id;                
              //  $delivery_code = $manifest_id['data']['delivery_code'];
                $linked_product = $prod->code;
                $response = AreteX_WPI_DI::save_manifest($manifest_id,$manifest_deliverables,true,$linked_product);
                /* {"id":"18","delivery_code":"TES9","description":"Test: Paid Content","deliverable_ids":["16"]}   */
                
                
                $short_code = self::paid_content_short_code($prod->code);
                $_SESSION['AreteX_Wizard']['shortcode'] = $short_code;
                echo json_encode($short_code);
                die();
            }
            
            echo json_encode("There was an Error");
            die();
            
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
        
        protected function paid_content_short_code($code) {
            $str = <<<END_SCD
[aretex_paid_content deliverable_code="$code" status="!LoggedIn"]

You must be logged in to view or buy this ...

[/aretex_paid_content]

[aretex_paid_content deliverable_code="$code" status="!Authorized"]

To buy this content just click the button below.

[atx_buynow code="$code"]<button>Buy Now</button>[/atx_buynow]

[/aretex_paid_content]

[aretex_paid_content deliverable_code="$code"]

--- REPLACE THIS WITH YOUR ACTUAL CONTENT ---

[/aretex_paid_content]        
END_SCD;
            return $str;
        }
        
        
        
        public function atx_create_prod() {
            $prod = AreteX_WPI::createProduct($_POST);
            echo json_encode($prod);
            
            die();  
        }
        
        public function atx_validate_tracking_code() {
            $result = AreteX_WPI::validateTrackingCode($_POST['tracking_code']);
            echo json_encode($result);
            die();
        }
        
        public function atx_full_tracking() {
            $result = self::full_tracking($_POST['payee'],$_POST['offer'],$_POST['media']);
            echo json_encode($result);
            die();
        }
        
         public function atx_create_splash_code() {
                $result = AreteX_WPI::createSplashCode($_POST['data']);
                echo json_encode($result);
                die();
         }
         
         public function atx_create_media_code() {
                $data = array();
                $data['source_id'] = $_POST['source_id'];
                $data['description'] = $_POST['description'];
                
                $result = AreteX_WPI::createMediaCode($data);                
                if (strtolower(substr($result,0,5)) == 'error'){
                    echo json_encode('Error');
                }
                else {
                    $ret = self::example_tracking($_POST['offer_code'],$result);
                    echo json_encode($ret);
                }
                die();
         }
        
        public function atx_create_offer() {
            $result = AreteX_WPI::createOffer($_POST);
            
            if (strtolower(substr($result,0,5)) == 'error'){
                echo json_encode('Error');
            }
            else {
                $ret = self::example_tracking($_POST['offer_code']);
                echo json_encode($ret);
            }
            
           
            
            die();  
        }
        
         public function atx_delete_manifest() {
            require_once(plugin_dir_path( __FILE__ ) . 'AreteX_WPI_DI.class.php');
            
            $response = AreteX_WPI_DI::delete_manifest($_POST['delivery_code']);
            if (strtolower(substr($response,0,5)) == 'error'){
                $result['status'] = 'Error';
                $error['message'] = "$result";
            }
            else
                $result['status'] = 'OK';
                
             echo json_encode($result);
            die(); 
            
         }
        
        public function atx_save_pcs_out() {
            parse_str($_POST['data'],$data);
            $response = AreteX_WPI::postBsuPcsOut($data);
            
            echo "OK";
            die();
            
            
        } 
        public function atx_save_deliverable_payouts() {
             require_once(plugin_dir_path( __FILE__ ) . 'AreteX_WPI_DI.class.php');
             
             parse_str($_POST['payouts'],$payouts);
             $payout_code_id = $payouts['payout_code_id'];
             $payouts = array();
             
             if (is_array($payout_code_id)) {
                foreach($payout_code_id as $payee_id =>$payout_code_ids ) {
                    
                    foreach($payout_code_ids as $payout_code_id)
                    {
                        $data['payee_id'] = $payee_id;
                        $data['payout_code_id'] = $payout_code_id;
                        $payouts[] = $data;
                    }
                    
                }
             }
         //    error_log("Deliverable Id: {$_POST['deliverable_id']}\n".var_export($payouts,true));
               
             
             $response = AreteX_WPI_DI::save_deliverable_payouts($_POST['deliverable_id'], $payouts);
            // error_log(var_export($response,true));
             
             $result['status'] = 'OK';
             
             echo json_encode($result);
             die();  
             
             
        }
        
        public function send_ptr_pdf() {
            AreteX_WPI::send_ptr_pdf($_GET['account_id']);
            die();
        }
        
        public function atx_get_wp_user_name() {
            $wp_id = $_POST['wp_id'];
            $user = new WP_User($wp_id);
            if ($user->user_login)
                echo json_encode($user->user_login);
            else
                echo json_encode('');
            
            die();
            
        }
        
        public function atx_payee_agree() {
            $user_id = $_POST['user_id'];
            $current_user_id =  get_current_user_id();
            if ($user_id != $current_user_id)
                die();
                
            update_user_meta( $user_id, 'atx_payee_agree_tos',  'Yes');
             echo json_encode('');
            die();
        }
        
        public function atx_set_can_ptr() {
            
            $user_id = $_POST['wp_id'];
            $user = new WP_User( $user_id );
            if (! user_can( $user, 'access_aretex_ptr' ))
                $user->add_cap( 'access_aretex_ptr');
                        
            $payee_name    = $_POST['payee_name'];
            $payee_address = $_POST['payee_address'];
            $payee_email   = $_POST['payee_email'];
            $payee_phone   = $_POST['payee_phone'];
            
            update_user_meta( $user_id, 'atx_payee_email',  $payee_email); // This is the payee email on file with AreteX
            update_user_meta( $user_id, 'atx_payee_name',   $payee_name); // This is the payee name (pay to the order of ...) on file with AreteX
            update_user_meta( $user_id, 'atx_payee_address',$payee_address); // This is the payee mailing address on file with AreteX
            update_user_meta( $user_id, 'atx_payee_phone',  $payee_phone); // This is the payee phone on file with AreteX
            
            add_user_meta($user_id,'atx_payee_agree_tos','No',true);

            
            
            echo json_encode('OK');
            die();
        }
        
        public function atx_find_wp_user() {
            
                       
            $query_val = $_POST['q'];
            $limit = $_POST['limit'];
            
            $args = array(
            	'search'         => '*'.$query_val.'*',
            	'search_columns' => array( 'user_login', 'user_email'
                )
            );
            
            if ($limit)
                $args['number'] = $limit;
            
            $user_query = new WP_User_Query( $args );
            $ret = array();
            if ( ! empty( $user_query->results ) ) {
            	foreach ( $user_query->results as $user ) {
            	    $data = array();
                    $data['wp_id'] = $user->ID;
            	    $data['username'] = $user->user_login;
                    $data['email'] = $user->user_email;
                    
                    $ret[] = $data;
            	}
            }
            $ret = json_encode($ret);
            echo $ret;
            die();           
        }
        
        public function send_admin_ptr_pdf() {
            AreteX_WPI::send_admin_ptr_pdf($_GET['account_id'],$_GET['wp_id']);
            die();
        }
        
        public function atx_create_manifest() {
            require_once(plugin_dir_path( __FILE__ ) . 'AreteX_WPI_DI.class.php');
            
            parse_str($_POST['manifest_id'],$manifest_id);
            parse_str($_POST['manifest_content'],$manifest_content);
            $manifest_deliverables = $manifest_content['deliverable_id'];       
            $delivery_code = $manifest_id['data']['delivery_code'];
            
            if (strtolower($_POST['new_manifest']) == 'true' && $delivery_code != '*') {

                if (ctype_digit($delivery_code)) {
                    $result['status'] = 'Error';
                    $error['element'] = 'delivery_code';
                    $error['message'] = "Must have at least one letter.";                
                    $result['errors'][] = $error;
                }
                $re = '/^[a-zA-Z0-9]+$/'; 
                preg_match($re, $delivery_code, $match);
                if (count($match) != 1) {
                    $result['status'] = 'Error';
                    $error['element'] = 'delivery_code';
                    $error['message'] = "Letters and Numbers Only.";                
                    $result['errors'][] = $error;
                }
                
                if (strlen($delivery_code) > 20) {
                    $result['status'] = 'Error';
                    $error['element'] = 'delivery_code';
                    $error['message'] = "No more then 20 characters.";                
                    $result['errors'][] = $error;
                    
                }
            }
            if ( $result['status'] != 'Error') {
                if (strtolower($_POST['new_manifest']) == 'true' ) {
                    $response = AreteX_WPI_DI::get_manifest_by_code($delivery_code);
                    if (! empty($response['id'])) {
                        $result['status'] = 'Error';
                        $error['element'] = 'delivery_code';
                        $error['message'] = "$delivery_code Already Exists "; 
                        $error['more'] = 'new_manifest: ' . serialize($_POST['new_manifest']);               
                        $result['errors'][] = $error;
                        
                    }
                    else {
                        $linked_product = false;
                        if ($_POST['linked_product'])
                            $linked_product = $_POST['linked_product'];
                            
                        $response = AreteX_WPI_DI::save_manifest($manifest_id['data'],$manifest_deliverables,true,$linked_product);
                        $result['status'] = 'OK';
                    }
                }
                else {
                     $linked_product = false;
                     if ($_POST['linked_product'])
                        $linked_product = $_POST['linked_product'];
                    $response = AreteX_WPI_DI::save_manifest($manifest_id['data'],$manifest_deliverables,false,$linked_product);
                    $result['status'] = 'OK';
                }
            }
          
            
          //  $result = AreteX_WPI_DI::createManifest($_POST);
          /*  
            if (strtolower(substr($result,0,5)) == 'error'){
                echo json_encode('Error');
            }
            else {
                $ret = self::example_tracking($_POST['offer_code']);
                echo json_encode($ret);
            }
            
           */
            echo json_encode($result);
            die();  
        }
        
        public function atx_save_pay_sched() {
            
            $result = AreteX_WPI::savePaySched($_POST);
            
            if (strtolower(substr($result,0,5)) == 'error'){
                echo json_encode('Error');
            }
            else {
               
                echo json_encode($result);
            }
            
           
            
            die();  
        }
        
        public function atx_post_deliverable_auth() {
            $result = AreteX_WPI::postAuthorizationUpdate($_POST['id'],$_POST['data']);
             echo json_encode($result);
            die();
        }
        
        public function atx_replace_id_key() {
            
            if (isset($_POST['data'])) {
                    
                $dechunk = str_replace('--- BEGIN ARETEX KEY REPLACEMENT REQUEST ---','',$_POST['data']);
                $dechunk = str_replace('--- END ARETEX KEY REPLACEMENT REQUEST ---','',$dechunk);
                $dechunk = preg_replace('/\s+/', '', $dechunk);
               
               // error_log("De-chunked: $dechunk");                 
                $public_key = get_option('aretex_central_publickey');               
                $crypton = new Crypton();
                
                $message = $crypton->decrypt_message($dechunk,$public_key);
                error_log($message);
                if ($message) {
                    $my_license_key = get_option('aretex_license_key');
                    $my_api_key = get_option('aretex_api_key');
                    list($license_key,$app_key,$private_key) = explode('|',$message);
                    if ($license_key == $my_license_key && $app_key == $my_api_key) {
                        // Get something from AreteX first ..
                        
                        $keys = AreteX_API::ClientKeys();
                        
                        // Post public key to AreteX

                        $data = $crypton->encrypt_message($keys['publickey'],$private_key);
                        
                        $results = AreteX_WPI::post_new_public_key($my_license_key,$my_api_key,$data);
                        
                        if ($results == 'OK') {                
                            update_option('aretex_public_key',$keys['publickey']);
                            $password = base64_encode($crypton->generate_sym_key());
                            $ini_code=<<<END_INI_CODE2
;<? if (; //Cause parse error to hide from prying eyes?>
; Protect this file .... it has an important key in it
; Of course! The key is the key
bflat="$password"
END_INI_CODE2;
                            $protect_file = plugin_dir_path( __FILE__ ) . 'protect.ini.php';
                            file_put_contents($protect_file,$ini_code);
             
                            $crypton->store_keys($keys,'aretex_wp',$password,true);
                            update_option('aretex_hash',$password);
                            $enc_keys = $crypton->get_keys_for_backup();
                            update_option('aretex_private_key',$enc_keys);
                            AreteX_WPI::cleanCache(true);
                            echo 'Replacement Complete';
                            die();
                        }
                        
                    }
                    
                }
                                                                                          
            }
            
             echo 'Replacement Request Not Valid';
            die();
        }
        
        public function atx_ptr_wp_cfg() {
            $defaults = array('ptr_tos_link'=>'#',
                              'ptr_qvar'=>'atxcc',
                              'ptr_cookie_duration'=>'30',
                              'ptr_deep_link'=>'Yes',
                              'home_page_message'=>null,
                              'pending_payments_message'=>null,
                              'referrer_message'=>null);
            $flds = array('ptr_tos_link' => 'aretex_ptr_tos_link',
                          'ptr_qvar'=>'aretex_tracking_qvar',
                          'ptr_cookie_duration'=>'aretex_tracking_cookie_days',
                          'ptr_deep_link'=>'aretex_explain_deep',
                          'home_page_message'=>'aretex_ptr_home_message',
                          'pending_payments_message' => 'aretex_pending_pay_message',
                          'referrer_message'=>'aretex_ptr_referrer_message'
                          );
                          
            $post_data = array();
            parse_str($_POST['data'],$post_data);
            foreach($post_data as $key=>$value) {
                $value = trim($value);
                if (empty($value))
                    $value = $defaults[$key];
                $option_key = $flds[$key];
                update_option($option_key,$value);
                
            }
            
            echo json_encode("Success");
            die();
        }
        
        public function atx_delete_deliverable_auth() {
            $result = AreteX_WPI::deleteDeliverableAuthorization($_POST['id']);
             echo json_encode($result);
            die();
        }
        
        public function atx_post_manual_payments() {
            $result = AreteX_WPI::post_manual_payment($_POST['duedate'],$_POST['account_id']);
            echo json_encode($result);
            die();
        }
        
        public function atx_cam_to_wp() {
            global $user_ID;
            
            get_currentuserinfo(); // Populate the globals ...                                   
            $new_email = $_POST['email'];
            $user_id = wp_update_user( array( 'ID' => $user_ID, 'user_email' => esc_attr($new_email) ) );

            if ( is_wp_error( $user_id ) ) {
               echo json_encode('Error - Profile not updated to '.$new_email);
            } 
            else {
            	echo json_encode('OK');
            }
            die();	 
        }
        
        public function atx_post_refund() {
            $result = AreteX_WPI::post_refund($_POST['data']['txn'],$_POST['data']['amount']);
            echo json_encode($result);
            die();
            
        }
        
        public function atx_check_offer_code() {
            
            $code = $_REQUEST['offer_code'];
            
            $offer = AreteX_WPI::getOffers($code,true);
            if (empty($offer))            
                echo json_encode("true"); // If everything is fine ...
            else
                echo json_encode("Offer Code Already in Use"); 
            die();
        }
        
        public function atx_check_prod_code() {
            
            $code = $_REQUEST['prod_code2'];
            if (ctype_alnum($code) === false) { 
                if ($code != '*') {
                    echo json_encode('Alphanumeric only');
                    die();    
                }
             }
            if (ctype_digit($code)) {
                  echo json_encode('At least one letter.');
                    die();
             } 
            $results = AreteX_WPI::getProducts($code);
            if (is_array($results->products)) {
                $code = trim(strtolower($code));
                foreach($results->products as $prod){
                    $existing_prod_code = trim(strtolower($prod->code));
                    if ($code == $existing_prod_code){                       
                        echo json_encode('Product Code Already in Use');
                        die();
                    }
                        
                }
            }          
            echo json_encode("true"); // If everything is fine ... 
            die();
        }
        
        
        public function atx_new_commision_structure() {
            
            $data = array();
            
            foreach($_POST['data'] as $key=>$value) {
                $parsed_query = array();
                parse_str($value,$parsed_query);
                $data[$key] = $parsed_query;
            }
            
            $data = json_encode($data);
            $data =  AreteX_WPI::post_commission_structure($data);
            
            
            echo "OK";
            die();
        }
        
        public function atx_save_commision_structure() {
            
            $data = array();
             parse_str($_POST['data'],$parsed_query);
            
            
            $data = json_encode($parsed_query);
            $data =  AreteX_WPI::post_commission_structure($data,$_POST['code']);
            
            
            echo "OK";
            die();
        }
        
        public function atx_delete_commission_structure() {
            $code = $_POST['code'];
            
            AreteX_WPI::deleteCommissionStructure($code);
            echo "OK";
            die();
            
        }
        
        public function atx_delete_splash_code() {
            $code = $_POST['code'];
            
            AreteX_WPI::deleteSplashCode($code);
            echo "OK";
            die();
            
        }
        
        public function  atx_check_comm_group_code() {
            $code = $_REQUEST['comm_grp_code'];
            if (ctype_alnum($code) === false) { 
                if ($code != '*') {
                    echo json_encode('Alphanumeric only');
                    die();    
                }
             }
             if (ctype_digit($code)) {
                  echo json_encode('At least one letter.');
                    die();
             }
             $results = AreteX_WPI::getBsuCommissionGroups($code);
             if (is_array($results) && count($results) > 0) {
                 echo json_encode('Commission Group Code Already in Use');
                 die();
             }
             
            echo json_encode("true"); // If everything is fine ... 
            die();
             
        }
        
        
        public function atx_complete_wizard() {
            // Need to mark wizard "complete"
        }
        
        public function atx_check_dlv_code() {
             require_once(plugin_dir_path( __FILE__ ) . 'AreteX_WPI_DI.class.php');
             
            $code = $_REQUEST['dlv_code'];
            if (ctype_alnum($code) === false) { 
                if ($code != '*') {
                    echo json_encode('Alphanumeric only');
                    die();    
                }
             }
            
             // Check AreteX for deliverable code 
            $results = AreteX_WPI_DI::get_deliverables_by_id($code);
            if ($results['total'] > 0) {
               echo json_encode('Deliverable Code Already in Use');
                        die(); 
            } 
                  
            echo json_encode("true"); // If everything is fine ... 
            die();
        }
        
        
         public function atx_check_wiz_code() {
             require_once(plugin_dir_path( __FILE__ ) . 'AreteX_WPI_DI.class.php');
             
            $code = $_REQUEST['prod_code2'];
            if (empty($code))
                $code = $_REQUEST['dlv_code'];
            if (ctype_alnum($code) === false) { 
                if ($code != '*') {
                    echo json_encode('Alphanumeric only');
                    die();    
                }
             }
           
                        
            if (ctype_digit($code)) {
                  echo json_encode('At least one letter.');
                    die();
             } 
            $results = AreteX_WPI::getProducts($code);
            if (is_array($results->products)) {
                $code = trim(strtolower($code));
                foreach($results->products as $prod){
                    $existing_prod_code = trim(strtolower($prod->code));
                    if ($code == $existing_prod_code){                       
                        echo json_encode('Product Code Already in Use');
                        die();
                    }
                        
                }
            }  
            
             // Check AreteX for deliverable code 
            $results = AreteX_WPI_DI::get_deliverables_by_id($code);
            if ($results['total'] > 0) {
               echo json_encode('Deliverable Code Already in Use');
                        die(); 
            }
            
            $results = AreteX_WPI_DI::get_manifest_by_code($code);
            if ($results['id'] > 0) {
               echo json_encode('Manifest Delivery Code Already in Use');
                        die(); 
            }  
                  
            echo json_encode("true"); // If everything is fine ... 
            die();
        }
        
        
        public static function load_screen($screen) {
            
            include(plugin_dir_path( __FILE__ ) . 'pages/sub_pages/'.$screen.'.php');
            
        }
        
        public static function load_ptr_screen($screen) {
            
            include(plugin_dir_path( __FILE__ ) . 'ptr/pages/'.$screen.'.php');
            
        }
        
        public static function load_cam_screen($screen) {
            
            include(plugin_dir_path( __FILE__ ) . 'cam/pages/'.$screen.'.php');
            
        }
        
        public static function default_tracking() {
            
            $default_tracking = AreteX_WPI::get_tracking_codes(0,'REG','WEB');
            foreach($default_tracking as $tracking_code=>$details) {
                break;
            }
            $base_url = get_bloginfo('wpurl');
            return $base_url.'/'.$tracking_code;
            
        }
        
        public static function full_tracking($payee,$offer,$media) {
            $full_tracking = AreteX_WPI::get_tracking_codes($payee,$offer,$media);
            foreach($full_tracking as $tracking_code=>$details) {
                break;
            }
            $base_url = get_bloginfo('wpurl');
            $qvar = get_option('aretex_tracking_qvar');
            $tracking['url'] = $base_url.'/'.$qvar.'/'.$tracking_code;
            $tracking['code'] = $tracking_code;
            
            return $tracking;
            
        }
        
        public static function example_tracking($offer, $media='WEB') {
            
            $default_tracking = AreteX_WPI::get_tracking_codes(0,$offer,$media);
            foreach($default_tracking as $tracking_code=>$details) {
                break;
            }

            $base_url = get_bloginfo('wpurl');
            $ret['tracking_code'] = $tracking_code;
            $qvar = get_option('aretex_tracking_qvar');
            $ret['url'] = $base_url.'/'.$qvar.'/'.$tracking_code;
            return $ret;
            
        }
        
        public static function download_as_attachment() {
            
             switch($_GET['file_id']) {
                case 'default_css':
                    $filename = 'aretex_notification.css';
                    $aretex_core_path = get_option('aretex_core_path'); 
                    $path = dirname($aretex_core_path) . '/style_sheet_templates/notification-default.css';
                    $content = file_get_contents($path);
                break;
                case 'default_email':
                    $filename = 'new_account.html';
                    $aretex_core_path = get_option('aretex_core_path'); 
                    $path = dirname($aretex_core_path) . '/email_templates/new_account.html';
                    $content = file_get_contents($path);
                break;
                case 'default_payment_css':
                    $filename = 'aretex_payment.css';
                    $aretex_core_path = get_option('aretex_core_path'); 
                    $path = dirname($aretex_core_path) . '/style_sheet_templates/payment-form-sample.css';
                    $content = file_get_contents($path);
                break;
                case 'payment_css':
                    $url = AreteX_WPI::getBasBsuEndPoint();
                    $aretex_ajax_auth = AreteX_WPI::ajaxAccessToken('master');
                    $url .= '?aretex_ajax_auth='.$aretex_ajax_auth.'&format=raw&cmd=get&resource=payment_form_style';
                    $filename = 'aretex_payment.css';                
                    $response = wp_remote_get($url);
                    if ($response['response']['code'] == 200) {
                        $content = $response['body'];                                                
                    }
                    else {
                        error_log('AreteX Payment Style: Failure'.var_export($response,true));
                        die();
                    }  
                
                break;
                case 'current_css':
                    $url = AreteX_WPI::getBasBsuEndPoint();
                    $aretex_ajax_auth = AreteX_WPI::ajaxAccessToken('master');
                    $url .= '?aretex_ajax_auth='.$aretex_ajax_auth.'&format=raw&cmd=get&resource=notify_style';
                    $filename = 'aretex_notification.css';                
                    $response = wp_remote_get($url);
                    if ($response['response']['code'] == 200) {
                        $content = $response['body'];                                                
                    }
                    else {
                        error_log('AreteX Notification Style: Failure'.var_export($response,true));
                        die();
                    }  
                
                break;
                case 'welcome_email':
                 $url = AreteX_WPI::getBasBsuEndPoint();
                    $aretex_ajax_auth = AreteX_WPI::ajaxAccessToken('master');
                    $url .= '?aretex_ajax_auth='.$aretex_ajax_auth.'&format=raw&cmd=get&resource=welcome_email';
                    $filename = 'welcome_email.html';                
                    $response = wp_remote_get($url);
                    if ($response['response']['code'] == 200) {
                        $content = $response['body'];                                                
                    }
                    else {
                        error_log('AreteX Welcome Email: Failure'.var_export($response,true));
                        die();
                    }  

                break;
             }
                              
             header('HTTP/1.1 200 OK');
             header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
             header('Date: ' . date("D M j G:i:s T Y"));
             header('Last-Modified: ' . date("D M j G:i:s T Y"));
             header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
             header("Cache-Control: private",false); // required for certain browsers 
             header("Pragma: public");        
             header('Content-type: text/plain');                        
             header("Content-Length: " . strlen($content));
             header("Content-Transfer-Encoding: Binary"); 
             header('Content-Disposition: attachment; filename="'.$filename.'"');
            
             
           
            print $content;
            
            die();
            
        }
        
        
        protected static function goLiveButton($license_info) {
           
            $biz = AreteX_WPI::getBusiness();
            if (is_object($biz)) {
                $email = base64_encode($biz->Email_Address);
                $url = get_option('aretex_authorize_endpoint');
                $url .= '/go_live?start_email='.$email;      
                return '<button class="small_license_button" onclick="window.open('."'$url'".')">Go Live</button>';
            }
        }
        
        protected static function upgradeButton($license_info) {
            $token = AreteX_WPI::ajaxAccessToken('master',true);
            $auth="&aretex_ajax_auth=$token";
            $url = get_option('aretex_authorize_endpoint');
            $url .= '/paidsandbox?license='.$license_info->license_key.$auth;
            return '<button onclick="window.open('."'$url'".')" class="small_license_button">Upgrade</button>';
        }
        
        protected static function updatePaymentButton($license_info) {
                $access_token = AreteX_WPI::ajaxAccessToken('master',true);                          
                $update_url = get_option('aretex_update_endpoint'); 
                $payment_auth = AreteX_WPI::paymentAuthToken();
                $payment_auth = urlencode($payment_auth);          
                $update_url .= '?license='.$license_info->license_key.'&aretex_ajax_auth='.$access_token.'&payment_auth='.$payment_auth;

            $click = "window.open('$update_url');";
            return '<button onclick="'.$click.'" class="small_license_button">Update Payment Method</button>';
        }
        
        public static function topPayButton($license_info) {
            $buttons = '';
            switch($license_info->license_type) {
                case 'Sandbox':
                    switch ($license_info->license_status) {
                        case 'Trial':
                            $buttons .= self::upgradeButton($license_info) . '&nbsp;&nbsp;';
                        case 'Good':
                            $buttons .= self::goLiveButton($license_info);
                        break;
                        case 'Advisory':
                            $buttons = self::updatePaymentButton($license_info) . '&nbsp;&nbsp;' . self::goLiveButton($license_info);
                        break;
                    }
                break;
                case 'Production':
                    switch ($license_info->license_status) {
                        case 'Advisory':
                            $buttons = self::updatePaymentButton($license_info) . '&nbsp;&nbsp;' . self::goLiveButton($license_info);
                        break;
                    }
                break;                                
            }
            
            return $buttons;
        }

  
        public function ajax_script() {
        ?>
            
            <script type="text/javascript" >            
            
            function ajax_have_license(){
                jQuery(function ($) {
                
                	var data = {
                		action: 'have_license',
                		whatever: 1254
                	};
                
                	// since 2.8 ajaxurl is always defined in the admin header and points to admin-ajax.php
                	$.post(ajaxurl, data, function(response) {
                		alert('Got this from the server: ' + response);
                	});
                
                });                                                
            }
            
            function features_yes_to_all(){
            jQuery(function ($) {                
            	                           
                var data = {
        		action: 'features_yes_to_all'
                
        	   };
                	
            	$.post(ajaxurl, data, function(response) {
            	   location.reload(); 
            	});
                
            
            });
            
            }
            
            function features_no_to_all(){
            jQuery(function ($) {                
            	                           
                var data = {
        		action: 'features_no_to_all'
                
        	   };
                	
            	$.post(ajaxurl, data, function(response) {
            	   location.reload(); 
            	});
                
            
            });   
        }
        
        function answer_feature(feature_name,answer){
            jQuery(function ($) {                
            	                           
                var data = {
        		action: 'answer_feature',
                feature_name: feature_name,
                answer: answer
                
        	   };
                	
            	$.post(ajaxurl, data, function(response) {
            	   location.reload(); 
            	});
                
            
            });   
        }
            
            
            </script>
            
            
        <?php
       
    }
    
    //  Credit: http://stackoverflow.com/questions/11504541/get-comments-in-a-php-file
      static protected function ParamsFromComments($filename) {
        $docComments = array_filter(token_get_all(file_get_contents($filename)), function($entry)
        {
            return $entry[0] == T_DOC_COMMENT;
        });
        $fileDocComment = array_shift($docComments);    
    
        $regexp = "/\@.*\:\s.*\r/";
        preg_match_all($regexp, $fileDocComment[1], $matches);
    
        for($i = 0; $i < sizeof($matches[0]); $i++)
        {
            $params[$i] = split(": ", $matches[0][$i]);
        }
        $parameters = array();
        foreach($params as $pair)
        {
            $key = trim($pair[0],'@ ');
            $parameters[$key] = trim($pair[1]);
        }
        
    
        return($parameters);
    }  
  
    }
    
    
    

}

// Credit: http://www.wpexplorer.com/create-widget-plugin-wordpress/
if (! class_exists('AreteXCouponWidget')) {
    class AreteXCouponWidget extends WP_Widget {
    
    	// constructor
    	public function __construct() {
    	   parent::WP_Widget(false, $name = __('AreteX Coupon', 'AreteXCouponWidget') );
    	}
    
    
    	// widget form creation
    	public function form($instance) {	
    	   
            // Check values
            if( $instance) {
                 $title = esc_attr($instance['title']);
                 $text = esc_attr($instance['text']);
                 $button_text = esc_attr($instance['button_text']);
                 $current_code = esc_attr($instance['current_code']);
            } else {
                 $title = 'Coupon Code';
                 $text = 'Enter a Coupon Code';
                 $button_text = 'Submit Code';
                 $current_code = 'Current Coupon: :tracking: - :description: - :referrer:';
            }
            ?>
            
            <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Coupon Box Title', 'AreteXCouponWidget'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
            </p>
            
            <p>
            <label for="<?php echo $this->get_field_id('text'); ?>"><?php _e('Instructions:', 'AreteXCouponWidget'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('text'); ?>" name="<?php echo $this->get_field_name('text'); ?>" type="text" value="<?php echo $text; ?>" />
            </p>
            
            <p>
            <label for="<?php echo $this->get_field_id('button_text'); ?>"><?php _e('Button Text:', 'AreteXCouponWidget'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('button_text'); ?>" name="<?php echo $this->get_field_name('button_text'); ?>" type="text" value="<?php echo $button_text; ?>" />
            </p>
            
             <p>
            <label for="<?php echo $this->get_field_id('current_code'); ?>"><?php _e('Current Coupon Text:', 'AreteXCouponWidget'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('current_code'); ?>" name="<?php echo $this->get_field_name('current_code'); ?>" type="text" value="<?php echo $current_code; ?>" /><br />
            <em>Note:</em> You may use <em>:tracking:</em>, <em>:description:</em> and <em>:referrer:</em>, just like in the aretex_coupon_info shortcode.
            </p>
            <?php

    	}
    
    	// widget update
    	public function update($new_instance, $old_instance) {
    		  $instance = $old_instance;
              // Fields
              $instance['title'] = strip_tags($new_instance['title']);
              $instance['text'] = strip_tags($new_instance['text']);
              $instance['button_text'] = strip_tags($new_instance['button_text']);
              $instance['current_code'] = strip_tags($new_instance['current_code']);
             return $instance;
    	}
    
    	// widget display
    	public function widget($args, $instance) {
    		extract( $args );
           // these are the widget options
           $title = apply_filters('widget_title', $instance['title']);
           $text = $instance['text'];
           $button_text = $instance['button_text'];
           $current_code = $instance['current_code'];
           echo $before_widget;
           // Display the widget
           echo '<div class="widget-text wp_widget_plugin_box aretex_coupon_widget">';
        
           // Check if title is set
           if ( $title ) {
              echo $before_title . $title . $after_title;
           }
        
           // Check if text is set
           if( $text ) {
              echo '<p class="wp_widget_plugin_text">'.$text.'</p>';
           }
           
           
           if(! $button_text ) {
                $button_text = 'Submit Code';
           }
           $qvar = get_option('aretex_tracking_qvar');
           $coupon = AreteX_WPI::getCurrentTrackingCode();
           $current_coupon = '';
           if ($coupon->valid)
           {
                $current_coupon = '<p class="wp_widget_plugin_text aretex_coupon_info">'.str_replace(':tracking:','<span class="aretex_tracking_text">'.$coupon->original,$current_code.'</span>').'</p>';
                $current_coupon = str_replace(':description:',$coupon->summary->description,'<span class="aretex_description_text">'. $current_coupon.'</span>' );
                $current_coupon = str_replace(':referrer:',$coupon->summary->rep,'<span class="aretex_referrer_text">'. $current_coupon.'</span>' );

           }
            $output =<<<END_COUPON_BOX2
            <form class="aretex_coupon_widget_form" method="POST">
            <input type="text" name="$qvar" />
            <input class="aretex_coupon_submit" type="submit" value="$button_text" />
            </form>
            $current_coupon
END_COUPON_BOX2;
           echo $output;
           echo '</div>';
           echo $after_widget;
            
            
    	}
    }

}




?>