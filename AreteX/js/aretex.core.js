/*!
 * Core Javascript for AreteX for Wordpress
 *
 * http://3BAlliance.com
 * 
 *
 * Copyright 2014 3B Alliance LLC
 * Released under the GPL 2.0 license or later
 *  
 */
 
 var theAreteXCart; // The AreteX Cart Object
 
 
 function decodeCart(co_data) {
    
    var obj = JSON.parse(co_data);    
    var json_string = atob(obj.cart);   
    theAreteXCart = JSON.parse(json_string);
 }
 
 function atx_buynow_code(product_code){
    jQuery(function ($) {                
    	
                      
        var data = {
		action: 'atx_buynow',        
        code: product_code
	   };
        	
    	$.post(AreteXCoreJS.ajaxurl, data, function(response) {
    	  var obj = JSON.parse(response);                   
           var post_data = Array();
           post_data['data'] = obj.data;
           atx_postIt(obj.url,post_data);
          
    	});
        
    
    });  
}

 

 function atx_register_payee(form_id,capcha_type){
    jQuery(function ($) {                
    	
        var chosen_options = $('#'+form_id).serialize();              
        var data = {
		action: 'atx_payee_reg',        
        form_id: form_id,
        capcha_type: capcha_type,
        options: chosen_options 
	   };
       
       
      
       $('.aretex_reg_error').hide(); 	
    	$.post(AreteXCoreJS.ajaxurl, data, function(response) {    	  
    	  var obj = JSON.parse(response);
           if (obj.errors) {            
            for(var i = 0; i < obj.errors.length; ++i ){
              err = obj.errors[i];             
              $('#'+err.element).after('<label class="aretex_reg_error">'+err.message+'</label>');
            }
            return;
           }
           $('#aretex_payee_reg_div').html('Please check your email for your temporary password');
           
    	});
        
    
    });  
}


function atx_role_only(product_code,element_id){
    jQuery(function ($) {                
    	
                   
        var data = {
		action: 'atx_register',        
        code: product_code,
        options: 'role_only',
        element_id: element_id
	   };
       
        $('.aretex_reg_error').hide(); 	
    	$.post(AreteXCoreJS.ajaxurl, data, function(response) {    	   
    	  var obj = JSON.parse(response);
           if (obj.errors) {            
            for(var i = 0; i < obj.errors.length; ++i ){
              err = obj.errors[i];
              $('#'+err.element).after('<label class="aretex_reg_error">'+err.message+'</label>');
            }
            return;
           }
                       
           var post_data = Array();
           post_data['data'] = obj.data;
           atx_postIt(obj.url,post_data);
          
    	});
        
    
    });  
}


function atx_register(product_code, form_id){
    jQuery(function ($) {                
    	
        var chosen_options = $('#'+form_id).serialize();              
        var data = {
		action: 'atx_register',        
        code: product_code,
        options: chosen_options
	   };
       
        $('.aretex_reg_error').hide(); 	
    	$.post(AreteXCoreJS.ajaxurl, data, function(response) {    	   
    	  var obj = JSON.parse(response);
           if (obj.errors) {            
            for(var i = 0; i < obj.errors.length; ++i ){
              err = obj.errors[i];
              $('#'+err.element).after('<label class="aretex_reg_error">'+err.message+'</label>');
            }
            return;
           }
                       
           var post_data = Array();
           post_data['data'] = obj.data;
           atx_postIt(obj.url,post_data);
          
    	});
        
    
    });  
}



// Credit: http://stackoverflow.com/questions/3846271/jquery-submit-post-synchronously-not-ajax
// 
function atx_postIt(url, data){
     jQuery(function ($) {   
        $('body').append($('<form/>', {
          id: 'atx_jQueryPostItForm',
          method: 'POST',
          action: url
        }));
    
        for(var i in data){
          $('#atx_jQueryPostItForm').append($('<input/>', {
            type: 'hidden',
            name: i,
            value: data[i]
          }));
        }
    
        $('#atx_jQueryPostItForm').submit();
    });
}


