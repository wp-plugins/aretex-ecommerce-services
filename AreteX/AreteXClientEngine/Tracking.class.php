<? 
/**
 * Copyright  2009-2014 3B Alliance, LLC 
 * Subject to the Terms of 3B Alliance, LLC Derivative License.
 * Licensed for use in the AreteX Client Engine.
 *  
 **/
 
 include_once('utilities.php');

abstract class OfferType extends Enum
{
    const access = 'STD';
    const percent_discount = 'DIS';   
}
 
abstract class LimitType extends Enum
{
    const none = 'NONE';
    const expires = 'EXP';   
}
 
class TrackingOffer {
    var $offer_code;
    var $description;
    var $offer_type;
    var $discount_amount;
    var $expiration;
    
 }
 
?>