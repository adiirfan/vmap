(function($) {
	$("[data-toggle='slimscroll']").each(function() {
		var options = $(this).data();
		
		$(this).slimScroll(options);
	});
})(jQuery);