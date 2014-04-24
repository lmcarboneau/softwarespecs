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

// MORE PHP GOES HERE. Haven't gotten to it yet.

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

    <title>Technician Form</title>

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

	
	<div class="page-header">    <!-- MORE PHP GOES HERE. Haven't gotten to it yet. -->
	  <p style="float:right;"><a href="technicians.php"><button type="button" class="btn btn-success">Save Changes</button></a></p>
	  <h2>Technician Form </h2>  <!-- Should say something like "new tech" or their name if it's an edit -->
	</div>

	<!-- Main body, with graphs and such -->
	<br>
	<div class="row">
		<div class="col-lg-6">
			<form class="form-horizontal" role="form">
				
				<div class="form-group">
					<label class="col-sm-4 control-label">First Name</label>
					<div class="col-sm-5"> 
						<input class="form-control">
					</div>
				</div>
				
				<div class="form-group">
					<label class="col-sm-4 control-label">Last Name</label>
					<div class="col-sm-5"> 
						<input class="form-control">
					</div>
				</div>
				
				<div class="form-group">
					<label class="col-sm-4 control-label">Address</label>
					<div class="col-sm-5"> 
						<input class="form-control">
					</div>
					<div class="col-sm-5 col-sm-offset-4"> 
						<input class="form-control">
					</div>
				</div>
				
				<div class="form-group">
					<label class="col-sm-4 control-label">City</label>
					<div class="col-sm-5"> 
						<input class="form-control">
					</div>
				</div>
				
				<div class="form-group">
					<label class="col-sm-4 control-label">State</label>
					<div class="col-sm-5">
						<select class="col-sm-5 form-control">
							<option>Select...</option>
							<option>Florida</option>
							<option>Other</option>
						</select>
					</div>
				</div>
				
				<div class="form-group">
					<label class="col-sm-4 control-label">Zip</label>
					<div class="col-sm-5"> 
						<input class="form-control">
					</div>
				</div>
				
				
			</form>
		</div>
		
		<div class="col-lg-6">
			
			<div>
				<label>Photo</label>
				<br>
				<img
				  width="50%"
				  height="250"
				  frameborder="0" style="border:0"
				  src="sample_tech.jpg"/>
				
			</div>
			<br>
			<div class="row" style="width:100%">
				<div class="col-md-6 col-md-offset-2">
				<button type="button" class="btn btn-default">Upload New Photo</button>
				</div>
			</div>
		</div>
		
	</div>
	<br><br>
	
	
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
