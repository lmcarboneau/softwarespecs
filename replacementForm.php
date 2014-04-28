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

//echo "<pre>Post Data\n"; print_r($_POST); echo "</pre>";


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

	$date_submitted = $_POST['date_submitted'];
	$gardenerID = $_POST['technician'];
	$customerID = $_POST['customer'];
	$emergency = $_POST['emergency'];
	$plant_type = $_POST['plant_type'];
	$light_level = $_POST['light_level'];
	$comments = $_POST['comments'];
	$status = $_POST['status'];
	$date_completed = $_POST['date_completed'];

	if ($status != 2){
		$date_completed = 'NULL';
	}

	$result = null;
	if ($action === "new"){
		$result = $replacements->addReplacement($customerID,
										$gardenerID,
										$plant_type,
										$light_level,
										$emergency,
										"",
										$comments,
										$status,
										$date_submitted,
										$date_completed);
	} else {
		$result = $replacements->editReplacement($customerID,
										$gardenerID,
										$plant_type,
										$light_level,
										$emergency,
										"",
										$comments,
										$status,
										$date_submitted,
										$date_completed,
										$_POST['id']);
	}

	//echo "<pre>Result\n"; print_r($result); echo "</pre>";
	header('Location: ' . "/replacements.php", true, 303);
   	die();
}

$thisReplacement = null;
if ($action === "edit"){
	$thisReplacement = $replacements->getReplacement($id);
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

    <title>Replacement Form</title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">   

    <!-- Custom styles for this template -->
    <link href="css/justified-nav.css" rel="stylesheet">  

    <!-- Datepicker CSS -->
    <link href="css/bootstrap-datetimepicker.min.css" rel="stylesheet">  

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
                $('.datepicker').datetimepicker({
                     pickTime: false,
                     useStrict: true
                });

                var validator = $("#mainForm").validate();

                // Update validation for datepickers on value change
                $(".datepicker").on("dp.change",function (e) {
	               validator.element(e);
	            });


	           $('input[name="status"]').change(
				    function(){
				        if ($(this).val()==2) {
					         $("#completedDate").rules("add", "required dateISO");
					    } else  {
					    	$("#completedDate").rules("remove", "required dateISO");
					    }
				    }
				);
	           $('input[name="status"]').trigger("change");
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
          <li><a href="technicians.php">Technicians</a></li>
          <li class="active"><a href="replacements.php">Replacements</a></li>
        </ul>
		
      </div>
	
	<form id="mainForm" class="form-horizontal" role="form" action="replacementForm.php" method="POST">
	<input type="hidden" name="id" value="<?php echo $id;?>"/>
	<input type="hidden" name="action" value="<?php echo $action;?>"/>
	<input type="hidden" name="submit" value="true"/>

	<div class="page-header">    <!-- MORE PHP GOES HERE. Haven't gotten to it yet. -->
	  <p style="float:right;"><button type="submit" class="btn btn-success">
	  <?php echo ($action === "new") ? "Submit New Replacement" : "Save Changes"?>
	  </button></p>
	  <h2><?php echo ($action === "new") ? "New Replacement" : "Edit Replacement"?></h2>
	</div>

	<!-- Main body, with graphs and such -->
	<div class="row">
		<div class="col-lg-5">
			<h3>Customer</h3>
			<br>
			
			
			
				<div class="form-group">
					<label for="date_submitted"class="col-sm-4 control-label">Date Requested</label>
					<div class="col-sm-5"> 
						<div class='input-group date datepicker' id="picker1" data-date-format="YYYY-MM-DD">
		                    <input 
		                    	type='text' 
		                    	class="form-control" 
		                    	name="date_submitted" 
		                    	value="<?php echo ($thisReplacement == null) ? "" : $thisReplacement['date_submitted'];?>"
		                    	required
		                    	dateISO="true"
		                    />
		                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
		                </div>
					</div>
				</div>
			
				<div class="form-group">
					<label class="col-sm-4 control-label">Technician</label>
					<div class="col-sm-5">
						<select name="technician" class="col-sm-5 form-control" required>
							<option value="">Select...</option>
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
					<label class="col-sm-4 control-label">Account</label>
					<div class="col-sm-5">
						<select name="customer" class="col-sm-5 form-control" required>
							<option value="">Select...</option>
							<?php 
							foreach($customerList as $customer){
								echo "<option value='";
								echo $customer['customerID'];
								echo "'";
								echo ($thisReplacement != null && $thisReplacement['customerID'] == $customer['customerID']) ? "selected='selected'" : "";
								echo ">";
								echo $customer['customer_name'];
								echo "</option>\n";
							}
							?>
						</select>
					</div>
				</div>
				
				<div class="form-group">
					<label class="col-sm-4 control-label">Emergency</label>
					<div class="col-sm-5">
						<select name="emergency" class="col-sm-5 form-control" required>
							<option value="0" <?php echo ($thisReplacement != null && $thisReplacement['emergency'] == 0) ? "selected='selected'" : "";?>>No</option>
							<option value="1" <?php echo ($thisReplacement != null && $thisReplacement['emergency'] == 1) ? "selected='selected'" : "";?>>Yes</option>
						</select>
					</div>
				</div>
			
			<br><br>
		</div>
			
			
		<div class="col-lg-5">
			<h3>Plant</h3>
			<br>
			
				
				<div class="form-group">
					<label class="col-sm-3 control-label">Plant Type</label>
					<div class="col-sm-5">
						<select name="plant_type" class="col-sm-5 form-control" required>
							<option value="">Select...</option>
							<option value="1" <?php echo ($thisReplacement != null && $thisReplacement['plantID'] == 1) ? "selected='selected'" : "";?>>Standard</option>
						</select>
					</div>
				</div>
				
				<div class="form-group">
					<label class="col-sm-3 control-label">Light Level</label>
					<div class="col-sm-5">
						<select name="light_level" class="col-sm-5 form-control" required>
							<option><?php echo ($thisReplacement != null) ? $thisReplacement['light_level'] : "";?></option>
							<option>Low</option>
							<option>Medium</option>
							<option>High</option>
						</select>
					</div>
				</div>
				
				<div class="form-group">
					<div class="row">
						<label class="col-sm-3 control-label">Comments</label>
					</div>
					<div class="row">
						<div class="col-sm-1"></div>
						<div class="col-sm-7">
							<textarea name="comments" class="form-control" rows="3"><?php echo ($thisReplacement != null) ? $thisReplacement['comments'] : "";?></textarea>
						</div>
					</div>
				</div>
			<br><br>
		</div>
		
		
		<div class="col-lg-2">
			<h3>Admin</h3>
			<br>
			<div class="form-group">
			<fieldset>
			<div class="statusError"></div>
			<div class="radio">
			  <label for="opitonRadios0">
				<input class="statusOption input-group" type="radio" name="status" id="optionsRadios0" value="0"
					<?php echo ($thisReplacement != null && $thisReplacement['status'] == 0) ? "checked" : "";?>
					required>
				Needs Approval
			</label>  
			</div>
			<div class="radio">
			  <label for="optionRadios1">
				<input class="statusOption input-group" type="radio" name="status" id="optionsRadios1" value="1"
					<?php echo ($thisReplacement != null && $thisReplacement['status'] == 1) ? "checked" : "";?>>
				Approved
			  </label>
			</div>
			<div class="radio">
			  <label for="optionRadios2">
				<input class="statusOption input-group" type="radio" name="status" id="optionsRadios2" value="2"
					<?php echo ($thisReplacement != null && $thisReplacement['status'] == 2) ? "checked" : "";?>>
				Completed
			  </label>
			</div>
			<div class='input-group date datepicker' id="picker2" data-date-format="YYYY-MM-DD">
                <input id="completedDate" type='text' class="form-control" name="date_completed" value="<?php echo ($thisReplacement == null) ? "" : $thisReplacement['date_completed'];?>"/>
                <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span>
                </span>
            </div>
             <br>
			<div class="radio">
			  <label for="optionRadios3">
				<input class="statusOption input-group" type="radio" name="status" id="optionsRadios3" value="3"
					<?php echo ($thisReplacement != null && $thisReplacement['status'] == 3) ? "checked" : "";?>>
				Cancelled
			  </label>
			</div>
			 <label for="status" class="error" style="display:none;">Please select a status</label>
			</fieldset>
			</div>
			
        </div>
		
	</div>
	<br><br>
	
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
