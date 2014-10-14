<?php
/**
 * AreteX_WPI
 * 
 * @package AreteX For WordPress
 * @author 3B Alliance, LLC
 * @copyright 2013
 * @access public
 * 
 * AreteX WordPress Interface
 */



if ( ! class_exists( 'AreteX_WPI' ) ) {
    
    require_once(plugin_dir_path( __FILE__ ).'AreteXClientEngine/AreteXAPI.php');
    require_once(plugin_dir_path( __FILE__ ).'AreteXClientEngine/Product.class.php');
    require_once(plugin_dir_path( __FILE__ ).'AreteXClientEngine/Tracking.class.php');
    
    class AreteX_WPI{
        
        const no_cache = false;
        const use_cache = true;
        const user_id = true;
        const no_user_id = false;
        
        public static function validate_license($license_key) {
            /*
                        
            $check = substr($license_key,0,3);
            $key =  substr($license_key,3);
            $hash = strtoupper(md5($key));
            $hash = substr($hash,0,3);
            if ($hash != $check)
                return false;
            */    
            // Do a Rest Server call here to validate
            
            $license_info = self::getBasLicense();
            if (! is_object($license_info) )
                return false;
            
            
            return $license_info->license_status && $license_info->license_key == $license_key; 
            
        }
        
        protected static function rest_delete($api_url,$body,$username,$password) {
            
            $headers = array( 'Authorization' => 'Basic '.base64_encode("$username:$password") );
            
        	$req_args = array(
        		'method' => 'DELETE', 
        		'body' => $body, 
        		'headers' => $headers, 
        		'sslverify' => true  // set to true in live envrio
        	);
        
        	// make the remote request
        	$result = wp_remote_request( $api_url, $req_args);
            
            return $result;
        }
        
        protected static function rest_post($api_url,$body,$username,$password) {                                           
            $headers = array( 'Authorization' => 'Basic '.base64_encode("$username:$password") );
            
            $args = array(
                'headers' => $headers,
                'body' => $body
            );
            
            $results = wp_remote_post($api_url,$args);   
            
            return $results;
        }
        
        protected static function rest_get($api_url,$params,$username,$password) {                                           
            $headers = array( 'Authorization' => 'Basic '.base64_encode("$username:$password") );
            
            $args = array(
                'headers' => $headers
            );
            
            if (! empty($params))
            {
                $q = http_build_query($params);
                $api_url = $api_url.'?'.$q;
            }                
                
            
            $results = wp_remote_get($api_url,$args);         
            
            return $results;
        }
        
        public static function get_splash_codes() {
            
            $url = get_option('aretex_cat_endpoint');
            $url .= '/tracking/splash_codes';
            
                           
            $creds = self::makeLoginCreds();                      
            extract($creds);
          
            $response = self::rest_get($url,array(),$username,$password);
    
            if ($response['response']['code'] == 200) {
                $response = $response['body'];
                
                $response = json_decode($response,true);
                
            }
            
            return $response;
        }

        
        
        public static function get_tracking_codes($payee,$offer=null,$media=null) {
            
            $url = get_option('aretex_cat_endpoint');
            $url .= '/tracking/full_codes/'.$payee;
            if ($offer)
            {
                 $url .= '/'.$offer;
                 if ($media)
                    $url .= '/'.$media;
            }
               
            
            $creds = self::makeLoginCreds();                      
            extract($creds);
          
            $response = self::rest_get($url,array(),$username,$password);
            if ($response['response']['code'] == 200) {
                $response = $response['body'];
                
                $response = json_decode($response,true);
                
            }
            
            return $response;
        }
        
         public static function post_refund($txn,$amt) {
            $data['ip'] = self::real_ip();
            $data['amount'] = $amt;
            
            $creds = self::makeLoginCreds('master',true);                      
            extract($creds);
            
            $url = get_option('aretex_bas_endpoint');
            $url .='/api/sales/'.$txn.'/refund';
            
            $results = self::rest_post($url,$data,$username,$password);
           
           
                        
            if ($results['response']['code'] == 200) {
                $response = $results['body'];
                error_log('response:'.var_export($response,true));
                $response = json_decode($response,true);
            }
            error_log('response:'.var_export($response,true));
            return $response;
            
            
         }
         
         public static function post_manual_payment($duedate=null,$account_id=null) {
            
            $data = array();
            if (! empty($account_id))
                $data['payment_account'] = $account_id;
            
           $creds = self::makeLoginCreds('master',true);                      
           extract($creds);
            

            $url = get_option('aretex_bas_endpoint');
            $url .='/api/pcs/out/payments';
    
            if (! empty($duedate))
                 $url .= '/duedate/'.date('Y-m-d',strtotime($duedate));
            
           
            $results = self::rest_post($url,$data,$username,$password);
           
           
                        
            if ($results['response']['code'] == 200) {
                $response = $results['body'];
               // error_log('response:'.var_export($response,true));
                $response = json_decode($response,true);
            }
            
            return $response;
         }
        
        
         public static function post_commission_structure($post_data,$code=null) {
            $data['data'] = $post_data;
            
           $creds = self::makeLoginCreds('master',true);                      
           extract($creds);
            

            $url = get_option('aretex_bas_endpoint');
            $url .= '/api/bsu/commission_structure';
            if ($code)
                $url .= '/'.$code;
           
            $results = self::rest_post($url,$data,$username,$password);
           
           
                        
            if ($results['response']['code'] == 200) {
                $response = $results['body'];
               // error_log('response:'.var_export($response,true));
                $response = json_decode($response,true);
            }
            
            return $response;
         }
        
        // Credit: http://stackoverflow.com/questions/1175096/how-to-find-out-if-you-are-using-https-without-serverhttps
        public static function isSecure() {
          return
            (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off')
            || $_SERVER['SERVER_PORT'] == 443;
        }
        
        public static function check_sandbox() {
            
            if (! self::isSecure()) {
                $response['sandbox_message'] = 'You must be running your site with SSL (i.e. https) to register for the AreteX&trade; sandbox.<br/>'.
                '<p>It is an AreteX&trade; requirement that <em>all</em> communication use Transport Layer Secuirty (i.e. https, ssl).</p>'.
                '<p>Please install and use an SSL certificate for your site. If you have already installed your SSL certificate, please log out, and log back in using <strong>https:</strong> .</p>';
                
                $response['ssl'] = 'No';
                
                return $response;
            
            }
           
            
            
            $api_url = get_option('aretex_rest_endpoint');
            $api_url .= '/sandbox';
            
            $results = wp_remote_get($api_url); 
            if ($results['response']['code'] == 200) {
                $response = $results['body'];
               // error_log('response:'.var_export($response,true));
                $response = json_decode($response,true);
            }
            
            return $response;  
        }
        
        
        
        public static function getRegistrationPacket($message_id) {
            
            
            $username = get_option('aretex_api_key');
            $password = get_option('aretex_api_secret');
            $api_url = get_option('aretex_rest_endpoint');
            $api_url .= "/registration_packet/app_key/$username/access_key/$message_id";
            
           
            $results = self::rest_get($api_url,array(),$username,$password);
           
           
                        
            if ($results['response']['code'] == 200) {
                $response = $results['body'];
 
                $response = json_decode($response,true);
                $packet = trim($response);
                $start_marker = '--- BEGIN ARETEX CONFIRMATION ---';
                $end_marker = '--- END ARETEX CONFIRMATION ---';
                $start_pos = strpos($packet,$start_marker);
                if ($start_pos !== FALSE) {
                   $start_pos += strlen($start_marker);  
                }
                else {
                    return false;
                }
                
                $packet = substr($packet,$start_pos);
                $end_pos = strpos($packet,$end_marker);
                if ($end_pos !== false) {
                    $packet = substr($packet,0,$end_pos);
                }
                else
                    return false;
                
                $packet = trim($packet);
                // base64_encode(gzcompress(json_encode($message)))
                $packet = json_decode(gzuncompress(base64_decode($packet)),true);
                
                return $packet['envelope'];              
                
            }
            else {
                
                return false;
            }
            
            return false;
        }

        
        
        public static function post_new_public_key($license_key,$app_key,$new_public_key) {
            $data = $post_data;
           
            
           
            $api_url = get_option('aretex_rest_endpoint');
            $api_url .= "/new_public_key/app_key/$app_key/license_key/$license_key";
            error_log($api_url);            
            $data['new_public_key'] = $new_public_key;
                      
            $results = self::rest_post($api_url,$data,null,null); 
            error_log(var_export($results,true));                        
            if ($results['response']['code'] == 200) {
                $response = $results['body'];
               
                $response = json_decode($response,true);
              
                                                                
               return $response; 
                
                
            }
            else {
                
                return false;
            }
            
            return true;
        }

        
        
        public static function sandbox_registration($post_data) {
            $data = $post_data;
            $data['nonce'] = wp_create_nonce( 'aretex-sandbox-registration' );
            $data['callback'] = plugins_url( 'callback.php' , __FILE__ );
            $data['hash'] = get_option('aretex_hash');
            $data['ip'] = self::real_ip();
            $data['public_key'] = get_option('aretex_public_key');
            
            $username = get_option('aretex_api_key');
            $password = get_option('aretex_api_secret');
            $api_url = get_option('aretex_rest_endpoint');
            $api_url .= '/registration';
            
           
            $results = self::rest_post($api_url,$data,$username,$password);
           
           
                        
            if ($results['response']['code'] == 200) {
                $response = $results['body'];
               // error_log('response:'.var_export($response,true));
                $response = json_decode($response,true);
              //  error_log('response:'.var_export($response,true));
                                                                
                update_option('aretex_message_id',$response['message_id']);                
                update_option('aretex_central_publickey',base64_decode($response['public_key']));
                
                
            }
            else {
                
                return false;
            }
            
            return true;
        }
        
        // They encrypted registration packet contains the license key and the API Secret key,
        // (both of which are necessary to access the AreteX server)
        public static function complete_sandbox_registration($registration) {
            
                $registration = json_decode($registration,true);
               // error_log("Registration:".var_export($registration,true));
                if ($registration['subject'] == 'Sandbox Registration') {
                   // $nonce = $registration['nonce'];
                    // First Verify that this is the request we initiated;
                                  
                    $reg_packet = $registration['registration_packet'];
                    $signature = $registration['signature'];
                    // Verify that the response has come from AreteX
                    if (self::validate_message($reg_packet,$signature)) {
                        $message = self::decrypt($reg_packet,$crypt_key,$salt);
                        $message_id = get_option('aretex_message_id');
                        
                        // Is this the message we were told to expect?
                        if ($message_id == $message['message_id']) {
                            // Is the plaintext subject the same as the encryptd subject?
                           if ($message['subject'] == $registration['subject']) {
                            update_option('aretex_license_key',$message['license_key']);
                            update_option('aretex_api_secret',$message['app_secret']);
                            
                            update_option('aretex_cat_endpoint',$message['cat_endpoint']);
                            update_option('aretex_ptr_endpoint',$message['ptr_endpoint']);
                            update_option('aretex_cam_endpoint',$message['cam_endpoint']);
                            update_option('aretex_bas_endpoint',$message['bas_endpoint']);
                            update_option('aretex_pcs_in_endpoint',$message['pcs_in_endpoint']);
                            update_option('aretex_go_live_endpoint',$message['go_live_endpoint']);
                            update_option('aretex_update_endpoint',$message['update_endpoint']);
                            update_option('aretex_authorize_endpoint',$message['authorize_endpoint']);           
                                                       
                            delete_option('aretex_message_id');
                            
                            return true;
                           } 
                                                      
                        }
                       
                                                     
                    }
                   
                    
                    
                }
                
                
            
        }
        
        protected static function validate_message($reg_packet,$signature) {
            
            $public_key = get_option('aretex_central_publickey'); // Did this truly come from AreteX?
            return AreteX_API::Verify($reg_packet,$signature,$public_key);                        
        }
        
               
        
        protected static function decrypt($message) {
           // $private_key = get_option('aretex_private_key'); // Our locally generated private key
            $password = self::getEncPw();          
            $crypton = new Crypton();
            $keys = $crypton->get_keys('aretex_wp',$password);
            $private_key = $keys['privatekey'];                                           
            $decrypted = $crypton->decrypt_message($message,$private_key);
            $decrypted = unserialize($decrypted);          
            return $decrypted;
        }
        
        protected static function real_ip() {

                $onlineip = '';
                if(getenv('HTTP_CLIENT_IP') && strcasecmp(getenv('HTTP_CLIENT_IP'), 'unknown')) {
                    $onlineip = getenv('HTTP_CLIENT_IP');
                } elseif(getenv('HTTP_X_FORWARDED_FOR') && strcasecmp(getenv('HTTP_X_FORWARDED_FOR'), 'unknown')) {
                    $onlineip = getenv('HTTP_X_FORWARDED_FOR');
                } elseif(getenv('REMOTE_ADDR') && strcasecmp(getenv('REMOTE_ADDR'), 'unknown')) {
                    $onlineip = getenv('REMOTE_ADDR');
                } elseif(isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], 'unknown')) {
                    $onlineip = $_SERVER['REMOTE_ADDR'];
                }
                return $onlineip;

		}
        
        public static function jsProductSearch($dom_id) {
            $url = get_option('aretex_cat_endpoint');
            $url .= '/products';
            $license_key = get_option('aretex_license_key');
            $app_key = get_option('aretex_api_key');
            $password = self::getEncPw();
            // $private_key = get_option('aretex_private_key');
            $crypton = new Crypton();
            $keys = $crypton->get_keys('aretex_wp',$password);
            $private_key = $keys['privatekey'];
            $creds = AreteX_API::Ajax_credentials($license_key,$app_key,$private_key);            
            extract($creds);
            
            $js = "\n set_product_search('$dom_id','$url','$username','$password'); \n";
            
            return $js;
            
        }
        
        
        public static function jsPayeeSearch($dom_id) {
            $url = get_option('aretex_bas_endpoint');
            $url .= '/api/payees';
            $license_key = get_option('aretex_license_key');
            $app_key = get_option('aretex_api_key');
            $password = self::getEncPw();
            // $private_key = get_option('aretex_private_key');
            $crypton = new Crypton();
            $keys = $crypton->get_keys('aretex_wp',$password);
            $private_key = $keys['privatekey'];
            $creds = AreteX_API::Ajax_credentials($license_key,$app_key,$private_key);            
            extract($creds);
            
            $js = "\n set_payee_search('$dom_id','$url','$username','$password'); \n";
            
            return $js;
            
        }
        
        public static function jsPayeeSearchByOffer($dom_id,$offer_elem_id) {
            $url = get_option('aretex_bas_endpoint');
            $url .= '/api/payees/offer_code';
            $license_key = get_option('aretex_license_key');
            $app_key = get_option('aretex_api_key');
            $password = self::getEncPw();
            // $private_key = get_option('aretex_private_key');
            $crypton = new Crypton();
            $keys = $crypton->get_keys('aretex_wp',$password);
            $private_key = $keys['privatekey'];
            $creds = AreteX_API::Ajax_credentials($license_key,$app_key,$private_key);            
            extract($creds);
            
            $js = "\n set_offer_payee_search('$dom_id','$offer_elem_id','$url','$username','$password'); \n";
            
            return $js;
            
        }
        
        
        public static function ptrAjaxDirect() {
            $url = get_option('aretex_bas_endpoint');
            $url .= '/ptr';
                        
            return $url;                        
        }
        
         public static function camAjaxDirect() {
            $url = get_option('aretex_bas_endpoint');
            $url .= '/cam';
                        
            return $url;                        
        }
        
        
        public static function ajaxAccessToken($site=null,$user_id=false) {
            
                $creds = self::makeLoginCreds($site,$user_id);
                extract($creds);
            	$access_token = $username . ':' . $password;
                
                return urlencode($access_token);
        }
        
        protected static function makeLoginCreds($site=null,$user_id=false) {
            
            $license_key = get_option('aretex_license_key');
            $app_key = get_option('aretex_api_key');
            $password = self::getEncPw();
            $crypton = new Crypton();
            $keys = $crypton->get_keys('aretex_wp',$password);
            $private_key = $keys['privatekey'];
            $wp_user_id = null;
            if ($user_id)
                $wp_user_id= get_current_user_id();
                
            $creds = AreteX_API::Ajax_credentials($license_key,$app_key,$private_key,$site,$wp_user_id);  
            
            return $creds;
        }
        
        
        protected static function makeSensitiveLoginCreds($proxy_user_id) {
            
            if (! current_user_can('manage_options'))
                return false;
            
            $license_key = get_option('aretex_license_key');
            $app_key = get_option('aretex_api_key');
            $password = self::getEncPw();
            $crypton = new Crypton();
            $keys = $crypton->get_keys('aretex_wp',$password);
            $private_key = $keys['privatekey'];
            
            $sign_proxy = $crypton->sign($proxy_user_id,$private_key);
            $privilaged_user = $proxy_user_id.'@'.$sign_proxy;    
            $creds = AreteX_API::Ajax_credentials($license_key,$app_key,$private_key,'master',$privilaged_user);  
            
            return $creds;
        }
        
        public static function getOffers($code,$exact=false) {
            $url = get_option('aretex_cat_endpoint');
            $url .= '/tracking/offers/'.$code;
            
            $creds = self::makeLoginCreds();                      
            extract($creds);
            if ($exact)
                $data = array('exact'=>'true');
            else
                $data = array();
          
            $response = self::rest_get($url,$data,$username,$password);
            if ($response['response']['code'] == 200) {
                $response = $response['body'];
                
                $response = json_decode($response);
                
            }
            
            return $response;
        }
        
        
        public static function getProducts($code) {
            $url = get_option('aretex_cat_endpoint');
            $url .= '/products';
            
            $creds = self::makeLoginCreds();                      
            extract($creds);
          
            $response = self::rest_get($url,array('q'=>$code),$username,$password);
            
            if ($response['response']['code'] == 200) {
                $response = $response['body'];
                
                $response = json_decode($response);
                
            }
                       
            
            return $response;
        }
        
        public static function cleanCache($all=false) {
            	global $wpdb; 
                $table_name = $wpdb->prefix .'aretex_cache';
                
                if ($all)
                    $sql = "DELETE FROM $table_name";
                else
                {
                   $now = date('Y-m-d H:i:s'); 
                   $sql = "DELETE FROM $table_name WHERE expires <= '$now'";  
                }
                    
                    
                 $wpdb->query($sql);
                
        }
        
        public static function cleanCacheByKey($key) {
            global $wpdb; 
            $table_name = $wpdb->prefix .'aretex_cache';
                
          
            $sql = "DELETE FROM $table_name WHERE  hash_key = '$key'";
                    
            $wpdb->query($sql);
                
        }
        
        
        protected static function checkCache($key) {
                        
            global $wpdb;
             
            $table_name = $wpdb->prefix .'aretex_cache';
            self::cleanCache();
            
            $sql = "SELECT data FROM $table_name WHERE hash_key = '$key'";
            
            $data = $wpdb->get_var($sql);
            
          
            
            return $data;
            
        }
        
        protected static function cacheData($key,$data,$time_in_minutes=null) {
            
            global $wpdb;
             
            $table_name = $wpdb->prefix .'aretex_cache';
            self::cleanCache();
            
            $sql = "DELETE FROM $table_name WHERE hash_key = '$key'";
            $wpdb->query($sql);
            
            
            $ins['hash_key'] = $key; 
            $ins['data'] = $data;
            if ($time_in_minutes === null)           
                $ins['expires'] = date('Y-m-d H:i:s',strtotime('+4 hour'));
            else
                $ins['expires'] = date('Y-m-d H:i:s',strtotime("+$time_in_minutes minute")); 
            
            $wpdb->insert($table_name,$ins );
        
            
        }
        
        protected static function getProductDetailByURI($uri) {
            $key = md5($uri);
                                   
            $data = self::checkCache($key);
            if (! $data) {
                $creds = self::makeLoginCreds();                      
                extract($creds);
              
                $response = self::rest_get($uri,array(),$username,$password);
                if ($response['response']['code'] == 200) {
                    $data = $response['body'];
                    
                    self::cacheData($key,$data);
                                
                }
                else  {
                   // error_log("GET $uri: Response Code: ".$response['response']['code']);
                    $data = false;
                }
                                    
            }
            
            if (is_string($data)) 
                $prod = Product::fromJSON($data);
            
            return $prod;
            
        }
        
        
        public static function getPayoutCodes(){
             $url = get_option('aretex_bas_endpoint');
             $url .= '/api/payout_codes';
             
             $ret = self::getGenericResourceByURI($url,self::no_cache);
             
             return $ret;
        }
        
        
        public static function getBsuCommissionGroups($id=null){
             $url = get_option('aretex_bas_endpoint');
             $url .= '/api/bsu/commission_groups';
             
             if ($id) {
                $url .= '/'.$id.'?exact=true';
             }
             
             $ret = self::getGenericResourceByURI($url,self::no_cache);
             
             $ret = json_encode($ret);
             $ret = json_decode($ret,true);
                          
             
             return $ret;
        }
        
        public static function getBsuCommissionStructure($id) {
            // 
            
             $url = get_option('aretex_bas_endpoint');
             $url .= '/api/bsu/commission_structure/'.$id;
            // echo "<br/>$url</br>";
             $ret = self::getGenericResourceByURI($url,self::no_cache);
             
             $ret = json_encode($ret);
             $ret = json_decode($ret,true);
                          
             
             return $ret;
             
            
        }
        
        public static function deleteSplashCode($id) {
            // 
            
              $url = get_option('aretex_cat_endpoint');
              $url .= '/tracking/splash_codes/'.$id;
             
              $creds = self::makeLoginCreds('master',true);                      
              extract($creds);
             
              $data = array();
              $results = self::rest_delete($url,$data,$username,$password);
          //  error_log(var_export($results,true));
           
                        
            if ($results['response']['code'] == 200) {
                $ret = $results['body'];
                           
            }
            else {
                 
                return 'Error: '.$results['body'];
            }
                          
             
             return $ret;
             
            
        }
        
        
         public static function deleteCommissionStructure($id) {
            // 
            
             $url = get_option('aretex_bas_endpoint');
             $url .= '/api/bsu/commission_structure/'.$id;
            // echo "<br/>$url</br>";
             
              $creds = self::makeLoginCreds('master',true);                      
              extract($creds);
             
              $data = array();
              $results = self::rest_delete($url,$data,$username,$password);
          //  error_log(var_export($results,true));
           
                        
            if ($results['response']['code'] == 200) {
                $ret = $results['body'];
                           
            }
            else {
                 
                return 'Error: '.$results['body'];
            }
                          
             
             return $ret;
             
            
        }
        
         public static function deleteDeliverableAuthorization($id) {
            // 
            
             $url = get_option('aretex_bas_endpoint');
             $url .= '/api/delivery/authorizations/'.$id;
            // echo "<br/>$url</br>";
             
              $creds = self::makeLoginCreds('master',true);                      
              extract($creds);
             
              $data = array();
              $results = self::rest_delete($url,$data,$username,$password);
          //  error_log(var_export($results,true));
           
                        
            if ($results['response']['code'] == 200) {
                $ret = $results['body'];
                $ret = json_decode($ret);
                           
            }
            else {
                 
                return 'Error: '.$results['body'];
            }
                          
             
             return $ret;
             
            
        }
        
        public static function getBsuCommissionSummary() {
            // 
            
             $url = get_option('aretex_bas_endpoint');
             $url .= '/api/bsu/commission_groups/usage_summary';
            
             $ret = self::getGenericResourceByURI($url,self::no_cache);
             
             $ret = json_encode($ret);
             $ret = json_decode($ret,true);
                          
             
             return $ret;
             
            
        }
        
        public static function getBsuPaymentSchedule(){
             $url = get_option('aretex_bas_endpoint');
             $url .= '/api/bsu/payment_schedule';
             
             $ret = self::getGenericResourceByURI($url,self::no_cache);
             
             return $ret;
        }
        
        public static function getBsuConfiguration($property_name){
             $url = get_option('aretex_bas_endpoint');
             $url .= '/api/bsu/configuration/'.$property_name;
             
             $ret = self::getGenericResourceByURI($url,self::no_cache);
             
             return $ret;
        }
        
        public static function getBsuPcsOut(){
             $url = get_option('aretex_bas_endpoint');
             $url .= '/api/bsu/pcs/out';
             
             $ret = self::getGenericResourceByURI($url);
             
             return $ret;
        }
        
        public static function postBsuPcsOut($post_data){
             $url = get_option('aretex_bas_endpoint');
             $url .= '/api/bsu/pcs/out';             
             $data['data'] = json_encode($post_data);            
             $creds = self::makeLoginCreds('master',true);                      
             extract($creds);
            
            $results = self::rest_post($url,$data,$username,$password);
                                           
            if ($results['response']['code'] == 200) {
                $response = $results['body'];
                $response = json_decode($response,true);
            }
            
            return $response;                         
        }
        

        
         public static function getBasSaleDetail($sale_id){
             $url = get_option('aretex_bas_endpoint');
             $url .= '/api/sales/'.$sale_id;
             
             $ret = self::getGenericResourceByURI($url,AreteX_WPI::no_cache,false,'master');
             
             return $ret;
        }

        
        public static function getBasLicense($cache = true){
             $url = get_option('aretex_bas_endpoint');
             $url .= '/api/license';
             
             $ret = self::getGenericResourceByURI($url,$cache);
             
             return $ret;
        }
        
        public static function getTimeZone($cache = '10'){ // 10 minutes rather than four hours
             $url = get_option('aretex_bas_endpoint');
             $url .= '/api/timezone';
        

             $ret = self::getGenericResourceByURI($url,$cache);
             
             return $ret;
        }
        
        
        public static function postTimeZone($timezone){
             $url = get_option('aretex_bas_endpoint');
             $url .= '/api/timezone/'.$timezone; 
                      
             $data=array();       
             $creds = self::makeLoginCreds('master',true);                      
             extract($creds);
            
            $results = self::rest_post($url,$data,$username,$password);                                                      
            if ($results['response']['code'] == 200) {
                $response = $results['body'];
                $response = json_decode($response,true);
            }
            
            return $response;                         
        }
        
        public static function postAuthorizationUpdate($id,$data) {
            $url = get_option('aretex_bas_endpoint');
            $url .= '/api/delivery/authorizations/'.$id;
            
             $creds = self::makeLoginCreds('master',true);                      
             extract($creds);
            
            $results = self::rest_post($url,$data,$username,$password);                                                      
            if ($results['response']['code'] == 200) {
                $response = $results['body'];
                $response = json_decode($response,true);
            }
            
            return $response;                         
            
        }
        
        
        
        public static function getBasBsuEndPoint(){
             $url = get_option('aretex_bas_endpoint');
             $url .= '/bsu/index.php';
                          
             
             return $url;
        }
        
        public static function getBasAreteXPayments(){
             $url = get_option('aretex_bas_endpoint');
             $url .= '/api/aretex_payments';
             
             $ret = self::getGenericResourceByURI($url);
             
             return $ret;
        }
        
        
        public static function getSensitiveResourceByURI($uri,$cache=false,$proxy_user_id) {
       
         //  error_log("Proxy User: $proxy_user_id");
            
            if (! current_user_can('manage_options'))
                return false;
            
            $key = md5($uri);
            
            if ($cache)                       
                $data = self::checkCache($key);
            else {
                $data = false;
                self::cleanCache();
            }
                
            if (! $data) {
                $creds = self::makeSensitiveLoginCreds($proxy_user_id);                      
                extract($creds);
              
                $response = self::rest_get($uri,array(),$username,$password);
           //     error_log("Response: ".var_export($response, true));
               
                if ($response['response']['code'] == 200) {
                    $data = $response['body'];
                    
                    if ($cache)
                        self::cacheData($key,$data);
                                
                }
                else  {
             //       error_log("GET $uri: Response Code: ".$response['response']['code']);
                    $data = false;
                }                
            }
           // error_log("Data = ".var_export($data,true));                                    
            if (is_string($data))
                $obj = json_decode($data);
            else
                $obj = false;
            
         //   error_log("Returning ".var_export($obj,true));
            return $obj;
            
        }

        
        public static function getGenericResourceByURI($uri,$cache=true,$send_user_id=false,$site_id=null) {
            $key = md5($uri);
            
            if ($cache)                       
                $data = self::checkCache($key);
            else {
                $data = false;
                self::cleanCacheByKey($key);
            }
                
            if (! $data) {
                $creds = self::makeLoginCreds($site_id,$send_user_id);                      
                extract($creds);
              
                $response = self::rest_get($uri,array(),$username,$password);
                if (is_wp_error( $response ))
                {                   
                    return false;
                }
               
                if ($response['response']['code'] == 200) {
                    $data = $response['body'];

                    if ($cache){
                        if ($cache === true)
                            self::cacheData($key,$data);
                        else
                            self::cacheData($key,$data,$cache);
                    } 
                        
                                
                }
                else  {                   
                    $data = false;
                }                
            }
           // error_log("Data = ".var_export($data,true));                                    
            if (is_string($data))
                $obj = json_decode($data);
            else
                $obj = false;
            
         //   error_log("Returning ".var_export($obj,true));
            return $obj;
            
        }
        
         public static function getPayees($query) {
            
             $url = get_option('aretex_bas_endpoint');
             $url .= '/api/payees?q='.$query;
             
             $ret = self::getGenericResourceByURI($url);
             
             return $ret;
            
        }
        
        public static function getAPayee($id) {
            
             $url = get_option('aretex_bas_endpoint');
             $url .= '/api/payees/'.$id;                                   
             $ret = self::getGenericResourceByURI($url);
                       
             
             return $ret;
            
        }
        
        public static function paymentAuthToken() {
            $bas_url =  get_option('aretex_bas_endpoint');
            $license = AreteX_WPI::getBasLicense();
            $biz = AreteX_WPI::getBusiness();
            $url = $bas_url.'/api/bsu/business/payment_authorization';
            $app_key = get_option('aretex_api_key');
            $payment_auth = AreteX_WPI::getGenericResourceByURI($url,AreteX_WPI::no_cache,AreteX_WPI::user_id,'master');
            $account_id = $app_key.'@'.$payment_auth->account_identifier.'@'.$biz->Business_id.'@'.$license->license_key.'@'.time();
            $crypton = new Crypton();
            
            $keys = self::GetKeys();
            $private_key = $keys['privatekey'];                        
            $signature = $crypton->sign($account_id,$private_key);
            
            return $account_id.':'.$signature;
            
            

        }
        
        public static function getBusiness() {
            
             $url = get_option('aretex_bas_endpoint');
             $url .= '/api/bsu/business';
             
             $ret = self::getGenericResourceByURI($url);
             
             return $ret;
            
        }
        
         public static function getAllBusinessLicenses() {
            
             $url = get_option('aretex_bas_endpoint');
             $url .= '/api/bsu/business/licenses';
             
             $ret = self::getGenericResourceByURI($url);
             
             return $ret;
            
        }
        
        
        public static function getReceiptURL($id) {
            
             $url = get_option('aretex_bas_endpoint');
             $url .= '/api/sales/'.$id.'/receipt';
             
          //   error_log($url);
             $ret = self::getGenericResourceByURI($url);
         //    error_log(var_export($ret,true));
             
             return $ret;
            
        }
        
        protected static function GetKeys() {
            $password = self::getEncPw();           
            $crypton = new Crypton();
            $keys = $crypton->get_keys('aretex_wp',$password);
            
            return $keys;
        }
        
        public static function validateTrackingCode($tracking_code) {
            $url = get_option('aretex_cat_endpoint');
            $url .= '/tracking/validation/'.$tracking_code;
            
            
            $tracking_validation =  self::getGenericResourceByURI($url,false,true,'master');
            
            
            
            if ($tracking_validation->valid) {
                $public_key = get_option('aretex_central_publickey');
                list($tracking,$signature) = explode('@',$tracking_validation->validation);
                // error_log("$public_key");
                if ($signature) {
                    if (AreteX_API::Verify($tracking,$signature,$public_key)) {
                        list($tcode,$norm_code,$lkey,$summary,$ts) = explode('|',$tracking);
                      //  error_log("$tcode,$norm_code,$lkey,$ts ");
                        if ((time() - $ts) < (24*60*60) ) {
                            if($tcode == $tracking_code) {
                                $license_key = get_option('aretex_license_key');
                                if ($lkey == $license_key) {
                                    $summary = json_decode(base64_decode($summary));
                                    $tracking_validation->summary = $summary;
                                //    error_log(var_export($tracking_validation,true));
                                    return $tracking_validation;
                                }
                            }
                        }
                    }
                    else {
                        error_log("Invalid Signature");
                    }
                    
                }
                
            }
            error_log("Returning False");
            return false;
            
        }
        
    
    /*=== Rebill Detail ...
    
    stdClass::__set_state(array(
   'rebill_id' => '2',
   'start_date' => '2014-05-17 19:35:38',
   'initial_payment' => '1.00',
   'initial_period' => '1',
   'rebill_amount' => '1.00',
   'rebill_cycle' => 'daily',
   'rebill_method' => 'automatic',
   'max_billing_cycles' => '5',
   'next_bill_due' => '2014-05-22 19:35:38',
   'masked_pan' => 'XXXXXXXXXXXX0716',
   'card_type' => 'Visa',
   'status' => 'active',
   'billing_email_address' => 'david@xk29.com',
   'original_sales_record' => '/account/1/purchase_history/27',
   'original_authorize_id' => 'D27304F9476B4EE1B8227C3481ABC01D',
   'product_name' => 'Gadgets',
   'product_code' => 'GAD1',
   'original_confirmation' => 'https://aretexhome.com/AreteX/receipts/view/cf882c5f2d595780280b21433f163e2f7515a2f0/D27304F9476B4EE1B8227C3481ABC01D',
))
    
    ===*/
    
    public static function CancelRebillAgreement($rebill_id) {
        
       
         //   error_log('Canceling Rebill:'.$rebill_id);           
            $customer_id = self::customerSignedUp();
            if (ctype_digit($customer_id))
            {
                 $url = get_option('aretex_cam_endpoint');
                 $rebill_url = $url.'/account/'.$customer_id.'/rebill_agreement/'.$rebill_id;
                 
                
            }
            else
            {
                error_log("Customer ID Invalid");
                return false;
            }
                
                
           $creds = self::makeLoginCreds('master',true);                      
           extract($creds);
           $data['status'] = 'canceled';
           $data['data'] = json_encode($data); 
            
           $results = self::rest_post($rebill_url,$data,$username,$password); 
           
           return $results;   
        
    }    
    
    public static function UpdateCustomerContact($data) {
        
       
                 
            $customer_id = self::customerSignedUp();
            if (ctype_digit($customer_id))
            {
                 $url = get_option('aretex_cam_endpoint');
                 $rebill_url = $url.'/account/'.$customer_id.'/contact';                                 
            }
            else
            {
                error_log("Customer ID Invalid");
                return false;
            }
                
                
           $creds = self::makeLoginCreds('master',true);                      
           extract($creds);           
           $data['data'] = json_encode($data); 
            
           $results = self::rest_post($rebill_url,$data,$username,$password); 
           
           return $results;   
        
    }    
        
    public static function UpdatePaymentButtonCode($rebill_id) {
            
             $license_key = get_option('aretex_license_key');
             $app_key = get_option('aretex_api_key');
             $crypt_keys = self::GetKeys();
             
             
             
             $options = array();
           
            $customer_id = self::customerSignedUp();
            if (ctype_digit($customer_id))
            {
                 $url = get_option('aretex_cam_endpoint');
                 $rebill_url = $url.'/account/'.$customer_id.'/rebill_agreement/'.$rebill_id;
                 $contact_url = $url.'/account/'.$customer_id.'/contact';  
                
            }
            else
                return false;                      
    
            $obj = AreteX_WPI::getGenericResourceByURI($rebill_url,AreteX_WPI::no_cache,AreteX_WPI::user_id);
            $options['rebill_id'] = $rebill_id;
            $options['original_txn'] = $obj->original_authorize_id;
    
            $contact = AreteX_WPI::getGenericResourceByURI($contact_url,AreteX_WPI::no_cache,AreteX_WPI::user_id);
            
            $options['force_email'] = 'true';
            $options['email'] = $contact->email_address;
                
            
             if (empty($options))
                $options = null;
             
            // error_log("Product to Buy: ".var_export($product,true));
             
             global $user_login; 
             global $user_ID;
             get_currentuserinfo(); // Populate the globals ... 
             
             $product = new Product();
             $product->code = $obj->product_code;
             $product->name = $obj->product_name;
             $product->details->pricing = new Pricing();
             $product->details->pricing->update_rebill();    

             $button_code = AreteX_API::SimpleBuyNowData($product,$license_key,$app_key,$crypt_keys['privatekey'],$tracking_code,$options,$customer_id,'master',TxnType::update_payment,$user_login);
   
                                      
             
             return $button_code;
        }
        
        
        public static function getCurrentTrackingCode() {
            
            if (isset($_SESSION['aretex_tc'])) {
                    $tracking_code = $_SESSION['aretex_tc'];
             }
             else if (isset($_COOKIE['aretex_tc'])) {
                $tracking_code = $_COOKIE['aretex_tc'];
             }
             if ($tracking_code) {
                $tracking_code = self::validateTrackingCode($tracking_code);
                if (! $tracking_code->valid)
                    $tracking_code = false;
             }
             return $tracking_code;
        }
        
        public static function BuyNowButtonCode($product) {
            
             
             $license_key = get_option('aretex_license_key');
             $app_key = get_option('aretex_api_key');
             $crypt_keys = self::GetKeys();
             
             if (isset($_SESSION['aretex_tc'])) {
                    $tracking_code = $_SESSION['aretex_tc'];
             }
             else if (isset($_COOKIE['aretex_tc'])) {
                $tracking_code = $_COOKIE['aretex_tc'];
             }
             if ($tracking_code) {
                $tracking_code = self::validateTrackingCode($tracking_code);
                if (! $tracking_code->valid)
                    $tracking_code = false;
             }
             
             $options = array();
           
             if (is_array($product->details->delivery->deliverables)) {
                foreach($product->details->delivery->deliverables as $deliverable) {
                 //   error_log("Deliverable: ".var_export($deliverable,true));
                    $delivery_type = $deliverable->delivery_type;
                    if ($delivery_type == 'unspecified')
                        continue;
                    $descriptor = $deliverable->type_details->descriptor;
                  //  error_log("Delivery Type: $delivery_type - Descriptor: $descriptor");
                    if ((! empty($delivery_type)) && (! empty($descriptor))) {
                        global $wpdb;
                        
                       $table_name = $wpdb->prefix .'aretex_deliverable_options';
                       $sql = "SELECT feature_class FROM $table_name WHERE deliverable_type='$delivery_type' AND deliverable_descriptor='$descriptor' ";
                       $rows = $wpdb->get_results($sql,ARRAY_A);
                 //      error_log("Rows".var_export($rows,true));
                       if (! empty($rows[0]['feature_class'])) {
                            $class = $rows[0]['feature_class'];
                           if (method_exists($class,'BuildOptions')) {
                              $del_opts = $class::BuildOptions();
                              if (is_array($del_opts)) {
                                  $options = array_merge($options,$del_opts);
                              }
                           }
                       }
                       
                    }
                    
                }
             }
             
             if (empty($options['force_email'])) {
                $options['force_email'] = 'true';
            } 
            
            if (empty($options['email'])) {
                 $customer_id = self::customerSignedUp();
                 if ($customer_id && ctype_digit($customer_id)) {
                     $url = get_option('aretex_cam_endpoint');                     
                     $contact_url = $url.'/account/'.$customer_id.'/contact'; 
                     $contact = AreteX_WPI::getGenericResourceByURI($contact_url,AreteX_WPI::use_cache,AreteX_WPI::user_id);
                     $options['email'] = $contact->email_address;
                 }
                 else {
                    global $user_email;
                    get_currentuserinfo();
                    $options['email'] = $user_email;
                 }                                           
            }   
            
             if (empty($options))
                $options = null;
             
            // error_log("Product to Buy: ".var_export($product,true));
             
             global $user_login; 
             global $user_ID;
             get_currentuserinfo(); // Populate the globals ... 
             
                
             if ($product->details->pricing->pricing_model == PricingModel::single_price  )
                $button_code = AreteX_API::SimpleBuyNowData($product,$license_key,$app_key,$crypt_keys['privatekey'],$tracking_code,$options,0,'master',null,$user_login);
             else if ($product->details->pricing->pricing_model == PricingModel::donation)
                 $button_code = AreteX_API::SimpleBuyNowData($product,$license_key,$app_key,$crypt_keys['privatekey'],$tracking_code,$options,0,'master',TxnType::donation,$user_login);
             else if ($product->details->pricing->pricing_model == PricingModel::recurring_billing)
                 $button_code = AreteX_API::SimpleBuyNowData($product,$license_key,$app_key,$crypt_keys['privatekey'],$tracking_code,$options,0,'master',TxnType::autopay_subscription,$user_login);
   
             
             
             $customer_id = get_user_meta($user_ID, 'atx_customer_id', true);
             if (! $customer_id)
             {
                update_user_meta( $user_ID, 'atx_customer_id', 'Pending'); 
                // Ask AreteX for Customer Data Next Time User Logs in

             }
             
             /*
 
             */
             
             return $button_code;
        }
        
        public static function customerSignedUp($site_id='master') {
            
             if (! get_option('aretex_core_path')) {
                return false;
             }
			
			 $license_key = get_option('aretex_license_key');
			 if (empty($license_key))
				return false;
			 if (! self::validate_license($license_key)) {
				return false;
			 }
				
             global $user_login; 
             global $user_ID;
             global $user_email;
             get_currentuserinfo(); // Populate the globals ... 
            
            $customer_id = get_user_meta($user_ID, 'atx_customer_id', true);
            if (! $customer_id){
                
                $app_key = get_option('aretex_api_key');
                $base_url = get_option('aretex_bas_endpoint');
                $url = $base_url .'/api/sales/customer_account/'.$user_email;
                 //error_log("Using URL: $url");
                $res = self::getGenericResourceByURI($url, self::no_cache);
                if ($res->customer_id)
                {
                    update_user_meta($user_ID,'atx_customer_id',$res->customer_id);
                    
                    return $res->customer_id;
                    
                }
                
     
                return false;
            }
           
            if ($customer_id == 'Pending')
            {
                $app_key = get_option('aretex_api_key');
                $url = get_option('aretex_cam_endpoint');
                
                $user_login = urlencode($user_login);
                $url .= '/linked_account/'.$app_key.'/'.$site_id.'/'.$user_login;                          
                $ret = self::getGenericResourceByURI($url, self::no_cache);
                
                if ($ret)
                    update_user_meta($user_ID,'atx_customer_id',$ret);
                
            }
            else
                $ret = $customer_id;
                
             
            return $ret;
        }
        
        
        
         public static function SingleProductButtonCode($product,$txn_type=TxnType::sale,$chosen_options=array()) {
            

             $license_key = get_option('aretex_license_key');
             $app_key = get_option('aretex_api_key');
             $crypt_keys = self::GetKeys();
             
             if (isset($_SESSION['aretex_tc'])) {
                    $tracking_code = $_SESSION['aretex_tc'];
             }
             else if (isset($_COOKIE['aretex_tc'])) {
                $tracking_code = $_SESSION['aretex_tc'];
             }
             if ($tracking_code) {
                $tracking_code = self::validateTrackingCode($tracking_code);
                if (! $tracking_code->valid)
                    $tracking_code = false;
             }
             
             $options = $chosen_options;

             if (is_array($product->details->delivery->deliverables)) {
                foreach($product->details->delivery->deliverables as $deliverable) {
                //    error_log("Deliverable: ".var_export($deliverable,true));
                    $delivery_type = $deliverable->delivery_type;
                    $descriptor = $deliverable->type_details->descriptor;
                //    error_log("Delivery Type: $delivery_type - Descriptor: $descriptor");
                    if ((! empty($delivery_type)) && (! empty($descriptor))) {
                        global $wpdb;
                        
                       $table_name = $wpdb->prefix .'aretex_deliverable_options';
                       $sql = "SELECT feature_class FROM $table_name WHERE deliverable_type='$delivery_type' AND deliverable_descriptor='$descriptor' ";
                       $rows = $wpdb->get_results($sql,ARRAY_A);
                //       error_log("Rows".var_export($rows,true));
                       if (! empty($rows[0]['feature_class'])) {
                            $class = $rows[0]['feature_class'];
                           if (method_exists($class,'BuildOptions')) {
                              $del_opts = $class::BuildOptions();
                              if (is_array($del_opts)) {
                                  $options = array_merge($options,$del_opts);
                              }
                           }
                       }
                       
                    }
                    
                }
             }
             
            
             
            
            
            if (empty($options['force_email'])) {
                $options['force_email'] = 'true';
            } 
            
            if (empty($options['email'])) {
                 $customer_id = self::customerSignedUp();
                 if ($customer_id && ctype_digit($customer_id)) {
                     $url = get_option('aretex_cam_endpoint');                     
                     $contact_url = $url.'/account/'.$customer_id.'/contact'; 
                     $contact = AreteX_WPI::getGenericResourceByURI($contact_url,AreteX_WPI::use_cache,AreteX_WPI::user_id);
                     $options['email'] = $contact->email_address;
                 }
                 else {
                    global $user_email;
                    get_currentuserinfo();
                    $options['email'] = $user_email;
                 }                                           
            }
            
            
             if (empty($options))
                $options = null;
             $button_code = AreteX_API::SimpleBuyNowData($product,$license_key,
                              $app_key,$crypt_keys['privatekey'],$tracking_code,$options,0,'master',$txn_type);
             
             return $button_code;
        }

        
        
        
        public static function getProductDetailByCode($code) {
            $url = get_option('aretex_cat_endpoint');
            $url .= '/products/'.$code;
            
            $prod = self::getProductDetailByURI($url);
            
            if ($prod->id && ctype_digit($prod->id))
                return $prod;
            else
                return null; 
        }
        
        
        
        public static function createProduct($post_data) {
            
          //  error_log("createProduct: Post Data".var_export($post_data,true));
         //   error_log("Post Data Pricing Model:".$post_data['pricing_model']);
                
            if ((! $post_data['pricing_model']) || 
                (  $post_data['pricing_model'] == PricingModel::single_price)) {
                if ($post_data['price'] &&
                     is_numeric($post_data['price'])) {                    
                        $pricing = new single_price($post_data['price']); 
                        $pricing_model = PricingModel::single_price;
                     
                }
            }
            else if ($post_data['pricing_model']) {
                $pricing_model =  $post_data['pricing_model'];
             //   error_log("Constructing $pricing_model with ".var_export($post_data['price'],true));
                $pricing = new $pricing_model($post_data['price']);
                
            }
            else
                return "No Pricing Model";
                
            if (! $post_data['code'])
                return "No Product Code";
            
            if (! $post_data['name'])
                return "No Product Name";
             
            $pricing_data = new Pricing();
            $pricing_data->pricing_model = $pricing_model;
            $pricing_data->offers['default'] = $pricing;    
            
            $product = new Product();
            $product->name = $post_data['name'];
            $product->code = $post_data['code'];
            $product->details->pricing = $pricing_data;
            // Will add delivery, tax, etc. later
            
          //  error_log("Product ... ".var_export($product,true));
            
            $url = get_option('aretex_cat_endpoint');
            $url .= '/products';
            $data['data'] = $product->toJSON();
            $creds = self::makeLoginCreds('master');                      
            extract($creds);
            
            
            $results = self::rest_post($url,$data,$username,$password);
          //  error_log(var_export($results,true));
           
                        
            if ($results['response']['code'] == 200) {
                $response = $results['body'];
                $response = json_decode($response);
                $prod = class_cast('ProductSummary',$response);
                
            //     error_log("Returning: ".var_export($prod,true));              
              
                return $prod;                 
            }
            else {
                 
                return 'Error: '.$results['body'];
            }
            
            
            
        }
        
        

        
        public static function saveSiteInfo($site_data,$site_id='master') {
            
            $app_key = get_option('aretex_api_key');
            $data['data'] = json_encode($site_data);
            $url = get_option('aretex_bas_endpoint');
            $url .= '/api/bsu/'.$app_key.'/site_url/'.$site_id;
            
            $creds = self::makeLoginCreds($site_id);                      
            extract($creds);
            
            
            $results = self::rest_post($url,$data,$username,$password);
          //   error_log(var_export($results,true));
           
                        
            if ($results['response']['code'] == 200) {
                self::cleanCache(true);
                $response = $results['body'];
                $response = json_decode($response);
                               
              //   error_log("Returning: ".var_export($response,true));              
              
                return $response;                 
            }
            else {
                 
              //   error_log("Returning: Error:".var_export($results['body'],true));  
                return 'Error: '.$results['body'];
            }
            
                 
             
        }
        
        
        
        
        public static function saveBsuBusiness($post_data) {
            
            $data['data'] = json_encode($post_data);
            $url = get_option('aretex_bas_endpoint');
            $url .= '/api/bsu/business';
            
             $creds = self::makeLoginCreds('master');                      
            extract($creds);
            
            
            $results = self::rest_post($url,$data,$username,$password);
            // error_log(var_export($results,true));
           
                        
            if ($results['response']['code'] == 200) {
                self::cleanCache(true);
                $response = $results['body'];
                $response = json_decode($response);
                               
              //   error_log("Returning: ".var_export($response,true));              
              
                return $response;                 
            }
            else {
                 
              //   error_log("Returning: Error:".var_export($results['body'],true));  
                return 'Error: '.$results['body'];
            }
            
                 
             
        }

        
        
        public static function savePaySched($post_data) {
            
            $data['data'] = json_encode($post_data);
            $url = get_option('aretex_bas_endpoint');
            $url .= '/api/bsu/payment_schedule';
            
             $creds = self::makeLoginCreds('master');                      
            extract($creds);
            
            
            $results = self::rest_post($url,$data,$username,$password);
            // error_log(var_export($results,true));
           
                        
            if ($results['response']['code'] == 200) {
                self::cleanCache(true);
                $response = $results['body'];
                $response = json_decode($response);
                               
              //   error_log("Returning: ".var_export($response,true));              
              
                return $response;                 
            }
            else {
                 
              //   error_log("Returning: Error:".var_export($results['body'],true));  
                return 'Error: '.$results['body'];
            }
            
                 
             
        }
        
        public static function getAllOffers() {
            $url = get_option('aretex_cat_endpoint');
            $url .= '/tracking/offers';
            
            $ret = self::getGenericResourceByURI($url, self::no_cache,true);
            
            return $ret;
            
        }
        
        public static function getAllSourceMedia() {
            $url = get_option('aretex_cat_endpoint');
            $url .= '/tracking/source_media';
            
            $ret = self::getGenericResourceByURI($url, self::no_cache,true);
            
            return $ret;
            
        }
        
        public static function createMediaCode($post_data) {
            
          //  error_log("Post Data: ".var_export($post_data,true));    
            
            $url = get_option('aretex_cat_endpoint');
            $url .= '/tracking/source_media';
            $data['data'] = json_encode($post_data);
            $creds = self::makeLoginCreds('master');                      
            extract($creds);
            
            
         //   error_log("URL: ".var_export($url,true));  
            $results = self::rest_post($url,$data,$username,$password);
             
           
                        
            if ($results['response']['code'] == 200) {
                $response = $results['body'];
                $response = json_decode($response);
                               
              //   error_log("Returning: ".var_export($response,true));              
              
                return $response;                 
            }
            else {
                 
              //   error_log("Returning: Error:".var_export($results['body'],true));  
                return 'Error: '.$results['body'];
            }
            
                
            
            
        }
        
        
        public static function createSplashCode($post_data) {
            
          //  error_log("Post Data: ".var_export($post_data,true));    
            
            $url = get_option('aretex_cat_endpoint');
            $url .= '/tracking/splash_code';
            $data['data'] = json_encode($post_data);
            $creds = self::makeLoginCreds('master');                      
            extract($creds);
            
            
         //   error_log("URL: ".var_export($url,true));  
            $results = self::rest_post($url,$data,$username,$password);
             error_log(var_export($results,true));
           
                        
            if ($results['response']['code'] == 200) {
                $response = $results['body'];
                $response = json_decode($response);
                               
              //   error_log("Returning: ".var_export($response,true));              
              
                return $response;                 
            }
            else {
                 
              //   error_log("Returning: Error:".var_export($results['body'],true));  
                return 'Error: '.$results['body'];
            }
            
                
            
            
        }
        
        
        public static function createOffer($post_data) {
            $tracking = new TrackingOffer();
            $tracking->offer_code = $post_data['offer_code'];
            $tracking->description = $post_data['description'];
            if (is_array($post_data['limits']))
            {
                foreach($post_data['limits'] as $limit)
                {
                    if ($limit == LimitType::expires)
                    {
                        $tracking->expiration = $post_data['exp_date'];                        
                    }
                }
            }
            if (OfferType::isValidValue($post_data['offer_type']))
                $tracking->offer_type = $post_data['offer_type'];
            if ($tracking->offer_type == OfferType::percent_discount)
                $tracking->discount_amount = $post_data['pct_off'];
                
            
            $url = get_option('aretex_cat_endpoint');
            $url .= '/tracking/offers';
            $data['data'] = json_encode($tracking);
            $creds = self::makeLoginCreds('master');                      
            extract($creds);
            
            
            $results = self::rest_post($url,$data,$username,$password);
         //    error_log(var_export($results,true));
           
                        
            if ($results['response']['code'] == 200) {
                $response = $results['body'];
                $response = json_decode($response);
                               
              //   error_log("Returning: ".var_export($response,true));              
              
                return $response;                 
            }
            else {
                 
              //   error_log("Returning: Error:".var_export($results['body'],true));  
                return 'Error: '.$results['body'];
            }
            
                
            
            
        }
        
        protected static function getEncPw() {
            
            $protect_file = plugin_dir_path( __FILE__ ) . 'protect.ini.php';
            if (file_exists($protect_file))
            {
                $protect = parse_ini_file($protect_file);
                $password = $protect['bflat'];                
            }
            if (! $password)
                    $password = get_option('aretex_hash'); 
                    
            return $password;
                
        }
        
        public static function payeeSignedUp($user_id) {
            
            $ret = false;
           $payee_account_id = get_user_meta($user_id,'atx_payee_account_id',true); // The numeric id is cannonical          
            $payee_email = get_user_meta($user_id, 'atx_payee_email', true); // The email is the natural key
            if ($payee_account_id) {
                $url = get_option('aretex_ptr_endpoint');
                $url .= '/sign_up/'.$payee_account_id;                
            } 
            else if ($payee_email) { // If we do not yet know the cannaonical key, use the email address
                $url = get_option('aretex_ptr_endpoint');
                $url .= '/sign_up/'.$payee_email;
                                                                             
            }
            else 
                return false;
            
            $ret = self::getGenericResourceByURI($url, self::no_cache);
            
            if (! $payee_account_id ) { // Sync the cannonical key with the natural key
                if (isset($ret->id) && ctype_digit($ret->id)) {
                    update_user_meta($user_id,'atx_payee_account_id',$ret->id);
                }                
            }
            if (isset($ret->contact_email) && filter_var($ret->contact_email, FILTER_VALIDATE_EMAIL)) {
                if ($ret->contact_email != $payee_email) {
                        update_user_meta($user_id,'atx_payee_email',$ret->contact_email);
                } 
            }
            
            return $ret;
        }
        
        public static function payeeAccountInfo($account_id) {
            
            $ret = false;

            //echo "<br/> $payee_email";
          
                $url = get_option('aretex_ptr_endpoint');
                $url .= '/account/'.$account_id;
                               
                $ret = self::getGenericResourceByURI($url, self::no_cache,true);
                               
            
            return $ret;
        }
        
        public static function payeePaymentAccount($account_id) {
            
            $ret = false;

            //echo "<br/> $payee_email";
          
                $url = get_option('aretex_ptr_endpoint');
                $url .= '/account/'.$account_id.'/payment_account';
                
             //   echo "<br/>URL: $url<br/>"; 
                $ret = self::getGenericResourceByURI($url, self::no_cache,true);
                               
            
            return $ret;
        }
        
        
        public static function getPayeePaymentOptions($account_id) {
            
            $ret = false;

            //echo "<br/> $payee_email";
          
                $url = get_option('aretex_ptr_endpoint');
                $url .= '/options';
                
              //   echo "<br/>URL: $url<br/>"; 
              //  self::cleanCache(true);  
                
                $ret = self::getGenericResourceByURI($url, self::use_cache ,true);
                               
            
            return $ret;
        }
        
        public static function signUpPayee($send) {
            
           // error_log("Start Sign Up Payee");
            $ret = false;
           
            $url = get_option('aretex_ptr_endpoint');
            $url .= '/sign_up';
            
            $data = array();
            $to_send = array();
            foreach($send as $key=>$value)
            {
                $key = trim($key,'_');
                $to_send[$key] = $value;
            }
            $data['data'] = json_encode($to_send);
            
            $creds = self::makeLoginCreds('master');                      
            extract($creds);
                        
            $results = self::rest_post($url,$data,$username,$password);
           //  error_log(var_export($results,true));
           
                        
            if ($results['response']['code'] == 200) {
                $response = $results['body'];
                $response = json_decode($response);
                               
           //      error_log("Returning: ".var_export($response,true));              
              
                return $response;                 
            }
            else {
                 
             //   error_log("Returning: Error:".var_export($results['body'],true));  
                return 'Error: '.$results['body'];
            }
                
               
            
        }
        
        function send_admin_ptr_pdf($account_id,$wp_id) {
            
            $url = get_option('aretex_ptr_endpoint');
            $url .= '/account/'.$account_id.'/payment_account'; 
            
        //    error_log($url);
            $obj = self::getSensitiveResourceByURI($url,false,$wp_id);
            
            $payment_account = get_object_vars($obj); 
            // We'll be outputting a PDF
        
             header('HTTP/1.1 200 OK');
             header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
             header('Date: ' . date("D M j G:i:s T Y"));
             header('Last-Modified: ' . date("D M j G:i:s T Y"));
             header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
             header("Cache-Control: private",false); // required for certain browsers 
             header("Pragma: public");        
             header('Content-type: application/pdf');
             $pdf = $payment_account['authorization_vars']->authorization_snapshot;
             $pdf = base64_decode($pdf);
           
             header("Content-Length: " . strlen($pdf));
             header("Content-Transfer-Encoding: Binary"); // add
             header('Content-Disposition: attachment; filename="authorization.pdf"');
            
            
           
            print $pdf;
            
        }
        
        function send_ptr_pdf($account_id)
        {
            
            $url = get_option('aretex_ptr_endpoint');
            $url .= '/account/'.$account_id.'/payment_account'; 
          //  error_log('URL ..'.$url);               
            $obj = self::getGenericResourceByURI($url,AreteX_WPI::no_cache,AreteX_WPI::user_id);
            
         //   error_log("Got...".var_export($obj,true));
                        
            $payment_account = get_object_vars($obj); 
            // We'll be outputting a PDF
        
             header('HTTP/1.1 200 OK');
             header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
             header('Date: ' . date("D M j G:i:s T Y"));
             header('Last-Modified: ' . date("D M j G:i:s T Y"));
             header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
             header("Cache-Control: private",false); // required for certain browsers 
             header("Pragma: public");        
             header('Content-type: application/pdf');
             $pdf = $payment_account['authorization_vars']->authorization_snapshot;
             $pdf = base64_decode($pdf);
           
             header("Content-Length: " . strlen($pdf));
             header("Content-Transfer-Encoding: Binary"); // add
             header('Content-Disposition: attachment; filename="authorization.pdf"');
            
            
           
            print $pdf;
            
        }
        
        
    }
    
}
?>