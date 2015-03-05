
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
//echo "country is: ".$country."<br />";

// Escape User Input to help prevent SQL Injection
//$country = mysql_real_escape_string($country);

///build query
$query = "SELECT `CLIENT_REGION` FROM `tbl_data` WHERE `CLIENT_COUNTRY` = '".$country."'";
$result = $conn->query($query);

$region = array();


//manipulate data
if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
		$dat = $row["CLIENT_REGION"];
		$region[$dat] = $region[$dat]+1;
		//echo $dat;
    }
} else {
    echo "0 results";
}
ksort($region);
?>
<form>
	<select name="region" onchange="showRegion(this.value, '<?php echo $country; ?>')">
		<option value="">Select a region:</option>

<?php
foreach ($region as $key => $value){
	if($value >= '2'){
		if($key !== ""){
			echo "<option value='".$key."'>".$key."</option>";
		}
	}
}
?>
	</select>
	   
</form>
<div id="txtCity"><b>City info will be listed here...</b></div>