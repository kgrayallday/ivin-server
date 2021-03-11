<?php

include 'imail.php';
include 'irandom.php';
include 'iquery.php';

$newQuery = new iquery();
$newMail = new imail();


$firstOfLast = date("Y-m-d H:i:s", strtotime("first day of previous month"));
$lastOfLast = date("Y-m-d H:i:s", strtotime("last day of previous month"));

$lastMonthQuery = $newQuery->dateRange($firstOfLast,$lastOfLast);
// will need the remixer to make this into html string
// then pass html string to mail 

$newMail->send_mail('strings and attachments here');





?>
