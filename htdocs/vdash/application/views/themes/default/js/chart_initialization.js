(function($) {
	var charts = {};
	
	var drawCharts = function() {
		var index = 0;
		
		$(".chart").each(function() {
			var data = new google.visualization.DataTable();
			var columns = $(this).data("columns");
			var rows = $(this).data("data");
			var options = $(this).data("options");
			var chartType = $(this).data("chart");
			var div = $(this).get(0);
			var name = $(this).data("name");
			
			if ( columns ) {
				for ( var i = 0; i < columns.length; i ++ ) {
					var col = columns[i];
					data.addColumn(col[0], col[1]);
				}
			}
			
			data.addRows(rows);
			
			var chart = null;
			
			switch ( chartType ) {
				case "piechart":
					chart = new google.visualization.PieChart(div);
					break;
				case "linechart":
					chart = new google.visualization.LineChart(div);
					break;
				case "columnchart":
					chart = new google.visualization.ColumnChart(div);
					break;
			}
			
			// Assign the chart object as data attribute to the div.
			$(div).data("chart-api", chart);
			
			// Assign the chart object to the charts list.
			if ( chart ) {
				if ( options ) {
					chart.draw(data, options);
				} else {
					chart.draw(data);
				}
				
				if ( name && name != "" ) {
					charts[name] = chart;
				} else {
					charts[index] = chart;
					
					index ++;
				}
			}
		});
		
		// Trigger the window event.
		$(document).trigger("chart.initialized", [charts]);
	};
	
	// Initialize google chart.
	google.load("visualization", "1.0", {"packages" : ["corechart"]});
	
	google.setOnLoadCallback(drawCharts);
})(jQuery);