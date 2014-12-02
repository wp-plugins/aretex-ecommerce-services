<?php
/**
 * Copyright  2009-2013 3B Alliance, LLC 
 * Subject to the Terms of 3B Alliance, LLC Derivative License.
 * Licensed for use in the AreteX Client Engine.
 *  
 **/
 
require_once('Product.class.php');

class AssignedPricing
{
    var $pricing_model;
    var $assigned_offer;
    var $item_pay_now;
    var $item_tax;
    
   public function __construct($qty=1,$pricing=null,$offer='default')
   {
        $this->pricing_model =  $pricing->pricing_model;
        if (is_object($pricing->offers[$offer]))
            $this->assigned_offer = $pricing->offers[$offer];
        else
            $this->assigned_offer = $pricing->offers['default'];
        
        if ($this->pricing_model == 'recurring_billing')
            $this->assigned_offer = $this->assigned_offer->offer_total($qty);
            
        if (is_object($this->assigned_offer))
            $this->item_pay_now = $this->assigned_offer->total($qty);
            
        $this->item_tax = 0;
   }
   
   public function compute_tax($parent_item,$tax_option = null) {
        if ($tax_option) {
            $rate = $tax_option->compute_rate($parent_item);
            $this->item_tax = $rate * $this->item_pay_now;
        }
    
   }
    
    
}

class Item 
{
    var $qty;
    var $code;
    var $name;
    var $options;
    var $pricing;
    var $terms;
    var $item_offer;
    
    public function __construct($qty=1,$product=null,$options=null,$offer='default')
    {
        $this->qty=$qty;
        if (is_object($product))
        {
            $this->code = $product->code;
            $this->name = $product->name;
            $this->options = $options;
            $this->item_offer = $offer;
            $this->pricing = new AssignedPricing($qty,$product->details->pricing,$this->item_offer);
           
        }
    }
    
    
}

class LocalItem extends Item {
    var $product;
    public function __construct($qty=1,$product=null,$options=null,$offer='default') {
        $this->product = $product;
        parent::__construct($qty,$product,$options,$offer);
    }
    
    public function refreshPrice($offer='default') {
       $this->item_offer = $offer; 
       $this->pricing = new AssignedPricing($this->qty,$this->product->details->pricing,$this->item_offer); 
    }
    
}

class CartIdenityValidation
{
    var $license_key;
    var $app_key;
    var $timestamp;
    var $site_id;
    var $customer_id;
    var $checkout_id;
    var $linked_id;
    
       
   public function __construct($license_key=null,$app_key=null,$site_id='master',$customer_id=0,$checkout_id=false,$linked_id=false)
   {
        $this->license_key = $license_key;
        $this->app_key = $app_key;
        $this->timestamp = time();
        $this->site_id = $site_id;
        $this->customer_id = $customer_id;
        $this->linked_id = $linked_id;
        if ($checkout_id)
            $this->checkout_id = $checkout_id;
        else
        {
            $prefix = substr(md5($this->site_id),0,4);
            $this->checkout_id = strtoupper(uniqid($prefix.':'));
        }
             
        
   }
        
}

class SignedCartIdenityValidation 
{
    var $cartIdentity; // B64 Encoded JSON String
    var $signature; //  $this->$cartIdentity signed with RSA PRivate Key that madches site id - B64 
}

abstract class SummaryPageType extends Enum
{
    const skip_to_cc = 'skip_to_cc'; // Or Token
    const show_summary_fixed = 'show_summary_fixed';
    const show_summary_editable = 'show_summary_editable';    
    const skip_to_eCheck = 'skip_to_eCheck';
    const skip_to_paypal = 'skip_to_paypal';
   
}


abstract class TxnType extends Enum
{
    const sale = 'sale';
    const prepaid_subscription = 'prepaid_subscription';
    const make_payment = 'make_payment';
    const autopay_subscription = 'autopay_subscription';
    const make_an_offer = 'make_an_offer';
    const group_buy_offer = 'group_buy_offer';
    const update_payment = 'update_payment';
    const authorize = 'authorize';
    const on_demand_approval = 'on_demand_approval';
    const increase_offer = 'increase_offer';
    const add_feature_express = 'add_feature_express';
    const add_feature_separate = 'add_feature_separate';
    const donation = 'donation';
   
}

class Cart 
{
    var $txn_type;
    var $items;
    var $summary_page;
    var $tracking_code;
    var $tracking_code_signature;
    var $item_total;
    var $total_tax;
    var $total_shipping;
    var $total_due;
    var $order_number;   
    
    public function __construct()
    {
        $this->items = array();
    }
    
    public function addProduct($product,$qty=1,$options=null,$tracking_code=null)
    {        
        // Assumes tracking code has been validated ...
        // Validation will be checked on AreteX Server
        $tracking_code = $this->tracking_code; // Adding per Item Tracking Later ... 
        $offer = 'default';
        if (is_string($tracking_code))
        {
            $dash = strpos($tracking_code,'-');
            $offer = substr($tracking_code,0,$dash);                               
        }
        $item = new Item($qty,$product,$options,$offer);
        
        $this->items[] = $item;
    }
    
    public function totalOrder($shipping_option = null,$tax_option=null)
    {
        $this->item_total = 0.00;
        foreach($this->items as $item)
            $this->item_total += $item->pricing->item_pay_now;
        
        $this->total_tax = 0.00;    
        foreach($this->items as $item) {
            if ($tax_option) {
                $item->compute_tax($item,$tax_option);
            }
            
            $this->total_tax += $item->pricing->item_tax;
        }
            
        $this->total_shipping = 0.00; 
        if (is_object($shipping_option))
            $this->total_shipping = $shipping_option->calculate_shipping($this);
            
        $this->total_due = $this->item_total +
                           $this->total_tax +
                           $this->total_shipping;                                                         
        
    }
    
    
}

class Checkout 
{
    var $identity_validation; // Base 64 Encoded 
    var $cart; // B64 Encoded JSON
    var $checkout_validation;
    
}

 /**
 *  3B Alliance, LLC Derivative License
 *  This license applies to code created for a third party derived 
 *  from code created by 3B Alliance, LLC.
 * 
 * Programmers may derive code from this licensed code, subject to the terms of the license.
 *  
 * Explicit permission is granted to create derivative code from this licensed code for the sole purpose 
 * of accessing or otherwise using a licensed AreteX(tm) service (or related services). 
 * 
 * Copyright notices, credits and restrictions must remain intact.
 * 
 * Derivative License Terms:
 * - If this code is not derived from any open source code, the following terms apply.  
 *    - No derivative code may be created without explicit permission/license of 3B Alliance, LLC.
 *    - 3B Alliance reserves the right to use any code derived from this 3B Allinace Derivative Licensed 
 *      code without restriction by the Copyright Holder.  
 *    - No portion of code provided under 3B Alliance Derivative License may be copied, 
 *      ported or otherwise used without explicit permission of 3B Alliance, LLC.
 * 
 * - If this code is also dependent upon open source code, all license terms are subordinate 
 *   to the most restrictive, derivative interpretation of the open source license of the 
 *   original code.  If there are multiple open source licenses applied to the orignal code, 
 *   3B Alliance is presumed to have chosen the license that is most compatible with these 
 *   restrictions for derivative code.
 *  
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, 
 * INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE 
 * AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, 
 * DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, 
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
 */
 /**
 _____
|A ^  |
| / \ |
| \ / | AreteX(tm) Client Engine (c) 2013 - 3B Alliance, LLC ;)
|  .  |
|____V|
 
 IXR K<3
 
  * */


?>