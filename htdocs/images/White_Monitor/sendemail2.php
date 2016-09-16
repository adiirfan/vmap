<?

$name=$_POST['name'];
$email=$_POST['email'];
$company=$_POST['subject'];
$message=$_POST['message'];

if(isset($_POST['g-recaptcha-response']))
          $captcha=$_POST['g-recaptcha-response'];

        if(!$captcha){
          echo '<h2>Please check the the captcha form.</h2>';
          exit;
        }
        $response=json_decode(file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=6LcC2CATAAAAANDfMHzHGV1h0sWTVGmCe4YdqMA4&response=".$captcha."&remoteip=".$_SERVER['REMOTE_ADDR']), true);
        if($response['success'] == false)
        {
          echo '<h2>captcha error.</h2>';
         exit;
        }
        else
        {
    $body .= "Name: " . $name . "\n"; 
    $body .= "Email: " . $email . "\n"; 
	
	
    
    $body .= "Message: " . $message . "\n"; 

   
    mail("adiirfan01@gmail.com",$company,$body);
	  
		}
?> 