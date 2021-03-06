<?php
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;
    use PHPMailer\PHPMailer\OAuth;
    use League\OAuth2\Client\Provider\Google;
 
class imail {
    function send_mail($content){
        require 'const.php';
        require 'vendor/phpmailer/phpmailer/src/PHPMailer.php';
        require 'vendor/phpmailer/phpmailer/src/Exception.php';
        require 'vendor/phpmailer/phpmailer/src/SMTP.php';
        require 'vendor/autoload.php';   
       
        //set creds from const file
        $account=$const_AccountEmail;
        $password=$const_GmailPassword;
        $subject="Subject";
        $to=$const_AccountEmail;
        //SMTP config settings
        $mail=new PHPMailer;
        $mail->isSMTP();
        $mail->SMTPDebug = SMTP::DEBUG_SERVER;
        $mail->Host = "smtp.gmail.com";
        $mail->Port = 587;
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->SMTPAuth=true;
        $mail->AuthType='XOAUTH2';
        $mail->Username=$account;
        $mail->Password=$password;
        $mail->setFrom($const_AccountEmail);
        $clientId=$const_ClientId;
        $clientSecret=$const_ClientSecret;
        $refreshToken=$const_RefreshToken;

        $provider=new Google(['clientId'=>$clientId,'clientSecret'=>$clientSecret,]);

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
        
        $mail->AddAddress($const_KyleEmail);
        $mail->AddAddress($const_DaveEmail);
        $mail->AddReplyTo($const_AccountEmail);
        $mail->isHTML(true);
        $mail->Subject = "TEST SUBJECT";
        $mail->Body = $content;

        if(!$mail->send()){
            echo "PHPMailer Error: " . $mail->ErrorInfo;
        }else{
             echo "Send Successful";
        }
    }
}







?>
