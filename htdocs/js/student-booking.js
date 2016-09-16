$(function () {

    // Populate Table
    $.ajax({
        url: 'php/get-booking-student.php',
        type: 'GET',
        dataType: 'json',
        //data: "parameter=some_parameter",
        success: function (data)
        {
            //alert('content of the executed page: ' + data);
            //var decode_data = jQuery.parseJSON(data);
            console.log(data);
            for (i = 0; i < data.booking_student_id.length; i++) {
                var table = document.getElementById("table-admin-body");
                     var row = table.insertRow(i);
                var cell1 = row.insertCell(0);
                var cell2 = row.insertCell(1);
                var cell3 = row.insertCell(2);
                var cell4 = row.insertCell(3);
				var cell5 = row.insertCell(4);
				var cell6 = row.insertCell(5);
				var cell7 = row.insertCell(6);
				var cell8 = row.insertCell(7);
//                var cell5 = row.insertCell(4);
                cell1.className = "column-admin-checkbox";
                cell2.className = "column-admin-action";
                cell3.className = "column-admin-name";
//                cell3.className = "column-admin-password";
                cell4.className = "column-admin-username";
				 cell5.className = "column-pc-name";
				 cell6.className = "column-start";
				 cell7.className = "column-end";
				  cell8.className = "column-duration";
				 

                row.id = data.booking_student_id[i];
                var checktext = '<div class="checkbox"><label><input class="chk-delete" type="checkbox"></label></div>';
//                var buttontext = 

//                cell1.innerHTML = checktext;
                $("div>.button-view-profile").clone(true).appendTo($(cell2));
//                $("div>.button-edit-profile").clone(true).appendTo($(cell2));
                $("div>.button-delete-profile").clone(true).appendTo($(cell2));

               
                cell3.innerHTML = data.student_name[i];
				 cell4.innerHTML = data.pc_name[i];
				cell5.innerHTML = data.lab_name[i];
				cell6.innerHTML = data.start[i];
				cell7.innerHTML = data.end[i];
				cell8.innerHTML = data.duration[i];
				

            }

            // Enable tooltip CSS
            $('[data-toggle="tooltip"]').tooltip();

            // Initialize button clicks for icons
            $('.button-view-profile').click(function () {
                var adminToView = $(this).closest('tr').attr("id");
                
                $.ajax({
                    url: 'php/view-student.php',
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        adminToView: adminToView
                    },
                    //data: "parameter=some_parameter",
                    success: function (data)
                    {
                        $("#table-name").text(data.booking_student_id);
                        $("#table-username").text(data.admin_username);
                        

                        $('#modal-view-admin').modal('show');
                    }
                });

            });

            $('.button-delete-profile').click(function () {
                var admindelete = $(this).closest('tr').attr("id");
                $('#admin-to-delete').text(admindelete);
                $('#modal-delete-admin').modal('show');
            });


        }
    });

});

$("#button-display-active").click(function () {
    // Populate Table
    $.ajax({
        url: 'php/get-booking-student.php',
        type: 'GET',
        dataType: 'json',
        //data: "parameter=some_parameter",
        success: function (data)
        {
			var table = document.getElementById("table-admin-body");
			$("#table-admin-body").empty();
            //alert('content of the executed page: ' + data);
            //var decode_data = jQuery.parseJSON(data);
            console.log(data);
            for (i = 0; i < data.booking_student_id.length; i++) {
                
                     var row = table.insertRow(i);
                var cell1 = row.insertCell(0);
                var cell2 = row.insertCell(1);
                var cell3 = row.insertCell(2);
                var cell4 = row.insertCell(3);
				var cell5 = row.insertCell(4);
				var cell6 = row.insertCell(5);
				var cell7 = row.insertCell(6);
				var cell8 = row.insertCell(7);
//                var cell5 = row.insertCell(4);
                cell1.className = "column-admin-checkbox";
                cell2.className = "column-admin-action";
                cell3.className = "column-admin-name";
//                cell3.className = "column-admin-password";
                cell4.className = "column-admin-username";
				 cell5.className = "column-pc-name";
				 cell6.className = "column-start";
				 cell7.className = "column-end";
				  cell8.className = "column-duration";
				 

                row.id = data.booking_student_id[i];
                var checktext = '<div class="checkbox"><label><input class="chk-delete" type="checkbox"></label></div>';
//                var buttontext = 

//                cell1.innerHTML = checktext;
                $("div>.button-view-profile").clone(true).appendTo($(cell2));
//                $("div>.button-edit-profile").clone(true).appendTo($(cell2));
                $("div>.button-delete-profile").clone(true).appendTo($(cell2));

               
                cell3.innerHTML = data.student_name[i];
				 cell4.innerHTML = data.pc_name[i];
				cell5.innerHTML = data.lab_name[i];
				cell6.innerHTML = data.start[i];
				cell7.innerHTML = data.end[i];
				cell8.innerHTML = data.duration[i];		

            }

        }
    });

});

$("#button-display-expired").click(function () {
    // Populate Table
    $.ajax({
        url: 'php/get-booking-student-expired.php',
        type: 'GET',
        dataType: 'json',
        //data: "parameter=some_parameter",
        success: function (data)
        {	
			var table = document.getElementById("table-admin-body");
			$("#table-admin-body").empty();
            //alert('content of the executed page: ' + data);
            //var decode_data = jQuery.parseJSON(data);
            console.log(data);
            for (i = 0; i < data.booking_student_id.length; i++) {
                     var row = table.insertRow(i);
                var cell1 = row.insertCell(0);
                var cell2 = row.insertCell(1);
                var cell3 = row.insertCell(2);
                var cell4 = row.insertCell(3);
				var cell5 = row.insertCell(4);
				var cell6 = row.insertCell(5);
				var cell7 = row.insertCell(6);
				var cell8 = row.insertCell(7);
//                var cell5 = row.insertCell(4);
                cell1.className = "column-admin-checkbox";
                cell2.className = "column-admin-action";
                cell3.className = "column-admin-name";
//                cell3.className = "column-admin-password";
                cell4.className = "column-admin-username";
				 cell5.className = "column-pc-name";
				 cell6.className = "column-start";
				 cell7.className = "column-end";
				  cell8.className = "column-duration";
				 

                row.id = data.booking_student_id[i];
                var checktext = '<div class="checkbox"><label><input class="chk-delete" type="checkbox"></label></div>';
//                var buttontext = 

//                cell1.innerHTML = checktext;
                $("div>.button-view-profile").clone(true).appendTo($(cell2));
//                $("div>.button-edit-profile").clone(true).appendTo($(cell2));
                $("div>.button-delete-profile").clone(true).appendTo($(cell2));

               
                cell3.innerHTML = data.student_name[i];
				 cell4.innerHTML = data.pc_name[i];
				cell5.innerHTML = data.lab_name[i];
				cell6.innerHTML = data.start[i];
				cell7.innerHTML = data.end[i];
				cell8.innerHTML = data.duration[i];		

            }

        }
    });

});

$("#button-confirm-add-admin").click(function () {
    var name = $("#input-name").val();
    var username = $("#input-username").val();
    var password = $("#input-password").val();

    $.ajax({
        url: 'php/add-student.php',
        type: 'POST',
        data: {
            name: name,
            username: username,
            password: password,
        },
        //data: "parameter=some_parameter",
        success: function (data)
        {
            $('#modal-add-admin').modal('hide');
            window.setTimeout(function () {
                $("#student-management").click();
            }, 1000);
        }
    });

});

$("#button-confirm-delete-admin").click(function () {
    var adminToDelete = $('#admin-to-delete').text();

    $.ajax({
        url: 'php/delete-booking-student.php',
        type: 'POST',
        data: {
            adminToDelete: adminToDelete
        },
        //data: "parameter=some_parameter",
        success: function (data)
        {
//                alert(data);
            $('#modal-delete-admin').modal('hide');
            window.setTimeout(function () {
                $("#student-booking").click();
            }, 1000);
        }
    });
});
