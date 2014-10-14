<?php 

class AreteXDT {
    public static function TableListScrollX($headerMap,$actionList,$dataRows) {
        
        $col_headers = '';
        if (! empty($actionList))
            $col_headers .= '<th class="no_sort">Actions </th>';
        $col_headers .= self::makeHeaders(array_keys($headerMap));
        $list_data = self::ListData($dataRows,$headerMap,$actionList); 
        $id = uniqid('tbl_');

        
              $str = <<<END_LVTBL
      <table cellpadding="0" cellspacing="0" border="0" style="width: 100%;"  id="$id">
	<thead>
		<tr>
			$col_headers
		</tr>
	</thead>
	<tbody>
	
		$list_data
		
	</tbody>
	<tfoot>
		<tr>
			$col_headers
		</tr>
	</tfoot>
    </table>
    
    <script>
   	jQuery(function($) {
        $(document).ready(function() {
            
             var aoColums = [];
             
             $('#$id thead th').each( function () {
                    if ( $(this).hasClass( 'no_sort' )) {
                        aoColums.push( { "bSortable": false } );
                    } else {
                        aoColums.push( null );
                    }
           } ); 
                     
           
            $('#$id').dataTable( {
            "bJQueryUI": true,
            "sPaginationType": "full_numbers",
            "sScrollX": "100%",  
            "bScrollCollapse": true,
             "aoColumns": aoColums,
            "bAutoWidth": false,
            "sDom": '<"H"lCfr>t<"clear"ip>',
                    "oColVis": {
                    "sSize": "css"
                    },
          } );
          
          
          
         });
            
         
     });
     
    
     
    </script> 
     
END_LVTBL;
  
  //  error_log($str);
    return $str;
        
        
    }
    
    
    public static function TableList($headerMap,$actionList,$dataRows) {
        
        $col_headers = '';
        if (! empty($actionList))
            $col_headers .= '<th class="no_sort">Action</th>';
        $col_headers .= self::makeHeaders(array_keys($headerMap));
        $list_data = self::ListData($dataRows,$headerMap,$actionList); 
        $id = uniqid('tbl_');

        
              $str = <<<END_LVTBL
      <table cellpadding="0" cellspacing="0" border="0" style="width: 100%;" width="100%"  id="$id">
	<thead>
		<tr>
			$col_headers
		</tr>
	</thead>
	<tbody>
	
		$list_data
		
	</tbody>
	<tfoot>
		<tr>
			$col_headers
		</tr>
	</tfoot>
    </table>
    
    <script>
   	jQuery(function($) {
        $(document).ready(function() {
        
           var aoColums = [];
           $('#$id thead th').each( function () {
                    if ( $(this).hasClass( 'no_sort' )) {
                        aoColums.push( { "bSortable": false } );
                    } else {
                        aoColums.push( null );
                    }
           } ); 
         
                     
           
            $('#$id').dataTable( {
    "bJQueryUI": true,
    "sPaginationType": "full_numbers",
    "aoColumns": aoColums
        
  } );
          
         });
     });
    </script> 
     
END_LVTBL;
  
  //  error_log($str);
    return $str;
        
        
    }
    
    
    protected static function makeHeaders($header_list){
        $str = '';
       
        foreach($header_list as $colName)
            $str .= '<th>'.$colName.'</th>';
        
        return $str;
    }
    
    
    protected static function makeFunctionParameters($action_item, $line){
        $str = '';
        $parameters = $action_item['parameters'];
        if (is_array($parameters)) {                    
            foreach($parameters as $parameter){
                if ($parameter[0] == '[') {
                    $parameter = trim($parameter,'[]');
                    $parameter = $line[$parameter];                
                }
                $str .= "'$parameter',";                        
            }
            $str = trim($str,',');
        }
        return $str;
    }
    
    protected static function make_ActionCol($actions,$line)
    {
        $str = '<td><span style="float: right">';
        foreach($actions as $action) {
            $str .= '<a href="javascript:void(0)"  onclick=" ';
            $str .= $action['function_name'].'('.self::makeFunctionParameters($action, $line) .');">';            
            $str .= '<img title="'.$action['title'].'" src="'.plugins_url( $action['icon_path'], __FILE__ ).'" /></a> ';
        }
        $str .= '</span></td>';
        return $str;
    }
    
    protected static function ListData($data,$HeaderMap,$actions)
    {
      
        $str = '';
        foreach($data as $line)
        {
            // var_export($merchant);
              //  echo "\n".$merchant->id;
             // var_export($vantiv->MerchantProfile($merchant->id));
             $str .= '<tr>';
             if (! empty($actions))
                $str .= self::make_ActionCol($actions,$line);
             foreach($HeaderMap as $header=>$col)
             $str .= '<td>'.$line[$col].'</td>';                         
             $str .= '</tr>'."\n";
         
        }
        
        return $str;
    }
    
    
}

?>