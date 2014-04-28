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
require_once("php/customers.class.php");
$customers = new customers($database);
require_once("php/technicians.class.php");
$technicians = new technicians($database);

$customerList = $customers->getCustomerList();
$techniciansList = $technicians->getTechnicianList();

// Uncomment the line below to show which data is being passed in via form 
//echo "<pre>"; print_r($_POST); echo "</pre>";


$id = null;
if(isset($_GET['id'])){
	$id = $_GET['id'];
} elseif (isset($_POST['id'])){
	$id = $_POST['id'];
}

$action = "edit";
if (is_null($id) || empty($id)){
	$action = "new";
}

$submit = null;
if(isset($_GET['submit'])){
	$submit = $_GET['submit'];
} elseif (isset($_POST['submit'])){
	$submit = $_POST['submit'];
}

if ($submit){
	$name = $_POST['name'];
	$first_name = $_POST['first_name'];
	$last_name = $_POST['last_name'];
	$address1 = $_POST['address1'];
	$address2 = $_POST['address2'];
	$city = $_POST['city'];
	$state = $_POST['state'];
	$zip = $_POST['zip'];
	$phonenumber = $_POST['phonenumber'];
	$gardenerID = $_POST['gardenerID'];
	$monthly_revenue = $_POST['monthly_revenue'];
	$avghours = $_POST['avghours'];
	$quantityID = $_POST['quantityID'];
	$active = $_POST['active'];
	
	if ($action === "new"){
		$customers->addCustomer($name,
									$first_name,
									$last_name,
									$address1,
									$address2,
									$city,
									$state,
									$zip,
									$phonenumber,
									$gardenerID,
									$monthly_revenue,
									$avghours,
									$quantityID,
									$active);
	} else {
		$customers->editCustomer($name,
									$first_name,
									$last_name,
									$address1,
									$address2,
									$city,
									$state,
									$zip,
									$phonenumber,
									$gardenerID,
									$monthly_revenue,
									$avghours,
									$quantityID,
									$active,
									$_POST['id');
	}

	header('Location: ' . "/customers.php", true, 303);
   	die();
}

$thisCustomer = null;
if ($action === "edit"){
	$thisCustomer = $customers->getCustomer($id);
	//echo $id."<pre>"; print_r($thisReplacement); echo "</pre>";
}

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
	  <p style="float:right;"><a href="customers.php"><button type="submit" class="btn btn-success">Submit New Customer</button></a></p>
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
							<input class="form-control" name="name">
						</div>
					</div>
					
					<div class="form-group">
						<label class="col-sm-4 control-label">Technician</label>
						<!-- PHP GOES HERE -->
						<div class="col-sm-5">
							<select class="col-sm-5 form-control" name = "gardenerID">
								<option>Select...</option>
								<?php
								foreach($techniciansList as $technician){
									echo "<option value='";
									echo $technician['gardenerID'];
									echo "'";
									echo ($thisReplacement != null && $thisReplacement['gardenerID'] == $technician['gardenerID']) ? "selected='selected'" : "";
									echo ">";
									echo $technician['first_name']." ".$technician['last_name'];
									echo "</option>\n";
								}
								?>
							</select>
						</div>
					</div>
					
					<div class="form-group">
						<label class="col-sm-4 control-label">Address</label>
						<div class="col-sm-5"> 
							<input class="form-control" name="address1">
						</div>
						<div class="col-sm-5 col-sm-offset-4"> 
							<input class="form-control" name="address2">
						</div>
					</div>
					
					<div class="form-group">
						<label class="col-sm-4 control-label">City</label>
						<div class="col-sm-5"> 
							<input class="form-control" name="city">
						</div>
					</div>
					
					<div class="form-group">
						<label class="col-sm-4 control-label">State</label>
						<div class="col-sm-5">
							<select class="col-sm-5 form-control" name = "state">
								<option>Select...</option>
								<option>Florida</option>
								<option>Other</option>
							</select>
						</div>
					</div>
					
					<div class="form-group">
						<label class="col-sm-4 control-label">Zip</label>
						<div class="col-sm-5"> 
							<input class="form-control" name="zip">
						</div>
					</div>
					
					
				</form>
			</div>
			
			<div class="col-lg-6">
				<form class="form-horizontal" role="form">
					
					<div class="form-group">
						<label class="col-sm-4 control-label">Contact First Name</label>
						<div class="col-sm-5"> 
							<input class="form-control" name = "first_name">
						</div>
					</div>
					
					<div class="form-group">
						<label class="col-sm-4 control-label">Contact Last Name</label>
						<div class="col-sm-5"> 
							<input class="form-control" name = "last_name">
						</div>
					</div>
					
					<div class="form-group">
						<label class="col-sm-4 control-label">Phone</label>
						<div class="col-sm-5"> 
							<input class="form-control" name = "phonenumber" placeholder="(555) 555-5555">
						</div>
					</div>
					
					<div class="form-group">
						<label class="col-sm-4 control-label">Email</label>
						<div class="col-sm-5"> 
							<input class="form-control" name = "email" placeholder="name@example.com">
						</div>
					</div>
					
					<div class="col-md-6 col-md-offset-4">
						<textarea class="form-control" name = "comments" rows="4" placeholder="Comments"></textarea>
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
