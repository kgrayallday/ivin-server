<?php
class iquery {
    
    //==================
    // DATE RANGE QUERY
    //================== 
    
    function dateRange($startDate,$endDate){
        include 'const.php';
        //est conn
        $connection = new mysqli(
            $const_ServerName,
            $const_UserName,
            $const_Password,
            $const_DbName
        );
        
        if ($connection -> connect_errno){
            echo "failed to connect to MySQL: " 
                . $connection -> connect_error;
            exit();
        }

        $sql_query="SELECT * FROM scans WHERE timestamp BETWEEN '
            $startDate' and '$endDate';";
        
        if(!$connection->query($sql_query)){
            echo("error desc: " . $connection -> error);
        }

        $results=$connection->query($sql_query);
        return $results;
    }

//$lastMonthStart = date("Y-m-d H:i:s",strtotime("01:01:01 first day of previous month"));
//$lastMonthEnd = date("Y-m-d H:i:s",strtotime("23:52:01 last day of previous month"));

//echo "TEST LAST MONTH RANGE: ";
//echo "</br>";
//echo "last month start: " . $lastMonthStart;
//echo "<br>";
//echo "last month end: " . $lastMonthEnd;

//selectDateRange($lastMonthStart,$lastMonthEnd);


    //==========================
    // DATE RANGE AND JOB QUERY
    //==========================
    
    function dateRangeJob($startDate, $endDate, $job){
        include 'const.php';
        //est connection
        $connection = new mysqli(
            $const_ServerName,
            $const_UserName,
            $const_Password,
            $const_DbName
        );

        if ($connection -> connect_errno){
            echo "failed to connect to MySQL: "
                . $connection -> connect_error;
            exit();
        }

        $sql_query="SELECT * FROM scans WHERE timestamp BETWEEN '
            $startDate' and '$endDate' AND job = '$job';";

        if(!$connection->query($sql_query)){
            echo("error desc: " . $connetion -> error);
        }
        $results=$connection->query($sql_query);
        return $results;
    }


}

?>

