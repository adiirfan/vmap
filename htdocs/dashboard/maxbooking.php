<h1 class="page-header" align="center">Maximum Booking</h1>

<html>
<body>
<div class="row">
 <div class="col-lg-9 col-xs-12" style="margin-left:100px;margin-right:100px;">
<form action="" class="form-inline" method="post">
 <div class="form-group">
 <div class="hour_60">
        <select name="hour" id="hour"></select>
</div>
</div>
 <div class="form-group">
<select name="satuan" class="form-control">
<option value="Munutes">-Select Date-</option>
<option value="Hour">Hour</option>
<option value="Day">Day</option>
<option value="Week">Week</option>
</select>
</div>
</br></br>
<input class="btn btn-primary" type="submit" value="Update">


</form>

</div>
</div>
</body>
</html>

<script>
$(document).ready(function(){
var myOptions = { val1 : 'Suganthar', val2 : 'Suganthar2'};
var opsi=[];
  
for (i = 0; i < 60; i++) { 
opsi[i]=i;

}

$.each(opsi, function(val, text) {
    $('#hour').append(new Option(text,val));
});

$("div.hour_100 select").val("4");
});

</script>