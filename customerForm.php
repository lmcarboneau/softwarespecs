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
	// HARDCODED
	$monthly_revenue = 300;
	// HARDCODED
	$avghours = 3;
	// HARDCODED
	$quantityID = 0;
	// ACTIVE IS HARDCODED TRUE
	$active = true;
	
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
									$_POST['id']);
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

    <script type="text/javascript" src="/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="/js/moment.min.js"></script>
	<script src="js/bootstrap-datetimepicker.min.js"></script>
	<script src="js/jquery.validate.min.js"></script>
	<script src="js/additional-methods.min.js"></script>	
    
	<script language="JavaScript">
		// override jquery validate plugin defaults
		$.validator.setDefaults({
		    highlight: function(element) {
		        $(element).closest('.form-group').addClass('has-error');
		    },
		    unhighlight: function(element) {
		        $(element).closest('.form-group').removeClass('has-error');
		    },
		    errorElement: 'span',
		    errorClass: 'help-block',
		    errorPlacement: function(error, element) {
		    	if(element.hasClass("statusOption")){
		    		$(".statusError").append(error);
		    	} else {
			        if(element.parent('.input-group').length) {
			            error.insertAfter(element.parent());
			        } else {
			            error.insertAfter(element);
			        }
		    	}
		    }
		});

		$(function () {
                var validator = $("#mainForm").validate({
                	rules:{
                		zip:{
                			zipcodeUS: true
                		},
                		phonenumber:{
                			phoneUS: true
                		}
                	}
                });
        });
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
	  
	  	<form id="mainForm" class="form-horizontal" role="form" action="customerForm.php" method="POST">
		<input type="hidden" name="id" value="<?php echo $id;?>"/>
		<input type="hidden" name="action" value="<?php echo $action;?>"/>
		<input type="hidden" name="submit" value="true"/>

    <div class="page-header">    <!-- MORE PHP GOES HERE. Havent gotten to it yet. -->
	  <p style="float:right;"><button type="submit" class="btn btn-success">
	  <?php echo ($action === "new") ? "Submit New Customer" : "Save Changes"?>
	  </button></p>
	  <h2><?php echo ($action === "new") ? "New Customer" : "Edit Customer"?></h2>
	</div>


	<div class="row" >  
		<div class="col-lg-6">
					<div class="form-group">
						<label class="col-sm-4 control-label">Customer Name</label>
						<div class="col-sm-5"> 
							<input class="form-control" name="name" 
								value="<?php echo ($thisCustomer != null) ? $thisCustomer['customer_name'] : "";?>"
								required >
						</div>
					</div>
					
					<div class="form-group">
						<label class="col-sm-4 control-label">Technician</label>
						<!-- PHP GOES HERE -->
						<div class="col-sm-5">
							<select class="col-sm-5 form-control" name = "gardenerID" required>
								<option value="">Select...</option>
								<?php
								foreach($techniciansList as $technician){
									echo "<option value='";
									echo $technician['gardenerID'];
									echo "'";
									echo ($thisCustomer != null && $thisCustomer['gardenerID'] == $technician['gardenerID']) ? "selected='selected'" : "";
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
							<input class="form-control" name="address1"
								value="<?php echo ($thisCustomer != null) ? $thisCustomer['address_line_one'] : "";?>"
								required>
						</div>
						<div class="col-sm-5 col-sm-offset-4"> 
							<input class="form-control" name="address2"
								value="<?php echo ($thisCustomer != null) ? $thisCustomer['address_line_two'] : "";?>"
								required >
						</div>
					</div>
					
					<div class="form-group">
						<label class="col-sm-4 control-label">City</label>
						<div class="col-sm-5"> 
							<input class="form-control" name="city"
								value="<?php echo ($thisCustomer != null) ? $thisCustomer['city'] : "";?>"
								required>
						</div>
					</div>
					
					<div class="form-group">
						<label class="col-sm-4 control-label">State</label>
						<div class="col-sm-5">
							<select class="col-sm-5 form-control" name = "state" required>
								<option><?php echo ($thisCustomer != null) ? $thisCustomer['state'] : "";?></option>
								<option>Florida</option>
								<option>Other</option>
							</select>
						</div>
					</div>
					
					<div class="form-group">
						<label class="col-sm-4 control-label">Zip</label>
						<div class="col-sm-5"> 
							<input class="form-control" name="zip" 
								value="<?php echo ($thisCustomer != null) ? $thisCustomer['zip'] : "";?>"
								required>
						</div>
					</div>
					
					
			</div>
			
			<div class="col-lg-6">
					
					<div class="form-group">
						<label class="col-sm-4 control-label">Contact First Name</label>
						<div class="col-sm-5"> 
							<input class="form-control" name="first_name" 
								value="<?php echo ($thisCustomer != null) ? $thisCustomer['contact_first_name'] : "";?>"
								required>
						</div>
					</div>
					
					<div class="form-group">
						<label class="col-sm-4 control-label">Contact Last Name</label>
						<div class="col-sm-5"> 
							<input class="form-control" name="last_name"
								value="<?php echo ($thisCustomer != null) ? $thisCustomer['contact_last_name'] : "";?>"
								required>
						</div>
					</div>
					
					<div class="form-group">
						<label class="col-sm-4 control-label">Phone</label>
						<div class="col-sm-5"> 
							<input class="form-control" name="phonenumber" placeholder="(555) 555-5555" 
								value="<?php echo ($thisCustomer != null) ? $thisCustomer['phonenumber'] : "";?>"
								required>
						</div>
					</div>
					
					<!-- These are not in the database or the SRS so we don't need them yet, should be re-enabled for the final version
					<div class="form-group">
						<label class="col-sm-4 control-label">Email</label>
						<div class="col-sm-5"> 
							<input class="form-control" name="email" placeholder="name@example.com">
						</div>
					</div>
					
					<div class="col-md-6 col-md-offset-4">
						<textarea class="form-control" name="comments" rows="4" placeholder="Comments"></textarea>
					</div>	
					--!>
					
					
			</div>
			
	
	</div> <!-- ends panel 'row' div -->
	</form>

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
