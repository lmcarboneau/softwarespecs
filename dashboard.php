<?php
date_default_timezone_set('America/New_York');

session_start(); // initialize the session
require_once("php/util.class.php");
if(!util::checkLogged()){
	$_SESSION = array();
	session_destroy();
	header('Location: ' . "/login.php", true, 303);
   	die();
}

require_once("php/database.class.php");
$database = new database();
require_once("php/replacements.class.php");
$replacements = new replacements($database);
require_once("php/technicians.class.php");
$technicians = new technicians($database);
require_once("php/customers.class.php");
$customers = new customers($database);

$rCounts = $replacements->getReplacementCounts();

$needsApproval = isset($rCounts[0]) ? $rCounts[0] : 0;
$approved = isset($rCounts[1]) ? $rCounts[1] : 0;
$completed = isset($rCounts[2]) ? $rCounts[2] : 0;
$cancelled = isset($rCounts[3]) ? $rCounts[3] : 0;

$month = date('F');

$mostEfficientCustomer = $customers->getMostEfficient();
$leastEfficientCustomer = $customers->getLeastEfficient();

$mostEfficientTechnician = $technicians->getMostEfficient();
$leastEfficientTechnician = $technicians->getLeastEfficient();

//echo "<pre>"; print_r($mostEfficientTechnician); echo "</pre>";


$mapQuery = "Bob's Auto Repair, Fort Myers, Florida";
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
		&nbsp;<?php echo $_SESSION['displayname'];?><br>
		<a href="/logout.php" class="btn btn-xs btn-success pull-right">
		Log Out</a>
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
				<a class="list-group-item list-group-item-success"><b><?php echo $month?> Statistics</b></a>
				<table class="table table-striped table-hover table-bordered">   
					<tr>
						<td>Most Efficient Customer</td>
						<td><a href="customerDetail.php?id=<?php echo $mostEfficientCustomer['customerID'];?>"><?php echo $mostEfficientCustomer['customer_name'];?></a></td>
						<td align="right"><?php echo floor($mostEfficientCustomer['rating']);?> Points</td>
					</tr>
					<tr>
						<td>Least Efficient Customer</td>
						<td><a href="customerDetail.php?id=<?php echo $leastEfficientCustomer['customerID'];?>"><?php echo $leastEfficientCustomer['customer_name'];?></a></td>
						<td align="right"><?php echo floor($leastEfficientCustomer['rating']);?> Points</td>
					</tr>
					<tr>
						<td>Most Efficient Technician</td>
						<td><a href="technicianDetail.php?id=<?php echo $mostEfficientTechnician['gardenerID'];?>"><?php echo $mostEfficientTechnician['first_name']." ".$mostEfficientTechnician['last_name'];?></a></td>
						<td align="right"><?php echo floor($mostEfficientTechnician['rating']);?> Points</td>
					</tr>
					<tr>
						<td>Least Efficient Technician</td>
						<td><a href="technicianDetail.php?id=<?php echo $leastEfficientCustomer['gardenerID'];?>"><?php echo $leastEfficientTechnician['first_name']." ".$leastEfficientTechnician['last_name'];?></a></td>
						<td align="right"><?php echo floor($leastEfficientTechnician['rating']);?> Points</td>
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
		
		<div class="col-md-12">
			<div class="list-group">
				<a class="list-group-item list-group-item-success"><b>Approved Replacements Map</b></a>
				<iframe ]
				src="https://www.google.com/maps/embed/v1/place?key=AIzaSyABVQ1AFYdGjKXmHiSsSHhup_Xo5LqM3Gc&q='<?php echo $mapQuery?>'"
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
