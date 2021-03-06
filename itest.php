<?php 

include 'iquery.php';

$testQuery = new iquery();
echo $testQuery->dateRangeJob('2021-03-04 :01:01:01', '2021-03-04 22:59:59','final');

?>  
