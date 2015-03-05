
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
//echo "country: ".$country."<br />region: ".$region;

// Escape User Input to help prevent SQL Injection
//$country = mysql_real_escape_string($country);

///build query
$query = "SELECT `CLIENT_CITY` FROM `tbl_data` WHERE `CLIENT_COUNTRY` = '".$country."' AND CLIENT_REGION = '".$region."'";
$result = $conn->query($query);

$city = array();


//manipulate data
if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
		$dat = $row["CLIENT_CITY"];
		$city[$dat] = $city[$dat]+1;
		//echo $dat;
    }
} else {
    echo "0 results";
}
ksort($city);
?>
<form>
	<select name="city" onchange="showCity(this.value, '<?php echo $country; ?>', '<?php echo $region; ?>')">
		<option value="">Select a city:</option>
<?php
foreach ($city as $key => $value){
	if($value >= '2'){
		if($key !== ""){
			echo "<option value='".$key."'>".$key."</option>";
		}
	}
}
?>
	</select>
	   
</form>
<div id="txtISP"><b>ISP info will be listed here...</b></div>