<?php

require_once('Crypton/Crypton.php');
require_once('Checkout.class.php');
require_once('Product.class.php');

class AreteX_API
{
    public static function ClientKeys()
    {
        $rsa = new Crypt_RSA();
        $keys = $rsa->createKey();
        
        return $keys;
    }
    
    
    public static function Verify($message,$b64_sig,$public_key) 
    {
       $crypton = new Crypton();
       
       return $crypton->verify($message,$b64_sig,$public_key);
        
    }
    
    public static function Sign($message,$private_key) 
    {
       $crypton = new Crypton();
       
       return $crypton->sign($message,$private_key);
        
    }
    
    public static function Ajax_credentials($license,$app_key,$private_key,$site=null,$logged_in_user=false)
    {
        $username=$license.'@'.$app_key.'@'.time();
        if ($site)
            $username .= "@$site";
        
        if ($logged_in_user)
        {
            if (!$site)
                $username .= '@';
            $username .= "@$logged_in_user";
        }
            
        
        $password = self::Sign($username,$private_key);
        
        $creds['username'] = $username;
        $creds['password'] = $password;
        
        return $creds;
        
    }
    
    public static function SimpleBuyNowData($product,$license,$app_key,$private_key,$tracking=null,$options=null,$cust_id = 0,$site='master',$txn_type=null,$linked_id=null) {
        
      //  error_log("Private Key".var_export($private_key,true));
        $idv = new CartIdenityValidation($license,$app_key,$site,$cust_id,false,$linked_id); 
                 // Yes, Idenity is misspelled ... I'll get to it.
        $signed_idv = new SignedCartIdenityValidation();
        $signed_idv->cartIdentity = base64_encode(json_encode($idv));
        $signed_idv->signature = self::Sign($signed_idv->cartIdentity, $private_key );
        
        $cart = new Cart();
        if ($tracking->valid) {
            $cart->tracking_code = $tracking->standard;
            $cart->tracking_code_signature = $tracking->validation;
        }
        else {
            $cart->tracking_code = null;
            $cart->tracking_code_signature = null;
        }
        
        if (empty($txn_type))
            $cart->txn_type = TxnType::sale;
        else
            $cart->txn_type = $txn_type;
       
        $cart->addProduct($product,1,$options, $cart->tracking_code);
        $cart->summary_page = SummaryPageType::skip_to_cc;
        $cart->totalOrder();
        
        $checkout = new Checkout();
        $checkout->identity_validation = base64_encode(json_encode($signed_idv));
  //      error_log("Cart:".var_export($cart,true));
        $checkout->cart = base64_encode(json_encode($cart));
        $message = $checkout->identity_validation.$checkout->cart;
       // $json_cart = json_encode($cart);
        $checkout->checkout_validation = self::Sign($message ,$private_key);
        
    //    error_log("Checkout".var_export($checkout,true));
        
        return json_encode($checkout);
   
    }
    
    
}


?>