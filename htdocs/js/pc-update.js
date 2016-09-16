/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
var getUrlParameter = function getUrlParameter(sParam) {
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
};
function updateMap(lab_id, refresh_min) {

    var refresh_msec = refresh_min * 60 * 1000;
	var data_table = "";
		
    console.log('refresh');
    $.ajax({
        url: 'php/ajaxquery.php',
        type: 'GET',
        dataType: 'json',
        //data: "parameter=some_parameter",
        data: {
            lab_id: lab_id,
            arrayTime: arrayTime
        },
        success: function (data)
        {
			
			var data_table = "<thead><tr><td><b>PC Name</b></td><td><b>Student Name</b></td><td><b>Start Booking</b></td><td><b>End Booking</b></td></tr></thead>";
		$.ajax({
						url: 'php/bookingget.php?labname=' + lab_id,
						type: 'GET',
						dataType: 'JSON',
						success: function (data) {
							console.log(data);
							for (var i =0; i<data.length; i++){
							 data_table +="<tr> <td> "+data[i].computer_name+"</td> <td> "+data[i].student_name+"</td><td> "+data[i].start_booking+"</td><td> "+data[i].end_booking+"</td></tr>";
						 }
						  $('#testing').html(data_table); 
							
						}


		});

//            console.log(data); // For troubleshooting, use this
            console.log(data.this_time);

            updatePC(data.status_name, data.booked);
//            // $("#SERVERPARK").html(data);

            // Update the "Overall" Chart
            allChart.segments[0].value = data.no_shutdown;
            allChart.segments[1].value = data.no_notavail;
            allChart.segments[2].value = data.no_busy;
            allChart.segments[3].value = data.no_avail;
            allChart.update();
			
            // Update the "Current" Chart
			var tech = getUrlParameter('map');
            currentChart.segments[0].value = data.this_shutdown;
            currentChart.segments[1].value = data.this_notavail;
            currentChart.segments[2].value = data.this_busy;
            currentChart.segments[3].value = data.this_avail;
			document.getElementById("free").innerHTML = data.this_avail;
			document.getElementById("busy").innerHTML =  data.this_busy;
			document.getElementById("booked").innerHTML =  data.this_notavail;
			document.getElementById("off").innerHTML = data.this_shutdown;
            currentChart.update();
			
            // Update Level 1 Progress Bar           
            for (var idx_group = 0; idx_group < data.lab_group.length; idx_group++) {
                var selector = "#progress-group-" + data.lab_group[idx_group].replace(/\s+/g, "-");
                // Bar Numbers
                $(selector).find(".vacant-pc-text").text(data.lab_group_unavail[idx_group]);
                $(selector).find(".total-pc-text").text(data.lab_group_total[idx_group]);

                // Progress Bar
                var progress = data.lab_group_unavail[idx_group] / data.lab_group_total[idx_group] * 100;
                $(selector).find(".progress-bar").css("width", progress + "%");
//                barUpdateColor($(selector).find(".progress-bar"), progress);
            }

            // Update Level 2 Progress Bar
            for (var idx_lab = 0; idx_lab < data.lab_name.length; idx_lab++) {
                var selector = "#progress-lab-" + data.lab_name[idx_lab].replace(/\s+/g, "-");
                // Bar Numbers
                $(selector).find(".vacant-pc-text").text(data.lab_name_unavail[idx_lab]);
                $(selector).find(".total-pc-text").text(data.lab_name_total[idx_lab]);

                // Progress Bar
                var progress = data.lab_name_unavail[idx_lab] / data.lab_name_total[idx_lab] * 100;
                $(selector).find(".progress-bar").css("width", progress + "%");
//                barUpdateColor($(selector).find(".progress-bar"), progress);
            }

            // Update Daily Schedule
            $('tr > .table-avail').each(function (index) {
                $(this).text(data.this_time[index]);
                $(this).attr('data-schedule',data.this_time[index]);
//                console.log(data.this_time);
            });
            
            // Update Time
            $("#current-date").html(data.current_date);
            $("#current-time").html(data.current_time);
        },
        complete: function () {
            // Only allow one time out instance
            if (typeof timeouthandle !== 'undefined') {
                clearTimeout(timeouthandle);
            }
            timeouthandle = setTimeout(function () {
                updateMap(lab_id, refresh_min);
            }, refresh_msec);
        }
    });
}

function updatePC(myData, booked) {
    //    var div = document.getElementById("dom-target");
    //    var myData = div.textContent;
    //    console.log(myData);
    var splitData = myData.split(",");
    for (i = 0; i <= splitData.length - 2; i++) {
        if (booked) {

            var comp_id = splitData[i].slice(2);
            //console.log(comp_id + ' not-available');
            setBgImageById(comp_id, 'booked');

        } else {

            if (splitData[i][0] == 0) {
                var comp_id = splitData[i].slice(2);
                //console.log(comp_id + ' available');
                setBgImageById(comp_id, 'free');
            } else if (splitData[i][0] == 1) {
                var comp_id = splitData[i].slice(2);
                //console.log(comp_id + ' not-available');
                setBgImageById(comp_id, 'busy');
            } else if (splitData[i][0] == 3) {
                var comp_id = splitData[i].slice(2);
                //console.log(comp_id + ' not-available');
                setBgImageById(comp_id, 'off');
            }else if (splitData[i][0] == 4) {
                var comp_id = splitData[i].slice(2);
                //console.log(comp_id + ' not-available');
                setBgImageById(comp_id, 'booked');
            }
        }

    }
}


function setBgImageById(id, status) {
//    var elem;
//    if (document.getElementById) {
//        if (elem = document.getElementById(id)) {
//            if (elem.style) {
//                elem.style.backgroundColor = sColor;
//                return 1;  // success
//            }
//        }
//    }
//    return 0;  // failure
    var elem = "#" + id;
    if ($(elem).hasClass('PC')) {

        if (!($(elem).hasClass('PC-status-' + status))) {

//            console.log($(elem).attr("class"));
            var theClass = strMatchClass('PC-status', $(elem).attr("class"));
            $(elem).toggleClass("PC-status-" + status + " " + theClass);
        }
    } else if ($(elem).hasClass('MAC')) {
        if (!($(elem).hasClass('MAC-status-' + status))) {
            // if dont have class, toggle
            var theClass = strMatchClass('MAC-status', $(elem).attr("class"));
            $(elem).toggleClass("MAC-status-" + status + " " + theClass);
        }
    }
}

// if Classname starts with str, return Classname
function strMatchClass(str, classname) {
    var classes = classname.split(" ");
//    console.log(classes.length);
//    console.log(classes);
    for (var i = 0; i < classes.length; i++) {
        if (classes[i].startsWith(str)) {
            return classes[i];
        }
    }
}

function barUpdateColor(selector, percentage) {
    if (percentage > 0 && percentage <= 25) {
        $(selector).attr('class', 'progress-bar progress-bar-green');
    } else if (percentage > 25 && percentage <= 50) {
        $(selector).attr('class', 'progress-bar progress-bar-aqua');
    } else if (percentage > 50 && percentage <= 75) {
        $(selector).attr('class', 'progress-bar progress-bar-yellow');
    } else {
        $(selector).attr('class', 'progress-bar progress-bar-red');
    }
}