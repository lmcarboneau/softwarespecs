<?php
error_reporting(-1);
ini_set('display_errors',1);
ini_set('display_startup_errors',1);
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
require_once("php/technicians.class.php");

$technicians = new technicians($database);
$techniciansList = $technicians->getTechnicianData();
$tableRows = "";
$month = date('M');

foreach($techniciansList as $technicianRow){
	$tableRows .= "<tr class='table-select' style='cursor:pointer;'>\n";

	$tableRows .= "\t<td class='id' style='display:none;'>";
	$tableRows .= $technicianRow['gardenerID']."</td>\n";

	$tableRows .= "\t<td class='first_name'>";
	$tableRows .= $technicianRow['first_name']."</td>\n";

	$tableRows .= "\t<td class='last_name'>";
	$tableRows .= $technicianRow['last_name']."</td>\n";
	
	$total_customers = $technicianRow['num_customers'];

	$tableRows .= "\t<td class='num_cust'>";
	$tableRows .= $total_customers."</td>\n";
	
	if ($technicianRow['amount_billed'] > 0){
		if ($technicianRow['cost_of_replacements'] > 0){
			$profit = ($technicianRow['amount_billed'] - $technicianRow['cost_of_replacements']);
		} else {
			$profit = $technicianRow['amount_billed'];
		}
	}else{
		$profit = 0;
	}
	$tableRows .= "\t<td class='curr_profit'>";
	$tableRows .= $profit."$</td>\n";

	if ($technicianRow['number_of_replacements'] > 0 && $technicianRow['num_plants'] > 0){
		$replacements = $technicianRow['number_of_replacements'] / $technicianRow['num_plants'] * 100;
		$replacements = round($replacements);
	}else{
		$replacements = 0;
	}
	$tableRows .= "\t<td class='curr_replacements'>";
	$tableRows .= $replacements."%</td>\n";	
	
	$rating = "";
	if ($profit!=0){
		$rating = ($replacements > 0) ? log($profit/($replacements/6))*10 : log($profit)*10;
	} else {
		$rating = 0;
	}

	$tableRows .= "\t<td class='rating'>";
	$tableRows .= floor($rating)."</td>\n";	
	$tableRows .= "</tr>\n";
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Technician List">
    <meta name="designer" content="Stetson Gafford">
    <meta name="author" content="Lindsey Carboneau">
    <link rel="shortcut icon" href="../../assets/ico/favicon.ico">

    <title>Plant Replacement Manager Technicians</title>

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
	  			valueNames: [ 'id', 'first_name', 'last_name', 'num_cust', 'curr_profit', 'curr_replacements', 'rating' ]
			};

			// Init list
			var list = new List('technicians', options);


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
	   			list.sort(sort, { order: direction});

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
		&nbsp;<?php echo $_SESSION['displayname'];?><br>
		<a href="/logout.php" class="btn btn-xs btn-success pull-right">
		Log Out</a>
		</p>
					
		<h3><img src="img/ipslogosmall.jpg"></h3>
        
		<ul class="nav nav-justified">
          <li><a href="dashboard.php">Dashboard</a></li>
          <li><a href="customers.php">Customers</a></li>
          <li class="active"><a href="technicians.php">Technicians</a></li>
          <li><a href="replacements.php">Replacements</a></li>        </ul>
      </div>

    <br> 
	<div class="row" >  
		<div id="technicians" style="margin:20px">
			<div class="navbar navbar-default">
				<form class="navbar-form" role="form">
					<input type="text" class="search form-control" placeholder="Search Technicians" style="max-width:20%"/>
					<a href="technicianForm.php" class="btn btn-success" style="float:right">
						New Technician
					</a>
				</form>
			</div>
			<table class="table table-striped table-hover table-responsive panel panel-default">
				<thead>
					<tr>
						<th>
							<button data-sort="first_name" class="sortbtn sort-default btn btn-default" style="width:100%">
								<span class="glyphicon glyphicon-sort"></span>
								First Name
							</button>
						</th>
						<th>
							<button data-sort="last_name" class="sortbtn btn btn-default" style="width:100%">
								<span class="glyphicon glyphicon-sort"></span>
								Last Name
							</button>
						</th>
						<th>
							<button data-sort="num_cust" class="sortbtn btn btn-default" style="width:100%">
								<span class="glyphicon glyphicon-sort"></span>
								Customers
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
						<th>
							<button data-sort="rating" class="sortbtn btn btn-default" style="width:100%">
								<span class="glyphicon glyphicon-sort"></span>
								Points
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
			<form id="selectForm" action="technicianDetail.php" method="post">
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
