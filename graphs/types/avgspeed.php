<?php

/*
*
*	This script will calculate the average speed of a specified interval.
*	Preconditions include: Country, City, Region and ISP
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
$title = "Average Speed(Mbps) for ".$company_name." customers in ".$city.", ".$region." per week";
$tests = array();
$speed_down = array();
$speed_up = array();

$xaxis = array();
$yaxis = array();
$y2axis = array();


//Perform query and store data in array
$sql = "SELECT `TEST_DATE`, `DOWNLOAD_KBPS`, `UPLOAD_KBPS` FROM tbl_data WHERE ISP = '".$company_name."' AND CLIENT_CITY = '".$city."' AND CLIENT_REGION = '".$region."' AND CLIENT_COUNTRY = '".$country."'";
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
		$speed_down[$string] = $speed_down[$string]+$row["DOWNLOAD_KBPS"];
		$speed_up[$string] = $speed_up[$string]+$row["UPLOAD_KBPS"];
    }
} else {
    echo "0 results";
}

//calculate the average
foreach ($tests as $key => $value){
	
	
	$speed_down[$key] = round(($speed_down[$key]/$value)*.001,1);
	$speed_up[$key] = round(($speed_up[$key]/$value)*.001,1);
	//echo $key.' '.$value.' '.$total_speed[$key].'<br />';
	
	$yaxis[] = $speed_down[$key];
	$y2axis[] = $speed_up[$key];
	//echo $key.'<br />';
	$xaxis[] = $key;
}

//TEST GRAPH STUFF 

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


// Create the second line
$p2 = new LinePlot($y2axis);
$graph->Add($p2);
$p2->value->SetMargin(-20);
$p2->mark->SetType(MARK_FILLEDCIRCLE,'',1.0);
$p2->mark->SetFillColor('#B22222');
$p2->value->SetFormat('%s');
$p2->value->Show();
$p2->SetLegend('Upload');

$graph->legend->SetMarkAbsSize(8);
$graph->legend->SetFrameWeight(1);

// Output line
$graph->Stroke();

?>

