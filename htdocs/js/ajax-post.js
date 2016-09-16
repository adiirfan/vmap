$("#submit").click(function () {
	var lab=$("#lab").val();
    if ($("#password").val() == "") {
        return;
    }
    if ($("#username").val() == "") {
        return;
    }
	var pc= $("#pc").val();
    $.ajax({
        type: "POST",
        url: "/login_action.php",
		dataType: 'json',
        data: {
            username: $("#username").val(),
            password: $("#password").val()
			
        },
        success: function (data) {
            //console.log(data);
			if (data.status_login == 1) {
				
				if(data.level == 2){
					if(lab == 1){
					$('#login').modal('hide'); 
					
					$('#lab_booking').modal('show'); 
					}else {
					location.href = "/demo/booking.php?pc="+pc;
					}
					
				}else{
						if (lab == 1 && data.level == 1){
						$('#login').modal('hide'); 
						alert('Student cannot book lab ');
						//$('#cannot-book').modal('show'); 
						
						}else {
						location.href = "/booking.php?pc="+pc;
						}
				
				}
				
			document.getElementById("level_tes").innerHTML = data.level;
			document.getElementById("sesion").innerHTML = data.status_login;
			document.getElementById("user_id").innerHTML = data.user_id;				
			
            } else {
				
                location.href = "/";
            }
        }
    });
});