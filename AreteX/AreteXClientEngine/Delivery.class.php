<?php
/**
 * Copyright  2009-2013 3B Alliance, LLC 
 * Subject to the Terms of 3B Alliance, LLC Derivative License.
 * Licensed for use in the AreteX Client Engine.
 *  
 **/
 
include_once('utilities.php');

abstract class PaymentStatus extends Enum
{
    const authorized = 'authorized'; // Delivered if CC is authorized or complete, or eCheck Authorized
    const complete = 'complete'; // Delivered only if CC is complete ... Future: eCheck clears 
    const is_free = 'is_free';  // Deliverable is always free so payment status is ignored. 
    // If the deliverable is part of a "Free Product" ... this entire item is ingnored.   
}


abstract class DeliveryCycle extends Enum
{
    const single = 'single';
    const daily = 'daily';
    const weekly = 'weekly';
    const monthly = 'monthly';    
    const quarterly = 'quarterly';
    const yearly = 'yearly';
    const extra = 'extra';
}
 
class DeliveryType
{
    var $id;
    var $type_name;
    var $type_key;
    var $phys_or_dig;
    var $descriptor;
    var $fields;        
}

class DeliverySchedule
{   
   var $first_delivery; // days after confirmed order or start_time  			
   var $required_payment_status; // Payment status required before deliery is initiated. 
   var $delivery_cycle;
   var $maximum_deliveries;  // Number of total deliveries: -1 means as  long as subscription is paid up.
   var $start_time;   
}

class Deliverable
{
   var $id;
   var $deliverable_code;
   var $name;
   var $description;
   var $delivery_type;
   var $type_details;
   var $schedule;
  
    
}

class DeliveryManifest
{
    var $id;
    var $delivery_code;
    var $description;
    
    var $deliverables; // Full objects
    
}

class ManifestByReference {
    var $id;
    var $delivery_code;
    var $description;
    
    var $deliverable_ids; // ID's only
    
}
 
 ?>