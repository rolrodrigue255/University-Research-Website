<?php
session_start();
try{

	include("BaseXClient.php");
	
	$query2 = $_POST['query2'];
	$uni2 = $_POST['u2'];
	$count2 = 0;
	
	$session = new Session("localhost", 1984, "admin", "admin");
	
	$cmd = 'for $x in doc("B:/Program Files/BaseX/dblps.xml")/dblp/article
where $x/author = "E. F. Codd"
return $x/year';
   
	$query = $session->query($query2);
	
	while ($query->more())
	{
	$next = $query->next();
	//echo $next. "\n";
	
	$count2 = $count2 + 1;
	}
	
	echo "<table border='0' cellspacing='2' cellpadding='4' width='20%'><tbody><tr style='text-align:center;'>";
	echo "<td style='text-align:center;background-color:#D7D7D7;border:#ffffff 1px solid;font-size:12pt;'></td>";
	echo "<td style='text-align:center;background-color:#D7D7D7;border:#ffffff 1px solid;font-size:12pt;'>Department</td>";
	echo "<td style='text-align:center;background-color:#D7D7D7;border:#ffffff 1px solid;font-size:12pt;'># of Articles</td>";
  
	echo "<tr style='text-align:center; background-color:#eeeeee;'>
			<td style='text-align:center;'>1</td><td style='text-align:center;'>$uni2</td>
			<td style='text-align:center;'>$count2</td></tr>";
	$query->close();
	$session->close();
	}

	catch (Exception $e) {
  // print exception
  print $e->getMessage();
}

$_SESSION['count2'] = $count2;
$_SESSION['uni2'] = $uni2;

?>