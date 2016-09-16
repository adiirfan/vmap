$(function () {

    // Populate Table
    $.ajax({
        url: 'php/get-admin.php',
        type: 'GET',
        dataType: 'json',
        //data: "parameter=some_parameter",
        success: function (data)
        {
            //alert('content of the executed page: ' + data);
            //var decode_data = jQuery.parseJSON(data);
            console.log(data);
            for (i = 0; i < data.admin_name.length; i++) {
                var table = document.getElementById("table-admin-body");
                var row = table.insertRow(i);
                var cell1 = row.insertCell(0);
                var cell2 = row.insertCell(1);
                var cell3 = row.insertCell(2);
                var cell4 = row.insertCell(3);
                var cell5 = row.insertCell(4);
//                var cell5 = row.insertCell(4);
                cell1.className = "column-admin-checkbox";
                cell2.className = "column-admin-action";
                cell3.className = "column-admin-name";
//                cell3.className = "column-admin-password";
                cell4.className = "column-admin-privilege";
                cell5.className = "column-admin-email";

                row.id = data.admin_name[i];
                var checktext = '<div class="checkbox"><label><input class="chk-delete" type="checkbox"></label></div>';
//                var buttontext = 

//                cell1.innerHTML = checktext;
                $("div>.button-view-profile").clone(true).appendTo($(cell2));
//                $("div>.button-edit-profile").clone(true).appendTo($(cell2));
                $("div>.button-delete-profile").clone(true).appendTo($(cell2));

                cell3.innerHTML = data.admin_name[i];
                cell4.innerHTML = data.admin_privilege[i];
                cell5.innerHTML = data.admin_email[i];

            }

            // Enable tooltip CSS
            $('[data-toggle="tooltip"]').tooltip();

            // Initialize button clicks for icons
            $('.button-view-profile').click(function () {
                var adminToView = $(this).closest('tr').attr("id");
                
                $.ajax({
                    url: 'php/view-admin.php',
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        adminToView: adminToView
                    },
                    //data: "parameter=some_parameter",
                    success: function (data)
                    {
                        $("#table-username").text(data.admin_name);
                        $("#table-firstname").text(data.admin_firstname);
                        $("#table-lastname").text(data.admin_lastname);
                        $("#table-staffID").text(data.admin_staffID);
                        $("#table-email").text(data.admin_email);
                        $("#table-privilege").text(data.admin_privilege);
                        

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

$("#button-confirm-add-admin").click(function () {
    var username = $("#input-username").val();
    var firstname = $("#input-firstname").val();
    var lastname = $("#input-lastname").val();
    var staffID = $("#input-staffID").val();
    var email = $("#input-email").val();
    var password = $("#input-password").val();
    var privilege = $("#select-privilege option:selected").text();

    $.ajax({
        url: 'php/add-admin.php',
        type: 'POST',
        data: {
            username: username,
            firstname: firstname,
            lastname: lastname,
            staffID: staffID,
            email: email,
            password: password,
            privilege: privilege
        },
        //data: "parameter=some_parameter",
        success: function (data)
        {
            $('#modal-add-admin').modal('hide');
            window.setTimeout(function () {
                $("#admin-management").click();
            }, 1000);
        }
    });

});

$("#button-confirm-delete-admin").click(function () {
    var adminToDelete = $('#admin-to-delete').text();

    $.ajax({
        url: 'php/delete-admin.php',
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
                $("#admin-management").click();
            }, 1000);
        }
    });
});
