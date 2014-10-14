function hover_url(orig_url) {
	return orig_url.replace('buttons', 'buttons/hover');
}

function off_hover_url(hover_url) {
	return hover_url.replace('buttons/hover', 'buttons');
}

function init_help_dlg() {
	jQuery(function($) {
		$(".help_dlg").dialog({
			autoOpen: false,
			width: 600,
			buttons: [{
				text: "Done",
				click: function() {
					$(this).dialog("close");
				}
			}]
		});
	});
}

function open_help_dlg(help_id) {
	jQuery(function($) {
		$(help_id).dialog("open");
	});
}
jQuery(document).ready(function() {
	jQuery(function($) {
		// Hover states on the static widgets
		$(".ui-button").hover(

		function() {
			$(this).addClass("ui-state-hover");
		}, function() {
			$(this).removeClass("ui-state-hover");
		});

		$('a.icon_help').hover(

		function() {
			var src = $(this).children('img').attr('src');
			src = hover_url(src);
			$(this).children('img').attr('src', src);
		}, function() {
			var src = $(this).children('img').attr('src');
			src = off_hover_url(src);
			$(this).children('img').attr('src', src);
		});
		

	});
});

function set_product_search(ctrl_id, url, username, password) {
    access_token = username + ':' + password;
    return set_product_search_token(ctrl_id, url, access_token);
}

function set_product_search_token(ctrl_id, url, access_token) {
	
	jQuery(function($) {
		function log(message) {
			return;
			$("<div>").text(message).prependTo("#log");
			$("#log").scrollTop(0);
		}
		$("#find_prod").autocomplete({
			source: function(request, response) {
				$.ajax({
					url: url,
					dataType: "jsonp",
					data: {
						limit: 12,
						q: request.term,
						aretex_ajax_auth: access_token
					},
					success: function(data) {
						response($.map(data.products, function(item) {
							return {
								label: item.code + ': ' + item.name,
								value: item.code,
								name: item.name,
								pricing: item.pricing
							}
						}));
					}
				});
			},
			minLength: 2,
			select: function(event, ui) {
				log(ui.item ? "Selected: " + ui.item.label : "Nothing selected, input was " + this.value);
				if (ui.item) {
					$('#prod_name').val(ui.item.name);
					$('#prod_code').val(ui.item.value);
					if (ui.item.pricing.pricing_model == 'single_price') {
						$('#prod_price').val(ui.item.pricing.offers['default'].price);
					}
				}
			},
			open: function() {
				$(this).removeClass("ui-corner-all").addClass("ui-corner-top");
			},
			close: function() {
				$(this).removeClass("ui-corner-top").addClass("ui-corner-all");
			}
		});
	});
}

var delete_from_manifest_icon;



function set_deliverable_search(ctrl_id, url, username, password) {
	access_token = username + ':' + password;
	jQuery(function($) {
		function log(message) {
			return;
			$("<div>").text(message).prependTo("#log");
			$("#log").scrollTop(0);
		}
		$("#find_deliverable").autocomplete({
			source: function(request, response) {
				$.ajax({
					url: url,
					dataType: "jsonp",
					data: {
						limit: 12,
						q: request.term,
						aretex_ajax_auth: access_token
					},
					success: function(data) {
						response($.map(data.deliverables, function(item) {
							return {
								label: item.deliverable_code + ': ' + item.name,
								value: item.name,
                                id: item.id,
                                deliverable_code: item.deliverable_code,
								name: item.name,
								description: item.description,
                                delivery_type: item.delivery_type,
                                type_descriptor: item.type_details.descriptor,                                                              
                                first_delivery: item.schedule.first_delivery,
                                duration: item.type_details.duration,  
                                delivery_cycle: item.schedule.delivery_cycle,
                                total_deliveries: item.schedule.maximum_deliveries
							}
						}));
					}
				});
                
			},
			minLength: 2,
			select: function(event, ui) {
				log(ui.item ? "Selected: " + ui.item.label : "Nothing selected, input was " + this.value);
				if (ui.item) {				    
                    if (ui.item.total_deliveries == -1)
                        ui.item.total_deliveries = 'Until Canceled';
                    append_row(ui.item);
				}
			},
			open: function() {
				$(this).removeClass("ui-corner-all").addClass("ui-corner-top");
			},
			close: function() {
				$(this).removeClass("ui-corner-top").addClass("ui-corner-all");
			}
		});
        
        function append_row(item) {
           var del_button = '<img src="'+delete_from_manifest_icon+'" style="float: right; cursor: pointer;" class="remove-row-button"   title="Remove from manifest" />'+
                            ' <input type="hidden" name="deliverable_id[]" value="'+item.id+'" /> ';
                
           if (item.duration === undefined || item.duration == 'undefined' || item.duration == 0)
                duration = 'Unlimited';
           else
                duration = item.duration;
                
            if (item.type_descriptor === undefined || item.type_descriptor == 'undefined' || item.type_descriptor == 0)
                item.type_descriptor = '(none)';
            
           var row = [del_button,
                     item.deliverable_code,
                     item.name,
                     item.description,
                     item.delivery_type,
                     item.type_descriptor,
                     '<span style="float: right" text-align: right>'+item.first_delivery+'</span>',
                     '<span style="float: right" text-align: right>'+duration+'</span>',
                     item.delivery_cycle,
                     '<span style="float: right" text-align: right>'+item.total_deliveries+'</span>'];
                     
           oTable.fnAddData(row);
           
           $('.remove-row-button').tooltip();

           $('.remove-row-button').off('click'); // Clear out all the old ones 
           $('.remove-row-button').on('click', function (event) {
            
                   $(this).tooltip('close');
                   var tr = $( this ).closest('tr');                          
                                                      
                //   var aPos = oTable.fnGetPosition( tr );
                  var nNodes = oTable.fnGetNodes( );
                 //  alert(nNodes[0].nodeName);
                   
                  // var aPos = oTable.fnGetPosition( tr[0] );
                  //   alert(aPos); 
                   oTable.fnDeleteRow(tr[0]);  
                                     
                   
                });

            
        }
        
	});
}


// [{"id":"5","name":"Test Payee","contact_email":"sample@3balliance.com","phone":"251-604-6831","commission_category_id":null,"other_id_1":"9","status":"Active"}]
function set_payee_search(ctrl_id, url, username, password) {
	access_token = username + ':' + password;
	jQuery(function($) {
		function log(message) {
			return;
			$("<div>").text(message).prependTo("#log");
			$("#log").scrollTop(0);
		}
		$("#find_payee").autocomplete({
			source: function(request, response) {
				$.ajax({
					url: url,
					dataType: "jsonp",
					data: {
						limit: 12,
						q: request.term,
						aretex_ajax_auth: access_token
					},
					success: function(data) {
						response($.map(data, function(item) {
							return {
								label: item.contact_email + ': ' + item.name,
								value: item.name,
                                id: item.id,
                                name: item.name,
								contact_email: item.contact_email,
								phone: item.phone,
                                commission_category_id: item.commission_category_id,
                                wp_id: item.other_id_1,                                                              
                                status: item.status,
                                account_id: item.payee_account_identifier                                
							}
						}));
					}
				});
                
			},
			minLength: 2,
			select: function(event, ui) {
				log(ui.item ? "Selected: " + ui.item.label : "Nothing selected, input was " + this.value);
				if (ui.item) {
				    
                    populate_form(ui.item);
				}
			},
			open: function() {
				$(this).removeClass("ui-corner-all").addClass("ui-corner-top");
			},
			close: function() {
				$(this).removeClass("ui-corner-top").addClass("ui-corner-all");
			}
		});
        
        function populate_form(item) {
            $('#payee_id').val(item.id);
            $('#payee_name').val(item.name);
            $('#payee_email').val(item.contact_email);
            $('#wp_id').val(item.wp_id);
            $('#payee_acct_id').val(item.account_id);
        }
        
	});
}

// atx_validate_tracking_code
function validate_tracking_code(tracking_code) {
    
     var the_validation;
                   
    	
                      
        var data = {
		action: 'atx_validate_tracking_code',        
        tracking_code: tracking_code
	   };
        var the_url;	
        jQuery.ajax({
          type: 'POST',
          url: ajaxurl,
          async: false, // Yes, the A is for Asyncronous
          data: data,
          dataType: 'json', // ... but the X is for XML.
          success: function(data){
            console.log(data);
            the_validation = data;        
          },
          error: function(xhr, type, exception) { 
            // if ajax fails display error alert
            alert("ajax error response type "+type);
          }
        });
                  
      
    
    return the_validation;
    
}

function set_offer_payee_search(ctrl_id,offer_cntl_id, url, username, password) {
	access_token = username + ':' + password;
	jQuery(function($) {
		function log(message) {
			return;
			$("<div>").text(message).prependTo("#log");
			$("#log").scrollTop(0);
		}       
		$("#find_payee").autocomplete({
			source: function(request, response) {
			  var offer_val = $('#'+offer_cntl_id).val();
              var burl = url + '/'+offer_val;
             

				$.ajax({
					url: burl,
					dataType: "jsonp",
					data: {
						limit: 12,
						q: request.term,
						aretex_ajax_auth: access_token
					},
					success: function(data) {
						response($.map(data, function(item) {
							return {
								label: item.contact_email + ': ' + item.name,
								value: item.name,
                                id: item.id,
                                name: item.name,
								contact_email: item.contact_email,
								phone: item.phone,
                                commission_category_id: item.commission_category_id,
                                wp_id: item.other_id_1,                                                              
                                status: item.status                                
							}
						}));
					},
                    error: function(xhr, type, exception) { 
                    // if ajax fails display error alert
                    
                    alert("ajax error exception "+exception);
                  }
				});
                
			},
			minLength: 2,
			select: function(event, ui) {
				log(ui.item ? "Selected: " + ui.item.label : "Nothing selected, input was " + this.value);
				if (ui.item) {
				    
                    populate_form(ui.item);
				}
			},
			open: function() {
				$(this).removeClass("ui-corner-all").addClass("ui-corner-top");
			},
			close: function() {
				$(this).removeClass("ui-corner-top").addClass("ui-corner-all");
			}
		});
        
        function populate_form(item) {
            $('#payee_id').val(item.id);
            $('#payee_name').val(item.name);
            $('#payee_email').val(item.contact_email);
            $('#wp_id').val(item.wp_id);
        }
        
	});
}




function aretex_dbui_SentPayments(config_id,dbui_url,target_div,row_id,auth,call_back) {
    
    load_linked_screen_back('reports/payees/payee_sent_report',row_id,call_back);
    
}

function aretex_dbui_PendingPayments(config_id,dbui_url,target_div,row_id,auth,call_back) {
    
    load_linked_screen_back('reports/payees/payee_pending_report',row_id,call_back);
    
}

function aretex_dbui_Adjust(config_id,dbui_url,target_div,row_id,auth,call_back) {
    
        
    jQuery('#pending_report_main_div').removeClass('span_12_of_12');
    jQuery('#pending_report_main_div').addClass('span_8_of_12');
    jQuery('#pending_report_help_div').show();
    //               config_id,     url,ajax_div,   id,aretex_ajax_auth,cancel_call
    
    call_back = 'reports/payees/payee_pending_report';
    var data='config_id='+config_id+'&cmd=Update&view=Form&id='+row_id+"&aretex_ajax_auth="+auth+'&cancel_call='+call_back;
    var filter_key = jQuery('#filter_key').val();
    if (filter_key)
        data += '&filter_key='+filter_key;

    jQuery.ajax({
      type: 'GET',
      url: dbui_url,
      data: data,
      dataType: 'jsonp',
      success: function(data){
        jQuery(target_div).html(data);
      },
      error: function(xhr, type, exception) { 
        // if ajax fails display error alert
        alert("Ajax Error: Exception: "+exception);
      }
    });   
    
}

function aretex_dbui_Refund(config_id,dbui_url,target_div,row_id,auth,call_back) {
    load_linked_screen('reports/sales/refund',row_id);
   
}

function aretex_dbui_Receipt(config_id,dbui_url,target_div,row_id,auth,call_back) {
   

    jQuery(function ($) {                
    	
                      
        var data = {
		action: 'atx_receipt',        
        receipt_id: row_id
	   };
        var the_url;	
        $.ajax({
          type: 'POST',
          url: ajaxurl,
          async: false, // Yes, the A is for Asyncronous
          data: data,
          dataType: 'json', // ... but the X is for XML.
          success: function(data){
            console.log(data);
            the_url = data; 
            the_url += '?aretex_ajax_auth='+auth;           
          },
          error: function(xhr, type, exception) { 
            // if ajax fails display error alert
            alert("ajax error response type "+type);
          }
        });
        
        window.open(the_url,'_blank');
    
    });  
    
    
    
}

function atx_update_payment(rebill_id){
    jQuery(function ($) {                
    	
                      
        var data = {
		action: 'atx_updatepayment',        
        rebill_id: rebill_id
	   };
        	
    	$.post(ajaxurl, data, function(response) {
    	  var obj = JSON.parse(response);                   
           var post_data = Array();
           post_data['data'] = obj.data;
           atx_admin_postIt(obj.url,post_data);
          
    	});
        
    
    });  
}

function dbui_add_new_payment_form(config_id,url,ajax_div,aretex_ajax_auth,cancel_call)
{

   jQuery('#pending_report_main_div').removeClass('span_12_of_12');
    jQuery('#pending_report_main_div').addClass('span_8_of_12');
    jQuery('#pending_report_help_div').show();
  
    var data='config_id='+config_id+'&cmd=Create&view=Form'+"&aretex_ajax_auth="+aretex_ajax_auth+'&cancel_call='+cancel_call;
    var filter_key = jQuery('#filter_key').val();
    if (filter_key)
        data += '&filter_key='+filter_key;

    
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


// Credit: http://stackoverflow.com/questions/3846271/jquery-submit-post-synchronously-not-ajax
// 
function atx_admin_postIt(url, data){
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

// Product Help Area ...
function hide_product_help() {
    jQuery('#right_product_column').hide();
    jQuery('#left_product_column').removeClass('span_8_of_12');
    jQuery('#left_product_column').addClass('span_12_of_12');
}

function show_product_help(screen) {
    jQuery('#right_product_column').show();
    jQuery('#left_product_column').removeClass('span_12_of_12');
    jQuery('#left_product_column').addClass('span_8_of_12');
    
     load_div_screen('catalog/products/'+screen,'#product_help_box');
}

function load_pricing_help(pm) {
    load_div_screen('catalog/products/price_detail/'+pm,'#price_detail_help');
}

// WordPress User Stuff ...
function set_wpu_search(ctrl_id) {

    url = ajaxurl;
	jQuery(function($) {
		
		$(ctrl_id).autocomplete({
			source: function(request, response) {
				$.ajax({
					url: url,
                    type: 'POST',
					dataType: "json",
					data: {
						limit: 12,
						q: request.term,
						action: 'atx_find_wp_user'
					},
					success: function(data) {
						response($.map(data, function(item) {
							return {
								label: item.username + ': '+item.email,
								value: item.username,
                                wp_id: item.wp_id,
                                email: item.email                                                              
							}
						}));
					}
				});
                
			},
			minLength: 2,
			select: function(event, ui) {
			
				if (ui.item) {
				    
                    populate_form(ui.item);
				}
			},
			open: function() {
				$(this).removeClass("ui-corner-all").addClass("ui-corner-top");
			},
			close: function() {
				$(this).removeClass("ui-corner-top").addClass("ui-corner-all");
			}
		});
        
        function populate_form(item) {
           
            $('#other_id_1').val(item.wp_id);
            $('#wp_user_name').val(item.username);
            $('#contact_email').val(item.email);            
        }
        
	});
}

function load_wp_user_name(wp_id) {
    get_wp_name('#wp_user_name',wp_id);
    
}

function get_wp_name(ctrl_id,wp_id) {
   
	jQuery(function($) {
	   
      var data = {
        action: 'atx_get_wp_user_name',
        wp_id: wp_id
        
      }
       
       $.ajax({
      type: 'POST',
      url: ajaxurl,
      data: data,
      dataType: "json",
      success: function(data){
        // on success use return data here
        $(ctrl_id).val(data);
      },
      error: function(xhr, type, exception) { 
        // if ajax fails display error alert
        alert("ajax error  "+exception);
      }
    });
       
	});
}
