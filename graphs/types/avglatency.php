<?php

/*
*
*	This script will calculate the average latency of a specified interval.
*	Preconditions include: ISP, country, city and region
*
*/


include('../../config.php');

// Create connection
$conn = new mysqli($config['db_host'], $config['db_user'], $config['db_pass'], $config['db_name']);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

//Obtain values to use later
$country = $_GET['country'];
$company_name = $_GET['isp'];
$city = $_GET['city'];
$region = $_GET['region'];
$title = "Average Latency for ".$company_name." customers in ".$city.", ".$region." per week";
$tests = array();
$latency = array();

$xaxis = array();
$yaxis = array();


//Perform query and store data in array
$sql = "SELECT `TEST_DATE`, `LATENCY` FROM tbl_data WHERE ISP = '".$company_name."' AND CLIENT_CITY = '".$city."' AND CLIENT_REGION = '".$region."' AND CLIENT_COUNTRY = '".$country."'";
$result = $conn->query($sql);

//manipulate data
if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
		//$string = explode(" ",$row["TEST_DATE"]);
		$string = substr($row["TEST_DATE"], strpos($row["TEST_DATE"], " "), 3);
		//print $string[0];
		
		$string = $string.=":00";
		//echo $string."<br />";
		$tests[$string] = $tests[$string]+1;
		$latency[$string] = $latency[$string]+$row["LATENCY"];
		
    }
} else {
    echo "0 results";
}

//calculate the average
foreach ($tests as $key => $value){

	$latency[$key] = round(($latency[$key]/$value),2);
	//echo $key.' '.$value.' '.$total_speed[$key].'<br />';
	
	$yaxis[] = $latency[$key];
	//echo $key." = ".$value.' avglatency = '.$latency[$key].'<br />';
	$xaxis[] = $key;
}


// Jpgraph configuration
require_once ('../../jpgraph/src/jpgraph.php');
require_once ('../../jpgraph/src/jpgraph_line.php');

// Setup the graph
$graph = new Graph(700,700);
$graph->SetScale("textlin");

$theme_class=new UniversalTheme;
$graph->SetTheme($theme_class);

$graph->SetTheme($theme_class);
$graph->img->SetAntiAliasing(false);
$graph->title->Set($title);
$graph->SetBox(false);

$graph->img->SetAntiAliasing();

$graph->yaxis->HideZeroLabel();
$graph->yaxis->HideLine(false);
$graph->yaxis->HideTicks(false,false);

$graph->xgrid->Show();
$graph->xgrid->SetLineStyle("solid");
$graph->xaxis->SetTickLabels($xaxis);
$graph->xaxis->SetLabelAngle(50);
$graph->xgrid->SetColor('#E3E3E3');

// Create the first line
$p1 = new LinePlot($yaxis);
$graph->Add($p1);
$p1->value->SetFormat('%s');
$p1->value->SetMargin(10);
$p1->mark->SetType(MARK_FILLEDCIRCLE,'',1.0);
$p1->mark->SetFillColor('#6495ED');
$p1->SetCenter();
$p1->value->Show();
$p1->SetLegend('Download');

$graph->legend->SetMarkAbsSize(8);
$graph->legend->SetFrameWeight(1);

// Output line
$graph->Stroke();

?>
