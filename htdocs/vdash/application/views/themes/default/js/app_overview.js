(function($) {
	$("#dropdown-date").change(function(e) {
		var value = $(this).val();
		var param = $.getUriParameter();
		
		if ( !param ) {
			param = {};
		}
		
		param["date"] = value;
		
		var uri = $.encodeURI(param);
		var url = baseurl + "app/overview?" + uri;
		
		window.location = url;
	});
	
	var businessDropdown = $("#dropdown-business");
	
	if ( businessDropdown.length ) {
		$(businessDropdown).change(function(e) {
			var value = $(this).val();
			var param = $.getUriParameter();
			
			if ( !param ) {
				param = {};
			}
			
			param["business"] = value;
			
			var uri = $.encodeURI(param);
			var url = baseurl + "app/overview?" + uri;
			
			window.location = url;
		});
	}
	
	/*
	 * Application Usage Activity Chart
	 */
	var drawChart = function(columns, rows) {
		var div = $("#graph-area");
		var data = new google.visualization.DataTable();
		var chart = new google.visualization.LineChart(div.get(0));
		var options = {
			width: "100%",
			pointSize: 5,
			legend: {
				position: "none"
			},
			//curveType: "function",
			chartArea: {
				width: "90%",
				height: "70%"
			}
		};
		
		for ( var i in columns ) {
			var col = columns[i];
			
			data.addColumn(col[0], col[1]);
		}
		
		data.addRows(rows);
		
		chart.draw(data, options);
	};
	
	var loadChartData = function(start, end) {
		var business = $("#dropdown-business");
		var businessId = 0;
		
		if ( business.length ) {
			businessId = $(business).val();
			
			if ( businessId == "" ) {
				businessId = 0;
			}
		}
		
		$("#graph-loading").removeClass("hidden");
		
		$.ajax({
			url: baseurl + "app/a_load_app_usage",
			type: "get",
			dataType: "json",
			data: {
				date_start: start,
				date_end: end,
				business: businessId,
				token: clientId
			},
			success: function(data) {
				if ( !data.error && data.result ) {
					var result = data.result;
					drawChart(result.columns, result.data);
				}
			},
			error: function(xhr, error, message) {
				
			},
			complete: function() {
				$("#graph-loading").addClass("hidden");
			}
		});
	};
	
	google.load("visualization", "1.0", {"packages" : ["corechart"]});
	
	google.setOnLoadCallback(function() {
		//loadChartData(moment().format("YYYY-MM-DD"));
		
		$(".calendar-box").each(function() {
			var box = this;
			
			var dateSelected = function(start, end) {
				var date1 = start.format("D MMMM, YYYY");
				var date2 = end.format("D MMMM, YYYY");
				
				if ( date1 != date2 ) {
					$(box).find(".calendar-text").html(date1 + " - " + date2);
					
					loadChartData(start.format("YYYY-MM-DD"), end.format("YYYY-MM-DD"));
				} else {
					$(box).find(".calendar-text").html(date1);
					loadChartData(start.format("YYYY-MM-DD"));
				}
			};
			
			dateSelected(moment(), moment());
			
			$(this).daterangepicker({
				ranges: {
		           'Today': [moment(), moment()],
		           'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
		           'Last 7 Days': [moment().subtract(6, 'days'), moment()],
		           'Last 30 Days': [moment().subtract(29, 'days'), moment()],
		           'This Month': [moment().startOf('month'), moment().endOf('month')],
		           'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
		        }
			}, dateSelected);
		});
	});
})(jQuery);