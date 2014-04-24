<?php
date_default_timezone_set('America/New_York');
session_start(); // initialize the session
require_once("php/util.class.php");
if(!util::checkLogged()){
	$_SESSION = array();
	session_destroy();
	header('Location: ' . "/login.html", true, 303);
   	die();
}

require_once("php/database.class.php");
$database = new database();
require_once("php/technicians.class.php");
$technicians = new technicians($database);
require_once("php/replacements.class.php");
$replacements = new replacements($database);

$technicianID = null;
if (isset($_GET['id'])){
	$technicianID = $_GET['id'];
}else if (isset($_POST['id'])){
	$technicianID = $_POST['id'];
}
if (is_null($technicianID)){
   header('Location: ' . "technicians.php", true, 303);
   die();
}

$thisTechnician = $technicians->getTechnician($technicianID);

// Uncomment this to view raw customer data for debugging
// echo "<pre>"; print_r($thisTechnician); echo "</pre>";

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="App Dashboard">
    <meta name="designer" content="Stetson Gafford">
    <meta name="author" content="Lindsey Carboneau">
    <link rel="shortcut icon" href="../../assets/ico/favicon.ico">

    <title>Technician Detail Information</title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">   

    <!-- Custom styles for this template -->
    <link href="css/justified-nav.css" rel="stylesheet">  
	
    

  </head>

  <body>

    <div class="container">
	
	<!-- Menu buttons -->
      <div class="masthead">
	  
        <p class="navbar-text navbar-right">
		<span class="glyphicon glyphicon-user"></span>
		&nbsp;<?php echo $_SESSION['displayname'];?><br>
		<a href="/logout.php" class="btn btn-xs btn-success pull-right">
		Log Out</a>
		</p>
			
		<h3><img src="img/ipslogosmall.jpg"></h3>
        
		<ul class="nav nav-justified">
          <li><a href="dashboard.php">Dashboard</a></li>
          <li><a href="customers.php">Customers</a></li>
          <li class="active"><a href="technicians.php">Technicians</a></li>
          <li><a href="replacements.php">Replacements</a></li>
        </ul>
		
      </div>

	<div class="page-header">  
	  <p style="float:right;"><a href="#"><button type="button" class="btn btn-success">Edit Technician Info</button></a></p>
	  <!-- PHP GOES HERE -->
	  <h2><?php echo $thisTechnician['first_name']." ".$thisTechnician['last_name'];?></h2>
	</div>  

	<!-- Main body, with graphs and such -->
	<div class="row">
		<div class="col-md-6">
			<img
			  width="50%"
			  height="250"
			  frameborder="0" style="border:0"
			  src="sample_tech.jpg">
			</img>
			<div class="col-md-6">
			<p style="float:right;"><a href="customers.php?search=<?php echo urlencode($thisTechnician['first_name']." ".$thisTechnician['last_name']);?>"><button type="button" class="btn btn-success">View Assigned Customers</button></a></p>
				<!-- PHP GOES HERE - bring up technicians chart pre-sorted by $thisTechnician or $id -->
			</div>

			<div class="col-md-4">
				</div>
			
		</div>
		
		<div class="col-md-6">
			<ul class="nav nav-justified">
			<li><a href="#">Charts</a></li>
			<li class="active"><a href="#"> Replacements</a></li>
			<li><a href="#"> Monthly Data</a></li>
        </ul>
		
		
		 <table class="table table-bordered table-striped table-hover">   
			<tr>
				<th>Date </th>
				<th>Customer </th>
				<th>Emergency </th>
				<th>Status </th>
			</tr>
			
			<tr>
				<td>2014-03-05 </td>
				<td>Bob's Automotive </td>
				<td>No </td>
				<td>Approved </td>
			</tr>
			
			<tr>
				<td>2014-04-21 </td>
				<td>Bob's Automotive </td>
				<td>No </td>
				<td>Completed </td>
			</tr>
			
		 </table>
		
		</div>
		
	</div>
	
	  <!-- Site footer -->
      <div class="footer">
        <p>&copy; Multitrack Engineering 2014</p>
      </div>

    </div> <!-- /container -->


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
	
  </body>
</html>