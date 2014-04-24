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

    <title>New Replacement Form</title>

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
          <li><a href="technicians.php">Technicians</a></li>
          <li class="active"><a href="replacements.php">Replacements</a></li>
        </ul>
		
      </div>

	<br><br>
	
	<div class="page-header">    <!-- MORE PHP GOES HERE. Haven't gotten to it yet. -->
	  <p style="float:right;"><a href="replacements.php"><button type="button" class="btn btn-success">Submit Replacement</button></a></p>
	  <h2>Replacement Form </h2>
	</div>

	<!-- Main body, with graphs and such -->
	<div class="row">
		
		<div class="col-lg-5">
			<h3>Customer</h3>
			<br>
			
			<form class="form-horizontal" role="form">
			
				<div class="form-group">
					<label class="col-sm-4 control-label">Date Requested</label>
					<div class="col-sm-5"> 
						<input class="form-control" placeholder="mm/dd/yyyy">
					</div>
				</div>
			
				<div class="form-group">
					<label class="col-sm-4 control-label">Technician</label>
					<div class="col-sm-5">
						<select class="col-sm-5 form-control">
							<option>Select...</option>
							<option>Yes</option>
						</select>
					</div>
				</div>
				
				<div class="form-group">
					<label class="col-sm-4 control-label">Account</label>
					<div class="col-sm-5">
						<select class="col-sm-5 form-control">
							<option>Select...</option>
							<option>FGCU</option> <!-- CAN PHP GO HERE? Haven't got a clue. -->
							<option>No</option>
							<option>Yes</option>
							<option>No</option>
							<option>Yes</option>
							<option>No</option>
							<option>Yes</option>
						</select>
					</div>
				</div>
				
				<div class="form-group">
					<label class="col-sm-4 control-label">Emergency</label>
					<div class="col-sm-5">
						<select class="col-sm-5 form-control">
							<option>No</option>
							<option>Yes</option>
						</select>
					</div>
				</div>
			
			</form>
			<br><br>
		</div>
			
			
		<div class="col-lg-5">
			<h3>Plant</h3>
			<br>
			
			<form class="form-horizontal" role="form">
				
				<div class="form-group">
					<label class="col-sm-3 control-label">Plant Type</label>
					<div class="col-sm-5">
						<select class="col-sm-5 form-control">
							<option>Select...</option>
							<option>Standard</option>
						</select>
					</div>
				</div>
				
				<div class="form-group">
					<label class="col-sm-3 control-label">Light Level</label>
					<div class="col-sm-5">
						<select class="col-sm-5 form-control">
							<option>Select...</option>
							<option>1</option>
							<option>2</option>
							<option>3</option>
							<option>4</option>
							<option>5</option>
							<option>6</option>
							<option>7</option>
							<option>8</option>
							<option>9</option>
							<option>10</option>
						</select>
					</div>
				</div>
				<br>
				
				<div class="col-lg-8">
					<textarea class="form-control" rows="3" placeholder="Comments"></textarea>
				</div>	
				
			</form>
			<br><br>
		</div>
		
		
		<div class="col-lg-2">
			<h3>Admin</h3>
			<br>
			
			<div class="radio">
			  <label>
				<input type="radio" name="optionsRadios" id="optionsRadios1" value="option1">
				Approved
			  </label>
			</div>
			<div class="radio">
			  <label>
				<input type="radio" name="optionsRadios" id="optionsRadios2" value="option2">
				Cancelled
			  </label>
			</div>
			<br>
			<div class="radio">
			  <label>
				<input type="radio" name="optionsRadios" id="optionsRadios3" value="option3">
				Completed
			  </label>
			</div>
			
			<div class="form-group">
				<div> 
					<input class="form-control" placeholder="mm/dd/yyyy">
				</div>
			</div>
			<br><br>
			
			<label class="control-label">Total Cost</label>
			<div> 
				<input class="form-control" placeholder="$0.00">
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
