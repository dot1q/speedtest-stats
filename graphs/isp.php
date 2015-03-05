
<?php

include("../config.php");

// Create connection
$conn = new mysqli($config['db_host'], $config['db_user'], $config['db_pass'], $config['db_name']);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

// Retrieve data from Query String
$country = $_GET['country'];
$region = $_GET['region'];
$city = $_GET['city'];
// Escape User Input to help prevent SQL Injection
//$country = mysql_real_escape_string($country);

///build query
$query = "SELECT `ISP` FROM `tbl_data` WHERE `CLIENT_COUNTRY` = '".$country."' AND CLIENT_REGION = '".$region."' AND CLIENT_CITY = '".$city."'";
$result = $conn->query($query);

$provider = array();


//manipulate data
if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
		$dat = $row["ISP"];
		$provider[$dat] = $provider[$dat]+1;
		//echo $dat;
    }
} else {
    echo "0 results";
}
ksort($provider);
?>

<form>
	<select name="isp" onchange="showISP(this.value, '<?php echo $country; ?>', '<?php echo $region; ?>', '<?php echo $city; ?>')">
		<option value="">Select an ISP:</option>
<?php
foreach ($provider as $key => $value){
	if($value >= '2'){
		if($key !== ""){
			echo "<option value='".$key."'>".$key."</option>";
		}
	}
}
?>
	</select>
	   
</form>
<div id="txtGraphs">
	<img src="" id="avgspeed" >
	<hr>
	<img src="" id="avglatency" >
</div>