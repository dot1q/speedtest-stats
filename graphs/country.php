	<script>
	function showCountry(str) {
		//window.alert("Country selected was "+str+"!");
		if (str == "") {
			document.getElementById("txtRegion").innerHTML = "";
			return;
		} else { 
			if (window.XMLHttpRequest) {
				// code for IE7+, Firefox, Chrome, Opera, Safari
				xmlhttp = new XMLHttpRequest();
			} else {
				// code for IE6, IE5
				xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
			}
			xmlhttp.onreadystatechange = function() {
				if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
					document.getElementById("txtRegion").innerHTML = xmlhttp.responseText;
				}
			}
			xmlhttp.open("GET","graphs/region.php?country="+str,true);
			xmlhttp.send();
		}
	}
	</script>
	<script>
	function showRegion(str, country) {
		//window.alert("Region selected was "+str+" with country " + country);
		if (str == "") {
			document.getElementById("txtCity").innerHTML = "";
			return;
		} else { 
			if (window.XMLHttpRequest) {
				// code for IE7+, Firefox, Chrome, Opera, Safari
				xmlhttp = new XMLHttpRequest();
			} else {
				// code for IE6, IE5
				xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
			}
			xmlhttp.onreadystatechange = function() {
				if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
					document.getElementById("txtCity").innerHTML = xmlhttp.responseText;
				}
			}
			xmlhttp.open("GET","graphs/city.php?country="+country+"&region="+str,true);
			xmlhttp.send();
		}
	}
	</script>
	<script>
	function showCity(str, country, region) {
		//window.alert("City selected was "+str+" with country " + country + "in reigon " + region);
		if (str == "") {
			document.getElementById("txtISP").innerHTML = "";
			return;
		} else { 
			if (window.XMLHttpRequest) {
				// code for IE7+, Firefox, Chrome, Opera, Safari
				xmlhttp = new XMLHttpRequest();
			} else {
				// code for IE6, IE5
				xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
			}
			xmlhttp.onreadystatechange = function() {
				if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
					document.getElementById("txtISP").innerHTML = xmlhttp.responseText;
				}
			}
			xmlhttp.open("GET","graphs/isp.php?country="+country+"&region="+region+"&city="+str,true);
			xmlhttp.send();
		}
	}
	</script>
	<script>
	function showISP(str, country, region, city) {
		//window.alert("City selected was "+city+" with country " + country + "in reigon " + region + "with ISP " + str);
		document.getElementById('avgspeed').src = "graphs/types/avgspeed.php?country="+country+"&region="+region+"&city="+city+"&isp="+str;
		document.getElementById('avglatency').src = "graphs/types/avglatency.php?country="+country+"&region="+region+"&city="+city+"&isp="+str;
		if (str == "") {
			document.getElementById("txtGraphs").innerHTML = "";
			return;
		} else { 
			if (window.XMLHttpRequest) {
				// code for IE7+, Firefox, Chrome, Opera, Safari
				xmlhttp = new XMLHttpRequest();
			} else {
				// code for IE6, IE5
				xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
			}
			xmlhttp.onreadystatechange = function() {
				if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
					document.getElementById("txtGraphs").innerHTML = xmlhttp.responseText;
				}
			}
			//xmlhttp.open("GET","graphs/isp.php?country="+country+"&region="+region+"&city="+str,true);
			xmlhttp.send();
		}
	}
	</script>
<?php

include("../config.php");
// Create connection
$conn = new mysqli($config['db_host'], $config['db_user'], $config['db_pass'], $config['db_name']);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
//Perform query and store data in array
$sql = "SELECT `CLIENT_COUNTRY` FROM tbl_data";
$result = $conn->query($sql);

$country = array();

//manipulate data
if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
		$dat = $row["CLIENT_COUNTRY"];
		$country[$dat] = $country[$dat]+1;
		//echo $dat;
    }
ksort($country);
} else {
    echo "0 results";
}

?>
			<form>
				<select name="country" onchange="showCountry(this.value)">
					<option value="">Select a country:</option>
<?php
foreach ($country as $key => $value){
	if($value >= '2'){
		echo "<option value='".$key."'>".$key."</option>";
	}
}
?>
				</select>
			</form>
			<div id="txtRegion"><b>Region info will be listed here...</b></div>