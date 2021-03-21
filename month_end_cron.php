<?php

include 'imail.php';
include 'irandom.php';
include 'iquery.php';

$newQuery = new iquery();
$newMail = new imail();


$firstOfLast = date("Y-m-d H:i:s", strtotime("first day of previous month"));
$lastOfLast = date("Y-m-d H:i:s", strtotime("last day of previous month"));

$lastMonthSQLObject = $newQuery->dateRange($firstOfLast,$lastOfLast);
// will need the remixer to make this into html string
// then pass html string to mail 

while($row = $lastMonthSQLObject->fetch_assoc()){
			echo "<tr>";
			echo "<td>" . $row['id'] . "</td>";
			echo "<td>" . $row['job'] . "</td>";
			echo "<td>" . $row['timestamp'] . "</td>";
			echo "<td>" . $row['vin'] . "</td>";
			echo "<td>" . $row['reading'] . "</td>";
			echo "<td>" . $row['tire'] . "</td>";
			echo "<td>" . $row['comment'] . "</td>";
			echo "<td>" . $row['devid'] . "</td>";
            echo "</tr>";
}
	
newMail->send_mail(var_dump($lastMonthSQLObject));





?>
