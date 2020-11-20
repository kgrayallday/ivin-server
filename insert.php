<?php
require "const.php";
require "vendor/phpmailer/phpmailer/src/PHPMailer.php";
require "vendor/phpmailer/phpmailer/src/Exception.php";
require "vendor/phpmailer/phpmailer/src/SMTP.php";
require "vendor/autoload.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMAILER\PHPMailer\Exception;
use PHPMailer\PHPMailer\OAuth;
use League\OAuth2\Client\Provider\Google;
// phpOffice added 08/04/2020 - so far unused
use PhpOffice\PhpSpreadhseet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;

$connection = new mysqli($const_ServerName, $const_UserName, $const_Password, $const_DbName);

$counter = 0;

date_default_timezone_set('America/Vancouver'); //sets default timezone to Vancouver time

$date = date("m.d.y.H.i.s");

$inputjson = file_get_contents("php://input");
$scans_array = json_decode($inputjson, TRUE);
$job = $scans_array[0]['job']; // which job are we dealing with (ex. generic, bmw initial, ect)

if($connection->connect_error){
    print_r("Connection to database failed: %s\n", $connection->connect_error + ".");
    exit();
}

require 'vendor/autoload.php';

// credentials for PHPMailer.php
$account = $const_AccountEmail;
$password = $const_GmailPassword;
$subject = "IVIN SCAN ".strtoupper($job)." ".$date;
$to = $const_AccountEmail;

// SMTP Configuration settings
$mail = new PHPMailer;
$mail->isSMTP();
$mail->SMTPDebug = SMTP::DEBUG_SERVER;
$mail->Host = "smtp.gmail.com";
$mail->Port = 587; //try 587 with TLS or 465 SSL
$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
$mail->SMTPAuth = true;
$mail->AuthType = 'XOAUTH2';
$mail->Username = $account;
$mail->Password = $password;
$mail->setFrom($const_AccountEmail);

// CONFIDENTIAL Google Oauth credentials, !!! PLACE IN CONST FILE IS UPLOADING TO GITHUB !!!
$clientId = $const_ClientId;
$clientSecret = $const_ClientSecret;
//Obtained by configuring and running get_oauth_token.php
$refreshToken = $const_RefreshToken;

//Create a new OAuth2 provider instance
$provider = new Google(
    [
        'clientId' => $clientId,
        'clientSecret' => $clientSecret,
    ]
);

//Pass the OAuth provider instance to PHPMailer
$mail->setOAuth(
    new OAuth(
        [
            'provider' => $provider,
            'clientId' => $clientId,
            'clientSecret' => $clientSecret,
            'refreshToken' => $refreshToken,
            'userName' => $account,
        ]
    )
);

//head styling variable for html table in email
$htmlhead = "<head>
	     <style>
	        table{
		  font-family: arial, sans-serif;
		  border-collapse: collapse;
		  width: 100%;
		}

		td, th {
		  border: 1px solid #dddddd;
		  text-align: left;
		  padding: 8px;
		}

		tr:nth-child(even)
		{
		  background-color: #dddddd;
		}

	</style>
	</head>";

$mail_string = "";
$title = "";
$table = "<table><thead><tr>";

$dataheaders = array();

$commentIsSet = false;
$readingIsSet = false;
$tireIsSet = false;

$keys = array_keys($scans_array);

// print optional rows
for($i=0;$i<count($scans_array);$i++){
  foreach($scans_array[$keys[$i]] as $key => $value){
        if($key == "comment" && $value != null){
           $commentIsSet = true;
        }

        if($key == "reading" && $value != null){
           $readingIsSet = true;
        }

        if($key == "tire" && $value != null){
           $tireIsSet = true;
        }
  }
}

// Sets up title headers based on available data
    if($scans_array[0]["vin"]!=null){
	$title .= "<th>VIN</th>";
        array_push($dataheaders, "VIN");
    }
    if($scans_array[0]["job"]!=null){
        $title .= "<th>JOB</th>";
        array_push($dataheaders,"JOB");
    }
    if($commentIsSet){
        $title.="<th>COMMENT</th>";
        array_push($dataheaders,"COMMENT");
    }
    if($scans_array[0]["stamp"]!=null){
        $title .= "<th>TIME STAMP</th>";
        array_push($dataheaders,"TIME STAMP");
    }
    if($readingIsSet == true){
        $title .= "<th>READING</th>";
        array_push($dataheaders, "READING");
    }
    if($tireIsSet == true){
        $title .= "<th>TIRE BRAND</th>";
        array_push($dataheaders, "TIRE BRAND");
    }
    if($scans_array[0]["devid"]!=null){
        $title .= "<th>DEVICE ID</th>";
        array_push($dataheaders, "DEVICE ID");
    }




    $title .= "</tr></thead>";
    //$mail_string .= $title;
    $table .= $title;
    $data = "";


    for($i=0;$i<count($scans_array);$i++){

    	// START FOREACH
	foreach($scans_array[$keys[$i]] as $key => $value){
      	if($key == "vin"){
          $vinvalue = $value;
  	  $data .= $vinvalue.",";
        }
        if($key == "job"){
          $jobvalue = $value;
	  $data .= $jobvalue.",";
        }
        if($key=="comment"){
          if($commentIsSet == true){
            if($value != null){
             $commentvalue = $value;
             $data .= $commentvalue.",";
            }else{
             $commentvalue = " ";
             $data.=$commentvalue.",";
            }
          }
        }
        if($key == "stamp"){
          $stampvalue = $value;
	  $data .= $stampvalue.",";
        }
        //if($key == "reading"){
        if($key=="reading"){
          if($readingIsSet == true){
            if($value!=null){
              $readingvalue = $value;
	      $data .= $readingvalue.",";
            }else{
              $readingvalue = " ";
              $data.=$readingvalue.",";
            }
          }
        }
        //if($key == "tire"){
        if($key=="tire"){
          if($tireIsSet==true){
            if($value!=null){
              $tirevalue = $value;
	      $data .= $tirevalue.",";
            }else{
              $tirevalue=" ";
              $data.=$tirevalue.",";
            }
          }
        }
        if($key == "devid"){
          $devidvalue = $value;
	  $data .= $devidvalue.",";
        }
	// NEW LINE FOR CSV OR XLSX
	$data .= "\n";
    }
    // END FOREACH

    // MySQL INSERT STATEMENT
    $sql_query = "INSERT INTO scans (vin, job, comment, appstamp, tire, reading, devid) VALUES ('$vinvalue','$jobvalue','$commentvalue', '$stampvalue','$tirevalue','$readingvalue','$devidvalue')";
    if ($connection->query($sql_query) === TRUE) {
        $counter++;
    }else{
        print_r("db insert failed. ");
        print_r(mysqli_error($connection));
	print_r(" vinvalue is: " . $vinvalue);
        }

	// COUNT TOTAL TO PRINT FOR USER
    	$array_count = count($scans_array);

        // ERROR CHECK FOR INSERT - ALSO CHECKED BELOW BUT USES HTTP RESPONSE CODE INSTEAD OF STRING
	if($counter==$array_count){
        print_r("insert successful");
        }

	// BEGIN INSERTION OF TABLE ROWS FOR WEB TABLE DATA
	$table .= "<tr>";

        if($vinvalue != null){
        $table .= "<td>" . $vinvalue . "</td>";
    	}
        if($jobvalue != null){
        $table .= "<td>" . $jobvalue . "</td>";
    	}
        if($commentvalue != null){
        $table .= "<td>" . $commentvalue . "</td>";
    	}
        if($stampvalue != null){
        $table .= "<td>" . $stampvalue . "</td>";
    	}
        if($readingvalue != null){
        $table .= "<td>" . $readingvalue . "</td>";
    	}
        if($tirevalue != null){
        $table .= "<td>" . $tirevalue . "</td>";
    	}
        if($devidvalue != null){
        $table .= "<td>" .$devidvalue . "</td>";
    	}
	// END SINGLE ROW OF TABLE
    	$table .= "</tr>";
}
// END BIG FOR LOOP

       $array_count = count($scans_array);
       if($counter==$array_count){ http_response_code(200); }

       $count_text = "<h3>Total Scans: ".$array_count."</h3>";
       $mail_string = "<html>".$htmlhead."<body>".$count_text.$table;

       $mail_string .= "</table></body></html>";

// sending details
$mail->AddAddress($const_KyleEmail);
$mail->AddAddress($const_AccountEmail);
$mail->AddAddress($const_DaveEmail);
$mail->AddReplyTo($const_AccountEmail);
$mail->isHTML(true);
$mail->Subject = $subject;
//$mail->msgHTML($mail_string);
$mail->Body = $mail_string;
//$mail->addCustomHeader("MIME-Version: 1.0");
//$mail->addCustomHeader("Content-Type: text/html; charset=utf-8");

// Random string function to make unique file names and prevent collision
function rand_string($length){
  $key = '';
  $keys = array_merge(range(0,9),range('A','Z'));
  for($i=0;$i<$length;$i++){
    $key .= $keys[array_rand($keys)];
  }
  return $key;
}

//create a random string of 6 characters to attach to end of file
$unique = rand_string(6);


$reader = IOFactory::createReader('Html'); //create reader to read html
$tmp_file = fopen('/var/www/ivin.app/public_html/tmp_file.html','w+');
file_put_contents('/var/www/ivin.app/public_html/tmp_file.html',$mail_string);
$spreadsheet = $reader->load('/var/www/ivin.app/public_html/tmp_file.html');
$writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
$file = fopen('/var/www/ivin.app/public_html/'.'scan'.$unique.'.xlsx','w+');

if($file === FALSE) {
    die('Failed to open temporary file');
}
$writer->save($file);
  fclose($file); // releases the memory (or tempfile)
  fclose('/var/www/ivin.app/public_html/tmp_file.html');
  $mail->addAttachment('/var/www/ivin.app/public_html/'.'scan'.$unique.'.xlsx','IVINSCAN_'.$date.'_'.$unique.'.xlsx');
  //$mail->AddAttachment('scanTA68XU.csv');
  //$mail->AddAttachment($output,"scantest.csv");


// The following is code for PHPMailer //
  if(!$mail->send()){
    echo "PHPMailer Error: " . $mail->ErrorInfo;
      }else{
        echo " Message Successfully Sent";
      }

    unlink('scan'.$unique.'.xlsx');
    unlink($tmp_file);

    mysqli_close($connection);



?>
