<?php 
function selectDateRange($startDate,$endDate){
    include 'const.php';
   
    //est conn
    $connection = new mysqli($const_ServerName,$const_UserName,$const_Password,$const_DbName);
    // query variable
    if ($connection -> connect_errno){
        echo "failed to connect to MySQL: " . $connection -> connect_error;
        exit();
    }
    $sql_query="SELECT * FROM scans WHERE timestamp BETWEEN '$startDate' and '$endDate';";
    // results in results
    //$results=
    
    if(!$connection->query($sql_query)){
        echo("error desc: " . $connection -> error);
    }

    $results=$connection->query($sql_query);

    //test dump keys
    foreach($results as $array){
        foreach($array as $key=>$value){ 
            echo $key . ": " . $value;
            echo "</br>";
    }
} 

}

$lastMonthStart = date("Y-m-d H:i:s",strtotime("01:01:01 first day of previous month"));
$lastMonthEnd = date("Y-m-d H:i:s",strtotime("23:52:01 last day of previous month"));

echo "TEST LAST MONTH RANGE: ";
echo "</br>";
echo "last month start: " . $lastMonthStart;
echo "<br>";
echo "last month end: " . $lastMonthEnd;

selectDateRange($lastMonthStart,$lastMonthEnd);

?>

