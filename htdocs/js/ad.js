$(function () {

    // Populate Table
    $.ajax({
        url: 'php/get-ad.php',
        type: 'GET',
        dataType: 'json',
        //data: "parameter=some_parameter",
        success: function (data)
        {
            //alert('content of the executed page: ' + data);
            //var decode_data = jQuery.parseJSON(data);
            console.log(data);
            for (i = 0; i < data.ad_id.length; i++) {
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
			//	var cell9 = row.insertCell(8);
//                var cell5 = row.insertCell(4);
                cell1.className = "column-admin-checkbox";
                cell2.className = "column-admin-action";
                cell3.className = "column-admin-name";
//                cell3.className = "column-admin-password";
                cell4.className = "column-admin-username";
				cell5.className = "column-pc-name";
				cell6.className = "column-start";
				cell7.className = "column-end";
			//	cell8.className = "column-duration";
				cell8.className = "column-hasil";
				 

                row.id = data.ad_id[i];
                var checktext = '<div class="checkbox"><label><input class="chk-delete" type="checkbox"></label></div>';
//                var buttontext = 

//                cell1.innerHTML = checktext;
                $("div>.button-view-profile").clone(true).appendTo($(cell2));
//                $("div>.button-edit-profile").clone(true).appendTo($(cell2));
                $("div>.button-delete-profile").clone(true).appendTo($(cell2));

               
                cell3.innerHTML = data.account_suffix[i];
				 cell4.innerHTML = data.domain_controllers_1[i];
				cell5.innerHTML = data.domain_controllers_2[i];
				cell6.innerHTML = data.base_dn[i];
				cell7.innerHTML = data.admin_username[i];
				//cell8.innerHTML = '******';
				cell8.innerHTML = data.hasil[i];
            }

            // Enable tooltip CSS
            $('[data-toggle="tooltip"]').tooltip();

            // Initialize button clicks for icons
            $('.button-view-profile').click(function () {
				var adminToView=$(this).closest('tr').attr("id");
				if(adminToView == null){
                var adminToView = 0;
				}
             //   alert(adminToView);
                $.ajax({
                    url: 'php/view-ad.php',
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        adminToView: adminToView
                    },
                    //data: "parameter=some_parameter",
                    success: function (data)
                    {
                        $("#input-id").val(data.ad_id);
						$("#input-suffix").val(data.account_suffix);
                        $("#input-username").val(data.admin_username);
						$("#input-controller-1").val(data.domain_controllers_1);
						$("#input-controller-2").val(data.domain_controllers_2);
						$("#input-base").val(data.base_dn);
						$("#input-password").val(data.admin_password);
						$("#input-category").val(data.category_ad);
						
                        $('#modal-add-admin').modal('show');
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
    var suffix = $("#input-suffix").val();
	//alert(suffix);
	var id = $("#input-id").val();
    var controller_1 = $("#input-controller-1").val();
    var controller_2 = $("#input-controller-2").val();
	 var base = $("#input-base").val();
	  var username = $("#input-username").val();
	   var pass = $("#input-password").val();
	    var category = $("#input-category").val();
	  
	   
	// alert(suffix+controller_1+controller_2+base+username+pass);

    $.ajax({
        url: 'php/add-ad.php',
        type: 'POST',
        data: {
			id: id,
            suffix: suffix,
            controller_1: controller_1,
            controller_2: controller_2,
			base: base,
			username: username,
			pass: pass,
			category: category,
        },
        //data: "parameter=some_parameter",
        success: function (data)
        {
            $('#modal-add-admin').modal('hide');
			//alert(data);
            window.setTimeout(function () {
                $("#configad").click();
            }, 1000);
        }
    });

});

$("#button-confirm-delete-admin").click(function () {
    var adDelete = $('#admin-to-delete').text();
//alert(adDelete);
    $.ajax({
        url: 'php/delete-ad.php',
        type: 'POST',
        data: {
            adDelete: adDelete,
        },
        //data: "parameter=some_parameter",
        success: function (data)
        {
               // alert(data);
            $('#modal-delete-admin').modal('hide');
            window.setTimeout(function () {
                $("#configad").click();
            }, 1000);
        }
    });
});
