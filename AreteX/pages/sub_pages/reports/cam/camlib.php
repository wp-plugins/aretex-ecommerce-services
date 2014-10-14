<?php
function getResource($urn)
{
    global $customer_id;
    if (! class_exists('AreteX_WPI'))
    {
        $aretex_core_path = get_option('aretex_core_path');
        require_once($aretex_core_path .'AreteX_WPI.class.php');
    }
    $url = get_option('aretex_cam_endpoint');
    if (! empty($urn))
    {
        $url .= '/account/'.$customer_id.'/'.$urn;
    }
    else
    {
        $url .= '/account/'.$customer_id;
    }
    
    $obj = AreteX_WPI::getSensitiveResourceByURI($url,AreteX_WPI::no_cache,$customer_id);
    
    return $obj;
}


function displayObject($obj,$field_prompt)
{
    $start_row = false;
    $end_row = false;
    $i = 0;
    foreach($field_prompt as $field=>$prompt)
    {
        if ($end_row)
        {
            $start_row = false;
            echo "\n</div><!-- END ROW -->";
        }
        if (($i % 2) == 0)
        {
            $start_row = true;
            $end_row = false;
            echo "<div class=\"section group\"> <!-- START ROW --> \n".
                "<div class=\"col span_1_of_12\">&nbsp;</div>";
        }
        $id=uniqid();
        echo 
             "<div class=\"col span_4_of_12\">".
             "<label for=\"$id\">$prompt:</label><span id=\"$id\"> ".$obj->$field.'</span>'.
             "\n</div>";
        $i++;
        if (($i % 2) == 0)
        {
            $end_row = true;
        }
        
    
        
    }
    if ($start_row)
       echo "\n</div><!-- END ROW -->";
}
 





    
    
 



?>