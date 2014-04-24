

<?php
error_reporting(-1);
ini_set('display_errors',1);
ini_set('display_startup_errors',1);

require_once("php/database.class.php");
$database = new database();
require_once("php/customers.class.php");
require_once("php/technicians.class.php");

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

    <title>Plant Replacement Manager Edit Customer</title>

    <!-- Bootstrap core CSS-->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/justified-nav.css" rel="stylesheet">

    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8/jquery.min.js"></script>
	<script src="js/List.js"></script>

	<script language="JavaScript">

   	</script>

  </head>

  <body>

    <div class="container">
	
	<!-- Menu buttons -->
      <div class="masthead">
	  
        <p class="navbar-text navbar-right">
		<span class="glyphicon glyphicon-user"></span>
		&nbsp;User Name <br>
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

    <div class="page-header">    <!-- MORE PHP GOES HERE. Haven't gotten to it yet. -->
	  <p style="float:right;"><a href="customers.php"><button type="button" class="btn btn-success">Submit New Customer</button></a></p>
	  <h2>New Customer Form </h2>  <!-- Should say something like "new customer" or their name if it's an edit -->
	  <!-- also, most of this probably shouldn't show if the PHP throws the "no customer selected" thing -->
	</div> 
	<div class="row" >  
		
		<?php 
			/* if (isset($_GET['id'])){
				$customerID = $_GET['id'];
				echo "Customer ID: ".$customerID;
			}else if (isset($_POST['id'])){
				$customerID = $_POST['id'];
				echo "Customer ID: ".$customerID;
			}else{
				echo "No customer selected to edit.";
			} */
			
			// commented because I can't see what I'm doing when it's complaining. And what I'm doing shouldn't 
			// display if the php is complaining anyway.
		// ?> 
	
	<!-- Main body, with graphs and such -->
	
		<div class="col-lg-6">
				<form class="form-horizontal" role="form">
					
					<div class="form-group">
						<label class="col-sm-4 control-label">Customer Name</label>
						<div class="col-sm-5"> 
							<input class="form-control">
						</div>
					</div>
					
					<div class="form-group">
						<label class="col-sm-4 control-label">Technician</label>
						<!-- PHP GOES HERE -->
						<div class="col-sm-5">
							<select class="col-sm-5 form-control">
								<option>Select...</option>
								<option>Bill</option>
								<option>Jeff</option>
							</select>
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
				<form class="form-horizontal" role="form">
					
					<div class="form-group">
						<label class="col-sm-4 control-label">Contact Name</label>
						<div class="col-sm-5"> 
							<input class="form-control">
						</div>
					</div>
					
					
					<div class="form-group">
						<label class="col-sm-4 control-label">Phone</label>
						<div class="col-sm-5"> 
							<input class="form-control" placeholder="(555) 555-5555">
						</div>
					</div>
					
					<div class="form-group">
						<label class="col-sm-4 control-label">Email</label>
						<div class="col-sm-5"> 
							<input class="form-control" placeholder="name@example.com">
						</div>
					</div>
					
					<div class="col-md-6 col-md-offset-4">
						<textarea class="form-control" rows="4" placeholder="Comments"></textarea>
					</div>	
					
					
				</form>
			</div>
			
	
	</div> <!-- ends panel 'row' div -->


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
