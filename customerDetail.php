<?php
date_default_timezone_set('America/New_York');
session_start(); // initialize the session
//check_logged(); // if not logged in, user redirected to login page

require_once("php/database.class.php");
$database = new database();
require_once("php/customers.class.php");
$customers = new customers($database);
require_once("php/replacements.class.php");
$replacements = new replacements($database);

$customerID = null;
if (isset($_GET['id'])){
	$customerID = $_GET['id'];
}else if (isset($_POST['id'])){
	$customerID = $_POST['id'];
}
if (is_null($customerID)){
   header('Location: ' . "customers.php", true, 303);
   die();
}

$thisCustomer = $customers->getCustomer($customerID);

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

    <title>Customer Detail Tracking</title>

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
		&nbsp;Admin <br>
		<button type="button" class="btn btn-xs btn-success pull-right">
		Log Out</button>
		</p>
			
		<h3><img src="img/ipslogosmall.jpg"></h3>
        
		<ul class="nav nav-justified">
          <li><a href="dashboard.php">Dashboard</a></li>
          <li class="active"><a href="customers.php">Customers</a></li>
          <li><a href="technicians.php">Technicians</a></li>
          <li><a href="replacements.php">Replacements</a></li>
        </ul>
		
      </div>

	<div class="page-header">  
	  <p style="float:right;"><a href="#"><button type="button" class="btn btn-success">Edit Customer Info</button></a></p>
	  <h2><?php echo $thisCustomer['customer_name']?></h2>
	</div>  

	<!-- Main body, with graphs and such -->
	<div class="row">
		<div class="col-md-6">
			<iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d3580.325554342321!2d-80.28965199999999!3d26.186086000000003!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x88d90f4d3bd145b1%3A0xd7b4999fbe8f4e41!2sBob&#39;s+Automotive+Services+Inc!5e0!3m2!1sen!2sus!4v1398106750012" width="100%" height="350" frameborder="0" style="border:0"></iframe>

			<div class="col-md-6">
				<h4>Contact Information</h4>
			<!-- INSERT PHP HERE -->
				<h6><?php echo $thisCustomer['contact_first_name']." ".$thisCustomer['contact_last_name'];?></h6>
				<h6><?php echo $thisCustomer['address_line_one'];?></h6>
				<h6><?php echo $thisCustomer['address_line_two'];?></h6>
				<h6><?php echo $thisCustomer['city'].", ".$thisCustomer['state']." ".$thisCustomer['zip'];?></h6><br>
				<h6><?php echo $thisCustomer['phonenumber'];?></h6>
			<!-- INSERT PHP HERE -->
			</div>

			<div class="col-md-6">
				<h4>Assigned Technician</h4>
				<!-- INSERT PHP HERE -->
				<h6>
					<a href="technicianDetail.php?id=<?php echo $thisCustomer['gardenerID'];?>">
					<?php echo $thisCustomer['first_name']." ".$thisCustomer['last_name']
					</a>
				</h6>
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
				<th>Technician </th>
				<th>Emergency </th>
				<th>Status </th>
			</tr>
			
			<tr>
				<td>2014-03-05 </td>
				<td>Jeff Smith </td>
				<td>No </td>
				<td>Approved </td>
			</tr>
			
			<tr>
				<td>2014-04-21 </td>
				<td>Jeff </td>
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
