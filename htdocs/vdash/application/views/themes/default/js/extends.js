jQuery.getUriParameter = function(sParam) {
	if ( sParam === undefined ) {
		var search = location.search.substring(1);
		
		if ( search == "" ) {
			return null;
		} else {
			return JSON.parse('{"' + decodeURI(search).replace(/"/g, '\\"').replace(/&/g, '","').replace(/=/g,'":"') + '"}');
		}
	} else {
		var sPageURL = decodeURIComponent(window.location.search.substring(1)),
		    sURLVariables = sPageURL.split('&'),
		    sParameterName,
		    i;
		
		for (i = 0; i < sURLVariables.length; i++) {
		    sParameterName = sURLVariables[i].split('=');
		
		    if (sParameterName[0] === sParam) {
		        return sParameterName[1] === undefined ? true : sParameterName[1];
		    }
		}
		
		return null;
	}
};

jQuery.encodeURI = function(params) {
	var components = [];
	
	for ( var i in params ) {
		components.push(i + "=" + encodeURIComponent(params[i]));
	}
	
	return components.join("&");
};