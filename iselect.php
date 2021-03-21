<?php

function selectJob($job){
    require 'const.php';
    $connection = new mysqli($const_ServerName,$const_UserName,$const_Password,$const_DbName);
	//need to inject data into the website. 
	$sql_query = "SELECT * FROM scans WHERE job = '$job';";
	$result = $connection->query($sql_query);
	
	if ($result->num_rows > 0) {
		$count = $result->num_rows;
		echo $count . " rows returned";
        echo "<table style='width:100%;margin: 20px'>";
		echo "<tr>";
		echo "<th>id</th>";
		echo "<th>Job</th>";
		echo "<th>Date Time</th>";
		echo "<th>VIN</th>";
		echo "<th>Reading</th>";
		echo "<th>Tire Brand</th>";
		echo "<th>Comment</th>";
		echo "<th>Device ID</th>";
		echo "</tr>";
	
		while($row = $result->fetch_assoc()) {
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

		echo "</table>";
    }else{
    echo "0 results";
    }
}

function selectToday(){
	require 'const.php';
	$connection = new mysqli($const_ServerName,$const_UserName,$const_Password,$const_DbName);
	$sql_query = "SELECT * FROM scans WHERE DATE(timestamp) = CURDATE()";
	$result = $connection->query($sql_query);
	
	if ($result->num_rows > 0) {
		$count = $result->num_rows;
		echo $count . " rows returned";
        echo "<table style='width:90%;margin: 20px'>";
		echo "<tr>";
		echo "<th>id</th>";
		echo "<th>Job</th>";
		echo "<th>Date Time</th>";
		echo "<th>VIN</th>";
		echo "<th>Reading</th>";
		echo "<th>Tire Brand</th>";
		echo "<th>Comment</th>";
		echo "<th>Device ID</th>";
		echo "</tr>";
	
		while($row = $result->fetch_assoc()) {
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

		echo "</table>";
		switch($count){
			case 0:
			break;
			case 1:
				echo $count . " row returned";
			break;
			default;
				echo $count . " rows returned.";
		}


    }else{
    echo "0 results";
    }

}

function selectYesterday(){
	require 'const.php';
	$connection = new mysqli($const_ServerName,$const_UserName,$const_Password,$const_DbName);
	$sql_query = "SELECT * FROM scans WHERE DATE(timestamp) = SUBDATE(CURDATE(),1)";
	$result = $connection->query($sql_query);
	
	if ($result->num_rows > 0) {
		$count = $result->num_rows;
		echo $count . " rows returned";
        echo "<table style='width:90%;'>";
		echo "<tr>";
		echo "<th>id</th>";
		echo "<th>Job</th>";
		echo "<th>Date Time</th>";
		echo "<th>VIN</th>";
		echo "<th>Reading</th>";
		echo "<th>Tire Brand</th>";
		echo "<th>Comment</th>";
		echo "<th>Device ID</th>";
		echo "</tr>";
			
		while($row = $result->fetch_assoc()) {
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
			
		echo "</table>";
		switch($count){
			case 0:
			break;
			case 1:
				echo $count . " row returned";
			break;
			default;
				echo $count . " rows returned.";
		}

    }else{
    echo "0 results";
    }

}

function selectMTD(){
	require 'const.php';
	$connection = new mysqli($const_ServerName,$const_UserName,$const_Password,$const_DbName);
	$sql_query = "SELECT * FROM scans WHERE DATE(timestamp) = MONTH(CURDATE())";
	$result = $connection->query($sql_query);
	
	if ($result->num_rows > 0) {
		$count = $result->num_rows;
		echo $count . " rows returned";
        echo "<table style='width:90%;margin: 20px'>";
        echo "<tr>";
        echo "<th>id</th>";
        echo "<th>Job</th>";
        echo "<th>Date Time</th>";
        echo "<th>VIN</th>";
        echo "<th>Reading</th>";
        echo "<th>Tire Brand</th>";
        echo "<th>Comment</th>";
        echo "<th>Device ID</th>";
		echo "</tr>";
				
    	while($row = $result->fetch_assoc()) {
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
				
		echo "</table>";
		switch($count){
			case 0:
			break;
			case 1:
				echo $count . " row returned";
			break;
			default;
				echo $count . " rows returned.";
		}

    }else{
    echo "0 results";
    } 
    
    mysqli_close($connection);
}
?>
