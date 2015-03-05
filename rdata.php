<link rel="stylesheet" type="text/css" href="css/bootstrap.css">
<?php  

/**
 *
 * OUTPUTS RAW DATABASE INFORMATION 
 * DOES NOTHING ELSE!
 */

include('config.php');

//connect to the database 
$connection = new mysqli($config['db_host'],$config['db_user'],$config['db_pass'], $config['db_name']);

mysql_select_db($config['db_name'],$connect); //select the table 
// Check connection
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
} 

//run query and pull information
$sql = "SELECT * FROM tbl_data";
$result = $connection->query($sql);

$data = array();

if ($result->num_rows > 0) {
	echo "<table border='1'><tr><th>ID</th><th>Client IP</th><th>Client City</th><th>Client Region</th><th>Client Country</th><th>ISP</th><th>Client Latitude</th><th>Client Longitude</th><th>Test Date</th><th>Server Name</th><th>Download Kbps</th><th>Upload Kbps</th><th>Latency</th><th>Client Browser</th><th>Client Operating System</th><th>User Agent</th></tr>";
    // output data of each row
    while($row = $result->fetch_assoc()) {
		echo "<tr><td>".$row["id"]."</td><td>".$row["CLIENT_IP"]."</td><td>".$row["CLIENT_CITY"]."</td><td>".$row["CLIENT_REGION"]."</td><td>".$row["CLIENT_COUNTRY"]."</td><td>".$row["ISP"]."</td><td>".$row["CLIENT_LATITUDE"]."</td><td>".$row["CLIENT_LONGITUDE"]."</td><td>".$row["TEST_DATE"]."</td><td>".$row["SERVER_NAME"]."</td><td>".$row["DOWNLOAD_KBPS"]."</td><td>".$row["UPLOAD_KBPS"]."</td><td>".$row["LATENCY"]."</td><td>".$row["CLIENT_BROWSER"]."</td><td>".$row["CLIENT_OPERATING_SYSTEM"]."</td><td>".$row["USER_AGENT"]."</td></tr>";
		
    }
	echo "</table>";
} else {
    echo "0 results";
}
//print_r($data);
$connection->close();


?>