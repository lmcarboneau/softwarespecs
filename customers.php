<?php
error_reporting(-1);
ini_set('display_errors',1);
ini_set('display_startup_errors',1);

require_once("php/database.class.php");
$database = new database();
require_once("php/customers.class.php");
require_once("php/technicians.class.php");

$customers = new customers($database);
$technicians = new technicians($database);

$customerList = $customers->getCustomerList();
$technicanList = array();

$tableRows = "";

foreach($customerList as $customerRow){
	$tableRows .= "<tr class='table-select'>\n";

	$tableRows .= "\t<td class='id' style='display:none;'>";
	$tableRows .= $customerRow['customerID']."</td>\n";

	$tableRows .= "\t<td class='customer_name'>";
	$tableRows .= $customerRow['customer_name']."</td>\n";

	// Only query for technician data if the
	// technician is not already in technicianList
	$techID = $customerRow['gardenerID'];
	if (!isset($technicianList[$techID])){
		$technicianList[$techID] = $technicians->getTechnician($techID);
	}
	$tech = $technicianList[$techID];
	if ($tech){
		$techName = $tech['first_name']." ".$tech['last_name'];
	} else {
		$techName = $techID;
	}
	$tableRows .= "\t<td class='technician_name'>";
	$tableRows .= $techName."</td>\n";

	$tableRows .= "\t<td class='city'>";
	$tableRows .= $customerRow['city']."</td>\n";

	$tableRows .= "</tr>\n";
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

    <title>Plant Replacement Manager Customers</title>

    <!-- Bootstrap core CSS-->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/justified-nav.css" rel="stylesheet">

    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8/jquery.min.js"></script>
	<script src="js/List.js"></script>

	<script language="JavaScript">
		// Set up List.js table on load
		$(document).ready ( function(){
			var options = {
	  			valueNames: [ 'customerID', 'customer_name', 'technician_name', 'city' ]
			};

			// Init list
			var customerList = new List('customers', options);

			// Sort by customer name
   			//customerList.sort('customer_name', { order: "asc" });

   			var sort = "";
	   		var direction = "asc";
	   		var btn_customer = $("#sort-customer-name");
	   		var btn_technician = $("#sort-technician-name");
	   		var btn_city = $("#sort-city");

	   		btn_customer.click(function(){
	   			if (sort == "customer_name"){
	   				direction = (direction == "asc") ? "desc" : "asc";
	   			} else {
	   				direction = "asc";
	   			}
	     		sort = "customer_name";
	   			customerList.sort(sort, { order: direction});

	   			btn_customer.addClass("btn-primary");
	   			btn_technician.removeClass("btn-primary");
	   			btn_city.removeClass("btn-primary");
	   		});

	   		btn_technician.click(function(){
	   			if (sort == "technician_name"){
	   				direction = (direction == "asc") ? "desc" : "asc";
	   			} else {
	   				direction = "asc";
	   			}
	     		sort = "technician_name";
	   			customerList.sort(sort, { order: direction});

	   			btn_customer.removeClass("btn-primary");
	   			btn_technician.addClass("btn-primary");
	   			btn_city.removeClass("btn-primary");
	   		});

	   		btn_city.click(function(){
	   			if (sort == "city"){
	   				direction = (direction == "asc") ? "desc" : "asc";
	   			} else {
	   				direction = "asc";
	   			}
	     		sort = "city";
	   			customerList.sort(sort, { order: direction});

	   			btn_customer.removeClass("btn-primary");
	   			btn_technician.removeClass("btn-primary");
	   			btn_city.addClass("btn-primary");
	   		});

	   		btn_customer.trigger("click");

	   		$(".table-select").click(function (){
	   			var id = $(this).find('.id').text();
	   			$("#selectID").val(id);
	   			$("#selectForm").submit();
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
          <li><a href="#">Dashboard</a></li>
          <li class="active"><a href="#">Customers</a></li>
          <li><a href="dashboard.php">Technicians</a></li>
          <li><a href="#">Replacements</a></li>
        </ul>
		
      </div>

    <br>
	<div class="row" >  
		<div id="customers" style="margin:20px">
			<input type="text" class="search form-control" placeholder="Search Customers" />
			<table class="table table-striped table-hover table-responsive">
				<thead>
					<tr>
						<th>
							<button id="sort-customer-name" class="btn btn-default" style="width:100%">
								<span class="glyphicon glyphicon-sort"></span>
								Customer
							</button>
						</th>
						<th>
							<button id="sort-technician-name" class="sort btn btn-default" data-sort="technician_name" style="width:100%">
								<span class="glyphicon glyphicon-sort"></span>
								Technician
							</button>
						</th>
						<th>
							<button id="sort-city" class="sort btn btn-default" data-sort="city" style="width:100%">
								<span class="glyphicon glyphicon-sort"></span>
								City
							</button>
						</th>
					</tr>
				</thead>
				<tbody class="list">
					<?php echo $tableRows; ?>
				</tbody>
			</table>
		</div>
		<!-- Hidden form to submit which customer was clicked -->
		<div style="display:none;">
			<form id="selectForm" action="customerForm.php" method="post">
				<input id="selectID" type="text" name="id" value="5"/>
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
