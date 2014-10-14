function set_auth_context(url,aretex_ajax_auth,config_id,plugin_url)
{
    
    url = url+"?aretex_ajax_auth="+aretex_ajax_auth;
    console.log(url);
    jQuery.ajax({
       type: 'POST', 
       url: url,
       async: true, // Don't wait'.
       dataType: 'json',
       data: { cmd: 'SET_AUTH',  plugin_url: plugin_url , auth: aretex_ajax_auth, config: config_id  },       
       error: function(xhr, type, exception) { 
           if (confirm('Access Authorization To AreteX Server Failed\nClick OK to Refresh License Status')) {
            jQuery('#refresh_license').submit();
           }
           
       }
    });
    
    
    
}

function config_settings(url,aretex_ajax_auth,config_id,settings_id,settings)
{
    url = url+"?aretex_ajax_auth="+aretex_ajax_auth;
    jQuery.ajax({
       type: 'POST', 
       url: url,
       async: false, // Wait For It ...
       dataType: 'json',
       data: { cmd: 'CONFIG_SETTINGS',  settings_id: settings_id , settings: settings, auth: aretex_ajax_auth, config: config_id  }  
    });
    
}


function init_datatable_resizeable(url,table_id,config_id,filter_key,aoCols,aretex_ajax_auth,cancel_call)
{
   plugin_url = 'test'; 
   url=url+"?&cmd=Read&view=List&config_id="+config_id+"&aretex_ajax_auth="+aretex_ajax_auth+"&cancel_call="+cancel_call;
    if (filter_key)
         url = url+ '&filter_key='+filter_key;
        
     var oTable = jQuery('#'+table_id).dataTable(
            {
                
                "bJQueryUI": true,
                "sPaginationType": "full_numbers",
                "bProcessing": true,
                "bServerSide": true,
                "sAjaxSource": url,
                "fnServerData": function( sUrl, aoData, fnCallback, oSettings ) {
                                                                                          
                    oSettings.jqXHR = jQuery.ajax( {
                        "url": sUrl,
                        "data": aoData,
                        "success": fnCallback,
                        "dataType": "jsonp",
                        "cache": false
                    } );
                },
                
                "sDom": '<"H"RlCfr>t<"F"ip>',
                "oColVis": {
                "sSize": "css"
                },
                "aoColumns": aoCols
                           
                           
            }
    );
    
  //  console.log('Returning'+oTable); 
    return oTable;
  
    
   
}


function init_local_datatable_resizeable(table_id)
{
        
     var oTable = jQuery('#'+table_id).dataTable(
            {
                
                "bJQueryUI": true,
                "sPaginationType": "full_numbers",
                "bProcessing": true,
                "bServerSide": false,
                              
                "sDom": '<"H"RlCfr>t<"F"ip>',
                "oColVis": {
                "sSize": "css"
                },
                                           
                           
            }
    );
    
  //  console.log('Returning'+oTable); 
    return oTable;
  
    
   
}

function init_local_datatable_scroll_x(table_id,inner,bSearchable)
{

         
     var oTable = jQuery('#'+table_id).dataTable(
        {
                
            "bJQueryUI": true,
            "sPaginationType": "full_numbers",
            "bProcessing": true,
            "bServerSide": false,
            "bSearchable": bSearchable,
            "sScrollX": "100%",
  		    "sScrollXInner": inner,
            "bScrollCollapse": true,
            "sDom": '<"H"lCfr>t<"clear"ip>',
            "oColVis": {
            "sSize": "css"
            }
        }
                
    ); 
    
    return oTable;

}

function init_local_datatable(table_id)
{

         
     var oTable = jQuery('#'+table_id).dataTable(
        {
                
            "bJQueryUI": true,            
            "bProcessing": true,
            "bServerSide": false,
            "bSearchable": false,           
            "sDom": '<"H"lCfr>t<"clear"ip>',
            "oColVis": {
            "sSize": "css"
            }
        }
                
    ); 
    
    return oTable;

}



function init_datatable_resizeable_all(url,table_id,config_id,filter_key,aoCols)
{
      
     url=url+"?&cmd=Read&view=List&config_id="+config_id;
    if (filter_key)
         url = url+ '&filter_key='+filter_key;
        
     var oTable = jQuery('#'+table_id).dataTable(
        {
                
            "bJQueryUI": true,
            "sPaginationType": "full_numbers",
            "bProcessing": true,
            "bServerSide": true,
            "sAjaxSource": url,
            "sDom": '<"H"Rlfr>t<"F"ip>',
            "aoColumns": aoCols
        }
        
                
    ); 
    return oTable;
  
}



function init_datatable_scroll_x(url,table_id,config_id,filter_key,aoCols,aretex_ajax_auth)
{

     url=url+"?&cmd=Read&view=List&config_id="+config_id+"&aretex_ajax_auth="+aretex_ajax_auth;
    if (filter_key)
         url = url+ '&filter_key='+filter_key;
    
   // console.log(url);
        
     var oTable = jQuery('#'+table_id).dataTable(
        {
                
            "bJQueryUI": true,
            "sPaginationType": "full_numbers",
            "bProcessing": true,
            "bServerSide": true,
            "sAjaxSource": url,
            "fnServerData": function( sUrl, aoData, fnCallback, oSettings ) {
                                        
                                                         
                    oSettings.jqXHR = jQuery.ajax( {
                        "url": sUrl,
                        "data": aoData,
                        "success": fnCallback,
                        "dataType": "jsonp",
                        "cache": false
                    } );
                },
            "sScrollX": "100%",
  		    "sScrollXInner": "150%",
            "bScrollCollapse": true,
            "sDom": '<"H"lCfr>t<"clear"ip>',
            "oColVis": {
            "sSize": "css"
            },
            "aoColumns": aoCols
        }
                
    ); 
    
    return oTable;

}

function init_datatable_scroll_x_no_inner(url,table_id,config_id,filter_key,aoCols,aretex_ajax_auth)
{

     url=url+"?&cmd=Read&view=List&config_id="+config_id+"&aretex_ajax_auth="+aretex_ajax_auth;
    if (filter_key)
        var url = url+ '&filter_key='+filter_key;
        
     var oTable = jQuery('#'+table_id).dataTable(
        {
                
            "bJQueryUI": true,
            "sPaginationType": "full_numbers",
            "bProcessing": true,
            "bServerSide": true,
            "sAjaxSource": url,
            "fnServerData": function( sUrl, aoData, fnCallback, oSettings ) {
                                        
                                                         
                    oSettings.jqXHR = jQuery.ajax( {
                        "url": sUrl,
                        "data": aoData,
                        "success": fnCallback,
                        "dataType": "jsonp",
                        "cache": false
                    } );
                },
            "sScrollX": "100%",  		    
            "bScrollCollapse": true,
            "sDom": '<"H"lCfr>t<"clear"ip>',
            "oColVis": {
            "sSize": "css"
            },
            "aoColumns": aoCols
        }
                
    ); 
    
    return oTable;

}



function init_datatable_scroll_x_all(url,table_id,config_id,filter_key,aoCols)
{

    url=url+"?&cmd=Read&view=List&config_id="+config_id;
    if (filter_key)
         url = url+ '&filter_key='+filter_key;
        
    var oTable = jQuery('#'+table_id).dataTable(
        {
                
             
            "bJQueryUI": true,
            "sPaginationType": "full_numbers",
            "bProcessing": true,
            "bServerSide": true,
            "sAjaxSource": url,
            "sScrollX": "100%",
  		    "sScrollXInner": "150%",
            "bScrollCollapse": true,
            "aoColumns": aoCols
        }
                
    ); 
    
    return oTable;

    
}  

/*
[ 	{ type: "text" },
    { type: "date-range" },
    { type: "number-range" }
						]
*/

function add_column_filters(oTable,filters)
{
    oTable.columnFilter({ 	sPlaceHolder: "foot:after",
					aoColumns: filters  });
  
  return oTable;
}

// Credit: https://gist.github.com/gordonbrander/2230317
// Generate unique IDs for use as pseudo-private/protected names.
// Similar in concept to
// <http://wiki.ecmascript.org/doku.php?id=strawman:names>.
//
// The goals of this function are twofold:
// 
// * Provide a way to generate a string guaranteed to be unique when compared
//   to other strings generated by this function.
// * Make the string complex enough that it is highly unlikely to be
//   accidentally duplicated by hand (this is key if you're using `ID`
//   as a private/protected name on an object).
//
// Use:
//
//     var privateName = ID();
//     var o = { 'public': 'foo' };
//     o[privateName] = 'bar';
var ID = function () {
  // Math.random should be unique because of its seeding algorithm.
  // Convert it to base 36 (numbers + letters), and grab the first 9 characters
  // after the decimal.
  return '_' + Math.random().toString(36).substr(2, 9);
};


function excel_export(oTable,config_id,base_url,aretex_ajax_auth)
{
       
    var oSettings = oTable.fnSettings();
    var str =  JSON.stringify(oSettings.aoColumns);
    var settings_id = ID();
    config_settings(base_url+"/bas/dbui/dbui_ajax_JSON.php",aretex_ajax_auth,config_id,settings_id,str);
    var url = base_url+"/bas/dbui/dbui_ajax_JSON.php?config_id="+config_id+"&settings=use_id&settings_id="+settings_id+"&cmd=Save&view=List&fmt=XLS"+"&aretex_ajax_auth="+aretex_ajax_auth;
    jQuery('#export_frame').attr('src',url);
    

    
}

function csv_export(oTable,config_id,base_url,aretex_ajax_auth)
{
      
    var oSettings = oTable.fnSettings();
    var str =  JSON.stringify(oSettings.aoColumns);
    var settings_id = ID();
    config_settings(base_url+"/bas/dbui/dbui_ajax_JSON.php",aretex_ajax_auth,config_id,settings_id,str);

    var url = base_url+"/bas/dbui/dbui_ajax_JSON.php?config_id="+config_id+"&settings=use_id&settings_id="+settings_id+"&cmd=Save&view=List&fmt=CSV"+"&aretex_ajax_auth="+aretex_ajax_auth;
    jQuery('#export_frame').attr('src',url);
    
}

function prn_export(oTable,config_id,base_url,aretex_ajax_auth)
{
      
    var oSettings = oTable.fnSettings();
    var str =  JSON.stringify(oSettings.aoColumns);
    var settings_id = ID();
    config_settings(base_url+"/bas/dbui/dbui_ajax_JSON.php",aretex_ajax_auth,config_id,settings_id,str);

    var url = base_url+"/bas/dbui/dbui_ajax_JSON.php?config_id="+config_id+"&settings=use_id&settings_id="+settings_id+"&cmd=Save&view=List&fmt=PRN"+"&aretex_ajax_auth="+aretex_ajax_auth;
    window.open(url);
    
}


function add_std_buttons(oTable,selector,config_id,base_url,aretex_ajax_auth)
{
      
    var oTableTools = new TableTools( oTable, {
		"aButtons": [
                {
                    "sExtends":    "text",
                    "sButtonText": 'Print',
                    "fnClick": function ( nButton, oConfig, oFlash ) {
                        prn_export(oTable,config_id,base_url,aretex_ajax_auth);
                    }
                    
                },
                {
                    "sExtends":    "text",
                    "sButtonText": 'Excel',
                    "fnClick": function ( nButton, oConfig, oFlash ) {
                        excel_export(oTable,config_id,base_url,aretex_ajax_auth);
                    }
                    
                },
                {
                    "sExtends":    "text",
                    "sButtonText": 'CSV',
                    "fnClick": function ( nButton, oConfig, oFlash ) {
                        csv_export(oTable,config_id,base_url,aretex_ajax_auth);
                    }
                    
                }
            ]
	} );
	
	jQuery('.dataTables_wrapper').before( oTableTools.dom.container );
    
    
    return oTable;
  
}

function add_custom_buttons(selector,buttons)
{
   
	
	jQuery('.dataTables_wrapper').before( buttons );
    
}

function dbui_save_form(form_id,url,ajax_div,done_call,aretex_ajax_auth)
{
    
    var old_url = url;
      
    url = url+"?aretex_ajax_auth="+aretex_ajax_auth;
   
    var filter_key = jQuery('#filter_key').val();
  
      
    jQuery(form_id).validate();
    if (jQuery(form_id).valid())
    {        
        var form_data = jQuery(form_id).serialize();
        if (typeof(before_dbui_save_function) === 'function') {
            before_dbui_save_function(form_id);
        }
        jQuery.ajax({
          type: 'POST',
          url: url,
          data: form_data,
          dataType: 'json',
          crossDomain: true,          
          success: function(data){
                 if (data.status == 'OK' && data.id){
                    if (done_call.edit_self) {
                        aretex_dbui_Edit(done_call.config_id,old_url,ajax_div,data.id,aretex_ajax_auth,done_call.cancel_call);
                    }
                    else {
                        
   
                        if (filter_key && done_call)
                            load_linked_screen(done_call,filter_key)
                        else
                            load_screen(done_call);
                    }
                 }
                 else
                 {
                    alert('Problem Saving - (Duplicate ?)');
                 }
          },
          error: function(xhr, type, exception) { 
            // if ajax fails display error alert
           alert("Ajax Error: Exception: "+exception+type);
          }
        });
    }
    
}

function dbui_ConfirmDelete_form(form_id,url,ajax_div,done_call,aretex_ajax_auth)
{
        url = url+"?aretex_ajax_auth="+aretex_ajax_auth;
        var filter_key = jQuery('#filter_key').val(); 
  
        var form_data = jQuery(form_id).serialize();       
        jQuery.ajax({
          type: 'POST',
          url: url,
          data: form_data,
          dataType: 'json',
          crossDomain: true,
          success: function(data){             
               if (filter_key && done_call){
                    load_linked_screen(done_call,filter_key);
               } 
               else {
                    load_screen(done_call);
               }
          },
          error: function(xhr, type, exception) { 
            // if ajax fails display error alert
            alert("Ajax Error: Exception: "+exception);
          }
        });
    
}

function dbui_add_new_form(config_id,url,ajax_div,aretex_ajax_auth,cancel_call)
{

  
    var data='config_id='+config_id+'&cmd=Create&view=Form'+"&aretex_ajax_auth="+aretex_ajax_auth+'&cancel_call='+cancel_call;
    jQuery.ajax({
      type: 'GET',
      url: url,
      data: data,
      dataType: 'jsonp',
      success: function(data){
        jQuery(ajax_div).html(data);
      },
      error: function(xhr, type, exception) { 
        // if ajax fails display error alert
        alert("Ajax Error: Exception: "+exception);
      }
    });
       
}

function dbui_add_new_linked_form(config_id,url,ajax_div,aretex_ajax_auth,cancel_call,filter_key)
{

  
    var data='config_id='+config_id+'&cmd=Create&view=Form'+"&aretex_ajax_auth="+aretex_ajax_auth+'&cancel_call='+cancel_call+'&filter_key='+filter_key;
    jQuery.ajax({
      type: 'GET',
      url: url,
      data: data,
      dataType: 'jsonp',
      success: function(data){
        jQuery(ajax_div).html(data);
      },
      error: function(xhr, type, exception) { 
        // if ajax fails display error alert
        alert("Ajax Error: Exception: "+exception);
      }
    });
       
}


function aretex_dbui_Edit(config_id,url,ajax_div,id,aretex_ajax_auth,cancel_call)
{

     var data='config_id='+config_id+'&cmd=Update&view=Form&id='+id+"&aretex_ajax_auth="+aretex_ajax_auth+'&cancel_call='+cancel_call;

    jQuery.ajax({
      type: 'GET',
      url: url,
      data: data,
      dataType: 'jsonp',
      success: function(data){
        jQuery(ajax_div).html(data);
      },
      error: function(xhr, type, exception) { 
        // if ajax fails display error alert
        alert("Ajax Error: Exception: "+exception);
      }
    });   
        
}

function aretex_dbui_View(config_id,url,ajax_div,id,aretex_ajax_auth,cancel_call)
{
     
     var data='config_id='+config_id+'&cmd=Read&view=Form&id='+id+"&aretex_ajax_auth="+aretex_ajax_auth+'&cancel_call='+cancel_call;
     jQuery.ajax({
      type: 'GET',
      url: url,
      data: data,
      dataType: 'jsonp',
      success: function(data){
        jQuery(ajax_div).html(data);
      },
      error: function(xhr, type, exception) { 
        // if ajax fails display error alert
        alert("Ajax Error: Exception: "+exception);
      }
    });   
        
}


function aretex_dbui_Delete(config_id,url,ajax_div,id,aretex_ajax_auth,cancel_call)
{

     var data='config_id='+config_id+'&cmd=Delete&view=Form&id='+id+"&aretex_ajax_auth="+aretex_ajax_auth+'&cancel_call='+cancel_call;
     jQuery.ajax({
      type: 'GET',
      url: url,
      data: data,
      dataType: 'jsonp',
      success: function(data){
        jQuery(ajax_div).html(data);
        
      },
      error: function(xhr, type, exception) { 
        // if ajax fails display error alert
        alert("Ajax Error: Exception: "+exception);
      }
    });   
        
}  

function dbui_Cancel_form(config_id,url,ajax_div,cancel_call)
{
   var filter_key = jQuery('#filter_key').val();
   
   if (filter_key && cancel_call){
    load_linked_screen(cancel_call,filter_key);
    
   }else if (cancel_call)
     load_screen(cancel_call);
   else {    
       var data='config_id='+config_id+'&cmd=Read&view=List';
        jQuery.ajax({
          type: 'POST',
          url: url,
          data: data,
          success: function(data){

            jQuery(ajax_div).html(data);

          },
          error: function(xhr, type, exception) { 
            // if ajax fails display error alert
            alert("Ajax Error: Exception: "+exception);
          }
        });
   }
       
}
 

