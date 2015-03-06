<?php
	include_once('config.php');
?>
    <link rel="stylesheet" type="text/css" href="css/bootstrap.css">
    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap theme -->
    <link href="css/bootstrap-theme.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="theme.css" rel="stylesheet">
	
	    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/docs.min.js"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="js/ie10-viewport-bug-workaround.js"></script>

    <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
    <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
    <script src="js/ie-emulation-modes-warning.js"></script>
	<nav class="navbar navbar-inverse">
	<div class="container">
	  <div class="navbar-header">
		<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".navbar-collapse">
		  <span class="i">Toggle navigation</span>
		  <span class="icon-bar"></span>
		  <span class="icon-bar"></span>
		  <span class="icon-bar"></span>
		</button>
		<a class="navbar-brand" href="index.php"><?php echo $config['header-title']; ?></a>
	  </div>
	  <div class="navbar-collapse collapse">
		<ul class="nav navbar-nav">
		  <li><a href="index.php">Home</a></li>
		  <li><a href="graphs.php">Graphs</a></li>
		  <li class="dropdown">
			<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Advanced <span class="caret"></span></a>
			<ul class="dropdown-menu" role="menu">
			<!---
			  <li><a href="#">Action</a></li>
			  <li><a href="#">Another action</a></li>
			  <li><a href="#">Something else here</a></li>
			  <li class="divider"></li>
			  -->
			  <li class="dropdown-header">Data Manipulation</li>
			  <li><a href="import.php">Upload CSV File</a></li>
			  <li><a href="rdata.php">View Raw Data (WARNING!)</a></li>
			  <li class="dropdown-header">Version: <?php echo $config['version']; ?></li>
			</ul>
		  </li>
		</ul>
	  </div><!--/.nav-collapse -->
	</div>
	</nav>
