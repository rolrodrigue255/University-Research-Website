<?php
session_start();
try{
	
	//Calls BaseXClient php file
	include("BaseXClient.php");
	
	$query1 = $_POST['query'];   //gets javascript element "query" and converts it to PHP variable
	$uni1 = $_POST['u1'];   //gets javascript element "u1" and converts it to PHP variable
	$array;      //used to store each result into an array
	$x = 0;      //used as index for array "array"
	$count = 0;  //used to count number of articles/display count
	$demo = 111;
	
	//creates new session that connects to BaseX server
	$session = new Session("localhost", 1984, "admin", "admin");
	
	//Query string used for testing
	$cmd = 'for $x in doc("B:/Program Files/BaseX/dblps.xml")/dblp/article
where $x/author = "E. F. Codd"
return $x/year';
   
    //Assigns query string "$query1" to $query variable
	$query = $session->query($query1);
	
	//Loops through the query as long as there are more elements left
	while ($query->more())
	{
	$next = $query->next();
	//echo $next. "\n\n";
	
	//Assigns each result to a new element in array "array"
	$array[$x] = $next;
	$x = $x + 1;
	
	//Adds 1 to count so that a total # of articles can be kept
	$count = $count + 1;
	
	}
	echo $array[0];
	echo $array[0];
	echo $array[1];
	
	
	//Creates a table to store the count variable for each University
	echo "<table border='0' cellspacing='2' cellpadding='4' width='20%'><tbody><tr style='text-align:center;'>";
	echo "<td style='text-align:center;background-color:#D7D7D7;border:#ffffff 1px solid;font-size:12pt;'></td>";
	echo "<td style='text-align:center;background-color:#D7D7D7;border:#ffffff 1px solid;font-size:12pt;'>Department</td>";
	echo "<td style='text-align:center;background-color:#D7D7D7;border:#ffffff 1px solid;font-size:12pt;'># of Articles</td>";
  
	echo "<tr style='text-align:center; background-color: #eeeeee;'>
			<td style='text-align:center;'>1</td><td style='text-align:center;'>$uni1</td>
			<td style='text-align:center;'>$count</td></tr>"; 
	$query->close();
	$session->close();
	}

	catch (Exception $e) {
  // print exception
  print $e->getMessage();
}
$_SESSION['count'] = $count;
$_SESSION['uni1'] = $uni1;
$_SESSION['array'] = $array;
?>