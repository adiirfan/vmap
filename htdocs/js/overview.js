/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
document.getElementById("demo3").innerHTML =rowling;
document.getElementById("demo2").innerHTML = line;
$.ajax({
    url: 'php/get-overview.php',
    type: 'GET',
    dataType: 'json',
    //data: "parameter=some_parameter",
    success: function (data)
    {
        //alert('content of the executed page: ' + data);
        //var decode_data = jQuery.parseJSON(data);
        console.log(data);
		
		var k=0;
        for (i=0;i<data.lab_name.length;i++){
            var table = document.getElementById("table-lab-body");
            var row = table.insertRow(i);
            var cell1 = row.insertCell(0);
            var cell2 = row.insertCell(1);
            var cell3 = row.insertCell(2);
            var cell4 = row.insertCell(3);
            
            cell1.className = "column-lab-name";
            cell2.className = "column-lab-usage";
            cell3.className = "column-station-available";
            cell4.className = "column-lab-description";
            // evaluating text for progress bar
            var progress = Math.round(100 - (data.pc_avail[i]/data.pc_total[i]*100));
            var bartext = '<div class="progress" style="margin-bottom: 0"><div class="progress-bar" role="progressbar" style="width:'+progress+'%;">'+progress+'%</div></div>';
            
            cell1.innerHTML = data.lab_name[i];
            cell2.innerHTML = bartext;
            cell3.innerHTML = data.pc_avail[i] +'/' + data.pc_total[i];
			cell4.innerHTML = data.description[i];
			
        }
		var tot= data.max;
		var pake= data.count;
		var sisa = rowling;
		
        

		CountDownTimer('02/19/2012 10:1 AM', 'countdown');
		CountDownTimer(data.tanggalasli, 'newcountdown'+data.beda);

		function CountDownTimer(dt, id)
		{
			var end = new Date(dt);

			var _second = 1000;
			var _minute = _second * 60;
			var _hour = _minute * 60;
			var _day = _hour * 24;
			var timer;

			function showRemaining() {
				var now = new Date();
				var distance = end - now;
				if (distance < 0) {

					clearInterval(timer);
					document.getElementById(id).innerHTML = 'EXPIRED!';

					return;
				}
				var days = Math.floor(distance / _day);
				var hours = Math.floor((distance % _day) / _hour);
				var minutes = Math.floor((distance % _hour) / _minute);
				var seconds = Math.floor((distance % _minute) / _second);

				document.getElementById(id).innerHTML = days + 'days ';
				document.getElementById(id).innerHTML += hours + 'hrs ';
				document.getElementById(id).innerHTML += minutes + 'mins ';
				document.getElementById(id).innerHTML += seconds + 'secs';
			}

			timer = setInterval(showRemaining, 1000);
		}



       
			o = data.busy;
			l = data.off;
			m = data.avail;
		  google.charts.load('current', {'packages':['corechart']});
		  google.charts.setOnLoadCallback(drawChart);
		  function drawChart() {

			var data = google.visualization.arrayToDataTable([
			  ['Task', 'Hours per Day'],
			  ['Busy',     o],
			  ['Off',      l],
			  ['Available',  m]
			
			]);

			var options = {
			  title: 'Daily Usage'
			};

			var chart = new google.visualization.PieChart(document.getElementById('piechart'));

			chart.draw(data, options);
		  }
		
    }
});



