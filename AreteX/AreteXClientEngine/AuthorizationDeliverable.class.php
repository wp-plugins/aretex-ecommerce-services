<?php

/**
 * Copyright  2009-2013 3B Alliance, LLC 
 * Subject to the Terms of 3B Alliance, LLC Derivative License.
 * Licensed for use in the AreteX Client Engine.
 *  
 **/

require_once('Delivery.class.php');

class Authorization_Fields
{
    var $descriptor; // Description of thing being authorized
    var $duration;   // Days for which the athorization is "good" -1 = "Infinte"
    var $authorization_options; // List of fields expected from the "special options" in the shopping cart
    var $additional_fields; // "Pass Back" authorization fields to further refine what exactly is being authorized
    var $include_order_header; // If set to "Yes" - Order Header information will be included in authorization return string
    var $include_pii; // If set to "Yes" - Personally identifiyable information will be included in authorization return string
    var $include_full_order; // If set to "Yes", other items in the order will be included in the authorization return string
    var $trigger_payout; // Physical goods only, if set to "Yes" Outbound payment will not be scheduled until status is set to "complete"
    var $trigger_charge_when_complete; // Physical goods only. Do not charge card until after satus is set to "complete";
    
    public function __construct($descriptor,$duration=-1,$authorization_options='',$additional_fields='') 
    {
        $this->descriptor = $descriptor;
        $this->duration = $duration;
        $this->authorization_options = $authorization_options;
        $this->include_order_header = 'No';
        $this->include_full_order = 'No';
        $this->include_pii = 'No';
        $this->trigger_payout = 'No'; // Future
        $this->trigger_charge_when_complete = 'No'; // Future
        $this->additional_fields = $additional_fields;
    }
    
}   


class AuthorizationDeliverable extends Deliverable 
{
    public function __construct($name, $description, $deliverable_code, Authorization_Fields $fields,DeliverySchedule $sched) 
    {
        $this->name = $name;
        $this->deliverable_code = $deliverable_code;
        $this->description = $description;
        $this->delivery_type = 'authorization';
        $this->schedule = $sched;
        $this->type_details = $fields;
        
    }
    
   // Data Array: name,description,deliverable_code,required_payment_status ,first_delivery, delivery_cycle, maximum_deliveries, duration
 
    public static function FromData($data)
    {
       
        $sched = new DeliverySchedule();
        $sched->first_delivery = $data['first_delivery'];
        $sched->required_payment_status = $data['required_payment_status'];
         PaymentStatus::clearCache(); // "Hack"
        if (! PaymentStatus::isValidValue($sched->required_payment_status))
            return "Invalid Required Payment Status: {$sched->required_payment_status}";              
        $sched->delivery_cycle = trim($data['delivery_cycle']);
        
        DeliveryCycle::clearCache(); // "Hack"

        if (! DeliveryCycle::isValidValue($sched->delivery_cycle))
            return "Invalid Delivery Cycle: {$sched->delivery_cycle}";
        $sched->maximum_deliveries = $data['maximum_deliveries'];
        if (! empty($data['start_time']))
            $sched->start_time = $data['start_time'];
        else
            $sched->start_time = 0;                
                        
        $auth_flds = $data['auth_flds'];       
        

        $obj = new AuthorizationDeliverable($data['name'],$data['description'],$data['deliverable_code'],$auth_flds,$sched);
        
        
        return $obj;  
        
    }
    
    
}

?>