(function($) {
	$("#per-page").change(function(e) {
		var uriParams = $.getUriParameter();
		var perPage = $(this).val();
		var path = window.location.protocol + window.location.pathname;
		
		if ( !uriParams ) {
			uriParams = {};
		}
		
		uriParams["per_page"] = perPage;
		
		var url = path + "?" + $.encodeURI(uriParams);
		
		window.location = url;
	});
})(jQuery);