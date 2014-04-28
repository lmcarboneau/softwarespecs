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
	$first_name = $_POST['first_name'];
	$last_name = $_POST['last_name'];
	$hourly_wage = $_POST['hourly_wage'];


	if ($action === "new"){
		$technicians->addTechnician($first_name,
										$last_name,
										$hourly_wage);
	} else {
		$technicians->editTechnician($first_name,
										$last_name,
										$hourly_wage,
										$_POST['id']);
	}

	header('Location: ' . "/technicians.php", true, 303);
   	die();
}

$thisTechnician = null;
if ($action === "edit"){
	$thisTechnician = $technicians->getTechnician($id);
	//echo $id."<pre>"; print_r($thisReplacement); echo "</pre>";
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
	
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8/jquery.min.js"></script>
	<script type="text/javascript" src="/js/bootstrap.min.js"></script>
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
				  rules: {
				    hourly_wage: {
				      required: true,
				      integer: true
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

	
	<form id="mainForm" class="form-horizontal" role="form" action="technicianForm.php" method="POST">
	<input type="hidden" name="id" value="<?php echo $id;?>"/>
	<input type="hidden" name="action" value="<?php echo $action;?>"/>
	<input type="hidden" name="submit" value="true"/>
	<div class="page-header">    <!-- MORE PHP GOES HERE. Haven't gotten to it yet. -->
	  <p style="float:right;"><button type="submit" class="btn btn-success">
	  <?php echo ($action === "new") ? "Submit New Technician" : "Save Changes"?>
	  </button></p>
	  <h2><?php echo ($action === "new") ? "New Technician" : "Edit Technician"?></h2>
	</div>

	<!-- Main body, with graphs and such -->
	<br>
	<div class="row">
		<div class="col-lg-6">				
				<div class="form-group">
					<label class="col-sm-4 control-label">First Name</label>
					<div class="col-sm-5"> 
						<input 
							type="text"
							class="form-control" 
							name="first_name" 
							value="<?php echo ($thisTechnician != null) ? $thisTechnician['first_name'] : "";?>"
							required>
					</div>
				</div>
				
				<div class="form-group">
					<label class="col-sm-4 control-label">Last Name</label>
					<div class="col-sm-5"> 
						<input 
							type="text"
							class="form-control" 
							name="last_name" 
							value="<?php echo ($thisTechnician != null) ? $thisTechnician['last_name'] : "";?>"
							required>
					</div>
				</div>
				
				<div class="form-group">
					<label class="col-sm-4 control-label">Hourly Wage</label>
					<div class="col-sm-5">
						<div class="input-group"> 
						<span class="input-group-addon">$</span>
						<input 
							type="text"
							class="form-control" 
							name="hourly_wage" 
							value="<?php echo ($thisTechnician != null) ? $thisTechnician['hourly_wage'] : "";?>">						<span class="input-group-addon">.00</span>
						</div>
					</div>
				</div>
				
				<!-- THESE FIELDS ARE NOT CURRENTLY IN OUR DATABASE
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
				</div> !-->
				
				
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
	</form>
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
