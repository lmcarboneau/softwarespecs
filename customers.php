<?php
error_reporting(-1);
ini_set('display_errors',1);
ini_set('display_startup_errors',1);

require_once("php/database.class.php");
$database = new database();
require_once("php/customers.class.php");

$customers = new customers($database);
$customerList = $customers->getCustomerData();
$tableRows = "";
$month = date('M');

foreach($customerList as $customerRow){
	$tableRows .= "<tr class='table-select' style='cursor:pointer;'>\n";

	$tableRows .= "\t<td class='id' style='display:none;'>";
	$tableRows .= $customerRow['customerID']."</td>\n";

	$tableRows .= "\t<td class='customer_name'>";
	$tableRows .= $customerRow['customer_name']."</td>\n";

	$tableRows .= "\t<td class='city'>";
	$tableRows .= $customerRow['city']."</td>\n";

	$techName = $customerRow['first_name']." ".$customerRow['last_name'];
	$tableRows .= "\t<td class='technician_name'>";
	$tableRows .= $techName."</td>\n";

	if ($customerRow['amount_billed'] > 0 && $customerRow['cost_of_replacements'] > 0){
		$profit = ($customerRow['amount_billed'] - $customerRow['cost_of_replacements'])."$";
	}else{
		$profit = "-";
	}
	$tableRows .= "\t<td class='curr_profit'>";
	$tableRows .= $profit."</td>\n";

	if ($customerRow['number_of_replacements'] > 0 && $customerRow['quantity'] > 0){
		$replacements = $customerRow['number_of_replacements'] / $customerRow['quantity'] * 100;
		$replacements = round($replacements)."%";
	}else{
		$replacements = "-";
	}
	$tableRows .= "\t<td class='curr_replacements'>";
	$tableRows .= $replacements."</td>\n";
	//$tableRows .= $customerRow['number_of_replacements']."/".$customerRow['quantity']."%</td>\n";

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
	  			valueNames: [ 'customerID', 'customer_name', 'city', 'technician_name', 'curr_profit', 'curr_replacements' ]
			};

			// Init list
			var customerList = new List('customers', options);


   			var sort = "";
	   		var direction = "asc";
	   		var sort_btns = $(".sortbtn");

	   		sort_btns.click(function(){
	   			var clicked = $(this);
	   			var sortid = clicked.attr("data-sort");
	   			if (sort == sortid){
	   				direction = (direction == "asc") ? "desc" : "asc";
	   			} else {
	   				direction = "asc";
	   			}
	     		sort = sortid;
	   			customerList.sort(sort, { order: direction});

	   			sort_btns.removeClass("btn-primary");
	   			clicked.addClass("btn-primary");
	   		});

	   		// We "click" the sort-by-customer button on page load
	   		// so that the list starts out sorted
	   		$(".sort-default").trigger("click");

	   		// This section detects a click in the customer table
	   		// and submits the customer ID to customerForm.php
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

    <div class="page-header">  
	  <h1></h1>
	</div>  
	<div class="row" >  
		<div id="customers" style="margin:20px">
			<input type="text" class="search form-control" placeholder="Search Customers" style="max-width:20%"/>
			<button class="btn btn-success" style="float:right">Add New Customer</button>
			<table class="table table-striped table-hover table-responsive">
				<thead>
					<tr>
						<th>
							<button data-sort="customer_name" class="sortbtn sort-default btn btn-default" style="width:100%">
								<span class="glyphicon glyphicon-sort"></span>
								Customer
							</button>
						</th>
						<th>
							<button data-sort="city" class="sortbtn btn btn-default" style="width:100%">
								<span class="glyphicon glyphicon-sort"></span>
								City
							</button>
						</th>
						<th>
							<button data-sort="technician_name" class="sortbtn btn btn-default" style="width:100%">
								<span class="glyphicon glyphicon-sort"></span>
								Technician
							</button>
						</th>
						<th>
							<button data-sort="curr_profit" class="sortbtn btn btn-default" style="width:100%">
								<span class="glyphicon glyphicon-sort"></span>
								Profit
							</button>
						</th>
						<th>
							<button data-sort="curr_replacements" class="sortbtn btn btn-default" style="width:100%">
								<span class="glyphicon glyphicon-sort"></span>
								Replacements
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
