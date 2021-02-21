// Class for sending emails
// 

<?php
require 'vendor/autoload.php';
require 'vendor/phpmailer/phpmailer/src/PHPMailer.php';
require 'const.php';
require 'vendor/phpmailer/phpmailer/src/Exception.php';
require 'vendor/phpmailer/phpmailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\OAuth;
use League\OAuth2\Client\Provider\Google;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

//PHPMailer Credentials
$account = $const_AccountEmail;
$password = $const_GmailPassword;
$subject = "IVIN SCAN " . strtoupper($job) . " " . $date;
$recipient = $const_AccountEmail;

//SMTP Config 
$mail = new PHPMailer;
$mail->isSTMP();
$mail->SMTPDebug = STMP::DEBUG_SERVER;
$mail->Port = 587; //try 587 with TLS or 465 SSL
$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
$mail->SMTPAuth=true;
$mail->AuthType ='XOAUTH2';
$mail->Username=$account;
$mail->Password=$password;
$mail->setForm($const_AccountEmail);

$clierntId=$const_ClientId;
$clientSecret=$const_ClientSecret;
$refreshToken=$const_RefreshToken;

$provider=new Google(
    [
        'clientId'=>$clientId,
        'clientSecret'=>clientSecret,
    ]
);

$mail->setOAuth(
    new OAuth(
        [
            'provider'=>$provider,
            'clientId'=>$clientId,
            'clientSecret'=>$clientSecret,
            'refreshToken'=>$refreshToken,
            'userName'=>$account,
        ]
    )
);

?>
