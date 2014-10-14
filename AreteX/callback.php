<? 
/*******************************************************
  Callback Function to Allow AreteX Server to Communicate
  Back to WordPress for AreteX Plugin
  
  Uses Basic Authentication to avoid becoming a back door.
  
 
 Note: The callback_access.ini.php file is stored in plain text.
 If you believe it has been compromised, deactivate adn reactivate the plugin.
  
 ****************************************************** */

$ini = parse_ini_file(dirname(__FILE__).'/callback_access.ini.php');

$valid = false; 
if ($_SERVER['PHP_AUTH_USER'] == $ini['callback_id'])
{    
    if ( $_SERVER['PHP_AUTH_PW'] == $ini['callback_secret'])
    {
        $valid = true;
    }
}

if (! $valid)
{
    header("HTTP/1.1 403 Unauthorized" );
    echo 'Unauthorized';
    exit();
}
/*****
    All Callbacks Are Delivered via HTTP POST
*****/



error_log(var_export($_POST,true));

$envelope = stripslashes($_POST['envelope']);


$content = json_decode($envelope,true);

error_log(var_export($content,true));

switch($content['subject'])
{
    case 'Sandbox Registration':
        $ser = serialize($content);
        $path = dirname(__FILE__).'/in/register.ser';
        file_put_contents($path,$ser);
    break;
}



?>