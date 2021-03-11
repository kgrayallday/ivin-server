<?php 

include 'iquery.php';

$testQuery = new iquery();
$storedTestQuery = $testQuery->dateRangeJob('2021-03-04 :01:01:01', '2021-03-07 22:59:59','final');

if ($storedTestQuery->num_rows > 0) {
    $count = $storedTestQuery->num_rows;
    $HTML_String = "";
    $HTML_String .= $count . " rows returned </br>";
    $HTML_String .= "<table style='width:100%;margin: 20px'> <tr> <th>id</th> <th>Job</th>"
        . "<th>Date Time</th> <th>VIN</th> <th>Reading</th> <th>Tire Brand</th> <th>Comment</th>"
        . "<th>Device ID</th> </tr>";

    while($row = $storedTestQuery->fetch_assoc()) {
        $HTML_String .= "<tr>";
        $HTML_String .= "<td>" . $row['id'] . "</td>";
        $HTML_String .= "<td>" . $row['job'] . "</td>";
        $HTML_String .= "<td>" . $row['timestamp'] . "</td>";
        $HTML_String .= "<td>" . $row['vin'] . "</td>";
        $HTML_String .= "<td>" . $row['reading'] . "</td>";
        $HTML_String .= "<td>" . $row['tire'] . "</td>";
        $HTML_String .= "<td>" . $row['comment'] . "</td>";
        $HTML_String .= "<td>" . $row['devid'] . "</td>";
        $HTML_String .= "</tr>";
        }	
    $HTML_String .= "</table>";
}else{
    $HTML_String = "0 results";
}


?>  
