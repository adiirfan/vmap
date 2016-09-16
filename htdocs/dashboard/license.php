 <?php
 session_start();
 $user = "root";
$password = "";
$database = "computer_availability";
if (empty($_POST['name'])){
	$_SESSION['pesan']   = 'App Code is Empty';
	header("Location:/admin-dashboard.php#statistic");
}elseif(empty($_POST['keys'])){
	$_SESSION['pesan']   = 'License Keys is Empty ';
	header("Location:/admin-dashboard.php#statistic");
}
else{

#connect to the database
$DB = mysql_connect('127.0.0.1', $user, $password);
@mysql_select_db($database) or die("Unable to select database");

 function encryptIt( $q ) {
    $cryptKey  = 'qJB0rGtIn5UB1xG03efyCp';
    $qEncoded      = base64_encode( mcrypt_encrypt( MCRYPT_RIJNDAEL_256, md5( $cryptKey ), $q, MCRYPT_MODE_CBC, md5( md5( $cryptKey ) ) ) );
    return( $qEncoded );
}

function decryptIt( $q ) {
    $cryptKey  = 'qJB0rGtIn5UB1xG03efyCp';
    $qDecoded      = rtrim( mcrypt_decrypt( MCRYPT_RIJNDAEL_256, md5( $cryptKey ), base64_decode( $q ), MCRYPT_MODE_CBC, md5( md5( $cryptKey ) ) ), "\0");
    return( $qDecoded );
}
$username = $_POST['name'];
$input = $_POST['keys'];
$query1 = "SELECT * FROM license";
$result1 = mysql_query($query1);
$hasil1 = mysql_fetch_assoc($result1);
if(mysql_num_rows($result1)<1 || $username == $hasil1['username']){

$encrypted = encryptIt( $input );
$urlstring = str_replace("+", "", $encrypted);
$url = 'http://licensing.clouddesk.io/web_service/?key='.$urlstring.'&app_code='.$username;

$json = file_get_contents($url);  
$data = json_decode($json);

$encryptedkey = encryptIt( $input );



if(mysql_num_rows($result1)<1 && $username = $data->license[0]->app_code && $input = $data->license_info[0]->license_key){
	$sql = "INSERT INTO license (username,licensekey,expired,max,app,status,id,vdash,booking)
				VALUES 
			    ('".$data->license[0]->app_code."','".$encryptedkey."','".$data->license[0]->expired_date."','".$data->license[0]->sum_max_pc."','".$data->license[0]->app_code."','1','1','".$data->license[0]->vdash."','".$data->license[0]->booking."')";
			mysql_query($sql) or die(mysql_error());
	$_SESSION['pesan2']   = $data->license[0]->app_code;
	$_SESSION['pesan3']   = $data->license_info[0]->license_key;
	$_SESSION['pesan4']   = $data->license_info[0]->live_time;
	$_SESSION['pesan5']   = $data->license_info[0]->sum_pc_license;


	header("Location:/admin-dashboard.php");
	
}
else{
if($data->result == "APP Not Found"){
	$_SESSION['pesan']   = 'App Code does not match';
	header("Location:/admin-dashboard.php#statistic");
	echo clean($encrypted);
	exit();
}
if($data->result == "APP Key Not Found"){
	$_SESSION['pesan']   = 'License Key does not match,please check your key';
	header("Location:/admin-dashboard.php#statistic");

	exit();
}
elseif($data->status == 0){
	$_SESSION['pesan']   = 'Keys already used';
	header("Location:/admin-dashboard.php#statistic");
	exit();
	
}else{

$query = "SELECT licensekey FROM license WHERE username = '".$username."'";
$result = mysql_query($query);
$hasil = mysql_fetch_assoc($result);

$appcodeencrypted= encryptIt($data->license_info[0]->license_key);



$encrypted = encryptIt( $input );
$decrypted = decryptIt( $encrypted );
if ($encrypted == $appcodeencrypted || $username == $data->license[0]->app_code){
$_SESSION['pesan2']   = $data->license[0]->app_code;
$_SESSION['pesan3']   = $data->license_info[0]->license_key;
$_SESSION['pesan4']   = $data->license_info[0]->live_time;
$_SESSION['pesan5']   = $data->license_info[0]->sum_pc_license;


header("Location:/admin-dashboard.php");
$sql = "UPDATE license SET status = 1 ,licensekey = '".$encrypted."',expired = '".$data->license[0]->expired_date."',username = '".$data->license[0]->app_code."',max = '".$data->license[0]->sum_max_pc."',app = '".$data->license[0]->app_code."',vdash = '".$data->license[0]->vdash."',booking = '".$data->license[0]->booking."' where id='1'";
mysql_query($sql) or die(mysql_error());
echo "succses";
}


}
}
}
else{
$_SESSION['pesan']   = 'App Code does not match';
	header("Location:/admin-dashboard.php#statistic");
	echo $hasil1['username'];
	exit();	
}
}

?>