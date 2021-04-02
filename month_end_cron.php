<?php

include 'imail.php';
include 'irandom.php';
include 'iquery.php';
include 'tablizer.php';

$newQuery = new iquery();
$newMail = new imail();
$myTablizer = new tablizer();

$firstOfLast = date("Y-m-d H:i:s", strtotime("first day of previous month"));
$lastOfLast = date("Y-m-d H:i:s", strtotime("last day of previous month"));

$lastMonthSQLObject = $newQuery->dateRange($firstOfLast,$lastOfLast);
// will need the remixer to make this into html string
// then pass html string to mail 

$sqliArray = $lastMonthSQLObject->fetch_all(MYSQLI_ASSOC);

$emailBodyData = $myTablizer->webTable($sqliArray);
$emailAttachment = $myTablizer->spreadsheet($emailBodyData);

$newMail->send_mail_with_attachment($emailBodyData,$emailAttachment);





?>
