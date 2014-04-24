<?php
date_default_timezone_set('America/New_York');

session_start(); // initialize the session
include("passwords.php");
//check_logged(); // if not logged in, user redirected to login page

require_once("php/database.class.php");
$database = new database();
require_once("php/replacements.class.php");
$replacements = new replacements($database);

$rCounts = $replacements->getReplacementCounts();

$needsApproval = isset($rCounts[0]) ? $rCounts[0] : 0;
$approved = isset($rCounts[1]) ? $rCounts[1] : 0;
$completed = isset($rCounts[2]) ? $rCounts[2] : 0;
$cancelled = isset($rCounts[3]) ? $rCounts[3] : 0;

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

    <title>Plant Replacement Manager Dashboard</title>

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
		&nbsp;Admin<br>
		<button type="button" class="btn btn-xs btn-success pull-right">
		Log Out</button>
		</p>
			
		<h3><img src="img/ipslogosmall.jpg"></h3>
        
		<ul class="nav nav-justified">
          <li class="active"><a href="dashboard.php">Dashboard</a></li>
          <li><a href="customers.php">Customers</a></li>
          <li><a href="technicians.php">Technicians</a></li>
          <li><a href="replacements.php">Replacements</a></li>
        </ul>
		
      </div>

	<br><br>
	

	<!-- Main body, with graphs and such -->
	<div class="row">
		
		<div class="col-md-8">
			<div class="list-group">
				<a class="list-group-item list-group-item-success"><b>Statistics</b></a>
				<table class="table table-striped table-hover table-bordered">   
					<tr>
						<td>Most Profitable Customer </td>
						<td>Bob's Automotive </td>
						<td>$400 </td>
					</tr>
					<tr>
						<td>Least Profitable Customer </td>
						<td>Furniture by Bill </td>
						<td>$150 </td>
					</tr>
					
					<tr>
						<td>Technician with Most Replacements </td>
						<td>John Smith</td>
						<td>15 </td>
					</tr>
					
					<tr>
						<td>Technician with Least Replacements </td>
						<td> Bob Smith </td>
						<td>2 </td>
					</tr>
					<tr>
						<td>Technician with Most Points </td>
						<td> Jeff Smith </td>
						<td>5 </td>
					</tr>

					
				 </table>
			</div>
		</div>
				
		<div class="col-md-1"></div>
		
		<div class="col-sm-3">
          <div class="list-group">
          	<a class="list-group-item list-group-item-success"><b>Replacements</b></a>
            <a href="replacements.php?status=0" class="list-group-item">
			<span class="badge pull-left alert-warning"><?php echo $needsApproval;?></span>
			&nbsp;&nbsp;Needs Approval
			<span class="glyphicon glyphicon-chevron-right pull-right"></span>
			</a>
            <a href="replacements.php?status=1" class="list-group-item">
			<span class="badge pull-left alert-info"><?php echo $approved;?></span>
			&nbsp;&nbsp;Approved
			<span class="glyphicon glyphicon-chevron-right pull-right"></span>
			</a>
            <a href="replacements.php?status=2" class="list-group-item">
			<span class="badge pull-left alert-success"><?php echo $completed;?></span>
			&nbsp;&nbsp;Completed
			<span class="glyphicon glyphicon-chevron-right pull-right"></span>
			</a>
            <a href="replacements.php?status=3" class="list-group-item">
			<span class="badge pull-left alert-danger"><?php echo $cancelled;?></span>
			&nbsp;&nbsp;Cancelled
			<span class="glyphicon glyphicon-chevron-right pull-right"></span>
			</a>
          </div>
          <a class="btn btn-success" href="replacementForm.php" style="width:100%;">
          	New Replacement
          	<span class="glyphicon glyphicon-chevron-right pull-right"></span>
          </a>
        </div>
		
		
	</div>
	<br><br>
	<div class="row">
	
		<div class="col-md-0"></div>
	
		<div class="col-md-12">
			<div class="list-group">
				<a class="list-group-item list-group-item-success"><b>Approved Replacements Map</b></a>
				<iframe ]
				src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d3580.325554342321!2d-80.28965199999999!3d26.186086000000003!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x88d90f4d3bd145b1%3A0xd7b4999fbe8f4e41!2sBob&#39;s+Automotive+Services+Inc!5e0!3m2!1sen!2sus!4v1398106750012" 
				width="100%" 
				height="450" 
				frameborder="0" 
				style="border:0">
				</iframe>
				
			</div>
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
