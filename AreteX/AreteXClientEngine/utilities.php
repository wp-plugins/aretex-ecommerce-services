<?php
/**
 * File: utilities.php
 * 
 * Contents: Useful classes and functions gleaned from around the web.
 * 
 * 
 * */


/**
 * Class Enum:
 * 
 * Modified by David Brumbaugh from StackExchange Code
 * 
 * License: CC-Attribution: http://creativecommons.org/licenses/by-sa/3.0/
 * 
 * Credit: http://stackoverflow.com/questions/254514/php-and-enumerations
 * 
 * 
 * */
 
 abstract class Enum 
 {
    protected static $constCache = NULL;
    protected static $last_check_name = NULL;

    protected static function getConstants() 
    {
        
        if (self::$constCache === NULL) {
            $reflect = new ReflectionClass(get_called_class());
            self::$constCache = $reflect->getConstants();
        }

        return self::$constCache;
    }
    
    public function clearCache() 
    {
       self::$constCache = NULL; 
    }

    public static function isValidName($name, $strict = false) 
    {
        $constants = self::getConstants();

        if ($strict) {
            return array_key_exists($name, $constants);
        }

        $keys = array_map('strtolower', array_keys($constants));
        return in_array(strtolower($name), $keys);
    }

    public static function isValidValue($value) 
    {
        $values = array_values(self::getConstants());
        return in_array($value, $values, $strict = true);
    }
}

/**
 * class_cast
 *  
 * Function casting standard object to a specific class
 *
 * @param string|object $destination
 * @param object $sourceObject
 * @return object
 */
 
 /**
 * 
 * Modified by David Brumbaugh from StackExchange Code
 * 
 * License: CC-Attribution: http://creativecommons.org/licenses/by-sa/3.0/
 * 
 * Credit: http://stackoverflow.com/questions/3243900/convert-cast-an-stdclass-object-to-another-class
 * 
 * 
 * */
 
function class_cast($destination, $sourceObject)
{
       
    if (is_string($destination)) {
        /*
        if (! class_exists($destination))
        {
            $ar = debug_backtrace();
            echo "<pre>";
            var_dump($ar);
            echo"</pre>";
            exit();
        }
        */
        $destination = new $destination();
    }

    $sourceReflection = new ReflectionObject($sourceObject);
    $destinationReflection = new ReflectionObject($destination);
    $sourceProperties = $sourceReflection->getProperties();
    foreach ($sourceProperties as $sourceProperty) {
        $sourceProperty->setAccessible(true);
        $name = $sourceProperty->getName();
        $value = $sourceProperty->getValue($sourceObject);
        if ($destinationReflection->hasProperty($name)) {
            $propDest = $destinationReflection->getProperty($name);
            $propDest->setAccessible(true);
            $propDest->setValue($destination,$value);
        } else {
            $destination->$name = $value;
        }
    }
    return $destination;
}

?>