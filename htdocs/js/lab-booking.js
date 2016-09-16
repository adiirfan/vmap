$(function () {

    // Populate Table
    $.ajax({
        url: 'php/get-booking-lab.php',
        type: 'GET',
        dataType: 'json',
        //data: "parameter=some_parameter",
        success: function (data)
        {
            //alert('content of the executed page: ' + data);
            //var decode_data = jQuery.parseJSON(data);
            console.log(data);
            for (i = 0; i < data.lab_name.length; i++) {
                var table = document.getElementById("table-admin-body");
                     var row = table.insertRow(i);
                var cell1 = row.insertCell(0);
                var cell2 = row.insertCell(1);
                var cell3 = row.insertCell(2);
                var cell4 = row.insertCell(3);
//                var cell5 = row.insertCell(4);
                cell1.className = "column-admin-checkbox";
                cell2.className = "column-admin-action";
				 cell3.className = "column-admin-labname";
				 cell4.className = "column-admin-labmax";
				 

                row.id = data.lab_name[i];
				row.className = data.lab_id[i];
                var checktext = '<div class="checkbox"><label><input class="chk-delete" type="checkbox"></label></div>';
//                var buttontext = 

//                cell1.innerHTML = checktext;
                $("div>.button-view-profile").clone(true).appendTo($(cell2));
//                $("div>.button-edit-profile").clone(true).appendTo($(cell2));
                $("div>.button-delete-profile").clone(true).appendTo($(cell2));

               
             
				cell3.innerHTML = data.lab_name[i];
				cell4.innerHTML = data.lab_max[i];
				

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
				var admindeleteclass = $(this).closest('tr').attr("class");
                $('#admin-to-delete').text(admindelete);
				$('#hiddeninput').val(admindeleteclass);
                $('#modal-delete-admin').modal('show');
            });


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
