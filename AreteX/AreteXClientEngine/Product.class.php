<?php

/**
 * Copyright  2009-2013 3B Alliance, LLC 
 * Subject to the Terms of 3B Alliance, LLC Derivative License.
 * Licensed for use in the AreteX Client Engine.
 **/ 

include_once('utilities.php');

abstract class PricingModel extends Enum
{
    const free_product = 'free_product';
    const single_price = 'single_price';
    const recurring_billing = 'recurring_billing';
    const update_rebill = 'update_rebill';
    const donation='donation';
   
}

class donation
{
    var $price;
    
    public function __construct() {
        $this->price = 0.00;
    }
    
    public function total($qty=1) {
        return 0.00;
    }
}

class update_rebill
{
    var $price;
    
    public function __construct() {
        $this->price = 0.00;
    }
    
    public function total($qty=1) {
        return 0.00;
    } 
    
    
}

class free_product
{
    var $price;
    
    public function __construct() {
        $this->price = 0.00;
    }
    
    public function total($qty=1) {
        return 0.00;
    }
    
}

class single_price 
{
    var $price;
    
    public function __construct($price = 0) {
        $this->price = $price;
    }
    
    public function total($qty=1)
    {
        return $this->price * $qty;
    }
    
    
}

class recurring_billing
{
    var $onetime_price;
    var $onetime_period;
    var $recurring_price;
    var $billing_cycle;
    var $max_billing_cycles;
    var $trial_period;
    var $trial_price;
    
    var $auto_invoice;
    var $auto_charge;
    
    var $grace_period;
    var $reinstatement_price;
    
  
    
    public function total($qty=1) 
    {
       

        return $this->trial_price * $qty;// Since this is total to pay now ...
    }
    
    public function offer_total($qty=1) 
    {
        $ret = clone $this;
        $ret->onetime_price   *= $qty;
        $ret->recurring_price *= $qty;
        $ret->trial_price *= $qty;

        return $ret;// Since this is total to pay now ...
    }
    
    public function __construct($price_data = null) {
        
        $fields = array('onetime_price', 'onetime_period', 'recurring_price', 'grace_period', 'reinstatement_price', 
                       'billing_cycle',  'max_billing_cycles', 'trial_period', 'trial_price',
                       'auto_invoice','auto_charge');
                       
        foreach($fields as $fld) {
            if ($price_data[$fld]) {
               $this->$fld =  $price_data[$fld];
            }
        }
              
    }
    
    
}


class Pricing
{
    var $pricing_model;
    var $offers;
    
    public function __construct()
    {
        $this->offers = array();
    }
    
    public function single_price($price,$offer_code='default')
    {
        $this->pricing_model = PricingModel::single_price;
        $this->offers[$offer_code] = new single_price($price);
        
        
    }
    
     public function update_rebill()
    {
        $this->pricing_model = PricingModel::update_rebill;
        $this->offers['default'] = new update_rebill();
    }
    
    public function recurring_billing($price_data,$offer_code='default') {
        $this->pricing_model = PricingModel::recurring_billing;
        $this->offers[$offer_code] = new recurring_billing($price_data);
        
    }
    
    
}

class Shipping
{
    var $charge_shipping;
    var $shipping_class;
    var $shipping_height;
    var $shipping_width;
    var $shipping_depth;
    var $paypal_shipping;
    var $weight_of_item;
    var $fixed_shipping;
    
    
    public function __construct() 
    {
        $this->charge_shipping = 'No';
    }
    
    
                               
                                
}

class Delivery 
{
    var $delivery_type;
    var $delivery_details;
    public function __construct()
    {
        $this->delivery_type = 'unspecified';
        $this->delivery_details = null;
    }
    
}

class ItemTax
{
    var $charge_tax;
    var $tax_categories;
   
    
    public function __construct() 
    {
        $this->charge_tax = 'No';
    }
    
   
   
}

class ProductDetails
{
    var $description;
    var $receipt_note;    
    var $pricing;
    var $shipping;
    var $tax;
    var $delivery;
    
    public function __construct() 
    {
        $this->pricing = new Pricing();
        $this->shipping = new Shipping();
        $this->tax = new ItemTax();
        $this->delivery = new Delivery();
        
    } 
    
    
}



class ProductSummary
{
    var $id;
    var $code;
    var $name;
    var $pricing;
    var $delivery;
    
    var $uri; 
}


class Product
{
    var $id;
    var $code;
    var $name;
    var $details;
    
    
    public function __construct() 
    {
        $this->details = new ProductDetails();
    }

    
    public function summary($base_uri)
    {
        $s = new ProductSummary();
        $s->id = $this->id;
        $s->code = $this->code;
        $s->name = $this->name;
        $s->pricing = $this->details->pricing;
        $s->delivery = $this->details->delivery;
        
        $s->uri = $base_uri.'/products/'.$this->id;
        
        return $s;
        
    }
    
    public function toJSON()
    {
        return json_encode($this);
    }
    
    public static function fromJSON($json_string)
    {
        $obj = json_decode($json_string);
        $obj = class_cast('Product',$obj);      
        $obj->details = class_cast('ProductDetails',$obj->details);
       
        $obj->details->pricing = class_cast('Pricing',$obj->details->pricing);
        if (is_object($obj->details->pricing->offers))
        {
            $offers = get_object_vars($obj->details->pricing->offers); 
            
                    
            $obj->details->pricing->offers =  $offers;
        }        
        if (PricingModel::isValidValue($obj->details->pricing->pricing_model))
        {            
            foreach($offers as $offer=>$pricing)
            {   

                $pricing = class_cast($obj->details->pricing->pricing_model,$pricing);
                $obj->details->pricing->offers[$offer] = $pricing;
            }
        }
        else
        {
            error_log("Invalid Pricing Model: ".var_export($obj,true));
        }
        
        $obj->details->shipping = class_cast('Shipping',$obj->details->shipping);
        $obj->details->tax = class_cast('ItemTax',$obj->details->tax);
        $obj->details->delivery = class_cast('Delivery',$obj->details->delivery);
                                    
        return $obj;
        
    }
    
    

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