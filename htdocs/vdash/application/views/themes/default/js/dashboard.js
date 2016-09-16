(function($) {
	$(document).on("chart.initialized", function(e, charts) {
		// Bind the machine group changed.
		$("#dropdown-machine-group").change(function(e) {
			var value = $(this).val();
			var url = baseurl + "dashboard?machine_group=" + encodeURIComponent(value);
			
			window.location = url;
		});
		
		// Bind the click event on application usage statistics.
		$("#application-usage-period .list-group-item").click(function(e) {
			e.preventDefault();
			
			var list = $(this).parent();
			var period = $(this).data("period");
			$(list).find(".list-group-item").removeClass("active");
			$(this).addClass("active");
			
			$("#modal-loading").modal("show");
			
			var url = baseurl + "dashboard/a_app_usage";
			
			$.ajax({
				url: url,
				type: "get",
				dataType: "json",
				data: {
					code: clientId,
					date: period,
					machine_group: $("#dropdown-machine-group").val()
				},
				success: function(data) {
					var appData = data.data;
					
					if ( appData ) {
						var chartData = appData.chart_data;
						var chartDate = appData.date;
						
						if ( !chartData ) {
							chartData = [];
						}
						
						var chart = charts["app_usage"];
						var d = new google.visualization.DataTable();
						var columns = $(".chart[data-name=app_usage]").data("columns");
						var options = $(".chart[data-name=app_usage]").data("options");
						
						if ( columns ) {
							for ( var i = 0; i < columns.length; i ++ ) {
								var col = columns[i];
								d.addColumn(col[0], col[1]);
							}
							
							d.addRows(chartData);
							
							chart.draw(d, options);
						}
						
						// Update the chart date.
						var dateString = "";
						
						if ( $.isArray(chartDate) ) {
							dateString = chartDate[0] + " - " + chartDate[1];
						} else {
							dateString = chartDate;
						}
						
						$("#app-chart-title").html(dateString);
						
						// Top apps.
						var topApps = appData.top_apps;
						
						$("#top-apps .item-list").empty();
						
						if ( topApps && topApps.length ) {
							for ( var i = 0; i < topApps.length; i ++ ) {
								var app = topApps[i];
								var appName = app.name;
								var instances = app.instance_word;
								var li = $("<li></li>");
								var htmlName = $("<span></span>").addClass("item-title").html(appName);
								var htmlSubLine = $("<span></span>").addClass("sub-line").html(instances);
								$(li).append(htmlName).append(htmlSubLine);
								
								$("#top-apps .item-list").append(li);
							}
							
							$("#top-apps .no-result").addClass("hidden");
						} else {
							$("#top-apps .item-list").empty();
							$("#top-apps .no-result").removeClass("hidden");
						}
					}
				},
				error: function(xhr, error, message) {
					alert(message);
				},
				complete: function() {
					$("#modal-loading").modal("hide");
				}
			});
		});
		
		// Bind the click event on application usage statistics.
		$("#machine-usage-period .list-group-item").click(function(e) {
			e.preventDefault();
			
			var list = $(this).parent();
			var period = $(this).data("period");
			$(list).find(".list-group-item").removeClass("active");
			$(this).addClass("active");
			
			$("#modal-loading").modal("show");
			
			var url = baseurl + "dashboard/a_machine_usage";
			
			$.ajax({
				url: url,
				type: "get",
				dataType: "json",
				data: {
					code: clientId,
					date: period,
					machine_group: $("#dropdown-machine-group").val()
				},
				success: function(data) {
					var machineData = data.data;
					
					if ( machineData ) {
						var chartData = machineData.chart_data;
						var chartDate = machineData.date;
						
						if ( !chartData ) {
							chartData = [];
						}
						
						var chart = charts["machine_usage"];
						var d = new google.visualization.DataTable();
						var columns = $(".chart[data-name=machine_usage]").data("columns");
						var options = $(".chart[data-name=machine_usage]").data("options");
						
						if ( columns ) {
							for ( var i = 0; i < columns.length; i ++ ) {
								var col = columns[i];
								d.addColumn(col[0], col[1]);
							}
							
							d.addRows(chartData);
							
							chart.draw(d, options);
						}
						
						// Update the chart date.
						var dateString = "";
						
						if ( $.isArray(chartDate) ) {
							dateString = chartDate[0] + " - " + chartDate[1];
						} else {
							dateString = chartDate;
						}
						
						$("#machine-chart-title").html(dateString);
						
						// Top apps.
						var topApps = machineData.top_apps;
						
						$("#machine-apps .item-list").empty();
						if ( topApps && topApps.length ) {
							for ( var i = 0; i < topApps.length; i ++ ) {
								var app = topApps[i];
								var appName = app.name;
								var instances = app.instance_word;
								var li = $("<li></li>");
								var htmlName = $("<span></span>").addClass("item-title").html(appName);
								var htmlSubLine = $("<span></span>").addClass("sub-line").html(instances);
								$(li).append(htmlName).append(htmlSubLine);
								
								$("#machine-apps .item-list").append(li);
							}
							
							$("#machine-apps .no-result").addClass("hidden");
						} else {
							$("#machine-apps .no-result").removeClass("hidden");
						}
					}
				},
				error: function(xhr, error, message) {
					alert(message);
				},
				complete: function() {
					$("#modal-loading").modal("hide");
				}
			});
		});
	});
})(jQuery);