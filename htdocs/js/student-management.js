function load_data(){
    // Populate Table
    $.ajax({
        url: 'php/get-student.php',
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
				 var cell6 = row.insertCell(5);
//                var cell5 = row.insertCell(4);
                cell1.className = "column-admin-checkbox";
                cell2.className = "column-admin-action";
                cell3.className = "column-admin-name";
//                cell3.className = "column-admin-password";
                cell4.className = "column-admin-username";
				 cell5.className = "column-admin-email";
				  cell6.className = "column-admin-mobile";

                row.id = data.admin_name[i];
                var checktext = '<div class="checkbox"><label><input class="chk-delete" type="checkbox"></label></div>';
//                var buttontext = 

//                cell1.innerHTML = checktext;
                $("div>.button-view-profile").clone(true).appendTo($(cell2));
//                $("div>.button-edit-profile").clone(true).appendTo($(cell2));
                $("div>.button-delete-profile").clone(true).appendTo($(cell2));

                cell3.innerHTML = data.admin_name[i];
                cell4.innerHTML = data.admin_username[i];
				cell5.innerHTML = data.admin_email[i];
				cell6.innerHTML = data.admin_mobile[i];

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
                        $("#table-name").text(data.admin_name);
                        $("#table-username").text(data.admin_username);
						$("#table-email").text(data.admin_email);
                        $("#table-mobile").text(data.admin_mobile);
						  $("#table-address").text(data.admin_address);
                        

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

}


load_data();
	
$("#button-confirm-add-admin").click(function () {
    var name = $("#input-name").val();
    var username = $("#input-username").val();
    var password = $("#input-password").val();
	var email = $("#input-email").val();
    var mobile = $("#input-mobile").val();
	 var address = $("#input-address").val();

    $.ajax({
        url: 'php/add-student.php',
        type: 'POST',
        data: {
            name: name,
            username: username,
            password: password,
			email: email,
			mobile: mobile,
            address: address,
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

$("#import").click(function (e) {
	$(".alert").hide();
	e.preventDefault();
	$(this).parents('form').submit();
});
$("#formStudent").submit(function (e){
	e.preventDefault();
	console.log("form submitted");
	var formData = new FormData($(this)[0]);		
	$.ajax({
		url: "php/insert-csv.php",
		type: "POST",
		data: formData,
		success: function (e) {
			$(".alert").removeClass("alert-success").removeClass("alert-danger").addClass('alert-'+e.status).empty().html(e.msg).show();
			if(e.code == 200){
				load_data();
				window.setTimeout(function () {
                $("#student-management").click();
            }, 1000);
			}
		},
		cache: false,
		contentType: false,
		processData: false
	});
		
    // var file = $("#file").val();
 
    // $.ajax({
        // url: 'php/insert-csv.php',
        // type: 'POST',
        // data: {
            // file: file
        // },
        // //data: "parameter=some_parameter",
        // success: function (data)
        // {
            // window.setTimeout(function () {
                // $("#student-management").click();
            // }, 1000);
        // }
    // });

});

$("#button-confirm-delete-admin").click(function () {
    var adminToDelete = $('#admin-to-delete').text();

    $.ajax({
        url: 'php/delete-student.php',
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
                $("#student-management").click();
            }, 1000);
        }
    });
});
