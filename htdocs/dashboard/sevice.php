<?php

$json = file_get_contents('http://eduhakim.com/web_service/service.php?key=843hhsjdsdkki9987&app_code=CX500');  
$data = json_decode($json);
echo '<br>';
if($data->result == 'Success') { 
echo $data->license[0]->expired_date;
echo $data->license[0]->sum_max_pc;
echo $data->license[0]->app_code;
echo $data->license[0]->client_date;
}
?>