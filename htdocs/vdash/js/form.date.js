(function($) {
	var toSystemFormat = function(currentFormat) {
		var dateTokens = ["M", "D", "d", "Y", "g", "G"];
		var timeTokens = ["A", "a", "H", "h", "m", "s", "S"];
		var hasDate = false;
		var hasTime = false;
		var systemFormat = "";
		
		for ( var i = 0; i < dateTokens.length; i ++ ) {
			var token = dateTokens[i];
			var regex = new RegExp(token);
			
			if ( currentFormat.match(regex) ) {
				hasDate = true;
				break ;
			}
		}
		
		for ( var i = 0; i < timeTokens.length; i ++ ) {
			var token = timeTokens[i];
			var regex = new RegExp(token);
			
			if ( currentFormat.match(regex) ) {
				hasTime = true;
				break ;
			}
		}
		
		if ( hasDate ) {
			systemFormat = "YYYY-MM-DD";
		}
		
		if ( hasTime ) {
			if ( $.trim(systemFormat) != "" ) {
				systemFormat += " ";
			}
			
			systemFormat += "HH:mm:ss";
		}
		
		return systemFormat;
	};
	
	$(".bootstrap-datepicker").each(function() {
		var dateField = $(this).find("input[type=\"text\"]:first");
		var systemField = $(this).find("input[type=\"hidden\"]:first");
		
		if ( dateField.length ) {
			var options = $(dateField).data();
			
			if ( typeof(options) != "object" ) {
				options = {};
			}
			
			if ( typeof(options.format) == "undefined" ) {
				// By default, it's only show date without time.
				options.format = "D/M/YYYY";
			}
			
			$(dateField).on("dp.change", function() {
				// Copy the date to system field.
				if ( systemField.length ) {
					var currentFormat = $(this).data("DateTimePicker").format();
					var dateObject = $(this).data("DateTimePicker").date();
					
					if ( null === dateObject ) {
						var systemDate = "";
					} else {
						var systemFormat = toSystemFormat(currentFormat);
						var systemDate = dateObject.format(systemFormat);
					}
					
					$(systemField).val(systemDate);
				}
			});
			
			$(dateField).datetimepicker(options);
			
			// Initialize the value from the system date.
			if ( systemField.length && $(systemField).val() != "" ) {
				var currentFormat = $(dateField).data("DateTimePicker").format();
				var dateObject = $(dateField).data("DateTimePicker").date();
				var systemFormat = toSystemFormat(currentFormat);
				var dateObject = moment($(systemField).val(), systemFormat);
				
				$(dateField).data("DateTimePicker").date(dateObject);
			}
		}
	});
})(jQuery);