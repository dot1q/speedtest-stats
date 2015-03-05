<?php  

/**
 *
 * THIS FILE ATTEMPTS TO CREATE A DATABASE WITH THE CREDENTIALS LOCATED IN THE CONFIG.PHP FILE 
 * 1)TEST IF CREDENDTIALS ARE VALID
 * 2)TRUNCATE THE TABLE
 * 3)UPLOAD CSV DATA TO TABLE
 */

//connect to the database 
include('config.php');
$connect = mysql_connect($config['db_host'], $config['db_user'], $config['db_pass']);
mysql_select_db($config['db_name'],$connect); //select the table 

if ($_FILES[csv][size] > 0) { 

    //get the csv file 
    $file = $_FILES[csv][tmp_name]; 
    $handle = fopen($file,"r"); 
     
    //loop through the csv file and insert into database 
	
	//Drop the table and re-create it
	/*
	THIS ARGUMENT IS USED FOR ANDROID STATS
	$arg = "
		DROP TABLE `tbl_data`;
		CREATE TABLE `tbl_data` (
			`id` INT(6) AUTO_INCREMENT PRIMARY KEY,
			`CLIENT_IP` VARCHAR(255) NOT NULL,
			`ISP` VARCHAR(255) NOT NULL,
			`TEST_DATE` VARCHAR(255) NOT NULL,
			`SERVER_NAME` VARCHAR(255) NOT NULL,
			`DOWNLOAD_KBPS` VARCHAR(255) NOT NULL,
			`UPLOAD_KBPS` VARCHAR(255) NOT NULL,
			`LATENCY` VARCHAR(255) NOT NULL,
			`LATITUDE` VARCHAR(255) NOT NULL,
			`LONGITUDE` VARCHAR(255) NOT NULL,
			`CONNECTION_TYPE` VARCHAR(255) NOT NULL
		) ENGINE=MyISAM DEFAULT CHARSET=utf8;	
	";
	
	USE THIS FOR SQL ARGUMENTS NOW!
		DROP TABLE `tbl_data`;
		CREATE TABLE `tbl_data` (
			`id` INT(6) AUTO_INCREMENT PRIMARY KEY,
			`CLIENT_IP` VARCHAR(255) NOT NULL,
			`CLIENT_CITY` VARCHAR(255) NOT NULL,
			`CLIENT_REGION` VARCHAR(255) NOT NULL,
			`CLIENT_COUNTRY` VARCHAR(255) NOT NULL,
			`ISP` VARCHAR(255) NOT NULL,
			`CLIENT_LATITUDE` VARCHAR(255) NOT NULL,
			`CLIENT_LONGITUDE` VARCHAR(255) NOT NULL,
			`TEST_DATE` VARCHAR(255) NOT NULL,
			`SERVER_NAME` VARCHAR(255) NOT NULL,
			`DOWNLOAD_KBPS` VARCHAR(255) NOT NULL,
			`UPLOAD_KBPS` VARCHAR(255) NOT NULL,
			`LATENCY` VARCHAR(255) NOT NULL,
			`CLIENT_BROWSER` VARCHAR(255) NOT NULL,
			`CLIENT_OPERATING_SYSTEM` VARCHAR(255) NOT NULL,
			`USER_AGENT` VARCHAR(255) NOT NULL
		) ENGINE=MyISAM DEFAULT CHARSET=utf8;
	
	
	
	*/
	$arg = " TRUNCATE TABLE tbl_data";

	$rs = mysql_query($arg);

	if (!$rs) {
		echo "Could not execute query: $arg\n";
		trigger_error(mysql_error(), E_USER_ERROR);
	}
	
    do { 
	//echo $data[14];
        if ($data[0]) { 
            mysql_query("INSERT INTO tbl_data (CLIENT_IP,CLIENT_CITY,CLIENT_REGION,CLIENT_COUNTRY,ISP,CLIENT_LATITUDE,CLIENT_LONGITUDE,TEST_DATE,SERVER_NAME,DOWNLOAD_KBPS,UPLOAD_KBPS,LATENCY,CLIENT_BROWSER,CLIENT_OPERATING_SYSTEM,USER_AGENT) VALUES 
                ( 
                    '".addslashes($data[0])."', 
                    '".addslashes($data[1])."', 
                    '".addslashes($data[2])."',
					'".addslashes($data[3])."',
					'".addslashes($data[4])."',
					'".addslashes($data[5])."',
					'".addslashes($data[6])."',
					'".addslashes($data[7])."',
					'".addslashes($data[8])."',
					'".addslashes($data[9])."',
					'".addslashes($data[10])."',
					'".addslashes($data[11])."',
					'".addslashes($data[12])."',
					'".addslashes($data[13])."',
					'".addslashes($data[14])."'
                ) 
            "); 
        } 
    } while ($data = fgetcsv($handle,1000,",",'"')); 
	mysql_query("DELETE FROM tbl_data WHERE id=1");
    // 

    //redirect 
    header('Location: import.php?success=1'); die; 

} 

?> 
<html>
	<head><title>Speedtest Stats</title>
	<?php
		include("header.php");
	?>
	</head>
	
	<body role="document">
		<div class="container theme-showcase" role="main">

<?php if (!empty($_GET[success])) { echo '<div class="alert alert-success" role="alert"><strong>Whoopee!</strong> File successfully uploaded!</div><br />'; } //generic success notice ?> 


			<form action="" method="post" enctype="multipart/form-data" name="form1" id="form1"> 
			  Choose your file: <br /> 
			  <input name="csv" type="file" id="csv" /> 
			  <input type="submit" name="Submit" value="Submit" /> 
			</form> 

		</div>
	</body>
</html>
